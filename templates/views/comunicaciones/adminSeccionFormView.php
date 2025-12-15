<?php require_once INCLUDES.'inc_head.php'; ?>
<main id="main-wrapper" class="main-wrapper">
  <?php require_once INCLUDES.'inc_header.php'; ?>
  <div id="app-content"><div class="app-content-area">
    <div class="container-fluid">

      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Comunicaciones | <?= !empty($d->seccionEdit) ? 'Editar' : 'Nueva' ?> Sección</h3>
        <a class="btn btn-outline-secondary btn-sm" href="<?= URL ?>comunicaciones/admin-secciones/<?= (int)$d->pagina->pag_id ?>">Volver</a>
      </div>

      <div class="card shadow-sm">
        <div class="card-body">
          <form method="post">
            <input type="hidden" name="sec_id" value="<?= !empty($d->seccionEdit) ? (int)$d->seccionEdit->sec_id : 0 ?>">
            <input type="hidden" name="sec_pagina_id" value="<?= (int)$d->pagina->pag_id ?>">

            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label">Slug (único por página)</label>
                <input class="form-control" name="sec_slug" required value="<?= h($d->seccionEdit->sec_slug ?? '') ?>"
                       placeholder="ultimas-noticias / lo-que-necesitas / links-rapidos / calendar / historia / redes / politicas-sst ...">
              </div>

              <div class="col-md-5">
                <label class="form-label">Título</label>
                <input class="form-control" name="sec_titulo" value="<?= h($d->seccionEdit->sec_titulo ?? '') ?>">
              </div>

              <div class="col-md-3">
                <label class="form-label">Tipo</label>
                <?php $tp = $d->seccionEdit->sec_tipo ?? 'TEXT'; ?>
                <select class="form-select" name="sec_tipo">
                  <?php foreach (['CAROUSEL','GRID','LINKS','CALENDAR','VIDEO','TEXT','CTA'] as $opt): ?>
                    <option value="<?= $opt ?>" <?= $tp===$opt?'selected':'' ?>><?= $opt ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Descripción (texto)</label>
                <textarea class="form-control" name="sec_descripcion" rows="3"><?= h($d->seccionEdit->sec_descripcion ?? '') ?></textarea>
              </div>

              <div class="col-md-3">
                <label class="form-label">Layout</label>
                <?php $ly = $d->seccionEdit->sec_layout ?? 'CONTAINER'; ?>
                <select class="form-select" name="sec_layout">
                  <option value="CONTAINER" <?= $ly==='CONTAINER'?'selected':'' ?>>CONTAINER</option>
                  <option value="FULL" <?= $ly==='FULL'?'selected':'' ?>>FULL</option>
                  <option value="NARROW" <?= $ly==='NARROW'?'selected':'' ?>>NARROW</option>
                </select>
              </div>

              <div class="col-md-3">
                <label class="form-label">Cols (GRID)</label>
                <input type="number" class="form-control" name="sec_cols" value="<?= (int)($d->seccionEdit->sec_cols ?? 3) ?>">
              </div>

              <div class="col-md-6">
                <label class="form-label">Iframe src (CALENDAR)</label>
                <input class="form-control" name="sec_iframe_src" value="<?= h($d->seccionEdit->sec_iframe_src ?? '') ?>"
                       placeholder="https://calendar.google.com/calendar/embed?...">
              </div>

              <div class="col-md-6">
                <label class="form-label">Video URL (VIDEO)</label>
                <input class="form-control" name="sec_video_url" value="<?= h($d->seccionEdit->sec_video_url ?? '') ?>"
                       placeholder="https://www.youtube.com/embed/...">
              </div>

              <div class="col-md-4">
                <label class="form-label">CTA texto (CTA)</label>
                <input class="form-control" name="sec_boton_texto" value="<?= h($d->seccionEdit->sec_boton_texto ?? '') ?>">
              </div>

              <div class="col-md-8">
                <label class="form-label">CTA url (CTA)</label>
                <input class="form-control" name="sec_boton_url" value="<?= h($d->seccionEdit->sec_boton_url ?? '') ?>">
              </div>

              <div class="col-md-3">
                <label class="form-label">Estado</label>
                <?php $st = $d->seccionEdit->sec_estado ?? 'ACTIVO'; ?>
                <select class="form-select" name="sec_estado">
                  <option value="ACTIVO" <?= $st==='ACTIVO'?'selected':'' ?>>ACTIVO</option>
                  <option value="INACTIVO" <?= $st==='INACTIVO'?'selected':'' ?>>INACTIVO</option>
                </select>
              </div>

              <div class="col-md-3">
                <label class="form-label">Orden</label>
                <input type="number" class="form-control" name="sec_orden" value="<?= (int)($d->seccionEdit->sec_orden ?? 0) ?>">
              </div>
            </div>

            <div class="mt-4 d-flex justify-content-end gap-2">
              <a href="<?= URL ?>comunicaciones/admin-secciones/<?= (int)$d->pagina->pag_id ?>" class="btn btn-outline-danger">Cancelar</a>
              <button class="btn btn-primary" name="form_guardar" value="1">Guardar</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div></div>
</main>
<?php require_once INCLUDES.'inc_footer.php'; ?>
