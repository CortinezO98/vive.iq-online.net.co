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
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-etica<?php echo $data['path_add']; ?>" class="btn btn-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Código de ética, Anticorrupción y Buen Gobierno<span id="status_etica"></span></a>
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
                                            <h3>Código de ética, Anticorrupción y Buen Gobierno P6-A1</h3>
                                            <!-- CONTENIDO FORMULARIO -->
                                            <?php if($data['valida_token']): ?>
                                                <?php if($data['valida_oferta']): ?>
                                                    <p class="appoinment-content-text mt-0 mb-2">
                                                        <?php echo $data['resultado_registros_parametros'][0]->app_descripcion; ?>
                                                    </p>
                                                    <hr class="my-3">
                                                    <div class="col-md-12 mb-3 mt-3">
                                                        <label for="hvae_familiar" class="form-label my-0 font-size-12">¿Tiene usted familiares, cónyuge y/o compañero permanente, parientes dentro del cuarto grado de consanguinidad, tercero de afinidad o único civil que actualmente sea trabajador, practicante o aprendiz del GRUPO ASD S.A.S.?</label>
                                                        <div
    class="d-flex flex-wrap gap-3 mt-1"
    role="radiogroup"
    aria-label="Declaración de familiares o personas relacionadas"
>
    <div class="form-check form-check-inline">
        <input
            class="form-check-input"
            type="radio"
            name="hvae_familiar"
            id="hvae_familiar_si"
            value="Si"
            required
            onchange="validar_etica();"
            <?php echo (
                isset($data['resultado_registros'][0]->hvae_familiar)
                && $data['resultado_registros'][0]->hvae_familiar === 'Si'
            ) ? 'checked' : ''; ?>
        >
        <label
            class="form-check-label font-size-12"
            for="hvae_familiar_si"
        >Sí</label>
    </div>

    <div class="form-check form-check-inline">
        <input
            class="form-check-input"
            type="radio"
            name="hvae_familiar"
            id="hvae_familiar_no"
            value="No"
            required
            onchange="validar_etica();"
            <?php echo (
                isset($data['resultado_registros'][0]->hvae_familiar)
                && $data['resultado_registros'][0]->hvae_familiar === 'No'
            ) ? 'checked' : ''; ?>
        >
        <label
            class="form-check-label font-size-12"
            for="hvae_familiar_no"
        >No</label>
    </div>
</div>
                                                    </div>
                                                    <div class="col-md-12 mb-3 d-none" id="hpr_tabla_div">
                                                        <p class="appoinment-content-text mt-0 mb-2">Por favor, proporcione el nombre completo, el cargo que ocupa y la campaña/cliente a la que pertenece su familiar.</p>
                                                        <div class="row g-2 align-items-end">
                                                            <div class="col-md-3">
                                                                <label for="hpr_nombre_completo" class="form-label my-0 font-size-12">Nombre Completo</label>
                                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" id="hpr_nombre_completo" autocomplete="off">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label for="hpr_cargo" class="form-label my-0 font-size-12">Cargo</label>
                                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" id="hpr_cargo" autocomplete="off">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label for="hpr_campana_cliente" class="form-label my-0 font-size-12">Campaña/Cliente</label>
                                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" id="hpr_campana_cliente" autocomplete="off">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label for="hpr_relacion_contractual" class="form-label my-0 font-size-12">Relación Contractual/Comercial</label>
                                                                <select
    class="form-control form-control-sm font-size-11 px-2 py-1"
    id="hpr_relacion_contractual"
    aria-label="Relación Contractual/Comercial"
>
    <option value="">Seleccione</option>
    <option value="Trabajador">Trabajador</option>
    <option value="Practicante">Practicante</option>
    <option value="Aprendiz">Aprendiz</option>
    <option value="Contratista">Contratista</option>
    <option value="Cliente">Cliente</option>
</select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label for="hpr_parentesco" class="form-label my-0 font-size-12">Parentesco/Relación</label>
                                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" id="hpr_parentesco" autocomplete="off">
                                                            </div>
                                                            <div class="col-md-1">
                                                                <a class="btn btn-warning login-btn btn-sm w-100" onclick="persona_relacionada_add();">Agregar</a>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <p class="appoinment-content-text mt-0 mb-2">Personas Relacionadas Registradas</p>
                                                        <div class="col-md-12 mb-2" id="lista_persona_relacionada"></div>
                                                    </div>
                                                    <hr class="my-3">
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label my-0 font-size-12 d-block">¿Forma parte de alguna población sujeto de especial protección o vulnerabilidad?</label>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="hvae_poblacion_vulnerable" id="hvae_poblacion_vulnerable_si" value="Si" required <?php echo (isset($data['resultado_registros'][0]->hvae_poblacion_vulnerable) AND $data['resultado_registros'][0]->hvae_poblacion_vulnerable=='Si') ? 'checked' : ''; ?>>
                                                            <label class="form-check-label font-size-12" for="hvae_poblacion_vulnerable_si">Sí</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="hvae_poblacion_vulnerable" id="hvae_poblacion_vulnerable_no" value="No" required <?php echo (isset($data['resultado_registros'][0]->hvae_poblacion_vulnerable) AND $data['resultado_registros'][0]->hvae_poblacion_vulnerable=='No') ? 'checked' : ''; ?>>
                                                            <label class="form-check-label font-size-12" for="hvae_poblacion_vulnerable_no">No</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="hvae_poblacion_vulnerable" id="hvae_poblacion_vulnerable_np" value="Prefiero no decirlo" required <?php echo (isset($data['resultado_registros'][0]->hvae_poblacion_vulnerable) AND $data['resultado_registros'][0]->hvae_poblacion_vulnerable=='Prefiero no decirlo') ? 'checked' : ''; ?>>
                                                            <label class="form-check-label font-size-12" for="hvae_poblacion_vulnerable_np">Prefiero no decirlo</label>
                                                        </div>
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
    function validar_etica() {
        var seleccionado = document.querySelector(
            'input[name="hvae_familiar"]:checked'
        );

        var respuesta = seleccionado ? seleccionado.value : '';

        $("#hpr_tabla_div")
            .removeClass('d-block')
            .addClass('d-none');

        if (respuesta === 'Si') {
            $("#hpr_tabla_div")
                .removeClass('d-none')
                .addClass('d-block');

            persona_relacionada_list();
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            validar_etica
        );
    } else {
        validar_etica();
    }
jQuery(document).ready(function(){
        jQuery("#hpr_nombre_completo").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hpr_parentesco").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });
// ===== RF-02: Personas relacionadas con GRUPO ASD S.A.S. =====
    function persona_relacionada_add() {
        var id_oferta = '<?php echo $data['id_oferta']; ?>';
        var token = '<?php echo $data['id_token']; ?>';
        var hpr_nombre_completo = document.getElementById("hpr_nombre_completo").value;
        var hpr_cargo = document.getElementById("hpr_cargo").value;
        var hpr_campana_cliente = document.getElementById("hpr_campana_cliente").value;
        var hpr_relacion_contractual = document.getElementById("hpr_relacion_contractual").value;
        var hpr_parentesco = document.getElementById("hpr_parentesco").value;

        var formData = new FormData();
        formData.append("id_oferta", id_oferta);
        formData.append("token", token);
        formData.append("hpr_nombre_completo", hpr_nombre_completo);
        formData.append("hpr_cargo", hpr_cargo);
        formData.append("hpr_campana_cliente", hpr_campana_cliente);
        formData.append("hpr_relacion_contractual", hpr_relacion_contractual);
        formData.append("hpr_parentesco", hpr_parentesco);

        if (token!="" && id_oferta!="" && hpr_nombre_completo!="" && hpr_cargo!="" && hpr_campana_cliente!="" && hpr_relacion_contractual!="" && hpr_parentesco!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>seleccion-vinculacion/formulario-persona-relacionada-registro',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    document.getElementById("hpr_nombre_completo").disabled=true;
                    document.getElementById("hpr_cargo").disabled=true;
                    document.getElementById("hpr_campana_cliente").disabled=true;
                    document.getElementById("hpr_parentesco").disabled=true;
                },
                complete:function(data){
                    document.getElementById("hpr_nombre_completo").disabled=false;
                    document.getElementById("hpr_cargo").disabled=false;
                    document.getElementById("hpr_campana_cliente").disabled=false;
                    document.getElementById("hpr_parentesco").disabled=false;
                },
                success: function(data){
                    var resp = $.parseJSON(data);

                    if (resp.resultado_valor) {
                        document.getElementById("hpr_nombre_completo").value='';
                        document.getElementById("hpr_cargo").value='';
                        document.getElementById("hpr_campana_cliente").value='';
                        document.getElementById('hpr_relacion_contractual').value = '';
                        document.getElementById("hpr_parentesco").value='';
                    } else {
                        alert("¡No se pudo agregar el registro, verifique que la relación contractual sea válida e intente nuevamente!");
                    }
                    persona_relacionada_list();
                },
                error: function(data){
                    alert("Problemas al tratar de crear el registro, por favor verifique e intente nuevamente");
                }
            });
        } else {
            alert("¡Todos los campos son obligatorios, por favor verifique e intente nuevamente!");
        }
    }

    function persona_relacionada_list() {
        var id_oferta = '<?php echo $data['id_oferta']; ?>';
        var token = '<?php echo $data['id_token']; ?>';

        var formData = new FormData();
        formData.append("id_oferta", id_oferta);
        formData.append("token", token);

        if (token!="" && id_oferta!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>seleccion-vinculacion/formulario-persona-relacionada-listar',
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
                        $('#lista_persona_relacionada').html(resp.resultado_lista);
                        progreso();
                    } else {
                        $('#lista_persona_relacionada').html('<p class="alert alert-warning p-1 font-size-11">¡No se encontró información de personas relacionadas registrada!</p>');
                    }
                },
                error: function(data){
                    alert("Problemas al tratar de obtener el registro, por favor verifique e intente nuevamente");
                }
            });
        }
    }

    function persona_relacionada_del(id_registro) {
        if (!confirm("¿Está seguro de eliminar esta persona relacionada?")) {
            return;
        }

        var id_oferta = '<?php echo $data['id_oferta']; ?>';
        var token = '<?php echo $data['id_token']; ?>';

        var formData = new FormData();
        formData.append("id_oferta", id_oferta);
        formData.append("token", token);
        formData.append("id_registro", id_registro);

        if (token!="" && id_oferta!="" && id_registro!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>seleccion-vinculacion/formulario-persona-relacionada-eliminar',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){

                },
                complete:function(data){

                },
                success: function(data){
                    persona_relacionada_list();
                },
                error: function(data){
                    alert("Problemas al tratar de eliminar el registro, por favor verifique e intente nuevamente");
                }
            });
        }
    }
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

                    if (resp.secciones.etica==1) {
                        $('#btn_continuar').html('<a href="<?php echo URL; ?>seleccion-vinculacion/formulario-iq<?php echo $data['path_add']; ?>" class="btn btn-dark login-btn">Continuar</a>');
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