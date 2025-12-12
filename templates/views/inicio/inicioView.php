<?php require_once INCLUDES.'inc_head.php'; ?>
<main id="main-wrapper" class="main-wrapper">
    <?php require_once INCLUDES.'inc_header.php'; ?>
    <!-- page content -->
    <div id="app-content">
        <div class="app-content-area">
            <div class="container-fluid">
                <div class="row" id="titulo_modulo">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="align-items-center mb-5">
                            <h3 class="mb-0 font-size-11">| <?php echo str_replace('|', '<span class="fas fa-chevron-right text-gray-400 mx-1"></span>', $data['titulo_pagina']); ?> <span class="fas fa-chevron-right text-gray-400 mx-1"></span> Bienvenido(a), <?php echo $_SESSION[APP_SESSION.'usu_nombre']; ?></h3>
                            <span class="font-size-11 py-0 my-0"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-8 col-md-12 col-12 mb-5">
                        <div class="row g-5">
                            <div class="col-md-12">
                                <div class="card card-lift">
                                    <div class="card-body">
                                        <?php if(true): ?>
                                            <div id="carouselExampleAutoplaying" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                <?php foreach ($data['registros_parametros_bienvenida'] as $registro): ?>
                                                    <div class="carousel-item active">
                                                        <iframe width="100%" height="500" src="<?php echo $registro->app_link; ?>" title="Bienvenido(a) ciudadano(a) iQ" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen class="d-block w-100"></iframe>
                                                        <!-- <img src="<?php echo UPLOADS; ?><?php echo $registro->gn_imagen_ruta; ?>" class="d-block w-100"> -->
                                                    </div>
                                                <?php endforeach; ?>
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Anterior</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Siguiente</span>
                                                </button>
                                            </div>
                                        <?php else: ?>
                                            <p class="alert alert-warning p-1 font-size-11">¡No se encontraron noticias vigentes!</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-12 col-12 mb-5">
                        <div class="row g-5">
                            <div class="col-md-12">
                                <div class="card card-lift">
                                    <div class="card-header ">
                                        <h4 class="mb-0">Actividad</h4>
                                    </div>
                                    <div class="card-body">
                                        <?php if($data['resultado_actividad_count']>0): ?>
                                            <div class="mb-5 d-flex ">
                                                <span class="text-primary mt-1 icon-sm fas fa-dollar text-center" style="font-size: 22px !important;"></span>
                                                <div class="ms-3">
                                                    <h5 class="mb-0">Review your payouts</h5>
                                                    <p class="mb-0">Check you wallet for the new payouts...</p>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <p class="alert alert-warning p-1 font-size-11">¡No se encontraron registros!</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 mb-5">
                        <div class="card h-100">
                            <div class="card-header ">
                                <h4 class="mb-0">Encuestas<?php echo $nonce; ?></h4>
                            </div>
                            <div class="card-body">
                                <?php foreach ($data['registros_encuestas'] as $registro_encuestas): ?>
                                    <div class="mb-5 d-block">
                                        <div class="d-flex align-items-center">
                                            <span class="fas fa-list-check"></span>
                                            <div class="ms-4">
                                                <h5 class="mb-0"><a href="<?php echo URL; ?>inicio/encuestas/<?php echo base64_encode($registro_encuestas->enc_id); ?>" class="text-inherit"><?php echo $registro_encuestas->enc_titulo; ?></a></h5>
                                                <small class="text-muted"><?php echo $registro_encuestas->enc_descripcion; ?></small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?php if($data['registros_encuestas_count']==0): ?>
                                    <p class="alert alert-dark p-1 mt-0">¡No se encontraron registros!</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once INCLUDES.'inc_footer.php'; ?>
<!-- MODAL DETALLE -->
<div class="modal fade" id="modal-detalle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Bienvenido(a) ciudadano(a) iQ</h5>
                
            </div>
            <div class="modal-body-detalle">
                <?php foreach ($data['registros_parametros_bienvenida'] as $registro): ?>
                    <iframe width="100%" height="500" src="<?php echo $registro->app_link; ?>" title="Bienvenido(a) ciudadano(a) iQ" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark py-2 px-2" data-bs-dismiss="modal">Continuar</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function tour_bienvenida(modulo) {
        if (modulo!="") {
            $.ajax({
                type: 'GET',
                url: '<?php echo URL; ?>inicio/tour/'+modulo,
                data: '',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                },
                complete:function(data){
                },
                success: function(data){
                    var resp = $.parseJSON(data);

                    if (resp.resultado_valor || active) {
                        var myModal = new bootstrap.Modal(document.getElementById("modal-detalle"), {});
                        myModal.show();
                    }
                },
                error: function(data){
                }
            });
        }
    }

    tour_bienvenida('BV');
</script> 