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
                    <div class="col-md-8">
                        <div class="bg-white rounded-3 col-lg-12 col-md-12 col-12">
                            <div class="row mb-5">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="row p-6 d-lg-flex justify-content-between align-items-center ">
                                        <div class="col-md-12 mb-3">
                                            <h3 class="py-0 my-0"><?php echo $data['resultado_registros'][0]->enc_titulo; ?></h3>
                                            <small class="text-muted"><?php echo $data['resultado_registros'][0]->enc_descripcion; ?></small>
                                        </div>
                                        <?php if($_SESSION[APP_SESSION.'_encuestas_respuestas_add']!=1): ?>
                                        <div class="col-md-12">
                                            <?php foreach ($data['resultado_registros_preguntas'] as $registro_pregunta): ?>
                                                <div class="col-md-12">
                                                    <p class="alert alert-corp p-1 my-0">
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
                                                                    <input class="form-check-input me-1" type="radio" name="pregunta_<?php echo $registro_pregunta->encp_id; ?>" value="Verdadero" required>
                                                                    Verdadero
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <input class="form-check-input me-1" type="radio" name="pregunta_<?php echo $registro_pregunta->encp_id; ?>" value="Falso" required>
                                                                    Falso
                                                                </li>
                                                            </ul>
                                                        <?php elseif ($registro_pregunta->encp_tipo=='opcion_multiple'): ?>
                                                            <?php
                                                                $opciones=explode(';', $registro_pregunta->encp_opciones);
                                                            ?>
                                                            <!-- Checkbox and radio -->
                                                            <ul class="list-group">
                                                                <?php for ($i=0; $i < count($opciones); $i++): ?>
                                                                <li class="list-group-item">
                                                                    <input class="form-check-input me-1" type="radio" name="pregunta_<?php echo $registro_pregunta->encp_id; ?>" value="<?php echo $opciones[$i]; ?>" required>
                                                                    <?php echo $opciones[$i]; ?>
                                                                </li>
                                                                <?php endfor; ?>
                                                            </ul>
                                                        <?php elseif ($registro_pregunta->encp_tipo=='opcion_multiple' OR $registro_pregunta->encp_tipo=='lista_desplegable'): ?>
                                                            <?php
                                                                $opciones=explode(';', $registro_pregunta->encp_opciones);
                                                            ?>
                                                            <select class="form-select form-select-sm" name="pregunta_<?php echo $registro_pregunta->encp_id; ?>" required>
                                                                <option value=""></option>
                                                                <?php for ($i=0; $i < count($opciones); $i++): ?>
                                                                    <option value="<?php echo $opciones[$i]; ?>"><?php echo $opciones[$i]; ?></option>
                                                                <?php endfor; ?>
                                                            </select>
                                                        <?php elseif($registro_pregunta->encp_tipo=='abierta'): ?>
                                                            <div class="col-md-12">
                                                                <div class="form-group my-1">
                                                                    <input type="text" class="form-control form-control-sm font-size-11" name="pregunta_<?php echo $registro_pregunta->encp_id; ?>" maxlength="100" value="" required>
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
                                        <?php endif; ?>
                                        <?php echo Flasher::flash(); ?>
                                        <div class="col-md-12 text-end">
                                            <?php if($_SESSION[APP_SESSION.'_encuestas_respuestas_add']==1): ?>
                                                <a href="<?php echo URL; ?>inicio" class="btn btn-dark float-end">Finalizar</a>
                                            <?php else: ?>
                                                <button class="btn btn-success float-end ms-1" type="submit" name="form_guardar" id="guardar_registro_btn">Guardar</button>
                                                <a href="<?php echo URL; ?>inicio" class="btn btn-danger float-end">Cancelar</a>
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
<?php require_once INCLUDES.'inc_footer.php'; ?>