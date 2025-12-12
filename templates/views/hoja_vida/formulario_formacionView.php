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
                                                        <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-ranking-star"></span> Último Nivel Académico Alcanzado</p>
                                                    </div>
                                                    <!-- <div class="col-md-4 mb-3">
                                                        <label for="hvp_formacion_nivel_academico_culminado" class="form-label my-0 font-size-12">Selecciona el máximo nivel académico culminado</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_formacion_nivel_academico_culminado" id="hvp_formacion_nivel_academico_culminado" data-container="body" title="Seleccione" required>
                                                            <option value="BACHILLER" <?php echo ($data['resultado_registros_usuario'][0]->hvp_formacion_nivel_academico_culminado=='BACHILLER') ? 'selected' : ''; ?>>BACHILLER</option>
                                                            <option value="TÉCNICO" <?php echo ($data['resultado_registros_usuario'][0]->hvp_formacion_nivel_academico_culminado=='TÉCNICO') ? 'selected' : ''; ?>>TÉCNICO</option>
                                                            <option value="TECNÓLOGO" <?php echo ($data['resultado_registros_usuario'][0]->hvp_formacion_nivel_academico_culminado=='TECNÓLOGO') ? 'selected' : ''; ?>>TECNÓLOGO</option>
                                                            <option value="PROFESIONAL UNIVERSITARIO" <?php echo ($data['resultado_registros_usuario'][0]->hvp_formacion_nivel_academico_culminado=='PROFESIONAL UNIVERSITARIO') ? 'selected' : ''; ?>>PROFESIONAL UNIVERSITARIO</option>
                                                            <option value="ESPECIALISTA" <?php echo ($data['resultado_registros_usuario'][0]->hvp_formacion_nivel_academico_culminado=='ESPECIALISTA') ? 'selected' : ''; ?>>ESPECIALISTA</option>
                                                            <option value="MAGÍSTER/MBA" <?php echo ($data['resultado_registros_usuario'][0]->hvp_formacion_nivel_academico_culminado=='MAGÍSTER/MBA') ? 'selected' : ''; ?>>MAGÍSTER/MBA</option>
                                                            <option value="DOCTORADO" <?php echo ($data['resultado_registros_usuario'][0]->hvp_formacion_nivel_academico_culminado=='DOCTORADO') ? 'selected' : ''; ?>>DOCTORADO</option>
                                                        </select>
                                                    </div> -->
                                                    <div class="col-md-8 mb-3">
                                                        <label for="hvp_formacion_ultimo_certificado_enviado_rrhh" class="form-label my-0 font-size-12">Ya enviaste al área de Gestión humana el último certificado de tus estudios culminados?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_formacion_ultimo_certificado_enviado_rrhh" id="hvp_formacion_ultimo_certificado_enviado_rrhh" data-container="body" title="Seleccione" onchange="validar_ultimo_certificado();" required>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_formacion_ultimo_certificado_enviado_rrhh=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_formacion_ultimo_certificado_enviado_rrhh=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mb-3 d-none" id="div_documento_soporte_ultimo_estudio">
                                                        <?php if($data['resultado_registros_usuario'][0]->hvp_auxiliar_4==''): ?>
                                                            <p class="alert alert-warning p-1 font-size-11 mt-0 mb-2">Por favor cargue el certificado en formato PDF.</p>
                                                        <?php else: ?>
                                                            <a href="<?php echo UPLOADS.$data['resultado_registros_usuario'][0]->hvp_auxiliar_4; ?>" target="_blank">Ver documento Certificado Estudio <span class="fas fa-external-link"></span></a>
                                                            <p class="alert alert-warning p-1 font-size-11 mt-0 mb-2">Para actualizar el certificado, por favor cargue nuevamente la firma en formato de imagen.</p>
                                                        <?php endif; ?>
                                                        <label for="documento_soporte_ultimo_estudio" class="form-label my-0 font-size-11">Certificado</label>
                                                        <small class="fst-italic text-danger font-size-11">Adjunte el certificado en formato PDF (Máx. 5Mb)</small>
                                                        <input type="file" class="form-control form-control-sm" name="documento_soporte_ultimo_estudio" id="documento_soporte_ultimo_estudio" accept=".pdf, .PDF" <?php echo ($data['resultado_registros_usuario'][0]->hvp_auxiliar_4=='') ? 'required' : ''; ?> disabled>
                                                    </div>
                                                    <div class="col-md-8 mb-3">
                                                        <label for="hvp_formacion_ultimo_estudio_realizado_titulo" class="form-label my-0 font-size-12">Indica el nombre del título de tu último estudio realizado</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_formacion_ultimo_estudio_realizado_titulo" id="hvp_formacion_ultimo_estudio_realizado_titulo" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_formacion_ultimo_estudio_realizado_titulo; ?>" required autocomplete="off">
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="hvp_formacion_tarjeta_profesional" class="form-label my-0 font-size-12">Tienes tarjeta profesional?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_formacion_tarjeta_profesional" id="hvp_formacion_tarjeta_profesional" data-container="body" title="Seleccione" onchange="validar_tarjeta_profesional();" required>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_formacion_tarjeta_profesional=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_formacion_tarjeta_profesional=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mb-3 d-none" id="div_documento_soporte_tarjeta_profesional">
                                                        <?php if($data['resultado_registros_usuario'][0]->hvp_auxiliar_5==''): ?>
                                                            <p class="alert alert-warning p-1 font-size-11 mt-0 mb-2">Por favor cargue la tarjeta profesional en formato PDF.</p>
                                                        <?php else: ?>
                                                            <a href="<?php echo UPLOADS.$data['resultado_registros_usuario'][0]->hvp_auxiliar_5; ?>" target="_blank">Ver documento Tarjeta Profesional <span class="fas fa-external-link"></span></a>
                                                            <p class="alert alert-warning p-1 font-size-11 mt-0 mb-2">Para actualizar la tarjeta profesional, por favor cargue nuevamente la firma en formato de imagen.</p>
                                                        <?php endif; ?>
                                                        <label for="documento_soporte_tarjeta_profesional" class="form-label my-0 font-size-11">Tarjeta Profesional</label>
                                                        <small class="fst-italic text-danger font-size-11">Adjunte la tarjeta profesional en formato PDF (Máx. 5Mb)</small>
                                                        <input type="file" class="form-control form-control-sm" name="documento_soporte_tarjeta_profesional" id="documento_soporte_tarjeta_profesional" accept=".pdf, .PDF" <?php echo ($data['resultado_registros_usuario'][0]->hvp_auxiliar_5=='') ? 'required' : ''; ?> disabled>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_formacion_estudios_curso" class="form-label my-0 font-size-12">¿Estás estudiando actualmente?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_formacion_estudios_curso" id="hvp_formacion_estudios_curso" data-container="body" title="Seleccione" onchange="valida_curso();" required>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_formacion_estudios_curso=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_formacion_estudios_curso=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-9 mb-3 d-none" id="div_hvp_formacion_estudios_curso_titulo">
                                                        <label for="hvp_formacion_estudios_curso_titulo" class="form-label my-0 font-size-12">Nombre de los Estudios en curso</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_formacion_estudios_curso_titulo" id="hvp_formacion_estudios_curso_titulo" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_formacion_estudios_curso_titulo; ?>" required autocomplete="off" disabled>
                                                    </div>
                                                    <div class="col-md-5 mb-3 d-none" id="div_hvp_formacion_estudios_curso_nivel">
                                                        <label for="hvp_formacion_estudios_curso_nivel" class="form-label my-0 font-size-12">¿Cuál es el nivel académico del estudio que estas cursando?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_formacion_estudios_curso_nivel" id="hvp_formacion_estudios_curso_nivel" data-container="body" title="Seleccione" required disabled>
                                                            <option value="Bachillerato" <?php echo ($data['resultado_registros_usuario'][0]->hvp_formacion_estudios_curso_nivel=='Bachillerato') ? 'selected' : ''; ?>>Bachillerato</option>
                                                            <option value="Técnico" <?php echo ($data['resultado_registros_usuario'][0]->hvp_formacion_estudios_curso_nivel=='Técnico') ? 'selected' : ''; ?>>Técnico</option>
                                                            <option value="Tecnólogo" <?php echo ($data['resultado_registros_usuario'][0]->hvp_formacion_estudios_curso_nivel=='Tecnólogo') ? 'selected' : ''; ?>>Tecnólogo</option>
                                                            <option value="Profesional" <?php echo ($data['resultado_registros_usuario'][0]->hvp_formacion_estudios_curso_nivel=='Profesional') ? 'selected' : ''; ?>>Profesional</option>
                                                            <option value="Posgrado" <?php echo ($data['resultado_registros_usuario'][0]->hvp_formacion_estudios_curso_nivel=='Posgrado') ? 'selected' : ''; ?>>Posgrado</option>
                                                            <option value="Ninguno" <?php echo ($data['resultado_registros_usuario'][0]->hvp_formacion_estudios_curso_nivel=='Ninguno') ? 'selected' : ''; ?>>Ninguno</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-7 mb-3 d-none" id="div_hvp_formacion_estudios_curso_establecimiento">
                                                        <label for="hvp_formacion_estudios_curso_establecimiento" class="form-label my-0 font-size-12">Institución educativa de los estudios en curso</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_formacion_estudios_curso_establecimiento" id="hvp_formacion_estudios_curso_establecimiento" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_formacion_estudios_curso_establecimiento; ?>" required autocomplete="off" disabled>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-graduation-cap"></span> Estudios en Curso</p>
                                                    </div>
                                                    <p class="appoinment-content-text mt-0 mb-2">En este apartado deberás incluir sólo los estudios en curso.</p>
                                                    <!-- <hr> -->
                                                    <!-- <p class="appoinment-content-text mt-0 mb-2">Estudios Culminados Registrados</p> -->
                                                    <div class="col-md-12 mb-2" id="lista_registros_curso"></div>
                                                    <div class="col-md-12 mb-2">
                                                        <a name="form_guardar" class="btn btn-warning login-btn" onclick="open_modal_curso();">Agregar estudio</a>
                                                        <!-- onclick="estudio_add();" -->
                                                    </div>

                                                    <div class="col-md-12">
                                                        <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-graduation-cap"></span> Estudios Culminados</p>
                                                    </div>
                                                    <p class="appoinment-content-text mt-0 mb-2">En este apartado deberás incluir sólo los estudios culminados de los que cuentes con diplomas o actas de grado <b>y que no hayas incluido en tu proceso de contratación</b>.</p>
                                                    <!-- <hr> -->
                                                    <!-- <p class="appoinment-content-text mt-0 mb-2">Estudios Culminados Registrados</p> -->
                                                    <div class="col-md-12 mb-2" id="lista_registros"></div>
                                                    <div class="col-md-12 mb-2">
                                                        <a name="form_guardar" class="btn btn-warning login-btn" onclick="open_modal_culminado();">Agregar estudio</a>
                                                        <!-- onclick="estudio_add();" -->
                                                    </div>
                                                    


                                                    <div class="col-md-12">
                                                        <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-lightbulb"></span> Información de Habilidades</p>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="hvp_habilidades_nivel_ingles" class="form-label my-0 font-size-12">¿Nivel de inglés conversacional?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_habilidades_nivel_ingles" id="hvp_habilidades_nivel_ingles" data-container="body" title="Seleccione" required>
                                                            <option value="A0: Principiante" <?php echo ($data['resultado_registros_usuario'][0]->hvp_habilidades_nivel_ingles=='A0: Principiante') ? 'selected' : ''; ?>>A0: Principiante</option>
                                                            <option value="A1 -A2; Básico" <?php echo ($data['resultado_registros_usuario'][0]->hvp_habilidades_nivel_ingles=='A1 -A2; Básico') ? 'selected' : ''; ?>>A1 -A2; Básico</option>
                                                            <option value="A2-B1: Pre-intermedio" <?php echo ($data['resultado_registros_usuario'][0]->hvp_habilidades_nivel_ingles=='A2-B1: Pre-intermedio') ? 'selected' : ''; ?>>A2-B1: Pre-intermedio</option>
                                                            <option value="B1: Intermedio" <?php echo ($data['resultado_registros_usuario'][0]->hvp_habilidades_nivel_ingles=='B1: Intermedio') ? 'selected' : ''; ?>>B1: Intermedio</option>
                                                            <option value="B2: Intermedio-Alto" <?php echo ($data['resultado_registros_usuario'][0]->hvp_habilidades_nivel_ingles=='B2: Intermedio-Alto') ? 'selected' : ''; ?>>B2: Intermedio-Alto</option>
                                                            <option value="C1-C2: Avanzado" <?php echo ($data['resultado_registros_usuario'][0]->hvp_habilidades_nivel_ingles=='C1-C2: Avanzado') ? 'selected' : ''; ?>>C1-C2: Avanzado</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="hvp_habilidades_nivel_excel" class="form-label my-0 font-size-12">¿Nivel de manejo de hojas de cálculo?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_habilidades_nivel_excel" id="hvp_habilidades_nivel_excel" data-container="body" title="Seleccione" required>
                                                            <option value="Básico" <?php echo ($data['resultado_registros_usuario'][0]->hvp_habilidades_nivel_excel=='Básico') ? 'selected' : ''; ?>>Básico</option>
                                                            <option value="Intermedio" <?php echo ($data['resultado_registros_usuario'][0]->hvp_habilidades_nivel_excel=='Intermedio') ? 'selected' : ''; ?>>Intermedio</option>
                                                            <option value="Avanzado" <?php echo ($data['resultado_registros_usuario'][0]->hvp_habilidades_nivel_excel=='Avanzado') ? 'selected' : ''; ?>>Avanzado</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="hvp_habilidades_nivel_google_ws" class="form-label my-0 font-size-12">Nivel de manejo de google WS (Workspace)</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_habilidades_nivel_google_ws" id="hvp_habilidades_nivel_google_ws" data-container="body" title="Seleccione" required>
                                                            <option value="Nulo" <?php echo ($data['resultado_registros_usuario'][0]->hvp_habilidades_nivel_google_ws=='Nulo') ? 'selected' : ''; ?>>Nulo</option>
                                                            <option value="Básico" <?php echo ($data['resultado_registros_usuario'][0]->hvp_habilidades_nivel_google_ws=='Básico') ? 'selected' : ''; ?>>Básico</option>
                                                            <option value="Intermedio" <?php echo ($data['resultado_registros_usuario'][0]->hvp_habilidades_nivel_google_ws=='Intermedio') ? 'selected' : ''; ?>>Intermedio</option>
                                                            <option value="Avanzado" <?php echo ($data['resultado_registros_usuario'][0]->hvp_habilidades_nivel_google_ws=='Avanzado') ? 'selected' : ''; ?>>Avanzado</option>
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                            <?php echo Flasher::flash(); ?>
                                            <div class="col-md-12 text-end">
                                                <span id="btn_enviar">
                                                    <a href="<?php echo URL; ?>hoja-vida/formulario-intereses-habitos/<?php echo base64_encode('intereses-habitos'); ?>" class="btn btn-warning login-btn">Regresar</a>
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
<!-- MODAL DETALLE -->
    <div class="modal fade" id="modal-detalle-culminado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-fullscreen-lg-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Agregar Estudio Culminado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body-detalle-culminado p-6">
                <div class="row d-lg-flex justify-content-between align-items-center ">
                    <div class="col-md-12 mb-3">
                        <label for="hvaet_nivel" class="form-label my-0 font-size-12">Nivel</label>
                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvaet_nivel" id="hvaet_nivel" data-container="body" title="Seleccione">
                            <option value="Diplomado">Diplomado</option>
                            <option value="Certificación">Certificación</option>
                            <option value="Bachiller">Bachiller</option>
                            <option value="Técnico">Técnico</option>
                            <option value="Tecnólogo">Tecnólogo</option>
                            <option value="Pregrado">Pregrado</option>
                            <option value="Especialización">Especialización</option>
                            <option value="Maestría">Maestría</option>
                            <option value="Doctorado">Doctorado</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="hvaet_establecimiento" class="form-label my-0 font-size-12">Institución educativa</label>
                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaet_establecimiento" id="hvaet_establecimiento" value="" autocomplete="off">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="hvaet_titulo" class="form-label my-0 font-size-12">Título</label>
                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaet_titulo" id="hvaet_titulo" value="" autocomplete="off">
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="hvaet_ciudad" class="form-label my-0 font-size-12">Ciudad</label>
                            <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvaet_ciudad" id="hvaet_ciudad" data-live-search="true" data-container="body" title="Seleccione">
                                <option value="00001" class="font-size-11">INTERNACIONAL/EXTERIOR</option>
                                <?php foreach ($data['resultado_registros_ciudad'] as $registro): ?>
                                    <option value="<?php echo $registro->ciu_codigo; ?>" class="font-size-11"><?php echo $registro->ciu_municipio.', '.$registro->ciu_departamento; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="hvaet_fecha_inicio" class="form-label my-0 font-size-12">Fecha inicio</label>
                        <input type="date" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaet_fecha_inicio" id="hvaet_fecha_inicio" value="" max="<?php echo date('Y-m-d'); ?>" autocomplete="off">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="hvaet_fecha_terminacion" class="form-label my-0 font-size-12">Fecha terminación</label>
                        <input type="date" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaet_fecha_terminacion" id="hvaet_fecha_terminacion" value="" max="<?php echo date('Y-m-d'); ?>" onchange="valida_fecha_terminado();" onkeyup="valida_fecha_terminado();" autocomplete="off">
                    </div> 
                    <div class="col-md-12 mb-3">
                            <label for="hvaet_modalidad" class="form-label my-0 font-size-12">Modalidad</label>
                            <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvaet_modalidad" id="hvaet_modalidad" data-container="body" title="Seleccione">
                                <option value="Presencial">Presencial</option>
                                <option value="Virtual">Virtual</option>
                                <option value="Híbrida">Híbrida</option>
                            </select>
                        </div>
                    <div class="col-md-12 mb-3">
                        <label for="hvaet_tarjeta_profesional" class="form-label my-0 font-size-12">Tarjeta profesional</label>
                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvaet_tarjeta_profesional" id="hvaet_tarjeta_profesional" data-container="body" title="Seleccione">
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                            <option value="No aplica">No aplica</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3" id="resultado_estudio_culminado">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark py-2 px-2" id="btn_estudio_culminado_cerrar" data-bs-dismiss="modal" onclick="estudio_culminado_list();">Cerrar</button>
                <button type="button" class="btn btn-success py-2 px-2" id="btn_estudio_culminado_guardar" onclick="estudio_culminado_add();">Guardar</button>
            </div>
        </div>
        </div>
    </div>

<!-- MODAL DETALLE -->
    <div class="modal fade" id="modal-detalle-curso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-fullscreen-lg-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Agregar Estudio en Curso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body-detalle-curso p-6">
                <div class="row d-lg-flex justify-content-between align-items-center ">
                    <div class="col-md-12 mb-3">
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
                    <div class="col-md-12 mb-3">
                        <label for="hvaec_establecimiento" class="form-label my-0 font-size-12">Institución educativa</label>
                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaec_establecimiento" id="hvaec_establecimiento" value="" autocomplete="off">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="hvaec_titulo" class="form-label my-0 font-size-12">Título a obtener</label>
                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaec_titulo" id="hvaec_titulo" value="" autocomplete="off">
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="hvaec_ciudad" class="form-label my-0 font-size-12">Ciudad</label>
                            <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvaec_ciudad" id="hvaec_ciudad" data-live-search="true" data-container="body" title="Seleccione">
                                <?php foreach ($data['resultado_registros_ciudad'] as $registro): ?>
                                    <option value="<?php echo $registro->ciu_codigo; ?>" class="font-size-11"><?php echo $registro->ciu_municipio.', '.$registro->ciu_departamento; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="hvaec_horario" class="form-label my-0 font-size-12">Horario</label>
                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvaec_horario" id="hvaec_horario" data-container="body" title="Seleccione">
                            <option value="Diurno">Diurno</option>
                            <option value="Nocturno">Nocturno</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="hvaec_modalidad" class="form-label my-0 font-size-12">Modalidad</label>
                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvaec_modalidad" id="hvaec_modalidad" data-container="body" title="Seleccione">
                            <option value="Presencial">Presencial</option>
                            <option value="Virtual">Virtual</option>
                            <option value="Híbrida">Híbrida</option>
                        </select>
                    </div> 
                    <div class="col-md-12 mb-3">
                        <label for="hvaec_fecha_terminacion" class="form-label my-0 font-size-12">Fecha de terminación proyectada</label>
                        <input type="date" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvaec_fecha_terminacion" id="hvaec_fecha_terminacion" value="" autocomplete="off">
                    </div>
                    <div class="col-md-12 mb-3" id="resultado_estudio_curso">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark py-2 px-2" id="btn_estudio_curso_cerrar" data-bs-dismiss="modal" onclick="estudio_curso_list();">Cerrar</button>
                <button type="button" class="btn btn-success py-2 px-2" id="btn_estudio_curso_guardar" onclick="estudio_curso_add();">Guardar</button>
            </div>
        </div>
        </div>
    </div>
<?php require_once INCLUDES.'inc_footer.php'; ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#hvp_formacion_ultimo_estudio_realizado_titulo").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_formacion_ultimo_estudio_realizado_titulo").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_formacion_estudios_curso_titulo").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_formacion_estudios_curso_titulo").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_formacion_estudios_curso_establecimiento").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_formacion_estudios_curso_establecimiento").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
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

    function valida_curso() {
        $("#div_hvp_formacion_estudios_curso_titulo").removeClass('d-block').addClass('d-none');
        $("#div_hvp_formacion_estudios_curso_nivel").removeClass('d-block').addClass('d-none');
        $("#div_hvp_formacion_estudios_curso_establecimiento").removeClass('d-block').addClass('d-none');

        document.getElementById('hvp_formacion_estudios_curso_titulo').disabled=true;
        document.getElementById('hvp_formacion_estudios_curso_nivel').disabled=true;
        document.getElementById('hvp_formacion_estudios_curso_establecimiento').disabled=true;

        var hvp_formacion_estudios_curso = document.getElementById("hvp_formacion_estudios_curso").value;

        if (hvp_formacion_estudios_curso!="" && (hvp_formacion_estudios_curso=="Si")) {
            $("#div_hvp_formacion_estudios_curso_titulo").removeClass('d-none').addClass('d-block');
            $("#div_hvp_formacion_estudios_curso_nivel").removeClass('d-none').addClass('d-block');
            $("#div_hvp_formacion_estudios_curso_establecimiento").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_formacion_estudios_curso_titulo').disabled=false;
            document.getElementById('hvp_formacion_estudios_curso_nivel').disabled=false;
            document.getElementById('hvp_formacion_estudios_curso_establecimiento').disabled=false;
            $('#hvp_formacion_estudios_curso_nivel').selectpicker('destroy');
            $('#hvp_formacion_estudios_curso_nivel').selectpicker();
        }
    }

    function validar_ultimo_certificado() {
        $("#div_documento_soporte_ultimo_estudio").removeClass('d-block').addClass('d-none');

        document.getElementById('documento_soporte_ultimo_estudio').disabled=true;

        var hvp_formacion_ultimo_certificado_enviado_rrhh = document.getElementById("hvp_formacion_ultimo_certificado_enviado_rrhh").value;

        if (hvp_formacion_ultimo_certificado_enviado_rrhh!="" && (hvp_formacion_ultimo_certificado_enviado_rrhh=="No")) {
            $("#div_documento_soporte_ultimo_estudio").removeClass('d-none').addClass('d-block');
            document.getElementById('documento_soporte_ultimo_estudio').disabled=false;
            
        }
    }

    function validar_tarjeta_profesional() {
        $("#div_documento_soporte_tarjeta_profesional").removeClass('d-block').addClass('d-none');

        document.getElementById('documento_soporte_tarjeta_profesional').disabled=true;

        var hvp_formacion_tarjeta_profesional = document.getElementById("hvp_formacion_tarjeta_profesional").value;
        console.log(hvp_formacion_tarjeta_profesional);
        if (hvp_formacion_tarjeta_profesional!="" && (hvp_formacion_tarjeta_profesional=="Si")) {
            $("#div_documento_soporte_tarjeta_profesional").removeClass('d-none').addClass('d-block');
            document.getElementById('documento_soporte_tarjeta_profesional').disabled=false;
            
        }
    }

    <?php if($data['resultado_registros_usuario'][0]->hvp_formacion_ultimo_certificado_enviado_rrhh!=''): ?>
        valida_curso();
        validar_ultimo_certificado();
        validar_tarjeta_profesional();
    <?php endif; ?>
</script>
<script type="text/javascript">
    function open_modal_culminado() {
        var myModal = new bootstrap.Modal(document.getElementById("modal-detalle-culminado"), {});
        myModal.show();
        // $('.modal-body-detalle').load('<?php echo URL; ?>hoja-vida/formulario-formacion-add',function(){

        // });
    }

    $('#hvaet_ciudad').selectpicker({ container: '#modal' });
    $('#hvaec_ciudad').selectpicker({ container: '#modal' });

    function open_modal_curso() {
        var myModal = new bootstrap.Modal(document.getElementById("modal-detalle-curso"), {});
        myModal.show();
        // $('.modal-body-detalle').load('<?php echo URL; ?>hoja-vida/formulario-formacion-add',function(){

        // });
    }
</script>
<script type="text/javascript">
    function estudio_curso_add() {
        var id_aspirante = '<?php echo $data['id_aspirante']; ?>';
        var hvaec_nivel = document.getElementById("hvaec_nivel").value;
        var hvaec_establecimiento = document.getElementById("hvaec_establecimiento").value;
        var hvaec_titulo = document.getElementById("hvaec_titulo").value;
        var hvaec_ciudad = document.getElementById("hvaec_ciudad").value;
        var hvaec_horario = document.getElementById("hvaec_horario").value;
        var hvaec_modalidad = document.getElementById("hvaec_modalidad").value;
        var hvaec_fecha_terminacion = document.getElementById("hvaec_fecha_terminacion").value;

        var formData = new FormData();
        formData.append("id_aspirante", id_aspirante);
        formData.append("hvaec_nivel", hvaec_nivel);
        formData.append("hvaec_establecimiento", hvaec_establecimiento);
        formData.append("hvaec_titulo", hvaec_titulo);
        formData.append("hvaec_ciudad", hvaec_ciudad);
        formData.append("hvaec_horario", hvaec_horario);
        formData.append("hvaec_modalidad", hvaec_modalidad);
        formData.append("hvaec_fecha_terminacion", hvaec_fecha_terminacion);

        if (id_aspirante!="" && hvaec_nivel!="" && hvaec_establecimiento!="" && hvaec_titulo!="" && hvaec_ciudad!="" && hvaec_horario!="" && hvaec_modalidad!="" && hvaec_fecha_terminacion!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>hoja-vida/formulario-estudio-curso-registro',
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
                    document.getElementById("btn_estudio_curso_cerrar").disabled=true;
                    document.getElementById("btn_estudio_curso_guardar").disabled=true;
                },
                complete:function(data){
                    document.getElementById("hvaec_nivel").disabled=false;
                    document.getElementById("hvaec_establecimiento").disabled=false;
                    document.getElementById("hvaec_titulo").disabled=false;
                    document.getElementById("hvaec_ciudad").disabled=false;
                    document.getElementById("hvaec_horario").disabled=false;
                    document.getElementById("hvaec_modalidad").disabled=false;
                    document.getElementById("hvaec_fecha_terminacion").disabled=false;
                    document.getElementById("btn_estudio_curso_cerrar").disabled=false;
                    document.getElementById("btn_estudio_curso_guardar").disabled=false;
                    
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
                        document.getElementById("hvaec_nivel").disabled=false;
                        document.getElementById("hvaec_establecimiento").disabled=false;
                        document.getElementById("hvaec_titulo").disabled=false;
                        document.getElementById("hvaec_ciudad").disabled=false;
                        document.getElementById("hvaec_horario").disabled=false;
                        document.getElementById("hvaec_modalidad").disabled=false;
                        document.getElementById("hvaec_fecha_terminacion").disabled=false;
                        $('#btn_estudio_curso_guardar').removeClass('d-block').addClass('d-none');
                        $('#resultado_estudio_curso').html('<p class="alert alert-success p-1 m-0 font-size-11">¡Estudio agregado exitosamente!</p>');
                        // estudio_curso_list();
                    } else {
                        $('#resultado_estudio_curso').html('<p class="alert alert-warning p-1 m-0 font-size-11">¡Problemas al agregar el estudio!</p>');
                        
                    }
                    // estudio_list();
                },
                error: function(data){
                    alert("Problemas al tratar de crear el registro, por favor verifique e intente nuevamente");
                }
            });
        } else {
            alert("¡Todos los campos son obligatorios, por favor verifique e intente nuevamente!");
        }
    }

    function estudio_curso_list() {
        var id_aspirante = '<?php echo $data['id_aspirante']; ?>';

        var formData = new FormData();
        formData.append("id_aspirante", id_aspirante);

        if (id_aspirante!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>hoja-vida/formulario-estudio-curso-listar',
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
                        $('#lista_registros_curso').html(resp.resultado_lista);
                        document.getElementById("hvaec_nivel").disabled=false;
                        document.getElementById("hvaec_establecimiento").disabled=false;
                        document.getElementById("hvaec_titulo").disabled=false;
                        document.getElementById("hvaec_ciudad").disabled=false;
                        document.getElementById("hvaec_horario").disabled=false;
                        document.getElementById("hvaec_modalidad").disabled=false;
                        document.getElementById("hvaec_fecha_terminacion").disabled=false;
                        document.getElementById("btn_estudio_curso_cerrar").disabled=false;
                        document.getElementById("btn_estudio_curso_guardar").disabled=false;
                        $('#btn_estudio_curso_guardar').removeClass('d-none').addClass('d-block');
                        $('#resultado_estudio_curso').html('');
                        progreso();
                    } else {
                        $('#lista_registros_curso').html('<p class="alert alert-warning p-1 font-size-11">¡No se encontraron estudios en curso registrados!</p>');
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

    function estudio_curso_del(id_registro) {
        var id_aspirante = '<?php echo $data['id_aspirante']; ?>';

        var formData = new FormData();
        formData.append("id_aspirante", id_aspirante);
        formData.append("id_registro", id_registro);

        if (id_aspirante!="" && id_registro!="") {
            if (confirm("¿Está seguro de eliminar el registro?")) {
                // El usuario hizo clic en "Aceptar"
                $.ajax({
                    type: 'POST',
                    url: '<?php echo URL; ?>hoja-vida/formulario-estudio-curso-eliminar',
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

                        // if (resp.resultado_valor) {
                        //     $('#lista_registros').html(resp.resultado_lista);
                        // } else {
                        //     $('#lista_registros').html('');
                        // }
                        estudio_curso_list();
                    },
                    error: function(data){
                        alert("Problemas al tratar de crear el registro, por favor verifique e intente nuevamente");
                    }
                });
            } else {
                // El usuario hizo clic en "Cancelar"
                return false;
            }
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

    estudio_curso_list();

    function estudio_culminado_add() {
        var id_aspirante = '<?php echo $data['id_aspirante']; ?>';
        var hvaet_nivel = document.getElementById("hvaet_nivel").value;
        var hvaet_establecimiento = document.getElementById("hvaet_establecimiento").value;
        var hvaet_titulo = document.getElementById("hvaet_titulo").value;
        var hvaet_ciudad = document.getElementById("hvaet_ciudad").value;
        var hvaet_fecha_inicio = document.getElementById("hvaet_fecha_inicio").value;
        var hvaet_fecha_terminacion = document.getElementById("hvaet_fecha_terminacion").value;
        var hvaet_modalidad = document.getElementById("hvaet_modalidad").value;
        var hvaet_tarjeta_profesional = document.getElementById("hvaet_tarjeta_profesional").value;

        var formData = new FormData();
        formData.append("id_aspirante", id_aspirante);
        formData.append("hvaet_nivel", hvaet_nivel);
        formData.append("hvaet_establecimiento", hvaet_establecimiento);
        formData.append("hvaet_titulo", hvaet_titulo);
        formData.append("hvaet_ciudad", hvaet_ciudad);
        formData.append("hvaet_fecha_inicio", hvaet_fecha_inicio);
        formData.append("hvaet_fecha_terminacion", hvaet_fecha_terminacion);
        formData.append("hvaet_modalidad", hvaet_modalidad);
        formData.append("hvaet_tarjeta_profesional", hvaet_tarjeta_profesional);

        if (id_aspirante!="" && hvaet_nivel!="" && hvaet_establecimiento!="" && hvaet_titulo!="" && hvaet_ciudad!="" && hvaet_fecha_inicio!="" && hvaet_fecha_terminacion!="" && hvaet_tarjeta_profesional!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>hoja-vida/formulario-estudio-culminado-registro',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    document.getElementById("hvaet_nivel").disabled=true;
                    document.getElementById("hvaet_establecimiento").disabled=true;
                    document.getElementById("hvaet_titulo").disabled=true;
                    document.getElementById("hvaet_ciudad").disabled=true;
                    document.getElementById("hvaet_fecha_inicio").disabled=true;
                    document.getElementById("hvaet_fecha_terminacion").disabled=true;
                    document.getElementById("hvaet_modalidad").disabled=true;
                    document.getElementById("hvaet_tarjeta_profesional").disabled=true;
                },
                complete:function(data){
                    document.getElementById("hvaet_nivel").disabled=false;
                    document.getElementById("hvaet_establecimiento").disabled=false;
                    document.getElementById("hvaet_titulo").disabled=false;
                    document.getElementById("hvaet_ciudad").disabled=false;
                    document.getElementById("hvaet_fecha_inicio").disabled=false;
                    document.getElementById("hvaet_fecha_terminacion").disabled=false;
                    document.getElementById("hvaet_modalidad").disabled=false;
                    document.getElementById("hvaet_tarjeta_profesional").disabled=false;
                    
                },
                success: function(data){
                    var resp = $.parseJSON(data);
                    if (resp.resultado_valor) {
                        $('#hvaet_nivel').selectpicker('val', '');
                        document.getElementById("hvaet_establecimiento").value='';
                        document.getElementById("hvaet_titulo").value='';
                        $('#hvaet_ciudad').selectpicker('val', '');
                        document.getElementById("hvaet_fecha_inicio").value='';
                        document.getElementById("hvaet_fecha_terminacion").value='';
                        $('#hvaet_modalidad').selectpicker('val', '');
                        $('#hvaet_tarjeta_profesional').selectpicker('val', '');
                        document.getElementById("hvaet_nivel").disabled=false;
                        document.getElementById("hvaet_establecimiento").disabled=false;
                        document.getElementById("hvaet_titulo").disabled=false;
                        document.getElementById("hvaet_ciudad").disabled=false;
                        document.getElementById("hvaet_fecha_inicio").disabled=false;
                        document.getElementById("hvaet_fecha_terminacion").disabled=false;
                        document.getElementById("hvaet_modalidad").disabled=false;
                        document.getElementById("hvaet_tarjeta_profesional").disabled=false;
                        $('#btn_estudio_culminado_guardar').removeClass('d-block').addClass('d-none');
                        $('#resultado_estudio_culminado').html('<p class="alert alert-success p-1 m-0 font-size-11">¡Estudio agregado exitosamente!</p>');
                    } else {
                        $('#resultado_estudio_culminado').html('<p class="alert alert-warning p-1 m-0 font-size-11">¡Problemas al agregar el estudio!</p>');
                    }
                    // estudio_culminado_list();
                },
                error: function(data){
                    alert("Problemas al tratar de crear el registro, por favor verifique e intente nuevamente");
                }
            });
        } else {
            alert("¡Todos los campos son obligatorios, por favor verifique e intente nuevamente!");
        }
    }

    function estudio_culminado_list() {
        var id_aspirante = '<?php echo $data['id_aspirante']; ?>';

        var formData = new FormData();
        formData.append("id_aspirante", id_aspirante);

        if (id_aspirante!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>hoja-vida/formulario-estudio-culminado-listar',
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
                        $('#lista_registros').html('<p class="alert alert-warning p-1 font-size-11">¡No se encontraron estudios culminados registrados!</p>');
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

    function estudio_culminado_del(id_registro) {
        var id_aspirante = '<?php echo $data['id_aspirante']; ?>';

        var formData = new FormData();
        formData.append("id_aspirante", id_aspirante);
        formData.append("id_registro", id_registro);

        if (id_aspirante!="" && id_registro!="") {
            if (confirm("¿Está seguro de eliminar el registro?")) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo URL; ?>hoja-vida/formulario-estudio-culminado-eliminar',
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

                        estudio_culminado_list();
                    },
                    error: function(data){
                        alert("Problemas al tratar de crear el registro, por favor verifique e intente nuevamente");
                    }
                });
            } else {
                // El usuario hizo clic en "Cancelar"
                return false;
            }
        } else {
            alert("¡Todos los campos son obligatorios, por favor verifique e intente nuevamente!");
        }
    }

    jQuery(document).ready(function(){
        jQuery("#hvaet_establecimiento").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvaet_establecimiento").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvaet_titulo").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvaet_titulo").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    estudio_culminado_list();

    function valida_fecha_terminado() {
        var hvaet_fecha_inicio = document.getElementById("hvaet_fecha_inicio").value;
        var hvaet_fecha_terminacion = document.getElementById("hvaet_fecha_terminacion").value;

        if (hvaet_fecha_inicio!="" && hvaet_fecha_terminacion!="" && hvaet_fecha_inicio>hvaet_fecha_terminacion) {
            alert('La fecha de terminación ingresada no puede ser menor a la fecha de inicio, por favor verifique');
            document.getElementById("hvaet_fecha_terminacion").value='';
        }
    }
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