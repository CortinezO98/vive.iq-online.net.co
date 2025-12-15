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
?>
<main id="main-wrapper" class="main-wrapper">
  <?php require_once INCLUDES.'inc_header.php'; ?>

  <div id="app-content"><div class="app-content-area">
    <div class="container-fluid">

      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Comunicaciones | <?= $item ? 'Editar' : 'Nuevo' ?> Item</h3>
        <a class="btn btn-outline-secondary btn-sm"
           href="<?= URL ?>?uri=comunicaciones/admin_items/<?= (int)($d->seccion->sec_id ?? 0) ?>">
          Volver
        </a>
      </div>

      <div class="card shadow-sm">
        <div class="card-body">

          <form method="post" enctype="multipart/form-data"
                action="<?= URL ?>?uri=comunicaciones/admin_item_guardar">

            <input type="hidden" name="itm_id" value="<?= (int)($item->itm_id ?? 0) ?>">
            <input type="hidden" name="sec_id" value="<?= (int)($d->seccion->sec_id ?? 0) ?>">
            <input type="hidden" name="itm_imagen" value="<?= h($item->itm_imagen ?? '') ?>">

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Título</label>
                <input class="form-control" name="itm_titulo" value="<?= h($item->itm_titulo ?? '') ?>" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Badge (opcional)</label>
                <input class="form-control" name="itm_badge"
                       value="<?= h($item->itm_badge ?? '') ?>"
                       placeholder="Nuevo / Convocatoria / Importante">
              </div>

              <div class="col-md-12">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" name="itm_descripcion" rows="3"><?= h($item->itm_descripcion ?? '') ?></textarea>
              </div>

              <div class="col-md-6">
                <label class="form-label">Subir imagen (opcional)</label>
                <input class="form-control" type="file" name="itm_imagen_file" accept=".jpg,.jpeg,.png,.webp,.gif">
                <div class="form-text">Si subes una imagen, reemplaza la ruta actual automáticamente.</div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Imagen actual</label>
                <?php $src = !empty($item->itm_imagen) ? upload_src($item->itm_imagen) : ''; ?>
                <div class="border rounded p-2 bg-light">
                  <?php if ($src): ?>
                    <img src="<?= h($src) ?>" class="img-fluid rounded" style="max-height:110px;" alt="">
                    <div class="small text-muted mt-2"><code><?= h($item->itm_imagen) ?></code></div>
                  <?php else: ?>
                    <div class="text-muted small">Sin imagen</div>
                  <?php endif; ?>
                </div>
              </div>

              <div class="col-md-7">
                <label class="form-label">URL (link de redirección)</label>
                <input class="form-control" name="itm_url"
                       value="<?= h($item->itm_url ?? '') ?>"
                       placeholder="https://... o ruta interna (ej: modulo/pagina)">
              </div>

              <div class="col-md-5">
                <label class="form-label">Target</label>
                <?php $tg = $item->itm_target ?? '_blank'; ?>
                <select class="form-select" name="itm_target">
                  <option value="_blank" <?= $tg==='_blank'?'selected':'' ?>>_blank</option>
                  <option value="_self" <?= $tg==='_self'?'selected':'' ?>>_self</option>
                </select>
              </div>

              <div class="col-md-9">
                <label class="form-label">Embed (opcional)</label>
                <textarea class="form-control" name="itm_embed" rows="3"
                          placeholder="<iframe ...></iframe> (para VIDEO/CALENDAR si decides manejar embed por item)"><?= h($item->itm_embed ?? '') ?></textarea>
              </div>

              <div class="col-md-3">
                <label class="form-label">Estado</label>
                <?php $st = $item->itm_estado ?? 'ACTIVO'; ?>
                <select class="form-select" name="itm_estado">
                  <option value="ACTIVO" <?= $st==='ACTIVO'?'selected':'' ?>>ACTIVO</option>
                  <option value="INACTIVO" <?= $st==='INACTIVO'?'selected':'' ?>>INACTIVO</option>
                </select>
              </div>

              <div class="col-md-3">
                <label class="form-label">Orden</label>
                <input type="number" class="form-control" name="itm_orden" value="<?= (int)($item->itm_orden ?? 0) ?>">
              </div>

              <div class="col-md-9">
                <label class="form-label">Extra JSON (opcional)</label>
                <textarea class="form-control" name="itm_extra_json_raw" rows="2"
                          placeholder='{"fecha":"2025-12-15","categoria":"Convocatoria"}'><?= h($item->itm_extra_json ?? '') ?></textarea>
              </div>
            </div>

            <div class="mt-4 d-flex justify-content-end gap-2">
              <a href="<?= URL ?>?uri=comunicaciones/admin_items/<?= (int)($d->seccion->sec_id ?? 0) ?>" class="btn btn-outline-danger">Cancelar</a>
              <button class="btn btn-primary">Guardar</button>
            </div>
          </form>

        </div>
      </div>

    </div>
  </div></div>
</main>
<?php require_once INCLUDES.'inc_footer.php'; ?>
