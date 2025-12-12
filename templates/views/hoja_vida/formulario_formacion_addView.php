<div class="row justify-content-center mb-2 p-6">
    <div class="col-md-12">
        <div class="bg-white rounded-3 col-lg-12 col-md-12 col-12">
            <div class="row mb-5">
                <div class="col-lg-12 col-md-12 col-12">
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
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>