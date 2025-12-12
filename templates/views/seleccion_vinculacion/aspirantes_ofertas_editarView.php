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
                    <div class="col-md-4">
                        <div class="bg-white rounded-3 col-lg-12 col-md-12 col-12">
                            <div class="row mb-5">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="row p-6 d-lg-flex justify-content-between align-items-center ">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <p class="alert alert-corp p-1 font-size-11 my-0"><span class="fas fa-info-circle"></span> Información Aspirante</p>
                                                </div>
                                                <div class="table-responsive table-fixed">
                                                    <table class="table table-hover table-bordered table-striped">
                                                        <tbody>
                                                            <?php foreach ($data['resultado_registros'] as $registro): ?>
                                                                <tr>
                                                                    <th class="p-1 font-size-11 align-middle">Estado</th>
                                                                    <td class="p-1 font-size-11 align-middle"><?php echo $registro->hva_estado; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="p-1 font-size-11 align-middle">No Identificación</th>
                                                                    <td class="p-1 font-size-11 align-middle"><?php echo $registro->hva_identificacion; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="p-1 font-size-11 align-middle">Nombres y Apellidos</th>
                                                                    <td class="p-1 font-size-11 align-middle"><?php echo $registro->hva_nombres.' '.$registro->hva_nombres_2.' '.$registro->hva_apellido_1.' '.$registro->hva_apellido_2; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="p-1 font-size-11 align-middle">Celular</th>
                                                                    <td class="p-1 font-size-11 align-middle"><?php echo $registro->hva_celular; ?><?php echo ($registro->hva_celular_2!='') ? '/'.$registro->hva_celular_2 : ''; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="p-1 font-size-11 align-middle">Correo</th>
                                                                    <td class="p-1 font-size-11 align-middle"><?php echo $registro->hva_correo; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="p-1 font-size-11 align-middle">Centro de Costo</th>
                                                                    <td class="p-1 font-size-11 align-middle"><?php echo $registro->aa_nombre; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="p-1 font-size-11 align-middle">Cargo</th>
                                                                    <td class="p-1 font-size-11 align-middle"><?php echo $registro->ac_nombre; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="p-1 font-size-11 align-middle">Observaciones</th>
                                                                    <td class="p-1 font-size-11 align-middle"><?php echo $registro->hva_observaciones; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="p-1 font-size-11 align-middle">Actualizado</th>
                                                                    <td class="p-1 font-size-11 align-middle">
                                                                        <?php echo $registro->usuario_actualiza; ?>
                                                                        <br><?php echo $registro->hva_actualiza_fecha; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-12">
                                                    <p class="alert alert-corp p-1 font-size-11 my-0">
                                                        <span><span class="fas fa-file"></span> Documentos</span>
                                                        <a href="<?php echo URL; ?>seleccion-vinculacion/hoja-vida-consolidado-descargar/<?php echo $data['id_registro']; ?>" class="btn py-0 px-2 btn-success btn-sm btn-corp btn-icon-text font-size-11 me-1 float-end" title="Descargar consolidado" target="_blank">
                                                            <i class="fas fa-file-download btn-icon-prepend me-0 me-lg-1 font-size-11"></i><span class="d-none d-lg-inline">Descargar</span>
                                                        </a>
                                                    </p>
                                                </div>
                                                <div class="table-responsive table-fixed">
                                                    <table class="table table-hover table-bordered table-striped mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <th class="p-1 font-size-11 align-middle">
                                                                    <a href="#" class="btn btn-dark btn-sm font-size-10 btn-table" title="Ver" onclick="open_modal_hoja_vida('<?php echo $data['id_registro']; ?>');"><i class="fas fa-file-alt font-size-11"></i></a>
                                                                    <a href="<?php echo URL; ?>seleccion-vinculacion/hoja-vida-descargar/<?php echo $data['id_registro']; ?>/Descargar" class="btn btn-success btn-sm font-size-11 btn-table" target="_blank" title="Descargar"><i class="fas fa-file-download font-size-11"></i></a>
                                                                </th>
                                                                <th class="p-1 font-size-11 align-middle">
                                                                    Hoja de Vida
                                                                </th>
                                                            </tr>
                                                            <?php foreach ($data['resultado_registros_documentos'] as $registro): ?>
                                                                <tr>
                                                                    <th class="p-1 font-size-11 align-middle">
                                                                        <?php if($registro->hvad_ruta!=''): ?>
                                                                            <a href="#" class="btn btn-dark btn-sm font-size-10 btn-table" title="Ver" onclick="open_modal_documentos('<?php echo base64_encode($registro->hvad_id); ?>');"><i class="fas fa-file-alt font-size-11"></i></a>
                                                                        <?php endif; ?>
                                                                        <a href="<?php echo URL; ?>descargar/adjuntos/<?php echo base64_encode($registro->hvad_ruta); ?>/<?php echo base64_encode($registro->hvad_nombre); ?>" class="btn btn-success btn-sm font-size-11 btn-table" target="_blank" title="Descargar"><i class="fas fa-file-download font-size-11"></i></a>
                                                                    </th>
                                                                    <th class="p-1 font-size-11 align-middle">
                                                                        <?php echo $registro->hvad_nombre; ?>
                                                                    </th>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="bg-white rounded-3 col-lg-12 col-md-12 col-12">
                            <div class="row mb-5">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="row p-6 d-lg-flex justify-content-between align-items-center ">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row mb-2">
                                                    <div class="col-md-4 mb-1">
                                                        <label for="hvao_debida_diligencia" class="form-label my-0 font-size-11">Debida diligencia</label>
                                                        <select class="form-select form-select-sm" name="hvao_debida_diligencia" id="hvao_debida_diligencia" required>
                                                            <option value=""></option>
                                                            <option value="Aprobado" <?php echo ($data['resultado_registros_ofertas'][0]->hvao_debida_diligencia=='Aprobado') ? 'selected' : ''; ?>>Aprobado</option>
                                                            <option value="Pendiente" <?php echo ($data['resultado_registros_ofertas'][0]->hvao_debida_diligencia=='Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                                            <option value="Rechazado" <?php echo ($data['resultado_registros_ofertas'][0]->hvao_debida_diligencia=='Rechazado') ? 'selected' : ''; ?>>Rechazado</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-1">
                                                        <label for="hvao_prueba_confiabilidad" class="form-label my-0 font-size-11">Prueba confiabilidad</label>
                                                        <select class="form-select form-select-sm" name="hvao_prueba_confiabilidad" id="hvao_prueba_confiabilidad" required>
                                                            <option value=""></option>
                                                            <option value="Aprobado" <?php echo ($data['resultado_registros_ofertas'][0]->hvao_prueba_confiabilidad=='Aprobado') ? 'selected' : ''; ?>>Aprobado</option>
                                                            <option value="Pendiente" <?php echo ($data['resultado_registros_ofertas'][0]->hvao_prueba_confiabilidad=='Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                                            <option value="Rechazado" <?php echo ($data['resultado_registros_ofertas'][0]->hvao_prueba_confiabilidad=='Rechazado') ? 'selected' : ''; ?>>Rechazado</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-1">
                                                        <label for="hvao_examen_medico" class="form-label my-0 font-size-11">Exámen médico</label>
                                                        <select class="form-select form-select-sm" name="hvao_examen_medico" id="hvao_examen_medico" required>
                                                            <option value=""></option>
                                                            <option value="Aprobado" <?php echo ($data['resultado_registros_ofertas'][0]->hvao_examen_medico=='Aprobado') ? 'selected' : ''; ?>>Aprobado</option>
                                                            <option value="Pendiente" <?php echo ($data['resultado_registros_ofertas'][0]->hvao_examen_medico=='Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                                            <option value="Rechazado" <?php echo ($data['resultado_registros_ofertas'][0]->hvao_examen_medico=='Rechazado') ? 'selected' : ''; ?>>Rechazado</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-1">
                                                        <label for="hvao_check_contratacion" class="form-label my-0 font-size-11">Check contratación</label>
                                                        <select class="form-select form-select-sm" name="hvao_check_contratacion" id="hvao_check_contratacion" required>
                                                            <option value=""></option>
                                                            <option value="Pendiente" <?php echo ($data['resultado_registros_ofertas'][0]->hvao_check_contratacion=='Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                                            <option value="Aprobado" <?php echo ($data['resultado_registros_ofertas'][0]->hvao_check_contratacion=='Aprobado') ? 'selected' : ''; ?>>Aprobado</option>
                                                            <option value="Rechazado" <?php echo ($data['resultado_registros_ofertas'][0]->hvao_check_contratacion=='Rechazado') ? 'selected' : ''; ?>>Rechazado</option>
                                                            <option value="Desiste" <?php echo ($data['resultado_registros_ofertas'][0]->hvao_check_contratacion=='Desiste') ? 'selected' : ''; ?>>Desiste</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-1">
                                                        <label for="hvao_estado_fase_2" class="form-label my-0 font-size-11">Notificación fase 2</label>
                                                        <select class="form-select form-select-sm" name="hvao_estado_fase_2" id="hvao_estado_fase_2" required>
                                                            <option value=""></option>
                                                            <option value="Enviar" <?php echo ($data['resultado_registros_ofertas'][0]->hvao_estado_fase_2=='Enviar') ? 'selected' : ''; ?>>Enviar</option>
                                                            <option value="Rechazado" <?php echo ($data['resultado_registros_ofertas'][0]->hvao_estado_fase_2=='Rechazado') ? 'selected' : ''; ?>>Rechazado</option>
                                                            <option value="Enviado" <?php echo ($data['resultado_registros_ofertas'][0]->hvao_estado_fase_2=='Enviado') ? 'selected' : ''; ?>>Enviado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php echo Flasher::flash(); ?>
                                            <div class="col-md-12 text-end">
                                                <button class="btn btn-success float-end ms-1" type="submit" name="form_guardar" id="guardar_registro_btn">Guardar</button>
                                                <?php if(isset($_POST["form_guardar"])): ?>
                                                    <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes-ofertas/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>/<?php echo $data['id_registro']; ?>" class="btn btn-dark float-end">Finalizar</a>
                                                <?php endif; ?>
                                                <?php if(!isset($_POST["form_guardar"])): ?>
                                                    <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes-ofertas/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>/<?php echo $data['id_registro']; ?>" class="btn btn-danger float-end">Cancelar</a>
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
<!-- MODAL DETALLE -->
    <div class="modal fade" id="modal-detalle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Visor documentos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body-detalle">
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark py-2 px-2" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
<?php require_once INCLUDES.'inc_footer.php'; ?>
<script type="text/javascript">
    function open_modal_hoja_vida(id_registro) {
        var myModal = new bootstrap.Modal(document.getElementById("modal-detalle"), {});
        $('.modal-body-detalle').load('<?php echo URL; ?>seleccion-vinculacion/hoja-vida-ver/'+id_registro,function(){
            myModal.show();
        });
    }

    function open_modal_documentos(id_registro) {
        var myModal = new bootstrap.Modal(document.getElementById("modal-detalle"), {});
        $('.modal-body-detalle').load('<?php echo URL; ?>seleccion-vinculacion/hoja-vida-documentos-ver/'+id_registro,function(){
            myModal.show();
        });
    }
</script>