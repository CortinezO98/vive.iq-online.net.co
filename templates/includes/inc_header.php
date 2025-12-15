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

            <!-- ... (tu menú existente Hoja de Vida, Selección, Encuestas, Administrador, etc.) ... -->

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
            // Ver Comunicaciones: cualquier usuario logueado
            $puedeVerComunicaciones = isset($_SESSION[APP_SESSION.'usu_id']);

            // Admin Comunicaciones: solo perfiles autorizados
            $perfil = $_SESSION[APP_SESSION.'usu_perfil'] ?? '';
            $puedeAdminComunicaciones = in_array($perfil, ['ADMIN','Administrador','SUPERADMIN'], true);
            ?>

            <?php if($puedeVerComunicaciones): ?>
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

                    <?php if($puedeAdminComunicaciones): ?>
                    <li class="nav-item mt-3"><div class="navbar-heading">Administración</div></li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URL; ?>?uri=comunicaciones/admin_paginas">
                        <i class="fa-solid fa-gear nav-icon me-2 icon-xxs"></i> Administrar páginas
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
<!-- ==============>>header section end here<<================ -->
