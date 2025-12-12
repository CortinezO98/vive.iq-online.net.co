<?php require_once INCLUDES.'inc_head.php'; ?>
<main id="main-wrapper" class="main-wrapper">
    <?php require_once INCLUDES.'inc_header.php'; ?>
    <!-- page content -->
    <div id="app-content">
        <div class="app-content-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <!-- Page header -->
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <h3 class="mb-0 font-size-11">| <?php echo str_replace('|', '<span class="fas fa-chevron-right text-gray-400 mx-1"></span>', $data['titulo_pagina']); ?></h3>
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-xxl-1 col-xxl-8 offset-xl-1 col-xl-7 col-md-12 col-sm-12 col-12 ">
                        <!-- Content -->
                        <div class="docs-content mx-xxl-9">
                            
                            <!-- Introducción -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="intro">
                                        <h1 class="mb-2 ">Navegación</h1>
                                        <p class="mb-6 lead text-muted">
                                            La navegación del sistema está diseñada para que el usuario pueda acceder de forma rápida e intuitiva a todas las funcionalidades disponibles. 
                                            Desde el menú principal, se puede ingresar a los diferentes módulos, visualizar información clave en el dashboard y cerrar sesión de manera segura cuando finalice su trabajo.
                                        </p>
                                        <p class="fs-4 mb-0"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Menú Principal -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="menu-principal">
                                        <h2 class="h3">Menú principal</h2>
                                        <p class="my-1">
                                            El <strong>menú principal</strong> es la herramienta de acceso a los distintos módulos de la plataforma.
                                            Está ubicado en la parte lateral-izquierda de la pantalla.
                                            Contiene enlaces organizados por categorías o procesos que permiten acceder rápidamente a módulos, reportes y configuraciones.
                                            Además, incluye íconos y descripciones para facilitar la identificación de cada opción.
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/login/menu_principal.jpg" alt="Menú principal" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dashboard -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="dashboard">
                                        <h2 class="h3">Dashboard</h2>
                                        <p class="my-1">
                                            El <strong>dashboard</strong> o panel principal muestra de forma resumida la información más relevante del sistema o algunas secciones informativas.
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/login/dashboard.jpg" alt="Dashboard" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Cerrar Sesión -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="cerrar-sesion">
                                        <h2 class="h3">Cerrar sesión</h2>
                                        <p class="my-1">
                                            La opción <strong>Cerrar sesión</strong> permite salir de la paltaforma de forma segura.
                                            Se recomienda utilizarla siempre que finalice el uso del sistema para proteger la información y evitar accesos no autorizados.
                                            Se puede acceder a esta funcionalidad haciendo clic en el avatar de la parte superior-derecha, desplegando el menú para cerrar sesión.
                                            Al hacer clic, el sistema finalizará la sesión y redirigirá a la pantalla de inicio de sesión.
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/login/cerrar_sesion.jpg" alt="Cerrar sesión" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12 d-none d-xl-block position-fixed end-0">
                        <!-- Sidebar nav fixed -->
                        <div class="sidebar-nav-fixed">
                            <span class="px-4 mb-2 d-block text-uppercase ls-md h4 fs-6">Contenido</span>
                            <ul class="list-unstyled">
                                <li><a href="#intro" class="active">Introducción</a></li>
                                <li><a href="#menu-principal">Menú principal</a></li>
                                <li><a href="#dashboard">Dashboard</a></li>
                                <li><a href="#cerrar-sesion">Cerrar sesión</a></li>
                            </ul>
                        </div>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</main>
<?php require_once INCLUDES.'inc_footer.php'; ?>