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
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-experiencia<?php echo $data['path_add']; ?>" class="btn btn-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Experiencia Laboral<span id="status_laboral"></span></a>
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
                                            <h3>Experiencia Laboral</h3>
                                            <!-- CONTENIDO FORMULARIO -->
                                            <?php if($data['valida_token']): ?>
                                                <?php if($data['valida_oferta']): ?>
                                                <p class="appoinment-content-text mt-0 mb-2">Por favor indique si cuenta con experiencia laboral o es su primer empleo.</p>
                                                <div class="col-md-12 mb-2">
                                                    <?php if($data['primer_empleo']=='No' OR $data['primer_empleo']==''): ?>
                                                        <button type="submit" name="form_empleo_si" class="btn btn-success login-btn">Si, tengo experiencia laboral</button>
                                                    <?php endif; ?>
                                                    <?php if($data['primer_empleo']=='Si' OR $data['primer_empleo']==''): ?>
                                                        <button type="submit" name="form_empleo_no" class="btn btn-danger login-btn">No, es mi primer empleo</button>
                                                    <?php endif; ?>
                                                </div>
                                                    <?php if($data['primer_empleo']=='Si'): ?>
                                                        <hr>
                                                        <p class="appoinment-content-text mt-0 mb-2">Incluya la información de las tres últimas experiencias laborales, iniciando de la más actual a la más antigua.</p>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="hvaex_empresa" class="form-label my-0 font-size-12">Nombre de la empresa</label>
                                                            <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaex_empresa" id="hvaex_empresa" value="" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="hvaex_cargo" class="form-label my-0 font-size-12">Cargo</label>
                                                            <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaex_cargo" id="hvaex_cargo" value="" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-2 mb-3">
                                                            <label for="hvaex_fecha_inicio" class="form-label my-0 font-size-12">Fecha inicio</label>
                                                            <input type="date" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaex_fecha_inicio" id="hvaex_fecha_inicio" value="" max="<?php echo date('Y-m-d'); ?>" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-2 mb-3">
                                                            <label for="hvaex_fecha_retiro" class="form-label my-0 font-size-12">Fecha retiro</label>
                                                            <input type="date" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaex_fecha_retiro" id="hvaex_fecha_retiro" value="" max="<?php echo date('Y-m-d'); ?>" autocomplete="off">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="Si" name="hvaex_fecha_retiro_actual" id="hvaex_fecha_retiro_actual" onclick="actualmente();">
                                                                <label class="form-check-label font-size-12 fw-bold" for="hvaex_fecha_retiro_actual">Actualmente</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <div class="form-group">
                                                                <label for="hvaex_ciudad" class="form-label my-0 font-size-12">Ciudad</label>
                                                                <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvaex_ciudad" id="hvaex_ciudad" data-live-search="true" data-container="body" title="Seleccione">
                                                                    <?php foreach ($data['resultado_registros_ciudad'] as $registro): ?>
                                                                        <option value="<?php echo $registro->ciu_codigo; ?>" class="font-size-11"><?php echo $registro->ciu_municipio.', '.$registro->ciu_departamento; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label for="hvaex_jefe_nombre" class="form-label my-0 font-size-12">Nombre jefe inmediato</label>
                                                            <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaex_jefe_nombre" id="hvaex_jefe_nombre" value="" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-2 mb-3">
                                                            <label for="hvaex_jefe_cargo" class="form-label my-0 font-size-12">Cargo</label>
                                                            <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaex_jefe_cargo" id="hvaex_jefe_cargo" value="" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-2 mb-3">
                                                            <label for="hvaex_telefonos" class="form-label my-0 font-size-12">Teléfono de referencia</label>
                                                            <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaex_telefonos" id="hvaex_telefonos" value="" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-2 mb-3">
                                                            <label for="hvaex_motivo_retiro" class="form-label my-0 font-size-12">Motivo de retiro</label>
                                                            <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvaex_motivo_retiro" id="hvaex_motivo_retiro" data-container="body" title="Seleccione">
                                                                <option value="Renuncia voluntaria">Renuncia voluntaria</option>
                                                                <option value="Con justa causa">Con justa causa</option>
                                                                <option value="Termino de contrato">Termino de contrato</option>
                                                                <option value="Período de prueba">Período de prueba</option>
                                                                <option value="No aplica">No aplica</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 mb-2">
                                                            <a name="form_guardar" class="btn btn-warning login-btn" onclick="experiencia_add();">Agregar experiencia laboral</a>
                                                        </div>
                                                        <hr>
                                                        <p class="appoinment-content-text mt-0 mb-2">Experiencia Laboral Registrada</p>
                                                        <div class="col-md-12 mb-2" id="lista_registros"></div>
                                                    <?php endif; ?>
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
<script type="text/javascript">
    function actualmente(){
        var hvaex_fecha_retiro_actual = document.getElementById("hvaex_fecha_retiro_actual").checked;
        document.getElementById("hvaex_fecha_retiro").disabled=false;
        document.getElementById("hvaex_motivo_retiro").disabled=false;
        if (hvaex_fecha_retiro_actual) {
            document.getElementById("hvaex_fecha_retiro").disabled=true;
            document.getElementById("hvaex_motivo_retiro").disabled=true;
            document.getElementById("hvaex_fecha_retiro").value='';
            document.getElementById("hvaex_motivo_retiro").value='';
        }
    }
    
    function experiencia_add() {
        var id_aspirante = '<?php echo $data['id_aspirante']; ?>';
        var token = '<?php echo $data['id_token']; ?>';
        var hvaex_empresa = document.getElementById("hvaex_empresa").value;
        var hvaex_cargo = document.getElementById("hvaex_cargo").value;
        var hvaex_fecha_inicio = document.getElementById("hvaex_fecha_inicio").value;
        var hvaex_fecha_retiro = document.getElementById("hvaex_fecha_retiro").value;
        var hvaex_ciudad = document.getElementById("hvaex_ciudad").value;
        var hvaex_jefe_nombre = document.getElementById("hvaex_jefe_nombre").value;
        var hvaex_jefe_cargo = document.getElementById("hvaex_jefe_cargo").value;
        var hvaex_telefonos = document.getElementById("hvaex_telefonos").value;
        var hvaex_motivo_retiro = document.getElementById("hvaex_motivo_retiro").value;
        var hvaex_fecha_retiro_actual = document.getElementById("hvaex_fecha_retiro_actual").checked;

        if (hvaex_fecha_retiro_actual) {
            hvaex_fecha_retiro='Actualmente';
            hvaex_motivo_retiro='No aplica';
        }

        var formData = new FormData();
        formData.append("id_aspirante", id_aspirante);
        formData.append("token", token);
        formData.append("hvaex_empresa", hvaex_empresa);
        formData.append("hvaex_cargo", hvaex_cargo);
        formData.append("hvaex_fecha_inicio", hvaex_fecha_inicio);
        formData.append("hvaex_fecha_retiro", hvaex_fecha_retiro);
        formData.append("hvaex_ciudad", hvaex_ciudad);
        formData.append("hvaex_jefe_nombre", hvaex_jefe_nombre);
        formData.append("hvaex_jefe_cargo", hvaex_jefe_cargo);
        formData.append("hvaex_telefonos", hvaex_telefonos);
        formData.append("hvaex_motivo_retiro", hvaex_motivo_retiro);

        if (token!="" && id_aspirante!="" && hvaex_empresa!="" && hvaex_cargo!="" && hvaex_fecha_inicio!="" && hvaex_fecha_retiro!="" && hvaex_ciudad!="" && hvaex_jefe_nombre!="" && hvaex_jefe_cargo!="" && hvaex_telefonos!="" && hvaex_motivo_retiro!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>seleccion-vinculacion/formulario-experiencia-registro',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    document.getElementById("hvaex_empresa").disabled=true;
                    document.getElementById("hvaex_cargo").disabled=true;
                    document.getElementById("hvaex_fecha_inicio").disabled=true;
                    document.getElementById("hvaex_fecha_retiro").disabled=true;
                    document.getElementById("hvaex_fecha_retiro").disabled=true;
                    document.getElementById("hvaex_ciudad").disabled=true;
                    document.getElementById("hvaex_jefe_nombre").disabled=true;
                    document.getElementById("hvaex_jefe_cargo").disabled=true;
                    document.getElementById("hvaex_telefonos").disabled=true;
                    document.getElementById("hvaex_motivo_retiro").disabled=true;
                    document.getElementById("hvaex_fecha_retiro_actual").disabled=true;
                },
                complete:function(data){
                    document.getElementById("hvaex_empresa").disabled=false;
                    document.getElementById("hvaex_cargo").disabled=false;
                    document.getElementById("hvaex_fecha_inicio").disabled=false;
                    document.getElementById("hvaex_fecha_retiro").disabled=false;
                    document.getElementById("hvaex_ciudad").disabled=false;
                    document.getElementById("hvaex_jefe_nombre").disabled=false;
                    document.getElementById("hvaex_jefe_cargo").disabled=false;
                    document.getElementById("hvaex_telefonos").disabled=false;
                    document.getElementById("hvaex_motivo_retiro").disabled=false;
                    document.getElementById("hvaex_fecha_retiro_actual").disabled=false;
                    
                },
                success: function(data){
                    var resp = $.parseJSON(data);

                    if (resp.resultado_valor) {
                        document.getElementById("hvaex_empresa").value='';
                        document.getElementById("hvaex_cargo").value='';
                        document.getElementById("hvaex_fecha_inicio").value='';
                        document.getElementById("hvaex_fecha_retiro").value='';
                        document.getElementById("hvaex_fecha_retiro_actual").checked=false;
                        $('#hvaex_ciudad').selectpicker('val', '');
                        document.getElementById("hvaex_jefe_nombre").value='';
                        document.getElementById("hvaex_jefe_cargo").value='';
                        document.getElementById("hvaex_telefonos").value='';
                        $('#hvaex_motivo_retiro').selectpicker('val', '');
                    } else {
                        
                    }
                    experiencia_list();
                },
                error: function(data){
                    alert("Problemas al tratar de crear el registro, por favor verifique e intente nuevamente");
                }
            });
        } else {
            alert("¡Todos los campos son obligatorios, por favor verifique e intente nuevamente!");
        }
    }

    function experiencia_list() {
        var id_aspirante = '<?php echo $data['id_aspirante']; ?>';
        var token = '<?php echo $data['id_token']; ?>';

        var formData = new FormData();
        formData.append("id_aspirante", id_aspirante);
        formData.append("token", token);

        if (token!="" && id_aspirante!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>seleccion-vinculacion/formulario-experiencia-listar',
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

                    if (resp.resultado_valor) {
                        $('#lista_registros').html(resp.resultado_lista);
                        progreso();
                    } else {
                        $('#lista_registros').html('<p class="alert alert-warning p-1 font-size-11">¡No se encontró experiencia laboral registrada!</p>');
                    }
                },
                error: function(data){
                    alert("Problemas al tratar de crear el registro, por favor verifique e intente nuevamente");
                }
            });
        } else {
            alert("¡Todos los campos son obligatorios, por favor verifique e intente nuevamente!");
        }
    }

    function experiencia_del(id_registro) {
        var id_aspirante = '<?php echo $data['id_aspirante']; ?>';
        var token = '<?php echo $data['id_token']; ?>';

        var formData = new FormData();
        formData.append("id_aspirante", id_aspirante);
        formData.append("token", token);
        formData.append("id_registro", id_registro);

        if (token!="" && id_aspirante!="" && id_registro!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>seleccion-vinculacion/formulario-experiencia-eliminar',
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

                    if (resp.resultado_valor) {
                        $('#lista_registros').html(resp.resultado_lista);
                    } else {
                        $('#lista_registros').html('');
                    }
                    experiencia_list();
                },
                error: function(data){
                    alert("Problemas al tratar de crear el registro, por favor verifique e intente nuevamente");
                }
            });
        } else {
            alert("¡Todos los campos son obligatorios, por favor verifique e intente nuevamente!");
        }
    }

    jQuery(document).ready(function(){
        jQuery("#hvaex_empresa").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvaex_cargo").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvaex_jefe_nombre").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvaex_jefe_cargo").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvaex_telefonos").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvaex_motivo_retiro").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    experiencia_list();
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

                    if (resp.secciones.laboral==1) {
                        $('#btn_continuar').html('<a href="<?php echo URL; ?>seleccion-vinculacion/formulario-etica<?php echo $data['path_add']; ?>" class="btn btn-dark login-btn">Continuar</a>');
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