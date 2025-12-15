<?php require_once INCLUDES.'inc_head.php'; ?>
<main id="main-wrapper" class="main-wrapper">
  <?php require_once INCLUDES.'inc_header.php'; ?>

  <div id="app-content">
    <div class="app-content-area">

      <?php
        // HERO + secciones dinámicas
        require_once __DIR__ . '/layout.php';
        render_hero($d->pagina);

        if (!empty($d->secciones)) {
          foreach ($d->secciones as $sec) {
            render_section($sec, $d->itemsBySeccion ?? []);
          }
        }
      ?>

    </div>
  </div>
</main>
<?php require_once INCLUDES.'inc_footer.php'; ?>
