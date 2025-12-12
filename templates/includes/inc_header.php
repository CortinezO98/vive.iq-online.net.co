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
         </ul>
    </div>
</div>
<!-- ==============>>header section end here<<================ -->