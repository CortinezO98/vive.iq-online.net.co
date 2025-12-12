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
                                                                    <td class="p-1 font-size-11 align-middle"><?php echo $registro->enc_estado; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="p-1 font-size-11 align-middle">Título</th>
                                                                    <td class="p-1 font-size-11 align-middle"><?php echo $registro->enc_titulo; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="p-1 font-size-11 align-middle">Descripción</th>
                                                                    <td class="p-1 font-size-11 align-middle"><?php echo $registro->enc_descripcion; ?></td>
                                                                </tr>
                                                                <!-- <tr>
                                                                    <th class="p-1 font-size-11 align-middle">Actualizado</th>
                                                                    <td class="p-1 font-size-11 align-middle">
                                                                        <?php echo $registro->usuario_actualiza; ?>
                                                                        <br><?php echo $registro->hva_actualiza_fecha; ?>
                                                                    </td>
                                                                </tr> -->
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
                                        <div class="row pe-0">
                                            <div class="col-md-12 mb-1 text-end px-0" id="menu_bandejas">
                                                <a href="<?php echo URL; ?>encuestas/configuracion/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo base64_encode('Todos'); ?>" class="btn pt-1 px-2 btn-warning btn-sm btn-icon-text font-size-12" title="Todos">
                                                    <i class="fas fa-arrow-left btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Regresar</span>
                                                </a>
                                                
                                                <a href="#" onclick="open_modal_preguntas('<?php echo $data['id_registro']; ?>', 'abierta', 'crear');" class="btn pt-1 px-2 btn-dark btn-sm btn-corp btn-icon-text font-size-12" title="Respuesta abierta">
                                                    <i class="fas fa-keyboard btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Respuesta abierta</span>
                                                </a>
                                                <a href="#" onclick="open_modal_preguntas('<?php echo $data['id_registro']; ?>', 'lista_desplegable', 'crear');" class="btn pt-1 px-2 btn-dark btn-sm btn-corp btn-icon-text font-size-12" title="Lista desplegable">
                                                    <i class="fas fa-list-check btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Lista desplegable</span>
                                                </a>
                                                <a href="#" onclick="open_modal_preguntas('<?php echo $data['id_registro']; ?>', 'opcion_multiple', 'crear');" class="btn pt-1 px-2 btn-dark btn-sm btn-corp btn-icon-text font-size-12" title="Opción múltiple/única respuesta">
                                                    <i class="fas fa-check-circle btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Opción múltiple/única respuesta</span>
                                                </a>
                                                <a href="#" onclick="open_modal_preguntas('<?php echo $data['id_registro']; ?>', 'verdadero_falso', 'crear');" class="btn pt-1 px-2 btn-dark btn-sm btn-corp btn-icon-text font-size-12" title="Verdadero/Falso">
                                                    <i class="fas fa-arrows-alt-h btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Verdadero/Falso</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <?php foreach ($data['resultado_registros_preguntas'] as $registro_pregunta): ?>
                                                <div class="col-md-12">
                                                    <p class="alert alert-corp p-1 font-size-11 my-0">
                                                        <a href="#" onClick="open_modal_preguntas('<?php echo base64_encode($registro_pregunta->encp_encuesta); ?>', '<?php echo $registro_pregunta->encp_tipo; ?>', 'editar', '<?php echo base64_encode($registro_pregunta->encp_id); ?>');" class="btn btn-warning btn-sm btn-width mb-1 me-2" title="Editar"><span class="fas fa-pen"></span></a>
                                                        <!-- <a href="#" onClick="open_modal_preguntas('<?php echo base64_encode($registro_pregunta->encp_encuesta); ?>', '<?php echo $registro_pregunta->encp_tipo; ?>', 'eliminar', '<?php echo base64_encode($registro_pregunta->encp_id); ?>');" class="btn btn-danger btn-sm btn-width mb-1" title="Eliminar"><span class="fas fa-trash-alt"></span></a> -->
                                                        <?php echo $registro_pregunta->encp_orden.'. '.nl2br($registro_pregunta->encp_pregunta); ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-12 mt-0 py-2 pl-1">
                                                    <?php
                                                        if ($registro_pregunta->encp_tipo=='verdadero_falso') {
                                                            $complemento_enunciado='Responda verdadero o falso:';
                                                        } elseif ($registro_pregunta->encp_tipo=='opcion_multiple' OR $registro_pregunta->encp_tipo=='lista_desplegable') {
                                                            $complemento_enunciado='Opción múltiple con única respuesta:';
                                                        } elseif ($registro_pregunta->encp_tipo=='opcion_multiple_mr') {
                                                            $complemento_enunciado='Opción múltiple con múltiple respuesta:';
                                                        }
                                                    ?>
                                                    <div class="mb-2 pl-3">
                                                        <?php if($registro_pregunta->encp_tipo=='opcion_multiple_mr'): ?>
                                                            <b>Seleccione más de una opción:</b>
                                                        <?php elseif($registro_pregunta->encp_tipo=='opcion_multiple' OR $registro_pregunta->encp_tipo=='lista_desplegable'): ?>
                                                            <b>Seleccione una opción:</b>
                                                            <?php elseif($registro_pregunta->encp_tipo=='verdadero_falso'): ?>
                                                            <b>Seleccione una opción:</b>
                                                        <?php else: ?>
                                                            <b>Responda:</b>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="mb-2 pl-3">
                                                        <?php if($registro_pregunta->encp_tipo=='verdadero_falso'): ?>
                                                            <!-- Checkbox and radio -->
                                                            <ul class="list-group">
                                                                <li class="list-group-item">
                                                                    <input class="form-check-input me-1" type="radio" name="falso_verdadero<?php echo $registro_pregunta->encp_id; ?>" value="" disabled>
                                                                    Verdadero
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <input class="form-check-input me-1" type="radio" name="falso_verdadero<?php echo $registro_pregunta->encp_id; ?>" value="" disabled>
                                                                    Falso
                                                                </li>
                                                            </ul>
                                                        <?php elseif ($registro_pregunta->encp_tipo=='opcion_multiple' OR $registro_pregunta->encp_tipo=='lista_desplegable'): ?>
                                                            <?php
                                                                $opciones=explode(';', $registro_pregunta->encp_opciones);
                                                            ?>
                                                            <!-- Checkbox and radio -->
                                                            <ul class="list-group">
                                                                <?php for ($i=0; $i < count($opciones); $i++): ?>
                                                                <li class="list-group-item">
                                                                    <input class="form-check-input me-1" type="radio" name="opciones_<?php echo $registro_pregunta->encp_id; ?>" value="" disabled>
                                                                    <?php echo $opciones[$i]; ?>
                                                                </li>
                                                                <?php endfor; ?>
                                                            </ul>
                                                        <?php elseif($registro_pregunta->encp_tipo=='abierta'): ?>
                                                            <div class="col-md-12">
                                                                <div class="form-group my-1">
                                                                    <input type="text" class="form-control form-control-sm font-size-11" name="respuesta_abierta_<?php echo $registro_pregunta->encp_id; ?>" maxlength="100" value="" disabled>
                                                                </div>
                                                            </div>
                                                        <?php elseif ($registro_pregunta->encp_tipo=='opcion_multiple_mr'): ?>
                                                            <?php echo $registro_pregunta->encp_opciones; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                            <?php if($data['resultado_registros_preguntas_count']==0): ?>
                                                <p class="alert alert-dark p-1 mt-0">¡No se encontraron registros!</p>
                                            <?php endif; ?>
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
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body-detalle">

            </div>
            <div class="modal-footer">
                <a href="#" onClick="close_modal_preguntas();" class="btn btn-danger float-end" data-bs-dismiss="modal" id="btnCancelar">Cerrar</a>
                <button class="btn btn-success float-end ms-1" name="form_guardar" id="btnEnviar" onclick="guardar();">Guardar</button>
            </div>
        </div>
        </div>
    </div>
<?php require_once INCLUDES.'inc_footer.php'; ?>
<script type="text/javascript">
    function open_modal_preguntas(id_encuesta, tipo, accion, id_pregunta = null) {
        var myModal = new bootstrap.Modal(document.getElementById("modal-detalle"), {});
        $('.modal-body-detalle').load('<?php echo URL; ?>encuestas/configuracion-preguntas-crear/'+id_encuesta+'/'+tipo+'/'+accion+'/'+id_pregunta,function(){
            myModal.show();
        });
    }

    function close_modal_preguntas() {
        var myModal = new bootstrap.Modal(document.getElementById("modal-detalle"), {});
        $('.modal-body-detalle').html('');
        window.location.reload();
    }
</script>