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
                <form name="form_guardar" id="id_form_guardar" action="" method="post" class="comment-form" enctype="multipart/form-data" novalidate>
                <div class="row mb-5">
                    <div class="col-md-3">
                        <div class="bg-white rounded-3 col-lg-12 col-md-12 col-12">
                            <div class="row mb-5">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="row p-6 d-lg-flex justify-content-between align-items-center">
                                        <?php require_once INCLUDES.'inc_secciones_hoja_vida.php'; ?>
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
                                                <div class="row mb-2">
                                                    <div class="col-md-12 mb-2">
                                                        <label for="">Progreso</label><span class="float-end">Completado: <span id="avance_total"></span> de <span id="secciones_total"></span></span>
                                                        <div class="progress" style="height: 25px;" id="avance_barra">
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-user-tie"></span> Información Personal</p>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 mb-3">
                                                            <label for="hvp_datos_personales_tipo_documento" class="form-label my-0 font-size-12">Tipo de documento de identidad</label>
                                                            <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_datos_personales_tipo_documento" id="hvp_datos_personales_tipo_documento" data-container="body" title="Seleccione" required>
                                                                <option value="Cédula de ciudadanía (CC)" <?php echo ($data['resultado_registros_usuario'][0]->hvp_datos_personales_tipo_documento=='Cédula de ciudadanía (CC)') ? 'selected' : ''; ?>>Cédula de ciudadanía (CC)</option>
                                                                <option value="Tarjeta de identidad (TI)" <?php echo ($data['resultado_registros_usuario'][0]->hvp_datos_personales_tipo_documento=='Tarjeta de identidad (TI)') ? 'selected' : ''; ?>>Tarjeta de identidad (TI)</option>
                                                                <option value="Documento nacional de identidad (DNI)" <?php echo ($data['resultado_registros_usuario'][0]->hvp_datos_personales_tipo_documento=='Documento nacional de identidad (DNI)') ? 'selected' : ''; ?>>Documento nacional de identidad (DNI)</option>
                                                                <option value="Cédula de extranjería (CE)" <?php echo ($data['resultado_registros_usuario'][0]->hvp_datos_personales_tipo_documento=='Cédula de extranjería (CE)') ? 'selected' : ''; ?>>Cédula de extranjería (CE)</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label for="hvp_datos_personales_numero_identificacion" class="form-label my-0 font-size-12">Número de identificación</label>
                                                            <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1 is-in valid" name="hvp_datos_personales_numero_identificacion" id="hvp_datos_personales_numero_identificacion" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_datos_personales_numero_identificacion; ?>" required>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label for="hva_auxiliar_5" class="form-label my-0 font-size-12">Fecha de expedición</label>
                                                            <input type="date" class="form-control form-control-sm font-size-11 px-2 py-1 is-in valid" name="hva_auxiliar_5" id="hva_auxiliar_5" value="<?php echo $data['resultado_registros_oferta'][0]->hva_auxiliar_5; ?>" min="1940-01-01" max="<?php echo date('Y-m-d'); ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_datos_personales_nombre_1" class="form-label my-0 font-size-12">Primer nombre</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_datos_personales_nombre_1" id="hvp_datos_personales_nombre_1" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_datos_personales_nombre_1; ?>" required onchange="valida_nombre_preferencia();">
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_datos_personales_nombre_2" class="form-label my-0 font-size-12">Segundo nombre</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_datos_personales_nombre_2" id="hvp_datos_personales_nombre_2" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_datos_personales_nombre_2; ?>" onchange="valida_nombre_preferencia();">
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_datos_personales_apellido_1" class="form-label my-0 font-size-12">Primer apellido</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_datos_personales_apellido_1" id="hvp_datos_personales_apellido_1" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_datos_personales_apellido_1; ?>" required>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_datos_personales_apellido_2" class="form-label my-0 font-size-12">Segundo apellido</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_datos_personales_apellido_2" id="hvp_datos_personales_apellido_2" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_datos_personales_apellido_2; ?>" required>
                                                    </div>
                                                    <div class="col-md-3 mb-3 " id="div_hvp_nombre_preferencia">
                                                        <?php if ($data['resultado_registros_usuario'][0]->hvp_datos_personales_nombre_1!='' AND $data['resultado_registros_usuario'][0]->hvp_datos_personales_nombre_2!=''): ?>
                                                            <label for="hvp_nombre_preferencia" class="form-label my-0 font-size-12">¿Cómo prefieres que te llamen?</label>
                                                            <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_nombre_preferencia" id="hvp_nombre_preferencia" data-container="body" title="Seleccione" required>
                                                                <option value="<?php echo $data['resultado_registros_usuario'][0]->hvp_datos_personales_nombre_1; ?>" <?php echo ($data['resultado_registros_usuario'][0]->hvp_auxiliar_1==$data['resultado_registros_usuario'][0]->hvp_datos_personales_nombre_1) ? 'selected' : ''; ?>><?php echo $data['resultado_registros_usuario'][0]->hvp_datos_personales_nombre_1; ?></option>
                                                                <option value="<?php echo $data['resultado_registros_usuario'][0]->hvp_datos_personales_nombre_2; ?>" <?php echo ($data['resultado_registros_usuario'][0]->hvp_auxiliar_1==$data['resultado_registros_usuario'][0]->hvp_datos_personales_nombre_2) ? 'selected' : ''; ?>><?php echo $data['resultado_registros_usuario'][0]->hvp_datos_personales_nombre_2; ?></option>
                                                            </select>
                                                        <?php elseif ($data['resultado_registros_usuario'][0]->hvp_datos_personales_nombre_1!=''): ?>
                                                            <label for="hvp_nombre_preferencia" class="form-label my-0 font-size-12">¿Cómo prefieres que te llamen?</label>
                                                            <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_nombre_preferencia" id="hvp_nombre_preferencia" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_auxiliar_1; ?>" required>
                                                        <?php endif; ?>
                                                        
                                                    </div>

                                                    <div class="col-md-12">
                                                        <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-address-card"></span> Información Demográfica</p>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_demografia_genero" class="form-label my-0 font-size-12">¿Cuál es tu género?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_demografia_genero" id="hvp_demografia_genero" data-container="body" title="Seleccione" required>
                                                            <option value="Hombre" <?php echo ($data['resultado_registros_usuario'][0]->hvp_demografia_genero=='Hombre') ? 'selected' : ''; ?>>Hombre</option>
                                                            <option value="Mujer" <?php echo ($data['resultado_registros_usuario'][0]->hvp_demografia_genero=='Mujer') ? 'selected' : ''; ?>>Mujer</option>
                                                            <option value="Hombre transexual" <?php echo ($data['resultado_registros_usuario'][0]->hvp_demografia_genero=='Hombre transexual') ? 'selected' : ''; ?>>Hombre transexual</option>
                                                            <option value="Mujer transexual" <?php echo ($data['resultado_registros_usuario'][0]->hvp_demografia_genero=='Mujer transexual') ? 'selected' : ''; ?>>Mujer transexual</option>
                                                            <option value="Bigénero" <?php echo ($data['resultado_registros_usuario'][0]->hvp_demografia_genero=='Bigénero') ? 'selected' : ''; ?>>Bigénero</option>
                                                            <option value="No Binario" <?php echo ($data['resultado_registros_usuario'][0]->hvp_demografia_genero=='No Binario') ? 'selected' : ''; ?>>No Binario</option>
                                                            <option value="Prefiero no decir" <?php echo ($data['resultado_registros_usuario'][0]->hvp_demografia_genero=='Prefiero no decir') ? 'selected' : ''; ?>>Prefiero no decir</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_demografia_estado_civil" class="form-label my-0 font-size-12">¿Cuál es tu estado civil ?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_demografia_estado_civil" id="hvp_demografia_estado_civil" data-container="body" title="Seleccione" required>
                                                            <option value="Soltero(a)" <?php echo ($data['resultado_registros_usuario'][0]->hvp_demografia_estado_civil=='Soltero(a)') ? 'selected' : ''; ?>>Soltero(a)</option>
                                                            <option value="Casado(a)" <?php echo ($data['resultado_registros_usuario'][0]->hvp_demografia_estado_civil=='Casado(a)') ? 'selected' : ''; ?>>Casado(a)</option>
                                                            <option value="Viudo(a)" <?php echo ($data['resultado_registros_usuario'][0]->hvp_demografia_estado_civil=='Viudo(a)') ? 'selected' : ''; ?>>Viudo(a)</option>
                                                            <option value="Separado(a)" <?php echo ($data['resultado_registros_usuario'][0]->hvp_demografia_estado_civil=='Separado(a)') ? 'selected' : ''; ?>>Separado(a)</option>
                                                            <option value="Unión libre" <?php echo ($data['resultado_registros_usuario'][0]->hvp_demografia_estado_civil=='Unión libre') ? 'selected' : ''; ?>>Unión libre</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hvp_demografia_lugar_nacimiento" class="form-label my-0 font-size-12">Lugar nacimiento</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_demografia_lugar_nacimiento" id="hvp_demografia_lugar_nacimiento" <?php echo ($_SESSION[APP_SESSION.'_usuario_add']==1) ? 'disabled' : ''; ?> data-live-search="true" data-container="body" title="Seleccione" required>
                                                            <?php foreach ($data['resultado_registros_ciudad'] as $registro): ?>
                                                                <option value="<?php echo $registro->ciu_codigo; ?>" class="font-size-11" <?php echo ($data['resultado_registros_usuario'][0]->hvp_demografia_lugar_nacimiento==$registro->ciu_codigo) ? 'selected' : ''; ?>><?php echo $registro->ciu_municipio.', '.$registro->ciu_departamento; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <label for="hvp_demografia_fecha_nacimiento" class="form-label my-0 font-size-12">Fecha nacimiento</label>
                                                        <input type="date" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_demografia_fecha_nacimiento" id="hvp_demografia_fecha_nacimiento" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_demografia_fecha_nacimiento; ?>" min="1940-01-01" max="<?php echo date('Y-m-d'); ?>" onchange="calcularEdad();" required>
                                                    </div>
                                                    <div class="col-md-1 mb-3">
                                                        <label for="hvp_demografia_edad" class="form-label my-0 font-size-12">Edad</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_demografia_edad" id="hvp_demografia_edad" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_demografia_edad; ?>" readonly required>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-history"></span> Información Antiguedad</p>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="hvp_expectativa_motivacion_expectativa_desarrollo" class="form-label my-0 font-size-12">¿Llevas más de 6 meses en la compañía?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_expectativa_motivacion_expectativa_desarrollo" id="hvp_expectativa_motivacion_expectativa_desarrollo" data-container="body" title="Seleccione" onchange="valida_antiguedad();" required>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_expectativa_motivacion_expectativa_desarrollo=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_expectativa_motivacion_expectativa_desarrollo=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3 d-none" id="div_hvp_expectativa_motivacion_expectativa_crecimiento_profesional">
                                                            <label for="hvp_expectativa_motivacion_expectativa_crecimiento_profesional" class="form-label my-0 font-size-12">¿Crees que este trabajo te ofrecerá oportunidades de crecimiento profesional?</label>
                                                            <div id="experience-level" class="btn-group w-100" role="group" aria-label="Calificación">
                                                                <!-- Botones toggle -->
                                                                <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_expectativa_crecimiento_profesional" id="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level1" value="1" <?php echo ($data['resultado_registros_usuario'][0]->hvp_expectativa_motivacion_expectativa_crecimiento_profesional=='1') ? 'checked' : ''; ?> required disabled>
                                                                <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level1">1</label>

                                                                <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_expectativa_crecimiento_profesional" id="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level2" value="2" <?php echo ($data['resultado_registros_usuario'][0]->hvp_expectativa_motivacion_expectativa_crecimiento_profesional=='2') ? 'checked' : ''; ?> required disabled>
                                                                <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level2">2</label>

                                                                <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_expectativa_crecimiento_profesional" id="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level3" value="3" <?php echo ($data['resultado_registros_usuario'][0]->hvp_expectativa_motivacion_expectativa_crecimiento_profesional=='3') ? 'checked' : ''; ?> required disabled>
                                                                <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level3">3</label>

                                                                <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_expectativa_crecimiento_profesional" id="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level4" value="4" <?php echo ($data['resultado_registros_usuario'][0]->hvp_expectativa_motivacion_expectativa_crecimiento_profesional=='4') ? 'checked' : ''; ?> required disabled>
                                                                <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level4">4</label>

                                                                <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_expectativa_crecimiento_profesional" id="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level5" value="5" <?php echo ($data['resultado_registros_usuario'][0]->hvp_expectativa_motivacion_expectativa_crecimiento_profesional=='5') ? 'checked' : ''; ?> required disabled>
                                                                <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level5">5</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3 d-none" id="div_hvp_expectativa_motivacion_realidad_crecimiento_profesional">
                                                            <label for="hvp_expectativa_motivacion_realidad_crecimiento_profesional" class="form-label my-0 font-size-12">¿En qué medida estás de acuerdo con la siguiente afirmación?:<br><br><b><i>“Este trabajo me ha ofrecido oportunidades de crecimiento laboral.”</i></b></label>
                                                            <div id="experience-level" class="btn-group w-100" role="group" aria-label="Calificación">
                                                                <!-- Botones toggle -->
                                                                <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_realidad_crecimiento_profesional" id="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level1" value="Totalmente en desacuerdo" <?php echo ($data['resultado_registros_usuario'][0]->hvp_expectativa_motivacion_realidad_crecimiento_profesional=='Totalmente en desacuerdo') ? 'checked' : ''; ?> required disabled>
                                                                <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level1">Totalmente en desacuerdo</label>
    
                                                                <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_realidad_crecimiento_profesional" id="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level2" value="En desacuerdo" <?php echo ($data['resultado_registros_usuario'][0]->hvp_expectativa_motivacion_realidad_crecimiento_profesional=='En desacuerdo') ? 'checked' : ''; ?> required disabled>
                                                                <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level2">En desacuerdo</label>
    
                                                                <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_realidad_crecimiento_profesional" id="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level3" value="Ni de acuerdo ni en desacuerdo" <?php echo ($data['resultado_registros_usuario'][0]->hvp_expectativa_motivacion_realidad_crecimiento_profesional=='Ni de acuerdo ni en desacuerdo') ? 'checked' : ''; ?> required disabled>
                                                                <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level3">Ni de acuerdo ni en desacuerdo</label>
    
                                                                <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_realidad_crecimiento_profesional" id="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level4" value="De acuerdo" <?php echo ($data['resultado_registros_usuario'][0]->hvp_expectativa_motivacion_realidad_crecimiento_profesional=='De acuerdo') ? 'checked' : ''; ?> required disabled>
                                                                <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level4">De acuerdo</label>
    
                                                                <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_realidad_crecimiento_profesional" id="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level5" value="Totalmente de acuerdo" <?php echo ($data['resultado_registros_usuario'][0]->hvp_expectativa_motivacion_realidad_crecimiento_profesional=='Totalmente de acuerdo') ? 'checked' : ''; ?> required disabled>
                                                                <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level5">Totalmente de acuerdo</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-3 d-none" id="div_hvp_expectativa_motivacion_motivacion_trabajo">
                                                        <label for="hvp_expectativa_motivacion_motivacion_trabajo" class="form-label my-0 font-size-12">Motivación principal para aceptar el trabajo</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_expectativa_motivacion_motivacion_trabajo" id="hvp_expectativa_motivacion_motivacion_trabajo" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_expectativa_motivacion_motivacion_trabajo; ?>" required autocomplete="off" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php echo Flasher::flash(); ?>
                                            <div class="col-md-12 text-end">
                                                <span id="btn_enviar">
                                                    <a href="<?php echo URL; ?>hoja-vida/formulario-instrucciones/<?php echo base64_encode('instrucciones'); ?>" class="btn btn-warning login-btn">Regresar</a>
                                                    <button type="submit" name="form_guardar" class="btn btn-success login-btn">Guardar y continuar</button>
                                                </span>
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
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#hvp_datos_personales_numero_identificacion").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_datos_personales_nombre_1").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_datos_personales_nombre_2").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_datos_personales_apellido_1").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_datos_personales_apellido_2").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_nombre_preferencia").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_expectativa_motivacion_motivacion_trabajo").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    document.getElementById("id_form_guardar").addEventListener("submit", function(event) {
        let formulario = this;
        let valido = true;

        // Selecciona todos los inputs y selects requeridos que no estén deshabilitados
        let campos = formulario.querySelectorAll("input[required]:not([disabled]), select[required]:not([disabled]), checkbox[required]:not([disabled])");

        campos.forEach(campo => {
            if (campo.type === "checkbox") {
                // Validar checkbox requerido
                if (!campo.checked) {
                    campo.classList.add("is-invalid");
                    campo.classList.remove("is-valid");
                    valido = false;
                    console.log('Ingreso NO valido: '+campo.name);
                } else {
                    campo.classList.add("is-valid");
                    campo.classList.remove("is-invalid");
                }
            } else if (campo.tagName === "SELECT") {
                // Validar select requerido
                let container = campo.closest('.bootstrap-select');
                if (!campo.value || campo.value === "") {
                    campo.classList.add("is-invalid");
                    campo.classList.remove("is-valid");
                    if (container) container.classList.remove("is-valid");
                    if (container) container.classList.add("is-invalid");
                    valido = false;
                    console.log('Ingreso NO valido: '+campo.name);
                } else {
                    campo.classList.add("is-valid");
                    campo.classList.remove("is-invalid");
                    if (container) container.classList.add("is-valid");
                    if (container) container.classList.remove("is-invalid");
                }
            } else {
                // Validar inputs de texto y otros tipos
                if (!campo.value.trim()) {
                    campo.classList.add("is-invalid");
                    campo.classList.remove("is-valid");
                    valido = false;
                    console.log('Ingreso NO valido: '+campo.name);
                } else {
                    campo.classList.add("is-valid");
                    campo.classList.remove("is-invalid");
                }
            }
        });

        if (!valido) {
            console.log('Ingreso NO valido');
            event.preventDefault(); // Evita el envío del formulario si hay errores
        }
    });
</script>
<script type="text/javascript">
    function valida_nombre_preferencia() {
        $("#div_hvp_nombre_preferencia").removeClass('d-block').addClass('d-none');

        document.getElementById('hvp_nombre_preferencia').disabled=true;

        var hvp_datos_personales_nombre_1 = document.getElementById("hvp_datos_personales_nombre_1").value;
        var hvp_datos_personales_nombre_2 = document.getElementById("hvp_datos_personales_nombre_2").value;

        if (hvp_datos_personales_nombre_1!="" && hvp_datos_personales_nombre_2!="") {
            $("#div_hvp_nombre_preferencia").removeClass('d-none').addClass('d-block');
            $("#div_hvp_nombre_preferencia").html('<label for="hvp_nombre_preferencia" class="form-label my-0 font-size-12">¿Cómo prefieres que te llamen?</label>\
                                                <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_nombre_preferencia" id="hvp_nombre_preferencia" data-container="body" title="Seleccione" required disabled>\
                                                    <option value="'+hvp_datos_personales_nombre_1+'">'+hvp_datos_personales_nombre_1+'</option>\
                                                    <option value="'+hvp_datos_personales_nombre_2+'">'+hvp_datos_personales_nombre_2+'</option>\
                                                </select>');
            document.getElementById('hvp_nombre_preferencia').disabled=false;
            $('#hvp_nombre_preferencia').selectpicker('destroy');
            $('#hvp_nombre_preferencia').selectpicker();
        } else if (hvp_datos_personales_nombre_1!="") {
            $("#div_hvp_nombre_preferencia").removeClass('d-none').addClass('d-block');
            $("#div_hvp_nombre_preferencia").html('<label for="hvp_nombre_preferencia" class="form-label my-0 font-size-12">¿Cómo prefieres que te llamen?</label>\
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_nombre_preferencia" id="hvp_nombre_preferencia" value="" required disabled>');
            document.getElementById('hvp_nombre_preferencia').disabled=false;
        }

    }

    function calcularEdad() {
        // Obtener la fecha de nacimiento desde el input date
        var fechaNacimiento = new Date(document.getElementById("hvp_demografia_fecha_nacimiento").value);
        // Obtener la fecha actual
        var fechaActual = new Date();

        // Calcular la diferencia en milisegundos entre las dos fechas
        var diferencia = fechaActual - fechaNacimiento;

        // Calcular la edad en años
        var edad = Math.floor(diferencia / (1000 * 60 * 60 * 24 * 365.25));
        if (edad!='NaN') {
            // Mostrar la edad en el input number
            document.getElementById("hvp_demografia_edad").value = edad;
        } else {
            document.getElementById("hvp_demografia_edad").value = '';
        }
    }
    calcularEdad();

    function valida_antiguedad() {
        $("#div_hvp_expectativa_motivacion_expectativa_crecimiento_profesional").removeClass('d-block').addClass('d-none');
        $("#div_hvp_expectativa_motivacion_realidad_crecimiento_profesional").removeClass('d-block').addClass('d-none');
        $("#div_hvp_expectativa_motivacion_motivacion_trabajo").removeClass('d-block').addClass('d-none');
        
        document.getElementById('hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level1').disabled=true;
        document.getElementById('hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level2').disabled=true;
        document.getElementById('hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level3').disabled=true;
        document.getElementById('hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level4').disabled=true;
        document.getElementById('hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level5').disabled=true;
        
        document.getElementById('hvp_expectativa_motivacion_realidad_crecimiento_profesional_level1').disabled=true;
        document.getElementById('hvp_expectativa_motivacion_realidad_crecimiento_profesional_level2').disabled=true;
        document.getElementById('hvp_expectativa_motivacion_realidad_crecimiento_profesional_level3').disabled=true;
        document.getElementById('hvp_expectativa_motivacion_realidad_crecimiento_profesional_level4').disabled=true;
        document.getElementById('hvp_expectativa_motivacion_realidad_crecimiento_profesional_level5').disabled=true;
        
        document.getElementById('hvp_expectativa_motivacion_motivacion_trabajo').disabled=true;
        
        var hvp_expectativa_motivacion_expectativa_desarrollo = document.getElementById("hvp_expectativa_motivacion_expectativa_desarrollo").value;

        if (hvp_expectativa_motivacion_expectativa_desarrollo!="" && (hvp_expectativa_motivacion_expectativa_desarrollo=="Si")) {
            $("#div_hvp_expectativa_motivacion_realidad_crecimiento_profesional").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_expectativa_motivacion_realidad_crecimiento_profesional_level1').disabled=false;
            document.getElementById('hvp_expectativa_motivacion_realidad_crecimiento_profesional_level2').disabled=false;
            document.getElementById('hvp_expectativa_motivacion_realidad_crecimiento_profesional_level3').disabled=false;
            document.getElementById('hvp_expectativa_motivacion_realidad_crecimiento_profesional_level4').disabled=false;
            document.getElementById('hvp_expectativa_motivacion_realidad_crecimiento_profesional_level5').disabled=false;
        } else if (hvp_expectativa_motivacion_expectativa_desarrollo!="" && (hvp_expectativa_motivacion_expectativa_desarrollo=="No")) {
            $("#div_hvp_expectativa_motivacion_expectativa_crecimiento_profesional").removeClass('d-none').addClass('d-block');
            $("#div_hvp_expectativa_motivacion_motivacion_trabajo").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level1').disabled=false;
            document.getElementById('hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level2').disabled=false;
            document.getElementById('hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level3').disabled=false;
            document.getElementById('hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level4').disabled=false;
            document.getElementById('hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level5').disabled=false;
            document.getElementById('hvp_expectativa_motivacion_motivacion_trabajo').disabled=false;
        }
    }

    <?php if($data['resultado_registros_usuario'][0]->hvp_expectativa_motivacion_expectativa_desarrollo!=''): ?>
        valida_antiguedad();
    <?php endif; ?>


</script>
<script type="text/javascript">
    function progreso() {
        var formData = new FormData();

        $.ajax({
            type: 'POST',
            url: '<?php echo URL; ?>hoja-vida/formulario-progreso',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                
            },
            complete:function(data){
                
            },
            success: function(data){
                var resp = $.parseJSON(data);
                $('#status_autorizaciones').removeClass('seccion-warning').removeClass('seccion-success').addClass(resp.status_autorizaciones);
                $('#status_personal').removeClass('seccion-warning').removeClass('seccion-success').addClass(resp.status_personal);
                $('#status_ubicacion').removeClass('seccion-warning').removeClass('seccion-success').addClass(resp.status_ubicacion);
                $('#status_familiar').removeClass('seccion-warning').removeClass('seccion-success').addClass(resp.status_familiar);
                $('#status_salud').removeClass('seccion-warning').removeClass('seccion-success').addClass(resp.status_salud);
                $('#status_intereses').removeClass('seccion-warning').removeClass('seccion-success').addClass(resp.status_intereses);
                $('#status_formacion').removeClass('seccion-warning').removeClass('seccion-success').addClass(resp.status_formacion);
                $('#status_poblaciones').removeClass('seccion-warning').removeClass('seccion-success').addClass(resp.status_poblaciones);
                $('#avance_barra').html(resp.avance_barra);
                $('#avance_total').html(resp.avance_total);
                $('#secciones_total').html(resp.secciones_total);
            },
            error: function(data){
                alert("Problemas al tratar de obtener el progreso, por favor verifique e intente nuevamente");
            }
        });
    }

    progreso();
</script>