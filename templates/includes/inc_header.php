<!-- ==============>>header section start here<<================ -->
<div class="header">
    <!-- navbar -->
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
            <!--Navbar nav -->
            <ul class="navbar-nav navbar-right-wrap ms-lg-auto d-flex nav-top-wrap align-items-center ms-4 ms-lg-0">
                <li>
                    <a class="btn btn-ghost btn-icon rounded-circle" id="ayuda" onclick="help(true);" role="button">
                        <span class="fas fa-circle-question"></span>
                    </a>
                </li>
                <li class="dropdown stopevent ms-2">
                    <a class="btn btn-ghost btn-icon rounded-circle" href="#!" role="button" id="dropdownNotification" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fas fa-bell"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end" aria-labelledby="dropdownNotification">
                        <div>
                            <div class="border-bottom px-3 pt-2 pb-3 d-flex justify-content-between align-items-center">
                                <p class="mb-0 text-dark fw-medium fs-4">Notificaciones</p>
                            </div>
                            <div  data-simplebar style="height: 250px;">
                                <!-- List group -->
                                <ul class="list-group list-group-flush notification-list-scroll">
                                    <!-- List group item -->
                                    <!-- <li class="list-group-item bg-light">
                                        <a href="#!" class="text-muted">
                                            <h5 class=" mb-1">Rishi Chopra</h5>
                                            <p class="mb-0">
                                            Mauris blandit erat id nunc blandit, ac eleifend dolor pretium.
                                            </p>
                                        </a>
                                    </li> -->
                                    
                                </ul>
                            </div>
                            <div class="border-top px-3 py-2 text-center">
                                <a href="#!" class="text-inherit ">
                                    Ver todo
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- List -->
                <li class="dropdown ms-2">
                    <a class="rounded-circle" href="#!" role="button" id="dropdownUser" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar avatar-md avatar-indicators avatar-online">
                            <img alt="avatar" src="<?php echo IMAGES; ?><?php echo ($_SESSION[APP_SESSION.'usu_avatar']!="") ? $_SESSION[APP_SESSION.'usu_avatar'] : ''; ?>" class="rounded-circle">
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                        <div class="px-4 pb-0 pt-2">
                            <div class="lh-1 ">
                                <h5 class="mb-1"><?php echo $_SESSION[APP_SESSION.'usu_nombre']; ?></h5>
                                <!-- <a href="<?php echo URL; ?>perfil/ver" class="text-inherit fs-6">Ver mi perfil</a> -->
                            </div>
                            <div class=" dropdown-divider mt-3 mb-2"></div>
                        </div>
                        <ul class="list-unstyled">
                            <!-- <li>
                                <a class="dropdown-item d-flex align-items-center" href="<?php echo URL; ?>perfil/editar">
                                    <i class="me-2 icon-xxs dropdown-item-icon" data-feather="user"></i>Editar perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo URL; ?>perfil/actividad">
                                    <i class="me-2 icon-xxs dropdown-item-icon" data-feather="activity"></i>Actividad
                                </a>
                            </li> -->
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
<!-- navbar vertical -->
<!-- Sidebar -->
<div class="navbar-vertical navbar nav-dashboard">
    <div class="h-100" data-simplebar>
        <!-- Brand logo -->
        <a class="navbar-brand border-bottom py-0" href="<?php echo URL; ?>login">
           <div class="row py-0">
                <div class="col-md-12 text-center d-none d-md-block py-1"><img src="<?php echo IMAGES; ?><?php echo LOGO_MENU; ?>" class="img-fluid"></div>
           </div>
        </a>
        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column pt-3 mt-11 mt-md-0" id="sideNavbar">
            <!-- Nav item DASHBOARD-->
            <li class="nav-item">
                <a class="nav-link has-arrow"
                    href="<?php echo URL; ?>inicio">
                    <i class="fa-solid fa-home nav-icon me-2 icon-xxs" >
                    </i> Dashboard
                </a>
            </li>
            <?php if((isset($_SESSION[APP_SESSION.'usu_modulos']['Hoja de Vida']) AND $_SESSION[APP_SESSION.'usu_modulos']['Hoja de Vida']!='') OR (isset($_SESSION[APP_SESSION.'usu_modulos']['Hoja de Vida-Consolidado']) AND $_SESSION[APP_SESSION.'usu_modulos']['Hoja de Vida-Consolidado']!='')): ?>
                <!-- Nav item Hoja de Vida -->
                <li class="nav-item">
                    <a class="nav-link has-arrow " href="#!"
                        data-bs-toggle="collapse" data-bs-target="#HojaVida" aria-expanded="false"
                        aria-controls="HojaVida">
                        <i class="fa-solid fa-file-alt nav-icon me-2 icon-xxs" ></i>
                        Hoja de Vida
                    </a>
                    <div id="HojaVida" class="collapse"
                        data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">
                            <?php if(isset($_SESSION[APP_SESSION.'usu_modulos']['Hoja de Vida']) AND $_SESSION[APP_SESSION.'usu_modulos']['Hoja de Vida']!=''): ?>
                                <li class="nav-item">   
                                    <a class="nav-link" href="<?php echo URL; ?>hoja-vida/formulario-instrucciones/<?php echo base64_encode('instrucciones'); ?>">Mi hoja de vida</a>
                                </li>
                            <?php endif; ?>
                            <?php if(isset($_SESSION[APP_SESSION.'usu_modulos']['Hoja de Vida-Consolidado']) AND $_SESSION[APP_SESSION.'usu_modulos']['Hoja de Vida-Consolidado']!=''): ?>
                                <?php
                                    if ($_SESSION[APP_SESSION.'usu_modulos']['Hoja de Vida-Consolidado']=='Administrador' OR $_SESSION[APP_SESSION.'usu_modulos']['Hoja de Vida-Consolidado']=='Gestor' OR $_SESSION[APP_SESSION.'usu_modulos']['Hoja de Vida-Consolidado']=='Usuario') {
                                        $bandeja='Todos';
                                    } else {
                                        $bandeja='Activos';
                                    }
                                ?>
                                <li class="nav-item">   
                                    <a class="nav-link" href="<?php echo URL; ?>hoja-vida/personal/0/null/<?php echo base64_encode($bandeja); ?>">Consolidado</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
            <?php if(isset($_SESSION[APP_SESSION.'usu_modulos']['Selección']) AND $_SESSION[APP_SESSION.'usu_modulos']['Selección']!=''): ?>
                <!-- Nav item SELECCIÓN -->
                <li class="nav-item">
                    <a class="nav-link has-arrow " href="#!"
                        data-bs-toggle="collapse" data-bs-target="#navSeleccion" aria-expanded="false"
                        aria-controls="navSeleccion">
                        <i class="fa-solid fa-users-line nav-icon me-2 icon-xxs" ></i>
                        Selección
                    </a>
                    <div id="navSeleccion" class="collapse"
                        data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">
                            <?php if(isset($_SESSION[APP_SESSION.'usu_modulos']['Selección']) AND $_SESSION[APP_SESSION.'usu_modulos']['Selección']!=''): ?>
                                <?php
                                    if ($_SESSION[APP_SESSION.'usu_modulos']['Selección']=='Contratación' OR $_SESSION[APP_SESSION.'usu_modulos']['Selección']=='Contratación-Retiros') {
                                        $bandeja_seleccion='Vinculados';
                                    } elseif ($_SESSION[APP_SESSION.'usu_modulos']['Selección']=='Gestión Usuarios') {
                                        $bandeja_seleccion='Vinculados';
                                    } else {
                                        $bandeja_seleccion='Todos';
                                    }
                                    
                                ?>
                                <li class="nav-item">   
                                    <a class="nav-link" href="<?php echo URL; ?>seleccion-vinculacion/aspirantes/0/null/<?php echo base64_encode($bandeja_seleccion); ?>">Aspirantes</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
            
            <?php if(isset($_SESSION[APP_SESSION.'usu_modulos']['Encuestas']) AND $_SESSION[APP_SESSION.'usu_modulos']['Encuestas']!=''): ?>
                <!-- Nav item ENCUESTAS -->
                <li class="nav-item">
                    <a class="nav-link has-arrow " href="#!"
                        data-bs-toggle="collapse" data-bs-target="#navEncuestas" aria-expanded="false"
                        aria-controls="navEncuestas">
                        <i class="fa-solid fa-check-square nav-icon me-2 icon-xxs" ></i>
                        Encuestas
                    </a>
                    <div id="navEncuestas" class="collapse"
                        data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">
                            <?php if(isset($_SESSION[APP_SESSION.'usu_modulos']['Encuestas-Configuración']) AND $_SESSION[APP_SESSION.'usu_modulos']['Encuestas-Configuración']!=''): ?>
                                <li class="nav-item">   
                                    <a class="nav-link" href="<?php echo URL; ?>encuestas/configuracion/0/null/<?php echo base64_encode('Todos'); ?>">Configuración</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>

            <?php if(isset($_SESSION[APP_SESSION.'usu_modulos']['Administrador']) AND $_SESSION[APP_SESSION.'usu_modulos']['Administrador']!=''): ?>
                <!-- Nav item ADMINISTRADOR-->
                <li class="nav-item">
                    <a class="nav-link has-arrow " href="#!"
                        data-bs-toggle="collapse" data-bs-target="#navAdministrador" aria-expanded="false"
                        aria-controls="navAdministrador">
                        <i class="fa-solid fa-cog nav-icon me-2 icon-xxs" ></i>
                        Administrador
                    </a>
                    <div id="navAdministrador" class="collapse"
                        data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">
                            <?php if(isset($_SESSION[APP_SESSION.'usu_modulos']['Administrador-Usuarios']) AND $_SESSION[APP_SESSION.'usu_modulos']['Administrador-Usuarios']!=''): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo URL; ?>administrador-usuarios">Usuarios</a>
                                </li>
                            <?php endif; ?>
                            <?php if(isset($_SESSION[APP_SESSION.'usu_modulos']['Administrador-Buzones correo']) AND $_SESSION[APP_SESSION.'usu_modulos']['Administrador-Buzones correo']!=''): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo URL; ?>administrador-buzones">Buzones correo</a>
                                </li>
                            <?php endif; ?>
                            <?php if(isset($_SESSION[APP_SESSION.'usu_modulos']['Administrador-Parámetros']) AND $_SESSION[APP_SESSION.'usu_modulos']['Administrador-Parámetros']!=''): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo URL; ?>administrador-parametros">Parámetros</a>
                                </li>
                            <?php endif; ?>
                            <?php if(isset($_SESSION[APP_SESSION.'usu_modulos']['Administrador-Notificaciones']) AND $_SESSION[APP_SESSION.'usu_modulos']['Administrador-Notificaciones']!=''): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo URL; ?>administrador-notificaciones">Notificaciones</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
                <!-- Nav item ADMINISTRADOR > LOGS-->
                <li class="nav-item">
                    <a class="nav-link has-arrow"
                        href="<?php echo URL; ?>administrador_logs">
                        <i class="fa-solid fa-clock-rotate-left nav-icon me-2 icon-xxs" >
                        </i> Log de eventos
                    </a>
                </li>
            <?php endif; ?>
            <!-- Nav item -->
            <li class="nav-item">
                <div class="navbar-heading">Documentación</div>
            </li>
            <li class="nav-item">
            <a class="nav-link has-arrow " href="#!" data-bs-toggle="collapse" data-bs-target="#navDocs" aria-expanded="false" aria-controls="navDocs">
                <i class="fas fa-book nav-icon me-2 icon-xxs"></i> Manual de Usuario
            </a>
            <div id="navDocs" class="collapse"
                data-bs-parent="#sideNavbar">
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
            $modulosComunicaciones =
                $_SESSION[APP_SESSION.'usu_modulos'] ?? [];

            $perfilModuloComunicaciones = '';

            if (is_array($modulosComunicaciones)) {
                $perfilModuloComunicaciones = strtoupper(
                    trim(
                        (string)(
                            $modulosComunicaciones['Comunicaciones']
                            ?? ''
                        )
                    )
                );
            }

            $perfil =
                $_SESSION[APP_SESSION.'usu_perfil'] ?? '';

            $perfilGlobalComunicaciones = strtoupper(
                trim((string)$perfil)
            );

            $esAdminGlobalComunicaciones = in_array(
                $perfilGlobalComunicaciones,
                ['ADMIN', 'ADMINISTRADOR', 'SUPERADMIN'],
                true
            );

            /*
             * Si ya existe asignación modular, esta tiene prioridad.
             * Si todavía no existe, se conserva la funcionalidad original.
             */
            if ($perfilModuloComunicaciones !== '') {
                $puedeVerComunicaciones = in_array(
                    $perfilModuloComunicaciones,
                    [
                        'VISITANTE',
                        'USUARIO',
                        'GESTOR',
                        'ADMIN',
                        'ADMINISTRADOR',
                        'SUPERADMIN',
                    ],
                    true
                );

                $puedeAdminComunicaciones = in_array(
                    $perfilModuloComunicaciones,
                    [
                        'GESTOR',
                        'ADMIN',
                        'ADMINISTRADOR',
                        'SUPERADMIN',
                    ],
                    true
                );

                $puedeAnalyticsComunicaciones = in_array(
                    $perfilModuloComunicaciones,
                    ['ADMIN', 'ADMINISTRADOR', 'SUPERADMIN'],
                    true
                );
            } else {
                $puedeVerComunicaciones =
                    isset($_SESSION[APP_SESSION.'usu_id']);

                $puedeAdminComunicaciones =
                    $esAdminGlobalComunicaciones;

                $puedeAnalyticsComunicaciones =
                    $esAdminGlobalComunicaciones;
            }
            ?>

            <?php if ($puedeVerComunicaciones): ?>
            <li class="nav-item mt-2">
                <a class="nav-link has-arrow no-track" href="#!"
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

                        <?php if (
                            $puedeAdminComunicaciones
                            || $puedeAnalyticsComunicaciones
                        ): ?>
                        <li class="nav-item mt-3">
                            <div class="navbar-heading">
                                Administración
                            </div>
                        </li>
                        <?php endif; ?>

                        <?php if ($puedeAdminComunicaciones): ?>
                        <li class="nav-item">
                            <a class="nav-link"
                               href="<?php echo URL; ?>?uri=comunicaciones/admin_paginas">
                                <i class="fa-solid fa-gear nav-icon me-2 icon-xxs"></i>
                                Administrar páginas
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if ($puedeAnalyticsComunicaciones): ?>
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
                                <i class="fa-solid fa-chart-pie nav-icon me-2 icon-xxs"></i>
                                Analytics General
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

<style>
#dropdownUser,
#dropdownNotification {
    cursor: pointer;
    position: relative;
    z-index: 1055;
}

#dropdownUser .avatar,
#dropdownUser img,
#dropdownNotification span {
    pointer-events: none;
}

.dropdown-menu[aria-labelledby="dropdownUser"],
.dropdown-menu[aria-labelledby="dropdownNotification"] {
    z-index: 2000;
}
</style>

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

        return target.closest('.js-track-click, a[href], button, [role="button"], [data-url], [onclick]');
    }

    function esElementoExcluido(element) {
        if (!element) return true;

        if (element.classList.contains('no-track')) return true;
        if (element.closest('.no-track')) return true;

        if (element.hasAttribute('data-bs-toggle')) return true;
        if (element.closest('[data-bs-toggle]')) return true;

        const href = (element.getAttribute('href') || '').trim().toLowerCase();

        if (href === '#!' || href === '#') return true;
        if (href.indexOf('logout') !== -1) return true;

        return false;
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

        if (href.toLowerCase().indexOf('logout') !== -1) {
            return false;
        }

        if (element.hasAttribute('data-bs-toggle') || element.closest('[data-bs-toggle]')) {
            return false;
        }

        return true;
    }

    window.registrarClick = function(element, originalEvent = null) {
        if (!element || esElementoExcluido(element)) {
            return true;
        }

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

        if (esElementoExcluido(element)) {
            return;
        }

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
    }, false);

    const dropdownUserBtn = document.getElementById('dropdownUser');
    if (dropdownUserBtn) {
        dropdownUserBtn.addEventListener('click', function(e) {
            e.stopPropagation();

            if (typeof bootstrap !== 'undefined' && bootstrap.Dropdown) {
                const instance = bootstrap.Dropdown.getOrCreateInstance(dropdownUserBtn);
                instance.toggle();
            }
        });
    }

    const dropdownNotificationBtn = document.getElementById('dropdownNotification');
    if (dropdownNotificationBtn) {
        dropdownNotificationBtn.addEventListener('click', function(e) {
            e.stopPropagation();

            if (typeof bootstrap !== 'undefined' && bootstrap.Dropdown) {
                const instance = bootstrap.Dropdown.getOrCreateInstance(dropdownNotificationBtn);
                instance.toggle();
            }
        });
    }
});
</script>
         </ul>
    </div>
</div>
<!-- ==============>>header section end here<<================ -->
