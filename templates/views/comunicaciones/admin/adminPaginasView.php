<?php require_once INCLUDES.'inc_head.php'; ?>
<main id="main-wrapper" class="main-wrapper">
  <?php require_once INCLUDES.'inc_header.php'; ?>
  <div id="app-content"><div class="app-content-area">
    <div class="container-fluid">

      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Comunicaciones | Páginas</h3>
        <a class="btn btn-primary btn-sm" href="<?= URL ?>comunicaciones/admin-pagina-form">
          <span class="fas fa-plus me-1"></span>Nueva página
        </a>
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
                  <th>Estado</th>
                  <th>Orden</th>
                  <th class="text-end">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach (($d->paginas ?? []) as $p): ?>
                  <tr>
                    <td><?= (int)$p->pag_id ?></td>
                    <td><code><?= h($p->pag_slug) ?></code></td>
                    <td><?= h($p->pag_titulo) ?></td>
                    <td>
                      <span class="badge <?= ($p->pag_estado==='ACTIVO')?'bg-success':'bg-secondary' ?>">
                        <?= h($p->pag_estado) ?>
                      </span>
                    </td>
                    <td><?= (int)$p->pag_orden ?></td>
                    <td class="text-end">
                      <a class="btn btn-outline-dark btn-sm"
                         href="<?= URL ?>comunicaciones/admin-secciones/<?= (int)$p->pag_id ?>">
                        Secciones
                      </a>
                      <a class="btn btn-outline-primary btn-sm"
                         href="<?= URL ?>comunicaciones/admin-pagina-form/<?= (int)$p->pag_id ?>">
                        Editar
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
                <?php if (empty($d->paginas)): ?>
                  <tr><td colspan="6" class="text-center text-muted py-4">Sin páginas.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>

    </div>
  </div></div>
</main>
<?php require_once INCLUDES.'inc_footer.php'; ?>
