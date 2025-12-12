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
                                            </div>
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
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="alert alert-corp p-1 font-size-11 my-0"><span class="fas fa-info-circle"></span> Información Oferta</p>
                                            </div>
                                            <div class="table-responsive table-fixed">
                                                <table class="table table-hover table-bordered table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="px-1 py-2 text-center font-size-12 align-middle">Estado</th>
                                                        <th class="px-1 py-2 text-center font-size-12 align-middle">Centro de Costo	</th>
                                                        <th class="px-1 py-2 text-center font-size-12 align-middle">Cargo</th>
                                                        <th class="px-1 py-2 text-center font-size-12 align-middle">Director</th>
                                                        <th class="px-1 py-2 text-center font-size-12 align-middle">Debida Diligencia</th>
                                                        <th class="px-1 py-2 text-center font-size-12 align-middle">Confiabilidad</th>
                                                        <th class="px-1 py-2 text-center font-size-12 align-middle">Exámen Médico</th>
                                                        <th class="px-1 py-2 text-center font-size-12 align-middle">Contratación</th>
                                                        <th class="px-1 py-2 text-center font-size-12 align-middle">Fecha Diligencia</th>
                                                        <th class="px-1 py-2 text-center font-size-12 align-middle">Psicólogo</th>
                                                        <th class="px-1 py-2 text-center font-size-12 align-middle">Fecha Registro</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($data['resultado_registros_ofertas'] as $registro): ?>
                                                        <tr>
                                                            <td class="p-1 font-size-11 align-middle text-center">
                                                                <?php echo $registro->hvao_estado; ?>
                                                            </td>
                                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->aa_nombre; ?></td>
                                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->ac_nombre; ?></td>
                                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->usuario_director; ?></td>
                                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvao_debida_diligencia; ?></td>
                                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvao_prueba_confiabilidad; ?></td>
                                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvao_examen_medico; ?></td>
                                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvao_check_contratacion; ?></td>
                                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvao_fecha_diligencia; ?></td>
                                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->usuario_psicologo; ?></td>
                                                            <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvao_registro_fecha; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                                </table>
                                                <?php if($data['resultado_registros_ofertas_count']==0): ?>
                                                    <p class="alert alert-dark p-1 mt-0">¡No se encontraron registros!</p>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row mb-2">
                                                    <div class="col-md-4 mb-1">
                                                        <label for="hvao_reenviar" class="form-label my-0 font-size-11">Enviar recordatorio?</label>
                                                        <select class="form-select form-select-sm" name="hvao_reenviar" id="hvao_reenviar" <?php echo ($_SESSION[APP_SESSION.'_proceso_reenviar_add']==1) ? 'disabled' : ''; ?> required>
                                                            <option value=""></option>
                                                            <option value="Si" <?php echo (isset($_POST["form_guardar"]) AND $_POST['hvao_reenviar']=='Si') ? 'selected' : ''; ?>>Si</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php echo Flasher::flash(); ?>
                                            <div class="col-md-12 text-end">
                                                <?php if($_SESSION[APP_SESSION.'_proceso_reenviar_add']==1): ?>
                                                    <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes-ofertas/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>/<?php echo $data['id_registro']; ?>" class="btn btn-dark float-end">Finalizar</a>
                                                <?php else: ?>
                                                    <button class="btn btn-success float-end ms-1" type="submit" name="form_guardar" id="guardar_registro_btn">Guardar</button>
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
<?php require_once INCLUDES.'inc_footer.php'; ?>