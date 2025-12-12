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
                                        <a href="<?php echo URL; ?>encuestas/configuracion/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo base64_encode('Todos'); ?>" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" title="Todos">
                                            <i class="fas fa-users btn-icon-prepend me-0 me-lg-1 font-size-12"></i><span class="d-none d-lg-inline">Todos</span>
                                        </a>
                                        <a href="<?php echo URL; ?>encuestas/configuracion-crear/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>" class="btn pt-1 px-2 btn-primary btn-sm btn-corp btn-icon-text font-size-12" title="Crear Encuesta">
                                            <i class="fas fa-plus btn-icon-prepend font-size-12"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive table-fixed">
                                    <table class="table table-hover table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle" style="width: 80px;"></th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Estado</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Título</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Descripción</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Fecha Registro</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['resultado_registros'] as $registro): ?>
                                            <tr>
                                                <td class="p-1 align-middle text-center">
                                                    <a href="<?php echo URL; ?>encuestas/configuracion-editar/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>/<?php echo base64_encode($registro->enc_id); ?>" class="btn btn-warning btn-sm font-size-11 btn-table mb-1" title="Editar"><i class="fas fa-pen font-size-11"></i></a>
                                                    <a href="<?php echo URL; ?>encuestas/configuracion-preguntas/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo $data['bandeja']; ?>/<?php echo base64_encode($registro->enc_id); ?>" class="btn btn-dark btn-sm font-size-11 btn-table mb-1" title="Preguntas"><i class="fas fa-cog font-size-11"></i></a>
                                                    <a href="<?php echo URL; ?>reportes/encuestas/<?php echo base64_encode($registro->enc_id); ?>" class="btn btn-success btn-sm font-size-11 btn-table mb-1" title="Reporte" target="_blank"><i class="fas fa-file-excel font-size-11"></i></a>
                                                </td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->enc_estado; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->enc_titulo; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->enc_descripcion; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->enc_registro_fecha; ?></td>
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
<?php require_once INCLUDES.'inc_footer.php'; ?>