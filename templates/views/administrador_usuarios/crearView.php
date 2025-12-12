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
                <div class="row justify-content-center">
                    <div class="bg-white rounded-3 col-lg-8 col-md-12 col-12">
                        <div class="row mb-5">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="row p-6 d-lg-flex justify-content-between align-items-center ">
                                    <form name="form_guardar" action="" method="post" class="comment-form" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6 mb-1">
                                                        <label for="usu_documento" class="form-label my-0 font-size-11">Doc identidad</label>
                                                        <input type="text" class="form-control form-control-sm" name="usu_documento" id="usu_documento" value="<?php echo (isset($_POST["form_guardar"])) ? checkInput($_POST['usu_documento']) : ''; ?>" <?php echo ($_SESSION[APP_SESSION.'_usuario_add']==1) ? 'disabled' : ''; ?> required>
                                                    </div>
                                                    <div class="col-md-6 mb-1">
                                                        <label for="usu_acceso" class="form-label my-0 font-size-11">Usuario acceso</label>
                                                        <input type="text" class="form-control form-control-sm" name="usu_acceso" id="usu_acceso" value="<?php echo (isset($_POST["form_guardar"])) ? checkInput($_POST['usu_acceso']) : ''; ?>" <?php echo ($_SESSION[APP_SESSION.'_usuario_add']==1) ? 'disabled' : ''; ?> required>
                                                    </div>
                                                    <div class="col-md-12 mb-1">
                                                        <label for="usu_nombres_apellidos" class="form-label my-0 font-size-11">Nombres y apellidos</label>
                                                        <input type="text" class="form-control form-control-sm" name="usu_nombres_apellidos" id="usu_nombres_apellidos" value="<?php echo (isset($_POST["form_guardar"])) ? checkInput($_POST['usu_nombres_apellidos']) : ''; ?>" <?php echo ($_SESSION[APP_SESSION.'_usuario_add']==1) ? 'disabled' : ''; ?> required>
                                                    </div>
                                                    <div class="col-md-6 mb-1">
                                                        <label for="usu_estado" class="form-label my-0 font-size-11">Estado</label>
                                                        <select class="form-select form-select-sm" name="usu_estado" id="usu_estado" <?php echo ($_SESSION[APP_SESSION.'_usuario_add']==1) ? 'disabled' : ''; ?> required>
                                                            <option value=""></option>
                                                            <option value="Activo" <?php echo (isset($_POST["form_guardar"]) AND $_POST['usu_estado']=='Activo') ? 'selected' : ''; ?>>Activo</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-1">
                                                        <label for="usu_genero" class="form-label my-0 font-size-11">Género</label>
                                                        <select class="form-select form-select-sm" name="usu_genero" id="usu_genero" <?php echo ($_SESSION[APP_SESSION.'_usuario_add']==1) ? 'disabled' : ''; ?> required>
                                                            <option value=""></option>
                                                            <option value="Femenino" <?php echo (isset($_POST["form_guardar"]) AND $_POST['usu_genero']=='Femenino') ? 'selected' : ''; ?>>Femenino</option>
                                                            <option value="Masculino" <?php echo (isset($_POST["form_guardar"]) AND $_POST['usu_genero']=='Masculino') ? 'selected' : ''; ?>>Masculino</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-1">
                                                        <label for="usu_fecha_incorporacion" class="form-label my-0 font-size-11">Fecha ingreso</label>
                                                        <input type="date" class="form-control form-control-sm" name="usu_fecha_incorporacion" id="usu_fecha_incorporacion" max="<?php echo date("Y-m-d", strtotime("+ 10 day")); ?>" value="<?php echo (isset($_POST["form_guardar"])) ? checkInput($_POST['usu_fecha_incorporacion']) : ''; ?>" <?php echo ($_SESSION[APP_SESSION.'_usuario_add']==1) ? 'disabled' : ''; ?> required>
                                                    </div>
                                                    <div class="col-md-6 mb-1">
                                                        <label for="usu_fecha_nacimiento" class="form-label my-0 font-size-11">Fecha nacimiento</label>
                                                        <input type="date" class="form-control form-control-sm" name="usu_fecha_nacimiento" id="usu_fecha_nacimiento" max="<?php echo date("Y-m-d", strtotime("- 18 year")); ?>" value="<?php echo (isset($_POST["form_guardar"])) ? checkInput($_POST['usu_fecha_nacimiento']) : ''; ?>" <?php echo ($_SESSION[APP_SESSION.'_usuario_add']==1) ? 'disabled' : ''; ?> required>
                                                    </div>
                                                    <div class="col-md-6 mb-1">
                                                        <label for="usu_correo" class="form-label my-0 font-size-11">Correo</label>
                                                        <input type="email" class="form-control form-control-sm" name="usu_correo" id="usu_correo" value="<?php echo (isset($_POST["form_guardar"])) ? checkInput($_POST['usu_correo']) : ''; ?>" <?php echo ($_SESSION[APP_SESSION.'_usuario_add']==1) ? 'disabled' : ''; ?> required>
                                                    </div>
                                                    <div class="col-md-6 mb-1">
                                                        <label for="usu_correo_corporativo" class="form-label my-0 font-size-11">Correo corporativo</label>
                                                        <input type="email" class="form-control form-control-sm" name="usu_correo_corporativo" id="usu_correo_corporativo" value="<?php echo (isset($_POST["form_guardar"])) ? checkInput($_POST['usu_correo_corporativo']) : ''; ?>" <?php echo ($_SESSION[APP_SESSION.'_usuario_add']==1) ? 'disabled' : ''; ?> required>
                                                    </div>
                                                    <div class="col-md-12 mb-1">
                                                        <div class="form-group">
                                                            <label for="usu_ciudad" class="form-label my-0 font-size-11">Ciudad</label>
                                                            <select class="selectpicker form-control form-control-sm font-size-11" name="usu_ciudad" id="usu_ciudad" data-live-search="true" data-container="body" title="Seleccione" <?php echo ($_SESSION[APP_SESSION.'_usuario_add']==1) ? 'disabled' : ''; ?> required>
                                                                <?php foreach ($data['resultado_registros_ciudad'] as $registro): ?>
                                                                    <option value="<?php echo $registro->ciu_codigo; ?>" class="font-size-11" <?php echo (isset($_POST["form_guardar"]) AND $_POST['usu_ciudad']==$registro->ciu_codigo) ? 'selected' : ''; ?>><?php echo $registro->ciu_municipio.', '.$registro->ciu_departamento; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-1">
                                                        <div class="form-group">
                                                            <label for="usu_area" class="form-label my-0 font-size-11">Área</label>
                                                            <select class="selectpicker form-control form-control-sm font-size-11" name="usu_area" id="usu_area" data-live-search="true" data-container="body" title="Seleccione" <?php echo ($_SESSION[APP_SESSION.'_usuario_add']==1) ? 'disabled' : ''; ?> required>
                                                                <?php foreach ($data['resultado_registros_area'] as $registro): ?>
                                                                    <option value="<?php echo $registro->aa_id; ?>" class="font-size-11" <?php echo (isset($_POST["form_guardar"]) AND $_POST['usu_area']==$registro->aa_id) ? 'selected' : ''; ?>><?php echo $registro->aa_nombre; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-1">
                                                        <div class="form-group">
                                                            <label for="usu_cargo" class="form-label my-0 font-size-11">Cargo</label>
                                                            <select class="selectpicker form-control form-control-sm font-size-11" name="usu_cargo" id="usu_cargo" data-live-search="true" data-container="body" title="Seleccione" <?php echo ($_SESSION[APP_SESSION.'_usuario_add']==1) ? 'disabled' : ''; ?> required>
                                                                <?php foreach ($data['resultado_registros_cargo'] as $registro): ?>
                                                                    <option value="<?php echo $registro->ac_id; ?>" class="font-size-11" <?php echo (isset($_POST["form_guardar"]) AND $_POST['usu_cargo']==$registro->ac_id) ? 'selected' : ''; ?>><?php echo $registro->ac_nombre; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-1">
                                                        <div class="form-group">
                                                            <label for="usu_jefe_inmediato" class="form-label my-0 font-size-11">Jefe inmediato</label>
                                                            <select class="selectpicker form-control form-control-sm font-size-11" name="usu_jefe_inmediato" id="usu_jefe_inmediato" data-live-search="true" data-container="body" title="Seleccione" <?php echo ($_SESSION[APP_SESSION.'_usuario_add']==1) ? 'disabled' : ''; ?> required>
                                                                <?php foreach ($data['resultado_registros_jefe'] as $registro): ?>
                                                                    <option value="<?php echo $registro->usu_id; ?>" class="font-size-11" <?php echo (isset($_POST["form_guardar"]) AND $_POST['usu_jefe_inmediato']==$registro->usu_id) ? 'selected' : ''; ?>><?php echo $registro->usu_nombres_apellidos; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <table class="table table-hover table-bordered table-striped mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th class="px-1 py-1 text-center font-size-12">Módulo</th>
                                                                <th class="px-1 py-1 text-center font-size-12">Perfil</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($data['resultado_registros_modulo'] as $registro_modulo): ?>
                                                                <tr>
                                                                    <td class="p-1 font-size-11 align-middle"><?php echo $registro_modulo->amod_nombre; ?></td>
                                                                    <td class="p-1 font-size-11 align-middle">
                                                                    <select class="form-select form-select-sm" name="usu_modulo_<?php echo $registro_modulo->amod_id; ?>" id="usu_modulo_<?php echo $registro_modulo->amod_id; ?>" <?php echo ($_SESSION[APP_SESSION.'_usuario_add']==1) ? 'disabled' : ''; ?>>
                                                                        <option value=""></option>
                                                                        <option value="Visitante" <?php echo (isset($_POST["form_guardar"]) AND $_POST["usu_modulo_".$registro_modulo->amod_id]=='Visitante') ? 'selected' : ''; ?>>Visitante</option>
                                                                        <?php if($registro_modulo->amod_nombre=='Selección'): ?>
                                                                            <option value="Contratación" <?php echo (isset($_POST["form_guardar"]) AND $_POST["usu_modulo_".$registro_modulo->amod_id]=='Contratación') ? 'selected' : ''; ?>>Contratación</option>
                                                                            <option value="Cumplimiento" <?php echo (isset($_POST["form_guardar"]) AND $_POST["usu_modulo_".$registro_modulo->amod_id]=='Cumplimiento') ? 'selected' : ''; ?>>Cumplimiento</option>
                                                                            <option value="Gestión Usuarios" <?php echo (isset($_POST["form_guardar"]) AND $_POST["usu_modulo_".$registro_modulo->amod_id]=='Gestión Usuarios') ? 'selected' : ''; ?>>Gestión Usuarios</option>
                                                                        <?php endif; ?>
                                                                        <?php if($registro_modulo->amod_nombre=='Hoja de Vida-Consolidado'): ?>
                                                                            <option value="Contratación" <?php echo (isset($_POST["form_guardar"]) AND $_POST["usu_modulo_".$registro_modulo->amod_id]=='Contratación') ? 'selected' : ''; ?>>Contratación</option>
                                                                            <option value="Cumplimiento" <?php echo (isset($_POST["form_guardar"]) AND $_POST["usu_modulo_".$registro_modulo->amod_id]=='Cumplimiento') ? 'selected' : ''; ?>>Cumplimiento</option>
                                                                            <option value="Formación" <?php echo (isset($_POST["form_guardar"]) AND $_POST["usu_modulo_".$registro_modulo->amod_id]=='Formación') ? 'selected' : ''; ?>>Formación</option>
                                                                        <?php endif; ?>
                                                                        <option value="Usuario" <?php echo (isset($_POST["form_guardar"]) AND $_POST["usu_modulo_".$registro_modulo->amod_id]=='Usuario') ? 'selected' : ''; ?>>Usuario</option>
                                                                        <option value="Gestor" <?php echo (isset($_POST["form_guardar"]) AND $_POST["usu_modulo_".$registro_modulo->amod_id]=='Gestor') ? 'selected' : ''; ?>>Gestor</option>
                                                                        <option value="Administrador" <?php echo (isset($_POST["form_guardar"]) AND $_POST["usu_modulo_".$registro_modulo->amod_id]=='Administrador') ? 'selected' : ''; ?>>Administrador</option>
                                                                    </select>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <?php echo Flasher::flash(); ?>
                                            <div class="col-md-12 text-end">
                                                <?php if($_SESSION[APP_SESSION.'_usuario_add']==1): ?>
                                                    <a href="<?php echo URL; ?>administrador_usuarios/ver/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>" class="btn btn-dark float-end">Finalizar</a>
                                                <?php else: ?>
                                                    <button class="btn btn-success float-end ms-1" type="submit" name="form_guardar" id="guardar_registro_btn">Guardar</button>
                                                    <a href="<?php echo URL; ?>administrador_usuarios/ver/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>" class="btn btn-danger float-end">Cancelar</a>
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