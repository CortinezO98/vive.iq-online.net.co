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
        if (is_object($eventosPorDia)) {
            $eventosPorDia = get_object_vars($eventosPorDia);
        }

        if (!is_array($eventosPorDia)) {
            return [];
        }

        $result = [];

        foreach ($eventosPorDia as $key => $lista) {
            if (is_object($lista)) {
                $lista = get_object_vars($lista);
            }

            if (!is_array($lista)) {
                continue;
            }

            $fechaKey = null;
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', (string)$key)) {
                $fechaKey = (string)$key;
            }

            foreach ($lista as $ev) {
                if (is_object($ev)) {
                    $ev = get_object_vars($ev);
                }

                if (!is_array($ev)) {
                    continue;
                }

                $fecha = $ev['event_date'] ?? $fechaKey;
                if (!$fecha) {
                    continue;
                }

                $ts = strtotime((string)$fecha);
                if ($ts === false) {
                    continue;
                }

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
                align-items: center;
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
                grid-template-columns: repeat(7, minmax(0, 1fr));
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
                min-height: 145px;
                border: 2px solid transparent;
                transition: var(--iq-transition);
                position: relative;
                overflow: hidden;
                cursor: pointer;
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
                gap: 0.4rem;
            }

            .com-calendar-events {
                display: flex;
                flex-direction: column;
                gap: 0.3rem;
                pointer-events: none;
            }

            .com-calendar-event {
                background: #FFFFFF;
                border-left: 4px solid var(--iq-primary);
                border-radius: 8px;
                padding: 0.35rem 0.5rem;
                font-size: 0.78rem;
                transition: var(--iq-transition);
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
                overflow: hidden;
                cursor: pointer;
                pointer-events: auto;
            }

            .com-calendar-event:hover {
                transform: translateX(3px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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

            .add-event-btn {
                width: 26px;
                height: 26px;
                border: none;
                border-radius: 50%;
                background: var(--iq-primary);
                color: #fff;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: var(--iq-transition);
                padding: 0;
                flex: 0 0 auto;
                pointer-events: auto;
            }

            .add-event-btn:hover {
                background: var(--iq-secondary);
                transform: scale(1.08);
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
                .com-calendar-day {
                    min-height: 120px;
                }
            }

            @media (max-width: 768px) {
                .com-header-content h1 { font-size: 2.2rem; }
                .com-header-content .lead { font-size: 1rem; }
                .com-section { padding: 2.4rem 0; }

                .com-calendar-day {
                    min-height: 95px;
                    padding: 0.5rem;
                }

                .com-calendar-weekday {
                    font-size: 0.74rem;
                    padding: 0.55rem;
                }

                .com-calendar-event {
                    padding: 0.25rem 0.35rem;
                    font-size: 0.7rem;
                }

                .com-schedule-nav,
                .com-calendar-nav {
                    width: 100%;
                }
            }

            @media (max-width: 576px) {
                .com-section { padding: 2rem 0; }
                .com-card-body { padding: 1rem; }
                .com-card-img-wrapper {
                    min-height: 160px;
                    max-height: 180px;
                }
                .com-calendar-weekday {
                    display: block;
                    font-size: 0.68rem;
                    padding: 0.45rem 0.2rem;
                }
                .com-calendar-day {
                    min-height: 88px;
                }
                .com-calendar-event {
                    font-size: 0.66rem;
                }
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
 * SCHEDULE (PARRILLA MENSUAL)
 * ============================================================
 */
if (!function_exists('render_schedule')) {
    function render_schedule($sec, $items = []) {
        render_com_styles_once();

        $mes = (int)($GLOBALS['mes_agenda'] ?? date('n'));
        $anio = (int)($GLOBALS['anio_agenda'] ?? date('Y'));
        $eventosPorDia = normalize_eventos_por_dia($GLOBALS['eventosPorDia'] ?? []);
        $slug = $GLOBALS['slug'] ?? 'inicio';
        $puedeEditar = is_admin_comunicaciones();

        $mesesNombre = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];

        $diasSemana = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];

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

        $primerDia = new DateTimeImmutable(sprintf('%04d-%02d-01', $anio, $mes));
        $inicioSemana = (int)$primerDia->format('N');
        $fechaInicioGrid = $primerDia->modify('-' . ($inicioSemana - 1) . ' days');
        ?>
        <div class="com-schedule-container">
            <div class="com-schedule-header">
                <div>
                    <h3><?= !empty($sec->sec_titulo) ? e($sec->sec_titulo) : 'Agenda de eventos' ?></h3>
                    <small class="text-muted d-block mt-1"><?= e($mesesNombre[$mes] ?? 'Mes') ?> <?= (int)$anio ?></small>
                </div>

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

                    <?php if ($puedeEditar): ?>
                        <button type="button"
                                class="btn btn-primary"
                                onclick="abrirFormularioEvento('<?= e(date('Y-m-d')) ?>')">
                            <i class="fas fa-plus me-2"></i>Agregar evento
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($sec->sec_descripcion)): ?>
                <p class="text-muted mb-4"><?= nl2br(e($sec->sec_descripcion)) ?></p>
            <?php endif; ?>

            <div class="com-calendar-grid">
                <?php foreach ($diasSemana as $dia): ?>
                    <div class="com-calendar-weekday"><?= e($dia) ?></div>
                <?php endforeach; ?>

                <?php
                $fecha = $fechaInicioGrid;

                for ($i = 0; $i < 42; $i++):
                    $fechaKey = $fecha->format('Y-m-d');
                    $esMesActual = ((int)$fecha->format('n') === $mes && (int)$fecha->format('Y') === $anio);
                    $esHoy = ($fechaKey === date('Y-m-d'));
                    $eventosDia = $eventosPorDia[$fechaKey] ?? [];

                    $clase = 'com-calendar-day';
                    if (!$esMesActual) $clase .= ' other-month';
                    if ($esHoy) $clase .= ' today';
                    ?>
                    <div class="<?= e($clase) ?>" 
                         data-fecha="<?= e($fechaKey) ?>"
                         onclick="verEventosDelDia('<?= e($fechaKey) ?>')">
                        <div class="com-calendar-day-number">
                            <span><?= (int)$fecha->format('d') ?></span>

                            <?php if ($puedeEditar && $esMesActual): ?>
                                <button type="button"
                                        class="add-event-btn"
                                        onclick="event.stopPropagation(); abrirFormularioEvento('<?= e($fechaKey) ?>')"
                                        title="Agregar evento">
                                    <i class="fas fa-plus"></i>
                                </button>
                            <?php endif; ?>
                        </div>

                        <div class="com-calendar-events" onclick="event.stopPropagation();">
                            <?php if (!empty($eventosDia)): ?>
                                <?php foreach (array_slice($eventosDia, 0, 3) as $ev): ?>
                                    <?php
                                    $titulo = $ev['title'] ?? 'Evento';
                                    $desc = $ev['description'] ?? '';
                                    $allDay = (int)($ev['is_all_day'] ?? 0) === 1;
                                    $color = $ev['color'] ?? '#1C2262';
                                    $hora = $allDay ? 'Todo el día' : (!empty($ev['start_time']) ? substr((string)$ev['start_time'], 0, 5) : 'Sin hora');
                                    ?>
                                    <div class="com-calendar-event <?= $allDay ? 'all-day' : '' ?>"
                                         style="border-left-color: <?= e($color) ?>;"
                                         data-evento='<?= htmlspecialchars(json_encode($ev, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8') ?>'
                                         onclick='event.stopPropagation(); verEvento(<?= htmlspecialchars(json_encode($ev, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8') ?>)'
                                         title="<?= e($titulo . ($desc ? ' - ' . $desc : '')) ?>">
                                        <div class="event-time"><?= e($hora) ?></div>
                                        <div class="event-title"><?= e($titulo) ?></div>
                                    </div>
                                <?php endforeach; ?>

                                <?php if (count($eventosDia) > 3): ?>
                                    <small class="text-muted">+<?= count($eventosDia) - 3 ?> más</small>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="no-events" style="height: 20px;"></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                    $fecha = $fecha->modify('+1 day');
                endfor;
                ?>
            </div>
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

/**
 * ============================================================
 * MODALES PARA EVENTOS DEL CALENDARIO
 * ============================================================
 */
if (!function_exists('render_event_modals')) {
    function render_event_modals() {
        static $modalsRendered = false;
        if ($modalsRendered) return;
        $modalsRendered = true;
        
        $perfil = strtoupper(trim((string)($_SESSION[APP_SESSION.'usu_perfil'] ?? '')));
        $puedeEditar = in_array($perfil, ['ADMIN','ADMINISTRADOR','SUPERADMIN'], true);
        
        // Token CSRF
        if (empty($_SESSION['iqvive_token'])) {
            $_SESSION['iqvive_token'] = bin2hex(random_bytes(32));
        }
        $csrfToken = (string)($_SESSION['iqvive_token'] ?? '');
        ?>
        
        <!-- Modal de eventos del día -->
        <div class="modal fade event-modal" id="eventosDiaModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-white"><i class="fas fa-calendar-day me-2"></i>Eventos del día <span id="fechaEventosDia"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="eventosDiaModalBody">
                        <div class="text-center text-muted">
                            <i class="fas fa-spinner fa-spin me-2"></i>Cargando eventos...
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <?php if ($puedeEditar): ?>
                            <button type="button" class="btn btn-primary" id="btnAgregarEventoDesdeDia">
                                <i class="fas fa-plus me-2"></i>Agregar evento
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de detalle de evento -->
        <div class="modal fade event-modal" id="eventoModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-white"><i class="fas fa-calendar-check me-2"></i>Detalle del evento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="eventoModalBody">
                        <div class="text-center text-muted">
                            <i class="fas fa-spinner fa-spin me-2"></i>Cargando...
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <?php if ($puedeEditar): ?>
                            <button type="button" class="btn btn-outline-danger" onclick="eliminarEvento()">
                                <i class="fas fa-trash me-1"></i>Eliminar
                            </button>
                            <button type="button" class="btn btn-primary" onclick="editarEvento()">
                                <i class="fas fa-pen me-1"></i>Editar
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de formulario de evento -->
        <div class="modal fade event-modal" id="eventoFormModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-white" id="eventoFormTitle">
                            <i class="fas fa-plus-circle me-2"></i>Nuevo evento
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form id="eventoForm">
                        <div class="modal-body">
                            <input type="hidden" name="id" id="eventoId" value="0">
                            <input type="hidden" name="token" value="<?= htmlspecialchars($csrfToken) ?>">

                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold">Título <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" id="eventoTitulo" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Color</label>
                                    <select class="form-select" name="color" id="eventoColor">
                                        <option value="#1C2262">Azul</option>
                                        <option value="#09A28E">Verde</option>
                                        <option value="#dc3545">Rojo</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Fecha <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="event_date" id="eventoFecha" required>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Hora inicio</label>
                                    <input type="time" class="form-control" name="start_time" id="eventoHoraInicio">
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Hora fin</label>
                                    <input type="time" class="form-control" name="end_time" id="eventoHoraFin">
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_all_day" id="eventoAllDay" value="1">
                                        <label class="form-check-label" for="eventoAllDay">Todo el día</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Ubicación</label>
                                    <input type="text" class="form-control" name="location" id="eventoLocation">
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Enlace (Meet/Teams/Zoom)</label>
                                    <input type="url" class="form-control" name="meet_url" id="eventoMeetUrl" placeholder="https://...">
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Descripción</label>
                                    <textarea class="form-control" name="description" id="eventoDescripcion" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar evento</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <style>
        /* Estilos para los modales de eventos */
        .event-modal .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .event-modal .modal-header {
            background: #1C2262;
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 1.5rem;
        }

        .event-modal .btn-close {
            filter: brightness(0) invert(1);
        }

        .event-detail-label {
            font-weight: 600;
            color: #1C2262;
            margin-bottom: 0.25rem;
        }

        .event-detail-value {
            background: #f8f9fa;
            padding: 0.75rem;
            border-radius: 12px;
            margin-bottom: 1rem;
        }

        .loading-spinner {
            text-align: center;
            padding: 3rem;
        }

        .loading-spinner .spinner-border {
            width: 3rem;
            height: 3rem;
            color: #1C2262;
        }
        
        /* Estilos para la lista de eventos en el modal del día */
        .evento-dia-item {
            background: #f8f9fa;
            border-left: 4px solid #1C2262;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .evento-dia-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            background: #ffffff;
        }
        
        .evento-dia-item.all-day {
            border-left-color: #09A28E;
        }
        
        .evento-dia-titulo {
            font-weight: 700;
            color: #1C2262;
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
        }
        
        .evento-dia-hora {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }
        
        .evento-dia-descripcion {
            color: #495057;
            font-size: 0.95rem;
            line-height: 1.4;
        }
        
        .evento-dia-enlace {
            margin-top: 0.5rem;
        }
        
        .evento-dia-enlace a {
            color: #1C2262;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .evento-dia-enlace a:hover {
            text-decoration: underline;
        }
        
        .sin-eventos-dia {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }
        
        .sin-eventos-dia i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        </style>

        <script>
        // Variables globales
        let eventoActual = null;
        let fechaSeleccionada = null;

        // Función para ver eventos del día
        function verEventosDelDia(fecha) {
            fechaSeleccionada = fecha;
            
            // Formatear fecha para mostrar
            const fechaObj = new Date(fecha + 'T12:00:00');
            const opciones = { year: 'numeric', month: 'long', day: 'numeric' };
            const fechaFormateada = fechaObj.toLocaleDateString('es-ES', opciones);
            document.getElementById('fechaEventosDia').textContent = fechaFormateada;
            
            // Obtener eventos del día desde el DOM o desde el servidor
            const eventos = window.eventosPorDiaGlobal ? (window.eventosPorDiaGlobal[fecha] || []) : [];
            
            renderEventosDia(eventos);
            
            // Configurar botón de agregar evento
            const btnAgregar = document.getElementById('btnAgregarEventoDesdeDia');
            if (btnAgregar) {
                btnAgregar.onclick = function() {
                    bootstrap.Modal.getInstance(document.getElementById('eventosDiaModal')).hide();
                    setTimeout(() => {
                        abrirFormularioEvento(fecha);
                    }, 300);
                };
            }
            
            // Abrir modal
            try {
                const modal = new bootstrap.Modal(document.getElementById('eventosDiaModal'));
                modal.show();
            } catch (e) {
                console.error('Error al abrir modal:', e);
            }
        }
        
        // Función para renderizar eventos del día
        function renderEventosDia(eventos) {
            const container = document.getElementById('eventosDiaModalBody');
            
            if (!eventos || eventos.length === 0) {
                container.innerHTML = `
                    <div class="sin-eventos-dia">
                        <i class="fas fa-calendar-times"></i>
                        <h5>No hay eventos para este día</h5>
                        <p class="text-muted">Haz clic en "Agregar evento" para crear uno nuevo.</p>
                    </div>
                `;
                return;
            }
            
            let html = '<div class="eventos-lista">';
            
            eventos.forEach(ev => {
                const allDay = ev.is_all_day == 1;
                const hora = allDay ? 'Todo el día' : (ev.start_time ? ev.start_time.substring(0,5) + (ev.end_time ? ' - ' + ev.end_time.substring(0,5) : '') : 'Sin hora');
                const descripcion = ev.description ? ev.description.substring(0, 150) + (ev.description.length > 150 ? '...' : '') : '';
                
                html += `
                    <div class="evento-dia-item ${allDay ? 'all-day' : ''}" 
                         onclick="verEventoDesdeLista(${JSON.stringify(ev).replace(/"/g, '&quot;')})"
                         style="border-left-color: ${ev.color || '#1C2262'};">
                        <div class="evento-dia-titulo">${ev.title || 'Evento sin título'}</div>
                        <div class="evento-dia-hora"><i class="far fa-clock me-1"></i> ${hora}</div>
                        ${descripcion ? `<div class="evento-dia-descripcion">${descripcion}</div>` : ''}
                        ${ev.location ? `<div class="evento-dia-descripcion"><i class="fas fa-map-marker-alt me-1"></i> ${ev.location}</div>` : ''}
                        ${ev.meet_url ? `
                            <div class="evento-dia-enlace">
                                <a href="${ev.meet_url}" target="_blank" rel="noopener" onclick="event.stopPropagation();">
                                    <i class="fas fa-video me-1"></i> Abrir reunión
                                </a>
                            </div>
                        ` : ''}
                    </div>
                `;
            });
            
            html += '</div>';
            container.innerHTML = html;
        }
        
        // Función para ver evento desde la lista
        function verEventoDesdeLista(evento) {
            bootstrap.Modal.getInstance(document.getElementById('eventosDiaModal')).hide();
            setTimeout(() => {
                verEvento(evento);
            }, 300);
        }

        // Función para abrir formulario de evento (nuevo o editar)
        function abrirFormularioEvento(fecha, evento = null) {
            console.log('Abriendo formulario para fecha:', fecha);

            if (evento) {
                // Modo edición
                document.getElementById('eventoFormTitle').innerHTML = '<i class="fas fa-pen me-2"></i>Editar evento';
                document.getElementById('eventoId').value = evento.id || 0;
                document.getElementById('eventoTitulo').value = evento.title || '';
                document.getElementById('eventoFecha').value = evento.event_date || fecha;
                document.getElementById('eventoHoraInicio').value = evento.start_time || '';
                document.getElementById('eventoHoraFin').value = evento.end_time || '';
                document.getElementById('eventoAllDay').checked = (evento.is_all_day == 1);
                document.getElementById('eventoLocation').value = evento.location || '';
                document.getElementById('eventoMeetUrl').value = evento.meet_url || '';
                document.getElementById('eventoDescripcion').value = evento.description || '';
                document.getElementById('eventoColor').value = evento.color || '#1C2262';
            } else {
                // Modo nuevo
                document.getElementById('eventoFormTitle').innerHTML = '<i class="fas fa-plus-circle me-2"></i>Nuevo evento';
                document.getElementById('eventoId').value = '0';
                document.getElementById('eventoTitulo').value = '';
                document.getElementById('eventoFecha').value = fecha;
                document.getElementById('eventoHoraInicio').value = '';
                document.getElementById('eventoHoraFin').value = '';
                document.getElementById('eventoAllDay').checked = false;
                document.getElementById('eventoLocation').value = '';
                document.getElementById('eventoMeetUrl').value = '';
                document.getElementById('eventoDescripcion').value = '';
                document.getElementById('eventoColor').value = '#1C2262';
            }

            // Habilitar/deshabilitar campos de hora según allDay
            const allDay = document.getElementById('eventoAllDay').checked;
            document.getElementById('eventoHoraInicio').disabled = allDay;
            document.getElementById('eventoHoraFin').disabled = allDay;

            // Abrir modal
            try {
                const modal = new bootstrap.Modal(document.getElementById('eventoFormModal'));
                modal.show();
            } catch (e) {
                console.error('Error al abrir modal:', e);
                alert('Error al abrir el formulario. Verifica que Bootstrap esté cargado.');
            }
        }

        // Función para ver detalle de evento
        function verEvento(evento) {
            if (!evento) return;

            eventoActual = evento;
            console.log('Viendo evento:', evento);

            // Construir HTML del detalle
            let html = '<div class="event-detail">' +
                       '<div class="event-detail-label">Título</div>' +
                       '<div class="event-detail-value">' + (evento.title || '') + '</div>' +
                       '</div>';

            if (evento.description) {
                html += '<div class="event-detail">' +
                        '<div class="event-detail-label">Descripción</div>' +
                        '<div class="event-detail-value">' + (evento.description.replace(/\n/g,'<br>') || '') + '</div>' +
                        '</div>';
            }

            html += '<div class="event-detail">' +
                    '<div class="event-detail-label">Fecha</div>' +
                    '<div class="event-detail-value">' + (evento.event_date || '') + '</div>' +
                    '</div>';

            if (evento.start_time) {
                html += '<div class="event-detail">' +
                        '<div class="event-detail-label">Hora</div>' +
                        '<div class="event-detail-value">' + (evento.start_time || '') + 
                        (evento.end_time ? ' - ' + evento.end_time : '') + '</div>' +
                        '</div>';
            }

            if (evento.location) {
                html += '<div class="event-detail">' +
                        '<div class="event-detail-label">Ubicación</div>' +
                        '<div class="event-detail-value">' + evento.location + '</div>' +
                        '</div>';
            }

            if (evento.meet_url) {
                html += '<div class="event-detail">' +
                        '<div class="event-detail-label">Enlace</div>' +
                        '<div class="event-detail-value">' +
                        '<a href="' + evento.meet_url + '" target="_blank" rel="noopener">' + 
                        evento.meet_url + '</a>' +
                        '</div></div>';
            }

            document.getElementById('eventoModalBody').innerHTML = html;

            try {
                const modal = new bootstrap.Modal(document.getElementById('eventoModal'));
                modal.show();
            } catch (e) {
                console.error('Error al abrir modal:', e);
            }
        }

        // Función para editar evento
        function editarEvento() {
            if (!eventoActual) return;

            // Cerrar modal de detalle
            try {
                bootstrap.Modal.getInstance(document.getElementById('eventoModal')).hide();
            } catch (e) {}

            // Abrir formulario con datos del evento actual
            setTimeout(() => {
                abrirFormularioEvento(eventoActual.event_date, eventoActual);
            }, 300);
        }

        // Función para eliminar evento
        function eliminarEvento() {
            if (!eventoActual) return;
            if (!confirm('¿Estás seguro de eliminar este evento?')) return;

            const params = new URLSearchParams();
            params.append('id', eventoActual.id);
            params.append('token', '<?= htmlspecialchars($csrfToken) ?>');

            fetch('<?= URL ?>?uri=comunicaciones/evento_eliminar_ajax', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: params.toString()
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cerrar modal
                    try {
                        bootstrap.Modal.getInstance(document.getElementById('eventoModal')).hide();
                    } catch (e) {}

                    // Recargar página para mostrar cambios
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'No se pudo eliminar'));
                }
            })
            .catch(err => {
                console.error('Error:', err);
                alert('Error de conexión');
            });
        }

        // Función para guardar evento
        document.addEventListener('DOMContentLoaded', function() {
            const eventoForm = document.getElementById('eventoForm');
            if (eventoForm) {
                eventoForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Mostrar indicador de carga
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Guardando...';
                    submitBtn.disabled = true;

                    const formData = new FormData(this);

                    fetch('<?= URL ?>?uri=comunicaciones/evento_guardar_ajax', {
                        method: 'POST',
                        body: formData
                    })
                    .then(async response => {
                        const text = await response.text();
                        console.log('Respuesta del servidor:', text);

                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            console.error('No es JSON válido:', text);
                            throw new Error('El servidor no devolvió JSON válido');
                        }
                    })
                    .then(data => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;

                        if (data.success) {
                            // Cerrar modal
                            try {
                                bootstrap.Modal.getInstance(document.getElementById('eventoFormModal')).hide();
                            } catch (e) {}

                            // Recargar página para mostrar cambios
                            location.reload();
                        } else {
                            alert('Error: ' + (data.message || 'No se pudo guardar'));
                        }
                    })
                    .catch(err => {
                        console.error('Error:', err);
                        alert('Error al guardar: ' + err.message);
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    });
                });
            }

            // Manejar checkbox "Todo el día"
            const allDayCheckbox = document.getElementById('eventoAllDay');
            if (allDayCheckbox) {
                allDayCheckbox.addEventListener('change', function() {
                    const hi = document.getElementById('eventoHoraInicio');
                    const hf = document.getElementById('eventoHoraFin');

                    if (hi && hf) {
                        hi.disabled = this.checked;
                        hf.disabled = this.checked;

                        if (this.checked) {
                            hi.value = '';
                            hf.value = '';
                        }
                    }
                });
            }
        });
        </script>
        <?php
    }
}
?>