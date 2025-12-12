<?php require_once INCLUDES.'inc_head.php'; ?>
<?php require_once INCLUDES.'inc_header.php'; ?>

<!-- ==============>>Service section start here<<================ -->
<section class="service padding-bottom">
    <section class="page-header px-0 mx-0" style="background-image:url('<?php echo $_SESSION[APP_SESSION.'param_login_image']; ?>');">
        <div class="container mx-0 px-0">
            <div class="page-header__content">
                <h2 style="color: #FFF;">CONFIGURACIÓN PARÁMETROS</h2>
                <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Inicio</li>
                        <li class="breadcrumb-item" aria-current="page">Configuración</li>
                        <li class="breadcrumb-item" aria-current="page">Parámetros</li>
                        <li class="breadcrumb-item active" aria-current="page">Editar</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="service__wrapper">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-6 col-md-6 pt-5">
                    <div class="service__item">
                        <div class="service__inner text-start">
                            <div class="respond px-3">
                                <div class="respond__title">
                                    <h3>Editar parámetro</h3>
                                </div>
                                <form name="form_guardar" action="" method="post" class="comment-form" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="app_id" class="form-label my-0">Parámetro</label>
                                                    <input type="text" class="form-control form-control-sm" name="app_id" id="app_id" value="<?php echo $data['resultado_registros'][0]->app_id; ?>" readonly required>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="app_titulo" class="form-label my-0">Título</label>
                                                    <input type="text" class="form-control form-control-sm" name="app_titulo" id="app_titulo" value="<?php echo $data['resultado_registros'][0]->app_titulo; ?>" required>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="app_descripcion" class="form-label my-0">Descripción</label>
                                                    <textarea class="form-control form-control-sm" name="app_descripcion" id="app_descripcion" rows="3" required><?php echo $data['resultado_registros'][0]->app_descripcion; ?></textarea>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="app_link" class="form-label my-0">Url video</label>
                                                    <input type="text" class="form-control form-control-sm" name="app_link" id="app_link" value="<?php echo $data['resultado_registros'][0]->app_link; ?>">
                                                </div>
                                                <div class="col-md-12 my-1">
                                                    <div class="form-group">
                                                        <label for="documento" class="my-0">Adjuntar imagen</label>
                                                        <input class="form-control form-control-sm" name="documento" id="inputGroupFile01" type="file" accept=".png, .PNG, .jpg, .JPG, .jpeg, .JPEG, .jfif, .JFIF">
                                                        <p class="alert alert-danger p-1 font-size-11">La imagen anterior será reemplazada si adjunta una nueva.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo Flasher::flash(); ?>
                                        <div class="col-md-12 text-end">
                                            <button class="btn btn-success float-end ms-1" type="submit" name="form_guardar" id="guardar_registro_btn">Guardar</button>
                                            <?php if(isset($_POST["form_guardar"])): ?>
                                                <a href="<?php echo URL; ?>parametros/ver/0/null" class="btn btn-dark float-end">Finalizar</a>
                                            <?php endif; ?>
                                            <?php if(!isset($_POST["form_guardar"])): ?>
                                                <a href="<?php echo URL; ?>parametros/ver/0/null" class="btn btn-danger float-end">Cancelar</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==============>>Service section end here<<================ -->

<?php require_once INCLUDES.'inc_footer.php'; ?>