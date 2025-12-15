<?php require_once INCLUDES.'inc_head.php'; ?>
<main id="main-wrapper" class="main-wrapper">
  <?php require_once INCLUDES.'inc_header.php'; ?>
  <div id="app-content"><div class="app-content-area">
    <div class="container-fluid">

      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h3 class="mb-0">Comunicaciones | Items</h3>
          <p class="text-muted mb-0">
            Sección: <code><?= h($d->seccion->sec_slug ?? '') ?></code> — <?= h($d->seccion->sec_titulo ?? '') ?>
            <span class="badge bg-info ms-2"><?= h($d->seccion->sec_tipo ?? '') ?></span>
          </p>
        </div>
        <div class="d-flex gap-2">
          <a class="btn btn-outline-secondary btn-sm" href="<?= URL ?>comunicaciones/admin-secciones/<?= (int)$d->pagina->pag_id ?>">Volver</a>
          <a class="btn btn-primary btn-sm" href="<?= URL ?>comunicaciones/admin-item-form/<?= (int)$d->seccion->sec_id ?>">
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
                  <tr>
                    <td><?= (int)$it->item_id ?></td>
                    <td style="width:120px;">
                      <?php if (!empty($it->item_imagen)): ?>
                        <img src="<?= IMAGES . h($it->item_imagen) ?>" class="img-fluid rounded" style="max-height:48px;">
                      <?php else: ?>
                        <span class="text-muted small">Sin imagen</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <div class="fw-semibold"><?= h($it->item_titulo ?? '') ?></div>
                      <?php if (!empty($it->item_descripcion)): ?>
                        <div class="text-muted small"><?= h(mb_strimwidth($it->item_descripcion, 0, 120, '...')) ?></div>
                      <?php endif; ?>
                    </td>
                    <td>
                      <span class="badge <?= ($it->item_estado==='ACTIVO')?'bg-success':'bg-secondary' ?>">
                        <?= h($it->item_estado) ?>
                      </span>
                    </td>
                    <td><?= (int)$it->item_orden ?></td>
                    <td class="text-end">
                      <a class="btn btn-outline-primary btn-sm"
                         href="<?= URL ?>comunicaciones/admin-item-form/<?= (int)$d->seccion->sec_id ?>/<?= (int)$it->item_id ?>">
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
            <strong>Tip:</strong> los <code>Items</code> son los slides del carrusel o cards del grid (imagen + título + descripción + link).
          </div>
        </div>
      </div>

    </div>
  </div></div>
</main>
<?php require_once INCLUDES.'inc_footer.php'; ?>
