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
    <form name="form_guardar" action="" method="post" class="comment-form" enctype="multipart/form-data">
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
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-personal<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Información Personal<span id="status_personal"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-familiar<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Información Familiar<span id="status_familiar"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-estudio-culminado<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Estudios Culminados<span id="status_estudio_culminado"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-estudio-curso<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Estudios en Curso<span id="status_estudio_curso"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-experiencia<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Experiencia Laboral<span id="status_laboral"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-etica<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Código de ética, Anticorrupción y Buen Gobierno<span id="status_etica"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-iq<?php echo $data['path_add']; ?>" class="btn btn-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Información IQ<span id="status_informacion"></span></a>
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
                                            <h3>Información IQ</h3>
                                            <!-- CONTENIDO FORMULARIO -->
                                            <?php if($data['valida_token']): ?>
                                                <?php if($data['valida_oferta']): ?>
                                                <p class="appoinment-content-text mt-0 mb-2"></p>
                                                
                                                <div class="col-md-12 mb-3">
                                                    <label for="hvai_medio_conocer_oferta" class="form-label my-0 font-size-12">¿Por qué medio conociste la oferta laboral?</label>
                                                    <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvai_medio_conocer_oferta" id="hvai_medio_conocer_oferta" data-container="body" title="Seleccione" required>
                                                        <option value=""></option>
                                                        <option value="LinkedIn" <?php echo ($data['resultado_registros'][0]->hvai_medio_conocer_oferta=='LinkedIn') ? 'selected' : ''; ?>>LinkedIn</option>
                                                        <option value="Facebook" <?php echo ($data['resultado_registros'][0]->hvai_medio_conocer_oferta=='Facebook') ? 'selected' : ''; ?>>Facebook</option>
                                                        <option value="Instagram" <?php echo ($data['resultado_registros'][0]->hvai_medio_conocer_oferta=='Instagram') ? 'selected' : ''; ?>>Instagram</option>
                                                        <option value="YouTube" <?php echo ($data['resultado_registros'][0]->hvai_medio_conocer_oferta=='YouTube') ? 'selected' : ''; ?>>YouTube</option>
                                                        <option value="Tik Tok" <?php echo ($data['resultado_registros'][0]->hvai_medio_conocer_oferta=='Tik Tok') ? 'selected' : ''; ?>>Tik Tok</option>
                                                        <option value="Elempleo.com" <?php echo ($data['resultado_registros'][0]->hvai_medio_conocer_oferta=='Elempleo.com') ? 'selected' : ''; ?>>Elempleo.com</option>
                                                        <option value="Recomendación personal" <?php echo ($data['resultado_registros'][0]->hvai_medio_conocer_oferta=='Recomendación personal') ? 'selected' : ''; ?>>Recomendación personal</option>
                                                    </select>
                                                </div>
                                                <div class="appoinment-title mt-2">
                                                    <hr>
                                                    <h4>Ex colaborador IQ</h4>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="hvai_excolaborador" class="form-label my-0 font-size-12">¿Ha trabajado anteriormente en IQ?</label>
                                                    <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvai_excolaborador" id="hvai_excolaborador" data-container="body" title="Seleccione" required onchange="validar_excolaborador();">
                                                        <option value=""></option>
                                                        <option value="Si" <?php echo ($data['resultado_registros'][0]->hvai_excolaborador=='Si') ? 'selected' : ''; ?>>Si</option>
                                                        <option value="No" <?php echo ($data['resultado_registros'][0]->hvai_excolaborador=='No') ? 'selected' : ''; ?>>No</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3 d-none" id="hvai_excolaborador_motivo_div">
                                                    <label for="hvai_excolaborador_motivo" class="form-label my-0 font-size-12">Motivo del retiro</label>
                                                    <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvai_excolaborador_motivo" id="hvai_excolaborador_motivo" data-container="body" title="Seleccione" required disabled>
                                                        <option value=""></option>
                                                        <option value="Renuncia" <?php echo ($data['resultado_registros'][0]->hvai_excolaborador_motivo=='Renuncia') ? 'selected' : ''; ?>>Renuncia</option>
                                                        <option value="Con justa causa" <?php echo ($data['resultado_registros'][0]->hvai_excolaborador_motivo=='Con justa causa') ? 'selected' : ''; ?>>Con justa causa</option>
                                                        <option value="Sin justa causa" <?php echo ($data['resultado_registros'][0]->hvai_excolaborador_motivo=='Sin justa causa') ? 'selected' : ''; ?>>Sin justa causa</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3 d-none" id="hvai_excolaborador_fecha_div">
                                                    <label for="hvai_excolaborador_fecha" class="form-label my-0 font-size-12">Fecha de retiro</label>
                                                    <input type="date" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvai_excolaborador_fecha" id="hvai_excolaborador_fecha" value="<?php echo $data['resultado_registros'][0]->hvai_excolaborador_fecha; ?>" required disabled>
                                                </div>
                                                <div class="appoinment-title mt-2">
                                                    <hr>
                                                    <h4>Procesos de Selección Previos con IQ</h4>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="hvai_seleccion_previo" class="form-label my-0 font-size-12">¿Ha presentado procesos de selección previamente en IQ?</label>
                                                    <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvai_seleccion_previo" id="hvai_seleccion_previo" data-container="body" title="Seleccione" required onchange="validar_seleccion();">
                                                        <option value=""></option>
                                                        <option value="Si" <?php echo ($data['resultado_registros'][0]->hvai_seleccion_previo=='Si') ? 'selected' : ''; ?>>Si</option>
                                                        <option value="No" <?php echo ($data['resultado_registros'][0]->hvai_seleccion_previo=='No') ? 'selected' : ''; ?>>No</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3 d-none" id="hvai_seleccion_previo_cargo_div">
                                                    <label for="hvai_seleccion_previo_cargo" class="form-label my-0 font-size-12">Cargo</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvai_seleccion_previo_cargo" id="hvai_seleccion_previo_cargo" value="<?php echo $data['resultado_registros'][0]->hvai_seleccion_previo_cargo; ?>" required disabled autocomplete="off">
                                                </div>
                                                <div class="col-md-6 mb-3 d-none" id="hvai_seleccion_previo_fecha_div">
                                                    <label for="hvai_seleccion_previo_fecha" class="form-label my-0 font-size-12">Fecha</label>
                                                    <input type="date" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvai_seleccion_previo_fecha" id="hvai_seleccion_previo_fecha" value="<?php echo $data['resultado_registros'][0]->hvai_seleccion_previo_fecha; ?>" required disabled autocomplete="off">
                                                </div>
                                                <div class="appoinment-title mt-2">
                                                    <hr>
                                                    <h4>Trabajos Simultáneos</h4>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="hvai_trabajo" class="form-label my-0 font-size-12">¿Declara tener otro trabajo u ocupación simultánea?</label>
                                                    <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvai_trabajo" id="hvai_trabajo" data-container="body" title="Seleccione" required onchange="validar_trabajo();">
                                                        <option value=""></option>
                                                        <option value="Si" <?php echo ($data['resultado_registros'][0]->hvai_trabajo=='Si') ? 'selected' : ''; ?>>Si</option>
                                                        <option value="No" <?php echo ($data['resultado_registros'][0]->hvai_trabajo=='No') ? 'selected' : ''; ?>>No</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12 mb-3 d-none" id="hvai_trabajo_tipo_div">
                                                    <label for="hvai_trabajo_tipo" class="form-label my-0 font-size-12">Tipo de vinculación</label>
                                                    <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvai_trabajo_tipo" id="hvai_trabajo_tipo" data-container="body" title="Seleccione" required disabled>
                                                        <option value=""></option>
                                                        <option value="Dependiente" <?php echo ($data['resultado_registros'][0]->hvai_trabajo_tipo=='Dependiente') ? 'selected' : ''; ?>>Dependiente</option>
                                                        <option value="Independiente" <?php echo ($data['resultado_registros'][0]->hvai_trabajo_tipo=='Independiente') ? 'selected' : ''; ?>>Independiente</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3 d-none" id="hvai_trabajo_empresa_div">
                                                    <label for="hvai_trabajo_empresa" class="form-label my-0 font-size-12">Nombre de la empresa</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvai_trabajo_empresa" id="hvai_trabajo_empresa" value="<?php echo $data['resultado_registros'][0]->hvai_trabajo_empresa; ?>" required disabled autocomplete="off">
                                                </div>
                                                <div class="col-md-6 mb-3 d-none" id="hvai_trabajo_cargo_div">
                                                    <label for="hvai_trabajo_cargo" class="form-label my-0 font-size-12">Cargo</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvai_trabajo_cargo" id="hvai_trabajo_cargo" value="<?php echo $data['resultado_registros'][0]->hvai_trabajo_cargo; ?>" required disabled autocomplete="off">
                                                </div>
                                                <div class="col-md-6 mb-3 d-none" id="hvai_ocupacion_div">
                                                    <label for="hvai_ocupacion" class="form-label my-0 font-size-12">Ocupación o trabajo desempeñado</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvai_ocupacion" id="hvai_ocupacion" value="<?php echo $data['resultado_registros'][0]->hvai_ocupacion; ?>" required disabled autocomplete="off">
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="hvai_conflicto_renuncia" class="form-label my-0 font-size-12">¿Si su ocupación actual genera conflicto de interés, estaría dispuesto a renunciar a su trabajo actual?</label>
                                                    <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvai_conflicto_renuncia" id="hvai_conflicto_renuncia" data-container="body" title="Seleccione" required>
                                                        <option value=""></option>
                                                        <option value="Si" <?php echo ($data['resultado_registros'][0]->hvai_conflicto_renuncia=='Si') ? 'selected' : ''; ?>>Si</option>
                                                        <option value="No" <?php echo ($data['resultado_registros'][0]->hvai_conflicto_renuncia=='No') ? 'selected' : ''; ?>>No</option>
                                                    </select>
                                                </div>
                                                <p class="appoinment-content-text mt-0 mb-2">De acuerdo con lo establecido en el Código de ética, anticorrupción y buen gobierno P6-A1, no se admite un segundo empleo o la prestación de sus servicios bajo cualquier modalidad cuando la otra parte ejecute actividades semejantes al objeto social de la Compañía y/o sea competidor de la Compañía. Un segundo empleo o acuerdo de servicios con un cliente o proveedor de la Compañía tampoco será permitido. si usted brinda información no veraz representa una falta grave y asume la responsabilidad de cualquier falsedad frente a la misma.</p>
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
                                        <!-- BOTONES FORMULARIO -->
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
<?php require_once INCLUDES.'inc_footer_index.php'; ?>
<script src="<?php echo JS; ?>valid-input.js"></script>
<script type="text/javascript">
    function validar_excolaborador(){
        var hvai_excolaborador = document.getElementById("hvai_excolaborador").value;
        var hvai_excolaborador_motivo = document.getElementById('hvai_excolaborador_motivo').disabled=true;
        var hvai_excolaborador_fecha = document.getElementById('hvai_excolaborador_fecha').disabled=true;
        $("#hvai_excolaborador_motivo_div").removeClass('d-block').addClass('d-none');
        $("#hvai_excolaborador_fecha_div").removeClass('d-block').addClass('d-none'); 

        if(hvai_excolaborador=='Si') {
            var hvai_excolaborador_motivo = document.getElementById('hvai_excolaborador_motivo').disabled=false;
            var hvai_excolaborador_fecha = document.getElementById('hvai_excolaborador_fecha').disabled=false;
            $("#hvai_excolaborador_motivo_div").removeClass('d-none').addClass('d-block');
            $("#hvai_excolaborador_fecha_div").removeClass('d-none').addClass('d-block');
            $('#hvai_excolaborador_motivo').selectpicker('destroy');
            $('#hvai_excolaborador_motivo').selectpicker();
        }
    }

    function validar_seleccion(){
        var hvai_seleccion_previo = document.getElementById("hvai_seleccion_previo").value;
        var hvai_seleccion_previo_cargo = document.getElementById('hvai_seleccion_previo_cargo').disabled=true;
        var hvai_seleccion_previo_fecha = document.getElementById('hvai_seleccion_previo_fecha').disabled=true;
        $("#hvai_seleccion_previo_cargo_div").removeClass('d-block').addClass('d-none');
        $("#hvai_seleccion_previo_fecha_div").removeClass('d-block').addClass('d-none');

        if(hvai_seleccion_previo=='Si') {
            var hvai_seleccion_previo_cargo = document.getElementById('hvai_seleccion_previo_cargo').disabled=false;
            var hvai_seleccion_previo_fecha = document.getElementById('hvai_seleccion_previo_fecha').disabled=false;
            $("#hvai_seleccion_previo_cargo_div").removeClass('d-none').addClass('d-block');
            $("#hvai_seleccion_previo_fecha_div").removeClass('d-none').addClass('d-block');
        }
    }

    function validar_trabajo(){
        var hvai_trabajo = document.getElementById("hvai_trabajo").value;
        var hvai_trabajo_tipo = document.getElementById('hvai_trabajo_tipo').disabled=true;
        var hvai_trabajo_empresa = document.getElementById('hvai_trabajo_empresa').disabled=true;
        var hvai_trabajo_cargo = document.getElementById('hvai_trabajo_cargo').disabled=true;
        var hvai_ocupacion = document.getElementById('hvai_ocupacion').disabled=true;
        $("#hvai_trabajo_tipo_div").removeClass('d-block').addClass('d-none');
        $("#hvai_trabajo_empresa_div").removeClass('d-block').addClass('d-none');
        $("#hvai_trabajo_cargo_div").removeClass('d-block').addClass('d-none');
        $("#hvai_ocupacion_div").removeClass('d-block').addClass('d-none');

        if(hvai_trabajo=='Si') {
            var hvai_trabajo_tipo = document.getElementById('hvai_trabajo_tipo').disabled=false;
            var hvai_trabajo_empresa = document.getElementById('hvai_trabajo_empresa').disabled=false;
            var hvai_trabajo_cargo = document.getElementById('hvai_trabajo_cargo').disabled=false;
            var hvai_ocupacion = document.getElementById('hvai_ocupacion').disabled=false;
            $("#hvai_trabajo_tipo_div").removeClass('d-none').addClass('d-block');
            $("#hvai_trabajo_empresa_div").removeClass('d-none').addClass('d-block');
            $("#hvai_trabajo_cargo_div").removeClass('d-none').addClass('d-block');
            $("#hvai_ocupacion_div").removeClass('d-none').addClass('d-block');
            $('#hvai_trabajo_tipo').selectpicker('destroy');
            $('#hvai_trabajo_tipo').selectpicker();
        }
    }

    validar_excolaborador();
    validar_seleccion();
    validar_trabajo();

    validateControlById('hvai_medio_conocer_oferta');
    validateControlById('hvai_excolaborador');
    validateControlById('hvai_excolaborador_motivo');
    validateControlById('hvai_excolaborador_fecha');
    validateControlById('hvai_seleccion_previo');
    validateControlById('hvai_seleccion_previo_cargo');
    validateControlById('hvai_seleccion_previo_fecha');
    validateControlById('hvai_trabajo');
    validateControlById('hvai_trabajo_tipo');
    validateControlById('hvai_trabajo_empresa');
    validateControlById('hvai_trabajo_cargo');
    validateControlById('hvai_ocupacion');
    validateControlById('hvai_conflicto_renuncia');
</script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#hvai_seleccion_previo_cargo").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvai_trabajo_empresa").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvai_trabajo_cargo").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvai_ocupacion").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
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

                    if (resp.secciones.informacion==1) {
                        $('#btn_continuar').html('<a href="<?php echo URL; ?>seleccion-vinculacion/formulario-financiera<?php echo $data['path_add']; ?>" class="btn btn-dark login-btn">Continuar</a>');
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