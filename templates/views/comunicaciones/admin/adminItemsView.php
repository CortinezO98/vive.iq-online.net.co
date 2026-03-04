<?php require_once INCLUDES.'inc_head.php'; ?>
<?php
if (!function_exists('h')) {
  function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}
if (!function_exists('upload_src')) {
  function upload_src($rel){
    if (!$rel) return '';
    return rtrim(UPLOADS, '/').'/'.ltrim($rel, '/');
  }
}

// Helper para iconos según tipo de sección
function getTipoIcono($tipo) {
  $iconos = [
    'CAROUSEL' => 'images',
    'CARDS' => 'th',
    'LINKS' => 'link',
    'CALENDAR' => 'calendar-alt',
    'VIDEO' => 'video',
    'CTA' => 'bullhorn',
    'TEXT' => 'align-left',
    'SCHEDULE' => 'clock',
    'AGENDA' => 'calendar-check'
  ];
  return $iconos[$tipo] ?? 'file';
}
?>
<style>
/* Estilos mejorados para la tabla de items */
.items-table {
  border-collapse: separate;
  border-spacing: 0 8px;
  margin-top: -8px;
}

.items-table tbody tr {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.02);
  transition: all 0.2s ease;
}

.items-table tbody tr:hover {
  box-shadow: 0 4px 16px rgba(28, 34, 98, 0.08);
  transform: translateY(-2px);
}

.items-table td {
  border: none;
  padding: 1rem 0.75rem;
  vertical-align: middle;
}

.items-table td:first-child {
  border-top-left-radius: 12px;
  border-bottom-left-radius: 12px;
  padding-left: 1.25rem;
}

.items-table td:last-child {
  border-top-right-radius: 12px;
  border-bottom-right-radius: 12px;
  padding-right: 1.25rem;
}

/* Cabecera de la tabla */
.items-table thead th {
  border: none;
  background: transparent;
  color: #6c757d;
  font-weight: 600;
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  padding: 0.75rem;
}

/* Imagen del item */
.item-image {
  width: 60px;
  height: 60px;
  border-radius: 10px;
  object-fit: cover;
  background: #f8f9fa;
  border: 1px solid #e9ecef;
  transition: transform 0.2s;
}

.item-image:hover {
  transform: scale(2);
  z-index: 10;
  position: relative;
  box-shadow: 0 8px 24px rgba(0,0,0,0.15);
}

.item-image-placeholder {
  width: 60px;
  height: 60px;
  border-radius: 10px;
  background: #f1f3f5;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #adb5bd;
  font-size: 1.5rem;
  border: 1px dashed #dee2e6;
}

/* Badges de estado mejorados */
.status-badge {
  padding: 0.35rem 0.65rem;
  border-radius: 30px;
  font-size: 0.75rem;
  font-weight: 600;
  letter-spacing: 0.3px;
  text-transform: uppercase;
  display: inline-block;
  background: #e9ecef;
  color: #495057;
}

.status-badge.active {
  background: #d4edda;
  color: #155724;
}

.status-badge.inactive {
  background: #f8d7da;
  color: #721c24;
}

/* Etiqueta de tipo de sección */
.section-type-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  padding: 0.25rem 0.75rem;
  background: #e7e9f0;
  color: #1C2262;
  border-radius: 30px;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}

/* Badge personalizado */
.item-badge {
  display: inline-block;
  padding: 0.2rem 0.6rem;
  background: #e7e9f0;
  color: #1C2262;
  border-radius: 30px;
  font-size: 0.7rem;
  font-weight: 600;
  margin-right: 0.25rem;
}

/* Botones de acción */
.action-buttons {
  display: flex;
  gap: 0.5rem;
  justify-content: flex-end;
}

.btn-action {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: #f8f9fa;
  color: #495057;
  border: 1px solid #e9ecef;
  transition: all 0.2s;
}

.btn-action:hover {
  background: #1C2262;
  color: white;
  border-color: #1C2262;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(28, 34, 98, 0.2);
}

.btn-action.delete:hover {
  background: #dc3545;
  border-color: #dc3545;
}

/* Tarjeta de resumen */
.summary-card {
  background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
  border-radius: 16px;
  padding: 1.25rem;
  border: 1px solid #e9ecef;
  margin-bottom: 1.5rem;
}

.summary-item {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.summary-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  background: #1C2262;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
}

/* Filtros rápidos */
.filter-chip {
  display: inline-flex;
  align-items: center;
  padding: 0.4rem 1rem;
  background: #f8f9fa;
  border: 1px solid #dee2e6;
  border-radius: 30px;
  color: #495057;
  font-size: 0.9rem;
  cursor: pointer;
  transition: all 0.2s;
  margin-right: 0.5rem;
  margin-bottom: 0.5rem;
}

.filter-chip:hover,
.filter-chip.active {
  background: #1C2262;
  color: white;
  border-color: #1C2262;
}

.filter-chip i {
  margin-right: 0.5rem;
  font-size: 0.8rem;
}

/* Tooltip personalizado */
[data-tooltip] {
  position: relative;
  cursor: help;
}

[data-tooltip]:before {
  content: attr(data-tooltip);
  position: absolute;
  bottom: 100%;
  left: 50%;
  transform: translateX(-50%);
  padding: 0.3rem 0.6rem;
  background: #1C2262;
  color: white;
  font-size: 0.7rem;
  border-radius: 4px;
  white-space: nowrap;
  opacity: 0;
  visibility: hidden;
  transition: all 0.2s;
  pointer-events: none;
  z-index: 1000;
}

[data-tooltip]:hover:before {
  opacity: 1;
  visibility: visible;
  bottom: 120%;
}

/* Animación de carga */
@keyframes shimmer {
  0% { background-position: -1000px 0; }
  100% { background-position: 1000px 0; }
}

.loading-placeholder {
  animation: shimmer 2s infinite linear;
  background: linear-gradient(to right, #f6f7f8 8%, #edeef1 18%, #f6f7f8 33%);
  background-size: 1000px 100%;
}
</style>

<main id="main-wrapper" class="main-wrapper">
  <?php require_once INCLUDES.'inc_header.php'; ?>

  <div id="app-content">
    <div class="app-content-area">
      <div class="container-fluid">

        <!-- Breadcrumb mejorado -->
        <div class="row mb-4">
          <div class="col-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= URL ?>?uri=comunicaciones/admin_paginas">Páginas</a></li>
                <li class="breadcrumb-item"><a href="<?= URL ?>?uri=comunicaciones/admin_secciones/<?= (int)($d->pagina->pag_id ?? 0) ?>">
                  <?= h($d->pagina->pag_titulo ?? 'Página') ?>
                </a></li>
                <li class="breadcrumb-item active">Items</li>
              </ol>
            </nav>
          </div>
        </div>

        <!-- Cabecera con información de la sección -->
        <div class="row align-items-center mb-4">
          <div class="col-md-8">
            <div class="d-flex align-items-center gap-3">
              <div class="summary-icon">
                <i class="fas fa-<?= getTipoIcono($d->seccion->sec_tipo ?? '') ?>"></i>
              </div>
              <div>
                <h2 class="mb-1" style="color: #1C2262; font-weight: 700;">
                  Items de la sección
                </h2>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                  <span class="section-type-badge">
                    <i class="fas fa-<?= getTipoIcono($d->seccion->sec_tipo ?? '') ?> me-1"></i>
                    <?= h($d->seccion->sec_tipo ?? '') ?>
                  </span>
                  <span class="text-muted">|</span>
                  <span><strong>Slug:</strong> <code><?= h($d->seccion->sec_slug ?? '') ?></code></span>
                  <span class="text-muted">|</span>
                  <span><strong>Título:</strong> <?= h($d->seccion->sec_titulo ?: 'Sin título') ?></span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="d-flex gap-2 justify-content-md-end">
              <a class="btn btn-outline-secondary" href="<?= URL ?>?uri=comunicaciones/admin_secciones/<?= (int)($d->pagina->pag_id ?? 0) ?>">
                <i class="fas fa-arrow-left me-1"></i> Volver
              </a>
              <a class="btn btn-primary" href="<?= URL ?>?uri=comunicaciones/admin_item_form/<?= (int)($d->seccion->sec_id ?? 0) ?>" 
                 style="background: #1C2262; border-color: #1C2262;">
                <i class="fas fa-plus me-1"></i> Nuevo item
              </a>
            </div>
          </div>
        </div>

        <!-- Tarjeta de resumen -->
        <div class="summary-card">
          <div class="row align-items-center">
            <div class="col-md-auto">
              <div class="summary-item">
                <div class="summary-icon">
                  <i class="fas fa-cubes"></i>
                </div>
                <div>
                  <div class="small text-muted">Total items</div>
                  <div class="h3 mb-0 fw-bold"><?= count($d->items ?? []) ?></div>
                </div>
              </div>
            </div>
            <div class="col-md-auto">
              <div class="summary-item">
                <div class="summary-icon" style="background: #28a745;">
                  <i class="fas fa-check-circle"></i>
                </div>
                <div>
                  <div class="small text-muted">Activos</div>
                  <?php 
                  $activos = 0;
                  foreach (($d->items ?? []) as $it) {
                    if (($it->itm_estado ?? '') === 'ACTIVO') $activos++;
                  }
                  ?>
                  <div class="h3 mb-0 fw-bold"><?= $activos ?></div>
                </div>
              </div>
            </div>
            <div class="col-md-auto">
              <div class="summary-item">
                <div class="summary-icon" style="background: #dc3545;">
                  <i class="fas fa-times-circle"></i>
                </div>
                <div>
                  <div class="small text-muted">Inactivos</div>
                  <div class="h3 mb-0 fw-bold"><?= count($d->items ?? []) - $activos ?></div>
                </div>
              </div>
            </div>
            <div class="col-md text-md-end">
              <div class="small text-muted mb-1">Filtros rápidos</div>
              <div>
                <span class="filter-chip active" onclick="filtrarItems('todos')">
                  <i class="fas fa-list"></i> Todos
                </span>
                <span class="filter-chip" onclick="filtrarItems('activos')">
                  <i class="fas fa-check-circle"></i> Activos
                </span>
                <span class="filter-chip" onclick="filtrarItems('inactivos')">
                  <i class="fas fa-times-circle"></i> Inactivos
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Tabla de items mejorada -->
        <div class="card shadow-sm border-0">
          <div class="card-body p-4">

            <?php if (empty($d->items)): ?>
              <!-- Estado vacío mejorado -->
              <div class="text-center py-5">
                <div class="mb-4">
                  <i class="fas fa-cubes" style="font-size: 4rem; color: #dee2e6;"></i>
                </div>
                <h4 class="text-muted mb-3">No hay items creados</h4>
                <p class="text-muted mb-4">Comienza agregando tu primer item a esta sección</p>
                <a href="<?= URL ?>?uri=comunicaciones/admin_item_form/<?= (int)($d->seccion->sec_id ?? 0) ?>" 
                   class="btn btn-primary btn-lg" style="background: #1C2262; border-color: #1C2262;">
                  <i class="fas fa-plus me-2"></i>Crear primer item
                </a>
              </div>
            <?php else: ?>

              <div class="table-responsive">
                <table class="items-table w-100">
                  <thead>
                    <tr>
                      <th style="width: 80px;">ID</th>
                      <th style="width: 100px;">Imagen</th>
                      <th>Contenido</th>
                      <th style="width: 100px;">Estado</th>
                      <th style="width: 80px;">Orden</th>
                      <th style="width: 120px;">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach (($d->items ?? []) as $it): ?>
                      <?php $src = !empty($it->itm_imagen) ? upload_src($it->itm_imagen) : ''; ?>
                      <tr data-id="<?= $it->itm_id ?>" data-estado="<?= $it->itm_estado ?? '' ?>">
                        <td>
                          <span class="fw-bold">#<?= str_pad((int)$it->itm_id, 3, '0', STR_PAD_LEFT) ?></span>
                        </td>
                        <td>
                          <?php if ($src): ?>
                            <img src="<?= h($src) ?>" class="item-image" alt="" 
                                 data-tooltip="Haz clic para ampliar" onclick="verImagen('<?= h($src) ?>')">
                          <?php else: ?>
                            <div class="item-image-placeholder">
                              <i class="fas fa-image"></i>
                            </div>
                          <?php endif; ?>
                        </td>
                        <td>
                          <div class="fw-bold mb-1"><?= h($it->itm_titulo ?? '') ?></div>
                          <?php if (!empty($it->itm_descripcion)): ?>
                            <div class="text-muted small mb-2"><?= h(mb_strimwidth($it->itm_descripcion, 0, 100, '...')) ?></div>
                          <?php endif; ?>
                          <div class="d-flex flex-wrap gap-1 align-items-center">
                            <?php if (!empty($it->itm_badge)): ?>
                              <span class="item-badge">
                                <i class="fas fa-tag me-1"></i><?= h($it->itm_badge) ?>
                              </span>
                            <?php endif; ?>
                            <?php if (!empty($it->itm_url)): ?>
                              <span class="item-badge" style="background: #e3f2fd;">
                                <i class="fas fa-link me-1"></i>URL
                              </span>
                            <?php endif; ?>
                            <?php if (!empty($it->itm_embed)): ?>
                              <span class="item-badge" style="background: #fff3e0;">
                                <i class="fas fa-code me-1"></i>Embed
                              </span>
                            <?php endif; ?>
                          </div>
                        </td>
                        <td>
                          <span class="status-badge <?= ($it->itm_estado ?? '') === 'ACTIVO' ? 'active' : 'inactive' ?>">
                            <i class="fas fa-<?= ($it->itm_estado ?? '') === 'ACTIVO' ? 'check-circle' : 'times-circle' ?> me-1"></i>
                            <?= h($it->itm_estado ?? '') ?>
                          </span>
                        </td>
                        <td>
                          <span class="badge bg-light text-dark px-3 py-2">
                            <i class="fas fa-sort me-1"></i><?= (int)($it->itm_orden ?? 0) ?>
                          </span>
                        </td>
                        <td>
                          <div class="action-buttons">
                            <a href="<?= URL ?>?uri=comunicaciones/admin_item_form/<?= (int)($d->seccion->sec_id ?? 0) ?>/<?= (int)$it->itm_id ?>" 
                               class="btn-action" data-tooltip="Editar">
                              <i class="fas fa-pen"></i>
                            </a>
                            <a href="#" class="btn-action delete" data-tooltip="Eliminar"
                               onclick="confirmarEliminar(<?= $it->itm_id ?>, '<?= h(addslashes($it->itm_titulo ?? '')) ?>')">
                              <i class="fas fa-trash"></i>
                            </a>
                            <a href="<?= URL ?>?uri=comunicaciones/ver/<?= h($d->pagina->pag_slug ?? '') ?>" 
                               class="btn-action" target="_blank" data-tooltip="Ver en página">
                              <i class="fas fa-external-link-alt"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>

              <!-- Paginación simple -->
              <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <div class="text-muted small">
                  Mostrando <strong><?= count($d->items ?? []) ?></strong> items
                </div>
                <div>
                  <button class="btn btn-outline-secondary btn-sm me-2" disabled>
                    <i class="fas fa-chevron-left"></i>
                  </button>
                  <span class="px-3 py-1 bg-light rounded">1</span>
                  <button class="btn btn-outline-secondary btn-sm ms-2" disabled>
                    <i class="fas fa-chevron-right"></i>
                  </button>
                </div>
              </div>
            <?php endif; ?>

          </div>
        </div>

        <!-- Tips y ayuda -->
        <div class="row mt-4">
          <div class="col-md-12">
            <div class="alert alert-info d-flex align-items-center border-0" style="background: #e7e9f0; color: #1C2262;">
              <i class="fas fa-lightbulb me-3" style="font-size: 1.5rem;"></i>
              <div>
                <strong>Tips para items:</strong> 
                Los items se muestran según el tipo de sección:
                <span class="badge bg-dark ms-2">CAROUSEL</span> (diapositivas),
                <span class="badge bg-dark">CARDS</span> (tarjetas),
                <span class="badge bg-dark">LINKS</span> (enlaces),
                <span class="badge bg-dark">SCHEDULE</span> (horario),
                <span class="badge bg-dark">AGENDA</span> (calendario).
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</main>

<!-- Modal para ver imagen ampliada -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Vista previa de imagen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="" id="modalImage" class="img-fluid" style="max-height: 70vh;" alt="">
      </div>
    </div>
  </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>¿Estás seguro de eliminar el item <strong id="deleteItemTitle"></strong>?</p>
        <p class="text-muted small">Esta acción no se puede deshacer.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a href="#" id="deleteConfirmBtn" class="btn btn-danger">Eliminar</a>
      </div>
    </div>
  </div>
</div>

<script>
// Función para ver imagen ampliada
function verImagen(src) {
  document.getElementById('modalImage').src = src;
  new bootstrap.Modal(document.getElementById('imageModal')).show();
}

// Función para confirmar eliminación
function confirmarEliminar(id, titulo) {
  document.getElementById('deleteItemTitle').textContent = titulo;
  document.getElementById('deleteConfirmBtn').href = '<?= URL ?>?uri=comunicaciones/admin_item_eliminar/' + id;
  new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// Función para filtrar items
function filtrarItems(filtro) {
  const rows = document.querySelectorAll('.items-table tbody tr');
  const chips = document.querySelectorAll('.filter-chip');
  
  chips.forEach(chip => chip.classList.remove('active'));
  event.target.classList.add('active');
  
  rows.forEach(row => {
    const estado = row.dataset.estado;
    if (filtro === 'todos') {
      row.style.display = '';
    } else if (filtro === 'activos') {
      row.style.display = estado === 'ACTIVO' ? '' : 'none';
    } else if (filtro === 'inactivos') {
      row.style.display = estado !== 'ACTIVO' ? '' : 'none';
    }
  });
}

// Tooltips personalizados
document.querySelectorAll('[data-tooltip]').forEach(el => {
  el.addEventListener('mouseenter', function(e) {
    // Ya manejado por CSS
  });
});

// Ordenar items (funcionalidad básica)
let ordenAscendente = true;
document.querySelector('.fa-sort')?.addEventListener('click', function() {
  const tbody = document.querySelector('.items-table tbody');
  const rows = Array.from(tbody.querySelectorAll('tr'));
  
  rows.sort((a, b) => {
    const ordenA = parseInt(a.querySelector('td:nth-child(5)').textContent);
    const ordenB = parseInt(b.querySelector('td:nth-child(5)').textContent);
    return ordenAscendente ? ordenA - ordenB : ordenB - ordenA;
  });
  
  ordenAscendente = !ordenAscendente;
  rows.forEach(row => tbody.appendChild(row));
});
</script>

<?php require_once INCLUDES.'inc_footer.php'; ?>