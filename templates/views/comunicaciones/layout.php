<?php
require_once __DIR__ . '/_helpers.php';


/**
 * ============================================================
 * Helpers (no rompe compatibilidad)
 * ============================================================
 */
if (!function_exists('safe_url')) {
  function safe_url($url) {
    $url = trim((string)$url);
    if ($url === '') return '';
    if (preg_match('#^(https?://)#i', $url)) return $url;
    return URL . ltrim($url, '/');
  }
}

if (!function_exists('normalize_items_map')) {
  function normalize_items_map($itemsBySeccion): array {

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

if (!function_exists('items_for_section')) {
  function items_for_section($itemsBySeccion, int $secId): array {
    $map = normalize_items_map($itemsBySeccion);

    if (isset($map[$secId]) && is_array($map[$secId])) return $map[$secId];

    $k = (string)$secId;
    if (isset($map[$k]) && is_array($map[$k])) return $map[$k];

    return [];
  }
}

/**
 * ============================================================
 * Contenedores (FULL realmente ocupa toda la pantalla)
 * ============================================================
 */
if (!function_exists('render_container_open')) {
  function render_container_open($layout) {
    $layout = strtoupper((string)$layout);

    // FULL: sin container (100% ancho)
    if ($layout === 'FULL') {
      return '<section class="com-section com-section--full py-0"><div class="container-fluid px-0">';
    }

    // CONTAINER / NARROW (usa tu helper)
    $cls = section_layout_class($layout);
    return '<section class="com-section py-5"><div class="'.$cls.'">';
  }
}
if (!function_exists('render_container_close')) {
  function render_container_close() { return '</div></section>'; }
}

if (!function_exists('render_section_inner_open')) {
  function render_section_inner_open($layout) {
    $layout = strtoupper((string)$layout);

    // FULL: no centra nada, el contenido decide
    if ($layout === 'FULL') {
      return '<div class="w-100">';
    }

    if ($layout === 'NARROW') {
      return '<div class="row justify-content-center"><div class="col-12 col-md-11 col-lg-10 col-xl-8">';
    }

    return '<div class="row justify-content-center"><div class="col-12 col-md-11 col-lg-10 col-xl-9">';
  }
}
if (!function_exists('render_section_inner_close')) {
  function render_section_inner_close($layout) {
    $layout = strtoupper((string)$layout);
    return ($layout === 'FULL') ? '</div>' : '</div></div>';
  }
}

/**
 * ============================================================
 * Estilos UI/UX (una sola vez)
 * ============================================================
 */
if (!function_exists('render_com_styles_once')) {
  function render_com_styles_once() {
    static $printed = false;
    if ($printed) return;
    $printed = true;
    ?>
    <style>
      /* ---- Forzar full width aunque el template tenga wrappers raros ---- */
      .com-section--full,
      .com-section--full > .container-fluid {
        width: 100% !important;
        max-width: 100% !important;
      }
      .com-section--full { margin: 0 !important; padding: 0 !important; }

      /* Estilos base existentes */
      .com-imgbox{
        width: 100%;
        background: #fff;
        display:flex;
        align-items:center;
        justify-content:center;
        overflow:hidden;
      }
      .com-imgbox--soft{
        background: linear-gradient(135deg, #f1f3f5 0%, #e9ecef 100%);
      }
      .com-imgbox img{
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        display:block;
      }

      .com-card-media{ height: 100px; }
      .com-carousel-media{ min-height: 100px; height: 100%; }

      @media (max-width: 767px){
        .com-card-media{ height: 170px; }
        .com-carousel-media{ min-height: 200px; }
      }

      /* ===== HERO 100% pantalla ===== */
      .com-dynamic-header{
        width: 100%;
        min-height: calc(100vh - 64px); /* ajusta si tu navbar mide distinto */
        display:flex;
        align-items:center;
        justify-content:center;
        position: relative;
        overflow:hidden;
        background: linear-gradient(135deg, #1C2262 0%, #09A28E 100%);
      }
      .com-header-bg{
        position:absolute;
        inset:0;
        background-size: cover;
        background-position:center;
        transform: scale(1.02);
      }
      .com-header-overlay{
        position:absolute;
        inset:0;
        background: rgba(0,0,0,.45);
      }
      .com-header-content{
        position: relative;
        color:#fff !important;
        padding: 2.5rem 1rem;
        max-width: 980px;
        margin: 0 auto;
        text-shadow: 2px 2px 4px rgba(0,0,0,.5);
      }
      .com-header-content h1{
        font-size: clamp(34px, 5vw, 72px);
        font-weight: 800;
        margin-bottom: .5rem;
      }
      .com-header-content .lead{
        font-size: clamp(16px, 2vw, 22px);
        font-weight: 300;
        margin: 0;
        opacity: .95;
      }

      /* Sticky bar al hacer scroll (mini header) */
      .com-stickybar{
        position: sticky;
        top: 0;
        z-index: 1050;
        background: rgba(255,255,255,.92);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(0,0,0,.06);
        transform: translateY(-120%);
        transition: transform .25s ease;
      }
      .com-stickybar.is-visible{ transform: translateY(0); }

      /* Secciones */
      .com-section { padding: 4rem 0; }
      .com-section-title h2 {
        font-size: 2.2rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: #1C2262;
      }
      .com-section-title p {
        font-size: 1.1rem;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
      }

      /* Tarjetas mejoradas */
      .com-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.08);
      }
      .com-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 2rem rgba(0,0,0,0.12);
      }
      .com-card-img { height: 200px; object-fit: cover; }
      .com-card-body { padding: 1.5rem; }
      .com-card-title { font-size: 1.2rem; font-weight: 600; margin-bottom: 0.75rem; }
      .com-card-text { color: #6c757d; line-height: 1.6; }

      /* Enlaces como tarjetas */
      .com-link-item {
        padding: 1rem 1.5rem;
        background-color: #f8f9fa;
        border-radius: 8px;
        transition: background-color 0.2s;
        text-decoration: none;
        color: #1C2262;
        font-weight: 500;
        display: flex;
        justify-content: space-between;
        align-items: center;
      }
      .com-link-item:hover { background-color: #e9ecef; }

      /* Calendario / Schedule */
      .table-schedule {
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.08);
      }
      .table-schedule thead th {
        background-color: #1C2262;
        color: white;
        font-weight: 500;
        border: none;
      }
    </style>
    <?php
  }
}

/**
 * ============================================================
 * HERO (FULL WIDTH + stickybar al bajar)
 * ============================================================
 */
if (!function_exists('render_hero')) {
  function render_hero($pagina) {
    render_com_styles_once();

    $bg = !empty($pagina->pag_hero_bg) ? asset_upload($pagina->pag_hero_bg) : '';
    $align = $pagina->pag_hero_alineacion ?? 'center';
    $alignClass = $align === 'left' ? 'text-start' : ($align === 'right' ? 'text-end' : 'text-center');

    $title = $pagina->pag_titulo ?? '';
    $subtitle = $pagina->pag_subtitulo ?? '';
    ?>
    <header id="com-hero" class="com-dynamic-header">
      <div class="com-header-bg" style="background-image:url('<?= e($bg) ?>');"></div>
      <div class="com-header-overlay"></div>

      <div class="com-header-content <?= e($alignClass) ?>">
        <h1><?= e($title) ?></h1>
        <?php if (!empty($subtitle)): ?>
          <p class="lead"><?= e($subtitle) ?></p>
        <?php endif; ?>
      </div>
    </header>

    <script>
      (() => {
        const hero = document.getElementById('com-hero');
        const sticky = document.getElementById('com-stickybar');
        if (!hero || !sticky) return;

        const io = new IntersectionObserver((entries) => {
          sticky.classList.toggle('is-visible', !entries[0].isIntersecting);
        }, { threshold: 0.05 });

        io.observe(hero);
      })();
    </script>
    <?php
  }
}

/**
 * ============================================================
 * Headers de sección
 * ============================================================
 */
if (!function_exists('render_section_header')) {
  function render_section_header($sec) {
    if (empty($sec->sec_titulo) && empty($sec->sec_descripcion)) return;
    ?>
    <div class="row mb-4 com-section-title">
      <div class="col-12 text-center">
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

/**
 * ============================================================
 * CAROUSEL
 * ============================================================
 */
if (!function_exists('render_carousel')) {
  function render_carousel($sec, $items) {
    render_com_styles_once();

    $carouselId = 'carousel_' . (int)$sec->sec_id;

    if (empty($items)) {
      echo '<p class="text-muted text-center">No hay contenido disponible.</p>';
      return;
    }

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
                <div class="com-imgbox com-carousel-media <?= $img ? '' : 'com-imgbox--soft' ?>">
                  <?php if ($img): ?>
                    <img src="<?= e($img) ?>" alt="<?= e($it->itm_titulo ?? '') ?>" loading="lazy">
                  <?php endif; ?>
                </div>
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
    <?php
  }
}

/**
 * ============================================================
 * GRID / CARDS
 * ============================================================
 */
if (!function_exists('render_grid')) {
  function render_grid($sec, $items) {
    render_com_styles_once();

    $cols = (int)($sec->sec_cols ?? 3);
    if ($cols < 1) $cols = 1;
    if ($cols > 5) $cols = 5;

    if (empty($items)) {
      echo '<p class="text-muted text-center">No hay contenido disponible.</p>';
      return;
    }

    if ($cols === 1) {
      echo '<div class="d-flex flex-column gap-4">';
      foreach ($items as $it) {
        $img = !empty($it->itm_imagen) ? asset_upload($it->itm_imagen) : '';
        ?>
        <article class="card shadow-sm overflow-hidden com-card">
          <div class="row g-0 align-items-stretch">
            <div class="col-12 col-md-4">
              <div class="com-imgbox com-carousel-media <?= $img ? '' : 'com-imgbox--soft' ?>">
                <?php if ($img): ?>
                  <img src="<?= e($img) ?>" alt="<?= e($it->itm_titulo ?? '') ?>" loading="lazy" class="com-card-img">
                <?php endif; ?>
              </div>
            </div>
            <div class="col-12 col-md-8">
              <div class="card-body p-4 com-card-body">
                <?php if (!empty($it->itm_badge)): ?>
                  <span class="badge bg-success mb-2"><?= e($it->itm_badge) ?></span>
                <?php endif; ?>
                <h3 class="h5 fw-bold mb-2 com-card-title"><?= e($it->itm_titulo ?? '') ?></h3>
                <?php if (!empty($it->itm_descripcion)): ?>
                  <p class="text-muted mb-0 com-card-text"><?= nl2br(e($it->itm_descripcion)) ?></p>
                <?php endif; ?>
                <?php if (!empty($it->itm_url)): ?>
                  <div class="mt-3">
                    <a class="btn btn-outline-dark btn-sm"
                       target="<?= e(safe_target($it->itm_target ?? '_blank')) ?>"
                       rel="noopener"
                       href="<?= e(safe_url($it->itm_url)) ?>">
                      Abrir
                    </a>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </article>
        <?php
      }
      echo '</div>';
      return;
    }

    $colClass = 'col-12 col-md-6 col-lg-4';
    if ($cols === 2) $colClass = 'col-12 col-md-6';
    if ($cols === 4) $colClass = 'col-12 col-md-6 col-lg-3';
    if ($cols === 5) $colClass = 'col-12 col-md-6 col-lg-3';

    ?>
    <div class="row g-4 justify-content-center">
      <?php foreach ($items as $it): ?>
        <?php $img = !empty($it->itm_imagen) ? asset_upload($it->itm_imagen) : ''; ?>
        <div class="<?= e($colClass) ?>">
          <div class="card h-100 shadow-sm com-card">
            <div class="com-imgbox com-card-media <?= $img ? '' : 'com-imgbox--soft' ?>">
              <?php if ($img): ?>
                <img src="<?= e($img) ?>" alt="<?= e($it->itm_titulo ?? '') ?>" loading="lazy" class="com-card-img">
              <?php endif; ?>
            </div>

            <div class="card-body com-card-body">
              <?php if (!empty($it->itm_badge)): ?>
                <span class="badge bg-success mb-2"><?= e($it->itm_badge) ?></span>
              <?php endif; ?>
              <h3 class="h6 fw-bold mb-2 com-card-title"><?= e($it->itm_titulo ?? '') ?></h3>
              <?php if (!empty($it->itm_descripcion)): ?>
                <p class="text-muted small mb-3 com-card-text"><?= nl2br(e($it->itm_descripcion)) ?></p>
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
    <?php
  }
}

/**
 * ============================================================
 * LINKS
 * ============================================================
 */
if (!function_exists('render_links')) {
  function render_links($sec, $items) {
    if (empty($items)) {
      echo '<p class="text-muted text-center">No hay enlaces configurados.</p>';
      return;
    }
    ?>
    <div class="list-group shadow-sm">
      <?php foreach ($items as $it): ?>
        <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center com-link-item"
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

/**
 * ============================================================
 * CALENDAR
 * ============================================================
 */
if (!function_exists('render_calendar')) {
  function render_calendar($sec) {
    if (empty($sec->sec_iframe_src)) {
      echo '<p class="text-muted text-center">Calendar no configurado.</p>';
      return;
    }
    ?>
    <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden">
      <iframe src="<?= e($sec->sec_iframe_src) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <?php
  }
}

/**
 * ============================================================
 * VIDEO
 * ============================================================
 */
if (!function_exists('render_video')) {
  function render_video($sec) {
    if (empty($sec->sec_video_url)) {
      echo '<p class="text-muted text-center">Video no configurado.</p>';
      return;
    }
    ?>
    <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden">
      <iframe src="<?= e(trim($sec->sec_video_url)) ?>" allow="autoplay; encrypted-media" allowfullscreen loading="lazy"></iframe>
    </div>
    <?php
  }
}

/**
 * ============================================================
 * TEXT
 * ============================================================
 */
if (!function_exists('render_text')) {
  function render_text($sec, $items = []) {
    render_com_styles_once();

    if (!empty($sec->sec_descripcion)) {
      echo '<div class="bg-white p-4 rounded shadow-sm">' . nl2br(e($sec->sec_descripcion)) . '</div>';
      return;
    }

    if (!empty($items)) {
      echo '<div class="d-flex flex-column gap-4">';
      foreach ($items as $it) {
        $img = !empty($it->itm_imagen) ? asset_upload($it->itm_imagen) : '';
        ?>
        <article class="card shadow-sm overflow-hidden com-card">
          <div class="row g-0 align-items-stretch">
            <div class="col-12 col-md-4">
              <div class="com-imgbox com-carousel-media <?= $img ? '' : 'com-imgbox--soft' ?>">
                <?php if ($img): ?>
                  <img src="<?= e($img) ?>" alt="<?= e($it->itm_titulo ?? '') ?>" loading="lazy" class="com-card-img">
                <?php endif; ?>
              </div>
            </div>
            <div class="col-12 col-md-8">
              <div class="card-body p-4 com-card-body">
                <h3 class="h5 fw-bold mb-2 com-card-title"><?= e($it->itm_titulo ?? '') ?></h3>
                <?php if (!empty($it->itm_descripcion)): ?>
                  <p class="text-muted mb-0 com-card-text"><?= nl2br(e($it->itm_descripcion)) ?></p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </article>
        <?php
      }
      echo '</div>';
      return;
    }

    echo '<p class="text-muted text-center">Sin contenido.</p>';
  }
}

/**
 * ============================================================
 * CTA
 * ============================================================
 */
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

/**
 * ============================================================
 * SCHEDULE
 * ============================================================
 */
if (!function_exists('render_schedule')) {
  function render_schedule($sec, $items) {
    if (empty($items)) {
      echo '<p class="text-muted text-center">No hay eventos programados.</p>';
      return;
    }
    ?>
    <div class="table-responsive">
      <table class="table table-hover table-bordered align-middle table-schedule">
        <thead class="table-dark">
          <tr>
            <th scope="col" style="width: 80px;">Hora</th>
            <th scope="col">Evento</th>
            <th scope="col" style="width: 200px;">Enlace</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($items as $it): ?>
            <?php
              $extra = json_decode($it->itm_extra_json ?? '{}', true);
              $dia = $extra['dia'] ?? '';
              $duracion = $extra['duracion'] ?? '';
            ?>
          <tr>
            <td class="fw-bold text-nowrap"><?= e($it->itm_badge ?? '') ?></td>
            <td>
              <strong><?= e($it->itm_titulo ?? '') ?></strong>
              <?php if ($dia || $duracion): ?>
                <br><small class="text-muted">
                  <?= e($dia) ?><?= ($dia && $duracion) ? ' &bull; ' : '' ?><?= e($duracion) ?>
                </small>
              <?php endif; ?>
              <?php if (!empty($it->itm_descripcion)): ?>
                <p class="text-muted mt-1 mb-0"><?= nl2br(e($it->itm_descripcion)) ?></p>
              <?php endif; ?>
            </td>
            <td>
              <?php if (!empty($it->itm_url) && $it->itm_url !== '#!'): ?>
                <a href="<?= e(safe_url($it->itm_url)) ?>"
                   target="<?= e(safe_target($it->itm_target ?? '_blank')) ?>"
                   rel="noopener"
                   class="btn btn-sm btn-outline-primary w-100">
                  <span class="fas fa-video me-1"></span> Unirse
                </a>
              <?php else: ?>
                <span class="text-muted fst-italic">Sin enlace</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php
  }
}

/**
 * ============================================================
 * Render principal por sección
 * ============================================================
 */
if (!function_exists('render_section')) {
  function render_section($sec, $itemsBySeccion) {

    $secId  = (int)($sec->sec_id ?? 0);
    $items  = items_for_section($itemsBySeccion, $secId);
    $tipo   = strtoupper((string)($sec->sec_tipo ?? ''));
    $layout = $sec->sec_layout ?? 'CONTAINER';

    // compatibilidad
    if ($tipo === 'GRID') $tipo = 'CARDS';

    echo render_container_open($layout);
    echo render_section_inner_open($layout);

    if ($tipo === 'SCHEDULE') {
      render_section_header($sec);
      render_schedule($sec, $items);
      echo render_section_inner_close($layout);
      echo render_container_close();
      return;
    }

    if ($tipo === 'TEXT') {
      if (!empty($sec->sec_titulo)) {
        echo '<div class="row mb-3"><div class="col-12 text-center">';
        echo '<h2 class="h4 fw-bold mb-0">'.e($sec->sec_titulo).'</h2>';
        echo '</div></div>';
      }

      render_text($sec, $items);

      echo render_section_inner_close($layout);
      echo render_container_close();
      return;
    }

    render_section_header($sec);

    if ($tipo === 'CAROUSEL')      render_carousel($sec, $items);
    elseif ($tipo === 'CARDS')     render_grid($sec, $items);
    elseif ($tipo === 'LINKS')     render_links($sec, $items);
    elseif ($tipo === 'CALENDAR')  render_calendar($sec);
    elseif ($tipo === 'VIDEO')     render_video($sec);
    elseif ($tipo === 'CTA')       render_cta($sec);
    else                           render_text($sec, $items);

    echo render_section_inner_close($layout);
    echo render_container_close();
  }
}
?>