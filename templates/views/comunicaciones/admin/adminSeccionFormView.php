<?php require_once INCLUDES.'inc_head.php'; ?>
<?php
if (!function_exists('h')) {
  function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}
$sec = $d->seccion ?? null;
$pagina = $d->pagina ?? null;

// Helper para obtener icono según el tipo
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
    'FEATURE' => 'columns',
    'IMAGE' => 'image' 
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
    'CTA' => 'Llamado a la acción con botón',
    'TEXT' => 'Texto enriquecido',
    'SCHEDULE' => 'Horario tipo parrilla con eventos',
    'FEATURE' => 'Imagen y texto alternado',
    'IMAGE' => 'Sección con imagen destacada' 
  ];
  return $descripciones[$tipo] ?? 'Sección personalizada';
}
?>
<style>
/* Estilos mejorados para el formulario */
.form-section-title {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1C2262;
  margin-top: 1.5rem;
  margin-bottom: 1rem;
  padding-bottom: 0.5rem;
  border-bottom: 2px solid #e9ecef;
}

.form-section-title:first-of-type {
  margin-top: 0;
}

/* Tarjeta de información de la página */
.page-info-mini {
  background: #f8f9fa;
  border-radius: 12px;
  padding: 1rem;
  margin-bottom: 1.5rem;
  display: flex;
  align-items: center;
  gap: 1rem;
  border: 1px solid #e9ecef;
}

.page-info-mini-icon {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  background: #1C2262;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
}

.page-info-mini-details {
  flex: 1;
}

.page-info-mini-details .page-name {
  font-weight: 600;
  color: #1C2262;
  margin-bottom: 0.2rem;
}

.page-info-mini-details .page-slug {
  font-size: 0.85rem;
  color: #6c757d;
}

/* Selector de tipo visual */
.tipo-selector-container {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  margin-top: 0.5rem;
}

.tipo-option {
  flex: 1 0 auto;
  min-width: 100px;
  text-align: center;
  padding: 0.75rem 0.5rem;
  border: 1px solid #dee2e6;
  border-radius: 12px;
  cursor: pointer;
  transition: all 0.2s;
  background: #fff;
}

.tipo-option:hover {
  border-color: #1C2262;
  background: #f0f1f7;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(28, 34, 98, 0.1);
}

.tipo-option.active {
  border-color: #1C2262;
  background: #e7e9f0;
  color: #1C2262;
  font-weight: 500;
  box-shadow: 0 4px 12px rgba(28, 34, 98, 0.15);
}

.tipo-option i {
  font-size: 1.5rem;
  margin-bottom: 0.3rem;
  display: block;
  color: #1C2262;
}

.tipo-option .tipo-nombre {
  font-size: 0.8rem;
  font-weight: 600;
  display: block;
  margin-bottom: 0.2rem;
}

.tipo-option .tipo-desc {
  font-size: 0.7rem;
  color: #6c757d;
  display: block;
}

/* Selector de layout visual */
.layout-selector {
  display: flex;
  gap: 0.5rem;
  margin-top: 0.5rem;
}

.layout-option {
  flex: 1;
  text-align: center;
  padding: 0.75rem 0.5rem;
  border: 1px solid #dee2e6;
  border-radius: 12px;
  cursor: pointer;
  transition: all 0.2s;
  background: #fff;
}

.layout-option:hover {
  border-color: #1C2262;
  background: #f0f1f7;
}

.layout-option.active {
  border-color: #1C2262;
  background: #e7e9f0;
  color: #1C2262;
  font-weight: 500;
}

.layout-option i {
  font-size: 1.2rem;
  margin-bottom: 0.25rem;
  display: block;
}

.layout-option .layout-nombre {
  font-size: 0.75rem;
  font-weight: 600;
}

/* Campos condicionales */
.conditional-field {
  background: #f8f9fa;
  border-radius: 12px;
  padding: 1.25rem;
  border-left: 4px solid #1C2262;
  margin-top: 1rem;
}

.conditional-field-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-weight: 600;
  color: #1C2262;
  margin-bottom: 0.75rem;
}

.conditional-field-label i {
  font-size: 1rem;
}

/* Tooltips */
.info-tooltip {
  color: #6c757d;
  cursor: help;
  margin-left: 0.25rem;
}

.info-tooltip:hover {
  color: #1C2262;
}

/* Badge de tipo */
.tipo-badge-preview {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  background: #e7e9f0;
  color: #1C2262;
  border-radius: 30px;
  font-size: 0.8rem;
  font-weight: 600;
  margin-left: 0.5rem;
}

/* Slug preview */
.slug-preview {
  background: #f8f9fa;
  border-radius: 6px;
  padding: 0.5rem 1rem;
  font-family: monospace;
  font-size: 0.9rem;
  color: #1C2262;
  border: 1px solid #e9ecef;
  margin-top: 0.5rem;
}

/* Campos numéricos */
.number-hint {
  font-size: 0.8rem;
  color: #6c757d;
  margin-top: 0.25rem;
}

/* Vista previa JSON */
.json-preview {
  background: #f8f9fa;
  border-radius: 8px;
  padding: 0.75rem;
  font-family: monospace;
  font-size: 0.85rem;
  border: 1px solid #e9ecef;
  color: #1C2262;
  max-height: 100px;
  overflow-y: auto;
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
                <li class="breadcrumb-item"><a href="<?= URL ?>?uri=comunicaciones/admin_secciones/<?= (int)($d->pagina->pag_id ?? 0) ?>">Secciones</a></li>
                <li class="breadcrumb-item active"><?= $sec ? 'Editar' : 'Nueva' ?> Sección</li>
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
                <h2 class="mb-1" style="color: #1C2262; font-weight: 700;">
                  <?= $sec ? 'Editar sección' : 'Nueva sección' ?>
                </h2>
                <p class="text-muted mb-0">Configura los detalles de la sección</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 text-md-end">
            <a class="btn btn-outline-secondary" href="<?= URL ?>?uri=comunicaciones/admin_secciones/<?= (int)($d->pagina->pag_id ?? 0) ?>">
              <i class="fas fa-arrow-left me-1"></i> Volver a secciones
            </a>
          </div>
        </div>

        <!-- Mini tarjeta de información de la página -->
        <?php if ($pagina): ?>
        <div class="page-info-mini">
          <div class="page-info-mini-icon">
            <i class="fas fa-file-alt"></i>
          </div>
          <div class="page-info-mini-details">
            <div class="page-name"><?= h($pagina->pag_titulo ?? '') ?></div>
            <div class="page-slug">Slug: <code><?= h($pagina->pag_slug ?? '') ?></code></div>
          </div>
          <div>
            <span class="badge bg-<?= ($pagina->pag_estado ?? '') === 'ACTIVO' ? 'success' : 'secondary' ?>">
              <?= h($pagina->pag_estado ?? '') ?>
            </span>
          </div>
        </div>
        <?php endif; ?>

        <!-- Formulario principal -->
        <div class="row">
          <div class="col-lg-8">
            <div class="card shadow-sm border-0">
              <div class="card-body p-4">

                <form method="post" action="<?= URL ?>?uri=comunicaciones/admin_seccion_guardar" id="seccionForm">
                  <input type="hidden" name="sec_id" value="<?= (int)($sec->sec_id ?? 0) ?>">
                  <input type="hidden" name="pag_id" value="<?= (int)($d->pagina->pag_id ?? 0) ?>">

                  <!-- Información básica -->
                  <div class="form-section-title">
                    <i class="fas fa-info-circle me-2"></i>Información básica
                  </div>

                  <div class="row g-3 mb-4">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">
                        Título <i class="fas fa-question-circle info-tooltip" title="Título de la sección que se mostrará al usuario"></i>
                      </label>
                      <input class="form-control form-control-lg" name="sec_titulo" 
                             value="<?= h($sec->sec_titulo ?? '') ?>" 
                             placeholder="Ej: Últimas noticias, Nuestros servicios..."
                             onkeyup="actualizarPreview()">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label fw-semibold">
                        Slug <span class="text-danger">*</span>
                        <i class="fas fa-question-circle info-tooltip" title="Identificador único dentro de la página (solo letras minúsculas y guiones)"></i>
                      </label>
                      <input class="form-control" name="sec_slug" required
                             value="<?= h($sec->sec_slug ?? '') ?>"
                             placeholder="ultimas-noticias"
                             pattern="[a-z0-9-]+"
                             title="Solo letras minúsculas, números y guiones"
                             onkeyup="actualizarSlugPreview()">
                      <div class="slug-preview mt-2" id="slugPreview">
                        <i class="fas fa-link"></i> Slug: <span id="slugValue"><?= h($sec->sec_slug ?? '[slug]') ?></span>
                      </div>
                    </div>

                    <div class="col-12">
                      <label class="form-label fw-semibold">
                        Descripción <i class="fas fa-question-circle info-tooltip" title="Descripción detallada de la sección"></i>
                      </label>
                      <textarea class="form-control" name="sec_descripcion" rows="4" 
                                placeholder="Describe el contenido y propósito de esta sección..."><?= h($sec->sec_descripcion ?? '') ?></textarea>
                    </div>
                  </div>

                  <!-- Tipo de sección (selector visual) -->
                  <div class="form-section-title">
                    <i class="fas fa-puzzle-piece me-2"></i>Tipo de sección
                  </div>

                  <?php
                    $tp = strtoupper(trim((string)($sec->sec_tipo ?? 'CAROUSEL')));
                    if ($tp === '' || $tp === 'GRID') $tp = 'CARDS';
                    $allowed = ['TEXT', 'CAROUSEL', 'CARDS', 'LINKS', 'CALENDAR', 'VIDEO', 'CTA', 'SCHEDULE', 'FEATURE', 'IMAGE'];
                    if (!in_array($tp, $allowed, true)) $tp = 'CAROUSEL';
                  ?>
                  <input type="hidden" name="sec_tipo" id="sec_tipo_hidden" value="<?= $tp ?>">

                  <div class="tipo-selector-container mb-4">
                    <?php foreach ($allowed as $tipo): ?>
                      <div class="tipo-option <?= $tp === $tipo ? 'active' : '' ?>" 
                           onclick="seleccionarTipo('<?= $tipo ?>')"
                           data-tipo="<?= $tipo ?>">
                        <i class="fas fa-<?= getTipoIcono($tipo) ?>"></i>
                        <span class="tipo-nombre"><?= $tipo ?></span>
                        <span class="tipo-desc"><?= getTipoDescripcion($tipo) ?></span>
                      </div>
                    <?php endforeach; ?>
                  </div>

                  <!-- Configuración visual -->
                  <div class="form-section-title">
                    <i class="fas fa-paint-brush me-2"></i>Configuración visual
                  </div>

                  <div class="row g-3 mb-4">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">Layout (ancho)</label>
                      <?php $ly = $sec->sec_layout ?? 'CONTAINER'; ?>
                      <input type="hidden" name="sec_layout" id="sec_layout_hidden" value="<?= $ly ?>">
                      
                      <div class="layout-selector">
                        <div class="layout-option <?= $ly === 'CONTAINER' ? 'active' : '' ?>" 
                             onclick="seleccionarLayout('CONTAINER')">
                          <i class="fas fa-square"></i>
                          <span class="layout-nombre">CONTAINER</span>
                        </div>
                        <div class="layout-option <?= $ly === 'FULL' ? 'active' : '' ?>" 
                             onclick="seleccionarLayout('FULL')">
                          <i class="fas fa-expand"></i>
                          <span class="layout-nombre">FULL</span>
                        </div>
                        <div class="layout-option <?= $ly === 'NARROW' ? 'active' : '' ?>" 
                             onclick="seleccionarLayout('NARROW')">
                          <i class="fas fa-compress"></i>
                          <span class="layout-nombre">NARROW</span>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <label class="form-label fw-semibold">
                        Columnas (CARDS)
                        <i class="fas fa-question-circle info-tooltip" title="Número de columnas para la cuadrícula de tarjetas"></i>
                      </label>
                      <input type="number" class="form-control" name="sec_cols" 
                             value="<?= (int)($sec->sec_cols ?? 3) ?>" min="1" max="5">
                      <div class="number-hint">Mín: 1, Máx: 5</div>
                    </div>

                    <div class="col-md-3">
                      <label class="form-label fw-semibold">
                        Orden
                        <i class="fas fa-question-circle info-tooltip" title="Posición de la sección en la página (menor número = aparece primero)"></i>
                      </label>
                      <input type="number" class="form-control" name="sec_orden" 
                             value="<?= (int)($sec->sec_orden ?? 0) ?>" min="0" step="1">
                    </div>
                  </div>

                  <!-- Campos condicionales según el tipo -->
                  <div id="conditionalFields">
                    <!-- CALENDAR (iframe) -->
                    <div class="conditional-field" id="field_calendar" style="display: <?= $tp === 'CALENDAR' ? 'block' : 'none' ?>;">
                      <div class="conditional-field-label">
                        <i class="fas fa-calendar-alt"></i>
                        Configuración de calendario
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <label class="form-label">URL del iframe</label>
                          <input class="form-control" name="sec_iframe_src"
                                 value="<?= h($sec->sec_iframe_src ?? '') ?>"
                                 placeholder="https://calendar.google.com/calendar/embed?...">
                          <div class="form-text">Ejemplo: URL de Google Calendar, Outlook, etc.</div>
                        </div>
                      </div>
                    </div>

                    <!-- VIDEO -->
                    <div class="conditional-field" id="field_video" style="display: <?= $tp === 'VIDEO' ? 'block' : 'none' ?>;">
                      <div class="conditional-field-label">
                        <i class="fas fa-video"></i>
                        Configuración de video
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <label class="form-label">URL del video (YouTube, Vimeo)</label>
                          <input class="form-control" name="sec_video_url"
                                 value="<?= h($sec->sec_video_url ?? '') ?>"
                                 placeholder="https://www.youtube.com/embed/...">
                          <div class="form-text">Usa URL de embed (iframe) para mejor compatibilidad</div>
                        </div>
                      </div>
                    </div>

                    <!-- CTA -->
                    <div class="conditional-field" id="field_cta" style="display: <?= $tp === 'CTA' ? 'block' : 'none' ?>;">
                      <div class="conditional-field-label">
                        <i class="fas fa-bullhorn"></i>
                        Configuración de llamado a la acción
                      </div>
                      <div class="row g-3">
                        <div class="col-md-4">
                          <label class="form-label">Texto del botón</label>
                          <input class="form-control" name="sec_boton_texto" 
                                 value="<?= h($sec->sec_boton_texto ?? '') ?>"
                                 placeholder="Ver más, Contactar...">
                        </div>
                        <div class="col-md-8">
                          <label class="form-label">URL del botón</label>
                          <input class="form-control" name="sec_boton_url" 
                                 value="<?= h($sec->sec_boton_url ?? '') ?>"
                                 placeholder="https://...">
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Configuración avanzada -->
                  <div class="form-section-title">
                    <i class="fas fa-cog me-2"></i>Configuración avanzada
                  </div>

                  <div class="row g-3 mb-4">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">
                        JSON de configuración
                        <i class="fas fa-question-circle info-tooltip" title="Configuración adicional en formato JSON para personalizar el comportamiento"></i>
                      </label>
                      <textarea class="form-control font-monospace" name="sec_config_json_raw" rows="4"
                                placeholder='{"autoplay":true,"interval":6000,"effect":"slide"}'
                                id="jsonInput"
                                onkeyup="validarJSON()"><?= h($sec->sec_config_json ?? '') ?></textarea>
                      <div id="jsonValidation" class="form-text"></div>
                    </div>

                    <div class="col-md-3">
                      <label class="form-label fw-semibold">Estado</label>
                      <?php $st = $sec->sec_estado ?? 'ACTIVO'; ?>
                      <select class="form-select" name="sec_estado">
                        <option value="ACTIVO" <?= $st==='ACTIVO'?'selected':'' ?>>ACTIVO</option>
                        <option value="INACTIVO" <?= $st==='INACTIVO'?'selected':'' ?>>INACTIVO</option>
                      </select>
                    </div>

                    <div class="col-md-3">
                      <label class="form-label fw-semibold">ID de sección</label>
                      <input type="text" class="form-control bg-light" value="<?= (int)($sec->sec_id ?? 0) ?>" readonly disabled>
                      <div class="form-text">Autogenerado</div>
                    </div>
                  </div>

                  <!-- Botones de acción -->
                  <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="<?= URL ?>?uri=comunicaciones/admin_secciones/<?= (int)($d->pagina->pag_id ?? 0) ?>" 
                       class="btn btn-outline-danger px-4">
                      <i class="fas fa-times me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary px-5" style="background: #1C2262; border-color: #1C2262;">
                      <i class="fas fa-save me-1"></i> Guardar sección
                    </button>
                  </div>
                </form>

              </div>
            </div>
          </div>

          <!-- Panel lateral de ayuda -->
          <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 90px; z-index: 1020;">
              <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-semibold">
                  <i class="fas fa-question-circle me-2" style="color: #1C2262;"></i>
                  Ayuda y ejemplos
                </h5>
              </div>
              <div class="card-body">
                
                <!-- Información según tipo seleccionado -->
                <div id="helpContent">
                  <div class="mb-4">
                    <h6 class="fw-bold" id="helpTitle">Selecciona un tipo de sección</h6>
                    <p class="small text-muted" id="helpDescription">Cada tipo tiene diferentes opciones de configuración</p>
                  </div>

                  <div id="helpExamples">
                    <!-- Los ejemplos se actualizarán vía JS -->
                  </div>
                </div>

                <hr>

                <!-- Ejemplos de JSON -->
                <h6 class="fw-bold mb-3">Ejemplos de configuración JSON:</h6>
                
                <div class="mb-3">
                  <div class="small fw-bold">Para CAROUSEL:</div>
                  <pre class="json-preview small">{"autoplay":true,"interval":5000}</pre>
                </div>

                <div class="mb-3">
                  <div class="small fw-bold">Para CARDS:</div>
                  <pre class="json-preview small">{"columns_mobile":1,"columns_tablet":2}</pre>
                </div>

                <div class="mb-3">
                  <div class="small fw-bold">Para SCHEDULE:</div>
                  <pre class="json-preview small">{"show_weekends":false,"start_hour":8}</pre>
                </div>

                <!-- Tips -->
                <div class="alert alert-info mt-3 mb-0" style="background: #e7e9f0; border: none; color: #1C2262;">
                  <i class="fas fa-lightbulb me-2"></i>
                  <strong>Tips:</strong>
                  <ul class="small mt-2 mb-0 ps-3">
                    <li>El slug debe ser único dentro de la página</li>
                    <li>Las secciones inactivas no se muestran</li>
                    <li>Puedes reordenar secciones cambiando el número de orden</li>
                    <li>Los items se gestionan después de crear la sección</li>
                  </ul>
                </div>

              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</main>

<script>
// Variable global para el tipo seleccionado
let tipoSeleccionado = '<?= $tp ?>';

// Función para seleccionar tipo
function seleccionarTipo(tipo) {
  // Actualizar hidden input
  document.getElementById('sec_tipo_hidden').value = tipo;
  tipoSeleccionado = tipo;
  
  // Actualizar clases activas
  document.querySelectorAll('.tipo-option').forEach(opt => {
    if (opt.dataset.tipo === tipo) {
      opt.classList.add('active');
    } else {
      opt.classList.remove('active');
    }
  });
  
  // Mostrar/ocultar campos condicionales
  const campos = ['calendar', 'video', 'cta'];
  campos.forEach(campo => {
    const el = document.getElementById(`field_${campo}`);
    if (el) {
      el.style.display = (campo === tipo.toLowerCase()) ? 'block' : 'none';
    }
  });
  
  // Actualizar ayuda
  actualizarAyuda(tipo);
}

// Función para seleccionar layout
function seleccionarLayout(layout) {
  document.getElementById('sec_layout_hidden').value = layout;
  
  document.querySelectorAll('.layout-option').forEach(opt => {
    const texto = opt.querySelector('.layout-nombre').textContent;
    if (texto === layout) {
      opt.classList.add('active');
    } else {
      opt.classList.remove('active');
    }
  });
}

// Función para actualizar ayuda según tipo
function actualizarAyuda(tipo) {
  const helpTitle = document.getElementById('helpTitle');
  const helpDesc = document.getElementById('helpDescription');
  const helpExamples = document.getElementById('helpExamples');
  
  const ayudas = {
    'TEXT': {
      titulo: 'Sección de texto',
      desc: 'Ideal para contenido escrito, políticas, información general.',
      ejemplo: 'Usa este tipo para párrafos largos, listas, citas.'
    },
    'CAROUSEL': {
      titulo: 'Carrusel',
      desc: 'Múltiples elementos en formato de slideshow.',
      ejemplo: 'Crea items con imagen, título, descripción y enlace.'
    },
    'CARDS': {
      titulo: 'Tarjetas',
      desc: 'Contenido organizado en cuadrícula de tarjetas.',
      ejemplo: 'Perfecto para servicios, noticias, equipo.'
    },
    'LINKS': {
      titulo: 'Enlaces',
      desc: 'Lista de enlaces con descripciones.',
      ejemplo: 'Para directorios, recursos, documentos.'
    },
    'CALENDAR': {
      titulo: 'Calendario',
      desc: 'Calendario embebido vía iframe.',
      ejemplo: 'Configura la URL del iframe en el campo correspondiente.'
    },
    'VIDEO': {
      titulo: 'Video',
      desc: 'Video embebido (YouTube, Vimeo).',
      ejemplo: 'Usa URL de embed para mejor compatibilidad.'
    },
    'CTA': {
      titulo: 'Llamado a la acción',
      desc: 'Botón destacado con texto y enlace.',
      ejemplo: 'Configura el texto y la URL del botón.'
    },
    'SCHEDULE': {
      titulo: 'Horario',
      desc: 'Tabla de horarios tipo parrilla.',
      ejemplo: 'Cada item es un evento con hora, título y enlace.'
    },
    'FEATURE': {
      titulo: 'Imagen y texto alternado',
      desc: 'Items con imagen y texto lado a lado, alternando posición.',
      ejemplo: 'En el JSON del item usa {"imagen_pos":"left"} o {"imagen_pos":"right"} para controlar la posición.'
    },
    'IMAGE': {
      titulo: 'Sección de imagen',
      desc: 'Una imagen destacada con opción a texto superpuesto.',
      ejemplo: 'Ideal para banners o secciones visuales impactantes.'
    }
    
  };
  
  const info = ayudas[tipo] || ayudas['TEXT'];
  helpTitle.textContent = info.titulo;
  helpDesc.textContent = info.desc;
  helpExamples.innerHTML = `<div class="small bg-light p-2 rounded">${info.ejemplo}</div>`;
}

// Función para validar JSON
function validarJSON() {
  const input = document.getElementById('jsonInput');
  const validation = document.getElementById('jsonValidation');
  const valor = input.value.trim();
  
  if (valor === '') {
    validation.innerHTML = '<span class="text-muted"><i class="fas fa-info-circle"></i> Vacío (opcional)</span>';
    return;
  }
  
  try {
    JSON.parse(valor);
    validation.innerHTML = '<span class="text-success"><i class="fas fa-check-circle"></i> JSON válido</span>';
  } catch (e) {
    validation.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-circle"></i> JSON inválido: ' + e.message + '</span>';
  }
}

// Función para actualizar preview del slug
function actualizarSlugPreview() {
  const slugInput = document.querySelector('[name="sec_slug"]');
  const slugSpan = document.getElementById('slugValue');
  if (slugInput && slugSpan) {
    slugSpan.textContent = slugInput.value || '[slug]';
  }
}

// Validación del slug en tiempo real
document.querySelector('[name="sec_slug"]')?.addEventListener('input', function(e) {
  this.value = this.value.toLowerCase().replace(/[^a-z0-9-]/g, '');
  actualizarSlugPreview();
});

// Auto-generar slug a partir del título (solo para nuevos)
const tituloInput = document.querySelector('[name="sec_titulo"]');
const slugInput = document.querySelector('[name="sec_slug"]');
const isNew = <?= $sec ? 'false' : 'true' ?>;

if (isNew && tituloInput && slugInput && !slugInput.value) {
  tituloInput.addEventListener('blur', function() {
    if (!slugInput.value && this.value) {
      slugInput.value = this.value
        .toLowerCase()
        .replace(/[^a-z0-9áéíóúñü\s]/g, '')
        .replace(/[áéíóú]/g, match => {
          const mapa = { 'á':'a', 'é':'e', 'í':'i', 'ó':'o', 'ú':'u' };
          return mapa[match];
        })
        .replace(/\s+/g, '-')
        .replace(/ñ/g, 'n')
        .substring(0, 50);
      actualizarSlugPreview();
    }
  });
}

// Inicializar ayuda
actualizarAyuda(tipoSeleccionado);

// Validar JSON inicial si existe
validarJSON();
</script>

<?php require_once INCLUDES.'inc_footer.php'; ?>