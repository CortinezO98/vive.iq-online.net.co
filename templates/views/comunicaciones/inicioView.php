<?php require_once INCLUDES.'inc_head.php'; ?>

<?php
require_once __DIR__ . '/layout.php';

// fallback global por si alguien llama mal render_section()
$GLOBALS['itemsBySeccion'] = $d->itemsBySeccion ?? [];
?>

<main id="main-wrapper" class="main-wrapper">
  <?php require_once INCLUDES.'inc_header.php'; ?>

  <div id="app-content">
    <div class="app-content-area">

      <?php
        render_hero($d->pagina);

        foreach (($d->secciones ?? []) as $sec) {
          render_section($sec, $d->itemsBySeccion ?? []);
        }
      ?>

    </div>
  </div>
</main>

<?php require_once INCLUDES.'inc_footer.php'; ?>
