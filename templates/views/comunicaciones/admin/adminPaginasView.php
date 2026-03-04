<?php require_once INCLUDES.'inc_head.php'; ?>
<?php
if (!function_exists('h')) {
  function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}

// Helper para obtener el color del estado
function getEstadoColor($estado) {
  return $estado === 'ACTIVO' ? 'success' : 'secondary';
}

// Helper para obtener icono según el slug
function getSlugIcon($slug) {
  $iconos = [
    'inicio' => 'home',
    'compania' => 'building',
    'cultura-iq' => 'heart',
    'identidad-corporativa' => 'fingerprint',
    'bienestar-formacion' => 'heartbeat',
    'atraccion-personal' => 'users',
    'sst' => 'shield-alt',
    'compensacion-beneficios' => 'gift',
    'contacto' => 'envelope'
  ];
  return $iconos[$slug] ?? 'file';
}
?>
<style>
/* Estilos mejorados para la tabla de páginas */
.paginas-table {
  border-collapse: separate;
  border-spacing: 0 8px;
  margin-top: -8px;
}

.paginas-table tbody tr {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.02);
  transition: all 0.2s ease;
}

.paginas-table tbody tr:hover {
  box-shadow: 0 4px 16px rgba(28, 34, 98, 0.08);
  transform: translateY(-2px);
}

.paginas-table td {
  border: none;
  padding: 1rem 0.75rem;
  vertical-align: middle;
}

.paginas-table td:first-child {
  border-top-left-radius: 12px;
  border-bottom-left-radius: 12px;
  padding-left: 1.25rem;
}

.paginas-table td:last-child {
  border-top-right-radius: 12px;
  border-bottom-right-radius: 12px;
  padding-right: 1.25rem;
}

/* Cabecera de la tabla */
.paginas-table thead th {
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

/* Slug con icono */
.slug-container {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.slug-icon {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: #f0f1f7;
  color: #1C2262;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
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

/* Tarjeta de resumen */
.summary-card {
  background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
  border-radius: 16px;
  padding: 1.5rem;
  border: 1px solid #e9ecef;
  margin-bottom: 2rem;
}

.summary-stats {
  display: flex;
  gap: 2rem;
  flex-wrap: wrap;
}

.stat-item {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.stat-icon {
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

.stat-info h4 {
  font-size: 1.8rem;
  font-weight: 700;
  margin: 0;
  line-height: 1.2;
  color: #1C2262;
}

.stat-info p {
  margin: 0;
  color: #6c757d;
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

.filter-chip i {
  font-size: 0.8rem;
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
                <li class="breadcrumb-item"><a href="<?= URL ?>?uri=comunicaciones/admin_paginas">Comunicaciones</a></li>
                <li class="breadcrumb-item active">Páginas</li>
              </ol>
            </nav>
          </div>
        </div>

        <!-- Cabecera con título y acción -->
        <div class="row align-items-center mb-4">
          <div class="col-md-8">
            <div class="d-flex align-items-center gap-3">
              <div style="width: 56px; height: 56px; border-radius: 14px; background: #1C2262; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">
                <i class="fas fa-file-alt"></i>
              </div>
              <div>
                <h2 class="mb-1" style="color: #1C2262; font-weight: 700;">Páginas</h2>
                <p class="text-muted mb-0">Gestiona las páginas del portal de comunicaciones</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 text-md-end">
            <a class="btn btn-primary btn-lg" href="<?= URL ?>?uri=comunicaciones/admin_pagina_form" 
               style="background: #1C2262; border-color: #1C2262; padding: 0.6rem 1.5rem;">
              <i class="fas fa-plus me-2"></i>Nueva página
            </a>
          </div>
        </div>

        <!-- Tarjeta de resumen -->
        <?php 
        $totalPaginas = count($d->paginas ?? []);
        $activas = 0;
        $inactivas = 0;
        foreach (($d->paginas ?? []) as $p) {
          if (($p->pag_estado ?? '') === 'ACTIVO') $activas++;
          else $inactivas++;
        }
        ?>
        <div class="summary-card">
          <div class="summary-stats">
            <div class="stat-item">
              <div class="stat-icon">
                <i class="fas fa-file-alt"></i>
              </div>
              <div class="stat-info">
                <h4><?= $totalPaginas ?></h4>
                <p>Total páginas</p>
              </div>
            </div>
            <div class="stat-item">
              <div class="stat-icon" style="background: #28a745;">
                <i class="fas fa-check-circle"></i>
              </div>
              <div class="stat-info">
                <h4><?= $activas ?></h4>
                <p>Activas</p>
              </div>
            </div>
            <div class="stat-item">
              <div class="stat-icon" style="background: #6c757d;">
                <i class="fas fa-times-circle"></i>
              </div>
              <div class="stat-info">
                <h4><?= $inactivas ?></h4>
                <p>Inactivas</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Buscador y filtros -->
        <div class="row mb-3">
          <div class="col-md-6">
            <div class="search-box">
              <i class="fas fa-search"></i>
              <input type="text" class="form-control" id="searchInput" placeholder="Buscar páginas por título o slug...">
            </div>
          </div>
          <div class="col-md-6">
            <div class="filter-chips justify-content-md-end">
              <span class="filter-chip active" onclick="filtrarPaginas('todas')" id="filtroTodas">
                <i class="fas fa-list"></i> Todas
              </span>
              <span class="filter-chip" onclick="filtrarPaginas('activas')" id="filtroActivas">
                <i class="fas fa-check-circle"></i> Activas
              </span>
              <span class="filter-chip" onclick="filtrarPaginas('inactivas')" id="filtroInactivas">
                <i class="fas fa-times-circle"></i> Inactivas
              </span>
            </div>
          </div>
        </div>

        <!-- Tabla de páginas mejorada -->
        <div class="card shadow-sm border-0">
          <div class="card-body p-4">

            <?php if (empty($d->paginas)): ?>
              <!-- Estado vacío mejorado -->
              <div class="empty-state">
                <div class="empty-state-icon">
                  <i class="fas fa-file-alt"></i>
                </div>
                <h4>No hay páginas creadas</h4>
                <p>Comienza creando la primera página para tu portal de comunicaciones</p>
                <a href="<?= URL ?>?uri=comunicaciones/admin_pagina_form" class="btn btn-primary btn-lg" 
                   style="background: #1C2262; border-color: #1C2262;">
                  <i class="fas fa-plus me-2"></i>Crear primera página
                </a>
              </div>
            <?php else: ?>

              <div class="table-responsive">
                <table class="paginas-table w-100" id="paginasTable">
                  <thead>
                    <tr>
                      <th style="width: 80px;">ID</th>
                      <th>Página</th>
                      <th style="width: 120px;">Estado</th>
                      <th style="width: 100px;">Orden</th>
                      <th style="width: 250px;">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach (($d->paginas ?? []) as $p): ?>
                      <?php 
                      $estado = $p->pag_estado ?? '';
                      $slug = $p->pag_slug ?? '';
                      $icono = getSlugIcon($slug);
                      ?>
                      <tr data-estado="<?= $estado ?>" data-titulo="<?= h(strtolower($p->pag_titulo ?? '')) ?>" data-slug="<?= h(strtolower($slug)) ?>">
                        <td>
                          <span class="fw-bold">#<?= str_pad((int)$p->pag_id, 3, '0', STR_PAD_LEFT) ?></span>
                        </td>
                        <td>
                          <div class="slug-container">
                            <div class="slug-icon">
                              <i class="fas fa-<?= $icono ?>"></i>
                            </div>
                            <div>
                              <div class="fw-bold mb-1"><?= h($p->pag_titulo ?? '') ?></div>
                              <div>
                                <code class="small"><?= h($slug) ?></code>
                              </div>
                              <?php if (!empty($p->pag_subtitulo)): ?>
                                <div class="small text-muted mt-1">
                                  <i class="fas fa-quote-right me-1"></i><?= h(mb_strimwidth($p->pag_subtitulo, 0, 50, '...')) ?>
                                </div>
                              <?php endif; ?>
                            </div>
                          </div>
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
                            <?= (int)($p->pag_orden ?? 0) ?>
                          </span>
                        </td>
                        <td>
                          <div class="action-buttons">
                            <a class="btn-action secondary" 
                               href="<?= URL ?>?uri=comunicaciones/ver/<?= h($slug) ?>" 
                               target="_blank"
                               data-tooltip="Ver página pública">
                              <i class="fas fa-eye"></i>
                              Ver
                            </a>
                            <a class="btn-action secondary"
                               href="<?= URL ?>?uri=comunicaciones/admin_secciones/<?= (int)$p->pag_id ?>"
                               data-tooltip="Gestionar secciones">
                              <i class="fas fa-layer-group"></i>
                              Secciones
                            </a>
                            <a class="btn-action primary"
                               href="<?= URL ?>?uri=comunicaciones/admin_pagina_form/<?= (int)$p->pag_id ?>"
                               data-tooltip="Editar página">
                              <i class="fas fa-pen"></i>
                              Editar
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
                  Mostrando <strong id="mostrandoCount"><?= $totalPaginas ?></strong> de <strong><?= $totalPaginas ?></strong> páginas
                </div>
                <div class="text-muted small">
                  <i class="fas fa-lightbulb me-1"></i>
                  Las páginas inactivas no se muestran en el portal
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
                <strong>Consejos para organizar tus páginas:</strong>
                <ul class="mb-0 mt-2 ps-3">
                  <li>El <code>slug</code> define la URL pública: <strong><?= URL ?>?uri=comunicaciones/ver/[slug]</strong></li>
                  <li>El <strong>orden</strong> determina la posición en el menú (menor número = primero)</li>
                  <li>Las páginas <span class="badge bg-success">ACTIVAS</span> son visibles, las <span class="badge bg-secondary">INACTIVAS</span> están ocultas</li>
                  <li>Cada página puede contener múltiples secciones que verás al hacer clic en "Secciones"</li>
                </ul>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</main>

<script>
// Función para filtrar páginas por estado
function filtrarPaginas(filtro) {
  const rows = document.querySelectorAll('#paginasTable tbody tr');
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
  
  document.getElementById('mostrandoCount').textContent = contador;
}

// Función de búsqueda
document.getElementById('searchInput')?.addEventListener('keyup', function() {
  const termino = this.value.toLowerCase().trim();
  const rows = document.querySelectorAll('#paginasTable tbody tr');
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
  
  document.getElementById('mostrandoCount').textContent = contador;
});

// Tooltips
document.querySelectorAll('[data-tooltip]').forEach(el => {
  // Ya manejado por CSS
});

// Ordenar por orden (funcionalidad extra)
let ordenAscendente = true;
document.querySelector('.fa-sort')?.addEventListener('click', function() {
  const tbody = document.querySelector('#paginasTable tbody');
  const rows = Array.from(tbody.querySelectorAll('tr'));
  
  rows.sort((a, b) => {
    const ordenA = parseInt(a.querySelector('td:nth-child(4) .orden-badge').textContent);
    const ordenB = parseInt(b.querySelector('td:nth-child(4) .orden-badge').textContent);
    return ordenAscendente ? ordenA - ordenB : ordenB - ordenA;
  });
  
  ordenAscendente = !ordenAscendente;
  rows.forEach(row => tbody.appendChild(row));
});
</script>

<?php require_once INCLUDES.'inc_footer.php'; ?>