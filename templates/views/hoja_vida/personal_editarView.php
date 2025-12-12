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
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hvp_datos_personales_numero_identificacion " class="form-label my-0 font-size-11">Doc identidad</label>
                                                        <input type="text" class="form-control form-control-sm" name="hvp_datos_personales_numero_identificacion" id="hvp_datos_personales_numero_identificacion " value="<?php echo $data['resultado_registros'][0]->hvp_datos_personales_numero_identificacion; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hvp_datos_personales_nombre_1" class="form-label my-0 font-size-11">Primer nombre</label>
                                                        <input type="text" class="form-control form-control-sm" name="hvp_datos_personales_nombre_1" id="hvp_datos_personales_nombre_1" value="<?php echo $data['resultado_registros'][0]->hvp_datos_personales_nombre_1; ?>" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hvp_datos_personales_nombre_2" class="form-label my-0 font-size-11">Segundo nombre</label>
                                                        <input type="text" class="form-control form-control-sm" name="hvp_datos_personales_nombre_2" id="hvp_datos_personales_nombre_2" value="<?php echo $data['resultado_registros'][0]->hvp_datos_personales_nombre_2; ?>">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hvp_datos_personales_apellido_1" class="form-label my-0 font-size-11">Primer apellido</label>
                                                        <input type="text" class="form-control form-control-sm" name="hvp_datos_personales_apellido_1" id="hvp_datos_personales_apellido_1" value="<?php echo $data['resultado_registros'][0]->hvp_datos_personales_apellido_1; ?>" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hvp_datos_personales_apellido_2" class="form-label my-0 font-size-11">Segundo apellido</label>
                                                        <input type="text" class="form-control form-control-sm" name="hvp_datos_personales_apellido_2" id="hvp_datos_personales_apellido_2" value="<?php echo $data['resultado_registros'][0]->hvp_datos_personales_apellido_2; ?>">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hvp_contacto_correo_corporativo" class="form-label my-0 font-size-11">Correo corporativo</label>
                                                        <input type="email" class="form-control form-control-sm" name="hvp_contacto_correo_corporativo" id="hvp_contacto_correo_corporativo" value="<?php echo $data['resultado_registros'][0]->hvp_contacto_correo_corporativo; ?>" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hvp_fecha_ingreso" class="form-label my-0 font-size-11">Fecha ingreso</label>
                                                        <input type="date" class="form-control form-control-sm" name="hvp_fecha_ingreso" id="hvp_fecha_ingreso" value="<?php echo $data['resultado_registros'][0]->hvp_fecha_ingreso; ?>" required>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <div class="form-group">
                                                            <label for="hvp_centro_costo" class="form-label my-0 font-size-11">Centro de costo</label>
                                                            <select class="selectpicker form-control form-control-sm font-size-11" name="hvp_centro_costo" id="hvp_centro_costo" data-live-search="true" data-container="body" title="Seleccione" required>
                                                                <?php foreach ($data['resultado_registros_area_lista'] as $registro): ?>
                                                                    <option value="<?php echo $registro->aa_id; ?>" class="font-size-11" <?php echo ($data['resultado_registros'][0]->hvp_centro_costo==$registro->aa_id) ? 'selected' : ''; ?>><?php echo $registro->aa_nombre; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <div class="form-group">
                                                            <label for="hvp_cargo" class="form-label my-0 font-size-11">Cargo</label>
                                                            <select class="selectpicker form-control form-control-sm font-size-11" name="hvp_cargo" id="hvp_cargo" data-live-search="true" data-container="body" title="Seleccione" required>
                                                                <?php foreach ($data['resultado_registros_cargo'] as $registro): ?>
                                                                    <option value="<?php echo $registro->ac_id; ?>" class="font-size-11" <?php echo ($data['resultado_registros'][0]->hvp_cargo==$registro->ac_id) ? 'selected' : ''; ?>><?php echo $registro->ac_nombre; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="hvp_observaciones" class="form-label my-0 font-size-11">Observaciones</label>
                                                        <textarea class="form-control form-control-sm" name="hvp_observaciones" id="hvp_observaciones" rows="3" maxlength="500"><?php echo $data['resultado_registros'][0]->hvp_observaciones; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php echo Flasher::flash(); ?>
                                            <div class="col-md-12 text-end">
                                                <button class="btn btn-success float-end ms-1" type="submit" name="form_guardar" id="guardar_registro_btn">Guardar</button>
                                                <?php if(isset($_POST["form_guardar"])): ?>
                                                    <a href="<?php echo URL; ?>hoja-vida/personal-detalle/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>/<?php echo $data['id_registro']; ?>" class="btn btn-dark float-end">Finalizar</a>
                                                <?php endif; ?>
                                                <?php if(!isset($_POST["form_guardar"])): ?>
                                                    <a href="<?php echo URL; ?>hoja-vida/personal-detalle/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>/<?php echo $data['id_registro']; ?>" class="btn btn-danger float-end">Cancelar</a>
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
<script>
    jQuery(document).ready(function(){
        jQuery("#hvp_datos_personales_nombre_1").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_datos_personales_nombre_2").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_datos_personales_apellido_1").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_datos_personales_apellido_2").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_contacto_correo_corporativo").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toLowerCase());
        });
    });
</script>
