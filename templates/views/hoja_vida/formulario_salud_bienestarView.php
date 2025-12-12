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
                                                        <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-person-swimming"></span> Información de Salud y Bienestar</p>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="hvp_salud_bienestar_grupo_sanguineo" class="form-label my-0 font-size-12">¿Cuál es tu grupo sanguíneo?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_salud_bienestar_grupo_sanguineo" id="hvp_salud_bienestar_grupo_sanguineo" data-container="body" title="Seleccione" required>
                                                            <option value="A" <?php echo ($data['resultado_registros_usuario'][0]->hvp_salud_bienestar_grupo_sanguineo=='A') ? 'selected' : ''; ?>>A</option>
                                                            <option value="B" <?php echo ($data['resultado_registros_usuario'][0]->hvp_salud_bienestar_grupo_sanguineo=='B') ? 'selected' : ''; ?>>B</option>
                                                            <option value="AB" <?php echo ($data['resultado_registros_usuario'][0]->hvp_salud_bienestar_grupo_sanguineo=='AB') ? 'selected' : ''; ?>>AB</option>
                                                            <option value="O" <?php echo ($data['resultado_registros_usuario'][0]->hvp_salud_bienestar_grupo_sanguineo=='O') ? 'selected' : ''; ?>>O</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_salud_bienestar_rh" class="form-label my-0 font-size-12">¿Cuál es tu RH?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_salud_bienestar_rh" id="hvp_salud_bienestar_rh" data-container="body" title="Seleccione" required>
                                                            <option value="Positivo" <?php echo ($data['resultado_registros_usuario'][0]->hvp_salud_bienestar_rh=='Positivo') ? 'selected' : ''; ?>>Positivo</option>
                                                            <option value="Negativo" <?php echo ($data['resultado_registros_usuario'][0]->hvp_salud_bienestar_rh=='Negativo') ? 'selected' : ''; ?>>Negativo</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5 mb-3">
                                                        <label for="hvp_salud_bienestar_actividad_fisica_minima" class="form-label my-0 font-size-12">¿Realizas actividad física de mínimo 20 minutos al día?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_salud_bienestar_actividad_fisica_minima" id="hvp_salud_bienestar_actividad_fisica_minima" data-container="body" title="Seleccione" required>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_salud_bienestar_actividad_fisica_minima=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_salud_bienestar_actividad_fisica_minima=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <label for="hvp_salud_bienestar_fumador" class="form-label my-0 font-size-12">¿Fumas?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_salud_bienestar_fumador" id="hvp_salud_bienestar_fumador" data-container="body" title="Seleccione" required>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_salud_bienestar_fumador=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_salud_bienestar_fumador=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5 mb-3">
                                                        <label for="hvp_salud_bienestar_pausas_activas" class="form-label my-0 font-size-12">¿Realizas pausas activas durante la jornada laboral?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_salud_bienestar_pausas_activas" id="hvp_salud_bienestar_pausas_activas" data-container="body" title="Seleccione" required>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_salud_bienestar_pausas_activas=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_salud_bienestar_pausas_activas=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5 mb-3">
                                                        <label for="hvp_salud_bienestar_medicina_prepagada" class="form-label my-0 font-size-12">¿Tienes medicina prepagada?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_salud_bienestar_medicina_prepagada" id="hvp_salud_bienestar_medicina_prepagada" data-container="body" title="Seleccione" onchange="valida_prepagada();" required>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_salud_bienestar_medicina_prepagada=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_salud_bienestar_medicina_prepagada=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3 d-none" id="div_hvp_salud_bienestar_medicina_prepagada_cual">
                                                        <label for="hvp_salud_bienestar_medicina_prepagada_cual" class="form-label my-0 font-size-12">¿Cual?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_salud_bienestar_medicina_prepagada_cual" id="hvp_salud_bienestar_medicina_prepagada_cual" data-container="body" title="Seleccione" required disabled>
                                                            <?php for ($i=0; $i < count($data['resultado_registros_medicina_prepagada']); $i++): ?>
                                                                <option value="<?php echo $data['resultado_registros_medicina_prepagada'][$i]; ?>" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_operador_internet==$data['resultado_registros_medicina_prepagada'][$i]) ? 'selected' : ''; ?>><?php echo $data['resultado_registros_medicina_prepagada'][$i]; ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3 d-none" id="div_hvp_salud_bienestar_plan_complementario_salud">
                                                        <label for="hvp_salud_bienestar_plan_complementario_salud" class="form-label my-0 font-size-12">¿Tienes plan complementario de salud?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_salud_bienestar_plan_complementario_salud" id="hvp_salud_bienestar_plan_complementario_salud" data-container="body" title="Seleccione" onchange="valida_complementario();" required disabled>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_salud_bienestar_plan_complementario_salud=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_salud_bienestar_plan_complementario_salud=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3 d-none" id="div_hvp_salud_bienestar_plan_complementario_salud_cual">
                                                        <label for="hvp_salud_bienestar_plan_complementario_salud_cual" class="form-label my-0 font-size-12">¿Cual?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_salud_bienestar_plan_complementario_salud_cual" id="hvp_salud_bienestar_plan_complementario_salud_cual" data-container="body" title="Seleccione" required disabled>
                                                            <?php for ($i=0; $i < count($data['resultado_registros_complementario_salud']); $i++): ?>
                                                                <option value="<?php echo $data['resultado_registros_complementario_salud'][$i]; ?>" <?php echo ($data['resultado_registros_usuario'][0]->hvp_salud_bienestar_plan_complementario_salud_cual==$data['resultado_registros_complementario_salud'][$i]) ? 'selected' : ''; ?>><?php echo $data['resultado_registros_complementario_salud'][$i]; ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <p class="alert alert-warning p-1 m-0 font-size-12">
                                                            <b>Plan complementario en salud:</b> Amplía la cobertura del POS (Plan Obligatorio de Salud) con servicios adicionales como medicamentos costosos o consultas con especialistas. Sigue ligado al sistema público de salud.
                                                            <br><br>
                                                            <b>Medicina prepagada:</b> Sistema privado de salud con cobertura médica completa a través de una red privada de clínicas y hospitales. Independiente del sistema público de salud.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php echo Flasher::flash(); ?>
                                            <div class="col-md-12 text-end">
                                                <span id="btn_enviar">
                                                    <a href="<?php echo URL; ?>hoja-vida/formulario-socioeconomico/<?php echo base64_encode('socioeconomico'); ?>" class="btn btn-warning login-btn">Regresar</a>
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

    function valida_prepagada() {
        $("#div_hvp_salud_bienestar_medicina_prepagada_cual").removeClass('d-block').addClass('d-none');
        $("#div_hvp_salud_bienestar_plan_complementario_salud").removeClass('d-block').addClass('d-none');
        $("#div_hvp_salud_bienestar_plan_complementario_salud_cual").removeClass('d-block').addClass('d-none');

        document.getElementById('hvp_salud_bienestar_medicina_prepagada_cual').disabled=true;
        document.getElementById('hvp_salud_bienestar_plan_complementario_salud').disabled=true;
        document.getElementById('hvp_salud_bienestar_plan_complementario_salud_cual').disabled=true;

        var hvp_salud_bienestar_medicina_prepagada = document.getElementById("hvp_salud_bienestar_medicina_prepagada").value;

        if (hvp_salud_bienestar_medicina_prepagada!="" && (hvp_salud_bienestar_medicina_prepagada=="Si")) {
            $("#div_hvp_salud_bienestar_medicina_prepagada_cual").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_salud_bienestar_medicina_prepagada_cual').disabled=false;
            $('#hvp_salud_bienestar_medicina_prepagada_cual').selectpicker('destroy');
            $('#hvp_salud_bienestar_medicina_prepagada_cual').selectpicker();
        }

        if (hvp_salud_bienestar_medicina_prepagada=="No") {
            $("#div_hvp_salud_bienestar_plan_complementario_salud").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_salud_bienestar_plan_complementario_salud').disabled=false;
            $('#hvp_salud_bienestar_plan_complementario_salud').selectpicker('destroy');
            $('#hvp_salud_bienestar_plan_complementario_salud').selectpicker();
        }
    }
    
    function valida_complementario() {
        $("#div_hvp_salud_bienestar_plan_complementario_salud_cual").removeClass('d-block').addClass('d-none');
        
        document.getElementById('hvp_salud_bienestar_plan_complementario_salud_cual').disabled=true;

        var hvp_salud_bienestar_plan_complementario_salud = document.getElementById("hvp_salud_bienestar_plan_complementario_salud").value;

        if (hvp_salud_bienestar_plan_complementario_salud!="" && (hvp_salud_bienestar_plan_complementario_salud=="Si")) {
            $("#div_hvp_salud_bienestar_plan_complementario_salud_cual").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_salud_bienestar_plan_complementario_salud_cual').disabled=false;
            $('#hvp_salud_bienestar_plan_complementario_salud_cual').selectpicker('destroy');
            $('#hvp_salud_bienestar_plan_complementario_salud_cual').selectpicker();
        }

        
    }

    <?php if($data['resultado_registros_usuario'][0]->hvp_salud_bienestar_grupo_sanguineo!=''): ?>
        valida_complementario();
        valida_prepagada();
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