<?php require_once INCLUDES.'inc_head.php'; ?>
<main id="main-wrapper" class="main-wrapper">
    <?php require_once INCLUDES.'inc_header.php'; ?>
    <script>
      tinymce.init({
        selector: '#app_descripcion',
        license_key: 'gpl'
      });
    </script>
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
                <div class="row justify-content-center">
                    <div class="bg-white rounded-3 col-lg-4 col-md-12 col-12">
                        <div class="row mb-5">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="row p-6 d-lg-flex justify-content-between align-items-center ">
                                    <form name="form_guardar" action="" method="post" class="comment-form" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12 mb-1">
                                                        <label for="app_id" class="form-label my-0 font-size-11">Host</label>
                                                        <input type="text" class="form-control form-control-sm" name="ncr_host" id="ncr_host" value="<?php echo $data['resultado_registros'][0]->ncr_host; ?>" required>
                                                    </div>
                                                    <div class="col-md-12 mb-1">
                                                        <label for="app_titulo" class="form-label my-0 font-size-11">Port</label>
                                                        <input type="text" class="form-control form-control-sm" name="ncr_port" id="ncr_port" value="<?php echo $data['resultado_registros'][0]->ncr_port; ?>" required>
                                                    </div>
                                                    <div class="col-md-12 mb-1">
                                                        <label for="app_titulo" class="form-label my-0 font-size-11">Smtpsecure</label>
                                                        <input type="text" class="form-control form-control-sm" name="ncr_smtpsecure" id="ncr_smtpsecure" value="<?php echo $data['resultado_registros'][0]->ncr_smtpsecure; ?>" required>
                                                    </div>
                                                    <div class="col-md-12 mb-1">
                                                        <label for="app_titulo" class="form-label my-0 font-size-11">Smtpauth</label>
                                                        <input type="text" class="form-control form-control-sm" name="ncr_smtpauth" id="ncr_smtpauth" value="<?php echo $data['resultado_registros'][0]->ncr_smtpauth; ?>" required>
                                                    </div>
                                                    <div class="col-md-12 mb-1">
                                                        <label for="app_titulo" class="form-label my-0 font-size-11">Username</label>
                                                        <input type="text" class="form-control form-control-sm" name="ncr_username" id="ncr_username" value="<?php echo $data['resultado_registros'][0]->ncr_username; ?>" required>
                                                    </div>
                                                    <div class="col-md-12 mb-1">
                                                        <label for="app_titulo" class="form-label my-0 font-size-11">Password</label>
                                                        <input type="text" class="form-control form-control-sm" name="ncr_password" id="ncr_password" value="<?php echo $data['resultado_registros'][0]->ncr_password; ?>" required>
                                                    </div>
                                                    <div class="col-md-12 mb-1">
                                                        <label for="app_titulo" class="form-label my-0 font-size-11">Setfrom</label>
                                                        <input type="text" class="form-control form-control-sm" name="ncr_setfrom" id="ncr_setfrom" value="<?php echo $data['resultado_registros'][0]->ncr_setfrom; ?>" required>
                                                    </div>
                                                    <div class="col-md-12 mb-1">
                                                        <label for="app_titulo" class="form-label my-0 font-size-11">Setfrom_name</label>
                                                        <input type="text" class="form-control form-control-sm" name="ncr_setfrom_name" id="ncr_setfrom_name" value="<?php echo $data['resultado_registros'][0]->ncr_setfrom_name; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php echo Flasher::flash(); ?>
                                            <div class="col-md-12 text-end mt-2">
                                                <button class="btn btn-success float-end ms-1" type="submit" name="form_guardar" id="guardar_registro_btn">Guardar</button>
                                                <?php if(isset($_POST["form_guardar"])): ?>
                                                    <a href="<?php echo URL; ?>administrador-buzones/ver/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>" class="btn btn-dark float-end">Finalizar</a>
                                                <?php endif; ?>
                                                <?php if(!isset($_POST["form_guardar"])): ?>
                                                    <a href="<?php echo URL; ?>administrador-buzones/ver/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>" class="btn btn-danger float-end">Cancelar</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once INCLUDES.'inc_footer.php'; ?>