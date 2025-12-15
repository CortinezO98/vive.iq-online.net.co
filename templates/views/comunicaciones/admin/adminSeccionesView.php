<?php require_once INCLUDES.'inc_head.php'; ?>
<?php
if (!function_exists('h')) {
  function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}
?>
<main id="main-wrapper" class="main-wrapper">
  <?php require_once INCLUDES.'inc_header.php'; ?>

  <div id="app-content"><div class="app-content-area">
    <div class="container-fluid">

      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h3 class="mb-0">Comunicaciones | Secciones</h3>
          <p class="text-muted mb-0">
            Página: <code><?= h($d->pagina->pag_slug ?? '') ?></code> — <?= h($d->pagina->pag_titulo ?? '') ?>
          </p>
        </div>

        <div class="d-flex gap-2">
          <a class="btn btn-outline-secondary btn-sm" href="<?= URL ?>?uri=comunicaciones/admin_paginas">Volver</a>
          <a class="btn btn-primary btn-sm"
             href="<?= URL ?>?uri=comunicaciones/admin_seccion_form/<?= (int)($d->pagina->pag_id ?? 0) ?>">
            <span class="fas fa-plus me-1"></span>Nueva sección
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
                  <th>Slug</th>
                  <th>Título</th>
                  <th>Tipo</th>
                  <th>Layout</th>
                  <th>Estado</th>
                  <th>Orden</th>
                  <th class="text-end">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach (($d->secciones ?? []) as $s): ?>
                  <tr>
                    <td><?= (int)$s->sec_id ?></td>
                    <td><code><?= h($s->sec_slug ?? '') ?></code></td>
                    <td><?= h($s->sec_titulo ?? '') ?></td>
                    <td><span class="badge bg-info"><?= h($s->sec_tipo ?? '') ?></span></td>
                    <td><?= h($s->sec_layout ?? 'CONTAINER') ?></td>
                    <td>
                      <span class="badge <?= (($s->sec_estado ?? '')==='ACTIVO')?'bg-success':'bg-secondary' ?>">
                        <?= h($s->sec_estado ?? '') ?>
                      </span>
                    </td>
                    <td><?= (int)($s->sec_orden ?? 0) ?></td>
                    <td class="text-end">
                      <a class="btn btn-outline-dark btn-sm"
                         href="<?= URL ?>?uri=comunicaciones/admin_items/<?= (int)$s->sec_id ?>">
                        Items
                      </a>
                      <a class="btn btn-outline-primary btn-sm"
                         href="<?= URL ?>?uri=comunicaciones/admin_seccion_form/<?= (int)($d->pagina->pag_id ?? 0) ?>/<?= (int)$s->sec_id ?>">
                        Editar
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>

                <?php if (empty($d->secciones)): ?>
                  <tr><td colspan="8" class="text-center text-muted py-4">Sin secciones.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          <div class="alert alert-light mt-3 mb-0">
            <strong>Tip:</strong> En <code>CALENDAR</code> usa <code>sec_iframe_src</code>.
            En <code>VIDEO</code> usa <code>sec_video_url</code>.
            En <code>CAROUSEL/GRID/LINKS</code> administra los <strong>Items</strong>.
          </div>

        </div>
      </div>

    </div>
  </div></div>
</main>
<?php require_once INCLUDES.'inc_footer.php'; ?>
