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
                                                    <div class="col-md-12 mb-3">
                                                        <p class="p-1 m-0">¡Por favor seleccione el formato de excel para actualizar los correos electrónicos, verifique antes de continuar!</p>
                                                    </div>
                                                    <div class="col-md-12 mb-3" id="mensajes_alerta"></div>
                                                    <div class="col-12 mb-3">
                                                        <label for="documento_masivo" class="form-label my-0 font-size-11">Formato actualización masiva</label>
                                                        <small class="fst-italic text-danger font-size-11">Adjunte la plantilla para actualización masiva de correo corporativo en formato XLSX</small>
                                                        <input type="file" class="form-control form-control-sm" name="documento_masivo" id="documento_masivo" accept=".xls, .XLS, .xlsx, .XLSX" <?php echo ($_SESSION[APP_SESSION.'_correo_masivo_add']==1) ? 'disabled' : ''; ?> required>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php echo Flasher::flash(); ?>
                                            <?php if(count($data['resultado_registros_errores'])>0): ?>
                                                <!-- <div class="col-md-12 mb-2 mt-2">
                                                    <p class="alert alert-warning p-1">Se encontraron las siguientes novedades:</p>
                                                    <?php for ($i=0; $i < count($data['resultado_registros_errores']); $i++): ?>
                                                        <p class="alert alert-danger p-1 my-0"><?php echo $data['resultado_registros_errores'][$i]; ?></p>
                                                    <?php endfor; ?>
                                                </div> -->
                                            <?php endif; ?>
                                            <?php if(count($data['resultado_registros_creados'])>0): ?>
                                                <!-- <div class="col-md-12 mb-2 mt-2">
                                                    <p class="alert alert-warning p-1">Se actualizaron los siguientes documentos:</p>
                                                    <?php for ($i=0; $i < count($data['resultado_registros_creados']); $i++): ?>
                                                        <p class="alert alert-success p-1 my-0"><?php echo $data['resultado_registros_creados'][$i]; ?></p>
                                                    <?php endfor; ?>
                                                </div> -->
                                            <?php endif; ?>
                                            <?php if(count($data['resultado_registros_base'])>0): ?>
                                                <div class="col-md-12 mb-2 mt-2">
                                                    <p class="p-1">Resultados de la actualización:</p>
                                                    <div class="table-responsive table-fixed">
                                                        <table class="table table-hover table-bordered table-striped mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="px-1 py-2 text-center font-size-12 align-middle">No Identificación</th>
                                                                    <th class="px-1 py-2 text-center font-size-12 align-middle">Correo Corporativo</th>
                                                                    <th class="px-1 py-2 text-center font-size-12 align-middle">NT</th>
                                                                    <th class="px-1 py-2 text-center font-size-12 align-middle">Validación Datos</th>
                                                                    <th class="px-1 py-2 text-center font-size-12 align-middle">Aspirante</th>
                                                                    <th class="px-1 py-2 text-center font-size-12 align-middle">Usuario</th>
                                                                    <th class="px-1 py-2 text-center font-size-12 align-middle">Hoja de Vida</th>
                                                                    <th class="px-1 py-2 text-center font-size-12 align-middle">Estado Correo</th>
                                                                    <th class="px-1 py-2 text-center font-size-12 align-middle">Estado NT</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php for ($i=0; $i < count($data['resultado_registros_base']); $i++): ?>
                                                                    <?php
                                                                        $documento_identidad = $data['resultado_registros_base'][$i]['documento_identidad'];
                                                                        $correo_corporativo = $data['resultado_registros_base'][$i]['correo'];
                                                                        $usuario_nt = $data['resultado_registros_base'][$i]['usuario_nt'];
                                                                    ?>
                                                                    <tr>
                                                                        <td class="p-1 font-size-11 align-middle"><?php echo $documento_identidad; ?></td>
                                                                        <td class="p-1 font-size-11 align-middle"><?php echo $correo_corporativo; ?></td>
                                                                        <td class="p-1 font-size-11 align-middle"><?php echo $usuario_nt; ?></td>
                                                                        <td class="p-1 font-size-11 align-middle text-center">
                                                                            <?php if($data['resultado_registros_update'][$documento_identidad]['datos']=='Validado'): ?>
                                                                                <span class="badge bg-success">Validado</span>
                                                                            <?php elseif($data['resultado_registros_update'][$documento_identidad]['datos']=='No validado'): ?>
                                                                                <span class="badge bg-danger">No validado</span>

                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td class="p-1 font-size-11 align-middle text-center">
                                                                            <?php if($data['resultado_registros_update'][$documento_identidad]['aspirante']=='Encontrado'): ?>
                                                                                <span class="badge bg-success">Encontrado</span>
                                                                            <?php elseif($data['resultado_registros_update'][$documento_identidad]['aspirante']=='No encontrado'): ?>
                                                                                <span class="badge bg-danger">No encontrado</span>

                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td class="p-1 font-size-11 align-middle text-center">
                                                                            <?php if($data['resultado_registros_update'][$documento_identidad]['usuario']=='Encontrado' OR $data['resultado_registros_update'][$documento_identidad]['usuario']=='Creado'): ?>
                                                                                <span class="badge bg-success"><?php echo $data['resultado_registros_update'][$documento_identidad]['usuario']; ?></span>
                                                                            <?php elseif($data['resultado_registros_update'][$documento_identidad]['usuario']=='Error'): ?>
                                                                                <span class="badge bg-danger">Error</span>

                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td class="p-1 font-size-11 align-middle text-center">
                                                                        <?php if($data['resultado_registros_update'][$documento_identidad]['hoja_vida']=='Encontrado' OR $data['resultado_registros_update'][$documento_identidad]['hoja_vida']=='Creado'): ?>
                                                                                <span class="badge bg-success"><?php echo $data['resultado_registros_update'][$documento_identidad]['hoja_vida']; ?></span>
                                                                            <?php elseif($data['resultado_registros_update'][$documento_identidad]['hoja_vida']=='Error'): ?>
                                                                                <span class="badge bg-danger">Error</span>

                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td class="p-1 font-size-11 align-middle text-center">
                                                                            <?php if($data['resultado_registros_update'][$documento_identidad]['correo']=='Actualizado'): ?>
                                                                                <span class="badge bg-success">Actualizado</span>
                                                                            <?php else: ?>
                                                                                <span class="badge bg-danger">No actualizado</span>

                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td class="p-1 font-size-11 align-middle text-center">
                                                                            <?php if($data['resultado_registros_update'][$documento_identidad]['nt']=='Actualizado'): ?>
                                                                                <span class="badge bg-success">Actualizado</span>
                                                                            <?php else: ?>
                                                                                <span class="badge bg-danger">No actualizado</span>

                                                                            <?php endif; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php endfor; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <div class="col-md-12 text-end">
                                                <?php if($_SESSION[APP_SESSION.'_correo_masivo_add']==1): ?>
                                                    <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>" class="btn btn-dark float-end">Finalizar</a>
                                                <?php else: ?>
                                                    <button class="btn btn-success float-end ms-1" type="submit" name="form_guardar" id="guardar_registro_btn">Guardar</button>
                                                    <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>" class="btn btn-danger float-end">Cancelar</a>
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