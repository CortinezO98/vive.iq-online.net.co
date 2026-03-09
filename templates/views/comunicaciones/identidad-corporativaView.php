<?php require_once INCLUDES.'inc_head.php'; ?>

<?php
require_once __DIR__ . '/layout.php';

$GLOBALS['itemsBySeccion'] = $d->itemsBySeccion ?? [];
$GLOBALS['slug'] = $d->slug ?? 'identidad-corporativa';

// --- NUEVO: Variables para el calendario de eventos ---
$GLOBALS['eventos_mes'] = isset($d->eventos)
    ? (is_object($d->eventos) ? get_object_vars($d->eventos) : $d->eventos)
    : []; // Lista completa de eventos del mes
$GLOBALS['eventosPorDia'] = isset($d->eventosPorDia)
    ? (is_object($d->eventosPorDia) ? get_object_vars($d->eventosPorDia) : $d->eventosPorDia)
    : []; // Eventos organizados por día
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