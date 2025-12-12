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
                                                        <label for="hvp_poblaciones_familiares_iq" class="form-label my-0 font-size-12">¿Tienes familiares, conyugue y/o compañero permanente, parientes dentro del  primer o segundo grado de consanguinidad, segundo de afinidad o único civil que actualmente trabaje en iQ?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_poblaciones_familiares_iq" id="hvp_poblaciones_familiares_iq" data-container="body" title="Seleccione" onchange="valida_familiar();" required>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_poblaciones_familiares_iq=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_poblaciones_familiares_iq=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-3 d-none" id="div_hvp_poblaciones_familiares_iq_identificacion">
                                                        <label for="hvp_poblaciones_familiares_iq_identificacion" class="form-label my-0 font-size-12">Documento de identidad de tu familiar</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_poblaciones_familiares_iq_identificacion" id="hvp_poblaciones_familiares_iq_identificacion" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_poblaciones_familiares_iq_identificacion; ?>" required disabled>
                                                    </div>
                                                    <div class="col-md-4 mb-3 d-none" id="div_hvp_poblaciones_familiares_iq_nombres_apellidos">
                                                        <label for="hvp_poblaciones_familiares_iq_nombres_apellidos" class="form-label my-0 font-size-12">¿Cuál es el nombre de tu familiar?</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_poblaciones_familiares_iq_nombres_apellidos" id="hvp_poblaciones_familiares_iq_nombres_apellidos" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_poblaciones_familiares_iq_nombres_apellidos; ?>" required disabled>
                                                    </div>
                                                    <div class="col-md-5 mb-3 d-none" id="div_hvp_poblaciones_familiares_iq_ingreso_marzo_2022">
                                                        <label for="hvp_poblaciones_familiares_iq_ingreso_marzo_2022" class="form-label my-0 font-size-12">Tu familiar ingresó a la compañía antes de marzo 2022?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_poblaciones_familiares_iq_ingreso_marzo_2022" id="hvp_poblaciones_familiares_iq_ingreso_marzo_2022" data-container="body" title="Seleccione" required disabled>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_poblaciones_familiares_iq_ingreso_marzo_2022=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_poblaciones_familiares_iq_ingreso_marzo_2022=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="appoinment-title mt-2">
                                                        <h4>Veracidad de la Información Proporcionada</h4>
                                                    </div>
                                                    <p class="appoinment-content-text mt-0 mb-2">
                                                        <?php echo $data['resultado_registros_parametros'][0]->app_descripcion; ?>
                                                    </p>
                                                    <div class="col-md-12 my-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="Si" name="hvp_veracidad" id="hvp_veracidad" <?php echo ($data['resultado_registros_usuario'][0]->hvp_veracidad=='Si') ? 'checked' : ''; ?> required>
                                                            <label class="form-check-label font-size-12 fw-bold" for="hvp_veracidad">Si, acepto</label>
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
        $("#div_hvp_poblaciones_familiares_iq_identificacion").removeClass('d-block').addClass('d-none');
        $("#div_hvp_poblaciones_familiares_iq_nombres_apellidos").removeClass('d-block').addClass('d-none');
        $("#div_hvp_poblaciones_familiares_iq_ingreso_marzo_2022").removeClass('d-block').addClass('d-none');

        document.getElementById('hvp_poblaciones_familiares_iq_identificacion').disabled=true;
        document.getElementById('hvp_poblaciones_familiares_iq_nombres_apellidos').disabled=true;
        document.getElementById('hvp_poblaciones_familiares_iq_ingreso_marzo_2022').disabled=true;

        var hvp_poblaciones_familiares_iq = document.getElementById("hvp_poblaciones_familiares_iq").value;

        if (hvp_poblaciones_familiares_iq!="" && (hvp_poblaciones_familiares_iq=="Si")) {
            $("#div_hvp_poblaciones_familiares_iq_identificacion").removeClass('d-none').addClass('d-block');
            $("#div_hvp_poblaciones_familiares_iq_nombres_apellidos").removeClass('d-none').addClass('d-block');
            $("#div_hvp_poblaciones_familiares_iq_ingreso_marzo_2022").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_poblaciones_familiares_iq_identificacion').disabled=false;
            document.getElementById('hvp_poblaciones_familiares_iq_nombres_apellidos').disabled=false;
            document.getElementById('hvp_poblaciones_familiares_iq_ingreso_marzo_2022').disabled=false;
            $('#hvp_poblaciones_familiares_iq_ingreso_marzo_2022').selectpicker('destroy');
            $('#hvp_poblaciones_familiares_iq_ingreso_marzo_2022').selectpicker();
        }
    }

    <?php if($data['resultado_registros_usuario'][0]->hvp_poblaciones_poblacion!=''): ?>
        valida_poblacion();
        // valida_poblacion_soporte();
        valida_familiar();
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