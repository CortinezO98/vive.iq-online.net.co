<?php require_once INCLUDES.'inc_head.php'; ?>
<?php require_once INCLUDES.'inc_header.php'; ?>

<!-- ==============>>section start here<<================ -->
<section class="service padding-bottom">
    <section class="page-header px-0 mx-0" style="background-image:url('<?php echo $_SESSION[APP_SESSION.'param_login_image']; ?>');">
        <div class="container mx-0 px-0">
            <div class="page-header__content">
                <h2 style="color: #FFF;">Mi Perfil</h2>
                <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Inicio</li>
                        <li class="breadcrumb-item" aria-current="page">Mi perfil</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="service__wrapper">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-5 col-md-5 pt-5">
                    <div class="service__item">
                        <div class="service__inner text-start">
                            <div class="respond px-3">
                                <div class="contact__info">
                                    <div class="contact__info-body">
                                        <ul>
                                            <li>
                                                <div class="contact__info-left">
                                                    <i class="fa-solid fa-user"></i>
                                                </div>
                                                <div class="contact__info-right">
                                                    <h5>Nombres y Apellidos</h5>
                                                    <p><?php echo $data['resultado_registros'][0]->usu_nombres_apellidos; ?></p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="contact__info-left">
                                                    <i class="fa-solid fa-sitemap"></i>
                                                </div>
                                                <div class="contact__info-right">
                                                    <h5>Área</h5>
                                                    <p><?php echo $data['resultado_registros'][0]->aa_nombre; ?></p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="contact__info-left">
                                                    <i class="fa-solid fa-user-tie"></i>
                                                </div>
                                                <div class="contact__info-right">
                                                    <h5>Cargo</h5>
                                                    <p><?php echo $data['resultado_registros'][0]->ac_nombre; ?></p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="contact__info-left">
                                                    <i class="fa-solid fa-envelope"></i>
                                                </div>
                                                <div class="contact__info-right">
                                                    <h5>Email</h5>
                                                    <p><?php echo $data['resultado_registros'][0]->usu_correo_corporativo; ?></p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="contact__info-left">
                                                    <i class="fa-solid fa-cog"></i>
                                                </div>
                                                <div class="contact__info-right">
                                                    <h5>Perfil</h5>
                                                    <p><?php echo $data['resultado_registros'][0]->usu_perfil; ?></p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12 text-end mb-4">
                                        <!-- <a href="<?php echo URL; ?>usuarios/ver/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>" class="btn btn-primary"><span class="fas fa-image"></span> Cambiar foto</a> -->
                                        <a href="<?php echo URL; ?>perfil/ver/" class="btn btn-primary"><span class="fas fa-key"></span> Cambiar contraseña</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==============>>section end here<<================ -->
<?php require_once INCLUDES.'inc_footer.php'; ?>