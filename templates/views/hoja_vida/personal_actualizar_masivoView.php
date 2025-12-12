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
                                                    <div class="col-md-12 mb-3" id="mensajes_alerta">
                                                        <p class="alert alert-warning p-1 m-0">¡Por favor seleccione el tipo de actualización y cargue la lista de documentos de identidad que desea actualizar, verifique antes de continuar!</p>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label for="tipo_actualizacion" class="form-label my-0 font-size-11">Tipo de actualización</label>
                                                        <select class="form-select form-select-sm" name="tipo_actualizacion" id="tipo_actualizacion" <?php echo ($_SESSION[APP_SESSION.'_actualizar_masivo_add']==1) ? 'disabled' : ''; ?> required>
                                                            <option value=""></option>
                                                            <option value="Centro de Costo" <?php echo (isset($_POST["form_guardar"]) AND $_POST['tipo_actualizacion']=='Centro de Costo') ? 'selected' : ''; ?>>Centro de Costo</option>
                                                            <option value="Cargo" <?php echo (isset($_POST["form_guardar"]) AND $_POST['tipo_actualizacion']=='Cargo') ? 'selected' : ''; ?>>Cargo</option>
                                                        </select> 
                                                    </div>
                                                    <div class="col-12 mb-3">
                                                        <label for="documento_masivo" class="form-label my-0 font-size-11">Formato cargue masivo</label>
                                                        <small class="fst-italic text-danger font-size-11">Adjunte la plantilla para cargue masivo en formato XLSX</small>
                                                        <input type="file" class="form-control form-control-sm" name="documento_masivo" id="documento_masivo" accept=".xls, .XLS, .xlsx, .XLSX" <?php echo ($_SESSION[APP_SESSION.'_actualizar_masivo_add']==1) ? 'disabled' : ''; ?> required>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php echo Flasher::flash(); ?>
                                            <?php if(count($data['resultado_registros_errores'])>0): ?>
                                                <div class="col-md-12 mb-2 mt-2">
                                                    <p class="alert alert-warning p-1">Se encontraron las siguientes novedades:</p>
                                                    <?php for ($i=0; $i < count($data['resultado_registros_errores']); $i++): ?>
                                                        <p class="alert alert-danger p-1 my-0"><?php echo $data['resultado_registros_errores'][$i]; ?></p>
                                                    <?php endfor; ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if(count($data['resultado_registros_creados'])>0): ?>
                                                <div class="col-md-12 mb-2 mt-2">
                                                    <p class="alert alert-warning p-1">Se actualizaron los siguientes registros:</p>
                                                    <?php for ($i=0; $i < count($data['resultado_registros_creados']); $i++): ?>
                                                        <p class="alert alert-success p-1 my-0"><?php echo $data['resultado_registros_creados'][$i]; ?></p>
                                                    <?php endfor; ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="col-md-12 text-end">
                                                <?php if($_SESSION[APP_SESSION.'_actualizar_masivo_add']==1): ?>
                                                    <a href="<?php echo URL; ?>hoja-vida/personal/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>" class="btn btn-dark float-end">Finalizar</a>
                                                <?php else: ?>
                                                    <button class="btn btn-success float-end ms-1" type="submit" name="form_guardar" id="guardar_registro_btn">Guardar</button>
                                                    <a href="<?php echo URL; ?>hoja-vida/personal/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>" class="btn btn-danger float-end">Cancelar</a>
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