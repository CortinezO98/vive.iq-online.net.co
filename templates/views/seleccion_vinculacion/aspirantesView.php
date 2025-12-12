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
                                        <?php if ($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Usuario'): ?>
                                            <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo base64_encode('Todos'); ?>" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" title="Todos">
                                                <i class="fas fa-users btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Todos</span>
                                            </a>
                                            <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo base64_encode('Pendientes'); ?>" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" title="Pendientes">
                                                <i class="fas fa-user-clock btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Pendientes</span>
                                            </a>
                                            <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo base64_encode('Diligenciados'); ?>" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" title="Diligenciados">
                                                <i class="fas fa-file-signature btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Diligenciados</span>
                                            </a>
                                            <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo base64_encode('Documentos Cargados'); ?>" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" title="Documentos Cargados">
                                                <i class="fas fa-file-alt btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Documentos Cargados</span>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo base64_encode('Vinculados'); ?>" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" title="Vinculados">
                                            <i class="fas fa-user-check btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Vinculados</span>
                                        </a>
                                        <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo base64_encode('Retirados'); ?>" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" title="Retirados">
                                            <i class="fas fa-user-times btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Retirados</span>
                                        </a>
                                        <?php if ($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Usuario' OR $data['modulo_perfil']=='Contratación'): ?>
                                            <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo base64_encode('Desiste'); ?>" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" title="Desiste">
                                                <i class="fas fa-user-times btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Desiste</span>
                                            </a>
                                        <?php endif; ?>
                                        <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Usuario'): ?>
                                            <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes-crear/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" title="Crear Aspirante">
                                                <i class="fas fa-user-plus btn-icon-prepend font-size-12"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor'): ?>
                                            <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes-crear-masivo/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" title="Crear Aspirantes Masivo">
                                                <i class="fas fa-file-upload btn-icon-prepend font-size-12"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Contratación'): ?>
                                            <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes-actualizar-masivo/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>" class="btn pt-1 px-2 btn-warning btn-sm btn-corp btn-icon-text font-size-12" title="Actualizar Aspirantes Masivo">
                                                <i class="fas fa-user-gear btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Actualizar Aspirantes Masivo</span>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($data['modulo_perfil']=='Gestión Usuarios'): ?>
                                            <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes-correo-masivo/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>" class="btn pt-1 px-2 btn-warning btn-sm btn-corp btn-icon-text font-size-12" title="Actualizar Correo Masivo">
                                                <i class="fas fa-user-gear btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Actualizar Correo Masivo</span>
                                            </a>
                                        <?php endif; ?>
                                        <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Contratación' OR $data['modulo_perfil']=='Gestión Usuarios' OR $data['modulo_perfil']=='Usuario' OR $data['modulo_perfil']=='Cumplimiento'): ?>
                                            <button type="button" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" data-bs-toggle="modal" data-bs-target="#modal-reporte" title="Reportes">
                                                <i class="fas fa-file-excel btn-icon-prepend me-0 font-size-12"></i>
                                            </button>
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
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Nombres y Apellidos</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Correo</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Correo Corporativo</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Centro de Costo</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Cargo</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Director</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Psicólogo</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Fecha Ingreso</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Fecha Retiro</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">NT</th>
                                            <!-- <th class="px-1 py-2 text-center font-size-12 align-middle">Motivo Retiro</th> -->
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Observaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['resultado_registros'] as $registro): ?>
                                            <tr>
                                                <td class="p-1 align-middle text-center">
                                                    <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Usuario'): ?>
                                                        <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes-editar/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>/<?php echo base64_encode($registro->hva_id); ?>" class="btn btn-warning btn-sm font-size-11 btn-table mb-1" title="Editar"><i class="fas fa-pen font-size-11"></i></a>
                                                        <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes-ofertas/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>/<?php echo base64_encode($registro->hva_id); ?>" class="btn btn-success btn-sm font-size-11 btn-table mb-1" title="Ofertas"><i class="fas fa-list-alt font-size-11"></i></a>
                                                    <?php endif; ?>
                                                    <?php if($registro->hvada_tratamiento_datos!='' AND ($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Usuario')): ?>
                                                        <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes-autorizacion-descargar/<?php echo base64_encode($registro->hva_id); ?>" target="_blank" class="btn btn-warning btn-sm font-size-11 btn-table mb-1" title="Editar"><i class="fas fa-file-arrow-down font-size-11"></i></a>
                                                    <?php endif; ?>
                                                    <?php if ($data['modulo_perfil']=='Administrador'): ?>
                                                        <a href="<?php echo URL; ?>seleccion-vinculacion/aspirantes-eliminar/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>/<?php echo base64_encode($registro->hva_id); ?>" class="btn btn-danger btn-sm font-size-11 btn-table mb-1" title="Eliminar"><i class="fas fa-trash-alt font-size-11"></i></a>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="p-1 font-size-11 align-middle text-center">
                                                    <?php include INCLUDES.'inc_seleccion_vinculacion_estado.php'; ?>
                                                </td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->hva_identificacion; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->hva_nombres.' '.$registro->hva_nombres_2.' '.$registro->hva_apellido_1.' '.$registro->hva_apellido_2; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->hva_correo; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->hva_correo_corporativo; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->aa_nombre; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->ac_nombre; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->usuario_director; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->usuario_psicologo; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->hva_ingreso_fecha; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->hva_retiro_fecha; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->hvp_usuario_nt; ?></td>
                                                <!-- <td class="p-1 font-size-11 align-middle"><?php echo $registro->hva_retiro_motivo; ?></td> -->
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->hva_observaciones; ?></td>
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
            <form name="reporte" action="<?php echo URL; ?>reportes/seleccion-aspirantes" method="POST">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tipo_reporte" class="form-label my-0 font-size-11">Tipo de reporte</label>
                            <select class="form-select form-select-sm font-size-11" name="tipo_reporte" id="tipo_reporte" required>
                                <option value="">Seleccione</option>
                                <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Usuario'): ?>
                                    <option value="Consolidado">Consolidado</option>
                                    <option value="Ofertas">Ofertas</option>
                                <?php endif; ?>
                                <?php if ($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestión Usuarios'): ?>
                                    <option value="Correos Gestión Usuarios">Correos Gestión Usuarios</option>
                                <?php endif; ?>
                                <?php if ($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Contratación'): ?>
                                    <option value="Contratación">Contratación</option>
                                <?php endif; ?>
                                <?php if ($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Cumplimiento'): ?>
                                    <option value="Cumplimiento">Cumplimiento</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="estado" class="form-label my-0 font-size-11">Estado</label>
                            <select class="form-select form-select-sm font-size-11" name="estado" id="estado" required>
                                <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Usuario' OR $data['modulo_perfil']=='Cumplimiento'): ?>
                                    <option value="Todos">Todos</option>
                                <?php endif; ?>
                                <?php if($data['modulo_perfil']=='Administrador' OR $data['modulo_perfil']=='Gestor' OR $data['modulo_perfil']=='Usuario'): ?>
                                    <option value="Desiste">Desiste</option>
                                    <option value="Diligenciado">Diligenciado</option>
                                    <option value="Documentos Cargados">Documentos Cargados</option>
                                    <option value="No vinculado">No vinculado</option>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Pendiente Fase 2">Pendiente Fase 2</option>
                                <?php endif; ?>
                                <?php if ($data['modulo_perfil']=='Contratación' OR $data['modulo_perfil']=='Gestión Usuarios'): ?>
                                    <option value="Vinculado">Vinculado</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="hva_area" class="form-label my-0 font-size-11">Centro de costo</label>
                            <select class="selectpicker form-control form-control-sm font-size-11" name="hva_area" id="hva_area" data-live-search="true" data-container="body" title="Seleccione" required>
                                <option value="Todos" class="font-size-11">Todos</option>
                                <?php foreach ($data['resultado_registros_area_lista'] as $registro): ?>
                                    <option value="<?php echo $registro->aa_id; ?>" class="font-size-11"><?php echo $registro->aa_nombre; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="hva_cargo" class="form-label my-0 font-size-11">Cargo</label>
                            <select class="selectpicker form-control form-control-sm font-size-11" name="hva_cargo" id="hva_cargo" data-live-search="true" data-container="body" title="Seleccione" required>
                                <option value="Todos" class="font-size-11">Todos</option>
                                <?php foreach ($data['resultado_registros_cargo'] as $registro): ?>
                                    <option value="<?php echo $registro->ac_id; ?>" class="font-size-11"><?php echo $registro->ac_nombre; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="hva_psicologo" class="form-label my-0 font-size-11">Psicólogo</label>
                            <select class="selectpicker form-control form-control-sm font-size-11" name="hva_psicologo" id="hva_psicologo" data-live-search="true" data-container="body" title="Seleccione" required>
                                <option value="Todos" class="font-size-11">Todos</option>
                                <?php foreach ($data['resultado_registros_psicologo'] as $registro): ?>
                                    <option value="<?php echo $registro->usu_id; ?>" class="font-size-11"><?php echo $registro->usu_nombres_apellidos; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <label for="fecha_inicio" class="form-label my-0 font-size-11">Fecha inicio</label>
                        <input type="date" class="form-control form-control-sm" name="fecha_inicio" id="fecha_inicio" max="<?php echo date('Y'); ?>-12-31" value="">
                    </div>
                    <div class="col-md-6 mb-1">
                        <label for="fecha_fin" class="form-label my-0 font-size-11">Fecha fin</label>
                        <input type="date" class="form-control form-control-sm" name="fecha_fin" id="fecha_fin" max="<?php echo date('Y'); ?>-12-31" value="">
                    </div>
                    <?php if ($data['modulo_perfil']=='Contratación' OR $data['modulo_perfil']=='Gestión Usuarios'): ?>
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

    $('#hva_area').selectpicker({ container: '#modal' });
    $('#hva_cargo').selectpicker({ container: '#modal' });
    $('#hva_psicologo').selectpicker({ container: '#modal' });
    
</script>