<?php require_once INCLUDES.'inc_head.php'; ?>
<?php
if (!function_exists('h')) {
  function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}

// Helper para obtener el color del estado
function getEstadoColor($estado) {
  return $estado === 'ACTIVO' ? 'success' : 'secondary';
}

// Helper para obtener icono según el tipo de sección
function getTipoIcono($tipo) {
  $iconos = [
    'CAROUSEL' => 'images',
    'CARDS' => 'th-large',
    'LINKS' => 'link',
    'CALENDAR' => 'calendar-alt',
    'VIDEO' => 'video',
    'CTA' => 'bullhorn',
    'TEXT' => 'align-left',
    'SCHEDULE' => 'clock',
    'HERO' => 'star',
    'SOCIAL' => 'share-alt',
    'AGENDA' => 'calendar-check'
  ];
  return $iconos[$tipo] ?? 'file';
}

// Helper para descripción del tipo
function getTipoDescripcion($tipo) {
  $descripciones = [
    'CAROUSEL' => 'Carrusel de imágenes con contenido',
    'CARDS' => 'Tarjetas en cuadrícula',
    'LINKS' => 'Lista de enlaces',
    'CALENDAR' => 'Calendario embebido (iframe)',
    'VIDEO' => 'Video embebido',
    'CTA' => 'Llamado a la acción',
    'TEXT' => 'Texto enriquecido',
    'SCHEDULE' => 'Horario tipo parrilla',
    'HERO' => 'Sección destacada',
    'SOCIAL' => 'Redes sociales',
    'AGENDA' => 'Agenda mensual con eventos'
  ];
  return $descripciones[$tipo] ?? 'Sección personalizada';
}
?>
<style>
/* Estilos mejorados para la tabla de secciones */
.secciones-table {
  border-collapse: separate;
  border-spacing: 0 8px;
  margin-top: -8px;
}

.secciones-table tbody tr {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.02);
  transition: all 0.2s ease;
}

.secciones-table tbody tr:hover {
  box-shadow: 0 4px 16px rgba(28, 34, 98, 0.08);
  transform: translateY(-2px);
}

.secciones-table td {
  border: none;
  padding: 1rem 0.75rem;
  vertical-align: middle;
}

.secciones-table td:first-child {
  border-top-left-radius: 12px;
  border-bottom-left-radius: 12px;
  padding-left: 1.25rem;
}

.secciones-table td:last-child {
  border-top-right-radius: 12px;
  border-bottom-right-radius: 12px;
  padding-right: 1.25rem;
}

/* Cabecera de la tabla */
.secciones-table thead th {
  border: none;
  background: transparent;
  color: #6c757d;
  font-weight: 600;
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  padding: 0.75rem;
}

/* Badges de estado mejorados */
.status-badge {
  padding: 0.35rem 0.75rem;
  border-radius: 30px;
  font-size: 0.75rem;
  font-weight: 600;
  letter-spacing: 0.3px;
  text-transform: uppercase;
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
}

.status-badge i {
  font-size: 0.7rem;
}

/* Tipo badge */
.tipo-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.3rem 0.8rem;
  background: #f0f1f7;
  color: #1C2262;
  border-radius: 30px;
  font-size: 0.8rem;
  font-weight: 600;
}

.tipo-badge i {
  font-size: 0.8rem;
}

/* Layout badge */
.layout-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
  padding: 0.2rem 0.6rem;
  background: #f8f9fa;
  border: 1px solid #e9ecef;
  border-radius: 20px;
  font-size: 0.75rem;
  color: #495057;
}

/* Botones de acción */
.action-buttons {
  display: flex;
  gap: 0.5rem;
  justify-content: flex-end;
}

.btn-action {
  padding: 0.4rem 1rem;
  border-radius: 8px;
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  font-size: 0.85rem;
  font-weight: 500;
  transition: all 0.2s;
  border: 1px solid transparent;
}

.btn-action i {
  font-size: 0.9rem;
}

.btn-action.primary {
  background: #f0f1f7;
  color: #1C2262;
}

.btn-action.primary:hover {
  background: #1C2262;
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(28, 34, 98, 0.2);
}

.btn-action.secondary {
  background: #f8f9fa;
  color: #495057;
  border-color: #e9ecef;
}

.btn-action.secondary:hover {
  background: #e9ecef;
  color: #1C2262;
  transform: translateY(-2px);
}

.btn-action.danger {
  background: #fee2e2;
  color: #dc2626;
  border-color: #fecaca;
}

.btn-action.danger:hover {
  background: #dc2626;
  color: white;
  border-color: #dc2626;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
}

/* Tarjeta de información de la página */
.page-info-card {
  background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
  border-radius: 16px;
  padding: 1.5rem;
  border: 1px solid #e9ecef;
  margin-bottom: 2rem;
  display: flex;
  align-items: center;
  gap: 1.5rem;
  flex-wrap: wrap;
}

.page-icon {
  width: 64px;
  height: 64px;
  border-radius: 16px;
  background: #1C2262;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
}

.page-details h3 {
  font-size: 1.5rem;
  font-weight: 700;
  margin-bottom: 0.25rem;
  color: #1C2262;
}

.page-details .page-meta {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
  color: #6c757d;
}

.page-meta-item {
  display: flex;
  align-items: center;
  gap: 0.3rem;
  font-size: 0.9rem;
}

/* Buscador */
.search-box {
  position: relative;
  margin-bottom: 1.5rem;
}

.search-box i {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  color: #adb5bd;
}

.search-box input {
  padding-left: 2.5rem;
  border-radius: 30px;
  border: 1px solid #e9ecef;
  background: #f8f9fa;
  height: 45px;
}

.search-box input:focus {
  background: #fff;
  border-color: #1C2262;
  box-shadow: 0 0 0 3px rgba(28, 34, 98, 0.1);
}

/* Filtros rápidos */
.filter-chips {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
  margin-bottom: 1.5rem;
}

.filter-chip {
  padding: 0.4rem 1rem;
  border-radius: 30px;
  background: #f8f9fa;
  border: 1px solid #dee2e6;
  color: #495057;
  font-size: 0.85rem;
  cursor: pointer;
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
}

.filter-chip:hover,
.filter-chip.active {
  background: #1C2262;
  color: white;
  border-color: #1C2262;
}

/* Orden badge */
.orden-badge {
  background: #f8f9fa;
  padding: 0.3rem 0.8rem;
  border-radius: 30px;
  font-size: 0.8rem;
  font-weight: 600;
  color: #495057;
  border: 1px solid #e9ecef;
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
}

/* Estado vacío mejorado */
.empty-state {
  text-align: center;
  padding: 4rem 2rem;
}

.empty-state-icon {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: #f0f1f7;
  color: #1C2262;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 3rem;
  margin: 0 auto 1.5rem;
}

.empty-state h4 {
  color: #1C2262;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.empty-state p {
  color: #6c757d;
  margin-bottom: 2rem;
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
</style>

<main id="main-wrapper" class="main-wrapper">
  <?php require_once INCLUDES.'inc_header.php'; ?>

  <div id="app-content">
    <div class="app-content-area">
      <div class="container-fluid">

        <!-- Breadcrumb -->
        <div class="row mb-4">
          <div class="col-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= URL ?>?uri=comunicaciones/admin_paginas">Páginas</a></li>
                <li class="breadcrumb-item active">Secciones</li>
              </ol>
            </nav>
          </div>
        </div>

        <!-- Cabecera con título y acción -->
        <div class="row align-items-center mb-4">
          <div class="col-md-8">
            <div class="d-flex align-items-center gap-3">
              <div style="width: 56px; height: 56px; border-radius: 14px; background: #1C2262; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">
                <i class="fas fa-layer-group"></i>
              </div>
              <div>
                <h2 class="mb-1" style="color: #1C2262; font-weight: 700;">Secciones</h2>
                <p class="text-muted mb-0">Gestiona las secciones de la página</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 text-md-end">
            <div class="d-flex gap-2 justify-content-md-end">
              <a class="btn btn-outline-secondary" href="<?= URL ?>?uri=comunicaciones/admin_paginas">
                <i class="fas fa-arrow-left me-1"></i> Volver
              </a>
              <a class="btn btn-primary" href="<?= URL ?>?uri=comunicaciones/admin_seccion_form/<?= (int)($d->pagina->pag_id ?? 0) ?>" 
                 style="background: #1C2262; border-color: #1C2262;">
                <i class="fas fa-plus me-1"></i> Nueva sección
              </a>
            </div>
          </div>
        </div>

        <!-- Tarjeta de información de la página -->
        <div class="page-info-card">
          <div class="page-icon">
            <i class="fas fa-file-alt"></i>
          </div>
          <div class="page-details">
            <h3><?= h($d->pagina->pag_titulo ?? '') ?></h3>
            <div class="page-meta">
              <span class="page-meta-item">
                <i class="fas fa-tag"></i> Slug: <code><?= h($d->pagina->pag_slug ?? '') ?></code>
              </span>
              <span class="page-meta-item">
                <i class="fas fa-sort"></i> Orden: <?= (int)($d->pagina->pag_orden ?? 0) ?>
              </span>
              <span class="page-meta-item">
                <i class="fas fa-<?= ($d->pagina->pag_estado ?? '') === 'ACTIVO' ? 'check-circle text-success' : 'times-circle text-secondary' ?>"></i>
                Estado: <?= h($d->pagina->pag_estado ?? '') ?>
              </span>
            </div>
          </div>
        </div>

        <!-- Buscador y filtros -->
        <?php if (!empty($d->secciones)): ?>
        <div class="row mb-3">
          <div class="col-md-6">
            <div class="search-box">
              <i class="fas fa-search"></i>
              <input type="text" class="form-control" id="searchInput" placeholder="Buscar secciones por título o slug...">
            </div>
          </div>
          <div class="col-md-6">
            <div class="filter-chips justify-content-md-end">
              <span class="filter-chip active" onclick="filtrarSecciones('todas')" id="filtroTodas">
                <i class="fas fa-list"></i> Todas
              </span>
              <span class="filter-chip" onclick="filtrarSecciones('activas')" id="filtroActivas">
                <i class="fas fa-check-circle"></i> Activas
              </span>
              <span class="filter-chip" onclick="filtrarSecciones('inactivas')" id="filtroInactivas">
                <i class="fas fa-times-circle"></i> Inactivas
              </span>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <!-- Tabla de secciones mejorada -->
        <div class="card shadow-sm border-0">
          <div class="card-body p-4">

            <?php if (empty($d->secciones)): ?>
              <!-- Estado vacío mejorado -->
              <div class="empty-state">
                <div class="empty-state-icon">
                  <i class="fas fa-layer-group"></i>
                </div>
                <h4>No hay secciones creadas</h4>
                <p>Comienza agregando la primera sección a esta página</p>
                <a href="<?= URL ?>?uri=comunicaciones/admin_seccion_form/<?= (int)($d->pagina->pag_id ?? 0) ?>" 
                   class="btn btn-primary btn-lg" style="background: #1C2262; border-color: #1C2262;">
                  <i class="fas fa-plus me-2"></i>Crear primera sección
                </a>
              </div>
            <?php else: ?>

              <div class="table-responsive">
                <table class="secciones-table w-100" id="seccionesTable">
                  <thead>
                    <tr>
                      <th style="width: 60px;">ID</th>
                      <th>Sección</th>
                      <th style="width: 120px;">Tipo</th>
                      <th style="width: 100px;">Layout</th>
                      <th style="width: 100px;">Estado</th>
                      <th style="width: 80px;">Orden</th>
                      <th style="width: 280px;">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach (($d->secciones ?? []) as $s): ?>
                      <?php 
                      $estado = $s->sec_estado ?? '';
                      $tipo = $s->sec_tipo ?? '';
                      $icono = getTipoIcono($tipo);
                      ?>
                      <tr data-estado="<?= $estado ?>" data-titulo="<?= h(strtolower($s->sec_titulo ?? '')) ?>" data-slug="<?= h(strtolower($s->sec_slug ?? '')) ?>">
                        <td>
                          <span class="fw-bold">#<?= str_pad((int)$s->sec_id, 3, '0', STR_PAD_LEFT) ?></span>
                        </td>
                        <td>
                          <div class="d-flex align-items-start gap-2">
                            <div style="width: 32px; height: 32px; border-radius: 8px; background: #f0f1f7; color: #1C2262; display: flex; align-items: center; justify-content: center;">
                              <i class="fas fa-<?= $icono ?>"></i>
                            </div>
                            <div>
                              <div class="fw-bold mb-1"><?= h($s->sec_titulo ?: 'Sin título') ?></div>
                              <div>
                                <code class="small"><?= h($s->sec_slug ?? '') ?></code>
                              </div>
                              <?php if (!empty($s->sec_descripcion)): ?>
                                <div class="small text-muted mt-1">
                                  <i class="fas fa-quote-right me-1"></i><?= h(mb_strimwidth($s->sec_descripcion, 0, 60, '...')) ?>
                                </div>
                              <?php endif; ?>
                            </div>
                          </div>
                        </td>
                        <td>
                          <span class="tipo-badge" data-tooltip="<?= getTipoDescripcion($tipo) ?>">
                            <i class="fas fa-<?= $icono ?>"></i>
                            <?= h($tipo) ?>
                          </span>
                        </td>
                        <td>
                          <span class="layout-badge">
                            <i class="fas fa-<?= ($s->sec_layout ?? 'CONTAINER') === 'FULL' ? 'expand' : 'compress' ?>"></i>
                            <?= h($s->sec_layout ?? 'CONTAINER') ?>
                          </span>
                        </td>
                        <td>
                          <span class="status-badge bg-<?= getEstadoColor($estado) ?> text-white">
                            <i class="fas fa-<?= $estado === 'ACTIVO' ? 'check-circle' : 'times-circle' ?>"></i>
                            <?= h($estado) ?>
                          </span>
                        </td>
                        <td>
                          <span class="orden-badge">
                            <i class="fas fa-sort"></i>
                            <?= (int)($s->sec_orden ?? 0) ?>
                          </span>
                        </td>
                        <td>
                          <div class="action-buttons">
                            <a class="btn-action secondary"
                               href="<?= URL ?>?uri=comunicaciones/admin_items/<?= (int)$s->sec_id ?>"
                               data-tooltip="Gestionar items de la sección">
                              <i class="fas fa-cubes"></i>
                              Items
                            </a>
                            <a class="btn-action primary"
                               href="<?= URL ?>?uri=comunicaciones/admin_seccion_form/<?= (int)($d->pagina->pag_id ?? 0) ?>/<?= (int)$s->sec_id ?>"
                               data-tooltip="Editar sección">
                              <i class="fas fa-pen"></i>
                              Editar
                            </a>
                            <a href="javascript:void(0);" 
                               class="btn-action danger"
                               onclick="confirmarEliminar(<?= (int)$s->sec_id ?>, '<?= h(addslashes($s->sec_titulo ?: 'Sin título')) ?>')"
                               data-tooltip="Eliminar sección">
                              <i class="fas fa-trash"></i>
                              Eliminar
                            </a>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>

              <!-- Información adicional -->
              <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <div class="text-muted small">
                  <i class="fas fa-info-circle me-1"></i>
                  Mostrando <strong id="mostrandoCount"><?= count($d->secciones ?? []) ?></strong> secciones
                </div>
                <div class="text-muted small">
                  <i class="fas fa-lightbulb me-1"></i>
                  Las secciones determinan la estructura de la página
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
                <strong>Guía rápida de tipos de sección:</strong>
                <div class="row mt-2 g-2">
                  <div class="col-md-3"><span class="tipo-badge"><i class="fas fa-images"></i> CAROUSEL</span> Carrusel de imágenes</div>
                  <div class="col-md-3"><span class="tipo-badge"><i class="fas fa-th-large"></i> CARDS</span> Tarjetas en cuadrícula</div>
                  <div class="col-md-3"><span class="tipo-badge"><i class="fas fa-link"></i> LINKS</span> Lista de enlaces</div>
                  <div class="col-md-3"><span class="tipo-badge"><i class="fas fa-calendar-alt"></i> CALENDAR</span> Calendario iframe</div>
                  <div class="col-md-3"><span class="tipo-badge"><i class="fas fa-video"></i> VIDEO</span> Video embebido</div>
                  <div class="col-md-3"><span class="tipo-badge"><i class="fas fa-bullhorn"></i> CTA</span> Llamado a la acción</div>
                  <div class="col-md-3"><span class="tipo-badge"><i class="fas fa-align-left"></i> TEXT</span> Texto enriquecido</div>
                  <div class="col-md-3"><span class="tipo-badge"><i class="fas fa-clock"></i> SCHEDULE</span> Horario parrilla</div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</main>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>¿Estás seguro de eliminar la sección <strong id="deleteItemTitle"></strong>?</p>
        <p class="text-danger small">Esta acción no se puede deshacer. Se eliminarán también todos los items asociados a esta sección.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a href="#" id="deleteConfirmBtn" class="btn btn-danger">Eliminar</a>
      </div>
    </div>
  </div>
</div>

<script>
// Función para filtrar secciones por estado
function filtrarSecciones(filtro) {
  const rows = document.querySelectorAll('#seccionesTable tbody tr');
  const chips = document.querySelectorAll('.filter-chip');
  
  chips.forEach(chip => chip.classList.remove('active'));
  document.getElementById(`filtro${filtro.charAt(0).toUpperCase() + filtro.slice(1)}`).classList.add('active');
  
  let contador = 0;
  rows.forEach(row => {
    const estado = row.dataset.estado;
    if (filtro === 'todas') {
      row.style.display = '';
      contador++;
    } else if (filtro === 'activas') {
      if (estado === 'ACTIVO') {
        row.style.display = '';
        contador++;
      } else {
        row.style.display = 'none';
      }
    } else if (filtro === 'inactivas') {
      if (estado !== 'ACTIVO') {
        row.style.display = '';
        contador++;
      } else {
        row.style.display = 'none';
      }
    }
  });
  
  const mostrandoElem = document.getElementById('mostrandoCount');
  if (mostrandoElem) mostrandoElem.textContent = contador;
}

// Función de búsqueda
document.getElementById('searchInput')?.addEventListener('keyup', function() {
  const termino = this.value.toLowerCase().trim();
  const rows = document.querySelectorAll('#seccionesTable tbody tr');
  let contador = 0;
  
  rows.forEach(row => {
    const titulo = row.dataset.titulo || '';
    const slug = row.dataset.slug || '';
    
    if (titulo.includes(termino) || slug.includes(termino)) {
      row.style.display = '';
      contador++;
    } else {
      row.style.display = 'none';
    }
  });
  
  const mostrandoElem = document.getElementById('mostrandoCount');
  if (mostrandoElem) mostrandoElem.textContent = contador;
});

// Función para confirmar eliminación
function confirmarEliminar(id, titulo) {
  document.getElementById('deleteItemTitle').textContent = titulo;
  document.getElementById('deleteConfirmBtn').href = '<?= URL ?>?uri=comunicaciones/admin_seccion_eliminar/' + id;
  new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// Ordenar por orden (funcionalidad extra)
let ordenAscendente = true;
document.querySelector('.fa-sort')?.addEventListener('click', function() {
  const tbody = document.querySelector('#seccionesTable tbody');
  if (!tbody) return;
  
  const rows = Array.from(tbody.querySelectorAll('tr'));
  
  rows.sort((a, b) => {
    const ordenA = parseInt(a.querySelector('td:nth-child(6) .orden-badge').textContent);
    const ordenB = parseInt(b.querySelector('td:nth-child(6) .orden-badge').textContent);
    return ordenAscendente ? ordenA - ordenB : ordenB - ordenA;
  });
  
  ordenAscendente = !ordenAscendente;
  rows.forEach(row => tbody.appendChild(row));
});

// Inicializar tooltips
document.querySelectorAll('[data-tooltip]').forEach(el => {
  // Ya manejado por CSS
});
</script>

<?php require_once INCLUDES.'inc_footer.php'; ?>