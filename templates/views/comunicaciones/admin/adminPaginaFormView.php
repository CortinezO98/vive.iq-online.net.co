<?php require_once INCLUDES.'inc_head.php'; ?>
<?php
if (!function_exists('h')) {
  function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}
$edit = $d->pagina ?? null;
?>
<main id="main-wrapper" class="main-wrapper">
  <?php require_once INCLUDES.'inc_header.php'; ?>

  <div id="app-content"><div class="app-content-area">
    <div class="container-fluid">

      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Comunicaciones | <?= $edit ? 'Editar' : 'Nueva' ?> Página</h3>
        <a class="btn btn-outline-secondary btn-sm" href="<?= URL ?>?uri=comunicaciones/admin_paginas">Volver</a>
      </div>

      <div class="card shadow-sm">
        <div class="card-body">
          <form method="post" action="<?= URL ?>?uri=comunicaciones/admin_pagina_guardar">
            <input type="hidden" name="pag_id" value="<?= (int)($edit->pag_id ?? 0) ?>">

            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label">Slug (único)</label>
                <input class="form-control" name="pag_slug" required
                       value="<?= h($edit->pag_slug ?? '') ?>"
                       placeholder="inicio / compania / cultura-iq / identidad-corporativa / bienestar-formacion / atraccion-personal / sst / compensacion-beneficios / contacto">
                <div class="form-text">Ejemplo público: <code>?uri=comunicaciones/ver/&lt;slug&gt;</code></div>
              </div>

              <div class="col-md-5">
                <label class="form-label">Título</label>
                <input class="form-control" name="pag_titulo" required value="<?= h($edit->pag_titulo ?? '') ?>">
              </div>

              <div class="col-md-3">
                <label class="form-label">Estado</label>
                <?php $st = $edit->pag_estado ?? 'ACTIVO'; ?>
                <select class="form-select" name="pag_estado">
                  <option value="ACTIVO" <?= $st==='ACTIVO'?'selected':'' ?>>ACTIVO</option>
                  <option value="INACTIVO" <?= $st==='INACTIVO'?'selected':'' ?>>INACTIVO</option>
                </select>
              </div>

              <div class="col-md-8">
                <label class="form-label">Subtítulo</label>
                <input class="form-control" name="pag_subtitulo" value="<?= h($edit->pag_subtitulo ?? '') ?>">
              </div>

              <div class="col-md-4">
                <label class="form-label">Orden</label>
                <input type="number" class="form-control" name="pag_orden" value="<?= (int)($edit->pag_orden ?? 0) ?>">
              </div>

              <div class="col-md-6">
                <label class="form-label">Hero background (ruta en uploads)</label>
                <input class="form-control" name="pag_hero_bg" value="<?= h($edit->pag_hero_bg ?? '') ?>"
                       placeholder="comunicaciones/hero_inicio.webp">
                <div class="form-text">Se renderiza con <code>UPLOADS</code> (assets/uploads).</div>
              </div>

              <div class="col-md-3">
                <label class="form-label">Overlay</label>
                <?php $ov = (int)($edit->pag_hero_overlay ?? 1); ?>
                <select class="form-select" name="pag_hero_overlay">
                  <option value="1" <?= $ov===1?'selected':'' ?>>Sí</option>
                  <option value="0" <?= $ov===0?'selected':'' ?>>No</option>
                </select>
              </div>

              <div class="col-md-3">
                <label class="form-label">Alineación</label>
                <?php $al = $edit->pag_hero_alineacion ?? 'center'; ?>
                <select class="form-select" name="pag_hero_alineacion">
                  <option value="left" <?= $al==='left'?'selected':'' ?>>Left</option>
                  <option value="center" <?= $al==='center'?'selected':'' ?>>Center</option>
                  <option value="right" <?= $al==='right'?'selected':'' ?>>Right</option>
                </select>
              </div>

              <div class="col-12">
                <label class="form-label">Descripción (opcional)</label>
                <textarea class="form-control" name="pag_descripcion" rows="3"><?= h($edit->pag_descripcion ?? '') ?></textarea>
              </div>
            </div>

            <div class="mt-4 d-flex justify-content-end gap-2">
              <a href="<?= URL ?>?uri=comunicaciones/admin_paginas" class="btn btn-outline-danger">Cancelar</a>
              <button class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div></div>
</main>
<?php require_once INCLUDES.'inc_footer.php'; ?>
