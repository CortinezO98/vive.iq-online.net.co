<?php require_once INCLUDES.'inc_head.php'; ?>
<main id="main-wrapper" class="main-wrapper">
  <?php require_once INCLUDES.'inc_header.php'; ?>
  <div id="app-content"><div class="app-content-area">
    <div class="container-fluid">

      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Comunicaciones | <?= !empty($d->paginaEdit) ? 'Editar' : 'Nueva' ?> Página</h3>
        <a class="btn btn-outline-secondary btn-sm" href="<?= URL ?>comunicaciones/admin-paginas">Volver</a>
      </div>

      <div class="card shadow-sm">
        <div class="card-body">
          <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="pag_id" value="<?= !empty($d->paginaEdit) ? (int)$d->paginaEdit->pag_id : 0 ?>">

            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label">Slug (único)</label>
                <input class="form-control" name="pag_slug" required
                       value="<?= h($d->paginaEdit->pag_slug ?? '') ?>"
                       placeholder="inicio / compania / cultura / identidad / bienestar / atraccion / sst / compensacion / contacto">
              </div>

              <div class="col-md-5">
                <label class="form-label">Título</label>
                <input class="form-control" name="pag_titulo" required value="<?= h($d->paginaEdit->pag_titulo ?? '') ?>">
              </div>

              <div class="col-md-3">
                <label class="form-label">Estado</label>
                <select class="form-select" name="pag_estado">
                  <?php $st = $d->paginaEdit->pag_estado ?? 'ACTIVO'; ?>
                  <option value="ACTIVO" <?= $st==='ACTIVO'?'selected':'' ?>>ACTIVO</option>
                  <option value="INACTIVO" <?= $st==='INACTIVO'?'selected':'' ?>>INACTIVO</option>
                </select>
              </div>

              <div class="col-md-8">
                <label class="form-label">Subtítulo</label>
                <input class="form-control" name="pag_subtitulo" value="<?= h($d->paginaEdit->pag_subtitulo ?? '') ?>">
              </div>

              <div class="col-md-4">
                <label class="form-label">Orden</label>
                <input type="number" class="form-control" name="pag_orden" value="<?= (int)($d->paginaEdit->pag_orden ?? 0) ?>">
              </div>

              <div class="col-md-6">
                <label class="form-label">Hero background (ruta imagen, ej: uploads/comunicaciones/hero.jpg)</label>
                <input class="form-control" name="pag_hero_bg" value="<?= h($d->paginaEdit->pag_hero_bg ?? '') ?>">
              </div>

              <div class="col-md-3">
                <label class="form-label">Overlay</label>
                <?php $ov = (int)($d->paginaEdit->pag_hero_overlay ?? 1); ?>
                <select class="form-select" name="pag_hero_overlay">
                  <option value="1" <?= $ov===1?'selected':'' ?>>Sí</option>
                  <option value="0" <?= $ov===0?'selected':'' ?>>No</option>
                </select>
              </div>

              <div class="col-md-3">
                <label class="form-label">Alineación</label>
                <?php $al = $d->paginaEdit->pag_hero_alineacion ?? 'center'; ?>
                <select class="form-select" name="pag_hero_alineacion">
                  <option value="left" <?= $al==='left'?'selected':'' ?>>Left</option>
                  <option value="center" <?= $al==='center'?'selected':'' ?>>Center</option>
                  <option value="right" <?= $al==='right'?'selected':'' ?>>Right</option>
                </select>
              </div>
            </div>

            <div class="mt-4 d-flex justify-content-end gap-2">
              <a href="<?= URL ?>comunicaciones/admin-paginas" class="btn btn-outline-danger">Cancelar</a>
              <button class="btn btn-primary" name="form_guardar" value="1">Guardar</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div></div>
</main>
<?php require_once INCLUDES.'inc_footer.php'; ?>
