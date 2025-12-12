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
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-financiera<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Información Financiera<span id="status_financiera"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-publica<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Personas Expuestas Públicamente - PEP<span id="status_publica"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-segsocial<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Seguridad Social<span id="status_segsocial"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-autorizaciones<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Declaraciones<span id="status_autorizaciones"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-autorizaciones-datos<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Autorización Tratamiento Datos Personales<span id="status_datos_personales"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-documentos<?php echo $data['path_add']; ?>" class="btn btn-outline-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Documentos<span id="status_documentos"></span></a>
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-cierre<?php echo $data['path_add']; ?>" class="btn btn-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Firmar y enviar<span id="status_firma"></span></a>
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
                                            <h3>Firmar</h3>
                                            <!-- CONTENIDO FORMULARIO -->
                                            <?php if($data['valida_token']): ?>
                                                <?php if($data['valida_oferta']): ?>
                                                    <p class="appoinment-content-text mt-0 mb-2">Para finalizar el diligenciamiento de la hoja de vida digital, por favor cargue la firma en formato de imagen.</p>
                                                    <div class="col-12 mb-3">
                                                        <label for="documento_soporte" class="form-label my-0 font-size-11">Firma</label>
                                                        <small class="fst-italic text-danger font-size-11">Adjunte la firma en formato PNG, JPG o JPEG (Máx. 5Mb)</small>
                                                        <input type="file" class="form-control form-control-sm" name="documento_soporte" id="documento_soporte" accept=".png, .PNG, .jpg, .JPG, .jpeg, .JPEG" required>
                                                        <!-- Imagen de vista previa -->
                                                        <div class="mt-2">
                                                            <img id="preview_firma" src="" alt="Vista previa de la firma" style="max-height: 150px; display: none; border: 1px solid #ccc; padding: 5px;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 my-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="Si" name="firma_confirma" id="firma_confirma" <?php echo ($data['resultado_registros'][0]->firma_confirma=='Si') ? 'checked' : ''; ?> required>
                                                            <label class="form-check-label font-size-12 fw-bold" for="firma_confirma">Confirmo que la firma seleccionada es la correcta</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <?php if($data['menor_edad']): ?>
                                                        <div class="col-md-12 my-2">
                                                            <p class="alert alert-warning p-1">Debido a que es menor de edad, debe diligenciar los datos y cargar la firma de autorización de uno de los padres:</p>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="hva_auxiliar_3" class="form-label my-0 font-size-12">Nombres y apellidos</label>
                                                            <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hva_auxiliar_3" id="hva_auxiliar_3" value="<?php echo $data['resultado_registros_usuario'][0]->hva_auxiliar_3; ?>" required>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="hva_auxiliar_4" class="form-label my-0 font-size-12">No. identificación</label>
                                                            <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hva_auxiliar_4" id="hva_auxiliar_4" value="<?php echo $data['resultado_registros_usuario'][0]->hva_auxiliar_4; ?>" required>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label for="documento_soporte_padres" class="form-label my-0 font-size-11">Firma de uno de los padres</label>
                                                            <small class="fst-italic text-danger font-size-11">Adjunte la firma en formato PNG, JPG o JPEG (Máx. 5Mb)</small>
                                                            <input type="file" class="form-control form-control-sm" name="documento_soporte_padres" id="documento_soporte_padres" accept=".png, .PNG, .jpg, .JPG, .jpeg, .JPEG" required>
                                                            <!-- Imagen de vista previa -->
                                                            <div class="mt-2">
                                                                <img id="preview_firma_padres" src="" alt="Vista previa de la firma" style="max-height: 150px; display: none; border: 1px solid #ccc; padding: 5px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 my-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="Si" name="firma_confirma_padres" id="firma_confirma_padres" <?php echo ($data['resultado_registros'][0]->firma_confirma_padres=='Si') ? 'checked' : ''; ?> required>
                                                                <label class="form-check-label font-size-12 fw-bold" for="firma_confirma_padres">Confirmo que la firma seleccionada es la correcta</label>
                                                            </div>
                                                        </div>
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
                                        <span id="btn_enviar"></span>
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
    jQuery(document).ready(function(){
        jQuery("#hva_auxiliar_4").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });
    
    jQuery(document).ready(function(){
        jQuery("#hva_auxiliar_3").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });
    
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

                    $('#btn_enviar').html(resp.control_firma_string);

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

    document.getElementById('documento_soporte').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview_firma');

        if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
        } else {
        preview.src = '';
        preview.style.display = 'none';
        }
    });

    document.getElementById('documento_soporte_padres').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview_firma_padres');

        if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
        } else {
        preview.src = '';
        preview.style.display = 'none';
        }
    });
</script>