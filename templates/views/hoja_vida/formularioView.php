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
                <div class="row justify-content-center mb-5">
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
                                                        <p class="alert alert-corp p-1 my-0"><span class="fas fa-file-signature"></span> Autorización para el Tratamiento de Datos Personales</p>
                                                    </div>
                                                    <?php if($data['resultado_registros_usuario_count']>0): ?>
                                                        <div class="col-md-12">
                                                            <div class="bg-light p-3 overflow-y-scroll" style="min-height: 100px !important; max-height: 300px !important;">
                                                                <?php echo $data['resultado_registros_parametros'][0]->app_descripcion; ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 my-5">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="Si" name="hvp_consentimiento_tratamiento_datos_personales" id="hvp_consentimiento_tratamiento_datos_personales" <?php echo ($data['resultado_registros_usuario'][0]->hvp_consentimiento_tratamiento_datos_personales=='Si') ? 'checked' : ''; ?> required>
                                                                <label class="form-check-label font-size-12 fw-bold" for="hvp_consentimiento_tratamiento_datos_personales">Si, autorizo el tratamiento de datos personales</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <?php if($data['resultado_registros_usuario'][0]->hvp_auxiliar_3==''): ?>
                                                                <p class="alert alert-warning p-1 font-size-11 mt-0 mb-2">Para autorizar el Tratamiento de Datos Personales, por favor cargue la firma en formato de imagen.</p>
                                                            <?php else: ?>
                                                                <img src="<?php echo UPLOADS.$data['resultado_registros_usuario'][0]->hvp_auxiliar_3; ?>" class="img-fluid mb-2" style="width: 100px;">
                                                                <p class="alert alert-warning p-1 font-size-11 mt-0 mb-2">Para actualizar la firma de la política de Tratamiento de Datos Personales, por favor cargue nuevamente la firma en formato de imagen.</p>
                                                            <?php endif; ?>
                                                            <label for="documento_soporte" class="form-label my-0 font-size-11">Firma</label>
                                                            <small class="fst-italic text-danger font-size-11">Adjunte la firma en formato PNG, JPG o JPEG (Máx. 5Mb)</small>
                                                            <input type="file" class="form-control form-control-sm" name="documento_soporte" id="documento_soporte" accept=".png, .PNG, .jpg, .JPG, .jpeg, .JPEG" <?php echo ($data['resultado_registros_usuario'][0]->hvp_auxiliar_3=='') ? 'required' : ''; ?>>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="col-md-12">
                                                            <p class="alert alert-warning p-1 font-size-11">¡No encontramos secciones habilitadas para la Hoja de Vida, por favor verifique!</p>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php echo Flasher::flash(); ?>
                                            <div class="col-md-12 text-end">
                                                <?php if($data['resultado_registros_usuario_count']>0): ?>
                                                    <span id="btn_enviar">
                                                        <button type="submit" name="form_guardar" class="btn btn-success login-btn">Guardar y continuar</button>
                                                    </span>
                                                <?php endif; ?>
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
<!-- MODAL DETALLE -->
    <div class="modal fade" id="modal-detalle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Detalle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body-detalle">
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark py-2 px-2" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
        </div>
    </div>
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