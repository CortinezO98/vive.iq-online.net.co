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
$item = $d->item ?? null;
$seccion = $d->seccion ?? null;
$pagina = $d->pagina ?? null;
?>
<style>
/* Estilos adicionales para el formulario */
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

.image-preview-container {
  position: relative;
  display: inline-block;
  max-width: 100%;
}

.image-preview-container img {
  border: 1px solid #dee2e6;
  border-radius: 8px;
  padding: 4px;
  background: #fff;
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

.field-hint {
  font-size: 0.85rem;
  color: #6c757d;
  margin-top: 0.25rem;
}

.badge-preview {
  display: inline-block;
  padding: 0.25rem 0.5rem;
  background: #e9ecef;
  border-radius: 4px;
  font-size: 0.85rem;
  margin-top: 0.5rem;
}

.badge-preview .badge {
  margin-right: 0.5rem;
}

/* Mejoras para el selector de archivos */
.custom-file-upload {
  border: 2px dashed #dee2e6;
  border-radius: 8px;
  padding: 1.5rem;
  text-align: center;
  background: #f8f9fa;
  cursor: pointer;
  transition: all 0.2s;
}

.custom-file-upload:hover {
  border-color: #1C2262;
  background: #e9ecef;
}

.custom-file-upload i {
  font-size: 2rem;
  color: #6c757d;
  margin-bottom: 0.5rem;
}

.custom-file-upload .file-name {
  font-size: 0.9rem;
  color: #1C2262;
  font-weight: 500;
  margin-top: 0.5rem;
  word-break: break-all;
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
</style>

<main id="main-wrapper" class="main-wrapper">
  <?php require_once INCLUDES.'inc_header.php'; ?>

  <div id="app-content">
    <div class="app-content-area">
      <div class="container-fluid">

        <!-- Breadcrumb y título mejorado -->
        <div class="row mb-4">
          <div class="col-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= URL ?>?uri=comunicaciones/admin_paginas">Páginas</a></li>
                <?php if ($pagina): ?>
                <li class="breadcrumb-item"><a href="<?= URL ?>?uri=comunicaciones/admin_secciones/<?= (int)$pagina->pag_id ?>"><?= h($pagina->pag_titulo) ?></a></li>
                <?php endif; ?>
                <?php if ($seccion): ?>
                <li class="breadcrumb-item"><a href="<?= URL ?>?uri=comunicaciones/admin_items/<?= (int)$seccion->sec_id ?>"><?= h($seccion->sec_titulo ?: 'Sección') ?></a></li>
                <?php endif; ?>
                <li class="breadcrumb-item active"><?= $item ? 'Editar' : 'Nuevo' ?> Item</li>
              </ol>
            </nav>
            
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h2 class="mb-1" style="color: #1C2262; font-weight: 600;">
                  <i class="fas fa-<?= $item ? 'edit' : 'plus-circle' ?> me-2"></i>
                  <?= $item ? 'Editar Item' : 'Nuevo Item' ?>
                </h2>
                <p class="text-muted mb-0">
                  <?php if ($seccion): ?>
                    Sección: <strong><?= h($seccion->sec_titulo ?: $seccion->sec_slug) ?></strong> 
                    <span class="badge bg-info ms-2"><?= h($seccion->sec_tipo) ?></span>
                  <?php endif; ?>
                </p>
              </div>
              <a class="btn btn-outline-secondary" href="<?= URL ?>?uri=comunicaciones/admin_items/<?= (int)($d->seccion->sec_id ?? 0) ?>">
                <i class="fas fa-arrow-left me-1"></i> Volver
              </a>
            </div>
          </div>
        </div>

        <!-- Formulario principal -->
        <div class="row">
          <div class="col-lg-8 col-xl-9">
            <div class="card shadow-sm border-0">
              <div class="card-body p-4">

                <form method="post" enctype="multipart/form-data" id="itemForm"
                      action="<?= URL ?>?uri=comunicaciones/admin_item_guardar">

                  <input type="hidden" name="itm_id" value="<?= (int)($item->itm_id ?? 0) ?>">
                  <input type="hidden" name="sec_id" value="<?= (int)($d->seccion->sec_id ?? 0) ?>">
                  <input type="hidden" name="itm_imagen" id="itm_imagen_hidden" value="<?= h($item->itm_imagen ?? '') ?>">

                  <!-- Información básica -->
                  <div class="form-section-title">
                    <i class="fas fa-info-circle me-2"></i>Información básica
                  </div>

                  <div class="row g-3 mb-4">
                    <div class="col-md-8">
                      <label class="form-label fw-semibold">
                        Título <span class="text-danger">*</span>
                        <i class="fas fa-question-circle info-tooltip" title="Título del item que se mostrará al usuario"></i>
                      </label>
                      <input class="form-control form-control-lg" name="itm_titulo" 
                             value="<?= h($item->itm_titulo ?? '') ?>" 
                             placeholder="Ej: Reunión de equipo, Noticia importante..." required>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label fw-semibold">
                        Badge <i class="fas fa-question-circle info-tooltip" title="Etiqueta pequeña para destacar el item (ej: Nuevo, Urgente)"></i>
                      </label>
                      <input class="form-control" name="itm_badge"
                             value="<?= h($item->itm_badge ?? '') ?>"
                             placeholder="Nuevo / Destacado">
                      <?php if (!empty($item->itm_badge)): ?>
                      <div class="badge-preview">
                        <span class="badge bg-primary"><?= h($item->itm_badge) ?></span>
                        <span class="text-muted small">Vista previa</span>
                      </div>
                      <?php endif; ?>
                    </div>

                    <div class="col-12">
                      <label class="form-label fw-semibold">
                        Descripción <i class="fas fa-question-circle info-tooltip" title="Descripción detallada del item"></i>
                      </label>
                      <textarea class="form-control" name="itm_descripcion" rows="4" 
                                placeholder="Describe el contenido de este item..."><?= h($item->itm_descripcion ?? '') ?></textarea>
                    </div>
                  </div>

                  <!-- Enlace y target -->
                  <div class="form-section-title">
                    <i class="fas fa-link me-2"></i>Enlace
                  </div>

                  <div class="row g-3 mb-4">
                    <div class="col-md-8">
                      <label class="form-label fw-semibold">
                        URL <i class="fas fa-question-circle info-tooltip" title="Enlace al que redirigirá al hacer clic"></i>
                      </label>
                      <input class="form-control" name="itm_url"
                             value="<?= h($item->itm_url ?? '') ?>"
                             placeholder="https://ejemplo.com o ruta interna">
                    </div>

                    <div class="col-md-4">
                      <label class="form-label fw-semibold">Target</label>
                      <?php $tg = $item->itm_target ?? '_blank'; ?>
                      <select class="form-select" name="itm_target">
                        <option value="_blank" <?= $tg==='_blank'?'selected':'' ?>>_blank (nueva pestaña)</option>
                        <option value="_self" <?= $tg==='_self'?'selected':'' ?>>_self (misma pestaña)</option>
                      </select>
                    </div>
                  </div>

                  <!-- Estado y orden -->
                  <div class="form-section-title">
                    <i class="fas fa-cog me-2"></i>Configuración
                  </div>

                  <div class="row g-3 mb-4">
                    <div class="col-md-3">
                      <label class="form-label fw-semibold">Estado</label>
                      <?php $st = $item->itm_estado ?? 'ACTIVO'; ?>
                      <select class="form-select" name="itm_estado">
                        <option value="ACTIVO" <?= $st==='ACTIVO'?'selected':'' ?>>ACTIVO</option>
                        <option value="INACTIVO" <?= $st==='INACTIVO'?'selected':'' ?>>INACTIVO</option>
                      </select>
                    </div>

                    <div class="col-md-3">
                      <label class="form-label fw-semibold">
                        Orden <i class="fas fa-question-circle info-tooltip" title="Número para ordenar los items (menor = primero)"></i>
                      </label>
                      <input type="number" class="form-control" name="itm_orden" 
                             value="<?= (int)($item->itm_orden ?? 0) ?>" min="0" step="1">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label fw-semibold">
                        Embed <i class="fas fa-question-circle info-tooltip" title="Código HTML para incrustar (videos, iframes, etc.)"></i>
                      </label>
                      <textarea class="form-control" name="itm_embed" rows="2"
                                placeholder="<iframe src='...'></iframe>"><?= h($item->itm_embed ?? '') ?></textarea>
                    </div>
                  </div>

                  <!-- JSON extra -->
                  <div class="form-section-title">
                    <i class="fas fa-code me-2"></i>Datos adicionales (JSON)
                  </div>

                  <div class="row mb-4">
                    <div class="col-12">
                      <textarea class="form-control font-monospace" name="itm_extra_json_raw" rows="3"
                                placeholder='{"fecha":"2025-12-15","categoria":"Convocatoria"}'
                                style="font-size: 0.9rem;"><?= h($item->itm_extra_json ?? '') ?></textarea>
                      <div class="field-hint">
                        <i class="fas fa-info-circle me-1"></i>
                        Formato JSON válido. Se usará para datos personalizados según el tipo de sección.
                      </div>
                    </div>
                  </div>

                  <!-- Botones de acción -->
                  <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="<?= URL ?>?uri=comunicaciones/admin_items/<?= (int)($d->seccion->sec_id ?? 0) ?>" 
                       class="btn btn-outline-danger px-4">
                      <i class="fas fa-times me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary px-5" style="background: #1C2262; border-color: #1C2262;">
                      <i class="fas fa-save me-1"></i> Guardar
                    </button>
                  </div>
                </form>

              </div>
            </div>
          </div>

          <!-- Panel lateral para imagen -->
          <div class="col-lg-4 col-xl-3">
            <div class="card shadow-sm border-0 sticky-top" style="top: 90px; z-index: 1020;">
              <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-semibold">
                  <i class="fas fa-image me-2" style="color: #1C2262;"></i>
                  Imagen del item
                </h5>
              </div>
              <div class="card-body">
                
                <!-- Previsualización de imagen actual -->
                <div class="mb-4 text-center">
                  <label class="form-label fw-semibold d-block">Imagen actual</label>
                  <?php $src = !empty($item->itm_imagen) ? upload_src($item->itm_imagen) : ''; ?>
                  
                  <div class="image-preview-container" id="currentImageContainer" style="<?= $src ? '' : 'display: none;' ?>">
                    <img src="<?= h($src) ?>" class="img-fluid rounded shadow-sm" style="max-height: 180px;" alt="Imagen actual" id="currentImage">
                    <button type="button" class="btn-remove-image" id="removeImageBtn" title="Eliminar imagen">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                  
                  <?php if ($src): ?>
                    <div class="small text-muted mt-2">
                      <code class="text-wrap"><?= h($item->itm_imagen) ?></code>
                    </div>
                  <?php else: ?>
                    <div class="text-muted small" id="noImageText">No hay imagen actual</div>
                  <?php endif; ?>
                </div>

                <!-- Subir nueva imagen -->
                <div class="mb-3">
                  <label class="form-label fw-semibold">Subir nueva imagen</label>
                  
                  <div class="custom-file-upload" id="fileUploadArea">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <div class="mt-2">Haz clic o arrastra una imagen</div>
                    <div class="small text-muted mt-1">PNG, JPG, WEBP o GIF (max. 5MB)</div>
                    <div class="file-name d-none" id="fileName"></div>
                    <input type="file" name="itm_imagen_file" id="itm_imagen_file" 
                           accept=".jpg,.jpeg,.png,.webp,.gif" style="display: none;">
                  </div>
                  
                  <div class="field-hint mt-2">
                    <i class="fas fa-info-circle me-1"></i>
                    Si subes una imagen, reemplazará la actual automáticamente.
                  </div>
                </div>

                <!-- Vista previa de la nueva imagen -->
                <div id="newImagePreview" class="text-center d-none">
                  <label class="form-label fw-semibold d-block mt-3">Vista previa</label>
                  <img src="" class="img-fluid rounded shadow-sm" style="max-height: 150px;" alt="Vista previa" id="preview">
                  <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="cancelNewImage">
                    <i class="fas fa-times me-1"></i> Cancelar nueva imagen
                  </button>
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
document.addEventListener('DOMContentLoaded', function() {
  
  // Manejo del selector de archivos personalizado
  const fileInput = document.getElementById('itm_imagen_file');
  const fileUploadArea = document.getElementById('fileUploadArea');
  const fileName = document.getElementById('fileName');
  const preview = document.getElementById('preview');
  const newImagePreview = document.getElementById('newImagePreview');
  const currentImageContainer = document.getElementById('currentImageContainer');
  const noImageText = document.getElementById('noImageText');
  const removeImageBtn = document.getElementById('removeImageBtn');
  const cancelNewImage = document.getElementById('cancelNewImage');
  const imagenHidden = document.getElementById('itm_imagen_hidden');

  // Hacer clic en el área para abrir el selector
  fileUploadArea.addEventListener('click', function() {
    fileInput.click();
  });

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
    };
    reader.readAsDataURL(file);
  }

  // Cancelar nueva imagen
  cancelNewImage.addEventListener('click', function() {
    fileInput.value = '';
    fileName.classList.add('d-none');
    newImagePreview.classList.add('d-none');
    fileUploadArea.classList.remove('border-primary');
  });

  // Eliminar imagen actual
  removeImageBtn.addEventListener('click', function() {
    if (confirm('¿Estás seguro de eliminar la imagen actual?')) {
      currentImageContainer.style.display = 'none';
      if (noImageText) noImageText.style.display = 'block';
      imagenHidden.value = '';
      
      // También limpiar el campo de archivo si hay uno nuevo
      fileInput.value = '';
      fileName.classList.add('d-none');
      newImagePreview.classList.add('d-none');
    }
  });

  // Validación del formulario
  const form = document.getElementById('itemForm');
  form.addEventListener('submit', function(e) {
    const titulo = document.querySelector('[name="itm_titulo"]').value.trim();
    
    if (!titulo) {
      e.preventDefault();
      alert('El título es obligatorio');
      return;
    }
  });

});
</script>

<?php require_once INCLUDES.'inc_footer.php'; ?>