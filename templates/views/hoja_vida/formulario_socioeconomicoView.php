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
                                                        <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-house-user"></span> Información Socioeconómica</p>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_socioeconomico_estrato_socioeconomico" class="form-label my-0 font-size-12">Estrato socioeconómico</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_socioeconomico_estrato_socioeconomico" id="hvp_socioeconomico_estrato_socioeconomico" data-container="body" title="Seleccione" required>
                                                            <option value="1" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_estrato_socioeconomico=='1') ? 'selected' : ''; ?>>1</option>
                                                            <option value="2" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_estrato_socioeconomico=='2') ? 'selected' : ''; ?>>2</option>
                                                            <option value="3" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_estrato_socioeconomico=='3') ? 'selected' : ''; ?>>3</option>
                                                            <option value="4" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_estrato_socioeconomico=='4') ? 'selected' : ''; ?>>4</option>
                                                            <option value="5" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_estrato_socioeconomico=='5') ? 'selected' : ''; ?>>5</option>
                                                            <option value="6" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_estrato_socioeconomico=='6') ? 'selected' : ''; ?>>6</option>
                                                        </select>
                                                    </div> 
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_socioeconomico_operador_internet" class="form-label my-0 font-size-12">Operador de internet</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_socioeconomico_operador_internet" id="hvp_socioeconomico_operador_internet" onchange="valida_operador();" data-container="body" title="Seleccione" required>
                                                            <?php for ($i=0; $i < count($data['resultado_registros_operador_internet']); $i++): ?>
                                                                <option value="<?php echo $data['resultado_registros_operador_internet'][$i]; ?>" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_operador_internet==$data['resultado_registros_operador_internet'][$i]) ? 'selected' : ''; ?>><?php echo $data['resultado_registros_operador_internet'][$i]; ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3 d-none" id="div_hvp_socioeconomico_operador_internet_otro">
                                                        <label for="hvp_socioeconomico_operador_internet_otro" class="form-label my-0 font-size-12">Nombre operador</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_socioeconomico_operador_internet_otro" id="hvp_socioeconomico_operador_internet_otro" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_socioeconomico_operador_internet_otro; ?>" required disabled>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_socioeconomico_velocidad_internet_descarga" class="form-label my-0 font-size-12">Velocidad de descarga de internet (MB)</label>
                                                        <input type="number" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_socioeconomico_velocidad_internet_descarga" id="hvp_socioeconomico_velocidad_internet_descarga" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_socioeconomico_velocidad_internet_descarga; ?>" min="2" max="900" onkeyup="valida_velocidad_descarga();" required>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_socioeconomico_velocidad_internet_carga" class="form-label my-0 font-size-12">Velocidad de carga de internet (MB)</label>
                                                        <input type="number" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_socioeconomico_velocidad_internet_carga" id="hvp_socioeconomico_velocidad_internet_carga" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_socioeconomico_velocidad_internet_carga; ?>" min="2" max="900" onkeyup="valida_velocidad_carga();" required>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <p class="alert alert-warning p-1 m-0 font-size-11">Para confirmar la velocidad de su internet, por favor ingrese al siguiente link y siga las instrucciones para obtener esta información: <a href="https://www.speedtest.net/es" target="_blank"><span class="fas fa-arrow-up-right-from-square"></span> https://www.speedtest.net/es</a></p>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_socioeconomico_caracteristicas_vivienda" class="form-label my-0 font-size-12">Características de tu vivienda</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_socioeconomico_caracteristicas_vivienda" id="hvp_socioeconomico_caracteristicas_vivienda" data-container="body" title="Seleccione" required>
                                                            <option value="Habitación" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_caracteristicas_vivienda=='Habitación') ? 'selected' : ''; ?>>Habitación</option>
                                                            <option value="Apartamento" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_caracteristicas_vivienda=='Apartamento') ? 'selected' : ''; ?>>Apartamento</option>
                                                            <option value="Casa" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_caracteristicas_vivienda=='Casa') ? 'selected' : ''; ?>>Casa</option>
                                                            <option value="Casa lote" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_caracteristicas_vivienda=='Casa lote') ? 'selected' : ''; ?>>Casa lote</option>
                                                            <option value="Finca" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_caracteristicas_vivienda=='Finca') ? 'selected' : ''; ?>>Finca</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_socioeconomico_condiciones_vivienda" class="form-label my-0 font-size-12">Condición de la vivienda</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_socioeconomico_condiciones_vivienda" id="hvp_socioeconomico_condiciones_vivienda" data-container="body" title="Seleccione" required>
                                                            <option value="Propia" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_condiciones_vivienda=='Propia') ? 'selected' : ''; ?>>Propia</option>
                                                            <option value="Arriendo" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_condiciones_vivienda=='Arriendo') ? 'selected' : ''; ?>>Arriendo</option>
                                                            <option value="Familiar" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_condiciones_vivienda=='Familiar') ? 'selected' : ''; ?>>Familiar</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hvp_socioeconomico_estado_terminacion_vivienda" class="form-label my-0 font-size-12">¿Cuál es el estado de terminación de tu vivienda?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_socioeconomico_estado_terminacion_vivienda" id="hvp_socioeconomico_estado_terminacion_vivienda" data-container="body" title="Seleccione" required>
                                                            <option value="Obra negra: En construcción" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_estado_terminacion_vivienda=='Obra negra: En construcción') ? 'selected' : ''; ?>>Obra negra: En construcción</option>
                                                            <option value="Obra gris: Pendiente de acabados finales" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_estado_terminacion_vivienda=='Obra gris: Pendiente de acabados finales') ? 'selected' : ''; ?>>Obra gris: Pendiente de acabados finales</option>
                                                            <option value="Obra blanca: Totalmente terminada" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_estado_terminacion_vivienda=='Obra blanca: Totalmente terminada') ? 'selected' : ''; ?>>Obra blanca: Totalmente terminada</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_socioeconomico_servicios_vivienda" class="form-label my-0 font-size-12">¿Qué servicios tienes en tu vivienda?</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="hvp_socioeconomico_servicios_vivienda[]" value="Luz" id="xxx" <?php echo (in_array('Luz', $data['hvp_socioeconomico_servicios_vivienda_array'])) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="flexCheckDefault">Luz</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="hvp_socioeconomico_servicios_vivienda[]" value="Agua" id="xxx" <?php echo (in_array('Agua', $data['hvp_socioeconomico_servicios_vivienda_array'])) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="flexCheckChecked">Agua</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="hvp_socioeconomico_servicios_vivienda[]" value="Gas" id="xxx" <?php echo (in_array('Gas', $data['hvp_socioeconomico_servicios_vivienda_array'])) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="flexCheckChecked">Gas</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="hvp_socioeconomico_servicios_vivienda[]" value="Internet" id="xxx" <?php echo (in_array('Internet', $data['hvp_socioeconomico_servicios_vivienda_array'])) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="flexCheckChecked">Internet</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="hvp_socioeconomico_servicios_vivienda[]" value="Plataformas de entretenimiento" id="xxx" <?php echo (in_array('Plataformas de entretenimiento', $data['hvp_socioeconomico_servicios_vivienda_array'])) ? 'checked' : ''; ?>>
                                                            <labePlataformas de entretenimientol class="form-check-label" for="flexCheckChecked">Plataformas de entretenimiento</labePlataformas>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="hvp_socioeconomico_plan_compra_vivienda" class="form-label my-0 font-size-12">¿Tienes pensado comprar vivienda en los próximos 3 años?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_socioeconomico_plan_compra_vivienda" id="hvp_socioeconomico_plan_compra_vivienda" data-container="body" title="Seleccione" required>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_plan_compra_vivienda=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_plan_compra_vivienda=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="hvp_socioeconomico_beneficiario_subsidio_vivienda" class="form-label my-0 font-size-12">¿Has sido beneficiario de subsidio de vivienda?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_socioeconomico_beneficiario_subsidio_vivienda" id="hvp_socioeconomico_beneficiario_subsidio_vivienda" data-container="body" title="Seleccione" required>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_beneficiario_subsidio_vivienda=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_socioeconomico_beneficiario_subsidio_vivienda=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-people-roof"></span> Información Familiar</p>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_familia_numero_hijos" class="form-label my-0 font-size-12">¿Cuántos hijos tienes?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_familia_numero_hijos" id="hvp_familia_numero_hijos" data-container="body" title="Seleccione" onchange="valida_edad_hijos();" required>
                                                            <option value="0" <?php echo ($data['resultado_registros_usuario'][0]->hvp_familia_numero_hijos=='0') ? 'selected' : ''; ?>>0</option>
                                                            <option value="1" <?php echo ($data['resultado_registros_usuario'][0]->hvp_familia_numero_hijos=='1') ? 'selected' : ''; ?>>1</option>
                                                            <option value="2" <?php echo ($data['resultado_registros_usuario'][0]->hvp_familia_numero_hijos=='2') ? 'selected' : ''; ?>>2</option>
                                                            <option value="3" <?php echo ($data['resultado_registros_usuario'][0]->hvp_familia_numero_hijos=='3') ? 'selected' : ''; ?>>3</option>
                                                            <option value="4" <?php echo ($data['resultado_registros_usuario'][0]->hvp_familia_numero_hijos=='4') ? 'selected' : ''; ?>>4</option>
                                                            <option value="5" <?php echo ($data['resultado_registros_usuario'][0]->hvp_familia_numero_hijos=='5') ? 'selected' : ''; ?>>5</option>
                                                            <option value="6" <?php echo ($data['resultado_registros_usuario'][0]->hvp_familia_numero_hijos=='6') ? 'selected' : ''; ?>>6</option>
                                                            <option value="7" <?php echo ($data['resultado_registros_usuario'][0]->hvp_familia_numero_hijos=='7') ? 'selected' : ''; ?>>7</option>
                                                            <option value="8" <?php echo ($data['resultado_registros_usuario'][0]->hvp_familia_numero_hijos=='8') ? 'selected' : ''; ?>>8</option>
                                                            <option value="9" <?php echo ($data['resultado_registros_usuario'][0]->hvp_familia_numero_hijos=='9') ? 'selected' : ''; ?>>9</option>
                                                            <option value="10" <?php echo ($data['resultado_registros_usuario'][0]->hvp_familia_numero_hijos=='10') ? 'selected' : ''; ?>>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="row mb-2" id="lista_edad_hijos">
                                                        <?php if($data['resultado_registros_usuario'][0]->hvp_familia_numero_hijos>0): ?>
                                                            <label for="tabla_edad_hijos" class="form-label my-0 font-size-12">Por favor indique el rango de edad de sus hijos:</label>
                                                            <div class="table-responsive table-fixed mt-2">
                                                                <table class="table table-hover table-bordered table-striped mb-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="px-1 py-2 text-center font-size-12 align-middle"></th>
                                                                        <th class="px-1 py-2 text-center font-size-12 align-middle">0 a 2 años</th>
                                                                        <th class="px-1 py-2 text-center font-size-12 align-middle">2 a 5 años</th>
                                                                        <th class="px-1 py-2 text-center font-size-12 align-middle">5 a 10 años</th>
                                                                        <th class="px-1 py-2 text-center font-size-12 align-middle">10 a 15 años</th>
                                                                        <th class="px-1 py-2 text-center font-size-12 align-middle">15+ años</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php for ($i=1; $i <= $data['resultado_registros_usuario'][0]->hvp_familia_numero_hijos; $i++): ?>
                                                                        <tr>
                                                                            <td class="p-1 align-middle text-center">Hijo <?php echo $i; ?></td>
                                                                            <td class="p-1 font-size-11 align-middle text-center">
                                                                                <input class="form-check-input font-size-12" type="radio" name="edad_hijos_<?php echo $i; ?>" value="0-2" id="edad_hijos_<?php echo $i; ?>" <?php echo ($data['edad_hijos_final_array'][$i-1]=='0-2') ? 'checked' : ''; ?>>
                                                                            </td>
                                                                            <td class="p-1 font-size-11 align-middle text-center">
                                                                                <input class="form-check-input font-size-12" type="radio" name="edad_hijos_<?php echo $i; ?>" value="2-5" id="edad_hijos_<?php echo $i; ?>" <?php echo ($data['edad_hijos_final_array'][$i-1]=='2-5') ? 'checked' : ''; ?>>
                                                                            </td>
                                                                            <td class="p-1 font-size-11 align-middle text-center">
                                                                                <input class="form-check-input font-size-12" type="radio" name="edad_hijos_<?php echo $i; ?>" value="5-10" id="edad_hijos_<?php echo $i; ?>" <?php echo ($data['edad_hijos_final_array'][$i-1]=='5-10') ? 'checked' : ''; ?>>
                                                                            </td>
                                                                            <td class="p-1 font-size-11 align-middle text-center">
                                                                                <input class="form-check-input font-size-12" type="radio" name="edad_hijos_<?php echo $i; ?>" value="10-15" id="edad_hijos_<?php echo $i; ?>" <?php echo ($data['edad_hijos_final_array'][$i-1]=='10-15') ? 'checked' : ''; ?>>
                                                                            </td>
                                                                            <td class="p-1 font-size-11 align-middle text-center">
                                                                                <input class="form-check-input font-size-12" type="radio" name="edad_hijos_<?php echo $i; ?>" value="15+" id="edad_hijos_<?php echo $i; ?>" <?php echo ($data['edad_hijos_final_array'][$i-1]=='15+') ? 'checked' : ''; ?>>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endfor; ?>
                                                                </tbody>
                                                                </table>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="hvp_familia_capacitacion_familia" class="form-label my-0 font-size-12">¿En cual de los siguientes temas relacionados con la familia te gustaría recibir capacitación o acompañamiento?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_familia_capacitacion_familia" id="hvp_familia_capacitacion_familia" data-container="body" title="Seleccione" required>
                                                            <option value="Económicos - finanzas familiares" <?php echo ($data['resultado_registros_usuario'][0]->hvp_familia_capacitacion_familia=='Económicos - finanzas familiares') ? 'selected' : ''; ?>>Económicos - finanzas familiares</option>
                                                            <option value="Organización y distribución del tiempo" <?php echo ($data['resultado_registros_usuario'][0]->hvp_familia_capacitacion_familia=='Organización y distribución del tiempo') ? 'selected' : ''; ?>>Organización y distribución del tiempo</option>
                                                            <option value="Relaciones de pareja" <?php echo ($data['resultado_registros_usuario'][0]->hvp_familia_capacitacion_familia=='Relaciones de pareja') ? 'selected' : ''; ?>>Relaciones de pareja</option>
                                                            <option value="Relaciones interpersonales" <?php echo ($data['resultado_registros_usuario'][0]->hvp_familia_capacitacion_familia=='Relaciones interpersonales') ? 'selected' : ''; ?>>Relaciones interpersonales</option>
                                                            <option value="Relaciones padres e hijos(as)" <?php echo ($data['resultado_registros_usuario'][0]->hvp_familia_capacitacion_familia=='Relaciones padres e hijos(as)') ? 'selected' : ''; ?>>Relaciones padres e hijos(as)</option>
                                                            <option value="Rendimiento escolar de los hijos" <?php echo ($data['resultado_registros_usuario'][0]->hvp_familia_capacitacion_familia=='Rendimiento escolar de los hijos') ? 'selected' : ''; ?>>Rendimiento escolar de los hijos</option>
                                                            <option value="No aplica" <?php echo ($data['resultado_registros_usuario'][0]->hvp_familia_capacitacion_familia=='No aplica') ? 'selected' : ''; ?>>No aplica</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-"></span> Información Financiera</p>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hvp_financiero_activos" class="form-label my-0 font-size-12">Activos <span class="fas fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="Relacione el valor de todos aquellos bienes y propiedades que se encuentren a su nombre (casas, apartamentos, locales, terrenos, fincas, vehículos, inversiones)."></span></label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_financiero_activos" id="hvp_financiero_activos" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_financiero_activos; ?>" required autocomplete="off">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hvp_financiero_ingresos" class="form-label my-0 font-size-12">Ingresos mensuales  <span class="fas fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="Hace referencia a los ingresos percibidos de forma constante o en promedio en el mes."></label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_financiero_ingresos" id="hvp_financiero_ingresos" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_financiero_ingresos; ?>" required autocomplete="off">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hvp_financiero_pasivos" class="form-label my-0 font-size-12">Pasivos <span class="fas fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="Relacione el monto de las deudas a cargo, vigentes en esa fecha (Créditos bancarios, obligaciones con particulares siempre que estén soportados con un documento, contrato o título valor; deudas con entidades del estado)."></label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_financiero_pasivos" id="hvp_financiero_pasivos" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_financiero_pasivos; ?>" required autocomplete="off">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hvp_financiero_egresos" class="form-label my-0 font-size-12">Egresos mensuales <span class="fas fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="Hace referencia a las deudas o salidas de dinero en el mes (de forma constante o en promedio)."></label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_financiero_egresos" id="hvp_financiero_egresos" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_financiero_egresos; ?>" required autocomplete="off">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hvp_financiero_patrimonio" class="form-label my-0 font-size-12">Patrimonio <span class="fas fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="Relacione  aquí el valor general del conjunto de bienes, derechos y obligaciones con los que cuenta actualmente (Activos - Pasivos)."></label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_financiero_patrimonio" id="hvp_financiero_patrimonio" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_financiero_patrimonio; ?>" required autocomplete="off">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hvp_financiero_ingresos_otros" class="form-label my-0 font-size-12">Otros ingresos <span class="fas fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="Ingresos adicionales que pueden darse de forma variable o esporádica."></label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_financiero_ingresos_otros" id="hvp_financiero_ingresos_otros" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_financiero_ingresos_otros; ?>" required autocomplete="off">
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="hvp_financiero_concepto_ingresos" class="form-label my-0 font-size-12">Concepto de otros ingresos</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_financiero_concepto_ingresos" id="hvp_financiero_concepto_ingresos" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_financiero_concepto_ingresos; ?>">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hvp_financiero_moneda_extranjera" class="form-label my-0 font-size-12">¿Realiza Operaciones en Moneda Extranjera?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_financiero_moneda_extranjera" id="hvp_financiero_moneda_extranjera" data-container="body" title="Seleccione" required>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_financiero_moneda_extranjera=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_financiero_moneda_extranjera=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="appoinment-title mt-2">
                                                        <h4>Declaración de Origen de Fondos y Prevención de Lavado de Activos y Financiación del Terrorismo - SAGRILAFT</h4>
                                                    </div>
                                                    <p class="appoinment-content-text mt-0 mb-2">
                                                        <?php echo $data['resultado_registros_parametros'][0]->app_descripcion; ?>
                                                        
                                                    </p>
                                                    <div class="col-md-12 my-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="Si" name="hvp_origen_fondos" id="hvp_origen_fondos" <?php echo ($data['resultado_registros_usuario'][0]->hvp_origen_fondos=='Si') ? 'checked' : ''; ?> required>
                                                            <label class="form-check-label font-size-12 fw-bold" for="hvp_origen_fondos">Si, acepto</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-"></span> Personas Expuestas Públicamente - PEP</p>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="hvp_pep_recursos" class="form-label my-0 font-size-12">¿Maneja recursos públicos?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_pep_recursos" id="hvp_pep_recursos" data-container="body" title="Seleccione" required onchange="validar_campos();">
                                                            <option value=""></option>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_pep_recursos=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_pep_recursos=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="hvp_pep_reconocimiento" class="form-label my-0 font-size-12">¿Goza de reconocimiento público general?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_pep_reconocimiento" id="hvp_pep_reconocimiento" data-container="body" title="Seleccione" required onchange="validar_campos();">
                                                            <option value=""></option>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_pep_reconocimiento=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_pep_reconocimiento=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="hvp_pep_poder" class="form-label my-0 font-size-12">¿Ejerce algún grado de poder público?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_pep_poder" id="hvp_pep_poder" data-container="body" title="Seleccione" required onchange="validar_campos();">
                                                            <option value=""></option>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_pep_poder=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_pep_poder=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="hvp_pep_familiar" class="form-label my-0 font-size-12">¿Tiene usted algún familiar que cumpla con una característica anterior?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_pep_familiar" id="hvp_pep_familiar" data-container="body" title="Seleccione" required onchange="validar_campos();">
                                                            <option value=""></option>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_pep_familiar=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_pep_familiar=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mb-3 d-none" id="mensaje_alerta_div">
                                                        <p class="alert alert-warning p-1">Si alguna de las respuestas anteriores es afirmativa, por favor especifique cédula y nombre completo de la persona:</p>
                                                    </div>
                                                    <div class="col-md-4 mb-3 d-none" id="hvp_pep_cedula_div">
                                                        <label for="hvp_pep_cedula" class="form-label my-0 font-size-12">Cédula</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_pep_cedula" id="hvp_pep_cedula" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_pep_cedula; ?>" required disabled>
                                                    </div>
                                                    <div class="col-md-8 mb-3 d-none" id="hvp_pep_nombres_apellidos_div">
                                                        <label for="hvp_pep_nombres_apellidos" class="form-label my-0 font-size-12">Nombres y apellidos</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_pep_nombres_apellidos" id="hvp_pep_nombres_apellidos" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_pep_nombres_apellidos; ?>" required disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php echo Flasher::flash(); ?>
                                            <div class="col-md-12 text-end">
                                                <span id="btn_enviar">
                                                    <a href="<?php echo URL; ?>hoja-vida/formulario-ubicacion/<?php echo base64_encode('ubicacion'); ?>" class="btn btn-warning login-btn">Regresar</a>
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
    jQuery(document).ready(function(){
        jQuery("#hvp_socioeconomico_velocidad_internet_descarga").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_socioeconomico_velocidad_internet_carga").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });
    
    jQuery(document).ready(function(){
        jQuery("#hvp_socioeconomico_operador_internet_otro").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_financiero_concepto_ingresos").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_financiero_activos").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_financiero_ingresos").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_financiero_pasivos").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_financiero_egresos").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_financiero_patrimonio").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_financiero_ingresos_otros").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_pep_cedula").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_pep_nombres_apellidos").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
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
</script>
<script type="text/javascript">
    function validar_campos(){
        var hvp_pep_recursos = document.getElementById("hvp_pep_recursos").value;
        var hvp_pep_reconocimiento = document.getElementById("hvp_pep_reconocimiento").value;
        var hvp_pep_poder = document.getElementById("hvp_pep_poder").value;
        var hvp_pep_familiar = document.getElementById("hvp_pep_familiar").value;
        var hvp_pep_cedula = document.getElementById('hvp_pep_cedula').disabled=true;
        var hvp_pep_nombres_apellidos = document.getElementById('hvp_pep_nombres_apellidos').disabled=true;
        $("#mensaje_alerta_div").removeClass('d-block').addClass('d-none');
        $("#hvp_pep_cedula_div").removeClass('d-block').addClass('d-none');
        $("#hvp_pep_nombres_apellidos_div").removeClass('d-block').addClass('d-none');

        if(hvp_pep_recursos=='Si' || hvp_pep_reconocimiento=='Si' || hvp_pep_poder=='Si' || hvp_pep_familiar=='Si') {
            var hvp_pep_cedula = document.getElementById('hvp_pep_cedula').disabled=false;
            var hvp_pep_nombres_apellidos = document.getElementById('hvp_pep_nombres_apellidos').disabled=false;
            $("#mensaje_alerta_div").removeClass('d-none').addClass('d-block');
            $("#hvp_pep_cedula_div").removeClass('d-none').addClass('d-block');
            $("#hvp_pep_nombres_apellidos_div").removeClass('d-none').addClass('d-block');
        }
    }

    validar_campos();

    function valida_edad_hijos() {
        var hvp_familia_numero_hijos = document.getElementById("hvp_familia_numero_hijos").value;
        let resultado='';
        $("#lista_edad_hijos").html('');
        if (hvp_familia_numero_hijos!="" && (hvp_familia_numero_hijos>0)) {
            resultado+='<label for="tabla_edad_hijos" class="form-label my-0 font-size-12">Por favor indique el rango de edad de sus hijos:</label>\
                            <div class="table-responsive table-fixed mt-2">\
                                <table class="table table-hover table-bordered table-striped mb-0">\
                                <thead>\
                                    <tr>\
                                        <th class="px-1 py-2 text-center font-size-12 align-middle"></th>\
                                        <th class="px-1 py-2 text-center font-size-12 align-middle">0 a 2 años</th>\
                                        <th class="px-1 py-2 text-center font-size-12 align-middle">2 a 5 años</th>\
                                        <th class="px-1 py-2 text-center font-size-12 align-middle">5 a 10 años</th>\
                                        <th class="px-1 py-2 text-center font-size-12 align-middle">10 a 15 años</th>\
                                        <th class="px-1 py-2 text-center font-size-12 align-middle">15+ años</th>\
                                    </tr>\
                                </thead>\
                                <tbody>';
            for (let i = 1; i <= hvp_familia_numero_hijos; i++) {
                resultado+='<tr>\
                                <td class="p-1 align-middle text-center">Hijo '+i+'</td>\
                                <td class="p-1 font-size-11 align-middle text-center">\
                                    <input class="form-check-input font-size-12" type="radio" name="edad_hijos_'+i+'" value="0-2" id="edad_hijos_'+i+'">\
                                </td>\
                                <td class="p-1 font-size-11 align-middle text-center">\
                                    <input class="form-check-input font-size-12" type="radio" name="edad_hijos_'+i+'" value="2-5" id="edad_hijos_'+i+'">\
                                </td>\
                                <td class="p-1 font-size-11 align-middle text-center">\
                                    <input class="form-check-input font-size-12" type="radio" name="edad_hijos_'+i+'" value="5-10" id="edad_hijos_'+i+'">\
                                </td>\
                                <td class="p-1 font-size-11 align-middle text-center">\
                                    <input class="form-check-input font-size-12" type="radio" name="edad_hijos_'+i+'" value="10-15" id="edad_hijos_'+i+'">\
                                </td>\
                                <td class="p-1 font-size-11 align-middle text-center">\
                                    <input class="form-check-input font-size-12" type="radio" name="edad_hijos_'+i+'" value="15+" id="edad_hijos_'+i+'">\
                                </td>\
                            </tr>';
            }

            resultado+='</tbody>\
                            </table>\
                        </div>';
            $("#lista_edad_hijos").html(resultado);
        }
    }
</script>
<script type="text/javascript">
    function valida_operador() {
        $("#div_hvp_socioeconomico_operador_internet_otro").removeClass('d-block').addClass('d-none');

        document.getElementById('hvp_socioeconomico_operador_internet_otro').disabled=true;

        var hvp_socioeconomico_operador_internet = document.getElementById("hvp_socioeconomico_operador_internet").value;

        if (hvp_socioeconomico_operador_internet!="" && (hvp_socioeconomico_operador_internet=="Otro")) {
            $("#div_hvp_socioeconomico_operador_internet_otro").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_socioeconomico_operador_internet_otro').disabled=false;
        }
    }

    function valida_velocidad_carga() {
        var hvp_socioeconomico_velocidad_internet_carga = document.getElementById("hvp_socioeconomico_velocidad_internet_carga").value;

        if (hvp_socioeconomico_velocidad_internet_carga!="" && hvp_socioeconomico_velocidad_internet_carga>900) {
            alert('El valor ingresado supera la velocidad máxima, por favor verifique');
            document.getElementById("hvp_socioeconomico_velocidad_internet_carga").value='';
        }
    }

    function valida_velocidad_descarga() {
        var hvp_socioeconomico_velocidad_internet_descarga = document.getElementById("hvp_socioeconomico_velocidad_internet_descarga").value;

        if (hvp_socioeconomico_velocidad_internet_descarga!="" && hvp_socioeconomico_velocidad_internet_descarga>900) {
            alert('El valor ingresado supera la velocidad máxima, por favor verifique');
            document.getElementById("hvp_socioeconomico_velocidad_internet_descarga").value='';
        }
    }

    <?php if($data['resultado_registros_usuario'][0]->hvp_socioeconomico_estrato_socioeconomico!=''): ?>
        valida_operador();
        valida_velocidad_carga();
        valida_velocidad_descarga();
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