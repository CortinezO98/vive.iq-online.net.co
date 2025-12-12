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
                            <!-- <a href="#!" class="btn btn-primary">Button</a> -->
                        </div>
                    </div>
                </div>
                <form name="form_guardar" action="" method="post" class="comment-form" enctype="multipart/form-data">
                <div class="row justify-content-center mb-2">
                    <div class="col-md-6">
                        <div class="bg-white rounded-3 col-lg-12 col-md-12 col-12">
                            <div class="row mb-5">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="row p-6 d-lg-flex justify-content-between align-items-center ">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row mb-2">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="hva_identificacion" class="form-label my-0 font-size-11">Doc identidad</label>
                                                        <input type="text" class="form-control form-control-sm" name="hva_identificacion" id="hva_identificacion" value="<?php echo $data['resultado_registros'][0]->hva_identificacion; ?>" required>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="hva_nombres" class="form-label my-0 font-size-11">Primer nombre</label>
                                                        <input type="text" class="form-control form-control-sm" name="hva_nombres" id="hva_nombres" value="<?php echo $data['resultado_registros'][0]->hva_nombres; ?>" required>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="hva_nombres_2" class="form-label my-0 font-size-11">Segundo nombre</label>
                                                        <input type="text" class="form-control form-control-sm" name="hva_nombres_2" id="hva_nombres_2" value="<?php echo $data['resultado_registros'][0]->hva_nombres_2; ?>">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hva_apellido_1" class="form-label my-0 font-size-11">Primer apellido</label>
                                                        <input type="text" class="form-control form-control-sm" name="hva_apellido_1" id="hva_apellido_1" value="<?php echo $data['resultado_registros'][0]->hva_apellido_1; ?>" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hva_apellido_2" class="form-label my-0 font-size-11">Segundo apellido</label>
                                                        <input type="text" class="form-control form-control-sm" name="hva_apellido_2" id="hva_apellido_2" value="<?php echo $data['resultado_registros'][0]->hva_apellido_2; ?>">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hva_correo" class="form-label my-0 font-size-11">Correo</label>
                                                        <input type="email" class="form-control form-control-sm" name="hva_correo" id="hva_correo" value="<?php echo $data['resultado_registros'][0]->hva_correo; ?>" required>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="hva_observaciones" class="form-label my-0 font-size-11">Observaciones</label>
                                                        <textarea class="form-control form-control-sm" name="hva_observaciones" id="hva_observaciones" rows="3" maxlength="500"><?php echo $data['resultado_registros'][0]->hva_observaciones; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php echo Flasher::flash(); ?>
                                            <div class="col-md-12 text-end">
                                                <button class="btn btn-success float-end ms-1" type="submit" name="form_guardar" id="guardar_registro_btn">Guardar</button>
                                                <?php if(isset($_POST["form_guardar"])): ?>
                                                    <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>/<?php echo $data['id_registro']; ?>" class="btn btn-dark float-end">Finalizar</a>
                                                <?php endif; ?>
                                                <?php if(!isset($_POST["form_guardar"])): ?>
                                                    <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>/<?php echo $data['id_registro']; ?>" class="btn btn-danger float-end">Cancelar</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php require_once INCLUDES.'inc_footer.php'; ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#hva_nombres").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hva_nombres_2").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hva_apellido_1").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hva_apellido_2").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });
</script>
