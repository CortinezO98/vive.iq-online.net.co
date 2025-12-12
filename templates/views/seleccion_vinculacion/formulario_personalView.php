<?php require_once INCLUDES.'inc_head.php'; ?>
<!-- container -->
<main class="px-5 d-flex flex-column">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center my-5">
                <h3 class="mb-0 font-size-11">| <?php echo str_replace('|', '<span class="fas fa-chevron-right text-gray-400 mx-1"></span>', $data['titulo_pagina']); ?></h3>
            </div>
        </div>
    </div>
    <form name="form_guardar" id="form_guardar_frm" action="" method="post" class="comment-form" enctype="multipart/form-data">
    <div class="row justify-content-center mb-2">
        <?php if($data['valida_token']): ?>
            <div class="col-md-3">
                <div class="bg-white rounded-3 col-lg-12 col-md-12 col-12">
                    <div class="row mb-5">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="row p-6 d-lg-flex justify-content-between align-items-center">
                                <div class="col-md-12">
                                    <p class="alert alert-corp px-2 py-1 font-size-11 mt-0 mb-3"><span class="fas fa-list-ol"></span> Secciones</p>
                                </div>
                                <div class="col-md-12 px-5">
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-instrucciones<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Instrucciones</a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-personal<?php echo $data['path_add']; ?>" class="btn btn-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Información Personal<span id="status_personal"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-familiar<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Información Familiar<span id="status_familiar"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-estudio-culminado<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Estudios Culminados<span id="status_estudio_culminado"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-estudio-curso<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Estudios en Curso<span id="status_estudio_curso"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-experiencia<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Experiencia Laboral<span id="status_laboral"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-etica<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Código de ética, Anticorrupción y Buen Gobierno<span id="status_etica"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-iq<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Información IQ<span id="status_informacion"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-financiera<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Información Financiera<span id="status_financiera"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-publica<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Personas Expuestas Públicamente - PEP<span id="status_publica"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-segsocial<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Seguridad Social<span id="status_segsocial"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-autorizaciones<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Declaraciones<span id="status_autorizaciones"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-autorizaciones-datos<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Autorización Tratamiento Datos Personales<span id="status_datos_personales"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-documentos<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Documentos<span id="status_documentos"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-cierre<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Firmar y enviar<span id="status_firma"></span></a>
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
                                        <div class="row mb-2">
                                            <div class="col-md-2 text-start">
                                                <img src="<?php echo IMAGES; ?><?php echo LOGO; ?>" class="mb-2 img-fluid"></a>
                                            </div>
                                            <div class="col-md-10">
                                                <label for="">Progreso</label><span class="float-end">Completado: <span id="avance_total"></span> de <span id="secciones_total"></span></span>
                                                <div class="progress" style="height: 25px;" id="avance_barra">
                                                    
                                                </div>
                                            </div>
                                            <hr class="my-3">
                                            <h3>Información Personal</h3>
                                            <?php if($data['valida_token']): ?>
                                                <?php if($data['valida_oferta']): ?>
                                                <div class="col-md-3 mb-3">
                                                    <label for="hva_nombres" class="form-label my-0 font-size-12">Primer nombre</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hva_nombres" id="hva_nombres" value="<?php echo $data['resultado_registros_usuario'][0]->hva_nombres; ?>" required disabled>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="hva_nombres_2" class="form-label my-0 font-size-12">Segundo nombre</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hva_nombres_2" id="hva_nombres_2" value="<?php echo $data['resultado_registros_usuario'][0]->hva_nombres_2; ?>" required disabled>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="hva_apellido_1" class="form-label my-0 font-size-12">Primer apellido</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hva_apellido_1" id="hva_apellido_1" value="<?php echo $data['resultado_registros_usuario'][0]->hva_apellido_1; ?>" required disabled>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="hva_apellido_2" class="form-label my-0 font-size-12">Segundo apellido</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hva_apellido_2" id="hva_apellido_2" value="<?php echo $data['resultado_registros_usuario'][0]->hva_apellido_2; ?>" required disabled>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="hva_identificacion" class="form-label my-0 font-size-12">Doc identidad</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hva_identificacion" id="hva_identificacion" value="<?php echo $data['resultado_registros_usuario'][0]->hva_identificacion; ?>" required disabled>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="hva_auxiliar_5" class="form-label my-0 font-size-12">Fecha de expedición</label>
                                                    <input type="date" class="form-control form-control-sm font-size-11 px-2 py-1" name="hva_auxiliar_5" id="hva_auxiliar_5" value="<?php echo $data['resultado_registros_usuario'][0]->hva_auxiliar_5; ?>" min="1940-01-01" max="<?php echo date('Y-m-d'); ?>" required>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="hva_ciudad" class="form-label my-0 font-size-12">Ciudad</label>
                                                    <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hva_ciudad" id="hva_ciudad" <?php echo ($_SESSION[APP_SESSION.'_usuario_add']==1) ? 'disabled' : ''; ?> data-live-search="true" data-container="body" title="Seleccione" onchange="valida_ciudad();" required>
                                                        <?php foreach ($data['resultado_registros_ciudad'] as $registro): ?>
                                                            <option value="<?php echo $registro->ciu_codigo; ?>" class="font-size-11" <?php echo ($data['resultado_registros_usuario'][0]->hva_ciudad==$registro->ciu_codigo) ? 'selected' : ''; ?>><?php echo $registro->ciu_municipio.', '.$registro->ciu_departamento; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="hva_direccion" class="form-label my-0 font-size-12">Dirección</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hva_direccion" id="hva_direccion" value="<?php echo $data['resultado_registros_usuario'][0]->hva_direccion; ?>" required readonly>
                                                        <div class="input-group-append">
                                                            <a href="#" class="btn btn-warning login-btn font-size-11 px-1 py-1" onclick="open_modal_direccion();">Diligenciar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mb-3 <?php echo $data['control_localidad']; ?>" id="hva_localidad_div">
                                                    <label for="hva_localidad" class="form-label my-0 font-size-12">Localidad</label>
                                                    <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hva_localidad" id="hva_localidad" data-live-search="true" data-container="body" title="Seleccione" onchange="valida_localidad();" required <?php echo ($data['control_localidad']=='d-block') ? '' : 'disabled'; ?>>
                                                        <?php foreach ($data['resultado_registros_localidad'] as $registro): ?>
                                                            <option value="<?php echo $registro->ciub_localidad; ?>" class="font-size-11" <?php echo ($data['resultado_registros_usuario'][0]->hva_localidad==$registro->ciub_localidad) ? 'selected' : ''; ?>><?php echo $registro->ciub_localidad; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 mb-3 <?php echo $data['control_barrio']; ?>" id="hva_barrio_div">
                                                    <label for="hva_barrio" class="form-label my-0 font-size-12">Barrio</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hva_barrio" id="hva_barrio" value="<?php echo $data['resultado_registros_usuario'][0]->hva_barrio; ?>" required <?php echo ($data['control_barrio']=='d-block') ? '' : 'disabled'; ?>>
                                                </div>
                                                <div class="col-md-2 mb-3 <?php echo $data['control_barrio_lista']; ?>" id="hva_barrio_lista_div">
                                                    <label for="hva_barrio_lista" class="form-label my-0 font-size-12">Barrio</label>
                                                    <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hva_barrio_lista" id="hva_barrio_lista" data-live-search="true" data-container="body" title="Seleccione" required <?php echo ($data['control_barrio_lista']=='d-block') ? '' : 'disabled'; ?>>
                                                        <?php foreach ($data['resultado_registros_barrio'] as $registro): ?>
                                                            <option value="<?php echo $registro->ciub_barrio; ?>" class="font-size-11" <?php echo ($data['resultado_registros_usuario'][0]->hva_barrio==$registro->ciub_barrio) ? 'selected' : ''; ?>><?php echo $registro->ciub_barrio; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="hva_celular" class="form-label my-0 font-size-12">Celular</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hva_celular" id="hva_celular" value="<?php echo $data['resultado_registros_usuario'][0]->hva_celular; ?>" required>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="hva_celular_2" class="form-label my-0 font-size-12">Número de contacto alternativo</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hva_celular_2" id="hva_celular_2" value="<?php echo $data['resultado_registros_usuario'][0]->hva_celular_2; ?>">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="hva_correo" class="form-label my-0 font-size-12">E-mail</label>
                                                    <input type="email" class="form-control form-control-sm font-size-11 px-2 py-1" name="hva_correo" id="hva_correo" value="<?php echo $data['resultado_registros_usuario'][0]->hva_correo; ?>" required disabled>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="hva_nacimiento_lugar" class="form-label my-0 font-size-12">Lugar nacimiento</label>
                                                    <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hva_nacimiento_lugar" id="hva_nacimiento_lugar" <?php echo ($_SESSION[APP_SESSION.'_usuario_add']==1) ? 'disabled' : ''; ?> data-live-search="true" data-container="body" title="Seleccione" required>
                                                        <?php foreach ($data['resultado_registros_ciudad'] as $registro): ?>
                                                            <option value="<?php echo $registro->ciu_codigo; ?>" class="font-size-11" <?php echo ($data['resultado_registros_usuario'][0]->hva_nacimiento_lugar==$registro->ciu_codigo) ? 'selected' : ''; ?>><?php echo $registro->ciu_municipio.', '.$registro->ciu_departamento; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="hva_nacimiento_fecha" class="form-label my-0 font-size-12">Fecha nacimiento</label>
                                                    <input type="date" class="form-control form-control-sm font-size-11 px-2 py-1" name="hva_nacimiento_fecha" id="hva_nacimiento_fecha" value="<?php echo $data['resultado_registros_usuario'][0]->hva_nacimiento_fecha; ?>" min="1940-01-01" max="<?php echo date('Y-m-d'); ?>" onchange="calcularEdad();" required>
                                                </div>
                                                <div class="col-md-1 mb-3">
                                                    <label for="hva_edad" class="form-label my-0 font-size-12">Edad</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hva_edad" id="hva_edad" value="<?php echo $data['resultado_registros_usuario'][0]->hva_edad; ?>" readonly required>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="hva_estado_civil" class="form-label my-0 font-size-12">Estado civil</label>
                                                    <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hva_estado_civil" id="hva_estado_civil" data-container="body" title="Seleccione" required>
                                                        <option value="Soltero(a)" <?php echo ($data['resultado_registros_usuario'][0]->hva_estado_civil=='Soltero(a)') ? 'selected' : ''; ?>>Soltero(a)</option>
                                                        <option value="Casado(a)" <?php echo ($data['resultado_registros_usuario'][0]->hva_estado_civil=='Casado(a)') ? 'selected' : ''; ?>>Casado(a)</option>
                                                        <option value="Viudo(a)" <?php echo ($data['resultado_registros_usuario'][0]->hva_estado_civil=='Viudo(a)') ? 'selected' : ''; ?>>Viudo(a)</option>
                                                        <option value="Separado(a)" <?php echo ($data['resultado_registros_usuario'][0]->hva_estado_civil=='Separado(a)') ? 'selected' : ''; ?>>Separado(a)</option>
                                                        <option value="Unión libre" <?php echo ($data['resultado_registros_usuario'][0]->hva_estado_civil=='Unión libre') ? 'selected' : ''; ?>>Unión libre</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="hva_genero" class="form-label my-0 font-size-12">Con cual género te identificas?</label>
                                                    <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hva_genero" id="hva_genero" data-container="body" title="Seleccione" required>
                                                        <option value="Hombre" <?php echo ($data['resultado_registros_usuario'][0]->hva_genero=='Hombre') ? 'selected' : ''; ?>>Hombre</option>
                                                        <option value="Mujer" <?php echo ($data['resultado_registros_usuario'][0]->hva_genero=='Mujer') ? 'selected' : ''; ?>>Mujer</option>
                                                        <option value="Hombre transexual" <?php echo ($data['resultado_registros_usuario'][0]->hva_genero=='Hombre transexual') ? 'selected' : ''; ?>>Hombre transexual</option>
                                                        <option value="Mujer transexual" <?php echo ($data['resultado_registros_usuario'][0]->hva_genero=='Mujer transexual') ? 'selected' : ''; ?>>Mujer transexual</option>
                                                        <option value="Bigénero" <?php echo ($data['resultado_registros_usuario'][0]->hva_genero=='Bigénero') ? 'selected' : ''; ?>>Bigénero</option>
                                                        <option value="No Binario" <?php echo ($data['resultado_registros_usuario'][0]->hva_genero=='No Binario') ? 'selected' : ''; ?>>No Binario</option>
                                                        <option value="Otro" <?php echo ($data['resultado_registros_usuario'][0]->hva_genero=='Otro') ? 'selected' : ''; ?>>Otro</option>
                                                        <option value="Prefiero no decir" <?php echo ($data['resultado_registros_usuario'][0]->hva_genero=='Prefiero no decir') ? 'selected' : ''; ?>>Prefiero no decir</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="hvaem_grupo_sanguineo" class="form-label my-0 font-size-12">Grupo sanguíneo</label>
                                                    <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvaem_grupo_sanguineo" id="hvaem_grupo_sanguineo" data-container="body" title="Seleccione" required>
                                                        <option value="A" <?php echo ($data['resultado_registros_emergencia'][0]->hvaem_grupo_sanguineo=='A') ? 'selected' : ''; ?>>A</option>
                                                        <option value="B" <?php echo ($data['resultado_registros_emergencia'][0]->hvaem_grupo_sanguineo=='B') ? 'selected' : ''; ?>>B</option>
                                                        <option value="O" <?php echo ($data['resultado_registros_emergencia'][0]->hvaem_grupo_sanguineo=='O') ? 'selected' : ''; ?>>O</option>
                                                        <option value="AB" <?php echo ($data['resultado_registros_emergencia'][0]->hvaem_grupo_sanguineo=='AB') ? 'selected' : ''; ?>>AB</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1 mb-3">
                                                    <label for="hvaem_rh" class="form-label my-0 font-size-12">RH</label>
                                                    <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvaem_rh" id="hvaem_rh" data-container="body" title="Seleccione" required>
                                                        <option value="Positivo" <?php echo ($data['resultado_registros_emergencia'][0]->hvaem_rh=='Positivo') ? 'selected' : ''; ?>>Positivo</option>
                                                        <option value="Negativo" <?php echo ($data['resultado_registros_emergencia'][0]->hvaem_rh=='Negativo') ? 'selected' : ''; ?>>Negativo</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="hva_operador_internet" class="form-label my-0 font-size-12">Operador de internet</label>
                                                    <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hva_operador_internet" id="hva_operador_internet" data-container="body" title="Seleccione" required>
                                                        <option value="A Y A" <?php echo ($data['resultado_registros_usuario'][0]->hva_operador_internet=='A Y A') ? 'selected' : ''; ?>>A Y A</option>
                                                        <option value="AZTECA COMUNICACIONES" <?php echo ($data['resultado_registros_usuario'][0]->hva_operador_internet=='AZTECA COMUNICACIONES') ? 'selected' : ''; ?>>AZTECA COMUNICACIONES</option>
                                                        <option value="CABLE VISIÓN" <?php echo ($data['resultado_registros_usuario'][0]->hva_operador_internet=='CABLE VISIÓN') ? 'selected' : ''; ?>>CABLE VISIÓN</option>
                                                        <option value="CABLEMÁS" <?php echo ($data['resultado_registros_usuario'][0]->hva_operador_internet=='CABLEMÁS') ? 'selected' : ''; ?>>CABLEMÁS</option>
                                                        <option value="CLARO" <?php echo ($data['resultado_registros_usuario'][0]->hva_operador_internet=='CLARO') ? 'selected' : ''; ?>>CLARO</option>
                                                        <option value="COLCABLE" <?php echo ($data['resultado_registros_usuario'][0]->hva_operador_internet=='COLCABLE') ? 'selected' : ''; ?>>COLCABLE</option>
                                                        <option value="COLOMBIA + TV" <?php echo ($data['resultado_registros_usuario'][0]->hva_operador_internet=='COLOMBIA + TV') ? 'selected' : ''; ?>>COLOMBIA + TV</option>
                                                        <option value="CONEXIÓN DIGITAL" <?php echo ($data['resultado_registros_usuario'][0]->hva_operador_internet=='CONEXIÓN DIGITAL') ? 'selected' : ''; ?>>CONEXIÓN DIGITAL</option>
                                                        <option value="DIRECTV" <?php echo ($data['resultado_registros_usuario'][0]->hva_operador_internet=='DIRECTV') ? 'selected' : ''; ?>>DIRECTV</option>
                                                        <option value="ETB" <?php echo ($data['resultado_registros_usuario'][0]->hva_operador_internet=='ETB') ? 'selected' : ''; ?>>ETB</option>
                                                        <option value="HV TELEVISIÓN" <?php echo ($data['resultado_registros_usuario'][0]->hva_operador_internet=='HV TELEVISIÓN') ? 'selected' : ''; ?>>HV TELEVISIÓN</option>
                                                        <option value="MOVISTAR" <?php echo ($data['resultado_registros_usuario'][0]->hva_operador_internet=='MOVISTAR') ? 'selected' : ''; ?>>MOVISTAR</option>
                                                        <option value="STARGO" <?php echo ($data['resultado_registros_usuario'][0]->hva_operador_internet=='STARGO') ? 'selected' : ''; ?>>STARGO</option>
                                                        <option value="TIGO" <?php echo ($data['resultado_registros_usuario'][0]->hva_operador_internet=='TIGO') ? 'selected' : ''; ?>>TIGO</option>
                                                        <option value="UNE EPM" <?php echo ($data['resultado_registros_usuario'][0]->hva_operador_internet=='UNE EPM') ? 'selected' : ''; ?>>UNE EPM</option>
                                                        <option value="WI-SAT COMUNICACIONES LTDA" <?php echo ($data['resultado_registros_usuario'][0]->hva_operador_internet=='WI-SAT COMUNICACIONES LTDA') ? 'selected' : ''; ?>>WI-SAT COMUNICACIONES LTDA</option>
                                                        <option value="NO REPORTA" <?php echo ($data['resultado_registros_usuario'][0]->hva_operador_internet=='NO REPORTA') ? 'selected' : ''; ?>>NO REPORTA</option>
                                                    </select>
                                                </div>
                                                <hr class="my-3">
                                                <h3>Información en caso de Emergencia</h3>
                                                <p class="appoinment-content-text mt-0 mb-2">En caso de emergencia avisar a:</p>
                                                <div class="col-md-6 mb-3">
                                                    <label for="hvaem_nombres_apellidos" class="form-label my-0 font-size-12">Nombres y apellidos</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaem_nombres_apellidos" id="hvaem_nombres_apellidos" value="<?php echo $data['resultado_registros_emergencia'][0]->hvaem_nombres_apellidos; ?>" required>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="hvaem_parentesco" class="form-label my-0 font-size-12">Parentesco</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaem_parentesco" id="hvaem_parentesco" value="<?php echo $data['resultado_registros_emergencia'][0]->hvaem_parentesco; ?>" required>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="hvaem_telefono" class="form-label my-0 font-size-12">Teléfono</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaem_telefono" id="hvaem_telefono" value="<?php echo $data['resultado_registros_emergencia'][0]->hvaem_telefono; ?>" required>
                                                </div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <div class="col-md-12 my-2">
                                                    <p class="alert alert-warning p-1">¡No hemos podido validar el token, por favor intenta nuevamente!</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php echo Flasher::flash(); ?>
                                    <div class="col-md-12 text-end">
                                        <span id="btn_enviar">
                                            <button type="submit" name="form_guardar" class="btn btn-success login-btn">Guardar</button>
                                            <span id="btn_continuar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="col-md-12 my-2">
                <p class="alert alert-warning p-1">¡No hemos podido validar el token, por favor intenta nuevamente!</p>
            </div>
        <?php endif; ?>
    </div>
    </form>
</main>
<!-- MODAL DETALLE -->
    <div class="modal fade" id="modal-detalle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Asistente para el ingreso de la dirección</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body-detalle">
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger py-2 px-2" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success d-none" name="btn_guardar_direccion" id="btn_guardar_direccion" data-bs-dismiss="modal" onclick="guardar_direccion();">Guardar dirección</button>
            </div>
        </div>
        </div>
    </div>
<?php require_once INCLUDES.'inc_footer_index.php'; ?>
<script src="<?php echo JS; ?>valid-input.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#hva_celular").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    }); 
    
    jQuery(document).ready(function(){
        jQuery("#hva_celular_2").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });
    
    jQuery(document).ready(function(){
        jQuery("#hva_direccion").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hva_barrio").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvaem_nombres_apellidos").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvaem_parentesco").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvaem_telefono").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });
</script>
<script type="text/javascript">
    function progreso() {
        var id_oferta = '<?php echo $data['id_oferta']; ?>';
        var token = '<?php echo $data['id_token']; ?>';

        var formData = new FormData();

        if (token!="" && id_oferta!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>seleccion-vinculacion/formulario-progreso/'+id_oferta+'/'+token,
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
                    $('#status_personal').html(resp.status_personal);
                    $('#status_familiar').html(resp.status_familiar);
                    $('#status_estudio_culminado').html(resp.status_estudio_culminado);
                    $('#status_estudio_curso').html(resp.status_estudio_curso);
                    $('#status_laboral').html(resp.status_laboral);
                    $('#status_etica').html(resp.status_etica);
                    $('#status_informacion').html(resp.status_informacion);
                    $('#status_financiera').html(resp.status_financiera);
                    $('#status_publica').html(resp.status_publica);
                    $('#status_segsocial').html(resp.status_segsocial);
                    $('#status_autorizaciones').html(resp.status_autorizaciones);
                    $('#status_datos_personales').html(resp.status_datos_personales);
                    $('#status_documentos').html(resp.status_documentos);
                    $('#status_firma').html(resp.status_firma);
                    $('#avance_barra').html(resp.avance_barra);
                    $('#avance_total').html(resp.avance_total);
                    $('#secciones_total').html(resp.secciones_total);

                    if (resp.secciones.personal==1) {
                        $('#btn_continuar').html('<a href="<?php echo URL; ?>seleccion-vinculacion/formulario-familiar<?php echo $data['path_add']; ?>" class="btn btn-dark login-btn">Continuar</a>');
                    }

                    if (resp.control_envio) {
                        $('#btn_enviar').html(resp.control_envio_string);
                    }
                },
                error: function(data){
                    alert("Problemas al tratar de obtener el progreso, por favor verifique e intente nuevamente");
                }
            });
        } else {
            alert("Problemas al tratar de obtener el progreso, por favor verifique e intente nuevamente");
        }
    }

    progreso();
</script>
<script type="text/javascript">
    function open_modal_direccion() {
        var myModal = new bootstrap.Modal(document.getElementById("modal-detalle"), {});
        $('.modal-body-detalle').load('<?php echo URL; ?>seleccion-vinculacion/formulario-direccion',function(){
            myModal.show();
        });
    }

    function close_modal_direccion() {
        var myModal = new bootstrap.Modal(document.getElementById("modal-detalle"), {});
        $('.modal-body-detalle').html('');
    }

    function guardar_direccion() {
        var direccion_completa = $('#direccion_completa').val();
        $('#hva_direccion').val(direccion_completa);
        
        close_modal_direccion();
    }

    function valida_ciudad() {
        var id_oferta = '<?php echo $data['id_oferta']; ?>';
        var formData = new FormData();

        $("#hva_localidad_div").removeClass('d-block').addClass('d-none');
        $("#hva_barrio_lista_div").removeClass('d-block').addClass('d-none');
        $("#hva_barrio_div").removeClass('d-block').addClass('d-none');

        $('#hva_localidad').selectpicker('val', '');
        $('#hva_localidad').selectpicker('destroy');
        $('#hva_localidad').selectpicker();

        $('#hva_barrio_lista').selectpicker('val', '');
        $('#hva_barrio_lista').selectpicker('destroy');
        $('#hva_barrio_lista').selectpicker();
        document.getElementById('hva_localidad').disabled=true;
        document.getElementById('hva_barrio_lista').disabled=true;
        document.getElementById('hva_barrio').disabled=true;

        var hva_ciudad = document.getElementById("hva_ciudad").value;

        if (hva_ciudad!="" && (hva_ciudad=="11001" || hva_ciudad=="05001")) {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>seleccion-vinculacion/formulario-localidad/'+hva_ciudad+'/'+id_oferta,
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
                    $("#hva_localidad").html(resp.resultado);
                    $("#hva_localidad_div").removeClass('d-none').addClass('d-block');
                    document.getElementById('hva_localidad').disabled=false;
                    $('#hva_localidad').selectpicker('destroy');
                    $('#hva_localidad').selectpicker();
                },
                error: function(data){
                    alert("Problemas al tratar de obtener los datos, por favor verifique e intente nuevamente");
                }
            });
        } else {
            $("#hva_barrio_div").removeClass('d-none').addClass('d-block');
            document.getElementById('hva_barrio').disabled=false;
        }
    }

    function valida_localidad() {
        var id_oferta = '<?php echo $data['id_oferta']; ?>';
        var formData = new FormData();

        $("#hva_barrio_lista_div").removeClass('d-block').addClass('d-none');
        $("#hva_barrio_div").removeClass('d-block').addClass('d-none');

        $('#hva_barrio_lista').selectpicker('val', '');
        $('#hva_barrio_lista').selectpicker('destroy');
        $('#hva_barrio_lista').selectpicker();
        document.getElementById('hva_barrio_lista').disabled=true;
        document.getElementById('hva_barrio').disabled=true;

        var hva_ciudad = document.getElementById("hva_ciudad").value;
        var hva_localidad = document.getElementById("hva_localidad").value;

        if (hva_ciudad!="" && (hva_ciudad=="11001" || hva_ciudad=="05001") && hva_localidad!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>seleccion-vinculacion/formulario-barrio/'+hva_ciudad+'/'+hva_localidad+'/'+id_oferta,
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
                    $("#hva_barrio_lista").html(resp.resultado);
                    $("#hva_barrio_lista_div").removeClass('d-none').addClass('d-block');
                    document.getElementById('hva_barrio_lista').disabled=false;
                    $('#hva_barrio_lista').selectpicker('destroy');
                    $('#hva_barrio_lista').selectpicker();
                },
                error: function(data){
                    alert("Problemas al tratar de obtener los datos, por favor verifique e intente nuevamente");
                }
            });
        } else {
            $("#hva_barrio_div").removeClass('d-none').addClass('d-block');
            document.getElementById('hva_barrio').disabled=false;
        }
    }

    function calcularEdad() {
        // Obtener la fecha de nacimiento desde el input date
        var fechaNacimiento = new Date(document.getElementById("hva_nacimiento_fecha").value);
        // Obtener la fecha actual
        var fechaActual = new Date();

        // Calcular la diferencia en milisegundos entre las dos fechas
        var diferencia = fechaActual - fechaNacimiento;

        // Calcular la edad en años
        var edad = Math.floor(diferencia / (1000 * 60 * 60 * 24 * 365.25));
        if (edad!='NaN') {
            // Mostrar la edad en el input number
            document.getElementById("hva_edad").value = edad;
        } else {
            document.getElementById("hva_edad").value = '';
        }
    }
    calcularEdad();
</script>
<script>
    validateControlById('hva_auxiliar_5');
    validateControlById('hva_ciudad');
    validateControlById('hva_direccion');
    validateControlById('hva_localidad');
    validateControlById('hva_barrio');
    validateControlById('hva_barrio_lista');
    validateControlById('hva_celular');
    validateControlById('hva_celular_2');
    validateControlById('hva_nacimiento_lugar');
    validateControlById('hva_nacimiento_fecha');
    validateControlById('hva_edad');
    validateControlById('hva_estado_civil');
    validateControlById('hva_genero');
    validateControlById('hvaem_grupo_sanguineo');
    validateControlById('hvaem_rh');
    validateControlById('hva_operador_internet');
    validateControlById('hvaem_nombres_apellidos');
    validateControlById('hvaem_parentesco');
    validateControlById('hvaem_telefono');
</script>
