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
                            
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-3">
                    <div class="row mb-5">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="row p-6 d-lg-flex justify-content-between align-items-center ">
                                <div class="row pe-0">
                                    <div class="col-md-3 mb-1">
                                        <?php require_once INCLUDES.'inc_search.php'; ?>
                                    </div>
                                    <div class="col-md-9 mb-1 text-end px-0" id="menu_bandejas">
                                        <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Usuario'): ?>
                                            <a href="<?php echo URL; ?>hoja-vida/personal/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo base64_encode('Todos'); ?>" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" title="Todos">
                                                <i class="fas fa-users btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Todos</span>
                                            </a>
                                        <?php endif; ?>

                                        <a href="<?php echo URL; ?>hoja-vida/personal/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo base64_encode('Activos'); ?>" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" title="Activos">
                                            <i class="fas fa-user-check btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Activos</span>
                                        </a>
                                        <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Usuario'): ?>
                                            <a href="<?php echo URL; ?>hoja-vida/personal/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo base64_encode('Retirados'); ?>" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" title="Retirados">
                                                <i class="fas fa-user-times btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Retirados</span>
                                            </a>
                                        <?php endif; ?>
                                        <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Contratación'): ?>
                                            <a href="<?php echo URL; ?>hoja-vida/personal/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo base64_encode('Documentos Nuevos'); ?>" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" title="Documentos Nuevos">
                                                <i class="fas fa-file-pdf btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Documentos Nuevos</span>
                                            </a>
                                        <?php endif; ?>
                                        <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Usuario'): ?>
                                            <!-- <a href="<?php echo URL; ?>hoja-vida/personal-crear/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" title="Crear Hoja de Vida">
                                                <i class="fas fa-user-plus btn-icon-prepend font-size-12"></i>
                                            </a> -->
                                        <?php endif; ?>
                                        <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor'): ?>
                                            <a href="<?php echo URL; ?>hoja-vida/personal-actualizar-masivo/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" title="Actualizar Centro de Costo o Área Masivo">
                                                <i class="fas fa-sync-alt btn-icon-prepend font-size-12"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Cumplimiento' OR $data['modulo_perfil']=='Contratación' OR $data['modulo_perfil']=='Usuario' OR $data['modulo_perfil']=='Formación'): ?>
                                            <button type="button" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" data-bs-toggle="modal" data-bs-target="#modal-reporte" title="Reportes">
                                                <i class="fas fa-file-excel btn-icon-prepend me-0 font-size-12"></i>
                                            </button>
                                        <?php endif; ?>
                                        <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Cumplimiento'): ?>
                                            <a href="<?php echo URL; ?>hoja-vida/personal-autorizacion-descargar-zip" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" title="Descargar Formatos Autorización Tratamiento de Datos">
                                                <i class="fas fa-file-zipper btn-icon-prepend font-size-12"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="table-responsive table-fixed">
                                    <table class="table table-hover table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle" style="width: 80px;"></th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Estado</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">No Identificación</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Primer Nombre</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Segundo Nombre</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Primer Apellido</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Segundo Apellido</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Correo Corporativo</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Correo Personal</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Centro de Costo</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Cargo</th>
                                            <th class="px-1 py-2 text-center font-size-9 align-middle">Autorizaciones</th>
                                            <th class="px-1 py-2 text-center font-size-9 align-middle">Información Personal</th>
                                            <th class="px-1 py-2 text-center font-size-9 align-middle">Ubicación/ Contacto</th>
                                            <th class="px-1 py-2 text-center font-size-9 align-middle">Socioeconómico/ Familiar</th>
                                            <th class="px-1 py-2 text-center font-size-9 align-middle">Salud/ Bienestar</th>
                                            <th class="px-1 py-2 text-center font-size-9 align-middle">Intereses/ Hábitos</th>
                                            <th class="px-1 py-2 text-center font-size-9 align-middle">Formación/ Habilidades</th>
                                            <th class="px-1 py-2 text-center font-size-9 align-middle">Poblaciones/ Relaciones Familiares</th>
                                            <th class="px-1 py-2 text-center font-size-9 align-middle">Progreso General</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Fecha Actualización</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Fecha Ingreso</th>
                                            <?php if(base64_decode($data['bandeja'])=='Retirados'): ?>
                                                <th class="px-1 py-2 text-center font-size-12 align-middle">Fecha Retiro</th>
                                                <th class="px-1 py-2 text-center font-size-12 align-middle">Motivo Retiro</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['resultado_registros'] as $registro): ?>
                                            <?php
                                                $cantidad_campos = 0;
                                                $control_diligenciamiento = 0;
                                            ?>
                                            <tr>
                                                <td class="p-1 align-middle text-center">
                                                    <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Contratación'): ?>
                                                        <a href="<?php echo URL; ?>hoja-vida/personal-detalle/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>/<?php echo base64_encode($registro->hvp_id); ?>" class="btn btn-warning btn-sm font-size-11 btn-table mb-1" title="Detalle"><i class="fas fa-list-alt font-size-11"></i></a>
                                                    <?php endif; ?>
                                                    <?php if(($registro->hvp_consentimiento_tratamiento_datos_personales!='' AND $registro->hvp_auxiliar_3!='') AND ($data['modulo_perfil']=='Cumplimiento')): ?>
                                                        <a href="<?php echo URL; ?>hoja-vida/personal-autorizacion-descargar/<?php echo base64_encode($registro->hvp_id); ?>" target="_blank" class="btn btn-dark btn-sm font-size-11 btn-table mb-1" title="Editar"><i class="fas fa-file-arrow-down font-size-11"></i></a>
                                                    <?php endif; ?>
                                                    <!-- <a href="#" class="btn btn-dark btn-sm font-size-11 btn-table mb-1" title="Detalle" onclick="open_modal_ver('<?php echo base64_encode($registro->ea_id ); ?>');"><i class="fas fa-file-alt font-size-11"></i></a> -->
                                                </td>
                                                <td class="p-1 font-size-11 align-middle text-center">
                                                    <?php if($registro->hvp_estado=='Activo'): ?>
                                                        <div class="alert bg-success text-white px-1 py-0 font-size-10 m-0">Activo</div>
                                                    <?php elseif($registro->hvp_estado=='Retirado'): ?>
                                                        <div class="alert bg-dark text-white px-1 py-0 font-size-10 m-0">Retirado</div>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvp_datos_personales_numero_identificacion; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvp_datos_personales_nombre_1; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvp_datos_personales_nombre_2; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvp_datos_personales_apellido_1; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvp_datos_personales_apellido_2; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvp_contacto_correo_corporativo; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvp_contacto_correo_personal; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->aa_nombre; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->ac_nombre; ?></td>
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

                                                <!-- Autorizaciones -->
                                                <td class="p-1 font-size-11 align-middle text-center">
                                                    <?php echo $estado_autorizaciones; ?>
                                                    
                                                </td>
                                                <!-- Información Personal -->
                                                <td class="p-1 font-size-11 align-middle text-center">
                                                    <?php echo $estado_informacion_personal; ?>
                                                    
                                                </td>
                                                <!-- Ubicación/ Contacto -->
                                                <td class="p-1 font-size-11 align-middle text-center">
                                                    <?php echo $estado_ubicacion_contacto; ?>
                                                    
                                                </td>
                                                <!-- Socioeconómico/ Familiar -->
                                                <td class="p-1 font-size-11 align-middle text-center">
                                                    <?php echo $estado_socioeconomico_familiar; ?>
                                                    
                                                </td>
                                                <!-- Salud/ Bienestar -->
                                                <td class="p-1 font-size-11 align-middle text-center">
                                                    <?php echo $estado_salud_bienestar; ?>
                                                    
                                                </td>
                                                <!-- Intereses/ Hábitos -->
                                                <td class="p-1 font-size-11 align-middle text-center">
                                                    <?php echo $estado_intereses_habitos; ?>
                                                    
                                                </td>
                                                <!-- Formación/ Habilidades -->
                                                <td class="p-1 font-size-11 align-middle text-center">
                                                    <?php echo $estado_formacion_habilidades; ?>
                                                    
                                                </td>
                                                <!-- Poblaciones/ Relaciones Familiares -->
                                                <td class="p-1 font-size-11 align-middle text-center">
                                                    <?php echo $estado_poblaciones_relaciones; ?>
                                                    
                                                </td>
                                                <td class="p-1 font-size-11 align-middle text-center">
                                                    <?php echo $estado_general; ?>
                                                    
                                                </td>
                                                <td class="p-1 font-size-11 align-middle text-center">
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
                                                <td class="p-1 font-size-11 align-middle">
                                                    <?php echo ($registro->hvp_fecha_ingreso!='') ? date('d/m/Y', strtotime($registro->hvp_fecha_ingreso)) : ''; ?>
                                                </td>
                                                <?php if(base64_decode($data['bandeja'])=='Retirados'): ?>
                                                    <td class="p-1 font-size-11 align-middle">
                                                        <?php echo ($registro->hvp_retiro_fecha!='') ? date('d/m/Y', strtotime($registro->hvp_retiro_fecha)) : ''; ?>
                                                    </td>
                                                    <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvp_retiro_motivo; ?></td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    </table>
                                    <?php if($data['resultado_registros_count']==0): ?>
                                        <p class="alert alert-dark p-1 mt-0">¡No se encontraron registros!</p>
                                    <?php endif; ?>
                                </div>
                                <?php require_once INCLUDES.'inc_pagination.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- MODAL DETALLE -->
    <div class="modal fade" id="modal-detalle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Detalle</h5>
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
<!-- MODAL REPORTES -->
    <div class="modal fade" id="modal-reporte" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Reportes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form name="reporte" action="<?php echo URL; ?>reportes/hoja-vida" method="POST">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tipo_reporte" class="form-label my-0 font-size-11">Tipo de reporte</label>
                            <select class="form-select form-select-sm font-size-11" name="tipo_reporte" id="tipo_reporte" required>
                                <option value="">Seleccione</option>
                                <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Usuario'): ?>
                                    <option value="Consolidado">Consolidado</option>
                                    <option value="Consolidado Vinculados">Consolidado Vinculados</option>
                                <?php endif; ?>
                                <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Contratación'): ?>
                                    <option value="Contratación">Retirados Contratación</option>
                                <?php endif; ?>
                                <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Cumplimiento'): ?>
                                    <option value="Cumplimiento">Cumplimiento</option>
                                <?php endif; ?>
                                <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Contratación' OR $data['modulo_perfil']=='Formación'): ?>
                                    <option value="Formación">Retirados Formación</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="estado" class="form-label my-0 font-size-11">Estado</label>
                            <select class="form-select form-select-sm font-size-11" name="estado" id="estado" required>
                                <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor'): ?>
                                    <option value="Todos">Todos</option>
                                <?php endif; ?>
                                <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Usuario' OR $data['modulo_perfil']=='Cumplimiento'): ?>
                                    <option value="Activo">Activo</option>
                                <?php endif; ?>
                                <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Usuario' OR $data['modulo_perfil']=='Contratación' OR $data['modulo_perfil']=='Formación'): ?>
                                    <option value="Retirado">Retirado</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="fecha_inicio" class="form-label my-0 font-size-11">Fecha inicio</label>
                        <input type="date" class="form-control form-control-sm" name="fecha_inicio" id="fecha_inicio" value=""  required>
                    </div>
                    <div class="col-md-6">
                        <label for="fecha_fin" class="form-label my-0 font-size-11">Fecha fin</label>
                        <input type="date" class="form-control form-control-sm" name="fecha_fin" id="fecha_fin" value=""  required>
                    </div>
                    <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Usuario'): ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger py-2 px-2" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" name="reporte" class="btn btn-primary btn-corp py-2 px-2">Generar</button>
            </div>
            </form>
            </div>
        </div>  
    </div>
<!-- MODAL REPORTES -->
<?php require_once INCLUDES.'inc_footer.php'; ?>
<script type="text/javascript">
    function open_modal_ver(id_registro) {
        var myModal = new bootstrap.Modal(document.getElementById("modal-detalle"), {});
        $('.modal-body-detalle').load('<?php echo URL; ?>xxx/xxx/'+id_registro,function(){
            myModal.show();
        });
    }

    function close_modal_ver() {
        var myModal = new bootstrap.Modal(document.getElementById("modal-detalle"), {});
        $('.modal-body-detalle').html('');
    }
</script>