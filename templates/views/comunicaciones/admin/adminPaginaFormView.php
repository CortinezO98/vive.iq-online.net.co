<?php require_once INCLUDES.'inc_head.php'; ?>
<?php
if (!function_exists('h')) {
  function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}

// Helper para obtener la URL de la imagen subida
if (!function_exists('upload_src')) {
  function upload_src($rel){
    if (!$rel) return '';
    return rtrim(UPLOADS, '/').'/'.ltrim($rel, '/');
  }
}

$edit = $d->pagina ?? null;

// Helper para obtener el color del estado
function getEstadoColor($estado) {
  return $estado === 'ACTIVO' ? 'success' : 'secondary';
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

/* Preview del hero */
.hero-preview {
  background: #f8f9fa;
  border-radius: 12px;
  padding: 1.5rem;
  margin-top: 1rem;
  border: 1px solid #e9ecef;
  position: relative;
  min-height: 150px;
  display: flex;
  align-items: center;
  justify-content: center;
  background-size: cover;
  background-position: center;
  transition: all 0.3s ease;
}

.hero-preview.has-bg {
  color: white;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.hero-preview-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.45);
  border-radius: 12px;
  display: none;
}

.hero-preview.has-bg .hero-preview-overlay {
  display: block;
}

.hero-preview-content {
  position: relative;
  z-index: 2;
  text-align: center;
  width: 100%;
}

.hero-preview-content h4 {
  font-size: 1.5rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
}

.hero-preview-content p {
  font-size: 1rem;
  opacity: 0.9;
  margin-bottom: 0;
}

/* Selector de alineación visual */
.alignment-selector {
  display: flex;
  gap: 0.5rem;
  margin-top: 0.5rem;
}

.alignment-option {
  flex: 1;
  text-align: center;
  padding: 0.5rem;
  border: 1px solid #dee2e6;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.2s;
  background: #fff;
}

.alignment-option:hover {
  border-color: #1C2262;
  background: #f0f1f7;
}

.alignment-option.active {
  border-color: #1C2262;
  background: #e7e9f0;
  color: #1C2262;
  font-weight: 500;
}

.alignment-option i {
  font-size: 1.2rem;
  margin-bottom: 0.25rem;
  display: block;
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

/* Selector de overlay */
.overlay-toggle {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 0.5rem 0;
}

.overlay-toggle .form-check {
  margin: 0;
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

.slug-preview i {
  color: #6c757d;
  margin-right: 0.5rem;
}

/* Badge de estado */
.status-badge {
  display: inline-block;
  padding: 0.35rem 0.75rem;
  border-radius: 30px;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}

/* Estilos para la previsualización de imagen */
.image-preview-container {
  position: relative;
  display: inline-block;
  max-width: 100%;
  margin-top: 0.5rem;
}

.image-preview-container img {
  border: 2px solid #e9ecef;
  border-radius: 8px;
  padding: 4px;
  background: #fff;
  max-height: 150px;
  width: auto;
}

.image-preview-container .btn-remove-image {
  position: absolute;
  top: -8px;
  right: -8px;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background: #dc3545;
  color: white;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  cursor: pointer;
  box-shadow: 0 2px 4px rgba(0,0,0,0.2);
  transition: all 0.2s;
}

.image-preview-container .btn-remove-image:hover {
  background: #bb2d3b;
  transform: scale(1.1);
}

/* Selector de archivo personalizado */
.custom-file-upload {
  border: 2px dashed #dee2e6;
  border-radius: 8px;
  padding: 1rem;
  text-align: center;
  background: #f8f9fa;
  cursor: pointer;
  transition: all 0.2s;
  margin-bottom: 0.5rem;
}

.custom-file-upload:hover {
  border-color: #1C2262;
  background: #e9ecef;
}

.custom-file-upload i {
  font-size: 1.5rem;
  color: #6c757d;
  margin-bottom: 0.25rem;
}

.custom-file-upload .file-name {
  font-size: 0.85rem;
  color: #1C2262;
  font-weight: 500;
  margin-top: 0.25rem;
  word-break: break-all;
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
                <li class="breadcrumb-item active"><?= $edit ? 'Editar' : 'Nueva' ?> Página</li>
              </ol>
            </nav>
          </div>
        </div>

        <!-- Cabecera con título y acción -->
        <div class="row align-items-center mb-4">
          <div class="col-md-8">
            <div class="d-flex align-items-center gap-3">
              <div style="width: 48px; height: 48px; border-radius: 12px; background: #1C2262; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                <i class="fas fa-<?= $edit ? 'edit' : 'plus-circle' ?>"></i>
              </div>
              <div>
                <h2 class="mb-1" style="color: #1C2262; font-weight: 700;">
                  <?= $edit ? 'Editar página' : 'Nueva página' ?>
                </h2>
                <?php if ($edit): ?>
                <div class="d-flex align-items-center gap-2">
                  <span class="status-badge bg-<?= getEstadoColor($edit->pag_estado ?? '') ?> text-white">
                    <i class="fas fa-<?= ($edit->pag_estado ?? '') === 'ACTIVO' ? 'check-circle' : 'times-circle' ?> me-1"></i>
                    <?= h($edit->pag_estado ?? '') ?>
                  </span>
                  <span class="text-muted">|</span>
                  <span><strong>Slug:</strong> <code><?= h($edit->pag_slug ?? '') ?></code></span>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="col-md-4 text-md-end">
            <a class="btn btn-outline-secondary" href="<?= URL ?>?uri=comunicaciones/admin_paginas">
              <i class="fas fa-arrow-left me-1"></i> Volver al listado
            </a>
          </div>
        </div>

        <!-- Formulario principal -->
        <div class="row">
          <div class="col-lg-8">
            <div class="card shadow-sm border-0">
              <div class="card-body p-4">

                <form method="post" action="<?= URL ?>?uri=comunicaciones/admin_pagina_guardar" id="paginaForm" enctype="multipart/form-data">
                  <input type="hidden" name="pag_id" value="<?= (int)($edit->pag_id ?? 0) ?>">

                  <!-- Información básica -->
                  <div class="form-section-title">
                    <i class="fas fa-info-circle me-2"></i>Información básica
                  </div>

                  <div class="row g-3 mb-4">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">
                        Título <span class="text-danger">*</span>
                        <i class="fas fa-question-circle info-tooltip" title="Título principal de la página que se mostrará en el hero"></i>
                      </label>
                      <input class="form-control form-control-lg" name="pag_titulo" 
                             value="<?= h($edit->pag_titulo ?? '') ?>" 
                             placeholder="Ej: Nuestra compañía, Cultura iQ..." required
                             onkeyup="actualizarPreview()">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">
                        Mostrar título en el banner
                        <i class="fas fa-question-circle info-tooltip" title="Define si el título se mostrará en el banner principal"></i>
                      </label>
                      <select class="form-select" name="pag_mostrar_titulo_banner" onchange="actualizarPreview()">
                        <option value="1" <?= ((int)($edit->pag_mostrar_titulo_banner ?? 1) === 1) ? 'selected' : '' ?>>Sí</option>
                        <option value="0" <?= ((int)($edit->pag_mostrar_titulo_banner ?? 1) === 0) ? 'selected' : '' ?>>No</option>
                      </select>
                    </div>
                    

                    <div class="col-md-6">
                      <label class="form-label fw-semibold">
                        Slug <span class="text-danger">*</span>
                        <i class="fas fa-question-circle info-tooltip" title="Identificador único para la URL (solo letras minúsculas y guiones)"></i>
                      </label>
                      <input class="form-control" name="pag_slug" 
                             value="<?= h($edit->pag_slug ?? '') ?>" 
                             placeholder="ej: nuestra-compania" required
                             pattern="[a-z0-9-]+" 
                             title="Solo letras minúsculas, números y guiones">
                      <div class="slug-preview mt-2">
                        <i class="fas fa-link"></i>
                        <span id="slugPreview"><?= URL ?>?uri=comunicaciones/ver/<?= h($edit->pag_slug ?? '[slug]') ?></span>
                      </div>
                    </div>

                    <div class="col-md-8">
                      <label class="form-label fw-semibold">
                        Subtítulo
                        <i class="fas fa-question-circle info-tooltip" title="Subtítulo o descripción breve que aparecerá debajo del título"></i>
                      </label>
                      <input class="form-control" name="pag_subtitulo" 
                             value="<?= h($edit->pag_subtitulo ?? '') ?>" 
                             placeholder="Breve descripción de la página"
                             onkeyup="actualizarPreview()">
                    </div>

                    <div class="col-md-4">
                      <label class="form-label fw-semibold">
                        Orden
                        <i class="fas fa-question-circle info-tooltip" title="Posición en el menú (menor número = aparece primero)"></i>
                      </label>
                      <input type="number" class="form-control" name="pag_orden" 
                             value="<?= (int)($edit->pag_orden ?? 0) ?>" min="0" step="1">
                    </div>

                    <div class="col-12">
                      <label class="form-label fw-semibold">
                        Descripción
                        <i class="fas fa-question-circle info-tooltip" title="Descripción completa de la página (opcional)"></i>
                      </label>
                      <textarea class="form-control" name="pag_descripcion" rows="4" 
                                placeholder="Describe el contenido de esta página..."><?= h($edit->pag_descripcion ?? '') ?></textarea>
                    </div>
                  </div>

                  <!-- Configuración del Hero (MODIFICADO PARA SUBIR IMÁGENES) -->
                  <div class="form-section-title">
                    <i class="fas fa-image me-2"></i>Configuración del Hero (Cabecera)
                  </div>

                  <div class="row g-3 mb-4">
                    <!-- Campo para subir imagen -->
                    <div class="col-md-8">
                      <label class="form-label fw-semibold">
                        Imagen de fondo
                        <i class="fas fa-question-circle info-tooltip" title="Imagen de fondo para el header. Se recomienda 1920x1080px"></i>
                      </label>
                      
                      <div class="row g-2">
                        <div class="col-8">
                          <div class="custom-file-upload" id="fileUploadArea">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <div class="small">Haz clic o arrastra una imagen</div>
                            <div class="file-name d-none" id="fileName"></div>
                            <input type="file" name="pag_hero_imagen" id="heroImagen" 
                                   accept="image/jpeg,image/png,image/webp,image/gif" style="display: none;">
                          </div>
                          <div class="form-text">Formatos: JPG, PNG, WEBP, GIF. Máx. 5MB</div>
                        </div>
                        <div class="col-4">
                          <label class="form-label small">O ruta manual:</label>
                          <input class="form-control form-control-sm" name="pag_hero_bg" id="heroBgInput"
                                 value="<?= h($edit->pag_hero_bg ?? '') ?>"
                                 placeholder="comunicaciones/mi-imagen.jpg"
                                 onchange="actualizarPreview()">
                        </div>
                      </div>
                      
                      <!-- Vista previa de la imagen actual -->
                      <?php if (!empty($edit->pag_hero_bg)): ?>
                        <div class="image-preview-container" id="currentImageContainer">
                          <img src="<?= upload_src($edit->pag_hero_bg) ?>" class="img-fluid rounded" alt="Vista previa">
                          <button type="button" class="btn-remove-image" id="removeImageBtn" title="Eliminar imagen">
                            <i class="fas fa-times"></i>
                          </button>
                          <div class="small text-muted mt-1">
                            <i class="fas fa-image me-1"></i> <code><?= h($edit->pag_hero_bg) ?></code>
                          </div>
                        </div>
                      <?php else: ?>
                        <div class="text-muted small mt-2" id="noImageText">
                          <i class="fas fa-info-circle me-1"></i> No hay imagen actual
                        </div>
                      <?php endif; ?>
                      
                      <!-- Vista previa de nueva imagen -->
                      <div id="newImagePreview" class="d-none mt-2">
                        <label class="form-label small">Nueva imagen:</label>
                        <div class="image-preview-container">
                          <img src="" class="img-fluid rounded" id="preview" alt="Vista previa">
                          <button type="button" class="btn-remove-image" id="cancelNewImage" title="Cancelar">
                            <i class="fas fa-times"></i>
                          </button>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label fw-semibold">Alineación del texto</label>
                      <?php $al = $edit->pag_hero_alineacion ?? 'center'; ?>
                      <input type="hidden" name="pag_hero_alineacion" id="heroAlignment" value="<?= $al ?>">
                      <div class="alignment-selector">
                        <div class="alignment-option <?= $al === 'left' ? 'active' : '' ?>" 
                             onclick="setAlignment('left')" data-alignment="left">
                          <i class="fas fa-align-left"></i>
                          <span class="small d-block">Izquierda</span>
                        </div>
                        <div class="alignment-option <?= $al === 'center' ? 'active' : '' ?>" 
                             onclick="setAlignment('center')" data-alignment="center">
                          <i class="fas fa-align-center"></i>
                          <span class="small d-block">Centro</span>
                        </div>
                        <div class="alignment-option <?= $al === 'right' ? 'active' : '' ?>" 
                             onclick="setAlignment('right')" data-alignment="right">
                          <i class="fas fa-align-right"></i>
                          <span class="small d-block">Derecha</span>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="overlay-toggle">
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" role="switch" 
                                 name="pag_hero_overlay" id="heroOverlay" value="1"
                                 <?= ((int)($edit->pag_hero_overlay ?? 1)) === 1 ? 'checked' : '' ?>
                                 onchange="actualizarPreview()">
                          <label class="form-check-label fw-semibold" for="heroOverlay">
                            Mostrar overlay oscuro
                            <i class="fas fa-question-circle info-tooltip" title="Añade una capa semitransparente para mejorar la legibilidad del texto"></i>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Estado -->
                  <div class="form-section-title">
                    <i class="fas fa-toggle-on me-2"></i>Estado
                  </div>

                  <div class="row mb-4">
                    <div class="col-md-6">
                      <?php $st = $edit->pag_estado ?? 'ACTIVO'; ?>
                      <div class="btn-group w-100" role="group">
                        <input type="radio" class="btn-check" name="pag_estado" id="estadoActivo" 
                               value="ACTIVO" <?= $st === 'ACTIVO' ? 'checked' : '' ?>>
                        <label class="btn btn-outline-success" for="estadoActivo">
                          <i class="fas fa-check-circle me-1"></i> ACTIVO
                        </label>

                        <input type="radio" class="btn-check" name="pag_estado" id="estadoInactivo" 
                               value="INACTIVO" <?= $st === 'INACTIVO' ? 'checked' : '' ?>>
                        <label class="btn btn-outline-secondary" for="estadoInactivo">
                          <i class="fas fa-times-circle me-1"></i> INACTIVO
                        </label>
                      </div>
                      <div class="form-text">
                        <i class="fas fa-info-circle me-1"></i>
                        Las páginas inactivas no son visibles en el portal.
                      </div>
                    </div>
                  </div>

                  <!-- Botones de acción -->
                  <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="<?= URL ?>?uri=comunicaciones/admin_paginas" class="btn btn-outline-danger px-4">
                      <i class="fas fa-times me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary px-5" style="background: #1C2262; border-color: #1C2262;">
                      <i class="fas fa-save me-1"></i> Guardar página
                    </button>
                  </div>
                </form>

              </div>
            </div>
          </div>

          <!-- Panel lateral de vista previa -->
          <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 90px; z-index: 1020;">
              <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-semibold">
                  <i class="fas fa-eye me-2" style="color: #1C2262;"></i>
                  Vista previa del Hero
                </h5>
              </div>
              <div class="card-body">
                
                <!-- Preview del hero -->
                <div id="heroPreview" class="hero-preview mb-3" 
                     style="<?php if (!empty($edit->pag_hero_bg)): ?>background-image: url('<?= upload_src($edit->pag_hero_bg) ?>');<?php endif; ?>">
                  <div class="hero-preview-overlay" id="previewOverlay" 
                       style="display: <?= ((int)($edit->pag_hero_overlay ?? 1)) === 1 ? 'block' : 'none' ?>;"></div>
                  <div class="hero-preview-content" id="previewContent" 
                       style="text-align: <?= $edit->pag_hero_alineacion ?? 'center' ?>;">
                    <h4 id="previewTitle"><?= h($edit->pag_titulo ?? 'Título de la página') ?></h4>
                    <p id="previewSubtitle"><?= h($edit->pag_subtitulo ?? 'Subtítulo opcional') ?></p>
                  </div>
                </div>

                <!-- Sugerencias de imágenes -->
                <div class="mt-4">
                  <label class="form-label fw-semibold">Sugerencias de imágenes</label>
                  <div class="small text-muted mb-2">Haz clic para usar estas imágenes de ejemplo:</div>
                  <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-light text-dark p-2" style="cursor: pointer;" onclick="usarImagen('comunicaciones/hero-default.jpg')">
                      <i class="fas fa-image me-1"></i> default.jpg
                    </span>
                    <span class="badge bg-light text-dark p-2" style="cursor: pointer;" onclick="usarImagen('comunicaciones/hero-company.jpg')">
                      <i class="fas fa-image me-1"></i> company.jpg
                    </span>
                    <span class="badge bg-light text-dark p-2" style="cursor: pointer;" onclick="usarImagen('comunicaciones/hero-culture.jpg')">
                      <i class="fas fa-image me-1"></i> culture.jpg
                    </span>
                  </div>
                </div>

                <!-- Recomendaciones -->
                <div class="alert alert-info mt-4 mb-0" style="background: #e7e9f0; border: none; color: #1C2262;">
                  <i class="fas fa-lightbulb me-2"></i>
                  <strong>Recomendaciones:</strong>
                  <ul class="small mt-2 mb-0 ps-3">
                    <li>Usa imágenes con relación 16:9</li>
                    <li>Tamaño mínimo recomendado: 1920x1080px</li>
                    <li>Formatos soportados: JPG, PNG, WEBP</li>
                    <li>El texto siempre será visible gracias al overlay</li>
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
// Función para actualizar la vista previa
function actualizarPreview() {
  const titulo = document.querySelector('[name="pag_titulo"]').value;
  const subtitulo = document.querySelector('[name="pag_subtitulo"]').value;
  const bgInput = document.querySelector('[name="pag_hero_bg"]').value;
  const overlay = document.getElementById('heroOverlay').checked;
  const alignment = document.getElementById('heroAlignment').value;
  const slug = document.querySelector('[name="pag_slug"]').value;
  const mostrarTitulo = document.querySelector('[name="pag_mostrar_titulo_banner"]').value;
  const previewTitle = document.getElementById('previewTitle');

  // Actualizar título y subtítulo
  document.getElementById('previewTitle').textContent = titulo || 'Título de la página';
  document.getElementById('previewSubtitle').textContent = subtitulo || 'Subtítulo opcional';

  if (mostrarTitulo == "0") {
    previewTitle.style.display = 'none';
  } else {
    previewTitle.style.display = 'block';
  }
  
  // Actualizar alineación
  document.getElementById('previewContent').style.textAlign = alignment;
  
  // Actualizar overlay
  document.getElementById('previewOverlay').style.display = overlay ? 'block' : 'none';
  
  // Actualizar imagen de fondo
  const heroPreview = document.getElementById('heroPreview');
  if (bgInput) {
    heroPreview.style.backgroundImage = `url('<?= rtrim(UPLOADS, '/') ?>/${bgInput}')`;
    heroPreview.classList.add('has-bg');
  } else {
    heroPreview.style.backgroundImage = '';
    heroPreview.classList.remove('has-bg');
  }

  // Actualizar preview del slug
  const slugPreview = document.getElementById('slugPreview');
  if (slugPreview) {
    slugPreview.textContent = `<?= URL ?>?uri=comunicaciones/ver/${slug || '[slug]'}`;
  }
}

// Función para establecer la alineación
function setAlignment(alignment) {
  document.getElementById('heroAlignment').value = alignment;
  
  // Actualizar clases activas
  document.querySelectorAll('.alignment-option').forEach(opt => {
    if (opt.dataset.alignment === alignment) {
      opt.classList.add('active');
    } else {
      opt.classList.remove('active');
    }
  });
  
  actualizarPreview();
}

// Función para usar una imagen sugerida
function usarImagen(ruta) {
  document.querySelector('[name="pag_hero_bg"]').value = ruta;
  actualizarPreview();
}

// Manejo del selector de archivos
document.addEventListener('DOMContentLoaded', function() {
  const fileInput = document.getElementById('heroImagen');
  const fileUploadArea = document.getElementById('fileUploadArea');
  const fileName = document.getElementById('fileName');
  const preview = document.getElementById('preview');
  const newImagePreview = document.getElementById('newImagePreview');
  const currentImageContainer = document.getElementById('currentImageContainer');
  const noImageText = document.getElementById('noImageText');
  const removeImageBtn = document.getElementById('removeImageBtn');
  const cancelNewImage = document.getElementById('cancelNewImage');
  const heroBgInput = document.getElementById('heroBgInput');

  // Hacer clic en el área para abrir el selector
  if (fileUploadArea) {
    fileUploadArea.addEventListener('click', function() {
      fileInput.click();
    });
  }

  // Arrastrar y soltar
  fileUploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    fileUploadArea.style.borderColor = '#1C2262';
    fileUploadArea.style.background = '#e9ecef';
  });

  fileUploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    fileUploadArea.style.borderColor = '#dee2e6';
    fileUploadArea.style.background = '#f8f9fa';
  });

  fileUploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    fileUploadArea.style.borderColor = '#dee2e6';
    fileUploadArea.style.background = '#f8f9fa';
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
      fileInput.files = files;
      handleFileSelect(files[0]);
    }
  });

  // Manejar selección de archivo
  fileInput.addEventListener('change', function(e) {
    if (this.files.length > 0) {
      handleFileSelect(this.files[0]);
    }
  });

  function handleFileSelect(file) {
    // Validar tipo de archivo
    const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif'];
    if (!validTypes.includes(file.type)) {
      alert('Tipo de archivo no válido. Solo se permiten imágenes JPG, PNG, WEBP o GIF.');
      fileInput.value = '';
      return;
    }

    // Validar tamaño (5MB)
    if (file.size > 5 * 1024 * 1024) {
      alert('El archivo no puede superar los 5MB.');
      fileInput.value = '';
      return;
    }

    // Mostrar nombre del archivo
    fileName.textContent = file.name;
    fileName.classList.remove('d-none');
    fileUploadArea.classList.add('border-primary');

    // Mostrar vista previa
    const reader = new FileReader();
    reader.onload = function(e) {
      preview.src = e.target.result;
      newImagePreview.classList.remove('d-none');
      
      // Limpiar el campo de ruta manual cuando se sube una imagen
      if (heroBgInput) heroBgInput.value = '';
    };
    reader.readAsDataURL(file);
  }

  // Cancelar nueva imagen
  if (cancelNewImage) {
    cancelNewImage.addEventListener('click', function() {
      fileInput.value = '';
      fileName.classList.add('d-none');
      newImagePreview.classList.add('d-none');
      fileUploadArea.classList.remove('border-primary');
    });
  }

  // Eliminar imagen actual
  if (removeImageBtn) {
    removeImageBtn.addEventListener('click', function() {
      if (confirm('¿Estás seguro de eliminar la imagen actual?')) {
        if (currentImageContainer) currentImageContainer.style.display = 'none';
        if (noImageText) noImageText.style.display = 'block';
        if (heroBgInput) heroBgInput.value = '';
        
        // También limpiar el campo de archivo si hay uno nuevo
        if (fileInput) {
          fileInput.value = '';
          fileName.classList.add('d-none');
          newImagePreview.classList.add('d-none');
        }
        
        actualizarPreview();
      }
    });
  }

  actualizarPreview();

  // Validación del slug en tiempo real
  const slugInput = document.querySelector('[name="pag_slug"]');
  if (slugInput) {
    slugInput.addEventListener('input', function(e) {
      this.value = this.value.toLowerCase().replace(/[^a-z0-9-]/g, '');
    });
  }

  // Auto-generar slug a partir del título (solo para nuevos)
  const tituloInput = document.querySelector('[name="pag_titulo"]');
  const isNew = <?= $edit ? 'false' : 'true' ?>;
  
  if (isNew && tituloInput && slugInput && !slugInput.value) {
    tituloInput.addEventListener('blur', function() {
      if (!slugInput.value) {
        slugInput.value = this.value
          .toLowerCase()
          .replace(/[^a-z0-9áéíóúñü\s]/g, '')
          .replace(/[áéíóú]/g, match => {
            const mapa = { 'á':'a', 'é':'e', 'í':'i', 'ó':'o', 'ú':'u' };
            return mapa[match];
          })
          .replace(/\s+/g, '-')
          .replace(/ñ/g, 'n');
        actualizarPreview();
      }
    });
  }
});
</script>

<?php require_once INCLUDES.'inc_footer.php'; ?>