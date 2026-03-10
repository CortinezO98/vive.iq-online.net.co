<!-- ==============>>header section start here<<================ -->
<div class="header">
    <div class="navbar-custom navbar navbar-expand-lg" id="bienvenida">
        <div class="container-fluid px-0">
            <a class="navbar-brand d-block d-md-none p-0" href="<?php echo URL; ?>">
                <img src="<?php echo IMAGES; ?><?php echo LOGO_MENU; ?>" class="img-fluid">
            </a>

            <a id="nav-toggle" href="#!" class="ms-auto ms-md-0 me-0 me-lg-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-text-indent-left text-muted" viewBox="0 0 16 16">
                    <path d="M2 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm.646 2.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L4.293 8 2.646 6.354a.5.5 0 0 1 0-.708zM7 6.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </a>

            <ul class="navbar-nav navbar-right-wrap ms-lg-auto d-flex nav-top-wrap align-items-center ms-4 ms-lg-0">
                <li>
                    <a class="btn btn-ghost btn-icon rounded-circle" id="ayuda" onclick="help(true);" role="button">
                        <span class="fas fa-circle-question"></span>
                    </a>
                </li>

                <li class="dropdown stopevent ms-2">
                    <a class="btn btn-ghost btn-icon rounded-circle" href="#!" role="button" id="dropdownNotification"
                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fas fa-bell"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end" aria-labelledby="dropdownNotification">
                        <div>
                            <div class="border-bottom px-3 pt-2 pb-3 d-flex justify-content-between align-items-center">
                                <p class="mb-0 text-dark fw-medium fs-4">Notificaciones</p>
                            </div>

                            <div data-simplebar style="height: 250px;">
                                <ul class="list-group list-group-flush notification-list-scroll"></ul>
                            </div>
                            <div class="border-top px-3 py-2 text-center">
                                <a href="#!" class="text-inherit">Ver todo</a>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="dropdown ms-2">
                    <a class="rounded-circle" href="#!" role="button" id="dropdownUser" data-bs-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <div class="avatar avatar-md avatar-indicators avatar-online">
                            <img alt="avatar" src="<?php echo IMAGES; ?><?php echo ($_SESSION[APP_SESSION.'usu_avatar']!="") ? $_SESSION[APP_SESSION.'usu_avatar'] : ''; ?>" class="rounded-circle">
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                        <div class="px-4 pb-0 pt-2">
                            <div class="lh-1">
                                <h5 class="mb-1"><?php echo $_SESSION[APP_SESSION.'usu_nombre']; ?></h5>
                            </div>
                            <div class="dropdown-divider mt-3 mb-2"></div>
                        </div>
                        <ul class="list-unstyled">
                            <li>
                                <a class="dropdown-item" href="<?php echo URL; ?>logout">
                                    <i class="me-2 icon-xxs dropdown-item-icon" data-feather="power"></i>Cerrar sesión
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>

        </div>
    </div>
</div>

<div class="navbar-vertical navbar nav-dashboard">
    <div class="h-100" data-simplebar>
        <a class="navbar-brand border-bottom py-0" href="<?php echo URL; ?>login">
            <div class="row py-0">
                <div class="col-md-12 text-center d-none d-md-block py-1">
                    <img src="<?php echo IMAGES; ?><?php echo LOGO_MENU; ?>" class="img-fluid">
                </div>
            </div>
        </a>

        <ul class="navbar-nav flex-column pt-3 mt-11 mt-md-0" id="sideNavbar">

            <li class="nav-item">
                <a class="nav-link has-arrow" href="<?php echo URL; ?>inicio">
                    <i class="fa-solid fa-home nav-icon me-2 icon-xxs"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <div class="navbar-heading">Documentación</div>
            </li>

            <li class="nav-item">
                <a class="nav-link has-arrow" href="#!" data-bs-toggle="collapse" data-bs-target="#navDocsManual"
                   aria-expanded="false" aria-controls="navDocsManual">
                    <i class="fas fa-book nav-icon me-2 icon-xxs"></i> Manual de Usuario
                </a>
                <div id="navDocsManual" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a href="<?php echo URL; ?>ayuda/login" class="nav-link">Login</a></li>
                        <li class="nav-item"><a href="<?php echo URL; ?>ayuda/navegacion" class="nav-link">Navegación</a></li>
                        <li class="nav-item"><a href="<?php echo URL; ?>ayuda/hoja-vida" class="nav-link">Hoja de Vida</a></li>
                        <li class="nav-item"><a href="<?php echo URL; ?>ayuda/aspirantes" class="nav-link">Aspirantes</a></li>
                        <li class="nav-item"><a href="<?php echo URL; ?>ayuda/encuestas" class="nav-link">Encuestas</a></li>
                        <li class="nav-item"><a href="<?php echo URL; ?>ayuda/administrador" class="nav-link">Administrador</a></li>
                    </ul>
                </div>
            </li>

            <?php
            $puedeVerComunicaciones = isset($_SESSION[APP_SESSION.'usu_id']);
            $perfil = $_SESSION[APP_SESSION.'usu_perfil'] ?? '';
            $puedeAdminComunicaciones = in_array($perfil, ['ADMIN','Administrador','SUPERADMIN'], true);
            ?>

            <?php if ($puedeVerComunicaciones): ?>
            <li class="nav-item mt-2">
                <a class="nav-link has-arrow" href="#!"
                   data-bs-toggle="collapse" data-bs-target="#navComunicaciones"
                   aria-expanded="false" aria-controls="navComunicaciones">
                    <i class="fa-solid fa-bullhorn nav-icon me-2 icon-xxs"></i> Comunicaciones
                </a>

                <div id="navComunicaciones" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL; ?>?uri=comunicaciones/ver/inicio">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL; ?>?uri=comunicaciones/ver/identidad-corporativa">Identidad corporativa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL; ?>?uri=comunicaciones/ver/contacto">Contacto</a>
                        </li>

                        <li class="nav-item mt-2"><div class="navbar-heading">Sobre iQ</div></li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL; ?>?uri=comunicaciones/ver/compania">Compañía</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL; ?>?uri=comunicaciones/ver/cultura-iq">Cultura iQ</a>
                        </li>

                        <li class="nav-item mt-2"><div class="navbar-heading">Lo que necesitas</div></li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL; ?>?uri=comunicaciones/ver/bienestar-formacion">Bienestar y formación</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL; ?>?uri=comunicaciones/ver/atraccion-personal">Atracción de personal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL; ?>?uri=comunicaciones/ver/sst">SST</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL; ?>?uri=comunicaciones/ver/compensacion-beneficios">Compensación y beneficios</a>
                        </li>

                        <?php if ($puedeAdminComunicaciones): ?>
                        <li class="nav-item mt-3"><div class="navbar-heading">Administración</div></li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL; ?>?uri=comunicaciones/admin_paginas">
                                <i class="fa-solid fa-gear nav-icon me-2 icon-xxs"></i> Administrar páginas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL; ?>?uri=reporte_clics">
                                <i class="fa-solid fa-chart-line nav-icon me-2 icon-xxs"></i> Reporte de clics
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link js-track-click"
                               href="<?php echo URL; ?>?uri=analytics/index"
                               data-click-tipo="menu"
                               data-click-clave="analytics_general"
                               data-click-label="Analytics General"
                               data-click-modulo="reportes"
                               data-seccion="menu_lateral"
                               data-contexto="acceso_dashboard_analytics"
                               data-posicion="3">
                                <i class="fa-solid fa-chart-pie nav-icon me-2 icon-xxs"></i> Analytics General
                            </a>
                        </li>
                        <?php endif; ?>

                    </ul>
                </div>
            </li>
            <?php endif; ?>

        </ul>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    function construirDomPath(element) {
        if (!element) return '';

        const path = [];
        let current = element;

        while (current && current.nodeType === 1 && current.tagName.toLowerCase() !== 'html') {
            let selector = current.tagName.toLowerCase();

            if (current.id) {
                selector += '#' + current.id;
                path.unshift(selector);
                break;
            }

            if (typeof current.className === 'string' && current.className.trim() !== '') {
                const classes = current.className.trim().split(/\s+/).slice(0, 3).join('.');
                if (classes) {
                    selector += '.' + classes;
                }
            }

            path.unshift(selector);
            current = current.parentElement;
        }

        return path.join(' > ');
    }

    function obtenerPageSlug() {
        try {
            const url = new URL(window.location.href);
            return url.searchParams.get('uri') || window.location.pathname || '';
        } catch (e) {
            return window.location.pathname || '';
        }
    }

    function limpiarTexto(texto) {
        return String(texto || '')
            .replace(/\s+/g, ' ')
            .trim();
    }

    function slugify(valor) {
        return limpiarTexto(valor)
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]+/g, '_')
            .replace(/^_+|_+$/g, '')
            .substring(0, 150);
    }

    function detectarElementoTrackeable(target) {
        if (!target) return null;

        return target.closest(
            '.js-track-click, a[href], button, [role="button"], [data-url], [onclick]'
        );
    }

    function inferirTipo(element) {
        const tag = (element.tagName || '').toLowerCase();
        const href = element.getAttribute('href') || '';
        const role = (element.getAttribute('role') || '').toLowerCase();

        if (element.classList.contains('js-track-click') && element.getAttribute('data-click-tipo')) {
            return element.getAttribute('data-click-tipo');
        }

        if (tag === 'a') {
            if (href.startsWith('mailto:')) return 'email';
            if (href.startsWith('tel:')) return 'telefono';
            if (href === '#!' || href === '#') return 'accion';
            return 'link';
        }

        if (tag === 'button') {
            return 'boton';
        }

        if (role === 'button') {
            return 'boton';
        }

        if (element.hasAttribute('data-url')) {
            return 'card';
        }

        return 'elemento';
    }

    function inferirModulo(element) {
        const moduloManual = element.getAttribute('data-click-modulo');
        if (moduloManual) {
            return moduloManual;
        }

        const slug = obtenerPageSlug();
        if (!slug) {
            return 'general';
        }

        return slug.substring(0, 100);
    }

    function inferirSeccion(element) {
        const seccionManual = element.getAttribute('data-seccion');
        if (seccionManual) {
            return seccionManual;
        }

        const contenedor = element.closest('[id], section, .card, .navbar, .dropdown-menu, .modal, .table-responsive, .container, .container-fluid');
        if (!contenedor) {
            return '';
        }

        if (contenedor.id) {
            return limpiarTexto(contenedor.id).substring(0, 255);
        }

        const clases = typeof contenedor.className === 'string' ? limpiarTexto(contenedor.className) : '';
        return clases.substring(0, 255);
    }

    function inferirContexto(element) {
        const contextoManual = element.getAttribute('data-contexto');
        if (contextoManual) {
            return contextoManual;
        }

        const tag = (element.tagName || '').toLowerCase();
        const tipo = inferirTipo(element);
        return (tag + '_' + tipo).substring(0, 255);
    }

    function inferirPosicion(element) {
        const posicionManual = element.getAttribute('data-posicion');
        if (posicionManual !== null && posicionManual !== '') {
            return posicionManual;
        }

        if (!element.parentElement) {
            return '';
        }

        const hermanos = Array.from(element.parentElement.children).filter(function(child) {
            return child.tagName === element.tagName;
        });

        const index = hermanos.indexOf(element);
        return index >= 0 ? String(index + 1) : '';
    }

    function autocompletarTracking(element) {
        const href = element.getAttribute('href') || element.getAttribute('data-url') || '';
        const texto = limpiarTexto(element.innerText || element.textContent || '');
        const tipo = inferirTipo(element);
        const modulo = inferirModulo(element);
        const seccion = inferirSeccion(element);
        const contexto = inferirContexto(element);
        const posicion = inferirPosicion(element);

        if (!element.getAttribute('data-click-tipo')) {
            element.setAttribute('data-click-tipo', tipo);
        }

        if (!element.getAttribute('data-click-label')) {
            element.setAttribute('data-click-label', (texto || href || tipo || 'Elemento').substring(0, 250));
        }

        if (!element.getAttribute('data-click-clave')) {
            const baseClave = texto || href || contexto || tipo || 'elemento_auto';
            element.setAttribute('data-click-clave', slugify(baseClave) || 'elemento_auto');
        }

        if (!element.getAttribute('data-click-modulo')) {
            element.setAttribute('data-click-modulo', modulo);
        }

        if (!element.getAttribute('data-seccion') && seccion) {
            element.setAttribute('data-seccion', seccion);
        }

        if (!element.getAttribute('data-contexto') && contexto) {
            element.setAttribute('data-contexto', contexto);
        }

        if (!element.getAttribute('data-posicion') && posicion) {
            element.setAttribute('data-posicion', posicion);
        }
    }

    function debeInterceptarNavegacion(element) {
        if (!element) return false;

        const tag = (element.tagName || '').toLowerCase();
        const href = element.getAttribute('href') || '';
        const target = (element.getAttribute('target') || '').toLowerCase();
        const download = element.hasAttribute('download');

        if (tag !== 'a') {
            return false;
        }

        if (!href || href === '#' || href === '#!') {
            return false;
        }

        if (target === '_blank' || download) {
            return false;
        }

        if (href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) {
            return false;
        }

        return true;
    }

    window.registrarClick = function(element, originalEvent = null) {
        const tipo = element.getAttribute('data-click-tipo') || 'elemento';
        const clave = element.getAttribute('data-click-clave') || '';
        const label = element.getAttribute('data-click-label') || limpiarTexto(element.textContent) || 'sin_etiqueta';
        const modulo = element.getAttribute('data-click-modulo') || '';
        const destino = element.getAttribute('href') || element.getAttribute('data-url') || '';
        const entidadId = element.getAttribute('data-entidad-id') || '';
        const entidadTipo = element.getAttribute('data-entidad-tipo') || '';
        const seccionNombre = element.getAttribute('data-seccion') || '';
        const clickContexto = element.getAttribute('data-contexto') || '';
        const clickPosicion = element.getAttribute('data-posicion') || '';

        if (!clave) {
            return true;
        }

        const rect = element.getBoundingClientRect();

        let clickX = Math.round(rect.left + (rect.width / 2));
        let clickY = Math.round(rect.top + (rect.height / 2));

        if (originalEvent && typeof originalEvent.clientX === 'number' && typeof originalEvent.clientY === 'number') {
            clickX = Math.round(originalEvent.clientX);
            clickY = Math.round(originalEvent.clientY);
        }

        const payload = {
            click_tipo: tipo,
            click_clave: clave,
            click_label: label.substring(0, 250),
            click_modulo: modulo,
            click_url_destino: destino,
            entidad_id: entidadId,
            entidad_tipo: entidadTipo,

            click_dom_path: construirDomPath(element).substring(0, 1000),
            click_texto_visible: limpiarTexto(element.innerText || element.textContent || '').substring(0, 500),
            click_x: clickX,
            click_y: clickY,
            viewport_w: window.innerWidth || document.documentElement.clientWidth || 0,
            viewport_h: window.innerHeight || document.documentElement.clientHeight || 0,
            page_url: window.location.href.substring(0, 1000),
            page_slug: obtenerPageSlug().substring(0, 255),
            seccion_nombre: seccionNombre.substring(0, 255),
            click_contexto: clickContexto.substring(0, 255),
            click_posicion: clickPosicion
        };

        fetch('<?php echo URL; ?>?uri=analytics/registrar_click', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams(payload),
            credentials: 'same-origin',
            keepalive: true
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            console.log('Respuesta tracking:', data);
        })
        .catch(function(error) {
            console.error('Error enviando tracking:', error);
        });

        return true;
    };

    document.addEventListener('click', function(e) {
        const element = detectarElementoTrackeable(e.target);
        if (!element) return;

        autocompletarTracking(element);

        if (debeInterceptarNavegacion(element)) {
            const href = element.getAttribute('href');

            e.preventDefault();
            window.registrarClick(element, e);

            setTimeout(function() {
                window.location.href = href;
            }, 100);

            return;
        }

        window.registrarClick(element, e);
    }, true);
});
</script>
<!-- ==============>>header section end here<<================ -->