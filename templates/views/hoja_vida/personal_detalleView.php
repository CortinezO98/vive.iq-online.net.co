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
                    <div class="col-md-3">
                        <div class="bg-white rounded-3 col-lg-12 col-md-12 col-12">
                            <div class="row mb-5">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="row p-6 d-lg-flex justify-content-between align-items-center ">
                                        <div class="col-md-12">
                                            <p class="alert alert-corp p-1 font-size-11 my-0">
                                                <span class="fas fa-info-circle"></span> Información Aspirante
                                                <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor'): ?>
                                                    <a href="<?php echo URL; ?>hoja-vida/personal-editar/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>/<?php echo $data['id_registro']; ?>" class="btn py-0 px-2 btn-warning btn-sm btn-corp btn-icon-text font-size-11 float-end" title="Editar">
                                                        <i class="fas fa-pen btn-icon-prepend me-0 me-lg-1 font-size-11"></i><span class="d-none d-lg-inline">Editar</span>
                                                    </a>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <div class="table-responsive table-fixed">
                                            <table class="table table-hover table-bordered table-striped mb-1">
                                                <tbody>
                                                    <?php foreach ($data['resultado_registros'] as $registro): ?>
                                                        <tr>
                                                            <th class="p-1 font-size-11 align-middle">Estado</th>
                                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvp_estado; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="p-1 font-size-11 align-middle">No Identificación</th>
                                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvp_datos_personales_numero_identificacion; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="p-1 font-size-11 align-middle">Primer Nombre</th>
                                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvp_datos_personales_nombre_1; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="p-1 font-size-11 align-middle">Segundo Nombre</th>
                                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvp_datos_personales_nombre_2; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="p-1 font-size-11 align-middle">Primer Apellido</th>
                                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvp_datos_personales_apellido_1; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="p-1 font-size-11 align-middle">Segundo Apellido</th>
                                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvp_datos_personales_apellido_2; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="p-1 font-size-11 align-middle">Correo Corporativo</th>
                                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvp_contacto_correo_corporativo; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="p-1 font-size-11 align-middle">Correo Personal</th>
                                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvp_contacto_correo_personal; ?></td>
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
                                                            <th class="p-1 font-size-11 align-middle">Progreso General</th>
                                                            <td class="p-1 font-size-11 align-middle">
                                                                <?php
                                                                    //Función para obtener el estado de los campos
                                                                    $array_registro = (array) $registro;
                                                                    $array_estados=estadoDiligenciaHV($array_registro);

                                                                    $estado_autorizaciones=$array_estados['estado_autorizaciones_icono'];
                                                                    $estado_informacion_personal=$array_estados['estado_informacion_personal_icono'];
                                                                    $estado_ubicacion_contacto=$array_estados['estado_ubicacion_contacto_icono'];
                                                                    $estado_socioeconomico_familiar=$array_estados['estado_socioeconomico_familiar_icono'];
                                                                    $estado_salud_bienestar=$array_estados['estado_salud_bienestar_icono'];
                                                                    $estado_intereses_habitos=$array_estados['estado_intereses_habitos_icono'];
                                                                    $estado_formacion_habilidades=$array_estados['estado_formacion_habilidades_icono'];
                                                                    $estado_poblaciones_relaciones=$array_estados['estado_poblaciones_relaciones_icono'];
                                                                    $estado_general=$array_estados['estado_general_icono'];
                                                                ?>
                                                                <?php echo $estado_general; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="p-1 font-size-11 align-middle">Fecha Actualización</th>
                                                            <td class="p-1 font-size-11 align-middle">
                                                                <?php
                                                                    // Fecha actual
                                                                    $fecha_actual = new DateTime();

                                                                    if ($registro->hvp_actualiza_fecha!='') {
                                                                        // Fecha de inicio (puedes poner cualquier fecha en formato 'YYYY-MM-DD')
                                                                        $fecha_inicio = new DateTime($registro->hvp_actualiza_fecha);
                                                                    } else {
                                                                        // Fecha de inicio (puedes poner cualquier fecha en formato 'YYYY-MM-DD')
                                                                        $fecha_inicio = new DateTime($registro->hvp_registro_fecha);
                                                                    }
                                                                    
                                                                    // Calcular la diferencia entre las dos fechas
                                                                    $diferencia = $fecha_actual->diff($fecha_inicio);
                                                                    $dias_diferencia=$diferencia->days;    
                                                                    
                                                                ?>
                                                                <?php if($dias_diferencia<30): ?>
                                                                    <span class="badge bg-success"><?php echo $dias_diferencia; ?> días</span>
                                                                <?php else: ?>
                                                                    <span class="badge bg-warning"><?php echo $dias_diferencia; ?> días</span>
                                                                <?php endif; ?>
                                                                <?php echo ($registro->hvp_actualiza_fecha!='') ? date('d/m/Y', strtotime($registro->hvp_actualiza_fecha)) : date('d/m/Y', strtotime($registro->hvp_registro_fecha)); ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="p-1 font-size-11 align-middle">Fecha Ingreso</th>
                                                            <td class="p-1 font-size-11 align-middle"><?php echo ($registro->hvp_fecha_ingreso!='') ? date('d/m/Y', strtotime($registro->hvp_fecha_ingreso)) : ''; ?></td>
                                                        </tr>
                                                        <?php if($registro->hvp_estado='Retirado'): ?>
                                                            <tr>
                                                                <th class="p-1 font-size-11 align-middle">Fecha Retiro</th>
                                                                <td class="p-1 font-size-11 align-middle"><?php echo ($registro->hvp_retiro_fecha!='') ? date('d/m/Y', strtotime($registro->hvp_retiro_fecha)) : ''; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th class="p-1 font-size-11 align-middle">Motivo Retiro</th>
                                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvp_retiro_motivo; ?></td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor'): ?>
                                            <?php $modo_secciones='lectura'; ?>
                                            <?php require_once INCLUDES.'inc_secciones_hoja_vida.php'; ?>
                                        <?php endif; ?>
                                        <div class="col-md-12">
                                            <p class="alert alert-corp p-1 font-size-11 my-0">
                                                <span><span class="fas fa-file"></span> Documentos</span>
                                            </p>
                                        </div>
                                        <div class="table-responsive table-fixed">
                                            <table class="table table-hover table-bordered table-striped mb-0">
                                                <tbody>
                                                    <?php if($data['resultado_registros'][0]->hvp_auxiliar_4!=''): ?>
                                                        <?php
                                                            $control_documentos++;
                                                        ?>
                                                        <tr>
                                                            <th class="p-1 font-size-11 align-middle" style="width: 80px;">
                                                                <a href="#" class="btn btn-dark btn-sm font-size-10 btn-table" title="Ver" onclick="open_modal_documentos('<?php echo base64_encode($data['resultado_registros'][0]->hvp_auxiliar_4); ?>');"><i class="fas fa-file-alt font-size-11"></i></a>
                                                                <a href="<?php echo URL; ?>descargar/adjuntos/<?php echo base64_encode($data['resultado_registros'][0]->hvp_auxiliar_4); ?>/<?php echo base64_encode($data['resultado_registros'][0]->hvp_datos_personales_nombre_1.' '.$data['resultado_registros'][0]->hvp_datos_personales_nombre_2.' '.$data['resultado_registros'][0]->hvp_datos_personales_apellido_1.' '.$data['resultado_registros'][0]->hvp_datos_personales_apellido_2.'-Certificado último estudio'); ?>" class="btn btn-success btn-sm font-size-11 btn-table" target="_blank" title="Descargar"><i class="fas fa-file-download font-size-11"></i></a>
                                                            </th>
                                                            <th class="p-1 font-size-11 align-middle">
                                                                Certificado último estudio
                                                            </th>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if($data['resultado_registros'][0]->hvp_auxiliar_5!=''): ?>
                                                        <?php
                                                            $control_documentos++;    
                                                        ?>
                                                        <tr>
                                                            <th class="p-1 font-size-11 align-middle" style="width: 80px;">
                                                                <a href="#" class="btn btn-dark btn-sm font-size-10 btn-table" title="Ver" onclick="open_modal_documentos('<?php echo base64_encode($data['resultado_registros'][0]->hvp_auxiliar_5); ?>');"><i class="fas fa-file-alt font-size-11"></i></a>
                                                                <a href="<?php echo URL; ?>descargar/adjuntos/<?php echo base64_encode($data['resultado_registros'][0]->hvp_auxiliar_5); ?>/<?php echo base64_encode($data['resultado_registros'][0]->hvp_datos_personales_nombre_1.' '.$data['resultado_registros'][0]->hvp_datos_personales_nombre_2.' '.$data['resultado_registros'][0]->hvp_datos_personales_apellido_1.' '.$data['resultado_registros'][0]->hvp_datos_personales_apellido_2.'-Tarjeta Profesional'); ?>" class="btn btn-success btn-sm font-size-11 btn-table" target="_blank" title="Descargar"><i class="fas fa-file-download font-size-11"></i></a>
                                                            </th>
                                                            <th class="p-1 font-size-11 align-middle">
                                                                Tarjeta Profesional
                                                            </th>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if($data['resultado_registros'][0]->hvp_consentimiento_tratamiento_datos_personales!='' AND $data['resultado_registros'][0]->hvp_auxiliar_3!=''): ?>
                                                        <?php
                                                            $control_documentos++;    
                                                        ?>
                                                        <tr>
                                                            <th class="p-1 font-size-11 align-middle" style="width: 80px;">
                                                                <a href="<?php echo URL; ?>hoja-vida/personal-autorizacion-descargar/<?php echo base64_encode($data['resultado_registros'][0]->hvp_id); ?>" class="btn btn-success btn-sm font-size-11 btn-table" target="_blank" title="Descargar"><i class="fas fa-file-download font-size-11"></i></a>
                                                            </th>
                                                            <th class="p-1 font-size-11 align-middle">
                                                                Formato Autorización de Tratamiento de Datos Personales
                                                            </th>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if($control_documentos==0): ?>
                                                        <tr>
                                                            <th class="p-1 font-size-11 align-middle" colspan="2">
                                                                <p class="alert alert-warning p-1 font-size-11">¡No se encontraron documentos!</p>
                                                            </th>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="bg-white rounded-3 col-lg-12 col-md-12 col-12">
                            <div class="row mb-5">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="row p-6 d-lg-flex justify-content-between align-items-center ">
                                        <div class="row pe-0">
                                            <div class="col-md-12 mb-1 text-end px-0" id="menu_bandejas">
                                                <a href="<?php echo URL; ?>hoja-vida/personal/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>" class="btn pt-1 px-2 btn-dark btn-sm btn-corp btn-icon-text font-size-12" title="Todos">
                                                    <i class="fas fa-arrow-left btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Regresar</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row" id="secciones_hoja_vida_detalle">
                                                <?php if($data['modulo_perfil']=='Contratación'): ?>
                                                    <div class="col-md-12 my-1">
                                                        <fieldset class="border rounded-3 px-3 py-1">
                                                            <legend class="float-none w-auto px-2 font-size-12 fw-bold">
                                                                Certificado último estudio
                                                            </legend>
                                                            <?php if($data['resultado_registros'][0]->hvp_auxiliar_4!=''): ?>
                                                                <embed src="<?php echo UPLOADS; ?><?php echo $data['resultado_registros'][0]->hvp_auxiliar_4; ?>" type="application/pdf" width="100%" height="600px" />
                                                            <?php else: ?>
                                                                <p class="alert alert-warning p-1 font-size-11">No se ha cargado el documento.</p>
                                                            <?php endif; ?>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-12 my-1">
                                                        <fieldset class="border rounded-3 px-3 py-1">
                                                            <legend class="float-none w-auto px-2 font-size-12 fw-bold">
                                                                Tarjeta Profesional
                                                            </legend>
                                                            <?php if($data['resultado_registros'][0]->hvp_auxiliar_5!=''): ?>
                                                                <embed src="<?php echo UPLOADS; ?><?php echo $data['resultado_registros'][0]->hvp_auxiliar_5; ?>" type="application/pdf" width="100%" height="600px" />
                                                            <?php else: ?>
                                                                <p class="alert alert-warning p-1 font-size-11">No se ha cargado el documento.</p>
                                                            <?php endif; ?>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-12 my-1">
                                                        <fieldset class="border rounded-3 px-3 py-1">
                                                            <legend class="float-none w-auto px-2 font-size-12 fw-bold">
                                                                Formato Autorización de Tratamiento de Datos Personales
                                                            </legend>
                                                            <?php if($data['resultado_registros'][0]->hvp_consentimiento_tratamiento_datos_personales!='' AND $data['resultado_registros'][0]->hvp_auxiliar_3!=''): ?>
                                                                <embed src="<?php echo URL; ?>hoja-vida/personal-autorizacion-descargar/<?php echo base64_encode($data['resultado_registros'][0]->hvp_id); ?>/view" type="application/pdf" width="100%" height="600px" />
                                                            <?php else: ?>
                                                                <p class="alert alert-warning p-1 font-size-11">No se ha firmado el documento.</p>
                                                            <?php endif; ?>
                                                        </fieldset>
                                                    </div>
                                                    <?php echo Flasher::flash(); ?>
                                                    <form name="form_guardar_documentos" action="" method="post" class="comment-form" enctype="multipart/form-data">
                                                        <div class="col-md-12 text-end">
                                                            <button class="btn btn-warning float-end ms-1" type="submit" name="form_guardar_documentos" id="guardar_registro_btn">Confirmar documentos descargados</button>
                                                        </div>
                                                    </form>
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
    function open_modal_documentos(id_registro) {
        var myModal = new bootstrap.Modal(document.getElementById("modal-detalle"), {});
        $('.modal-body-detalle').load('<?php echo URL; ?>hoja-vida/personal-documentos-ver/'+id_registro,function(){
            myModal.show();
        });
    }
    <?php if($modo_secciones=='lectura'): ?>
        mostrar_seccion('instrucciones');
    <?php endif; ?>
</script>