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
                                    <div class="col-md-9 mb-1 text-end px-0">
                                        
                                    </div>
                                </div>
                                <div class="table-responsive table-fixed">
                                    <table class="table table-hover table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle"></th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Id</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Estado</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Asunto</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Remitente</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Destinatario</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">CC</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Intentos</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Fecha Envío</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Fecha Registro</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['resultado_registros'] as $registro): ?>
                                            <tr>
                                                <td class="p-1 font-size-11 align-middle"></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->nc_id; ?></td>
                                                <td class="p-1 font-size-11 align-middle text-center">
                                                <?php if ($registro->nc_estado_envio=='Pendiente'): ?>
                                                    <span class="fas fa-clock color-pendiente size-3" title="<?php echo $registro->nc_estado_envio; ?>"></span>
                                                <?php elseif ($registro->nc_estado_envio=='Enviado'): ?>
                                                    <span class="fas fa-paper-plane color-verde size-3" title="<?php echo $registro->nc_estado_envio; ?>"></span>
                                                <?php elseif ($registro->nc_estado_envio=='Destinatario inválido'): ?>
                                                    <span class="fas fa-user-times color-rojo size-3" title="<?php echo $registro->nc_estado_envio; ?>"></span>
                                                <?php elseif ($registro->nc_estado_envio=='Error de autenticación'): ?>
                                                    <span class="fas fa-key color-rojo size-3" title="<?php echo $registro->nc_estado_envio; ?>"></span>
                                                
                                                <?php endif; ?>
                                                </td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->nc_subject; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->ncr_setfrom; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->nc_address; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->nc_cc; ?></td>
                                                <td class="p-1 font-size-11 align-middle text-center"><?php echo $registro->nc_intentos; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->nc_fecha_envio; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->nc_fecha_registro; ?></td>
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