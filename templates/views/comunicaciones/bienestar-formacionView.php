<?php require_once INCLUDES.'inc_head.php'; ?>

<?php
// Mover layout.php y variables GLOBALES antes del <main>
require_once __DIR__ . '/layout.php';

// Variables existentes
$GLOBALS['itemsBySeccion'] = $d->itemsBySeccion ?? [];
$GLOBALS['slug'] = $d->slug ?? '';

// --- NUEVO: Variables para el calendario de eventos ---
$GLOBALS['eventos_mes'] = $d->eventos ?? [];
$GLOBALS['eventosPorDia'] = $d->eventosPorDia ?? [];
$GLOBALS['mes_agenda'] = $d->mes_agenda ?? (int)($_GET['m'] ?? date('n'));
$GLOBALS['anio_agenda'] = $d->anio_agenda ?? (int)($_GET['y'] ?? date('Y'));
// -----------------------------------------------------
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