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
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-estudio-curso<?php echo $data['path_add']; ?>" class="btn btn-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Estudios en Curso<span id="status_estudio_curso"></span></a>
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
                                            <h3>Estudios en Curso</h3>
                                            <!-- CONTENIDO FORMULARIO  --> 
                                            <?php if($data['valida_token']): ?>
                                                <?php if($data['valida_oferta']): ?>
                                                <div class="col-md-12 my-2">
                                                    <p class="alert alert-warning p-1">¡Por favor indique si actualmente tiene estudios en curso!</p>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <?php if($data['estudio_curso']=='No' OR $data['estudio_curso']==''): ?>
                                                        <button type="submit" name="form_estudio_si" class="btn btn-success login-btn">Si, tengo estudios en curso</button>
                                                    <?php endif; ?>
                                                    <?php if($data['estudio_curso']=='Si' OR $data['estudio_curso']==''): ?>
                                                        <button type="submit" name="form_estudio_no" class="btn btn-danger login-btn">No, no tengo estudios en curso</button>
                                                    <?php endif; ?>
                                                </div>
                                                    <?php if($data['estudio_curso']=='Si'): ?>
                                                        <hr>
                                                        <div class="col-md-2 mb-3">
                                                            <label for="hvaec_nivel" class="form-label my-0 font-size-12">Nivel</label>
                                                            <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvaec_nivel" id="hvaec_nivel" data-container="body" title="Seleccione">
                                                                <option value="Diplomado">Diplomado</option>
                                                                <option value="Certificación">Certificación</option>
                                                                <option value="Técnico">Técnico</option>
                                                                <option value="Tecnólogo">Tecnólogo</option>
                                                                <option value="Pregrado">Pregrado</option>
                                                                <option value="Especialización">Especialización</option>
                                                                <option value="Maestría">Maestría</option>
                                                                <option value="Doctorado">Doctorado</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-5 mb-3">
                                                            <label for="hvaec_establecimiento" class="form-label my-0 font-size-12">Entidad educativa</label>
                                                            <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaec_establecimiento" id="hvaec_establecimiento" value="" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-5 mb-3">
                                                            <label for="hvaec_titulo" class="form-label my-0 font-size-12">Título a obtener</label>
                                                            <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaec_titulo" id="hvaec_titulo" value="" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <div class="form-group">
                                                                <label for="hvaec_ciudad" class="form-label my-0 font-size-12">Ciudad</label>
                                                                <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvaec_ciudad" id="hvaec_ciudad" data-live-search="true" data-container="body" title="Seleccione">
                                                                    <?php foreach ($data['resultado_registros_ciudad'] as $registro): ?>
                                                                        <option value="<?php echo $registro->ciu_codigo; ?>" class="font-size-11"><?php echo $registro->ciu_municipio.', '.$registro->ciu_departamento; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 mb-3">
                                                            <label for="hvaec_horario" class="form-label my-0 font-size-12">Horario</label>
                                                            <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvaec_horario" id="hvaec_horario" data-container="body" title="Seleccione">
                                                                <option value="Diurno">Diurno</option>
                                                                <option value="Nocturno">Nocturno</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2 mb-3">
                                                            <label for="hvaec_modalidad" class="form-label my-0 font-size-12">Modalidad</label>
                                                            <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvaec_modalidad" id="hvaec_modalidad" data-container="body" title="Seleccione">
                                                                <option value="Presencial">Presencial</option>
                                                                <option value="Virtual">Virtual</option>
                                                                <option value="Híbrida">Híbrida</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label for="hvaec_fecha_terminacion" class="form-label my-0 font-size-12">Fecha de terminación proyectada</label>
                                                            <input type="date" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaec_fecha_terminacion" id="hvaec_fecha_terminacion" value="" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-12 mb-2">
                                                            <a name="form_guardar" class="btn btn-warning login-btn" onclick="estudio_add();">Agregar estudio</a>
                                                        </div>
                                                        <hr>
                                                        <p class="appoinment-content-text mt-0 mb-2">Estudios en Curso Registrados</p>
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
    function estudio_add() {
        var id_aspirante = '<?php echo $data['id_aspirante']; ?>';
        var token = '<?php echo $data['id_token']; ?>';
        var hvaec_nivel = document.getElementById("hvaec_nivel").value;
        var hvaec_establecimiento = document.getElementById("hvaec_establecimiento").value;
        var hvaec_titulo = document.getElementById("hvaec_titulo").value;
        var hvaec_ciudad = document.getElementById("hvaec_ciudad").value;
        var hvaec_horario = document.getElementById("hvaec_horario").value;
        var hvaec_modalidad = document.getElementById("hvaec_modalidad").value;
        var hvaec_fecha_terminacion = document.getElementById("hvaec_fecha_terminacion").value;

        var formData = new FormData();
        formData.append("id_aspirante", id_aspirante);
        formData.append("token", token);
        formData.append("hvaec_nivel", hvaec_nivel);
        formData.append("hvaec_establecimiento", hvaec_establecimiento);
        formData.append("hvaec_titulo", hvaec_titulo);
        formData.append("hvaec_ciudad", hvaec_ciudad);
        formData.append("hvaec_horario", hvaec_horario);
        formData.append("hvaec_modalidad", hvaec_modalidad);
        formData.append("hvaec_fecha_terminacion", hvaec_fecha_terminacion);

        if (token!="" && id_aspirante!="" && hvaec_nivel!="" && hvaec_establecimiento!="" && hvaec_titulo!="" && hvaec_ciudad!="" && hvaec_horario!="" && hvaec_modalidad!="" && hvaec_fecha_terminacion!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>seleccion-vinculacion/formulario-estudio-curso-registro',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    document.getElementById("hvaec_nivel").disabled=true;
                    document.getElementById("hvaec_establecimiento").disabled=true;
                    document.getElementById("hvaec_titulo").disabled=true;
                    document.getElementById("hvaec_ciudad").disabled=true;
                    document.getElementById("hvaec_horario").disabled=true;
                    document.getElementById("hvaec_modalidad").disabled=true;
                    document.getElementById("hvaec_fecha_terminacion").disabled=true;
                },
                complete:function(data){
                    document.getElementById("hvaec_nivel").disabled=false;
                    document.getElementById("hvaec_establecimiento").disabled=false;
                    document.getElementById("hvaec_titulo").disabled=false;
                    document.getElementById("hvaec_ciudad").disabled=false;
                    document.getElementById("hvaec_horario").disabled=false;
                    document.getElementById("hvaec_modalidad").disabled=false;
                    document.getElementById("hvaec_fecha_terminacion").disabled=false;
                    
                },
                success: function(data){
                    var resp = $.parseJSON(data);

                    if (resp.resultado_valor) {
                        $('#hvaec_nivel').selectpicker('val', '');
                        document.getElementById("hvaec_establecimiento").value='';
                        document.getElementById("hvaec_titulo").value='';
                        $('#hvaec_ciudad').selectpicker('val', '');
                        $('#hvaec_horario').selectpicker('val', '');
                        $('#hvaec_modalidad').selectpicker('val', '');
                        document.getElementById("hvaec_fecha_terminacion").value='';
                    } else {
                        
                    }
                    estudio_list();
                },
                error: function(data){
                    alert("Problemas al tratar de crear el registro, por favor verifique e intente nuevamente");
                }
            });
        } else {
            alert("¡Todos los campos son obligatorios, por favor verifique e intente nuevamente!");
        }
    }

    function estudio_list() {
        var id_aspirante = '<?php echo $data['id_aspirante']; ?>';
        var token = '<?php echo $data['id_token']; ?>';

        var formData = new FormData();
        formData.append("id_aspirante", id_aspirante);
        formData.append("token", token);

        if (token!="" && id_aspirante!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>seleccion-vinculacion/formulario-estudio-curso-listar',
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
                        $('#lista_registros').html('<p class="alert alert-warning p-1 font-size-11">¡No se encontraron estudios en curso registrados!</p>');
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

    function estudio_del(id_registro) {
        var id_aspirante = '<?php echo $data['id_aspirante']; ?>';
        var token = '<?php echo $data['id_token']; ?>';

        var formData = new FormData();
        formData.append("id_aspirante", id_aspirante);
        formData.append("token", token);
        formData.append("id_registro", id_registro);

        if (token!="" && id_aspirante!="" && id_registro!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>seleccion-vinculacion/formulario-estudio-curso-eliminar',
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
                    estudio_list();
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
        jQuery("#hvaec_establecimiento").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvaec_titulo").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    estudio_list();
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

                    if (resp.secciones.estudio_curso==1) {
                        $('#btn_continuar').html('<a href="<?php echo URL; ?>seleccion-vinculacion/formulario-experiencia<?php echo $data['path_add']; ?>" class="btn btn-dark login-btn">Continuar</a>');
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