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
                                                    <div class="col-md-12 mb-3" id="mensajes_alerta"></div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="enc_estado" class="form-label my-0 font-size-11">Estado</label>
                                                        <select class="form-select form-select-sm" name="enc_estado" id="enc_estado" <?php echo ($_SESSION[APP_SESSION.'_encuestas_add']==1) ? 'disabled' : ''; ?> required>
                                                            <option value=""></option>
                                                            <option value="Activo" <?php echo (isset($_POST["form_guardar"]) AND $_POST['enc_estado']=='Activo') ? 'selected' : ''; ?>>Activo</option>
                                                            <option value="Inactivo" <?php echo (isset($_POST["form_guardar"]) AND $_POST['enc_estado']=='Inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="enc_titulo" class="form-label my-0 font-size-11">Título</label>
                                                        <input type="text" class="form-control form-control-sm" name="enc_titulo" id="enc_titulo" value="<?php echo (isset($_POST["form_guardar"])) ? $_POST['enc_titulo'] : ''; ?>" <?php echo ($_SESSION[APP_SESSION.'_encuestas_add']==1) ? 'disabled' : ''; ?> required>
                                                    </div>
<!--                                                     
                                                    <div class="col-md-12 mb-3">
                                                        <div class="form-group">
                                                            <label for="hva_area" class="form-label my-0 font-size-11">Centro de costo</label>
                                                            <select class="selectpicker form-control form-control-sm font-size-11" name="hva_area" id="hva_area" <?php echo ($_SESSION[APP_SESSION.'_encuestas_add']==1) ? 'disabled' : ''; ?> data-live-search="true" data-container="body" title="Seleccione" required>
                                                                <?php foreach ($data['resultado_registros_area_lista'] as $registro): ?>
                                                                    <option value="<?php echo $registro->aa_id; ?>" class="font-size-11" <?php echo (isset($_POST["form_guardar"]) AND $_POST['hva_area']==$registro->aa_id) ? 'selected' : ''; ?>><?php echo $registro->aa_nombre; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-md-12 mb-3">
                                                        <label for="enc_descripcion" class="form-label my-0 font-size-11">Descripción</label>
                                                        <textarea class="form-control form-control-sm" name="enc_descripcion" id="enc_descripcion" rows="3" maxlength="500" <?php echo ($_SESSION[APP_SESSION.'_encuestas_add']==1) ? 'disabled' : ''; ?>><?php echo (isset($_POST["form_guardar"])) ? $_POST['enc_descripcion'] : ''; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php echo Flasher::flash(); ?>
                                            <div class="col-md-12 text-end">
                                                <?php if($_SESSION[APP_SESSION.'_encuestas_add']==1): ?>
                                                    <a href="<?php echo URL; ?>encuestas/configuracion/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>" class="btn btn-dark float-end">Finalizar</a>
                                                <?php else: ?>
                                                    <button class="btn btn-success float-end ms-1" type="submit" name="form_guardar" id="guardar_registro_btn">Guardar</button>
                                                    <a href="<?php echo URL; ?>encuestas/configuracion/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>" class="btn btn-danger float-end">Cancelar</a>
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