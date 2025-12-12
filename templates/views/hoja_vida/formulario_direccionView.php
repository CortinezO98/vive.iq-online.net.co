<div class="col-md-12">
    <div class="bg-white rounded-3 col-lg-12 col-md-12 col-12">
        <div class="row mb-5">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="row p-6 d-lg-flex justify-content-between align-items-center ">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <img src="<?php echo IMAGES; ?>logo/instrucciones_direccion.png" class="img-fluid">
                                </div>
                                <hr class="my-3">
                                <p class="appoinment-content-text mt-2 mb-3">Diligencie los campos requeridos que identifiquen la dirección actual de residencia; los campos que no requiera los puede dejar en blanco. Continue verificando en el cuadro de <b>"Dirección Completa"</b>  su dirección.</p>
                                <div class="row">
                                    <div class="col-md-2 mb-3">
                                        <label for="campo_1" class="form-label my-0 font-size-11">Vía Principal</label>
                                        <select class="form-select form-select-sm font-size-11" name="campo_1" id="campo_1" required onchange="construye_direccion();" onkeyup="construye_direccion();">
                                            <option value="">Seleccione</option>
                                            <option value="Avenida Calle">Avenida Calle</option>
                                            <option value="Avenida Carrera">Avenida Carrera</option>
                                            <option value="Calle">Calle</option>
                                            <option value="Carrera">Carrera</option>
                                            <option value="Diagonal">Diagonal</option>
                                            <option value="Transversal">Transversal</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <label for="campo_2" class="form-label my-0 font-size-11">Número</label>
                                        <input type="number" class="form-control form-control-sm font-size-11 px-2 py-1" min="1" max="900" step="1" name="campo_2" id="campo_2" value="" required onchange="construye_direccion();" onkeyup="construye_direccion();">
                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <label for="campo_3" class="form-label my-0 font-size-11">Letra</label>
                                        <select class="form-select form-select-sm font-size-11" name="campo_3" id="campo_3" required onchange="construye_direccion();" onkeyup="construye_direccion();">
                                            <option value=""></option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                            <option value="F">F</option>
                                            <option value="G">G</option>
                                            <option value="H">H</option>
                                            <option value="I">I</option>
                                            <option value="J">J</option>
                                            <option value="K">K</option>
                                            <option value="L">L</option>
                                            <option value="M">M</option>
                                            <option value="N">N</option>
                                            <option value="Ñ">Ñ</option>
                                            <option value="P">P</option>
                                            <option value="Q">Q</option>
                                            <option value="R">R</option>
                                            <option value="S">S</option>
                                            <option value="U">U</option>
                                            <option value="V">V</option>
                                            <option value="W">W</option>
                                            <option value="X">X</option>
                                            <option value="Y">Y</option>
                                            <option value="Z">Z</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <label for="campo_4" class="form-label my-0 font-size-11">Cuadrante</label>
                                        <select class="form-select form-select-sm font-size-11" name="campo_4" id="campo_4" required onchange="construye_direccion();" onkeyup="construye_direccion();">
                                            <option value=""></option>
                                            <option value="BIS">BIS</option>
                                        </select>
                                    </div>
                                    <!-- <div class="col-md-1 mb-3">
                                        <label for="campo_4" class="form-label my-0 font-size-11">Cuadrante</label>
                                        <select class="form-select form-select-sm font-size-11" name="campo_5" id="campo_5" required onchange="construye_direccion();" onkeyup="construye_direccion();">
                                            <option value=""></option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                            <option value="F">F</option>
                                            <option value="G">G</option>
                                            <option value="H">H</option>
                                            <option value="I">I</option>
                                            <option value="J">J</option>
                                            <option value="K">K</option>
                                            <option value="L">L</option>
                                            <option value="M">M</option>
                                            <option value="N">N</option>
                                            <option value="Ñ">Ñ</option>
                                            <option value="P">P</option>
                                            <option value="Q">Q</option>
                                            <option value="R">R</option>
                                            <option value="S">S</option>
                                            <option value="U">U</option>
                                            <option value="V">V</option>
                                            <option value="W">W</option>
                                            <option value="X">X</option>
                                            <option value="Y">Y</option>
                                            <option value="Z">Z</option>
                                        </select>
                                    </div> -->
                                    <div class="col-md-1 mb-3">
                                        <label for="campo_4" class="form-label my-0 font-size-11">Cardinal</label>
                                        <select class="form-select form-select-sm font-size-11" name="campo_6" id="campo_6" required onchange="construye_direccion();" onkeyup="construye_direccion();">
                                            <option value=""></option>
                                            <option value="Este">Este</option>
                                            <option value="Oeste">Oeste</option>
                                            <option value="Sur">Sur</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1 mb-3 text-center">
                                        <h1>#</h1>
                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <label for="campo_7" class="form-label my-0 font-size-11">Número</label>
                                        <input type="number" class="form-control form-control-sm font-size-11 px-2 py-1" min="1" max="900" step="1" name="campo_7" id="campo_7" value="" required onchange="construye_direccion();" onkeyup="construye_direccion();">
                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <label for="campo_4" class="form-label my-0 font-size-11">Letra</label>
                                        <select class="form-select form-select-sm font-size-11" name="campo_8" id="campo_8" required onchange="construye_direccion();" onkeyup="construye_direccion();">
                                            <option value=""></option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                            <option value="F">F</option>
                                            <option value="G">G</option>
                                            <option value="H">H</option>
                                            <option value="I">I</option>
                                            <option value="J">J</option>
                                            <option value="K">K</option>
                                            <option value="L">L</option>
                                            <option value="M">M</option>
                                            <option value="N">N</option>
                                            <option value="Ñ">Ñ</option>
                                            <option value="P">P</option>
                                            <option value="Q">Q</option>
                                            <option value="R">R</option>
                                            <option value="S">S</option>
                                            <option value="U">U</option>
                                            <option value="V">V</option>
                                            <option value="W">W</option>
                                            <option value="X">X</option>
                                            <option value="Y">Y</option>
                                            <option value="Z">Z</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 mb-3 text-center">
                                        <h1>-</h1>
                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <label for="campo_9" class="form-label my-0 font-size-11">Placa</label>
                                        <input type="number" class="form-control form-control-sm font-size-11 px-2 py-1" min="1" max="900" step="1" name="campo_9" id="campo_9" value="" required onchange="construye_direccion();" onkeyup="construye_direccion();">
                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <label for="campo_10" class="form-label my-0 font-size-11">Letra</label>
                                        <select class="form-select form-select-sm font-size-11" name="campo_10" id="campo_10" required onchange="construye_direccion();" onkeyup="construye_direccion();">
                                            <option value=""></option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                            <option value="F">F</option>
                                            <option value="G">G</option>
                                            <option value="H">H</option>
                                            <option value="I">I</option>
                                            <option value="J">J</option>
                                            <option value="K">K</option>
                                            <option value="L">L</option>
                                            <option value="M">M</option>
                                            <option value="N">N</option>
                                            <option value="Ñ">Ñ</option>
                                            <option value="P">P</option>
                                            <option value="Q">Q</option>
                                            <option value="R">R</option>
                                            <option value="S">S</option>
                                            <option value="U">U</option>
                                            <option value="V">V</option>
                                            <option value="W">W</option>
                                            <option value="X">X</option>
                                            <option value="Y">Y</option>
                                            <option value="Z">Z</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <label for="campo_11" class="form-label my-0 font-size-11">Cardinal</label>
                                        <select class="form-select form-select-sm font-size-11" name="campo_11" id="campo_11" required onchange="construye_direccion();" onkeyup="construye_direccion();">
                                            <option value=""></option>
                                            <option value="Este">Este</option>
                                            <option value="Oeste">Oeste</option>
                                            <option value="Sur">Sur</option>
                                        </select>
                                    </div>
                                </div>
                                <p class="appoinment-content-text mt-2 mb-3">Complemento</p>
                                <div class="col-md-6 mb-3">
                                    <select class="form-select form-select-sm font-size-11" name="campo_12" id="campo_12" required onchange="construye_direccion();" onkeyup="construye_direccion();">
                                        <option value="">Seleccione</option>
                                        <option value="ADELANTE">ADELANTE</option>
                                        <option value="ADMINISTRACION">ADMINISTRACION</option>
                                        <option value="AEROPUERTO">AEROPUERTO</option>
                                        <option value="AGENCIA">AGENCIA</option>
                                        <option value="AGRUPACION">AGRUPACION</option>
                                        <option value="AL LADO">AL LADO</option>
                                        <option value="ALMACEN">ALMACEN</option>
                                        <option value="ALTILLO">ALTILLO</option>
                                        <option value="APARTADO">APARTADO</option>
                                        <option value="APARTAMENTO">APARTAMENTO</option>
                                        <option value="ATRÁS">ATRÁS</option>
                                        <option value="AUTOPISTA">AUTOPISTA</option>
                                        <option value="AVENIDA">AVENIDA</option>
                                        <option value="AVENIDA CALLE">AVENIDA CALLE</option>
                                        <option value="AVENIDA CARRERA">AVENIDA CARRERA</option>
                                        <option value="BLOQUE">BLOQUE</option>
                                        <option value="BODEGA">BODEGA</option>
                                        <option value="BOULEVAR">BOULEVAR</option>
                                        <option value="CALLE">CALLE</option>
                                        <option value="CAMINO">CAMINO</option>
                                        <option value="CARRERA">CARRERA</option>
                                        <option value="CARRETERA">CARRETERA</option>
                                        <option value="CASA">CASA</option>
                                        <option value="CASERIO">CASERIO</option>
                                        <option value="CELULA">CELULA</option>
                                        <option value="CENTRO">CENTRO</option>
                                        <option value="CENTRO COMERCIAL">CENTRO COMERCIAL</option>
                                        <option value="CIRCULAR">CIRCULAR</option>
                                        <option value="CIRCUNVALAR">CIRCUNVALAR</option>
                                        <option value="CIUDADELA">CIUDADELA</option>
                                        <option value="CONJUNTO">CONJUNTO</option>
                                        <option value="CONJUNTO RESIDENCIAL">CONJUNTO RESIDENCIAL</option>
                                        <option value="CONSULTORIO">CONSULTORIO</option>
                                        <option value="CORREGIMIENTO">CORREGIMIENTO</option>
                                        <option value="DEPARTAMENTO">DEPARTAMENTO</option>
                                        <option value="DEPOSITO">DEPOSITO</option>
                                        <option value="DEPOSITO SOTANO">DEPOSITO SOTANO</option>
                                        <option value="DIAGONAL">DIAGONAL</option>
                                        <option value="EDIFICIO">EDIFICIO</option>
                                        <option value="ENTRADA">ENTRADA</option>
                                        <option value="ESCALERA">ESCALERA</option>
                                        <option value="ESQUINA">ESQUINA</option>
                                        <option value="ESTE">ESTE</option>
                                        <option value="ETAPA">ETAPA</option>
                                        <option value="EXTERIOR">EXTERIOR</option>
                                        <option value="FINCA">FINCA</option>
                                        <option value="GARAJE">GARAJE</option>
                                        <option value="GARAJE SOTANO">GARAJE SOTANO</option>
                                        <option value="GLORIETA">GLORIETA</option>
                                        <option value="HACIENDA">HACIENDA</option>
                                        <option value="HANGAR">HANGAR</option>
                                        <option value="INSPECCION DE POLICIA">INSPECCION DE POLICIA</option>
                                        <option value="INSPECCION DEPARTAMENTAL">INSPECCION DEPARTAMENTAL</option>
                                        <option value="INSPECCION MUNICIPAL">INSPECCION MUNICIPAL</option>
                                        <option value="INTERIOR">INTERIOR</option>
                                        <option value="KILOMETRO">KILOMETRO</option>
                                        <option value="LOCAL">LOCAL</option>
                                        <option value="LOCAL MEZZANINE">LOCAL MEZZANINE</option>
                                        <option value="LOTE">LOTE</option>
                                        <option value="MANZANA">MANZANA</option>
                                        <option value="MEZZANINE">MEZZANINE</option>
                                        <option value="MODULO">MODULO</option>
                                        <option value="MOJON">MOJON</option>
                                        <option value="MUELLE">MUELLE</option>
                                        <option value="MUNICIPIO">MUNICIPIO</option>
                                        <option value="NORTE">NORTE</option>
                                        <option value="OCCIDENTE">OCCIDENTE</option>
                                        <option value="OESTE">OESTE</option>
                                        <option value="OFICINA">OFICINA</option>
                                        <option value="ORIENTE">ORIENTE</option>
                                        <option value="PARAJE">PARAJE</option>
                                        <option value="PARCELA">PARCELA</option>
                                        <option value="PARK WAY">PARK WAY</option>
                                        <option value="PARQUE">PARQUE</option>
                                        <option value="PARQUEADERO">PARQUEADERO</option>
                                        <option value="PASAJE">PASAJE</option>
                                        <option value="PASEO">PASEO</option>
                                        <option value="PENTHOUSE">PENTHOUSE</option>
                                        <option value="PISO">PISO</option>
                                        <option value="PLANTA">PLANTA</option>
                                        <option value="PORTERIA">PORTERIA</option>
                                        <option value="POSTE">POSTE</option>
                                        <option value="PLAZA DE MERCADO">PLAZA DE MERCADO</option>
                                        <option value="PREDIO">PREDIO</option>
                                        <option value="PUENTE">PUENTE</option>
                                        <option value="PUESTO">PUESTO</option>
                                        <option value="ROUND POINT">ROUND POINT</option>
                                        <option value="SALON">SALON</option>
                                        <option value="SALON COMUNAL">SALON COMUNAL</option>
                                        <option value="SECTOR">SECTOR</option>
                                        <option value="SEMISOTANO">SEMISOTANO</option>
                                        <option value="SOLAR">SOLAR</option>
                                        <option value="SOTANO">SOTANO</option>
                                        <option value="SUITE">SUITE</option>
                                        <option value="SUPERMANZANA">SUPERMANZANA</option>
                                        <option value="SUR">SUR</option>
                                        <option value="TERMINAL">TERMINAL</option>
                                        <option value="TERRAZA">TERRAZA</option>
                                        <option value="TORRE">TORRE</option>
                                        <option value="TRANSVERSAL">TRANSVERSAL</option>
                                        <option value="UNIDAD">UNIDAD</option>
                                        <option value="UNIDAD RESIDENCIAL">UNIDAD RESIDENCIAL</option>
                                        <option value="URBANIZACION">URBANIZACION</option>
                                        <option value="VARIANTE">VARIANTE</option>
                                        <option value="VEREDA">VEREDA</option>
                                        <option value="VIA">VIA</option>
                                        <option value="VIAS DE NOMBRE COMUN">VIAS DE NOMBRE COMUN</option>
                                        <option value="ZONA">ZONA</option>
                                        <option value="ZONA FRANCA">ZONA FRANCA</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="campo_13" id="campo_13" value="" required onchange="construye_direccion();" onkeyup="construye_direccion();">
                                </div>
                                <div class="col-md-12 mb-0">
                                    <label for="direccion_completa" class="form-label my-0 font-size-11">Dirección completa</label>
                                    <textarea class="form-control form-control-sm bg-gray-200" name="direccion_completa" id="direccion_completa" rows="3" maxlength="500" readonly></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function construye_direccion(){
        var campo_1 = $('#campo_1').val();
        var campo_2 = $('#campo_2').val();
        var campo_3 = $('#campo_3').val();
        var campo_4 = $('#campo_4').val();
        // var campo_5 = $('#campo_5').val();
        var campo_6 = $('#campo_6').val();
        var campo_7 = $('#campo_7').val();
        var campo_8 = $('#campo_8').val();
        var campo_9 = $('#campo_9').val();
        var campo_10 = $('#campo_10').val();
        var campo_11 = $('#campo_11').val();
        var campo_12 = $('#campo_12').val();
        var campo_13 = $('#campo_13').val();
        var direccion_completa="";
        
        var valida=false;
        if (campo_1!='') {
            direccion_completa = campo_1;

            if (campo_2!='') {
                direccion_completa = direccion_completa + " " + campo_2;
            }

            if (campo_3!='') {
                direccion_completa = direccion_completa + " " + campo_3;
            }

            if (campo_4!='') {
                direccion_completa = direccion_completa + " " + campo_4;
            }

            // if (campo_5!='') {
            //     direccion_completa = direccion_completa + " " + campo_5;
            // }

            if (campo_6!='') {
                direccion_completa = direccion_completa + " " + campo_6;
            }

            if (campo_7!='') {
                direccion_completa = direccion_completa + " # " + campo_7;
            }

            if (campo_8!='') {
                direccion_completa = direccion_completa + "" + campo_8;
            }

            if (campo_9!='') {
                direccion_completa = direccion_completa + " - " + campo_9;
            }

            if (campo_10!='') {
                direccion_completa = direccion_completa + " " + campo_10;
            }

            if (campo_11!='') {
                direccion_completa = direccion_completa + " " + campo_11;
            }

            if (campo_12!='') {
                direccion_completa = direccion_completa + " " + campo_12;
            }

            if (campo_13!='') {
                direccion_completa = direccion_completa + " " + campo_13;
            }
        }

        $('#direccion_completa').val(direccion_completa);

        $('#btn_guardar_direccion').removeClass('d-block').addClass('d-none');
        if (campo_1!='' && campo_7!='' && campo_9!='') {
            $('#btn_guardar_direccion').removeClass('d-none').addClass('d-block');
            if (campo_12=='' && campo_13=='') {
                geocodeAddress();
            }
        }
    }
</script>