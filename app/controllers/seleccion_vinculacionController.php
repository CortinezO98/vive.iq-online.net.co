<?php
    // use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    // use setasign\Fpdi\Tcpdf\Fpdi;
    // use iio\libmergepdf\Merger;
    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');
     require_once(ASSETS_ROOT.'plugins/TCPDF-main/tcpdf.php');
    //  require_once(ROOT.'app/plugins/PhpSpreadsheet/vendor/autoload.php');
    //  require_once(ASSETS_ROOT.'plugins/PDFLeer/fpdf.php');
    //  require_once(ASSETS_ROOT.'plugins/PDFLeer/fpdi.php');
     
    class CustomTCPDF extends TCPDF {
        public function Header() {
            // Agrega la imagen al encabezado
            $imagePath = ASSETS_ROOT.'images/logo/logo_iq.png';
            $this->Image($imagePath, '', 5, 40, '', 'PNG', '', 'T', false, 40, '', false, false, 0, false, false, false);
            // Set font
            $this->SetFont('helvetica', 'B', 8);
            // Title
            $this->Cell(20,4, '', '', 0, 'C');
            $this->MultiCell(50, 5, 'HOJA DE VIDA', 0, 'C', 0, 1, '', '');
            $this->Cell(148,4, '', '', 0, 'C');
            $this->Cell(50,4, 'Calidad', '', 1, 'C');
            $this->Cell(50,4, '', '', 0, 'C');
            $this->MultiCell(100, 5, 'CÓDIGO DE FORMATO: F10-A1 VERSIÓN No. 11', 0, 'C', 0, 1, '', '');
        }
    }

    class CustomTCPDF2 extends TCPDF {
        public function Header() {
            // Agrega la imagen al encabezado
            $imagePath = ASSETS_ROOT.'images/logo/logo_iq.png';
            $this->Image($imagePath, '', 5, 40, '', 'PNG', '', 'T', false, 40, '', false, false, 0, false, false, false);
            // Set font
            $this->SetFont('helvetica', 'B', 8);
            // Title
            $this->Cell(5,4, '', '', 0, 'C');
            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11; text-align: center;"><b>FORMATO AUTORIZACIÓN DE TRATAMIENTO DE DATOS PERSONALES</b></td>
                </tr>';
            $html .= '</table>';
            $this->writeHTML($html, true, false, true, false, '');
            
        }
    }

    function generate_pub_pdf ($pdf_file, $pdf_ruta) {
        natcasesort($pdf_ruta);
        if (count($pdf_ruta)) {
            $pdf = new FPDI();
            foreach ($pdf_ruta as $page) {
                if (pathinfo(strtolower($page), PATHINFO_EXTENSION) == 'pdf') {
                    $pdf->setSourceFile($page);
                    $pageid = $pdf->importPage(1);
                    $size = $pdf->getTemplateSize($pageid);
                    if ($size['w'] > $size['h']) {
                        $pdf->AddPage('L', array($size['w'], $size['h']));
                    } else {
                        $pdf->AddPage('P', array($size['w'], $size['h']));
                    }
                    $pdf->useTemplate($pageid);
                }
            }
            // $pdf->SetDisplayMode('fullpage', 'single');
            $pdf->Output('D', $pdf_file);
            return true;
        } else {
            return false;
        }
    }
    
    class seleccion_vinculacionController extends Controller {
        function __construct()
        {
        } 

        function index() {
            Controller::checkSesion();
            Redirect::to('seleccion-vinculacion/aspirantes/0/null');
        }

        function aspirantes($pagina, $filtro_busqueda, $bandeja) {
            Controller::checkSesion();
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $bandeja=checkInput(base64_decode($bandeja));
            unset($_SESSION[APP_SESSION.'_proceso_add']);
            unset($_SESSION[APP_SESSION.'_proceso_masivo_add']);
            unset($_SESSION[APP_SESSION.'_actualizar_masivo_add']);
            unset($_SESSION[APP_SESSION.'_aspirante_del']);
            unset($_SESSION[APP_SESSION.'_correo_masivo_add']);
            // error_reporting(E_ALL);
            // ini_set('display_errors', '1');
            $modulo_perfil=$_SESSION[APP_SESSION.'usu_modulos']['Selección'];

            if(isset($_POST["form_filtro_busqueda"])){
                //obtiene variables de formulario
                $filtro_busqueda=checkInput($_POST['filtro_busqueda']);
                $pagina=0;
            }
            
            $registros = new hv_aspiranteModel();
            $registros->pagina = $pagina;
            $registros->limite = 20;
            $registros->offset = $pagina*$registros->limite;
            $registros->filtro = $filtro_busqueda;
            
            $array_estados=array();
            if ($bandeja=='Todos') {

            } elseif ($bandeja=='Pendientes') {
                $array_estados[]='Pendiente';
                $array_estados[]='Pendiente Fase 2';
            } elseif ($bandeja=='Diligenciados') {
                $array_estados[]='Diligenciado';
            } elseif ($bandeja=='Documentos Cargados') {
                $array_estados[]='Documentos Cargados';
            } elseif ($bandeja=='Vinculados') {
                $array_estados[]='Vinculado';
            } elseif ($bandeja=='Retirados') {
                $array_estados[]='Retirado';
            } elseif ($bandeja=='Desiste') {
                $array_estados[]='Desiste';
            } elseif ($bandeja=='No vinculados') {
                $array_estados[]='No vinculado';
            }

            $registros->filtro_bandeja = $array_estados;

            $res = $registros->list();
            $resCount = $registros->listCount();
            if (!isset($res[0])) {
                $res=array();
            }
            if (!isset($resCount[0])) {
                $resCount=array();
            }
            $pag_total=ceil(count($resCount)/$registros->limite);

            if (count($resCount)>0) {
                $pag_inicio=($pagina*$registros->limite)+1;
            } else {
                $pag_inicio=0;
            }
            
            if ((($pagina+1)*$registros->limite)>count($resCount)) {
                $pag_fin=count($resCount);
            } else {
                $pag_fin=(($pagina+1)*$registros->limite);
            }

            $area_lista = new areaModel();
            $resarea_lista = $area_lista->listActive();

            if (!isset($resarea_lista[0])) {
                $resarea_lista=array();
            }

            $cargo = new cargoModel();
            $rescargo=$cargo->listActive();

            if (!isset($rescargo[0])) {
                $rescargo=array();
            }

            $psicologo = new usuarioModel();
            $respsicologo=$psicologo->listPsicologo();

            if (!isset($respsicologo[0])) {
                $respsicologo=array();
            }

            $data =
            [
                'titulo_pagina' => 'SELECCIÓN|ASPIRANTES|'.mb_strtoupper($bandeja),
                'path' => 'seleccion-vinculacion/aspirantes/',
                'path_add' => '/'.base64_encode($bandeja),
                'resultado_registros' => to_object($res),
                'pag_inicio' => $pag_inicio,
                'pag_fin' => $pag_fin,
                'pag_total' => $pag_total,
                'resultado_registros_count' => count($resCount),
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'bandeja' => base64_encode($bandeja),
                'modulo_perfil' => $modulo_perfil,
                'resultado_registros_area_lista' => to_object($resarea_lista),
                'resultado_registros_cargo' => to_object($rescargo),
                'resultado_registros_psicologo' => to_object($respsicologo),
            ];
            try {
            } catch (Exception $e) {
                Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
            }
            
            View::render('aspirantes', $data);
        }

        public static function aspirantes_crear_masivo($pagina, $filtro_busqueda, $bandeja) {
            // ini_set('display_errors', '1');
            // error_reporting(E_ALL);
            require_once(ROOT.'app/plugins/PHPOffice/vendor/autoload.php');
            
            $modulo_plataforma="1";
            Controller::checkSesion();
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $bandeja=checkInput(base64_decode($bandeja));

            $area_lista = new areaModel();
            $resarea_lista = $area_lista->listActive();

            if (!isset($resarea_lista[0])) {
                $resarea_lista=array();
            }

            $array_centro_costos=array();
            for ($i=0; $i < count($resarea_lista); $i++) { 
                $array_centro_costos[$resarea_lista[$i]['aa_nombre']]=$resarea_lista[$i]['aa_id'];
            }

            $cargo = new cargoModel();
            $rescargo=$cargo->listActive();

            if (!isset($rescargo[0])) {
                $rescargo=array();
            }

            $array_cargos=array();
            for ($i=0; $i < count($rescargo); $i++) { 
                $array_cargos[$rescargo[$i]['ac_nombre']]=$rescargo[$i]['ac_id'];
            }

            $usuario = new usuarioModel();
            $respsicologo=$usuario->listPsicologo();

            if (!isset($respsicologo[0])) {
                $respsicologo=array();
            }

            $resdirector=$usuario->listActive();

            if (!isset($resdirector[0])) {
                $resdirector=array();
            }

            $array_psicologos=array();
            for ($i=0; $i < count($respsicologo); $i++) { 
                $array_psicologos[$respsicologo[$i]['usu_documento']]=$respsicologo[$i]['usu_id'];
            }

            $array_director=array();
            for ($i=0; $i < count($resdirector); $i++) { 
                $array_director[$resdirector[$i]['usu_documento']]=$resdirector[$i]['usu_id'];
            }

            $control_errores_detalle=array();
            $control_registro_detalle=array();

            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                $hva_observaciones=checkInput($_POST['hva_observaciones']);
 
                try {
                    if($_SESSION[APP_SESSION.'_proceso_masivo_add']!=1) {
                        if ($_FILES['documento_masivo']['name']!="") {
                            $archivo_extension = checkInput(strtolower(pathinfo($_FILES['documento_masivo']['name'], PATHINFO_EXTENSION)));
                            $NombreArchivo=nowFile().".".$archivo_extension;
                            $ruta_actual=UPLOADS_ROOT."administrador/";
                            $ruta_final=$ruta_actual.$NombreArchivo;
                            
                            if ($_FILES['documento_masivo']["error"] > 0) {
                                $control_documento=0;
                            } else {
                            /*ahora co la funcion move_uploaded_file lo guardaremos en el destino que queramos*/
                                if (move_uploaded_file($_FILES['documento_masivo']['tmp_name'], $ruta_final)) {
                                    $control_documento=1;
                                } else {
                                    $control_documento=0;
                                }
                            }
                        } else {
                            $control_documento=0;
                        }
                    
                        if ($control_documento AND file_exists($ruta_final)) {
                            clearstatcache();

                            $documento = IOFactory::load($ruta_final);
                            $hojaActual = $documento->getSheet(0);
                            $numeroMayorDeFila = $hojaActual->getHighestRow();

                            $control_item=0;
                            for ($indicefila = 2; $indicefila <= $numeroMayorDeFila; $indicefila++) {
                                $columna_a = $hojaActual->getCellByColumnAndRow(1, $indicefila)->getValue();
                                $columna_b = $hojaActual->getCellByColumnAndRow(2, $indicefila)->getValue();
                                $columna_c = $hojaActual->getCellByColumnAndRow(3, $indicefila)->getValue();
                                $columna_d = $hojaActual->getCellByColumnAndRow(4, $indicefila)->getValue();
                                $columna_e = $hojaActual->getCellByColumnAndRow(5, $indicefila)->getValue();
                                $columna_f = $hojaActual->getCellByColumnAndRow(6, $indicefila)->getValue();
                                $columna_g = $hojaActual->getCellByColumnAndRow(7, $indicefila)->getValue();
                                $columna_h = $hojaActual->getCellByColumnAndRow(8, $indicefila)->getValue();
                                $columna_i = $hojaActual->getCellByColumnAndRow(9, $indicefila)->getValue();
                                $columna_i = $hojaActual->getCellByColumnAndRow(10, $indicefila)->getValue();
                                
                                if ($columna_a!='' AND $columna_b!='') {
                                    $array_data_base[$control_item]['documento_identidad']=checkInput($columna_a);//DOCUMENTO_IDENTIDAD
                                    $array_data_base[$control_item]['nombre_1']=checkInput(strtoupper($columna_b));//NOMBRE 1
                                    $array_data_base[$control_item]['nombre_2']=checkInput(strtoupper($columna_c));//NOMBRE 2
                                    $array_data_base[$control_item]['apellido_1']=checkInput(strtoupper($columna_d));//APELLIDO 1
                                    $array_data_base[$control_item]['apellido_2']=checkInput(strtoupper($columna_e));//APELLIDO 2
                                    $array_data_base[$control_item]['correo']=checkInput(strtolower($columna_f));//CORREO
                                    $array_data_base[$control_item]['centro_costos']=checkInput($columna_g);//CENTRO DE COSTOS
                                    $array_data_base[$control_item]['cargo']=checkInput($columna_h);//CARGO
                                    $array_data_base[$control_item]['cc_psicologo']=checkInput($columna_i);//CC PSICÓLOGO
                                    $array_data_base[$control_item]['cc_director']=checkInput($columna_i);//CC DIRECTOR
    
                                    $control_item++;
                                    
                                } else {
                                    break;
                                }

                            }

                            
                            for ($i=0; $i < count($array_data_base); $i++) { 
                                if ($array_data_base[$i]['documento_identidad']!='' OR $array_data_base[$i]['nombre_1']!='' OR $array_data_base[$i]['apellido_1']!='' OR $array_data_base[$i]['apellido_2']!='' OR $array_data_base[$i]['correo']!='' OR $array_data_base[$i]['centro_costos']!='' OR $array_data_base[$i]['cargo']!='' OR $array_data_base[$i]['cc_psicologo']!='') {
                                    if ($array_data_base[$i]['documento_identidad']!='' AND $array_data_base[$i]['nombre_1']!='' AND $array_data_base[$i]['apellido_1']!='' AND $array_data_base[$i]['correo']!='' AND $array_data_base[$i]['centro_costos']!='' AND $array_data_base[$i]['cargo']!='' AND $array_data_base[$i]['cc_psicologo']!='') {
                                        if (!isset($array_centro_costos[$array_data_base[$i]['centro_costos']]) OR $array_centro_costos[$array_data_base[$i]['centro_costos']]=='') {
                                            $control_errores_detalle[]='Centro de costos ['.$array_data_base[$i]['centro_costos'].'] no identificada en fila: '.$i+1;
                                        }
    
                                        if (!isset($array_cargos[$array_data_base[$i]['cargo']]) OR $array_cargos[$array_data_base[$i]['cargo']]=='') {
                                            $control_errores_detalle[]='Cargo ['.$array_data_base[$i]['cargo'].'] no identificado en fila: '.$i+1;
                                        }
    
                                        if (!isset($array_psicologos[$array_data_base[$i]['cc_psicologo']]) OR $array_psicologos[$array_data_base[$i]['cc_psicologo']]=='') {
                                            $control_errores_detalle[]='Psicólogo ['.$array_data_base[$i]['cc_psicologo'].'] no identificado en fila: '.$i+1;
                                        }

                                        if (!isset($array_director[$array_data_base[$i]['cc_director']]) OR $array_director[$array_data_base[$i]['cc_director']]=='') {
                                            $control_errores_detalle[]='Director ['.$array_data_base[$i]['cc_director'].'] no identificado en fila: '.$i+1;
                                        }
                                    } else {
                                        $control_errores++;
                                        $control_errores_detalle[]='Datos incompletos en fila: '.$i+1;
                                    }
                                }
                            }

                            if (count($control_errores_detalle)==0) {
                                $control_errores=0;
                                $control_insert=0;
                                $control_registrar=0;
                                
                                $aspirante = new hv_aspiranteModel();

                                for ($i=0; $i < count($array_data_base); $i++) { 
                                    if ($array_data_base[$i]['documento_identidad']!='' OR $array_data_base[$i]['nombre_1']!='' OR $array_data_base[$i]['apellido_1']!='' OR $array_data_base[$i]['apellido_2']!='' OR $array_data_base[$i]['correo']!='' OR $array_data_base[$i]['centro_costos']!='' OR $array_data_base[$i]['cargo']!='' OR $array_data_base[$i]['cc_psicologo']!='') {
                                        $control_registrar++;
                                        if ($array_data_base[$i]['documento_identidad']!='' AND $array_data_base[$i]['nombre_1']!='' AND $array_data_base[$i]['apellido_1']!='' AND $array_data_base[$i]['correo']!='' AND $array_data_base[$i]['centro_costos']!='' AND $array_data_base[$i]['cargo']!='' AND $array_data_base[$i]['cc_psicologo']!='') {
                                            
                                            $hva_area=$array_centro_costos[$array_data_base[$i]['centro_costos']];
                                            $hva_cargo=$array_cargos[$array_data_base[$i]['cargo']];
                                            $hva_psicologo=$array_psicologos[$array_data_base[$i]['cc_psicologo']];
                                            $hva_director=$array_director[$array_data_base[$i]['cc_director']];
                                            $hva_correo=$array_data_base[$i]['correo'];
                                            $hva_estado='Pendiente';                           
                                            
                                            $aspirante->hva_identificacion=$array_data_base[$i]['documento_identidad'];

                                            $resaspirante=$aspirante->listDuplicado();

                                            if (!isset($resaspirante[0])) {
                                                $resaspirante=array();
                                            }
                                            
                                            $aspirante->hva_nombres=$array_data_base[$i]['nombre_1'];
                                            $aspirante->hva_nombres_2=$array_data_base[$i]['nombre_2'];
                                            $aspirante->hva_apellido_1=$array_data_base[$i]['apellido_1'];
                                            $aspirante->hva_apellido_2=$array_data_base[$i]['apellido_2'];
                                            $aspirante->hva_direccion='';
                                            $aspirante->hva_barrio='';
                                            $aspirante->hva_ciudad='';
                                            $aspirante->hva_celular='';
                                            $aspirante->hva_celular_2='';
                                            $aspirante->hva_correo=$hva_correo;
                                            $aspirante->hva_correo_corporativo='';
                                            $aspirante->hva_nacimiento_lugar='';
                                            $aspirante->hva_nacimiento_fecha='';
                                            $aspirante->hva_operador_internet='';
                                            $aspirante->hva_genero='';
                                            $aspirante->hva_estado_civil='';
                                            $aspirante->hva_estado=$hva_estado;
                                            $aspirante->hva_localidad='';
                                            $aspirante->hva_primer_empleo='';
                                            $aspirante->hva_auxiliar_1='';
                                            $aspirante->hva_auxiliar_2='';
                                            $aspirante->hva_auxiliar_3='';
                                            $aspirante->hva_auxiliar_4='';
                                            $aspirante->hva_auxiliar_5='';
                                            $aspirante->hva_ingreso_fecha='';
                                            $aspirante->hva_retiro_fecha='';
                                            $aspirante->hva_retiro_motivo='';
                                            $aspirante->hva_observaciones=$hva_observaciones;
                                            $aspirante->hva_oferta_id='';
                                            $aspirante->hva_autorizaciones_id='';
                                            $aspirante->hva_emergencia_id='';
                                            $aspirante->hva_etica_id='';
                                            $aspirante->hva_financiera_id='';
                                            $aspirante->hva_informacion_id='';
                                            $aspirante->hva_publico_id='';
                                            $aspirante->hva_seguridad_social_id='';
                                            $aspirante->hva_actualiza_usuario='';
                                            $aspirante->hva_actualiza_fecha='';
                                            $aspirante->hva_registro_usuario=checkInput($_SESSION[APP_SESSION.'usu_id']);
                                            
                                            if (count($resaspirante)==0) {
                                                $resinsert = $aspirante->add();
                                                $hva_id=$resinsert;
                                            } else {
                                                $aspirante->hva_id=$resaspirante[0]['hva_id'];
                                                $resinsert = $aspirante->updateAspirante();
                                                $hva_id=$resaspirante[0]['hva_id'];
                                            }

                                            if ($resinsert) {
                                                $oferta = new hv_aspirante_ofertaModel();
                                                $oferta->hvao_aspirante=$hva_id;
                                                $oferta->hvao_area=$hva_area;
                                                $oferta->hvao_cargo=$hva_cargo;
                                                $oferta->hvao_salario='';
                                                $oferta->hvao_psicologo=$hva_psicologo;
                                                $oferta->hvao_director=$hva_director;
                                                $oferta->hvao_horario='';
                                                $oferta->hvao_debida_diligencia='Pendiente';
                                                $oferta->hvao_prueba_confiabilidad='Pendiente';
                                                $oferta->hvao_examen_medico='Pendiente';
                                                $oferta->hvao_check_contratacion='Pendiente';
                                                $oferta->hvao_fecha_diligencia='';
                                                $oferta->hvao_firma_ruta='';
                                                $oferta->hvao_estado='Pendiente';
                                                $oferta->hvao_revisa_usuario='';
                                                $oferta->hvao_revisa_fecha='';
                                                $oferta->hvao_estado_fase_2='';
                                                $oferta->hvao_auxiliar_1='';
                                                $oferta->hvao_auxiliar_2='';
                                                $oferta->hvao_registro_usuario=checkInput($_SESSION[APP_SESSION.'usu_id']);
                                                $resinsertoferta = $oferta->add();

                                                if ($resinsertoferta) {
                                                    $aspirante->hva_id=$hva_id;
                                                    $aspirante->hva_oferta_id=$resinsertoferta;
                                                    $resupdate_oferta=$aspirante->updateIdOferta();

                                                    $token = new tokenModel();
                                                    $token->aut_usuario='HV'.$resinsertoferta;
                                                    $token->aut_token=newToken();
                                                    $token->aut_estado='Generado';
                                                    $token->aut_expira=date("Y-m-d H:i:s", strtotime("+ 90 day", strtotime(now())));
                                                    $res_insert_token = $token->add();
                        
                                                    if ($res_insert_token) {
                                                        $notificacion = new notificacionModel();

                                                        $boton_url=URL."seleccion-vinculacion/formulario-instrucciones/".base64_encode($token->aut_usuario)."/".base64_encode($token->aut_token);
                                                        $boton_titulo='Da clic aquí para ingresar';
                                                        //PROGRAMACIÓN NOTIFICACIÓN 
                                                            $contenido="<p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Para oficializar tu proceso de selección, te invitamos a diligenciar con la mayor celeridad los datos de tu hoja de vida, ingresando al siguiente link:</p>
                                                            <center>
                                                                <a href='".$boton_url."' target='_blank' style='border-radius:4px; color:#ffffff; font-size:12px; padding: 5px 5px 5px 5px; text-align:center; text-decoration:none !important; width:50%; display: block; background-color: ".COLOR_PRINCIPAL."'>".$boton_titulo."</a>
                                                            </center>";
                                                        /*SE CONFIGURAN PARÁMETROS A REGISTRAR EN SISTEMA DE NOTIFICACIÓN*/
                                                        $notificacion->nc_id_modulo=$modulo_plataforma;
                                                        $notificacion->nc_address=$hva_correo.';';
                                                        $notificacion->nc_subject="Bienvenid@ al proceso de selección iQ Outsourcing";
                                                        $notificacion->nc_body=notificacion_general($contenido, $boton_titulo, $boton_url);
                                                        $notificacion->nc_embeddedimage_ruta="".BASEPATH_IMAGE."logo/firma-verde.png;".BASEPATH_IMAGE."logo/logo_notificacion.png";
                                                        $notificacion->nc_embeddedimage_nombre="firma-verde;logo_notificacion";
                                                        $notificacion->nc_embeddedimage_tipo="image/png;image/png";
                                                        $notificacion->nc_usuario_registro=checkInput($_SESSION[APP_SESSION.'usu_id']);
                                                        $resnotificacion=$notificacion->add();

                                                        if ($resnotificacion) {
                                                            $control_insert++;
                                                            $control_registro_detalle[]='Oferta registrada exitosamente para el aspirante: '.$array_data_base[$i]['documento_identidad'].' | '.$array_data_base[$i]['nombre_1'].' '.$array_data_base[$i]['apellido_1'].' '.$array_data_base[$i]['apellido_2'];
                                                        } else {
                                                            // $usuario->delete();
                                                            // $passhistorial->delete();
                                                            // $usuarionegocio->deleteAll();
                                                            $control_errores++;
                                                            $control_errores_detalle[]='Problemas al notificar oferta para el aspirante en fila: '.$i+1;
                                                        }
                                                    } else {
                                                        // $usuario->delete();
                                                        // $passhistorial->delete();
                                                        // $usuarionegocio->deleteAll();
                                                        $control_errores++;
                                                        $control_errores_detalle[]='Problemas al generar token para el aspirante en fila: '.$i+1;
                                                    }
                                                } else {
                                                    $control_errores++;
                                                    $control_errores_detalle[]='Problemas al crear la oferta fila: '.$i+1;
                                                }
                                            } else {
                                                $control_errores++;
                                                $control_errores_detalle[]='Problemas al crear el aspirante fila: '.$i+1;
                                            }
                                        } else {
                                            $control_errores++;
                                            $control_errores_detalle[]='Datos incompletos en fila: '.$i+1;
                                        }
                                    }
                                }

                                if (($control_insert+$control_errores)==$control_registrar) {
                                    Flasher::new('¡Registros creados exitosamente!', 'success');
                                    $_SESSION[APP_SESSION.'_proceso_masivo_add']=1;
                                }
                            } else {
                                Flasher::new('¡Problemas al cargar la plantilla, verifique e intente nuevamente!', 'warning');
                            }
                        } else {
                            Flasher::new('¡Problemas al cargar la plantilla, verifique e intente nuevamente!', 'warning');
                        }
                    } else {
                        Flasher::new('¡Registro creado exitosamente!', 'success');
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }

            $data =
            [
                'titulo_pagina' => 'SELECCIÓN|ASPIRANTES|CREAR MASIVO',
                'path' => 'seleccion-vinculacion/aspirantes-crear-masivo/',
                'path_add' => '/'.base64_encode($bandeja),
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'resultado_registros_area_lista' => to_object($resarea_lista),
                'resultado_registros_cargo' => to_object($rescargo),
                'resultado_registros_psicologo' => to_object($respsicologo),
                'bandeja' => base64_encode($bandeja),
                'resultado_registros_errores' => $control_errores_detalle,
                'resultado_registros_creados' => $control_registro_detalle,

            ];
            
            View::render('aspirantes_crear_masivo', $data);
        }

        public static function aspirantes_actualizar_masivo($pagina, $filtro_busqueda, $bandeja) {
            require_once(ROOT.'app/plugins/PHPOffice/vendor/autoload.php');
            $modulo_plataforma="1";
            Controller::checkSesion();
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $bandeja=checkInput(base64_decode($bandeja));
            
            $modulo_perfil=$_SESSION[APP_SESSION.'usu_modulos']['Selección'];

            $control_errores_detalle=array();
            $control_registro_detalle=array();

            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                $hva_estado=checkInput($_POST['hva_estado']);
                $enviar_notificacion=checkInput($_POST['enviar_notificacion']);
                // $documentos = $_POST['documentos'] ?? '';
                // $documentos=preg_split('/\r\n|\r|\n/', $documentos);

                $registro_parametro = new parametroModel();
                $registro_parametro->app_id = 'seleccion_notificacion_contratacion';
                $resregistro_parametro=$registro_parametro->listDetail();

                if (!isset($resregistro_parametro[0])) {
                    $resregistro_parametro=array();
                }


                if($_SESSION[APP_SESSION.'_actualizar_masivo_add']!=1) {
                    try {
                        $control_datos=false;
                        if ($_FILES['documento_masivo']['name']!="") {
                            $archivo_extension = checkInput(strtolower(pathinfo($_FILES['documento_masivo']['name'], PATHINFO_EXTENSION)));
                            $NombreArchivo=nowFile().".".$archivo_extension;
                            $ruta_actual=UPLOADS_ROOT."administrador/";
                            $ruta_final=$ruta_actual.$NombreArchivo;
                            
                            if ($_FILES['documento_masivo']["error"] > 0) {
                                $control_documento=0;
                            } else {
                            /*ahora co la funcion move_uploaded_file lo guardaremos en el destino que queramos*/
                                if (move_uploaded_file($_FILES['documento_masivo']['tmp_name'], $ruta_final)) {
                                    $control_documento=1;
                                } else {
                                    $control_documento=0;
                                }
                            }
                        } else {
                            $control_documento=0;
                        }
                    
                        if ($control_documento AND file_exists($ruta_final)) {
                            clearstatcache();

                            $documento = IOFactory::load($ruta_final);
                            $hojaActual = $documento->getSheet(0);
                            $numeroMayorDeFila = $hojaActual->getHighestRow();

                            $control_item=0;
                            $control_errores=0;
                            for ($indicefila = 2; $indicefila <= $numeroMayorDeFila; $indicefila++) {
                                $columna_a = $hojaActual->getCellByColumnAndRow(1, $indicefila)->getValue();
                                $columna_a=checkInput($columna_a);
                                $columna_b = $hojaActual->getCellByColumnAndRow(2, $indicefila)->getValue();
                                $array_data_base[$control_item]['documento_identidad']=$columna_a;//DOCUMENTO_IDENTIDAD
                                if ($hva_estado=='Vinculado' OR $hva_estado=='Retirado') {
                                    // Verificar si el valor de la columna B es una fecha
                                    if (\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($hojaActual->getCell('B' . $indicefila))) {
                                        // Convertir el valor a una fecha PHP
                                        $fecha = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($columna_b);
                                        // Mostrar la fecha
                                        // echo 'Fecha en la fila ' . $indicefila . ': ' . $fecha->format('Y-m-d') . "<br>";
                                        $array_data_base[$control_item]['fecha_ingreso']=$fecha->format('Y-m-d');//FECHA DE INGRESO O RETIRO
                                        $array_data_base_fechas[$columna_a]=$fecha->format('Y-m-d');//FECHA DE INGRESO O RETIRO
                                    } else {
                                        // echo 'Valor en la fila ' . $indicefila . ' no es una fecha: ' . $columna_b . "<br>";
                                        $control_errores++;
                                        $control_errores_detalle[]='Datos incompletos en fila: '.$indicefila;
                                    }
                                }

                                if ($hva_estado=='Retirado') {
                                    $columna_c = $hojaActual->getCellByColumnAndRow(3, $indicefila)->getValue();
                                    $columna_c=checkInput($columna_c);
                                    if ($columna_c!='') {
                                        $array_data_base_motivo[$columna_a]['motivo_retiro']=checkInput(strtoupper($columna_c));//MOTIVO RETIRO
                                    } else {
                                        // echo 'Valor en la fila ' . $indicefila . ' no es una fecha: ' . $columna_b . "<br>";
                                        $control_errores++;
                                        $control_errores_detalle[]='Datos incompletos en fila: '.$indicefila;
                                    }
                                }

                                $control_item++;
                            }

                            
                            for ($i=0; $i < count($array_data_base); $i++) { 
                                if ($array_data_base[$i]['documento_identidad']!='') {
                                    $documentos[]=$array_data_base[$i]['documento_identidad'];
                                } else {
                                    $control_errores++;
                                    $control_errores_detalle[]='Datos incompletos en fila: '.$i+1;
                                }
                            }

                            if ($control_errores==0) {
                                $control_datos=true;
                            }
                        } else {
                            Flasher::new('¡Problemas al cargar la plantilla, verifique e intente nuevamente!', 'warning');
                        }
                        
                        if ($control_datos) {
                            if (count($documentos)>0) {
                                $control_errores=0;
                                $control_insert=0;
                                $control_registrar=0;
                                
                                $aspirante = new hv_aspiranteModel();
                                $hojavida = new hv_aspiranteModel();
                                $ofertas = new hv_aspirante_ofertaModel();
                                $aspirante_emergencia = new hv_aspirante_emergenciaModel();
                                $usuario = new usuarioModel();
                                $contenido_vinculados='';
                                $contenido_desiste='';
                                for ($i = 0; $i <= count($documentos); $i++) {
                                    if ($documentos[$i]!='') {
                                        $control_actualizacion=false;
                                        $aspirante->hva_identificacion=$documentos[$i];
        
                                        $resaspirante=$aspirante->listDuplicado();
        
                                        if (!isset($resaspirante[0])) {
                                            $resaspirante=array();
                                        }
        
                                        if (count($resaspirante)>0) {
                                            $ofertas->hvao_aspirante=$resaspirante[0]['hva_id'];
                                            $resofertas=$ofertas->listLast();
        
                                            if (!isset($resofertas[0])) {
                                                $resofertas=array();
                                            }
                                            
                                            if (count($resofertas)>0 OR $hva_estado=='Retirado') {
                                                
                                                $ofertas->hvao_id=$resofertas[0]['hvao_id'];
                                                $ofertas->hvao_estado=$hva_estado;
                                                if ($hva_estado=='Vinculado') {
                                                    $hvao_check_contratacion='Aprobado';
                                                } elseif ($hva_estado=='No vinculado') {
                                                    $hvao_check_contratacion='Rechazado';
                                                } elseif ($hva_estado=='Desiste') {
                                                    $hvao_check_contratacion='Desiste';
                                                } elseif ($hva_estado=='Pendiente Fase 2') {
                                                    $hvao_check_contratacion='Pendiente';
                                                }
        
                                                $ofertas->hvao_check_contratacion=$hvao_check_contratacion;
                                                
                                                $aspirante_emergencia->hvaem_aspirante=$resaspirante[0]['hva_id'];
                                                $resaspirante_emergencia=$aspirante_emergencia->listDetail();
    
                                                if (!isset($resaspirante_emergencia[0])) {
                                                    $resaspirante_emergencia=array();
                                                }
    
                                                if ($hva_estado=='Vinculado') {
                                                    $control_actualizacion=true;
                                                } elseif ($hva_estado=='No vinculado')  {
                                                    if ($enviar_notificacion=='Si') {
                                                        $notificacion = new notificacionModel();
        
                                                        $boton_url='';
                                                        $boton_titulo='';
                                                        //PROGRAMACIÓN NOTIFICACIÓN 
                                                            $contenido="";
                                                        /*SE CONFIGURAN PARÁMETROS A REGISTRAR EN SISTEMA DE NOTIFICACIÓN*/
                                                        $notificacion->nc_id_modulo='5';
                                                        $notificacion->nc_address=$resaspirante[0]['hva_correo'].';';
                                                        $notificacion->nc_subject="Agradecemos tu participación en el proceso de selección iQ";
                                                        $notificacion->nc_body=notificacion_general($contenido, $boton_titulo, $boton_url);
                                                        $notificacion->nc_embeddedimage_ruta="".BASEPATH_IMAGE."logo/logo_notificacion_nocontinua.png";
                                                        $notificacion->nc_embeddedimage_nombre="logo_notificacion";
                                                        $notificacion->nc_embeddedimage_tipo="image/png;image/png";
                                                        $notificacion->nc_usuario_registro=checkInput($_SESSION[APP_SESSION.'usu_id']);
                                                        $resnotificacion=$notificacion->add();
                                                        
                                                        if ($resnotificacion) {
                                                            $control_actualizacion=true;
                                                        } else {
                                                            $control_errores_detalle[]='Problemas al programar notificación del aspirante con documento: '.$documentos[$i];
                                                        }
                                                    } else {
                                                        $control_actualizacion=true;
                                                    }
                                                } elseif ($hva_estado=='Pendiente Fase 2') {
                                                    $ofertas->hvao_estado='Revisado';
                                                    $ofertas->hvao_debida_diligencia='Pendiente';
                                                    $ofertas->hvao_prueba_confiabilidad='Pendiente';
                                                    $ofertas->hvao_examen_medico='Pendiente';
                                                    $ofertas->hvao_check_contratacion='Pendiente';
                                                    $ofertas->hvao_revisa_usuario=checkInput($_SESSION[APP_SESSION.'usu_id']);
                                                    $ofertas->hvao_revisa_fecha=now();
                                                    $ofertas->hvao_estado_fase_2='Enviar';
                                                    $ofertas->hvao_auxiliar_1='';
                                                    $ofertas->hvao_auxiliar_2='';
    
                                                    $resupdate = $ofertas->updateOferta();
                                                    
                                                    if ($resupdate) {
                                                        $token = new tokenModel();
                                                        $token->aut_usuario='HVR'.$resofertas[0]['hvao_id'];
                                                        $token->aut_token=newToken();
                                                        $token->aut_estado='Generado';
                                                        $token->aut_expira=date("Y-m-d H:i:s", strtotime("+ 90 day", strtotime(now())));
                                                        $res_insert_token = $token->add();
                                                        
                                                        if ($res_insert_token) {
                                                            $notificacion = new notificacionModel();
    
                                                            $boton_url=URL."seleccion-vinculacion/formulario-documentos-f2/".base64_encode($token->aut_usuario)."/".base64_encode($token->aut_token);
                                                            $boton_titulo='Da clic aquí para ingresar';
                                                            //PROGRAMACIÓN NOTIFICACIÓN 
                                                                $contenido="<p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Para continuar con tu proceso de selección, te invitamos a cargar con la mayor celeridad los documentos complementarios de tu hoja de vida, ingresando al siguiente link:</p>
                                                                <center>
                                                                    <a href='".$boton_url."' target='_blank' style='border-radius:4px; color:#ffffff; font-size:12px; padding: 5px 5px 5px 5px; text-align:center; text-decoration:none !important; width:50%; display: block; background-color: ".COLOR_PRINCIPAL."'>".$boton_titulo."</a>
                                                                </center>";
                                                            /*SE CONFIGURAN PARÁMETROS A REGISTRAR EN SISTEMA DE NOTIFICACIÓN*/
                                                            $notificacion->nc_id_modulo='5';
                                                            $notificacion->nc_address=$resaspirante[0]['hva_correo'].';';
                                                            $notificacion->nc_subject="Continuar proceso de selección iQ Outsourcing";
                                                            $notificacion->nc_body=notificacion_general($contenido, $boton_titulo, $boton_url);
                                                            $notificacion->nc_embeddedimage_ruta="".BASEPATH_IMAGE."logo/firma-verde.png;".BASEPATH_IMAGE."logo/logo_notificacion.png";
                                                            $notificacion->nc_embeddedimage_nombre="firma-verde;logo_notificacion";
                                                            $notificacion->nc_embeddedimage_tipo="image/png;image/png";
                                                            $notificacion->nc_usuario_registro=checkInput($_SESSION[APP_SESSION.'usu_id']);
                                                            $resnotificacion=$notificacion->add();
                                                            
                                                            if ($resnotificacion) {
                                                                $ofertas->hvao_estado_fase_2='Enviado';
                                                                $resupdate = $ofertas->updateOfertaEstado();
                                                                $control_actualizacion=true;
                                                            } else {
                                                                $control_errores_detalle[]='Problemas al programar notificación del aspirante con documento: '.$documentos[$i];
                                                            }
                                                        } else {
                                                            Flasher::new('¡Problemas al crear la notificación, verifique e intente nuevamente!', 'warning');
                                                        }
                                                    } else {
                                                        Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                                                    }
                                                } elseif ($hva_estado=='Retirado')  {
                                                    $usuario->usu_documento=$resaspirante[0]['hva_identificacion'];
                                                    $usuario->usu_estado='Retirado';
                                                    $usuario->usu_actualiza_fecha=now();
    
                                                    $resusuario_duplicado=$usuario->listDuplicadoCC();
    
                                                    if (!isset($resusuario_duplicado[0])) {
                                                        $resusuario_duplicado=array();
                                                    }
    
                                                    if (count($resusuario_duplicado)==0) {
                                                        $control_errores_detalle[]='Usuario no encontrado con documento: '.$documentos[$i];
                                                        $resupdate_usuario=true;
                                                    } else {
                                                        $usuario->usu_id=$resusuario_duplicado[0]['usu_id'];
                                                        $resupdate_usuario = $usuario->updateStatus();
                                                    }

                                                    if ($resupdate_usuario) {
                                                        $control_actualizacion=true;
                                                        // echo "Ingreso a actualizar usuario";

                                                        $aspirante_hoja_vida = new hv_personalModel();
                                                
                                                        $aspirante_hoja_vida->hvp_aspirante_id=$resaspirante[0]['hva_id'];
                                                        $aspirante_hoja_vida->hvp_estado='Retirado';
                                                        $aspirante_hoja_vida->hvp_retiro_fecha=$array_data_base_fechas[$documentos[$i]];
                                                        $aspirante_hoja_vida->hvp_retiro_motivo=$array_data_base_motivo[$documentos[$i]]['motivo_retiro'];
                                                        $aspirante_hoja_vida->hvp_actualiza_fecha=now();
                                                        $res_update_retiro=$aspirante_hoja_vida->updateRetiro();

                                                    } else {
                                                        $control_errores_detalle[]='Problemas al actualizar el usuario con documento: '.$documentos[$i];
                                                    }
                                                } else {
                                                    $control_actualizacion=true;
                                                }
    
                                                if ($control_actualizacion) {
                                                    if ($hva_estado=='Retirado') {
                                                        $resupdate_oferta = true;                                                    
                                                    } else {
                                                        $resupdate_oferta = $ofertas->updateOfertaMasivo();
                                                    }
                                                
                                                    if ($resupdate_oferta) {
                                                        $aspirante->hva_id=$resaspirante[0]['hva_id'];
                                                        $aspirante->hva_estado=$hva_estado;
                                                        $aspirante->hva_ingreso_fecha=$array_data_base_fechas[$documentos[$i]];
                                                        $aspirante->hva_retiro_fecha=$array_data_base_fechas[$documentos[$i]];
                                                        $aspirante->hva_retiro_motivo=$array_data_base_motivo[$documentos[$i]]['motivo_retiro'];
                                                        $aspirante->hva_actualiza_fecha=now();

                                                        if ($hva_estado=='Vinculado') {
                                                            $resupdate_aspirante = $aspirante->updateEstadoIngreso();
                                                        } elseif ($hva_estado=='Retirado') {
                                                            $resupdate_aspirante = $aspirante->updateEstadoRetiro();
                                                        } else {
                                                            $resupdate_aspirante = $aspirante->updateEstado();
                                                        }
                    
                                                        if ($resupdate_aspirante) {
                                                            $control_insert++;
                                                            $contenido_vinculados.='<tr>
                                                                <td>'.$resaspirante[0]['hva_identificacion'].'</td>
                                                                <td>'.$resaspirante[0]['hva_nombres'].' '.$resaspirante[0]['hva_nombres_2'].' '.$resaspirante[0]['hva_apellido_1'].' '.$resaspirante[0]['hva_apellido_2'].'</td>
                                                                <td>'.$array_data_base_fechas[$documentos[$i]].'</td>
                                                                <td>'.$resaspirante[0]['aa_nombre'].'</td>
                                                                <td>'.$resaspirante[0]['usuario_director'].'</td>
                                                            </tr>';

                                                            $contenido_desiste.='<tr>
                                                                <td>'.$resaspirante[0]['hva_identificacion'].'</td>
                                                                <td>'.$resaspirante[0]['hva_nombres'].' '.$resaspirante[0]['hva_nombres_2'].' '.$resaspirante[0]['hva_apellido_1'].' '.$resaspirante[0]['hva_apellido_2'].'</td>
                                                                <td>'.$resaspirante[0]['aa_nombre'].'</td>
                                                                <td>'.$resaspirante[0]['usuario_director'].'</td>
                                                            </tr>';

                                                        } else {
                                                            $control_errores++;
                                                            $control_errores_detalle[]='Problemas al actualizar el aspirante con documento: '.$documentos[$i];
                                                        }
                                                    } else {
                                                        $control_errores++;
                                                        $control_errores_detalle[]='Problemas al actualizar la oferta para el documento: '.$documentos[$i];
                                                    }
                                                }
                                            } else {
                                                $control_errores++;
                                                $control_errores_detalle[]='Oferta no encontrada para el documento: '.$documentos[$i];
                                            }
                                        } else {
                                            $control_errores++;
                                            $control_errores_detalle[]='Aspirante no encontrado para el documento: '.$documentos[$i];
                                        }
                                        $control_registrar++;
                                    }
                                }
    
                                if (($control_insert+$control_errores)==$control_registrar) {
                                    Flasher::new('¡Registros actualizados exitosamente!', 'success');
                                    $_SESSION[APP_SESSION.'_actualizar_masivo_add']=1;

                                    //programar notificación para gestión de usuarios en vinculación
                                    if ($hva_estado=='Vinculado') {
                                        $notificacion = new notificacionModel();
                                
                                        $boton_url=URL;
                                        $boton_titulo='Da clic aquí para ingresar';
                                        //PROGRAMACIÓN NOTIFICACIÓN 
                                            $contenido="<p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Cordial saludo,</p>
                                            <p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>A continuación se relacionan los usuarios nuevos vinculados en el proceso de selección:</p>
                                            <center>
                                                <table>
                                                    <tr>
                                                        <td style='font-size: 12px;padding: 3px 5px 3px 5px; margin-bottom: 3px; color: #FFFFFF; background-color: ".COLOR_PRINCIPAL."; border: solid 1px #FFFFFF; border-radius: 5px;'>Identificación</td>
                                                        <td style='font-size: 12px;padding: 3px 5px 3px 5px; margin-bottom: 3px; color: #FFFFFF; background-color: ".COLOR_PRINCIPAL."; border: solid 1px #FFFFFF; border-radius: 5px;'>Nombres y Apellidos</td>
                                                        <td style='font-size: 12px;padding: 3px 5px 3px 5px; margin-bottom: 3px; color: #FFFFFF; background-color: ".COLOR_PRINCIPAL."; border: solid 1px #FFFFFF; border-radius: 5px;'>Fecha Ingreso</td>
                                                        <td style='font-size: 12px;padding: 3px 5px 3px 5px; margin-bottom: 3px; color: #FFFFFF; background-color: ".COLOR_PRINCIPAL."; border: solid 1px #FFFFFF; border-radius: 5px;'>Área</td>
                                                        <td style='font-size: 12px;padding: 3px 5px 3px 5px; margin-bottom: 3px; color: #FFFFFF; background-color: ".COLOR_PRINCIPAL."; border: solid 1px #FFFFFF; border-radius: 5px;'>Director</td>
                                                    </tr>
                                                    ".$contenido_vinculados."
                                                </table>
                                                <br>
                                                <br>
                                                <a href='".$boton_url."' target='_blank' style='border-radius:4px; color:#ffffff; font-size:12px; padding: 5px 5px 5px 5px; text-align:center; text-decoration:none !important; width:50%; display: block; background-color: ".COLOR_PRINCIPAL."'>".$boton_titulo."</a>
                                            </center>";
                                        /*SE CONFIGURAN PARÁMETROS A REGISTRAR EN SISTEMA DE NOTIFICACIÓN*/
                                        $notificacion->nc_id_modulo='8';
                                        $notificacion->nc_address=$resregistro_parametro[0]['app_descripcion'].';';
                                        $notificacion->nc_subject="Vinculaciones a Vive iQ";
                                        $notificacion->nc_body=notificacion_general($contenido, $boton_titulo, $boton_url);
                                        $notificacion->nc_embeddedimage_ruta="".BASEPATH_IMAGE."logo/firma-verde.png;".BASEPATH_IMAGE."logo/logo.png";
                                        $notificacion->nc_embeddedimage_nombre="firma-verde;logo_notificacion";
                                        $notificacion->nc_embeddedimage_tipo="image/png;image/png";
                                        $notificacion->nc_usuario_registro=checkInput($_SESSION[APP_SESSION.'usu_id']);
                                        $resnotificacion=$notificacion->add();
                                    }

                                    //programar notificación para gestión de usuarios en vinculación
                                    if ($hva_estado=='Desiste') {
                                        $notificacion = new notificacionModel();
                                
                                        $boton_url=URL;
                                        $boton_titulo='Da clic aquí para ingresar';
                                        //PROGRAMACIÓN NOTIFICACIÓN 
                                            $contenido="<p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Cordial saludo,</p>
                                            <p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>A continuación se relacionan los usuarios que desistieron del proceso de selección:</p>
                                            <center>
                                                <table>
                                                    <tr>
                                                        <td style='font-size: 12px;padding: 3px 5px 3px 5px; margin-bottom: 3px; color: #FFFFFF; background-color: ".COLOR_PRINCIPAL."; border: solid 1px #FFFFFF; border-radius: 5px;'>Identificación</td>
                                                        <td style='font-size: 12px;padding: 3px 5px 3px 5px; margin-bottom: 3px; color: #FFFFFF; background-color: ".COLOR_PRINCIPAL."; border: solid 1px #FFFFFF; border-radius: 5px;'>Nombres y Apellidos</td>
                                                        <td style='font-size: 12px;padding: 3px 5px 3px 5px; margin-bottom: 3px; color: #FFFFFF; background-color: ".COLOR_PRINCIPAL."; border: solid 1px #FFFFFF; border-radius: 5px;'>Área</td>
                                                        <td style='font-size: 12px;padding: 3px 5px 3px 5px; margin-bottom: 3px; color: #FFFFFF; background-color: ".COLOR_PRINCIPAL."; border: solid 1px #FFFFFF; border-radius: 5px;'>Director</td>
                                                    </tr>
                                                    ".$contenido_desiste."
                                                </table>
                                                <br>
                                                <br>
                                                <a href='".$boton_url."' target='_blank' style='border-radius:4px; color:#ffffff; font-size:12px; padding: 5px 5px 5px 5px; text-align:center; text-decoration:none !important; width:50%; display: block; background-color: ".COLOR_PRINCIPAL."'>".$boton_titulo."</a>
                                            </center>";
                                        /*SE CONFIGURAN PARÁMETROS A REGISTRAR EN SISTEMA DE NOTIFICACIÓN*/
                                        $notificacion->nc_id_modulo='8';
                                        $notificacion->nc_address=$resregistro_parametro[0]['app_descripcion'].';';
                                        $notificacion->nc_subject="Desisten de Vive iQ";
                                        $notificacion->nc_body=notificacion_general($contenido, $boton_titulo, $boton_url);
                                        $notificacion->nc_embeddedimage_ruta="".BASEPATH_IMAGE."logo/firma-verde.png;".BASEPATH_IMAGE."logo/logo.png";
                                        $notificacion->nc_embeddedimage_nombre="firma-verde;logo_notificacion";
                                        $notificacion->nc_embeddedimage_tipo="image/png;image/png";
                                        $notificacion->nc_usuario_registro=checkInput($_SESSION[APP_SESSION.'usu_id']);
                                        $resnotificacion=$notificacion->add();
                                    }
                                } else {
                                    Flasher::new('¡Problemas al actualizar los registros, verifique e intente nuevamente #1!', 'warning');
                                }
                            } else {
                                Flasher::new('¡Problemas al actualizar los registros, verifique e intente nuevamente#2!', 'warning');
                            }
                        } else {
                            Flasher::new('¡Problemas al cargar la plantilla, verifique e intente nuevamente!', 'warning');
                        }
                    } catch (Exception $e) {
                        Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                    }
                } else {
                    Flasher::new('¡Registro creado exitosamente!', 'success');
                }
            }

            $data =
            [
                'titulo_pagina' => 'SELECCIÓN|ASPIRANTES|ACTUALIZAR MASIVO',
                'path' => 'seleccion-vinculacion/aspirantes-actualizar-masivo/',
                'path_add' => '/'.base64_encode($bandeja),
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'bandeja' => base64_encode($bandeja),
                'resultado_registros_errores' => $control_errores_detalle,
                'resultado_registros_creados' => $control_registro_detalle,
                'modulo_perfil' => $modulo_perfil,

            ];
            
            View::render('aspirantes_actualizar_masivo', $data);
        }

        public static function aspirantes_correo_masivo($pagina, $filtro_busqueda, $bandeja) {
            require_once(ROOT.'app/plugins/PHPOffice/vendor/autoload.php');
            
            $modulo_plataforma="1";
            Controller::checkSesion();
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $bandeja=checkInput(base64_decode($bandeja));
            // ini_set('display_errors', '1');
            // error_reporting(E_ALL);
            $aspirante_hoja_vida = new hv_personalModel();
            $usuario = new usuarioModel();

            $control_errores_detalle=array();
            $control_registro_detalle=array();
            $array_resultado_update=array();
            $array_data_base=array();

            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                $hva_observaciones=checkInput($_POST['hva_observaciones']);
 
                try {
                    if($_SESSION[APP_SESSION.'_correo_masivo_add']!=1) {
                        if ($_FILES['documento_masivo']['name']!="") {
                            $archivo_extension = checkInput(strtolower(pathinfo($_FILES['documento_masivo']['name'], PATHINFO_EXTENSION)));
                            $NombreArchivo=nowFile().".".$archivo_extension;
                            $ruta_actual=UPLOADS_ROOT."administrador/";
                            $ruta_final=$ruta_actual.$NombreArchivo;
                            
                            if ($_FILES['documento_masivo']["error"] > 0) {
                                $control_documento=0;
                            } else {
                            /*ahora co la funcion move_uploaded_file lo guardaremos en el destino que queramos*/
                                if (move_uploaded_file($_FILES['documento_masivo']['tmp_name'], $ruta_final)) {
                                    $control_documento=1;
                                } else {
                                    $control_documento=0;
                                }
                            }
                        } else {
                            $control_documento=0;
                        }
                    
                        if ($control_documento AND file_exists($ruta_final)) {
                            clearstatcache();

                            $documento = IOFactory::load($ruta_final);
                            $hojaActual = $documento->getSheet(0);
                            $numeroMayorDeFila = $hojaActual->getHighestRow();

                            $control_item=0;
                            for ($indicefila = 2; $indicefila <= $numeroMayorDeFila; $indicefila++) {
                                $columna_a = $hojaActual->getCellByColumnAndRow(1, $indicefila)->getValue();
                                $columna_b = $hojaActual->getCellByColumnAndRow(2, $indicefila)->getValue();
                                $columna_c = $hojaActual->getCellByColumnAndRow(3, $indicefila)->getValue();
                                
                                if ($columna_a!='' AND $columna_b!='' AND $columna_c!='') {
                                    $array_data_base[$control_item]['documento_identidad']=checkInput($columna_a);//DOCUMENTO_IDENTIDAD
                                    $array_data_base[$control_item]['correo']=checkInput($columna_b);//CORREO CORPORATIVA
                                    $array_data_base[$control_item]['usuario_nt']=checkInput($columna_c);//USUARIO NT
                                }

                                $control_item++;
                            }

                            
                            for ($i=0; $i < count($array_data_base); $i++) { 
                                if ($array_data_base[$i]['documento_identidad']!='' AND $array_data_base[$i]['correo']!='' AND $array_data_base[$i]['usuario_nt']!='') {
                                    
                                } else {
                                    $control_errores++;
                                    $control_errores_detalle[]='Datos incompletos en fila: '.$i+1;
                                }
                            }

                            if (count($control_errores_detalle)==0) {
                                $control_errores=0;
                                $control_insert=0;
                                $control_registrar=0;
                            
                                for ($i=0; $i < count($array_data_base); $i++) { 
                                    if ($array_data_base[$i]['documento_identidad']!='' OR $array_data_base[$i]['correo']!='' OR $array_data_base[$i]['usuario_nt']!='') {
                                        $control_registrar++;
                                        $documento_identidad=$array_data_base[$i]['documento_identidad'];
                                        $array_resultado_update[$documento_identidad]['datos']='';
                                        if ($array_data_base[$i]['documento_identidad']!='' AND $array_data_base[$i]['correo']!='' AND $array_data_base[$i]['usuario_nt']!='') {
                                            $correo_corporativo=strtolower($array_data_base[$i]['correo']);
                                            $usuario_nt=$array_data_base[$i]['usuario_nt'];
                                            $array_resultado_update[$documento_identidad]['datos']='Validado';
                                            $array_resultado_update[$documento_identidad]['aspirante']='';
                                            $array_resultado_update[$documento_identidad]['usuario']='';
                                            $array_resultado_update[$documento_identidad]['hoja_vida']='';
                                            $array_resultado_update[$documento_identidad]['correo']='';
                                            $array_resultado_update[$documento_identidad]['nt']='';

                                            $aspirante = new hv_aspiranteModel();
                                            $aspirante->hva_identificacion=$documento_identidad;
                                            $resaspirante=$aspirante->listDuplicado();

                                            if (!isset($resaspirante[0])) {
                                                $resaspirante=array();
                                            }
                                            
                                            // $ofertas = new hv_aspirante_ofertaModel();
                                            // $ofertas->hvao_id=$id_oferta;
                                            // $resofertas=$ofertas->listDetail();

                                            // if (!isset($resofertas[0])) {
                                            //     $resofertas=array();
                                            // }

                                            // echo "<pre>";
                                            // print_r($resaspirante);
                                            // echo "</pre>";

                                            $aspirante_emergencia = new hv_aspirante_emergenciaModel();
                                            $aspirante_emergencia->hvaem_aspirante=$resaspirante[0]['hva_id'];
                                            $resaspirante_emergencia=$aspirante_emergencia->listDetail();

                                            if (!isset($resaspirante_emergencia[0])) {
                                                $resaspirante_emergencia=array();
                                            }

                                            // Valida Información Financiera
                                            $aspirante_financiera = new hv_aspirante_financieraModel();
                                            $aspirante_financiera->hvaf_aspirante=$resaspirante[0]['hva_id'];
                                            $resaspirante_financiera=$aspirante_financiera->listDetail();

                                            if (!isset($resaspirante_financiera[0])) {
                                                $resaspirante_financiera=array();
                                            }

                                            $aspirante_autorizaciones = new hv_aspirante_autorizacionesModel();
                                            $aspirante_autorizaciones->hvada_aspirante=$resaspirante[0]['hva_id'];
                                            $resaspirante_tratamiento_datos=$aspirante_autorizaciones->listDetailFormulario();

                                            if (!isset($resaspirante_tratamiento_datos[0])) {
                                                $resaspirante_tratamiento_datos=array();
                                            }
                                            
                                            
                                            if (count($resaspirante)>0) {
                                                $array_resultado_update[$documento_identidad]['aspirante']='Encontrado';
                                                // echo "ingreso aspirante";
                                                $usuario->usu_documento=$resaspirante[0]['hva_identificacion'];
                                                $usuario->usu_acceso=$resaspirante[0]['hva_identificacion'];

                                                $nueva_contrasena=newPassword(10);
                                                $salt = substr(base64_encode(openssl_random_pseudo_bytes('30')), 0, 22);
                                                $salt = strtr($salt, array('+' => '.'));

                                                $usuario->usu_contrasena=crypt($nueva_contrasena, '$2y$10$' . $salt);

                                                $usuario->usu_nombres_apellidos=$resaspirante[0]['hva_nombres'].' '.$resaspirante[0]['hva_nombres_2'].' '.$resaspirante[0]['hva_apellido_1'].' '.$resaspirante[0]['hva_apellido_2'];
                                                $usuario->usu_correo=$resaspirante[0]['hva_correo'];
                                                $usuario->usu_correo_corporativo=$correo_corporativo;
                                                $usuario->usu_fecha_incorporacion=date('Y-m-d');
                                                $usuario->usu_area='';
                                                $usuario->usu_cargo='';
                                                $usuario->usu_jefe_inmediato='';
                                                $usuario->usu_ciudad=$resaspirante[0]['hva_ciudad'];
                                                $usuario->usu_estado='Activo';
                                                $usuario->usu_inicio_sesion='0';
                                                $usuario->usu_avatar='avatar/avatar.jpg';
                                                $usuario->usu_genero='';
                                                $usuario->usu_fecha_nacimiento=$resaspirante[0]['hva_nacimiento_fecha'];
                                                $usuario->usu_perfil='Ciudadano iQ';
                                                $usuario->usu_aspirante_id=$resaspirante[0]['hva_id'];
                                                $usuario->usu_actualiza_fecha='';
                                                $usuario->usu_actualiza_login='';
                                                $usuario->usu_registro_usuario=checkInput($_SESSION[APP_SESSION.'usu_id']);

                                                $resusuario_duplicado=$usuario->listDuplicadoCC();

                                                if (!isset($resusuario_duplicado[0])) {
                                                    $resusuario_duplicado=array();
                                                }

                                                // $resusuario_duplicado_id=$usuario->listDuplicadoId();

                                                // if (!isset($resusuario_duplicado_id[0])) {
                                                //     $resusuario_duplicado_id=array();
                                                // }

                                                if (count($resusuario_duplicado)==0) {
                                                    $array_resultado_update[$documento_identidad]['usuario']='Creado';
                                                    // echo "duplicado=0";
                                                    $resinsert_usuario = $usuario->add();
                                                } else {
                                                    if (count($resusuario_duplicado)>0) {
                                                        // echo "duplicado=1";
                                                        $array_resultado_update[$documento_identidad]['usuario']='Encontrado';
                                                        $resinsert_usuario = $resusuario_duplicado[0]['usu_id'];
                                                    } else {
                                                        $resinsert_usuario='';
                                                        $array_resultado_update[$documento_identidad]['usuario']='Error';
                                                    }
                                                }

                                                if ($resinsert_usuario!='') {
                                                    $usuario->usu_id=$resinsert_usuario;

                                                    $aspirante_hoja_vida = new hv_personalModel();
                                                    
                                                    $aspirante_hoja_vida->hvp_usuario_id=$usuario->usu_id;
                                                    $aspirante_hoja_vida->hvp_aspirante_id=$resaspirante[0]['hva_id'];
                                                    $aspirante_hoja_vida->hvp_centro_costo=$resaspirante[0]['hvao_area'];
                                                    $aspirante_hoja_vida->hvp_cargo=$resaspirante[0]['hvao_cargo'];
                                                    $aspirante_hoja_vida->hvp_consentimiento_tratamiento_datos_personales='';
                                                    $aspirante_hoja_vida->hvp_consentimiento_tratamiento_datos_personales_fecha=$resaspirante_tratamiento_datos[0]['hvada_registro_fecha'];
                                                    $aspirante_hoja_vida->hvp_datos_personales_tipo_documento='';
                                                    $aspirante_hoja_vida->hvp_datos_personales_numero_identificacion=$resaspirante[0]['hva_identificacion'];
                                                    $aspirante_hoja_vida->hvp_datos_personales_apellido_1=$resaspirante[0]['hva_apellido_1'];
                                                    $aspirante_hoja_vida->hvp_datos_personales_apellido_2=$resaspirante[0]['hva_apellido_2'];
                                                    $aspirante_hoja_vida->hvp_datos_personales_nombre_1=$resaspirante[0]['hva_nombres'];
                                                    $aspirante_hoja_vida->hvp_datos_personales_nombre_2=$resaspirante[0]['hva_nombres_2'];
                                                    $aspirante_hoja_vida->hvp_demografia_genero=$resaspirante[0]['hva_genero'];
                                                    $aspirante_hoja_vida->hvp_demografia_estado_civil=$resaspirante[0]['hva_estado_civil'];
                                                    $aspirante_hoja_vida->hvp_demografia_lugar_nacimiento=$resaspirante[0]['hva_nacimiento_lugar'];
                                                    $aspirante_hoja_vida->hvp_demografia_fecha_nacimiento=$resaspirante[0]['hva_nacimiento_fecha'];
                                                    $aspirante_hoja_vida->hvp_demografia_edad='';
                                                    
                                                    $aspirante_hoja_vida->hvp_ubicacion_direccion_residencia='';
                                                    $aspirante_hoja_vida->hvp_ubicacion_ciudad_residencia='';
                                                    $aspirante_hoja_vida->hvp_ubicacion_localidad_comuna='';
                                                    $aspirante_hoja_vida->hvp_ubicacion_barrio='';
                                                    $aspirante_hoja_vida->hvp_ubicacion_maps_latitud='';
                                                    $aspirante_hoja_vida->hvp_ubicacion_maps_longitud='';
                                                    $aspirante_hoja_vida->hvp_ubicacion_maps_ciudad='';
                                                    $aspirante_hoja_vida->hvp_ubicacion_maps_departamento='';
                                                    $aspirante_hoja_vida->hvp_ubicacion_maps_pais='';
                                                    $aspirante_hoja_vida->hvp_ubicacion_maps_localidad='';
                                                    $aspirante_hoja_vida->hvp_ubicacion_maps_barrio='';
                                                    $aspirante_hoja_vida->hvp_ubicacion_maps_codigo_postal='';
                                                    $aspirante_hoja_vida->hvp_ubicacion_maps_direccion='';
                                                    $aspirante_hoja_vida->hvp_socioeconomico_estrato_socioeconomico='';
                                                    $aspirante_hoja_vida->hvp_socioeconomico_operador_internet='';
                                                    $aspirante_hoja_vida->hvp_socioeconomico_operador_internet_otro='';
                                                    $aspirante_hoja_vida->hvp_socioeconomico_velocidad_internet_descarga='';
                                                    $aspirante_hoja_vida->hvp_socioeconomico_velocidad_internet_carga='';
                                                    $aspirante_hoja_vida->hvp_socioeconomico_caracteristicas_vivienda='';
                                                    $aspirante_hoja_vida->hvp_socioeconomico_condiciones_vivienda='';
                                                    $aspirante_hoja_vida->hvp_socioeconomico_estado_terminacion_vivienda='';
                                                    $aspirante_hoja_vida->hvp_socioeconomico_servicios_vivienda='';
                                                    $aspirante_hoja_vida->hvp_socioeconomico_plan_compra_vivienda='';
                                                    $aspirante_hoja_vida->hvp_socioeconomico_beneficiario_subsidio_vivienda='';
                                                    $aspirante_hoja_vida->hvp_contacto_numero_celular=$resaspirante[0]['hva_celular'];
                                                    $aspirante_hoja_vida->hvp_contacto_correo_personal=$resaspirante[0]['hva_correo'];
                                                    $aspirante_hoja_vida->hvp_contacto_correo_corporativo=$correo_corporativo;
                                                    $aspirante_hoja_vida->hvp_contacto_emergencia_nombres=$resaspirante_emergencia[0]['hvaem_nombres_apellidos'];
                                                    $aspirante_hoja_vida->hvp_contacto_emergencia_apellidos='';
                                                    $aspirante_hoja_vida->hvp_contacto_emergencia_parentesco=$resaspirante_emergencia[0]['hvaem_parentesco'];
                                                    $aspirante_hoja_vida->hvp_contacto_emergencia_celular=$resaspirante_emergencia[0]['hvaem_telefono'];
                                                    $aspirante_hoja_vida->hvp_contacto_emergencia_nombres_2='';
                                                    $aspirante_hoja_vida->hvp_contacto_emergencia_apellidos_2='';
                                                    $aspirante_hoja_vida->hvp_contacto_emergencia_parentesco_2='';
                                                    $aspirante_hoja_vida->hvp_contacto_emergencia_celular_2='';
                                                    $aspirante_hoja_vida->hvp_salud_bienestar_grupo_sanguineo='';
                                                    $aspirante_hoja_vida->hvp_salud_bienestar_rh='';
                                                    $aspirante_hoja_vida->hvp_salud_bienestar_actividad_fisica_minima='';
                                                    $aspirante_hoja_vida->hvp_salud_bienestar_fumador='';
                                                    $aspirante_hoja_vida->hvp_salud_bienestar_pausas_activas='';
                                                    $aspirante_hoja_vida->hvp_salud_bienestar_medicina_prepagada='';
                                                    $aspirante_hoja_vida->hvp_salud_bienestar_medicina_prepagada_cual='';
                                                    $aspirante_hoja_vida->hvp_salud_bienestar_plan_complementario_salud='';
                                                    $aspirante_hoja_vida->hvp_salud_bienestar_plan_complementario_salud_cual='';
                                                    $aspirante_hoja_vida->hvp_familia_numero_hijos='';
                                                    $aspirante_hoja_vida->hvp_familia_hijos_menor_3='';
                                                    $aspirante_hoja_vida->hvp_familia_hijos_4_10='';
                                                    $aspirante_hoja_vida->hvp_familia_hijos_11_17='';
                                                    $aspirante_hoja_vida->hvp_familia_hijos_mayor_18='';
                                                    $aspirante_hoja_vida->hvp_familia_capacitacion_familia='';
                                                    $aspirante_hoja_vida->hvp_expectativa_motivacion_motivacion_trabajo='';
                                                    $aspirante_hoja_vida->hvp_expectativa_antiguedad='';
                                                    $aspirante_hoja_vida->hvp_expectativa_motivacion_expectativa_desarrollo='';
                                                    $aspirante_hoja_vida->hvp_expectativa_motivacion_expectativa_crecimiento_profesional='';
                                                    $aspirante_hoja_vida->hvp_expectativa_motivacion_realidad_crecimiento_profesional='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_hobbies_deportes='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_hobbies_deportes_frecuencia='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_hobbies_deportes_cual='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_hobbies_aire='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_hobbies_aire_frecuencia='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_hobbies_aire_cual='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_hobbies_arte='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_hobbies_arte_frecuencia='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_hobbies_arte_instrumento='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_hobbies_arte_cual='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_hobbies_tecnologia='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_hobbies_tecnologia_frecuencia='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_hobbies_tecnologia_cual='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_hobbies_otro='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_hobbies_otro_frecuencia='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_hobbies_otro_cual='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_hobbies_recibir_informacion='';

                                                    $aspirante_hoja_vida->hvp_interes_habitos_actividades_familia='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_actividades_deportivas='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_actividades_deportivas_cual='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_medio_transporte='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_habito_ahorro='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_mascotas='';
                                                    $aspirante_hoja_vida->hvp_interes_habitos_mascotas_cual='';
                                                    $aspirante_hoja_vida->hvp_formacion_nivel_academico_culminado='';
                                                    $aspirante_hoja_vida->hvp_formacion_ultimo_certificado_enviado_rrhh='';
                                                    $aspirante_hoja_vida->hvp_formacion_ultimo_estudio_realizado_titulo='';
                                                    $aspirante_hoja_vida->hvp_formacion_tarjeta_profesional='';
                                                    $aspirante_hoja_vida->hvp_formacion_estudios_curso='';
                                                    $aspirante_hoja_vida->hvp_formacion_estudios_curso_titulo='';
                                                    $aspirante_hoja_vida->hvp_formacion_estudios_curso_nivel='';
                                                    $aspirante_hoja_vida->hvp_formacion_estudios_curso_establecimiento='';
                                                    $aspirante_hoja_vida->hvp_habilidades_nivel_ingles='';
                                                    $aspirante_hoja_vida->hvp_habilidades_nivel_excel='';
                                                    $aspirante_hoja_vida->hvp_habilidades_nivel_google_ws='';
                                                    $aspirante_hoja_vida->hvp_poblaciones_poblacion='';
                                                    $aspirante_hoja_vida->hvp_poblaciones_certificado='';
                                                    $aspirante_hoja_vida->hvp_poblaciones_poblacion_soporte='';
                                                    $aspirante_hoja_vida->hvp_poblaciones_familiares_iq='';
                                                    $aspirante_hoja_vida->hvp_poblaciones_familiares_iq_identificacion='';
                                                    $aspirante_hoja_vida->hvp_poblaciones_familiares_iq_nombres_apellidos='';
                                                    $aspirante_hoja_vida->hvp_poblaciones_familiares_iq_ingreso_marzo_2022='';
                                                    $aspirante_hoja_vida->hvp_financiero_activos=$resaspirante_financiera[0]['hvaf_activos'];
                                                    $aspirante_hoja_vida->hvp_financiero_ingresos=$resaspirante_financiera[0]['hvaf_pasivos'];
                                                    $aspirante_hoja_vida->hvp_financiero_pasivos=$resaspirante_financiera[0]['hvaf_patrimonio'];
                                                    $aspirante_hoja_vida->hvp_financiero_egresos=$resaspirante_financiera[0]['hvaf_ingresos'];
                                                    $aspirante_hoja_vida->hvp_financiero_patrimonio=$resaspirante_financiera[0]['hvaf_egresos'];
                                                    $aspirante_hoja_vida->hvp_financiero_ingresos_otros=$resaspirante_financiera[0]['hvaf_ingresos_otros'];
                                                    $aspirante_hoja_vida->hvp_financiero_concepto_ingresos=$resaspirante_financiera[0]['hvaf_concepto_ingresos'];
                                                    $aspirante_hoja_vida->hvp_financiero_moneda_extranjera=$resaspirante_financiera[0]['hvaf_moneda_extranjera'];
                                                    $aspirante_hoja_vida->hvp_origen_fondos='';
                                                    $aspirante_hoja_vida->hvp_pep_recursos='';
                                                    $aspirante_hoja_vida->hvp_pep_reconocimiento='';
                                                    $aspirante_hoja_vida->hvp_pep_poder='';
                                                    $aspirante_hoja_vida->hvp_pep_familiar='';
                                                    $aspirante_hoja_vida->hvp_pep_cedula='';
                                                    $aspirante_hoja_vida->hvp_pep_nombres_apellidos='';
                                                    $aspirante_hoja_vida->hvp_veracidad='';
                                                    $aspirante_hoja_vida->hvp_alerta_actualizacion='';
                                                    $aspirante_hoja_vida->hvp_estado='Activo';
                                                    $aspirante_hoja_vida->hvp_fecha_ingreso=$resaspirante[0]['hva_ingreso_fecha'];
                                                    $aspirante_hoja_vida->hvp_retiro_fecha='';
                                                    $aspirante_hoja_vida->hvp_retiro_motivo='';
                                                    $aspirante_hoja_vida->hvp_auxiliar_1='';
                                                    $aspirante_hoja_vida->hvp_auxiliar_2='';
                                                    $aspirante_hoja_vida->hvp_auxiliar_3='';
                                                    $aspirante_hoja_vida->hvp_auxiliar_4='';
                                                    $aspirante_hoja_vida->hvp_auxiliar_5='';
                                                    $aspirante_hoja_vida->hvp_usuario_nt=$usuario_nt;
                                                    $aspirante_hoja_vida->hvp_observaciones='';
                                                    $aspirante_hoja_vida->hvp_actualiza_usuario='';
                                                    $aspirante_hoja_vida->hvp_actualiza_fecha='';
                                                    $aspirante_hoja_vida->hvp_registro_usuario=checkInput($_SESSION[APP_SESSION.'usu_id']);

                                                    $resaspirante_duplicado=$aspirante_hoja_vida->listDuplicate();

                                                    $aspirante_hoja_vida->hvp_id=$resaspirante_duplicado[0]['hvp_id'];

                                                    if (!isset($resaspirante_duplicado[0])) {
                                                        $resaspirante_duplicado=array();
                                                    }

                                                    if (count($resaspirante_duplicado)==0) {
                                                        $resinsert_aspirante=$aspirante_hoja_vida->add();
                                                        $array_resultado_update[$documento_identidad]['hoja_vida']='Creado';
                                                        $array_resultado_update[$documento_identidad]['nt']='Actualizado';
                                                        
                                                    } else {
                                                        $resinsert_aspirante=true;
                                                        $aspirante_hoja_vida->updateCorreoCorporativo();
                                                        $aspirante_hoja_vida->updateInformacionReingreso();
                                                        // $control_errores++;
                                                        // $control_errores_detalle[]='Problemas al crear hoja de vida, ya existe registro para el usuario: '.$documento_identidad;
                                                        $array_resultado_update[$documento_identidad]['hoja_vida']='Encontrado';
                                                        $array_resultado_update[$documento_identidad]['nt']='Actualizado';
                                                    }

                                                    if ($resinsert_aspirante) {
                                                        $aspirante->hva_id=$resaspirante[0]['hva_id'];
                                                        $aspirante->hva_correo_corporativo=$correo_corporativo;
                                                        $aspirante->updateCorreoCorporativo();

                                                        $array_resultado_update[$documento_identidad]['correo']='Actualizado';

                                                        $passhistorial = new passwordModel();
                                                        $passhistorial->auc_usuario = $usuario->usu_id;
                                                        $passhistorial->auc_contrasena = $usuario->usu_contrasena;
                                                        $passhistorial->add();

                                                        $usuariomodulo = new usuariomoduloModel();
                                                        $usuariomodulo->aum_id='U'.$usuario->usu_id.'-M8';
                                                        $usuariomodulo->aum_usuario=$usuario->usu_id;
                                                        $usuariomodulo->aum_modulo='8';
                                                        $usuariomodulo->aum_perfil='Usuario';
                                                        $resinsertModulo = $usuariomodulo->addUpdate();

                                                        if ($resinsertModulo OR true) {
                                                            $notificacion = new notificacionModel();
                            
                                                            $boton_url=URL;
                                                            $boton_titulo='Da clic aquí para ingresar';
                                                            //PROGRAMACIÓN NOTIFICACIÓN 
                                                                $contenido="<p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>¡Bienvenido!</p>
                                                                <p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Ya eres un ciudadano iQ</p>
                                                                <p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Te asignamos un usuario y contraseña para que ingreses a Vive iQ, nuestra plataforma corporativa. Allí deberás tener al día tu información sociodemográfica.</p>
                                                                <center>
                                                                    <table>
                                                                        <tr>
                                                                            <td style='font-size: 12px;padding: 3px 5px 3px 5px; margin-bottom: 3px; color: #FFFFFF; background-color: ".COLOR_PRINCIPAL."; border: solid 1px #FFFFFF; border-radius: 5px;'>Usuario</td>
                                                                            <td style='font-size: 12px;padding: 3px 5px 3px 5px; margin-bottom: 3px; color: #666666; background-color: #f2f2f2; border: solid 1px #FFFFFF; border-radius: 5px;'>".$usuario->usu_acceso."</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style='font-size: 12px;padding: 3px 5px 3px 5px; margin-bottom: 3px; color: #FFFFFF; background-color: ".COLOR_PRINCIPAL."; border: solid 1px #FFFFFF; border-radius: 5px;'>Contraseña</td>
                                                                            <td style='font-size: 12px;padding: 3px 5px 3px 5px; margin-bottom: 3px; color: #666666; background-color: #f2f2f2; border: solid 1px #FFFFFF; border-radius: 5px;'>".$nueva_contrasena."</td>
                                                                        </tr>
                                                                    </table>
                                                                    <br>
                                                                    <br>
                                                                    <a href='".$boton_url."' target='_blank' style='border-radius:4px; color:#ffffff; font-size:12px; padding: 5px 5px 5px 5px; text-align:center; text-decoration:none !important; width:50%; display: block; background-color: ".COLOR_PRINCIPAL."'>".$boton_titulo."</a>
                                                                </center>";
                                                            /*SE CONFIGURAN PARÁMETROS A REGISTRAR EN SISTEMA DE NOTIFICACIÓN*/
                                                            $notificacion->nc_id_modulo='8';
                                                            $notificacion->nc_address=$correo_corporativo.';';
                                                            $notificacion->nc_subject="Bienvenido a Vive iQ";
                                                            $notificacion->nc_body=notificacion_general($contenido, $boton_titulo, $boton_url);
                                                            $notificacion->nc_embeddedimage_ruta="".BASEPATH_IMAGE."logo/firma-verde.png;".BASEPATH_IMAGE."logo/logo_notificacion_bienvenida.jpg";
                                                            $notificacion->nc_embeddedimage_nombre="firma-verde;logo_notificacion";
                                                            $notificacion->nc_embeddedimage_tipo="image/png;image/png";
                                                            $notificacion->nc_usuario_registro=checkInput($_SESSION[APP_SESSION.'usu_id']);
                                                            $resnotificacion=$notificacion->add();

                                                            if ($resnotificacion) {
                                                                $control_insert++;
                                                                $control_registro_detalle[]='Correo corporativo actualizado exitosamente para el usuario: '.$documento_identidad;
                                                            } else {
                                                                $control_errores++;
                                                                $control_errores_detalle[]='Problemas al programar notificación para el usuario: '.$documento_identidad;
                                                            }
                                                        } else {
                                                            $control_errores++;
                                                            $control_errores_detalle[]='Problemas al configurar permisos para el usuario: '.$documento_identidad;
                                                        }
                                                    } else {
                                                        $control_errores++;
                                                        $control_errores_detalle[]='Problemas al crear hoja de vida para el usuario: '.$documento_identidad;
                                                        $array_resultado_update[$documento_identidad]['hoja_vida']='Error';
                                                    }
                                                } else {
                                                    $control_errores++;
                                                    $control_errores_detalle[]='Problemas al crear credenciales, ya existe registro para el usuario: '.$documento_identidad;
                                                }
                                            } else {
                                                $control_errores++;
                                                $control_errores_detalle[]='Aspirante no encontrado para el documento: '.$documento_identidad;
                                                $array_resultado_update[$documento_identidad]['aspirante']='No encontrado';
                                            }
                                        } else {
                                            $control_errores++;
                                            $control_errores_detalle[]='Datos incompletos en fila: '.$i+1;
                                            $array_resultado_update[$documento_identidad]['datos']='Error';
                                        }
                                    } else {
                                        break;
                                    }
                                }

                                if (($control_insert+$control_errores)==$control_registrar) {
                                    Flasher::new('¡Registros actualizados exitosamente!', 'success');
                                    $_SESSION[APP_SESSION.'_correo_masivo_add']=1;
                                }
                            } else {
                                Flasher::new('¡Problemas al cargar la plantilla, verifique e intente nuevamente #1!', 'warning');
                            }
                        } else {
                            Flasher::new('¡Problemas al cargar la plantilla, verifique e intente nuevamente #2!', 'warning');
                        }
                    } else {
                        Flasher::new('¡Registro creado exitosamente!', 'success');
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }

            $data =
            [
                'titulo_pagina' => 'SELECCIÓN|ASPIRANTES|ACTUALIZAR CORREO MASIVO',
                'path' => 'seleccion-vinculacion/aspirantes-actualizar-masivo/',
                'path_add' => '/'.base64_encode($bandeja),
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'bandeja' => base64_encode($bandeja),
                'resultado_registros_errores' => $control_errores_detalle,
                'resultado_registros_creados' => $control_registro_detalle,
                'resultado_registros_update' => $array_resultado_update,
                'resultado_registros_base' => $array_data_base,
                'modulo_perfil' => $modulo_perfil,

            ];
            
            View::render('aspirantes_actualizar_correo_masivo', $data);
        }

        public static function aspirantes_crear($pagina, $filtro_busqueda, $bandeja) {
            $modulo_plataforma="1";
            Controller::checkSesion();
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $bandeja=checkInput(base64_decode($bandeja));
            // ini_set('display_errors', '1');
            // error_reporting(E_ALL);

            $area_lista = new areaModel();
            $resarea_lista = $area_lista->listActive();

            if (!isset($resarea_lista[0])) {
                $resarea_lista=array();
            }

            $cargo = new cargoModel();
            $rescargo=$cargo->listActive();

            if (!isset($rescargo[0])) {
                $rescargo=array();
            }

            $usuarios = new usuarioModel();
            $respsicologo=$usuarios->listPsicologo();

            if (!isset($respsicologo[0])) {
                $respsicologo=array();
            }

            $resusuarios=$usuarios->listActive();

            if (!isset($resusuarios[0])) {
                $resusuarios=array();
            }

            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                $hva_identificacion=checkInput($_POST['hva_identificacion']);
                $hva_nombres=checkInput($_POST['hva_nombres']);
                $hva_nombres_2=checkInput($_POST['hva_nombres_2']);
                $hva_apellido_1=checkInput($_POST['hva_apellido_1']);
                $hva_apellido_2=checkInput($_POST['hva_apellido_2']);
                $hva_correo=checkInput(strtolower($_POST['hva_correo']));
                $hva_estado=checkInput($_POST['hva_estado']);
                $hva_area=checkInput($_POST['hva_area']);
                $hva_cargo=checkInput($_POST['hva_cargo']);
                $hva_psicologo=checkInput($_POST['hva_psicologo']);
                $hva_director=checkInput($_POST['hva_director']);
                $hva_observaciones=checkInput($_POST['hva_observaciones']);
 
                try {
                    if($_SESSION[APP_SESSION.'_proceso_add']!=1) {
                        $aspirante = new hv_aspiranteModel();
                        $aspirante->hva_identificacion=$hva_identificacion;

                        $resaspirante=$aspirante->listDuplicado();

                        if (!isset($resaspirante[0])) {
                            $resaspirante=array();
                        }
                        
                        $aspirante->hva_nombres=$hva_nombres;
                        $aspirante->hva_nombres_2=$hva_nombres_2;
                        $aspirante->hva_apellido_1=$hva_apellido_1;
                        $aspirante->hva_apellido_2=$hva_apellido_2;
                        $aspirante->hva_direccion='';
                        $aspirante->hva_barrio='';
                        $aspirante->hva_ciudad='';
                        $aspirante->hva_celular='';
                        $aspirante->hva_celular_2='';
                        $aspirante->hva_correo=$hva_correo;
                        $aspirante->hva_correo_corporativo='';
                        $aspirante->hva_nacimiento_lugar='';
                        $aspirante->hva_nacimiento_fecha='';
                        $aspirante->hva_operador_internet='';
                        $aspirante->hva_genero='';
                        $aspirante->hva_estado_civil='';
                        $aspirante->hva_estado=$hva_estado;
                        $aspirante->hva_localidad='';
                        $aspirante->hva_primer_empleo='';
                        $aspirante->hva_auxiliar_1='';
                        $aspirante->hva_auxiliar_2='';
                        $aspirante->hva_auxiliar_3='';
                        $aspirante->hva_auxiliar_4='';
                        $aspirante->hva_auxiliar_5='';
                        $aspirante->hva_ingreso_fecha='';
                        $aspirante->hva_retiro_fecha='';
                        $aspirante->hva_retiro_motivo='';
                        $aspirante->hva_observaciones=$hva_observaciones;
                        $aspirante->hva_oferta_id='';
                        $aspirante->hva_autorizaciones_id='';
                        $aspirante->hva_emergencia_id='';
                        $aspirante->hva_etica_id='';
                        $aspirante->hva_financiera_id='';
                        $aspirante->hva_informacion_id='';
                        $aspirante->hva_publico_id='';
                        $aspirante->hva_seguridad_social_id='';
                        $aspirante->hva_actualiza_usuario='';
                        $aspirante->hva_actualiza_fecha='';
                        $aspirante->hva_registro_usuario=checkInput($_SESSION[APP_SESSION.'usu_id']);
                        
                        if (count($resaspirante)==0) {
                            $resinsert = $aspirante->add();
                            $hva_id=$resinsert;
                        } else {
                            $aspirante->hva_id=$resaspirante[0]['hva_id'];
                            $resinsert = $aspirante->updateAspirante();
                            $hva_id=$resaspirante[0]['hva_id'];
                        }

                        if ($resinsert) {
                            $oferta = new hv_aspirante_ofertaModel();
                            $oferta->hvao_aspirante=$hva_id;
                            $oferta->hvao_area=$hva_area;
                            $oferta->hvao_cargo=$hva_cargo;
                            $oferta->hvao_salario='';
                            $oferta->hvao_psicologo=$hva_psicologo;
                            $oferta->hvao_director=$hva_director;
                            $oferta->hvao_horario='';
                            $oferta->hvao_debida_diligencia='Pendiente';
                            $oferta->hvao_prueba_confiabilidad='Pendiente';
                            $oferta->hvao_examen_medico='Pendiente';
                            $oferta->hvao_check_contratacion='Pendiente';
                            $oferta->hvao_fecha_diligencia='';
                            $oferta->hvao_firma_ruta='';
                            $oferta->hvao_estado='Pendiente';
                            $oferta->hvao_revisa_usuario='';
                            $oferta->hvao_revisa_fecha='';
                            $oferta->hvao_estado_fase_2='';
                            $oferta->hvao_auxiliar_1='';
                            $oferta->hvao_auxiliar_2='';
                            $oferta->hvao_registro_usuario=checkInput($_SESSION[APP_SESSION.'usu_id']);
                            $resinsertoferta = $oferta->add();
                            
                            $token = new tokenModel();
                            $token->aut_usuario='HV'.$resinsertoferta;
                            $token->aut_token=newToken();
                            $token->aut_estado='Generado';
                            $token->aut_expira=date("Y-m-d H:i:s", strtotime("+ 90 day", strtotime(now())));
                            $res_insert_token = $token->add();
                            
                            if ($resinsertoferta AND $res_insert_token) {
                                
                                $aspirante->hva_id=$hva_id;
                                $aspirante->hva_oferta_id=$resinsertoferta;
                                $resupdate_oferta=$aspirante->updateIdOferta();

                                $notificacion = new notificacionModel();

                                $boton_url=URL."seleccion-vinculacion/formulario-instrucciones/".base64_encode($token->aut_usuario)."/".base64_encode($token->aut_token);
                                $boton_titulo='Da clic aquí para ingresar';
                                //PROGRAMACIÓN NOTIFICACIÓN 
                                    $contenido="<p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Para oficializar tu proceso de selección, te invitamos a diligenciar con la mayor celeridad los datos de tu hoja de vida, ingresando al siguiente link:</p>
                                    <center>
                                        <a href='".$boton_url."' target='_blank' style='border-radius:4px; color:#ffffff; font-size:12px; padding: 5px 5px 5px 5px; text-align:center; text-decoration:none !important; width:50%; display: block; background-color: ".COLOR_PRINCIPAL."'>".$boton_titulo."</a>
                                    </center>";
                                /*SE CONFIGURAN PARÁMETROS A REGISTRAR EN SISTEMA DE NOTIFICACIÓN*/
                                $notificacion->nc_id_modulo=$modulo_plataforma;
                                $notificacion->nc_address=$hva_correo.';';
                                $notificacion->nc_subject="Bienvenid@ al proceso de selección iQ Outsourcing";
                                $notificacion->nc_body=notificacion_general($contenido, $boton_titulo, $boton_url);
                                $notificacion->nc_embeddedimage_ruta="".BASEPATH_IMAGE."logo/firma-verde.png;".BASEPATH_IMAGE."logo/logo_notificacion.png";
                                $notificacion->nc_embeddedimage_nombre="firma-verde;logo_notificacion";
                                $notificacion->nc_embeddedimage_tipo="image/png;image/png";
                                $notificacion->nc_usuario_registro=checkInput($_SESSION[APP_SESSION.'usu_id']);
                                $resnotificacion=$notificacion->add();
                                
                                if ($resnotificacion) {
                                    Flasher::new('¡Registro creado exitosamente!', 'success');
                                    $_SESSION[APP_SESSION.'_proceso_add']=1;
                                } else {
                                    Flasher::new('¡Problemas al crear el registro, verifique e intente nuevamente!', 'warning');
                                }
                            } else {
                                Flasher::new('¡Problemas al crear el registro, verifique e intente nuevamente!', 'warning');
                            }
                        } else {
                            Flasher::new('¡Problemas al crear el registro, verifique e intente nuevamente!', 'warning');
                        }
                    } else {
                        Flasher::new('¡Registro creado exitosamente!', 'success');
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }

            $data =
            [
                'titulo_pagina' => 'SELECCIÓN|ASPIRANTES|CREAR',
                'path' => 'seleccion-vinculacion/aspirantes-crear/',
                'path_add' => '/'.base64_encode($bandeja),
                'resultado_registros' => to_object($res),
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'resultado_registros_area_lista' => to_object($resarea_lista),
                'resultado_registros_cargo' => to_object($rescargo),
                'resultado_registros_psicologo' => to_object($respsicologo),
                'resultado_registros_usuarios' => to_object($resusuarios),
                'bandeja' => base64_encode($bandeja),

            ];
            
            View::render('aspirantes_crear', $data);
        }

        public static function aspirantes_eliminar($pagina, $filtro_busqueda, $bandeja, $id_registro) {
            $modulo_plataforma="1";
            Controller::checkSesion();
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $bandeja=checkInput(base64_decode($bandeja));
            $id_registro=checkInput(base64_decode($id_registro));
            // ini_set('display_errors', '1');
            // error_reporting(E_ALL);

            $aspirante = new hv_aspiranteModel();
            $aspirante->hva_id=$id_registro;
            $resaspirante=$aspirante->listDetail();

            if (!isset($resaspirante[0])) {
                $resaspirante=array();
            }

            $area_lista = new areaModel();
            $resarea_lista = $area_lista->listActive();

            if (!isset($resarea_lista[0])) {
                $resarea_lista=array();
            }

            $cargo = new cargoModel();
            $rescargo=$cargo->listActive();

            if (!isset($rescargo[0])) {
                $rescargo=array();
            }

            $psicologo = new usuarioModel();
            $respsicologo=$psicologo->listPsicologo();

            if (!isset($respsicologo[0])) {
                $respsicologo=array();
            }

            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                
                try {
                    if($_SESSION[APP_SESSION.'_aspirante_del']!=1) {
                        
                        $resdelete_aspirante=$aspirante->delete();
                        
                        if ($resdelete_aspirante) {
                            $oferta = new hv_aspirante_ofertaModel();
                            $oferta->hvao_aspirante=$id_registro;
                            $resdelete_oferta = $oferta->delete();

                            // Valida Información en caso de Emergencia
                            $aspirante_emergencia = new hv_aspirante_emergenciaModel();
                            $aspirante_emergencia->hvaem_aspirante=$id_registro;
                            $reseliminar_emergencia=$aspirante_emergencia->deleteAll();

                            // Valida Información familiar
                            $aspirante_familiar = new hv_aspirante_familiarModel();
                            $aspirante_familiar->hvaf_aspirante=$id_registro;
                            $reseliminar_familiar=$aspirante_familiar->deleteAll();

                            // Valida Estudios Culminados
                            $aspirante_estudio_culminado = new hv_aspirante_estudio_terminadoModel();
                            $aspirante_estudio_culminado->hvaet_aspirante=$id_registro;
                            $reseliminar_estudio_culminado=$aspirante_estudio_culminado->deleteAll();

                            // Valida Estudios Curso
                            $aspirante_estudio_curso = new hv_aspirante_estudio_cursoModel();
                            $aspirante_estudio_curso->hvaec_aspirante=$id_registro;
                            $reseliminar_estudio_curso=$aspirante_estudio_curso->deleteAll();

                            // Valida Experiencia Laboral
                            $aspirante_experiencia = new hv_aspirante_experienciaModel();
                            $aspirante_experiencia->hvaex_aspirante=$id_registro;
                            $reseliminar_experiencia=$aspirante_experiencia->deleteAll();

                            // Valida Información Ética
                            $aspirante_etica = new hv_aspirante_eticaModel();
                            $aspirante_etica->hvae_aspirante=$id_registro;
                            $reseliminar_etica=$aspirante_etica->deleteAll();

                            // Valida Información IQ
                            $aspirante_informacion = new hv_aspirante_informacionModel();
                            $aspirante_informacion->hvai_aspirante=$id_registro;
                            $reseliminar_informacion=$aspirante_informacion->deleteAll();

                            // Valida Información Financiera
                            $aspirante_financiera = new hv_aspirante_financieraModel();
                            $aspirante_financiera->hvaf_aspirante=$id_registro;
                            $reseliminar_financiera=$aspirante_financiera->deleteAll();

                            // Valida Personas Expuestas Públicamente - PEP
                            $aspirante_publico = new hv_aspirante_publicoModel();
                            $aspirante_publico->hvap_aspirante=$id_registro;
                            $reseliminar_publico=$aspirante_publico->deleteAll();

                            // Valida Seguridad Social
                            $aspirante_segsocial = new hv_aspirante_seguridad_socialModel();
                            $aspirante_segsocial->hvass_aspirante=$id_registro;
                            $reseliminar_segsocial=$aspirante_segsocial->deleteAll();

                            // Valida Declaraciones y Autorizaciones
                            $aspirante_autorizaciones = new hv_aspirante_autorizacionesModel();
                            $aspirante_autorizaciones->hvada_aspirante=$id_registro;
                            $reseliminar_autorizaciones=$aspirante_autorizaciones->deleteAll();

                            // Valida Autorización Tratamiento Datos Personales
                            $aspirante_tratamiento_datos = new hv_aspirante_autorizacionesModel();
                            $aspirante_tratamiento_datos->hvada_aspirante=$id_registro;
                            $reseliminar_tratamiento_datos=$aspirante_tratamiento_datos->deleteAll();

                            // Valida Documentos
                            $aspirante_documentos = new hv_aspirante_documentoModel();
                            $aspirante_documentos->hvad_aspirante=$id_registro;
                            $reseliminar_documentos=$aspirante_documentos->deleteAll();
                            
                            if ($resdelete_oferta) {
                                Flasher::new('¡Registro eliminado exitosamente!', 'success');
                                $_SESSION[APP_SESSION.'_aspirante_del']=1;
                                $log = new logModel();
                                $log->clog_log_modulo='Login';
                                $log->clog_user_agent=checkInput($_SERVER['HTTP_USER_AGENT']);
                                $log->clog_remote_addr=checkInput($_SERVER['REMOTE_ADDR']);
                                $log->clog_script=checkInput($_SERVER['PHP_SELF']);
                                $log->clog_registro_usuario=$_SESSION[APP_SESSION.'usu_id'];
                                $log->clog_log_tipo='eliminar';
                                $log->clog_log_accion='Eliminar aspirante';
                                $log->clog_log_detalle='Eliminación de información del aspirante '.$resaspirante[0]['hva_identificacion'].' - '.$resaspirante[0]['hva_nombres'].' '.$resaspirante[0]['hva_apellido_1'].' '.$resaspirante[0]['hva_apellido_2'];
                                $log->add();
                            } else {
                                Flasher::new('¡Problemas al eliminar el registro, verifique e intente nuevamente!', 'warning');
                            }
                        } else {
                            Flasher::new('¡Problemas al eliminar el registro, verifique e intente nuevamente!', 'warning');
                        }
                    } else {
                        Flasher::new('¡Registro eliminado exitosamente!', 'success');
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }

            $resaspirante=$aspirante->listDetail();

            if (!isset($resaspirante[0])) {
                $resaspirante=array();
            }

            $data =
            [
                'titulo_pagina' => 'SELECCIÓN|ASPIRANTES|ELIMINAR',
                'path' => 'seleccion-vinculacion/aspirantes-eliminar/',
                'path_add' => '/'.base64_encode($bandeja),
                'resultado_registros' => to_object($resaspirante),
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'bandeja' => base64_encode($bandeja),
                'resultado_registros_area_lista' => to_object($resarea_lista),
                'resultado_registros_cargo' => to_object($rescargo),
                'resultado_registros_psicologo' => to_object($respsicologo),
                'id_registro' => base64_encode($id_registro),

            ];
            
            View::render('aspirantes_eliminar', $data);
        }

        public static function aspirantes_editar($pagina, $filtro_busqueda, $bandeja, $id_registro) {
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $bandeja=checkInput(base64_decode($bandeja));
            $id_registro=checkInput(base64_decode($id_registro));
            // ini_set('display_errors', '1');
            // error_reporting(E_ALL);

            $aspirante = new hv_aspiranteModel();
            $aspirante->hva_id=$id_registro;
            $resaspirante=$aspirante->listDetail();

            if (!isset($resaspirante[0])) {
                $resaspirante=array();
            }

            $area_lista = new areaModel();
            $resarea_lista = $area_lista->listActive();

            if (!isset($resarea_lista[0])) {
                $resarea_lista=array();
            }

            $cargo = new cargoModel();
            $rescargo=$cargo->listActive();

            if (!isset($rescargo[0])) {
                $rescargo=array();
            }

            $psicologo = new usuarioModel();
            $respsicologo=$psicologo->listPsicologo();

            if (!isset($respsicologo[0])) {
                $respsicologo=array();
            }
            
            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                $hva_identificacion=checkInput($_POST['hva_identificacion']);
                $hva_nombres=checkInput($_POST['hva_nombres']);
                $hva_nombres_2=checkInput($_POST['hva_nombres_2']);
                $hva_apellido_1=checkInput($_POST['hva_apellido_1']);
                $hva_apellido_2=checkInput($_POST['hva_apellido_2']);
                $hva_correo=checkInput(strtolower($_POST['hva_correo']));
                $hva_observaciones=checkInput($_POST['hva_observaciones']);

                try {
                    $aspirante->hva_identificacion=$hva_identificacion;
                    $aspirante->hva_nombres=$hva_nombres;
                    $aspirante->hva_nombres_2=$hva_nombres_2;
                    $aspirante->hva_apellido_1=$hva_apellido_1;
                    $aspirante->hva_apellido_2=$hva_apellido_2;
                    $aspirante->hva_correo=$hva_correo;
                    $aspirante->hva_observaciones=$hva_observaciones;
                    $aspirante->hva_actualiza_usuario=checkInput($_SESSION[APP_SESSION.'usu_id']);
                    $aspirante->hva_actualiza_fecha=now();

                    $resupdate = $aspirante->update();
                    
                    if ($resupdate) {
                        Flasher::new('¡Registro editado exitosamente!', 'success');
                    } else {
                        Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }

            $resaspirante=$aspirante->listDetail();

            if (!isset($resaspirante[0])) {
                $resaspirante=array();
            }

            $data =
            [
                'titulo_pagina' => 'SELECCIÓN|ASPIRANTES|EDITAR',
                'path' => 'seleccion-vinculacion/aspirantes-editar/',
                'path_add' => '/'.base64_encode($bandeja),
                'resultado_registros' => to_object($resaspirante),
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'bandeja' => base64_encode($bandeja),
                'resultado_registros_area_lista' => to_object($resarea_lista),
                'resultado_registros_cargo' => to_object($rescargo),
                'resultado_registros_psicologo' => to_object($respsicologo),
                'id_registro' => base64_encode($id_registro),

            ];
            
            View::render('aspirantes_editar', $data);
        }

        public static function aspirantes_documentos_crear($pagina, $filtro_busqueda, $bandeja, $id_registro) {
            $modulo_plataforma="1";
            Controller::checkSesion();
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $bandeja=checkInput(base64_decode($bandeja));
            $id_registro=checkInput(base64_decode($id_registro));
            // ini_set('display_errors', '1');
            // error_reporting(E_ALL);

            $aspirante = new hv_aspiranteModel();
            $aspirante->hva_id=$id_registro;
            $resaspirante=$aspirante->listDetail();

            if (!isset($resaspirante[0])) {
                $resaspirante=array();
            }
            
            $aspirante_documentos = new hv_aspirante_documentoModel();
            $aspirante_documentos->hvad_aspirante=$id_registro;
            
            $array_documentos[]='lista_chequeo_ingreso';
            $array_documentos[]='informe_seleccion';
            $array_documentos[]='verificacion_referencias';
            $array_documentos[]='perfil_cargo';
            $array_documentos[]='prueba_psicotecnica';
            $array_documentos[]='prueba_conocimiento';
            $array_documentos[]='requisicion_personal';
            $array_documentos[]='carta_oferta';
            $array_documentos[]='certificacion_confiabilidad';
            $array_documentos[]='examen_medico';

            $array_documentos_nombre['lista_chequeo_ingreso']='Lista de chequeo para ingreso';
            $array_documentos_nombre['informe_seleccion']='Informe de selección';
            $array_documentos_nombre['verificacion_referencias']='Verificación de referencias';
            $array_documentos_nombre['perfil_cargo']='Perfil del Cargo y Descripción de Responsabilidades';
            $array_documentos_nombre['prueba_psicotecnica']='Pruebas psicotécnicas';
            $array_documentos_nombre['prueba_conocimiento']='Pruebas de conocimientos';
            $array_documentos_nombre['requisicion_personal']='Requisición de personal';
            $array_documentos_nombre['carta_oferta']='Carta Oferta firmada o carta de práctica';
            $array_documentos_nombre['certificacion_confiabilidad']='Certificación de confiabilidad (Debida diligencia y prueba de seguridad)';
            $array_documentos_nombre['examen_medico']='Exámen Médico';

            $array_resultado_carga=array();
            if(isset($_POST["form_guardar"])){
                try {
                    //obtiene variables de formulario
                    $ruta_guardar_general=ASSETS_ROOT."uploads/aspirante_documentos/".$id_registro."/";
                    if (!file_exists($ruta_guardar_general)) {
                        mkdir($ruta_guardar_general, 0777, true);
                    }
                    
                    $documento_control=0;
                    for ($i=0; $i < count($array_documentos); $i++) {
                        $tipo_documento=$array_documentos[$i];
                        $resaspirante_documentos=array();
                        if ($_FILES[$tipo_documento]['name']!="") {
                            $archivo_extension = checkInput(strtolower(pathinfo($_FILES[$tipo_documento]['name'], PATHINFO_EXTENSION)));
                            if ($archivo_extension=="pdf" OR $archivo_extension=="png" OR $archivo_extension=="jpg" OR $archivo_extension=="jpeg") {
                                if ($_FILES[$tipo_documento]['size']<=80000000) {
                                    $documento_NombreArchivo=$tipo_documento.'_'.nowFile().".".$archivo_extension;
                                    $documento_ruta_actual=$ruta_guardar_general;
                                    $documento_ruta_actual_guardar="aspirante_documentos/".$id_registro."/";
                                    $documento_ruta_final=$documento_ruta_actual.$documento_NombreArchivo;
                                    $documento_ruta_final_guardar=$documento_ruta_actual_guardar.$documento_NombreArchivo;
                                    if ($_FILES[$tipo_documento]["error"] > 0) {
                                        $documento_control++;
                                    } else {
                                        if (move_uploaded_file($_FILES[$tipo_documento]['tmp_name'], $documento_ruta_final)) {
                                            
                                        } else {
                                            $documento_control++;
                                        }
                                    }
                                } else {
                                    $documento_control++;
                                }
                            } else {
                                $documento_control++;
                            }
                        } else {
                            $documento_ruta_final_guardar='';
                            // $documento_control++;
                        }

                        $aspirante_documentos->hvad_tipo=$tipo_documento;
                        $aspirante_documentos->hvad_nombre=$array_documentos_nombre[$tipo_documento];
                        $aspirante_documentos->hvad_ruta=$documento_ruta_final_guardar;
                        $aspirante_documentos->hvad_extension=$archivo_extension;
                        $aspirante_documentos->hvad_registro_usuario='';
                        $aspirante_documentos->hvad_registro_fecha=now();

                        if ($documento_control==0) {
                            if ($_FILES[$tipo_documento]['name']!="") {
                                $resaspirante_documentos=$aspirante_documentos->listDetailFormularioDuplicado();
        
                                if (!isset($resaspirante_documentos[0])) {
                                    $resaspirante_documentos=array();
                                }
        
                                if (count($resaspirante_documentos)>0) {
                                    $resinsert_documento = $aspirante_documentos->updateRegistro();
                                } else {
                                    $resinsert_documento = $aspirante_documentos->add();
                                }
                                
                                if ($resinsert_documento) {
                                    $array_resultado_carga[$tipo_documento]='¡Registro editado exitosamente!';
                                } else {
                                    $array_resultado_carga[$tipo_documento]='¡Problemas al editar el registro, verifique e intente nuevamente!';
                                }
                            }
                        } else {
                            $array_resultado_carga[$tipo_documento]='¡Problemas al editar el registro, verifique e intente nuevamente!';
                        }
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }

            $resaspirante_documentos=$aspirante_documentos->listDetail();

            if (!isset($resaspirante_documentos[0])) {
                $resaspirante_documentos=array();
            }

            $data =
            [
                'titulo_pagina' => 'SELECCIÓN|ASPIRANTES|OFERTAS|DOCUMENTOS|CARGAR',
                'path' => 'seleccion-vinculacion/aspirantes-documentos-crear/',
                'path_add' => '/'.base64_encode($bandeja),
                'resultado_registros' => to_object($resaspirante),
                'resultado_registros_documentos' => to_object($resaspirante_documentos),
                'pag_inicio' => $pag_inicio,
                'pag_fin' => $pag_fin,
                'pag_total' => $pag_total,
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'bandeja' => base64_encode($bandeja),
                'id_registro' => base64_encode($id_registro),
                'array_documentos' => $array_documentos,
                'array_documentos_nombre' => $array_documentos_nombre,

            ];
            
            View::render('aspirantes_ofertas_documentos_cargar', $data);
        }

        public static function aspirantes_ofertas($pagina, $filtro_busqueda, $bandeja, $id_registro) {
            $modulo_plataforma="1";
            Controller::checkSesion();
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $bandeja=checkInput(base64_decode($bandeja));
            $id_registro=checkInput(base64_decode($id_registro));
            // ini_set('display_errors', '1');
            // error_reporting(E_ALL);
            unset($_SESSION[APP_SESSION.'_vinculado_add']);
            unset($_SESSION[APP_SESSION.'_proceso_reenviar_add']);

            $aspirante = new hv_aspiranteModel();
            $aspirante->hva_id=$id_registro;
            $resaspirante=$aspirante->listDetail();

            if (!isset($resaspirante[0])) {
                $resaspirante=array();
            }
            
            $ofertas = new hv_aspirante_ofertaModel();
            $ofertas->hvao_aspirante=$id_registro;
            $resofertas=$ofertas->list();

            if (!isset($resofertas[0])) {
                $resofertas=array();
            }

            $aspirante_documentos = new hv_aspirante_documentoModel();
            $aspirante_documentos->hvad_aspirante=$id_registro;
            
            $resaspirante_documentos=$aspirante_documentos->listDetail();

            if (!isset($resaspirante_documentos[0])) {
                $resaspirante_documentos=array();
            }

            $data =
            [
                'titulo_pagina' => 'SELECCIÓN|ASPIRANTES|OFERTAS',
                'path' => 'seleccion-vinculacion/aspirantes-ofertas/',
                'path_add' => '/'.base64_encode($bandeja),
                'resultado_registros' => to_object($resaspirante),
                'resultado_registros_documentos' => to_object($resaspirante_documentos),
                'resultado_registros_ofertas' => to_object($resofertas),
                'resultado_registros_ofertas_count' => count($resofertas),
                'pag_inicio' => $pag_inicio,
                'pag_fin' => $pag_fin,
                'pag_total' => $pag_total,
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'bandeja' => base64_encode($bandeja),
                'id_registro' => base64_encode($id_registro),

            ];
            
            View::render('aspirantes_ofertas', $data);
        }

        public static function aspirantes_duplicado() {
            Controller::checkSesion();
            $id_aspirante = checkInput($_POST["id_aspirante"]);
            if($id_aspirante!=""){
                try {
                    $aspirante = new hv_aspiranteModel();
                    $aspirante->hva_identificacion=$id_aspirante;
                    $resaspirante=$aspirante->listDuplicado();

                    if (!isset($resaspirante[0])) {
                        $resaspirante=array();
                    }
                    
                    if (count($resaspirante)>0) {
                        $resultado_valor=true;
                        $resultado['hva_identificacion']=$resaspirante[0]['hva_identificacion'];
                        $resultado['hva_nombres']=$resaspirante[0]['hva_nombres'];
                        $resultado['hva_nombres_2']=$resaspirante[0]['hva_nombres_2'];
                        $resultado['hva_apellido_1']=$resaspirante[0]['hva_apellido_1'];
                        $resultado['hva_apellido_2']=$resaspirante[0]['hva_apellido_2'];
                        $resultado['hva_correo']=$resaspirante[0]['hva_correo'];
                    } else {
                        $resultado_valor=false;
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }
          
            $data = array(
                "resultado" => $resultado,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function aspirantes_ofertas_editar($pagina, $filtro_busqueda, $bandeja, $id_registro, $id_oferta) {
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $bandeja=checkInput(base64_decode($bandeja));
            $id_registro=checkInput(base64_decode($id_registro));
            $id_oferta=checkInput(base64_decode($id_oferta));
            // ini_set('display_errors', '1');
            // error_reporting(E_ALL);

            $aspirante = new hv_aspiranteModel();
            $aspirante->hva_id=$id_registro;
            $resaspirante=$aspirante->listDetail();

            if (!isset($resaspirante[0])) {
                $resaspirante=array();
            }
            
            $ofertas = new hv_aspirante_ofertaModel();
            $ofertas->hvao_id=$id_oferta;
            $resofertas=$ofertas->listDetail();

            if (!isset($resofertas[0])) {
                $resofertas=array();
            }

            $aspirante_documentos = new hv_aspirante_documentoModel();
            $aspirante_documentos->hvad_aspirante=$id_registro;
            
            $resaspirante_documentos=$aspirante_documentos->listDetail();

            if (!isset($resaspirante_documentos[0])) {
                $resaspirante_documentos=array();
            }

            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                $hvao_debida_diligencia=checkInput($_POST['hvao_debida_diligencia']);
                $hvao_prueba_confiabilidad=checkInput($_POST['hvao_prueba_confiabilidad']);
                $hvao_examen_medico=checkInput($_POST['hvao_examen_medico']);
                $hvao_check_contratacion=checkInput($_POST['hvao_check_contratacion']);
                $hvao_estado_fase_2=checkInput($_POST['hvao_estado_fase_2']);

                try {
                    $ofertas->hvao_estado='Revisado';
                    $ofertas->hvao_debida_diligencia=$hvao_debida_diligencia;
                    $ofertas->hvao_prueba_confiabilidad=$hvao_prueba_confiabilidad;
                    $ofertas->hvao_examen_medico=$hvao_examen_medico;
                    $ofertas->hvao_check_contratacion=$hvao_check_contratacion;
                    $ofertas->hvao_revisa_usuario=checkInput($_SESSION[APP_SESSION.'usu_id']);
                    $ofertas->hvao_revisa_fecha=now();
                    $ofertas->hvao_estado_fase_2=$hvao_estado_fase_2;
                    $ofertas->hvao_auxiliar_1='';
                    $ofertas->hvao_auxiliar_2='';

                    $resupdate = $ofertas->updateOferta();
                    
                    if ($resupdate) {
                        if ($hvao_debida_diligencia=='Aprobado' AND $hvao_prueba_confiabilidad=='Aprobado' AND $hvao_examen_medico=='Aprobado' AND $hvao_check_contratacion=='Aprobado' AND $hvao_estado_fase_2=='Enviar') {
                            $token = new tokenModel();
                            $token->aut_usuario='HVR'.$id_oferta;
                            $token->aut_token=newToken();
                            $token->aut_estado='Generado';
                            $token->aut_expira=date("Y-m-d H:i:s", strtotime("+ 90 day", strtotime(now())));
                            $res_insert_token = $token->add();
                            
                            if ($res_insert_token) {
                                $notificacion = new notificacionModel();

                                $boton_url=URL."seleccion-vinculacion/formulario-documentos-f2/".base64_encode($token->aut_usuario)."/".base64_encode($token->aut_token);
                                $boton_titulo='Da clic aquí para ingresar';
                                //PROGRAMACIÓN NOTIFICACIÓN 
                                    $contenido="<p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Para continuar con tu proceso de selección, te invitamos a cargar con la mayor celeridad los documentos complementarios de tu hoja de vida, ingresando al siguiente link:</p>
                                    <center>
                                        <a href='".$boton_url."' target='_blank' style='border-radius:4px; color:#ffffff; font-size:12px; padding: 5px 5px 5px 5px; text-align:center; text-decoration:none !important; width:50%; display: block; background-color: ".COLOR_PRINCIPAL."'>".$boton_titulo."</a>
                                    </center>";
                                /*SE CONFIGURAN PARÁMETROS A REGISTRAR EN SISTEMA DE NOTIFICACIÓN*/
                                $notificacion->nc_id_modulo='5';
                                $notificacion->nc_address=$resaspirante[0]['hva_correo'].';';
                                $notificacion->nc_subject="Continuar proceso de selección iQ Outsourcing";
                                $notificacion->nc_body=notificacion_general($contenido, $boton_titulo, $boton_url);
                                $notificacion->nc_embeddedimage_ruta="".BASEPATH_IMAGE."logo/firma-verde.png;".BASEPATH_IMAGE."logo/logo_notificacion.png";
                                $notificacion->nc_embeddedimage_nombre="firma-verde;logo_notificacion";
                                $notificacion->nc_embeddedimage_tipo="image/png;image/png";
                                $notificacion->nc_usuario_registro=checkInput($_SESSION[APP_SESSION.'usu_id']);
                                $resnotificacion=$notificacion->add();
                                
                                if ($resnotificacion) {
                                    $ofertas->hvao_estado_fase_2='Enviado';
                                    $resupdate = $ofertas->updateOfertaEstado();
                                    Flasher::new('¡Notificación creada exitosamente!', 'success');
                                } else {
                                    Flasher::new('¡Problemas al crear el registro, verifique e intente nuevamente!', 'warning');
                                }
                            } else {
                                Flasher::new('¡Problemas al crear la notificación, verifique e intente nuevamente!', 'warning');
                            }
                        } elseif ($hvao_estado_fase_2=='Rechazado') {
                            $notificacion = new notificacionModel();

                            $boton_url='';
                            $boton_titulo='';
                            //PROGRAMACIÓN NOTIFICACIÓN 
                                $contenido="";
                            /*SE CONFIGURAN PARÁMETROS A REGISTRAR EN SISTEMA DE NOTIFICACIÓN*/
                            $notificacion->nc_id_modulo='5';
                            $notificacion->nc_address=$resaspirante[0]['hva_correo'].';';
                            $notificacion->nc_subject="Agradecemos tu participación en el proceso de selección iQ";
                            $notificacion->nc_body=notificacion_general($contenido, $boton_titulo, $boton_url);
                            $notificacion->nc_embeddedimage_ruta="".BASEPATH_IMAGE."logo/logo_notificacion_nocontinua.png";
                            $notificacion->nc_embeddedimage_nombre="logo_notificacion";
                            $notificacion->nc_embeddedimage_tipo="image/png;image/png";
                            $notificacion->nc_usuario_registro=checkInput($_SESSION[APP_SESSION.'usu_id']);
                            $resnotificacion=$notificacion->add();
                            
                            if ($resnotificacion) {
                                $ofertas->hvao_estado_fase_2='Rechazado';
                                $resupdate = $ofertas->updateOfertaEstado();
                                Flasher::new('¡Notificación creada exitosamente!', 'success');
                            } else {
                                Flasher::new('¡Problemas al crear la notificación, verifique e intente nuevamente!', 'warning');
                            }
                        }

                        if ($hvao_debida_diligencia=='Aprobado' AND $hvao_prueba_confiabilidad=='Aprobado' AND $hvao_examen_medico=='Aprobado' AND $hvao_check_contratacion=='Aprobado') {
                            $aspirante->hva_estado='Pendiente Fase 2';
                            $aspirante->hva_actualiza_fecha=now();
                        } else {
                            $aspirante->hva_estado='Rechazado';
                            $aspirante->hva_actualiza_fecha=now();
                        }

                        $resupdateestado=$aspirante->updateEstado();

                        Flasher::new('¡Registro editado exitosamente!', 'success');
                    } else {
                        Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }

            $resaspirante=$aspirante->listDetail();

            if (!isset($resaspirante[0])) {
                $resaspirante=array();
            }
            
            $resofertas=$ofertas->listDetail();

            if (!isset($resofertas[0])) {
                $resofertas=array();
            }

            $data =
            [
                'titulo_pagina' => 'SELECCIÓN|ASPIRANTES|OFERTAS|EDITAR',
                'path' => 'seleccion-vinculacion/aspirantes-ofertas-editar/',
                'path_add' => '/'.base64_encode($bandeja),
                'resultado_registros' => to_object($resaspirante),
                'resultado_registros_documentos' => to_object($resaspirante_documentos),
                'resultado_registros_ofertas' => to_object($resofertas),
                'resultado_registros_ofertas_count' => count($resofertas),
                'pag_inicio' => $pag_inicio,
                'pag_fin' => $pag_fin,
                'pag_total' => $pag_total,
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'bandeja' => base64_encode($bandeja),
                'id_registro' => base64_encode($id_registro),

            ];
            
            View::render('aspirantes_ofertas_editar', $data);
        }

        public static function aspirantes_ofertas_reenviar($pagina, $filtro_busqueda, $bandeja, $id_registro, $id_oferta) {
            $modulo_plataforma="1";
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $bandeja=checkInput(base64_decode($bandeja));
            $id_registro=checkInput(base64_decode($id_registro));
            $id_oferta=checkInput(base64_decode($id_oferta));
            // ini_set('display_errors', '1');
            // error_reporting(E_ALL);

            $aspirante = new hv_aspiranteModel();
            $aspirante->hva_id=$id_registro;
            $resaspirante=$aspirante->listDetail();

            if (!isset($resaspirante[0])) {
                $resaspirante=array();
            }
            
            $ofertas = new hv_aspirante_ofertaModel();
            $ofertas->hvao_id=$id_oferta;
            $resofertas=$ofertas->listDetail();

            if (!isset($resofertas[0])) {
                $resofertas=array();
            }

            $aspirante_documentos = new hv_aspirante_documentoModel();
            $aspirante_documentos->hvad_aspirante=$id_registro;
            
            $resaspirante_documentos=$aspirante_documentos->listDetail();

            if (!isset($resaspirante_documentos[0])) {
                $resaspirante_documentos=array();
            }

            if(isset($_POST["form_guardar"])){
                try {
                    //obtiene variables de formulario
                    $hvao_reenviar=checkInput($_POST['hvao_reenviar']);
                    if($_SESSION[APP_SESSION.'_proceso_reenviar_add']!=1) {
                        if ($hvao_reenviar=='Si') {
                            if ($resofertas[0]['hvao_estado']=='Pendiente') {
                                $token = new tokenModel();
                                $token->aut_usuario='HV'.$resofertas[0]['hvao_id'];
                                $restoken=$token->listDetail();

                                if (!isset($restoken[0])) {
                                    $restoken=array();
                                }
                                
                                if (count($restoken)>0) {
                                    $notificacion = new notificacionModel();
                                    $boton_url=URL."seleccion-vinculacion/formulario-instrucciones/".base64_encode($restoken[0]['aut_usuario'])."/".base64_encode($restoken[0]['aut_token']);
                                    $boton_titulo='Da clic aquí para ingresar';
                                    //PROGRAMACIÓN NOTIFICACIÓN 
                                        $contenido="<p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Para oficializar tu proceso de selección, te invitamos a diligenciar con la mayor celeridad los datos de tu hoja de vida, ingresando al siguiente link:</p>
                                        <center>
                                            <a href='".$boton_url."' target='_blank' style='border-radius:4px; color:#ffffff; font-size:12px; padding: 5px 5px 5px 5px; text-align:center; text-decoration:none !important; width:50%; display: block; background-color: ".COLOR_PRINCIPAL."'>".$boton_titulo."</a>
                                        </center>";
                                    /*SE CONFIGURAN PARÁMETROS A REGISTRAR EN SISTEMA DE NOTIFICACIÓN*/
                                    $notificacion->nc_id_modulo=$modulo_plataforma;
                                    $notificacion->nc_address=$resaspirante[0]['hva_correo'].';';
                                    $notificacion->nc_subject="Recordatorio | Bienvenid@ al proceso de selección iQ Outsourcing";
                                    $notificacion->nc_body=notificacion_general($contenido, $boton_titulo, $boton_url);
                                    $notificacion->nc_embeddedimage_ruta="".BASEPATH_IMAGE."logo/firma-verde.png;".BASEPATH_IMAGE."logo/logo_notificacion.png";
                                    $notificacion->nc_embeddedimage_nombre="firma-verde;logo_notificacion";
                                    $notificacion->nc_embeddedimage_tipo="image/png;image/png";
                                    $notificacion->nc_usuario_registro=checkInput($_SESSION[APP_SESSION.'usu_id']);
                                    $resnotificacion=$notificacion->add();
                                } else {
                                    Flasher::new('¡Problemas al crear el registro, verifique e intente nuevamente!', 'warning');
                                }
                            } elseif ($resofertas[0]['hvao_estado']=='Revisado') {
                                $token = new tokenModel();
                                $token->aut_usuario='HVR'.$resofertas[0]['hvao_id'];
                                $restoken=$token->listDetail();

                                if (!isset($restoken[0])) {
                                    $restoken=array();
                                }
                                
                                if (count($restoken)>0) {
                                    $notificacion = new notificacionModel();
                                    $boton_url=URL."seleccion-vinculacion/formulario-documentos-f2/".base64_encode($restoken[0]['aut_usuario'])."/".base64_encode($restoken[0]['aut_token']);
                                    $boton_titulo='Da clic aquí para ingresar';
                                    //PROGRAMACIÓN NOTIFICACIÓN 
                                        $contenido="<p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Para continuar con tu proceso de selección, te invitamos a cargar con la mayor celeridad los documentos complementarios de tu hoja de vida, ingresando al siguiente link:</p>
                                        <center>
                                            <a href='".$boton_url."' target='_blank' style='border-radius:4px; color:#ffffff; font-size:12px; padding: 5px 5px 5px 5px; text-align:center; text-decoration:none !important; width:50%; display: block; background-color: ".COLOR_PRINCIPAL."'>".$boton_titulo."</a>
                                        </center>";
                                    /*SE CONFIGURAN PARÁMETROS A REGISTRAR EN SISTEMA DE NOTIFICACIÓN*/
                                    $notificacion->nc_id_modulo='5';
                                    $notificacion->nc_address=$resaspirante[0]['hva_correo'].';';
                                    $notificacion->nc_subject="Recordatorio | Continuar proceso de selección iQ Outsourcing";
                                    $notificacion->nc_body=notificacion_general($contenido, $boton_titulo, $boton_url);
                                    $notificacion->nc_embeddedimage_ruta="".BASEPATH_IMAGE."logo/firma-verde.png;".BASEPATH_IMAGE."logo/logo_notificacion.png";
                                    $notificacion->nc_embeddedimage_nombre="firma-verde;logo_notificacion";
                                    $notificacion->nc_embeddedimage_tipo="image/png;image/png";
                                    $notificacion->nc_usuario_registro=checkInput($_SESSION[APP_SESSION.'usu_id']);
                                    $resnotificacion=$notificacion->add();
                                } else {
                                    Flasher::new('¡Problemas al crear el registro, verifique e intente nuevamente!', 'warning');
                                }
                            }
                                
                            if ($resnotificacion) {
                                Flasher::new('¡Registro creado exitosamente!', 'success');
                                $_SESSION[APP_SESSION.'_proceso_reenviar_add']=1;
                            } else {
                                Flasher::new('¡Problemas al crear el registro, verifique e intente nuevamente!', 'warning');
                            }
                            
                        }
                    } else {
                        Flasher::new('¡Registro creado exitosamente!', 'success');
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }

            $resaspirante=$aspirante->listDetail();

            if (!isset($resaspirante[0])) {
                $resaspirante=array();
            }
            
            $resofertas=$ofertas->listDetail();

            if (!isset($resofertas[0])) {
                $resofertas=array();
            }

            $data =
            [
                'titulo_pagina' => 'SELECCIÓN|ASPIRANTES|OFERTAS|REENVIAR',
                'path' => 'seleccion-vinculacion/aspirantes-ofertas-reenviar/',
                'path_add' => '/'.base64_encode($bandeja),
                'resultado_registros' => to_object($resaspirante),
                'resultado_registros_documentos' => to_object($resaspirante_documentos),
                'resultado_registros_ofertas' => to_object($resofertas),
                'resultado_registros_ofertas_count' => count($resofertas),
                'pag_inicio' => $pag_inicio,
                'pag_fin' => $pag_fin,
                'pag_total' => $pag_total,
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'bandeja' => base64_encode($bandeja),
                'id_registro' => base64_encode($id_registro),

            ];
            
            View::render('aspirantes_ofertas_reenviar', $data);
        }

        

        public static function aspirantes_autorizacion_descargar($id_registro) {
            $modulo_plataforma="1";
            Controller::checkSesion();
            // error_reporting(E_ALL);
            // ini_set('display_errors', '1');
            // require_once(ASSETS_ROOT.'plugins/PHPfpdf/mc_table.php');
            // require_once(ASSETS_ROOT.'plugins/TCPDF-main/tcpdf.php');
            // echo ASSETS_ROOT;
            $id_registro=checkInput(base64_decode($id_registro));

            //PDF TCPDF
            $pdf = new CustomTCPDF2('P', 'mm', array(216, 355.6), true, 'UTF-8');
            // $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetCreator('iQ Outsourcing');
            $pdf->SetAuthor('iQ Outsourcing');
            $pdf->SetTitle('Formato Autorización Tratamiento de Datos Personales');
            // set default header data PDF_HEADER_LOGO
            // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);
            // set header and footer fonts
            // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            
            $pdf->SetFont('Helvetica', '', 8);

            $pdf->AddPage();
            
            $aspirante = new hv_aspiranteModel();
            $aspirante->hva_id=$id_registro;
            $resaspirante=$aspirante->listDetail();

            if (!isset($resaspirante[0])) {
                $resaspirante=array();
            }

            $aspirante_autorizaciones = new hv_aspirante_autorizacionesModel();
            $aspirante_autorizaciones->hvada_aspirante=$id_registro;

            $resaspirante_tratamiento_datos=$aspirante_autorizaciones->listDetailFormulario();

            if (!isset($resaspirante_tratamiento_datos[0])) {
                $resaspirante_tratamiento_datos=array();
            }

            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 10);
            $pdf->MultiCell('', 1, ''.$resaspirante[0]['ciu_municipio'].', '.$resaspirante[0]['ciu_departamento'].', '.date('d/m/Y', strtotime($resaspirante_tratamiento_datos[0]['hvada_registro_fecha'])).'', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);
            $pdf->MultiCell('', 1, '', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);
            $pdf->SetFont('Helvetica', 'B', 11);
            $pdf->MultiCell('', 1, 'AUTORIZACIÓN PARA EL TRATAMIENTO DE DATOS PERSONALES<br>Y DECLARACIONES', 0, 'C', 0, 1, '', '', true, 0, true, true, 0);
            $pdf->MultiCell('', 1, '', '', 'L', 0, 1, '', '', true, 0, true, true, 0);
            $pdf->MultiCell('', 1, '', '', 'L', 0, 1, '', '', true, 0, true, true, 0);
            $pdf->MultiCell('', 1, 'NOMBRES Y APELLIDOS: '.$resaspirante[0]['hva_nombres'].' '.$resaspirante[0]['hva_nombres_2'].' '.$resaspirante[0]['hva_apellido_1'].' '.$resaspirante[0]['hva_apellido_2'].'', 'B', 'L', 0, 1, '', '', true, 0, true, true, 0);
            $pdf->MultiCell('', 1, '', '', 'L', 0, 1, '', '', true, 0, true, true, 0);
            

            $registro_parametro = new parametroModel();
            $registro_parametro->app_id = 'autorizacion_tratamiento_datos';
            $resregistro_parametro=$registro_parametro->listDetail();

            if (!isset($resregistro_parametro[0])) {
                $resregistro_parametro=array();
            }
            $pdf->SetFont('Helvetica', '', 11);
            $pdf->SetTextColor(0, 0, 0); // Color de texto negro

            $html = $resregistro_parametro[0]['app_descripcion'];
            $pdf->writeHTML($html, true, false, true, false, '');

            // Valida Firma
            $aspirante_documentos = new hv_aspirante_documentoModel();
            $aspirante_documentos->hvad_aspirante=$id_registro;
            $aspirante_documentos->hvad_tipo='firma'; 
            $resaspirante_documentos=$aspirante_documentos->listDetailAll();

            if (!isset($resaspirante_documentos[0])) {
                $resaspirante_documentos=array();
            }

            $pdf->SetFont('Helvetica', '', 8);
            $pdf->MultiCell(160, 4, '', '', 'L', 0, 1, '', '');
            // Guardar la posición actual
            $posicionAntesDeFirma = $pdf->getY();

            if ($resaspirante_documentos[0]['hvad_ruta']!='') {
                // Agregar la firma después de la línea
                $imagenFirma = UPLOADS_ROOT_ASSETS.$resaspirante_documentos[0]['hvad_ruta'];
                $anchoFirma = 30; // ajusta el ancho de la firma según sea necesario
    
                if (file_exists($imagenFirma)) {
                    $pdf->Image($imagenFirma, 15, $posicionAntesDeFirma + 5, $anchoFirma);
                }
            }

            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 11);
            $pdf->MultiCell(120, 50, '', '', 'L', 0, 1, '', '');
            $pdf->MultiCell(120, 4, 'Firma', 'T', 'L', 0, 1, '', '');
            $pdf->MultiCell(160, 4, 'Nombres y apellidos: '.$resaspirante[0]['hva_nombres'].' '.$resaspirante[0]['hva_nombres_2'].' '.$resaspirante[0]['hva_apellido_1'].' '.$resaspirante[0]['hva_apellido_2'], '', 'L', 0, 1, '', '');
            $pdf->MultiCell(160, 4, 'Identificación: '.$resaspirante[0]['hva_identificacion'], '', 'L', 0, 1, '', '');

            $ruta_hoja_vida=UPLOADS_ROOT_ASSETS.'aspirante_documentos/'.$resaspirante[0]['hva_id'].'/FORMATO AUTORIZACIÓN DE TRATAMIENTO DE DATOS PERSONALES Y DECLARACIONES-'.$resaspirante[0]['hva_nombres'].' '.$resaspirante[0]['hva_nombres_2'].' '.$resaspirante[0]['hva_apellido_1'].' '.$resaspirante[0]['hva_apellido_2'].'.pdf';
            
            $pdf->Output($ruta_hoja_vida, 'D');
            
            $data =
            [
                
            ];
        }

        public static function hoja_vida_descargar($id_registro, $accion) {
            $modulo_plataforma="1";
            Controller::checkSesion();
            // error_reporting(E_ALL);
            // ini_set('display_errors', '1');
            // require_once(ASSETS_ROOT.'plugins/PHPfpdf/mc_table.php');
            // require_once(ASSETS_ROOT.'plugins/TCPDF-main/tcpdf.php');
            // echo ASSETS_ROOT;
            $id_aspirante_consulta=checkInput(base64_decode($id_registro));

            //PDF TCPDF
            $pdf = new CustomTCPDF('P', 'mm', array(216, 355.6), true, 'UTF-8');
            // $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetCreator('Tu nombre');
            $pdf->SetAuthor('Tu nombre');
            $pdf->SetTitle('Formato Hoja de Vida Digital');
            // set default header data PDF_HEADER_LOGO
            // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);
            // set header and footer fonts
            // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            
            $pdf->SetFont('Helvetica', '', 8);

            $pdf->AddPage();
            // $tagvs = array('p' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 0)));
            // $pdf->setHtmlVSpace($tagvs);

            // Función para crear una celda con esquinas redondeadas
            function getRoundedCell($pdf, $content, $radius, $width) {
                $imgBorderStyle = ['width' => 0,'cap' => 'square','join' => 'miter','dash' => '0','color' => [226, 232, 240]];

                $pdf->SetFont('Helvetica', '', 8);
                $pdf->SetX($pdf->GetX() + 2);
                $pdf->SetFillColor(226, 232, 240); // Color de relleno (Gris claro)
                $pdf->SetTextColor(0, 0, 0); // Color de texto negro
                $pdf->setCellPadding(1);
                $pdf->RoundedRect($pdf->GetX(), $pdf->GetY(), $width, 9, $radius, '1111', 'DF', $imgBorderStyle);
                $pdf->MultiCell($width, 8, $content, 0, 'L', 0, 0, $pdf->GetX(), $pdf->GetY(), true, 0, true, true, 0);
                // $pdf->MultiCell($width, 6, $content, 0, 'L', 0, 0, $pdf->GetX(), $pdf->GetY(), true, 0, true, true, 0);
                // MultiCell($w, $h, 'text<br />', $border=0, $align='L', $fill=1, $ln=0, $x='', $y='', $reseth=true, $reseth=0, $ishtml=true, $autopadding=true, $maxh=0);
                return '';
            }

            // Función para crear una celda con esquinas redondeadas
            function getRoundedTitle($pdf, $content, $radius, $width) {
                $imgBorderStyle = ['width' => 0,'cap' => 'square','join' => 'miter','dash' => '0','color' => [28, 34, 98]];

                $pdf->SetFont('Helvetica', '', 11);
                $pdf->SetX($pdf->GetX() + 0);
                $pdf->SetFillColor(28, 34, 98); // Color de relleno (Gris claro)
                $pdf->SetTextColor(255, 255, 255); // Color de texto blanco
                $pdf->setCellPadding(1);
                $pdf->RoundedRect($pdf->GetX(), $pdf->GetY(), $width, 7, $radius, '1111', 'DF', $imgBorderStyle);
                $pdf->MultiCell($width, 7, $content, 0, 'L', 0, 0, $pdf->GetX(), $pdf->GetY(), true, 0, true, true, 0);
                // $pdf->MultiCell($width, 6, $content, 0, 'L', 0, 0, $pdf->GetX(), $pdf->GetY(), true, 0, true, true, 0);
                // MultiCell($w, $h, 'text<br />', $border=0, $align='L', $fill=1, $ln=0, $x='', $y='', $reseth=true, $reseth=0, $ishtml=true, $autopadding=true, $maxh=0);
                return '';
            }

            // Define el radio para las esquinas redondeadas
            $radius = 1;

            // Valida Información Personal
            $aspirante = new hv_aspiranteModel();
            $aspirante->hva_id=$id_aspirante_consulta;
            $resaspirante=$aspirante->listDetail();

            if (!isset($resaspirante[0])) {
                $resaspirante=array();
            }

            // Valida Información en caso de Emergencia
            $aspirante_emergencia = new hv_aspirante_emergenciaModel();
            $aspirante_emergencia->hvaem_aspirante=$id_aspirante_consulta;
            $resaspirante_emergencia=$aspirante_emergencia->listDetail();

            if (!isset($resaspirante_emergencia[0])) {
                $resaspirante_emergencia=array();
            }

            // $pdf->SetFont('Helvetica', '', 11);
            // $pdf->SetTextColor(255, 255, 255); // Color de texto blanco
            
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->SetTextColor(0, 0, 0); // Color de texto negro

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Información Personal</b></td>
                </tr>';
            $html .= '</table>';

            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Primer nombre:</b><br>'.$resaspirante[0]['hva_nombres'].'</td>
                <td style="background-color: #E2E8F0;"><b>Segundo nombre:</b><br>'.$resaspirante[0]['hva_nombres_2'].'</td>
                <td style="background-color: #E2E8F0;"><b>Primer apellido:</b><br>'.$resaspirante[0]['hva_apellido_1'].'</td>
                <td style="background-color: #E2E8F0;"><b>Segundo apellido:</b><br>'.$resaspirante[0]['hva_apellido_2'].'</td>
                </tr>';
            $html .= '</table>';

            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Doc. identidad:</b><br>'.$resaspirante[0]['hva_identificacion'].'</td>
                <td style="background-color: #E2E8F0;"><b>Fecha expedición:</b><br>'.$resaspirante[0]['hva_auxiliar_5'].'</td>
                <td style="background-color: #E2E8F0;"><b>Dirección:</b><br>'.$resaspirante[0]['hva_direccion']. '</td>
                <td style="background-color: #E2E8F0;"><b>Barrio:</b><br>'.$resaspirante[0]['hva_barrio']. '</td>
                </tr>';
            $html .= '</table>';

            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
            <td style="background-color: #E2E8F0;"><b>Ciudad:</b><br>'.$resaspirante[0]['ciu_municipio'].', '.$resaspirante[0]['ciu_departamento']. '</td>
                <td style="background-color: #E2E8F0;"><b>Celular:</b><br>'.$resaspirante[0]['hva_celular'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Celular alternativo:</b><br>'.$resaspirante[0]['hva_celular_2'] . '</td>
                <td style="background-color: #E2E8F0;"><b>E-mail:</b><br>'.$resaspirante[0]['hva_correo'] . '</td>
                </tr>';
            $html .= '</table>';

            $edad_aspirante='';
            if ($resaspirante[0]['hva_nacimiento_fecha']!='') {
                $edad_aspirante=calcularEdad($resaspirante[0]['hva_nacimiento_fecha']);
            }

            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Lugar nacimiento:</b><br>'.$resaspirante[0]['nacimiento_ciu_municipio'].', '.$resaspirante[0]['nacimiento_ciu_departamento'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Fecha nacimiento:</b><br>'.$resaspirante[0]['hva_nacimiento_fecha'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Edad:</b><br>'.$edad_aspirante . '</td>
                <td style="background-color: #E2E8F0;"><b>Estado civil:</b><br>'.$resaspirante[0]['hva_estado_civil'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Género:</b><br>'.$resaspirante[0]['hva_genero'] . '</td>
                </tr>';
            $html .= '</table>';

            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Grupo sanguíneo:</b><br>'.$resaspirante_emergencia[0]['hvaem_grupo_sanguineo'] . '</td>
                <td style="background-color: #E2E8F0;"><b>RH:</b><br>'.$resaspirante_emergencia[0]['hvaem_rh'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Operador de internet:</b><br>'.$resaspirante[0]['hva_operador_internet'] . '</td>
                </tr>';
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Información en caso de Emergencia</b></td>
                </tr>';
            $html .= '</table>';

            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Nombres y apellidos:</b><br>'.$resaspirante_emergencia[0]['hvaem_nombres_apellidos'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Parentesco:</b><br>'.$resaspirante_emergencia[0]['hvaem_parentesco'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Teléfono:</b><br>'.$resaspirante_emergencia[0]['hvaem_telefono'] . '</td>
                </tr>';
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');

            // Valida Información Familiar
            $aspirante_familiar = new hv_aspirante_familiarModel();
            $aspirante_familiar->hvaf_aspirante=$id_aspirante_consulta;
            $resaspirante_familiar=$aspirante_familiar->listDetail();

            if (!isset($resaspirante_familiar[0])) {
                $resaspirante_familiar=array();
            }

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Información Familiar</b></td>
                </tr>';
            $html .= '</table>';
            
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                        <td align="center" style="background-color: #E2E8F0;" width="223"><b>Nombres y Apellidos</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="140"><b>Parentesco</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="50"><b>Edad</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="50"><b>A cargo?</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="50"><b>Convive?</b></td>
                    </tr>';

            for ($i=0; $i < count($resaspirante_familiar); $i++) { 
                $html .= '
                    <tr>
                        <td align="center" style="background-color: #E2E8F0;" width="223">'.$resaspirante_familiar[$i]['hvaf_nombres_apellidos'].'</td>
                        <td align="center" style="background-color: #E2E8F0;" width="140">'.$resaspirante_familiar[$i]['hvaf_parentesco'].'</td>
                        <td align="center" style="background-color: #E2E8F0;" width="50">'.$resaspirante_familiar[$i]['hvaf_edad'].'</td>
                        <td align="center" style="background-color: #E2E8F0;" width="50">'.$resaspirante_familiar[$i]['hvaf_acargo'].'</td>
                        <td align="center" style="background-color: #E2E8F0;" width="50">'.$resaspirante_familiar[$i]['hvaf_convive'].'</td>
                    </tr>';
            }
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, false, false, '');

            // Valida Estudios Culminados
            $aspirante_estudio_culminado = new hv_aspirante_estudio_terminadoModel();
            $aspirante_estudio_culminado->hvaet_aspirante=$id_aspirante_consulta;
            $resaspirante_estudio_culminado=$aspirante_estudio_culminado->listDetail();

            if (!isset($resaspirante_estudio_culminado[0])) {
                $resaspirante_estudio_culminado=array();
            }

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Estudios Culminados</b></td>
                </tr>';
            $html .= '</table>';
            
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                        <td align="center" style="background-color: #E2E8F0;" width="80"><b>Nivel</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="95"><b>Establecimiento</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="95"><b>Título</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="80"><b>Ciudad</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="55"><b>Fecha Inicio</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="55"><b>Fecha Terminación</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="50"><b>Tarjeta Profesional</b></td>
                    </tr>';

            for ($i=0; $i < count($resaspirante_estudio_culminado); $i++) { 
                $html .= '
                    <tr>
                        <td align="center" style="background-color: #E2E8F0;" width="80">'.$resaspirante_estudio_culminado[$i]['hvaet_nivel'].'</td>
                        <td align="center" style="background-color: #E2E8F0;" width="95">'.$resaspirante_estudio_culminado[$i]['hvaet_establecimiento'].'</td>
                        <td align="center" style="background-color: #E2E8F0;" width="95">'.$resaspirante_estudio_culminado[$i]['hvaet_titulo'].'</td>
                        <td align="center" style="background-color: #E2E8F0;" width="80">'.$resaspirante_estudio_culminado[$i]['ciu_municipio'].', '.$resaspirante_estudio_culminado[$i]['ciu_departamento'] . '</td>
                        <td align="center" style="background-color: #E2E8F0;" width="55">'.$resaspirante_estudio_culminado[$i]['hvaet_fecha_inicio'].'</td>
                        <td align="center" style="background-color: #E2E8F0;" width="55">'.$resaspirante_estudio_culminado[$i]['hvaet_fecha_terminacion'].'</td>
                        <td align="center" style="background-color: #E2E8F0;" width="50">'.$resaspirante_estudio_culminado[$i]['hvaet_tarjeta_profesional'].'</td>
                    </tr>';
            }
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, false, false, '');

            // //HR SEPARADOR SECCIONES
            // $pdf->SetFont('Helvetica', '', 3);
            // $pdf->MultiCell('', 1, '<hr style="color: E2E8F0;">', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            

            // Valida Estudios Curso
            $aspirante_estudio_curso = new hv_aspirante_estudio_cursoModel();
            $aspirante_estudio_curso->hvaec_aspirante=$id_aspirante_consulta;
            $resaspirante_estudio_curso=$aspirante_estudio_curso->listDetail();

            if (!isset($resaspirante_estudio_curso[0])) {
                $resaspirante_estudio_curso=array();
            }

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Estudios en Curso</b></td>
                </tr>';
            $html .= '</table>';
            
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                        <td align="center" style="background-color: #E2E8F0;" width="80"><b>Nivel</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="95"><b>Entidad Educativa</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="90"><b>Título a Obtener</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="80"><b>Ciudad</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="53"><b>Horario</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="57"><b>Modalidad</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="55"><b>Fecha Terminación Proyectada</b></td>
                    </tr>';
                    
            for ($i=0; $i < count($resaspirante_estudio_curso); $i++) { 
                $html .= '
                <tr>
                    <td align="center" style="background-color: #E2E8F0;" width="80">'.$resaspirante_estudio_curso[$i]['hvaec_nivel'].'</td>
                    <td align="center" style="background-color: #E2E8F0;" width="95">'.$resaspirante_estudio_curso[$i]['hvaec_establecimiento'].'</td>
                    <td align="center" style="background-color: #E2E8F0;" width="90">'.$resaspirante_estudio_curso[$i]['hvaec_titulo'].'</td>
                    <td align="center" style="background-color: #E2E8F0;" width="80">'.$resaspirante_estudio_curso[$i]['ciu_municipio'].', '.$resaspirante_estudio_curso[$i]['ciu_departamento'] . '</td>
                    <td align="center" style="background-color: #E2E8F0;" width="53">'.$resaspirante_estudio_curso[$i]['hvaec_horario'].'</td>
                    <td align="center" style="background-color: #E2E8F0;" width="57">'.$resaspirante_estudio_curso[$i]['hvaec_modalidad'].'</td>
                    <td align="center" style="background-color: #E2E8F0;" width="55">'.$resaspirante_estudio_curso[$i]['hvaec_fecha_terminacion'].'</td>
                </tr>';
            }
            $html .= '</table>';
                    

            $pdf->writeHTML($html, true, false, false, false, '');

            // Valida Experiencia Laboral
            $aspirante_experiencia = new hv_aspirante_experienciaModel();
            $aspirante_experiencia->hvaex_aspirante=$id_aspirante_consulta;
            $resaspirante_experiencia=$aspirante_experiencia->listDetail();

            if (!isset($resaspirante_experiencia[0])) {
                $resaspirante_experiencia=array();
            }

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Experiencia Laboral</b></td>
                </tr>';
            $html .= '</table>';
            // $pdf->writeHTML($html, true, false, true, false, '');
            for ($i=0; $i < count($resaspirante_experiencia); $i++) { 
                if ($i>0) {
                    //HR SEPARADOR SECCIONES
                    // $pdf->SetFont('Helvetica', '', 3);
                    // $pdf->MultiCell('', 1, '<hr style="color: E2E8F0;">', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);
                }
                
                // Crea una tabla HTML con celdas redondeadas
                $html .= '<table cellspacing="2" cellpadding="3">';
                $html .= '<tr>
                    <td style="background-color: #E2E8F0;"><b>Nombre de la empresa:</b><br>'.$resaspirante_experiencia[$i]['hvaex_empresa'].'</td>
                    <td style="background-color: #E2E8F0;"><b>Cargo:</b><br>'.$resaspirante_experiencia[$i]['hvaex_cargo'].'</td>
                    <td style="background-color: #E2E8F0;"><b>Fecha inicio:</b><br>'.$resaspirante_experiencia[$i]['hvaex_fecha_inicio'].'</td>
                    <td style="background-color: #E2E8F0;"><b>Fecha retiro:</b><br>'.$resaspirante_experiencia[$i]['hvaex_fecha_retiro'].'</td>
                    </tr>';
                $html .= '</table>';
                // $pdf->writeHTML($html, true, false, true, false, '');
    
                // Crea una tabla HTML con celdas redondeadas
                $html .= '<table cellspacing="2" cellpadding="3">';
                $html .= '<tr>
                    <td style="background-color: #E2E8F0;"><b>Ciudad:</b><br>'.$resaspirante_experiencia[$i]['ciu_municipio'].', '.$resaspirante_experiencia[$i]['ciu_departamento'] . '</td>
                    <td style="background-color: #E2E8F0;"><b>Nombre jefe inmediato:</b><br>'.$resaspirante_experiencia[$i]['hvaex_jefe_nombre'].'</td>
                    <td style="background-color: #E2E8F0;"><b>Cargo:</b><br>'.$resaspirante_experiencia[$i]['hvaex_jefe_cargo'].'</td>
                    </tr>';
                $html .= '</table>';
                // $pdf->writeHTML($html, true, false, true, false, '');
    
                // Crea una tabla HTML con celdas redondeadas
                $html .= '<table cellspacing="2" cellpadding="3">';
                $html .= '<tr>
                    <td style="background-color: #E2E8F0;"><b>Teléfono de referencia:</b><br>'.$resaspirante_experiencia[$i]['hvaex_telefonos'].'</td>
                    <td style="background-color: #E2E8F0;"><b>Motivo de retiro:</b><br>'.$resaspirante_experiencia[$i]['hvaex_motivo_retiro'].'</td>
                    </tr>';
                $html .= '</table>';
                // $pdf->writeHTML($html, true, false, true, false, '');
            }

            $pdf->writeHTML($html, true, false, true, false, '');


            // Valida Información Ética
            $aspirante_etica = new hv_aspirante_eticaModel();
            $aspirante_etica->hvae_aspirante=$id_aspirante_consulta;
            $resaspirante_etica=$aspirante_etica->listDetail();

            if (!isset($resaspirante_etica[0])) {
                $resaspirante_etica=array();
            }

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Código de ética, Anticorrupción y Buen Gobierno P6-A1</b></td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>¿Tiene usted familiares, conyugue y/o compañero permanente, parientes dentro del cuarto grado de consanguinidad, tercero de afinidad o único civil que actualmente trabaje en IQ?:</b> '.$resaspirante_etica[0]['hvae_familiar']. '</td>
                </tr>';
            $html .= '</table>';

            if ($resaspirante_etica[0]['hvae_familiar']=='Si') {
                // Crea una tabla HTML con celdas redondeadas
                $html .= '<table cellspacing="2" cellpadding="3">';
                $html .= '<tr>
                    <td style="background-color: #E2E8F0;"><b>Nombres y apellidos:</b><br>'.$resaspirante_etica[0]['hvae_familiar_nombre']. '</td>
                    <td style="background-color: #E2E8F0;"><b>Área:</b><br>'.$resaspirante_etica[0]['hvae_familiar_area']. '</td>
                    </tr>';
                $html .= '</table>';
            }
            
            $pdf->writeHTML($html, true, false, true, false, '');


            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 7);
            $pdf->MultiCell('', 1, 'De acuerdo con lo establecido en el Código de ética, Anticorrupción y Buen Gobierno P6-A1, está prohibido el ingreso de familiares o personas con grado de afinidad a la compañía, tal como se enuncia a continuación, si usted brinda información no veraz esto representa una falta grave al Reglamento Interno de Trabajo y Políticas de la organización, por lo que, asume la responsabilidad de cualquier falsedad frente a la misma.
            <br><br><b>GRADOS DE CONSAGUINIDAD</b>
                <br><br><b>Primer grado:</b> Mis padres, Mis hijos/as (tanto naturales como adoptivos)
                <br><b>Segundo grado:</b> Mis hermanos/as  abuelos/as Mis nietos/as
                <br><b>Tercer grado:</b> Mis tíos/as (hermanos/as de mis padres) Mis sobrinos/as (hijos/as de hermanos/as) Mis bisabuelos/as (padres de mis abuelos/as) Mis biznietos/as (hijos/as de mis nietos/as)
                <br><b>Cuarto grado:</b> Mis primos/as hermanos/as (hijos/as de los hermanos/as de mis padres)
                <br><br><b>GRADOS DE AFINIDAD</b>
                <br><br><b>Primer grado:</b> Mi cónyuge, Mis suegro/a (los padres de mi cónyuge), Los cónyuges de mis hijos/as, Cónyuge de mi padre, si no es mi madre, Cónyuge de mi madre, si no es mi padre.
                <br><b>Segundo grado:</b> Cónyuges de mis hermanos/as, Abuelos/as de mi cónyuge, Cónyuges de mis nietos/as, Mis hermanastros/as (entendiendo como hermanastro/a el hijo/a del cónyuge de mi padre/madre con el que no comparto ningún <br>lazo de sangre)
                <br><b>Tercer grado:</b> Cónyuges de mis tíos/as (cónyuges de los hermanos/as de mis padres), Cónyuges de mis sobrinos/as, Tíos de mi cónyuge y sus cónyuges
                <br><br><b>ÚNICO CIVIL:</b> Hijos adoptivos.<br><br>', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            

            // Valida Información IQ
            $aspirante_informacion = new hv_aspirante_informacionModel();
            $aspirante_informacion->hvai_aspirante=$id_aspirante_consulta;
            $resaspirante_informacion=$aspirante_informacion->listDetail();

            if (!isset($resaspirante_informacion[0])) {
                $resaspirante_informacion=array();
            }

            $pdf->SetFont('Helvetica', '', 8);
            $pdf->SetTextColor(0, 0, 0); // Color de texto negro

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Ex colaborador IQ</b></td>
                </tr>';
            $html .= '</table>';

            
            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>¿Ha trabajado anteriormente en IQ?:</b><br>'.$resaspirante_informacion[0]['hvai_excolaborador']. '</td>
                <td style="background-color: #E2E8F0;"><b>Motivo del retiro:</b><br>'.$resaspirante_informacion[0]['hvai_excolaborador_motivo']. '</td>
                <td style="background-color: #E2E8F0;"><b>Fecha de retiro:</b><br>'.$resaspirante_informacion[0]['hvai_excolaborador_fecha']. '</td>
                </tr>';
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Procesos de Selección Previos con IQ</b></td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>¿Ha presentado procesos de selección previamente en IQ?:</b><br>'.$resaspirante_informacion[0]['hvai_seleccion_previo']. '</td>
                <td style="background-color: #E2E8F0;"><b>Cargo:</b><br>'.$resaspirante_informacion[0]['hvai_seleccion_previo_cargo']. '</td>
                <td style="background-color: #E2E8F0;"><b>Fecha:</b><br>'.$resaspirante_informacion[0]['hvai_seleccion_previo_fecha']. '</td>
                </tr>';
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Trabajos Simultáneos</b></td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>¿Declara tener otro trabajo u ocupación simultánea?:</b><br>'.$resaspirante_informacion[0]['hvai_trabajo']. '</td>
                <td style="background-color: #E2E8F0;"><b>Tipo de vinculación:</b><br>'.$resaspirante_informacion[0]['hvai_trabajo_tipo']. '</td>
                </tr>';
            $html .= '</table>';
                
            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
            <td style="background-color: #E2E8F0;"><b>Nombre de la empresa:</b><br>'.$resaspirante_informacion[0]['hvai_trabajo_empresa']. '</td>
            <td style="background-color: #E2E8F0;"><b>Cargo:</b><br>'.$resaspirante_informacion[0]['hvai_trabajo_cargo']. '</td>
            </tr>';
            $html .= '</table>';
            
            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
            <td style="background-color: #E2E8F0;"><b>Ocupación o trabajo desempeñado:</b><br>'.$resaspirante_informacion[0]['hvai_ocupacion']. '</td>
            </tr>';
            $html .= '</table>';
            
            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>¿Si su ocupación actual genera conflicto de interés, estaría dispuesto a renunciar a su trabajo actual?:</b><br>'.$resaspirante_informacion[0]['hvai_conflicto_renuncia']. '</td>
                </tr>';
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');

            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 7);
            $pdf->MultiCell('', 1, 'De acuerdo con lo establecido en el Código de ética, anticorrupción y buen gobierno P6-A1, no se admite un segundo empleo o la prestación de sus servicios bajo cualquier modalidad cuando la otra parte ejecute actividades semejantes al objeto social de la Compañía y/o sea competidor de la Compañía. Un segundo empleo o acuerdo de servicios con un cliente o proveedor de la Compañía tampoco será permitido. si usted brinda información no veraz representa una falta grave y asume la responsabilidad de cualquier falsedad frente a la misma.<br><br>', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);



            // Valida Información Financiera
            $aspirante_financiera = new hv_aspirante_financieraModel();
            $aspirante_financiera->hvaf_aspirante=$id_aspirante_consulta;
            $resaspirante_financiera=$aspirante_financiera->listDetail();

            if (!isset($resaspirante_financiera[0])) {
                $resaspirante_financiera=array();
            }

            $pdf->SetFont('Helvetica', '', 8);
            $pdf->SetTextColor(0, 0, 0); // Color de texto negro

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Información Financiera</b></td>
                </tr>';
            $html .= '</table>';


            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Activos:</b><br>'.$resaspirante_financiera[0]['hvaf_activos']. '</td>
                <td style="background-color: #E2E8F0;"><b>Ingresos mensuales:</b><br>'.$resaspirante_financiera[0]['hvaf_ingresos']. '</td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Pasivos:</b><br>'.$resaspirante_financiera[0]['hvaf_pasivos']. '</td>
                <td style="background-color: #E2E8F0;"><b>Egresos mensuales:</b><br>'.$resaspirante_financiera[0]['hvaf_egresos']. '</td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Patrimonio:</b><br>'.$resaspirante_financiera[0]['hvaf_patrimonio']. '</td>
                <td style="background-color: #E2E8F0;"><b>Otros ingresos:</b><br>'.$resaspirante_financiera[0]['hvaf_ingresos_otros']. '</td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Concepto de otros ingresos:</b><br>'.$resaspirante_financiera[0]['hvaf_concepto_ingresos']. '</td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>¿Realiza Operaciones en Moneda Extranjera?:</b><br>'.$resaspirante_financiera[0]['hvaf_moneda_extranjera']. '</td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            // $html .= '<table cellspacing="2" cellpadding="3">';
            // $html .= '<tr>
            //     <td style="background-color: #E2E8F0;"><b>¿Se encuentra reportado en alguna central de riesgos?:</b><br>'.$resaspirante_financiera[0]['hvaf_reporte']. '</td>
            //     <td style="background-color: #E2E8F0;"><b>¿Cuál?:</b><br>'.$resaspirante_financiera[0]['hvaf_reporte_cual']. '</td>
            //     </tr>';
            // $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');


            // Valida Personas Expuestas Públicamente - PEP
            $aspirante_publico = new hv_aspirante_publicoModel();
            $aspirante_publico->hvap_aspirante=$id_aspirante_consulta;
            $resaspirante_publico=$aspirante_publico->listDetail();

            if (!isset($resaspirante_publico[0])) {
                $resaspirante_publico=array();
            }

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Personas Expuestas Públicamente - PEP</b></td>
                </tr>';
            $html .= '</table>';


            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>¿Maneja recursos públicos?:</b><br>'.$resaspirante_publico[0]['hvap_recursos'] . '</td>
                <td style="background-color: #E2E8F0;"><b>¿Goza de reconocimiento público general?:</b><br>'.$resaspirante_publico[0]['hvap_reconocimiento'] . '</td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>¿Ejerce algún grado de poder público?:</b><br>'.$resaspirante_publico[0]['hvap_poder'] . '</td>
                <td style="background-color: #E2E8F0;"><b>¿Tiene usted algún familiar que cumpla con una característica anterior?:</b><br>'.$resaspirante_publico[0]['hvap_familiar'] . '</td>
                </tr>';
            $html .= '</table>';

            if ($resaspirante_publico[0]['hvap_recursos']=='Si' OR $resaspirante_publico[0]['hvap_reconocimiento']=='Si' OR $resaspirante_publico[0]['hvap_poder']=='Si' OR $resaspirante_publico[0]['hvap_familiar']=='Si') {
                // Crea una tabla HTML con celdas redondeadas
                $html .= '<table cellspacing="2" cellpadding="3">';
                $html .= '<tr>
                    <td style="background-color: #E2E8F0;"><b>Si alguna de las respuestas anteriores es afirmativa, por favor especifique:</b><br>'.$resaspirante_publico[0]['hvap_observaciones'] . '</td>
                    </tr>';
                $html .= '</table>';
            }

            $pdf->writeHTML($html, true, false, true, false, '');

            // Valida Seguridad Social
            $aspirante_segsocial = new hv_aspirante_seguridad_socialModel();
            $aspirante_segsocial->hvass_aspirante=$id_aspirante_consulta;
            $resaspirante_segsocial=$aspirante_segsocial->listDetail();

            if (!isset($resaspirante_segsocial[0])) {
                $resaspirante_segsocial=array();
            }

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Seguridad Social</b></td>
                </tr>';
            $html .= '</table>';


            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>EPS:</b><br>'.$resaspirante_segsocial[0]['hvass_eps'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Fondo de pensión:</b><br>'.$resaspirante_segsocial[0]['hvass_pension'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Fondo de cesantías:</b><br>'.$resaspirante_segsocial[0]['hvass_cesantias'] . '</td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Fondo voluntario de pensión:</b><br>'.$resaspirante_segsocial[0]['hvass_pension_voluntario'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Medicina prepagada:</b><br>'.$resaspirante_segsocial[0]['hvass_prepagada'] . '</td>
                </tr>';
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');

            // Valida Declaraciones y Autorizaciones
            $aspirante_autorizaciones = new hv_aspirante_autorizacionesModel();
            $aspirante_autorizaciones->hvada_aspirante=$id_aspirante_consulta;
            $resaspirante_autorizaciones=$aspirante_autorizaciones->listDetail();

            if (!isset($resaspirante_autorizaciones[0])) {
                $resaspirante_autorizaciones=array();
            }

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Declaraciones y Autorizaciones</b></td>
                </tr>';
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');

            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 7);
            $pdf->MultiCell('', 1, '<b>Veracidad de la Información Proporcionada</b><br><br>Con la firma del  presente documento declaro que la información aquí contenida y suministrada durante el proceso de selección es veráz y que puede ser constatada en cualquier momento, asumiendo la responsabilidad en los eventos en que se presente cualquier falsedad frente a la misma.', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->MultiCell('', 1, '<b>Si, acepto</b> ', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            $pdf->SetFont('Helvetica', '', 1);
            $pdf->MultiCell('', 1, '', '', 'L', 0, 1, '', '');

            //HR SEPARADOR SECCIONES
            $pdf->SetFont('Helvetica', '', 3);
            $pdf->MultiCell('', 1, '<hr style="color: E2E8F0;">', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);


            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 7);
            $pdf->MultiCell('', 1, '<b>Declaración de Origen de Fondos y Prevención de Lavado de Activos y Financiación del Terrorismo - SAGRILAFT</b>
            <br><br>Declaro que los recursos utilizados o a utilizarse en cualquier relación contractual con la IMAGE QUALITY OUTSOURCING S.A.S., provienen de actividades lícitas; por tal razón, manifiesto que los recursos a utilizar en la relación contractual, no desarrollan o provienen de ninguna actividad ilícita de las contempladas en el Código Penal Colombiano o en cualquier norma que lo modifique o adicione. Igualmente, declaro que los recursos que se deriven del desarrollo de la relación contractual no se destinarán a la financiación del terrorismo, grupos terroristas o actividades terroristas.
            
            <br><br>Por ende, declaro bajo la gravedad de juramento que no me encuentro incluido en ninguna lista restrictiva como la lista OFAC o similares, ni he sido vinculado a investigación alguna ante cualquier autoridad como resultado de investigaciones en procesos de extinción de dominio, no he sido condenado, y no se ha emitido en mi contra sentencia o fallo en relación con las conductas mencionadas en este párrafo. Así mismo, declaro: Que la Información suministrada es veraz y verificable para el cumplimiento de la normatividad relacionada con prevención y control de lavado de activos y de la financiación del terrorismo y me comprometo a actualizar anualmente mis datos, suministrando la totalidad de los soportes que sean requieran.
            
            <br><br>Compromiso: Me comprometo a suministrar al Oficial de Cumplimiento de IMAGE QUALITY OUTSOURCING S.A.S. toda la información requerida frente al SAGRILAFT, dar a conocer cualquier inquietud que me surja sobre el mismo, y dar cumplimiento estricto a cada una de las políticas y procedimientos allí descritos, así como a las normas que obligan a actualizar mis datos personales e información financiera al menos una vez por año.', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->MultiCell('', 1, '<b>Si, acepto</b> ', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            $pdf->SetFont('Helvetica', '', 1);
            $pdf->MultiCell('', 1, '', '', 'L', 0, 1, '', '');

            //HR SEPARADOR SECCIONES
            $pdf->SetFont('Helvetica', '', 3);
            $pdf->MultiCell('', 1, '<hr style="color: E2E8F0;">', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);


            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 7);
            $pdf->MultiCell('', 1, '<b>Protección y Tratamiento de Datos Personales</b>
                <br><br>Autorización para el tratamiento de datos personales: Autorizo expresa e inequívocamente a IMAGE QUALITY OUTSOURCING S.A.S. (en adelante la “EMPRESA”), NIT 830.039.329-8, ubicada en la Carrera 13A No. 29-24, Teléfono (1) 593 1990, para que trate todos los datos que aquí se suministran y de los que posteriormente se suministren en desarrollo de la relación comercial contractual, declaro haber obtenido autorización para el tratamiento en los términos de la normatividad vigente. Finalidades: 1) Cumplir con las solicitudes de productos y/o de servicios realizados por la EMPRESA; 2) Cumplir con las solicitudes de productos y/o de servicios, 3) Realizar gestión, verificación y manejo de información financiera, contable, fiscal, administrativa y de facturación; 4) Verificar toda la información suministrada, realizar reportes de información contable, crediticia y financiera a centrales de riesgo e información financiera; 5) Consultar en listas restrictivas a todas las personas relacionadas y los que posteriormente se suministren; 6) Realizar pagos electrónicos y los diferentes medios derivados de la relación que vincula a las partes; 7) Realizar gestión y manejo de las relaciones comerciales establecidas o por establecer con los 3ros y los vinculados a los anteriores; 8) Suministrar y recibir información de material relacionado con el portafolio de productos y/o servicios de la EMPRESA, así como de noticias y nuevos lanzamientos por cualquier canal de comunicación; 9) Realizar gestión comercial, de mercadeo y publicidad de los productos y/o servicios ofrecidos por la EMPRESA; 10) Realizar gestión para la atención de PQR, campañas de actualización de datos y cambios, encuestas de opinión; 11) Captura de datos biométricos (datos sensibles) a través de registros fotográficos o de video para fines administrativos, comerciales, de publicidad, así como identificación, seguridad y la prevención de fraude interno y externo.; 12) Transmitir y/o transferir todos los datos personales a terceras personas según se requiera la vinculación contractual; 13) Atender visita domiciliaria o de establecimiento de comercio, 14) Las demás finalidades establecidas en la Política de Protección y Tratamiento de datos publicada en la página web https://www.iqoutsourcing.com/. Respecto de los datos personales que correspondan a titulares distintos de quien suscribe, éste manifiesta contar con la autorización para suministrar los datos a la EMPRESA y dar la presente autorización. Quien firma declara haber sido informado sobre los derechos que le asisten a los titulares de los datos personales, específicamente los de conocer, actualizar y eliminar sus datos personales, ser informado sobre el uso que se les ha dado, solicitar prueba de la autorización otorgada, presentar PQR ante la SIC por infracción a la ley, revocar la autorización y/o solicitar la supresión de sus datos, acceder a los mismos y abstenerse de suministrar datos sensibles o de menores de edad. Todo lo anterior de conformidad con la política de tratamiento de datos personales adoptada por la EMPRESA, la cual se me ha informado se encuentra disponible para pública consulta en la dirección web www.iqoutsourcing.com. La vigencia de la autorización para tratamiento de datos personales corresponderán al término que dure la relación entre las partes, de acuerdo con las finalidades que justificaron el tratamiento y/o al término que disponga la ley aplicable según la naturaleza de los datos.
                <br><br>
                Las peticiones, consultas y reclamos formulados por los titulares de Datos Personales bajo Tratamiento de IMAGE QUALITY OUTSOURCING S.A.S. para ejercer sus derechos a conocer, actualizar, rectificar y suprimir datos, o revocar la autorización deberán ser dirigidas a:
                <br><br>
                <br>• Oficial de Protección de Datos Personales: Calle 28 # 13-22, pisos 5 y 6, en Bogotá, D.C.
                <br>• Teléfono: (57) (601) 307 30 61
                <br>• Correo electrónico: privacidad@iq-online.com							
                <br><br><br>
                <b>Autorizo:</b> De manera irrevocable a IMAGE QUALITY OUTSOURCING S.A.S.  para solicitar, consultar, procesar, suministrar, reportar o divulgar a cualquier entidad válidamente autorizada para manejar o administrar bases de datos, incluidas las entidades gubernamentales, información contenida en este formulario y demás información relativa al cumplimiento de mis obligaciones legalmente adquiridas.								
                <br><br>
                <b>Acuerdo de protección y tratamiento de datos personales:</b> En relación con los datos personales que las partes se hayan comunicado o llegaren a comunicar recíprocamente como consecuencia o con ocasión de un vínculo o relación comercial/contractual vigente, estas se obligan a: 1) Efectuar el tratamiento de los datos personales de conformidad con las Políticas de Protección y Tratamiento de Datos Personales de cada una de ellas y la normatividad vigente que resulte aplicable; 2) Salvaguardar la seguridad de las bases de datos en las que se almacenen los datos personales, empleando medidas de seguridad razonables; 3) Guardar máxima confidencialidad respecto de los datos personales a los que tenga acceso en virtud de la relación contractual que las une, 4) realizar el tratamiento exclusivamente para las finalidades autorizadas; 5) cumplir con todas las obligaciones que resulten a su cargo, en la calidad de responsable o encargado del tratamiento de los datos personales, según el caso. Todo lo cual efectuará de conformidad con lo descrito en la ley 1581 de 2012 y sus concordantes y  con la política de privacidad descrita en la página www.iqoutsourcing.com acerca de la cual he sido informado.', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->MultiCell('', 1, '<b>Si, acepto</b><br><br>', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            $pdf->SetFont('Helvetica', '', 1);
            $pdf->MultiCell('', 1, '', '', 'L', 0, 1, '', '');

            // Valida Autorización Tratamiento Datos Personales
            $aspirante_tratamiento_datos = new hv_aspirante_autorizacionesModel();
            $aspirante_tratamiento_datos->hvada_aspirante=$id_aspirante_consulta;
            $resaspirante_tratamiento_datos=$aspirante_tratamiento_datos->listDetail();

            if (!isset($resaspirante_tratamiento_datos[0])) {
                $resaspirante_tratamiento_datos=array();
            }

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Autorización para el Tratamiento de Datos Personales</b></td>
                </tr>';
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');
            
            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 7);
            $pdf->MultiCell('', 1, 'Cumpliendo lo dispuesto en la Ley 1581 de 2012, “Por el cual se dictan disposiciones para la protección de datos personales” y de conformidad con lo señalado en el Decreto 1377 de 2013, con la firma de este documento manifiesto que he sido informado de lo siguiente:

                <br><br>1. IMAGE QUALITY OUTSOURCING S.A.S. (IQ Outsourcing o la Compañía), durante el proceso de selección en el que participo y/o en virtud de la vinculación laboral o contractual que tengo con la Compañía como empleado, aprendiz SENA o practicante, ha conocido o conocerá mi información personal a través de los diferentes canales de comunicación o de los documentos por medio los cuales se formaliza mi vinculación. Respecto de esta información, IQ Outsourcing actuará como Responsable del Tratamiento, el cual realizará para las siguientes finalidades:
                <br><br>a. Realizar pruebas psicotécnicas, pruebas de conocimiento, estudios de seguridad y exámenes médicos directamente por la Compañía o a través de terceros.
                <br>b. Realizar todas las actividades relativas a la contratación y manejo de relaciones laborales.
                <br>c. Realizar las actividades necesarias para dar cumplimiento a las obligaciones legales y contractuales en relación con los empleados y exempleados de la Compañía.
                <br>d. Controlar el cumplimiento de requisitos relacionados con el Sistema General de Seguridad Social.
                <br>e. Facilitar, coordinar y supervisar el cumplimiento de la labor para la cual fue contratado el personal (empleados, aprendices SENA, practicantes) de manera directa -personal-, o a través de herramientas tecnológicas tales como plataformas de chat y videollamadas, correos electrónicos, números telefónicos.
                <br>f. Verificar y supervisar la productividad de los trabajadores, aprendices SENA y practicantes, a través de cualquier mecanismo y medio definido por la Compañía.
                <br>g. Mantener un archivo digital y/o físico que permita contar con la información correspondiente a la historia laboral, incluida la hoja de vida, de cada empleado o exempleado de la compañía.
                <br>h. Verificar datos de estudio, experiencia laboral, referencias laborales y personales mediante fuentes públicas y/o privadas. Así mismo, para certificar experiencia solicitada por terceros cuando sea candidato para laborar en otras compañías.
                <br>i. Realizar investigaciones administrativas y/o disciplinarias cuando a ello haya lugar.
                <br>j. En caso de datos biométricos capturados a través de sistemas de videovigilancia o grabación, su tratamiento tendrá como finalidad la identificación, seguridad y la prevención de fraude interno y externo, así como el control de acceso a las instalaciones físicas o a los sistemas de comunicación a través de los cuales se prestan los servicios.
                <br>k. Los datos personales de menores, en caso de ser requeridos, serán tratados con la finalidad de dar cumplimiento a las obligaciones legales y lo dispuesto en la política de Protección y Datos personales de la compañía.
                <br>l. Para el caso de los participantes en procesos de selección, los datos personales tratados tendrán como finalidad, además de las ya señaladas, adelantar las gestiones de los procesos de selección; las hojas de vida se gestionarán garantizando el principio de acceso restringido. Así mismo, las hojas de vida podrán conservarse para efectos de contar con información de posibles candidatos para futuros procesos de contratación y contactarlos en caso de requerirse.
                <br>m. Mantener informados a los empleados sobre los eventos, noticias, recomendaciones, políticas, y en general toda información que la Compañía considere pertinente informar a su personal.
                <br>n. Realizar encuestas, evaluaciones y cuestionarios para el análisis y toma de decisiones de carácter laboral por parte de la Compañía, tales como evaluaciones de desempeño, evaluación del clima laboral, recopilación de información sobre condiciones físicas y tecnológicas en los hogares cuando se trata de trabajo remoto o teletrabajo, información de carácter sanitario, entre otros.
                <br>o. Consultar en las diferentes listas restrictivas que establezca la Compañía en el marco de su política SAGRILAFT, Programa de Transparencia y Ética Empresarial, y la debida diligencia para el conocimiento de las contrapartes. Igualmente, se consultará el estado o antecedentes, siempre que ello se considere pertinente, en las bases de información pública de la Registraduría Nacional, Contraloría General de la República, Procuraduría General de la Nación, Policía Nacional y Boletín de deudores morosos del Estado, y verificar antecedentes de crédito y hacer los reportes correspondientes ante centrales de información crediticia.
                <br>p. Gestionar el proceso contable y de nómina de la Compañía.
                <br>q. Transmitir la información a encargados nacionales o internacionales con los que se tenga una relación operativa que provean los servicios necesarios para la debida operación de la Compañía.
                <br>r. Compartir los datos personales con autoridades nacionales o extranjeras cuando la solicitud se base en razones legales y procesales, fundamentados en causas legítimas tales como lo son temas legales o de carácter tributario. En todo caso, la información compartida deberá ser estrictamente la solicitada por la autoridad competente.
                <br>s. Compartir los datos personales, hojas de vidas y los soportes que acrediten la información allí relacionada, con los Clientes para los cuales se preste o se vaya a prestar el servicio, con el objeto de que éstos puedan validar la información que requieran en el marco de los contratos suscritos o por suscribirse entre aquellos e IQ.
                <br>t. Para la expedición de certificaciones laborales y suministro de información por solicitud de terceros en los procesos de selección en los que el personal (empleados, aprendices SENA, practicantes) se encuentren participando.
                <br>u. Para compartir la información con los terceros con los que la Compañía tiene convenios de libranza o en el marco de las actividades de bienestar, siempre que el personal (empleados, aprendices SENA, practicantes) estén interesados en acceder a dichos convenios.
                <br>v. Para contactarlo por cualquier medio (ej. Telefónico, correo electrónico), de los reportados a la Compañía, bien sea personal o laboral, con el fin de darle información o lineamientos de ésta.
                
                <br><br>2. IQ Outsourcing no tratará datos personales sensibles, salvo que se cuente con la autorización explícita del titular y las demás excepciones establecidas en la Ley 1581 de 2012.
                
                <br><br>3. Los derechos de los Titulares de los datos son los previstos en la Política de Protección y Tratamiento de Datos Personales de la Compañía, la Constitución Política de Colombia y en la Ley 1581 de 2012. Estos derechos podrán ser ejercidos a través de los siguientes canales:
                
                <br><br>- Oficial de Protección de Datos Personales: Calle 28 # 13-22, pisos 5 y 6, en Bogotá, D.C.
                <br>- Teléfono: (57) (601) 307 30 61
                <br>- Correo electrónico: privacidad@iq-online.com
                
                <br><br>En virtud de lo anterior, OTORGO AUTORIZACIÓN de manera libre, voluntaria, explícita, informada e inequívoca a IQ Outsourcing para que realice el tratamiento de mis datos personales de conformidad con las finalidades antes descritas y la Política de Protección y Tratamiento de Datos Personales de la Compañía. Entiendo que esta autorización para adelantar el tratamiento de datos personales se extiende mientras persista el vínculo con la Compañía y con posterioridad al finiquito de este, siempre que tal tratamiento se encuentre relacionado con las finalidades para las cuales los datos personales, fueron inicialmente suministrados.', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            // Valida Firma
            $aspirante_documentos = new hv_aspirante_documentoModel();
            $aspirante_documentos->hvad_aspirante=$id_aspirante_consulta;
            $aspirante_documentos->hvad_tipo='firma'; 
            $resaspirante_documentos=$aspirante_documentos->listDetailAll();

            if (!isset($resaspirante_documentos[0])) {
                $resaspirante_documentos=array();
            }

            //HR SEPARADOR SECCIONES
            // $pdf->SetFont('Helvetica', '', 3);
            // $pdf->MultiCell('', 1, '<hr style="color: E2E8F0;">', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            $pdf->SetFont('Helvetica', '', 8);
            $pdf->MultiCell('', 6, '', '', 'L', 0, 1, '', '');
            // Guardar la posición actual
            $posicionAntesDeFirma = $pdf->getY();

            // Agregar la firma después de la línea
            if ($resaspirante_documentos[0]['hvad_ruta']!='') {
                $imagenFirma = UPLOADS_ROOT_ASSETS.$resaspirante_documentos[0]['hvad_ruta'];
                $anchoFirma = 30; // ajusta el ancho de la firma según sea necesario
    
                if (file_exists($imagenFirma)) {
                    $pdf->Image($imagenFirma, 15, $posicionAntesDeFirma + 5, $anchoFirma);
                }
            }


            $pdf->MultiCell(90, 40, 'Firma,', '', 'L', 0, 1, '', '');
            
            $pdf->MultiCell(160, 4, 'Nombres y apellidos: '.$resaspirante[0]['hva_nombres'].' '.$resaspirante[0]['hva_nombres_2'].' '.$resaspirante[0]['hva_apellido_1'].' '.$resaspirante[0]['hva_apellido_2'], '', 'L', 0, 1, '', '');
            $pdf->MultiCell(160, 4, 'Identificación: '.$resaspirante[0]['hva_identificacion'], '', 'L', 0, 1, '', '');
            // $pdf->MultiCell(70, 4, 'Fecha: '.$resaspirante[0]['ea_identificacion'], '', 'L', 0, 1, '', '');

            

            //Firma responsable para menor de edad
            $aspirante_documentos = new hv_aspirante_documentoModel();
            $aspirante_documentos->hvad_aspirante=$id_aspirante_consulta;
            $aspirante_documentos->hvad_tipo='firma_padre'; 
            $resaspirante_documentos=$aspirante_documentos->listDetailAll();

            if (!isset($resaspirante_documentos[0])) {
                $resaspirante_documentos=array();
            }

            if (count($resaspirante_documentos)>0) {
                $pdf->SetFont('Helvetica', '', 8);
                $pdf->MultiCell('', 6, '', '', 'L', 0, 1, '', '');
                $pdf->MultiCell('', 6, '', '', 'L', 0, 1, '', '');
                // Guardar la posición actual
                $posicionAntesDeFirma = $pdf->getY();
    
                // Agregar la firma después de la línea
                $imagenFirma = UPLOADS_ROOT_ASSETS.$resaspirante_documentos[0]['hvad_ruta'];
                $anchoFirma = 30; // ajusta el ancho de la firma según sea necesario
    
                if (file_exists($imagenFirma)) {
                    $pdf->Image($imagenFirma, 15, $posicionAntesDeFirma + 5, $anchoFirma);
                }
    
                $pdf->MultiCell(90, 40, 'Firma Autorización,', '', 'L', 0, 1, '', '');
                
                $pdf->MultiCell(160, 4, 'Nombres y apellidos: '.$resaspirante[0]['hva_auxiliar_3'], '', 'L', 0, 1, '', '');
                $pdf->MultiCell(160, 4, 'Identificación: '.$resaspirante[0]['hva_auxiliar_4'], '', 'L', 0, 1, '', '');
                // $pdf->MultiCell(70, 4, 'Fecha: '.$resaspirante[0]['ea_identificacion'], '', 'L', 0, 1, '', '');
            }

            $ruta_hoja_vida=UPLOADS_ROOT_ASSETS.'aspirante_documentos/'.$resaspirante[0]['hva_id'].'/FORMATO HOJA DE VIDA-'.$resaspirante[0]['hva_nombres'].' '.$resaspirante[0]['hva_nombres_2'].' '.$resaspirante[0]['hva_apellido_1'].' '.$resaspirante[0]['hva_apellido_2'].'.pdf';
            
            if ($accion=='Descargar') {
                $pdf->Output($ruta_hoja_vida, 'D');
            } elseif ($accion=='Ver') {
                $pdf->Output($ruta_hoja_vida, 'I');
            }

            $data =
            [
                
            ];
        }

        public static function hoja_vida_consolidado_descargar($id_registro) {
            $modulo_plataforma="1";
            Controller::checkSesion();
            // error_reporting(E_ALL);
            // ini_set('display_errors', '1');
            $id_aspirante_consulta=checkInput(base64_decode($id_registro));

            // Valida Información Personal
            $aspirante = new hv_aspiranteModel();
            $aspirante->hva_id=$id_aspirante_consulta;
            $resaspirante=$aspirante->listDetail();

            if (!isset($resaspirante[0])) {
                $resaspirante=array();
            }

            //GENERA HOJA DE VIDA DIGITAL Y GUARDA EN RUTA ABSOLUTA
            //PDF TCPDF
            $pdf = new CustomTCPDF('P', 'mm', array(216, 355.6), true, 'UTF-8');
            // $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetCreator('Tu nombre');
            $pdf->SetAuthor('Tu nombre');
            $pdf->SetTitle('Formato Hoja de Vida Digital');
            // set default header data PDF_HEADER_LOGO
            // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);
            // set header and footer fonts
            // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            
            $pdf->SetFont('Helvetica', '', 8);

            $pdf->AddPage();
            // $tagvs = array('p' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 0)));
            // $pdf->setHtmlVSpace($tagvs);

            // Función para crear una celda con esquinas redondeadas
            function getRoundedCell($pdf, $content, $radius, $width) {
                $imgBorderStyle = ['width' => 0,'cap' => 'square','join' => 'miter','dash' => '0','color' => [226, 232, 240]];

                $pdf->SetFont('Helvetica', '', 8);
                $pdf->SetX($pdf->GetX() + 2);
                $pdf->SetFillColor(226, 232, 240); // Color de relleno (Gris claro)
                $pdf->SetTextColor(0, 0, 0); // Color de texto negro
                $pdf->setCellPadding(1);
                $pdf->RoundedRect($pdf->GetX(), $pdf->GetY(), $width, 9, $radius, '1111', 'DF', $imgBorderStyle);
                $pdf->MultiCell($width, 8, $content, 0, 'L', 0, 0, $pdf->GetX(), $pdf->GetY(), true, 0, true, true, 0);
                // $pdf->MultiCell($width, 6, $content, 0, 'L', 0, 0, $pdf->GetX(), $pdf->GetY(), true, 0, true, true, 0);
                // MultiCell($w, $h, 'text<br />', $border=0, $align='L', $fill=1, $ln=0, $x='', $y='', $reseth=true, $reseth=0, $ishtml=true, $autopadding=true, $maxh=0);
                return '';
            }

            // Función para crear una celda con esquinas redondeadas
            function getRoundedTitle($pdf, $content, $radius, $width) {
                $imgBorderStyle = ['width' => 0,'cap' => 'square','join' => 'miter','dash' => '0','color' => [28, 34, 98]];

                $pdf->SetFont('Helvetica', '', 11);
                $pdf->SetX($pdf->GetX() + 0);
                $pdf->SetFillColor(28, 34, 98); // Color de relleno (Gris claro)
                $pdf->SetTextColor(255, 255, 255); // Color de texto blanco
                $pdf->setCellPadding(1);
                $pdf->RoundedRect($pdf->GetX(), $pdf->GetY(), $width, 7, $radius, '1111', 'DF', $imgBorderStyle);
                $pdf->MultiCell($width, 7, $content, 0, 'L', 0, 0, $pdf->GetX(), $pdf->GetY(), true, 0, true, true, 0);
                // $pdf->MultiCell($width, 6, $content, 0, 'L', 0, 0, $pdf->GetX(), $pdf->GetY(), true, 0, true, true, 0);
                // MultiCell($w, $h, 'text<br />', $border=0, $align='L', $fill=1, $ln=0, $x='', $y='', $reseth=true, $reseth=0, $ishtml=true, $autopadding=true, $maxh=0);
                return '';
            }

            // Define el radio para las esquinas redondeadas
            $radius = 1;

            // Valida Información Personal
            $aspirante = new hv_aspiranteModel();
            $aspirante->hva_id=$id_aspirante_consulta;
            $resaspirante=$aspirante->listDetail();

            if (!isset($resaspirante[0])) {
                $resaspirante=array();
            }

            // Valida Información en caso de Emergencia
            $aspirante_emergencia = new hv_aspirante_emergenciaModel();
            $aspirante_emergencia->hvaem_aspirante=$id_aspirante_consulta;
            $resaspirante_emergencia=$aspirante_emergencia->listDetail();

            if (!isset($resaspirante_emergencia[0])) {
                $resaspirante_emergencia=array();
            }

            // $pdf->SetFont('Helvetica', '', 11);
            // $pdf->SetTextColor(255, 255, 255); // Color de texto blanco
            
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->SetTextColor(0, 0, 0); // Color de texto negro

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Información Personal</b></td>
                </tr>';
            $html .= '</table>';

            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Primer nombre:</b><br>'.$resaspirante[0]['hva_nombres'].'</td>
                <td style="background-color: #E2E8F0;"><b>Segundo nombre:</b><br>'.$resaspirante[0]['hva_nombres_2'].'</td>
                <td style="background-color: #E2E8F0;"><b>Primer apellido:</b><br>'.$resaspirante[0]['hva_apellido_1'].'</td>
                <td style="background-color: #E2E8F0;"><b>Segundo apellido:</b><br>'.$resaspirante[0]['hva_apellido_2'].'</td>
                
                </tr>';
            $html .= '</table>';

            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Doc. identidad:</b><br>'.$resaspirante[0]['hva_identificacion'].'</td>
                <td style="background-color: #E2E8F0;"><b>Fecha expedición:</b><br>'.$resaspirante[0]['hva_auxiliar_5'].'</td>
                <td style="background-color: #E2E8F0;"><b>Dirección:</b><br>'.$resaspirante[0]['hva_direccion']. '</td>
                <td style="background-color: #E2E8F0;"><b>Barrio:</b><br>'.$resaspirante[0]['hva_barrio']. '</td>
                </tr>';
            $html .= '</table>';

            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Ciudad:</b><br>'.$resaspirante[0]['ciu_municipio'].', '.$resaspirante[0]['ciu_departamento']. '</td>
                <td style="background-color: #E2E8F0;"><b>Celular:</b><br>'.$resaspirante[0]['hva_celular'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Celular alternativo:</b><br>'.$resaspirante[0]['hva_celular_2'] . '</td>
                <td style="background-color: #E2E8F0;"><b>E-mail:</b><br>'.$resaspirante[0]['hva_correo'] . '</td>
                </tr>';
            $html .= '</table>';

            $edad_aspirante='';
            if ($resaspirante[0]['hva_nacimiento_fecha']!='') {
                $edad_aspirante=calcularEdad($resaspirante[0]['hva_nacimiento_fecha']);
            }

            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Lugar nacimiento:</b><br>'.$resaspirante[0]['nacimiento_ciu_municipio'].', '.$resaspirante[0]['nacimiento_ciu_departamento'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Fecha nacimiento:</b><br>'.$resaspirante[0]['hva_nacimiento_fecha'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Edad:</b><br>'.$edad_aspirante . '</td>
                <td style="background-color: #E2E8F0;"><b>Estado civil:</b><br>'.$resaspirante[0]['hva_estado_civil'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Género:</b><br>'.$resaspirante[0]['hva_genero'] . '</td>
                </tr>';
            $html .= '</table>';

            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Grupo sanguíneo:</b><br>'.$resaspirante_emergencia[0]['hvaem_grupo_sanguineo'] . '</td>
                <td style="background-color: #E2E8F0;"><b>RH:</b><br>'.$resaspirante_emergencia[0]['hvaem_rh'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Operador de internet:</b><br>'.$resaspirante[0]['hva_operador_internet'] . '</td>
                </tr>';
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Información en caso de Emergencia</b></td>
                </tr>';
            $html .= '</table>';

            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Nombres y apellidos:</b><br>'.$resaspirante_emergencia[0]['hvaem_nombres_apellidos'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Parentesco:</b><br>'.$resaspirante_emergencia[0]['hvaem_parentesco'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Teléfono:</b><br>'.$resaspirante_emergencia[0]['hvaem_telefono'] . '</td>
                </tr>';
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');

            // Valida Información Familiar
            $aspirante_familiar = new hv_aspirante_familiarModel();
            $aspirante_familiar->hvaf_aspirante=$id_aspirante_consulta;
            $resaspirante_familiar=$aspirante_familiar->listDetail();

            if (!isset($resaspirante_familiar[0])) {
                $resaspirante_familiar=array();
            }

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Información Familiar</b></td>
                </tr>';
            $html .= '</table>';
            
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                        <td align="center" style="background-color: #E2E8F0;" width="223"><b>Nombres y Apellidos</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="140"><b>Parentesco</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="50"><b>Edad</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="50"><b>A cargo?</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="50"><b>Convive?</b></td>
                    </tr>';

            for ($i=0; $i < count($resaspirante_familiar); $i++) { 
                $html .= '
                    <tr>
                        <td align="center" style="background-color: #E2E8F0;" width="223">'.$resaspirante_familiar[$i]['hvaf_nombres_apellidos'].'</td>
                        <td align="center" style="background-color: #E2E8F0;" width="140">'.$resaspirante_familiar[$i]['hvaf_parentesco'].'</td>
                        <td align="center" style="background-color: #E2E8F0;" width="50">'.$resaspirante_familiar[$i]['hvaf_edad'].'</td>
                        <td align="center" style="background-color: #E2E8F0;" width="50">'.$resaspirante_familiar[$i]['hvaf_acargo'].'</td>
                        <td align="center" style="background-color: #E2E8F0;" width="50">'.$resaspirante_familiar[$i]['hvaf_convive'].'</td>
                    </tr>';
            }
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, false, false, '');

            // Valida Estudios Culminados
            $aspirante_estudio_culminado = new hv_aspirante_estudio_terminadoModel();
            $aspirante_estudio_culminado->hvaet_aspirante=$id_aspirante_consulta;
            $resaspirante_estudio_culminado=$aspirante_estudio_culminado->listDetail();

            if (!isset($resaspirante_estudio_culminado[0])) {
                $resaspirante_estudio_culminado=array();
            }

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Estudios Culminados</b></td>
                </tr>';
            $html .= '</table>';
            
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                        <td align="center" style="background-color: #E2E8F0;" width="80"><b>Nivel</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="95"><b>Establecimiento</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="95"><b>Título</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="80"><b>Ciudad</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="55"><b>Fecha Inicio</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="55"><b>Fecha Terminación</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="50"><b>Tarjeta Profesional</b></td>
                    </tr>';

            for ($i=0; $i < count($resaspirante_estudio_culminado); $i++) { 
                $html .= '
                    <tr>
                        <td align="center" style="background-color: #E2E8F0;" width="80">'.$resaspirante_estudio_culminado[$i]['hvaet_nivel'].'</td>
                        <td align="center" style="background-color: #E2E8F0;" width="95">'.$resaspirante_estudio_culminado[$i]['hvaet_establecimiento'].'</td>
                        <td align="center" style="background-color: #E2E8F0;" width="95">'.$resaspirante_estudio_culminado[$i]['hvaet_titulo'].'</td>
                        <td align="center" style="background-color: #E2E8F0;" width="80">'.$resaspirante_estudio_culminado[$i]['ciu_municipio'].', '.$resaspirante_estudio_culminado[$i]['ciu_departamento'] . '</td>
                        <td align="center" style="background-color: #E2E8F0;" width="55">'.$resaspirante_estudio_culminado[$i]['hvaet_fecha_inicio'].'</td>
                        <td align="center" style="background-color: #E2E8F0;" width="55">'.$resaspirante_estudio_culminado[$i]['hvaet_fecha_terminacion'].'</td>
                        <td align="center" style="background-color: #E2E8F0;" width="50">'.$resaspirante_estudio_culminado[$i]['hvaet_tarjeta_profesional'].'</td>
                    </tr>';
            }
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, false, false, '');

            // //HR SEPARADOR SECCIONES
            // $pdf->SetFont('Helvetica', '', 3);
            // $pdf->MultiCell('', 1, '<hr style="color: E2E8F0;">', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            

            // Valida Estudios Curso
            $aspirante_estudio_curso = new hv_aspirante_estudio_cursoModel();
            $aspirante_estudio_curso->hvaec_aspirante=$id_aspirante_consulta;
            $resaspirante_estudio_curso=$aspirante_estudio_curso->listDetail();

            if (!isset($resaspirante_estudio_curso[0])) {
                $resaspirante_estudio_curso=array();
            }

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Estudios en Curso</b></td>
                </tr>';
            $html .= '</table>';
            
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                        <td align="center" style="background-color: #E2E8F0;" width="80"><b>Nivel</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="95"><b>Entidad Educativa</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="90"><b>Título a Obtener</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="80"><b>Ciudad</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="53"><b>Horario</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="57"><b>Modalidad</b></td>
                        <td align="center" style="background-color: #E2E8F0;" width="55"><b>Fecha Terminación Proyectada</b></td>
                    </tr>';
                    
            for ($i=0; $i < count($resaspirante_estudio_curso); $i++) { 
                $html .= '
                <tr>
                    <td align="center" style="background-color: #E2E8F0;" width="80">'.$resaspirante_estudio_curso[$i]['hvaec_nivel'].'</td>
                    <td align="center" style="background-color: #E2E8F0;" width="95">'.$resaspirante_estudio_curso[$i]['hvaec_establecimiento'].'</td>
                    <td align="center" style="background-color: #E2E8F0;" width="90">'.$resaspirante_estudio_curso[$i]['hvaec_titulo'].'</td>
                    <td align="center" style="background-color: #E2E8F0;" width="80">'.$resaspirante_estudio_curso[$i]['ciu_municipio'].', '.$resaspirante_estudio_curso[$i]['ciu_departamento'] . '</td>
                    <td align="center" style="background-color: #E2E8F0;" width="53">'.$resaspirante_estudio_curso[$i]['hvaec_horario'].'</td>
                    <td align="center" style="background-color: #E2E8F0;" width="57">'.$resaspirante_estudio_curso[$i]['hvaec_modalidad'].'</td>
                    <td align="center" style="background-color: #E2E8F0;" width="55">'.$resaspirante_estudio_curso[$i]['hvaec_fecha_terminacion'].'</td>
                </tr>';
            }
            $html .= '</table>';
                    

            $pdf->writeHTML($html, true, false, false, false, '');

            // Valida Experiencia Laboral
            $aspirante_experiencia = new hv_aspirante_experienciaModel();
            $aspirante_experiencia->hvaex_aspirante=$id_aspirante_consulta;
            $resaspirante_experiencia=$aspirante_experiencia->listDetail();

            if (!isset($resaspirante_experiencia[0])) {
                $resaspirante_experiencia=array();
            }

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Experiencia Laboral</b></td>
                </tr>';
            $html .= '</table>';
            // $pdf->writeHTML($html, true, false, true, false, '');
            for ($i=0; $i < count($resaspirante_experiencia); $i++) { 
                if ($i>0) {
                    //HR SEPARADOR SECCIONES
                    // $pdf->SetFont('Helvetica', '', 3);
                    // $pdf->MultiCell('', 1, '<hr style="color: E2E8F0;">', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);
                }
                
                // Crea una tabla HTML con celdas redondeadas
                $html .= '<table cellspacing="2" cellpadding="3">';
                $html .= '<tr>
                    <td style="background-color: #E2E8F0;"><b>Nombre de la empresa:</b><br>'.$resaspirante_experiencia[$i]['hvaex_empresa'].'</td>
                    <td style="background-color: #E2E8F0;"><b>Cargo:</b><br>'.$resaspirante_experiencia[$i]['hvaex_cargo'].'</td>
                    <td style="background-color: #E2E8F0;"><b>Fecha inicio:</b><br>'.$resaspirante_experiencia[$i]['hvaex_fecha_inicio'].'</td>
                    <td style="background-color: #E2E8F0;"><b>Fecha retiro:</b><br>'.$resaspirante_experiencia[$i]['hvaex_fecha_retiro'].'</td>
                    </tr>';
                $html .= '</table>';
                // $pdf->writeHTML($html, true, false, true, false, '');
    
                // Crea una tabla HTML con celdas redondeadas
                $html .= '<table cellspacing="2" cellpadding="3">';
                $html .= '<tr>
                    <td style="background-color: #E2E8F0;"><b>Ciudad:</b><br>'.$resaspirante_experiencia[$i]['ciu_municipio'].', '.$resaspirante_experiencia[$i]['ciu_departamento'] . '</td>
                    <td style="background-color: #E2E8F0;"><b>Nombre jefe inmediato:</b><br>'.$resaspirante_experiencia[$i]['hvaex_jefe_nombre'].'</td>
                    <td style="background-color: #E2E8F0;"><b>Cargo:</b><br>'.$resaspirante_experiencia[$i]['hvaex_jefe_cargo'].'</td>
                    </tr>';
                $html .= '</table>';
                // $pdf->writeHTML($html, true, false, true, false, '');
    
                // Crea una tabla HTML con celdas redondeadas
                $html .= '<table cellspacing="2" cellpadding="3">';
                $html .= '<tr>
                    <td style="background-color: #E2E8F0;"><b>Teléfono de referencia:</b><br>'.$resaspirante_experiencia[$i]['hvaex_telefonos'].'</td>
                    <td style="background-color: #E2E8F0;"><b>Motivo de retiro:</b><br>'.$resaspirante_experiencia[$i]['hvaex_motivo_retiro'].'</td>
                    </tr>';
                $html .= '</table>';
                // $pdf->writeHTML($html, true, false, true, false, '');
            }

            $pdf->writeHTML($html, true, false, true, false, '');


            // Valida Información Ética
            $aspirante_etica = new hv_aspirante_eticaModel();
            $aspirante_etica->hvae_aspirante=$id_aspirante_consulta;
            $resaspirante_etica=$aspirante_etica->listDetail();

            if (!isset($resaspirante_etica[0])) {
                $resaspirante_etica=array();
            }

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Código de ética, Anticorrupción y Buen Gobierno P6-A1</b></td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>¿Tiene usted familiares, conyugue y/o compañero permanente, parientes dentro del cuarto grado de consanguinidad, tercero de afinidad o único civil que actualmente trabaje en IQ?:</b> '.$resaspirante_etica[0]['hvae_familiar']. '</td>
                </tr>';
            $html .= '</table>';

            if ($resaspirante_etica[0]['hvae_familiar']=='Si') {
                // Crea una tabla HTML con celdas redondeadas
                $html .= '<table cellspacing="2" cellpadding="3">';
                $html .= '<tr>
                    <td style="background-color: #E2E8F0;"><b>Nombres y apellidos:</b><br>'.$resaspirante_etica[0]['hvae_familiar_nombre']. '</td>
                    <td style="background-color: #E2E8F0;"><b>Área:</b><br>'.$resaspirante_etica[0]['hvae_familiar_area']. '</td>
                    </tr>';
                $html .= '</table>';
            }
            
            $pdf->writeHTML($html, true, false, true, false, '');


            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 7);
            $pdf->MultiCell('', 1, 'De acuerdo con lo establecido en el Código de ética, Anticorrupción y Buen Gobierno P6-A1, está prohibido el ingreso de familiares o personas con grado de afinidad a la compañía, tal como se enuncia a continuación, si usted brinda información no veraz esto representa una falta grave al Reglamento Interno de Trabajo y Políticas de la organización, por lo que, asume la responsabilidad de cualquier falsedad frente a la misma.
            <br><br><b>GRADOS DE CONSAGUINIDAD</b>
                <br><br><b>Primer grado:</b> Mis padres, Mis hijos/as (tanto naturales como adoptivos)
                <br><b>Segundo grado:</b> Mis hermanos/as  abuelos/as Mis nietos/as
                <br><b>Tercer grado:</b> Mis tíos/as (hermanos/as de mis padres) Mis sobrinos/as (hijos/as de hermanos/as) Mis bisabuelos/as (padres de mis abuelos/as) Mis biznietos/as (hijos/as de mis nietos/as)
                <br><b>Cuarto grado:</b> Mis primos/as hermanos/as (hijos/as de los hermanos/as de mis padres)
                <br><br><b>GRADOS DE AFINIDAD</b>
                <br><br><b>Primer grado:</b> Mi cónyuge, Mis suegro/a (los padres de mi cónyuge), Los cónyuges de mis hijos/as, Cónyuge de mi padre, si no es mi madre, Cónyuge de mi madre, si no es mi padre.
                <br><b>Segundo grado:</b> Cónyuges de mis hermanos/as, Abuelos/as de mi cónyuge, Cónyuges de mis nietos/as, Mis hermanastros/as (entendiendo como hermanastro/a el hijo/a del cónyuge de mi padre/madre con el que no comparto ningún <br>lazo de sangre)
                <br><b>Tercer grado:</b> Cónyuges de mis tíos/as (cónyuges de los hermanos/as de mis padres), Cónyuges de mis sobrinos/as, Tíos de mi cónyuge y sus cónyuges
                <br><br><b>ÚNICO CIVIL:</b> Hijos adoptivos.<br><br>', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            

            // Valida Información IQ
            $aspirante_informacion = new hv_aspirante_informacionModel();
            $aspirante_informacion->hvai_aspirante=$id_aspirante_consulta;
            $resaspirante_informacion=$aspirante_informacion->listDetail();

            if (!isset($resaspirante_informacion[0])) {
                $resaspirante_informacion=array();
            }

            $pdf->SetFont('Helvetica', '', 8);
            $pdf->SetTextColor(0, 0, 0); // Color de texto negro

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Ex colaborador IQ</b></td>
                </tr>';
            $html .= '</table>';

            
            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>¿Ha trabajado anteriormente en IQ?:</b><br>'.$resaspirante_informacion[0]['hvai_excolaborador']. '</td>
                <td style="background-color: #E2E8F0;"><b>Motivo del retiro:</b><br>'.$resaspirante_informacion[0]['hvai_excolaborador_motivo']. '</td>
                <td style="background-color: #E2E8F0;"><b>Fecha de retiro:</b><br>'.$resaspirante_informacion[0]['hvai_excolaborador_fecha']. '</td>
                </tr>';
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Procesos de Selección Previos con IQ</b></td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>¿Ha presentado procesos de selección previamente en IQ?:</b><br>'.$resaspirante_informacion[0]['hvai_seleccion_previo']. '</td>
                <td style="background-color: #E2E8F0;"><b>Cargo:</b><br>'.$resaspirante_informacion[0]['hvai_seleccion_previo_cargo']. '</td>
                <td style="background-color: #E2E8F0;"><b>Fecha:</b><br>'.$resaspirante_informacion[0]['hvai_seleccion_previo_fecha']. '</td>
                </tr>';
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Trabajos Simultáneos</b></td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>¿Declara tener otro trabajo u ocupación simultánea?:</b><br>'.$resaspirante_informacion[0]['hvai_trabajo']. '</td>
                <td style="background-color: #E2E8F0;"><b>Tipo de vinculación:</b><br>'.$resaspirante_informacion[0]['hvai_trabajo_tipo']. '</td>
                </tr>';
            $html .= '</table>';
                
            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
            <td style="background-color: #E2E8F0;"><b>Nombre de la empresa:</b><br>'.$resaspirante_informacion[0]['hvai_trabajo_empresa']. '</td>
            <td style="background-color: #E2E8F0;"><b>Cargo:</b><br>'.$resaspirante_informacion[0]['hvai_trabajo_cargo']. '</td>
            </tr>';
            $html .= '</table>';
            
            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
            <td style="background-color: #E2E8F0;"><b>Ocupación o trabajo desempeñado:</b><br>'.$resaspirante_informacion[0]['hvai_ocupacion']. '</td>
            </tr>';
            $html .= '</table>';
            
            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>¿Si su ocupación actual genera conflicto de interés, estaría dispuesto a renunciar a su trabajo actual?:</b><br>'.$resaspirante_informacion[0]['hvai_conflicto_renuncia']. '</td>
                </tr>';
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');

            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 7);
            $pdf->MultiCell('', 1, 'De acuerdo con lo establecido en el Código de ética, anticorrupción y buen gobierno P6-A1, no se admite un segundo empleo o la prestación de sus servicios bajo cualquier modalidad cuando la otra parte ejecute actividades semejantes al objeto social de la Compañía y/o sea competidor de la Compañía. Un segundo empleo o acuerdo de servicios con un cliente o proveedor de la Compañía tampoco será permitido. si usted brinda información no veraz representa una falta grave y asume la responsabilidad de cualquier falsedad frente a la misma.<br><br>', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);



            // Valida Información Financiera
            $aspirante_financiera = new hv_aspirante_financieraModel();
            $aspirante_financiera->hvaf_aspirante=$id_aspirante_consulta;
            $resaspirante_financiera=$aspirante_financiera->listDetail();

            if (!isset($resaspirante_financiera[0])) {
                $resaspirante_financiera=array();
            }

            $pdf->SetFont('Helvetica', '', 8);
            $pdf->SetTextColor(0, 0, 0); // Color de texto negro

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Información Financiera</b></td>
                </tr>';
            $html .= '</table>';


            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Activos:</b><br>'.$resaspirante_financiera[0]['hvaf_activos']. '</td>
                <td style="background-color: #E2E8F0;"><b>Ingresos mensuales:</b><br>'.$resaspirante_financiera[0]['hvaf_ingresos']. '</td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Pasivos:</b><br>'.$resaspirante_financiera[0]['hvaf_pasivos']. '</td>
                <td style="background-color: #E2E8F0;"><b>Egresos mensuales:</b><br>'.$resaspirante_financiera[0]['hvaf_egresos']. '</td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Patrimonio:</b><br>'.$resaspirante_financiera[0]['hvaf_patrimonio']. '</td>
                <td style="background-color: #E2E8F0;"><b>Otros ingresos:</b><br>'.$resaspirante_financiera[0]['hvaf_ingresos_otros']. '</td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Concepto de otros ingresos:</b><br>'.$resaspirante_financiera[0]['hvaf_concepto_ingresos']. '</td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>¿Realiza Operaciones en Moneda Extranjera?:</b><br>'.$resaspirante_financiera[0]['hvaf_moneda_extranjera']. '</td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>¿Se encuentra reportado en alguna central de riesgos?:</b><br>'.$resaspirante_financiera[0]['hvaf_reporte']. '</td>
                <td style="background-color: #E2E8F0;"><b>¿Cuál?:</b><br>'.$resaspirante_financiera[0]['hvaf_reporte_cual']. '</td>
                </tr>';
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');


            // Valida Personas Expuestas Públicamente - PEP
            $aspirante_publico = new hv_aspirante_publicoModel();
            $aspirante_publico->hvap_aspirante=$id_aspirante_consulta;
            $resaspirante_publico=$aspirante_publico->listDetail();

            if (!isset($resaspirante_publico[0])) {
                $resaspirante_publico=array();
            }

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Personas Expuestas Públicamente - PEP</b></td>
                </tr>';
            $html .= '</table>';


            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>¿Maneja recursos públicos?:</b><br>'.$resaspirante_publico[0]['hvap_recursos'] . '</td>
                <td style="background-color: #E2E8F0;"><b>¿Goza de reconocimiento público general?:</b><br>'.$resaspirante_publico[0]['hvap_reconocimiento'] . '</td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>¿Ejerce algún grado de poder público?:</b><br>'.$resaspirante_publico[0]['hvap_poder'] . '</td>
                <td style="background-color: #E2E8F0;"><b>¿Tiene usted algún familiar que cumpla con una característica anterior?:</b><br>'.$resaspirante_publico[0]['hvap_familiar'] . '</td>
                </tr>';
            $html .= '</table>';

            if ($resaspirante_publico[0]['hvap_recursos']=='Si' OR $resaspirante_publico[0]['hvap_reconocimiento']=='Si' OR $resaspirante_publico[0]['hvap_poder']=='Si' OR $resaspirante_publico[0]['hvap_familiar']=='Si') {
                // Crea una tabla HTML con celdas redondeadas
                $html .= '<table cellspacing="2" cellpadding="3">';
                $html .= '<tr>
                    <td style="background-color: #E2E8F0;"><b>Si alguna de las respuestas anteriores es afirmativa, por favor especifique:</b><br>'.$resaspirante_publico[0]['hvap_observaciones'] . '</td>
                    </tr>';
                $html .= '</table>';
            }

            $pdf->writeHTML($html, true, false, true, false, '');

            // Valida Seguridad Social
            $aspirante_segsocial = new hv_aspirante_seguridad_socialModel();
            $aspirante_segsocial->hvass_aspirante=$id_aspirante_consulta;
            $resaspirante_segsocial=$aspirante_segsocial->listDetail();

            if (!isset($resaspirante_segsocial[0])) {
                $resaspirante_segsocial=array();
            }

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Seguridad Social</b></td>
                </tr>';
            $html .= '</table>';


            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>EPS:</b><br>'.$resaspirante_segsocial[0]['hvass_eps'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Fondo de pensión:</b><br>'.$resaspirante_segsocial[0]['hvass_pension'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Fondo de cesantías:</b><br>'.$resaspirante_segsocial[0]['hvass_cesantias'] . '</td>
                </tr>';
            $html .= '</table>';

            // Crea una tabla HTML con celdas redondeadas
            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Fondo voluntario de pensión:</b><br>'.$resaspirante_segsocial[0]['hvass_pension_voluntario'] . '</td>
                <td style="background-color: #E2E8F0;"><b>Medicina prepagada:</b><br>'.$resaspirante_segsocial[0]['hvass_prepagada'] . '</td>
                </tr>';
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');

            // Valida Declaraciones y Autorizaciones
            $aspirante_autorizaciones = new hv_aspirante_autorizacionesModel();
            $aspirante_autorizaciones->hvada_aspirante=$id_aspirante_consulta;
            $resaspirante_autorizaciones=$aspirante_autorizaciones->listDetail();

            if (!isset($resaspirante_autorizaciones[0])) {
                $resaspirante_autorizaciones=array();
            }

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Declaraciones y Autorizaciones</b></td>
                </tr>';
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');

            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 7);
            $pdf->MultiCell('', 1, '<b>Veracidad de la Información Proporcionada</b><br><br>Con la firma del  presente documento declaro que la información aquí contenida y suministrada durante el proceso de selección es veráz y que puede ser constatada en cualquier momento, asumiendo la responsabilidad en los eventos en que se presente cualquier falsedad frente a la misma.', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->MultiCell('', 1, '<b>Si, acepto</b> ', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            $pdf->SetFont('Helvetica', '', 1);
            $pdf->MultiCell('', 1, '', '', 'L', 0, 1, '', '');

            //HR SEPARADOR SECCIONES
            $pdf->SetFont('Helvetica', '', 3);
            $pdf->MultiCell('', 1, '<hr style="color: E2E8F0;">', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);


            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 7);
            $pdf->MultiCell('', 1, '<b>Declaración de Origen de Fondos y Prevención de Lavado de Activos y Financiación del Terrorismo - SAGRILAFT</b>
            <br><br>Declaro que los recursos utilizados o a utilizarse en cualquier relación contractual con la IMAGE QUALITY OUTSOURCING S.A.S., provienen de actividades lícitas; por tal razón, manifiesto que los recursos a utilizar en la relación contractual, no desarrollan o provienen de ninguna actividad ilícita de las contempladas en el Código Penal Colombiano o en cualquier norma que lo modifique o adicione. Igualmente, declaro que los recursos que se deriven del desarrollo de la relación contractual no se destinarán a la financiación del terrorismo, grupos terroristas o actividades terroristas.
            
            <br><br>Por ende, declaro bajo la gravedad de juramento que no me encuentro incluido en ninguna lista restrictiva como la lista OFAC o similares, ni he sido vinculado a investigación alguna ante cualquier autoridad como resultado de investigaciones en procesos de extinción de dominio, no he sido condenado, y no se ha emitido en mi contra sentencia o fallo en relación con las conductas mencionadas en este párrafo. Así mismo, declaro: Que la Información suministrada es veraz y verificable para el cumplimiento de la normatividad relacionada con prevención y control de lavado de activos y de la financiación del terrorismo y me comprometo a actualizar anualmente mis datos, suministrando la totalidad de los soportes que sean requieran.
            
            <br><br>Compromiso: Me comprometo a suministrar al Oficial de Cumplimiento de IMAGE QUALITY OUTSOURCING S.A.S. toda la información requerida frente al SAGRILAFT, dar a conocer cualquier inquietud que me surja sobre el mismo, y dar cumplimiento estricto a cada una de las políticas y procedimientos allí descritos, así como a las normas que obligan a actualizar mis datos personales e información financiera al menos una vez por año.', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->MultiCell('', 1, '<b>Si, acepto</b> ', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            $pdf->SetFont('Helvetica', '', 1);
            $pdf->MultiCell('', 1, '', '', 'L', 0, 1, '', '');

            //HR SEPARADOR SECCIONES
            $pdf->SetFont('Helvetica', '', 3);
            $pdf->MultiCell('', 1, '<hr style="color: E2E8F0;">', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);


            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 7);
            $pdf->MultiCell('', 1, '<b>Protección y Tratamiento de Datos Personales</b>
                <br><br>Autorización para el tratamiento de datos personales: Autorizo expresa e inequívocamente a IMAGE QUALITY OUTSOURCING S.A.S. (en adelante la “EMPRESA”), NIT 830.039.329-8, ubicada en la Carrera 13A No. 29-24, Teléfono (1) 593 1990, para que trate todos los datos que aquí se suministran y de los que posteriormente se suministren en desarrollo de la relación comercial contractual, declaro haber obtenido autorización para el tratamiento en los términos de la normatividad vigente. Finalidades: 1) Cumplir con las solicitudes de productos y/o de servicios realizados por la EMPRESA; 2) Cumplir con las solicitudes de productos y/o de servicios, 3) Realizar gestión, verificación y manejo de información financiera, contable, fiscal, administrativa y de facturación; 4) Verificar toda la información suministrada, realizar reportes de información contable, crediticia y financiera a centrales de riesgo e información financiera; 5) Consultar en listas restrictivas a todas las personas relacionadas y los que posteriormente se suministren; 6) Realizar pagos electrónicos y los diferentes medios derivados de la relación que vincula a las partes; 7) Realizar gestión y manejo de las relaciones comerciales establecidas o por establecer con los 3ros y los vinculados a los anteriores; 8) Suministrar y recibir información de material relacionado con el portafolio de productos y/o servicios de la EMPRESA, así como de noticias y nuevos lanzamientos por cualquier canal de comunicación; 9) Realizar gestión comercial, de mercadeo y publicidad de los productos y/o servicios ofrecidos por la EMPRESA; 10) Realizar gestión para la atención de PQR, campañas de actualización de datos y cambios, encuestas de opinión; 11) Captura de datos biométricos (datos sensibles) a través de registros fotográficos o de video para fines administrativos, comerciales, de publicidad, así como identificación, seguridad y la prevención de fraude interno y externo.; 12) Transmitir y/o transferir todos los datos personales a terceras personas según se requiera la vinculación contractual; 13) Atender visita domiciliaria o de establecimiento de comercio, 14) Las demás finalidades establecidas en la Política de Protección y Tratamiento de datos publicada en la página web https://www.iqoutsourcing.com/. Respecto de los datos personales que correspondan a titulares distintos de quien suscribe, éste manifiesta contar con la autorización para suministrar los datos a la EMPRESA y dar la presente autorización. Quien firma declara haber sido informado sobre los derechos que le asisten a los titulares de los datos personales, específicamente los de conocer, actualizar y eliminar sus datos personales, ser informado sobre el uso que se les ha dado, solicitar prueba de la autorización otorgada, presentar PQR ante la SIC por infracción a la ley, revocar la autorización y/o solicitar la supresión de sus datos, acceder a los mismos y abstenerse de suministrar datos sensibles o de menores de edad. Todo lo anterior de conformidad con la política de tratamiento de datos personales adoptada por la EMPRESA, la cual se me ha informado se encuentra disponible para pública consulta en la dirección web www.iqoutsourcing.com. La vigencia de la autorización para tratamiento de datos personales corresponderán al término que dure la relación entre las partes, de acuerdo con las finalidades que justificaron el tratamiento y/o al término que disponga la ley aplicable según la naturaleza de los datos.
                <br><br>
                Las peticiones, consultas y reclamos formulados por los titulares de Datos Personales bajo Tratamiento de IMAGE QUALITY OUTSOURCING S.A.S. para ejercer sus derechos a conocer, actualizar, rectificar y suprimir datos, o revocar la autorización deberán ser dirigidas a:
                <br><br>
                <br>• Oficial de Protección de Datos Personales: Calle 28 # 13-22, pisos 5 y 6, en Bogotá, D.C.
                <br>• Teléfono: (57) (601) 307 30 61
                <br>• Correo electrónico: privacidad@iq-online.com							
                <br><br><br>
                <b>Autorizo:</b> De manera irrevocable a IMAGE QUALITY OUTSOURCING S.A.S.  para solicitar, consultar, procesar, suministrar, reportar o divulgar a cualquier entidad válidamente autorizada para manejar o administrar bases de datos, incluidas las entidades gubernamentales, información contenida en este formulario y demás información relativa al cumplimiento de mis obligaciones legalmente adquiridas.								
                <br><br>
                <b>Acuerdo de protección y tratamiento de datos personales:</b> En relación con los datos personales que las partes se hayan comunicado o llegaren a comunicar recíprocamente como consecuencia o con ocasión de un vínculo o relación comercial/contractual vigente, estas se obligan a: 1) Efectuar el tratamiento de los datos personales de conformidad con las Políticas de Protección y Tratamiento de Datos Personales de cada una de ellas y la normatividad vigente que resulte aplicable; 2) Salvaguardar la seguridad de las bases de datos en las que se almacenen los datos personales, empleando medidas de seguridad razonables; 3) Guardar máxima confidencialidad respecto de los datos personales a los que tenga acceso en virtud de la relación contractual que las une, 4) realizar el tratamiento exclusivamente para las finalidades autorizadas; 5) cumplir con todas las obligaciones que resulten a su cargo, en la calidad de responsable o encargado del tratamiento de los datos personales, según el caso. Todo lo cual efectuará de conformidad con lo descrito en la ley 1581 de 2012 y sus concordantes y  con la política de privacidad descrita en la página www.iqoutsourcing.com acerca de la cual he sido informado.', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->MultiCell('', 1, '<b>Si, acepto</b><br><br>', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            $pdf->SetFont('Helvetica', '', 1);
            $pdf->MultiCell('', 1, '', '', 'L', 0, 1, '', '');

            // Valida Autorización Tratamiento Datos Personales
            $aspirante_tratamiento_datos = new hv_aspirante_autorizacionesModel();
            $aspirante_tratamiento_datos->hvada_aspirante=$id_aspirante_consulta;
            $resaspirante_tratamiento_datos=$aspirante_tratamiento_datos->listDetail();

            if (!isset($resaspirante_tratamiento_datos[0])) {
                $resaspirante_tratamiento_datos=array();
            }

            $html = '<table cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #1C2262; color: #FFFFFF; font-size: 11;"><b>Autorización para el Tratamiento de Datos Personales</b></td>
                </tr>';
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');
            
            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 7);
            $pdf->MultiCell('', 1, 'Cumpliendo lo dispuesto en la Ley 1581 de 2012, “Por el cual se dictan disposiciones para la protección de datos personales” y de conformidad con lo señalado en el Decreto 1377 de 2013, con la firma de este documento manifiesto que he sido informado de lo siguiente:

                <br><br>1. IMAGE QUALITY OUTSOURCING S.A.S. (IQ Outsourcing o la Compañía), durante el proceso de selección en el que participo y/o en virtud de la vinculación laboral o contractual que tengo con la Compañía como empleado, aprendiz SENA o practicante, ha conocido o conocerá mi información personal a través de los diferentes canales de comunicación o de los documentos por medio los cuales se formaliza mi vinculación. Respecto de esta información, IQ Outsourcing actuará como Responsable del Tratamiento, el cual realizará para las siguientes finalidades:
                <br><br>a. Realizar pruebas psicotécnicas, pruebas de conocimiento, estudios de seguridad y exámenes médicos directamente por la Compañía o a través de terceros.
                <br>b. Realizar todas las actividades relativas a la contratación y manejo de relaciones laborales.
                <br>c. Realizar las actividades necesarias para dar cumplimiento a las obligaciones legales y contractuales en relación con los empleados y exempleados de la Compañía.
                <br>d. Controlar el cumplimiento de requisitos relacionados con el Sistema General de Seguridad Social.
                <br>e. Facilitar, coordinar y supervisar el cumplimiento de la labor para la cual fue contratado el personal (empleados, aprendices SENA, practicantes) de manera directa -personal-, o a través de herramientas tecnológicas tales como plataformas de chat y videollamadas, correos electrónicos, números telefónicos.
                <br>f. Verificar y supervisar la productividad de los trabajadores, aprendices SENA y practicantes, a través de cualquier mecanismo y medio definido por la Compañía.
                <br>g. Mantener un archivo digital y/o físico que permita contar con la información correspondiente a la historia laboral, incluida la hoja de vida, de cada empleado o exempleado de la compañía.
                <br>h. Verificar datos de estudio, experiencia laboral, referencias laborales y personales mediante fuentes públicas y/o privadas. Así mismo, para certificar experiencia solicitada por terceros cuando sea candidato para laborar en otras compañías.
                <br>i. Realizar investigaciones administrativas y/o disciplinarias cuando a ello haya lugar.
                <br>j. En caso de datos biométricos capturados a través de sistemas de videovigilancia o grabación, su tratamiento tendrá como finalidad la identificación, seguridad y la prevención de fraude interno y externo, así como el control de acceso a las instalaciones físicas o a los sistemas de comunicación a través de los cuales se prestan los servicios.
                <br>k. Los datos personales de menores, en caso de ser requeridos, serán tratados con la finalidad de dar cumplimiento a las obligaciones legales y lo dispuesto en la política de Protección y Datos personales de la compañía.
                <br>l. Para el caso de los participantes en procesos de selección, los datos personales tratados tendrán como finalidad, además de las ya señaladas, adelantar las gestiones de los procesos de selección; las hojas de vida se gestionarán garantizando el principio de acceso restringido. Así mismo, las hojas de vida podrán conservarse para efectos de contar con información de posibles candidatos para futuros procesos de contratación y contactarlos en caso de requerirse.
                <br>m. Mantener informados a los empleados sobre los eventos, noticias, recomendaciones, políticas, y en general toda información que la Compañía considere pertinente informar a su personal.
                <br>n. Realizar encuestas, evaluaciones y cuestionarios para el análisis y toma de decisiones de carácter laboral por parte de la Compañía, tales como evaluaciones de desempeño, evaluación del clima laboral, recopilación de información sobre condiciones físicas y tecnológicas en los hogares cuando se trata de trabajo remoto o teletrabajo, información de carácter sanitario, entre otros.
                <br>o. Consultar en las diferentes listas restrictivas que establezca la Compañía en el marco de su política SAGRILAFT, Programa de Transparencia y Ética Empresarial, y la debida diligencia para el conocimiento de las contrapartes. Igualmente, se consultará el estado o antecedentes, siempre que ello se considere pertinente, en las bases de información pública de la Registraduría Nacional, Contraloría General de la República, Procuraduría General de la Nación, Policía Nacional y Boletín de deudores morosos del Estado, y verificar antecedentes de crédito y hacer los reportes correspondientes ante centrales de información crediticia.
                <br>p. Gestionar el proceso contable y de nómina de la Compañía.
                <br>q. Transmitir la información a encargados nacionales o internacionales con los que se tenga una relación operativa que provean los servicios necesarios para la debida operación de la Compañía.
                <br>r. Compartir los datos personales con autoridades nacionales o extranjeras cuando la solicitud se base en razones legales y procesales, fundamentados en causas legítimas tales como lo son temas legales o de carácter tributario. En todo caso, la información compartida deberá ser estrictamente la solicitada por la autoridad competente.
                <br>s. Compartir los datos personales, hojas de vidas y los soportes que acrediten la información allí relacionada, con los Clientes para los cuales se preste o se vaya a prestar el servicio, con el objeto de que éstos puedan validar la información que requieran en el marco de los contratos suscritos o por suscribirse entre aquellos e IQ.
                <br>t. Para la expedición de certificaciones laborales y suministro de información por solicitud de terceros en los procesos de selección en los que el personal (empleados, aprendices SENA, practicantes) se encuentren participando.
                <br>u. Para compartir la información con los terceros con los que la Compañía tiene convenios de libranza o en el marco de las actividades de bienestar, siempre que el personal (empleados, aprendices SENA, practicantes) estén interesados en acceder a dichos convenios.
                <br>v. Para contactarlo por cualquier medio (ej. Telefónico, correo electrónico), de los reportados a la Compañía, bien sea personal o laboral, con el fin de darle información o lineamientos de ésta.
                
                <br><br>2. IQ Outsourcing no tratará datos personales sensibles, salvo que se cuente con la autorización explícita del titular y las demás excepciones establecidas en la Ley 1581 de 2012.
                
                <br><br>3. Los derechos de los Titulares de los datos son los previstos en la Política de Protección y Tratamiento de Datos Personales de la Compañía, la Constitución Política de Colombia y en la Ley 1581 de 2012. Estos derechos podrán ser ejercidos a través de los siguientes canales:
                
                <br><br>- Oficial de Protección de Datos Personales: Calle 28 # 13-22, pisos 5 y 6, en Bogotá, D.C.
                <br>- Teléfono: (57) (601) 307 30 61
                <br>- Correo electrónico: privacidad@iq-online.com
                
                <br><br>En virtud de lo anterior, OTORGO AUTORIZACIÓN de manera libre, voluntaria, explícita, informada e inequívoca a IQ Outsourcing para que realice el tratamiento de mis datos personales de conformidad con las finalidades antes descritas y la Política de Protección y Tratamiento de Datos Personales de la Compañía. Entiendo que esta autorización para adelantar el tratamiento de datos personales se extiende mientras persista el vínculo con la Compañía y con posterioridad al finiquito de este, siempre que tal tratamiento se encuentre relacionado con las finalidades para las cuales los datos personales, fueron inicialmente suministrados.', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            // Valida Firma
            $aspirante_documentos = new hv_aspirante_documentoModel();
            $aspirante_documentos->hvad_aspirante=$id_aspirante_consulta;
            $aspirante_documentos->hvad_tipo='firma'; 
            $resaspirante_documentos=$aspirante_documentos->listDetailAll();

            if (!isset($resaspirante_documentos[0])) {
                $resaspirante_documentos=array();
            }

            //HR SEPARADOR SECCIONES
            // $pdf->SetFont('Helvetica', '', 3);
            // $pdf->MultiCell('', 1, '<hr style="color: E2E8F0;">', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);

            $pdf->SetFont('Helvetica', '', 8);
            $pdf->MultiCell('', 6, '', '', 'L', 0, 1, '', '');
            // Guardar la posición actual
            $posicionAntesDeFirma = $pdf->getY();

            // Agregar la firma después de la línea
            $imagenFirma = UPLOADS_ROOT_ASSETS.$resaspirante_documentos[0]['hvad_ruta'];
            $anchoFirma = 30; // ajusta el ancho de la firma según sea necesario

            if (file_exists($imagenFirma)) {
                $pdf->Image($imagenFirma, 15, $posicionAntesDeFirma + 5, $anchoFirma);
            }
            

            $pdf->MultiCell(90, 40, 'Firma,', '', 'L', 0, 1, '', '');
            
            $pdf->MultiCell(160, 4, 'Nombres y apellidos: '.$resaspirante[0]['hva_nombres'].' '.$resaspirante[0]['hva_nombres_2'].' '.$resaspirante[0]['hva_apellido_1'].' '.$resaspirante[0]['hva_apellido_2'], '', 'L', 0, 1, '', '');
            $pdf->MultiCell(160, 4, 'Identificación: '.$resaspirante[0]['hva_identificacion'], '', 'L', 0, 1, '', '');
            // $pdf->MultiCell(70, 4, 'Fecha: '.$resaspirante[0]['ea_identificacion'], '', 'L', 0, 1, '', '');
            
            //Firma responsable para menor de edad
            $aspirante_documentos = new hv_aspirante_documentoModel();
            $aspirante_documentos->hvad_aspirante=$id_aspirante_consulta;
            $aspirante_documentos->hvad_tipo='firma_padre'; 
            $resaspirante_documentos=$aspirante_documentos->listDetailAll();

            if (!isset($resaspirante_documentos[0])) {
                $resaspirante_documentos=array();
            }

            if (count($resaspirante_documentos)>0) {
                $pdf->SetFont('Helvetica', '', 8);
                $pdf->MultiCell('', 6, '', '', 'L', 0, 1, '', '');
                $pdf->MultiCell('', 6, '', '', 'L', 0, 1, '', '');
                // Guardar la posición actual
                $posicionAntesDeFirma = $pdf->getY();
    
                // Agregar la firma después de la línea
                $imagenFirma = UPLOADS_ROOT_ASSETS.$resaspirante_documentos[0]['hvad_ruta'];
                $anchoFirma = 30; // ajusta el ancho de la firma según sea necesario
    
                if (file_exists($imagenFirma)) {
                    $pdf->Image($imagenFirma, 15, $posicionAntesDeFirma + 5, $anchoFirma);
                }
    
                $pdf->MultiCell(90, 40, 'Firma Autorización,', '', 'L', 0, 1, '', '');
                
                $pdf->MultiCell(160, 4, 'Nombres y apellidos: '.$resaspirante[0]['hva_auxiliar_3'], '', 'L', 0, 1, '', '');
                $pdf->MultiCell(160, 4, 'Identificación: '.$resaspirante[0]['hva_auxiliar_4'], '', 'L', 0, 1, '', '');
                // $pdf->MultiCell(70, 4, 'Fecha: '.$resaspirante[0]['ea_identificacion'], '', 'L', 0, 1, '', '');
            }
            
            
            
            
            $ruta_hoja_vida=UPLOADS_ROOT_ASSETS.'aspirante_documentos/'.$resaspirante[0]['hva_id'].'/FORMATO HOJA DE VIDA-'.$resaspirante[0]['hva_nombres'].' '.$resaspirante[0]['hva_nombres_2'].' '.$resaspirante[0]['hva_apellido_1'].' '.$resaspirante[0]['hva_apellido_2'].'.pdf';
            $pdf->Output($ruta_hoja_vida, 'F');
            
            
            // Valida Firma
            $aspirante_documentos = new hv_aspirante_documentoModel();
            $aspirante_documentos->hvad_aspirante=$id_aspirante_consulta;
            $aspirante_documentos->hvad_tipo='firma'; 
            $resaspirante_documentos=$aspirante_documentos->listDetailAll();

            if (!isset($resaspirante_documentos[0])) {
                $resaspirante_documentos=array();
            }

            $resaspirante_documentos=$aspirante_documentos->listDetail();

            if (!isset($resaspirante_documentos[0])) {
                $resaspirante_documentos=array();
            }

            $ruta_documentos=array();
            $ruta_documentos[]=$ruta_hoja_vida;
            $ruta_documentos_nombre[]=$resaspirante[0]['hva_identificacion'].'_'.'FORMATO HOJA DE VIDA';
            for ($i=0; $i < count($resaspirante_documentos); $i++) {
                if ($resaspirante_documentos[$i]['hvad_tipo']!='fotografia' AND pathinfo(strtolower($resaspirante_documentos[$i]['hvad_ruta']), PATHINFO_EXTENSION) == 'pdf') {
                    $ruta_documentos[]=UPLOADS_ROOT_ASSETS.$resaspirante_documentos[$i]['hvad_ruta'];
                    $ruta_documentos_nombre[]=$resaspirante[0]['hva_identificacion'].'_'.$resaspirante_documentos[$i]['hvad_nombre'];
                }
            }

            // Nombre del archivo ZIP que se descargará
            $ruta_zip=UPLOADS_ROOT_ASSETS.'aspirante_documentos/'.$resaspirante[0]['hva_id'].'/'.$resaspirante[0]['hva_identificacion'].'.zip';
            $zipFilename = $ruta_zip;

            // Crear una nueva instancia de ZipArchive
            $zip = new ZipArchive();

            // Abre o crea el archivo ZIP
            if ($zip->open($zipFilename, ZipArchive::CREATE) === TRUE) {
                for ($j=0; $j < count($ruta_documentos); $j++) { 
                    $ruta_documentos_individual=$ruta_documentos[$j];
                    $extension=pathinfo(strtolower($ruta_documentos_individual), PATHINFO_EXTENSION);
                    $nombre = $ruta_documentos_nombre[$j].'.'.$extension;
                    if ($extension=='pdf' AND file_exists($ruta_documentos_individual)) {
                        $zip->addFile($ruta_documentos_individual, $nombre);
                    }
                }

                // Cierra el archivo ZIP
                $zip->close();

                // Envía los encabezados necesarios para indicar que se descargará un archivo ZIP
                header('Content-Type: application/zip');
                header('Content-disposition: attachment; filename=' . $resaspirante[0]['hva_identificacion'].'-'.$resaspirante[0]['hva_nombres'].' '.$resaspirante[0]['hva_nombres_2'].' '.$resaspirante[0]['hva_apellido_1'].' '.$resaspirante[0]['hva_apellido_2'].'.zip');
                header('Content-Length: ' . filesize($zipFilename));

                // // Envía el archivo ZIP al navegador para descargarlo
                readfile($zipFilename);

                // Borra el archivo ZIP después de descargarlo
                unlink($zipFilename);
            } else {
                echo 'Error: No se pudo crear el archivo ZIP.';
            }

            $data =
            [
                
            ];
        }

        public static function hoja_vida_ver($id_registro) {
            $modulo_plataforma="1";
            Controller::checkSesion();
            // error_reporting(E_ALL);
            $id_registro=checkInput(base64_decode($id_registro));
            
            try {
                
            } catch (Exception $e) {
                Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
            }

            $data =
            [
                'id_registro' => base64_encode($id_registro),
            ];
            
            View::render('aspirantes_ofertas_hoja_vida_ver', $data);
        }

        public static function hoja_vida_documentos_ver($id_registro) {
            $modulo_plataforma="1";
            Controller::checkSesion();
            // error_reporting(E_ALL);
            $id_registro=checkInput(base64_decode($id_registro));
            
            try {
                $documentos = new hv_aspirante_documentoModel();
                $documentos->hvad_id=$id_registro;
                
                $resdocumentos=$documentos->listDocumento();

                if (!isset($resdocumentos[0])) {
                    $resdocumentos=array();
                }
                
            } catch (Exception $e) {
                Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
            }

            $data =
            [
                'resultado_registros' => to_object($resdocumentos),
            ];
            
            View::render('aspirantes_ofertas_documentos_ver', $data);
        }

        public static function hoja_vida_documentos_ver_public($id_registro) {
            $modulo_plataforma="1";
            // Controller::checkSesion();
            // error_reporting(E_ALL);
            $id_registro=checkInput(base64_decode($id_registro));
            
            try {
                $documentos = new hv_aspirante_documentoModel();
                $documentos->hvad_id=$id_registro;
                
                $resdocumentos=$documentos->listDocumento();

                if (!isset($resdocumentos[0])) {
                    $resdocumentos=array();
                }
                
            } catch (Exception $e) {
                Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
            }

            $data =
            [
                'resultado_registros' => to_object($resdocumentos),
            ];
            
            View::render('aspirantes_ofertas_documentos_ver', $data);
        }

        public static function formulario_instrucciones($id_oferta, $id_token) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            unset($_SESSION[APP_SESSION.'_hv_informacion_general']);
            // error_reporting(E_ALL);
            
            $id_oferta=checkInput(base64_decode($id_oferta));
            $id_token=checkInput(base64_decode($id_token));
            $token = new tokenModel();
            $token->aut_usuario=$id_oferta;
            $token->aut_token=$id_token;
            $token->aut_expira=now();
            $res_token = $token->validate();

            if (!isset($res_token[0])) {
                $res_token=array();
            }

            if (count($res_token)>0) {
                $valida_token=1;
            } else {
                $valida_token=0;
            }

            $oferta = new hv_aspirante_ofertaModel();
            $oferta->hvao_id=substr($id_oferta, 2);
            $resoferta=$oferta->listDetailFormulario();

            if (!isset($resoferta[0])) {
                $resoferta=array();
            }

            $valida_oferta=1;
            if ($resoferta[0]['hvao_estado']!='Pendiente') {
                $valida_oferta=0;
            }

            $data =
            [   
                'titulo_pagina' => 'PROCESO DE SELECCIÓN|HOJA DE VIDA|INSTRUCCIONES',
                'path_add' => '/'.base64_encode($id_oferta).'/'.base64_encode($id_token),
                'valida_token' => $valida_token,
                'valida_oferta' => $valida_oferta,
                'id_oferta' => base64_encode($id_oferta),
                'id_token' => base64_encode($id_token),
                'resultado_aspirante' => to_object($resoferta),
            ];
            
            View::render('formulario', $data);
        }

        public static function formulario_personal($id_oferta, $id_token) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            
            $id_oferta=checkInput(base64_decode($id_oferta));
            $id_token=checkInput(base64_decode($id_token));
            
            try {
                $token = new tokenModel();
                $token->aut_usuario=$id_oferta;
                $token->aut_token=$id_token;
                $token->aut_expira=now();
                $res_token = $token->validate();

                if (!isset($res_token[0])) {
                    $res_token=array();
                }

                if (count($res_token)>0) {
                    $valida_token=1;
                    $control_envio=false;
                    
                    $oferta = new hv_aspirante_ofertaModel();
                    $oferta->hvao_id=substr($id_oferta, 2);
                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $id_aspirante_consulta=$resoferta[0]['hvao_aspirante'];

                    $aspirante = new hv_aspiranteModel();
                    $aspirante->hva_id=$id_aspirante_consulta;

                    $aspirante_emergencia = new hv_aspirante_emergenciaModel();
                    $aspirante_emergencia->hvaem_aspirante=$id_aspirante_consulta;

                    $ciudad = new ciudadModel();
                    $resciudad=$ciudad->listActive();

                    if (!isset($resciudad[0])) {
                        $resciudad=array();
                    } 

                    if(isset($_POST["form_guardar"])){
                        //obtiene variables de formulario
                        $hva_nombres=checkInput($_POST['hva_nombres']);
                        $hva_nombres_2=checkInput($_POST['hva_nombres_2']);
                        $hva_apellido_1=checkInput($_POST['hva_apellido_1']);
                        $hva_apellido_2=checkInput($_POST['hva_apellido_2']);
                        $hva_identificacion=checkInput($_POST['hva_identificacion']);
                        $hva_auxiliar_5=checkInput($_POST['hva_auxiliar_5']);
                        $hva_direccion=checkInput($_POST['hva_direccion']);
                        $hva_barrio=checkInput($_POST['hva_barrio']);
                        $hva_barrio_lista=checkInput($_POST['hva_barrio_lista']);
                        $hva_localidad=checkInput($_POST['hva_localidad']);
                        $hva_ciudad=checkInput($_POST['hva_ciudad']);
                        $hva_celular=checkInput($_POST['hva_celular']);
                        $hva_celular_2=checkInput($_POST['hva_celular_2']);
                        $hva_correo=checkInput($_POST['hva_correo']);
                        $hva_nacimiento_lugar=checkInput($_POST['hva_nacimiento_lugar']);
                        $hva_nacimiento_fecha=checkInput($_POST['hva_nacimiento_fecha']);
                        $hva_operador_internet=checkInput($_POST['hva_operador_internet']);
                        $hva_estado_civil=checkInput($_POST['hva_estado_civil']);
                        $hva_genero=checkInput($_POST['hva_genero']);
                        
                        $hvaem_nombres_apellidos=checkInput($_POST['hvaem_nombres_apellidos']);
                        $hvaem_parentesco=checkInput($_POST['hvaem_parentesco']);
                        $hvaem_telefono=checkInput($_POST['hvaem_telefono']);
                        $hvaem_grupo_sanguineo=checkInput($_POST['hvaem_grupo_sanguineo']);
                        $hvaem_rh=checkInput($_POST['hvaem_rh']);

                        $aspirante->hva_direccion=$hva_direccion;

                        if ($hva_ciudad=="11001" OR $hva_ciudad=="05001") {
                            $aspirante->hva_barrio=$hva_barrio_lista;
                        } else {
                            $aspirante->hva_barrio=$hva_barrio;
                        }

                        $aspirante->hva_auxiliar_5=$hva_auxiliar_5;
                        $aspirante->hva_localidad=$hva_localidad;
                        $aspirante->hva_ciudad=$hva_ciudad;
                        $aspirante->hva_celular=$hva_celular;
                        $aspirante->hva_celular_2=$hva_celular_2;
                        $aspirante->hva_nacimiento_lugar=$hva_nacimiento_lugar;
                        $aspirante->hva_nacimiento_fecha=$hva_nacimiento_fecha;
                        $aspirante->hva_operador_internet=$hva_operador_internet;
                        $aspirante->hva_genero=$hva_genero;
                        $aspirante->hva_estado_civil=$hva_estado_civil;
                        $aspirante->hva_actualiza_fecha=now();

                        $resupdate_aspirante = $aspirante->updateRegistro();
                        
                        $aspirante_emergencia->hvaem_nombres_apellidos=$hvaem_nombres_apellidos;
                        $aspirante_emergencia->hvaem_parentesco=$hvaem_parentesco;
                        $aspirante_emergencia->hvaem_telefono=$hvaem_telefono;
                        $aspirante_emergencia->hvaem_grupo_sanguineo=$hvaem_grupo_sanguineo;
                        $aspirante_emergencia->hvaem_rh=$hvaem_rh;
                        $aspirante_emergencia->hvaem_antecedentes='';
                        $aspirante_emergencia->hvaem_registro_usuario='';
                        $aspirante_emergencia->hvaem_registro_fecha=date('Y-m-d');

                        $resaspirante_emergencia=$aspirante_emergencia->listDetailFormulario();

                        if (!isset($resaspirante_emergencia[0])) {
                            $resaspirante_emergencia=array();
                        }

                        if (count($resaspirante_emergencia)>0) {
                            $aspirante_emergencia->hvaem_registro_fecha=now();
                            $resinsert_emergencia = $aspirante_emergencia->updateRegistro();
                            $hvaem_id=$resaspirante_emergencia[0]['hvaem_id'];
                        } else {
                            $resinsert_emergencia = $aspirante_emergencia->add();
                            $hvaem_id=$resinsert_emergencia;
                        }

                        if ($resupdate_aspirante AND $resinsert_emergencia) {
                            $aspirante->hva_emergencia_id=$hvaem_id;
                            $aspirante->updateIdEmergencia();
                            
                            Flasher::new('¡Registro editado exitosamente!', 'success');
                        } else {
                            Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                        }
                    }

                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $valida_oferta=1;
                    if ($resoferta[0]['hvao_estado']!='Pendiente') {
                        $valida_oferta=0;
                    }

                    $aspirante_emergencia->hvaem_registro_fecha=date('Y-m-d');
                    $resaspirante_emergencia=$aspirante_emergencia->listDetailFormulario();

                    if (!isset($resaspirante_emergencia[0])) {
                        $resaspirante_emergencia=array();
                    }

                    $localidad = new ciudad_barrioModel();
                    $localidad->ciub_ciudad=$resoferta[0]['hva_ciudad'];

                    $reslocalidad=$localidad->listLocalidad();

                    if (!isset($reslocalidad[0])) {
                        $reslocalidad=array();
                    }

                    $barrio = new ciudad_barrioModel();
                    $barrio->ciub_ciudad=$resoferta[0]['hva_ciudad'];
                    $barrio->ciub_localidad=$resoferta[0]['hva_localidad'];
                    
                    // Valida Información Personal
                    $resbarrio=$barrio->listBarrio();

                    if (!isset($resbarrio[0])) {
                        $resbarrio=array();
                    }

                    $control_localidad='d-none';
                    $control_barrio='d-block';
                    $control_barrio_lista='d-none';
                    if ($resoferta[0]['hva_ciudad']=='11001' OR $resoferta[0]['hva_ciudad']=='05001') {
                        $control_localidad='d-block';
                        $control_barrio='d-none';
                        $control_barrio_lista='d-block';
                    }


                } else {
                    $valida_token=0;
                }
            } catch (Exception $e) {
                // Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
            }

            $data =
            [
                'titulo_pagina' => 'PROCESO DE SELECCIÓN|HOJA DE VIDA|INFORMACIÓN PERSONAL',
                'path_add' => '/'.base64_encode($id_oferta).'/'.base64_encode($id_token),
                'valida_token' => $valida_token,
                'valida_oferta' => $valida_oferta,
                'id_oferta' => base64_encode($id_oferta),
                'id_token' => base64_encode($id_token),
                'resultado_registros_usuario' => to_object($resoferta),
                'resultado_registros_emergencia' => to_object($resaspirante_emergencia),
                'resultado_registros_ciudad' => to_object($resciudad),
                'resultado_registros_localidad' => to_object($reslocalidad),
                'resultado_registros_barrio' => to_object($resbarrio),
                'control_localidad' => $control_localidad,
                'control_barrio' => $control_barrio,
                'control_barrio_lista' => $control_barrio_lista,
            ];
            
            View::render('formulario_personal', $data);
        }

        public static function formulario_familiar($id_oferta, $id_token) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            
            $id_oferta=checkInput(base64_decode($id_oferta));
            $id_token=checkInput(base64_decode($id_token));
            
            try {
                $token = new tokenModel();
                $token->aut_usuario=$id_oferta;
                $token->aut_token=$id_token;
                $token->aut_expira=now();
                $res_token = $token->validate();

                if (!isset($res_token[0])) {
                    $res_token=array();
                }

                if (count($res_token)>0) {
                    $valida_token=1;
                    $control_envio=false;
                    
                    $oferta = new hv_aspirante_ofertaModel();
                    $oferta->hvao_id=substr($id_oferta, 2);
                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $valida_oferta=1;
                    if ($resoferta[0]['hvao_estado']!='Pendiente') {
                        $valida_oferta=0;
                    }

                    $id_aspirante_consulta=$resoferta[0]['hvao_aspirante'];

                    $aspirante = new hv_aspiranteModel();
                    $aspirante->hva_id=$id_aspirante_consulta;
                } else {
                    $valida_token=0;
                }
            } catch (Exception $e) {
                Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
            }

            $data =
            [
                'titulo_pagina' => 'PROCESO DE SELECCIÓN|HOJA DE VIDA|INFORMACIÓN FAMILIAR',
                'path_add' => '/'.base64_encode($id_oferta).'/'.base64_encode($id_token),
                'valida_token' => $valida_token,
                'valida_oferta' => $valida_oferta,
                'id_oferta' => base64_encode($id_oferta),
                'id_aspirante' => base64_encode($id_aspirante_consulta),
                'id_token' => base64_encode($id_token),
            ];
            
            View::render('formulario_familiar', $data);
        }

        public static function formulario_familiar_registro() {
            if(isset($_POST["token"])){
                try {
                    $id_token = checkInput(base64_decode($_POST["token"]));
                    $id_aspirante = checkInput(base64_decode($_POST["id_aspirante"]));

                    $aspirante_familiar = new hv_aspirante_familiarModel();
                    $aspirante_familiar->hvaf_aspirante=$id_aspirante;
                    $resaspirante_familiar=$aspirante_familiar->listDetail();

                    if (!isset($resaspirante_familiar[0])) {
                        $resaspirante_familiar=array();
                    }

                    //obtiene variables de formulario
                    $hvaf_nombres_apellidos=checkInput($_POST['hvaf_nombres_apellidos']);
                    $hvaf_parentesco=checkInput($_POST['hvaf_parentesco']);
                    $hvaf_edad=checkInput($_POST['hvaf_edad']);
                    $hvaf_nivel_educativo='';
                    $hvaf_acargo=checkInput($_POST['hvaf_acargo']);
                    $hvaf_convive=checkInput($_POST['hvaf_convive']);
                    
                    $aspirante_familiar->hvaf_nombres_apellidos=$hvaf_nombres_apellidos;
                    $aspirante_familiar->hvaf_parentesco=$hvaf_parentesco;
                    $aspirante_familiar->hvaf_edad=$hvaf_edad;
                    $aspirante_familiar->hvaf_nivel_educativo=$hvaf_nivel_educativo;
                    $aspirante_familiar->hvaf_acargo=$hvaf_acargo;
                    $aspirante_familiar->hvaf_convive=$hvaf_convive;
                    $aspirante_familiar->hvaf_registro_usuario=$id_aspirante;

                    $resinsert = $aspirante_familiar->add();
                    $resultado_lista='';
                    if ($resinsert) {
                        $resultado_valor = 1;
                    } else {
                        $resultado_valor = 0;
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }
          
            $data = array(
                "resultado_lista" => $resultado_lista,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function formulario_familiar_eliminar() {
            if(isset($_POST["token"])){
                try {
                    $id_token = checkInput(base64_decode($_POST["token"]));
                    $id_aspirante = checkInput(base64_decode($_POST["id_aspirante"]));
                    

                    //obtiene variables de formulario
                    $id_registro = checkInput($_POST["id_registro"]);

                    $aspirante_familiar = new hv_aspirante_familiarModel();
                    $aspirante_familiar->hvaf_id=$id_registro;
                    $aspirante_familiar->hvaf_aspirante=$id_aspirante;
                    $resdelete = $aspirante_familiar->delete();

                    if ($resdelete) {
                        $resultado_valor = 1;
                    } else {
                        $resultado_valor = 0;
                    }

                    $resultado_lista='';
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }
          
            $data = array(
                "resultado_lista" => $resultado_lista,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function formulario_familiar_listar() {
            if(isset($_POST["token"])){
                try {
                    $id_token = checkInput(base64_decode($_POST["token"]));
                    $id_aspirante = checkInput(base64_decode($_POST["id_aspirante"]));
                    

                    $aspirante_familiar = new hv_aspirante_familiarModel();
                    $aspirante_familiar->hvaf_aspirante=$id_aspirante;
                    $resaspirante_familiar=$aspirante_familiar->listDetail();

                    if (!isset($resaspirante_familiar[0])) {
                        $resaspirante_familiar=array();
                    }

                    if (count($resaspirante_familiar)>0) {
                        $resultado_valor = 1;
                        $resultado_lista='<div class="table-responsive table-fixed">
                                <table class="table table-hover table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th class="px-1 py-2 text-center font-size-12" style="width: 30px;"></th>
                                            <th class="px-1 py-2 text-center font-size-12">Nombres y Apellidos</th>
                                            <th class="px-1 py-2 text-center font-size-12">Parentesco</th>
                                            <th class="px-1 py-2 text-center font-size-12">Edad</th>
                                            <th class="px-1 py-2 text-center font-size-12">A cargo?</th>
                                            <th class="px-1 py-2 text-center font-size-12">Convive?</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                        for ($i=0; $i < count($resaspirante_familiar); $i++) { 
                            $resultado_lista.='<tr>
                                            <td class="p-1 text-center">
                                                <a class="btn btn-danger btn-sm font-size-11 btn-table" title="Eliminar" onclick="familiar_del('.$resaspirante_familiar[$i]['hvaf_id'].')"><i class="fas fa-trash-alt font-size-11"></i></a>
                                            </td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_familiar[$i]['hvaf_nombres_apellidos'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_familiar[$i]['hvaf_parentesco'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_familiar[$i]['hvaf_edad'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_familiar[$i]['hvaf_acargo'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_familiar[$i]['hvaf_convive'].'</td>
                                        </tr>';
                        }
                        $resultado_lista.='</tbody>
                                </table>';
                    } else {
                        $resultado_lista='';
                        $resultado_valor = 0;
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }
          
            $data = array(
                "resultado_lista" => $resultado_lista,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function formulario_estudio_culminado($id_oferta, $id_token) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            
            $id_oferta=checkInput(base64_decode($id_oferta));
            $id_token=checkInput(base64_decode($id_token));
            
            try {
                $token = new tokenModel();
                $token->aut_usuario=$id_oferta;
                $token->aut_token=$id_token;
                $token->aut_expira=now();
                $res_token = $token->validate();

                if (!isset($res_token[0])) {
                    $res_token=array();
                }

                if (count($res_token)>0) {
                    $valida_token=1;
                    $control_envio=false;
                    
                    $oferta = new hv_aspirante_ofertaModel();
                    $oferta->hvao_id=substr($id_oferta, 2);
                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $valida_oferta=1;
                    if ($resoferta[0]['hvao_estado']!='Pendiente') {
                        $valida_oferta=0;
                    }

                    $id_aspirante_consulta=$resoferta[0]['hvao_aspirante'];

                    $aspirante = new hv_aspiranteModel();
                    $aspirante->hva_id=$id_aspirante_consulta;

                    $ciudad = new ciudadModel();
                    $resciudad=$ciudad->listActive();

                    if (!isset($resciudad[0])) {
                        $resciudad=array();
                    }

                    $aspirante_estudio = new hv_aspirante_estudio_terminadoModel();
                    $aspirante_estudio->hvaet_aspirante=$id_aspirante_consulta;
                    $resaspirante_estudio=$aspirante_estudio->listDetail();

                    if (!isset($resaspirante_estudio[0])) {
                        $resaspirante_estudio=array();
                    }
                } else {
                    $valida_token=0;
                }
            } catch (Exception $e) {
                Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
            }

            $data =
            [
                'titulo_pagina' => 'PROCESO DE SELECCIÓN|HOJA DE VIDA|ESTUDIOS CULMINADOS',
                'path_add' => '/'.base64_encode($id_oferta).'/'.base64_encode($id_token),
                'valida_token' => $valida_token,
                'valida_oferta' => $valida_oferta,
                'id_oferta' => base64_encode($id_oferta),
                'resultado_registros' => to_object($resaspirante_estudio_culminado),
                'resultado_registros_ciudad' => to_object($resciudad),
                'id_aspirante' => base64_encode($id_aspirante_consulta),
                'id_token' => base64_encode($id_token),
            ];
            
            View::render('formulario_estudio_culminado', $data);
        }

        public static function formulario_estudio_culminado_registro() {
            if(isset($_POST["token"])){
                try {
                    $id_token = checkInput(base64_decode($_POST["token"]));
                    $id_aspirante = checkInput(base64_decode($_POST["id_aspirante"]));

                    $aspirante_estudio = new hv_aspirante_estudio_terminadoModel();
                    $aspirante_estudio->hvaet_aspirante=$id_aspirante;
                    $resaspirante_estudio=$aspirante_estudio->listDetail();

                    if (!isset($resaspirante_estudio[0])) {
                        $resaspirante_estudio=array();
                    }

                    //obtiene variables de formulario
                    $hvaet_nivel = checkInput($_POST["hvaet_nivel"]);
                    $hvaet_establecimiento = checkInput($_POST["hvaet_establecimiento"]);
                    $hvaet_titulo = checkInput($_POST["hvaet_titulo"]);
                    $hvaet_ciudad = checkInput($_POST["hvaet_ciudad"]);
                    $hvaet_fecha_inicio = checkInput($_POST["hvaet_fecha_inicio"]);
                    $hvaet_fecha_terminacion = checkInput($_POST["hvaet_fecha_terminacion"]);
                    $hvaet_modalidad = checkInput($_POST["hvaet_modalidad"]);
                    $hvaet_tarjeta_profesional = checkInput($_POST["hvaet_tarjeta_profesional"]);
                    
                    $aspirante_estudio->hvaet_nivel=$hvaet_nivel;
                    $aspirante_estudio->hvaet_establecimiento=$hvaet_establecimiento;
                    $aspirante_estudio->hvaet_titulo=$hvaet_titulo;
                    $aspirante_estudio->hvaet_ciudad=$hvaet_ciudad;
                    $aspirante_estudio->hvaet_fecha_inicio=$hvaet_fecha_inicio;
                    $aspirante_estudio->hvaet_fecha_terminacion=$hvaet_fecha_terminacion;
                    $aspirante_estudio->hvaet_tarjeta_profesional=$hvaet_tarjeta_profesional;
                    $aspirante_estudio->hvaet_modalidad=$hvaet_modalidad;
                    $aspirante_estudio->hvaet_registro_usuario=$id_aspirante;

                    $resinsert = $aspirante_estudio->add();

                    $resultado_lista='';
                    if ($resinsert) {
                        $resultado_valor = 1;
                    } else {
                        $resultado_valor = 0;
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }
          
            $data = array(
                "resultado_lista" => $resultado_lista,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function formulario_estudio_culminado_eliminar() {
            if(isset($_POST["token"])){
                try {
                    $id_token = checkInput(base64_decode($_POST["token"]));
                    $id_aspirante = checkInput(base64_decode($_POST["id_aspirante"]));
                    

                    //obtiene variables de formulario
                    $id_registro = checkInput($_POST["id_registro"]);

                    $aspirante_estudio = new hv_aspirante_estudio_terminadoModel();
                    $aspirante_estudio->hvaet_id=$id_registro;
                    $aspirante_estudio->hvaet_aspirante=$id_aspirante;
                    $resdelete = $aspirante_estudio->delete();

                    if ($resdelete) {
                        $resultado_valor = 1;
                    } else {
                        $resultado_valor = 0;
                    }

                    $resultado_lista='';
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }
          
            $data = array(
                "resultado_lista" => $resultado_lista,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function formulario_estudio_culminado_listar() {
            if(isset($_POST["token"])){
                try {
                    $id_token = checkInput(base64_decode($_POST["token"]));
                    $id_aspirante = checkInput(base64_decode($_POST["id_aspirante"]));
                    

                    $aspirante_estudio = new hv_aspirante_estudio_terminadoModel();
                    $aspirante_estudio->hvaet_aspirante=$id_aspirante;
                    $resaspirante_estudio=$aspirante_estudio->listDetail();

                    if (!isset($resaspirante_estudio[0])) {
                        $resaspirante_estudio=array();
                    }

                    if (count($resaspirante_estudio)>0) {
                        $resultado_valor = 1;
                        $resultado_lista='<div class="table-responsive table-fixed">
                                <table class="table table-hover table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th class="px-1 py-2 text-center font-size-12" style="width: 30px;"></th>
                                            <th class="px-1 py-2 text-center font-size-12">Nivel</th>
                                            <th class="px-1 py-2 text-center font-size-12">Establecimiento</th>
                                            <th class="px-1 py-2 text-center font-size-12">Título</th>
                                            <th class="px-1 py-2 text-center font-size-12">Ciudad</th>
                                            <th class="px-1 py-2 text-center font-size-12">Fecha inicio</th>
                                            <th class="px-1 py-2 text-center font-size-12">Fecha terminación</th>
                                            <th class="px-1 py-2 text-center font-size-12">Modalidad</th>
                                            <th class="px-1 py-2 text-center font-size-12">Tarjeta Profesional</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                        for ($i=0; $i < count($resaspirante_estudio); $i++) { 
                            $resultado_lista.='<tr>
                                            <td class="p-1 text-center">
                                                <a class="btn btn-danger btn-sm font-size-11 btn-table" title="Eliminar" onclick="estudio_del('.$resaspirante_estudio[$i]['hvaet_id'].')"><i class="fas fa-trash-alt font-size-11"></i></a>
                                            </td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio[$i]['hvaet_nivel'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio[$i]['hvaet_establecimiento'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio[$i]['hvaet_titulo'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio[$i]['ciu_municipio'].', '.$resaspirante_estudio[$i]['ciu_departamento'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio[$i]['hvaet_fecha_inicio'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio[$i]['hvaet_fecha_terminacion'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio[$i]['hvaet_modalidad'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio[$i]['hvaet_tarjeta_profesional'].'</td>
                                        </tr>';
                        }
                        $resultado_lista.='</tbody>
                                </table>';
                    } else {
                        $resultado_lista='';
                        $resultado_valor = 0;
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }
          
            $data = array(
                "resultado_lista" => $resultado_lista,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function formulario_estudio_curso($id_oferta, $id_token) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            
            $id_oferta=checkInput(base64_decode($id_oferta));
            $id_token=checkInput(base64_decode($id_token));
            
            try {
                $token = new tokenModel();
                $token->aut_usuario=$id_oferta;
                $token->aut_token=$id_token;
                $token->aut_expira=now();
                $res_token = $token->validate();

                if (!isset($res_token[0])) {
                    $res_token=array();
                }

                if (count($res_token)>0) {
                    $valida_token=1;
                    $control_envio=false;
                    
                    $oferta = new hv_aspirante_ofertaModel();
                    $oferta->hvao_id=substr($id_oferta, 2);
                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $valida_oferta=1;
                    if ($resoferta[0]['hvao_estado']!='Pendiente') {
                        $valida_oferta=0;
                    }

                    $id_aspirante_consulta=$resoferta[0]['hvao_aspirante'];

                    $aspirante = new hv_aspiranteModel();
                    $aspirante->hva_id=$id_aspirante_consulta;

                    if(isset($_POST["form_estudio_si"])){
                        //obtiene variables de formulario
                        $aspirante->hva_auxiliar_1='Si';
                        $resupdate_aspirante_estudio_curso = $aspirante->updateEstudioCurso();
                        
                        // if ($resupdate_aspirante_estudio_curso) {
                            
                        // } else {
                        //     Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                        // }
                    }

                    if(isset($_POST["form_estudio_no"])){
                        //obtiene variables de formulario
                        $aspirante->hva_auxiliar_1='No';
                        $resupdate_aspirante_estudio_curso = $aspirante->updateEstudioCurso();
                        
                        // if ($resupdate_aspirante_estudio_curso) {
                            
                        // } else {
                        //     Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                        // }
                    }

                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $ciudad = new ciudadModel();
                    $resciudad=$ciudad->listActive();

                    if (!isset($resciudad[0])) {
                        $resciudad=array();
                    } 

                    $aspirante_estudio = new hv_aspirante_estudio_cursoModel();
                    $aspirante_estudio->hvaec_aspirante=$id_aspirante_consulta;
                    $resaspirante_estudio=$aspirante_estudio->listDetail();

                    if (!isset($resaspirante_estudio[0])) {
                        $resaspirante_estudio=array();
                    }
                } else {
                    $valida_token=0;
                }
            } catch (Exception $e) {
                Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
            }

            $data =
            [
                'titulo_pagina' => 'PROCESO DE SELECCIÓN|HOJA DE VIDA|ESTUDIOS EN CURSO',
                'path_add' => '/'.base64_encode($id_oferta).'/'.base64_encode($id_token),
                'valida_token' => $valida_token,
                'valida_oferta' => $valida_oferta,
                'id_oferta' => base64_encode($id_oferta),
                'resultado_registros' => to_object($resaspirante_estudio_curso),
                'resultado_registros_ciudad' => to_object($resciudad),
                'id_aspirante' => base64_encode($id_aspirante_consulta),
                'id_token' => base64_encode($id_token),
                'estudio_curso' => $resoferta[0]['hva_auxiliar_1'],
            ];
            
            View::render('formulario_estudio_curso', $data);
        }

        public static function formulario_estudio_curso_registro() {
            if(isset($_POST["token"])){
                try {
                    $id_token = checkInput(base64_decode($_POST["token"]));
                    $id_aspirante = checkInput(base64_decode($_POST["id_aspirante"]));
                    

                    $aspirante_estudio = new hv_aspirante_estudio_cursoModel();
                    $aspirante_estudio->hvaec_aspirante=$id_aspirante;
                    $resaspirante_estudio=$aspirante_estudio->listDetail();

                    if (!isset($resaspirante_estudio[0])) {
                        $resaspirante_estudio=array();
                    }

                    //obtiene variables de formulario
                    $hvaec_nivel=checkInput($_POST['hvaec_nivel']);
                    $hvaec_establecimiento=checkInput($_POST['hvaec_establecimiento']);
                    $hvaec_titulo=checkInput($_POST['hvaec_titulo']);
                    $hvaec_ciudad=checkInput($_POST['hvaec_ciudad']);
                    $hvaec_horario=checkInput($_POST['hvaec_horario']);
                    $hvaec_modalidad=checkInput($_POST['hvaec_modalidad']);
                    $hvaec_fecha_terminacion=checkInput($_POST['hvaec_fecha_terminacion']);
                    
                    $aspirante_estudio->hvaec_nivel=$hvaec_nivel;
                    $aspirante_estudio->hvaec_establecimiento=$hvaec_establecimiento;
                    $aspirante_estudio->hvaec_titulo=$hvaec_titulo;
                    $aspirante_estudio->hvaec_ciudad=$hvaec_ciudad;
                    $aspirante_estudio->hvaec_horario=$hvaec_horario;
                    $aspirante_estudio->hvaec_modalidad=$hvaec_modalidad;
                    $aspirante_estudio->hvaec_fecha_terminacion=$hvaec_fecha_terminacion;
                    $aspirante_estudio->hvaec_registro_usuario=$id_aspirante;

                    $resinsert = $aspirante_estudio->add();
                    $resultado_lista='';
                    if ($resinsert) {
                        $resultado_valor = 1;
                    } else {
                        $resultado_valor = 0;
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }
          
            $data = array(
                "resultado_lista" => $resultado_lista,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function formulario_estudio_curso_eliminar() {
            if(isset($_POST["token"])){
                try {
                    $id_token = checkInput(base64_decode($_POST["token"]));
                    $id_aspirante = checkInput(base64_decode($_POST["id_aspirante"]));
                    

                    //obtiene variables de formulario
                    $id_registro = checkInput($_POST["id_registro"]);

                    $aspirante_estudio = new hv_aspirante_estudio_cursoModel();
                    $aspirante_estudio->hvaec_id=$id_registro;
                    $aspirante_estudio->hvaec_aspirante=$id_aspirante;
                    $resdelete = $aspirante_estudio->delete();

                    if ($resdelete) {
                        $resultado_valor = 1;
                    } else {
                        $resultado_valor = 0;
                    }

                    $resultado_lista='';
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }
          
            $data = array(
                "resultado_lista" => $resultado_lista,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function formulario_estudio_curso_listar() {
            if(isset($_POST["token"])){
                try {
                    $id_token = checkInput(base64_decode($_POST["token"]));
                    $id_aspirante = checkInput(base64_decode($_POST["id_aspirante"]));
                    

                    $aspirante_estudio = new hv_aspirante_estudio_cursoModel();
                    $aspirante_estudio->hvaec_aspirante=$id_aspirante;
                    $resaspirante_estudio=$aspirante_estudio->listDetail();

                    if (!isset($resaspirante_estudio[0])) {
                        $resaspirante_estudio=array();
                    }

                    if (count($resaspirante_estudio)>0) {
                        $resultado_valor = 1;
                        $resultado_lista='<div class="table-responsive table-fixed">
                                <table class="table table-hover table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th class="px-1 py-2 text-center font-size-12" style="width: 30px;"></th>
                                            <th class="px-1 py-2 text-center font-size-12">Nivel</th>
                                            <th class="px-1 py-2 text-center font-size-12">Establecimiento</th>
                                            <th class="px-1 py-2 text-center font-size-12">Título a obtener</th>
                                            <th class="px-1 py-2 text-center font-size-12">Ciudad</th>
                                            <th class="px-1 py-2 text-center font-size-12">Horario</th>
                                            <th class="px-1 py-2 text-center font-size-12">Modalidad</th>
                                            <th class="px-1 py-2 text-center font-size-12">Fecha terminación</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                        for ($i=0; $i < count($resaspirante_estudio); $i++) { 
                            $resultado_lista.='<tr>
                                            <td class="p-1 text-center">
                                                <a class="btn btn-danger btn-sm font-size-11 btn-table" title="Eliminar" onclick="estudio_del('.$resaspirante_estudio[$i]['hvaec_id'].')"><i class="fas fa-trash-alt font-size-11"></i></a>
                                            </td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio[$i]['hvaec_nivel'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio[$i]['hvaec_establecimiento'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio[$i]['hvaec_titulo'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio[$i]['ciu_municipio'].', '.$resaspirante_estudio[$i]['ciu_departamento'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio[$i]['hvaec_horario'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio[$i]['hvaec_modalidad'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio[$i]['hvaec_fecha_terminacion'].'</td>
                                        </tr>';
                        }
                        $resultado_lista.='</tbody>
                                </table>';
                    } else {
                        $resultado_lista='';
                        $resultado_valor = 0;
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }
          
            $data = array(
                "resultado_lista" => $resultado_lista,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function formulario_experiencia($id_oferta, $id_token) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            
            $id_oferta=checkInput(base64_decode($id_oferta));
            $id_token=checkInput(base64_decode($id_token));
            
            try {
                $token = new tokenModel();
                $token->aut_usuario=$id_oferta;
                $token->aut_token=$id_token;
                $token->aut_expira=now();
                $res_token = $token->validate();

                if (!isset($res_token[0])) {
                    $res_token=array();
                }

                if (count($res_token)>0) {
                    $valida_token=1;
                    $control_envio=false;
                    
                    $oferta = new hv_aspirante_ofertaModel();
                    $oferta->hvao_id=substr($id_oferta, 2);
                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $valida_oferta=1;
                    if ($resoferta[0]['hvao_estado']!='Pendiente') {
                        $valida_oferta=0;
                    }

                    $id_aspirante_consulta=$resoferta[0]['hvao_aspirante'];

                    $aspirante = new hv_aspiranteModel();
                    $aspirante->hva_id=$id_aspirante_consulta;

                    if(isset($_POST["form_empleo_si"])){
                        //obtiene variables de formulario
                        $aspirante->hva_auxiliar_2='Si';
                        $resupdate_aspirante_primer_empleo = $aspirante->updatePrimerEmpleo();
                        
                        // if ($resupdate_aspirante_primer_empleo) {
                            
                        // } else {
                        //     Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                        // }
                    }

                    if(isset($_POST["form_empleo_no"])){
                        //obtiene variables de formulario
                        $aspirante->hva_auxiliar_2='No';
                        $resupdate_aspirante_primer_empleo = $aspirante->updatePrimerEmpleo();
                        
                        // if ($resupdate_aspirante_primer_empleo) {
                            
                        // } else {
                        //     Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                        // }
                    }

                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $ciudad = new ciudadModel();
                    $resciudad=$ciudad->listActive();

                    if (!isset($resciudad[0])) {
                        $resciudad=array();
                    }

                    $aspirante_experiencia = new hv_aspirante_experienciaModel();
                    $aspirante_experiencia->hvaex_aspirante=$id_aspirante_consulta;
                    $resaspirante_experiencia=$aspirante_experiencia->listDetail();

                    if (!isset($resaspirante_experiencia[0])) {
                        $resaspirante_experiencia=array();
                    }
                } else {
                    $valida_token=0;
                }
            } catch (Exception $e) {
                Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
            }

            $data =
            [
                'titulo_pagina' => 'PROCESO DE SELECCIÓN|HOJA DE VIDA|EXPERIENCIA LABORAL',
                'path_add' => '/'.base64_encode($id_oferta).'/'.base64_encode($id_token),
                'valida_token' => $valida_token,
                'valida_oferta' => $valida_oferta,
                'id_oferta' => base64_encode($id_oferta),
                'resultado_registros' => to_object($resaspirante_experiencia),
                'resultado_registros_ciudad' => to_object($resciudad),
                'id_aspirante' => base64_encode($id_aspirante_consulta),
                'id_token' => base64_encode($id_token),
                'primer_empleo' => $resoferta[0]['hva_auxiliar_2'],
            ];
            
            View::render('formulario_experiencia', $data);
        }

        public static function formulario_experiencia_registro() {
            if(isset($_POST["token"])){
                try {
                    $id_token = checkInput(base64_decode($_POST["token"]));
                    $id_aspirante = checkInput(base64_decode($_POST["id_aspirante"]));
                    

                    $aspirante_experiencia = new hv_aspirante_experienciaModel();
                    $aspirante_experiencia->hvaex_aspirante=$id_aspirante;
                    $resaspirante_experiencia=$aspirante_experiencia->listDetail();

                    if (!isset($resaspirante_experiencia[0])) {
                        $resaspirante_experiencia=array();
                    }

                    //obtiene variables de formulario
                    $hvaex_empresa = checkInput($_POST["hvaex_empresa"]);
                    $hvaex_cargo = checkInput($_POST["hvaex_cargo"]);
                    $hvaex_fecha_inicio = checkInput($_POST["hvaex_fecha_inicio"]);
                    $hvaex_fecha_retiro = checkInput($_POST["hvaex_fecha_retiro"]);
                    $hvaex_ciudad = checkInput($_POST["hvaex_ciudad"]);
                    $hvaex_jefe_nombre = checkInput($_POST["hvaex_jefe_nombre"]);
                    $hvaex_jefe_cargo = checkInput($_POST["hvaex_jefe_cargo"]);
                    $hvaex_telefonos = checkInput($_POST["hvaex_telefonos"]);
                    $hvaex_motivo_retiro = checkInput($_POST["hvaex_motivo_retiro"]);
                    
                    $aspirante_experiencia->hvaex_empresa=$hvaex_empresa;
                    $aspirante_experiencia->hvaex_cargo=$hvaex_cargo;
                    $aspirante_experiencia->hvaex_fecha_inicio=$hvaex_fecha_inicio;
                    $aspirante_experiencia->hvaex_fecha_retiro=$hvaex_fecha_retiro;
                    $aspirante_experiencia->hvaex_ciudad=$hvaex_ciudad;
                    $aspirante_experiencia->hvaex_jefe_nombre=$hvaex_jefe_nombre;
                    $aspirante_experiencia->hvaex_jefe_cargo=$hvaex_jefe_cargo;
                    $aspirante_experiencia->hvaex_telefonos=$hvaex_telefonos;
                    $aspirante_experiencia->hvaex_motivo_retiro=$hvaex_motivo_retiro;
                    $aspirante_experiencia->hvaex_registro_usuario=$id_aspirante;

                    $resinsert = $aspirante_experiencia->add();
                    $resultado_lista='';
                    if ($resinsert) {
                        $resultado_valor = 1;
                    } else {
                        $resultado_valor = 0;
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }
          
            $data = array(
                "resultado_lista" => $resultado_lista,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function formulario_experiencia_eliminar() {
            if(isset($_POST["token"])){
                try {
                    $id_token = checkInput(base64_decode($_POST["token"]));
                    $id_aspirante = checkInput(base64_decode($_POST["id_aspirante"]));
                    

                    //obtiene variables de formulario
                    $id_registro = checkInput($_POST["id_registro"]);

                    $aspirante_experiencia = new hv_aspirante_experienciaModel();
                    $aspirante_experiencia->hvaex_id=$id_registro;
                    $aspirante_experiencia->hvaex_aspirante=$id_aspirante;
                    $resdelete = $aspirante_experiencia->delete();

                    if ($resdelete) {
                        $resultado_valor = 1;
                    } else {
                        $resultado_valor = 0;
                    }

                    $resultado_lista='';
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }
          
            $data = array(
                "resultado_lista" => $resultado_lista,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function formulario_experiencia_listar() {
            if(isset($_POST["token"])){
                try {
                    $id_token = checkInput(base64_decode($_POST["token"]));
                    $id_aspirante = checkInput(base64_decode($_POST["id_aspirante"]));
                    

                    $aspirante_experiencia = new hv_aspirante_experienciaModel();
                    $aspirante_experiencia->hvaex_aspirante=$id_aspirante;
                    $resaspirante_experiencia=$aspirante_experiencia->listDetail();

                    if (!isset($resaspirante_experiencia[0])) {
                        $resaspirante_experiencia=array();
                    }

                    if (count($resaspirante_experiencia)>0) {
                        $resultado_valor = 1;
                        $resultado_lista='<div class="table-responsive table-fixed">
                                <table class="table table-hover table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th class="px-1 py-2 text-center font-size-12" style="width: 30px;"></th>
                                            <th class="px-1 py-2 text-center font-size-12">Nombre de la empresa</th>
                                            <th class="px-1 py-2 text-center font-size-12">Cargo</th>
                                            <th class="px-1 py-2 text-center font-size-12">Fecha inicio</th>
                                            <th class="px-1 py-2 text-center font-size-12">Fecha retiro</th>
                                            <th class="px-1 py-2 text-center font-size-12">Ciudad</th>
                                            <th class="px-1 py-2 text-center font-size-12">Nombre jefe inmediato</th>
                                            <th class="px-1 py-2 text-center font-size-12">Cargo</th>
                                            <th class="px-1 py-2 text-center font-size-12">Teléfono de referencia</th>
                                            <th class="px-1 py-2 text-center font-size-12">Motivo de retiro</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                        for ($i=0; $i < count($resaspirante_experiencia); $i++) { 
                            $resultado_lista.='<tr>
                                            <td class="p-1 text-center">
                                                <a class="btn btn-danger btn-sm font-size-11 btn-table" title="Eliminar" onclick="experiencia_del('.$resaspirante_experiencia[$i]['hvaex_id'].')"><i class="fas fa-trash-alt font-size-11"></i></a>
                                            </td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_experiencia[$i]['hvaex_empresa'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_experiencia[$i]['hvaex_cargo'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_experiencia[$i]['hvaex_fecha_inicio'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_experiencia[$i]['hvaex_fecha_retiro'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_experiencia[$i]['ciu_municipio'].', '.$resaspirante_experiencia[$i]['ciu_departamento'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_experiencia[$i]['hvaex_jefe_nombre'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_experiencia[$i]['hvaex_jefe_cargo'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_experiencia[$i]['hvaex_telefonos'].'</td>
                                            <td class="p-1 font-size-11 align-middle">'.$resaspirante_experiencia[$i]['hvaex_motivo_retiro'].'</td>
                                        </tr>';
                        }
                        $resultado_lista.='</tbody>
                                </table>';
                    } else {
                        $resultado_lista='';
                        $resultado_valor = 0;
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }
          
            $data = array(
                "resultado_lista" => $resultado_lista,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function formulario_etica($id_oferta, $id_token) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            
            $id_oferta=checkInput(base64_decode($id_oferta));
            $id_token=checkInput(base64_decode($id_token));
            
            try {
                $token = new tokenModel();
                $token->aut_usuario=$id_oferta;
                $token->aut_token=$id_token;
                $token->aut_expira=now();
                $res_token = $token->validate();

                if (!isset($res_token[0])) {
                    $res_token=array();
                }

                if (count($res_token)>0) {
                    $valida_token=1;
                    $control_envio=false;
                    
                    $oferta = new hv_aspirante_ofertaModel();
                    $oferta->hvao_id=substr($id_oferta, 2);
                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $valida_oferta=1;
                    if ($resoferta[0]['hvao_estado']!='Pendiente') {
                        $valida_oferta=0;
                    }

                    $id_aspirante_consulta=$resoferta[0]['hvao_aspirante'];

                    $aspirante = new hv_aspiranteModel();
                    $aspirante->hva_id=$id_aspirante_consulta;

                    $aspirante_etica = new hv_aspirante_eticaModel();
                    $aspirante_etica->hvae_aspirante=$id_aspirante_consulta;
                    $resaspirante_etica=$aspirante_etica->listDetailFormulario();

                    if (!isset($resaspirante_etica[0])) {
                        $resaspirante_etica=array();
                    }

                    $registro_parametro = new parametroModel();
                    $registro_parametro->app_id = 'codigo_etica_buen_gobierno';
                    $resregistro_parametro=$registro_parametro->listDetail();

                    if (!isset($resregistro_parametro[0])) {
                        $resregistro_parametro=array();
                    }

                    if(isset($_POST["form_guardar"])){
                        //obtiene variables de formulario
                        $hvae_familiar=checkInput($_POST['hvae_familiar']);
                        $hvae_familiar_nombre=checkInput($_POST['hvae_familiar_nombre']);
                        $hvae_familiar_area=checkInput($_POST['hvae_familiar_area']);

                        $aspirante_etica->hvae_familiar=$hvae_familiar;
                        $aspirante_etica->hvae_familiar_nombre=$hvae_familiar_nombre;
                        $aspirante_etica->hvae_familiar_area=$hvae_familiar_area;
                        $aspirante_etica->hvae_registro_usuario=$id_aspirante_consulta; 
                        $aspirante_etica->hvae_registro_fecha=date('Y-m-d');
                        
                        $resaspirante_etica=$aspirante_etica->listDetailFormulario();

                        if (!isset($resaspirante_etica[0])) {
                            $resaspirante_etica=array();
                        }

                        if (count($resaspirante_etica)>0) {
                            $aspirante_etica->hvae_registro_fecha=now();
                            $resinsert_etica = $aspirante_etica->updateRegistro();
                            $hvae_id=$resaspirante_etica[0]['hvae_id'];
                        } else {
                            $resinsert_etica = $aspirante_etica->add();
                            $hvae_id=$resinsert_etica;
                        }

                        if ($resinsert_etica) {
                            $aspirante->hva_etica_id=$hvae_id;
                            $aspirante->updateIdEtica();
                            Flasher::new('¡Registro editado exitosamente!', 'success');
                        } else {
                            Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                        }
                    }

                    $aspirante_etica->hvae_registro_fecha=date('Y-m-d');
                    $resaspirante_etica=$aspirante_etica->listDetailFormulario();

                    if (!isset($resaspirante_etica[0])) {
                        $resaspirante_etica=array();
                    }
                } else {
                    $valida_token=0;
                }
            } catch (Exception $e) {
                Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
            }

            $data =
            [
                'titulo_pagina' => 'PROCESO DE SELECCIÓN|HOJA DE VIDA|INFORMACIÓN GENERAL',
                'path_add' => '/'.base64_encode($id_oferta).'/'.base64_encode($id_token),
                'valida_token' => $valida_token,
                'valida_oferta' => $valida_oferta,
                'id_oferta' => base64_encode($id_oferta),
                'id_token' => base64_encode($id_token),
                'resultado_registros' => to_object($resaspirante_etica),
                'resultado_registros_parametros' => to_object($resregistro_parametro),
            ];
            
            View::render('formulario_etica', $data);
        }

        public static function formulario_iq($id_oferta, $id_token) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            
            $id_oferta=checkInput(base64_decode($id_oferta));
            $id_token=checkInput(base64_decode($id_token));
            
            try {
                $token = new tokenModel();
                $token->aut_usuario=$id_oferta;
                $token->aut_token=$id_token;
                $token->aut_expira=now();
                $res_token = $token->validate();

                if (!isset($res_token[0])) {
                    $res_token=array();
                }

                if (count($res_token)>0) {
                    $valida_token=1;
                    $control_envio=false;
                    
                    $oferta = new hv_aspirante_ofertaModel();
                    $oferta->hvao_id=substr($id_oferta, 2);
                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $valida_oferta=1;
                    if ($resoferta[0]['hvao_estado']!='Pendiente') {
                        $valida_oferta=0;
                    }

                    $id_aspirante_consulta=$resoferta[0]['hvao_aspirante'];

                    $aspirante = new hv_aspiranteModel();
                    $aspirante->hva_id=$id_aspirante_consulta;

                    $aspirante_informacion = new hv_aspirante_informacionModel();
                    $aspirante_informacion->hvai_aspirante=$id_aspirante_consulta;
                    $resaspirante_informacion=$aspirante_informacion->listDetailFormulario();

                    if (!isset($resaspirante_informacion[0])) {
                        $resaspirante_informacion=array();
                    }

                    if(isset($_POST["form_guardar"])){
                        //obtiene variables de formulario
                        $hvai_excolaborador=checkInput($_POST['hvai_excolaborador']);
                        $hvai_excolaborador_motivo=checkInput($_POST['hvai_excolaborador_motivo']);
                        $hvai_excolaborador_fecha=checkInput($_POST['hvai_excolaborador_fecha']);
                        $hvai_seleccion_previo=checkInput($_POST['hvai_seleccion_previo']);
                        $hvai_seleccion_previo_cargo=checkInput($_POST['hvai_seleccion_previo_cargo']);
                        $hvai_seleccion_previo_fecha=checkInput($_POST['hvai_seleccion_previo_fecha']);
                        $hvai_trabajo=checkInput($_POST['hvai_trabajo']);
                        $hvai_trabajo_tipo=checkInput($_POST['hvai_trabajo_tipo']);
                        $hvai_trabajo_empresa=checkInput($_POST['hvai_trabajo_empresa']);
                        $hvai_trabajo_cargo=checkInput($_POST['hvai_trabajo_cargo']);
                        $hvai_ocupacion=checkInput($_POST['hvai_ocupacion']);
                        $hvai_conflicto_renuncia=checkInput($_POST['hvai_conflicto_renuncia']);
                        $hvai_medio_conocer_oferta=checkInput($_POST['hvai_medio_conocer_oferta']);
                        

                        $aspirante_informacion->hvai_excolaborador=$hvai_excolaborador;
                        $aspirante_informacion->hvai_excolaborador_motivo=$hvai_excolaborador_motivo;
                        $aspirante_informacion->hvai_excolaborador_fecha=$hvai_excolaborador_fecha;
                        $aspirante_informacion->hvai_seleccion_previo=$hvai_seleccion_previo;
                        $aspirante_informacion->hvai_seleccion_previo_cargo=$hvai_seleccion_previo_cargo;
                        $aspirante_informacion->hvai_seleccion_previo_fecha=$hvai_seleccion_previo_fecha;
                        $aspirante_informacion->hvai_trabajo=$hvai_trabajo;
                        $aspirante_informacion->hvai_trabajo_tipo=$hvai_trabajo_tipo;
                        $aspirante_informacion->hvai_trabajo_empresa=$hvai_trabajo_empresa;
                        $aspirante_informacion->hvai_trabajo_cargo=$hvai_trabajo_cargo;
                        $aspirante_informacion->hvai_ocupacion=$hvai_ocupacion;
                        $aspirante_informacion->hvai_conflicto_renuncia=$hvai_conflicto_renuncia;
                        $aspirante_informacion->hvai_medio_conocer_oferta=$hvai_medio_conocer_oferta;
                        $aspirante_informacion->hvai_registro_usuario=$id_aspirante_consulta;
                        $aspirante_informacion->hvai_registro_fecha=date('Y-m-d');

                        $resaspirante_informacion=$aspirante_informacion->listDetailFormulario();

                        if (!isset($resaspirante_informacion[0])) {
                            $resaspirante_informacion=array();
                        }

                        if (count($resaspirante_informacion)>0) {
                            $aspirante_informacion->hvai_registro_fecha=now();
                            $resinsert_informacion = $aspirante_informacion->updateRegistro();
                            $hvai_id=$resaspirante_informacion[0]['hvai_id'];
                        } else {
                            $resinsert_informacion = $aspirante_informacion->add();
                            $hvai_id=$resinsert_informacion;
                        }
                        
                        if ($resinsert_informacion) {
                            $aspirante->hva_informacion_id=$hvai_id;
                            $aspirante->updateIdInformacion();
                            // Redirect::to('seleccion-vinculacion/formulario-financiera/'.base64_encode($id_aspirante).'/'.base64_encode($id_token));
                            Flasher::new('¡Registro editado exitosamente!', 'success');
                        } else {
                            Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                        }
                    }

                    $aspirante_informacion->hvai_registro_fecha=date('Y-m-d');
                    $resaspirante_informacion=$aspirante_informacion->listDetailFormulario();

                    if (!isset($resaspirante_informacion[0])) {
                        $resaspirante_informacion=array();
                    }
                } else {
                    $valida_token=0;
                }
            } catch (Exception $e) {
                Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
            }

            $data =
            [
                'titulo_pagina' => 'PROCESO DE SELECCIÓN|HOJA DE VIDA|INFORMACIÓN IQ',
                'path_add' => '/'.base64_encode($id_oferta).'/'.base64_encode($id_token),
                'valida_token' => $valida_token,
                'valida_oferta' => $valida_oferta,
                'id_oferta' => base64_encode($id_oferta),
                'id_token' => base64_encode($id_token),
                'resultado_registros' => to_object($resaspirante_informacion),
            ];
            
            View::render('formulario_iq', $data);
        }

        public static function formulario_financiera($id_oferta, $id_token) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            
            $id_oferta=checkInput(base64_decode($id_oferta));
            $id_token=checkInput(base64_decode($id_token));
            
            try {
                $token = new tokenModel();
                $token->aut_usuario=$id_oferta;
                $token->aut_token=$id_token;
                $token->aut_expira=now();
                $res_token = $token->validate();

                if (!isset($res_token[0])) {
                    $res_token=array();
                }

                if (count($res_token)>0) {
                    $valida_token=1;
                    $control_envio=false;
                    
                    $oferta = new hv_aspirante_ofertaModel();
                    $oferta->hvao_id=substr($id_oferta, 2);
                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $valida_oferta=1;
                    if ($resoferta[0]['hvao_estado']!='Pendiente') {
                        $valida_oferta=0;
                    }

                    $id_aspirante_consulta=$resoferta[0]['hvao_aspirante'];

                    $aspirante = new hv_aspiranteModel();
                    $aspirante->hva_id=$id_aspirante_consulta;

                    $aspirante_financiera = new hv_aspirante_financieraModel();
                    $aspirante_financiera->hvaf_aspirante=$id_aspirante_consulta;
                    $resaspirante_financiera=$aspirante_financiera->listDetailFormulario();

                    if (!isset($resaspirante_financiera[0])) {
                        $resaspirante_financiera=array();
                    }

                    if(isset($_POST["form_guardar"])){
                        //obtiene variables de formulario
                        $hvaf_activos=checkInput($_POST['hvaf_activos']);
                        $hvaf_ingresos=checkInput($_POST['hvaf_ingresos']);
                        $hvaf_pasivos=checkInput($_POST['hvaf_pasivos']);
                        $hvaf_egresos=checkInput($_POST['hvaf_egresos']);
                        $hvaf_patrimonio=checkInput($_POST['hvaf_patrimonio']);
                        $hvaf_ingresos_otros=checkInput($_POST['hvaf_ingresos_otros']);
                        $hvaf_concepto_ingresos=checkInput($_POST['hvaf_concepto_ingresos']);
                        $hvaf_moneda_extranjera=checkInput($_POST['hvaf_moneda_extranjera']);
                        $hvaf_reporte='';
                        $hvaf_reporte_cual='';

                        $aspirante_financiera->hvaf_activos=$hvaf_activos;
                        $aspirante_financiera->hvaf_ingresos=$hvaf_ingresos;
                        $aspirante_financiera->hvaf_pasivos=$hvaf_pasivos;
                        $aspirante_financiera->hvaf_egresos=$hvaf_egresos;
                        $aspirante_financiera->hvaf_patrimonio=$hvaf_patrimonio;
                        $aspirante_financiera->hvaf_ingresos_otros=$hvaf_ingresos_otros;
                        $aspirante_financiera->hvaf_concepto_ingresos=$hvaf_concepto_ingresos;
                        $aspirante_financiera->hvaf_moneda_extranjera=$hvaf_moneda_extranjera;
                        $aspirante_financiera->hvaf_reporte=$hvaf_reporte;
                        $aspirante_financiera->hvaf_reporte_cual=$hvaf_reporte_cual;
                        $aspirante_financiera->hvaf_registro_usuario=$id_aspirante_consulta;
                        $aspirante_financiera->hvaf_registro_fecha=date('Y-m-d');

                        $resaspirante_financiera=$aspirante_financiera->listDetailFormulario();

                        if (!isset($resaspirante_financiera[0])) {
                            $resaspirante_financiera=array();
                        }

                        if (count($resaspirante_financiera)>0) {
                            $aspirante_financiera->hvaf_registro_fecha=now();
                            $resinsert_financiera = $aspirante_financiera->updateRegistro();
                            $hvaf_id=$resaspirante_financiera[0]['hvaf_id'];
                        } else {
                            $resinsert_financiera = $aspirante_financiera->add();
                            $hvaf_id=$resinsert_financiera;
                        }
                        
                        if ($resinsert_financiera) {
                            $aspirante->hva_financiera_id=$hvaf_id;
                            $aspirante->updateIdFinanciera();
                            Flasher::new('¡Registro editado exitosamente!', 'success');
                        } else {
                            Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                        }
                    }

                    $aspirante_financiera->hvaf_registro_fecha=date('Y-m-d');
                    $resaspirante_financiera=$aspirante_financiera->listDetailFormulario();

                    if (!isset($resaspirante_financiera[0])) {
                        $resaspirante_financiera=array();
                    }
                } else {
                    $valida_token=0;
                }
            } catch (Exception $e) {
                Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
            }

            $data =
            [
                'titulo_pagina' => 'PROCESO DE SELECCIÓN|HOJA DE VIDA|INFORMACIÓN FINANCIERA',
                'path_add' => '/'.base64_encode($id_oferta).'/'.base64_encode($id_token),
                'valida_token' => $valida_token,
                'valida_oferta' => $valida_oferta,
                'id_oferta' => base64_encode($id_oferta),
                'id_token' => base64_encode($id_token),
                'resultado_registros' => to_object($resaspirante_financiera),
            ];
            
            View::render('formulario_financiera', $data);
        }

        public static function formulario_publica($id_oferta, $id_token) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            
            $id_oferta=checkInput(base64_decode($id_oferta));
            $id_token=checkInput(base64_decode($id_token));
            
            try {
                $token = new tokenModel();
                $token->aut_usuario=$id_oferta;
                $token->aut_token=$id_token;
                $token->aut_expira=now();
                $res_token = $token->validate();

                if (!isset($res_token[0])) {
                    $res_token=array();
                }

                if (count($res_token)>0) {
                    $valida_token=1;
                    $control_envio=false;
                    
                    $oferta = new hv_aspirante_ofertaModel();
                    $oferta->hvao_id=substr($id_oferta, 2);
                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $valida_oferta=1;
                    if ($resoferta[0]['hvao_estado']!='Pendiente') {
                        $valida_oferta=0;
                    }

                    $id_aspirante_consulta=$resoferta[0]['hvao_aspirante'];

                    $aspirante = new hv_aspiranteModel();
                    $aspirante->hva_id=$id_aspirante_consulta;

                    $aspirante_publico = new hv_aspirante_publicoModel();
                    $aspirante_publico->hvap_aspirante=$id_aspirante_consulta;
                    $resaspirante_publico=$aspirante_publico->listDetailFormulario();

                    if (!isset($resaspirante_publico[0])) {
                        $resaspirante_publico=array();
                    }

                    if(isset($_POST["form_guardar"])){
                        //obtiene variables de formulario
                        $hvap_recursos=checkInput($_POST['hvap_recursos']);
                        $hvap_reconocimiento=checkInput($_POST['hvap_reconocimiento']);
                        $hvap_poder=checkInput($_POST['hvap_poder']);
                        $hvap_familiar=checkInput($_POST['hvap_familiar']);
                        $hvap_observaciones=checkInput($_POST['hvap_observaciones']);
                        $hvap_observaciones_2=checkInput($_POST['hvap_observaciones_2']);

                        $aspirante_publico->hvap_recursos=$hvap_recursos;
                        $aspirante_publico->hvap_reconocimiento=$hvap_reconocimiento;
                        $aspirante_publico->hvap_poder=$hvap_poder;
                        $aspirante_publico->hvap_familiar=$hvap_familiar;
                        $aspirante_publico->hvap_observaciones=$hvap_observaciones.'|'.$hvap_observaciones_2;
                        $aspirante_publico->hvap_registro_usuario=$id_aspirante_consulta;
                        $aspirante_publico->hvap_registro_fecha=date('Y-m-d');

                        $resaspirante_publico=$aspirante_publico->listDetailFormulario();

                        if (!isset($resaspirante_publico[0])) {
                            $resaspirante_publico=array();
                        }

                        if (count($resaspirante_publico)>0) {
                            $aspirante_publico->hvap_registro_fecha=now();
                            $resinsert_publico = $aspirante_publico->updateRegistro();
                            $hvap_id=$resaspirante_publico[0]['hvap_id'];
                        } else {
                            $resinsert_publico = $aspirante_publico->add();
                            $hvap_id=$resinsert_publico;
                        }
                        
                        if ($resinsert_publico) {
                            $aspirante->hva_publico_id=$hvap_id;
                            $aspirante->updateIdPublico();
                            Flasher::new('¡Registro editado exitosamente!', 'success');
                        } else {
                            Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                        }
                    }

                    $aspirante_publico->hvap_registro_fecha=date('Y-m-d');
                    $resaspirante_publico=$aspirante_publico->listDetailFormulario();

                    if (!isset($resaspirante_publico[0])) {
                        $resaspirante_publico=array();
                    }
                } else {
                    $valida_token=0;
                }
            } catch (Exception $e) {
                Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
            }

            $data =
            [
                'titulo_pagina' => 'PROCESO DE SELECCIÓN|HOJA DE VIDA|PERSONAS EXPUESTAS PÚBLICAMENTE - PEP',
                'path_add' => '/'.base64_encode($id_oferta).'/'.base64_encode($id_token),
                'valida_token' => $valida_token,
                'valida_oferta' => $valida_oferta,
                'id_oferta' => base64_encode($id_oferta),
                'id_token' => base64_encode($id_token),
                'resultado_registros' => to_object($resaspirante_publico),
            ];
            
            View::render('formulario_publica', $data);
        }

        public static function formulario_segsocial($id_oferta, $id_token) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            
            $id_oferta=checkInput(base64_decode($id_oferta));
            $id_token=checkInput(base64_decode($id_token));
            
            try {
                $token = new tokenModel();
                $token->aut_usuario=$id_oferta;
                $token->aut_token=$id_token;
                $token->aut_expira=now();
                $res_token = $token->validate();

                if (!isset($res_token[0])) {
                    $res_token=array();
                }

                if (count($res_token)>0) {
                    $valida_token=1;
                    $control_envio=false;
                    
                    $oferta = new hv_aspirante_ofertaModel();
                    $oferta->hvao_id=substr($id_oferta, 2);
                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $valida_oferta=1;
                    if ($resoferta[0]['hvao_estado']!='Pendiente') {
                        $valida_oferta=0;
                    }

                    $id_aspirante_consulta=$resoferta[0]['hvao_aspirante'];

                    $aspirante = new hv_aspiranteModel();
                    $aspirante->hva_id=$id_aspirante_consulta;

                    $aspirante_segsocial = new hv_aspirante_seguridad_socialModel();
                    $aspirante_segsocial->hvass_aspirante=$id_aspirante_consulta;
                    $resaspirante_segsocial=$aspirante_segsocial->listDetailFormulario();

                    if (!isset($resaspirante_segsocial[0])) {
                        $resaspirante_segsocial=array();
                    }

                    if(isset($_POST["form_guardar"])){
                        //obtiene variables de formulario
                        $hvass_eps=checkInput($_POST['hvass_eps']);
                        $hvass_pension=checkInput($_POST['hvass_pension']);
                        $hvass_cesantias=checkInput($_POST['hvass_cesantias']);
                        $hvass_pension_voluntario=checkInput($_POST['hvass_pension_voluntario']);
                        $hvass_prepagada=checkInput($_POST['hvass_prepagada']);

                        $aspirante_segsocial->hvass_eps=$hvass_eps;
                        $aspirante_segsocial->hvass_pension=$hvass_pension;
                        $aspirante_segsocial->hvass_cesantias=$hvass_cesantias;
                        $aspirante_segsocial->hvass_pension_voluntario=$hvass_pension_voluntario;
                        $aspirante_segsocial->hvass_prepagada=$hvass_prepagada;
                        $aspirante_segsocial->hvass_registro_usuario=$id_aspirante_consulta;
                        $aspirante_segsocial->hvass_registro_fecha=date('Y-m-d');

                        $resaspirante_segsocial=$aspirante_segsocial->listDetailFormulario();

                        if (!isset($resaspirante_segsocial[0])) {
                            $resaspirante_segsocial=array();
                        }

                        if (count($resaspirante_segsocial)>0) {
                            $aspirante_segsocial->hvass_registro_fecha=now();
                            $resinsert_segsocial = $aspirante_segsocial->updateRegistro();
                            $hvass_id=$resaspirante_segsocial[0]['hvass_id'];
                        } else {
                            $resinsert_segsocial = $aspirante_segsocial->add();
                        }
                        
                        if ($resinsert_segsocial) {
                            $aspirante->hva_seguridad_social_id=$hvass_id;
                            $aspirante->updateIdSeguridad();
                            // Redirect::to('seleccion-vinculacion/formulario-autorizaciones/'.base64_encode($id_aspirante).'/'.base64_encode($id_token));
                            Flasher::new('¡Registro editado exitosamente!', 'success');
                        } else {
                            Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                        }
                    }

                    $aspirante_segsocial->hvass_registro_fecha=date('Y-m-d');
                    $resaspirante_segsocial=$aspirante_segsocial->listDetailFormulario();

                    if (!isset($resaspirante_segsocial[0])) {
                        $resaspirante_segsocial=array();
                    }
                } else {
                    $valida_token=0;
                }
            } catch (Exception $e) {
                Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
            }

            $data =
            [
                'titulo_pagina' => 'PROCESO DE SELECCIÓN|HOJA DE VIDA|SEGURIDAD SOCIAL',
                'path_add' => '/'.base64_encode($id_oferta).'/'.base64_encode($id_token),
                'valida_token' => $valida_token,
                'valida_oferta' => $valida_oferta,
                'id_oferta' => base64_encode($id_oferta),
                'id_token' => base64_encode($id_token),
                'resultado_registros' => to_object($resaspirante_segsocial),
            ];
            
            View::render('formulario_segsocial', $data);
        }

        public static function formulario_autorizaciones($id_oferta, $id_token) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            
            $id_oferta=checkInput(base64_decode($id_oferta));
            $id_token=checkInput(base64_decode($id_token));
            
            try {
                $token = new tokenModel();
                $token->aut_usuario=$id_oferta;
                $token->aut_token=$id_token;
                $token->aut_expira=now();
                $res_token = $token->validate();

                if (!isset($res_token[0])) {
                    $res_token=array();
                }

                if (count($res_token)>0) {
                    $valida_token=1;
                    $control_envio=false;
                    
                    $oferta = new hv_aspirante_ofertaModel();
                    $oferta->hvao_id=substr($id_oferta, 2);
                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $valida_oferta=1;
                    if ($resoferta[0]['hvao_estado']!='Pendiente') {
                        $valida_oferta=0;
                    }

                    $id_aspirante_consulta=$resoferta[0]['hvao_aspirante'];

                    $aspirante = new hv_aspiranteModel();
                    $aspirante->hva_id=$id_aspirante_consulta;

                    $aspirante_autorizaciones = new hv_aspirante_autorizacionesModel();
                    $aspirante_autorizaciones->hvada_aspirante=$id_aspirante_consulta;

                    $registro_parametro = new parametroModel();
                    $registro_parametro->app_id = 'autorizacion_sagrilaft';
                    $resregistro_parametro=$registro_parametro->listDetail();

                    if (!isset($resregistro_parametro[0])) {
                        $resregistro_parametro=array();
                    }

                    if(isset($_POST["form_guardar"])){
                        //obtiene variables de formulario
                        $hvada_veracidad=checkInput($_POST['hvada_veracidad']);
                        $hvada_origen_fondos=checkInput($_POST['hvada_origen_fondos']);
                        $hvada_proteccion_datos='';

                        $aspirante_autorizaciones->hvada_veracidad=$hvada_veracidad;
                        $aspirante_autorizaciones->hvada_origen_fondos=$hvada_origen_fondos;
                        $aspirante_autorizaciones->hvada_proteccion_datos=$hvada_proteccion_datos;
                        $aspirante_autorizaciones->hvada_tratamiento_datos='';
                        $aspirante_autorizaciones->hvada_registro_usuario=$id_aspirante_consulta;
                        $aspirante_autorizaciones->hvada_registro_fecha=date('Y-m-d');

                        $resaspirante_autorizaciones=$aspirante_autorizaciones->listDetailFormulario();

                        if (!isset($resaspirante_autorizaciones[0])) {
                            $resaspirante_autorizaciones=array();
                        }

                        if (count($resaspirante_autorizaciones)>0) {
                            $aspirante_autorizaciones->hvada_registro_fecha=now();
                            $resinsert_autorizacion = $aspirante_autorizaciones->updateRegistro();
                            $hvada_id=$resaspirante_autorizaciones[0]['hvada_id'];
                        } else {
                            $resinsert_autorizacion = $aspirante_autorizaciones->add();
                            $hvada_id=$resinsert_autorizacion;
                        }

                        if ($resinsert_autorizacion) {
                            $aspirante->hva_autorizaciones_id=$hvada_id;
                            $aspirante->updateIdAutorizaciones();

                            Flasher::new('¡Registro editado exitosamente!', 'success');
                        } else {
                            Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                        }
                    }

                    $aspirante_autorizaciones->hvada_registro_fecha=date('Y-m-d');
                    $resaspirante_autorizaciones=$aspirante_autorizaciones->listDetailFormulario();

                    if (!isset($resaspirante_autorizaciones[0])) {
                        $resaspirante_autorizaciones=array();
                    }
                } else {
                    $valida_token=0;
                }
            } catch (Exception $e) {
                Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
            }

            $data =
            [
                'titulo_pagina' => 'PROCESO DE SELECCIÓN|HOJA DE VIDA|DECLARACIONES Y AUTORIZACIONES',
                'path_add' => '/'.base64_encode($id_oferta).'/'.base64_encode($id_token),
                'valida_token' => $valida_token,
                'valida_oferta' => $valida_oferta,
                'id_oferta' => base64_encode($id_oferta),
                'id_token' => base64_encode($id_token),
                'resultado_registros' => to_object($resaspirante_autorizaciones),
                'resultado_registros_parametros' => to_object($resregistro_parametro),
            ];
            
            View::render('formulario_autorizaciones', $data);
        }

        public static function formulario_autorizaciones_datos($id_oferta, $id_token) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            
            $id_oferta=checkInput(base64_decode($id_oferta));
            $id_token=checkInput(base64_decode($id_token));
            
            try {
                $token = new tokenModel();
                $token->aut_usuario=$id_oferta;
                $token->aut_token=$id_token;
                $token->aut_expira=now();
                $res_token = $token->validate();

                if (!isset($res_token[0])) {
                    $res_token=array();
                }

                if (count($res_token)>0) {
                    $valida_token=1;
                    $control_envio=false;
                    
                    $oferta = new hv_aspirante_ofertaModel();
                    $oferta->hvao_id=substr($id_oferta, 2);
                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $valida_oferta=1;
                    if ($resoferta[0]['hvao_estado']!='Pendiente') {
                        $valida_oferta=0;
                    }

                    $id_aspirante_consulta=$resoferta[0]['hvao_aspirante'];

                    $aspirante = new hv_aspiranteModel();
                    $aspirante->hva_id=$id_aspirante_consulta;

                    $aspirante_autorizaciones = new hv_aspirante_autorizacionesModel();
                    $aspirante_autorizaciones->hvada_aspirante=$id_aspirante_consulta;

                    $registro_parametro = new parametroModel();
                    $registro_parametro->app_id = 'autorizacion_tratamiento_datos';
                    $resregistro_parametro=$registro_parametro->listDetail();

                    if (!isset($resregistro_parametro[0])) {
                        $resregistro_parametro=array();
                    }

                    if(isset($_POST["form_guardar"])){
                        //obtiene variables de formulario
                        $hvada_tratamiento_datos=checkInput($_POST['hvada_tratamiento_datos']);
                        
                        $aspirante_autorizaciones->hvada_veracidad='';
                        $aspirante_autorizaciones->hvada_origen_fondos='';
                        $aspirante_autorizaciones->hvada_proteccion_datos='';
                        $aspirante_autorizaciones->hvada_tratamiento_datos=$hvada_tratamiento_datos;
                        $aspirante_autorizaciones->hvada_registro_usuario=$id_aspirante_consulta;
                        $aspirante_autorizaciones->hvada_registro_fecha=date('Y-m-d');

                        $resaspirante_tratamiento_datos=$aspirante_autorizaciones->listDetailFormulario();

                        if (!isset($resaspirante_tratamiento_datos[0])) {
                            $resaspirante_tratamiento_datos=array();
                        }

                        if (count($resaspirante_tratamiento_datos)>0) {
                            $aspirante_autorizaciones->hvada_registro_fecha=now();
                            $resinsert_autorizacion = $aspirante_autorizaciones->updateRegistroPTD();
                            $hvada_id=$resaspirante_tratamiento_datos[0]['hvada_id'];
                        } else {
                            $resinsert_autorizacion = $aspirante_autorizaciones->addPTD();
                            $hvada_id=$resinsert_autorizacion;

                        }

                        if ($resinsert_autorizacion) {
                            $aspirante->hva_autorizaciones_id=$hvada_id;
                            $aspirante->updateIdAutorizaciones();
                            Flasher::new('¡Registro editado exitosamente!', 'success');
                        } else {
                            Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                        }
                    }

                    $aspirante_autorizaciones->hvada_registro_fecha=date('Y-m-d');
                    $resaspirante_tratamiento_datos=$aspirante_autorizaciones->listDetailFormulario();

                    if (!isset($resaspirante_tratamiento_datos[0])) {
                        $resaspirante_tratamiento_datos=array();
                    }
                } else {
                    $valida_token=0;
                }
            } catch (Exception $e) {
                Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
            }

            $data =
            [
                'titulo_pagina' => 'PROCESO DE SELECCIÓN|HOJA DE VIDA|AUTORIZACIÓN TRATAMIENTO DE DATOS PERSONALES',
                'path_add' => '/'.base64_encode($id_oferta).'/'.base64_encode($id_token),
                'valida_token' => $valida_token,
                'valida_oferta' => $valida_oferta,
                'id_oferta' => base64_encode($id_oferta),
                'id_token' => base64_encode($id_token),
                'resultado_registros' => to_object($resaspirante_tratamiento_datos),
                'resultado_registros_parametros' => to_object($resregistro_parametro),
            ];
            
            View::render('formulario_autorizacion_datos', $data);
        }

        public static function formulario_documentos($id_oferta, $id_token) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            
            $id_oferta=checkInput(base64_decode($id_oferta));
            $id_token=checkInput(base64_decode($id_token));
            
            try {
                $token = new tokenModel();
                $token->aut_usuario=$id_oferta;
                $token->aut_token=$id_token;
                $token->aut_expira=now();
                $res_token = $token->validate();

                if (!isset($res_token[0])) {
                    $res_token=array();
                }

                if (count($res_token)>0) {
                    $valida_token=1;
                    $control_envio=false;
                    
                    $oferta = new hv_aspirante_ofertaModel();
                    $oferta->hvao_id=substr($id_oferta, 2);
                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $valida_oferta=1;
                    if ($resoferta[0]['hvao_estado']!='Pendiente') { 
                        $valida_oferta=0;
                    }

                    $id_aspirante_consulta=$resoferta[0]['hvao_aspirante'];

                    $aspirante = new hv_aspiranteModel();
                    $aspirante->hva_id=$id_aspirante_consulta;

                    $aspirante_documentos = new hv_aspirante_documentoModel();
                    $aspirante_documentos->hvad_aspirante=$id_aspirante_consulta;
                    $aspirante_documentos->hvad_tipo='documento_identidad';
                    
                    $resaspirante_documentos=$aspirante_documentos->listDetailFormulario();

                    if (!isset($resaspirante_documentos[0])) {
                        $resaspirante_documentos=array();
                    }

                    if(isset($_POST["form_guardar"])){
                        //obtiene variables de formulario
                        $ruta_guardar_general=ASSETS_ROOT."uploads/aspirante_documentos/".$id_aspirante_consulta."/";
                        if (!file_exists($ruta_guardar_general)) {
                            mkdir($ruta_guardar_general, 0777, true);
                        }
                        
                        $documento_control=0;
                        if ($_FILES['documento_soporte']['name']!="") {
                            $archivo_extension = checkInput(strtolower(pathinfo($_FILES['documento_soporte']['name'], PATHINFO_EXTENSION)));
                            if ($archivo_extension=="pdf") {
                                if ($_FILES['documento_soporte']['size']<=80000000) {
                                    $documento_NombreArchivo='documento_identidad'.'_'.nowFile().".".$archivo_extension;
                                    $documento_ruta_actual=$ruta_guardar_general;
                                    $documento_ruta_actual_guardar="aspirante_documentos/".$id_aspirante_consulta."/";
                                    $documento_ruta_final=$documento_ruta_actual.$documento_NombreArchivo;
                                    $documento_ruta_final_guardar=$documento_ruta_actual_guardar.$documento_NombreArchivo;
                                    if ($_FILES['documento_soporte']["error"] > 0) {
                                        $documento_control++;
                                    } else {
                                        if (move_uploaded_file($_FILES['documento_soporte']['tmp_name'], $documento_ruta_final)) {
                                            
                                        } else {
                                            $documento_control++;
                                        }
                                    }
                                } else {
                                    $documento_control++;
                                }
                            } else {
                                $documento_control++;
                            }
                        } else {
                            $documento_ruta_final_guardar='';
                            $documento_control++;
                        }

                        $aspirante_documentos->hvad_tipo='documento_identidad';
                        $aspirante_documentos->hvad_nombre='Documento de identidad';
                        $aspirante_documentos->hvad_ruta=$documento_ruta_final_guardar;
                        $aspirante_documentos->hvad_extension=$archivo_extension;
                        $aspirante_documentos->hvad_registro_usuario='';
                        $aspirante_documentos->hvad_registro_fecha=now();

                        if ($documento_control==0) {
                            $resaspirante_documentos=$aspirante_documentos->listDetailFormularioDuplicado();

                            if (!isset($resaspirante_documentos[0])) {
                                $resaspirante_documentos=array();
                            }

                            if (count($resaspirante_documentos)>0) {
                                $resinsert_documento = $aspirante_documentos->updateRegistro();
                            } else {
                                $resinsert_documento = $aspirante_documentos->add();
                            }
                            
                            if ($resinsert_documento) {
                                Flasher::new('¡Registro editado exitosamente!', 'success');
                            } else {
                                Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                            }
                        } else {
                            Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                        }
                    }

                    $resaspirante_documentos=$aspirante_documentos->listDetailFormulario();

                    if (!isset($resaspirante_documentos[0])) {
                        $resaspirante_documentos=array();
                    }

                    $control_envio=true;
                } else {
                    $valida_token=0;
                }
            } catch (Exception $e) {
                Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
            }

            $data =
            [
                'titulo_pagina' => 'PROCESO DE SELECCIÓN|HOJA DE VIDA|DOCUMENTOS',
                'path_add' => '/'.base64_encode($id_oferta).'/'.base64_encode($id_token),
                'valida_token' => $valida_token,
                'valida_oferta' => $valida_oferta,
                'id_oferta' => base64_encode($id_oferta),
                'id_token' => base64_encode($id_token),
                'resultado_registros' => to_object($resaspirante_documentos),
            ];
            
            View::render('formulario_documentos', $data);
        }

        public static function formulario_cierre($id_oferta, $id_token) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            
            $id_oferta=checkInput(base64_decode($id_oferta));
            $id_token=checkInput(base64_decode($id_token));
            
            try {
                $token = new tokenModel();
                $token->aut_usuario=$id_oferta;
                $token->aut_token=$id_token;
                $token->aut_expira=now();
                $res_token = $token->validate();

                if (!isset($res_token[0])) {
                    $res_token=array();
                }

                if (count($res_token)>0) {
                    $valida_token=1;
                    $control_envio=false;
                    
                    $oferta = new hv_aspirante_ofertaModel();
                    $oferta->hvao_id=substr($id_oferta, 2);
                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $id_aspirante_consulta=$resoferta[0]['hvao_aspirante'];

                    $aspirante = new hv_aspiranteModel();
                    $aspirante->hva_id=$id_aspirante_consulta;

                    $aspirante_documentos = new hv_aspirante_documentoModel();
                    $aspirante_documentos->hvad_aspirante=$id_aspirante_consulta;
                    $aspirante_documentos->hvad_tipo='firma';
                    $resaspirante_documentos=$aspirante_documentos->listDetailFormulario();

                    if (!isset($resaspirante_documentos[0])) {
                        $resaspirante_documentos=array();
                    }

                    $edad = calcularEdad($resoferta[0]['hva_nacimiento_fecha']);
                    $menor_edad=false;
                    if ($edad<18) {
                        $menor_edad=true;
                    }

                    if(isset($_POST["form_guardar"])){
                        //obtiene variables de formulario
                        $ruta_guardar_general=ASSETS_ROOT."uploads/aspirante_documentos/".$id_aspirante_consulta."/";
                        if (!file_exists($ruta_guardar_general)) {
                            mkdir($ruta_guardar_general, 0777, true);
                        }
                        
                        $documento_control=0;
                        if ($_FILES['documento_soporte']['name']!="") {
                            $archivo_extension = checkInput(strtolower(pathinfo($_FILES['documento_soporte']['name'], PATHINFO_EXTENSION)));
                            if ($archivo_extension=="png" OR $archivo_extension=="jpg" OR $archivo_extension=="jpeg") {
                                if ($_FILES['documento_soporte']['size']<=80000000) {
                                    $documento_NombreArchivo='firma'.'_'.nowFile().".".$archivo_extension;
                                    $documento_ruta_actual=$ruta_guardar_general;
                                    $documento_ruta_actual_guardar="aspirante_documentos/".$id_aspirante_consulta."/";
                                    $documento_ruta_final=$documento_ruta_actual.$documento_NombreArchivo;
                                    $documento_ruta_final_guardar=$documento_ruta_actual_guardar.$documento_NombreArchivo;
                                    if ($_FILES['documento_soporte']["error"] > 0) {
                                        $documento_control++;
                                    } else {
                                        if (move_uploaded_file($_FILES['documento_soporte']['tmp_name'], $documento_ruta_final)) {
                                            
                                        } else {
                                            $documento_control++;
                                        }
                                    }
                                } else {
                                    $documento_control++;
                                }
                            } else {
                                $documento_control++;
                            }
                        } else {
                            $documento_ruta_final_guardar='';
                            $documento_control++;
                        }

                        $aspirante_documentos->hvad_tipo='firma';
                        $aspirante_documentos->hvad_nombre='Firma';
                        $aspirante_documentos->hvad_ruta=$documento_ruta_final_guardar;
                        $aspirante_documentos->hvad_extension=$archivo_extension;
                        $aspirante_documentos->hvad_registro_usuario='';
                        $aspirante_documentos->hvad_registro_fecha=now();

                        if ($documento_control==0) {
                            $resaspirante_documentos=$aspirante_documentos->listDetailFormulario();

                            if (!isset($resaspirante_documentos[0])) {
                                $resaspirante_documentos=array();
                            }

                            if (count($resaspirante_documentos)>0) {
                                $resinsert_documento = $aspirante_documentos->updateRegistro();
                            } else {
                                $resinsert_documento = $aspirante_documentos->add();
                            }

                            if ($menor_edad) {
                                $documento_control_edad=0;
                                if ($_FILES['documento_soporte_padres']['name']!="") {
                                    $archivo_extension = checkInput(strtolower(pathinfo($_FILES['documento_soporte_padres']['name'], PATHINFO_EXTENSION)));
                                    if ($archivo_extension=="png" OR $archivo_extension=="jpg" OR $archivo_extension=="jpeg") {
                                        if ($_FILES['documento_soporte_padres']['size']<=80000000) {
                                            $documento_NombreArchivo='firma_padre'.'_'.nowFile().".".$archivo_extension;
                                            $documento_ruta_actual=$ruta_guardar_general;
                                            $documento_ruta_actual_guardar="aspirante_documentos/".$id_aspirante_consulta."/";
                                            $documento_ruta_final=$documento_ruta_actual.$documento_NombreArchivo;
                                            $documento_ruta_final_guardar=$documento_ruta_actual_guardar.$documento_NombreArchivo;
                                            if ($_FILES['documento_soporte_padres']["error"] > 0) {
                                                $documento_control_edad++;
                                            } else {
                                                if (move_uploaded_file($_FILES['documento_soporte_padres']['tmp_name'], $documento_ruta_final)) {
                                                    $aspirante_documentos->hvad_tipo='firma_padre';
                                                    $aspirante_documentos->hvad_nombre='Firma autorización';
                                                    $aspirante_documentos->hvad_ruta=$documento_ruta_final_guardar;
                                                    $aspirante_documentos->hvad_extension=$archivo_extension;
                                                    $aspirante_documentos->hvad_registro_usuario='';
                                                    $aspirante_documentos->hvad_registro_fecha=now();
                    
                                                    $resaspirante_documentos=$aspirante_documentos->listDetailFormulario();
                    
                                                    if (!isset($resaspirante_documentos[0])) {
                                                        $resaspirante_documentos=array();
                                                    }
                    
                                                    if (count($resaspirante_documentos)>0) {
                                                        $resinsert_documento_padres = $aspirante_documentos->updateRegistro();
                                                    } else {
                                                        $resinsert_documento_padres = $aspirante_documentos->add();
                                                    }

                                                    if ($resinsert_documento_padres) {
                                                        $hva_auxiliar_3=checkInput($_POST['hva_auxiliar_3']);
                                                        $hva_auxiliar_4=checkInput($_POST['hva_auxiliar_4']);


                                                        $aspirante->hva_auxiliar_3=$hva_auxiliar_3;
                                                        $aspirante->hva_auxiliar_4=$hva_auxiliar_4;
                                
                                                        $resupdateautorizaedad=$aspirante->updateAutorizaEdad();
                                                    }

                                                } else {
                                                    $documento_control_edad++;
                                                }
                                            }
                                        } else {
                                            $documento_control_edad++;
                                        }
                                    } else {
                                        $documento_control_edad++;
                                    }
                                    
                                } else {
                                    $documento_ruta_final_guardar='';
                                    $documento_control_edad++;
                                }

                            } else {
                                $resinsert_documento_padres=true;
                            }
                            
                            if ($resinsert_documento AND $resinsert_documento_padres) {
                                $oferta->hvao_estado='Diligenciado';
                                $oferta->hvao_fecha_diligencia=now();
                                $resoferta_update=$oferta->updateEstado();

                                $aspirante->hva_estado='Diligenciado';
                                $aspirante->hva_actualiza_fecha=now();
        
                                $resupdateestado=$aspirante->updateEstado();

                                if ($resoferta_update AND $resupdateestado) {
                                    Flasher::new('¡Registro editado exitosamente!', 'success');
                                } else {
                                    Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                                }
                            } else {
                                Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                            }
                        } else {
                            Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                        }
                    }

                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $valida_oferta=1;
                    if ($resoferta[0]['hvao_estado']!='Pendiente') {
                        $valida_oferta=0;
                    }

                    $resaspirante_documentos=$aspirante_documentos->listDetail();

                    if (!isset($resaspirante_documentos[0])) {
                        $resaspirante_documentos=array();
                    }

                    $control_envio=true;
                } else {
                    $valida_token=0;
                }
            } catch (Exception $e) {
                Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
            }

            $data =
            [
                'titulo_pagina' => 'PROCESO DE SELECCIÓN|HOJA DE VIDA|FIRMAR',
                'path_add' => '/'.base64_encode($id_oferta).'/'.base64_encode($id_token),
                'valida_token' => $valida_token,
                'valida_oferta' => $valida_oferta,
                'menor_edad' => $menor_edad,
                'id_oferta' => base64_encode($id_oferta),
                'id_token' => base64_encode($id_token),
                'resultado_registros' => to_object($resaspirante_tratamiento_datos),
            ];
            
            View::render('formulario_cierre', $data);
        }

        public static function formulario_progreso($id_oferta, $id_token) {
            // Controller::checkSesion();
            $id_oferta=checkInput(base64_decode($id_oferta));
            $id_token=checkInput(base64_decode($id_token));
            // error_reporting(E_ALL);
            if($id_oferta!=""){
                try {
                    $oferta = new hv_aspirante_ofertaModel();
                    $oferta->hvao_id=substr($id_oferta, 2);
                    $resoferta=$oferta->listDetailFormulario();
                    
                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $id_aspirante_consulta=$resoferta[0]['hvao_aspirante'];
                    
                    $aspirante = new hv_aspiranteModel();
                    $aspirante->hva_id=$id_aspirante_consulta;
                    
                    $array_seccion['personal']=0;
                    $array_seccion['familiar']=0;
                    $array_seccion['estudio_culminado']=0;
                    $array_seccion['estudio_curso']=0;
                    $array_seccion['laboral']=0;
                    $array_seccion['etica']=0;
                    $array_seccion['informacion']=0;
                    $array_seccion['financiera']=0;
                    $array_seccion['publica']=0;
                    $array_seccion['segsocial']=0;
                    $array_seccion['autorizaciones']=0;
                    $array_seccion['datos_personales']=0;
                    $array_seccion['documentos']=0;
                    $array_seccion['firma']=0;

                    // Valida Información Personal
                    $resaspirante=$aspirante->listDetail();

                    if (!isset($resaspirante[0])) {
                        $resaspirante=array();
                    }

                    // Valida Información en caso de Emergencia
                    $aspirante_emergencia = new hv_aspirante_emergenciaModel();
                    $aspirante_emergencia->hvaem_aspirante=$id_aspirante_consulta;
                    $aspirante_emergencia->hvaem_registro_fecha=date('Y-m-d');
                    $resaspirante_emergencia=$aspirante_emergencia->listDetailFormulario();

                    if (!isset($resaspirante_emergencia[0])) {
                        $resaspirante_emergencia=array();
                    }

                    if (count($resaspirante_emergencia)>0 AND $resaspirante[0]['hva_direccion']!='') {
                        $array_seccion['personal']=1;
                    }

                    // Valida Información familiar
                    $aspirante_familiar = new hv_aspirante_familiarModel();
                    $aspirante_familiar->hvaf_aspirante=$id_aspirante_consulta;
                    $resaspirante_familiar=$aspirante_familiar->listDetail();

                    if (!isset($resaspirante_familiar[0])) {
                        $resaspirante_familiar=array();
                    }

                    if (count($resaspirante_familiar)>0) {
                        $array_seccion['familiar']=1;
                    }

                    // Valida Estudios Culminados
                    $aspirante_estudio_culminado = new hv_aspirante_estudio_terminadoModel();
                    $aspirante_estudio_culminado->hvaet_aspirante=$id_aspirante_consulta;
                    $resaspirante_estudio_culminado=$aspirante_estudio_culminado->listDetail();

                    if (!isset($resaspirante_estudio_culminado[0])) {
                        $resaspirante_estudio_culminado=array();
                    }

                    if (count($resaspirante_estudio_culminado)>0) {
                        $array_seccion['estudio_culminado']=1;
                    }

                    // Valida Estudios Curso
                    $aspirante_estudio_curso = new hv_aspirante_estudio_cursoModel();
                    $aspirante_estudio_curso->hvaec_aspirante=$id_aspirante_consulta;
                    $resaspirante_estudio_curso=$aspirante_estudio_curso->listDetail();

                    if (!isset($resaspirante_estudio_curso[0])) {
                        $resaspirante_estudio_curso=array();
                    }

                    if (($resoferta[0]['hva_auxiliar_1']=='Si' AND count($resaspirante_estudio_curso)>0) OR $resoferta[0]['hva_auxiliar_1']=='No') {
                        $array_seccion['estudio_curso']=1;
                    }

                    // Valida Experiencia Laboral
                    $aspirante_experiencia = new hv_aspirante_experienciaModel();
                    $aspirante_experiencia->hvaex_aspirante=$id_aspirante_consulta;
                    $resaspirante_experiencia=$aspirante_experiencia->listDetail();

                    if (!isset($resaspirante_experiencia[0])) {
                        $resaspirante_experiencia=array();
                    }

                    if (($resoferta[0]['hva_auxiliar_2']=='Si' AND count($resaspirante_experiencia)>0) OR $resoferta[0]['hva_auxiliar_2']=='No') {
                        $array_seccion['laboral']=1;
                    }

                    // Valida Información Ética
                    $aspirante_etica = new hv_aspirante_eticaModel();
                    $aspirante_etica->hvae_registro_fecha=date('Y-m-d');
                    $aspirante_etica->hvae_aspirante=$id_aspirante_consulta;
                    $resaspirante_etica=$aspirante_etica->listDetailFormulario();

                    if (!isset($resaspirante_etica[0])) {
                        $resaspirante_etica=array();
                    }

                    if (count($resaspirante_etica)>0) {
                        $array_seccion['etica']=1;
                    }


                    // Valida Información IQ
                    $aspirante_informacion = new hv_aspirante_informacionModel();
                    $aspirante_informacion->hvai_aspirante=$id_aspirante_consulta;
                    $aspirante_informacion->hvai_registro_fecha=date('Y-m-d');
                    $resaspirante_informacion=$aspirante_informacion->listDetailFormulario();

                    if (!isset($resaspirante_informacion[0])) {
                        $resaspirante_informacion=array();
                    }

                    if (count($resaspirante_informacion)>0) {
                        $array_seccion['informacion']=1;
                    }

                    // Valida Información Financiera
                    $aspirante_financiera = new hv_aspirante_financieraModel();
                    $aspirante_financiera->hvaf_aspirante=$id_aspirante_consulta;
                    $aspirante_financiera->hvaf_registro_fecha=date('Y-m-d');
                    $resaspirante_financiera=$aspirante_financiera->listDetailFormulario();

                    if (!isset($resaspirante_financiera[0])) {
                        $resaspirante_financiera=array();
                    }

                    if (count($resaspirante_financiera)>0) {
                        $array_seccion['financiera']=1;
                    }

                    // Valida Personas Expuestas Públicamente - PEP
                    $aspirante_publico = new hv_aspirante_publicoModel();
                    $aspirante_publico->hvap_aspirante=$id_aspirante_consulta;
                    $aspirante_publico->hvap_registro_fecha=date('Y-m-d');
                    $resaspirante_publico=$aspirante_publico->listDetailFormulario();

                    if (!isset($resaspirante_publico[0])) {
                        $resaspirante_publico=array();
                    }

                    if (count($resaspirante_publico)>0) {
                        $array_seccion['publica']=1;
                    }

                    // Valida Seguridad Social
                    $aspirante_segsocial = new hv_aspirante_seguridad_socialModel();
                    $aspirante_segsocial->hvass_aspirante=$id_aspirante_consulta;
                    $aspirante_segsocial->hvass_registro_fecha=date('Y-m-d');
                    $resaspirante_segsocial=$aspirante_segsocial->listDetailFormulario();

                    if (!isset($resaspirante_segsocial[0])) {
                        $resaspirante_segsocial=array();
                    }

                    if (count($resaspirante_segsocial)>0) {
                        $array_seccion['segsocial']=1;
                    }

                    // Valida Declaraciones y Autorizaciones
                    $aspirante_autorizaciones = new hv_aspirante_autorizacionesModel();
                    $aspirante_autorizaciones->hvada_aspirante=$id_aspirante_consulta;
                    $aspirante_autorizaciones->hvada_registro_fecha=date('Y-m-d');
                    $resaspirante_autorizaciones=$aspirante_autorizaciones->listDetailFormulario();

                    if (!isset($resaspirante_autorizaciones[0])) {
                        $resaspirante_autorizaciones=array();
                    }

                    if ($resaspirante_autorizaciones[0]['hvada_veracidad']!='') {
                        $array_seccion['autorizaciones']=1;
                    }

                    // Valida Autorización Tratamiento Datos Personales
                    $aspirante_tratamiento_datos = new hv_aspirante_autorizacionesModel();
                    $aspirante_tratamiento_datos->hvada_aspirante=$id_aspirante_consulta;
                    $aspirante_autorizaciones->hvada_registro_fecha=date('Y-m-d');
                    $resaspirante_tratamiento_datos=$aspirante_tratamiento_datos->listDetailFormulario();

                    if (!isset($resaspirante_tratamiento_datos[0])) {
                        $resaspirante_tratamiento_datos=array();
                    }

                    if ($resaspirante_tratamiento_datos[0]['hvada_tratamiento_datos']!='') {
                        $array_seccion['datos_personales']=1;
                    }

                    // Valida Documentos
                    $aspirante_documentos = new hv_aspirante_documentoModel();
                    $aspirante_documentos->hvad_aspirante=$id_aspirante_consulta;
                    $aspirante_documentos->hvad_tipo='documento_identidad';
                    $aspirante_documentos->hvad_registro_fecha=date('Y-m-d');
                    $resaspirante_documentos=$aspirante_documentos->listDetailFormulario();

                    if (!isset($resaspirante_documentos[0])) {
                        $resaspirante_documentos=array();
                    }

                    if ($resaspirante_documentos[0]['hvad_nombre']!='' AND date('Y-m-d', strtotime($resaspirante_documentos[0]['hvad_registro_fecha']))==date('Y-m-d')) {
                        $array_seccion['documentos']=1;
                    }

                    // Valida Firma
                    $aspirante_documentos = new hv_aspirante_documentoModel();
                    $aspirante_documentos->hvad_aspirante=$id_aspirante_consulta;
                    $aspirante_documentos->hvad_tipo='firma';
                    $aspirante_documentos->hvad_registro_fecha=date('Y-m-d');
                    $resaspirante_documentos=$aspirante_documentos->listDetailFormulario();

                    if (!isset($resaspirante_documentos[0])) {
                        $resaspirante_documentos=array();
                    }

                    if ($resaspirante_documentos[0]['hvad_nombre']!='' AND date('Y-m-d', strtotime($resaspirante_documentos[0]['hvad_registro_fecha']))==date('Y-m-d')) {
                        $array_seccion['firma']=1;
                    }

                    if (array_sum($array_seccion)>0) {
                        $porcentaje=number_format(((array_sum($array_seccion)/count($array_seccion))*100), 2, '.', '');
                    } else {
                        $porcentaje=0;
                    }

                    $resultado='<div class="progress-bar bg-success" role="progressbar" style="width: '.$porcentaje.'%;" aria-valuenow="'.$porcentaje.'" aria-valuemin="0" aria-valuemax="100">'.$porcentaje.'%</div>';

                    $status_personal='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                    $status_familiar='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                    $status_estudio_culminado='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                    $status_estudio_curso='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                    $status_laboral='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                    $status_etica='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                    $status_informacion='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                    $status_financiera='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                    $status_publica='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                    $status_segsocial='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                    $status_autorizaciones='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                    $status_datos_personales='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                    $status_documentos='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                    $status_firma='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';

                    if($array_seccion['personal']==1) {
                        $status_personal='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                    }

                    if($array_seccion['familiar']==1) {
                        $status_familiar='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                    }

                    if($array_seccion['estudio_culminado']==1) {
                        $status_estudio_culminado='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                    }

                    if($array_seccion['estudio_curso']==1) {
                        $status_estudio_curso='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                    }

                    if($array_seccion['laboral']==1) {
                        $status_laboral='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                    }

                    if($array_seccion['etica']==1) {
                        $status_etica='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                    }

                    if($array_seccion['informacion']==1) {
                        $status_informacion='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                    }

                    if($array_seccion['financiera']==1) {
                        $status_financiera='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                    }

                    if($array_seccion['publica']==1) {
                        $status_publica='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                    }

                    if($array_seccion['segsocial']==1) {
                        $status_segsocial='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                    }

                    if($array_seccion['autorizaciones']==1) {
                        $status_autorizaciones='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                    }

                    if($array_seccion['datos_personales']==1) {
                        $status_datos_personales='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                    }

                    if($array_seccion['documentos']==1) {
                        $status_documentos='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                    }

                    if($array_seccion['firma']==1) {
                        $status_firma='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                    }

                    $control_firma=0;
                    $control_firma_string='<p class="alert alert-warning p-1 font-size-11">¡Por favor diligencie todas las secciones de la hoja de vida para poder continuar!</p>';
                    if ($array_seccion['personal']==1 AND $array_seccion['personal']==1 AND $array_seccion['estudio_culminado']==1 AND $array_seccion['estudio_curso']==1 AND $array_seccion['laboral']==1 AND $array_seccion['etica']==1 AND $array_seccion['informacion']==1 AND $array_seccion['financiera']==1 AND $array_seccion['publica']==1 AND $array_seccion['segsocial']==1 AND $array_seccion['autorizaciones']==1 AND $array_seccion['datos_personales']==1 AND $array_seccion['documentos']==1) {
                        $control_firma=1;
                        $control_firma_string='<button type="submit" name="form_guardar" class="btn btn-success login-btn">Firmar y enviar</button>';
                    }

                    $control_envio=0;
                    $control_envio_string='';
                    if ($array_seccion['personal']==1 AND $array_seccion['personal']==1 AND $array_seccion['estudio_culminado']==1 AND $array_seccion['estudio_curso']==1 AND $array_seccion['laboral']==1 AND $array_seccion['etica']==1 AND $array_seccion['informacion']==1 AND $array_seccion['financiera']==1 AND $array_seccion['publica']==1 AND $array_seccion['segsocial']==1 AND $array_seccion['autorizaciones']==1 AND $array_seccion['datos_personales']==1 AND $array_seccion['documentos']==1 AND $array_seccion['firma']==1) {
                        $control_envio=1;
                        $control_envio_string='<p class="alert alert-success p-1 font-size-11 text-start">¡Hoja de vida digital enviada exitosamente!</p><a href="https://www.iqoutsourcing.com/" class="btn btn-dark login-btn mt-1">Finalizar</a>';
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }
          
            $data = array(
                "avance_porcentaje" => $porcentaje,
                "avance_total" => array_sum($array_seccion),
                "avance_barra" => $resultado,
                "secciones_total" => count($array_seccion),
                "secciones" => $array_seccion,
                "status_personal" => $status_personal,
                "status_familiar" => $status_familiar,
                "status_estudio_culminado" => $status_estudio_culminado,
                "status_estudio_curso" => $status_estudio_curso,
                "status_laboral" => $status_laboral,
                "status_etica" => $status_etica,
                "status_informacion" => $status_informacion,
                "status_financiera" => $status_financiera,
                "status_publica" => $status_publica,
                "status_segsocial" => $status_segsocial,
                "status_autorizaciones" => $status_autorizaciones,
                "status_datos_personales" => $status_datos_personales,
                "status_documentos" => $status_documentos,
                "status_firma" => $status_firma,
                "control_firma" => $control_firma,
                "control_firma_string" => $control_firma_string,
                "control_envio" => $control_envio,
                "control_envio_string" => $control_envio_string
            );
            echo json_encode($data);
        }

        public static function formulario_direccion() {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            
            try {
                
            } catch (Exception $e) {
                Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
            }

            $data =
            [
                
            ];
            
            View::render('formulario_direccion', $data);
        }

        public static function formulario_localidad($id_ciudad, $id_oferta) {
            // Controller::checkSesion();
            $id_ciudad=checkInput($id_ciudad);
            $id_oferta=checkInput(base64_decode($id_oferta));
            // error_reporting(E_ALL);
            if($id_ciudad!=""){
                try {
                    $oferta = new hv_aspirante_ofertaModel();
                    $oferta->hvao_id=substr($id_oferta, 2);
                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $id_aspirante_consulta=$resoferta[0]['hvao_aspirante'];

                    $aspirante = new hv_aspiranteModel();
                    $aspirante->hva_id=$id_aspirante_consulta;
                    $resaspirante=$aspirante->listDetail();

                    if (!isset($resaspirante[0])) {
                        $resaspirante=array();
                    }

                    $localidad = new ciudad_barrioModel();
                    $localidad->ciub_ciudad=$id_ciudad;

                    // Valida Información Personal
                    $reslocalidad=$localidad->listLocalidad();

                    if (!isset($reslocalidad[0])) {
                        $reslocalidad=array();
                    }

                    $resultado='';
                    $resultado_control=1;

                    for ($i=0; $i < count($reslocalidad); $i++) { 
                        $resultado.='<option class="font-size-11 py-0" value="'.$reslocalidad[$i][0].'">'.$reslocalidad[$i][0].'</option>';
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }
          
            $data = array(
                "resultado" => $resultado,
                "resultado_control" => $resultado_control
            );
            echo json_encode($data);
        }

        public static function formulario_barrio($id_ciudad, $id_localidad, $id_oferta) {
            // Controller::checkSesion();
            $id_ciudad=checkInput($id_ciudad);
            $id_localidad=checkInput($id_localidad);
            $id_oferta=checkInput(base64_decode($id_oferta));
            // error_reporting(E_ALL);
            if($id_localidad!=""){
                try {
                    $oferta = new hv_aspirante_ofertaModel();
                    $oferta->hvao_id=substr($id_oferta, 2);
                    $resoferta=$oferta->listDetailFormulario();

                    if (!isset($resoferta[0])) {
                        $resoferta=array();
                    }

                    $id_aspirante_consulta=$resoferta[0]['hvao_aspirante'];

                    $aspirante = new hv_aspiranteModel();
                    $aspirante->hva_id=$id_aspirante_consulta;
                    $resaspirante=$aspirante->listDetail();

                    if (!isset($resaspirante[0])) {
                        $resaspirante=array();
                    }

                    $barrio = new ciudad_barrioModel();
                    $barrio->ciub_ciudad=$id_ciudad;
                    $barrio->ciub_localidad=$id_localidad;
                    
                    // Valida Información Personal
                    $resbarrio=$barrio->listBarrio();

                    if (!isset($resbarrio[0])) {
                        $resbarrio=array();
                    }

                    $resultado='';
                    $resultado_control=1;

                    for ($i=0; $i < count($resbarrio); $i++) {
                        $resultado.='<option class="font-size-11 py-0" value="'.$resbarrio[$i][0].'">'.$resbarrio[$i][0].'</option>';
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }
          
            $data = array(
                "resultado" => $resultado,
                "resultado_control" => $resultado_control
            );
            echo json_encode($data);
        }

        public static function formulario_documentos_f2($id_oferta, $id_token) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            unset($_SESSION[APP_SESSION.'_hv_informacion_documentos']);
            // error_reporting(E_ALL);
            
            $id_oferta=checkInput(base64_decode($id_oferta));
            $id_token=checkInput(base64_decode($id_token));
            $token = new tokenModel();
            $token->aut_usuario=$id_oferta;
            $token->aut_token=$id_token;
            $token->aut_expira=now();
            $res_token = $token->validate();

            if (!isset($res_token[0])) {
                $res_token=array();
            }

            if (count($res_token)>0) {
                $valida_token=1;
                $control_envio=false;
                    
                $oferta = new hv_aspirante_ofertaModel();
                $oferta->hvao_id=substr($id_oferta, 3);
                $resoferta=$oferta->listDetailFormulario();

                if (!isset($resoferta[0])) {
                    $resoferta=array();
                }

                $valida_oferta=1;
                if ($resoferta[0]['hvao_estado']!='Revisado') { 
                    $valida_oferta=0;
                }

                $id_aspirante_consulta=$resoferta[0]['hvao_aspirante'];

                $aspirante = new hv_aspiranteModel();
                $aspirante->hva_id=$id_aspirante_consulta;

                $aspirante_documentos = new hv_aspirante_documentoModel();
                $aspirante_documentos->hvad_aspirante=$id_aspirante_consulta;
                 
                $array_resultado_carga=array();
                if ($valida_oferta) {
                    if(isset($_POST["form_guardar"])){
                        //obtiene variables de formulario
                        $ruta_guardar_general=ASSETS_ROOT."uploads/aspirante_documentos/".$id_aspirante_consulta."/";
                        if (!file_exists($ruta_guardar_general)) {
                            mkdir($ruta_guardar_general, 0777, true);
                        }
                        
                        $array_documentos[]='hoja_vida_personal';
                        $array_documentos[]='certificado_estudio_formal';
                        $array_documentos[]='certificado_estudio_no_formal';
                        $array_documentos[]='certificado_laboral';
                        $array_documentos[]='certificado_eps';
                        $array_documentos[]='certificado_pension';
                        $array_documentos[]='certificado_cesantias';
                        $array_documentos[]='certificado_bancario';
                        $array_documentos[]='tarjeta_profesional';
                        $array_documentos[]='fotografia';
    
                        $array_documentos_nombre['hoja_vida_personal']='Hoja de vida personal';
                        $array_documentos_nombre['certificado_estudio_formal']='Certificaciones de estudios formales';
                        $array_documentos_nombre['certificado_estudio_no_formal']='Certificaciones de estudios no formales';
                        $array_documentos_nombre['certificado_laboral']='Certificaciones laborales';
                        $array_documentos_nombre['certificado_eps']='Certificado de afiliación a EPS';
                        $array_documentos_nombre['certificado_pension']='Certificado de afiliación a Fondo de Pensiones';
                        $array_documentos_nombre['certificado_cesantias']='Certificado de afiliación a Fondo de Cesantías';
                        $array_documentos_nombre['certificado_bancario']='Certificación bancaria cuenta de nómina';
                        $array_documentos_nombre['tarjeta_profesional']='Tarjeta profesional';
                        $array_documentos_nombre['fotografia']='Fotografía';
                        
                        $documento_control=0;
                        for ($i=0; $i < count($array_documentos); $i++) {
                            $tipo_documento=$array_documentos[$i];
                            $resaspirante_documentos=array();
                            if ($_FILES[$tipo_documento]['name']!="") {
                                $archivo_extension = checkInput(strtolower(pathinfo($_FILES[$tipo_documento]['name'], PATHINFO_EXTENSION)));
                                if ($archivo_extension=="pdf" OR $archivo_extension=="png" OR $archivo_extension=="jpg" OR $archivo_extension=="jpeg") {
                                    if ($_FILES[$tipo_documento]['size']<=80000000) {
                                        $documento_NombreArchivo=$tipo_documento.'_'.nowFile().".".$archivo_extension;
                                        $documento_ruta_actual=$ruta_guardar_general;
                                        $documento_ruta_actual_guardar="aspirante_documentos/".$id_aspirante_consulta."/";
                                        $documento_ruta_final=$documento_ruta_actual.$documento_NombreArchivo;
                                        $documento_ruta_final_guardar=$documento_ruta_actual_guardar.$documento_NombreArchivo;
                                        if ($_FILES[$tipo_documento]["error"] > 0) {
                                            $documento_control++;
                                        } else {
                                            if (move_uploaded_file($_FILES[$tipo_documento]['tmp_name'], $documento_ruta_final)) {
                                                
                                            } else {
                                                $documento_control++;
                                            }
                                        }
                                    } else {
                                        $documento_control++;
                                    }
                                } else {
                                    $documento_control++;
                                }
                            } else {
                                $documento_ruta_final_guardar='';
                                // $documento_control++;
                            }
        
                            $aspirante_documentos->hvad_tipo=$tipo_documento;
                            $aspirante_documentos->hvad_nombre=$array_documentos_nombre[$tipo_documento];
                            $aspirante_documentos->hvad_ruta=$documento_ruta_final_guardar;
                            $aspirante_documentos->hvad_extension=$archivo_extension;
                            $aspirante_documentos->hvad_registro_usuario='';
                            $aspirante_documentos->hvad_registro_fecha=now();
    
                            if ($documento_control==0) {
                                if ($_FILES[$tipo_documento]['name']!="") {
                                    $resaspirante_documentos=$aspirante_documentos->listDetailFormularioDuplicado();
            
                                    if (!isset($resaspirante_documentos[0])) {
                                        $resaspirante_documentos=array();
                                    }
            
                                    if (count($resaspirante_documentos)>0) {
                                        $resinsert_documento = $aspirante_documentos->updateRegistro();
                                    } else {
                                        $resinsert_documento = $aspirante_documentos->add();
                                    }
                                    
                                    if ($resinsert_documento) {
                                        $array_resultado_carga[$tipo_documento]='¡Registro editado exitosamente!';
                                    } else {
                                        $array_resultado_carga[$tipo_documento]='¡Problemas al editar el registro, verifique e intente nuevamente!';
                                    }
                                }
                            } else {
                                $array_resultado_carga[$tipo_documento]='¡Problemas al editar el registro, verifique e intente nuevamente!';
                            }
                        }
                    }
    
                    if (isset($_POST["form_enviar_finalizar"])){
                        $oferta->hvao_estado='Documentos Cargados';
                        $oferta->hvao_fecha_diligencia=now();
                        $resoferta_update=$oferta->updateEstado();

                        $aspirante->hva_estado='Documentos Cargados';
                        $aspirante->hva_actualiza_fecha=now();

                        $resupdateestado=$aspirante->updateEstado();
    
                        if ($resoferta_update AND $resupdateestado) {
                            $_SESSION[APP_SESSION.'documentos_fase2']=true;
                            Flasher::new('¡Documentos enviados exitosamente!', 'success');
                        } else {
                            Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                        }
                    }
                }
                
                $aspirante_documentos->hvad_tipo='hoja_vida_personal';
                $aspirante_documentos->hvad_registro_fecha=date('Y-m-d');
                $resdocumento_hoja_vida_personal=$aspirante_documentos->listDetailFormulario();

                if (!isset($resdocumento_hoja_vida_personal[0])) {
                    $resdocumento_hoja_vida_personal=array();
                }

                $control_hoja_vida_personal=false;
                if (count($resdocumento_hoja_vida_personal)>0) {
                    $control_hoja_vida_personal=true;
                }
                
                $aspirante_documentos->hvad_tipo='certificado_estudio_formal';
                $aspirante_documentos->hvad_registro_fecha=date('Y-m-d');
                $resdocumento_certificado_estudio_formal=$aspirante_documentos->listDetailFormulario();

                if (!isset($resdocumento_certificado_estudio_formal[0])) {
                    $resdocumento_certificado_estudio_formal=array();
                }

                $control_certificado_estudio_formal=false;
                if (count($resdocumento_certificado_estudio_formal)>0) {
                    $control_certificado_estudio_formal=true;
                }

                $aspirante_documentos->hvad_tipo='certificado_estudio_no_formal';
                $aspirante_documentos->hvad_registro_fecha=date('Y-m-d');
                $resdocumento_certificado_estudio_no_formal=$aspirante_documentos->listDetailFormulario();

                if (!isset($resdocumento_certificado_estudio_no_formal[0])) {
                    $resdocumento_certificado_estudio_no_formal=array();
                }

                $control_certificado_estudio_no_formal=false;
                if (count($resdocumento_certificado_estudio_no_formal)>0 OR $_POST['certificado_estudio_no_formal_na']=='Si') {
                    $control_certificado_estudio_no_formal=true;
                }

                $aspirante_documentos->hvad_tipo='certificado_laboral';
                $aspirante_documentos->hvad_registro_fecha=date('Y-m-d');
                $resdocumento_certificado_laboral=$aspirante_documentos->listDetailFormulario();

                if (!isset($resdocumento_certificado_laboral[0])) {
                    $resdocumento_certificado_laboral=array();
                }

                $control_certificado_laboral=false;
                if (count($resdocumento_certificado_laboral)>0 OR $_POST['certificado_laboral_na']=='Si' OR $resoferta[0]['hva_auxiliar_2']=='No') {
                    $control_certificado_laboral=true;
                }

                $aspirante_documentos->hvad_tipo='certificado_eps';
                $aspirante_documentos->hvad_registro_fecha=date('Y-m-d');
                $resdocumento_certificado_eps=$aspirante_documentos->listDetailFormulario();

                if (!isset($resdocumento_certificado_eps[0])) {
                    $resdocumento_certificado_eps=array();
                }

                $control_certificado_eps=false;
                if (count($resdocumento_certificado_eps)>0) {
                    $control_certificado_eps=true;
                }

                $aspirante_documentos->hvad_tipo='certificado_pension';
                $aspirante_documentos->hvad_registro_fecha=date('Y-m-d');
                $resdocumento_certificado_pension=$aspirante_documentos->listDetailFormulario();

                if (!isset($resdocumento_certificado_pension[0])) {
                    $resdocumento_certificado_pension=array();
                }

                $control_certificado_pension=false;
                if (count($resdocumento_certificado_pension)>0 OR $_POST['certificado_pension_na']=='Si') {
                    $control_certificado_pension=true;
                }

                $aspirante_documentos->hvad_tipo='certificado_cesantias';
                $aspirante_documentos->hvad_registro_fecha=date('Y-m-d');
                $resdocumento_certificado_cesantias=$aspirante_documentos->listDetailFormulario();

                if (!isset($resdocumento_certificado_cesantias[0])) {
                    $resdocumento_certificado_cesantias=array();
                }

                $control_certificado_cesantias=false;
                if (count($resdocumento_certificado_cesantias)>0 OR $_POST['certificado_cesantias_na']=='Si') {
                    $control_certificado_cesantias=true;
                }

                $aspirante_documentos->hvad_tipo='certificado_bancario';
                $aspirante_documentos->hvad_registro_fecha=date('Y-m-d');
                $resdocumento_certificado_bancario=$aspirante_documentos->listDetailFormulario();

                if (!isset($resdocumento_certificado_bancario[0])) {
                    $resdocumento_certificado_bancario=array();
                }

                $control_certificado_bancario=false;
                if (count($resdocumento_certificado_bancario)>0) {
                    $control_certificado_bancario=true;
                }

                $aspirante_documentos->hvad_tipo='tarjeta_profesional';
                $aspirante_documentos->hvad_registro_fecha=date('Y-m-d');
                $resdocumento_tarjeta_profesional=$aspirante_documentos->listDetailFormulario();

                if (!isset($resdocumento_tarjeta_profesional[0])) {
                    $resdocumento_tarjeta_profesional=array();
                }

                $control_tarjeta_profesional=false;
                if (count($resdocumento_tarjeta_profesional)>0 OR $_POST['tarjeta_profesional_na']=='Si') {
                    $control_tarjeta_profesional=true;
                }

                $aspirante_documentos->hvad_tipo='fotografia';
                $aspirante_documentos->hvad_registro_fecha=date('Y-m-d');
                $resdocumento_fotografia=$aspirante_documentos->listDetailFormulario();

                if (!isset($resdocumento_fotografia[0])) {
                    $resdocumento_fotografia=array();
                }

                $control_fotografia=false;
                if (count($resdocumento_fotografia)>0) {
                    $control_fotografia=true;
                }

                $valida_documentos=false;
                if ($control_hoja_vida_personal AND $control_certificado_estudio_formal AND $control_certificado_estudio_no_formal AND $control_certificado_laboral AND $control_certificado_eps AND $control_certificado_pension AND $control_certificado_cesantias AND $control_certificado_bancario AND $control_tarjeta_profesional AND $control_fotografia) {
                    $valida_documentos=true;
                }

                $resoferta=$oferta->listDetailFormulario();

                if (!isset($resoferta[0])) {
                    $resoferta=array();
                }

                $valida_oferta=1;
                if ($resoferta[0]['hvao_estado']!='Revisado') { 
                    $valida_oferta=0;
                }

                $control_envio=true;
            } else {
                $valida_token=0;
            }

            $data =
            [   
                'titulo_pagina' => 'PROCESO DE SELECCIÓN|HOJA DE VIDA|DOCUMENTOS',
                'path_add' => '/'.base64_encode($id_oferta).'/'.base64_encode($id_token),
                'valida_token' => $valida_token,
                'valida_oferta' => $valida_oferta,
                'valida_documentos' => $valida_documentos,
                'id_oferta' => base64_encode($id_oferta),
                'id_token' => base64_encode($id_token),
                'resultado_aspirante' => to_object($resoferta),
                'hoja_vida_personal' => to_object($resdocumento_hoja_vida_personal),
                'control_hoja_vida_personal' => $control_hoja_vida_personal,
                'certificado_estudio_formal' => to_object($resdocumento_certificado_estudio_formal),
                'control_certificado_estudio_formal' => $control_certificado_estudio_formal,
                'certificado_estudio_no_formal' => to_object($resdocumento_certificado_estudio_no_formal),
                'control_certificado_estudio_no_formal' => $control_certificado_estudio_no_formal,
                'certificado_laboral' => to_object($resdocumento_certificado_laboral),
                'control_certificado_laboral' => $control_certificado_laboral,
                'certificado_eps' => to_object($resdocumento_certificado_eps),
                'control_certificado_eps' => $control_certificado_eps,
                'certificado_pension' => to_object($resdocumento_certificado_pension),
                'control_certificado_pension' => $control_certificado_pension,
                'certificado_cesantias' => to_object($resdocumento_certificado_cesantias),
                'control_certificado_cesantias' => $control_certificado_cesantias,
                'certificado_bancario' => to_object($resdocumento_certificado_bancario),
                'control_certificado_bancario' => $control_certificado_bancario,
                'tarjeta_profesional' => to_object($resdocumento_tarjeta_profesional),
                'control_tarjeta_profesional' => $control_tarjeta_profesional,
                'fotografia' => to_object($resdocumento_fotografia),
                'control_fotografia' => $control_fotografia,
                'resultado_carga' => $array_resultado_carga,
                'primer_empleo' => $resoferta[0]['hva_auxiliar_2'],
            ];
            
            View::render('formulario_documentos_f2', $data);
        }
    }