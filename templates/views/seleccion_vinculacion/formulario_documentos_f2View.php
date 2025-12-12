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
                                    <p class="alert alert-corp p-1 font-size-11 my-0"><span class="fas fa-info-circle"></span> Información Aspirante</p>
                                    <p class="appoinment-content-text mt-0 my-0 py-1 px-2"><span class="fas fa-user-tie"></span> <?php echo $data['resultado_aspirante'][0]->hva_nombres.' '.$data['resultado_aspirante'][0]->hva_apellido_1.' '.$data['resultado_aspirante'][0]->hva_apellido_2; ?></p>
                                    <p class="appoinment-content-text mt-0 my-0 py-1 px-2"><span class="fas fa-address-card"></span> <?php echo $data['resultado_aspirante'][0]->hva_identificacion; ?></p>
                                    <!-- <p class="appoinment-content-text mt-0 my-0 py-1 px-2"><span class="fas fa-mobile"></span> <?php echo $data['resultado_aspirante'][0]->hva_celular; ?></p> -->
                                    <p class="appoinment-content-text mt-0 my-0 py-1 px-2"><span class="fas fa-envelope"></span> <?php echo $data['resultado_aspirante'][0]->hva_correo; ?></p>
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
                                            <hr class="my-3">
                                            <h3>Instrucciones para diligenciamiento de los documentos complementarios:</h3>
                                            <?php if($data['valida_token']): ?>
                                                <?php if($data['valida_oferta'] OR $_SESSION[APP_SESSION.'documentos_fase2']): ?>
                                                    <div class="col-md-12 appoinment-content-text mt-0 mb-2">
                                                        <ol>
                                                            <li class="my-2">Si cuentas con varios certificados de estudios o laborales deber unir los documentos en un solo PDF.</li>
                                                            <li class="my-2">Cuando vayas a adjuntar tus documentos corrobora que sean legibles y en formato PDF.</li>
                                                            <li class="my-2">Recuerda que no se reciben cuentas como (Nequi, Daviplata, lulobank, Bancolombia ahorro a la mano).</li>
                                                            <li class="my-2"><b>Nota: </b>Una vez cargados todos los documentos, debes enviar y finalizar el formulario.</li>
                                                        </ol>
                                                    </div>
                                                    <?php if($data['valida_oferta'] AND !$_SESSION[APP_SESSION.'documentos_fase2']): ?>
                                                        <div class="col-md-12 my-1">
                                                            <fieldset class="border rounded-3 px-3 py-1">
                                                                <legend class="float-none w-auto px-2 font-size-12 fw-bold">
                                                                    Hoja de vida personal
                                                                </legend>
                                                                <div class="col-12 mb-3">
                                                                    
                                                                    <small class="fst-italic text-danger font-size-11">Adjunte el documento en formato PDF (Máx. 20Mb)</small>
                                                                    <input type="file" class="form-control form-control-sm" name="hoja_vida_personal" id="hoja_vida_personal" accept=".pdf, .PDF" <?php echo ($data['control_hoja_vida_personal']) ? '' : 'required'; ?>>
                                                                </div>
                                                                <?php if($data['control_hoja_vida_personal']): ?>
                                                                    <?php foreach ($data['hoja_vida_personal'] as $documentos): ?>
                                                                        <p class="alert alert-success p-1 font-size-11">¡Documento cargado correctamente, si desea reemplazar el documento, seleccione nuevamente el archivo y haga clic en el botón <b>Guardar</b>!
                                                                            <?php if($documentos->hvad_ruta!=''): ?>
                                                                                <a class="btn btn-dark btn-sm font-size-10 btn-table" title="Ver" onclick="open_modal_documentos('<?php echo base64_encode($documentos->hvad_id); ?>');"><i class="fas fa-file-alt font-size-11"></i> Ver documento cargado</a>
                                                                            <?php endif; ?>
                                                                        </p>
                                                                    <?php endforeach; ?>
                                                                <?php else: ?>
                                                                    <p class="alert alert-warning p-1 font-size-11">¡Documento pendiente, por favor seleccione el documento correspondiente para continuar!</p>
                                                                <?php endif; ?>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-md-12 my-1">
                                                            <fieldset class="border rounded-3 px-3 py-1">
                                                                <legend class="float-none w-auto px-2 font-size-12 fw-bold">
                                                                    Certificaciones de estudios formales
                                                                </legend>
                                                                <div class="col-12 mb-3">
                                                                    
                                                                    <small class="fst-italic text-danger font-size-11">Adjunte el documento en formato PDF (Máx. 20Mb)</small>
                                                                    <input type="file" class="form-control form-control-sm" name="certificado_estudio_formal" id="certificado_estudio_formal" accept=".pdf, .PDF" <?php echo ($data['control_certificado_estudio_formal']) ? '' : 'required'; ?>>
                                                                </div>
                                                                <?php if($data['control_certificado_estudio_formal']): ?>
                                                                    <?php foreach ($data['certificado_estudio_formal'] as $documentos): ?>
                                                                        <p class="alert alert-success p-1 font-size-11">¡Documento cargado correctamente, si desea reemplazar el documento, seleccione nuevamente el archivo y haga clic en el botón <b>Guardar</b>!
                                                                            <?php if($documentos->hvad_ruta!=''): ?>
                                                                                <a class="btn btn-dark btn-sm font-size-10 btn-table" title="Ver" onclick="open_modal_documentos('<?php echo base64_encode($documentos->hvad_id); ?>');"><i class="fas fa-file-alt font-size-11"></i> Ver documento cargado</a>
                                                                            <?php endif; ?>
                                                                        </p>
                                                                    <?php endforeach; ?>
                                                                <?php else: ?>
                                                                    <p class="alert alert-warning p-1 font-size-11">¡Documento pendiente, por favor seleccione el documento correspondiente para continuar!</p>
                                                                <?php endif; ?>
                                                            </fieldset>
                                                        </div>

                                                        
                                                        

                                                        <div class="col-md-12 my-1">
                                                            <fieldset class="border rounded-3 px-3 py-1">
                                                                <legend class="float-none w-auto px-2 font-size-12 fw-bold">
                                                                    Certificaciones de estudios no formales
                                                                </legend>
                                                                <div class="col-12 mb-3">
                                                                    
                                                                    <small class="fst-italic text-danger font-size-11">Adjunte el documento en formato PDF (Máx. 20Mb)</small>
                                                                    <input type="file" class="form-control form-control-sm" name="certificado_estudio_no_formal" id="certificado_estudio_no_formal" accept=".pdf, .PDF" <?php echo ($data['control_certificado_estudio_no_formal']) ? '' : 'required'; ?>>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" value="Si" name="certificado_estudio_no_formal_na" id="certificado_estudio_no_formal_na" onclick="certificado_estudio();" <?php echo (isset($_POST["certificado_estudio_no_formal_na"]) AND $_POST["certificado_estudio_no_formal_na"]=='Si') ? 'checked' : ''; ?>>
                                                                        <label class="form-check-label font-size-12 fw-bold" for="certificado_estudio_no_formal_na">No aplica</label>
                                                                    </div>
                                                                </div>
                                                                <?php if(isset($_POST["certificado_estudio_no_formal_na"]) AND $_POST["certificado_estudio_no_formal_na"]=='Si'): ?>
                                                                    <p class="alert alert-success p-1 font-size-11">¡No aplica documento!</p>
                                                                <?php else: ?>
                                                                    <?php if($data['control_certificado_estudio_no_formal']): ?>
                                                                        <?php foreach ($data['certificado_estudio_no_formal'] as $documentos): ?>
                                                                            <p class="alert alert-success p-1 font-size-11">¡Documento cargado correctamente, si desea reemplazar el documento, seleccione nuevamente el archivo y haga clic en el botón <b>Guardar</b>!
                                                                                <?php if($documentos->hvad_ruta!=''): ?>
                                                                                    <a class="btn btn-dark btn-sm font-size-10 btn-table" title="Ver" onclick="open_modal_documentos('<?php echo base64_encode($documentos->hvad_id); ?>');"><i class="fas fa-file-alt font-size-11"></i> Ver documento cargado</a>
                                                                                <?php endif; ?>
                                                                            </p>
                                                                        <?php endforeach; ?>
                                                                    <?php else: ?>
                                                                        <p class="alert alert-warning p-1 font-size-11">¡Documento pendiente, por favor seleccione el documento correspondiente para continuar!</p>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            </fieldset>
                                                        </div>
                                                        
                                                        <?php if($data['primer_empleo']=='Si' OR $data['primer_empleo']==''): ?>
                                                            <div class="col-md-12 my-1">
                                                                <fieldset class="border rounded-3 px-3 py-1">
                                                                    <legend class="float-none w-auto px-2 font-size-12 fw-bold">
                                                                        Certificaciones laborales
                                                                    </legend>
                                                                    <div class="col-12 mb-3">
                                                                        
                                                                        <small class="fst-italic text-danger font-size-11">Adjunte el documento en formato PDF (Máx. 20Mb)</small>
                                                                        <input type="file" class="form-control form-control-sm" name="certificado_laboral" id="certificado_laboral" accept=".pdf, .PDF" <?php echo ($data['control_certificado_laboral']) ? '' : 'required'; ?>>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" value="Si" name="certificado_laboral_na" id="certificado_laboral_na" onclick="certificado_laboral_valida();" <?php echo (isset($_POST["certificado_laboral_na"]) AND $_POST["certificado_laboral_na"]=='Si') ? 'checked' : ''; ?>>
                                                                            <label class="form-check-label font-size-12 fw-bold" for="certificado_laboral_na">No aplica</label>
                                                                        </div>
                                                                    </div>
                                                                    <?php if(isset($_POST["certificado_laboral_na"]) AND $_POST["certificado_laboral_na"]=='Si'): ?>
                                                                        <p class="alert alert-success p-1 font-size-11">¡No aplica documento!</p>
                                                                    <?php else: ?>
                                                                        <?php if($data['control_certificado_laboral']): ?>
                                                                            <?php foreach ($data['certificado_laboral'] as $documentos): ?>
                                                                                <p class="alert alert-success p-1 font-size-11">¡Documento cargado correctamente, si desea reemplazar el documento, seleccione nuevamente el archivo y haga clic en el botón <b>Guardar</b>!
                                                                                <?php if($documentos->hvad_ruta!=''): ?>
                                                                                    <a class="btn btn-dark btn-sm font-size-10 btn-table" title="Ver" onclick="open_modal_documentos('<?php echo base64_encode($documentos->hvad_id); ?>');"><i class="fas fa-file-alt font-size-11"></i> Ver documento cargado</a>
                                                                                <?php endif; ?>
                                                                            </p>
                                                                            <?php endforeach; ?>
                                                                        <?php else: ?>
                                                                            <p class="alert alert-warning p-1 font-size-11">¡Documento pendiente, por favor seleccione el documento correspondiente para continuar!</p>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                </fieldset>
                                                            </div>
                                                        <?php endif; ?>

                                                        <div class="col-md-12 my-1">
                                                            <fieldset class="border rounded-3 px-3 py-1">
                                                                <legend class="float-none w-auto px-2 font-size-12 fw-bold">
                                                                    Certificado de afiliación a EPS vigente (No mayor a 2 meses)
                                                                </legend>
                                                                <div class="col-12 mb-3">
                                                                    
                                                                    <small class="fst-italic text-danger font-size-11">Adjunte el documento en formato PDF (Máx. 2Mb)</small>
                                                                    <input type="file" class="form-control form-control-sm" name="certificado_eps" id="certificado_eps" accept=".pdf, .PDF" <?php echo ($data['control_certificado_eps']) ? '' : 'required'; ?>>
                                                                </div>
                                                                <?php if($data['control_certificado_eps']): ?>
                                                                    <?php foreach ($data['certificado_eps'] as $documentos): ?>
                                                                        <p class="alert alert-success p-1 font-size-11">¡Documento cargado correctamente, si desea reemplazar el documento, seleccione nuevamente el archivo y haga clic en el botón <b>Guardar</b>!
                                                                            <?php if($documentos->hvad_ruta!=''): ?>
                                                                                <a class="btn btn-dark btn-sm font-size-10 btn-table" title="Ver" onclick="open_modal_documentos('<?php echo base64_encode($documentos->hvad_id); ?>');"><i class="fas fa-file-alt font-size-11"></i> Ver documento cargado</a>
                                                                            <?php endif; ?>
                                                                        </p>
                                                                    <?php endforeach; ?>
                                                                <?php else: ?>
                                                                    <p class="alert alert-warning p-1 font-size-11">¡Documento pendiente, por favor seleccione el documento correspondiente para continuar!</p>
                                                                <?php endif; ?>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-md-12 my-1">
                                                            <fieldset class="border rounded-3 px-3 py-1">
                                                                <legend class="float-none w-auto px-2 font-size-12 fw-bold">
                                                                    Certificado de afiliación a Fondo de Pensiones
                                                                </legend>
                                                                <div class="col-12 mb-3">
                                                                    
                                                                    <small class="fst-italic text-danger font-size-11">Adjunte el documento en formato PDF (Máx. 2Mb)</small>
                                                                    <input type="file" class="form-control form-control-sm" name="certificado_pension" id="certificado_pension" accept=".pdf, .PDF" <?php echo ($data['control_certificado_pension']) ? '' : 'required'; ?>>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" value="Si" name="certificado_pension_na" id="certificado_pension_na" onclick="certificado_pension_valida();" <?php echo (isset($_POST["certificado_pension_na"]) AND $_POST["certificado_pension_na"]=='Si') ? 'checked' : ''; ?>>
                                                                        <label class="form-check-label font-size-12 fw-bold" for="certificado_pension_na">No aplica</label>
                                                                    </div>
                                                                </div>
                                                                <?php if(isset($_POST["certificado_pension_na"]) AND $_POST["certificado_pension_na"]=='Si'): ?>
                                                                    <p class="alert alert-success p-1 font-size-11">¡No aplica documento!</p>
                                                                <?php else: ?>
                                                                    <?php if($data['control_certificado_pension']): ?>
                                                                        <?php foreach ($data['certificado_pension'] as $documentos): ?>
                                                                            <p class="alert alert-success p-1 font-size-11">¡Documento cargado correctamente, si desea reemplazar el documento, seleccione nuevamente el archivo y haga clic en el botón <b>Guardar</b>!
                                                                                <?php if($documentos->hvad_ruta!=''): ?>
                                                                                    <a class="btn btn-dark btn-sm font-size-10 btn-table" title="Ver" onclick="open_modal_documentos('<?php echo base64_encode($documentos->hvad_id); ?>');"><i class="fas fa-file-alt font-size-11"></i> Ver documento cargado</a>
                                                                                <?php endif; ?>
                                                                            </p>
                                                                        <?php endforeach; ?>
                                                                    <?php else: ?>
                                                                        <p class="alert alert-warning p-1 font-size-11">¡Documento pendiente, por favor seleccione el documento correspondiente para continuar!</p>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-md-12 my-1">
                                                            <fieldset class="border rounded-3 px-3 py-1">
                                                                <legend class="float-none w-auto px-2 font-size-12 fw-bold">
                                                                    Certificado de afiliación a Fondo de Cesantías
                                                                </legend>
                                                                <div class="col-12 mb-3">
                                                                    
                                                                    <small class="fst-italic text-danger font-size-11">Adjunte el documento en formato PDF (Máx. 2Mb)</small>
                                                                    <input type="file" class="form-control form-control-sm" name="certificado_cesantias" id="certificado_cesantias" accept=".pdf, .PDF" <?php echo ($data['control_certificado_cesantias']) ? '' : 'required'; ?>>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" value="Si" name="certificado_cesantias_na" id="certificado_cesantias_na" onclick="certificado_cesantias_valida();" <?php echo (isset($_POST["certificado_cesantias_na"]) AND $_POST["certificado_cesantias_na"]=='Si') ? 'checked' : ''; ?>>
                                                                        <label class="form-check-label font-size-12 fw-bold" for="certificado_cesantias_na">No aplica</label>
                                                                    </div>
                                                                </div>
                                                                <?php if(isset($_POST["certificado_cesantias_na"]) AND $_POST["certificado_cesantias_na"]=='Si'): ?>
                                                                    <p class="alert alert-success p-1 font-size-11">¡No aplica documento!</p>
                                                                <?php else: ?>
                                                                    <?php if($data['control_certificado_cesantias']): ?>
                                                                        <?php foreach ($data['certificado_cesantias'] as $documentos): ?>
                                                                            <p class="alert alert-success p-1 font-size-11">¡Documento cargado correctamente, si desea reemplazar el documento, seleccione nuevamente el archivo y haga clic en el botón <b>Guardar</b>!
                                                                                <?php if($documentos->hvad_ruta!=''): ?>
                                                                                    <a class="btn btn-dark btn-sm font-size-10 btn-table" title="Ver" onclick="open_modal_documentos('<?php echo base64_encode($documentos->hvad_id); ?>');"><i class="fas fa-file-alt font-size-11"></i> Ver documento cargado</a>
                                                                                <?php endif; ?>
                                                                            </p>
                                                                        <?php endforeach; ?>
                                                                    <?php else: ?>
                                                                        <p class="alert alert-warning p-1 font-size-11">¡Documento pendiente, por favor seleccione el documento correspondiente para continuar!</p>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            </fieldset>
                                                        </div>
                                                        
                                                        <div class="col-md-12 my-1">
                                                            <fieldset class="border rounded-3 px-3 py-1">
                                                                <legend class="float-none w-auto px-2 font-size-12 fw-bold">
                                                                    Certificación bancaria cuenta de nómina
                                                                </legend>
                                                                <div class="col-12 mb-3">
                                                                    
                                                                    <small class="fst-italic text-danger font-size-11">Adjunte el documento en formato PDF (Máx. 2Mb)</small>
                                                                    <input type="file" class="form-control form-control-sm" name="certificado_bancario" id="certificado_bancario" accept=".pdf, .PDF" <?php echo ($data['control_certificado_bancario']) ? '' : 'required'; ?>>
                                                                </div>
                                                                <?php if($data['control_certificado_bancario']): ?>
                                                                    <?php foreach ($data['certificado_bancario'] as $documentos): ?>
                                                                        <p class="alert alert-success p-1 font-size-11">¡Documento cargado correctamente, si desea reemplazar el documento, seleccione nuevamente el archivo y haga clic en el botón <b>Guardar</b>!
                                                                            <?php if($documentos->hvad_ruta!=''): ?>
                                                                                <a class="btn btn-dark btn-sm font-size-10 btn-table" title="Ver" onclick="open_modal_documentos('<?php echo base64_encode($documentos->hvad_id); ?>');"><i class="fas fa-file-alt font-size-11"></i> Ver documento cargado</a>
                                                                            <?php endif; ?>
                                                                        </p>
                                                                    <?php endforeach; ?>
                                                                <?php else: ?>
                                                                    <p class="alert alert-warning p-1 font-size-11">¡Documento pendiente, por favor seleccione el documento correspondiente para continuar!</p>
                                                                <?php endif; ?>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-md-12 my-1">
                                                            <fieldset class="border rounded-3 px-3 py-1">
                                                                <legend class="float-none w-auto px-2 font-size-12 fw-bold">
                                                                    Tarjeta profesional
                                                                </legend>
                                                                <div class="col-12 mb-3">
                                                                    
                                                                    <small class="fst-italic text-danger font-size-11">Adjunte el documento en formato PDF (Máx. 2Mb)</small>
                                                                    <input type="file" class="form-control form-control-sm" name="tarjeta_profesional" id="tarjeta_profesional" accept=".pdf, .PDF" <?php echo ($data['control_tarjeta_profesional']) ? '' : 'required'; ?>>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" value="Si" name="tarjeta_profesional_na" id="tarjeta_profesional_na" onclick="tarjeta_profesional_valida();" <?php echo (isset($_POST["tarjeta_profesional_na"]) AND $_POST["tarjeta_profesional_na"]=='Si') ? 'checked' : ''; ?>>
                                                                        <label class="form-check-label font-size-12 fw-bold" for="tarjeta_profesional_na">No aplica</label>
                                                                    </div>
                                                                </div>
                                                                <?php if(isset($_POST["tarjeta_profesional_na"]) AND $_POST["tarjeta_profesional_na"]=='Si'): ?>
                                                                    <p class="alert alert-success p-1 font-size-11">¡No aplica documento!</p>
                                                                <?php else: ?>
                                                                    <?php if($data['control_tarjeta_profesional']): ?>
                                                                        <?php foreach ($data['tarjeta_profesional'] as $documentos): ?>
                                                                            <p class="alert alert-success p-1 font-size-11">¡Documento cargado correctamente, si desea reemplazar el documento, seleccione nuevamente el archivo y haga clic en el botón <b>Guardar</b>!
                                                                                <?php if($documentos->hvad_ruta!=''): ?>
                                                                                    <a class="btn btn-dark btn-sm font-size-10 btn-table" title="Ver" onclick="open_modal_documentos('<?php echo base64_encode($documentos->hvad_id); ?>');"><i class="fas fa-file-alt font-size-11"></i> Ver documento cargado</a>
                                                                                <?php endif; ?>
                                                                            </p>
                                                                        <?php endforeach; ?>
                                                                    <?php else: ?>
                                                                        <p class="alert alert-warning p-1 font-size-11">¡Documento pendiente, por favor seleccione el documento correspondiente para continuar!</p>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-md-12 my-1">
                                                            <fieldset class="border rounded-3 px-3 py-1">
                                                                <legend class="float-none w-auto px-2 font-size-12 fw-bold">
                                                                    Fotografía fondo blanco
                                                                </legend>
                                                                <div class="col-12 mb-3">
                                                                    
                                                                    <small class="fst-italic text-danger font-size-11">Adjunte una fotografía en formato de imagen (PNG, JPG, JPEG) (Máx. 5Mb)</small>
                                                                    <input type="file" class="form-control form-control-sm" name="fotografia" id="fotografia" accept=".png, .PNG, .jpg, .JPG, .jpeg, .JPEG" <?php echo ($data['control_fotografia']) ? '' : 'required'; ?>>
                                                                </div>
                                                                <?php if($data['control_fotografia']): ?>
                                                                    <?php foreach ($data['fotografia'] as $documentos): ?>
                                                                        <p class="alert alert-success p-1 font-size-11">¡Documento cargado correctamente, si desea reemplazar el documento, seleccione nuevamente el archivo y haga clic en el botón <b>Guardar</b>!
                                                                            <?php if($documentos->hvad_ruta!=''): ?>
                                                                                <a class="btn btn-dark btn-sm font-size-10 btn-table" title="Ver" onclick="open_modal_documentos('<?php echo base64_encode($documentos->hvad_id); ?>');"><i class="fas fa-file-alt font-size-11"></i> Ver documento cargado</a>
                                                                            <?php endif; ?>
                                                                        </p>
                                                                    <?php endforeach; ?>
                                                                <?php else: ?>
                                                                    <p class="alert alert-warning p-1 font-size-11">¡Documento pendiente, por favor seleccione el documento correspondiente para continuar!</p>
                                                                <?php endif; ?>
                                                            </fieldset>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <div class="col-md-12 my-2">
                                                        <p class="alert alert-warning p-1">¡No hemos podido validar la oferta, por favor intente nuevamente!</p>
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
                                        <?php if($data['valida_token'] AND $data['valida_oferta']): ?>
                                            <button class="btn btn-success float-end ms-1" type="submit" name="form_guardar" id="guardar_registro_btn">Guardar</button>
                                            <?php if($data['valida_documentos']): ?>
                                                <button class="btn btn-warning float-end ms-1" type="submit" name="form_enviar_finalizar" id="guardar_registro_btn">Enviar y finalizar</button>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <a href="https://www.iqoutsourcing.com/" class="btn btn-dark login-btn mt-1">Finalizar</a>
                                        <?php endif; ?>
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
<!-- MODAL DETALLE -->
    <div class="modal fade" id="modal-detalle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Visor documentos</h5>
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
<?php require_once INCLUDES.'inc_footer_index.php'; ?>
<script type="text/javascript">
    function certificado_estudio(){
        var certificado_estudio_no_formal_na = document.getElementById("certificado_estudio_no_formal_na").checked;
        document.getElementById("certificado_estudio_no_formal").disabled=false;
        if (certificado_estudio_no_formal_na) {
            document.getElementById("certificado_estudio_no_formal").disabled=true;
        }
    }

    function certificado_laboral_valida(){
        var certificado_laboral_na = document.getElementById("certificado_laboral_na").checked;
        document.getElementById("certificado_laboral").disabled=false;
        if (certificado_laboral_na) {
            document.getElementById("certificado_laboral").disabled=true;
        }
    }

    function certificado_pension_valida(){
        var certificado_pension_na = document.getElementById("certificado_pension_na").checked;
        document.getElementById("certificado_pension").disabled=false;
        if (certificado_pension_na) {
            document.getElementById("certificado_pension").disabled=true;
        }
    }

    function certificado_cesantias_valida(){
        var certificado_cesantias_na = document.getElementById("certificado_cesantias_na").checked;
        document.getElementById("certificado_cesantias").disabled=false;
        if (certificado_cesantias_na) {
            document.getElementById("certificado_cesantias").disabled=true;
        }
    }

    function tarjeta_profesional_valida(){
        var tarjeta_profesional_na = document.getElementById("tarjeta_profesional_na").checked;
        document.getElementById("tarjeta_profesional").disabled=false;
        if (tarjeta_profesional_na) {
            document.getElementById("tarjeta_profesional").disabled=true;
        }
    }

    function open_modal_documentos(id_registro) {
        var myModal = new bootstrap.Modal(document.getElementById("modal-detalle"), {});
        $('.modal-body-detalle').load('<?php echo URL; ?>seleccion-vinculacion/hoja-vida-documentos-ver-public/'+id_registro,function(){
            myModal.show();
        });
    }

    certificado_estudio();
    certificado_laboral_valida();
    certificado_pension_valida();
    certificado_cesantias_valida();
    tarjeta_profesional_valida();
</script>