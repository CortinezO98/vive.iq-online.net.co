<?php require_once INCLUDES.'inc_head.php'; ?>

<?php
require_once __DIR__ . '/layout.php';

$GLOBALS['itemsBySeccion'] = $d->itemsBySeccion ?? [];
$GLOBALS['slug'] = $d->slug ?? 'compania'; 
?>

<main id="main-wrapper" class="main-wrapper">
  <?php require_once INCLUDES.'inc_header.php'; ?>

  <div id="app-content">
    <div class="app-content-area">

      <?php
        render_hero($d->pagina);
        
        $seccion_index = 0;
        foreach (($d->secciones ?? []) as $sec) {
          render_section($sec, $d->itemsBySeccion ?? [], $seccion_index);
          $seccion_index++;
        }
      ?>

    </div>
  </div>
</main>

<?php require_once INCLUDES.'inc_footer.php'; ?>