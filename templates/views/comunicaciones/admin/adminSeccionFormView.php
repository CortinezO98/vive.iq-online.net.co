<?php require_once INCLUDES.'inc_head.php'; ?>
<?php
if (!function_exists('h')) {
  function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}
$sec = $d->seccion ?? null;
?>
<main id="main-wrapper" class="main-wrapper">
  <?php require_once INCLUDES.'inc_header.php'; ?>

  <div id="app-content"><div class="app-content-area">
    <div class="container-fluid">

      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Comunicaciones | <?= $sec ? 'Editar' : 'Nueva' ?> Sección</h3>
        <a class="btn btn-outline-secondary btn-sm"
           href="<?= URL ?>?uri=comunicaciones/admin_secciones/<?= (int)($d->pagina->pag_id ?? 0) ?>">
          Volver
        </a>
      </div>

      <div class="card shadow-sm">
        <div class="card-body">

          <form method="post" action="<?= URL ?>?uri=comunicaciones/admin_seccion_guardar">
            <input type="hidden" name="sec_id" value="<?= (int)($sec->sec_id ?? 0) ?>">
            <input type="hidden" name="pag_id" value="<?= (int)($d->pagina->pag_id ?? 0) ?>">

            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label">Slug (único por página)</label>
                <input class="form-control" name="sec_slug" required
                       value="<?= h($sec->sec_slug ?? '') ?>"
                       placeholder="ultimas-noticias / lo-que-necesitas / links-rapidos / agenda / historia / redes / politicas...">
              </div>

              <div class="col-md-5">
                <label class="form-label">Título</label>
                <input class="form-control" name="sec_titulo" value="<?= h($sec->sec_titulo ?? '') ?>">
              </div>

              <div class="col-md-3">
                <label class="form-label">Tipo</label>
                <?php
                  // si venía un tipo inválido/ vacío, lo normalizamos para que el select no quede raro
                  $tp = strtoupper(trim((string)($sec->sec_tipo ?? 'CAROUSEL')));
                  if ($tp === '' || $tp === 'GRID') $tp = 'CARDS';
                  $allowed = ['CAROUSEL','CARDS','LINKS','CALENDAR','VIDEO','CTA','SOCIAL','HERO','TEXT'];
                  if (!in_array($tp, $allowed, true)) $tp = 'CAROUSEL';
                ?>
                <select class="form-select" name="sec_tipo">
                  <?php foreach (['TEXT','CAROUSEL','CARDS','LINKS','CALENDAR','VIDEO','CTA'] as $opt): ?>
                    <option value="<?= $opt ?>" <?= $tp===$opt?'selected':'' ?>><?= $opt ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" name="sec_descripcion" rows="3"><?= h($sec->sec_descripcion ?? '') ?></textarea>
              </div>

              <div class="col-md-3">
                <label class="form-label">Layout</label>
                <?php $ly = $sec->sec_layout ?? 'CONTAINER'; ?>
                <select class="form-select" name="sec_layout">
                  <option value="CONTAINER" <?= $ly==='CONTAINER'?'selected':'' ?>>CONTAINER</option>
                  <option value="FULL" <?= $ly==='FULL'?'selected':'' ?>>FULL</option>
                  <option value="NARROW" <?= $ly==='NARROW'?'selected':'' ?>>NARROW</option>
                </select>
              </div>

              <div class="col-md-3">
                <label class="form-label">Cols (CARDS)</label>
                <input type="number" class="form-control" name="sec_cols" value="<?= (int)($sec->sec_cols ?? 3) ?>">
              </div>

              <div class="col-md-6">
                <label class="form-label">Iframe src (CALENDAR)</label>
                <input class="form-control" name="sec_iframe_src"
                       value="<?= h($sec->sec_iframe_src ?? '') ?>"
                       placeholder="https://calendar.google.com/calendar/embed?...">
              </div>

              <div class="col-md-6">
                <label class="form-label">Video URL (VIDEO)</label>
                <input class="form-control" name="sec_video_url"
                       value="<?= h($sec->sec_video_url ?? '') ?>"
                       placeholder="https://www.youtube.com/embed/...">
              </div>

              <div class="col-md-4">
                <label class="form-label">CTA texto (CTA)</label>
                <input class="form-control" name="sec_boton_texto" value="<?= h($sec->sec_boton_texto ?? '') ?>">
              </div>

              <div class="col-md-8">
                <label class="form-label">CTA url (CTA)</label>
                <input class="form-control" name="sec_boton_url" value="<?= h($sec->sec_boton_url ?? '') ?>">
              </div>

              <div class="col-md-6">
                <label class="form-label">Config JSON (opcional)</label>
                <textarea class="form-control" name="sec_config_json_raw" rows="3"
                          placeholder='{"autoplay":true,"interval":6000}'><?= h($sec->sec_config_json ?? '') ?></textarea>
                <div class="form-text">Si no usas config, déjalo vacío.</div>
              </div>

              <div class="col-md-3">
                <label class="form-label">Estado</label>
                <?php $st = $sec->sec_estado ?? 'ACTIVO'; ?>
                <select class="form-select" name="sec_estado">
                  <option value="ACTIVO" <?= $st==='ACTIVO'?'selected':'' ?>>ACTIVO</option>
                  <option value="INACTIVO" <?= $st==='INACTIVO'?'selected':'' ?>>INACTIVO</option>
                </select>
              </div>

              <div class="col-md-3">
                <label class="form-label">Orden</label>
                <input type="number" class="form-control" name="sec_orden" value="<?= (int)($sec->sec_orden ?? 0) ?>">
              </div>
            </div>

            <div class="mt-4 d-flex justify-content-end gap-2">
              <a href="<?= URL ?>?uri=comunicaciones/admin_secciones/<?= (int)($d->pagina->pag_id ?? 0) ?>" class="btn btn-outline-danger">Cancelar</a>
              <button class="btn btn-primary">Guardar</button>
            </div>
          </form>

        </div>
      </div>

    </div>
  </div></div>
</main>
<?php require_once INCLUDES.'inc_footer.php'; ?>
