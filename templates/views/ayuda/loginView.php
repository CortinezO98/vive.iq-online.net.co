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
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="intro">
                                        <h1 class="mb-2 ">Login</h1>
                                        <p class="mb-6 lead text-muted">
                                            La pantalla de login permite a los usuarios acceder de manera segura a la plataforma. Desde aquí, podrá ingresar sus credenciales personales o, en caso de haberlas olvidado, iniciar el proceso de recuperación de contraseña. Este mecanismo garantiza que solo usuarios autorizados puedan acceder a la información y funcionalidades de la plataforma.
                                        </p>
                                        <p class="fs-4 mb-0"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="iniciar-sesion">
                                        <h2 class="h3">Iniciar sesión</h2>
                                        <p class="my-1">Para ingresar a la plataforma, el usuario debe escribir sus credenciales de acceso asignadas (usuario y contraseña) en los campos correspondientes, verificar el captcha y luego hacer clic en el botón "Iniciar Sesión".
                                        <ul>
                                            <li>Si las credenciales son correctas, el sistema permitirá el acceso y lo dirigirá al panel principal.</li>
                                            <li>En caso de ingresar datos incorrectos, se mostrará un mensaje de advertencia para que verifique la información e intente nuevamente.</li>
                                        </ul>
                                        </p>
                                        <div class="col-md-8 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/login/iniciar_sesion.jpg" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="recuperar-contrasena">
                                        <h2 class="h3">Recuperar contraseña</h2>
                                        <p class="my-1">Si el usuario no recuerda su contraseña de acceso, puede hacer clic en el enlace "¿Olvidó su contraseña?".
                                            <br><br>Esto abrirá un formulario donde deberá:
                                            <ul>
                                                <li>Ingresar el correo electrónico registrado en el sistema.</li>
                                                <li>Validar el captcha.</li>
                                                <li>Hacer clic en el botón "Validar correo".</li>
                                            </ul>
                                        </p>
                                        <div class="col-md-8 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/login/recuperar_contraseña.jpg" alt="" class="img-fluid">
                                        </div>
                                        <p class="my-1">Si el correo electrónico es validado por el sistema, se enviará un mensaje por correo electrónico con instrucciones para restablecer la contraseña. Es importante revisar la carpeta de Correo no deseado o Spam si no recibe el mensaje en unos minutos.</p>
                                        <div class="col-md-8 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/login/recuperar_contraseña2.jpg" alt="" class="img-fluid">
                                        </div>
                                        <p class="my-1">En el correo electrónico recibido deberá ingresar al link de recuperación, teniendo en cuenta que cuenta con 20 minutos antes de que expire el token para recuperación de contraseña.</p>
                                        <div class="col-md-8 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/login/recuperar_contraseña_correo.jpg" alt="" class="img-fluid">
                                        </div>
                                        <p class="my-1">Al ingresar al link recibido, se habilitará el formulario de cambio de contraseña, el cual deberá diligenciar con una contraseña nueva que cumpla con los requisitos mínimos de seguridad validados por la plataforma:
                                            <ul>
                                                <li>Deberá contener 8 caracteres mínimo.</li>
                                                <li>Una letra minúscula como mínimo.</li>
                                                <li>También como mínimo debe contener 1 letra mayúscula.</li>
                                                <li>Cómo mínimo 1 número.</li>
                                                <li>Y por último un caracter especial "<b>~  !  #  ¡  $  &  %  ^  *  +  =  -  [  ]  ;  ,  .  /  {  }  (  )  _  |  :  ></b>"</li>
                                            </ul>
                                        </p>
                                        <div class="col-md-8 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/login/recuperar_contraseña_update.jpg" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12  d-none d-xl-block position-fixed end-0">
                        <!-- Sidebar nav fixed -->
                        <div class="sidebar-nav-fixed">
                            <span class="px-4 mb-2 d-block text-uppercase ls-md h4 fs-6">Contenido</span>
                            <ul class="list-unstyled">
                                <li><a href="#intro" class="active">Introducción</a></li>
                                <li><a href="#iniciar-sesion">Iniciar sesión</a>
                                <li><a href="#recuperar-contrasena">Recuperar contraseña</a></li>
                            </ul>
                        </div>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</main>
<?php require_once INCLUDES.'inc_footer.php'; ?>