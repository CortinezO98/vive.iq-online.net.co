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
                                        
                                    </div>
                                </div>
                                <div class="table-responsive table-fixed">
                                    <table class="table table-hover table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle" style="width: 80px;"></th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Host</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Port</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Smtpsecure</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Smtpauth</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Username</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Password</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Setfrom</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Setfrom_name</th>
                                            <th class="px-1 py-2 text-center font-size-12 align-middle">Tipo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['resultado_registros'] as $registro): ?>
                                            <tr>
                                                <td class="p-1 align-middle text-center">
                                                    <a href="<?php echo URL; ?>administrador-buzones/editar/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>/<?php echo base64_encode($registro->ncr_id); ?>" class="btn btn-warning btn-sm font-size-11 btn-table mb-1" title="Editar"><i class="fas fa-pen font-size-11"></i></a>
                                                </td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->ncr_host; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->ncr_port; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->ncr_smtpsecure; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->ncr_smtpauth; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->ncr_username; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->ncr_password; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->ncr_setfrom; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->ncr_setfrom_name; ?></td>
                                                <td class="p-1 font-size-11 align-middle"><?php echo $registro->ncr_tipo; ?></td>
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