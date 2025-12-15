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
?>
<main id="main-wrapper" class="main-wrapper">
  <?php require_once INCLUDES.'inc_header.php'; ?>

  <div id="app-content"><div class="app-content-area">
    <div class="container-fluid">

      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h3 class="mb-0">Comunicaciones | Items</h3>
          <p class="text-muted mb-0">
            Página: <code><?= h($d->pagina->pag_slug ?? '') ?></code>
            — Sección: <code><?= h($d->seccion->sec_slug ?? '') ?></code>
            <span class="badge bg-info ms-2"><?= h($d->seccion->sec_tipo ?? '') ?></span>
          </p>
        </div>

        <div class="d-flex gap-2">
          <a class="btn btn-outline-secondary btn-sm"
             href="<?= URL ?>?uri=comunicaciones/admin_secciones/<?= (int)($d->pagina->pag_id ?? 0) ?>">
            Volver
          </a>
          <a class="btn btn-primary btn-sm"
             href="<?= URL ?>?uri=comunicaciones/admin_item_form/<?= (int)($d->seccion->sec_id ?? 0) ?>">
            <span class="fas fa-plus me-1"></span>Nuevo item
          </a>
        </div>
      </div>

      <div class="card shadow-sm">
        <div class="card-body">

          <div class="table-responsive">
            <table class="table table-sm align-middle">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Imagen</th>
                  <th>Título</th>
                  <th>Estado</th>
                  <th>Orden</th>
                  <th class="text-end">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach (($d->items ?? []) as $it): ?>
                  <?php $src = !empty($it->itm_imagen) ? upload_src($it->itm_imagen) : ''; ?>
                  <tr>
                    <td><?= (int)$it->itm_id ?></td>
                    <td style="width:120px;">
                      <?php if ($src): ?>
                        <img src="<?= h($src) ?>" class="img-fluid rounded" style="max-height:48px;" alt="">
                      <?php else: ?>
                        <span class="text-muted small">Sin imagen</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <div class="fw-semibold"><?= h($it->itm_titulo ?? '') ?></div>
                      <?php if (!empty($it->itm_descripcion)): ?>
                        <div class="text-muted small"><?= h(mb_strimwidth($it->itm_descripcion, 0, 120, '...')) ?></div>
                      <?php endif; ?>
                      <?php if (!empty($it->itm_badge)): ?>
                        <span class="badge bg-primary mt-1"><?= h($it->itm_badge) ?></span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <span class="badge <?= (($it->itm_estado ?? '')==='ACTIVO')?'bg-success':'bg-secondary' ?>">
                        <?= h($it->itm_estado ?? '') ?>
                      </span>
                    </td>
                    <td><?= (int)($it->itm_orden ?? 0) ?></td>
                    <td class="text-end">
                      <a class="btn btn-outline-primary btn-sm"
                         href="<?= URL ?>?uri=comunicaciones/admin_item_form/<?= (int)($d->seccion->sec_id ?? 0) ?>/<?= (int)$it->itm_id ?>">
                        Editar
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>

                <?php if (empty($d->items)): ?>
                  <tr><td colspan="6" class="text-center text-muted py-4">Sin items.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          <div class="alert alert-light mt-3 mb-0">
            <strong>Tip:</strong> Los <code>Items</code> son slides/cards/enlaces: (imagen + título + descripción + link + badge).
          </div>

        </div>
      </div>

    </div>
  </div></div>
</main>
<?php require_once INCLUDES.'inc_footer.php'; ?>
