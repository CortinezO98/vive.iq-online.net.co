<?php
require_once __DIR__ . '/_helpers.php';

/**
 * ============================================================
 * Helpers
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

if (!function_exists('is_admin_comunicaciones')) {
    function is_admin_comunicaciones(): bool {
        $perfil = strtoupper(trim((string)($_SESSION[APP_SESSION . 'usu_perfil'] ?? '')));
        return in_array($perfil, ['ADMIN', 'ADMINISTRADOR', 'SUPERADMIN'], true);
    }
}

if (!function_exists('safe_target')) {
    function safe_target(?string $t): string {
        return in_array($t, ['_self', '_blank'], true) ? $t : '_blank';
    }
}

if (!function_exists('section_layout_class')) {
    function section_layout_class(string $layout): string {
        $layout = strtoupper($layout);
        return match($layout) {
            'FULL'   => 'container-fluid px-0',
            'NARROW' => 'container',
            default  => 'container'
        };
    }
}

if (!function_exists('sec_cfg')) {
    function sec_cfg($sec): array {
        $raw = $sec->sec_config_json ?? null;

        if ($raw === null || $raw === '') return [];

        if (is_string($raw)) {
            $decoded = json_decode($raw, true);
            return (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : [];
        }

        if (is_object($raw)) return (array)$raw;
        if (is_array($raw)) return $raw;

        return [];
    }
}

if (!function_exists('cfg_get')) {
    function cfg_get($sec, string $key, $default = null) {
        $cfg = sec_cfg($sec);
        return array_key_exists($key, $cfg) ? $cfg[$key] : $default;
    }
}

if (!function_exists('normalize_eventos_por_dia')) {
    function normalize_eventos_por_dia($eventosPorDia): array {
        if (!is_array($eventosPorDia)) return [];

        $result = [];

        foreach ($eventosPorDia as $key => $lista) {
            if (!is_array($lista)) continue;

            $fechaKey = null;

            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', (string)$key)) {
                $fechaKey = (string)$key;
            }

            foreach ($lista as $ev) {
                if (!is_array($ev)) continue;

                $fecha = $ev['event_date'] ?? $fechaKey;
                if (!$fecha) continue;

                $ts = strtotime((string)$fecha);
                if ($ts === false) continue;

                $fechaNormalizada = date('Y-m-d', $ts);
                $ev['event_date'] = $fechaNormalizada;

                if (!isset($result[$fechaNormalizada])) {
                    $result[$fechaNormalizada] = [];
                }

                $result[$fechaNormalizada][] = $ev;
            }
        }

        ksort($result);
        return $result;
    }
}

/**
 * ============================================================
 * ESTILOS
 * ============================================================
 */
if (!function_exists('render_com_styles_once')) {
    function render_com_styles_once() {
        static $printed = false;
        if ($printed) return;
        $printed = true;
        ?>
        <style>
            :root {
                --iq-primary: #1C2262;
                --iq-secondary: #09A28E;
                --iq-accent: #FF6B35;
                --iq-dark: #1E1E2F;
                --iq-light: #F8F9FC;
                --iq-gray: #6B7280;
                --iq-border: #E5E7EB;
                --iq-shadow: 0 20px 40px -15px rgba(28, 34, 98, 0.15);
                --iq-shadow-hover: 0 30px 50px -20px rgba(28, 34, 98, 0.25);
                --iq-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                --iq-border-radius: 20px;
                --iq-border-radius-sm: 12px;
            }

            .com-text-white { color: #FFFFFF !important; }
            .com-text-primary { color: var(--iq-primary) !important; }
            .com-text-secondary { color: var(--iq-secondary) !important; }

            .com-dynamic-header {
                position: relative;
                min-height: 78vh;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                background: linear-gradient(135deg, var(--iq-primary) 0%, var(--iq-secondary) 100%);
            }

            .com-header-bg {
                position: absolute;
                inset: 0;
                background-size: cover;
                background-position: center center;
                background-repeat: no-repeat;
            }

            .com-header-overlay {
                position: absolute;
                inset: 0;
                background: transparent;
                backdrop-filter: none;
                pointer-events: none;
            }

            .com-header-content {
                position: relative;
                z-index: 2;
                color: #FFFFFF !important;
                max-width: 900px;
                margin: 0 auto;
                padding: 2rem;
                animation: com-fade-up 0.8s ease-out;
            }

            .com-header-content h1 {
                font-size: clamp(2.6rem, 7vw, 5rem);
                font-weight: 800;
                letter-spacing: -0.02em;
                margin-bottom: 1rem;
                line-height: 1.1;
                text-shadow: 2px 2px 18px rgba(0, 0, 0, 0.28);
                color: #FFFFFF !important;
            }

            .com-header-content .lead {
                font-size: clamp(1.05rem, 2vw, 1.5rem);
                font-weight: 400;
                opacity: 1;
                max-width: 700px;
                margin: 0 auto;
                text-shadow: 1px 1px 8px rgba(0, 0, 0, 0.25);
                color: #FFFFFF !important;
            }

            @keyframes com-fade-up {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .com-section {
                padding: 4.5rem 0;
                position: relative;
            }

            .com-section:nth-child(even) {
                background-color: var(--iq-light);
            }

            .com-section-title {
                margin-bottom: 2.5rem;
                text-align: center;
            }

            .com-section-title h2 {
                font-size: clamp(1.8rem, 4vw, 2.8rem);
                font-weight: 700;
                color: var(--iq-primary);
                margin-bottom: 1rem;
                position: relative;
                display: inline-block;
            }

            .com-section-title h2::after {
                content: '';
                position: absolute;
                bottom: -10px;
                left: 50%;
                transform: translateX(-50%);
                width: 80px;
                height: 4px;
                background: var(--iq-secondary);
                border-radius: 2px;
            }

            .com-section-title p {
                font-size: 1.05rem;
                color: var(--iq-gray);
                max-width: 700px;
                margin: 0 auto;
                line-height: 1.6;
            }

            .com-card {
                border: none;
                border-radius: var(--iq-border-radius);
                overflow: hidden;
                transition: var(--iq-transition);
                background: #FFFFFF;
                box-shadow: var(--iq-shadow);
                height: 100%;
                display: flex;
                flex-direction: column;
            }

            .com-card:hover {
                transform: translateY(-8px);
                box-shadow: var(--iq-shadow-hover);
            }

            .com-card-img-wrapper {
                position: relative;
                overflow: hidden;
                aspect-ratio: 16 / 8.5;
                min-height: 180px;
                max-height: 220px;
                background: linear-gradient(135deg, var(--iq-primary), var(--iq-secondary));
            }

            .com-card-img {
                width: 100%;
                height: 100%;
                object-fit: contain;
                object-position: center;
                transition: transform 0.3s ease;
                background: #fff;
            }

            .com-card:hover .com-card-img {
                transform: scale(1.06);
            }

            .com-card-body {
                padding: 1.25rem;
                flex: 1;
                display: flex;
                flex-direction: column;
            }

            .com-card-badge {
                display: inline-block;
                padding: 0.35rem 0.9rem;
                background: linear-gradient(135deg, var(--iq-secondary), #0B8A7A);
                color: white;
                border-radius: 50px;
                font-size: 0.72rem;
                font-weight: 600;
                letter-spacing: 0.5px;
                text-transform: uppercase;
                margin-bottom: 0.9rem;
                align-self: flex-start;
                box-shadow: 0 4px 10px rgba(9, 162, 142, 0.3);
            }

            .com-card-title {
                font-size: 1.15rem;
                font-weight: 700;
                color: var(--iq-primary);
                margin-bottom: 0.75rem;
                line-height: 1.3;
            }

            .com-card-text {
                color: var(--iq-gray);
                line-height: 1.45;
                font-size: 0.95rem;
                margin-bottom: 1rem;
                flex: 1;
            }

            .com-card-btn {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.75rem 1.3rem;
                background: transparent;
                color: var(--iq-primary);
                border: 2px solid var(--iq-primary);
                border-radius: 50px;
                font-weight: 600;
                text-decoration: none;
                transition: var(--iq-transition);
                align-self: flex-start;
                margin-top: auto;
            }

            .com-card-btn:hover {
                background: var(--iq-primary);
                color: white;
                text-decoration: none;
            }

            .com-carousel {
                border-radius: var(--iq-border-radius);
                overflow: hidden;
                box-shadow: var(--iq-shadow);
            }

            .carousel-item {
                background: #FFFFFF;
            }

            .carousel-item .row {
                min-height: 380px;
            }

            .com-carousel-media {
                height: 100%;
                min-height: 380px;
                max-height: 420px;
                background: linear-gradient(135deg, var(--iq-primary), var(--iq-secondary));
                overflow: hidden;
            }

            .com-carousel-media {
                height: 100%;
                min-height: 380px;
                max-height: 420px;
                background: #fff;
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .com-carousel-media img {
                width: 100%;
                height: 100%;
                object-fit: contain;
                object-position: center;
                transition: transform 0.3s ease;
                background: #fff;
            }

            .carousel-item:hover .com-carousel-media img {
                transform: scale(1.04);
            }

            .com-carousel-content {
                padding: 2rem;
                display: flex;
                flex-direction: column;
                justify-content: center;
                height: 100%;
                background: #FFFFFF;
            }

            .com-carousel-content h3 {
                font-size: 1.8rem;
                font-weight: 700;
                color: var(--iq-primary);
                margin-bottom: 1rem;
                line-height: 1.2;
            }

            .com-carousel-content p {
                font-size: 1rem;
                color: var(--iq-gray);
                line-height: 1.6;
                margin-bottom: 1.5rem;
            }

            .com-carousel-content .btn {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.9rem 1.6rem;
                background: var(--iq-primary);
                color: white;
                border: none;
                border-radius: 50px;
                font-weight: 600;
                transition: var(--iq-transition);
                align-self: flex-start;
            }

            .com-carousel-content .btn:hover {
                background: var(--iq-secondary);
                color: white;
                text-decoration: none;
            }

            .carousel-control-prev,
            .carousel-control-next {
                width: 52px;
                height: 52px;
                background: rgba(255, 255, 255, 0.25);
                backdrop-filter: blur(3px);
                border-radius: 50%;
                top: 50%;
                transform: translateY(-50%);
                opacity: 0;
                transition: var(--iq-transition);
                margin: 0 16px;
            }

            .carousel:hover .carousel-control-prev,
            .carousel:hover .carousel-control-next {
                opacity: 1;
            }

            .carousel-indicators {
                bottom: 16px;
            }

            .carousel-indicators button {
                width: 10px;
                height: 10px;
                border-radius: 50%;
                margin: 0 5px;
            }

            .com-grid {
                margin: 0;
            }

            .com-links-list {
                background: #FFFFFF;
                border-radius: var(--iq-border-radius);
                overflow: hidden;
                box-shadow: var(--iq-shadow);
            }

            .com-link-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 1.2rem 1.5rem;
                border: none;
                border-bottom: 1px solid var(--iq-border);
                transition: var(--iq-transition);
                text-decoration: none;
                color: inherit;
            }

            .com-link-item:last-child {
                border-bottom: none;
            }

            .com-link-item:hover {
                background: var(--iq-light);
                text-decoration: none;
            }

            .com-link-item .link-title {
                font-size: 1.05rem;
                font-weight: 600;
                color: var(--iq-primary);
                margin-bottom: 0.2rem;
            }

            .com-link-item .link-desc {
                color: var(--iq-gray);
                font-size: 0.92rem;
            }

            .com-link-item .link-arrow {
                color: var(--iq-secondary);
            }

            .com-schedule-container,
            .com-calendar-container {
                background: #FFFFFF;
                border-radius: var(--iq-border-radius);
                padding: 1.5rem;
                box-shadow: var(--iq-shadow);
            }

            .com-schedule-header,
            .com-calendar-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.5rem;
                flex-wrap: wrap;
                gap: 1rem;
            }

            .com-schedule-header h3,
            .com-calendar-header h3 {
                font-size: 1.7rem;
                font-weight: 700;
                color: var(--iq-primary);
                margin: 0;
            }

            .com-schedule-nav,
            .com-calendar-nav {
                display: flex;
                gap: 0.5rem;
                flex-wrap: wrap;
            }

            .com-schedule-nav .btn,
            .com-calendar-nav .btn {
                padding: 0.55rem 1.2rem;
                border-radius: 50px;
                font-weight: 600;
            }

            .com-schedule-table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0 0.5rem;
            }

            .com-schedule-table thead th {
                background: var(--iq-primary);
                color: white;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                padding: 0.9rem 1rem;
                border: none;
                font-size: 0.85rem;
            }

            .com-schedule-table thead th:first-child {
                border-top-left-radius: var(--iq-border-radius-sm);
                border-bottom-left-radius: var(--iq-border-radius-sm);
            }

            .com-schedule-table thead th:last-child {
                border-top-right-radius: var(--iq-border-radius-sm);
                border-bottom-right-radius: var(--iq-border-radius-sm);
            }

            .com-schedule-table tbody td {
                padding: 0.85rem 0.9rem;
                vertical-align: top;
                background: #FFFFFF;
                border-bottom: 1px solid var(--iq-border);
            }

            .com-schedule-table tbody tr {
                transition: var(--iq-transition);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            }

            .com-schedule-table tbody tr:hover {
                box-shadow: var(--iq-shadow);
                transform: translateY(-2px);
            }

            .com-schedule-table .event-time {
                font-weight: 600;
                color: var(--iq-primary);
                white-space: nowrap;
            }

            .com-schedule-table .event-time small {
                font-weight: normal;
                color: var(--iq-gray);
                font-size: 0.8rem;
                display: block;
                margin-top: 0.2rem;
            }

            .com-schedule-table .event-title {
                font-weight: 700;
                color: var(--iq-dark);
                margin-bottom: 0.2rem;
                font-size: 1rem;
            }

            .com-schedule-table .event-location {
                color: var(--iq-gray);
                font-size: 0.85rem;
                display: flex;
                align-items: center;
                gap: 0.3rem;
                margin-top: 0.3rem;
            }

            .com-schedule-table .event-location i {
                color: var(--iq-secondary);
                font-size: 0.8rem;
            }

            .com-schedule-table .event-desc {
                color: var(--iq-gray);
                font-size: 0.85rem;
                line-height: 1.4;
                margin-top: 0.45rem;
            }

            .com-schedule-table .btn-event {
                padding: 0.5rem 1rem;
                border-radius: 50px;
                font-weight: 600;
                font-size: 0.85rem;
                transition: var(--iq-transition);
                white-space: nowrap;
                background: var(--iq-primary);
                color: white;
                border: none;
                display: inline-flex;
                align-items: center;
                gap: 0.45rem;
                text-decoration: none;
            }

            .com-schedule-table .btn-event:hover {
                background: var(--iq-secondary);
                color: white;
                text-decoration: none;
            }

            .com-calendar-grid {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
                gap: 0.5rem;
                margin-top: 1rem;
            }

            .com-calendar-weekday {
                text-align: center;
                font-weight: 700;
                color: var(--iq-primary);
                padding: 0.8rem;
                background: var(--iq-light);
                border-radius: var(--iq-border-radius-sm);
                text-transform: uppercase;
                font-size: 0.85rem;
            }

            .com-calendar-day {
                background: var(--iq-light);
                border-radius: var(--iq-border-radius-sm);
                padding: 0.75rem;
                min-height: 120px;
                border: 2px solid transparent;
                transition: var(--iq-transition);
            }

            .com-calendar-day:hover {
                border-color: var(--iq-secondary);
                transform: translateY(-2px);
                box-shadow: var(--iq-shadow);
            }

            .com-calendar-day.today {
                border-color: var(--iq-primary);
                background: rgba(28, 34, 98, 0.05);
            }

            .com-calendar-day.other-month {
                opacity: 0.55;
                background: #F1F3F5;
            }

            .com-calendar-day-number {
                font-weight: 700;
                color: var(--iq-primary);
                margin-bottom: 0.6rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .com-calendar-events {
                display: flex;
                flex-direction: column;
                gap: 0.3rem;
            }

            .com-calendar-event {
                background: #FFFFFF;
                border-left: 4px solid var(--iq-primary);
                border-radius: 8px;
                padding: 0.35rem 0.5rem;
                font-size: 0.78rem;
                transition: var(--iq-transition);
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            }

            .com-calendar-event.all-day {
                border-left-color: var(--iq-secondary);
            }

            .com-calendar-event .event-time {
                font-size: 0.7rem;
                opacity: 0.75;
            }

            .com-calendar-event .event-title {
                font-weight: 600;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .com-video-wrapper {
                border-radius: var(--iq-border-radius);
                overflow: hidden;
                box-shadow: var(--iq-shadow);
                aspect-ratio: 16/9;
            }

            .com-video-wrapper iframe {
                width: 100%;
                height: 100%;
                border: 0;
            }

            .com-cta-section {
                background: linear-gradient(135deg, var(--iq-primary) 0%, var(--iq-secondary) 100%);
                border-radius: var(--iq-border-radius);
                padding: 3rem;
                color: white;
                text-align: center;
                position: relative;
                overflow: hidden;
            }

            .com-cta-content {
                position: relative;
                z-index: 2;
            }

            .com-cta-section h3 {
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 1rem;
                color: white;
            }

            .com-cta-section p {
                font-size: 1.05rem;
                opacity: 0.95;
                margin-bottom: 1.5rem;
                max-width: 650px;
                margin-left: auto;
                margin-right: auto;
            }

            .com-cta-section .btn {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 1rem 2.2rem;
                background: white;
                color: var(--iq-primary);
                border: none;
                border-radius: 50px;
                font-weight: 700;
                transition: var(--iq-transition);
            }

            .com-cta-section .btn:hover {
                background: var(--iq-secondary);
                color: white;
                text-decoration: none;
            }

            @media (max-width: 992px) {
                .com-section { padding: 3rem 0; }
                .com-carousel-media {
                    min-height: 260px;
                    max-height: 300px;
                }
                .com-carousel-content {
                    padding: 1.5rem;
                }
                .com-carousel-content h3 {
                    font-size: 1.5rem;
                }
            }

            @media (max-width: 768px) {
                .com-header-content h1 { font-size: 2.2rem; }
                .com-header-content .lead { font-size: 1rem; }
                .com-section { padding: 2.4rem 0; }
                .com-schedule-table thead { display: none; }

                .com-schedule-table tbody td {
                    display: block;
                    width: 100%;
                    text-align: left;
                    padding: 0.8rem;
                }

                .com-schedule-table tbody td:before {
                    content: attr(data-label);
                    font-weight: 600;
                    color: var(--iq-primary);
                    display: block;
                    margin-bottom: 0.3rem;
                }

                .com-calendar-day {
                    min-height: 95px;
                    padding: 0.5rem;
                }
            }

            @media (max-width: 576px) {
                .com-section { padding: 2rem 0; }
                .com-card-body { padding: 1rem; }
                .com-card-img-wrapper {
                    min-height: 160px;
                    max-height: 180px;
                }
                .com-calendar-weekday { display: none; }
                .com-calendar-event { display: none; }
                .com-cta-section { padding: 2rem 1.2rem; }
            }
        </style>
        <?php
    }
}

/**
 * ============================================================
 * HERO
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
            <?php if ($bg): ?>
                <div class="com-header-bg" style="background-image:url('<?= e($bg) ?>');"></div>
                <div class="com-header-overlay"></div>
            <?php endif; ?>

            <div class="com-header-content <?= e($alignClass) ?>">
                <h1 class="com-text-white"><?= e($title) ?></h1>
                <?php if (!empty($subtitle)): ?>
                    <p class="lead com-text-white"><?= e($subtitle) ?></p>
                <?php endif; ?>
            </div>
        </header>
        <?php
    }
}

/**
 * ============================================================
 * SECCIÓN
 * ============================================================
 */
if (!function_exists('render_section_header')) {
    function render_section_header($sec) {
        if (empty($sec->sec_titulo) && empty($sec->sec_descripcion)) return;
        ?>
        <div class="com-section-title">
            <?php if (!empty($sec->sec_titulo)): ?>
                <h2><?= e($sec->sec_titulo) ?></h2>
            <?php endif; ?>
            <?php if (!empty($sec->sec_descripcion)): ?>
                <p><?= nl2br(e($sec->sec_descripcion)) ?></p>
            <?php endif; ?>
        </div>
        <?php
    }
}

if (!function_exists('render_container_open')) {
    function render_container_open($layout) {
        $layout = strtoupper((string)$layout);
        if ($layout === 'FULL') {
            return '<section class="com-section"><div class="container-fluid px-0">';
        }
        return '<section class="com-section"><div class="container">';
    }
}

if (!function_exists('render_container_close')) {
    function render_container_close() {
        return '</div></section>';
    }
}

if (!function_exists('render_section_inner_open')) {
    function render_section_inner_open($layout) {
        $layout = strtoupper((string)$layout);
        if ($layout === 'FULL') {
            return '<div class="w-100">';
        }
        return '<div class="row justify-content-center"><div class="col-12 col-xl-10">';
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
 * CARRUSEL
 * ============================================================
 */
if (!function_exists('render_carousel')) {
    function render_carousel($sec, $items) {
        render_com_styles_once();

        if (empty($items)) {
            echo '<p class="text-muted text-center">No hay contenido disponible.</p>';
            return;
        }

        $carouselId = 'carousel_' . (int)$sec->sec_id;
        $autoplay = cfg_get($sec, 'autoplay', true);
        $interval = (int)cfg_get($sec, 'interval', 5000);
        ?>
        <div id="<?= e($carouselId) ?>" class="carousel slide com-carousel"
             data-bs-ride="<?= $autoplay ? 'carousel' : 'false' ?>"
             data-bs-interval="<?= (int)$interval ?>">

            <div class="carousel-inner">
                <?php foreach ($items as $i => $it): ?>
                    <?php
                    $img = !empty($it->itm_imagen) ? asset_upload($it->itm_imagen) : '';
                    $url = !empty($it->itm_url) ? $it->itm_url : '#';
                    $badge = !empty($it->itm_badge) ? $it->itm_badge : '';
                    ?>
                    <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                        <div class="row g-0 align-items-stretch">
                            <div class="col-12 col-lg-6">
                                <div class="com-carousel-media <?= $img ? '' : 'com-bg-gradient' ?>">
                                    <?php if ($img): ?>
                                        <img src="<?= e($img) ?>" alt="<?= e($it->itm_titulo ?? '') ?>" loading="lazy">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="com-carousel-content">
                                    <?php if ($badge): ?>
                                        <span class="com-card-badge"><?= e($badge) ?></span>
                                    <?php endif; ?>

                                    <h3><?= e($it->itm_titulo ?? '') ?></h3>

                                    <?php if (!empty($it->itm_descripcion)): ?>
                                        <p><?= nl2br(e($it->itm_descripcion)) ?></p>
                                    <?php endif; ?>

                                    <?php if ($url !== '#'): ?>
                                        <a class="btn"
                                           href="<?= e(safe_url($url)) ?>"
                                           target="<?= e(safe_target($it->itm_target ?? '_blank')) ?>"
                                           rel="noopener">
                                            <span>Ver más</span>
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
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

            <div class="carousel-indicators">
                <?php foreach ($items as $i => $it): ?>
                    <button type="button"
                            data-bs-target="#<?= e($carouselId) ?>"
                            data-bs-slide-to="<?= $i ?>"
                            class="<?= $i === 0 ? 'active' : '' ?>"
                            aria-current="<?= $i === 0 ? 'true' : 'false' ?>"
                            aria-label="Slide <?= $i + 1 ?>"></button>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}

/**
 * ============================================================
 * CARDS
 * ============================================================
 */
if (!function_exists('render_cards')) {
    function render_cards($sec, $items) {
        render_com_styles_once();

        $cols = (int)($sec->sec_cols ?? 3);
        if ($cols < 1) $cols = 1;
        if ($cols > 4) $cols = 4;

        if (empty($items)) {
            echo '<p class="text-muted text-center">No hay contenido disponible.</p>';
            return;
        }

        $colClass = 'col-12 col-sm-6 col-lg-4';
        if ($cols === 1) $colClass = 'col-12';
        if ($cols === 2) $colClass = 'col-12 col-md-6';
        if ($cols === 3) $colClass = 'col-12 col-sm-6 col-lg-4';
        if ($cols === 4) $colClass = 'col-12 col-sm-6 col-lg-3';

        echo '<div class="row g-4 com-grid">';
        foreach ($items as $it):
            $img = !empty($it->itm_imagen) ? asset_upload($it->itm_imagen) : '';
            $badge = !empty($it->itm_badge) ? $it->itm_badge : '';
            $url = !empty($it->itm_url) ? $it->itm_url : '#';
            ?>
            <div class="<?= e($colClass) ?>">
                <div class="com-card">
                    <div class="com-card-img-wrapper">
                        <?php if ($img): ?>
                            <img src="<?= e($img) ?>" class="com-card-img" alt="<?= e($it->itm_titulo ?? '') ?>" loading="lazy">
                        <?php else: ?>
                            <div class="com-card-img com-bg-gradient"></div>
                        <?php endif; ?>
                    </div>

                    <div class="com-card-body">
                        <?php if ($badge): ?>
                            <span class="com-card-badge"><?= e($badge) ?></span>
                        <?php endif; ?>

                        <h3 class="com-card-title"><?= e($it->itm_titulo ?? '') ?></h3>

                        <?php if (!empty($it->itm_descripcion)): ?>
                            <p class="com-card-text"><?= nl2br(e(mb_strimwidth((string)$it->itm_descripcion, 0, 140, '...'))) ?></p>
                        <?php endif; ?>

                        <?php if ($url !== '#'): ?>
                            <a href="<?= e(safe_url($url)) ?>"
                               class="com-card-btn"
                               target="<?= e(safe_target($it->itm_target ?? '_blank')) ?>"
                               rel="noopener">
                                <span>Conocer más</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php
        endforeach;
        echo '</div>';
    }
}

/**
 * ============================================================
 * LINKS
 * ============================================================
 */
if (!function_exists('render_links')) {
    function render_links($sec, $items) {
        render_com_styles_once();

        if (empty($items)) {
            echo '<p class="text-muted text-center">No hay enlaces configurados.</p>';
            return;
        }
        ?>
        <div class="com-links-list">
            <?php foreach ($items as $it):
                $url = !empty($it->itm_url) ? $it->itm_url : '#';
                ?>
                <a href="<?= e(safe_url($url)) ?>"
                   class="com-link-item"
                   target="<?= e(safe_target($it->itm_target ?? '_blank')) ?>"
                   rel="noopener">
                    <div class="link-content">
                        <div class="link-title"><?= e($it->itm_titulo ?? '') ?></div>
                        <?php if (!empty($it->itm_descripcion)): ?>
                            <div class="link-desc"><?= e($it->itm_descripcion) ?></div>
                        <?php endif; ?>
                    </div>
                    <span class="link-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
            <?php endforeach; ?>
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
        render_com_styles_once();

        $embed = $sec->sec_video_url ?? '';
        if (empty($embed)) {
            echo '<p class="text-muted text-center">Video no configurado.</p>';
            return;
        }

        if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $embed, $matches)) {
            $embed = 'https://www.youtube.com/embed/' . $matches[1];
        } elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $embed, $matches)) {
            $embed = 'https://www.youtube.com/embed/' . $matches[1];
        } elseif (preg_match('/vimeo\.com\/(\d+)/', $embed, $matches)) {
            $embed = 'https://player.vimeo.com/video/' . $matches[1];
        }
        ?>
        <div class="com-video-wrapper">
            <iframe src="<?= e($embed) ?>" allow="autoplay; encrypted-media" allowfullscreen loading="lazy"></iframe>
        </div>
        <?php
    }
}

/**
 * ============================================================
 * CALENDAR IFRAME
 * ============================================================
 */
if (!function_exists('render_calendar')) {
    function render_calendar($sec) {
        render_com_styles_once();

        $src = $sec->sec_iframe_src ?? '';
        if (empty($src)) {
            echo '<p class="text-muted text-center">Calendario no configurado.</p>';
            return;
        }
        ?>
        <div class="com-calendar-container">
            <div class="com-calendar-header">
                <h3>Calendario de eventos</h3>
            </div>
            <div class="com-video-wrapper">
                <iframe src="<?= e($src) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
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
    function render_schedule($sec, $items = []) {
        render_com_styles_once();

        $mes = (int)($GLOBALS['mes_agenda'] ?? date('n'));
        $anio = (int)($GLOBALS['anio_agenda'] ?? date('Y'));
        $eventosPorDia = normalize_eventos_por_dia($GLOBALS['eventosPorDia'] ?? []);
        $slug = $GLOBALS['slug'] ?? 'inicio';

        $mesAnterior = $mes - 1;
        $anioAnterior = $anio;
        if ($mesAnterior < 1) {
            $mesAnterior = 12;
            $anioAnterior--;
        }

        $mesSiguiente = $mes + 1;
        $anioSiguiente = $anio;
        if ($mesSiguiente > 12) {
            $mesSiguiente = 1;
            $anioSiguiente++;
        }
        ?>
        <div class="com-schedule-container">
            <div class="com-schedule-header">
                <h3><?= !empty($sec->sec_titulo) ? e($sec->sec_titulo) : 'Agenda de eventos' ?></h3>

                <div class="com-schedule-nav">
                    <a href="?uri=comunicaciones/ver/<?= e($slug) ?>&m=<?= $mesAnterior ?>&y=<?= $anioAnterior ?>"
                       class="btn btn-outline-primary">
                        <i class="fas fa-chevron-left me-2"></i>Anterior
                    </a>

                    <a href="?uri=comunicaciones/ver/<?= e($slug) ?>&m=<?= date('n') ?>&y=<?= date('Y') ?>"
                       class="btn btn-outline-secondary">
                        <i class="fas fa-calendar-day me-2"></i>Hoy
                    </a>

                    <a href="?uri=comunicaciones/ver/<?= e($slug) ?>&m=<?= $mesSiguiente ?>&y=<?= $anioSiguiente ?>"
                       class="btn btn-outline-primary">
                        Siguiente<i class="fas fa-chevron-right ms-2"></i>
                    </a>
                </div>
            </div>

            <?php if (!empty($sec->sec_descripcion)): ?>
                <p class="text-muted mb-4"><?= nl2br(e($sec->sec_descripcion)) ?></p>
            <?php endif; ?>

            <?php if (empty($eventosPorDia)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-4x mb-3" style="color: var(--iq-gray);"></i>
                    <h4 class="text-muted">No hay eventos programados para este mes</h4>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="com-schedule-table">
                        <thead>
                            <tr>
                                <th>Fecha y Hora</th>
                                <th>Evento</th>
                                <th>Enlace</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($eventosPorDia as $dia => $lista): ?>
                                <?php foreach ($lista as $ev): ?>
                                    <?php
                                    $fecha = $ev['event_date'] ?? '';
                                    $title = $ev['title'] ?? 'Sin título';
                                    $desc = $ev['description'] ?? '';
                                    $loc = $ev['location'] ?? '';
                                    $url = $ev['meet_url'] ?? '';
                                    $allDay = (int)($ev['is_all_day'] ?? 0) === 1;

                                    $start = isset($ev['start_time']) ? substr((string)$ev['start_time'], 0, 5) : '';
                                    $end = isset($ev['end_time']) ? substr((string)$ev['end_time'], 0, 5) : '';

                                    $horaTxt = $allDay ? 'Todo el día' : trim($start . ($end ? ' - ' . $end : ''));
                                    $fechaFormateada = $fecha ? date('d/m/Y', strtotime($fecha)) : '';
                                    ?>
                                    <tr>
                                        <td data-label="Fecha y Hora">
                                            <span class="event-time"><?= e($fechaFormateada) ?></span>
                                            <small class="d-block text-muted"><?= e($horaTxt ?: 'Sin hora') ?></small>
                                        </td>
                                        <td data-label="Evento">
                                            <div class="event-title"><?= e($title) ?></div>

                                            <?php if ($loc): ?>
                                                <div class="event-location">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <span><?= e($loc) ?></span>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($desc): ?>
                                                <div class="event-desc"><?= nl2br(e(mb_strimwidth((string)$desc, 0, 180, '...'))) ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td data-label="Enlace">
                                            <?php if ($url && $url !== '#!' && $url !== '#'): ?>
                                                <a href="<?= e(safe_url($url)) ?>" target="_blank" rel="noopener" class="btn-event">
                                                    <i class="fas fa-video"></i>
                                                    <span>Unirse</span>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Sin enlace</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}

/**
 * ============================================================
 * CTA
 * ============================================================
 */
if (!function_exists('render_cta')) {
    function render_cta($sec) {
        render_com_styles_once();

        $btnText = $sec->sec_boton_texto ?? 'Contáctanos';
        $btnUrl = $sec->sec_boton_url ?? '#';
        ?>
        <div class="com-cta-section">
            <div class="com-cta-content">
                <?php if (!empty($sec->sec_titulo)): ?>
                    <h3><?= e($sec->sec_titulo) ?></h3>
                <?php endif; ?>

                <?php if (!empty($sec->sec_descripcion)): ?>
                    <p><?= nl2br(e($sec->sec_descripcion)) ?></p>
                <?php endif; ?>

                <?php if ($btnUrl !== '#'): ?>
                    <a href="<?= e(safe_url($btnUrl)) ?>" class="btn" target="_blank" rel="noopener">
                        <span><?= e($btnText) ?></span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                <?php endif; ?>
            </div>
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
            render_cards($sec, $items);
            return;
        }

        echo '<p class="text-muted text-center">Sin contenido.</p>';
    }
}

/**
 * ============================================================
 * RENDER PRINCIPAL
 * ============================================================
 */
if (!function_exists('render_section')) {
    function render_section($sec, $itemsBySeccion) {
        $secId = (int)($sec->sec_id ?? 0);
        $items = items_for_section($itemsBySeccion, $secId);
        $tipo = strtoupper((string)($sec->sec_tipo ?? ''));
        $layout = $sec->sec_layout ?? 'CONTAINER';

        echo render_container_open($layout);
        echo render_section_inner_open($layout);

        if ($tipo !== 'SCHEDULE') {
            render_section_header($sec);
        }

        switch ($tipo) {
            case 'CAROUSEL':
                render_carousel($sec, $items);
                break;
            case 'CARDS':
            case 'GRID':
                render_cards($sec, $items);
                break;
            case 'LINKS':
                render_links($sec, $items);
                break;
            case 'VIDEO':
                render_video($sec);
                break;
            case 'CALENDAR':
                render_calendar($sec);
                break;
            case 'SCHEDULE':
                render_schedule($sec, $items);
                break;
            case 'CTA':
                render_cta($sec);
                break;
            case 'TEXT':
            default:
                render_text($sec, $items);
                break;
        }

        echo render_section_inner_close($layout);
        echo render_container_close();
    }
}
?>