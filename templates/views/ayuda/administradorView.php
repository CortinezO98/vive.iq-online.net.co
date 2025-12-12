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
                    <div class="offset-xxl-1 col-xxl-8 offset-xl-1 col-xl-7 col-md-12 col-sm-12 col-12">
                        <!-- Content -->
                        <div class="docs-content mx-xxl-9">
                            
                            <!-- Introducción -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="intro">
                                        <h1 class="mb-2">Módulo Administrador</h1>
                                        <p class="mb-6 lead text-muted">
                                            El módulo <b>Administrador</b> permite gestionar usuarios, parámetros y notificaciones de la plataforma.
                                            Desde este módulo, los administradores pueden crear y editar registros de usuarios, así como ajustar
                                            configuraciones y permisos clave para el correcto funcionamiento de la plataforma.
                                        </p>
                                        <p class="mb-6 lead text-muted">
                                            A continuación, se describen las principales funcionalidades disponibles dentro del módulo administrador.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Usuarios bandeja -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="usuarios-bandeja">
                                        <h2 class="h3">Usuarios - Bandeja</h2>
                                        <p class="my-1">
                                            Muestra el listado completo de usuarios registrados. Desde aquí se pueden filtrar resultados, 
                                            buscar por nombre, número de indentificación, correo, entre otros. y acceder a las opciones de edición de cada registro o creación de nuevos usuarios.
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/administrador/Vive iQ - Usuarios bandeja.jpg" alt="Usuarios bandeja" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Crear usuario -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="crear-usuario">
                                        <h2 class="h3">Crear usuario</h2>
                                        <p class="my-1">
                                            Permite registrar un nuevo usuario en el sistema ingresando sus datos básicos, rol asignado, configuración de permisos y generar las credenciales de acceso.
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/administrador/Vive iQ - Crear usuario.jpg" alt="Crear usuario" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Editar usuario -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="editar-usuario">
                                        <h2 class="h3">Editar usuario</h2>
                                        <p class="my-1">
                                            Desde esta pantalla se pueden modificar los datos de un usuario existente, incluyendo sus datos personales, 
                                            permisos y estado dentro de la plataforma.
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/administrador/Vive iQ - Editar usuario.jpg" alt="Editar usuario" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Buzones Correo -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="buzones-correo">
                                        <h2 class="h3">Buzones Correo</h2>
                                        <p class="my-1">
                                            Desde esta opción se puede actualizar las credenciales del correo electrónico usado por la plataforma para el envío de notificaciones.
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/administrador/buzones_correo.jpg" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Parámetros bandeja -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="parametros-bandeja">
                                        <h2 class="h3">Parámetros - Bandeja</h2>
                                        <p class="my-1">
                                            Lista todos los parámetros configurables del sistema. Estos parámetros permiten personalizar el comportamiento 
                                            de la plataforma en algunos de sus módulos según las necesidades de la organización.
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/administrador/Vive iQ - Parametros bandeja.jpg" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Editar parámetro -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="editar-parametro">
                                        <h2 class="h3">Editar parámetro</h2>
                                        <p class="my-1">
                                            Permite actualizar el valor y descripción de un parámetro existente. Es importante asegurarse de que los cambios 
                                            realizados no afecten el correcto funcionamiento del sistema.
                                        </p>
                                        <h4 class="h mt-2">Tipo de parámetro</h4>
                                        <p class="my-1">
                                            Existen tres tipos de parámetros configurables dentro de la plataforma:
                                            <ul>
                                                <li><b>Lista:</b> Se pueden agregar o quitar opciones que serán mostradas en una lista desplegable específica.</li>
                                            </ul>
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/administrador/Vive iQ - Editar parametro.jpg" alt="Editar parámetro" class="img-fluid">
                                        </div>
                                        <p class="my-1">
                                            <ul>
                                                <li><b>Texto:</b> A través de un edito de texto se puede modificar el contenido de una sección específica, usada sobre todo para textos asociados a políticas o información de la compañía.</li>
                                            </ul>
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/administrador/Vive iQ - editar parametro texto.jpg" alt="Editar parámetro" class="img-fluid">
                                        </div>
                                        <p class="my-1">
                                            <ul>
                                                <li><b>Link:</b> Mediante un campo tipo link permite actualizar los enlaces de contenidos específicos dentro de la plataforma.</li>
                                            </ul>
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/administrador/Vive iQ - editar parametro link.jpg" alt="Editar parámetro" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notificaciones -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="notificaciones">
                                        <h2 class="h3">Notificaciones</h2>
                                        <p class="my-1">
                                            Muestra las notificaciones generadas por la plataforma y enviadas a través de correo electrónico. Desde aquí el administrador puede revisar el estado de las notificaciones o realizar búsquedas para confirmar el envío de las mismas.
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/administrador/Vive iQ - Notificaciones.jpg" alt="Notificaciones" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12 d-none d-xl-block position-fixed end-0">
                        <div class="sidebar-nav-fixed">
                            <span class="px-4 mb-2 d-block text-uppercase ls-md h4 fs-6">Contenido</span>
                            <ul class="list-unstyled">
                                <li><a href="#intro" class="active">Introducción</a></li>
                                <li><a href="#usuarios-bandeja">Usuarios - Bandeja</a></li>
                                <li><a href="#crear-usuario">Crear usuario</a></li>
                                <li><a href="#editar-usuario">Editar usuario</a></li>
                                <li><a href="#buzones-correo">Buzones correo</a></li>
                                <li><a href="#parametros-bandeja">Parámetros - Bandeja</a></li>
                                <li><a href="#editar-parametro">Editar parámetro</a></li>
                                <li><a href="#notificaciones">Notificaciones</a></li>
                            </ul>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once INCLUDES.'inc_footer.php'; ?>