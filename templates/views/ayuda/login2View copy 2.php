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
                                            
                                        </p>
                                        <p class="fs-4 mb-0"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="setting-up">
                                        <h2 class="h3">Iniciar sesión</h2>
                                        <p class="mb-0">xxxx</p>
                                        <div class="col-md-5 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/login/iniciar_sesion.jpg" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="setting-up">
                                        <h2 class="h3">Recuperar contraseña</h2>
                                        <p class="mb-0">xxxx</p>
                                        <div class="col-md-5 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/login/recuperar_contraseña.jpg" alt="" class="img-fluid">
                                        </div>
                                        <p class="mb-0">xxxx</p>
                                        <div class="col-md-5 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/login/recuperar_contraseña2.jpg" alt="" class="img-fluid">
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
                                <li><a href="#intro" class="active">Introduction</a></li>
                                <li><a href="#setting-up">Setting Up</a>
                                <li><a href="#customize-theme">Customize Theme</a></li>
                            </ul>
                        </div>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</main>
<?php require_once INCLUDES.'inc_footer.php'; ?>