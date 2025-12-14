<?php require_once INCLUDES.'inc_header.php'; ?>

<div class="container-fluid px-0">
  <?php
    // Helpers
    $cfg = function($sec){
      if (empty($sec->sec_config_json)) return [];
      $arr = json_decode($sec->sec_config_json, true);
      return (json_last_error() === JSON_ERROR_NONE && is_array($arr)) ? $arr : [];
    };

    $items = $itemsPorSeccion ?? [];
  ?>

  <?php foreach(($secciones ?? []) as $sec): ?>
    <?php $conf = $cfg($sec); $secItems = $items[$sec->sec_id] ?? []; ?>

    <?php if($sec->sec_tipo === 'HERO'): ?>
      <?php
        $bg = $conf['bg'] ?? null; // ruta relativa en assets/uploads
        $bgUrl = $bg ? (UPLOADS.$bg) : '';
        $height = $conf['height'] ?? '55vh';
        $overlay = $conf['overlay'] ?? '0.55';
        $align = $conf['align'] ?? 'center'; // left/center
      ?>
      <section class="w-100 d-flex align-items-center"
               style="min-height: <?= htmlspecialchars($height) ?>; background-size:cover; background-position:center; background-image: url('<?= htmlspecialchars($bgUrl) ?>'); position:relative;">
        <div style="position:absolute; inset:0; background: rgba(0,0,0,<?= htmlspecialchars($overlay) ?>);"></div>
        <div class="container position-relative py-5">
          <div class="row">
            <div class="col-12 col-lg-8 text-<?= htmlspecialchars($align) ?> text-white">
              <h1 class="display-6 fw-bold mb-2"><?= htmlspecialchars($sec->sec_titulo ?? $pagina->pag_titulo) ?></h1>
              <?php if(!empty($sec->sec_descripcion)): ?>
                <p class="lead mb-0"><?= nl2br(htmlspecialchars($sec->sec_descripcion)) ?></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </section>

    <?php elseif($sec->sec_tipo === 'CAROUSEL'): ?>
      <?php
        $id = 'car_'.$sec->sec_id;
        $auto = !empty($conf['autoplay']) ? 'true' : 'false';
        $interval = (int)($conf['interval'] ?? 6000);
      ?>
      <section class="container py-4">
        <?php if(!empty($sec->sec_titulo)): ?>
          <div class="d-flex justify-content-between align-items-end mb-2">
            <div>
              <h3 class="mb-0"><?= htmlspecialchars($sec->sec_titulo) ?></h3>
              <?php if(!empty($sec->sec_descripcion)): ?>
                <small class="text-muted"><?= htmlspecialchars($sec->sec_descripcion) ?></small>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>

        <?php if(count($secItems) > 0): ?>
          <div id="<?= $id ?>" class="carousel slide" data-bs-ride="<?= $auto ?>" data-bs-interval="<?= $interval ?>">
            <div class="carousel-inner rounded shadow-sm">

              <?php foreach($secItems as $k=>$it): ?>
                <?php
                  $img = !empty($it->itm_imagen) ? (UPLOADS.$it->itm_imagen) : '';
                  $url = !empty($it->itm_url) ? $it->itm_url : '#!';
                ?>
                <div class="carousel-item <?= $k===0 ? 'active':''; ?>">
                  <div class="row g-0 align-items-stretch bg-white">
                    <div class="col-12 col-lg-6">
                      <div style="min-height: 260px; background-size:cover; background-position:center; background-image:url('<?= htmlspecialchars($img) ?>');"></div>
                    </div>
                    <div class="col-12 col-lg-6 p-4">
                      <h4 class="fw-semibold"><?= htmlspecialchars($it->itm_titulo ?? '') ?></h4>
                      <p class="text-muted mb-3"><?= nl2br(htmlspecialchars($it->itm_descripcion ?? '')) ?></p>
                      <?php if($url !== '#!'): ?>
                        <a class="btn btn-primary" href="<?= htmlspecialchars($url) ?>" target="_blank" rel="noopener">Ver más</a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>

            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#<?= $id ?>" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#<?= $id ?>" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Siguiente</span>
            </button>
          </div>
        <?php else: ?>
          <div class="alert alert-light border">Sin contenido todavía.</div>
        <?php endif; ?>
      </section>

    <?php elseif($sec->sec_tipo === 'CARDS'): ?>
      <?php $cols = (int)($conf['cols'] ?? 3); if(!in_array($cols,[2,3,4])) $cols=3; ?>
      <section class="container py-4">
        <?php if(!empty($sec->sec_titulo)): ?>
          <h3 class="mb-1"><?= htmlspecialchars($sec->sec_titulo) ?></h3>
        <?php endif; ?>
        <?php if(!empty($sec->sec_descripcion)): ?>
          <p class="text-muted"><?= htmlspecialchars($sec->sec_descripcion) ?></p>
        <?php endif; ?>

        <div class="row g-3">
          <?php foreach($secItems as $it): ?>
            <?php
              $img = !empty($it->itm_imagen) ? (UPLOADS.$it->itm_imagen) : '';
              $url = !empty($it->itm_url) ? $it->itm_url : '#!';
              $colClass = $cols===2 ? 'col-12 col-md-6' : ($cols===4 ? 'col-12 col-md-6 col-lg-3' : 'col-12 col-md-6 col-lg-4');
            ?>
            <div class="<?= $colClass ?>">
              <a href="<?= htmlspecialchars($url) ?>" class="text-decoration-none" target="_blank" rel="noopener">
                <div class="card h-100 shadow-sm">
                  <?php if($img): ?>
                    <img src="<?= htmlspecialchars($img) ?>" class="card-img-top" alt="">
                  <?php endif; ?>
                  <div class="card-body">
                    <h5 class="card-title mb-1"><?= htmlspecialchars($it->itm_titulo ?? '') ?></h5>
                    <p class="card-text text-muted mb-0"><?= htmlspecialchars($it->itm_descripcion ?? '') ?></p>
                  </div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

    <?php elseif($sec->sec_tipo === 'LINKS'): ?>
      <section class="container py-4">
        <?php if(!empty($sec->sec_titulo)): ?>
          <h3 class="mb-1"><?= htmlspecialchars($sec->sec_titulo) ?></h3>
        <?php endif; ?>
        <?php if(!empty($sec->sec_descripcion)): ?>
          <p class="text-muted"><?= htmlspecialchars($sec->sec_descripcion) ?></p>
        <?php endif; ?>

        <div class="list-group shadow-sm">
          <?php foreach($secItems as $it): ?>
            <?php $url = !empty($it->itm_url) ? $it->itm_url : '#!'; ?>
            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
               href="<?= htmlspecialchars($url) ?>" target="_blank" rel="noopener">
              <div>
                <div class="fw-semibold"><?= htmlspecialchars($it->itm_titulo ?? '') ?></div>
                <?php if(!empty($it->itm_descripcion)): ?>
                  <small class="text-muted"><?= htmlspecialchars($it->itm_descripcion) ?></small>
                <?php endif; ?>
              </div>
              <span class="text-muted">›</span>
            </a>
          <?php endforeach; ?>
        </div>
      </section>

    <?php elseif($sec->sec_tipo === 'CALENDAR'): ?>
      <section class="container py-4">
        <h3 class="mb-2"><?= htmlspecialchars($sec->sec_titulo ?? 'Agenda') ?></h3>
        <?php if(!empty($sec->sec_descripcion)): ?>
          <p class="text-muted"><?= htmlspecialchars($sec->sec_descripcion) ?></p>
        <?php endif; ?>

        <?php
          // Se usa itm_embed (iframe) del primer item
          $embed = $secItems[0]->itm_embed ?? '';
        ?>
        <?php if($embed): ?>
          <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden bg-white">
            <?= $embed ?>
          </div>
        <?php else: ?>
          <div class="alert alert-light border">Configura el iframe del calendario en esta sección.</div>
        <?php endif; ?>
      </section>

    <?php elseif($sec->sec_tipo === 'VIDEO'): ?>
      <section class="container py-4">
        <h3 class="mb-2"><?= htmlspecialchars($sec->sec_titulo ?? 'Video') ?></h3>
        <?php if(!empty($sec->sec_descripcion)): ?>
          <p class="text-muted"><?= htmlspecialchars($sec->sec_descripcion) ?></p>
        <?php endif; ?>
        <?php $embed = $secItems[0]->itm_embed ?? ''; ?>
        <?php if($embed): ?>
          <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden bg-white">
            <?= $embed ?>
          </div>
        <?php else: ?>
          <div class="alert alert-light border">Configura el iframe del video en esta sección.</div>
        <?php endif; ?>
      </section>

    <?php elseif($sec->sec_tipo === 'SOCIAL'): ?>
      <section class="container py-4">
        <h3 class="mb-2"><?= htmlspecialchars($sec->sec_titulo ?? 'Canales de comunicación') ?></h3>
        <?php if(!empty($sec->sec_descripcion)): ?>
          <p class="text-muted"><?= htmlspecialchars($sec->sec_descripcion) ?></p>
        <?php endif; ?>

        <div class="row g-3">
          <?php foreach($secItems as $it): ?>
            <?php
              $url = !empty($it->itm_url) ? $it->itm_url : '#!';
              $img = !empty($it->itm_imagen) ? (UPLOADS.$it->itm_imagen) : '';
            ?>
            <div class="col-6 col-md-4 col-lg-3">
              <a href="<?= htmlspecialchars($url) ?>" target="_blank" rel="noopener" class="text-decoration-none">
                <div class="card h-100 shadow-sm text-center">
                  <?php if($img): ?>
                    <img src="<?= htmlspecialchars($img) ?>" class="card-img-top" alt="">
                  <?php endif; ?>
                  <div class="card-body py-3">
                    <div class="fw-semibold"><?= htmlspecialchars($it->itm_titulo ?? '') ?></div>
                    <?php if(!empty($it->itm_descripcion)): ?>
                      <small class="text-muted"><?= htmlspecialchars($it->itm_descripcion) ?></small>
                    <?php endif; ?>
                  </div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

    <?php elseif($sec->sec_tipo === 'CTA'): ?>
      <section class="container py-4">
        <div class="p-4 bg-white rounded shadow-sm d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
          <div>
            <h4 class="mb-1"><?= htmlspecialchars($sec->sec_titulo ?? '') ?></h4>
            <p class="text-muted mb-0"><?= htmlspecialchars($sec->sec_descripcion ?? '') ?></p>
          </div>
          <?php
            // Primer item como botón (url)
            $btn = $secItems[0] ?? null;
          ?>
          <?php if($btn && !empty($btn->itm_url)): ?>
            <a class="btn btn-primary" href="<?= htmlspecialchars($btn->itm_url) ?>" target="_blank" rel="noopener">
              <?= htmlspecialchars($btn->itm_titulo ?? 'Ir') ?>
            </a>
          <?php endif; ?>
        </div>
      </section>
    <?php endif; ?>

  <?php endforeach; ?>
</div>

<?php require_once INCLUDES.'inc_footer.php'; ?>
