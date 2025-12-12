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
                                    <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-documentos<?php echo $data['path_add']; ?>" class="btn btn-dark px-2 font-size-11 py-1 text-start mt-1 d-block">Documentos<span id="status_documentos"></span></a>
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
                                            <h3>Documentos</h3>
                                            <!-- CONTENIDO FORMULARIO -->
                                            <?php if($data['valida_token']): ?>
                                                <?php if($data['valida_oferta']): ?>
                                                <p class="appoinment-content-text mt-0 mb-2">
                                                    Por favor cargue en formato PDF los siguientes documentos: 
                                                </p>
                                                <div class="col-12 mb-3">
                                                    <label for="documento_soporte" class="form-label my-0 font-size-11">Documento de identidad</label>
                                                    <small class="fst-italic text-danger font-size-11">Adjunte el documento de identidad en formato PDF (Máx. 2Mb)</small>
                                                    <input type="file" class="form-control form-control-sm" name="documento_soporte" id="documento_soporte" accept=".pdf, .PDF" required>
                                                    <!-- Feedback: nombre/peso + botón eliminar -->
                                                    <div id="documento_soporte_feedback" class="mb-2" aria-live="polite"></div>

                                                    <!-- Vista previa -->
                                                    <div id="documento_soporte_preview" class="border rounded-3 p-2 d-none"></div>
                                                </div>
                                                <?php foreach ($data['resultado_registros'] as $documentos): ?>
                                                    <?php if(date('Y-m-d') == date('Y-m-d', strtotime($documentos->hvad_registro_fecha))): ?>
                                                        <div class="col-md-12 my-1">
                                                            <fieldset class="border rounded-3 px-3 py-1">
                                                                <legend class="float-none w-auto px-2 font-size-12 fw-bold">
                                                                    <?php echo $documentos->hvad_nombre; ?>
                                                                </legend>
                                                                <embed src="<?php echo UPLOADS; ?><?php echo $documentos->hvad_ruta; ?>" type="application/pdf" width="100%" height="600px" />
                                                                
                                                            </fieldset>

                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
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
<script type="text/javascript">
    (function() {
        const input = document.getElementById('documento_soporte');
        if (!input) return;

        const feedback = document.getElementById('documento_soporte_feedback');
        const preview  = document.getElementById('documento_soporte_preview');

        const MAX_BYTES = 2 * 1024 * 1024; // 2MB
        let currentObjectURL = null;

        function bytesToSize(bytes) {
            if (bytes === 0) return '0 B';
            const k = 1024;
            const sizes = ['B', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function clearPreview() {
            if (currentObjectURL) {
            URL.revokeObjectURL(currentObjectURL);
            currentObjectURL = null;
            }
            preview.innerHTML = '';
            preview.classList.add('d-none');
        }

        function clearFeedback() {
            feedback.innerHTML = '';
        }

        function markValid() {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid', 'border', 'border-success');
        }

        function markInvalid() {
            input.classList.remove('is-valid', 'border-success');
            input.classList.add('is-invalid');
        }

        function resetInput() {
            input.value = '';
            input.classList.remove('is-valid', 'is-invalid', 'border', 'border-success');
            clearFeedback();
            clearPreview();
        }

        function renderFeedbackOk(name, sizeStr) {
            feedback.innerHTML = `
            <div class="alert alert-success d-flex justify-content-between align-items-center py-2 px-3 mb-2">
                <div>
                <strong>Archivo seleccionado:</strong> <span class="text-break">${name}</span>
                <span class="ms-2">(<strong>${sizeStr}</strong>)</span>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger" id="btnEliminarDoc">
                Eliminar
                </button>
            </div>
            `;

            const btnEliminar = document.getElementById('btnEliminarDoc');
            if (btnEliminar) btnEliminar.addEventListener('click', resetInput);
        }

        function renderFeedbackError(name, sizeStr, reason) {
            feedback.innerHTML = `
            <div class="alert alert-danger d-flex justify-content-between align-items-center py-2 px-3 mb-2">
                <div>
                <strong>Archivo:</strong> <span class="text-break">${name}</span>
                <span class="ms-2">(<strong>${sizeStr}</strong>)</span><br>
                <small>${reason}</small>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger" id="btnEliminarDoc">
                Eliminar
                </button>
            </div>
            `;

            const btnEliminar = document.getElementById('btnEliminarDoc');
            if (btnEliminar) btnEliminar.addEventListener('click', resetInput);
        }

        function renderPreview(file) {
            clearPreview();
            if (!file) return;

            const url = URL.createObjectURL(file);
            currentObjectURL = url;

            // Mostrar imagen
            if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = url;
            img.alt = 'Vista previa';
            img.className = 'img-fluid rounded';
            preview.appendChild(img);
            preview.classList.remove('d-none');
            return;
            }

            // Mostrar PDF
            if (file.type === 'application/pdf' || /\.pdf$/i.test(file.name)) {
            // Intento embebido con <embed>; algunos navegadores bloquean PDF: dejamos link fallback
            const embed = document.createElement('embed');
            embed.src = url + '#toolbar=1&navpanes=0';
            embed.type = 'application/pdf';
            embed.style.width = '100%';
            embed.style.height = '480px';
            embed.className = 'rounded mb-2';
            preview.appendChild(embed);

            // const link = document.createElement('a');
            // link.href = url;
            // link.target = '_blank';
            // link.rel = 'noopener';
            // link.textContent = 'Abrir PDF en una nueva pestaña';
            // preview.appendChild(link);

            preview.classList.remove('d-none');
            return;
            }

            // Otro tipo no soportado para previsualización
            const p = document.createElement('p');
            p.className = 'text-muted mb-0';
            p.textContent = 'Vista previa no disponible para este tipo de archivo.';
            preview.appendChild(p);
            preview.classList.remove('d-none');
        }

        input.addEventListener('change', function() {
            clearFeedback();
            clearPreview();

            const file = this.files && this.files[0] ? this.files[0] : null;
            if (!file) {
            resetInput();
            return;
            }

            const sizeStr = bytesToSize(file.size);

            // Validación tamaño
            if (file.size > MAX_BYTES) {
            markInvalid();
            renderFeedbackError(
                file.name,
                sizeStr,
                'El archivo supera el tamaño permitido (máx. 2 MB).'
            );
            alert('El archivo supera el tamaño permitido (máx. 2 MB).');
            return;
            }

            // Validación tipo vs accept (opcional; si quieres forzar)
            const accept = (this.getAttribute('accept') || '').replace(/\s/g, '');
            const allowed = accept ? accept.split(',') : [];
            const extOk = allowed.length
            ? allowed.some(rule => {
                if (rule.startsWith('.')) {
                    return file.name.toLowerCase().endsWith(rule.toLowerCase());
                }
                return file.type.toLowerCase() === rule.toLowerCase();
                })
            : true; // si no hay accept, permitimos

            if (!extOk) {
            markInvalid();
            renderFeedbackError(
                file.name,
                sizeStr,
                'El tipo de archivo no está permitido.'
            );
            alert('Tipo de archivo no permitido.');
            return;
            }

            // Todo OK
            markValid();
            renderFeedbackOk(file.name, sizeStr);
            renderPreview(file);
        });
    })();
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

                    if (resp.secciones.documentos==1) {
                        $('#btn_continuar').html('<a href="<?php echo URL; ?>seleccion-vinculacion/formulario-cierre<?php echo $data['path_add']; ?>" class="btn btn-dark login-btn">Continuar</a>');
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