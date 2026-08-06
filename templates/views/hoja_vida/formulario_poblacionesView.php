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
                                                        <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-users"></span> Información de Poblaciones</p>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="hvp_poblaciones_poblacion" class="form-label my-0 font-size-12">Haces parte de alguna de las poblaciones mencionadas?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_poblaciones_poblacion" id="hvp_poblaciones_poblacion" data-container="body" title="Seleccione" onchange="valida_poblacion();" required>
                                                            <option value="Persona en proceso de reincorporación, reintegración y/o desmovilización" <?php echo ($data['resultado_registros_usuario'][0]->hvp_poblaciones_poblacion=='Persona en proceso de reincorporación, reintegración y/o desmovilización') ? 'selected' : ''; ?>>Persona en proceso de reincorporación, reintegración y/o desmovilización</option>
                                                            <option value="Transgénero" <?php echo ($data['resultado_registros_usuario'][0]->hvp_poblaciones_poblacion=='Transgénero') ? 'selected' : ''; ?>>Transgénero</option>
                                                            <option value="Víctima Conflicto armado" <?php echo ($data['resultado_registros_usuario'][0]->hvp_poblaciones_poblacion=='Víctima Conflicto armado') ? 'selected' : ''; ?>>Víctima Conflicto armado</option>
                                                            <option value="Personas en pobreza SISBEN grupos A, B y C" <?php echo ($data['resultado_registros_usuario'][0]->hvp_poblaciones_poblacion=='Personas en pobreza SISBEN grupos A, B y C') ? 'selected' : ''; ?>>Personas en pobreza SISBEN grupos A, B y C</option>
                                                            <option value="Persona con pertenencia a grupo étnico: población Negra, Afrocolombiana, Raizal y Palenquera, indígena o Rrom." <?php echo ($data['resultado_registros_usuario'][0]->hvp_poblaciones_poblacion=='Persona con pertenencia a grupo étnico: población Negra, Afrocolombiana, Raizal y Palenquera, indígena o Rrom.') ? 'selected' : ''; ?>>Persona con pertenencia a grupo étnico: población Negra, Afrocolombiana, Raizal y Palenquera, indígena o Rrom</option>
                                                            <option value="Joven mayor de 18 años que está o estuvo en protección del ICBF" <?php echo ($data['resultado_registros_usuario'][0]->hvp_poblaciones_poblacion=='Joven mayor de 18 años que está o estuvo en protección del ICBF') ? 'selected' : ''; ?>>Joven mayor de 18 años que está o estuvo en protección del ICBF</option>
                                                            <option value="Discapacidad certificada" <?php echo ($data['resultado_registros_usuario'][0]->hvp_poblaciones_poblacion=='Discapacidad certificada') ? 'selected' : ''; ?>>Discapacidad certificada</option>
                                                            <option value="No aplica" <?php echo ($data['resultado_registros_usuario'][0]->hvp_poblaciones_poblacion=='No aplica') ? 'selected' : ''; ?>>No aplica</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3 d-none" id="div_hvp_poblaciones_certificado">
                                                        <label for="hvp_poblaciones_certificado" class="form-label my-0 font-size-12">¿Cuentas con los documentos que validen la información (certificación)?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_poblaciones_certificado" id="hvp_poblaciones_certificado" data-container="body" title="Seleccione" onchange="valida_poblacion_soporte();" required disabled>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_poblaciones_certificado=='No') ? 'selected' : ''; ?>>No</option>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_poblaciones_certificado=='Si') ? 'selected' : ''; ?>>Si</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 mb-3 d-none" id="div_hvp_poblaciones_poblacion_soporte">
                                                        <label for="hvp_poblaciones_poblacion_soporte" class="form-label my-0 font-size-11">Certificado</label>
                                                        <small class="fst-italic text-danger font-size-11">Adjunte el certificado correspondiente en formato PDF (Máx. 2Mb)</small>
                                                        <input type="file" class="form-control form-control-sm" name="hvp_poblaciones_poblacion_soporte" id="hvp_poblaciones_poblacion_soporte" accept=".pdf, .PDF" <?php echo ($data['resultado_registros_usuario'][0]->hvp_poblaciones_poblacion_soporte=='' AND $data['resultado_registros_usuario'][0]->hvp_poblaciones_certificado=='Si') ? 'required' : ''; ?> disabled>
                                                    </div>
                                                    <?php if($data['resultado_registros_usuario'][0]->hvp_poblaciones_poblacion_soporte!=''): ?>
                                                        <div class="col-md-12 my-1">
                                                            <fieldset class="border rounded-3 px-3 py-1">
                                                                <legend class="float-none w-auto px-2 font-size-12 fw-bold">
                                                                    Certificado población especial
                                                                </legend>
                                                                <embed src="<?php echo UPLOADS; ?><?php echo $data['resultado_registros_usuario'][0]->hvp_poblaciones_poblacion_soporte; ?>" type="application/pdf" width="100%" height="600px" />
                                                            </fieldset>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="col-md-12">
                                                        <p class="alert alert-corp p-1 my-2"><span class="fas fa-people-arrows"></span> Relaciones Familiares</p>
                                                    </div>
                                                    <p class="appoinment-content-text mt-0 mb-2">
                                                        <?php echo $data['resultado_registros_parametros_cod_etica'][0]->app_descripcion; ?>
                                                    </p>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="hvp_poblaciones_familiares_iq" class="form-label my-0 font-size-12">¿Tiene usted familiares, cónyuge y/o compañero permanente, parientes dentro del cuarto grado de consanguinidad, tercero de afinidad o único civil que actualmente sea trabajador, practicante o aprendiz del GRUPO ASD S.A.S.?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_poblaciones_familiares_iq" id="hvp_poblaciones_familiares_iq" data-container="body" title="Seleccione" onchange="valida_familiar();" required>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_poblaciones_familiares_iq=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_poblaciones_familiares_iq=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
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
                                                                <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" id="hpr_relacion_contractual" data-container="body" title="Seleccione">
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
                                                    <div class="col-md-12">
                                                        <p class="alert alert-corp p-1 my-2"><span class="fas fa-shield-alt"></span> Población Sujeto de Especial Protección</p>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label my-0 font-size-12 d-block">¿Forma parte de alguna población sujeto de especial protección o vulnerabilidad?</label>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="hvp_poblacion_vulnerable" id="hvp_poblacion_vulnerable_si" value="Si" required <?php echo (isset($data['resultado_registros_usuario'][0]->hvp_poblacion_vulnerable) AND $data['resultado_registros_usuario'][0]->hvp_poblacion_vulnerable=='Si') ? 'checked' : ''; ?>>
                                                            <label class="form-check-label font-size-12" for="hvp_poblacion_vulnerable_si">Sí</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="hvp_poblacion_vulnerable" id="hvp_poblacion_vulnerable_no" value="No" required <?php echo (isset($data['resultado_registros_usuario'][0]->hvp_poblacion_vulnerable) AND $data['resultado_registros_usuario'][0]->hvp_poblacion_vulnerable=='No') ? 'checked' : ''; ?>>
                                                            <label class="form-check-label font-size-12" for="hvp_poblacion_vulnerable_no">No</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="hvp_poblacion_vulnerable" id="hvp_poblacion_vulnerable_np" value="Prefiero no decirlo" required <?php echo (isset($data['resultado_registros_usuario'][0]->hvp_poblacion_vulnerable) AND $data['resultado_registros_usuario'][0]->hvp_poblacion_vulnerable=='Prefiero no decirlo') ? 'checked' : ''; ?>>
                                                            <label class="form-check-label font-size-12" for="hvp_poblacion_vulnerable_np">Prefiero no decirlo</label>
                                                        </div>
                                                    </div>
                                                    <div class="appoinment-title mt-2">
                                                        <h4>CONSIDERACIONES</h4>
                                                    </div>
                                                    <p class="appoinment-content-text mt-0 mb-2">
                                                        <?php echo $data['resultado_registros_parametros'][0]->app_descripcion; ?>
                                                    </p>
                                                    <div class="col-md-12 my-3">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" value="Si" name="hvp_veracidad" id="hvp_veracidad_si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_veracidad=='Si') ? 'checked' : ''; ?> required>
                                                            <label class="form-check-label font-size-12 fw-bold" for="hvp_veracidad_si">Sí</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" value="No" name="hvp_veracidad" id="hvp_veracidad_no" <?php echo ($data['resultado_registros_usuario'][0]->hvp_veracidad=='No') ? 'checked' : ''; ?> required>
                                                            <label class="form-check-label font-size-12 fw-bold" for="hvp_veracidad_no">No</label>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <?php echo Flasher::flash(); ?>
                                            <div class="col-md-12 text-end">
                                                <span id="btn_enviar">
                                                    <?php if($data['resultado_registros_usuario'][0]->hvp_poblaciones_poblacion!=''): ?>
                                                        <a href="<?php echo URL; ?>inicio" class="btn btn-dark login-btn">Finalizar</a>
                                                    <?php endif; ?>
                                                    <button type="submit" name="form_guardar" class="btn btn-success login-btn">Guardar</button>
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
        jQuery("#hvp_poblaciones_familiares_iq_nombres_apellidos").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
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

    function valida_poblacion() {
        $("#div_hvp_poblaciones_certificado").removeClass('d-block').addClass('d-none');
        $("#div_hvp_poblaciones_poblacion_soporte").removeClass('d-block').addClass('d-none');

        document.getElementById('hvp_poblaciones_certificado').disabled=true;
        document.getElementById('hvp_poblaciones_poblacion_soporte').disabled=true;

        var hvp_poblaciones_poblacion = document.getElementById("hvp_poblaciones_poblacion").value;

        if (hvp_poblaciones_poblacion!="" && (hvp_poblaciones_poblacion!="No aplica")) {
            $("#div_hvp_poblaciones_certificado").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_poblaciones_certificado').disabled=false;
            $('#hvp_poblaciones_certificado').selectpicker('destroy');
            $('#hvp_poblaciones_certificado').selectpicker();
        }

        valida_poblacion_soporte();
    }

    function valida_poblacion_soporte() {
        $("#div_hvp_poblaciones_poblacion_soporte").removeClass('d-block').addClass('d-none');

        document.getElementById('hvp_poblaciones_poblacion_soporte').disabled=true;

        var hvp_poblaciones_certificado = document.getElementById("hvp_poblaciones_certificado").value;
        
        if (hvp_poblaciones_certificado!="" && (hvp_poblaciones_certificado=="Si")) {
            $("#div_hvp_poblaciones_poblacion_soporte").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_poblaciones_poblacion_soporte').disabled=false;
            <?php if($data['resultado_registros_usuario'][0]->hvp_poblaciones_poblacion_soporte==''): ?>
                document.getElementById('hvp_poblaciones_poblacion_soporte').required=true;
            <?php endif; ?>
        }
    }

    function valida_familiar() {
        $("#hpr_tabla_div").removeClass('d-block').addClass('d-none');
        var respuesta=document.getElementById("hvp_poblaciones_familiares_iq").value;
        if (respuesta==="Si") {
            $("#hpr_tabla_div").removeClass('d-none').addClass('d-block');
            persona_relacionada_list();
        }
    }
    // ===== RF-02: Personas relacionadas con GRUPO ASD S.A.S. =====
    function persona_relacionada_add() {
        var hpr_nombre_completo = document.getElementById("hpr_nombre_completo").value;
        var hpr_cargo = document.getElementById("hpr_cargo").value;
        var hpr_campana_cliente = document.getElementById("hpr_campana_cliente").value;
        var hpr_relacion_contractual = document.getElementById("hpr_relacion_contractual").value;
        var hpr_parentesco = document.getElementById("hpr_parentesco").value;

        var formData = new FormData();
        formData.append("hpr_nombre_completo", hpr_nombre_completo);
        formData.append("hpr_cargo", hpr_cargo);
        formData.append("hpr_campana_cliente", hpr_campana_cliente);
        formData.append("hpr_relacion_contractual", hpr_relacion_contractual);
        formData.append("hpr_parentesco", hpr_parentesco);

        if (hpr_nombre_completo!="" && hpr_cargo!="" && hpr_campana_cliente!="" && hpr_relacion_contractual!="" && hpr_parentesco!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>hoja-vida/formulario-persona-relacionada-registro',
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
                        $('#hpr_relacion_contractual').selectpicker('val', '');
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
        var formData = new FormData();

        $.ajax({
            type: 'POST',
            url: '<?php echo URL; ?>hoja-vida/formulario-persona-relacionada-listar',
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

    function persona_relacionada_del(id_registro) {
        if (!confirm("¿Está seguro de eliminar esta persona relacionada?")) {
            return;
        }

        var formData = new FormData();
        formData.append("id_registro", id_registro);

        $.ajax({
            type: 'POST',
            url: '<?php echo URL; ?>hoja-vida/formulario-persona-relacionada-eliminar',
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

        valida_poblacion();
        valida_familiar();
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