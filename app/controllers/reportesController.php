<?php
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    require_once(ROOT.'app/plugins/PhpSpreadsheet/vendor/autoload.php');
    class reportesController extends Controller {
        function __construct()
        {
        }

        function seleccion_aspirantes() {
            // error_reporting(E_ALL);
            // ini_set('display_errors', '1');
            Controller::checkSesion();
            $tipo_reporte=checkInput($_POST['tipo_reporte']);
            $hva_area=checkInput($_POST['hva_area']);
            $hva_cargo=checkInput($_POST['hva_cargo']);
            $hva_psicologo=checkInput($_POST['hva_psicologo']);
            $fecha_inicio=checkInput($_POST['fecha_inicio']);
            $fecha_fin=checkInput($_POST['fecha_fin']);
            $estado=checkInput($_POST['estado']);
            
            try {
                $modulo_perfil=$_SESSION[APP_SESSION.'usu_modulos']['Selección'];

                $titulo_reporte="".$tipo_reporte.' - '.date('Y-m-d H_i_s').".xlsx";
                // Creamos nueva instancia de PHPExcel 
                $spreadsheet = new Spreadsheet();

                // Establecer propiedades
                $spreadsheet->getProperties()
                ->setCreator(APP_NAME_ALL)
                ->setLastModifiedBy($_SESSION[APP_SESSION.'usu_nombre'])
                ->setTitle(APP_NAME_ALL)
                ->setSubject(APP_NAME_ALL)
                ->setDescription(APP_NAME_ALL)
                ->setKeywords(APP_NAME_ALL)
                ->setCategory("Reporte");

                require_once(INCLUDES."inc_excel_style.php");

                //Activar hoja 0
                $sheet = $spreadsheet->getActiveSheet(0);
                
                // Nombramos la hoja 0 
                if ($tipo_reporte=='Consolidado') {
                    $registros = new hv_aspiranteModel();
                    $registros->hvao_area=$hva_area;
                    $registros->hvao_cargo=$hva_cargo;
                    $registros->hvao_psicologo=$hva_psicologo;
                    $registros->hva_estado=$estado;
                    $registros->hva_registro_fecha=$fecha_inicio;
                    $registros->hva_registro_fecha_2=$fecha_fin;
                    $registros->filtro_perfil=$modulo_perfil;

                    $resregistros=$registros->listAllReport();
                    
                    if (!isset($resregistros[0])) {
                        $resregistros=array();
                    }

                    // Valida Información en caso de Emergencia
                    $aspirante_emergencia = new hv_aspirante_emergenciaModel();
                    $resaspirante_emergencia=$aspirante_emergencia->listAllReport();

                    if (!isset($resaspirante_emergencia[0])) {
                        $resaspirante_emergencia=array();
                    }

                    $array_emergencia=array();
                    for ($i=0; $i < count($resaspirante_emergencia); $i++) { 
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_nombres_apellidos'] = $resaspirante_emergencia[$i]['hvaem_nombres_apellidos'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_parentesco'] = $resaspirante_emergencia[$i]['hvaem_parentesco'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_telefono'] = $resaspirante_emergencia[$i]['hvaem_telefono'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_grupo_sanguineo'] = $resaspirante_emergencia[$i]['hvaem_grupo_sanguineo'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_rh'] = $resaspirante_emergencia[$i]['hvaem_rh'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_antecedentes'] = $resaspirante_emergencia[$i]['hvaem_antecedentes'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_registro_usuario'] = $resaspirante_emergencia[$i]['hvaem_registro_usuario'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_registro_fecha'] = $resaspirante_emergencia[$i]['hvaem_registro_fecha'];
                    }

                    // Valida Información Familiar
                    $aspirante_familiar = new hv_aspirante_familiarModel();
                    $resaspirante_familiar=$aspirante_familiar->listAllReport();

                    if (!isset($resaspirante_familiar[0])) {
                        $resaspirante_familiar=array();
                    }

                    $array_familiar=array();
                    for ($i=0; $i < count($resaspirante_familiar); $i++) { 
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_nombres_apellidos'] = $resaspirante_familiar[$i]['hvaf_nombres_apellidos'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_parentesco'] = $resaspirante_familiar[$i]['hvaf_parentesco'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_edad'] = $resaspirante_familiar[$i]['hvaf_edad'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_nivel_educativo'] = $resaspirante_familiar[$i]['hvaf_nivel_educativo'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_acargo'] = $resaspirante_familiar[$i]['hvaf_acargo'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_convive'] = $resaspirante_familiar[$i]['hvaf_convive'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_registro_usuario'] = $resaspirante_familiar[$i]['hvaf_registro_usuario'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_registro_fecha'] = $resaspirante_familiar[$i]['hvaf_registro_fecha'];
                    }

                    // Valida Información Ética
                    $aspirante_etica = new hv_aspirante_eticaModel();
                    $resaspirante_etica=$aspirante_etica->listAllReport();

                    if (!isset($resaspirante_etica[0])) {
                        $resaspirante_etica=array();
                    }

                    $array_etica=array();
                    for ($i=0; $i < count($resaspirante_etica); $i++) { 
                        $array_etica[$resaspirante_etica[$i]['hvae_aspirante']]['hvae_familiar'] = $resaspirante_etica[$i]['hvae_familiar'];
                        $array_etica[$resaspirante_etica[$i]['hvae_aspirante']]['hvae_familiar_nombre'] = $resaspirante_etica[$i]['hvae_familiar_nombre'];
                        $array_etica[$resaspirante_etica[$i]['hvae_aspirante']]['hvae_familiar_area'] = $resaspirante_etica[$i]['hvae_familiar_area'];
                        $array_etica[$resaspirante_etica[$i]['hvae_aspirante']]['hvae_registro_usuario'] = $resaspirante_etica[$i]['hvae_registro_usuario'];
                        $array_etica[$resaspirante_etica[$i]['hvae_aspirante']]['hvae_registro_fecha'] = $resaspirante_etica[$i]['hvae_registro_fecha'];
                    }

                    // Valida Información IQ
                    $aspirante_informacion = new hv_aspirante_informacionModel();
                    $resaspirante_informacion=$aspirante_informacion->listAllReport();

                    if (!isset($resaspirante_informacion[0])) {
                        $resaspirante_informacion=array();
                    }

                    $array_informacion=array();
                    for ($i=0; $i < count($resaspirante_informacion); $i++) { 
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_excolaborador'] = $resaspirante_informacion[$i]['hvai_excolaborador'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_excolaborador_motivo'] = $resaspirante_informacion[$i]['hvai_excolaborador_motivo'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_excolaborador_fecha'] = $resaspirante_informacion[$i]['hvai_excolaborador_fecha'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_seleccion_previo'] = $resaspirante_informacion[$i]['hvai_seleccion_previo'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_seleccion_previo_cargo'] = $resaspirante_informacion[$i]['hvai_seleccion_previo_cargo'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_seleccion_previo_fecha'] = $resaspirante_informacion[$i]['hvai_seleccion_previo_fecha'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_trabajo'] = $resaspirante_informacion[$i]['hvai_trabajo'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_trabajo_tipo'] = $resaspirante_informacion[$i]['hvai_trabajo_tipo'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_trabajo_empresa'] = $resaspirante_informacion[$i]['hvai_trabajo_empresa'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_trabajo_cargo'] = $resaspirante_informacion[$i]['hvai_trabajo_cargo'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_ocupacion'] = $resaspirante_informacion[$i]['hvai_ocupacion'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_conflicto_renuncia'] = $resaspirante_informacion[$i]['hvai_conflicto_renuncia'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_registro_usuario'] = $resaspirante_informacion[$i]['hvai_registro_usuario'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_registro_fecha'] = $resaspirante_informacion[$i]['hvai_registro_fecha'];
                    }

                    // Valida Información Financiera
                    $aspirante_financiera = new hv_aspirante_financieraModel();
                    $resaspirante_financiera=$aspirante_financiera->listAllReport();

                    if (!isset($resaspirante_financiera[0])) {
                        $resaspirante_financiera=array();
                    }

                    $array_financiera=array();
                    for ($i=0; $i < count($resaspirante_financiera); $i++) { 
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_activos'] = $resaspirante_financiera[$i]['hvaf_activos'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_pasivos'] = $resaspirante_financiera[$i]['hvaf_pasivos'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_patrimonio'] = $resaspirante_financiera[$i]['hvaf_patrimonio'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_ingresos'] = $resaspirante_financiera[$i]['hvaf_ingresos'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_egresos'] = $resaspirante_financiera[$i]['hvaf_egresos'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_ingresos_otros'] = $resaspirante_financiera[$i]['hvaf_ingresos_otros'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_concepto_ingresos'] = $resaspirante_financiera[$i]['hvaf_concepto_ingresos'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_moneda_extranjera'] = $resaspirante_financiera[$i]['hvaf_moneda_extranjera'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_reporte'] = $resaspirante_financiera[$i]['hvaf_reporte'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_reporte_cual'] = $resaspirante_financiera[$i]['hvaf_reporte_cual'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_registro_usuario'] = $resaspirante_financiera[$i]['hvaf_registro_usuario'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_registro_fecha'] = $resaspirante_financiera[$i]['hvaf_registro_fecha'];
                    }
                    
                    // Valida Personas Expuestas Públicamente - PEP
                    $aspirante_publico = new hv_aspirante_publicoModel();
                    $resaspirante_publico=$aspirante_publico->listAllReport();

                    if (!isset($resaspirante_publico[0])) {
                        $resaspirante_publico=array();
                    }

                    $array_publico=array();
                    for ($i=0; $i < count($resaspirante_publico); $i++) { 
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_recursos'] = $resaspirante_publico[$i]['hvap_recursos'];
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_reconocimiento'] = $resaspirante_publico[$i]['hvap_reconocimiento'];
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_poder'] = $resaspirante_publico[$i]['hvap_poder'];
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_familiar'] = $resaspirante_publico[$i]['hvap_familiar'];
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_observaciones'] = $resaspirante_publico[$i]['hvap_observaciones'];
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_registro_usuario'] = $resaspirante_publico[$i]['hvap_registro_usuario'];
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_registro_fecha'] = $resaspirante_publico[$i]['hvap_registro_fecha'];
                    }

                    // Valida Seguridad Social
                    $aspirante_segsocial = new hv_aspirante_seguridad_socialModel();
                    $resaspirante_segsocial=$aspirante_segsocial->listAllReport();

                    if (!isset($resaspirante_segsocial[0])) {
                        $resaspirante_segsocial=array();
                    }

                    $array_segsocial=array();
                    for ($i=0; $i < count($resaspirante_segsocial); $i++) { 
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_eps'] = $resaspirante_segsocial[$i]['hvass_eps'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_pension'] = $resaspirante_segsocial[$i]['hvass_pension'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_pension_voluntario'] = $resaspirante_segsocial[$i]['hvass_pension_voluntario'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_cesantias'] = $resaspirante_segsocial[$i]['hvass_cesantias'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_prepagada'] = $resaspirante_segsocial[$i]['hvass_prepagada'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_registro_usuario'] = $resaspirante_segsocial[$i]['hvass_registro_usuario'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_registro_fecha'] = $resaspirante_segsocial[$i]['hvass_registro_fecha'];
                    }

                    // Valida Declaraciones y Autorizaciones
                    $aspirante_autorizaciones = new hv_aspirante_autorizacionesModel();
                    $resaspirante_autorizaciones=$aspirante_autorizaciones->listAllReport();

                    if (!isset($resaspirante_autorizaciones[0])) {
                        $resaspirante_autorizaciones=array();
                    }

                    $array_autorizaciones=array();
                    for ($i=0; $i < count($resaspirante_autorizaciones); $i++) { 
                        $array_autorizaciones[$resaspirante_autorizaciones[$i]['hvada_aspirante']]['hvada_veracidad'] = $resaspirante_autorizaciones[$i]['hvada_veracidad'];
                        $array_autorizaciones[$resaspirante_autorizaciones[$i]['hvada_aspirante']]['hvada_origen_fondos'] = $resaspirante_autorizaciones[$i]['hvada_origen_fondos'];
                        $array_autorizaciones[$resaspirante_autorizaciones[$i]['hvada_aspirante']]['hvada_proteccion_datos'] = $resaspirante_autorizaciones[$i]['hvada_proteccion_datos'];
                        $array_autorizaciones[$resaspirante_autorizaciones[$i]['hvada_aspirante']]['hvada_tratamiento_datos'] = $resaspirante_autorizaciones[$i]['hvada_tratamiento_datos'];
                        $array_autorizaciones[$resaspirante_autorizaciones[$i]['hvada_aspirante']]['hvada_registro_usuario'] = $resaspirante_autorizaciones[$i]['hvada_registro_usuario'];
                        $array_autorizaciones[$resaspirante_autorizaciones[$i]['hvada_aspirante']]['hvada_registro_fecha'] = $resaspirante_autorizaciones[$i]['hvada_registro_fecha'];
                    }

                    // Valida Estudios terminados
                    $aspirante_estudio = new hv_aspirante_estudio_terminadoModel();
                    $resaspirante_estudio_terminado=$aspirante_estudio->listAllReport();

                    if (!isset($resaspirante_estudio_terminado[0])) {
                        $resaspirante_estudio_terminado=array();
                    }

                    $array_estudio_terminado=array();
                    for ($i=0; $i < count($resaspirante_estudio_terminado); $i++) { 
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_nivel'][] = $resaspirante_estudio_terminado[$i]['hvaet_nivel'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_nivel'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_nivel']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_establecimiento'][] = $resaspirante_estudio_terminado[$i]['hvaet_establecimiento'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_establecimiento'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_establecimiento']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_titulo'][] = $resaspirante_estudio_terminado[$i]['hvaet_titulo'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_titulo'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_titulo']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_ciudad'][] = $resaspirante_estudio_terminado[$i]['hvaet_ciudad'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_ciudad'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_ciudad']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_fecha_inicio'][] = $resaspirante_estudio_terminado[$i]['hvaet_fecha_inicio'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_fecha_inicio'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_fecha_inicio']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_fecha_terminacion'][] = $resaspirante_estudio_terminado[$i]['hvaet_fecha_terminacion'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_fecha_terminacion'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_fecha_terminacion']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_tarjeta_profesional'][] = $resaspirante_estudio_terminado[$i]['hvaet_tarjeta_profesional'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_tarjeta_profesional'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_tarjeta_profesional']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['ciudad'][] = $resaspirante_estudio_terminado[$i]['ciu_municipio'].', '.$resaspirante_estudio_terminado[$i]['ciu_departamento'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['ciudad'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['ciudad']=array();
                        }
                    }

                    $aspirante_experiencia = new hv_aspirante_experienciaModel();
                    $resaspirante_experiencia=$aspirante_experiencia->listAllReport();

                    if (!isset($resaspirante_experiencia[0])) {
                        $resaspirante_experiencia=array();
                    }
                    
                    
                    $array_experiencia=array();
                    for ($i=0; $i < count($resaspirante_experiencia); $i++) { 
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_empresa'][] = $resaspirante_experiencia[$i]['hvaex_empresa'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_empresa'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_empresa']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_cargo'][] = $resaspirante_experiencia[$i]['hvaex_cargo'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_cargo'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_cargo']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_fecha_inicio'][] = $resaspirante_experiencia[$i]['hvaex_fecha_inicio'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_fecha_inicio'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_fecha_inicio']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_fecha_retiro'][] = $resaspirante_experiencia[$i]['hvaex_fecha_retiro'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_fecha_retiro'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_fecha_retiro']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_ciudad'][] = $resaspirante_experiencia[$i]['hvaex_ciudad'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_ciudad'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_ciudad']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_jefe_nombre'][] = $resaspirante_experiencia[$i]['hvaex_jefe_nombre'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_jefe_nombre'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_jefe_nombre']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_jefe_cargo'][] = $resaspirante_experiencia[$i]['hvaex_jefe_cargo'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_jefe_cargo'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_jefe_cargo']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_telefonos'][] = $resaspirante_experiencia[$i]['hvaex_telefonos'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_telefonos'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_telefonos']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_motivo_retiro'][] = $resaspirante_experiencia[$i]['hvaex_motivo_retiro'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_motivo_retiro'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_motivo_retiro']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['ciudad'][] = $resaspirante_experiencia[$i]['ciu_municipio'].', '.$resaspirante_experiencia[$i]['ciu_departamento'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['ciudad'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['ciudad']=array();
                        }
                    }
                    
                    //Estilos de la Hoja 0
                    $spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(80);
                    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AE')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AG')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AH')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AI')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AJ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AK')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AL')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AM')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AN')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AO')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AP')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AQ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AR')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AS')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AT')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AU')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AV')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AW')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AX')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AY')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AZ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BA')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BB')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BC')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BD')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BE')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BF')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BG')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BH')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BI')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BJ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BK')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BL')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BM')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BN')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BO')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BP')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BQ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BR')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BS')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BT')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BU')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BV')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BW')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BX')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BY')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BZ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CA')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CB')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CC')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CD')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CE')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CF')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CG')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CH')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CI')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CJ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getStyle('A4:BZ4')->applyFromArray($styleArrayTitulos);
                    $spreadsheet->getActiveSheet()->setAutoFilter('A4:BZ4');
                    $spreadsheet->getActiveSheet()->getStyle('3')->getAlignment()->setWrapText(true);
                    $spreadsheet->getActiveSheet()->getStyle('4')->getAlignment()->setWrapText(true);

                    // Escribiendo los titulos
                    $spreadsheet->getActiveSheet()->setCellValue('BH3','Experiencia Laboral');
                    $spreadsheet->getActiveSheet()->setCellValue('BQ3','Estudios Terminados');
                    


                    $spreadsheet->getActiveSheet()->setCellValue('A4','Estado');
                    $spreadsheet->getActiveSheet()->setCellValue('B4','No Identificación');
                    $spreadsheet->getActiveSheet()->setCellValue('C4','Fecha de Expedición');
                    $spreadsheet->getActiveSheet()->setCellValue('D4','Primer Nombre');
                    $spreadsheet->getActiveSheet()->setCellValue('E4','Segundo Nombre');
                    $spreadsheet->getActiveSheet()->setCellValue('F4','Primero Apellido');
                    $spreadsheet->getActiveSheet()->setCellValue('G4','Segundo Apellido');
                    $spreadsheet->getActiveSheet()->setCellValue('H4','Dirección');
                    $spreadsheet->getActiveSheet()->setCellValue('I4','Barrio');
                    $spreadsheet->getActiveSheet()->setCellValue('J4','Ciudad');
                    $spreadsheet->getActiveSheet()->setCellValue('K4','Departamento');
                    $spreadsheet->getActiveSheet()->setCellValue('L4','Celular');
                    $spreadsheet->getActiveSheet()->setCellValue('M4','Celular Alternativo');
                    $spreadsheet->getActiveSheet()->setCellValue('N4','Email');
                    $spreadsheet->getActiveSheet()->setCellValue('O4','Email Corporativo');
                    $spreadsheet->getActiveSheet()->setCellValue('P4','Lugar de Nacimiento');
                    $spreadsheet->getActiveSheet()->setCellValue('Q4','Fecha Nacimiento');
                    $spreadsheet->getActiveSheet()->setCellValue('R4','Edad');
                    $spreadsheet->getActiveSheet()->setCellValue('S4','Estado Civil');
                    $spreadsheet->getActiveSheet()->setCellValue('T4','Género');
                    $spreadsheet->getActiveSheet()->setCellValue('U4','Grupo Sanguíneo');
                    $spreadsheet->getActiveSheet()->setCellValue('V4','RH');
                    $spreadsheet->getActiveSheet()->setCellValue('W4','Operador Internet');
                    $spreadsheet->getActiveSheet()->setCellValue('X4','Información Emergencia-Nombres y Apellidos');
                    $spreadsheet->getActiveSheet()->setCellValue('Y4','Información Emergencia-Parentesco');
                    $spreadsheet->getActiveSheet()->setCellValue('Z4','Información Emergencia-Teléfono');
                    $spreadsheet->getActiveSheet()->setCellValue('AA4','¿Tiene usted familiares, conyugue y/o compañero permanente, parientes dentro del cuarto grado de consanguinidad, tercero de afinidad o único civil que actualmente trabaje en IQ?');
                    $spreadsheet->getActiveSheet()->setCellValue('AB4','Nombres y Apellidos');
                    $spreadsheet->getActiveSheet()->setCellValue('AC4','Área');
                    $spreadsheet->getActiveSheet()->setCellValue('AD4','¿Ha trabajado anteriormente en IQ?');
                    $spreadsheet->getActiveSheet()->setCellValue('AE4','Motivo del retiro');
                    $spreadsheet->getActiveSheet()->setCellValue('AF4','Fecha de retiro');
                    $spreadsheet->getActiveSheet()->setCellValue('AG4','¿Ha presentado procesos de selección previamente en IQ?');
                    $spreadsheet->getActiveSheet()->setCellValue('AH4','Cargo');
                    $spreadsheet->getActiveSheet()->setCellValue('AI4','Fecha');
                    $spreadsheet->getActiveSheet()->setCellValue('AJ4','¿Declara tener otro trabajo u ocupación simultánea?');
                    $spreadsheet->getActiveSheet()->setCellValue('AK4','Tipo de vinculación');
                    $spreadsheet->getActiveSheet()->setCellValue('AL4','Nombre de la empresa');
                    $spreadsheet->getActiveSheet()->setCellValue('AM4','Cargo');
                    $spreadsheet->getActiveSheet()->setCellValue('AN4','Ocupación o trabajo desempeñado');
                    $spreadsheet->getActiveSheet()->setCellValue('AO4','¿Si su ocupación actual genera conflicto de interés, estaría dispuesto a renunciar a su trabajo actual?');
                    $spreadsheet->getActiveSheet()->setCellValue('AP4','Activos');
                    $spreadsheet->getActiveSheet()->setCellValue('AQ4','Pasivos');
                    $spreadsheet->getActiveSheet()->setCellValue('AR4','Patrimonio');
                    $spreadsheet->getActiveSheet()->setCellValue('AS4','Ingresos mensuales');
                    $spreadsheet->getActiveSheet()->setCellValue('AT4','Egresos mensuales');
                    $spreadsheet->getActiveSheet()->setCellValue('AU4','Otros ingresos');
                    $spreadsheet->getActiveSheet()->setCellValue('AV4','Concepto de otros ingresos');
                    $spreadsheet->getActiveSheet()->setCellValue('AW4','¿Realiza Operaciones en Moneda Extranjera?');
                    $spreadsheet->getActiveSheet()->setCellValue('AX4','¿Maneja recursos públicos?');
                    $spreadsheet->getActiveSheet()->setCellValue('AY4','¿Goza de reconocimiento público general?');
                    $spreadsheet->getActiveSheet()->setCellValue('AZ4','¿Ejerce algún grado de poder público?');
                    $spreadsheet->getActiveSheet()->setCellValue('BA4','¿Tiene usted algún familiar que cumpla con una característica anterior?');
                    $spreadsheet->getActiveSheet()->setCellValue('BB4','Si alguna de las respuestas anteriores es afirmativa, por favor especifique');
                    $spreadsheet->getActiveSheet()->setCellValue('BC4','EPS');
                    $spreadsheet->getActiveSheet()->setCellValue('BD4','Fondo de pensión');
                    $spreadsheet->getActiveSheet()->setCellValue('BE4','Fondo de cesantías');
                    $spreadsheet->getActiveSheet()->setCellValue('BF4','Fondo voluntario de pensión');
                    $spreadsheet->getActiveSheet()->setCellValue('BG4','Medicina prepagada');
                    
                    $spreadsheet->getActiveSheet()->setCellValue('BH4','Empresa');
                    $spreadsheet->getActiveSheet()->setCellValue('BI4','Cargo');
                    $spreadsheet->getActiveSheet()->setCellValue('BJ4','Fecha inicio');
                    $spreadsheet->getActiveSheet()->setCellValue('BK4','Fecha retiro');
                    $spreadsheet->getActiveSheet()->setCellValue('BL4','Ciudad');
                    $spreadsheet->getActiveSheet()->setCellValue('BM4','Jefe nombre');
                    $spreadsheet->getActiveSheet()->setCellValue('BN4','Jefe cargo');
                    $spreadsheet->getActiveSheet()->setCellValue('BO4','Teléfonos');
                    $spreadsheet->getActiveSheet()->setCellValue('BP4','Motivo retiro');

                    $spreadsheet->getActiveSheet()->setCellValue('BQ4','Nivel');
                    $spreadsheet->getActiveSheet()->setCellValue('BR4','Establecimiento');
                    $spreadsheet->getActiveSheet()->setCellValue('BS4','Titulo');
                    $spreadsheet->getActiveSheet()->setCellValue('BT4','Ciudad');
                    $spreadsheet->getActiveSheet()->setCellValue('BU4','Fecha inicio');
                    $spreadsheet->getActiveSheet()->setCellValue('BV4','Fecha terminacion');
                    $spreadsheet->getActiveSheet()->setCellValue('BW4','Tarjeta profesional');
                    $spreadsheet->getActiveSheet()->setCellValue('BX4','Fecha Diligenciamiento');
                    
                    $spreadsheet->getActiveSheet()->setCellValue('A1','Reporte: Consolidado de Aspirantes');
                    
                    // Ingresar Data consultada a partir de la fila 4
                    for ($i=5; $i < count($resregistros)+5; $i++) {
                        $id_aspirante=$resregistros[$i-5]['hva_id'];

                        $edad_aspirante='';
                        if ($resregistros[$i-5]['hva_nacimiento_fecha']!='') {
                            $edad_aspirante=calcularEdad($resregistros[$i-5]['hva_nacimiento_fecha']);
                        }

                        $spreadsheet->getActiveSheet()->setCellValue('A'.$i,mb_strtoupper($resregistros[$i-5]['hva_estado']));
                        $spreadsheet->getActiveSheet()->setCellValue('B'.$i,mb_strtoupper($resregistros[$i-5]['hva_identificacion']));//No Identificación
                        $spreadsheet->getActiveSheet()->setCellValue('C'.$i,mb_strtoupper($resregistros[$i-5]['hva_auxiliar_5']));//Fecha Expedición
                        $spreadsheet->getActiveSheet()->setCellValue('D'.$i,mb_strtoupper($resregistros[$i-5]['hva_nombres']));//Primer Nombre
                        $spreadsheet->getActiveSheet()->setCellValue('E'.$i,mb_strtoupper($resregistros[$i-5]['hva_nombres_2']));//Segundo Nombre
                        $spreadsheet->getActiveSheet()->setCellValue('F'.$i,mb_strtoupper($resregistros[$i-5]['hva_apellido_1']));//Primero Apellido
                        $spreadsheet->getActiveSheet()->setCellValue('G'.$i,mb_strtoupper($resregistros[$i-5]['hva_apellido_2']));//Segundo Apellido
                        $spreadsheet->getActiveSheet()->setCellValue('H'.$i,mb_strtoupper($resregistros[$i-5]['hva_direccion']));//Dirección
                        $spreadsheet->getActiveSheet()->setCellValue('I'.$i,mb_strtoupper($resregistros[$i-5]['hva_barrio']));//Barrio
                        $spreadsheet->getActiveSheet()->setCellValue('J'.$i,mb_strtoupper($resregistros[$i-5]['ciu_municipio']));//Ciudad
                        $spreadsheet->getActiveSheet()->setCellValue('K'.$i,mb_strtoupper($resregistros[$i-5]['ciu_departamento']));//Departamento
                        $spreadsheet->getActiveSheet()->setCellValue('L'.$i,mb_strtoupper($resregistros[$i-5]['hva_celular']));//Celular
                        $spreadsheet->getActiveSheet()->setCellValue('M'.$i,mb_strtoupper($resregistros[$i-5]['hva_celular_2']));//Celular Alternativo
                        $spreadsheet->getActiveSheet()->setCellValue('N'.$i,strtolower($resregistros[$i-5]['hva_correo']));//Email
                        $spreadsheet->getActiveSheet()->setCellValue('O'.$i,strtolower($resregistros[$i-5]['hva_correo_corporativo']));//Email
                        $spreadsheet->getActiveSheet()->setCellValue('P'.$i,mb_strtoupper($resregistros[$i-5]['nacimiento_ciu_municipio']).', '.mb_strtoupper($resregistros[$i-5]['nacimiento_ciu_departamento']));//Lugar de Nacimiento
                        $spreadsheet->getActiveSheet()->setCellValue('Q'.$i,mb_strtoupper($resregistros[$i-5]['hva_nacimiento_fecha']));//Fecha Nacimiento
                        $spreadsheet->getActiveSheet()->setCellValue('R'.$i,$edad_aspirante);//Edad
                        $spreadsheet->getActiveSheet()->setCellValue('S'.$i,mb_strtoupper($resregistros[$i-5]['hva_estado_civil']));//Estado Civil
                        $spreadsheet->getActiveSheet()->setCellValue('T'.$i,mb_strtoupper($resregistros[$i-5]['hva_genero']));//Género
                        $spreadsheet->getActiveSheet()->setCellValue('U'.$i,mb_strtoupper($array_emergencia[$id_aspirante]['hvaem_grupo_sanguineo']));//Grupo Sanguíneo
                        $spreadsheet->getActiveSheet()->setCellValue('V'.$i,mb_strtoupper($array_emergencia[$id_aspirante]['hvaem_rh']));//RH
                        $spreadsheet->getActiveSheet()->setCellValue('W'.$i,mb_strtoupper($resregistros[$i-5]['hva_operador_internet']));//Operador Internet
                        $spreadsheet->getActiveSheet()->setCellValue('X'.$i,mb_strtoupper($array_emergencia[$id_aspirante]['hvaem_nombres_apellidos']));//Información Emergencia-Nombres y Apellidos
                        $spreadsheet->getActiveSheet()->setCellValue('Y'.$i,mb_strtoupper($array_emergencia[$id_aspirante]['hvaem_parentesco']));//Información Emergencia-Parentesco
                        $spreadsheet->getActiveSheet()->setCellValue('Z'.$i,mb_strtoupper($array_emergencia[$id_aspirante]['hvaem_telefono']));//Información Emergencia-Teléfono
                        $spreadsheet->getActiveSheet()->setCellValue('AA'.$i,mb_strtoupper($array_etica[$id_aspirante]['hvae_familiar']));//¿Tiene usted familiares, conyugue y/o compañero permanente
                        $spreadsheet->getActiveSheet()->setCellValue('AB'.$i,mb_strtoupper($array_etica[$id_aspirante]['hvae_familiar_nombre']));//Nombres y Apellidos
                        $spreadsheet->getActiveSheet()->setCellValue('AC'.$i,mb_strtoupper($array_etica[$id_aspirante]['hvae_familiar_area']));//Área
                        $spreadsheet->getActiveSheet()->setCellValue('AD'.$i,mb_strtoupper($array_informacion[$id_aspirante]['hvai_excolaborador']));//¿Ha trabajado anteriormente en IQ?
                        $spreadsheet->getActiveSheet()->setCellValue('AE'.$i,mb_strtoupper($array_informacion[$id_aspirante]['hvai_excolaborador_motivo']));//Motivo del retiro
                        $spreadsheet->getActiveSheet()->setCellValue('AF'.$i,mb_strtoupper($array_informacion[$id_aspirante]['hvai_excolaborador_fecha']));//Fecha de retiro
                        $spreadsheet->getActiveSheet()->setCellValue('AG'.$i,mb_strtoupper($array_informacion[$id_aspirante]['hvai_seleccion_previo']));//¿Ha presentado procesos de selección previamente en IQ?
                        $spreadsheet->getActiveSheet()->setCellValue('AH'.$i,mb_strtoupper($array_informacion[$id_aspirante]['hvai_seleccion_previo_cargo']));//Cargo
                        $spreadsheet->getActiveSheet()->setCellValue('AI'.$i,mb_strtoupper($array_informacion[$id_aspirante]['hvai_seleccion_previo_fecha']));//Fecha
                        $spreadsheet->getActiveSheet()->setCellValue('AJ'.$i,mb_strtoupper($array_informacion[$id_aspirante]['hvai_trabajo']));//¿Declara tener otro trabajo u ocupación simultánea?
                        $spreadsheet->getActiveSheet()->setCellValue('AK'.$i,mb_strtoupper($array_informacion[$id_aspirante]['hvai_trabajo_tipo']));//Tipo de vinculación
                        $spreadsheet->getActiveSheet()->setCellValue('AL'.$i,mb_strtoupper($array_informacion[$id_aspirante]['hvai_trabajo_empresa']));//Nombre de la empresa
                        $spreadsheet->getActiveSheet()->setCellValue('AM'.$i,mb_strtoupper($array_informacion[$id_aspirante]['hvai_trabajo_cargo']));//Cargo
                        $spreadsheet->getActiveSheet()->setCellValue('AN'.$i,mb_strtoupper($array_informacion[$id_aspirante]['hvai_ocupacion']));//Ocupación o trabajo desempeñado
                        $spreadsheet->getActiveSheet()->setCellValue('AO'.$i,mb_strtoupper($array_informacion[$id_aspirante]['hvai_conflicto_renuncia']));//¿Si su ocupación actual genera conflicto de interés, estaría dispuesto a renunciar
                        $spreadsheet->getActiveSheet()->setCellValue('AP'.$i,mb_strtoupper($array_financiera[$id_aspirante]['hvaf_activos']));//Activos
                        $spreadsheet->getActiveSheet()->setCellValue('AQ'.$i,mb_strtoupper($array_financiera[$id_aspirante]['hvaf_pasivos']));//Pasivos
                        $spreadsheet->getActiveSheet()->setCellValue('AR'.$i,mb_strtoupper($array_financiera[$id_aspirante]['hvaf_patrimonio']));//Patrimonio
                        $spreadsheet->getActiveSheet()->setCellValue('AS'.$i,mb_strtoupper($array_financiera[$id_aspirante]['hvaf_ingresos']));//Ingresos mensuales
                        $spreadsheet->getActiveSheet()->setCellValue('AT'.$i,mb_strtoupper($array_financiera[$id_aspirante]['hvaf_egresos']));//Egresos mensuales
                        $spreadsheet->getActiveSheet()->setCellValue('AU'.$i,mb_strtoupper($array_financiera[$id_aspirante]['hvaf_ingresos_otros']));//Otros ingresos
                        $spreadsheet->getActiveSheet()->setCellValue('AV'.$i,mb_strtoupper($array_financiera[$id_aspirante]['hvaf_concepto_ingresos']));//Concepto de otros ingresos
                        $spreadsheet->getActiveSheet()->setCellValue('AW'.$i,mb_strtoupper($array_financiera[$id_aspirante]['hvaf_moneda_extranjera']));//¿Realiza Operaciones en Moneda Extranjera?
                        $spreadsheet->getActiveSheet()->setCellValue('AX'.$i,mb_strtoupper($array_publico[$id_aspirante]['hvap_recursos']));//¿Maneja recursos públicos?
                        $spreadsheet->getActiveSheet()->setCellValue('AY'.$i,mb_strtoupper($array_publico[$id_aspirante]['hvap_reconocimiento']));//¿Goza de reconocimiento público general?
                        $spreadsheet->getActiveSheet()->setCellValue('AZ'.$i,mb_strtoupper($array_publico[$id_aspirante]['hvap_poder']));//¿Ejerce algún grado de poder público?
                        $spreadsheet->getActiveSheet()->setCellValue('BA'.$i,mb_strtoupper($array_publico[$id_aspirante]['hvap_familiar']));//¿Tiene usted algún familiar que cumpla con una característica anterior?
                        $spreadsheet->getActiveSheet()->setCellValue('BB'.$i,mb_strtoupper($array_publico[$id_aspirante]['hvap_observaciones']));//Si alguna de las respuestas anteriores es afirmativa, por favor especifique
                        $spreadsheet->getActiveSheet()->setCellValue('BC'.$i,mb_strtoupper($array_segsocial[$id_aspirante]['hvass_eps']));//EPS
                        $spreadsheet->getActiveSheet()->setCellValue('BD'.$i,mb_strtoupper($array_segsocial[$id_aspirante]['hvass_pension']));//Fondo de pensión
                        $spreadsheet->getActiveSheet()->setCellValue('BE'.$i,mb_strtoupper($array_segsocial[$id_aspirante]['hvass_pension_voluntario']));//Fondo de cesantías
                        $spreadsheet->getActiveSheet()->setCellValue('BF'.$i,mb_strtoupper($array_segsocial[$id_aspirante]['hvass_cesantias']));//Fondo voluntario de pensión
                        $spreadsheet->getActiveSheet()->setCellValue('BG'.$i,mb_strtoupper($array_segsocial[$id_aspirante]['hvass_prepagada']));//Medicina prepagada
                        
                        if(isset($array_experiencia[$id_aspirante]['hvaex_empresa'][0])){
                            $hvaex_empresa=implode(';', $array_experiencia[$id_aspirante]['hvaex_empresa']);

                        } else {
                            $hvaex_empresa='';
                        }
                        if(isset($array_experiencia[$id_aspirante]['hvaex_cargo'][0])){
                            $hvaex_cargo=implode(';', $array_experiencia[$id_aspirante]['hvaex_cargo']);

                        } else {
                            $hvaex_cargo='';
                        }
                        if(isset($array_experiencia[$id_aspirante]['hvaex_fecha_inicio'][0])){
                            $hvaex_fecha_inicio=implode(';', $array_experiencia[$id_aspirante]['hvaex_fecha_inicio']);

                        } else {
                            $hvaex_fecha_inicio='';
                        }
                        if(isset($array_experiencia[$id_aspirante]['hvaex_fecha_retiro'][0])){
                            $hvaex_fecha_retiro=implode(';', $array_experiencia[$id_aspirante]['hvaex_fecha_retiro']);

                        } else {
                            $hvaex_fecha_retiro='';
                        }
                        if(isset($array_experiencia[$id_aspirante]['hvaex_jefe_nombre'][0])){
                            $hvaex_jefe_nombre=implode(';', $array_experiencia[$id_aspirante]['hvaex_jefe_nombre']);

                        } else {
                            $hvaex_jefe_nombre='';
                        }
                        if(isset($array_experiencia[$id_aspirante]['hvaex_jefe_cargo'][0])){
                            $hvaex_jefe_cargo=implode(';', $array_experiencia[$id_aspirante]['hvaex_jefe_cargo']);

                        } else {
                            $hvaex_jefe_cargo='';
                        }
                        if(isset($array_experiencia[$id_aspirante]['hvaex_telefonos'][0])){
                            $hvaex_telefonos=implode(';', $array_experiencia[$id_aspirante]['hvaex_telefonos']);

                        } else {
                            $hvaex_telefonos='';
                        }
                        if(isset($array_experiencia[$id_aspirante]['hvaex_motivo_retiro'][0])){
                            $hvaex_motivo_retiro=implode(';', $array_experiencia[$id_aspirante]['hvaex_motivo_retiro']);

                        } else {
                            $hvaex_motivo_retiro='';
                        }
                        if(isset($array_experiencia[$id_aspirante]['ciudad'][0])){
                            $ciudad=implode(';', $array_experiencia[$id_aspirante]['ciudad']);

                        } else {
                            $ciudad='';
                        }
                        
                        $spreadsheet->getActiveSheet()->setCellValue('BH'.$i,mb_strtoupper($hvaex_empresa));
                        $spreadsheet->getActiveSheet()->setCellValue('BI'.$i,mb_strtoupper($hvaex_cargo));
                        $spreadsheet->getActiveSheet()->setCellValue('BJ'.$i,mb_strtoupper($hvaex_fecha_inicio));
                        $spreadsheet->getActiveSheet()->setCellValue('BK'.$i,mb_strtoupper($hvaex_fecha_retiro));
                        $spreadsheet->getActiveSheet()->setCellValue('BL'.$i,mb_strtoupper($ciudad));
                        $spreadsheet->getActiveSheet()->setCellValue('BM'.$i,mb_strtoupper($hvaex_jefe_nombre));
                        $spreadsheet->getActiveSheet()->setCellValue('BN'.$i,mb_strtoupper($hvaex_jefe_cargo));
                        $spreadsheet->getActiveSheet()->setCellValue('BO'.$i,mb_strtoupper($hvaex_telefonos));
                        $spreadsheet->getActiveSheet()->setCellValue('BP'.$i,mb_strtoupper($hvaex_motivo_retiro));

                        if (isset($array_estudio_terminado[$id_aspirante]['hvaet_nivel'][0])) {
                            $hvaet_nivel=implode(';', $array_estudio_terminado[$id_aspirante]['hvaet_nivel']);
                            
                        } else {
                            $hvaet_nivel='';
                        }
                        if (isset($array_estudio_terminado[$id_aspirante]['hvaet_establecimiento'][0])) {
                            $hvaet_establecimiento=implode(';', $array_estudio_terminado[$id_aspirante]['hvaet_establecimiento']);
                            
                        } else {
                            $hvaet_establecimiento='';
                        }
                        if (isset($array_estudio_terminado[$id_aspirante]['hvaet_titulo'][0])) {
                            $hvaet_titulo=implode(';', $array_estudio_terminado[$id_aspirante]['hvaet_titulo']);
                            
                        } else {
                            $hvaet_titulo='';
                        }
                        if (isset($array_estudio_terminado[$id_aspirante]['hvaet_fecha_inicio'][0])) {
                            $hvaet_fecha_inicio=implode(';', $array_estudio_terminado[$id_aspirante]['hvaet_fecha_inicio']);
                            
                        } else {
                            $hvaet_fecha_inicio='';
                        }
                        if (isset($array_estudio_terminado[$id_aspirante]['hvaet_fecha_terminacion'][0])) {
                            $hvaet_fecha_terminacion=implode(';', $array_estudio_terminado[$id_aspirante]['hvaet_fecha_terminacion']);
                            
                        } else {
                            $hvaet_fecha_terminacion='';
                        }
                        if (isset($array_estudio_terminado[$id_aspirante]['hvaet_tarjeta_profesional'][0])) {
                            $hvaet_tarjeta_profesional=implode(';', $array_estudio_terminado[$id_aspirante]['hvaet_tarjeta_profesional']);
                            
                        } else {
                            $hvaet_tarjeta_profesional='';
                        }
                        if (isset($array_estudio_terminado[$id_aspirante]['ciudad'][0])) {
                            $ciudad=implode(';', $array_estudio_terminado[$id_aspirante]['ciudad']);
                            
                        } else {
                            $ciudad='';
                        }

                        $spreadsheet->getActiveSheet()->setCellValue('BQ'.$i,mb_strtoupper($hvaet_nivel));
                        $spreadsheet->getActiveSheet()->setCellValue('BR'.$i,mb_strtoupper($hvaet_establecimiento));
                        $spreadsheet->getActiveSheet()->setCellValue('BS'.$i,mb_strtoupper($hvaet_titulo));
                        $spreadsheet->getActiveSheet()->setCellValue('BT'.$i,mb_strtoupper($ciudad));
                        $spreadsheet->getActiveSheet()->setCellValue('BU'.$i,mb_strtoupper($hvaet_fecha_inicio));
                        $spreadsheet->getActiveSheet()->setCellValue('BV'.$i,mb_strtoupper($hvaet_fecha_terminacion));
                        $spreadsheet->getActiveSheet()->setCellValue('BW'.$i,mb_strtoupper($hvaet_tarjeta_profesional));
                        $spreadsheet->getActiveSheet()->setCellValue('BX'.$i,$resregistros[$i-5]['hvao_fecha_diligencia']);
                    }
                } elseif ($tipo_reporte=='Ofertas') {
                    $ofertas = new hv_aspirante_ofertaModel();
                    $ofertas->hvao_area=$hvao_area;
                    $ofertas->hvao_cargo=$hvao_cargo;
                    $ofertas->hvao_psicologo=$hvao_psicologo;
                    $ofertas->hvao_estado=$estado;
                    // $ofertas->hvao_registro_fecha=$fecha_inicio;
                    // $ofertas->hvao_registro_fecha_2=$fecha_fin;
                    $resregistros=$ofertas->listAllReport();
                    
                    if (!isset($resregistros[0])) {
                        $resregistros=array();
                    }
    
                    //Estilos de la Hoja 0
                    $spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(80);
                    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AE')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AG')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AH')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AI')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AJ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AK')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AL')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AM')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AN')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AO')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AP')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AQ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AR')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AS')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AT')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AU')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AV')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AW')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AX')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AY')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AZ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BA')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BB')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BC')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BD')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BE')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BF')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BG')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BH')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BI')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BJ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BK')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BL')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BM')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BN')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BO')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BP')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BQ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BR')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BS')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BT')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BU')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BV')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BW')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BX')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BY')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BZ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CA')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CB')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CC')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CD')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CE')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CF')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CG')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CH')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CI')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CJ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getStyle('A4:BG4')->applyFromArray($styleArrayTitulos);
                    $spreadsheet->getActiveSheet()->setAutoFilter('A4:BG4');
                    $spreadsheet->getActiveSheet()->getStyle('3')->getAlignment()->setWrapText(true);
                    $spreadsheet->getActiveSheet()->getStyle('4')->getAlignment()->setWrapText(true);

                    // Escribiendo los titulos
                    $spreadsheet->getActiveSheet()->setCellValue('A4','Estado');
                    $spreadsheet->getActiveSheet()->setCellValue('B4','No Identificación');
                    $spreadsheet->getActiveSheet()->setCellValue('C4','Primer Nombre');
                    $spreadsheet->getActiveSheet()->setCellValue('D4','Segundo Nombre');
                    $spreadsheet->getActiveSheet()->setCellValue('E4','Primero Apellido');
                    $spreadsheet->getActiveSheet()->setCellValue('F4','Segundo Apellido');
                    $spreadsheet->getActiveSheet()->setCellValue('G4','Dirección');
                    $spreadsheet->getActiveSheet()->setCellValue('H4','Barrio');
                    $spreadsheet->getActiveSheet()->setCellValue('I4','Ciudad');
                    $spreadsheet->getActiveSheet()->setCellValue('J4','Departamento');
                    $spreadsheet->getActiveSheet()->setCellValue('K4','Celular');
                    $spreadsheet->getActiveSheet()->setCellValue('L4','Celular Alternativo');
                    $spreadsheet->getActiveSheet()->setCellValue('M4','Email');
                    $spreadsheet->getActiveSheet()->setCellValue('N4','Lugar de Nacimiento');
                    $spreadsheet->getActiveSheet()->setCellValue('O4','Fecha Nacimiento');
                    $spreadsheet->getActiveSheet()->setCellValue('P4','Edad');
                    $spreadsheet->getActiveSheet()->setCellValue('Q4','Estado Civil');
                    $spreadsheet->getActiveSheet()->setCellValue('R4','Género');
                    $spreadsheet->getActiveSheet()->setCellValue('S4','Área');
                    $spreadsheet->getActiveSheet()->setCellValue('T4','Cargo');
                    $spreadsheet->getActiveSheet()->setCellValue('U4','Director');
                    $spreadsheet->getActiveSheet()->setCellValue('V4','Psicólogo');
                    $spreadsheet->getActiveSheet()->setCellValue('W4','Horario');
                    $spreadsheet->getActiveSheet()->setCellValue('X4','Debida Diligencia');
                    $spreadsheet->getActiveSheet()->setCellValue('Y4','Prueba Confiabilidad');
                    $spreadsheet->getActiveSheet()->setCellValue('Z4','Exámen Médico');
                    $spreadsheet->getActiveSheet()->setCellValue('AA4','Check Contratación');
                    $spreadsheet->getActiveSheet()->setCellValue('AB4','Fecha Diligencia');
                    $spreadsheet->getActiveSheet()->setCellValue('AC4','Estado Oferta');
                    $spreadsheet->getActiveSheet()->setCellValue('AD4','Estado Oferta Fase 2');
                    $spreadsheet->getActiveSheet()->setCellValue('AE4','Fecha Registro Oferta');
                    
                    $spreadsheet->getActiveSheet()->setCellValue('A1','Reporte: Consolidado de Ofertas');
                    
                    // Ingresar Data consultada a partir de la fila 4
                    for ($i=5; $i < count($resregistros)+5; $i++) {
                        $spreadsheet->getActiveSheet()->setCellValue('A'.$i,mb_strtoupper($resregistros[$i-5]['hva_estado']));
                        $spreadsheet->getActiveSheet()->setCellValue('B'.$i,mb_strtoupper($resregistros[$i-5]['hva_identificacion']));//No Identificación
                        $spreadsheet->getActiveSheet()->setCellValue('C'.$i,mb_strtoupper($resregistros[$i-5]['hva_nombres']));//Primer Nombre
                        $spreadsheet->getActiveSheet()->setCellValue('D'.$i,mb_strtoupper($resregistros[$i-5]['hva_nombres_2']));//Segundo Nombre
                        $spreadsheet->getActiveSheet()->setCellValue('E'.$i,mb_strtoupper($resregistros[$i-5]['hva_apellido_1']));//Primero Apellido
                        $spreadsheet->getActiveSheet()->setCellValue('F'.$i,mb_strtoupper($resregistros[$i-5]['hva_apellido_2']));//Segundo Apellido
                        $spreadsheet->getActiveSheet()->setCellValue('G'.$i,mb_strtoupper($resregistros[$i-5]['hva_direccion']));//Dirección
                        $spreadsheet->getActiveSheet()->setCellValue('H'.$i,mb_strtoupper($resregistros[$i-5]['hva_barrio']));//Barrio
                        $spreadsheet->getActiveSheet()->setCellValue('I'.$i,mb_strtoupper($resregistros[$i-5]['ciu_municipio']));//Ciudad
                        $spreadsheet->getActiveSheet()->setCellValue('J'.$i,mb_strtoupper($resregistros[$i-5]['ciu_departamento']));//Departamento
                        $spreadsheet->getActiveSheet()->setCellValue('K'.$i,mb_strtoupper($resregistros[$i-5]['hva_celular']));//Celular
                        $spreadsheet->getActiveSheet()->setCellValue('L'.$i,mb_strtoupper($resregistros[$i-5]['hva_celular_2']));//Celular Alternativo
                        $spreadsheet->getActiveSheet()->setCellValue('M'.$i,strtolower($resregistros[$i-5]['hva_correo']));//Email

                        if ($resregistros[$i-5]['nacimiento_ciu_municipio']!='') {
                            $nacimiento_ciu_municipio=mb_strtoupper($resregistros[$i-5]['nacimiento_ciu_municipio']).', '.mb_strtoupper($resregistros[$i-5]['nacimiento_ciu_departamento']);
                        } else {
                            $nacimiento_ciu_municipio='';
                        }

                        $spreadsheet->getActiveSheet()->setCellValue('N'.$i,$nacimiento_ciu_municipio);//Lugar de Nacimiento
                        $spreadsheet->getActiveSheet()->setCellValue('O'.$i,mb_strtoupper($resregistros[$i-5]['hva_nacimiento_fecha']));//Fecha Nacimiento
                        $spreadsheet->getActiveSheet()->setCellValue('P'.$i,mb_strtoupper($resregistros[$i-5]['hva_nacimiento_fecha']));//Edad
                        $spreadsheet->getActiveSheet()->setCellValue('Q'.$i,mb_strtoupper($resregistros[$i-5]['hva_estado_civil']));//Estado Civil
                        $spreadsheet->getActiveSheet()->setCellValue('R'.$i,mb_strtoupper($resregistros[$i-5]['hva_genero']));//Género
                        $spreadsheet->getActiveSheet()->setCellValue('S'.$i,mb_strtoupper($resregistros[$i-5]['aa_nombre']));//Área
                        $spreadsheet->getActiveSheet()->setCellValue('T'.$i,mb_strtoupper($resregistros[$i-5]['ac_nombre']));//Cargo
                        $spreadsheet->getActiveSheet()->setCellValue('U'.$i,mb_strtoupper($resregistros[$i-5]['usuario_director']));//Director
                        $spreadsheet->getActiveSheet()->setCellValue('V'.$i,mb_strtoupper($resregistros[$i-5]['usuario_psicologo']));//Psicólogo
                        $spreadsheet->getActiveSheet()->setCellValue('W'.$i,mb_strtoupper($resregistros[$i-5]['hvao_horario']));//Horario
                        $spreadsheet->getActiveSheet()->setCellValue('X'.$i,mb_strtoupper($resregistros[$i-5]['hvao_debida_diligencia']));//Debida Diligencia
                        $spreadsheet->getActiveSheet()->setCellValue('Y'.$i,mb_strtoupper($resregistros[$i-5]['hvao_prueba_confiabilidad']));//Prueba Confiabilidad
                        $spreadsheet->getActiveSheet()->setCellValue('Z'.$i,mb_strtoupper($resregistros[$i-5]['hvao_examen_medico']));//Exámen Médico
                        $spreadsheet->getActiveSheet()->setCellValue('AA'.$i,mb_strtoupper($resregistros[$i-5]['hvao_check_contratacion']));//Check Contratación
                        $spreadsheet->getActiveSheet()->setCellValue('AB'.$i,mb_strtoupper($resregistros[$i-5]['hvao_fecha_diligencia']));//Fecha Diligencia
                        $spreadsheet->getActiveSheet()->setCellValue('AC'.$i,mb_strtoupper($resregistros[$i-5]['hvao_estado']));//Estado Oferta
                        $spreadsheet->getActiveSheet()->setCellValue('AD'.$i,mb_strtoupper($resregistros[$i-5]['hvao_estado_fase_2']));//Estado Oferta Fase 2
                        $spreadsheet->getActiveSheet()->setCellValue('AE'.$i,mb_strtoupper($resregistros[$i-5]['hvao_registro_fecha']));//Fecha Registro Oferta
                    }
                } elseif ($tipo_reporte=='Correos Gestión Usuarios') {
                    $registros = new hv_aspiranteModel();
                    $registros->hvao_area=$hva_area;
                    $registros->hvao_cargo=$hva_cargo;
                    $registros->hvao_psicologo=$hva_psicologo;
                    $registros->hva_estado=$estado;
                    $registros->hva_registro_fecha=$fecha_inicio;
                    $registros->hva_registro_fecha_2=$fecha_fin;

                    $resregistros=$registros->listAllReport();
                    
                    if (!isset($resregistros[0])) {
                        $resregistros=array();
                    }
                    
                    //Estilos de la Hoja 0
                    $spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(80);
                    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getStyle('A4:L4')->applyFromArray($styleArrayTitulos);
                    $spreadsheet->getActiveSheet()->setAutoFilter('A4:L4');
                    $spreadsheet->getActiveSheet()->getStyle('3')->getAlignment()->setWrapText(true);
                    $spreadsheet->getActiveSheet()->getStyle('4')->getAlignment()->setWrapText(true);

                    // Escribiendo los titulos
                    $spreadsheet->getActiveSheet()->setCellValue('A4','Estado');
                    $spreadsheet->getActiveSheet()->setCellValue('B4','No Identificación');
                    $spreadsheet->getActiveSheet()->setCellValue('C4','Primer Nombre');
                    $spreadsheet->getActiveSheet()->setCellValue('D4','Segundo Nombre');
                    $spreadsheet->getActiveSheet()->setCellValue('E4','Primero Apellido');
                    $spreadsheet->getActiveSheet()->setCellValue('F4','Segundo Apellido');
                    $spreadsheet->getActiveSheet()->setCellValue('G4','Correo Corporativo');
                    $spreadsheet->getActiveSheet()->setCellValue('H4','Fecha Ingreso');
                    $spreadsheet->getActiveSheet()->setCellValue('I4','Ciudad de residencia');
                    $spreadsheet->getActiveSheet()->setCellValue('J4','Centro de Costo');
                    $spreadsheet->getActiveSheet()->setCellValue('K4','Cargo');
                    $spreadsheet->getActiveSheet()->setCellValue('L4','NT');
                    
                    $spreadsheet->getActiveSheet()->setCellValue('A1','Reporte: Correos Gestión Usuarios');
                    
                    // Ingresar Data consultada a partir de la fila 4
                    for ($i=5; $i < count($resregistros)+5; $i++) {
                        $spreadsheet->getActiveSheet()->setCellValue('A'.$i,mb_strtoupper($resregistros[$i-5]['hva_estado']));
                        $spreadsheet->getActiveSheet()->setCellValue('B'.$i,mb_strtoupper($resregistros[$i-5]['hva_identificacion']));//No Identificación
                        $spreadsheet->getActiveSheet()->setCellValue('C'.$i,mb_strtoupper($resregistros[$i-5]['hva_nombres']));//Primer Nombre
                        $spreadsheet->getActiveSheet()->setCellValue('D'.$i,mb_strtoupper($resregistros[$i-5]['hva_nombres_2']));//Segundo Nombre
                        $spreadsheet->getActiveSheet()->setCellValue('E'.$i,mb_strtoupper($resregistros[$i-5]['hva_apellido_1']));//Primero Apellido
                        $spreadsheet->getActiveSheet()->setCellValue('F'.$i,mb_strtoupper($resregistros[$i-5]['hva_apellido_2']));//Segundo Apellido
                        $spreadsheet->getActiveSheet()->setCellValue('G'.$i,strtolower($resregistros[$i-5]['hva_correo_corporativo']));//Email
                        $spreadsheet->getActiveSheet()->setCellValue('H'.$i,mb_strtoupper($resregistros[$i-5]['hva_ingreso_fecha']));//Fecha Ingreso
                        $spreadsheet->getActiveSheet()->setCellValue('I'.$i,mb_strtoupper($resregistros[$i-5]['ciu_municipio']).', '.mb_strtoupper($resregistros[$i-5]['ciu_departamento']));//Ciudad de residencia
                        $spreadsheet->getActiveSheet()->setCellValue('J'.$i,mb_strtoupper($resregistros[$i-5]['aa_nombre']));//Centro de costo
                        $spreadsheet->getActiveSheet()->setCellValue('K'.$i,mb_strtoupper($resregistros[$i-5]['ac_nombre']));//Cargo
                        $spreadsheet->getActiveSheet()->setCellValue('L'.$i,mb_strtoupper($resregistros[$i-5]['hvp_usuario_nt']));//Cargo
                    }
                } elseif ($tipo_reporte=='Contratación') {
                    $registros = new hv_aspiranteModel();
                    $registros->hvao_area=$hva_area;
                    $registros->hvao_cargo=$hva_cargo;
                    $registros->hvao_psicologo=$hva_psicologo;
                    $registros->hva_estado=$estado;
                    $registros->hva_registro_fecha=$fecha_inicio;
                    $registros->hva_registro_fecha_2=$fecha_fin;

                    $resregistros=$registros->listAllReport();
                    
                    if (!isset($resregistros[0])) {
                        $resregistros=array();
                    }

                    // Valida Información en caso de Emergencia
                    $aspirante_emergencia = new hv_aspirante_emergenciaModel();
                    $resaspirante_emergencia=$aspirante_emergencia->listAllReport();

                    if (!isset($resaspirante_emergencia[0])) {
                        $resaspirante_emergencia=array();
                    }

                    $array_emergencia=array();
                    for ($i=0; $i < count($resaspirante_emergencia); $i++) { 
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_nombres_apellidos'] = $resaspirante_emergencia[$i]['hvaem_nombres_apellidos'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_parentesco'] = $resaspirante_emergencia[$i]['hvaem_parentesco'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_telefono'] = $resaspirante_emergencia[$i]['hvaem_telefono'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_grupo_sanguineo'] = $resaspirante_emergencia[$i]['hvaem_grupo_sanguineo'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_rh'] = $resaspirante_emergencia[$i]['hvaem_rh'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_antecedentes'] = $resaspirante_emergencia[$i]['hvaem_antecedentes'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_registro_usuario'] = $resaspirante_emergencia[$i]['hvaem_registro_usuario'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_registro_fecha'] = $resaspirante_emergencia[$i]['hvaem_registro_fecha'];
                    }

                    // Valida Seguridad Social
                    $aspirante_segsocial = new hv_aspirante_seguridad_socialModel();
                    $resaspirante_segsocial=$aspirante_segsocial->listAllReport();

                    if (!isset($resaspirante_segsocial[0])) {
                        $resaspirante_segsocial=array();
                    }

                    $array_segsocial=array();
                    for ($i=0; $i < count($resaspirante_segsocial); $i++) { 
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_eps'] = $resaspirante_segsocial[$i]['hvass_eps'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_pension'] = $resaspirante_segsocial[$i]['hvass_pension'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_pension_voluntario'] = $resaspirante_segsocial[$i]['hvass_pension_voluntario'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_cesantias'] = $resaspirante_segsocial[$i]['hvass_cesantias'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_prepagada'] = $resaspirante_segsocial[$i]['hvass_prepagada'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_registro_usuario'] = $resaspirante_segsocial[$i]['hvass_registro_usuario'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_registro_fecha'] = $resaspirante_segsocial[$i]['hvass_registro_fecha'];
                    }
                    
                    //Estilos de la Hoja 0
                    $spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(80);
                    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getStyle('A4:W4')->applyFromArray($styleArrayTitulos);
                    $spreadsheet->getActiveSheet()->setAutoFilter('A4:W4');
                    $spreadsheet->getActiveSheet()->getStyle('3')->getAlignment()->setWrapText(true);
                    $spreadsheet->getActiveSheet()->getStyle('4')->getAlignment()->setWrapText(true);

                    // Escribiendo los titulos
                    $spreadsheet->getActiveSheet()->setCellValue('A4','Tipo de documento de identidad');
                    $spreadsheet->getActiveSheet()->setCellValue('B4','No Identificación');
                    $spreadsheet->getActiveSheet()->setCellValue('C4','Fecha de Expedición');
                    $spreadsheet->getActiveSheet()->setCellValue('D4','Primer Nombre');
                    $spreadsheet->getActiveSheet()->setCellValue('E4','Segundo Nombre');
                    $spreadsheet->getActiveSheet()->setCellValue('F4','Primero Apellido');
                    $spreadsheet->getActiveSheet()->setCellValue('G4','Segundo Apellido');
                    $spreadsheet->getActiveSheet()->setCellValue('H4','Género');
                    $spreadsheet->getActiveSheet()->setCellValue('I4','Estado Civil');
                    $spreadsheet->getActiveSheet()->setCellValue('J4','Lugar de Nacimiento');
                    $spreadsheet->getActiveSheet()->setCellValue('K4','Fecha Nacimiento');
                    $spreadsheet->getActiveSheet()->setCellValue('L4','Ciudad de residencia');
                    $spreadsheet->getActiveSheet()->setCellValue('M4','Dirección de residencia');
                    $spreadsheet->getActiveSheet()->setCellValue('N4','Barrio');
                    $spreadsheet->getActiveSheet()->setCellValue('O4','Celular');
                    $spreadsheet->getActiveSheet()->setCellValue('P4','Celular Alternativo');
                    $spreadsheet->getActiveSheet()->setCellValue('Q4','Email');
                    $spreadsheet->getActiveSheet()->setCellValue('R4','Email Corporativo');
                    $spreadsheet->getActiveSheet()->setCellValue('S4','Grupo Sanguíneo');
                    $spreadsheet->getActiveSheet()->setCellValue('T4','RH');
                    $spreadsheet->getActiveSheet()->setCellValue('U4','Fecha Ingreso');
                    $spreadsheet->getActiveSheet()->setCellValue('V4','EPS');
                    $spreadsheet->getActiveSheet()->setCellValue('W4','Fondo de pensión');
                    $spreadsheet->getActiveSheet()->setCellValue('X4','Fondo de cesantías');
                    
                    $spreadsheet->getActiveSheet()->setCellValue('A1','Reporte: Selección Aspirantes - Contratación');
                    
                    // Ingresar Data consultada a partir de la fila 4
                    for ($i=5; $i < count($resregistros)+5; $i++) {
                        $id_aspirante=$resregistros[$i-5]['hva_id'];
                        $spreadsheet->getActiveSheet()->setCellValue('A'.$i,mb_strtoupper('Cédula de ciudadanía (CC)'));//Tipo de documento de identidad
                        $spreadsheet->getActiveSheet()->setCellValue('B'.$i,mb_strtoupper($resregistros[$i-5]['hva_identificacion']));//No Identificación
                        $spreadsheet->getActiveSheet()->setCellValue('C'.$i,mb_strtoupper($resregistros[$i-5]['hva_auxiliar_5']));//Fecha Expedición
                        $spreadsheet->getActiveSheet()->setCellValue('D'.$i,mb_strtoupper($resregistros[$i-5]['hva_nombres']));//Primer Nombre
                        $spreadsheet->getActiveSheet()->setCellValue('E'.$i,mb_strtoupper($resregistros[$i-5]['hva_nombres_2']));//Segundo Nombre
                        $spreadsheet->getActiveSheet()->setCellValue('F'.$i,mb_strtoupper($resregistros[$i-5]['hva_apellido_1']));//Primero Apellido
                        $spreadsheet->getActiveSheet()->setCellValue('G'.$i,mb_strtoupper($resregistros[$i-5]['hva_apellido_2']));//Segundo Apellido
                        $spreadsheet->getActiveSheet()->setCellValue('H'.$i,mb_strtoupper($resregistros[$i-5]['hva_genero']));//Género
                        $spreadsheet->getActiveSheet()->setCellValue('I'.$i,mb_strtoupper($resregistros[$i-5]['hva_estado_civil']));//Estado Civil
                        $spreadsheet->getActiveSheet()->setCellValue('J'.$i,mb_strtoupper($resregistros[$i-5]['nacimiento_ciu_municipio']).', '.mb_strtoupper($resregistros[$i-5]['nacimiento_ciu_departamento']));//Lugar de Nacimiento
                        $spreadsheet->getActiveSheet()->setCellValue('K'.$i,mb_strtoupper($resregistros[$i-5]['hva_nacimiento_fecha']));//Fecha Nacimiento
                        $spreadsheet->getActiveSheet()->setCellValue('L'.$i,mb_strtoupper($resregistros[$i-5]['ciu_municipio']).', '.mb_strtoupper($resregistros[$i-5]['ciu_departamento']));//Ciudad
                        $spreadsheet->getActiveSheet()->setCellValue('M'.$i,mb_strtoupper($resregistros[$i-5]['hva_direccion']));//Dirección
                        $spreadsheet->getActiveSheet()->setCellValue('N'.$i,mb_strtoupper($resregistros[$i-5]['hva_barrio']));//Barrio
                        $spreadsheet->getActiveSheet()->setCellValue('O'.$i,mb_strtoupper($resregistros[$i-5]['hva_celular']));//Celular
                        $spreadsheet->getActiveSheet()->setCellValue('P'.$i,mb_strtoupper($resregistros[$i-5]['hva_celular_2']));//Celular Alternativo
                        $spreadsheet->getActiveSheet()->setCellValue('Q'.$i,strtolower($resregistros[$i-5]['hva_correo']));//Email
                        $spreadsheet->getActiveSheet()->setCellValue('R'.$i,strtolower($resregistros[$i-5]['hva_correo_corporativo']));//Email
                        $spreadsheet->getActiveSheet()->setCellValue('S'.$i,mb_strtoupper($array_emergencia[$id_aspirante]['hvaem_grupo_sanguineo']));//Grupo Sanguíneo
                        $spreadsheet->getActiveSheet()->setCellValue('T'.$i,mb_strtoupper($array_emergencia[$id_aspirante]['hvaem_rh']));//RH
                        $spreadsheet->getActiveSheet()->setCellValue('U'.$i,mb_strtoupper($resregistros[$i-5]['hva_ingreso_fecha']));//Fecha Ingreso
                        $spreadsheet->getActiveSheet()->setCellValue('V'.$i,mb_strtoupper($array_segsocial[$id_aspirante]['hvass_eps']));//EPS
                        $spreadsheet->getActiveSheet()->setCellValue('W'.$i,mb_strtoupper($array_segsocial[$id_aspirante]['hvass_pension']));//Fondo de pensión
                        $spreadsheet->getActiveSheet()->setCellValue('X'.$i,mb_strtoupper($array_segsocial[$id_aspirante]['hvass_pension_voluntario']));//Fondo de cesantías
                    }
                } elseif ($tipo_reporte=='Cumplimiento') {
                    $registros = new hv_aspiranteModel();
                    $registros->hvao_area=$hva_area;
                    $registros->hvao_cargo=$hva_cargo;
                    $registros->hvao_psicologo=$hva_psicologo;
                    $registros->hva_estado=$estado;
                    $registros->hva_registro_fecha=$fecha_inicio;
                    $registros->hva_registro_fecha_2=$fecha_fin;
                    $registros->filtro_perfil=$modulo_perfil;

                    $resregistros=$registros->listAllReport();
                    
                    if (!isset($resregistros[0])) {
                        $resregistros=array();
                    }

                    // Valida Información en caso de Emergencia
                    $aspirante_emergencia = new hv_aspirante_emergenciaModel();
                    $resaspirante_emergencia=$aspirante_emergencia->listAllReport();

                    if (!isset($resaspirante_emergencia[0])) {
                        $resaspirante_emergencia=array();
                    }

                    $array_emergencia=array();
                    for ($i=0; $i < count($resaspirante_emergencia); $i++) { 
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_nombres_apellidos'] = $resaspirante_emergencia[$i]['hvaem_nombres_apellidos'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_parentesco'] = $resaspirante_emergencia[$i]['hvaem_parentesco'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_telefono'] = $resaspirante_emergencia[$i]['hvaem_telefono'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_grupo_sanguineo'] = $resaspirante_emergencia[$i]['hvaem_grupo_sanguineo'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_rh'] = $resaspirante_emergencia[$i]['hvaem_rh'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_antecedentes'] = $resaspirante_emergencia[$i]['hvaem_antecedentes'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_registro_usuario'] = $resaspirante_emergencia[$i]['hvaem_registro_usuario'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_registro_fecha'] = $resaspirante_emergencia[$i]['hvaem_registro_fecha'];
                    }

                    // Valida Información Familiar
                    $aspirante_familiar = new hv_aspirante_familiarModel();
                    $resaspirante_familiar=$aspirante_familiar->listAllReport();

                    if (!isset($resaspirante_familiar[0])) {
                        $resaspirante_familiar=array();
                    }

                    $array_familiar=array();
                    for ($i=0; $i < count($resaspirante_familiar); $i++) { 
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_nombres_apellidos'] = $resaspirante_familiar[$i]['hvaf_nombres_apellidos'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_parentesco'] = $resaspirante_familiar[$i]['hvaf_parentesco'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_edad'] = $resaspirante_familiar[$i]['hvaf_edad'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_nivel_educativo'] = $resaspirante_familiar[$i]['hvaf_nivel_educativo'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_acargo'] = $resaspirante_familiar[$i]['hvaf_acargo'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_convive'] = $resaspirante_familiar[$i]['hvaf_convive'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_registro_usuario'] = $resaspirante_familiar[$i]['hvaf_registro_usuario'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_registro_fecha'] = $resaspirante_familiar[$i]['hvaf_registro_fecha'];
                    }

                    // Valida Información Ética
                    $aspirante_etica = new hv_aspirante_eticaModel();
                    $resaspirante_etica=$aspirante_etica->listAllReport();

                    if (!isset($resaspirante_etica[0])) {
                        $resaspirante_etica=array();
                    }

                    $array_etica=array();
                    for ($i=0; $i < count($resaspirante_etica); $i++) { 
                        $array_etica[$resaspirante_etica[$i]['hvae_aspirante']]['hvae_familiar'] = $resaspirante_etica[$i]['hvae_familiar'];
                        $array_etica[$resaspirante_etica[$i]['hvae_aspirante']]['hvae_familiar_nombre'] = $resaspirante_etica[$i]['hvae_familiar_nombre'];
                        $array_etica[$resaspirante_etica[$i]['hvae_aspirante']]['hvae_familiar_area'] = $resaspirante_etica[$i]['hvae_familiar_area'];
                        $array_etica[$resaspirante_etica[$i]['hvae_aspirante']]['hvae_registro_usuario'] = $resaspirante_etica[$i]['hvae_registro_usuario'];
                        $array_etica[$resaspirante_etica[$i]['hvae_aspirante']]['hvae_registro_fecha'] = $resaspirante_etica[$i]['hvae_registro_fecha'];
                    }

                    // Valida Información IQ
                    $aspirante_informacion = new hv_aspirante_informacionModel();
                    $resaspirante_informacion=$aspirante_informacion->listAllReport();

                    if (!isset($resaspirante_informacion[0])) {
                        $resaspirante_informacion=array();
                    }

                    $array_informacion=array();
                    for ($i=0; $i < count($resaspirante_informacion); $i++) { 
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_excolaborador'] = $resaspirante_informacion[$i]['hvai_excolaborador'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_excolaborador_motivo'] = $resaspirante_informacion[$i]['hvai_excolaborador_motivo'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_excolaborador_fecha'] = $resaspirante_informacion[$i]['hvai_excolaborador_fecha'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_seleccion_previo'] = $resaspirante_informacion[$i]['hvai_seleccion_previo'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_seleccion_previo_cargo'] = $resaspirante_informacion[$i]['hvai_seleccion_previo_cargo'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_seleccion_previo_fecha'] = $resaspirante_informacion[$i]['hvai_seleccion_previo_fecha'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_trabajo'] = $resaspirante_informacion[$i]['hvai_trabajo'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_trabajo_tipo'] = $resaspirante_informacion[$i]['hvai_trabajo_tipo'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_trabajo_empresa'] = $resaspirante_informacion[$i]['hvai_trabajo_empresa'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_trabajo_cargo'] = $resaspirante_informacion[$i]['hvai_trabajo_cargo'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_ocupacion'] = $resaspirante_informacion[$i]['hvai_ocupacion'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_conflicto_renuncia'] = $resaspirante_informacion[$i]['hvai_conflicto_renuncia'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_registro_usuario'] = $resaspirante_informacion[$i]['hvai_registro_usuario'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_registro_fecha'] = $resaspirante_informacion[$i]['hvai_registro_fecha'];
                    }

                    // Valida Información Financiera
                    $aspirante_financiera = new hv_aspirante_financieraModel();
                    $resaspirante_financiera=$aspirante_financiera->listAllReport();

                    if (!isset($resaspirante_financiera[0])) {
                        $resaspirante_financiera=array();
                    }

                    $array_financiera=array();
                    for ($i=0; $i < count($resaspirante_financiera); $i++) { 
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_activos'] = $resaspirante_financiera[$i]['hvaf_activos'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_pasivos'] = $resaspirante_financiera[$i]['hvaf_pasivos'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_patrimonio'] = $resaspirante_financiera[$i]['hvaf_patrimonio'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_ingresos'] = $resaspirante_financiera[$i]['hvaf_ingresos'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_egresos'] = $resaspirante_financiera[$i]['hvaf_egresos'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_ingresos_otros'] = $resaspirante_financiera[$i]['hvaf_ingresos_otros'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_concepto_ingresos'] = $resaspirante_financiera[$i]['hvaf_concepto_ingresos'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_moneda_extranjera'] = $resaspirante_financiera[$i]['hvaf_moneda_extranjera'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_reporte'] = $resaspirante_financiera[$i]['hvaf_reporte'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_reporte_cual'] = $resaspirante_financiera[$i]['hvaf_reporte_cual'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_registro_usuario'] = $resaspirante_financiera[$i]['hvaf_registro_usuario'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_registro_fecha'] = $resaspirante_financiera[$i]['hvaf_registro_fecha'];
                    }
                    
                    // Valida Personas Expuestas Públicamente - PEP
                    $aspirante_publico = new hv_aspirante_publicoModel();
                    $resaspirante_publico=$aspirante_publico->listAllReport();

                    if (!isset($resaspirante_publico[0])) {
                        $resaspirante_publico=array();
                    }

                    $array_publico=array();
                    for ($i=0; $i < count($resaspirante_publico); $i++) { 
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_recursos'] = $resaspirante_publico[$i]['hvap_recursos'];
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_reconocimiento'] = $resaspirante_publico[$i]['hvap_reconocimiento'];
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_poder'] = $resaspirante_publico[$i]['hvap_poder'];
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_familiar'] = $resaspirante_publico[$i]['hvap_familiar'];
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_observaciones'] = $resaspirante_publico[$i]['hvap_observaciones'];
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_registro_usuario'] = $resaspirante_publico[$i]['hvap_registro_usuario'];
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_registro_fecha'] = $resaspirante_publico[$i]['hvap_registro_fecha'];
                    }

                    // Valida Seguridad Social
                    $aspirante_segsocial = new hv_aspirante_seguridad_socialModel();
                    $resaspirante_segsocial=$aspirante_segsocial->listAllReport();

                    if (!isset($resaspirante_segsocial[0])) {
                        $resaspirante_segsocial=array();
                    }

                    $array_segsocial=array();
                    for ($i=0; $i < count($resaspirante_segsocial); $i++) { 
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_eps'] = $resaspirante_segsocial[$i]['hvass_eps'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_pension'] = $resaspirante_segsocial[$i]['hvass_pension'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_pension_voluntario'] = $resaspirante_segsocial[$i]['hvass_pension_voluntario'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_cesantias'] = $resaspirante_segsocial[$i]['hvass_cesantias'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_prepagada'] = $resaspirante_segsocial[$i]['hvass_prepagada'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_registro_usuario'] = $resaspirante_segsocial[$i]['hvass_registro_usuario'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_registro_fecha'] = $resaspirante_segsocial[$i]['hvass_registro_fecha'];
                    }

                    // Valida Declaraciones y Autorizaciones
                    $aspirante_autorizaciones = new hv_aspirante_autorizacionesModel();
                    $resaspirante_autorizaciones=$aspirante_autorizaciones->listAllReport();

                    if (!isset($resaspirante_autorizaciones[0])) {
                        $resaspirante_autorizaciones=array();
                    }

                    $array_autorizaciones=array();
                    for ($i=0; $i < count($resaspirante_autorizaciones); $i++) { 
                        $array_autorizaciones[$resaspirante_autorizaciones[$i]['hvada_aspirante']]['hvada_veracidad'] = $resaspirante_autorizaciones[$i]['hvada_veracidad'];
                        $array_autorizaciones[$resaspirante_autorizaciones[$i]['hvada_aspirante']]['hvada_origen_fondos'] = $resaspirante_autorizaciones[$i]['hvada_origen_fondos'];
                        $array_autorizaciones[$resaspirante_autorizaciones[$i]['hvada_aspirante']]['hvada_proteccion_datos'] = $resaspirante_autorizaciones[$i]['hvada_proteccion_datos'];
                        $array_autorizaciones[$resaspirante_autorizaciones[$i]['hvada_aspirante']]['hvada_tratamiento_datos'] = $resaspirante_autorizaciones[$i]['hvada_tratamiento_datos'];
                        $array_autorizaciones[$resaspirante_autorizaciones[$i]['hvada_aspirante']]['hvada_registro_usuario'] = $resaspirante_autorizaciones[$i]['hvada_registro_usuario'];
                        $array_autorizaciones[$resaspirante_autorizaciones[$i]['hvada_aspirante']]['hvada_registro_fecha'] = $resaspirante_autorizaciones[$i]['hvada_registro_fecha'];
                    }

                    // Valida Estudios terminados
                    $aspirante_estudio = new hv_aspirante_estudio_terminadoModel();
                    $resaspirante_estudio_terminado=$aspirante_estudio->listAllReport();

                    if (!isset($resaspirante_estudio_terminado[0])) {
                        $resaspirante_estudio_terminado=array();
                    }

                    $array_estudio_terminado=array();
                    for ($i=0; $i < count($resaspirante_estudio_terminado); $i++) { 
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_nivel'][] = $resaspirante_estudio_terminado[$i]['hvaet_nivel'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_nivel'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_nivel']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_establecimiento'][] = $resaspirante_estudio_terminado[$i]['hvaet_establecimiento'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_establecimiento'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_establecimiento']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_titulo'][] = $resaspirante_estudio_terminado[$i]['hvaet_titulo'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_titulo'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_titulo']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_ciudad'][] = $resaspirante_estudio_terminado[$i]['hvaet_ciudad'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_ciudad'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_ciudad']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_fecha_inicio'][] = $resaspirante_estudio_terminado[$i]['hvaet_fecha_inicio'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_fecha_inicio'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_fecha_inicio']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_fecha_terminacion'][] = $resaspirante_estudio_terminado[$i]['hvaet_fecha_terminacion'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_fecha_terminacion'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_fecha_terminacion']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_tarjeta_profesional'][] = $resaspirante_estudio_terminado[$i]['hvaet_tarjeta_profesional'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_tarjeta_profesional'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_tarjeta_profesional']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['ciudad'][] = $resaspirante_estudio_terminado[$i]['ciu_municipio'].', '.$resaspirante_estudio_terminado[$i]['ciu_departamento'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['ciudad'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['ciudad']=array();
                        }
                    }

                    $aspirante_experiencia = new hv_aspirante_experienciaModel();
                    $resaspirante_experiencia=$aspirante_experiencia->listAllReport();

                    if (!isset($resaspirante_experiencia[0])) {
                        $resaspirante_experiencia=array();
                    }
                    
                    
                    $array_experiencia=array();
                    for ($i=0; $i < count($resaspirante_experiencia); $i++) { 
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_empresa'][] = $resaspirante_experiencia[$i]['hvaex_empresa'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_empresa'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_empresa']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_cargo'][] = $resaspirante_experiencia[$i]['hvaex_cargo'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_cargo'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_cargo']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_fecha_inicio'][] = $resaspirante_experiencia[$i]['hvaex_fecha_inicio'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_fecha_inicio'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_fecha_inicio']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_fecha_retiro'][] = $resaspirante_experiencia[$i]['hvaex_fecha_retiro'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_fecha_retiro'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_fecha_retiro']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_ciudad'][] = $resaspirante_experiencia[$i]['hvaex_ciudad'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_ciudad'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_ciudad']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_jefe_nombre'][] = $resaspirante_experiencia[$i]['hvaex_jefe_nombre'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_jefe_nombre'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_jefe_nombre']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_jefe_cargo'][] = $resaspirante_experiencia[$i]['hvaex_jefe_cargo'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_jefe_cargo'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_jefe_cargo']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_telefonos'][] = $resaspirante_experiencia[$i]['hvaex_telefonos'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_telefonos'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_telefonos']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_motivo_retiro'][] = $resaspirante_experiencia[$i]['hvaex_motivo_retiro'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_motivo_retiro'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_motivo_retiro']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['ciudad'][] = $resaspirante_experiencia[$i]['ciu_municipio'].', '.$resaspirante_experiencia[$i]['ciu_departamento'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['ciudad'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['ciudad']=array();
                        }
                    }
                    
                    //Estilos de la Hoja 0
                    $spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(80);
                    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AE')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AG')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AH')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AI')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AJ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AK')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AL')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AM')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AN')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AO')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AP')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AQ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AR')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AS')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AT')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AU')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AV')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AW')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AX')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AY')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AZ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BA')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BB')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BC')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BD')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BE')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BF')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BG')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BH')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BI')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BJ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BK')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BL')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BM')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BN')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BO')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BP')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BQ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BR')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BS')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BT')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BU')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BV')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BW')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BX')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BY')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('BZ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CA')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CB')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CC')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CD')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CE')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CF')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CG')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CH')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CI')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('CJ')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getStyle('A4:AI4')->applyFromArray($styleArrayTitulos);
                    $spreadsheet->getActiveSheet()->setAutoFilter('A4:AI4');
                    $spreadsheet->getActiveSheet()->getStyle('3')->getAlignment()->setWrapText(true);
                    $spreadsheet->getActiveSheet()->getStyle('4')->getAlignment()->setWrapText(true);

                    // Escribiendo los titulos
                    
                    $spreadsheet->getActiveSheet()->setCellValue('A4','Tipo de Identificación');
                    $spreadsheet->getActiveSheet()->setCellValue('B4','No Identificación');
                    $spreadsheet->getActiveSheet()->setCellValue('C4','Fecha de Expedición');
                    $spreadsheet->getActiveSheet()->setCellValue('D4','Primer Nombre');
                    $spreadsheet->getActiveSheet()->setCellValue('E4','Segundo Nombre');
                    $spreadsheet->getActiveSheet()->setCellValue('F4','Primero Apellido');
                    $spreadsheet->getActiveSheet()->setCellValue('G4','Segundo Apellido');
                    $spreadsheet->getActiveSheet()->setCellValue('H4','Dirección');
                    $spreadsheet->getActiveSheet()->setCellValue('I4','Barrio');
                    $spreadsheet->getActiveSheet()->setCellValue('J4','Ciudad');
                    $spreadsheet->getActiveSheet()->setCellValue('K4','Departamento');
                    $spreadsheet->getActiveSheet()->setCellValue('L4','¿Tiene usted familiares, conyugue y/o compañero permanente, parientes dentro del cuarto grado de consanguinidad, tercero de afinidad o único civil que actualmente trabaje en IQ?');
                    $spreadsheet->getActiveSheet()->setCellValue('M4','Nombres y Apellidos');
                    $spreadsheet->getActiveSheet()->setCellValue('N4','Área');
                    $spreadsheet->getActiveSheet()->setCellValue('O4','¿Declara tener otro trabajo u ocupación simultánea?');
                    $spreadsheet->getActiveSheet()->setCellValue('P4','Tipo de vinculación');
                    $spreadsheet->getActiveSheet()->setCellValue('Q4','Nombre de la empresa');
                    $spreadsheet->getActiveSheet()->setCellValue('R4','Cargo');
                    $spreadsheet->getActiveSheet()->setCellValue('S4','Ocupación o trabajo desempeñado');
                    $spreadsheet->getActiveSheet()->setCellValue('T4','¿Si su ocupación actual genera conflicto de interés, estaría dispuesto a renunciar a su trabajo actual?');
                    $spreadsheet->getActiveSheet()->setCellValue('U4','Activos');
                    $spreadsheet->getActiveSheet()->setCellValue('V4','Pasivos');
                    $spreadsheet->getActiveSheet()->setCellValue('W4','Patrimonio');
                    $spreadsheet->getActiveSheet()->setCellValue('X4','Ingresos mensuales');
                    $spreadsheet->getActiveSheet()->setCellValue('Y4','Egresos mensuales');
                    $spreadsheet->getActiveSheet()->setCellValue('Z4','Otros ingresos');
                    $spreadsheet->getActiveSheet()->setCellValue('AA4','Concepto de otros ingresos');
                    $spreadsheet->getActiveSheet()->setCellValue('AB4','¿Realiza Operaciones en Moneda Extranjera?');
                    $spreadsheet->getActiveSheet()->setCellValue('AC4','¿Maneja recursos públicos?');
                    $spreadsheet->getActiveSheet()->setCellValue('AD4','¿Goza de reconocimiento público general?');
                    $spreadsheet->getActiveSheet()->setCellValue('AE4','¿Ejerce algún grado de poder público?');
                    $spreadsheet->getActiveSheet()->setCellValue('AF4','¿Tiene usted algún familiar que cumpla con una característica anterior?');
                    $spreadsheet->getActiveSheet()->setCellValue('AG4','Si alguna de las respuestas anteriores es afirmativa, por favor especifique');
                    
                    $spreadsheet->getActiveSheet()->setCellValue('A1','Reporte: Cumplimiento');
                    
                    // Ingresar Data consultada a partir de la fila 4
                    for ($i=5; $i < count($resregistros)+5; $i++) {
                        $id_aspirante=$resregistros[$i-5]['hva_id'];

                        $edad_aspirante='';
                        if ($resregistros[$i-5]['hva_nacimiento_fecha']!='') {
                            $edad_aspirante=calcularEdad($resregistros[$i-5]['hva_nacimiento_fecha']);
                        }

                        $spreadsheet->getActiveSheet()->setCellValue('A'.$i,mb_strtoupper('Cédula de ciudadanía (CC)'));
                        $spreadsheet->getActiveSheet()->setCellValue('B'.$i,mb_strtoupper($resregistros[$i-5]['hva_identificacion']));//No Identificación
                        $spreadsheet->getActiveSheet()->setCellValue('C'.$i,mb_strtoupper($resregistros[$i-5]['hva_auxiliar_5']));//Fecha Expedición
                        $spreadsheet->getActiveSheet()->setCellValue('D'.$i,mb_strtoupper($resregistros[$i-5]['hva_nombres']));//Primer Nombre
                        $spreadsheet->getActiveSheet()->setCellValue('E'.$i,mb_strtoupper($resregistros[$i-5]['hva_nombres_2']));//Segundo Nombre
                        $spreadsheet->getActiveSheet()->setCellValue('F'.$i,mb_strtoupper($resregistros[$i-5]['hva_apellido_1']));//Primero Apellido
                        $spreadsheet->getActiveSheet()->setCellValue('G'.$i,mb_strtoupper($resregistros[$i-5]['hva_apellido_2']));//Segundo Apellido
                        $spreadsheet->getActiveSheet()->setCellValue('H'.$i,mb_strtoupper($resregistros[$i-5]['hva_direccion']));//Dirección
                        $spreadsheet->getActiveSheet()->setCellValue('I'.$i,mb_strtoupper($resregistros[$i-5]['hva_barrio']));//Barrio
                        $spreadsheet->getActiveSheet()->setCellValue('J'.$i,mb_strtoupper($resregistros[$i-5]['ciu_municipio']));//Ciudad
                        $spreadsheet->getActiveSheet()->setCellValue('K'.$i,mb_strtoupper($resregistros[$i-5]['ciu_departamento']));//Departamento
                        
                        $spreadsheet->getActiveSheet()->setCellValue('L'.$i,mb_strtoupper($array_etica[$id_aspirante]['hvae_familiar']));//¿Tiene usted familiares, conyugue y/o compañero permanente
                        $spreadsheet->getActiveSheet()->setCellValue('M'.$i,mb_strtoupper($array_etica[$id_aspirante]['hvae_familiar_nombre']));//Nombres y Apellidos
                        $spreadsheet->getActiveSheet()->setCellValue('N'.$i,mb_strtoupper($array_etica[$id_aspirante]['hvae_familiar_area']));//Área
                        $spreadsheet->getActiveSheet()->setCellValue('O'.$i,mb_strtoupper($array_informacion[$id_aspirante]['hvai_trabajo']));//¿Declara tener otro trabajo u ocupación simultánea?
                        $spreadsheet->getActiveSheet()->setCellValue('P'.$i,mb_strtoupper($array_informacion[$id_aspirante]['hvai_trabajo_tipo']));//Tipo de vinculación
                        $spreadsheet->getActiveSheet()->setCellValue('Q'.$i,mb_strtoupper($array_informacion[$id_aspirante]['hvai_trabajo_empresa']));//Nombre de la empresa
                        $spreadsheet->getActiveSheet()->setCellValue('R'.$i,mb_strtoupper($array_informacion[$id_aspirante]['hvai_trabajo_cargo']));//Cargo
                        $spreadsheet->getActiveSheet()->setCellValue('S'.$i,mb_strtoupper($array_informacion[$id_aspirante]['hvai_ocupacion']));//Ocupación o trabajo desempeñado
                        $spreadsheet->getActiveSheet()->setCellValue('T'.$i,mb_strtoupper($array_informacion[$id_aspirante]['hvai_conflicto_renuncia']));//¿Si su ocupación actual genera conflicto de interés, estaría dispuesto a renunciar
                        $spreadsheet->getActiveSheet()->setCellValue('U'.$i,mb_strtoupper($array_financiera[$id_aspirante]['hvaf_activos']));//Activos
                        $spreadsheet->getActiveSheet()->setCellValue('V'.$i,mb_strtoupper($array_financiera[$id_aspirante]['hvaf_pasivos']));//Pasivos
                        $spreadsheet->getActiveSheet()->setCellValue('W'.$i,mb_strtoupper($array_financiera[$id_aspirante]['hvaf_patrimonio']));//Patrimonio
                        $spreadsheet->getActiveSheet()->setCellValue('X'.$i,mb_strtoupper($array_financiera[$id_aspirante]['hvaf_ingresos']));//Ingresos mensuales
                        $spreadsheet->getActiveSheet()->setCellValue('Y'.$i,mb_strtoupper($array_financiera[$id_aspirante]['hvaf_egresos']));//Egresos mensuales
                        $spreadsheet->getActiveSheet()->setCellValue('Z'.$i,mb_strtoupper($array_financiera[$id_aspirante]['hvaf_ingresos_otros']));//Otros ingresos
                        $spreadsheet->getActiveSheet()->setCellValue('AA'.$i,mb_strtoupper($array_financiera[$id_aspirante]['hvaf_concepto_ingresos']));//Concepto de otros ingresos
                        $spreadsheet->getActiveSheet()->setCellValue('AB'.$i,mb_strtoupper($array_financiera[$id_aspirante]['hvaf_moneda_extranjera']));//¿Realiza Operaciones en Moneda Extranjera?
                        $spreadsheet->getActiveSheet()->setCellValue('AC'.$i,mb_strtoupper($array_publico[$id_aspirante]['hvap_recursos']));//¿Maneja recursos públicos?
                        $spreadsheet->getActiveSheet()->setCellValue('AD'.$i,mb_strtoupper($array_publico[$id_aspirante]['hvap_reconocimiento']));//¿Goza de reconocimiento público general?
                        $spreadsheet->getActiveSheet()->setCellValue('AE'.$i,mb_strtoupper($array_publico[$id_aspirante]['hvap_poder']));//¿Ejerce algún grado de poder público?
                        $spreadsheet->getActiveSheet()->setCellValue('AF'.$i,mb_strtoupper($array_publico[$id_aspirante]['hvap_familiar']));//¿Tiene usted algún familiar que cumpla con una característica anterior?
                        $spreadsheet->getActiveSheet()->setCellValue('AG'.$i,mb_strtoupper($array_publico[$id_aspirante]['hvap_observaciones']));//Si alguna de las respuestas anteriores es afirmativa, por favor especifique
                        
                    }
                }

                //Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="'.$titulo_reporte.'"');
                header('Cache-Control: max-age=0');

                // Guardamos el archivo
                $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save('php://output');
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        function hoja_vida() {
            // error_reporting(E_ALL);
            // ini_set('display_errors', '1');
            // Controller::checkSesion();
            $tipo_reporte=checkInput($_POST['tipo_reporte']);
            $estado=checkInput($_POST['estado']);
            $fecha_inicio=checkInput($_POST['fecha_inicio']);
            $fecha_fin=checkInput($_POST['fecha_fin']);
            
            try {
                $modulo_perfil=$_SESSION[APP_SESSION.'usu_modulos']['xxx'];

                $titulo_reporte="".$tipo_reporte.' - '.date('Y-m-d H_i_s').".xlsx";
                // Creamos nueva instancia de PHPExcel 
                $spreadsheet = new Spreadsheet();

                // Establecer propiedades
                $spreadsheet->getProperties()
                ->setCreator(APP_NAME_ALL)
                ->setLastModifiedBy($_SESSION[APP_SESSION.'usu_nombre'])
                ->setTitle(APP_NAME_ALL)
                ->setSubject(APP_NAME_ALL)
                ->setDescription(APP_NAME_ALL)
                ->setKeywords(APP_NAME_ALL)
                ->setCategory("Reporte");

                require_once(INCLUDES."inc_excel_style.php");

                //Activar hoja 0
                $sheet = $spreadsheet->getActiveSheet(0);
                
                // Nombramos la hoja 0
                $spreadsheet->getActiveSheet()->setTitle($tipo_reporte);

                if ($tipo_reporte=='Consolidado') {
                    $hoja_vida = new hv_personalModel();
                    if ($estado!='' AND $estado!='Todos') {
                        $hoja_vida->hvp_estado=$estado;
                    }

                    $hoja_vida->fecha_inicio=$fecha_inicio;
                    $hoja_vida->fecha_fin=$fecha_fin;

                    $resregistros=$hoja_vida->listAllReport();
                    
                    if (!isset($resregistros[0])) {
                        $resregistros=array();
                    }

                    //Estilos de la Hoja 0
                        $spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(80);
                        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AE')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AG')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AH')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AI')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AJ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AK')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AL')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AM')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AN')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AO')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AP')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AQ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AR')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AS')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AT')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AU')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AV')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AW')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AX')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AY')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AZ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BA')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BB')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BC')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BD')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BE')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BF')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BG')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BH')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BI')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BJ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BK')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BL')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BM')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BN')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BO')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BP')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BQ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BR')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BS')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BT')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BU')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BV')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BW')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BX')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BY')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BZ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CA')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CB')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CC')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CD')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CE')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CF')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CG')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CH')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CI')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CJ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CK')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CL')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CM')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CN')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CO')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CP')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CQ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CR')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CS')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CT')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CU')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CV')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CW')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CX')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CY')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CZ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DA')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DB')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DC')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DD')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DE')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DF')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DG')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DH')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DI')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DJ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DK')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DL')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DM')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DN')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DO')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DP')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DQ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DR')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DS')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DT')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DU')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DV')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DW')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DX')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DY')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DZ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EA')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EB')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EC')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('ED')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EE')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EF')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EG')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EH')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EI')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EJ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EK')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EL')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EM')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EN')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getStyle('A4:EN4')->applyFromArray($styleArrayTitulos);
                        
                        $spreadsheet->getActiveSheet()->getStyle('A3:C3')->applyFromArray($styleArrayTitulos_turno);
                        $spreadsheet->getActiveSheet()->getStyle('D3')->applyFromArray($styleArrayTitulos_almuerzo);
                        $spreadsheet->getActiveSheet()->getStyle('E3:K3')->applyFromArray($styleArrayTitulos_break);
                        $spreadsheet->getActiveSheet()->getStyle('L3:P3')->applyFromArray($styleArrayTitulos_pausa);
                        $spreadsheet->getActiveSheet()->getStyle('Q3:T3')->applyFromArray($styleArrayTitulos_capacitacion);
                        $spreadsheet->getActiveSheet()->getStyle('U3:AG3')->applyFromArray($styleArrayTitulos_retro);
                        $spreadsheet->getActiveSheet()->getStyle('AH3:AK3')->applyFromArray($styleArrayTitulos_turno);
                        $spreadsheet->getActiveSheet()->getStyle('AL3:AS3')->applyFromArray($styleArrayTitulos_almuerzo);
                        $spreadsheet->getActiveSheet()->getStyle('AT3:BD3')->applyFromArray($styleArrayTitulos_break);
                        $spreadsheet->getActiveSheet()->getStyle('BE3:BJ3')->applyFromArray($styleArrayTitulos_pausa);
                        $spreadsheet->getActiveSheet()->getStyle('BK3:BS3')->applyFromArray($styleArrayTitulos_capacitacion);
                        $spreadsheet->getActiveSheet()->getStyle('BT3:BZ3')->applyFromArray($styleArrayTitulos_retro);
                        $spreadsheet->getActiveSheet()->getStyle('CA3:CI3')->applyFromArray($styleArrayTitulos_turno);
                        $spreadsheet->getActiveSheet()->getStyle('CJ3:CZ3')->applyFromArray($styleArrayTitulos_almuerzo);
                        $spreadsheet->getActiveSheet()->getStyle('DA3:DG3')->applyFromArray($styleArrayTitulos_break);
                        $spreadsheet->getActiveSheet()->getStyle('DH3:DP3')->applyFromArray($styleArrayTitulos_pausa);
                        $spreadsheet->getActiveSheet()->getStyle('DQ3:DS3')->applyFromArray($styleArrayTitulos_capacitacion);
                        $spreadsheet->getActiveSheet()->getStyle('DT3:DU3')->applyFromArray($styleArrayTitulos_retro);
                        $spreadsheet->getActiveSheet()->getStyle('DV3:EE3')->applyFromArray($styleArrayTitulos_turno);
                        $spreadsheet->getActiveSheet()->getStyle('EF3:EN3')->applyFromArray($styleArrayTitulos_almuerzo);

                        $spreadsheet->getActiveSheet()->setAutoFilter('A4:EN4');
                        $spreadsheet->getActiveSheet()->getStyle('3')->getAlignment()->setWrapText(true);
                        $spreadsheet->getActiveSheet()->getStyle('4')->getAlignment()->setWrapText(true);

                    // Escribiendo los titulos
                    $spreadsheet->getActiveSheet()->setCellValue('A3','Información General');
                    $spreadsheet->getActiveSheet()->setCellValue('A4','Estado');
                    $spreadsheet->getActiveSheet()->setCellValue('B4','Fecha Actualización');
                    $spreadsheet->getActiveSheet()->setCellValue('C4','Tiempo Actualización (Días)');

                    $spreadsheet->getActiveSheet()->setCellValue('D3','Autorizaciones');
                    $spreadsheet->getActiveSheet()->setCellValue('D4','Consentimiento Tratamiento Datos');

                    $spreadsheet->getActiveSheet()->setCellValue('E3','Información Personal');
                    $spreadsheet->getActiveSheet()->setCellValue('E4','Tipo de documento de identidad');
                    $spreadsheet->getActiveSheet()->setCellValue('F4','Número de identificación');
                    $spreadsheet->getActiveSheet()->setCellValue('G4','Fecha de Expedición');
                    $spreadsheet->getActiveSheet()->setCellValue('H4','Primer nombre');
                    $spreadsheet->getActiveSheet()->setCellValue('I4','Segundo nombre');
                    $spreadsheet->getActiveSheet()->setCellValue('J4','Primer apellido');
                    $spreadsheet->getActiveSheet()->setCellValue('K4','Segundo apellido');
                    $spreadsheet->getActiveSheet()->setCellValue('L4','¿Cómo prefieres que te llamen?');

                    $spreadsheet->getActiveSheet()->setCellValue('M3','Información Demografía');
                    $spreadsheet->getActiveSheet()->setCellValue('M4','¿Cuál es tu género? ');
                    $spreadsheet->getActiveSheet()->setCellValue('N4','¿Cuál es tu estado civil ?');
                    $spreadsheet->getActiveSheet()->setCellValue('O4','Lugar nacimiento ');
                    $spreadsheet->getActiveSheet()->setCellValue('P4','Fecha nacimiento');
                    $spreadsheet->getActiveSheet()->setCellValue('Q4','Edad');

                    $spreadsheet->getActiveSheet()->setCellValue('R3','Información de Antiguedad');
                    $spreadsheet->getActiveSheet()->setCellValue('R4','¿Llevas más de 6 meses en la compañía? ');
                    $spreadsheet->getActiveSheet()->setCellValue('S4','¿Crees que este trabajo te ofrecerá oportunidades de crecimiento profesional?');
                    $spreadsheet->getActiveSheet()->setCellValue('T4','¿En qué medida estás de acuerdo con la siguiente afirmación?: “Este trabajo me ha ofrecido oportunidades de crecimiento laboral.”');
                    $spreadsheet->getActiveSheet()->setCellValue('U4','Motivación principal para aceptar el trabajo');

                    $spreadsheet->getActiveSheet()->setCellValue('V3','Información de Ubicación');
                    $spreadsheet->getActiveSheet()->setCellValue('V4','Ciudad de residencia ');
                    $spreadsheet->getActiveSheet()->setCellValue('W4','Dirección de residencia');
                    $spreadsheet->getActiveSheet()->setCellValue('X4','Localidad/Comuna');
                    $spreadsheet->getActiveSheet()->setCellValue('Y4','Barrio');
                    $spreadsheet->getActiveSheet()->setCellValue('Z4','Maps Latitud');
                    $spreadsheet->getActiveSheet()->setCellValue('AA4','Maps Longitud');
                    $spreadsheet->getActiveSheet()->setCellValue('AB4','Maps Ciudad');
                    $spreadsheet->getActiveSheet()->setCellValue('AC4','Maps Departamento');
                    $spreadsheet->getActiveSheet()->setCellValue('AD4','Maps Pais');
                    $spreadsheet->getActiveSheet()->setCellValue('AE4','Maps Localidad');
                    $spreadsheet->getActiveSheet()->setCellValue('AF4','Maps Barrio');
                    $spreadsheet->getActiveSheet()->setCellValue('AG4','Maps Código Postal');
                    $spreadsheet->getActiveSheet()->setCellValue('AH4','Maps Dirección');

                    $spreadsheet->getActiveSheet()->setCellValue('AI3','Información de Contacto');
                    $spreadsheet->getActiveSheet()->setCellValue('AI4','Número de celular');
                    $spreadsheet->getActiveSheet()->setCellValue('AJ4','Número de celular alternativo');
                    $spreadsheet->getActiveSheet()->setCellValue('AK4','Correo electrónico personal');
                    $spreadsheet->getActiveSheet()->setCellValue('AL4','Correo electrónico corporativo');

                    $spreadsheet->getActiveSheet()->setCellValue('AM3','En caso de emergencia avisar a:');
                    $spreadsheet->getActiveSheet()->setCellValue('AM4','1. Nombres');
                    $spreadsheet->getActiveSheet()->setCellValue('AN4','1. Apellidos');
                    $spreadsheet->getActiveSheet()->setCellValue('AO4','1. Parentesco');
                    $spreadsheet->getActiveSheet()->setCellValue('AP4','1. Número de celular de tu familiar/amigo(a)');

                    $spreadsheet->getActiveSheet()->setCellValue('AQ4','2. Nombres');
                    $spreadsheet->getActiveSheet()->setCellValue('AR4','2. Apellidos');
                    $spreadsheet->getActiveSheet()->setCellValue('AS4','2. Parentesco');
                    $spreadsheet->getActiveSheet()->setCellValue('AT4','2. Número de celular de tu familiar/amigo(a)');

                    $spreadsheet->getActiveSheet()->setCellValue('AU3','Información Socioeconómica');
                    $spreadsheet->getActiveSheet()->setCellValue('AU4','Estrato socioeconómico');
                    $spreadsheet->getActiveSheet()->setCellValue('AV4','Operador de internet ');
                    $spreadsheet->getActiveSheet()->setCellValue('AW4','Operador de internet - Otro');
                    $spreadsheet->getActiveSheet()->setCellValue('AX4','Velocidad de descarga de internet (MB)');
                    $spreadsheet->getActiveSheet()->setCellValue('AY4','Velocidad de carga de internet (MB)');
                    $spreadsheet->getActiveSheet()->setCellValue('AZ4','Características de tu vivienda');
                    $spreadsheet->getActiveSheet()->setCellValue('BA4','Condición de la vivienda');
                    $spreadsheet->getActiveSheet()->setCellValue('BB4','¿Cuál es el estado de terminación de tu vivienda?');
                    $spreadsheet->getActiveSheet()->setCellValue('BC4','¿Qué servicios tienes en tu vivienda?');
                    $spreadsheet->getActiveSheet()->setCellValue('BD4','¿Tienes pensado comprar vivienda en los próximos 3 años?');
                    $spreadsheet->getActiveSheet()->setCellValue('BE4','¿Has sido beneficiario de subsidio de vivienda?');

                    $spreadsheet->getActiveSheet()->setCellValue('BF3','Información Familiar');
                    $spreadsheet->getActiveSheet()->setCellValue('BF4','¿Cuántos hijos tienes?');
                    $spreadsheet->getActiveSheet()->setCellValue('BG4','familia_hijos_menor_3');
                    $spreadsheet->getActiveSheet()->setCellValue('BH4','familia_hijos_4_10');
                    $spreadsheet->getActiveSheet()->setCellValue('BI4','familia_hijos_11_17');
                    $spreadsheet->getActiveSheet()->setCellValue('BJ4','familia_hijos_mayor_18');
                    $spreadsheet->getActiveSheet()->setCellValue('BK4','¿En cual de los siguientes temas relacionados con la familia te gustaría recibir capacitación o acompañamiento?');
                    
                    $spreadsheet->getActiveSheet()->setCellValue('BL3','Información Financiera');
                    $spreadsheet->getActiveSheet()->setCellValue('BL4','Activos');
                    $spreadsheet->getActiveSheet()->setCellValue('BM4','Pasivos');
                    $spreadsheet->getActiveSheet()->setCellValue('BN4','Patrimonio');
                    $spreadsheet->getActiveSheet()->setCellValue('BO4','Ingresos Mensuales');
                    $spreadsheet->getActiveSheet()->setCellValue('BP4','Egresos Mensuales');
                    $spreadsheet->getActiveSheet()->setCellValue('BQ4','Otros Ingresos');
                    $spreadsheet->getActiveSheet()->setCellValue('BR4','Concepto de otros ingresos');
                    $spreadsheet->getActiveSheet()->setCellValue('BS4','¿Realiza Operaciones en Moneda Extranjera?');
                    $spreadsheet->getActiveSheet()->setCellValue('BT4','Declaración de Origen de Fondos y Prevención de Lavado de Activos y Financiación del Terrorismo - SAGRILAFT');

                    $spreadsheet->getActiveSheet()->setCellValue('BU3','Personas Expuestas Públicamente - PEP');
                    $spreadsheet->getActiveSheet()->setCellValue('BU4','¿Maneja recursos públicos?');
                    $spreadsheet->getActiveSheet()->setCellValue('BV4','¿Goza de reconocimiento público general?');
                    $spreadsheet->getActiveSheet()->setCellValue('BW4','¿Ejerce algún grado de poder público?');
                    $spreadsheet->getActiveSheet()->setCellValue('BX4','¿Tiene usted algún familiar que cumpla con una característica anterior?');
                    $spreadsheet->getActiveSheet()->setCellValue('BY4','PEP - Identificación');
                    $spreadsheet->getActiveSheet()->setCellValue('BZ4','PEP - Nombres y Apellidos');

                    $spreadsheet->getActiveSheet()->setCellValue('CA3','Información de Salud y Bienestar');
                    $spreadsheet->getActiveSheet()->setCellValue('CA4','¿Cuál es tu grupo sanguíneo?');
                    $spreadsheet->getActiveSheet()->setCellValue('CB4','¿Cuál es tu RH?');
                    $spreadsheet->getActiveSheet()->setCellValue('CC4','¿Realizas actividad física de mínimo 20 minutos al día?');
                    $spreadsheet->getActiveSheet()->setCellValue('CD4','¿Fumas?');
                    $spreadsheet->getActiveSheet()->setCellValue('CE4','¿Realizas pausas activas durante la jornada laboral?');
                    $spreadsheet->getActiveSheet()->setCellValue('CF4','¿Tienes medicina prepagada?');
                    $spreadsheet->getActiveSheet()->setCellValue('CG4','Medicina prepagada');
                    $spreadsheet->getActiveSheet()->setCellValue('CH4','¿Tienes plan complementario de salud?');
                    $spreadsheet->getActiveSheet()->setCellValue('CI4','Plan Complementario');
                    
                    $spreadsheet->getActiveSheet()->setCellValue('CJ3','¿Cuáles son tus hobbies?');
                    $spreadsheet->getActiveSheet()->setCellValue('CJ4','Deportes');
                    $spreadsheet->getActiveSheet()->setCellValue('CK4','Deportes - Otro');
                    $spreadsheet->getActiveSheet()->setCellValue('CL4','Deportes - Frecuencia');
                    $spreadsheet->getActiveSheet()->setCellValue('CM4','Actividades al aire libre');
                    $spreadsheet->getActiveSheet()->setCellValue('CN4','Actividades al aire libre - Otro');
                    $spreadsheet->getActiveSheet()->setCellValue('CO4','Actividades al aire libre - Frecuencia');
                    $spreadsheet->getActiveSheet()->setCellValue('CP4','Arte y creatividad');
                    $spreadsheet->getActiveSheet()->setCellValue('CQ4','Arte y creatividad - Otro');
                    $spreadsheet->getActiveSheet()->setCellValue('CR4','Arte y creatividad - Música - Instrumento');
                    $spreadsheet->getActiveSheet()->setCellValue('CS4','Arte y creatividad - Frecuencia');
                    $spreadsheet->getActiveSheet()->setCellValue('CT4','Tecnología');
                    $spreadsheet->getActiveSheet()->setCellValue('CU4','Tecnología - Otro');
                    $spreadsheet->getActiveSheet()->setCellValue('CV4','Tecnología - Frecuencia');
                    $spreadsheet->getActiveSheet()->setCellValue('CW4','Otros');
                    $spreadsheet->getActiveSheet()->setCellValue('CX4','Otros - Otro');
                    $spreadsheet->getActiveSheet()->setCellValue('CY4','Otros - Frecuencia');
                    $spreadsheet->getActiveSheet()->setCellValue('CZ4','¿Te gustaría recibir información sobre eventos o actividades relacionadas con tus hobbies?');

                    $spreadsheet->getActiveSheet()->setCellValue('DA3','Información de Intereses y Hábitos');
                    $spreadsheet->getActiveSheet()->setCellValue('DA4','¿Cuáles actividades te gusta hacer en familia?');
                    $spreadsheet->getActiveSheet()->setCellValue('DB4','¿Realizas actividades deportivas?');
                    $spreadsheet->getActiveSheet()->setCellValue('DC4','Cuáles actividades deportivas?');
                    $spreadsheet->getActiveSheet()->setCellValue('DD4','¿Cuál es tu medio de transporte cuando vas a la oficina?');
                    $spreadsheet->getActiveSheet()->setCellValue('DE4','¿Tienes el hábito de ahorrar?');
                    $spreadsheet->getActiveSheet()->setCellValue('DF4','¿Tienes Mascotas?');
                    $spreadsheet->getActiveSheet()->setCellValue('DG4','Cuéntanos que mascota tienes?');


                    $spreadsheet->getActiveSheet()->setCellValue('DH3','Último Nivel Académico Alcanzado');
                    $spreadsheet->getActiveSheet()->setCellValue('DH4','Ya enviaste al área de Gestión humana el último certificado de tus estudios culminados?');
                    $spreadsheet->getActiveSheet()->setCellValue('DI4','Indica el nombre del título de tu último estudio realizado');
                    $spreadsheet->getActiveSheet()->setCellValue('DJ4','Tienes tarjeta profesional?');
                    $spreadsheet->getActiveSheet()->setCellValue('DK4','¿Estás estudiando actualmente?');
                    $spreadsheet->getActiveSheet()->setCellValue('DL4','Nombre de los Estudios en curso');
                    $spreadsheet->getActiveSheet()->setCellValue('DM4','¿Cuál es el nivel académico del estudio que estas cursando?');
                    $spreadsheet->getActiveSheet()->setCellValue('DN4','Institución educativa de los estudios en curso');
                    
                    $spreadsheet->getActiveSheet()->setCellValue('DO4','Último Estudio Culminado');
                     //agregar columna con el último estudio culminado ordenado por fecha de finalización
                    $spreadsheet->getActiveSheet()->setCellValue('DP4','Estudios en Curso');
                    
                    
                    $spreadsheet->getActiveSheet()->setCellValue('DQ3','Información de Habilidades');
                    $spreadsheet->getActiveSheet()->setCellValue('DQ4','¿Nivel de inglés conversacional?');
                    $spreadsheet->getActiveSheet()->setCellValue('DR4','¿Nivel de manejo de hojas de cálculo?');
                    $spreadsheet->getActiveSheet()->setCellValue('DS4','Nivel de manejo de google WS (Workspace)');
                    
                    $spreadsheet->getActiveSheet()->setCellValue('DT3','Información de Poblaciones');
                    $spreadsheet->getActiveSheet()->setCellValue('DT4','Haces parte de alguna de las poblaciones mencionadas?');
                    $spreadsheet->getActiveSheet()->setCellValue('DU4','¿Cuentas con los documentos que validen la información (certificación)?');
                    
                    $spreadsheet->getActiveSheet()->setCellValue('DV3','Relaciones Familiares');
                    $spreadsheet->getActiveSheet()->setCellValue('DV4','¿Tienes familiares, conyugue y/o compañero permanente, parientes dentro del primer o segundo grado de consanguinidad, segundo de afinidad o único civil que actualmente trabaje en iQ?');
                    $spreadsheet->getActiveSheet()->setCellValue('DW4','Documento de identidad de tu familiar');
                    $spreadsheet->getActiveSheet()->setCellValue('DX4','¿Cuál es el nombre de tu familiar?');
                    $spreadsheet->getActiveSheet()->setCellValue('DY4','Tu familiar ingresó a la compañía antes de marzo 2022?');

                    $spreadsheet->getActiveSheet()->setCellValue('DZ4','Veracidad de la Información Proporcionada');
                    $spreadsheet->getActiveSheet()->setCellValue('EA4','Centro de Costo');
                    $spreadsheet->getActiveSheet()->setCellValue('EB4','Cargo');
                    $spreadsheet->getActiveSheet()->setCellValue('EC4','Fecha Ingreso');
                    $spreadsheet->getActiveSheet()->setCellValue('ED4','Fecha Retiro');
                    $spreadsheet->getActiveSheet()->setCellValue('EE4','Motivo Retiro');


                    $spreadsheet->getActiveSheet()->setCellValue('EF3','Estado Diligenciamiento');
                    $spreadsheet->getActiveSheet()->setCellValue('EF4','Autorizaciones');
                    $spreadsheet->getActiveSheet()->setCellValue('EG4','Información Personal');
                    $spreadsheet->getActiveSheet()->setCellValue('EH4','Ubicación/ Contacto');
                    $spreadsheet->getActiveSheet()->setCellValue('EI4','Socioeconómico/ Familiar');
                    $spreadsheet->getActiveSheet()->setCellValue('EJ4','Salud/ Bienestar');
                    $spreadsheet->getActiveSheet()->setCellValue('EK4','Intereses/ Hábitos');
                    $spreadsheet->getActiveSheet()->setCellValue('EL4','Formación/ Habilidades');
                    $spreadsheet->getActiveSheet()->setCellValue('EM4','Poblaciones/ Relaciones Familiares');
                    $spreadsheet->getActiveSheet()->setCellValue('EN4','Progreso General');
                    
                    $spreadsheet->getActiveSheet()->setCellValue('A1','Reporte: Consolidado');
                    $spreadsheet->getActiveSheet()->setCellValue('A2','Fecha: '.now());
                    
                    // Ingresar Data consultada a partir de la fila 4
                    for ($i=5; $i < count($resregistros)+5; $i++) {

                        // Fecha actual
                        $fecha_actual = new DateTime();

                        if ($resregistros[$i-5]['hvp_actualiza_fecha']!='') {
                            // Fecha de inicio (puedes poner cualquier fecha en formato 'YYYY-MM-DD')
                            $fecha_inicio = new DateTime($resregistros[$i-5]['hvp_actualiza_fecha']);
                            // Calcular la diferencia entre las dos fechas
                            $diferencia = $fecha_actual->diff($fecha_inicio);
                            $dias_diferencia=$diferencia->days;
                        } else {
                            $dias_diferencia='';
                        }

                        $spreadsheet->getActiveSheet()->setCellValue('A'.$i,mb_strtoupper($resregistros[$i-5]['hvp_estado']));//Estado
                        $spreadsheet->getActiveSheet()->setCellValue('B'.$i,mb_strtoupper($resregistros[$i-5]['hvp_actualiza_fecha']));//Fecha Actualización
                        $spreadsheet->getActiveSheet()->setCellValue('C'.$i,$dias_diferencia);//Tiempo Actualización
                        $spreadsheet->getActiveSheet()->setCellValue('D'.$i,mb_strtoupper($resregistros[$i-5]['hvp_consentimiento_tratamiento_datos_personales']));//Consentimiento Tratamiento Datos
                        $spreadsheet->getActiveSheet()->setCellValue('E'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_tipo_documento']));//Tipo de documento de identidad
                        $spreadsheet->getActiveSheet()->setCellValue('F'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_numero_identificacion']));//Número de identificación
                        $spreadsheet->getActiveSheet()->setCellValue('G'.$i,mb_strtoupper($resregistros[$i-5]['hva_auxiliar_5']));//hva_auxiliar_5 fecha expedición
                        $spreadsheet->getActiveSheet()->setCellValue('H'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_nombre_1']));//Primer nombre
                        $spreadsheet->getActiveSheet()->setCellValue('I'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_nombre_2']));//Segundo nombre
                        $spreadsheet->getActiveSheet()->setCellValue('J'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_apellido_1']));//Primer apellido
                        $spreadsheet->getActiveSheet()->setCellValue('K'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_apellido_2']));//Segundo apellido
                        $spreadsheet->getActiveSheet()->setCellValue('L'.$i,mb_strtoupper($resregistros[$i-5]['hvp_auxiliar_1']));//¿Cómo prefieres que te llamen?
                        $spreadsheet->getActiveSheet()->setCellValue('M'.$i,mb_strtoupper($resregistros[$i-5]['hvp_demografia_genero']));//¿Cuál es tu género? 
                        $spreadsheet->getActiveSheet()->setCellValue('N'.$i,mb_strtoupper($resregistros[$i-5]['hvp_demografia_estado_civil']));//¿Cuál es tu estado civil ?
                        $spreadsheet->getActiveSheet()->setCellValue('O'.$i,mb_strtoupper($resregistros[$i-5]['TCIUDADN_ciu_municipio']).', '.mb_strtoupper($resregistros[$i-5]['TCIUDADN_ciu_departamento']));//Lugar nacimiento 
                        $spreadsheet->getActiveSheet()->setCellValue('P'.$i,mb_strtoupper($resregistros[$i-5]['hvp_demografia_fecha_nacimiento']));//Fecha nacimiento
                        $spreadsheet->getActiveSheet()->setCellValue('Q'.$i,mb_strtoupper($resregistros[$i-5]['hvp_demografia_edad']));//Edad
                        $spreadsheet->getActiveSheet()->setCellValue('R'.$i,mb_strtoupper($resregistros[$i-5]['hvp_expectativa_motivacion_expectativa_desarrollo']));//¿Llevas más de 6 meses en la compañía? 
                        $spreadsheet->getActiveSheet()->setCellValue('S'.$i,mb_strtoupper($resregistros[$i-5]['hvp_expectativa_motivacion_expectativa_crecimiento_profesional']));//¿Crees que este trabajo te ofrecerá oportunidades de crecimiento profesional?
                        $spreadsheet->getActiveSheet()->setCellValue('T'.$i,mb_strtoupper($resregistros[$i-5]['hvp_expectativa_motivacion_realidad_crecimiento_profesional']));//¿En qué medida estás de acuerdo con la siguiente afirmación?: “Este trabajo me ha ofrecido oportunidades de crecimiento laboral.”
                        $spreadsheet->getActiveSheet()->setCellValue('U'.$i,mb_strtoupper($resregistros[$i-5]['hvp_expectativa_motivacion_motivacion_trabajo']));//Motivación principal para aceptar el trabajo
                        $spreadsheet->getActiveSheet()->setCellValue('V'.$i,mb_strtoupper($resregistros[$i-5]['TCIUDAD_ciu_municipio']).', '.mb_strtoupper($resregistros[$i-5]['TCIUDAD_ciu_departamento']));//Ciudad de residencia 
                        $spreadsheet->getActiveSheet()->setCellValue('W'.$i,mb_strtoupper($resregistros[$i-5]['hvp_ubicacion_direccion_residencia']));//Dirección de residencia
                        $spreadsheet->getActiveSheet()->setCellValue('X'.$i,mb_strtoupper($resregistros[$i-5]['hvp_ubicacion_localidad_comuna']));//Localidad/Comuna
                        $spreadsheet->getActiveSheet()->setCellValue('Y'.$i,mb_strtoupper($resregistros[$i-5]['hvp_ubicacion_barrio']));//Barrio
                        $spreadsheet->getActiveSheet()->setCellValue('Z'.$i,mb_strtoupper($resregistros[$i-5]['hvp_ubicacion_maps_latitud']));//Maps Latitud
                        $spreadsheet->getActiveSheet()->setCellValue('AA'.$i,mb_strtoupper($resregistros[$i-5]['hvp_ubicacion_maps_longitud']));//Maps Longitud
                        $spreadsheet->getActiveSheet()->setCellValue('AB'.$i,mb_strtoupper($resregistros[$i-5]['hvp_ubicacion_maps_ciudad']));//Maps Ciudad
                        $spreadsheet->getActiveSheet()->setCellValue('AC'.$i,mb_strtoupper($resregistros[$i-5]['hvp_ubicacion_maps_departamento']));//Maps Departamento
                        $spreadsheet->getActiveSheet()->setCellValue('AD'.$i,mb_strtoupper($resregistros[$i-5]['hvp_ubicacion_maps_pais']));//Maps Pais
                        $spreadsheet->getActiveSheet()->setCellValue('AE'.$i,mb_strtoupper($resregistros[$i-5]['hvp_ubicacion_maps_localidad']));//Maps Localidad
                        $spreadsheet->getActiveSheet()->setCellValue('AF'.$i,mb_strtoupper($resregistros[$i-5]['hvp_ubicacion_maps_barrio']));//Maps Barrio
                        $spreadsheet->getActiveSheet()->setCellValue('AG'.$i,mb_strtoupper($resregistros[$i-5]['hvp_ubicacion_maps_codigo_postal']));//Maps Código Postal
                        $spreadsheet->getActiveSheet()->setCellValue('AH'.$i,mb_strtoupper($resregistros[$i-5]['hvp_ubicacion_maps_direccion']));//Maps Dirección
                        $spreadsheet->getActiveSheet()->setCellValue('AI'.$i,mb_strtoupper($resregistros[$i-5]['hvp_contacto_numero_celular']));//Número de celular
                        $spreadsheet->getActiveSheet()->setCellValue('AJ'.$i,mb_strtoupper($resregistros[$i-5]['hvp_auxiliar_2']));//Número de celular alternativo
                        $spreadsheet->getActiveSheet()->setCellValue('AK'.$i,strtolower($resregistros[$i-5]['hvp_contacto_correo_personal']));//Correo electrónico personal
                        $spreadsheet->getActiveSheet()->setCellValue('AL'.$i,strtolower($resregistros[$i-5]['hvp_contacto_correo_corporativo']));//Correo electrónico corporativo
                        $spreadsheet->getActiveSheet()->setCellValue('AM'.$i,mb_strtoupper($resregistros[$i-5]['hvp_contacto_emergencia_nombres']));//1. Nombres
                        $spreadsheet->getActiveSheet()->setCellValue('AN'.$i,mb_strtoupper($resregistros[$i-5]['hvp_contacto_emergencia_apellidos']));//1. Apellidos
                        $spreadsheet->getActiveSheet()->setCellValue('AO'.$i,mb_strtoupper($resregistros[$i-5]['hvp_contacto_emergencia_parentesco']));//1. Parentesco
                        $spreadsheet->getActiveSheet()->setCellValue('AP'.$i,mb_strtoupper($resregistros[$i-5]['hvp_contacto_emergencia_celular']));//1. Número de celular de tu familiar/amigo(a)
                        $spreadsheet->getActiveSheet()->setCellValue('AQ'.$i,mb_strtoupper($resregistros[$i-5]['hvp_contacto_emergencia_nombres_2']));//2. Nombres
                        $spreadsheet->getActiveSheet()->setCellValue('AR'.$i,mb_strtoupper($resregistros[$i-5]['hvp_contacto_emergencia_apellidos_2']));//2. Apellidos
                        $spreadsheet->getActiveSheet()->setCellValue('AS'.$i,mb_strtoupper($resregistros[$i-5]['hvp_contacto_emergencia_parentesco_2']));//2. Parentesco
                        $spreadsheet->getActiveSheet()->setCellValue('AT'.$i,mb_strtoupper($resregistros[$i-5]['hvp_contacto_emergencia_celular_2']));//2. Número de celular de tu familiar/amigo(a)
                        $spreadsheet->getActiveSheet()->setCellValue('AU'.$i,mb_strtoupper($resregistros[$i-5]['hvp_socioeconomico_estrato_socioeconomico']));//Estrato socioeconómico
                        $spreadsheet->getActiveSheet()->setCellValue('AV'.$i,mb_strtoupper($resregistros[$i-5]['hvp_socioeconomico_operador_internet']));//Operador de internet 
                        $spreadsheet->getActiveSheet()->setCellValue('AW'.$i,mb_strtoupper($resregistros[$i-5]['hvp_socioeconomico_operador_internet_otro']));//Operador de internet - Otro
                        $spreadsheet->getActiveSheet()->setCellValue('AX'.$i,mb_strtoupper($resregistros[$i-5]['hvp_socioeconomico_velocidad_internet_descarga']));//Velocidad de descarga de internet (MB)
                        $spreadsheet->getActiveSheet()->setCellValue('AY'.$i,mb_strtoupper($resregistros[$i-5]['hvp_socioeconomico_velocidad_internet_carga']));//Velocidad de carga de internet (MB)
                        $spreadsheet->getActiveSheet()->setCellValue('AZ'.$i,mb_strtoupper($resregistros[$i-5]['hvp_socioeconomico_caracteristicas_vivienda']));//Características de tu vivienda
                        $spreadsheet->getActiveSheet()->setCellValue('BA'.$i,mb_strtoupper($resregistros[$i-5]['hvp_socioeconomico_condiciones_vivienda']));//Condición de la vivienda
                        $spreadsheet->getActiveSheet()->setCellValue('BB'.$i,mb_strtoupper($resregistros[$i-5]['hvp_socioeconomico_estado_terminacion_vivienda']));//¿Cuál es el estado de terminación de tu vivienda?
                        $spreadsheet->getActiveSheet()->setCellValue('BC'.$i,mb_strtoupper($resregistros[$i-5]['hvp_socioeconomico_servicios_vivienda']));//¿Qué servicios tienes en tu vivienda?
                        $spreadsheet->getActiveSheet()->setCellValue('BD'.$i,mb_strtoupper($resregistros[$i-5]['hvp_socioeconomico_plan_compra_vivienda']));//¿Tienes pensado comprar vivienda en los próximos 3 años?
                        $spreadsheet->getActiveSheet()->setCellValue('BE'.$i,mb_strtoupper($resregistros[$i-5]['hvp_socioeconomico_beneficiario_subsidio_vivienda']));//¿Has sido beneficiario de subsidio de vivienda?
                        $spreadsheet->getActiveSheet()->setCellValue('BF'.$i,mb_strtoupper($resregistros[$i-5]['hvp_familia_numero_hijos']));//¿Cuántos hijos tienes?
                        $spreadsheet->getActiveSheet()->setCellValue('BG'.$i,mb_strtoupper($resregistros[$i-5]['xxx']));//familia_hijos_menor_3
                        $spreadsheet->getActiveSheet()->setCellValue('BH'.$i,mb_strtoupper($resregistros[$i-5]['xxx']));//familia_hijos_4_10
                        $spreadsheet->getActiveSheet()->setCellValue('BI'.$i,mb_strtoupper($resregistros[$i-5]['xxx']));//familia_hijos_11_17
                        $spreadsheet->getActiveSheet()->setCellValue('BJ'.$i,mb_strtoupper($resregistros[$i-5]['xxx']));//familia_hijos_mayor_18
                        $spreadsheet->getActiveSheet()->setCellValue('BK'.$i,mb_strtoupper($resregistros[$i-5]['hvp_familia_capacitacion_familia']));//¿En cual de los siguientes temas relacionados con la familia te gustaría recibir
                        $spreadsheet->getActiveSheet()->setCellValue('BL'.$i,mb_strtoupper($resregistros[$i-5]['hvp_financiero_activos']));//Activos
                        $spreadsheet->getActiveSheet()->setCellValue('BM'.$i,mb_strtoupper($resregistros[$i-5]['hvp_financiero_pasivos']));//Pasivos
                        $spreadsheet->getActiveSheet()->setCellValue('BN'.$i,mb_strtoupper($resregistros[$i-5]['hvp_financiero_patrimonio']));//Patrimonio
                        $spreadsheet->getActiveSheet()->setCellValue('BO'.$i,mb_strtoupper($resregistros[$i-5]['hvp_financiero_ingresos']));//Ingresos Mensuales
                        $spreadsheet->getActiveSheet()->setCellValue('BP'.$i,mb_strtoupper($resregistros[$i-5]['hvp_financiero_egresos']));//Egresos Mensuales
                        $spreadsheet->getActiveSheet()->setCellValue('BQ'.$i,mb_strtoupper($resregistros[$i-5]['hvp_financiero_ingresos_otros']));//Otros Ingresos
                        $spreadsheet->getActiveSheet()->setCellValue('BR'.$i,mb_strtoupper($resregistros[$i-5]['hvp_financiero_concepto_ingresos']));//Concepto de otros ingresos
                        $spreadsheet->getActiveSheet()->setCellValue('BS'.$i,mb_strtoupper($resregistros[$i-5]['hvp_financiero_moneda_extranjera']));//¿Realiza Operaciones en Moneda Extranjera?
                        $spreadsheet->getActiveSheet()->setCellValue('BT'.$i,mb_strtoupper($resregistros[$i-5]['hvp_origen_fondos']));//Declaración de Origen de Fondos y Prevención de Lavado de Activos
                        $spreadsheet->getActiveSheet()->setCellValue('BU'.$i,mb_strtoupper($resregistros[$i-5]['hvp_pep_recursos']));//¿Maneja recursos públicos?
                        $spreadsheet->getActiveSheet()->setCellValue('BV'.$i,mb_strtoupper($resregistros[$i-5]['hvp_pep_reconocimiento']));//¿Goza de reconocimiento público general?
                        $spreadsheet->getActiveSheet()->setCellValue('BW'.$i,mb_strtoupper($resregistros[$i-5]['hvp_pep_poder']));//¿Ejerce algún grado de poder público?
                        $spreadsheet->getActiveSheet()->setCellValue('BX'.$i,mb_strtoupper($resregistros[$i-5]['hvp_pep_familiar']));//¿Tiene usted algún familiar que cumpla con una característica anterior?
                        $spreadsheet->getActiveSheet()->setCellValue('BY'.$i,mb_strtoupper($resregistros[$i-5]['hvp_pep_cedula']));//¿Tiene usted algún familiar que cumpla con una característica anterior?
                        $spreadsheet->getActiveSheet()->setCellValue('BZ'.$i,mb_strtoupper($resregistros[$i-5]['hvp_pep_nombres_apellidos']));//¿Tiene usted algún familiar que cumpla con una característica anterior?
                        $spreadsheet->getActiveSheet()->setCellValue('CA'.$i,mb_strtoupper($resregistros[$i-5]['hvp_salud_bienestar_grupo_sanguineo']));//¿Cuál es tu grupo sanguíneo?
                        $spreadsheet->getActiveSheet()->setCellValue('CB'.$i,mb_strtoupper($resregistros[$i-5]['hvp_salud_bienestar_rh']));//¿Cuál es tu RH?
                        $spreadsheet->getActiveSheet()->setCellValue('CC'.$i,mb_strtoupper($resregistros[$i-5]['hvp_salud_bienestar_actividad_fisica_minima']));//¿Realizas actividad física de mínimo 20 minutos al día?
                        $spreadsheet->getActiveSheet()->setCellValue('CD'.$i,mb_strtoupper($resregistros[$i-5]['hvp_salud_bienestar_fumador']));//¿Fumas?
                        $spreadsheet->getActiveSheet()->setCellValue('CE'.$i,mb_strtoupper($resregistros[$i-5]['hvp_salud_bienestar_pausas_activas']));//¿Realizas pausas activas durante la jornada laboral?
                        $spreadsheet->getActiveSheet()->setCellValue('CF'.$i,mb_strtoupper($resregistros[$i-5]['hvp_salud_bienestar_medicina_prepagada']));//¿Tienes medicina prepagada?
                        $spreadsheet->getActiveSheet()->setCellValue('CG'.$i,mb_strtoupper($resregistros[$i-5]['hvp_salud_bienestar_medicina_prepagada_cual']));//Medicina prepagada
                        $spreadsheet->getActiveSheet()->setCellValue('CH'.$i,mb_strtoupper($resregistros[$i-5]['hvp_salud_bienestar_plan_complementario_salud']));//¿Tienes plan complementario de salud?
                        $spreadsheet->getActiveSheet()->setCellValue('CI'.$i,mb_strtoupper($resregistros[$i-5]['hvp_salud_bienestar_plan_complementario_salud_cual']));//Plan Complementario
                        $spreadsheet->getActiveSheet()->setCellValue('CJ'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_hobbies_deportes']));//Deportes
                        $spreadsheet->getActiveSheet()->setCellValue('CK'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_hobbies_deportes_cual']));//Deportes - Otro
                        $spreadsheet->getActiveSheet()->setCellValue('CL'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_hobbies_deportes_frecuencia']));//Deportes - Frecuencia
                        $spreadsheet->getActiveSheet()->setCellValue('CM'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_hobbies_aire']));//Actividades al aire libre
                        $spreadsheet->getActiveSheet()->setCellValue('CN'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_hobbies_aire_cual']));//Actividades al aire libre - Otro
                        $spreadsheet->getActiveSheet()->setCellValue('CO'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_hobbies_aire_frecuencia']));//Actividades al aire libre - Frecuencia
                        $spreadsheet->getActiveSheet()->setCellValue('CP'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_hobbies_arte']));//Arte y creatividad
                        $spreadsheet->getActiveSheet()->setCellValue('CQ'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_hobbies_arte_cual']));//Arte y creatividad - Otro
                        $spreadsheet->getActiveSheet()->setCellValue('CR'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_hobbies_arte_instrumento']));//Arte y creatividad - Música - Instrumento
                        $spreadsheet->getActiveSheet()->setCellValue('CS'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_hobbies_arte_frecuencia']));//Arte y creatividad - Frecuencia
                        $spreadsheet->getActiveSheet()->setCellValue('CT'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_hobbies_tecnologia']));//Tecnología
                        $spreadsheet->getActiveSheet()->setCellValue('CU'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_hobbies_tecnologia_cual']));//Tecnología - Otro
                        $spreadsheet->getActiveSheet()->setCellValue('CV'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_hobbies_tecnologia_frecuencia']));//Tecnología - Frecuencia
                        $spreadsheet->getActiveSheet()->setCellValue('CW'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_hobbies_otro']));//Otros
                        $spreadsheet->getActiveSheet()->setCellValue('CX'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_hobbies_otro_cual']));//Otros - Otro
                        $spreadsheet->getActiveSheet()->setCellValue('CY'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_hobbies_otro_frecuencia']));//Otros - Frecuencia
                        $spreadsheet->getActiveSheet()->setCellValue('CZ'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_hobbies_recibir_informacion']));//¿Te gustaría recibir información sobre eventos o actividades relacionadas con tus hobbies?
                        $spreadsheet->getActiveSheet()->setCellValue('DA'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_actividades_familia']));//¿Cuáles actividades te gusta hacer en familia?
                        $spreadsheet->getActiveSheet()->setCellValue('DB'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_actividades_deportivas']));//¿Realizas actividades deportivas?
                        $spreadsheet->getActiveSheet()->setCellValue('DC'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_actividades_deportivas_cual']));//Cuales actividades deportivas
                        $spreadsheet->getActiveSheet()->setCellValue('DD'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_medio_transporte']));//¿Cuál es tu medio de transporte cuando vas a la oficina?
                        $spreadsheet->getActiveSheet()->setCellValue('DE'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_habito_ahorro']));//¿Tienes el hábito de ahorrar?
                        $spreadsheet->getActiveSheet()->setCellValue('DF'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_mascotas']));//¿Tienes Mascotas?
                        $spreadsheet->getActiveSheet()->setCellValue('DG'.$i,mb_strtoupper($resregistros[$i-5]['hvp_interes_habitos_mascotas_cual']));//Cuéntanos que mascota tienes?

                        


                        $spreadsheet->getActiveSheet()->setCellValue('DH'.$i,mb_strtoupper($resregistros[$i-5]['hvp_formacion_ultimo_certificado_enviado_rrhh']));//Ya enviaste al área de Gestión humana el último certificado de tus estudios culminados?
                        $spreadsheet->getActiveSheet()->setCellValue('DI'.$i,mb_strtoupper($resregistros[$i-5]['hvp_formacion_ultimo_estudio_realizado_titulo']));//Indica el nombre del título de tu último estudio realizado
                        $spreadsheet->getActiveSheet()->setCellValue('DJ'.$i,mb_strtoupper($resregistros[$i-5]['hvp_formacion_tarjeta_profesional']));//Tienes tarjeta profesional?
                        $spreadsheet->getActiveSheet()->setCellValue('DK'.$i,mb_strtoupper($resregistros[$i-5]['hvp_formacion_estudios_curso']));//¿Estás estudiando actualmente?
                        
                        $spreadsheet->getActiveSheet()->setCellValue('DL'.$i,mb_strtoupper($resregistros[$i-5]['hvp_formacion_estudios_curso_titulo']));//Nombre de los Estudios en curso
                        $spreadsheet->getActiveSheet()->setCellValue('DM'.$i,mb_strtoupper($resregistros[$i-5]['hvp_formacion_estudios_curso_nivel']));//¿Cuál es el nivel académico del estudio que estas cursando?
                        $spreadsheet->getActiveSheet()->setCellValue('DN'.$i,mb_strtoupper($resregistros[$i-5]['hvp_formacion_estudios_curso_establecimiento']));//Institución educativa de los estudios en curso
                        $spreadsheet->getActiveSheet()->setCellValue('DO'.$i,mb_strtoupper($resregistros[$i-5]['xxx']));//Último Estudio Culminado
                        $spreadsheet->getActiveSheet()->setCellValue('DP'.$i,mb_strtoupper($resregistros[$i-5]['xxx']));//Estudios en Curso

                        $spreadsheet->getActiveSheet()->setCellValue('DQ'.$i,mb_strtoupper($resregistros[$i-5]['hvp_habilidades_nivel_ingles']));//¿Nivel de inglés conversacional?
                        $spreadsheet->getActiveSheet()->setCellValue('DR'.$i,mb_strtoupper($resregistros[$i-5]['hvp_habilidades_nivel_excel']));//¿Nivel de manejo de hojas de cálculo?
                        $spreadsheet->getActiveSheet()->setCellValue('DS'.$i,mb_strtoupper($resregistros[$i-5]['hvp_habilidades_nivel_google_ws']));//Nivel de manejo de google WS (Workspace)
                        $spreadsheet->getActiveSheet()->setCellValue('DT'.$i,mb_strtoupper($resregistros[$i-5]['hvp_poblaciones_poblacion']));//Haces parte de alguna de las poblaciones mencionadas?
                        $spreadsheet->getActiveSheet()->setCellValue('DU'.$i,mb_strtoupper($resregistros[$i-5]['hvp_poblaciones_certificado']));//¿Cuentas con los documentos que validen la información (certificación)?
                        $spreadsheet->getActiveSheet()->setCellValue('DV'.$i,mb_strtoupper($resregistros[$i-5]['hvp_poblaciones_familiares_iq']));//¿Tienes familiares, conyugue y/o compañero permanente, parientes dentro del primer o segundo grado
                        $spreadsheet->getActiveSheet()->setCellValue('DW'.$i,mb_strtoupper($resregistros[$i-5]['hvp_poblaciones_familiares_iq_identificacion']));//Documento de identidad de tu familiar
                        $spreadsheet->getActiveSheet()->setCellValue('DX'.$i,mb_strtoupper($resregistros[$i-5]['hvp_poblaciones_familiares_iq_nombres_apellidos']));//¿Cuál es el nombre de tu familiar?
                        $spreadsheet->getActiveSheet()->setCellValue('DY'.$i,mb_strtoupper($resregistros[$i-5]['hvp_poblaciones_familiares_iq_ingreso_marzo_2022']));//Tu familiar ingresó a la compañía antes de marzo 2022?
                        $spreadsheet->getActiveSheet()->setCellValue('DZ'.$i,mb_strtoupper($resregistros[$i-5]['hvp_veracidad']));//Veracidad de la Información Proporcionada
                        $spreadsheet->getActiveSheet()->setCellValue('EA'.$i,mb_strtoupper($resregistros[$i-5]['aa_nombre']));//Centro de Costo
                        $spreadsheet->getActiveSheet()->setCellValue('EB'.$i,mb_strtoupper($resregistros[$i-5]['ac_nombre']));//Cargo

                        $spreadsheet->getActiveSheet()->setCellValue('EC'.$i,mb_strtoupper($resregistros[$i-5]['hvp_fecha_ingreso']));//Fecha Ingreso
                        $spreadsheet->getActiveSheet()->setCellValue('ED'.$i,mb_strtoupper($resregistros[$i-5]['hvp_retiro_fecha']));//Fecha Retiro
                        $spreadsheet->getActiveSheet()->setCellValue('EE'.$i,mb_strtoupper($resregistros[$i-5]['hvp_retiro_motivo']));//Motivo Retiro

                        //Función para obtener el estado de los campos
                        $array_estados=estadoDiligenciaHV($resregistros[$i-5]);

                        $estado_autorizaciones=$array_estados['estado_autorizaciones'];
                        $estado_informacion_personal=$array_estados['estado_informacion_personal'];
                        $estado_ubicacion_contacto=$array_estados['estado_ubicacion_contacto'];
                        $estado_socioeconomico_familiar=$array_estados['estado_socioeconomico_familiar'];
                        $estado_salud_bienestar=$array_estados['estado_salud_bienestar'];
                        $estado_intereses_habitos=$array_estados['estado_intereses_habitos'];
                        $estado_formacion_habilidades=$array_estados['estado_formacion_habilidades'];
                        $estado_poblaciones_relaciones=$array_estados['estado_poblaciones_relaciones'];
                        $estado_general=$array_estados['estado_general'];
                        
                        $spreadsheet->getActiveSheet()->setCellValue('EF'.$i,$estado_autorizaciones);//estado_autorizaciones
                        $spreadsheet->getActiveSheet()->setCellValue('EG'.$i,$estado_informacion_personal);//estado_informacion_personal
                        $spreadsheet->getActiveSheet()->setCellValue('EH'.$i,$estado_ubicacion_contacto);//estado_ubicacion_contacto
                        $spreadsheet->getActiveSheet()->setCellValue('EI'.$i,$estado_socioeconomico_familiar);//estado_socioeconomico_familiar
                        $spreadsheet->getActiveSheet()->setCellValue('EJ'.$i,$estado_salud_bienestar);//estado_salud_bienestar
                        $spreadsheet->getActiveSheet()->setCellValue('EK'.$i,$estado_intereses_habitos);//estado_intereses_habitos
                        $spreadsheet->getActiveSheet()->setCellValue('EL'.$i,$estado_formacion_habilidades);//estado_formacion_habilidades
                        $spreadsheet->getActiveSheet()->setCellValue('EM'.$i,$estado_poblaciones_relaciones);//estado_poblaciones_relaciones
                        $spreadsheet->getActiveSheet()->setCellValue('EN'.$i,$estado_general);//estado_general
                        
                    }
                } elseif ($tipo_reporte=='Consolidado Vinculados') {
                    // error_reporting(E_ALL);
                    // ini_set('display_errors', 1);
                    $registros = new hv_aspiranteModel();
                    
                    if ($estado=='Retirado') {
                        $estado='Vinculado';
                    }

                    if ($estado!='' AND $estado!='Todos') {
                        $registros->hva_estado=$estado;
                    }

                    
                    $registros->hva_registro_fecha=$fecha_inicio;
                    $registros->hva_registro_fecha_2=$fecha_fin;

                    $resregistros=$registros->listAllReportVinculados();
                    
                    if (!isset($resregistros[0])) {
                        $resregistros=array();
                    }

                    // Valida Información en caso de Emergencia
                    $aspirante_emergencia = new hv_aspirante_emergenciaModel();
                    $resaspirante_emergencia=$aspirante_emergencia->listAllReport();

                    if (!isset($resaspirante_emergencia[0])) {
                        $resaspirante_emergencia=array();
                    }

                    $array_emergencia=array();
                    for ($i=0; $i < count($resaspirante_emergencia); $i++) { 
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_nombres_apellidos'] = $resaspirante_emergencia[$i]['hvaem_nombres_apellidos'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_parentesco'] = $resaspirante_emergencia[$i]['hvaem_parentesco'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_telefono'] = $resaspirante_emergencia[$i]['hvaem_telefono'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_grupo_sanguineo'] = $resaspirante_emergencia[$i]['hvaem_grupo_sanguineo'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_rh'] = $resaspirante_emergencia[$i]['hvaem_rh'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_antecedentes'] = $resaspirante_emergencia[$i]['hvaem_antecedentes'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_registro_usuario'] = $resaspirante_emergencia[$i]['hvaem_registro_usuario'];
                        $array_emergencia[$resaspirante_emergencia[$i]['hvaem_aspirante']]['hvaem_registro_fecha'] = $resaspirante_emergencia[$i]['hvaem_registro_fecha'];
                    }

                    // Valida Información Familiar
                    $aspirante_familiar = new hv_aspirante_familiarModel();
                    $resaspirante_familiar=$aspirante_familiar->listAllReport();

                    if (!isset($resaspirante_familiar[0])) {
                        $resaspirante_familiar=array();
                    }

                    $array_familiar=array();
                    for ($i=0; $i < count($resaspirante_familiar); $i++) { 
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_nombres_apellidos'] = $resaspirante_familiar[$i]['hvaf_nombres_apellidos'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_parentesco'] = $resaspirante_familiar[$i]['hvaf_parentesco'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_edad'] = $resaspirante_familiar[$i]['hvaf_edad'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_nivel_educativo'] = $resaspirante_familiar[$i]['hvaf_nivel_educativo'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_acargo'] = $resaspirante_familiar[$i]['hvaf_acargo'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_convive'] = $resaspirante_familiar[$i]['hvaf_convive'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_registro_usuario'] = $resaspirante_familiar[$i]['hvaf_registro_usuario'];
                        $array_familiar[$resaspirante_familiar[$i]['hvaf_aspirante']]['hvaf_registro_fecha'] = $resaspirante_familiar[$i]['hvaf_registro_fecha'];
                    }

                    // Valida Información Ética
                    $aspirante_etica = new hv_aspirante_eticaModel();
                    $resaspirante_etica=$aspirante_etica->listAllReport();

                    if (!isset($resaspirante_etica[0])) {
                        $resaspirante_etica=array();
                    }

                    $array_etica=array();
                    for ($i=0; $i < count($resaspirante_etica); $i++) { 
                        $array_etica[$resaspirante_etica[$i]['hvae_aspirante']]['hvae_familiar'] = $resaspirante_etica[$i]['hvae_familiar'];
                        $array_etica[$resaspirante_etica[$i]['hvae_aspirante']]['hvae_familiar_nombre'] = $resaspirante_etica[$i]['hvae_familiar_nombre'];
                        $array_etica[$resaspirante_etica[$i]['hvae_aspirante']]['hvae_familiar_area'] = $resaspirante_etica[$i]['hvae_familiar_area'];
                        $array_etica[$resaspirante_etica[$i]['hvae_aspirante']]['hvae_registro_usuario'] = $resaspirante_etica[$i]['hvae_registro_usuario'];
                        $array_etica[$resaspirante_etica[$i]['hvae_aspirante']]['hvae_registro_fecha'] = $resaspirante_etica[$i]['hvae_registro_fecha'];
                    }

                    // Valida Información IQ
                    $aspirante_informacion = new hv_aspirante_informacionModel();
                    $resaspirante_informacion=$aspirante_informacion->listAllReport();

                    if (!isset($resaspirante_informacion[0])) {
                        $resaspirante_informacion=array();
                    }

                    $array_informacion=array();
                    for ($i=0; $i < count($resaspirante_informacion); $i++) { 
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_excolaborador'] = $resaspirante_informacion[$i]['hvai_excolaborador'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_excolaborador_motivo'] = $resaspirante_informacion[$i]['hvai_excolaborador_motivo'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_excolaborador_fecha'] = $resaspirante_informacion[$i]['hvai_excolaborador_fecha'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_seleccion_previo'] = $resaspirante_informacion[$i]['hvai_seleccion_previo'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_seleccion_previo_cargo'] = $resaspirante_informacion[$i]['hvai_seleccion_previo_cargo'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_seleccion_previo_fecha'] = $resaspirante_informacion[$i]['hvai_seleccion_previo_fecha'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_trabajo'] = $resaspirante_informacion[$i]['hvai_trabajo'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_trabajo_tipo'] = $resaspirante_informacion[$i]['hvai_trabajo_tipo'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_trabajo_empresa'] = $resaspirante_informacion[$i]['hvai_trabajo_empresa'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_trabajo_cargo'] = $resaspirante_informacion[$i]['hvai_trabajo_cargo'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_ocupacion'] = $resaspirante_informacion[$i]['hvai_ocupacion'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_conflicto_renuncia'] = $resaspirante_informacion[$i]['hvai_conflicto_renuncia'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_registro_usuario'] = $resaspirante_informacion[$i]['hvai_registro_usuario'];
                        $array_informacion[$resaspirante_informacion[$i]['hvai_aspirante']]['hvai_registro_fecha'] = $resaspirante_informacion[$i]['hvai_registro_fecha'];
                    }

                    // Valida Información Financiera
                    $aspirante_financiera = new hv_aspirante_financieraModel();
                    $resaspirante_financiera=$aspirante_financiera->listAllReport();

                    if (!isset($resaspirante_financiera[0])) {
                        $resaspirante_financiera=array();
                    }

                    $array_financiera=array();
                    for ($i=0; $i < count($resaspirante_financiera); $i++) { 
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_activos'] = $resaspirante_financiera[$i]['hvaf_activos'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_pasivos'] = $resaspirante_financiera[$i]['hvaf_pasivos'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_patrimonio'] = $resaspirante_financiera[$i]['hvaf_patrimonio'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_ingresos'] = $resaspirante_financiera[$i]['hvaf_ingresos'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_egresos'] = $resaspirante_financiera[$i]['hvaf_egresos'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_ingresos_otros'] = $resaspirante_financiera[$i]['hvaf_ingresos_otros'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_concepto_ingresos'] = $resaspirante_financiera[$i]['hvaf_concepto_ingresos'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_moneda_extranjera'] = $resaspirante_financiera[$i]['hvaf_moneda_extranjera'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_reporte'] = $resaspirante_financiera[$i]['hvaf_reporte'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_reporte_cual'] = $resaspirante_financiera[$i]['hvaf_reporte_cual'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_registro_usuario'] = $resaspirante_financiera[$i]['hvaf_registro_usuario'];
                        $array_financiera[$resaspirante_financiera[$i]['hvaf_aspirante']]['hvaf_registro_fecha'] = $resaspirante_financiera[$i]['hvaf_registro_fecha'];
                    }
                    
                    // Valida Personas Expuestas Públicamente - PEP
                    $aspirante_publico = new hv_aspirante_publicoModel();
                    $resaspirante_publico=$aspirante_publico->listAllReport();

                    if (!isset($resaspirante_publico[0])) {
                        $resaspirante_publico=array();
                    }

                    $array_publico=array();
                    for ($i=0; $i < count($resaspirante_publico); $i++) { 
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_recursos'] = $resaspirante_publico[$i]['hvap_recursos'];
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_reconocimiento'] = $resaspirante_publico[$i]['hvap_reconocimiento'];
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_poder'] = $resaspirante_publico[$i]['hvap_poder'];
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_familiar'] = $resaspirante_publico[$i]['hvap_familiar'];
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_observaciones'] = $resaspirante_publico[$i]['hvap_observaciones'];
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_registro_usuario'] = $resaspirante_publico[$i]['hvap_registro_usuario'];
                        $array_publico[$resaspirante_publico[$i]['hvap_aspirante']]['hvap_registro_fecha'] = $resaspirante_publico[$i]['hvap_registro_fecha'];
                    }

                    // Valida Seguridad Social
                    $aspirante_segsocial = new hv_aspirante_seguridad_socialModel();
                    $resaspirante_segsocial=$aspirante_segsocial->listAllReport();

                    if (!isset($resaspirante_segsocial[0])) {
                        $resaspirante_segsocial=array();
                    }

                    $array_segsocial=array();
                    for ($i=0; $i < count($resaspirante_segsocial); $i++) { 
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_eps'] = $resaspirante_segsocial[$i]['hvass_eps'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_pension'] = $resaspirante_segsocial[$i]['hvass_pension'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_pension_voluntario'] = $resaspirante_segsocial[$i]['hvass_pension_voluntario'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_cesantias'] = $resaspirante_segsocial[$i]['hvass_cesantias'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_prepagada'] = $resaspirante_segsocial[$i]['hvass_prepagada'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_registro_usuario'] = $resaspirante_segsocial[$i]['hvass_registro_usuario'];
                        $array_segsocial[$resaspirante_segsocial[$i]['hvass_aspirante']]['hvass_registro_fecha'] = $resaspirante_segsocial[$i]['hvass_registro_fecha'];
                    }

                    // Valida Declaraciones y Autorizaciones
                    $aspirante_autorizaciones = new hv_aspirante_autorizacionesModel();
                    $resaspirante_autorizaciones=$aspirante_autorizaciones->listAllReport();

                    if (!isset($resaspirante_autorizaciones[0])) {
                        $resaspirante_autorizaciones=array();
                    }

                    $array_autorizaciones=array();
                    for ($i=0; $i < count($resaspirante_autorizaciones); $i++) { 
                        $array_autorizaciones[$resaspirante_autorizaciones[$i]['hvada_aspirante']]['hvada_veracidad'] = $resaspirante_autorizaciones[$i]['hvada_veracidad'];
                        $array_autorizaciones[$resaspirante_autorizaciones[$i]['hvada_aspirante']]['hvada_origen_fondos'] = $resaspirante_autorizaciones[$i]['hvada_origen_fondos'];
                        $array_autorizaciones[$resaspirante_autorizaciones[$i]['hvada_aspirante']]['hvada_proteccion_datos'] = $resaspirante_autorizaciones[$i]['hvada_proteccion_datos'];
                        $array_autorizaciones[$resaspirante_autorizaciones[$i]['hvada_aspirante']]['hvada_tratamiento_datos'] = $resaspirante_autorizaciones[$i]['hvada_tratamiento_datos'];
                        $array_autorizaciones[$resaspirante_autorizaciones[$i]['hvada_aspirante']]['hvada_registro_usuario'] = $resaspirante_autorizaciones[$i]['hvada_registro_usuario'];
                        $array_autorizaciones[$resaspirante_autorizaciones[$i]['hvada_aspirante']]['hvada_registro_fecha'] = $resaspirante_autorizaciones[$i]['hvada_registro_fecha'];
                    }

                    // Valida Estudios terminados
                    $aspirante_estudio = new hv_aspirante_estudio_terminadoModel();
                    $resaspirante_estudio_terminado=$aspirante_estudio->listAllReport();

                    if (!isset($resaspirante_estudio_terminado[0])) {
                        $resaspirante_estudio_terminado=array();
                    }

                    $array_estudio_terminado=array();
                    for ($i=0; $i < count($resaspirante_estudio_terminado); $i++) { 
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_nivel'][] = $resaspirante_estudio_terminado[$i]['hvaet_nivel'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_nivel'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_nivel']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_establecimiento'][] = $resaspirante_estudio_terminado[$i]['hvaet_establecimiento'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_establecimiento'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_establecimiento']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_titulo'][] = $resaspirante_estudio_terminado[$i]['hvaet_titulo'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_titulo'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_titulo']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_ciudad'][] = $resaspirante_estudio_terminado[$i]['hvaet_ciudad'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_ciudad'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_ciudad']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_fecha_inicio'][] = $resaspirante_estudio_terminado[$i]['hvaet_fecha_inicio'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_fecha_inicio'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_fecha_inicio']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_fecha_terminacion'][] = $resaspirante_estudio_terminado[$i]['hvaet_fecha_terminacion'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_fecha_terminacion'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_fecha_terminacion']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_tarjeta_profesional'][] = $resaspirante_estudio_terminado[$i]['hvaet_tarjeta_profesional'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_tarjeta_profesional'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['hvaet_tarjeta_profesional']=array();
                        }
                        $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['ciudad'][] = $resaspirante_estudio_terminado[$i]['ciu_municipio'].', '.$resaspirante_estudio_terminado[$i]['ciu_departamento'];
                        if (!isset($array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['ciudad'][0])) {
                            $array_estudio_terminado[$resaspirante_estudio_terminado[$i]['hvaet_aspirante']]['ciudad']=array();
                        }
                    }

                    $aspirante_experiencia = new hv_aspirante_experienciaModel();
                    $resaspirante_experiencia=$aspirante_experiencia->listAllReport();

                    if (!isset($resaspirante_experiencia[0])) {
                        $resaspirante_experiencia=array();
                    }
                    
                    
                    $array_experiencia=array();
                    for ($i=0; $i < count($resaspirante_experiencia); $i++) { 
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_empresa'][] = $resaspirante_experiencia[$i]['hvaex_empresa'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_empresa'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_empresa']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_cargo'][] = $resaspirante_experiencia[$i]['hvaex_cargo'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_cargo'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_cargo']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_fecha_inicio'][] = $resaspirante_experiencia[$i]['hvaex_fecha_inicio'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_fecha_inicio'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_fecha_inicio']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_fecha_retiro'][] = $resaspirante_experiencia[$i]['hvaex_fecha_retiro'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_fecha_retiro'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_fecha_retiro']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_ciudad'][] = $resaspirante_experiencia[$i]['hvaex_ciudad'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_ciudad'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_ciudad']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_jefe_nombre'][] = $resaspirante_experiencia[$i]['hvaex_jefe_nombre'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_jefe_nombre'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_jefe_nombre']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_jefe_cargo'][] = $resaspirante_experiencia[$i]['hvaex_jefe_cargo'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_jefe_cargo'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_jefe_cargo']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_telefonos'][] = $resaspirante_experiencia[$i]['hvaex_telefonos'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_telefonos'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_telefonos']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_motivo_retiro'][] = $resaspirante_experiencia[$i]['hvaex_motivo_retiro'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_motivo_retiro'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['hvaex_motivo_retiro']=array();
                        }
                        $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['ciudad'][] = $resaspirante_experiencia[$i]['ciu_municipio'].', '.$resaspirante_experiencia[$i]['ciu_departamento'];
                        if (!isset($array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['ciudad'][0])) {
                            $array_experiencia[$resaspirante_experiencia[$i]['hvaex_aspirante']]['ciudad']=array();
                        }
                    }
                    
                    // Ingresar Data consultada a partir de la fila 4
                    $array_detalle_seleccion = array();
                    for ($i=5; $i < count($resregistros)+5; $i++) {
                        $id_aspirante=$resregistros[$i-5]['hva_id'];

                        $edad_aspirante='';
                        if ($resregistros[$i-5]['hva_nacimiento_fecha']!='') {
                            $edad_aspirante=calcularEdad($resregistros[$i-5]['hva_nacimiento_fecha']);
                        }

                        $array_detalle_seleccion[$id_aspirante]['hva_estado']=$resregistros[$i-5]['hva_estado'];
                        $array_detalle_seleccion[$id_aspirante]['hva_identificacion']=$resregistros[$i-5]['hva_identificacion'];//No Identificación
                        $array_detalle_seleccion[$id_aspirante]['hva_auxiliar_5']=$resregistros[$i-5]['hva_auxiliar_5'];//Fecha expedición
                        $array_detalle_seleccion[$id_aspirante]['hva_nombres']=$resregistros[$i-5]['hva_nombres'];//Primer Nombre
                        $array_detalle_seleccion[$id_aspirante]['hva_nombres_2']=$resregistros[$i-5]['hva_nombres_2'];//Segundo Nombre
                        $array_detalle_seleccion[$id_aspirante]['hva_apellido_1']=$resregistros[$i-5]['hva_apellido_1'];//Primero Apellido
                        $array_detalle_seleccion[$id_aspirante]['hva_apellido_2']=$resregistros[$i-5]['hva_apellido_2'];//Segundo Apellido
                        $array_detalle_seleccion[$id_aspirante]['hva_direccion']=$resregistros[$i-5]['hva_direccion'];//Dirección
                        $array_detalle_seleccion[$id_aspirante]['hva_barrio']=$resregistros[$i-5]['ciub_barrio'];//Barrio
                        $array_detalle_seleccion[$id_aspirante]['ciub_localidad']=$resregistros[$i-5]['ciub_localidad'];//Barrio
                        $array_detalle_seleccion[$id_aspirante]['ac_nombre']=$resregistros[$i-5]['ac_nombre'];//Barrio
                        $array_detalle_seleccion[$id_aspirante]['aa_nombre']=$resregistros[$i-5]['aa_nombre'];//Barrio
                        $array_detalle_seleccion[$id_aspirante]['hva_ingreso_fecha']=$resregistros[$i-5]['hva_ingreso_fecha'];//Barrio
                        $array_detalle_seleccion[$id_aspirante]['hva_retiro_fecha']=$resregistros[$i-5]['hva_retiro_fecha'];//Barrio
                        $array_detalle_seleccion[$id_aspirante]['hva_retiro_motivo']=$resregistros[$i-5]['hva_retiro_motivo'];//Barrio

                        $array_detalle_seleccion[$id_aspirante]['ciu_municipio']=$resregistros[$i-5]['ciu_municipio'];//Ciudad
                        $array_detalle_seleccion[$id_aspirante]['ciu_departamento']=$resregistros[$i-5]['ciu_departamento'];//Departamento
                        $array_detalle_seleccion[$id_aspirante]['hva_celular']=$resregistros[$i-5]['hva_celular'];//Celular
                        $array_detalle_seleccion[$id_aspirante]['hva_celular_2']=$resregistros[$i-5]['hva_celular_2'];//Celular Alternativo
                        $array_detalle_seleccion[$id_aspirante]['hva_correo']=$resregistros[$i-5]['hva_correo'];//Email
                        $array_detalle_seleccion[$id_aspirante]['hva_correo_corporativo']=$resregistros[$i-5]['hva_correo_corporativo'];//Email
                        $array_detalle_seleccion[$id_aspirante]['nacimiento_ciu_municipio']=$resregistros[$i-5]['nacimiento_ciu_municipio'].', '.$resregistros[$i-5]['nacimiento_ciu_departamento'];//Lugar de Nacimiento
                        $array_detalle_seleccion[$id_aspirante]['hva_nacimiento_fecha']=$resregistros[$i-5]['hva_nacimiento_fecha'];//Fecha Nacimiento
                        $array_detalle_seleccion[$id_aspirante]['edad_aspirante']=$edad_aspirante;//Edad
                        $array_detalle_seleccion[$id_aspirante]['hva_estado_civil']=$resregistros[$i-5]['hva_estado_civil'];//Estado Civil
                        $array_detalle_seleccion[$id_aspirante]['hva_genero']=$resregistros[$i-5]['hva_genero'];//Género
                        $array_detalle_seleccion[$id_aspirante]['hvaem_grupo_sanguineo']=$array_emergencia[$id_aspirante]['hvaem_grupo_sanguineo'];//Grupo Sanguíneo
                        $array_detalle_seleccion[$id_aspirante]['hvaem_rh']=$array_emergencia[$id_aspirante]['hvaem_rh'];//RH
                        $array_detalle_seleccion[$id_aspirante]['hva_operador_internet']=$resregistros[$i-5]['hva_operador_internet'];//Operador Internet
                        $array_detalle_seleccion[$id_aspirante]['hvaem_nombres_apellidos']=$array_emergencia[$id_aspirante]['hvaem_nombres_apellidos'];//Información Emergencia-Nombres y Apellidos
                        $array_detalle_seleccion[$id_aspirante]['hvaem_parentesco']=$array_emergencia[$id_aspirante]['hvaem_parentesco'];//Información Emergencia-Parentesco
                        $array_detalle_seleccion[$id_aspirante]['hvaem_telefono']=$array_emergencia[$id_aspirante]['hvaem_telefono'];//Información Emergencia-Teléfono
                        $array_detalle_seleccion[$id_aspirante]['hvae_familiar']=$array_etica[$id_aspirante]['hvae_familiar'];//¿Tiene usted familiares, conyugue y/o compañero permanente
                        $array_detalle_seleccion[$id_aspirante]['hvae_familiar_nombre']=$array_etica[$id_aspirante]['hvae_familiar_nombre'];//Nombres y Apellidos
                        $array_detalle_seleccion[$id_aspirante]['hvae_familiar_area']=$array_etica[$id_aspirante]['hvae_familiar_area'];//Área
                        $array_detalle_seleccion[$id_aspirante]['hvai_excolaborador']=$array_informacion[$id_aspirante]['hvai_excolaborador'];//¿Ha trabajado anteriormente en IQ?
                        $array_detalle_seleccion[$id_aspirante]['hvai_excolaborador_motivo']=$array_informacion[$id_aspirante]['hvai_excolaborador_motivo'];//Motivo del retiro
                        $array_detalle_seleccion[$id_aspirante]['hvai_excolaborador_fecha']=$array_informacion[$id_aspirante]['hvai_excolaborador_fecha'];//Fecha de retiro
                        $array_detalle_seleccion[$id_aspirante]['hvai_seleccion_previo']=$array_informacion[$id_aspirante]['hvai_seleccion_previo'];//¿Ha presentado procesos de selección previamente en IQ?
                        $array_detalle_seleccion[$id_aspirante]['hvai_seleccion_previo_cargo']=$array_informacion[$id_aspirante]['hvai_seleccion_previo_cargo'];//Cargo
                        $array_detalle_seleccion[$id_aspirante]['hvai_seleccion_previo_fecha']=$array_informacion[$id_aspirante]['hvai_seleccion_previo_fecha'];//Fecha
                        $array_detalle_seleccion[$id_aspirante]['hvai_trabajo']=$array_informacion[$id_aspirante]['hvai_trabajo'];//¿Declara tener otro trabajo u ocupación simultánea?
                        $array_detalle_seleccion[$id_aspirante]['hvai_trabajo_tipo']=$array_informacion[$id_aspirante]['hvai_trabajo_tipo'];//Tipo de vinculación
                        $array_detalle_seleccion[$id_aspirante]['hvai_trabajo_empresa']=$array_informacion[$id_aspirante]['hvai_trabajo_empresa'];//Nombre de la empresa
                        $array_detalle_seleccion[$id_aspirante]['hvai_trabajo_cargo']=$array_informacion[$id_aspirante]['hvai_trabajo_cargo'];//Cargo
                        $array_detalle_seleccion[$id_aspirante]['hvai_ocupacion']=$array_informacion[$id_aspirante]['hvai_ocupacion'];//Ocupación o trabajo desempeñado
                        $array_detalle_seleccion[$id_aspirante]['hvai_conflicto_renuncia']=$array_informacion[$id_aspirante]['hvai_conflicto_renuncia'];//¿Si su ocupación actual genera conflicto de interés
                        
                        $array_detalle_seleccion[$id_aspirante]['hvaf_activos']=$array_financiera[$id_aspirante]['hvaf_activos'];//Activos
                        $array_detalle_seleccion[$id_aspirante]['hvaf_pasivos']=$array_financiera[$id_aspirante]['hvaf_pasivos'];//Pasivos
                        $array_detalle_seleccion[$id_aspirante]['hvaf_patrimonio']=$array_financiera[$id_aspirante]['hvaf_patrimonio'];//Patrimonio
                        $array_detalle_seleccion[$id_aspirante]['hvaf_ingresos']=$array_financiera[$id_aspirante]['hvaf_ingresos'];//Ingresos mensuales
                        $array_detalle_seleccion[$id_aspirante]['hvaf_egresos']=$array_financiera[$id_aspirante]['hvaf_egresos'];//Egresos mensuales
                        $array_detalle_seleccion[$id_aspirante]['hvaf_ingresos_otros']=$array_financiera[$id_aspirante]['hvaf_ingresos_otros'];//Otros ingresos
                        $array_detalle_seleccion[$id_aspirante]['hvaf_concepto_ingresos']=$array_financiera[$id_aspirante]['hvaf_concepto_ingresos'];//Concepto de otros ingresos
                        $array_detalle_seleccion[$id_aspirante]['hvaf_moneda_extranjera']=$array_financiera[$id_aspirante]['hvaf_moneda_extranjera'];//¿Realiza Operaciones en Moneda Extranjera?
                        $array_detalle_seleccion[$id_aspirante]['hvaf_reporte']=$array_financiera[$id_aspirante]['hvaf_reporte'];//¿Se encuentra reportado en alguna central de riesgos?
                        $array_detalle_seleccion[$id_aspirante]['hvaf_reporte_cual']=$array_financiera[$id_aspirante]['hvaf_reporte_cual'];//¿Cuál?
                        $array_detalle_seleccion[$id_aspirante]['hvap_recursos']=$array_publico[$id_aspirante]['hvap_recursos'];//¿Maneja recursos públicos?
                        $array_detalle_seleccion[$id_aspirante]['hvap_reconocimiento']=$array_publico[$id_aspirante]['hvap_reconocimiento'];//¿Goza de reconocimiento público general?
                        $array_detalle_seleccion[$id_aspirante]['hvap_poder']=$array_publico[$id_aspirante]['hvap_poder'];//¿Ejerce algún grado de poder público?
                        $array_detalle_seleccion[$id_aspirante]['hvap_familiar']=$array_publico[$id_aspirante]['hvap_familiar'];//¿Tiene usted algún familiar que cumpla con una característica anterior?
                        $array_detalle_seleccion[$id_aspirante]['hvap_observaciones']=$array_publico[$id_aspirante]['hvap_observaciones'];//Si alguna de las respuestas anteriores es afirmativa, por favor especifique
                        $array_detalle_seleccion[$id_aspirante]['hvass_eps']=$array_segsocial[$id_aspirante]['hvass_eps'];//EPS
                        $array_detalle_seleccion[$id_aspirante]['hvass_pension']=$array_segsocial[$id_aspirante]['hvass_pension'];//Fondo de pensión
                        $array_detalle_seleccion[$id_aspirante]['hvass_pension_voluntario']=$array_segsocial[$id_aspirante]['hvass_pension_voluntario'];//Fondo de cesantías
                        $array_detalle_seleccion[$id_aspirante]['hvass_cesantias']=$array_segsocial[$id_aspirante]['hvass_cesantias'];//Fondo voluntario de pensión
                        $array_detalle_seleccion[$id_aspirante]['hvass_prepagada']=$array_segsocial[$id_aspirante]['hvass_prepagada'];//Medicina prepagada
                        
                        if(isset($array_experiencia[$id_aspirante]['hvaex_empresa'][0])){
                            $hvaex_empresa=implode(';', $array_experiencia[$id_aspirante]['hvaex_empresa']);

                        } else {
                            $hvaex_empresa='';
                        }
                        if(isset($array_experiencia[$id_aspirante]['hvaex_cargo'][0])){
                            $hvaex_cargo=implode(';', $array_experiencia[$id_aspirante]['hvaex_cargo']);

                        } else {
                            $hvaex_cargo='';
                        }
                        if(isset($array_experiencia[$id_aspirante]['hvaex_fecha_inicio'][0])){
                            $hvaex_fecha_inicio=implode(';', $array_experiencia[$id_aspirante]['hvaex_fecha_inicio']);

                        } else {
                            $hvaex_fecha_inicio='';
                        }
                        if(isset($array_experiencia[$id_aspirante]['hvaex_fecha_retiro'][0])){
                            $hvaex_fecha_retiro=implode(';', $array_experiencia[$id_aspirante]['hvaex_fecha_retiro']);

                        } else {
                            $hvaex_fecha_retiro='';
                        }
                        if(isset($array_experiencia[$id_aspirante]['hvaex_jefe_nombre'][0])){
                            $hvaex_jefe_nombre=implode(';', $array_experiencia[$id_aspirante]['hvaex_jefe_nombre']);

                        } else {
                            $hvaex_jefe_nombre='';
                        }
                        if(isset($array_experiencia[$id_aspirante]['hvaex_jefe_cargo'][0])){
                            $hvaex_jefe_cargo=implode(';', $array_experiencia[$id_aspirante]['hvaex_jefe_cargo']);

                        } else {
                            $hvaex_jefe_cargo='';
                        }
                        if(isset($array_experiencia[$id_aspirante]['hvaex_telefonos'][0])){
                            $hvaex_telefonos=implode(';', $array_experiencia[$id_aspirante]['hvaex_telefonos']);

                        } else {
                            $hvaex_telefonos='';
                        }
                        if(isset($array_experiencia[$id_aspirante]['hvaex_motivo_retiro'][0])){
                            $hvaex_motivo_retiro=implode(';', $array_experiencia[$id_aspirante]['hvaex_motivo_retiro']);

                        } else {
                            $hvaex_motivo_retiro='';
                        }
                        if(isset($array_experiencia[$id_aspirante]['ciudad'][0])){
                            $ciudad=implode(';', $array_experiencia[$id_aspirante]['ciudad']);

                        } else {
                            $ciudad='';
                        }
                        
                        $array_detalle_seleccion[$id_aspirante]['hvaex_empresa']=$hvaex_empresa;
                        $array_detalle_seleccion[$id_aspirante]['hvaex_cargo']=$hvaex_cargo;
                        $array_detalle_seleccion[$id_aspirante]['hvaex_fecha_inicio']=$hvaex_fecha_inicio;
                        $array_detalle_seleccion[$id_aspirante]['hvaex_fecha_retiro']=$hvaex_fecha_retiro;
                        $array_detalle_seleccion[$id_aspirante]['ciudad']=$ciudad;
                        $array_detalle_seleccion[$id_aspirante]['hvaex_jefe_nombre']=$hvaex_jefe_nombre;
                        $array_detalle_seleccion[$id_aspirante]['hvaex_jefe_cargo']=$hvaex_jefe_cargo;
                        $array_detalle_seleccion[$id_aspirante]['hvaex_telefonos']=$hvaex_telefonos;
                        $array_detalle_seleccion[$id_aspirante]['hvaex_motivo_retiro']=$hvaex_motivo_retiro;

                        if (isset($array_estudio_terminado[$id_aspirante]['hvaet_nivel'][0])) {
                            $hvaet_nivel=implode(';', $array_estudio_terminado[$id_aspirante]['hvaet_nivel']);
                            
                        } else {
                            $hvaet_nivel='';
                        }
                        if (isset($array_estudio_terminado[$id_aspirante]['hvaet_establecimiento'][0])) {
                            $hvaet_establecimiento=implode(';', $array_estudio_terminado[$id_aspirante]['hvaet_establecimiento']);
                            
                        } else {
                            $hvaet_establecimiento='';
                        }
                        if (isset($array_estudio_terminado[$id_aspirante]['hvaet_titulo'][0])) {
                            $hvaet_titulo=implode(';', $array_estudio_terminado[$id_aspirante]['hvaet_titulo']);
                            
                        } else {
                            $hvaet_titulo='';
                        }
                        if (isset($array_estudio_terminado[$id_aspirante]['hvaet_fecha_inicio'][0])) {
                            $hvaet_fecha_inicio=implode(';', $array_estudio_terminado[$id_aspirante]['hvaet_fecha_inicio']);
                            
                        } else {
                            $hvaet_fecha_inicio='';
                        }
                        if (isset($array_estudio_terminado[$id_aspirante]['hvaet_fecha_terminacion'][0])) {
                            $hvaet_fecha_terminacion=implode(';', $array_estudio_terminado[$id_aspirante]['hvaet_fecha_terminacion']);
                            
                        } else {
                            $hvaet_fecha_terminacion='';
                        }
                        if (isset($array_estudio_terminado[$id_aspirante]['hvaet_tarjeta_profesional'][0])) {
                            $hvaet_tarjeta_profesional=implode(';', $array_estudio_terminado[$id_aspirante]['hvaet_tarjeta_profesional']);
                            
                        } else {
                            $hvaet_tarjeta_profesional='';
                        }
                        if (isset($array_estudio_terminado[$id_aspirante]['ciudad'][0])) {
                            $ciudad=implode(';', $array_estudio_terminado[$id_aspirante]['ciudad']);
                            
                        } else {
                            $ciudad='';
                        }

                        $array_detalle_seleccion[$id_aspirante]['hvaet_nivel']=$hvaet_nivel;
                        $array_detalle_seleccion[$id_aspirante]['hvaet_establecimiento']=$hvaet_establecimiento;
                        $array_detalle_seleccion[$id_aspirante]['hvaet_titulo']=$hvaet_titulo;
                        $array_detalle_seleccion[$id_aspirante]['ciudad']=$ciudad;
                        $array_detalle_seleccion[$id_aspirante]['hvaet_fecha_inicio']=$hvaet_fecha_inicio;
                        $array_detalle_seleccion[$id_aspirante]['hvaet_fecha_terminacion']=$hvaet_fecha_terminacion;
                        $array_detalle_seleccion[$id_aspirante]['hvaet_tarjeta_profesional']=$hvaet_tarjeta_profesional;
                    }
                    
                    
                    $hoja_vida = new hv_personalModel();
                    if ($estado!='' AND $estado!='Todos') {
                        $hoja_vida->hvp_estado=$estado;
                    }

                    $resregistros_hoja_vida=$hoja_vida->listAllReportAspirantes();
                    
                    if (!isset($resregistros_hoja_vida[0])) {
                        $resregistros_hoja_vida=array();
                    }

                    // echo "<pre>";
                    // print_r($resregistros_hoja_vida);
                    // echo "</pre>";

                    $array_detalle_hoja_vida = array();
                    for ($i=5; $i < count($resregistros_hoja_vida)+5; $i++) {
                        $id_aspirantehv=$resregistros_hoja_vida[$i-5]['hvp_aspirante_id'];
                        // Fecha actual
                        $fecha_actual = new DateTime();

                        if ($resregistros_hoja_vida[$i-5]['hvp_actualiza_fecha']!='') {
                            // Fecha de inicio (puedes poner cualquier fecha en formato 'YYYY-MM-DD')
                            $fecha_inicio = new DateTime($resregistros_hoja_vida[$i-5]['hvp_actualiza_fecha']);
                            // Calcular la diferencia entre las dos fechas
                            $diferencia = $fecha_actual->diff($fecha_inicio);
                            $dias_diferencia=$diferencia->days;
                        } else {
                            $dias_diferencia='';
                        }
                        
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_estado']=$resregistros_hoja_vida[$i-5]['hvp_estado'];//Estado
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_actualiza_fecha']=$resregistros_hoja_vida[$i-5]['hvp_actualiza_fecha'];//Fecha Actualización
                        $array_detalle_hoja_vida[$id_aspirantehv]['dias_diferencia']=$dias_diferencia;//Tiempo Actualización
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_consentimiento_tratamiento_datos_personales']=$resregistros_hoja_vida[$i-5]['hvp_consentimiento_tratamiento_datos_personales'];//Consentimiento Tratamiento Datos
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_datos_personales_tipo_documento']=$resregistros_hoja_vida[$i-5]['hvp_datos_personales_tipo_documento'];//Tipo de documento de identidad
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_datos_personales_numero_identificacion']=$resregistros_hoja_vida[$i-5]['hvp_datos_personales_numero_identificacion'];//Número de identificación
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_datos_personales_nombre_1']=$resregistros_hoja_vida[$i-5]['hvp_datos_personales_nombre_1'];//Primer nombre
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_datos_personales_nombre_2']=$resregistros_hoja_vida[$i-5]['hvp_datos_personales_nombre_2'];//Segundo nombre
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_datos_personales_apellido_1']=$resregistros_hoja_vida[$i-5]['hvp_datos_personales_apellido_1'];//Primer apellido
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_datos_personales_apellido_2']=$resregistros_hoja_vida[$i-5]['hvp_datos_personales_apellido_2'];//Segundo apellido
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_auxiliar_1']=$resregistros_hoja_vida[$i-5]['hvp_auxiliar_1'];//¿Cómo prefieres que te llamen?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_demografia_genero']=$resregistros_hoja_vida[$i-5]['hvp_demografia_genero'];//¿Cuál es tu género? 
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_demografia_estado_civil']=$resregistros_hoja_vida[$i-5]['hvp_demografia_estado_civil'];//¿Cuál es tu estado civil ?
                        $array_detalle_hoja_vida[$id_aspirantehv]['TCIUDADN_ciu_municipio']=$resregistros_hoja_vida[$i-5]['TCIUDADN_ciu_municipio'].', '.$resregistros_hoja_vida[$i-5]['TCIUDADN_ciu_departamento'];//Lugar nacimiento 
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_demografia_fecha_nacimiento']=$resregistros_hoja_vida[$i-5]['hvp_demografia_fecha_nacimiento'];//Fecha nacimiento
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_demografia_edad']=$resregistros_hoja_vida[$i-5]['hvp_demografia_edad'];//Edad
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_expectativa_motivacion_expectativa_desarrollo']=$resregistros_hoja_vida[$i-5]['hvp_expectativa_motivacion_expectativa_desarrollo'];//¿Llevas más de 6 meses en la compañía? 
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_expectativa_motivacion_expectativa_crecimiento_profesional']=$resregistros_hoja_vida[$i-5]['hvp_expectativa_motivacion_expectativa_crecimiento_profesional'];//¿Crees que este trabajo te ofrecerá oportunidades de crecimiento profesional?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_expectativa_motivacion_realidad_crecimiento_profesional']=$resregistros_hoja_vida[$i-5]['hvp_expectativa_motivacion_realidad_crecimiento_profesional'];//¿En qué medida estás de acuerdo con la siguiente afirmación?: “Este trabajo me ha ofrecido oportunidades de crecimiento laboral.”
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_expectativa_motivacion_motivacion_trabajo']=$resregistros_hoja_vida[$i-5]['hvp_expectativa_motivacion_motivacion_trabajo'];//Motivación principal para aceptar el trabajo
                        $array_detalle_hoja_vida[$id_aspirantehv]['TCIUDAD_ciu_municipio']=$resregistros_hoja_vida[$i-5]['TCIUDAD_ciu_municipio'].', '.$resregistros_hoja_vida[$i-5]['TCIUDAD_ciu_departamento'];//Ciudad de residencia 
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_ubicacion_direccion_residencia']=$resregistros_hoja_vida[$i-5]['hvp_ubicacion_direccion_residencia'];//Dirección de residencia
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_ubicacion_localidad_comuna']=$resregistros_hoja_vida[$i-5]['hvp_ubicacion_localidad_comuna'];//Localidad/Comuna
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_ubicacion_barrio']=$resregistros_hoja_vida[$i-5]['hvp_ubicacion_barrio'];//Barrio
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_ubicacion_maps_latitud']=$resregistros_hoja_vida[$i-5]['hvp_ubicacion_maps_latitud'];//Maps Latitud
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_ubicacion_maps_longitud']=$resregistros_hoja_vida[$i-5]['hvp_ubicacion_maps_longitud'];//Maps Longitud
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_ubicacion_maps_ciudad']=$resregistros_hoja_vida[$i-5]['hvp_ubicacion_maps_ciudad'];//Maps Ciudad
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_ubicacion_maps_departamento']=$resregistros_hoja_vida[$i-5]['hvp_ubicacion_maps_departamento'];//Maps Departamento
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_ubicacion_maps_pais']=$resregistros_hoja_vida[$i-5]['hvp_ubicacion_maps_pais'];//Maps Pais
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_ubicacion_maps_localidad']=$resregistros_hoja_vida[$i-5]['hvp_ubicacion_maps_localidad'];//Maps Localidad
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_ubicacion_maps_barrio']=$resregistros_hoja_vida[$i-5]['hvp_ubicacion_maps_barrio'];//Maps Barrio
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_ubicacion_maps_codigo_postal']=$resregistros_hoja_vida[$i-5]['hvp_ubicacion_maps_codigo_postal'];//Maps Código Postal
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_ubicacion_maps_direccion']=$resregistros_hoja_vida[$i-5]['hvp_ubicacion_maps_direccion'];//Maps Dirección
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_contacto_numero_celular']=$resregistros_hoja_vida[$i-5]['hvp_contacto_numero_celular'];//Número de celular
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_auxiliar_2']=$resregistros_hoja_vida[$i-5]['hvp_auxiliar_2'];//Número de celular alternativo
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_contacto_correo_personal']=$resregistros_hoja_vida[$i-5]['hvp_contacto_correo_personal'];//Correo electrónico personal
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_contacto_correo_corporativo']=$resregistros_hoja_vida[$i-5]['hvp_contacto_correo_corporativo'];//Correo electrónico corporativo
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_contacto_emergencia_nombres']=$resregistros_hoja_vida[$i-5]['hvp_contacto_emergencia_nombres'];//1. Nombres
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_contacto_emergencia_apellidos']=$resregistros_hoja_vida[$i-5]['hvp_contacto_emergencia_apellidos'];//1. Apellidos
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_contacto_emergencia_parentesco']=$resregistros_hoja_vida[$i-5]['hvp_contacto_emergencia_parentesco'];//1. Parentesco
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_contacto_emergencia_celular']=$resregistros_hoja_vida[$i-5]['hvp_contacto_emergencia_celular'];//1. Número de celular de tu familiar/amigo(a)
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_contacto_emergencia_nombres_2']=$resregistros_hoja_vida[$i-5]['hvp_contacto_emergencia_nombres_2'];//2. Nombres
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_contacto_emergencia_apellidos_2']=$resregistros_hoja_vida[$i-5]['hvp_contacto_emergencia_apellidos_2'];//2. Apellidos
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_contacto_emergencia_parentesco_2']=$resregistros_hoja_vida[$i-5]['hvp_contacto_emergencia_parentesco_2'];//2. Parentesco
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_contacto_emergencia_celular_2']=$resregistros_hoja_vida[$i-5]['hvp_contacto_emergencia_celular_2'];//2. Número de celular de tu familiar/amigo(a)
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_socioeconomico_estrato_socioeconomico']=$resregistros_hoja_vida[$i-5]['hvp_socioeconomico_estrato_socioeconomico'];//Estrato socioeconómico
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_socioeconomico_operador_internet']=$resregistros_hoja_vida[$i-5]['hvp_socioeconomico_operador_internet'];//Operador de internet 
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_socioeconomico_operador_internet_otro']=$resregistros_hoja_vida[$i-5]['hvp_socioeconomico_operador_internet_otro'];//Operador de internet - Otro
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_socioeconomico_velocidad_internet_descarga']=$resregistros_hoja_vida[$i-5]['hvp_socioeconomico_velocidad_internet_descarga'];//Velocidad de descarga de internet (MB)
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_socioeconomico_velocidad_internet_carga']=$resregistros_hoja_vida[$i-5]['hvp_socioeconomico_velocidad_internet_carga'];//Velocidad de carga de internet (MB)
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_socioeconomico_caracteristicas_vivienda']=$resregistros_hoja_vida[$i-5]['hvp_socioeconomico_caracteristicas_vivienda'];//Características de tu vivienda
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_socioeconomico_condiciones_vivienda']=$resregistros_hoja_vida[$i-5]['hvp_socioeconomico_condiciones_vivienda'];//Condición de la vivienda
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_socioeconomico_estado_terminacion_vivienda']=$resregistros_hoja_vida[$i-5]['hvp_socioeconomico_estado_terminacion_vivienda'];//¿Cuál es el estado de terminación de tu vivienda?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_socioeconomico_servicios_vivienda']=$resregistros_hoja_vida[$i-5]['hvp_socioeconomico_servicios_vivienda'];//¿Qué servicios tienes en tu vivienda?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_socioeconomico_plan_compra_vivienda']=$resregistros_hoja_vida[$i-5]['hvp_socioeconomico_plan_compra_vivienda'];//¿Tienes pensado comprar vivienda en los próximos 3 años?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_socioeconomico_beneficiario_subsidio_vivienda']=$resregistros_hoja_vida[$i-5]['hvp_socioeconomico_beneficiario_subsidio_vivienda'];//¿Has sido beneficiario de subsidio de vivienda?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_familia_numero_hijos']=$resregistros_hoja_vida[$i-5]['hvp_familia_numero_hijos'];//¿Cuántos hijos tienes?
                        $array_detalle_hoja_vida[$id_aspirantehv]['xxx']=$resregistros_hoja_vida[$i-5]['xxx'];//familia_hijos_menor_3
                        $array_detalle_hoja_vida[$id_aspirantehv]['xxx']=$resregistros_hoja_vida[$i-5]['xxx'];//familia_hijos_4_10
                        $array_detalle_hoja_vida[$id_aspirantehv]['xxx']=$resregistros_hoja_vida[$i-5]['xxx'];//familia_hijos_11_17
                        $array_detalle_hoja_vida[$id_aspirantehv]['xxx']=$resregistros_hoja_vida[$i-5]['xxx'];//familia_hijos_mayor_18
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_familia_capacitacion_familia']=$resregistros_hoja_vida[$i-5]['hvp_familia_capacitacion_familia'];//¿En cual de los siguientes temas relacionados con la familia te gustaría recibir
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_financiero_activos']=$resregistros_hoja_vida[$i-5]['hvp_financiero_activos'];//Activos
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_financiero_pasivos']=$resregistros_hoja_vida[$i-5]['hvp_financiero_pasivos'];//Pasivos
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_financiero_patrimonio']=$resregistros_hoja_vida[$i-5]['hvp_financiero_patrimonio'];//Patrimonio
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_financiero_ingresos']=$resregistros_hoja_vida[$i-5]['hvp_financiero_ingresos'];//Ingresos Mensuales
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_financiero_egresos']=$resregistros_hoja_vida[$i-5]['hvp_financiero_egresos'];//Egresos Mensuales
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_financiero_ingresos_otros']=$resregistros_hoja_vida[$i-5]['hvp_financiero_ingresos_otros'];//Otros Ingresos
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_financiero_concepto_ingresos']=$resregistros_hoja_vida[$i-5]['hvp_financiero_concepto_ingresos'];//Concepto de otros ingresos
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_financiero_moneda_extranjera']=$resregistros_hoja_vida[$i-5]['hvp_financiero_moneda_extranjera'];//¿Realiza Operaciones en Moneda Extranjera?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_origen_fondos']=$resregistros_hoja_vida[$i-5]['hvp_origen_fondos'];//Declaración de Origen de Fondos y Prevención de Lavado de Activos
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_pep_recursos']=$resregistros_hoja_vida[$i-5]['hvp_pep_recursos'];//¿Maneja recursos públicos?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_pep_reconocimiento']=$resregistros_hoja_vida[$i-5]['hvp_pep_reconocimiento'];//¿Goza de reconocimiento público general?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_pep_poder']=$resregistros_hoja_vida[$i-5]['hvp_pep_poder'];//¿Ejerce algún grado de poder público?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_pep_familiar']=$resregistros_hoja_vida[$i-5]['hvp_pep_familiar'];//¿Tiene usted algún familiar que cumpla con una característica anterior?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_pep_cedula']=$resregistros_hoja_vida[$i-5]['hvp_pep_cedula'];//¿Tiene usted algún familiar que cumpla con una característica anterior?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_pep_nombres_apellidos']=$resregistros_hoja_vida[$i-5]['hvp_pep_nombres_apellidos'];//¿Tiene usted algún familiar que cumpla con una característica anterior?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_salud_bienestar_grupo_sanguineo']=$resregistros_hoja_vida[$i-5]['hvp_salud_bienestar_grupo_sanguineo'];//¿Cuál es tu grupo sanguíneo?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_salud_bienestar_rh']=$resregistros_hoja_vida[$i-5]['hvp_salud_bienestar_rh'];//¿Cuál es tu RH?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_salud_bienestar_actividad_fisica_minima']=$resregistros_hoja_vida[$i-5]['hvp_salud_bienestar_actividad_fisica_minima'];//¿Realizas actividad física de mínimo 20 minutos al día?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_salud_bienestar_fumador']=$resregistros_hoja_vida[$i-5]['hvp_salud_bienestar_fumador'];//¿Fumas?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_salud_bienestar_pausas_activas']=$resregistros_hoja_vida[$i-5]['hvp_salud_bienestar_pausas_activas'];//¿Realizas pausas activas durante la jornada laboral?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_salud_bienestar_medicina_prepagada']=$resregistros_hoja_vida[$i-5]['hvp_salud_bienestar_medicina_prepagada'];//¿Tienes medicina prepagada?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_salud_bienestar_medicina_prepagada_cual']=$resregistros_hoja_vida[$i-5]['hvp_salud_bienestar_medicina_prepagada_cual'];//Medicina prepagada
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_salud_bienestar_plan_complementario_salud']=$resregistros_hoja_vida[$i-5]['hvp_salud_bienestar_plan_complementario_salud'];//¿Tienes plan complementario de salud?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_salud_bienestar_plan_complementario_salud_cual']=$resregistros_hoja_vida[$i-5]['hvp_salud_bienestar_plan_complementario_salud_cual'];//Plan Complementario
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_hobbies_deportes']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_hobbies_deportes'];//Deportes
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_hobbies_deportes_cual']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_hobbies_deportes_cual'];//Deportes - Otro
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_hobbies_deportes_frecuencia']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_hobbies_deportes_frecuencia'];//Deportes - Frecuencia
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_hobbies_aire']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_hobbies_aire'];//Actividades al aire libre
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_hobbies_aire_cual']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_hobbies_aire_cual'];//Actividades al aire libre - Otro
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_hobbies_aire_frecuencia']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_hobbies_aire_frecuencia'];//Actividades al aire libre - Frecuencia
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_hobbies_arte']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_hobbies_arte'];//Arte y creatividad
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_hobbies_arte_cual']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_hobbies_arte_cual'];//Arte y creatividad - Otro
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_hobbies_arte_instrumento']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_hobbies_arte_instrumento'];//Arte y creatividad - Música - Instrumento
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_hobbies_arte_frecuencia']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_hobbies_arte_frecuencia'];//Arte y creatividad - Frecuencia
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_hobbies_tecnologia']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_hobbies_tecnologia'];//Tecnología
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_hobbies_tecnologia_cual']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_hobbies_tecnologia_cual'];//Tecnología - Otro
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_hobbies_tecnologia_frecuencia']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_hobbies_tecnologia_frecuencia'];//Tecnología - Frecuencia
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_hobbies_otro']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_hobbies_otro'];//Otros
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_hobbies_otro_cual']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_hobbies_otro_cual'];//Otros - Otro
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_hobbies_otro_frecuencia']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_hobbies_otro_frecuencia'];//Otros - Frecuencia
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_hobbies_recibir_informacion']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_hobbies_recibir_informacion'];//¿Te gustaría recibir información sobre eventos o actividades relacionadas con tus hobbies?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_actividades_familia']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_actividades_familia'];//¿Cuáles actividades te gusta hacer en familia?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_actividades_deportivas']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_actividades_deportivas'];//¿Realizas actividades deportivas?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_actividades_deportivas_cual']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_actividades_deportivas_cual'];//Cuales actividades deportivas
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_medio_transporte']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_medio_transporte'];//¿Cuál es tu medio de transporte cuando vas a la oficina?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_habito_ahorro']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_habito_ahorro'];//¿Tienes el hábito de ahorrar?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_mascotas']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_mascotas'];//¿Tienes Mascotas?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_interes_habitos_mascotas_cual']=$resregistros_hoja_vida[$i-5]['hvp_interes_habitos_mascotas_cual'];//Cuéntanos que mascota tienes?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_formacion_ultimo_certificado_enviado_rrhh']=$resregistros_hoja_vida[$i-5]['hvp_formacion_ultimo_certificado_enviado_rrhh'];//Ya enviaste al área de Gestión humana el último certificado de tus estudios culminados?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_formacion_ultimo_estudio_realizado_titulo']=$resregistros_hoja_vida[$i-5]['hvp_formacion_ultimo_estudio_realizado_titulo'];//Indica el nombre del título de tu último estudio realizado
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_formacion_tarjeta_profesional']=$resregistros_hoja_vida[$i-5]['hvp_formacion_tarjeta_profesional'];//Tienes tarjeta profesional?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_formacion_estudios_curso']=$resregistros_hoja_vida[$i-5]['hvp_formacion_estudios_curso'];//¿Estás estudiando actualmente?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_habilidades_nivel_ingles']=$resregistros_hoja_vida[$i-5]['hvp_habilidades_nivel_ingles'];//¿Nivel de inglés conversacional?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_habilidades_nivel_excel']=$resregistros_hoja_vida[$i-5]['hvp_habilidades_nivel_excel'];//¿Nivel de manejo de hojas de cálculo?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_habilidades_nivel_google_ws']=$resregistros_hoja_vida[$i-5]['hvp_habilidades_nivel_google_ws'];//Nivel de manejo de google WS (Workspace)
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_poblaciones_poblacion']=$resregistros_hoja_vida[$i-5]['hvp_poblaciones_poblacion'];//Haces parte de alguna de las poblaciones mencionadas?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_poblaciones_certificado']=$resregistros_hoja_vida[$i-5]['hvp_poblaciones_certificado'];//¿Cuentas con los documentos que validen la información (certificación)?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_poblaciones_familiares_iq']=$resregistros_hoja_vida[$i-5]['hvp_poblaciones_familiares_iq'];//¿Tienes familiares, conyugue y/o compañero permanente, parientes dentro del primer o segundo grado
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_poblaciones_familiares_iq_identificacion']=$resregistros_hoja_vida[$i-5]['hvp_poblaciones_familiares_iq_identificacion'];//Documento de identidad de tu familiar
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_poblaciones_familiares_iq_nombres_apellidos']=$resregistros_hoja_vida[$i-5]['hvp_poblaciones_familiares_iq_nombres_apellidos'];//¿Cuál es el nombre de tu familiar?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_poblaciones_familiares_iq_ingreso_marzo_2022']=$resregistros_hoja_vida[$i-5]['hvp_poblaciones_familiares_iq_ingreso_marzo_2022'];//Tu familiar ingresó a la compañía antes de marzo 2022?
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_veracidad']=$resregistros_hoja_vida[$i-5]['hvp_veracidad'];//Veracidad de la Información Proporcionada
                        $array_detalle_hoja_vida[$id_aspirantehv]['aa_nombre']=$resregistros_hoja_vida[$i-5]['aa_nombre'];//Centro de Costo
                        $array_detalle_hoja_vida[$id_aspirantehv]['ac_nombre']=$resregistros_hoja_vida[$i-5]['ac_nombre'];//Cargo

                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_fecha_ingreso']=$resregistros_hoja_vida[$i-5]['hvp_fecha_ingreso'];//Fecha Ingreso
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_retiro_fecha']=$resregistros_hoja_vida[$i-5]['hvp_retiro_fecha'];//Fecha Retiro
                        $array_detalle_hoja_vida[$id_aspirantehv]['hvp_retiro_motivo']=$resregistros_hoja_vida[$i-5]['hvp_retiro_motivo'];//Motivo Retiro

                        //Función para obtener el estado de los campos
                        $array_estados=estadoDiligenciaHV($resregistros_hoja_vida[$i-5]);

                        $estado_autorizaciones=$array_estados['estado_autorizaciones'];
                        $estado_informacion_personal=$array_estados['estado_informacion_personal'];
                        $estado_ubicacion_contacto=$array_estados['estado_ubicacion_contacto'];
                        $estado_socioeconomico_familiar=$array_estados['estado_socioeconomico_familiar'];
                        $estado_salud_bienestar=$array_estados['estado_salud_bienestar'];
                        $estado_intereses_habitos=$array_estados['estado_intereses_habitos'];
                        $estado_formacion_habilidades=$array_estados['estado_formacion_habilidades'];
                        $estado_poblaciones_relaciones=$array_estados['estado_poblaciones_relaciones'];
                        $estado_general=$array_estados['estado_general'];
                        
                        $array_detalle_hoja_vida[$id_aspirantehv]['estado_autorizaciones']=$estado_autorizaciones;//estado_autorizaciones
                        $array_detalle_hoja_vida[$id_aspirantehv]['estado_informacion_personal']=$estado_informacion_personal;//estado_informacion_personal
                        $array_detalle_hoja_vida[$id_aspirantehv]['estado_ubicacion_contacto']=$estado_ubicacion_contacto;//estado_ubicacion_contacto
                        $array_detalle_hoja_vida[$id_aspirantehv]['estado_socioeconomico_familiar']=$estado_socioeconomico_familiar;//estado_socioeconomico_familiar
                        $array_detalle_hoja_vida[$id_aspirantehv]['estado_salud_bienestar']=$estado_salud_bienestar;//estado_salud_bienestar
                        $array_detalle_hoja_vida[$id_aspirantehv]['estado_intereses_habitos']=$estado_intereses_habitos;//estado_intereses_habitos
                        $array_detalle_hoja_vida[$id_aspirantehv]['estado_formacion_habilidades']=$estado_formacion_habilidades;//estado_formacion_habilidades
                        $array_detalle_hoja_vida[$id_aspirantehv]['estado_poblaciones_relaciones']=$estado_poblaciones_relaciones;//estado_poblaciones_relaciones
                        $array_detalle_hoja_vida[$id_aspirantehv]['estado_general']=$estado_general;//estado_general
                        
                    }

    
                    //Estilos de la Hoja 0
                        $spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(80);
                        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AE')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AG')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AH')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AI')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AJ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AK')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AL')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AM')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AN')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AO')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AP')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AQ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AR')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AS')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AT')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AU')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AV')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AW')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AX')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AY')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('AZ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BA')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BB')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BC')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BD')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BE')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BF')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BG')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BH')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BI')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BJ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BK')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BL')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BM')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BN')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BO')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BP')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BQ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BR')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BS')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BT')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BU')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BV')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BW')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BX')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BY')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('BZ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CA')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CB')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CC')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CD')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CE')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CF')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CG')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CH')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CI')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CJ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CK')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CL')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CM')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CN')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CO')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CP')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CQ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CR')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CS')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CT')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CU')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CV')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CW')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CX')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CY')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('CZ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DA')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DB')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DC')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DD')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DE')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DF')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DG')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DH')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DI')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DJ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DK')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DL')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DM')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DN')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DO')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DP')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DQ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DR')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DS')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DT')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DU')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DV')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DW')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DX')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DY')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('DZ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EA')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EB')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EC')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('ED')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EE')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EF')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EG')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EH')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EI')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EJ')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getColumnDimension('EK')->setWidth(20);
                        $spreadsheet->getActiveSheet()->getStyle('A4:EK4')->applyFromArray($styleArrayTitulos);
                        $spreadsheet->getActiveSheet()->setAutoFilter('A4:EK4');
                        $spreadsheet->getActiveSheet()->getStyle('3')->getAlignment()->setWrapText(true);
                        $spreadsheet->getActiveSheet()->getStyle('4')->getAlignment()->setWrapText(true);
                    //Estilos de la Hoja 0

                    // Escribiendo los titulos
                        $spreadsheet->getActiveSheet()->setCellValue('A3','Información General');
                        $spreadsheet->getActiveSheet()->setCellValue('A4','Estado');
                        $spreadsheet->getActiveSheet()->setCellValue('B4','Fecha Actualización');
                        $spreadsheet->getActiveSheet()->setCellValue('C4','Tiempo Actualización (Días)');

                        $spreadsheet->getActiveSheet()->setCellValue('D3','Autorizaciones');
                        $spreadsheet->getActiveSheet()->setCellValue('D4','Consentimiento Tratamiento Datos');

                        $spreadsheet->getActiveSheet()->setCellValue('E3','Información Personal');
                        $spreadsheet->getActiveSheet()->setCellValue('E4','Tipo de documento de identidad');
                        $spreadsheet->getActiveSheet()->setCellValue('F4','Número de identificación');
                        $spreadsheet->getActiveSheet()->setCellValue('G4','Fecha de Expedición');
                        $spreadsheet->getActiveSheet()->setCellValue('H4','Primer nombre');
                        $spreadsheet->getActiveSheet()->setCellValue('I4','Segundo nombre');
                        $spreadsheet->getActiveSheet()->setCellValue('J4','Primer apellido');
                        $spreadsheet->getActiveSheet()->setCellValue('K4','Segundo apellido');
                        $spreadsheet->getActiveSheet()->setCellValue('L4','¿Cómo prefieres que te llamen?');

                        $spreadsheet->getActiveSheet()->setCellValue('M3','Información Demografía');
                        $spreadsheet->getActiveSheet()->setCellValue('M4','¿Cuál es tu género? ');
                        $spreadsheet->getActiveSheet()->setCellValue('N4','¿Cuál es tu estado civil ?');
                        $spreadsheet->getActiveSheet()->setCellValue('O4','Lugar nacimiento ');
                        $spreadsheet->getActiveSheet()->setCellValue('P4','Fecha nacimiento');
                        $spreadsheet->getActiveSheet()->setCellValue('Q4','Edad');

                        $spreadsheet->getActiveSheet()->setCellValue('R3','Información de Antiguedad');
                        $spreadsheet->getActiveSheet()->setCellValue('R4','¿Llevas más de 6 meses en la compañía? ');
                        $spreadsheet->getActiveSheet()->setCellValue('S4','¿Crees que este trabajo te ofrecerá oportunidades de crecimiento profesional?');
                        $spreadsheet->getActiveSheet()->setCellValue('T4','¿En qué medida estás de acuerdo con la siguiente afirmación?: “Este trabajo me ha ofrecido oportunidades de crecimiento laboral.”');
                        $spreadsheet->getActiveSheet()->setCellValue('U4','Motivación principal para aceptar el trabajo');

                        $spreadsheet->getActiveSheet()->setCellValue('V3','Información de Ubicación');
                        $spreadsheet->getActiveSheet()->setCellValue('V4','Ciudad de residencia ');
                        $spreadsheet->getActiveSheet()->setCellValue('W4','Dirección de residencia');
                        $spreadsheet->getActiveSheet()->setCellValue('X4','Localidad/Comuna');
                        $spreadsheet->getActiveSheet()->setCellValue('Y4','Barrio');
                        $spreadsheet->getActiveSheet()->setCellValue('Z4','Maps Latitud');
                        $spreadsheet->getActiveSheet()->setCellValue('AA4','Maps Longitud');
                        $spreadsheet->getActiveSheet()->setCellValue('AB4','Maps Ciudad');
                        $spreadsheet->getActiveSheet()->setCellValue('AC4','Maps Departamento');
                        $spreadsheet->getActiveSheet()->setCellValue('AD4','Maps Pais');
                        $spreadsheet->getActiveSheet()->setCellValue('AE4','Maps Localidad');
                        $spreadsheet->getActiveSheet()->setCellValue('AF4','Maps Barrio');
                        $spreadsheet->getActiveSheet()->setCellValue('AG4','Maps Código Postal');
                        $spreadsheet->getActiveSheet()->setCellValue('AH4','Maps Dirección');

                        $spreadsheet->getActiveSheet()->setCellValue('AI3','Información de Contacto');
                        $spreadsheet->getActiveSheet()->setCellValue('AI4','Número de celular');
                        $spreadsheet->getActiveSheet()->setCellValue('AJ4','Número de celular alternativo');
                        $spreadsheet->getActiveSheet()->setCellValue('AK4','Correo electrónico personal');
                        $spreadsheet->getActiveSheet()->setCellValue('AL4','Correo electrónico corporativo');

                        $spreadsheet->getActiveSheet()->setCellValue('AM3','En caso de emergencia avisar a:');
                        $spreadsheet->getActiveSheet()->setCellValue('AM4','1. Nombres');
                        $spreadsheet->getActiveSheet()->setCellValue('AN4','1. Apellidos');
                        $spreadsheet->getActiveSheet()->setCellValue('AO4','1. Parentesco');
                        $spreadsheet->getActiveSheet()->setCellValue('AP4','1. Número de celular de tu familiar/amigo(a)');

                        $spreadsheet->getActiveSheet()->setCellValue('AQ4','2. Nombres');
                        $spreadsheet->getActiveSheet()->setCellValue('AR4','2. Apellidos');
                        $spreadsheet->getActiveSheet()->setCellValue('AS4','2. Parentesco');
                        $spreadsheet->getActiveSheet()->setCellValue('AT4','2. Número de celular de tu familiar/amigo(a)');

                        $spreadsheet->getActiveSheet()->setCellValue('AU3','Información Socioeconómica');
                        $spreadsheet->getActiveSheet()->setCellValue('AU4','Estrato socioeconómico');
                        $spreadsheet->getActiveSheet()->setCellValue('AV4','Operador de internet ');
                        $spreadsheet->getActiveSheet()->setCellValue('AW4','Operador de internet - Otro');
                        $spreadsheet->getActiveSheet()->setCellValue('AX4','Velocidad de descarga de internet (MB)');
                        $spreadsheet->getActiveSheet()->setCellValue('AY4','Velocidad de carga de internet (MB)');
                        $spreadsheet->getActiveSheet()->setCellValue('AZ4','Características de tu vivienda');
                        $spreadsheet->getActiveSheet()->setCellValue('BA4','Condición de la vivienda');
                        $spreadsheet->getActiveSheet()->setCellValue('BB4','¿Cuál es el estado de terminación de tu vivienda?');
                        $spreadsheet->getActiveSheet()->setCellValue('BC4','¿Qué servicios tienes en tu vivienda?');
                        $spreadsheet->getActiveSheet()->setCellValue('BD4','¿Tienes pensado comprar vivienda en los próximos 3 años?');
                        $spreadsheet->getActiveSheet()->setCellValue('BE4','¿Has sido beneficiario de subsidio de vivienda?');

                        $spreadsheet->getActiveSheet()->setCellValue('BF3','Información Familiar');
                        $spreadsheet->getActiveSheet()->setCellValue('BF4','¿Cuántos hijos tienes?');
                        $spreadsheet->getActiveSheet()->setCellValue('BG4','familia_hijos_menor_3');
                        $spreadsheet->getActiveSheet()->setCellValue('BH4','familia_hijos_4_10');
                        $spreadsheet->getActiveSheet()->setCellValue('BI4','familia_hijos_11_17');
                        $spreadsheet->getActiveSheet()->setCellValue('BJ4','familia_hijos_mayor_18');
                        $spreadsheet->getActiveSheet()->setCellValue('BK4','¿En cual de los siguientes temas relacionados con la familia te gustaría recibir capacitación o acompañamiento?');
                        
                        $spreadsheet->getActiveSheet()->setCellValue('BL3','Información Financiera');
                        $spreadsheet->getActiveSheet()->setCellValue('BL4','Activos');
                        $spreadsheet->getActiveSheet()->setCellValue('BM4','Pasivos');
                        $spreadsheet->getActiveSheet()->setCellValue('BN4','Patrimonio');
                        $spreadsheet->getActiveSheet()->setCellValue('BO4','Ingresos Mensuales');
                        $spreadsheet->getActiveSheet()->setCellValue('BP4','Egresos Mensuales');
                        $spreadsheet->getActiveSheet()->setCellValue('BQ4','Otros Ingresos');
                        $spreadsheet->getActiveSheet()->setCellValue('BR4','Concepto de otros ingresos');
                        $spreadsheet->getActiveSheet()->setCellValue('BS4','¿Realiza Operaciones en Moneda Extranjera?');
                        $spreadsheet->getActiveSheet()->setCellValue('BT4','Declaración de Origen de Fondos y Prevención de Lavado de Activos y Financiación del Terrorismo - SAGRILAFT');

                        $spreadsheet->getActiveSheet()->setCellValue('BU3','Personas Expuestas Públicamente - PEP');
                        $spreadsheet->getActiveSheet()->setCellValue('BU4','¿Maneja recursos públicos?');
                        $spreadsheet->getActiveSheet()->setCellValue('BV4','¿Goza de reconocimiento público general?');
                        $spreadsheet->getActiveSheet()->setCellValue('BW4','¿Ejerce algún grado de poder público?');
                        $spreadsheet->getActiveSheet()->setCellValue('BX4','¿Tiene usted algún familiar que cumpla con una característica anterior?');
                        $spreadsheet->getActiveSheet()->setCellValue('BY4','PEP - Identificación');
                        $spreadsheet->getActiveSheet()->setCellValue('BZ4','PEP - Nombres y Apellidos');

                        $spreadsheet->getActiveSheet()->setCellValue('CA3','Información de Salud y Bienestar');
                        $spreadsheet->getActiveSheet()->setCellValue('CA4','¿Cuál es tu grupo sanguíneo?');
                        $spreadsheet->getActiveSheet()->setCellValue('CB4','¿Cuál es tu RH?');
                        $spreadsheet->getActiveSheet()->setCellValue('CC4','¿Realizas actividad física de mínimo 20 minutos al día?');
                        $spreadsheet->getActiveSheet()->setCellValue('CD4','¿Fumas?');
                        $spreadsheet->getActiveSheet()->setCellValue('CE4','¿Realizas pausas activas durante la jornada laboral?');
                        $spreadsheet->getActiveSheet()->setCellValue('CF4','¿Tienes medicina prepagada?');
                        $spreadsheet->getActiveSheet()->setCellValue('CG4','Medicina prepagada');
                        $spreadsheet->getActiveSheet()->setCellValue('CH4','¿Tienes plan complementario de salud?');
                        $spreadsheet->getActiveSheet()->setCellValue('CI4','Plan Complementario');
                        
                        $spreadsheet->getActiveSheet()->setCellValue('CJ3','¿Cuáles son tus hobbies?');
                        $spreadsheet->getActiveSheet()->setCellValue('CJ4','Deportes');
                        $spreadsheet->getActiveSheet()->setCellValue('CK4','Deportes - Otro');
                        $spreadsheet->getActiveSheet()->setCellValue('CL4','Deportes - Frecuencia');
                        $spreadsheet->getActiveSheet()->setCellValue('CM4','Actividades al aire libre');
                        $spreadsheet->getActiveSheet()->setCellValue('CN4','Actividades al aire libre - Otro');
                        $spreadsheet->getActiveSheet()->setCellValue('CO4','Actividades al aire libre - Frecuencia');
                        $spreadsheet->getActiveSheet()->setCellValue('CP4','Arte y creatividad');
                        $spreadsheet->getActiveSheet()->setCellValue('CQ4','Arte y creatividad - Otro');
                        $spreadsheet->getActiveSheet()->setCellValue('CR4','Arte y creatividad - Música - Instrumento');
                        $spreadsheet->getActiveSheet()->setCellValue('CS4','Arte y creatividad - Frecuencia');
                        $spreadsheet->getActiveSheet()->setCellValue('CT4','Tecnología');
                        $spreadsheet->getActiveSheet()->setCellValue('CU4','Tecnología - Otro');
                        $spreadsheet->getActiveSheet()->setCellValue('CV4','Tecnología - Frecuencia');
                        $spreadsheet->getActiveSheet()->setCellValue('CW4','Otros');
                        $spreadsheet->getActiveSheet()->setCellValue('CX4','Otros - Otro');
                        $spreadsheet->getActiveSheet()->setCellValue('CY4','Otros - Frecuencia');
                        $spreadsheet->getActiveSheet()->setCellValue('CZ4','¿Te gustaría recibir información sobre eventos o actividades relacionadas con tus hobbies?');

                        $spreadsheet->getActiveSheet()->setCellValue('DA3','Información de Intereses y Hábitos');
                        $spreadsheet->getActiveSheet()->setCellValue('DA4','¿Cuáles actividades te gusta hacer en familia?');
                        $spreadsheet->getActiveSheet()->setCellValue('DB4','¿Realizas actividades deportivas?');
                        $spreadsheet->getActiveSheet()->setCellValue('DC4','Cuáles actividades deportivas?');
                        $spreadsheet->getActiveSheet()->setCellValue('DD4','¿Cuál es tu medio de transporte cuando vas a la oficina?');
                        $spreadsheet->getActiveSheet()->setCellValue('DE4','¿Tienes el hábito de ahorrar?');
                        $spreadsheet->getActiveSheet()->setCellValue('DF4','¿Tienes Mascotas?');
                        $spreadsheet->getActiveSheet()->setCellValue('DG4','Cuéntanos que mascota tienes?');


                        $spreadsheet->getActiveSheet()->setCellValue('DH3','Último Nivel Académico Alcanzado');
                        $spreadsheet->getActiveSheet()->setCellValue('DH4','Ya enviaste al área de Gestión humana el último certificado de tus estudios culminados?');
                        $spreadsheet->getActiveSheet()->setCellValue('DI4','Indica el nombre del título de tu último estudio realizado');
                        $spreadsheet->getActiveSheet()->setCellValue('DJ4','Tienes tarjeta profesional?');
                        $spreadsheet->getActiveSheet()->setCellValue('DK4','¿Estás estudiando actualmente?');


                        $spreadsheet->getActiveSheet()->setCellValue('DL4','Estudios Culminados');
                        $spreadsheet->getActiveSheet()->setCellValue('DM4','Estudios en Curso');
                        
                        
                        $spreadsheet->getActiveSheet()->setCellValue('DN3','Información de Habilidades');
                        $spreadsheet->getActiveSheet()->setCellValue('DN4','¿Nivel de inglés conversacional?');
                        $spreadsheet->getActiveSheet()->setCellValue('DO4','¿Nivel de manejo de hojas de cálculo?');
                        $spreadsheet->getActiveSheet()->setCellValue('DP4','Nivel de manejo de google WS (Workspace)');
                        
                        $spreadsheet->getActiveSheet()->setCellValue('DQ3','Información de Poblaciones');
                        $spreadsheet->getActiveSheet()->setCellValue('DQ4','Haces parte de alguna de las poblaciones mencionadas?');
                        $spreadsheet->getActiveSheet()->setCellValue('DR4','¿Cuentas con los documentos que validen la información (certificación)?');
                        
                        $spreadsheet->getActiveSheet()->setCellValue('DS3','Relaciones Familiares');
                        $spreadsheet->getActiveSheet()->setCellValue('DS4','¿Tienes familiares, conyugue y/o compañero permanente, parientes dentro del primer o segundo grado de consanguinidad, segundo de afinidad o único civil que actualmente trabaje en iQ?');
                        $spreadsheet->getActiveSheet()->setCellValue('DT4','Documento de identidad de tu familiar');
                        $spreadsheet->getActiveSheet()->setCellValue('DU4','¿Cuál es el nombre de tu familiar?');
                        $spreadsheet->getActiveSheet()->setCellValue('DV4','Tu familiar ingresó a la compañía antes de marzo 2022?');

                        $spreadsheet->getActiveSheet()->setCellValue('DW4','Veracidad de la Información Proporcionada');
                        $spreadsheet->getActiveSheet()->setCellValue('DX4','Centro de Costo');
                        $spreadsheet->getActiveSheet()->setCellValue('DY4','Cargo');
                        $spreadsheet->getActiveSheet()->setCellValue('DZ4','Fecha Ingreso');
                        $spreadsheet->getActiveSheet()->setCellValue('EA4','Fecha Retiro');
                        $spreadsheet->getActiveSheet()->setCellValue('EB4','Motivo Retiro');


                        $spreadsheet->getActiveSheet()->setCellValue('EC3','Estado Diligenciamiento');
                        $spreadsheet->getActiveSheet()->setCellValue('EC4','Autorizaciones');
                        $spreadsheet->getActiveSheet()->setCellValue('ED4','Información Personal');
                        $spreadsheet->getActiveSheet()->setCellValue('EE4','Ubicación/ Contacto');
                        $spreadsheet->getActiveSheet()->setCellValue('EF4','Socioeconómico/ Familiar');
                        $spreadsheet->getActiveSheet()->setCellValue('EG4','Salud/ Bienestar');
                        $spreadsheet->getActiveSheet()->setCellValue('EH4','Intereses/ Hábitos');
                        $spreadsheet->getActiveSheet()->setCellValue('EI4','Formación/ Habilidades');
                        $spreadsheet->getActiveSheet()->setCellValue('EJ4','Poblaciones/ Relaciones Familiares');
                        $spreadsheet->getActiveSheet()->setCellValue('EK4','Progreso General');
                        
                        $spreadsheet->getActiveSheet()->setCellValue('A1','Reporte: Consolidado');
                        $spreadsheet->getActiveSheet()->setCellValue('A2','Fecha: '.now());
                    // Escribiendo los titulos
                    
                    // Ingresar Data consultada a partir de la fila 4
                    // echo "<pre>";
                    // print_r($array_detalle_seleccion[3256]);
                    // echo "</pre>";

                    for ($i=5; $i < count($resregistros)+5; $i++) {
                        $id_aspirante_final=$resregistros[$i-5]['hva_id'];
                        
                        if (isset($array_detalle_hoja_vida[$id_aspirante_final])) {
                            $hvp_estado=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_estado'];//Estado
                            $hvp_actualiza_fecha=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_actualiza_fecha'];//Fecha Actualización
                            $dias_diferencia=$array_detalle_hoja_vida[$id_aspirante_final]['dias_diferencia'];//Tiempo Actualización
                            $hvp_consentimiento_tratamiento_datos_personales=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_consentimiento_tratamiento_datos_personales'];//Consentimiento Tratamiento Datos
                            $hvp_datos_personales_tipo_documento=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_datos_personales_tipo_documento'];//Tipo de documento de identidad
                            $hvp_datos_personales_numero_identificacion=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_datos_personales_numero_identificacion'];//Número de identificación
                            $hva_auxiliar_5=$array_detalle_seleccion[$id_aspirante_final]['hva_auxiliar_5'];//Fecha de expedición
                            $hvp_datos_personales_nombre_1=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_datos_personales_nombre_1'];//Primer nombre
                            $hvp_datos_personales_nombre_2=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_datos_personales_nombre_2'];//Segundo nombre
                            $hvp_datos_personales_apellido_1=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_datos_personales_apellido_1'];//Primer apellido
                            $hvp_datos_personales_apellido_2=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_datos_personales_apellido_2'];//Segundo apellido
                            $hvp_auxiliar_1=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_auxiliar_1'];//¿Cómo prefieres que te llamen?
                            $hvp_demografia_genero=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_demografia_genero'];//¿Cuál es tu género? 
                            $hvp_demografia_estado_civil=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_demografia_estado_civil'];//¿Cuál es tu estado civil ?
                            $TCIUDADN_ciu_municipio=$array_detalle_hoja_vida[$id_aspirante_final]['TCIUDADN_ciu_municipio'];//Lugar nacimiento 
                            $hvp_demografia_fecha_nacimiento=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_demografia_fecha_nacimiento'];//Fecha nacimiento
                            $hvp_demografia_edad=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_demografia_edad'];//Edad
                            $hvp_expectativa_motivacion_expectativa_desarrollo=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_expectativa_motivacion_expectativa_desarrollo'];//¿Llevas más de 6 meses en la compañía? 
                            $hvp_expectativa_motivacion_expectativa_crecimiento_profesional=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_expectativa_motivacion_expectativa_crecimiento_profesional'];//¿Crees que este trabajo te ofrecerá oportunidades de crecimiento profesional?
                            $hvp_expectativa_motivacion_realidad_crecimiento_profesional=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_expectativa_motivacion_realidad_crecimiento_profesional'];//¿En qué medida estás de acuerdo con la siguiente afirmación?: “Este trabajo me ha ofrecido oportunidades de crecimiento laboral.”
                            $hvp_expectativa_motivacion_motivacion_trabajo=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_expectativa_motivacion_motivacion_trabajo'];//Motivación principal para aceptar el trabajo
                            $TCIUDAD_ciu_municipio=$array_detalle_hoja_vida[$id_aspirante_final]['TCIUDAD_ciu_municipio'];//Ciudad de residencia 
                            $hvp_ubicacion_direccion_residencia=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_ubicacion_direccion_residencia'];//Dirección de residencia
                            $hvp_ubicacion_localidad_comuna=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_ubicacion_localidad_comuna'];//Localidad/Comuna
                            $hvp_ubicacion_barrio=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_ubicacion_barrio'];//Barrio
                            $hvp_ubicacion_maps_latitud=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_ubicacion_maps_latitud'];//Maps Latitud
                            $hvp_ubicacion_maps_longitud=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_ubicacion_maps_longitud'];//Maps Longitud
                            $hvp_ubicacion_maps_ciudad=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_ubicacion_maps_ciudad'];//Maps Ciudad
                            $hvp_ubicacion_maps_departamento=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_ubicacion_maps_departamento'];//Maps Departamento
                            $hvp_ubicacion_maps_pais=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_ubicacion_maps_pais'];//Maps Pais
                            $hvp_ubicacion_maps_localidad=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_ubicacion_maps_localidad'];//Maps Localidad
                            $hvp_ubicacion_maps_barrio=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_ubicacion_maps_barrio'];//Maps Barrio
                            $hvp_ubicacion_maps_codigo_postal=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_ubicacion_maps_codigo_postal'];//Maps Código Postal
                            $hvp_ubicacion_maps_direccion=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_ubicacion_maps_direccion'];//Maps Dirección
                            $hvp_contacto_numero_celular=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_contacto_numero_celular'];//Número de celular
                            $hvp_auxiliar_2=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_auxiliar_2'];//Número de celular alternativo
                            $hvp_contacto_correo_personal=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_contacto_correo_personal'];//Correo electrónico personal
                            $hvp_contacto_correo_corporativo=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_contacto_correo_corporativo'];//Correo electrónico corporativo
                            $hvp_contacto_emergencia_nombres=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_contacto_emergencia_nombres'];//1. Nombres
                            $hvp_contacto_emergencia_apellidos=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_contacto_emergencia_apellidos'];//1. Apellidos
                            $hvp_contacto_emergencia_parentesco=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_contacto_emergencia_parentesco'];//1. Parentesco
                            $hvp_contacto_emergencia_celular=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_contacto_emergencia_celular'];//1. Número de celular de tu familiar/amigo(a)
                            $hvp_contacto_emergencia_nombres_2=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_contacto_emergencia_nombres_2'];//2. Nombres
                            $hvp_contacto_emergencia_apellidos_2=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_contacto_emergencia_apellidos_2'];//2. Apellidos
                            $hvp_contacto_emergencia_parentesco_2=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_contacto_emergencia_parentesco_2'];//2. Parentesco
                            $hvp_contacto_emergencia_celular_2=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_contacto_emergencia_celular_2'];//2. Número de celular de tu familiar/amigo(a)
                            $hvp_socioeconomico_estrato_socioeconomico=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_socioeconomico_estrato_socioeconomico'];//Estrato socioeconómico
                            $hvp_socioeconomico_operador_internet=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_socioeconomico_operador_internet'];//Operador de internet 
                            $hvp_socioeconomico_operador_internet_otro=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_socioeconomico_operador_internet_otro'];//Operador de internet - Otro
                            $hvp_socioeconomico_velocidad_internet_descarga=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_socioeconomico_velocidad_internet_descarga'];//Velocidad de descarga de internet (MB)
                            $hvp_socioeconomico_velocidad_internet_carga=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_socioeconomico_velocidad_internet_carga'];//Velocidad de carga de internet (MB)
                            $hvp_socioeconomico_caracteristicas_vivienda=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_socioeconomico_caracteristicas_vivienda'];//Características de tu vivienda
                            $hvp_socioeconomico_condiciones_vivienda=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_socioeconomico_condiciones_vivienda'];//Condición de la vivienda
                            $hvp_socioeconomico_estado_terminacion_vivienda=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_socioeconomico_estado_terminacion_vivienda'];//¿Cuál es el estado de terminación de tu vivienda?
                            $hvp_socioeconomico_servicios_vivienda=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_socioeconomico_servicios_vivienda'];//¿Qué servicios tienes en tu vivienda?
                            $hvp_socioeconomico_plan_compra_vivienda=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_socioeconomico_plan_compra_vivienda'];//¿Tienes pensado comprar vivienda en los próximos 3 años?
                            $hvp_socioeconomico_beneficiario_subsidio_vivienda=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_socioeconomico_beneficiario_subsidio_vivienda'];//¿Has sido beneficiario de subsidio de vivienda?
                            $hvp_familia_numero_hijos=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_familia_numero_hijos'];//¿Cuántos hijos tienes?
                            
                            $hvp_familia_capacitacion_familia=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_familia_capacitacion_familia'];//¿En cual de los siguientes temas relacionados con la familia te gustaría recibir
                            $hvp_financiero_activos=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_financiero_activos'];//Activos
                            $hvp_financiero_pasivos=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_financiero_pasivos'];//Pasivos
                            $hvp_financiero_patrimonio=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_financiero_patrimonio'];//Patrimonio
                            $hvp_financiero_ingresos=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_financiero_ingresos'];//Ingresos Mensuales
                            $hvp_financiero_egresos=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_financiero_egresos'];//Egresos Mensuales
                            $hvp_financiero_ingresos_otros=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_financiero_ingresos_otros'];//Otros Ingresos
                            $hvp_financiero_concepto_ingresos=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_financiero_concepto_ingresos'];//Concepto de otros ingresos
                            $hvp_financiero_moneda_extranjera=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_financiero_moneda_extranjera'];//¿Realiza Operaciones en Moneda Extranjera?
                            $hvp_origen_fondos=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_origen_fondos'];//Declaración de Origen de Fondos y Prevención de Lavado de Activos
                            $hvp_pep_recursos=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_pep_recursos'];//¿Maneja recursos públicos?
                            $hvp_pep_reconocimiento=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_pep_reconocimiento'];//¿Goza de reconocimiento público general?
                            $hvp_pep_poder=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_pep_poder'];//¿Ejerce algún grado de poder público?
                            $hvp_pep_familiar=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_pep_familiar'];//¿Tiene usted algún familiar que cumpla con una característica anterior?
                            $hvp_pep_cedula=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_pep_cedula'];//¿Tiene usted algún familiar que cumpla con una característica anterior?
                            $hvp_pep_nombres_apellidos=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_pep_nombres_apellidos'];//¿Tiene usted algún familiar que cumpla con una característica anterior?
                            $hvp_salud_bienestar_grupo_sanguineo=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_salud_bienestar_grupo_sanguineo'];//¿Cuál es tu grupo sanguíneo?
                            $hvp_salud_bienestar_rh=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_salud_bienestar_rh'];//¿Cuál es tu RH?
                            $hvp_salud_bienestar_actividad_fisica_minima=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_salud_bienestar_actividad_fisica_minima'];//¿Realizas actividad física de mínimo 20 minutos al día?
                            $hvp_salud_bienestar_fumador=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_salud_bienestar_fumador'];//¿Fumas?
                            $hvp_salud_bienestar_pausas_activas=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_salud_bienestar_pausas_activas'];//¿Realizas pausas activas durante la jornada laboral?
                            $hvp_salud_bienestar_medicina_prepagada=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_salud_bienestar_medicina_prepagada'];//¿Tienes medicina prepagada?
                            $hvp_salud_bienestar_medicina_prepagada_cual=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_salud_bienestar_medicina_prepagada_cual'];//Medicina prepagada
                            $hvp_salud_bienestar_plan_complementario_salud=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_salud_bienestar_plan_complementario_salud'];//¿Tienes plan complementario de salud?
                            $hvp_salud_bienestar_plan_complementario_salud_cual=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_salud_bienestar_plan_complementario_salud_cual'];//Plan Complementario
                            $hvp_interes_habitos_hobbies_deportes=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_hobbies_deportes'];//Deportes
                            $hvp_interes_habitos_hobbies_deportes_cual=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_hobbies_deportes_cual'];//Deportes - Otro
                            $hvp_interes_habitos_hobbies_deportes_frecuencia=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_hobbies_deportes_frecuencia'];//Deportes - Frecuencia
                            $hvp_interes_habitos_hobbies_aire=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_hobbies_aire'];//Actividades al aire libre
                            $hvp_interes_habitos_hobbies_aire_cual=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_hobbies_aire_cual'];//Actividades al aire libre - Otro
                            $hvp_interes_habitos_hobbies_aire_frecuencia=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_hobbies_aire_frecuencia'];//Actividades al aire libre - Frecuencia
                            $hvp_interes_habitos_hobbies_arte=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_hobbies_arte'];//Arte y creatividad
                            $hvp_interes_habitos_hobbies_arte_cual=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_hobbies_arte_cual'];//Arte y creatividad - Otro
                            $hvp_interes_habitos_hobbies_arte_instrumento=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_hobbies_arte_instrumento'];//Arte y creatividad - Música - Instrumento
                            $hvp_interes_habitos_hobbies_arte_frecuencia=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_hobbies_arte_frecuencia'];//Arte y creatividad - Frecuencia
                            $hvp_interes_habitos_hobbies_tecnologia=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_hobbies_tecnologia'];//Tecnología
                            $hvp_interes_habitos_hobbies_tecnologia_cual=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_hobbies_tecnologia_cual'];//Tecnología - Otro
                            $hvp_interes_habitos_hobbies_tecnologia_frecuencia=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_hobbies_tecnologia_frecuencia'];//Tecnología - Frecuencia
                            $hvp_interes_habitos_hobbies_otro=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_hobbies_otro'];//Otros
                            $hvp_interes_habitos_hobbies_otro_cual=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_hobbies_otro_cual'];//Otros - Otro
                            $hvp_interes_habitos_hobbies_otro_frecuencia=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_hobbies_otro_frecuencia'];//Otros - Frecuencia
                            $hvp_interes_habitos_hobbies_recibir_informacion=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_hobbies_recibir_informacion'];//¿Te gustaría recibir información sobre eventos o actividades relacionadas con tus hobbies?
                            $hvp_interes_habitos_actividades_familia=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_actividades_familia'];//¿Cuáles actividades te gusta hacer en familia?
                            $hvp_interes_habitos_actividades_deportivas=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_actividades_deportivas'];//¿Realizas actividades deportivas?
                            $hvp_interes_habitos_actividades_deportivas_cual=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_actividades_deportivas_cual'];//Cuales actividades deportivas
                            $hvp_interes_habitos_medio_transporte=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_medio_transporte'];//¿Cuál es tu medio de transporte cuando vas a la oficina?
                            $hvp_interes_habitos_habito_ahorro=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_habito_ahorro'];//¿Tienes el hábito de ahorrar?
                            $hvp_interes_habitos_mascotas=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_mascotas'];//¿Tienes Mascotas?
                            $hvp_interes_habitos_mascotas_cual=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_interes_habitos_mascotas_cual'];//Cuéntanos que mascota tienes?
                            $hvp_formacion_ultimo_certificado_enviado_rrhh=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_formacion_ultimo_certificado_enviado_rrhh'];//Ya enviaste al área de Gestión humana el último certificado de tus estudios culminados?
                            $hvp_formacion_ultimo_estudio_realizado_titulo=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_formacion_ultimo_estudio_realizado_titulo'];//Indica el nombre del título de tu último estudio realizado
                            $hvp_formacion_tarjeta_profesional=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_formacion_tarjeta_profesional'];//Tienes tarjeta profesional?
                            $hvp_formacion_estudios_curso=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_formacion_estudios_curso'];//¿Estás estudiando actualmente?
                            $hvp_habilidades_nivel_ingles=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_habilidades_nivel_ingles'];//¿Nivel de inglés conversacional?
                            $hvp_habilidades_nivel_excel=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_habilidades_nivel_excel'];//¿Nivel de manejo de hojas de cálculo?
                            $hvp_habilidades_nivel_google_ws=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_habilidades_nivel_google_ws'];//Nivel de manejo de google WS (Workspace)
                            $hvp_poblaciones_poblacion=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_poblaciones_poblacion'];//Haces parte de alguna de las poblaciones mencionadas?
                            $hvp_poblaciones_certificado=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_poblaciones_certificado'];//¿Cuentas con los documentos que validen la información (certificación)?
                            $hvp_poblaciones_familiares_iq=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_poblaciones_familiares_iq'];//¿Tienes familiares, conyugue y/o compañero permanente, parientes dentro del primer o segundo grado
                            $hvp_poblaciones_familiares_iq_identificacion=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_poblaciones_familiares_iq_identificacion'];//Documento de identidad de tu familiar
                            $hvp_poblaciones_familiares_iq_nombres_apellidos=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_poblaciones_familiares_iq_nombres_apellidos'];//¿Cuál es el nombre de tu familiar?
                            $hvp_poblaciones_familiares_iq_ingreso_marzo_2022=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_poblaciones_familiares_iq_ingreso_marzo_2022'];//Tu familiar ingresó a la compañía antes de marzo 2022?
                            $hvp_veracidad=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_veracidad'];//Veracidad de la Información Proporcionada
                            $aa_nombre=$array_detalle_hoja_vida[$id_aspirante_final]['aa_nombre'];//Centro de Costo
                            $ac_nombre=$array_detalle_hoja_vida[$id_aspirante_final]['ac_nombre'];//Cargo

                            $hvp_fecha_ingreso=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_fecha_ingreso'];//Fecha Ingreso
                            $hvp_retiro_fecha=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_retiro_fecha'];//Fecha Retiro
                            $hvp_retiro_motivo=$array_detalle_hoja_vida[$id_aspirante_final]['hvp_retiro_motivo'];//Motivo Retiro

                            $estado_autorizaciones=$array_detalle_hoja_vida[$id_aspirante_final]['estado_autorizaciones'];//estado_autorizaciones
                            $estado_informacion_personal=$array_detalle_hoja_vida[$id_aspirante_final]['estado_informacion_personal'];//estado_informacion_personal
                            $estado_ubicacion_contacto=$array_detalle_hoja_vida[$id_aspirante_final]['estado_ubicacion_contacto'];//estado_ubicacion_contacto
                            $estado_socioeconomico_familiar=$array_detalle_hoja_vida[$id_aspirante_final]['estado_socioeconomico_familiar'];//estado_socioeconomico_familiar
                            $estado_salud_bienestar=$array_detalle_hoja_vida[$id_aspirante_final]['estado_salud_bienestar'];//estado_salud_bienestar
                            $estado_intereses_habitos=$array_detalle_hoja_vida[$id_aspirante_final]['estado_intereses_habitos'];//estado_intereses_habitos
                            $estado_formacion_habilidades=$array_detalle_hoja_vida[$id_aspirante_final]['estado_formacion_habilidades'];//estado_formacion_habilidades
                            $estado_poblaciones_relaciones=$array_detalle_hoja_vida[$id_aspirante_final]['estado_poblaciones_relaciones'];//estado_poblaciones_relaciones
                            $estado_general=$array_detalle_hoja_vida[$id_aspirante_final]['estado_general'];//estado_general
                        } else {
                            $hvp_estado=$array_detalle_seleccion[$id_aspirante_final]['hva_estado'];//Estado
                            $hvp_actualiza_fecha='';//Fecha Actualización
                            $dias_diferencia='';//Tiempo Actualización
                            $hvp_consentimiento_tratamiento_datos_personales='Si';//Consentimiento Tratamiento Datos
                            $hvp_datos_personales_tipo_documento='';//Tipo de documento de identidad
                            $hvp_datos_personales_numero_identificacion=$array_detalle_seleccion[$id_aspirante_final]['hva_identificacion'];//Número de identificación
                            $hva_auxiliar_5=$array_detalle_seleccion[$id_aspirante_final]['hva_auxiliar_5'];//Fechad e expedición
                            $hvp_datos_personales_nombre_1=$array_detalle_seleccion[$id_aspirante_final]['hva_nombres'];//Primer nombre
                            $hvp_datos_personales_nombre_2=$array_detalle_seleccion[$id_aspirante_final]['hva_nombres_2'];//Segundo nombre
                            $hvp_datos_personales_apellido_1=$array_detalle_seleccion[$id_aspirante_final]['hva_apellido_1'];//Primer apellido
                            $hvp_datos_personales_apellido_2=$array_detalle_seleccion[$id_aspirante_final]['hva_apellido_2'];//Segundo apellido
                            $hvp_auxiliar_1='';//¿Cómo prefieres que te llamen?
                            $hvp_demografia_genero=$array_detalle_seleccion[$id_aspirante_final]['hva_genero'];//¿Cuál es tu género? 
                            $hvp_demografia_estado_civil=$array_detalle_seleccion[$id_aspirante_final]['hva_estado_civil'];//¿Cuál es tu estado civil ?
                            $TCIUDADN_ciu_municipio=$array_detalle_seleccion[$id_aspirante_final]['nacimiento_ciu_municipio'];//Lugar nacimiento 
                            $hvp_demografia_fecha_nacimiento=$array_detalle_seleccion[$id_aspirante_final]['hva_nacimiento_fecha'];//Fecha nacimiento
                            $hvp_demografia_edad=$array_detalle_seleccion[$id_aspirante_final]['edad_aspirante'];//Edad
                            $hvp_expectativa_motivacion_expectativa_desarrollo='';//¿Llevas más de 6 meses en la compañía? 
                            $hvp_expectativa_motivacion_expectativa_crecimiento_profesional='';//¿Crees que este trabajo te ofrecerá oportunidades de crecimiento profesional?
                            $hvp_expectativa_motivacion_realidad_crecimiento_profesional='';//¿En qué medida estás de acuerdo con la siguiente afirmación?: “Este trabajo me ha ofrecido oportunidades de crecimiento laboral.”
                            $hvp_expectativa_motivacion_motivacion_trabajo='';//Motivación principal para aceptar el trabajo
                            $TCIUDAD_ciu_municipio=$array_detalle_seleccion[$id_aspirante_final]['ciu_municipio'].', '.$array_detalle_seleccion[$id_aspirante_final]['ciu_departamento'];//Ciudad de residencia 
                            $hvp_ubicacion_direccion_residencia=$array_detalle_seleccion[$id_aspirante_final]['hva_direccion'];//Dirección de residencia
                            $hvp_ubicacion_localidad_comuna=$array_detalle_seleccion[$id_aspirante_final]['ciub_localidad'];//Localidad/Comuna
                            $hvp_ubicacion_barrio=$array_detalle_seleccion[$id_aspirante_final]['hva_barrio'];//Barrio
                            $hvp_ubicacion_maps_latitud='';//Maps Latitud
                            $hvp_ubicacion_maps_longitud='';//Maps Longitud
                            $hvp_ubicacion_maps_ciudad='';//Maps Ciudad
                            $hvp_ubicacion_maps_departamento='';//Maps Departamento
                            $hvp_ubicacion_maps_pais='';//Maps Pais
                            $hvp_ubicacion_maps_localidad='';//Maps Localidad
                            $hvp_ubicacion_maps_barrio='';//Maps Barrio
                            $hvp_ubicacion_maps_codigo_postal='';//Maps Código Postal
                            $hvp_ubicacion_maps_direccion='';//Maps Dirección
                            $hvp_contacto_numero_celular=$array_detalle_seleccion[$id_aspirante_final]['hva_celular'];//Número de celular
                            $hvp_auxiliar_2=$array_detalle_seleccion[$id_aspirante_final]['hva_celular_2'];//Número de celular alternativo
                            $hvp_contacto_correo_personal=$array_detalle_seleccion[$id_aspirante_final]['hva_correo'];//Correo electrónico personal
                            $hvp_contacto_correo_corporativo=$array_detalle_seleccion[$id_aspirante_final]['hva_correo_corporativo'];//Correo electrónico corporativo
                            $hvp_contacto_emergencia_nombres=$array_detalle_seleccion[$id_aspirante_final]['hvaem_nombres_apellidos'];//1. Nombres
                            $hvp_contacto_emergencia_apellidos='';//1. Apellidos
                            $hvp_contacto_emergencia_parentesco=$array_detalle_seleccion[$id_aspirante_final]['hvaem_parentesco'];//1. Parentesco
                            $hvp_contacto_emergencia_celular=$array_detalle_seleccion[$id_aspirante_final]['hvaem_telefono'];//1. Número de celular de tu familiar/amigo(a)
                            $hvp_contacto_emergencia_nombres_2='';//2. Nombres
                            $hvp_contacto_emergencia_apellidos_2='';//2. Apellidos
                            $hvp_contacto_emergencia_parentesco_2='';//2. Parentesco
                            $hvp_contacto_emergencia_celular_2='';//2. Número de celular de tu familiar/amigo(a)
                            $hvp_socioeconomico_estrato_socioeconomico='';//Estrato socioeconómico
                            $hvp_socioeconomico_operador_internet=$array_detalle_seleccion[$id_aspirante_final]['hva_operador_internet'];//Operador de internet 
                            $hvp_socioeconomico_operador_internet_otro='';//Operador de internet - Otro
                            $hvp_socioeconomico_velocidad_internet_descarga='';//Velocidad de descarga de internet (MB)
                            $hvp_socioeconomico_velocidad_internet_carga='';//Velocidad de carga de internet (MB)
                            $hvp_socioeconomico_caracteristicas_vivienda='';//Características de tu vivienda
                            $hvp_socioeconomico_condiciones_vivienda='';//Condición de la vivienda
                            $hvp_socioeconomico_estado_terminacion_vivienda='';//¿Cuál es el estado de terminación de tu vivienda?
                            $hvp_socioeconomico_servicios_vivienda='';//¿Qué servicios tienes en tu vivienda?
                            $hvp_socioeconomico_plan_compra_vivienda='';//¿Tienes pensado comprar vivienda en los próximos 3 años?
                            $hvp_socioeconomico_beneficiario_subsidio_vivienda='';//¿Has sido beneficiario de subsidio de vivienda?
                            $hvp_familia_numero_hijos='';//¿Cuántos hijos tienes?
                            
                            $hvp_familia_capacitacion_familia='';//¿En cual de los siguientes temas relacionados con la familia te gustaría recibir
                            $hvp_financiero_activos=$array_detalle_seleccion[$id_aspirante_final]['hvaf_activos'];//Activos
                            $hvp_financiero_pasivos=$array_detalle_seleccion[$id_aspirante_final]['hvaf_pasivos'];//Pasivos
                            $hvp_financiero_patrimonio=$array_detalle_seleccion[$id_aspirante_final]['hvaf_patrimonio'];//Patrimonio
                            $hvp_financiero_ingresos=$array_detalle_seleccion[$id_aspirante_final]['hvaf_ingresos'];//Ingresos Mensuales
                            $hvp_financiero_egresos=$array_detalle_seleccion[$id_aspirante_final]['hvaf_egresos'];//Egresos Mensuales
                            $hvp_financiero_ingresos_otros=$array_detalle_seleccion[$id_aspirante_final]['hvaf_ingresos_otros'];//Otros Ingresos
                            $hvp_financiero_concepto_ingresos=$array_detalle_seleccion[$id_aspirante_final]['hvaf_concepto_ingresos'];//Concepto de otros ingresos
                            $hvp_financiero_moneda_extranjera=$array_detalle_seleccion[$id_aspirante_final]['hvaf_moneda_extranjera'];//¿Realiza Operaciones en Moneda Extranjera?
                            $hvp_origen_fondos='Si';//Declaración de Origen de Fondos y Prevención de Lavado de Activos
                            $hvp_pep_recursos=$array_detalle_seleccion[$id_aspirante_final]['hvap_recursos'];//¿Maneja recursos públicos?
                            $hvp_pep_reconocimiento=$array_detalle_seleccion[$id_aspirante_final]['hvap_reconocimiento'];//¿Goza de reconocimiento público general?
                            $hvp_pep_poder=$array_detalle_seleccion[$id_aspirante_final]['hvap_poder'];//¿Ejerce algún grado de poder público?
                            $hvp_pep_familiar=$array_detalle_seleccion[$id_aspirante_final]['hvap_familiar'];//¿Tiene usted algún familiar que cumpla con una característica anterior?
                            $hvp_pep_cedula='';//¿Tiene usted algún familiar que cumpla con una característica anterior?
                            $hvp_pep_nombres_apellidos=$array_detalle_seleccion[$id_aspirante_final]['hvap_observaciones'];//¿Tiene usted algún familiar que cumpla con una característica anterior?
                            $hvp_salud_bienestar_grupo_sanguineo=$array_detalle_seleccion[$id_aspirante_final]['hvaem_grupo_sanguineo'];//¿Cuál es tu grupo sanguíneo?
                            $hvp_salud_bienestar_rh=$array_detalle_seleccion[$id_aspirante_final]['hvaem_rh'];//¿Cuál es tu RH?
                            $hvp_salud_bienestar_actividad_fisica_minima='';//¿Realizas actividad física de mínimo 20 minutos al día?
                            $hvp_salud_bienestar_fumador='';//¿Fumas?
                            $hvp_salud_bienestar_pausas_activas='';//¿Realizas pausas activas durante la jornada laboral?
                            $hvp_salud_bienestar_medicina_prepagada='';//¿Tienes medicina prepagada?
                            $hvp_salud_bienestar_medicina_prepagada_cual=$array_detalle_seleccion[$id_aspirante_final]['hvass_prepagada'];//Medicina prepagada
                            $hvp_salud_bienestar_plan_complementario_salud='';//¿Tienes plan complementario de salud?
                            $hvp_salud_bienestar_plan_complementario_salud_cual='';//Plan Complementario
                            $hvp_interes_habitos_hobbies_deportes='';//Deportes
                            $hvp_interes_habitos_hobbies_deportes_cual='';//Deportes - Otro
                            $hvp_interes_habitos_hobbies_deportes_frecuencia='';//Deportes - Frecuencia
                            $hvp_interes_habitos_hobbies_aire='';//Actividades al aire libre
                            $hvp_interes_habitos_hobbies_aire_cual='';//Actividades al aire libre - Otro
                            $hvp_interes_habitos_hobbies_aire_frecuencia='';//Actividades al aire libre - Frecuencia
                            $hvp_interes_habitos_hobbies_arte='';//Arte y creatividad
                            $hvp_interes_habitos_hobbies_arte_cual='';//Arte y creatividad - Otro
                            $hvp_interes_habitos_hobbies_arte_instrumento='';//Arte y creatividad - Música - Instrumento
                            $hvp_interes_habitos_hobbies_arte_frecuencia='';//Arte y creatividad - Frecuencia
                            $hvp_interes_habitos_hobbies_tecnologia='';//Tecnología
                            $hvp_interes_habitos_hobbies_tecnologia_cual='';//Tecnología - Otro
                            $hvp_interes_habitos_hobbies_tecnologia_frecuencia='';//Tecnología - Frecuencia
                            $hvp_interes_habitos_hobbies_otro='';//Otros
                            $hvp_interes_habitos_hobbies_otro_cual='';//Otros - Otro
                            $hvp_interes_habitos_hobbies_otro_frecuencia='';//Otros - Frecuencia
                            $hvp_interes_habitos_hobbies_recibir_informacion='';//¿Te gustaría recibir información sobre eventos o actividades relacionadas con tus hobbies?
                            $hvp_interes_habitos_actividades_familia='';//¿Cuáles actividades te gusta hacer en familia?
                            $hvp_interes_habitos_actividades_deportivas='';//¿Realizas actividades deportivas?
                            $hvp_interes_habitos_actividades_deportivas_cual='';//Cuales actividades deportivas
                            $hvp_interes_habitos_medio_transporte='';//¿Cuál es tu medio de transporte cuando vas a la oficina?
                            $hvp_interes_habitos_habito_ahorro='';//¿Tienes el hábito de ahorrar?
                            $hvp_interes_habitos_mascotas='';//¿Tienes Mascotas?
                            $hvp_interes_habitos_mascotas_cual='';//Cuéntanos que mascota tienes?
                            $hvp_formacion_ultimo_certificado_enviado_rrhh='';//Ya enviaste al área de Gestión humana el último certificado de tus estudios culminados?
                            $hvp_formacion_ultimo_estudio_realizado_titulo='';//Indica el nombre del título de tu último estudio realizado
                            $hvp_formacion_tarjeta_profesional=$array_detalle_seleccion[$id_aspirante_final]['hvaet_tarjeta_profesional'];//Tienes tarjeta profesional?
                            $hvp_formacion_estudios_curso='';//¿Estás estudiando actualmente?
                            $hvp_habilidades_nivel_ingles='';//¿Nivel de inglés conversacional?
                            $hvp_habilidades_nivel_excel='';//¿Nivel de manejo de hojas de cálculo?
                            $hvp_habilidades_nivel_google_ws='';//Nivel de manejo de google WS (Workspace)
                            $hvp_poblaciones_poblacion='';//Haces parte de alguna de las poblaciones mencionadas?
                            $hvp_poblaciones_certificado='';//¿Cuentas con los documentos que validen la información (certificación)?
                            $hvp_poblaciones_familiares_iq='';//¿Tienes familiares, conyugue y/o compañero permanente, parientes dentro del primer o segundo grado
                            $hvp_poblaciones_familiares_iq_identificacion='';//Documento de identidad de tu familiar
                            $hvp_poblaciones_familiares_iq_nombres_apellidos='';//¿Cuál es el nombre de tu familiar?
                            $hvp_poblaciones_familiares_iq_ingreso_marzo_2022='';//Tu familiar ingresó a la compañía antes de marzo 2022?
                            $hvp_veracidad='';//Veracidad de la Información Proporcionada
                            $aa_nombre=$array_detalle_seleccion[$id_aspirante_final]['aa_nombre'];//Centro de Costo
                            $ac_nombre=$array_detalle_seleccion[$id_aspirante_final]['ac_nombre'];//Cargo

                            $hvp_fecha_ingreso=$array_detalle_seleccion[$id_aspirante_final]['hva_ingreso_fecha'];//Fecha Ingreso
                            $hvp_retiro_fecha=$array_detalle_seleccion[$id_aspirante_final]['hva_retiro_fecha'];//Fecha Retiro
                            $hvp_retiro_motivo=$array_detalle_seleccion[$id_aspirante_final]['hva_retiro_motivo'];//Motivo Retiro

                            $estado_autorizaciones='';//estado_autorizaciones
                            $estado_informacion_personal='';//estado_informacion_personal
                            $estado_ubicacion_contacto='';//estado_ubicacion_contacto
                            $estado_socioeconomico_familiar='';//estado_socioeconomico_familiar
                            $estado_salud_bienestar='';//estado_salud_bienestar
                            $estado_intereses_habitos='';//estado_intereses_habitos
                            $estado_formacion_habilidades='';//estado_formacion_habilidades
                            $estado_poblaciones_relaciones='';//estado_poblaciones_relaciones
                            $estado_general='';//estado_general
                        }

                        
                        $spreadsheet->getActiveSheet()->setCellValue('A'.$i,mb_strtoupper($hvp_estado));//Estado
                        $spreadsheet->getActiveSheet()->setCellValue('B'.$i,mb_strtoupper($hvp_actualiza_fecha));//Fecha Actualización
                        $spreadsheet->getActiveSheet()->setCellValue('C'.$i,mb_strtoupper($dias_diferencia));//Tiempo Actualización
                        $spreadsheet->getActiveSheet()->setCellValue('D'.$i,mb_strtoupper($hvp_consentimiento_tratamiento_datos_personales));//Consentimiento Tratamiento Datos
                        $spreadsheet->getActiveSheet()->setCellValue('E'.$i,mb_strtoupper($hvp_datos_personales_tipo_documento));//Tipo de documento de identidad
                        $spreadsheet->getActiveSheet()->setCellValue('F'.$i,mb_strtoupper($hvp_datos_personales_numero_identificacion));//Número de identificación
                        $spreadsheet->getActiveSheet()->setCellValue('G'.$i,mb_strtoupper($hva_auxiliar_5));//Fecha de expedición del documento
                        $spreadsheet->getActiveSheet()->setCellValue('H'.$i,mb_strtoupper($hvp_datos_personales_nombre_1));//Primer nombre
                        $spreadsheet->getActiveSheet()->setCellValue('I'.$i,mb_strtoupper($hvp_datos_personales_nombre_2));//Segundo nombre
                        $spreadsheet->getActiveSheet()->setCellValue('J'.$i,mb_strtoupper($hvp_datos_personales_apellido_1));//Primer apellido
                        $spreadsheet->getActiveSheet()->setCellValue('K'.$i,mb_strtoupper($hvp_datos_personales_apellido_2));//Segundo apellido
                        $spreadsheet->getActiveSheet()->setCellValue('L'.$i,mb_strtoupper($hvp_auxiliar_1));//¿Cómo prefieres que te llamen?
                        $spreadsheet->getActiveSheet()->setCellValue('M'.$i,mb_strtoupper($hvp_demografia_genero));//¿Cuál es tu género? 
                        $spreadsheet->getActiveSheet()->setCellValue('N'.$i,mb_strtoupper($hvp_demografia_estado_civil));//¿Cuál es tu estado civil ?
                        $spreadsheet->getActiveSheet()->setCellValue('O'.$i,mb_strtoupper($TCIUDADN_ciu_municipio));//Lugar nacimiento 
                        $spreadsheet->getActiveSheet()->setCellValue('P'.$i,mb_strtoupper($hvp_demografia_fecha_nacimiento));//Fecha nacimiento
                        $spreadsheet->getActiveSheet()->setCellValue('Q'.$i,mb_strtoupper($hvp_demografia_edad));//Edad
                        $spreadsheet->getActiveSheet()->setCellValue('R'.$i,mb_strtoupper($hvp_expectativa_motivacion_expectativa_desarrollo));//¿Llevas más de 6 meses en la compañía? 
                        $spreadsheet->getActiveSheet()->setCellValue('S'.$i,mb_strtoupper($hvp_expectativa_motivacion_expectativa_crecimiento_profesional));//¿Crees que este trabajo te ofrecerá oportunidades de crecimiento profesional?
                        $spreadsheet->getActiveSheet()->setCellValue('T'.$i,mb_strtoupper($hvp_expectativa_motivacion_realidad_crecimiento_profesional));//¿En qué medida estás de acuerdo con la siguiente afirmación?: “Este trabajo me ha ofrecido oportunidades de crecimiento laboral.”
                        $spreadsheet->getActiveSheet()->setCellValue('U'.$i,mb_strtoupper($hvp_expectativa_motivacion_motivacion_trabajo));//Motivación principal para aceptar el trabajo
                        $spreadsheet->getActiveSheet()->setCellValue('V'.$i,mb_strtoupper($TCIUDAD_ciu_municipio));//Ciudad de residencia 
                        $spreadsheet->getActiveSheet()->setCellValue('W'.$i,mb_strtoupper($hvp_ubicacion_direccion_residencia));//Dirección de residencia
                        $spreadsheet->getActiveSheet()->setCellValue('X'.$i,mb_strtoupper($hvp_ubicacion_localidad_comuna));//Localidad/Comuna
                        $spreadsheet->getActiveSheet()->setCellValue('Y'.$i,mb_strtoupper($hvp_ubicacion_barrio));//Barrio
                        $spreadsheet->getActiveSheet()->setCellValue('Z'.$i,mb_strtoupper($hvp_ubicacion_maps_latitud));//Maps Latitud
                        $spreadsheet->getActiveSheet()->setCellValue('AA'.$i,mb_strtoupper($hvp_ubicacion_maps_longitud));//Maps Longitud
                        $spreadsheet->getActiveSheet()->setCellValue('AB'.$i,mb_strtoupper($hvp_ubicacion_maps_ciudad));//Maps Ciudad
                        $spreadsheet->getActiveSheet()->setCellValue('AC'.$i,mb_strtoupper($hvp_ubicacion_maps_departamento));//Maps Departamento
                        $spreadsheet->getActiveSheet()->setCellValue('AD'.$i,mb_strtoupper($hvp_ubicacion_maps_pais));//Maps Pais
                        $spreadsheet->getActiveSheet()->setCellValue('AE'.$i,mb_strtoupper($hvp_ubicacion_maps_localidad));//Maps Localidad
                        $spreadsheet->getActiveSheet()->setCellValue('AF'.$i,mb_strtoupper($hvp_ubicacion_maps_barrio));//Maps Barrio
                        $spreadsheet->getActiveSheet()->setCellValue('AG'.$i,mb_strtoupper($hvp_ubicacion_maps_codigo_postal));//Maps Código Postal
                        $spreadsheet->getActiveSheet()->setCellValue('AH'.$i,mb_strtoupper($hvp_ubicacion_maps_direccion));//Maps Dirección
                        $spreadsheet->getActiveSheet()->setCellValue('AI'.$i,mb_strtoupper($hvp_contacto_numero_celular));//Número de celular
                        $spreadsheet->getActiveSheet()->setCellValue('AJ'.$i,mb_strtoupper($hvp_auxiliar_2));//Número de celular alternativo
                        $spreadsheet->getActiveSheet()->setCellValue('AK'.$i,strtolower($hvp_contacto_correo_personal));//Correo electrónico personal
                        $spreadsheet->getActiveSheet()->setCellValue('AL'.$i,strtolower($hvp_contacto_correo_corporativo));//Correo electrónico corporativo
                        $spreadsheet->getActiveSheet()->setCellValue('AM'.$i,mb_strtoupper($hvp_contacto_emergencia_nombres));//1. Nombres
                        $spreadsheet->getActiveSheet()->setCellValue('AN'.$i,mb_strtoupper($hvp_contacto_emergencia_apellidos));//1. Apellidos
                        $spreadsheet->getActiveSheet()->setCellValue('AO'.$i,mb_strtoupper($hvp_contacto_emergencia_parentesco));//1. Parentesco
                        $spreadsheet->getActiveSheet()->setCellValue('AP'.$i,mb_strtoupper($hvp_contacto_emergencia_celular));//1. Número de celular de tu familiar/amigo(a)
                        $spreadsheet->getActiveSheet()->setCellValue('AQ'.$i,mb_strtoupper($hvp_contacto_emergencia_nombres_2));//2. Nombres
                        $spreadsheet->getActiveSheet()->setCellValue('AR'.$i,mb_strtoupper($hvp_contacto_emergencia_apellidos_2));//2. Apellidos
                        $spreadsheet->getActiveSheet()->setCellValue('AS'.$i,mb_strtoupper($hvp_contacto_emergencia_parentesco_2));//2. Parentesco
                        $spreadsheet->getActiveSheet()->setCellValue('AT'.$i,mb_strtoupper($hvp_contacto_emergencia_celular_2));//2. Número de celular de tu familiar/amigo(a)
                        $spreadsheet->getActiveSheet()->setCellValue('AU'.$i,mb_strtoupper($hvp_socioeconomico_estrato_socioeconomico));//Estrato socioeconómico
                        $spreadsheet->getActiveSheet()->setCellValue('AV'.$i,mb_strtoupper($hvp_socioeconomico_operador_internet));//Operador de internet 
                        $spreadsheet->getActiveSheet()->setCellValue('AW'.$i,mb_strtoupper($hvp_socioeconomico_operador_internet_otro));//Operador de internet - Otro
                        $spreadsheet->getActiveSheet()->setCellValue('AX'.$i,mb_strtoupper($hvp_socioeconomico_velocidad_internet_descarga));//Velocidad de descarga de internet (MB)
                        $spreadsheet->getActiveSheet()->setCellValue('AY'.$i,mb_strtoupper($hvp_socioeconomico_velocidad_internet_carga));//Velocidad de carga de internet (MB)
                        $spreadsheet->getActiveSheet()->setCellValue('AZ'.$i,mb_strtoupper($hvp_socioeconomico_caracteristicas_vivienda));//Características de tu vivienda
                        $spreadsheet->getActiveSheet()->setCellValue('BA'.$i,mb_strtoupper($hvp_socioeconomico_condiciones_vivienda));//Condición de la vivienda
                        $spreadsheet->getActiveSheet()->setCellValue('BB'.$i,mb_strtoupper($hvp_socioeconomico_estado_terminacion_vivienda));//¿Cuál es el estado de terminación de tu vivienda?
                        $spreadsheet->getActiveSheet()->setCellValue('BC'.$i,mb_strtoupper($hvp_socioeconomico_servicios_vivienda));//¿Qué servicios tienes en tu vivienda?
                        $spreadsheet->getActiveSheet()->setCellValue('BD'.$i,mb_strtoupper($hvp_socioeconomico_plan_compra_vivienda));//¿Tienes pensado comprar vivienda en los próximos 3 años?
                        $spreadsheet->getActiveSheet()->setCellValue('BE'.$i,mb_strtoupper($hvp_socioeconomico_beneficiario_subsidio_vivienda));//¿Has sido beneficiario de subsidio de vivienda?
                        $spreadsheet->getActiveSheet()->setCellValue('BF'.$i,mb_strtoupper($hvp_familia_numero_hijos));//¿Cuántos hijos tienes?
                        $spreadsheet->getActiveSheet()->setCellValue('BG'.$i,$xxx);//familia_hijos_menor_3
                        $spreadsheet->getActiveSheet()->setCellValue('BH'.$i,$xxx);//familia_hijos_4_10
                        $spreadsheet->getActiveSheet()->setCellValue('BI'.$i,$xxx);//familia_hijos_11_17
                        $spreadsheet->getActiveSheet()->setCellValue('BJ'.$i,$xxx);//familia_hijos_mayor_18
                        $spreadsheet->getActiveSheet()->setCellValue('BK'.$i,mb_strtoupper($hvp_familia_capacitacion_familia));//¿En cual de los siguientes temas relacionados con la familia te gustaría recibir
                        $spreadsheet->getActiveSheet()->setCellValue('BL'.$i,mb_strtoupper($hvp_financiero_activos));//Activos
                        $spreadsheet->getActiveSheet()->setCellValue('BM'.$i,mb_strtoupper($hvp_financiero_pasivos));//Pasivos
                        $spreadsheet->getActiveSheet()->setCellValue('BN'.$i,mb_strtoupper($hvp_financiero_patrimonio));//Patrimonio
                        $spreadsheet->getActiveSheet()->setCellValue('BO'.$i,mb_strtoupper($hvp_financiero_ingresos));//Ingresos Mensuales
                        $spreadsheet->getActiveSheet()->setCellValue('BP'.$i,mb_strtoupper($hvp_financiero_egresos));//Egresos Mensuales
                        $spreadsheet->getActiveSheet()->setCellValue('BQ'.$i,mb_strtoupper($hvp_financiero_ingresos_otros));//Otros Ingresos
                        $spreadsheet->getActiveSheet()->setCellValue('BR'.$i,mb_strtoupper($hvp_financiero_concepto_ingresos));//Concepto de otros ingresos
                        $spreadsheet->getActiveSheet()->setCellValue('BS'.$i,mb_strtoupper($hvp_financiero_moneda_extranjera));//¿Realiza Operaciones en Moneda Extranjera?
                        $spreadsheet->getActiveSheet()->setCellValue('BT'.$i,mb_strtoupper($hvp_origen_fondos));//Declaración de Origen de Fondos y Prevención de Lavado de Activos
                        $spreadsheet->getActiveSheet()->setCellValue('BU'.$i,mb_strtoupper($hvp_pep_recursos));//¿Maneja recursos públicos?
                        $spreadsheet->getActiveSheet()->setCellValue('BV'.$i,mb_strtoupper($hvp_pep_reconocimiento));//¿Goza de reconocimiento público general?
                        $spreadsheet->getActiveSheet()->setCellValue('BW'.$i,mb_strtoupper($hvp_pep_poder));//¿Ejerce algún grado de poder público?
                        $spreadsheet->getActiveSheet()->setCellValue('BX'.$i,mb_strtoupper($hvp_pep_familiar));//¿Tiene usted algún familiar que cumpla con una característica anterior?
                        $spreadsheet->getActiveSheet()->setCellValue('BY'.$i,mb_strtoupper($hvp_pep_cedula));//¿Tiene usted algún familiar que cumpla con una característica anterior?
                        $spreadsheet->getActiveSheet()->setCellValue('BZ'.$i,mb_strtoupper($hvp_pep_nombres_apellidos));//¿Tiene usted algún familiar que cumpla con una característica anterior?
                        $spreadsheet->getActiveSheet()->setCellValue('CA'.$i,mb_strtoupper($hvp_salud_bienestar_grupo_sanguineo));//¿Cuál es tu grupo sanguíneo?
                        $spreadsheet->getActiveSheet()->setCellValue('CB'.$i,mb_strtoupper($hvp_salud_bienestar_rh));//¿Cuál es tu RH?
                        $spreadsheet->getActiveSheet()->setCellValue('CC'.$i,mb_strtoupper($hvp_salud_bienestar_actividad_fisica_minima));//¿Realizas actividad física de mínimo 20 minutos al día?
                        $spreadsheet->getActiveSheet()->setCellValue('CD'.$i,mb_strtoupper($hvp_salud_bienestar_fumador));//¿Fumas?
                        $spreadsheet->getActiveSheet()->setCellValue('CE'.$i,mb_strtoupper($hvp_salud_bienestar_pausas_activas));//¿Realizas pausas activas durante la jornada laboral?
                        $spreadsheet->getActiveSheet()->setCellValue('CF'.$i,mb_strtoupper($hvp_salud_bienestar_medicina_prepagada));//¿Tienes medicina prepagada?
                        $spreadsheet->getActiveSheet()->setCellValue('CG'.$i,mb_strtoupper($hvp_salud_bienestar_medicina_prepagada_cual));//Medicina prepagada
                        $spreadsheet->getActiveSheet()->setCellValue('CH'.$i,mb_strtoupper($hvp_salud_bienestar_plan_complementario_salud));//¿Tienes plan complementario de salud?
                        $spreadsheet->getActiveSheet()->setCellValue('CI'.$i,mb_strtoupper($hvp_salud_bienestar_plan_complementario_salud_cual));//Plan Complementario
                        $spreadsheet->getActiveSheet()->setCellValue('CJ'.$i,mb_strtoupper($hvp_interes_habitos_hobbies_deportes));//Deportes
                        $spreadsheet->getActiveSheet()->setCellValue('CK'.$i,mb_strtoupper($hvp_interes_habitos_hobbies_deportes_cual));//Deportes - Otro
                        $spreadsheet->getActiveSheet()->setCellValue('CL'.$i,mb_strtoupper($hvp_interes_habitos_hobbies_deportes_frecuencia));//Deportes - Frecuencia
                        $spreadsheet->getActiveSheet()->setCellValue('CM'.$i,mb_strtoupper($hvp_interes_habitos_hobbies_aire));//Actividades al aire libre
                        $spreadsheet->getActiveSheet()->setCellValue('CN'.$i,mb_strtoupper($hvp_interes_habitos_hobbies_aire_cual));//Actividades al aire libre - Otro
                        $spreadsheet->getActiveSheet()->setCellValue('CO'.$i,mb_strtoupper($hvp_interes_habitos_hobbies_aire_frecuencia));//Actividades al aire libre - Frecuencia
                        $spreadsheet->getActiveSheet()->setCellValue('CP'.$i,mb_strtoupper($hvp_interes_habitos_hobbies_arte));//Arte y creatividad
                        $spreadsheet->getActiveSheet()->setCellValue('CQ'.$i,mb_strtoupper($hvp_interes_habitos_hobbies_arte_cual));//Arte y creatividad - Otro
                        $spreadsheet->getActiveSheet()->setCellValue('CR'.$i,mb_strtoupper($hvp_interes_habitos_hobbies_arte_instrumento));//Arte y creatividad - Música - Instrumento
                        $spreadsheet->getActiveSheet()->setCellValue('CS'.$i,mb_strtoupper($hvp_interes_habitos_hobbies_arte_frecuencia));//Arte y creatividad - Frecuencia
                        $spreadsheet->getActiveSheet()->setCellValue('CT'.$i,mb_strtoupper($hvp_interes_habitos_hobbies_tecnologia));//Tecnología
                        $spreadsheet->getActiveSheet()->setCellValue('CU'.$i,mb_strtoupper($hvp_interes_habitos_hobbies_tecnologia_cual));//Tecnología - Otro
                        $spreadsheet->getActiveSheet()->setCellValue('CV'.$i,mb_strtoupper($hvp_interes_habitos_hobbies_tecnologia_frecuencia));//Tecnología - Frecuencia
                        $spreadsheet->getActiveSheet()->setCellValue('CW'.$i,mb_strtoupper($hvp_interes_habitos_hobbies_otro));//Otros
                        $spreadsheet->getActiveSheet()->setCellValue('CX'.$i,mb_strtoupper($hvp_interes_habitos_hobbies_otro_cual));//Otros - Otro
                        $spreadsheet->getActiveSheet()->setCellValue('CY'.$i,mb_strtoupper($hvp_interes_habitos_hobbies_otro_frecuencia));//Otros - Frecuencia
                        $spreadsheet->getActiveSheet()->setCellValue('CZ'.$i,mb_strtoupper($hvp_interes_habitos_hobbies_recibir_informacion));//¿Te gustaría recibir información sobre eventos o actividades relacionadas con tus hobbies?
                        $spreadsheet->getActiveSheet()->setCellValue('DA'.$i,mb_strtoupper($hvp_interes_habitos_actividades_familia));//¿Cuáles actividades te gusta hacer en familia?
                        $spreadsheet->getActiveSheet()->setCellValue('DB'.$i,mb_strtoupper($hvp_interes_habitos_actividades_deportivas));//¿Realizas actividades deportivas?
                        $spreadsheet->getActiveSheet()->setCellValue('DC'.$i,mb_strtoupper($hvp_interes_habitos_actividades_deportivas_cual));//Cuales actividades deportivas
                        $spreadsheet->getActiveSheet()->setCellValue('DD'.$i,mb_strtoupper($hvp_interes_habitos_medio_transporte));//¿Cuál es tu medio de transporte cuando vas a la oficina?
                        $spreadsheet->getActiveSheet()->setCellValue('DE'.$i,mb_strtoupper($hvp_interes_habitos_habito_ahorro));//¿Tienes el hábito de ahorrar?
                        $spreadsheet->getActiveSheet()->setCellValue('DF'.$i,mb_strtoupper($hvp_interes_habitos_mascotas));//¿Tienes Mascotas?
                        $spreadsheet->getActiveSheet()->setCellValue('DG'.$i,mb_strtoupper($hvp_interes_habitos_mascotas_cual));//Cuéntanos que mascota tienes?
                        $spreadsheet->getActiveSheet()->setCellValue('DH'.$i,mb_strtoupper($hvp_formacion_ultimo_certificado_enviado_rrhh));//Ya enviaste al área de Gestión humana el último certificado de tus estudios culminados?
                        $spreadsheet->getActiveSheet()->setCellValue('DI'.$i,mb_strtoupper($hvp_formacion_ultimo_estudio_realizado_titulo));//Indica el nombre del título de tu último estudio realizado
                        $spreadsheet->getActiveSheet()->setCellValue('DL'.$i,mb_strtoupper($hvp_formacion_tarjeta_profesional));//Tienes tarjeta profesional?
                        $spreadsheet->getActiveSheet()->setCellValue('DM'.$i,mb_strtoupper($hvp_formacion_estudios_curso));//¿Estás estudiando actualmente?
                        $spreadsheet->getActiveSheet()->setCellValue('DN'.$i,mb_strtoupper($hvp_habilidades_nivel_ingles));//¿Nivel de inglés conversacional?
                        $spreadsheet->getActiveSheet()->setCellValue('DO'.$i,mb_strtoupper($hvp_habilidades_nivel_excel));//¿Nivel de manejo de hojas de cálculo?
                        $spreadsheet->getActiveSheet()->setCellValue('DP'.$i,mb_strtoupper($hvp_habilidades_nivel_google_ws));//Nivel de manejo de google WS (Workspace)
                        $spreadsheet->getActiveSheet()->setCellValue('DQ'.$i,mb_strtoupper($hvp_poblaciones_poblacion));//Haces parte de alguna de las poblaciones mencionadas?
                        $spreadsheet->getActiveSheet()->setCellValue('DR'.$i,mb_strtoupper($hvp_poblaciones_certificado));//¿Cuentas con los documentos que validen la información (certificación)?
                        $spreadsheet->getActiveSheet()->setCellValue('DS'.$i,mb_strtoupper($hvp_poblaciones_familiares_iq));//¿Tienes familiares, conyugue y/o compañero permanente, parientes dentro del primer o segundo grado
                        $spreadsheet->getActiveSheet()->setCellValue('DT'.$i,mb_strtoupper($hvp_poblaciones_familiares_iq_identificacion));//Documento de identidad de tu familiar
                        $spreadsheet->getActiveSheet()->setCellValue('DU'.$i,mb_strtoupper($hvp_poblaciones_familiares_iq_nombres_apellidos));//¿Cuál es el nombre de tu familiar?
                        $spreadsheet->getActiveSheet()->setCellValue('DV'.$i,mb_strtoupper($hvp_poblaciones_familiares_iq_ingreso_marzo_2022));//Tu familiar ingresó a la compañía antes de marzo 2022?
                        $spreadsheet->getActiveSheet()->setCellValue('DW'.$i,mb_strtoupper($hvp_veracidad));//Veracidad de la Información Proporcionada
                        $spreadsheet->getActiveSheet()->setCellValue('DX'.$i,mb_strtoupper($aa_nombre));//Centro de Costo
                        $spreadsheet->getActiveSheet()->setCellValue('DY'.$i,mb_strtoupper($ac_nombre));//Cargo

                        $spreadsheet->getActiveSheet()->setCellValue('DZ'.$i,mb_strtoupper($hvp_fecha_ingreso));//Fecha Ingreso
                        $spreadsheet->getActiveSheet()->setCellValue('EA'.$i,mb_strtoupper($hvp_retiro_fecha));//Fecha Retiro
                        $spreadsheet->getActiveSheet()->setCellValue('EB'.$i,mb_strtoupper($hvp_retiro_motivo));//Motivo Retiro

                        $spreadsheet->getActiveSheet()->setCellValue('EC'.$i,$estado_autorizaciones);//estado_autorizaciones
                        $spreadsheet->getActiveSheet()->setCellValue('ED'.$i,$estado_informacion_personal);//estado_informacion_personal
                        $spreadsheet->getActiveSheet()->setCellValue('EE'.$i,$estado_ubicacion_contacto);//estado_ubicacion_contacto
                        $spreadsheet->getActiveSheet()->setCellValue('EF'.$i,$estado_socioeconomico_familiar);//estado_socioeconomico_familiar
                        $spreadsheet->getActiveSheet()->setCellValue('EG'.$i,$estado_salud_bienestar);//estado_salud_bienestar
                        $spreadsheet->getActiveSheet()->setCellValue('EH'.$i,$estado_intereses_habitos);//estado_intereses_habitos
                        $spreadsheet->getActiveSheet()->setCellValue('EI'.$i,$estado_formacion_habilidades);//estado_formacion_habilidades
                        $spreadsheet->getActiveSheet()->setCellValue('EJ'.$i,$estado_poblaciones_relaciones);//estado_poblaciones_relaciones
                        $spreadsheet->getActiveSheet()->setCellValue('EK'.$i,$estado_general);//estado_general
                        
                    }
                } elseif ($tipo_reporte=='Cumplimiento') {
                    $hoja_vida = new hv_personalModel();
                    if ($estado!='' AND $estado!='Todos') {
                        $hoja_vida->hvp_estado=$estado;
                    }

                    $resregistros=$hoja_vida->listAllReport();
                    
                    if (!isset($resregistros[0])) {
                        $resregistros=array();
                    }
    
                    //Estilos de la Hoja 0
                    $spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(80);
                    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AE')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AG')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AH')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getStyle('A4:AH4')->applyFromArray($styleArrayTitulos);
                    $spreadsheet->getActiveSheet()->setAutoFilter('A4:AH4');
                    $spreadsheet->getActiveSheet()->getStyle('3')->getAlignment()->setWrapText(true);
                    $spreadsheet->getActiveSheet()->getStyle('4')->getAlignment()->setWrapText(true);

                    // Escribiendo los titulos
                    $spreadsheet->getActiveSheet()->setCellValue('A3','Información General');
                    $spreadsheet->getActiveSheet()->setCellValue('A4','Estado');

                    $spreadsheet->getActiveSheet()->setCellValue('B3','Autorizaciones');
                    $spreadsheet->getActiveSheet()->setCellValue('B4','Consentimiento Tratamiento Datos');

                    $spreadsheet->getActiveSheet()->setCellValue('C3','Información Personal');
                    $spreadsheet->getActiveSheet()->setCellValue('C4','Tipo de documento de identidad');
                    $spreadsheet->getActiveSheet()->setCellValue('D4','Número de identificación');
                    $spreadsheet->getActiveSheet()->setCellValue('E4','Fecha de Expedición');
                    $spreadsheet->getActiveSheet()->setCellValue('F4','Primer nombre');
                    $spreadsheet->getActiveSheet()->setCellValue('G4','Segundo nombre');
                    $spreadsheet->getActiveSheet()->setCellValue('H4','Primer apellido');
                    $spreadsheet->getActiveSheet()->setCellValue('I4','Segundo apellido');

                    $spreadsheet->getActiveSheet()->setCellValue('I3','Información Demografía');
                    $spreadsheet->getActiveSheet()->setCellValue('J4','Lugar nacimiento ');
                    $spreadsheet->getActiveSheet()->setCellValue('K4','Fecha nacimiento');
                    $spreadsheet->getActiveSheet()->setCellValue('L4','Edad');

                    $spreadsheet->getActiveSheet()->setCellValue('L3','Información de Ubicación');
                    $spreadsheet->getActiveSheet()->setCellValue('M4','Ciudad de residencia ');
                    $spreadsheet->getActiveSheet()->setCellValue('N4','Dirección de residencia');
                    $spreadsheet->getActiveSheet()->setCellValue('O4','Localidad/Comuna');
                    $spreadsheet->getActiveSheet()->setCellValue('P4','Barrio');
                    
                    $spreadsheet->getActiveSheet()->setCellValue('P3','Información Socioeconómica');
                    $spreadsheet->getActiveSheet()->setCellValue('Q4','Estrato socioeconómico');
                    
                    $spreadsheet->getActiveSheet()->setCellValue('Q3','Información Financiera');
                    $spreadsheet->getActiveSheet()->setCellValue('R4','Activos');
                    $spreadsheet->getActiveSheet()->setCellValue('S4','Pasivos');
                    $spreadsheet->getActiveSheet()->setCellValue('T4','Patrimonio');
                    $spreadsheet->getActiveSheet()->setCellValue('U4','Ingresos Mensuales');
                    $spreadsheet->getActiveSheet()->setCellValue('V4','Egresos Mensuales');
                    $spreadsheet->getActiveSheet()->setCellValue('W4','Otros Ingresos');
                    $spreadsheet->getActiveSheet()->setCellValue('X4','Concepto de otros ingresos');
                    $spreadsheet->getActiveSheet()->setCellValue('Y4','¿Realiza Operaciones en Moneda Extranjera?');
                    $spreadsheet->getActiveSheet()->setCellValue('Z4','Declaración de Origen de Fondos y Prevención de Lavado de Activos y Financiación del Terrorismo - SAGRILAFT');

                    $spreadsheet->getActiveSheet()->setCellValue('Z3','Personas Expuestas Públicamente - PEP');
                    $spreadsheet->getActiveSheet()->setCellValue('AA4','¿Maneja recursos públicos?');
                    $spreadsheet->getActiveSheet()->setCellValue('AB4','¿Goza de reconocimiento público general?');
                    $spreadsheet->getActiveSheet()->setCellValue('AC4','¿Ejerce algún grado de poder público?');
                    $spreadsheet->getActiveSheet()->setCellValue('AD4','¿Tiene usted algún familiar que cumpla con una característica anterior?');
                    $spreadsheet->getActiveSheet()->setCellValue('AE4','PEP - Identificación');
                    $spreadsheet->getActiveSheet()->setCellValue('AF4','PEP - Nombres y Apellidos');
                    
                    $spreadsheet->getActiveSheet()->setCellValue('AG4','Veracidad de la Información Proporcionada');
                    $spreadsheet->getActiveSheet()->setCellValue('AH4','Fecha Actualización');
                    
                    $spreadsheet->getActiveSheet()->setCellValue('A1','Reporte: Cumplimiento');
                    $spreadsheet->getActiveSheet()->setCellValue('A2','Fecha: '.now());
                    
                    // Ingresar Data consultada a partir de la fila 4
                    for ($i=5; $i < count($resregistros)+5; $i++) {
                        $spreadsheet->getActiveSheet()->setCellValue('A'.$i,mb_strtoupper($resregistros[$i-5]['hvp_estado']));//Estado
                        $spreadsheet->getActiveSheet()->setCellValue('B'.$i,mb_strtoupper($resregistros[$i-5]['hvp_consentimiento_tratamiento_datos_personales']));//Consentimiento Tratamiento Datos
                        $spreadsheet->getActiveSheet()->setCellValue('C'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_tipo_documento']));//Tipo de documento de identidad
                        $spreadsheet->getActiveSheet()->setCellValue('D'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_numero_identificacion']));//Número de identificación
                        $spreadsheet->getActiveSheet()->setCellValue('E'.$i,mb_strtoupper($resregistros[$i-5]['hva_auxiliar_5']));//Número de identificación
                        $spreadsheet->getActiveSheet()->setCellValue('F'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_nombre_1']));//Primer nombre
                        $spreadsheet->getActiveSheet()->setCellValue('G'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_nombre_2']));//Segundo nombre
                        $spreadsheet->getActiveSheet()->setCellValue('H'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_apellido_1']));//Primer apellido
                        $spreadsheet->getActiveSheet()->setCellValue('I'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_apellido_2']));//Segundo apellido
                        $spreadsheet->getActiveSheet()->setCellValue('J'.$i,mb_strtoupper($resregistros[$i-5]['TCIUDADN_ciu_municipio']).', '.mb_strtoupper($resregistros[$i-5]['TCIUDADN_ciu_departamento']));//Lugar nacimiento 
                        $spreadsheet->getActiveSheet()->setCellValue('K'.$i,mb_strtoupper($resregistros[$i-5]['hvp_demografia_fecha_nacimiento']));//Fecha nacimiento
                        $spreadsheet->getActiveSheet()->setCellValue('L'.$i,mb_strtoupper($resregistros[$i-5]['hvp_demografia_edad']));//Edad
                        $spreadsheet->getActiveSheet()->setCellValue('M'.$i,mb_strtoupper($resregistros[$i-5]['TCIUDAD_ciu_municipio']).', '.mb_strtoupper($resregistros[$i-5]['TCIUDAD_ciu_departamento']));//Ciudad de residencia 
                        $spreadsheet->getActiveSheet()->setCellValue('N'.$i,mb_strtoupper($resregistros[$i-5]['hvp_ubicacion_direccion_residencia']));//Dirección de residencia
                        $spreadsheet->getActiveSheet()->setCellValue('O'.$i,mb_strtoupper($resregistros[$i-5]['hvp_ubicacion_localidad_comuna']));//Localidad/Comuna
                        $spreadsheet->getActiveSheet()->setCellValue('P'.$i,mb_strtoupper($resregistros[$i-5]['hvp_ubicacion_barrio']));//Barrio
                        $spreadsheet->getActiveSheet()->setCellValue('Q'.$i,mb_strtoupper($resregistros[$i-5]['hvp_socioeconomico_estrato_socioeconomico']));//Estrato socioeconómico
                        $spreadsheet->getActiveSheet()->setCellValue('R'.$i,mb_strtoupper($resregistros[$i-5]['hvp_financiero_activos']));//Activos
                        $spreadsheet->getActiveSheet()->setCellValue('S'.$i,mb_strtoupper($resregistros[$i-5]['hvp_financiero_pasivos']));//Pasivos
                        $spreadsheet->getActiveSheet()->setCellValue('T'.$i,mb_strtoupper($resregistros[$i-5]['hvp_financiero_patrimonio']));//Patrimonio
                        $spreadsheet->getActiveSheet()->setCellValue('U'.$i,mb_strtoupper($resregistros[$i-5]['hvp_financiero_ingresos']));//Ingresos Mensuales
                        $spreadsheet->getActiveSheet()->setCellValue('V'.$i,mb_strtoupper($resregistros[$i-5]['hvp_financiero_egresos']));//Egresos Mensuales
                        $spreadsheet->getActiveSheet()->setCellValue('W'.$i,mb_strtoupper($resregistros[$i-5]['hvp_financiero_ingresos_otros']));//Otros Ingresos
                        $spreadsheet->getActiveSheet()->setCellValue('X'.$i,mb_strtoupper($resregistros[$i-5]['hvp_financiero_concepto_ingresos']));//Concepto de otros ingresos
                        $spreadsheet->getActiveSheet()->setCellValue('Y'.$i,mb_strtoupper($resregistros[$i-5]['hvp_financiero_moneda_extranjera']));//¿Realiza Operaciones en Moneda Extranjera?
                        $spreadsheet->getActiveSheet()->setCellValue('Z'.$i,mb_strtoupper($resregistros[$i-5]['hvp_origen_fondos']));//Declaración de Origen de Fondos y Prevención de Lavado de Activos
                        $spreadsheet->getActiveSheet()->setCellValue('AA'.$i,mb_strtoupper($resregistros[$i-5]['hvp_pep_recursos']));//¿Maneja recursos públicos?
                        $spreadsheet->getActiveSheet()->setCellValue('AB'.$i,mb_strtoupper($resregistros[$i-5]['hvp_pep_reconocimiento']));//¿Goza de reconocimiento público general?
                        $spreadsheet->getActiveSheet()->setCellValue('AC'.$i,mb_strtoupper($resregistros[$i-5]['hvp_pep_poder']));//¿Ejerce algún grado de poder público?
                        $spreadsheet->getActiveSheet()->setCellValue('AD'.$i,mb_strtoupper($resregistros[$i-5]['hvp_pep_familiar']));//¿Tiene usted algún familiar que cumpla con una característica anterior?
                        $spreadsheet->getActiveSheet()->setCellValue('AE'.$i,mb_strtoupper($resregistros[$i-5]['hvp_pep_cedula']));//¿Tiene usted algún familiar que cumpla con una característica anterior?
                        $spreadsheet->getActiveSheet()->setCellValue('AF'.$i,mb_strtoupper($resregistros[$i-5]['hvp_pep_nombres_apellidos']));//¿Tiene usted algún familiar que cumpla con una característica anterior?
                        $spreadsheet->getActiveSheet()->setCellValue('AG'.$i,mb_strtoupper($resregistros[$i-5]['hvp_veracidad']));//Veracidad de la Información Proporcionada
                        $spreadsheet->getActiveSheet()->setCellValue('AH'.$i,mb_strtoupper($resregistros[$i-5]['hvp_actualiza_fecha']));//Veracidad de la Información Proporcionada
                        
                    }
                } elseif ($tipo_reporte=='Contratación') {
                    $hoja_vida = new hv_personalModel();
                    if ($estado!='' AND $estado!='Todos') {
                        $hoja_vida->hvp_estado=$estado;
                    }

                    $hoja_vida->fecha_inicio=$fecha_inicio;
                    $hoja_vida->fecha_fin=$fecha_fin;

                    $resregistros=$hoja_vida->listAllReport();
                    
                    if (!isset($resregistros[0])) {
                        $resregistros=array();
                    }
    
                    //Estilos de la Hoja 0
                    $spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(80);
                    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AE')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getStyle('A4:V4')->applyFromArray($styleArrayTitulos);
                    $spreadsheet->getActiveSheet()->setAutoFilter('A4:V4');
                    $spreadsheet->getActiveSheet()->getStyle('3')->getAlignment()->setWrapText(true);
                    $spreadsheet->getActiveSheet()->getStyle('4')->getAlignment()->setWrapText(true);

                    // Escribiendo los titulos
                    $spreadsheet->getActiveSheet()->setCellValue('A3','Información Personal');
                    $spreadsheet->getActiveSheet()->setCellValue('A4','Tipo de documento de identidad');
                    $spreadsheet->getActiveSheet()->setCellValue('B4','Número de identificación');
                    $spreadsheet->getActiveSheet()->setCellValue('C4','Primer nombre');
                    $spreadsheet->getActiveSheet()->setCellValue('D4','Segundo nombre');
                    $spreadsheet->getActiveSheet()->setCellValue('E4','Primer apellido');
                    $spreadsheet->getActiveSheet()->setCellValue('F4','Segundo apellido');

                    $spreadsheet->getActiveSheet()->setCellValue('G3','Información Demografía');
                    $spreadsheet->getActiveSheet()->setCellValue('G4','¿Cuál es tu género? ');
                    $spreadsheet->getActiveSheet()->setCellValue('H4','¿Cuál es tu estado civil ?');
                    $spreadsheet->getActiveSheet()->setCellValue('I4','Lugar nacimiento ');
                    $spreadsheet->getActiveSheet()->setCellValue('J4','Fecha nacimiento');

                    $spreadsheet->getActiveSheet()->setCellValue('K3','Información de Ubicación');
                    $spreadsheet->getActiveSheet()->setCellValue('K4','Ciudad de residencia ');
                    $spreadsheet->getActiveSheet()->setCellValue('L4','Dirección de residencia');
                    $spreadsheet->getActiveSheet()->setCellValue('M4','Barrio');

                    $spreadsheet->getActiveSheet()->setCellValue('N3','Información de Contacto');
                    $spreadsheet->getActiveSheet()->setCellValue('N4','Número de celular');
                    $spreadsheet->getActiveSheet()->setCellValue('O4','Número de celular alternativo');
                    $spreadsheet->getActiveSheet()->setCellValue('P4','Correo electrónico personal');
                    $spreadsheet->getActiveSheet()->setCellValue('Q4','Correo electrónico corporativo');

                    $spreadsheet->getActiveSheet()->setCellValue('R3','Información de Salud y Bienestar');
                    $spreadsheet->getActiveSheet()->setCellValue('R4','¿Cuál es tu grupo sanguíneo?');
                    $spreadsheet->getActiveSheet()->setCellValue('S4','¿Cuál es tu RH?');
                    $spreadsheet->getActiveSheet()->setCellValue('T4','Fecha Ingreso');
                    $spreadsheet->getActiveSheet()->setCellValue('U4','Fecha Retiro');
                    $spreadsheet->getActiveSheet()->setCellValue('V4','Motivo Retiro');
                    
                    $spreadsheet->getActiveSheet()->setCellValue('A1','Reporte: Contratación');
                    $spreadsheet->getActiveSheet()->setCellValue('A2','Fecha: '.now());
                    
                    // Ingresar Data consultada a partir de la fila 4
                    for ($i=5; $i < count($resregistros)+5; $i++) {
                        $spreadsheet->getActiveSheet()->setCellValue('A'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_tipo_documento']));//Tipo de documento de identidad
                        $spreadsheet->getActiveSheet()->setCellValue('B'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_numero_identificacion']));//Número de identificación
                        $spreadsheet->getActiveSheet()->setCellValue('C'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_nombre_1']));//Primer nombre
                        $spreadsheet->getActiveSheet()->setCellValue('D'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_nombre_2']));//Segundo nombre
                        $spreadsheet->getActiveSheet()->setCellValue('E'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_apellido_1']));//Primer apellido
                        $spreadsheet->getActiveSheet()->setCellValue('F'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_apellido_2']));//Segundo apellido
                        $spreadsheet->getActiveSheet()->setCellValue('G'.$i,mb_strtoupper($resregistros[$i-5]['hvp_demografia_genero']));//¿Cuál es tu género? 
                        $spreadsheet->getActiveSheet()->setCellValue('H'.$i,mb_strtoupper($resregistros[$i-5]['hvp_demografia_estado_civil']));//¿Cuál es tu estado civil ?
                        $spreadsheet->getActiveSheet()->setCellValue('I'.$i,mb_strtoupper($resregistros[$i-5]['TCIUDADN_ciu_municipio']).', '.mb_strtoupper($resregistros[$i-5]['TCIUDADN_ciu_departamento']));//Lugar nacimiento 
                        $spreadsheet->getActiveSheet()->setCellValue('J'.$i,mb_strtoupper($resregistros[$i-5]['hvp_demografia_fecha_nacimiento']));//Fecha nacimiento
                        $spreadsheet->getActiveSheet()->setCellValue('K'.$i,mb_strtoupper($resregistros[$i-5]['TCIUDAD_ciu_municipio']).', '.mb_strtoupper($resregistros[$i-5]['TCIUDAD_ciu_departamento']));//Ciudad de residencia 
                        $spreadsheet->getActiveSheet()->setCellValue('L'.$i,mb_strtoupper($resregistros[$i-5]['hvp_ubicacion_direccion_residencia']));//Dirección de residencia
                        $spreadsheet->getActiveSheet()->setCellValue('M'.$i,mb_strtoupper($resregistros[$i-5]['hvp_ubicacion_barrio']));//Barrio
                        $spreadsheet->getActiveSheet()->setCellValue('N'.$i,mb_strtoupper($resregistros[$i-5]['hvp_contacto_numero_celular']));//Número de celular
                        $spreadsheet->getActiveSheet()->setCellValue('O'.$i,mb_strtoupper($resregistros[$i-5]['hvp_auxiliar_2']));//Número de celular alternativo
                        $spreadsheet->getActiveSheet()->setCellValue('P'.$i,strtolower($resregistros[$i-5]['hvp_contacto_correo_personal']));//Correo electrónico personal
                        $spreadsheet->getActiveSheet()->setCellValue('Q'.$i,strtolower($resregistros[$i-5]['hvp_contacto_correo_corporativo']));//Correo electrónico corporativo
                        $spreadsheet->getActiveSheet()->setCellValue('R'.$i,mb_strtoupper($resregistros[$i-5]['hvp_salud_bienestar_grupo_sanguineo']));//¿Cuál es tu grupo sanguíneo?
                        $spreadsheet->getActiveSheet()->setCellValue('S'.$i,mb_strtoupper($resregistros[$i-5]['hvp_salud_bienestar_rh']));//¿Cuál es tu RH?
                        $spreadsheet->getActiveSheet()->setCellValue('T'.$i,mb_strtoupper($resregistros[$i-5]['hvp_fecha_ingreso']));//Fecha Ingreso
                        $spreadsheet->getActiveSheet()->setCellValue('U'.$i,mb_strtoupper($resregistros[$i-5]['hvp_retiro_fecha']));//Fecha Retiro
                        $spreadsheet->getActiveSheet()->setCellValue('V'.$i,mb_strtoupper($resregistros[$i-5]['hvp_retiro_motivo']));//Motivo Retiro
                    }
                } elseif ($tipo_reporte=='Formación') {
                    $hoja_vida = new hv_personalModel();
                    if ($estado!='' AND $estado!='Todos') {
                        $hoja_vida->hvp_estado=$estado;
                    }

                    $hoja_vida->fecha_inicio_retiro=$fecha_inicio;
                    $hoja_vida->fecha_fin_retiro=$fecha_fin;

                    $resregistros=$hoja_vida->listAllReport();
                    
                    if (!isset($resregistros[0])) {
                        $resregistros=array();
                    }
    
                    //Estilos de la Hoja 0
                    $spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(80);
                    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AE')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
                    $spreadsheet->getActiveSheet()->getStyle('A4:K4')->applyFromArray($styleArrayTitulos);
                    $spreadsheet->getActiveSheet()->setAutoFilter('A4:K4');
                    $spreadsheet->getActiveSheet()->getStyle('3')->getAlignment()->setWrapText(true);
                    $spreadsheet->getActiveSheet()->getStyle('4')->getAlignment()->setWrapText(true);

                    // Escribiendo los titulos
                    $spreadsheet->getActiveSheet()->setCellValue('A3','Información Personal');
                    $spreadsheet->getActiveSheet()->setCellValue('A4','Tipo de documento de identidad');
                    $spreadsheet->getActiveSheet()->setCellValue('B4','Número de identificación');
                    $spreadsheet->getActiveSheet()->setCellValue('C4','Primer nombre');
                    $spreadsheet->getActiveSheet()->setCellValue('D4','Segundo nombre');
                    $spreadsheet->getActiveSheet()->setCellValue('E4','Primer apellido');
                    $spreadsheet->getActiveSheet()->setCellValue('F4','Segundo apellido');
                    $spreadsheet->getActiveSheet()->setCellValue('G4','Centro de Costo');
                    $spreadsheet->getActiveSheet()->setCellValue('H4','Cargo');
                    $spreadsheet->getActiveSheet()->setCellValue('I4','Fecha Ingreso');
                    $spreadsheet->getActiveSheet()->setCellValue('J4','Fecha Retiro');
                    $spreadsheet->getActiveSheet()->setCellValue('K4','Motivo Retiro');
                    
                    
                    $spreadsheet->getActiveSheet()->setCellValue('A1','Reporte: Formación');
                    $spreadsheet->getActiveSheet()->setCellValue('A2','Fecha: '.now());
                    
                    // Ingresar Data consultada a partir de la fila 4
                    for ($i=5; $i < count($resregistros)+5; $i++) {
                        $spreadsheet->getActiveSheet()->setCellValue('A'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_tipo_documento']));//Tipo de documento de identidad
                        $spreadsheet->getActiveSheet()->setCellValue('B'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_numero_identificacion']));//Número de identificación
                        $spreadsheet->getActiveSheet()->setCellValue('C'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_nombre_1']));//Primer nombre
                        $spreadsheet->getActiveSheet()->setCellValue('D'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_nombre_2']));//Segundo nombre
                        $spreadsheet->getActiveSheet()->setCellValue('E'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_apellido_1']));//Primer apellido
                        $spreadsheet->getActiveSheet()->setCellValue('F'.$i,mb_strtoupper($resregistros[$i-5]['hvp_datos_personales_apellido_2']));//Segundo apellido
                        $spreadsheet->getActiveSheet()->setCellValue('G'.$i,mb_strtoupper($resregistros[$i-5]['aa_nombre']));//Centro de Costo
                        $spreadsheet->getActiveSheet()->setCellValue('H'.$i,mb_strtoupper($resregistros[$i-5]['ac_nombre']));//Cargo
                        $spreadsheet->getActiveSheet()->setCellValue('I'.$i,mb_strtoupper($resregistros[$i-5]['hvp_fecha_ingreso']));//Fecha Ingreso
                        $spreadsheet->getActiveSheet()->setCellValue('J'.$i,mb_strtoupper($resregistros[$i-5]['hvp_retiro_fecha']));//Fecha Retiro
                        $spreadsheet->getActiveSheet()->setCellValue('K'.$i,mb_strtoupper($resregistros[$i-5]['hvp_retiro_motivo']));//Motivo Retiro
                    }
                }

                //Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="'.$titulo_reporte.'"');
                header('Cache-Control: max-age=0');

                // Guardamos el archivo
                $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save('php://output');
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        
        function encuestas($id_registro) {
            //array columnas
                $array_columnas=array();
                $array_columnas[]="A";
                $array_columnas[]="B";
                $array_columnas[]="C";
                $array_columnas[]="D";
                $array_columnas[]="E";
                $array_columnas[]="F";
                $array_columnas[]="G";
                $array_columnas[]="H";
                $array_columnas[]="I";
                $array_columnas[]="J";
                $array_columnas[]="K";
                $array_columnas[]="L";
                $array_columnas[]="M";
                $array_columnas[]="N";
                $array_columnas[]="O";
                $array_columnas[]="P";
                $array_columnas[]="Q";
                $array_columnas[]="R";
                $array_columnas[]="S";
                $array_columnas[]="T";
                $array_columnas[]="U";
                $array_columnas[]="V";
                $array_columnas[]="W";
                $array_columnas[]="X";
                $array_columnas[]="Y";
                $array_columnas[]="Z";
                $array_columnas[]="AA";
                $array_columnas[]="AB";
                $array_columnas[]="AC";
                $array_columnas[]="AD";
                $array_columnas[]="AE";
                $array_columnas[]="AF";
                $array_columnas[]="AG";
                $array_columnas[]="AH";
                $array_columnas[]="AI";
                $array_columnas[]="AJ";
                $array_columnas[]="AK";
                $array_columnas[]="AL";
                $array_columnas[]="AM";
                $array_columnas[]="AN";
                $array_columnas[]="AO";
                $array_columnas[]="AP";
                $array_columnas[]="AQ";
                $array_columnas[]="AR";
                $array_columnas[]="AS";
                $array_columnas[]="AT";
                $array_columnas[]="AU";
                $array_columnas[]="AV";
                $array_columnas[]="AW";
                $array_columnas[]="AX";
                $array_columnas[]="AY";
                $array_columnas[]="AZ";
                $array_columnas[]="BA";
                $array_columnas[]="BB";
                $array_columnas[]="BC";
                $array_columnas[]="BD";
                $array_columnas[]="BE";
                $array_columnas[]="BF";
                $array_columnas[]="BG";
                $array_columnas[]="BH";
                $array_columnas[]="BI";
                $array_columnas[]="BJ";
                $array_columnas[]="BK";
                $array_columnas[]="BL";
                $array_columnas[]="BM";
                $array_columnas[]="BN";
                $array_columnas[]="BO";
                $array_columnas[]="BP";
                $array_columnas[]="BQ";
                $array_columnas[]="BR";
                $array_columnas[]="BS";
                $array_columnas[]="BT";
                $array_columnas[]="BU";
                $array_columnas[]="BV";
                $array_columnas[]="BW";
                $array_columnas[]="BX";
                $array_columnas[]="BY";
                $array_columnas[]="BZ";
                $array_columnas[]="CA";
                $array_columnas[]="CB";
                $array_columnas[]="CC";
                $array_columnas[]="CD";
                $array_columnas[]="CE";
                $array_columnas[]="CF";
                $array_columnas[]="CG";
                $array_columnas[]="CH";
                $array_columnas[]="CI";
                $array_columnas[]="CJ";
                $array_columnas[]="CK";
                $array_columnas[]="CL";
                $array_columnas[]="CM";
                $array_columnas[]="CN";
                $array_columnas[]="CO";
                $array_columnas[]="CP";
                $array_columnas[]="CQ";
                $array_columnas[]="CR";
                $array_columnas[]="CS";
                $array_columnas[]="CT";
                $array_columnas[]="CU";
                $array_columnas[]="CV";
                $array_columnas[]="CW";
                $array_columnas[]="CX";
                $array_columnas[]="CY";
                $array_columnas[]="CZ";
            //array columnas
            // error_reporting(E_ALL);
            // ini_set('display_errors', '1');
            Controller::checkSesion();
            $tipo_reporte='Encuestas';

            try {
                $id_registro = checkInput(base64_decode($id_registro));
                
                $encuesta = new encuestaModel();
                $encuesta->enc_id=$id_registro;
                $resencuesta=$encuesta->listDetail();

                if (!isset($resencuesta[0])) {
                    $resencuesta=array();
                }
                
                $preguntas = new encuesta_preguntasModel();
                $preguntas->encp_encuesta=$id_registro;
                $respreguntas=$preguntas->list();

                if (!isset($respreguntas[0])) {
                    $respreguntas=array();
                }

                $respuestas = new encuesta_respuestasModel();
                $respuestas->encr_encuesta = $id_registro;
                $resrespuestas = $respuestas->listAll();

                if (!isset($resrespuestas[0])) {
                    $resrespuestas=array();
                }

                for ($i=0; $i < count($resrespuestas); $i++) { 
                    // $array_resultados[$resrespuestas[$i]['crr_usuario']][$resrespuestas[$i]['crr_pregunta']]['nota']=$resrespuestas[$i]['crr_nota'];
                    $array_resultados[$resrespuestas[$i]['encr_usuario']][$resrespuestas[$i]['encr_pregunta']]['respuesta_usuario']=$resrespuestas[$i]['encr_respuesta'];
                    $array_resultados[$resrespuestas[$i]['encr_usuario']]['respuesta_fecha']=$resrespuestas[$i]['encr_registro_fecha'];
                    
                }

                $respuestas_usuario = new encuesta_respuestasModel();
                $respuestas_usuario->encr_encuesta = $id_registro;
                $resrespuestas_usuario = $respuestas_usuario->listRespuestas();

                if (!isset($resrespuestas_usuario[0])) {
                    $resrespuestas_usuario=array();
                }

                $titulo_reporte="".$tipo_reporte.' - '.$resencuesta[0]['enc_titulo'].' - '.date('Y-m-d H_i_s').".xlsx";
                // Creamos nueva instancia de PHPExcel 
                $spreadsheet = new Spreadsheet();

                // Establecer propiedades
                $spreadsheet->getProperties()
                ->setCreator(APP_NAME_ALL)
                ->setLastModifiedBy($_SESSION[APP_SESSION.'usu_nombre'])
                ->setTitle(APP_NAME_ALL)
                ->setSubject(APP_NAME_ALL)
                ->setDescription(APP_NAME_ALL)
                ->setKeywords(APP_NAME_ALL)
                ->setCategory("Reporte");

                require_once(INCLUDES."inc_excel_style.php");

                //Activar hoja 0
                $sheet = $spreadsheet->getActiveSheet(0);
                
                // Nombramos la hoja 0
                $spreadsheet->getActiveSheet()->setTitle('Reporte Encuestas');

                //Estilos de la Hoja 0
                // $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(40);
                $spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(80);
                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                
                $spreadsheet->getActiveSheet()->setAutoFilter('A4:'.$array_columnas[(count($respreguntas))+4].'4');

                $spreadsheet->getActiveSheet()->getStyle('A4:'.$array_columnas[(count($respreguntas))+4].'4')->applyFromArray($styleArrayTitulos);
                $spreadsheet->getActiveSheet()->getStyle('A4:'.$array_columnas[(count($respreguntas))+4].'4')->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet()->getStyle('4')->getAlignment()->setWrapText(true);

                $spreadsheet->getActiveSheet()->setCellValue('A1','Encuesta: '.$resencuesta[0]['enc_titulo']);
                $spreadsheet->getActiveSheet()->setCellValue('A2','Fecha reporte: '.date('d/m/Y H:i:s'));

                // Escribiendo los titulos
                $spreadsheet->getActiveSheet()->setCellValue('A4','Doc Usuario');
                $spreadsheet->getActiveSheet()->setCellValue('B4','Nombres y Apellidos');
                $spreadsheet->getActiveSheet()->setCellValue('C4','Cargo');
                $spreadsheet->getActiveSheet()->setCellValue('D4','Centro de Costo');
                $spreadsheet->getActiveSheet()->setCellValue('E4','Fecha Diligenciamiento');
                
                $columna_nota=5;
                for ($i=0; $i < count($respreguntas); $i++) {
                    
                    $nombre_final=$respreguntas[$i]['encp_orden'].'. '.$respreguntas[$i]['encp_pregunta'];
                    $spreadsheet->getActiveSheet()->setCellValue($array_columnas[$columna_nota].'4',$nombre_final);

                    $spreadsheet->getActiveSheet()->getColumnDimension($array_columnas[$columna_nota])->setWidth(50);
                    $columna_nota+=1;
                }

                //Ingresar Data consultada a partir de la fila 5
                for ($i=5; $i < count($resrespuestas_usuario)+5; $i++) {
                    $spreadsheet->getActiveSheet()->setCellValue('A'.$i,$resrespuestas_usuario[$i-5]['usu_documento']);
                    $spreadsheet->getActiveSheet()->setCellValue('B'.$i,$resrespuestas_usuario[$i-5]['usu_nombres_apellidos']);
                    $spreadsheet->getActiveSheet()->setCellValue('C'.$i,$resrespuestas_usuario[$i-5]['ac_nombre']);
                    $spreadsheet->getActiveSheet()->setCellValue('D'.$i,$resrespuestas_usuario[$i-5]['aa_nombre']);
                    $spreadsheet->getActiveSheet()->setCellValue('E'.$i,$array_resultados[$resrespuestas_usuario[$i-5]['encr_usuario']]['respuesta_fecha']);
                    
                    $columna_nota=5;
                    for ($j=0; $j < count($respreguntas); $j++) {
                        $respuesta_pregunta=$array_resultados[$resrespuestas_usuario[$i-5]['encr_usuario']][$respreguntas[$j]['encp_id']]['respuesta_usuario'];
                        
                        $spreadsheet->getActiveSheet()->setCellValue($array_columnas[$columna_nota].$i,$respuesta_pregunta);
                        $columna_nota+=1;
                    }
                }

                //Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="'.$titulo_reporte.'"');
                header('Cache-Control: max-age=0');

                // Guardamos el archivo
                $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save('php://output');
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }