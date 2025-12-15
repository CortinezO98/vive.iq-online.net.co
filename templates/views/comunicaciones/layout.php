<?php
/**
 * comunicaciones/layout.php
 * Layout base para páginas personalizables del módulo Comunicaciones.
 *
 * Requiere que el controlador pase:
 *  - $d->pagina (obj) -> datos de com_pagina
 *  - $d->secciones (array obj) -> secciones de com_seccion
 *  - $d->itemsBySeccion (array sec_id => array items)
 */

if (!function_exists('h')) {
  function h($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
}

if (!function_exists('safe_url')) {
  function safe_url($url) {
    $url = trim((string)$url);
    if ($url === '') return '';
    // Permite http/https o rutas internas
    if (preg_match('#^(https?://)#i', $url)) return $url;
    // Si es interno, lo anexamos a URL
    return URL . ltrim($url, '/');
  }
}

if (!function_exists('render_container_open')) {
  function render_container_open($layout) {
    $layout = strtoupper((string)$layout);
    if ($layout === 'FULL') return '<section class="py-5"><div class="w-100 px-0">';
    if ($layout === 'NARROW') return '<section class="py-5"><div class="container" style="max-width: 900px;">';
    return '<section class="py-5"><div class="container">';
  }
}
if (!function_exists('render_container_close')) {
  function render_container_close() { return '</div></section>'; }
}

if (!function_exists('render_hero')) {
  function render_hero($pagina) {
    $bg = !empty($pagina->pag_hero_bg) ? IMAGES . h($pagina->pag_hero_bg) : '';
    $overlay = !empty($pagina->pag_hero_overlay);
    $align = $pagina->pag_hero_alineacion ?? 'center';
    $alignClass = $align === 'left' ? 'text-start' : ($align === 'right' ? 'text-end' : 'text-center');

    ?>
    <header class="com-hero position-relative">
      <?php if ($bg): ?>
        <div class="com-hero-bg" style="background-image:url('<?= $bg ?>');"></div>
      <?php else: ?>
        <div class="com-hero-bg com-hero-bg--default"></div>
      <?php endif; ?>

      <?php if ($overlay): ?>
        <div class="com-hero-overlay"></div>
      <?php endif; ?>

      <div class="container position-relative py-5">
        <div class="row">
          <div class="col-12 <?= $alignClass ?>">
            <h1 class="display-6 fw-bold text-white mb-2"><?= h($pagina->pag_titulo ?? '') ?></h1>
            <?php if (!empty($pagina->pag_subtitulo)): ?>
              <p class="lead text-white-50 mb-0"><?= h($pagina->pag_subtitulo) ?></p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </header>

    <style>
      .com-hero { min-height: 340px; display:flex; align-items:center; overflow:hidden; }
      .com-hero-bg{
        position:absolute; inset:0;
        background-size:cover; background-position:center;
        transform: scale(1.02);
      }
      .com-hero-bg--default{
        background: linear-gradient(135deg, #1C2262 0%, #09A28E 100%);
      }
      .com-hero-overlay{ position:absolute; inset:0; background: rgba(0,0,0,.45); }
    </style>
    <?php
  }
}

if (!function_exists('render_section_header')) {
  function render_section_header($sec) {
    if (empty($sec->sec_titulo) && empty($sec->sec_descripcion)) return;
    ?>
    <div class="row mb-4">
      <div class="col-12">
        <?php if (!empty($sec->sec_titulo)): ?>
          <h2 class="h4 fw-bold mb-2"><?= h($sec->sec_titulo) ?></h2>
        <?php endif; ?>
        <?php if (!empty($sec->sec_descripcion)): ?>
          <p class="text-muted mb-0"><?= nl2br(h($sec->sec_descripcion)) ?></p>
        <?php endif; ?>
      </div>
    </div>
    <?php
  }
}

if (!function_exists('render_carousel')) {
  function render_carousel($sec, $items) {
    $carouselId = 'carousel_' . (int)$sec->sec_id;
    if (empty($items)) {
      echo '<p class="text-muted">No hay contenido disponible.</p>';
      return;
    }
    ?>
    <div id="<?= h($carouselId) ?>" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner rounded-3 overflow-hidden shadow-sm">

        <?php foreach ($items as $i => $it): ?>
          <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
            <div class="row g-0 align-items-stretch bg-white">
              <div class="col-12 col-md-5">
                <?php if (!empty($it->item_imagen)): ?>
                  <div class="com-slide-img" style="background-image:url('<?= IMAGES . h($it->item_imagen) ?>');"></div>
                <?php else: ?>
                  <div class="com-slide-img com-slide-img--default"></div>
                <?php endif; ?>
              </div>
              <div class="col-12 col-md-7 p-4">
                <?php if (!empty($it->item_badge)): ?>
                  <span class="badge bg-primary mb-2"><?= h($it->item_badge) ?></span>
                <?php endif; ?>
                <h3 class="h5 fw-bold mb-2"><?= h($it->item_titulo ?? '') ?></h3>
                <?php if (!empty($it->item_descripcion)): ?>
                  <p class="text-muted mb-3"><?= nl2br(h($it->item_descripcion)) ?></p>
                <?php endif; ?>
                <?php if (!empty($it->item_url)): ?>
                  <a class="btn btn-outline-primary btn-sm"
                     target="<?= h($it->item_target ?? '_blank') ?>"
                     rel="noopener"
                     href="<?= h(safe_url($it->item_url)) ?>">
                    Ver más
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#<?= h($carouselId) ?>" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#<?= h($carouselId) ?>" data-bs-slide="next">
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

if (!function_exists('render_grid')) {
  function render_grid($sec, $items) {
    $cols = (int)($sec->sec_cols ?? 3);
    if ($cols < 2) $cols = 2;
    if ($cols > 5) $cols = 5;

    $colClass = 'col-12 col-md-6 col-lg-4';
    if ($cols === 2) $colClass = 'col-12 col-md-6';
    if ($cols === 3) $colClass = 'col-12 col-md-6 col-lg-4';
    if ($cols === 4) $colClass = 'col-12 col-md-6 col-lg-3';
    if ($cols === 5) $colClass = 'col-12 col-md-6 col-lg-3'; // Bootstrap no tiene 1/5 nativo

    if (empty($items)) {
      echo '<p class="text-muted">No hay contenido disponible.</p>';
      return;
    }
    ?>
    <div class="row g-4">
      <?php foreach ($items as $it): ?>
        <div class="<?= h($colClass) ?>">
          <div class="card h-100 shadow-sm">
            <?php if (!empty($it->item_imagen)): ?>
              <div class="card-img-top com-card-img" style="background-image:url('<?= IMAGES . h($it->item_imagen) ?>');"></div>
            <?php else: ?>
              <div class="card-img-top com-card-img com-card-img--default"></div>
            <?php endif; ?>
            <div class="card-body">
              <?php if (!empty($it->item_badge)): ?>
                <span class="badge bg-success mb-2"><?= h($it->item_badge) ?></span>
              <?php endif; ?>
              <h3 class="h6 fw-bold mb-2"><?= h($it->item_titulo ?? '') ?></h3>
              <?php if (!empty($it->item_descripcion)): ?>
                <p class="text-muted small mb-3"><?= nl2br(h($it->item_descripcion)) ?></p>
              <?php endif; ?>
              <?php if (!empty($it->item_url)): ?>
                <a class="btn btn-outline-dark btn-sm"
                   target="<?= h($it->item_target ?? '_blank') ?>"
                   rel="noopener"
                   href="<?= h(safe_url($it->item_url)) ?>">
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
           href="<?= h(safe_url($it->item_url ?? '#')) ?>"
           target="<?= h($it->item_target ?? '_blank') ?>"
           rel="noopener">
          <span>
            <strong><?= h($it->item_titulo ?? 'Enlace') ?></strong>
            <?php if (!empty($it->item_descripcion)): ?>
              <span class="text-muted small d-block"><?= h($it->item_descripcion) ?></span>
            <?php endif; ?>
          </span>
          <span class="fas fa-arrow-right text-muted"></span>
        </a>
      <?php endforeach; ?>
    </div>
    <?php
  }
}

if (!function_exists('render_calendar')) {
  function render_calendar($sec) {
    if (empty($sec->sec_iframe_src)) {
      echo '<p class="text-muted">Calendar no configurado.</p>';
      return;
    }
    ?>
    <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden">
      <iframe src="<?= h($sec->sec_iframe_src) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <?php
  }
}

if (!function_exists('render_video')) {
  function render_video($sec) {
    if (empty($sec->sec_video_url)) {
      echo '<p class="text-muted">Video no configurado.</p>';
      return;
    }
    $url = trim($sec->sec_video_url);
    // Si es YouTube embed ya viene listo, si no, se muestra como iframe genérico
    ?>
    <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden">
      <iframe src="<?= h($url) ?>" allow="autoplay; encrypted-media" allowfullscreen loading="lazy"></iframe>
    </div>
    <?php
  }
}

if (!function_exists('render_text')) {
  function render_text($sec) {
    if (empty($sec->sec_descripcion)) {
      echo '<p class="text-muted">Sin contenido.</p>';
      return;
    }
    echo '<div class="bg-white p-4 rounded shadow-sm">' . nl2br(h($sec->sec_descripcion)) . '</div>';
  }
}

if (!function_exists('render_cta')) {
  function render_cta($sec) {
    if (empty($sec->sec_boton_url)) return;
    ?>
    <div class="p-4 bg-light rounded shadow-sm d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
      <div>
        <?php if (!empty($sec->sec_titulo)): ?>
          <h3 class="h5 fw-bold mb-1"><?= h($sec->sec_titulo) ?></h3>
        <?php endif; ?>
        <?php if (!empty($sec->sec_descripcion)): ?>
          <p class="text-muted mb-0"><?= nl2br(h($sec->sec_descripcion)) ?></p>
        <?php endif; ?>
      </div>
      <a class="btn btn-primary"
         href="<?= h(safe_url($sec->sec_boton_url)) ?>"
         target="_blank" rel="noopener">
        <?= h($sec->sec_boton_texto ?? 'Abrir') ?>
      </a>
    </div>
    <?php
  }
}

if (!function_exists('render_section')) {
  function render_section($sec, $itemsBySeccion) {
    $items = $itemsBySeccion[$sec->sec_id] ?? [];
    $tipo = strtoupper((string)$sec->sec_tipo);

    echo render_container_open($sec->sec_layout ?? 'CONTAINER');
    render_section_header($sec);

    if ($tipo === 'CAROUSEL') render_carousel($sec, $items);
    elseif ($tipo === 'GRID') render_grid($sec, $items);
    elseif ($tipo === 'LINKS') render_links($sec, $items);
    elseif ($tipo === 'CALENDAR') render_calendar($sec);
    elseif ($tipo === 'VIDEO') render_video($sec);
    elseif ($tipo === 'CTA') render_cta($sec);
    else render_text($sec);

    echo render_container_close();
  }
}
