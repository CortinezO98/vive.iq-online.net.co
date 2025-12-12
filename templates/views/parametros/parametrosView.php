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
                        <li class="breadcrumb-item active" aria-current="page">Parámetros</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="service__wrapper">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-12 col-md-12 pt-5">
                    <div class="service__item">
                        <div class="service__inner text-start">
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <?php require_once INCLUDES.'inc_search.php'; ?>
                                </div>
                                <div class="col-md-6 mb-1 text-end">
                                    
                                </div>
                            </div>
                            <div class="table-responsive table-fixed">
                                <table class="table table-hover table-bordered table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th class="px-1 py-2 text-center font-size-12" style="width: 80px;"></th>
                                        <th class="px-1 py-2 text-center font-size-12">Parámetro</th>
                                        <th class="px-1 py-2 text-center font-size-12">Título</th>
                                        <th class="px-1 py-2 text-center font-size-12">Descripción</th>
                                        <th class="px-1 py-2 text-center font-size-12">Imagen</th>
                                        <th class="px-1 py-2 text-center font-size-12">Url Video</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['resultado_registros'] as $registro): ?>
                                        <tr>
                                            <td class="p-1 text-center">
                                                <a href="<?php echo URL; ?>parametros/editar/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo base64_encode($registro->app_id); ?>" class="btn btn-warning btn-sm font-size-11 btn-table" title="Editar"><i class="fas fa-pen font-size-11"></i></a>
                                            </td>
                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->app_id; ?></td>
                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->app_titulo; ?></td>
                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->app_descripcion; ?></td>
                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->app_imagen; ?></td>
                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->app_link; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                </table>
                                <?php if($data['resultado_registros_count']==0): ?>
                                    <p class="alert alert-dark p-1 mt-0">¡No se encontraron registros!</p>
                                <?php endif; ?>
                            </div>
                            <?php require_once INCLUDES.'inc_pagination.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==============>>Service section end here<<================ -->

<?php require_once INCLUDES.'inc_footer.php'; ?>