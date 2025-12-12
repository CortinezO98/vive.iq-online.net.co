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
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-iq<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Información IQ<span id="status_informacion"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-financiera<?php echo $data['path_add']; ?>" class="btn btn-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Información Financiera<span id="status_financiera"></span></a>
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
                                            <h3>Información Financiera</h3>
                                            <!-- CONTENIDO FORMULARIO -->
                                            <?php if($data['valida_token']): ?>
                                                <?php if($data['valida_oferta']): ?>
                                                <div class="col-md-6 mb-3">
                                                    <label for="hvaf_activos" class="form-label my-0 font-size-12">Activos <span class="fas fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="Relacione el valor de todos aquellos bienes y propiedades que se encuentren a su nombre (casas, apartamentos, locales, terrenos, fincas, vehículos, inversiones)."></span></label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaf_activos" id="hvaf_activos" value="<?php echo $data['resultado_registros'][0]->hvaf_activos; ?>" required autocomplete="off">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="hvaf_ingresos" class="form-label my-0 font-size-12">Ingresos mensuales  <span class="fas fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="Hace referencia a los ingresos percibidos de forma constante o en promedio en el mes."></label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaf_ingresos" id="hvaf_ingresos" value="<?php echo $data['resultado_registros'][0]->hvaf_ingresos; ?>" required autocomplete="off">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="hvaf_pasivos" class="form-label my-0 font-size-12">Pasivos <span class="fas fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="Relacione el monto de las deudas a cargo, vigentes en esa fecha (Créditos bancarios, obligaciones con particulares siempre que estén soportados con un documento, contrato o título valor; deudas con entidades del estado)."></label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaf_pasivos" id="hvaf_pasivos" value="<?php echo $data['resultado_registros'][0]->hvaf_pasivos; ?>" required autocomplete="off">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="hvaf_egresos" class="form-label my-0 font-size-12">Egresos mensuales <span class="fas fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="Hace referencia a las deudas o salidas de dinero en el mes (de forma constante o en promedio)."></label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaf_egresos" id="hvaf_egresos" value="<?php echo $data['resultado_registros'][0]->hvaf_egresos; ?>" required autocomplete="off">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="hvaf_patrimonio" class="form-label my-0 font-size-12">Patrimonio <span class="fas fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="Relacione  aquí el valor general del conjunto de bienes, derechos y obligaciones con los que cuenta actualmente (Activos - Pasivos)."></label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaf_patrimonio" id="hvaf_patrimonio" value="<?php echo $data['resultado_registros'][0]->hvaf_patrimonio; ?>" required autocomplete="off">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="hvaf_ingresos_otros" class="form-label my-0 font-size-12">Otros ingresos <span class="fas fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="Ingresos adicionales que pueden darse de forma variable o esporádica."></label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaf_ingresos_otros" id="hvaf_ingresos_otros" value="<?php echo $data['resultado_registros'][0]->hvaf_ingresos_otros; ?>" required autocomplete="off">
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="hvaf_concepto_ingresos" class="form-label my-0 font-size-12">Concepto de otros ingresos</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaf_concepto_ingresos" id="hvaf_concepto_ingresos" value="<?php echo $data['resultado_registros'][0]->hvaf_concepto_ingresos; ?>">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="hvaf_moneda_extranjera" class="form-label my-0 font-size-12">¿Realiza Operaciones en Moneda Extranjera?</label>
                                                    <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvaf_moneda_extranjera" id="hvaf_moneda_extranjera" data-container="body" title="Seleccione" required>
                                                        <option value="Si" <?php echo ($data['resultado_registros'][0]->hvaf_moneda_extranjera=='Si') ? 'selected' : ''; ?>>Si</option>
                                                        <option value="No" <?php echo ($data['resultado_registros'][0]->hvaf_moneda_extranjera=='No') ? 'selected' : ''; ?>>No</option>
                                                    </select>
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
    jQuery(document).ready(function(){
        jQuery("#hvaf_activos").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvaf_ingresos").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvaf_pasivos").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    jQuery(document).ready(function(){ 
        jQuery("#hvaf_egresos").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvaf_patrimonio").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvaf_ingresos_otros").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvaf_concepto_ingresos").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });
    
    validateControlById('hvaf_activos');
    validateControlById('hvaf_ingresos');
    validateControlById('hvaf_pasivos');
    validateControlById('hvaf_egresos');
    validateControlById('hvaf_patrimonio');
    validateControlById('hvaf_ingresos_otros');
    validateControlById('hvaf_concepto_ingresos');
    validateControlById('hvaf_moneda_extranjera');
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

                    if (resp.secciones.financiera==1) {
                        $('#btn_continuar').html('<a href="<?php echo URL; ?>seleccion-vinculacion/formulario-publica<?php echo $data['path_add']; ?>" class="btn btn-dark login-btn">Continuar</a>');
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