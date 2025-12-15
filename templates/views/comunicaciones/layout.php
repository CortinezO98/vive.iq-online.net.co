<?php
require_once __DIR__ . '/_helpers.php'; // e(), asset_upload(), safe_target(), section_layout_class()

/* =========================================================
 * URL segura
 * ========================================================= */
if (!function_exists('safe_url')) {
  function safe_url($url) {
    $url = trim((string)$url);
    if ($url === '') return '';
    if (preg_match('#^(https?://)#i', $url)) return $url;
    return URL . ltrim($url, '/');
  }
}

/* =========================================================
 * Normaliza itemsBySeccion:
 * - array: [1 => [...]]
 * - stdClass: {"1": [...]}
 * ========================================================= */
if (!function_exists('normalize_items_map')) {
  function normalize_items_map($itemsBySeccion): array {
    // fallback a global por si lo seteaste en la vista
    if ((empty($itemsBySeccion) || $itemsBySeccion === null) && isset($GLOBALS['itemsBySeccion'])) {
      $itemsBySeccion = $GLOBALS['itemsBySeccion'];
    }

    if (is_object($itemsBySeccion)) {
      $itemsBySeccion = get_object_vars($itemsBySeccion);
    }
    if (!is_array($itemsBySeccion)) return [];

    return $itemsBySeccion;
  }
}

/* =========================================================
 * Obtiene items por sección (robusto para int/string/obj)
 * ========================================================= */
if (!function_exists('items_for_section')) {
  function items_for_section($itemsBySeccion, int $secId): array {
    $map = normalize_items_map($itemsBySeccion);

    // intenta con int
    if (isset($map[$secId]) && is_array($map[$secId])) return $map[$secId];

    // intenta con string "1"
    $k = (string)$secId;
    if (isset($map[$k]) && is_array($map[$k])) return $map[$k];

    return [];
  }
}

/* =========================================================
 * Contenedor por layout
 * ========================================================= */
if (!function_exists('render_container_open')) {
  function render_container_open($layout) {
    $layout = strtoupper((string)$layout);
    $cls = section_layout_class($layout);
    return '<section class="py-5"><div class="'.$cls.'">';
  }
}
if (!function_exists('render_container_close')) {
  function render_container_close() { return '</div></section>'; }
}

/* =========================================================
 * HERO
 * ========================================================= */
if (!function_exists('render_hero')) {
  function render_hero($pagina) {
    $bg = !empty($pagina->pag_hero_bg) ? asset_upload($pagina->pag_hero_bg) : '';
    $overlay = !empty($pagina->pag_hero_overlay);
    $align = $pagina->pag_hero_alineacion ?? 'center';
    $alignClass = $align === 'left' ? 'text-start' : ($align === 'right' ? 'text-end' : 'text-center');
    ?>
    <header class="com-hero position-relative">
      <?php if ($bg): ?>
        <div class="com-hero-bg" style="background-image:url('<?= e($bg) ?>');"></div>
      <?php else: ?>
        <div class="com-hero-bg com-hero-bg--default"></div>
      <?php endif; ?>

      <?php if ($overlay): ?>
        <div class="com-hero-overlay"></div>
      <?php endif; ?>

      <div class="container position-relative py-5">
        <div class="row">
          <div class="col-12 <?= e($alignClass) ?>">
            <h1 class="display-6 fw-bold text-white mb-2"><?= e($pagina->pag_titulo ?? '') ?></h1>
            <?php if (!empty($pagina->pag_subtitulo)): ?>
              <p class="lead text-white-50 mb-0"><?= e($pagina->pag_subtitulo) ?></p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </header>

    <style>
      .com-hero { min-height: 340px; display:flex; align-items:center; overflow:hidden; }
      .com-hero-bg{ position:absolute; inset:0; background-size:cover; background-position:center; transform: scale(1.02); }
      .com-hero-bg--default{ background: linear-gradient(135deg, #1C2262 0%, #09A28E 100%); }
      .com-hero-overlay{ position:absolute; inset:0; background: rgba(0,0,0,.45); }
    </style>
    <?php
  }
}

/* =========================================================
 * Encabezado de sección
 * ========================================================= */
if (!function_exists('render_section_header')) {
  function render_section_header($sec) {
    if (empty($sec->sec_titulo) && empty($sec->sec_descripcion)) return;
    ?>
    <div class="row mb-4">
      <div class="col-12">
        <?php if (!empty($sec->sec_titulo)): ?>
          <h2 class="h4 fw-bold mb-2"><?= e($sec->sec_titulo) ?></h2>
        <?php endif; ?>
        <?php if (!empty($sec->sec_descripcion)): ?>
          <p class="text-muted mb-0"><?= nl2br(e($sec->sec_descripcion)) ?></p>
        <?php endif; ?>
      </div>
    </div>
    <?php
  }
}

/* =========================================================
 * CAROUSEL
 * ========================================================= */
if (!function_exists('render_carousel')) {
  function render_carousel($sec, $items) {
    $carouselId = 'carousel_' . (int)$sec->sec_id;

    if (empty($items)) {
      echo '<p class="text-muted">No hay contenido disponible.</p>';
      return;
    }

    // Config opcional desde JSON: {"autoplay":true,"interval":6000}
    $autoplay = true;
    $interval = 5000;
    if (!empty($sec->sec_config_json)) {
      $cfg = is_string($sec->sec_config_json) ? json_decode($sec->sec_config_json, true) : $sec->sec_config_json;
      if (is_array($cfg)) {
        if (isset($cfg['autoplay'])) $autoplay = (bool)$cfg['autoplay'];
        if (isset($cfg['interval'])) $interval = (int)$cfg['interval'];
      }
    }
    ?>
    <div id="<?= e($carouselId) ?>" class="carousel slide"
         <?= $autoplay ? 'data-bs-ride="carousel"' : '' ?>
         data-bs-interval="<?= (int)$interval ?>">

      <div class="carousel-inner rounded-3 overflow-hidden shadow-sm">
        <?php foreach ($items as $i => $it): ?>
          <?php $img = !empty($it->itm_imagen) ? asset_upload($it->itm_imagen) : ''; ?>
          <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
            <div class="row g-0 align-items-stretch bg-white">
              <div class="col-12 col-md-5">
                <?php if ($img): ?>
                  <div class="com-slide-img" style="background-image:url('<?= e($img) ?>');"></div>
                <?php else: ?>
                  <div class="com-slide-img com-slide-img--default"></div>
                <?php endif; ?>
              </div>
              <div class="col-12 col-md-7 p-4">
                <?php if (!empty($it->itm_badge)): ?>
                  <span class="badge bg-primary mb-2"><?= e($it->itm_badge) ?></span>
                <?php endif; ?>
                <h3 class="h5 fw-bold mb-2"><?= e($it->itm_titulo ?? '') ?></h3>
                <?php if (!empty($it->itm_descripcion)): ?>
                  <p class="text-muted mb-3"><?= nl2br(e($it->itm_descripcion)) ?></p>
                <?php endif; ?>
                <?php if (!empty($it->itm_url)): ?>
                  <a class="btn btn-outline-primary btn-sm"
                     target="<?= e(safe_target($it->itm_target ?? '_blank')) ?>"
                     rel="noopener"
                     href="<?= e(safe_url($it->itm_url)) ?>">
                    Ver más
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#<?= e($carouselId) ?>" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#<?= e($carouselId) ?>" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
      </button>
    </div>

    <style>
      .com-slide-img{ min-height:260px; height:100%; background-size:cover; background-position:center; }
      .com-slide-img--default{ background: linear-gradient(135deg, #f1f3f5 0%, #e9ecef 100%); }
      @media (max-width: 767px) { .com-slide-img{ min-height:200px; } }
    </style>
    <?php
  }
}

/* =========================================================
 * GRID
 * ========================================================= */
if (!function_exists('render_grid')) {
  function render_grid($sec, $items) {
    $cols = (int)($sec->sec_cols ?? 3);
    if ($cols < 2) $cols = 2;
    if ($cols > 5) $cols = 5;

    $colClass = 'col-12 col-md-6 col-lg-4';
    if ($cols === 2) $colClass = 'col-12 col-md-6';
    if ($cols === 4) $colClass = 'col-12 col-md-6 col-lg-3';
    if ($cols === 5) $colClass = 'col-12 col-md-6 col-lg-3';

    if (empty($items)) {
      echo '<p class="text-muted">No hay contenido disponible.</p>';
      return;
    }
    ?>
    <div class="row g-4">
      <?php foreach ($items as $it): ?>
        <?php $img = !empty($it->itm_imagen) ? asset_upload($it->itm_imagen) : ''; ?>
        <div class="<?= e($colClass) ?>">
          <div class="card h-100 shadow-sm">
            <?php if ($img): ?>
              <div class="card-img-top com-card-img" style="background-image:url('<?= e($img) ?>');"></div>
            <?php else: ?>
              <div class="card-img-top com-card-img com-card-img--default"></div>
            <?php endif; ?>
            <div class="card-body">
              <?php if (!empty($it->itm_badge)): ?>
                <span class="badge bg-success mb-2"><?= e($it->itm_badge) ?></span>
              <?php endif; ?>
              <h3 class="h6 fw-bold mb-2"><?= e($it->itm_titulo ?? '') ?></h3>
              <?php if (!empty($it->itm_descripcion)): ?>
                <p class="text-muted small mb-3"><?= nl2br(e($it->itm_descripcion)) ?></p>
              <?php endif; ?>
              <?php if (!empty($it->itm_url)): ?>
                <a class="btn btn-outline-dark btn-sm"
                   target="<?= e(safe_target($it->itm_target ?? '_blank')) ?>"
                   rel="noopener"
                   href="<?= e(safe_url($it->itm_url)) ?>">
                  Abrir
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <style>
      .com-card-img{ height: 170px; background-size:cover; background-position:center; }
      .com-card-img--default{ background: linear-gradient(135deg, #f1f3f5 0%, #e9ecef 100%); }
    </style>
    <?php
  }
}

/* =========================================================
 * LINKS
 * ========================================================= */
if (!function_exists('render_links')) {
  function render_links($sec, $items) {
    if (empty($items)) {
      echo '<p class="text-muted">No hay enlaces configurados.</p>';
      return;
    }
    ?>
    <div class="list-group shadow-sm">
      <?php foreach ($items as $it): ?>
        <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
           href="<?= e(safe_url($it->itm_url ?? '#')) ?>"
           target="<?= e(safe_target($it->itm_target ?? '_blank')) ?>"
           rel="noopener">
          <span>
            <strong><?= e($it->itm_titulo ?? 'Enlace') ?></strong>
            <?php if (!empty($it->itm_descripcion)): ?>
              <span class="text-muted small d-block"><?= e($it->itm_descripcion) ?></span>
            <?php endif; ?>
          </span>
          <span class="fas fa-arrow-right text-muted"></span>
        </a>
      <?php endforeach; ?>
    </div>
    <?php
  }
}

/* =========================================================
 * CALENDAR
 * ========================================================= */
if (!function_exists('render_calendar')) {
  function render_calendar($sec) {
    if (empty($sec->sec_iframe_src)) {
      echo '<p class="text-muted">Calendar no configurado.</p>';
      return;
    }
    ?>
    <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden">
      <iframe src="<?= e($sec->sec_iframe_src) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <?php
  }
}

/* =========================================================
 * VIDEO
 * ========================================================= */
if (!function_exists('render_video')) {
  function render_video($sec) {
    if (empty($sec->sec_video_url)) {
      echo '<p class="text-muted">Video no configurado.</p>';
      return;
    }
    ?>
    <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden">
      <iframe src="<?= e(trim($sec->sec_video_url)) ?>" allow="autoplay; encrypted-media" allowfullscreen loading="lazy"></iframe>
    </div>
    <?php
  }
}

/* =========================================================
 * TEXT
 * ========================================================= */
if (!function_exists('render_text')) {
  function render_text($sec) {
    if (empty($sec->sec_descripcion)) {
      echo '<p class="text-muted">Sin contenido.</p>';
      return;
    }
    echo '<div class="bg-white p-4 rounded shadow-sm">' . nl2br(e($sec->sec_descripcion)) . '</div>';
  }
}

/* =========================================================
 * CTA
 * ========================================================= */
if (!function_exists('render_cta')) {
  function render_cta($sec) {
    if (empty($sec->sec_boton_url)) return;
    ?>
    <div class="p-4 bg-light rounded shadow-sm d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
      <div>
        <?php if (!empty($sec->sec_titulo)): ?>
          <h3 class="h5 fw-bold mb-1"><?= e($sec->sec_titulo) ?></h3>
        <?php endif; ?>
        <?php if (!empty($sec->sec_descripcion)): ?>
          <p class="text-muted mb-0"><?= nl2br(e($sec->sec_descripcion)) ?></p>
        <?php endif; ?>
      </div>
      <a class="btn btn-primary"
         href="<?= e(safe_url($sec->sec_boton_url)) ?>"
         target="_blank" rel="noopener">
        <?= e($sec->sec_boton_texto ?? 'Abrir') ?>
      </a>
    </div>
    <?php
  }
}

/* =========================================================
 * Render principal (sirve para todas las opciones)
 * ========================================================= */
if (!function_exists('render_section')) {
  function render_section($sec, $itemsBySeccion) {

    $secId = (int)($sec->sec_id ?? 0);
    $items = items_for_section($itemsBySeccion, $secId);

    $tipo = strtoupper((string)($sec->sec_tipo ?? ''));

    // Compatibilidad BD/admin
    // BD: CARDS
    // Admin: GRID
    if ($tipo === 'CARDS') $tipo = 'GRID';

    echo render_container_open($sec->sec_layout ?? 'CONTAINER');
    render_section_header($sec);

    if ($tipo === 'CAROUSEL')      render_carousel($sec, $items);
    elseif ($tipo === 'GRID')      render_grid($sec, $items);
    elseif ($tipo === 'LINKS')     render_links($sec, $items);
    elseif ($tipo === 'CALENDAR')  render_calendar($sec);
    elseif ($tipo === 'VIDEO')     render_video($sec);
    elseif ($tipo === 'CTA')       render_cta($sec);
    elseif ($tipo === 'TEXT') render_text($sec);
    else                           render_text($sec);

    echo render_container_close();
  }
}
