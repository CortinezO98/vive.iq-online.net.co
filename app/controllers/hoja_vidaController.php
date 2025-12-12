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
    
    class hoja_vidaController extends Controller {
        function __construct()
        {
        }

        function index() {
            Controller::checkSesion();
            Redirect::to('hoja-vida/ver');
        }

        function personal($pagina, $filtro_busqueda, $bandeja) {
            Controller::checkSesion();
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $bandeja=checkInput(base64_decode($bandeja));
            unset($_SESSION[APP_SESSION.'_proceso_add']);
            unset($_SESSION[APP_SESSION.'_proceso_masivo_add']);
            unset($_SESSION[APP_SESSION.'_hoja_vida_add']);
            unset($_SESSION[APP_SESSION.'_correo_masivo_add']);
            unset($_SESSION[APP_SESSION.'_actualizar_masivo_add']);
            // error_reporting(E_ALL);
            // ini_set('display_errors', '1');
            $modulo_perfil=$_SESSION[APP_SESSION.'usu_modulos']['Hoja de Vida-Consolidado'];

            if(isset($_POST["form_filtro_busqueda"])){
                //obtiene variables de formulario
                $filtro_busqueda=checkInput($_POST['filtro_busqueda']);
                $pagina=0;
            }
            
            try {
                $registros = new hv_personalModel();
                $registros->pagina = $pagina;
                $registros->limite = 20;
                $registros->offset = $pagina*$registros->limite;
                $registros->filtro = $filtro_busqueda;
                
                $array_estados=array();
                if ($bandeja=='Todos') {

                } elseif ($bandeja=='Activos') {
                    $array_estados[]='Activo';
                } elseif ($bandeja=='Retirados') {
                    $array_estados[]='Retirado';
                } elseif ($bandeja=='Documentos Nuevos') {
                    $registros->filtro_documentos_nuevos = '1';
                } elseif ($bandeja=='xxx') {
                    
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

                $data =
                [
                    'titulo_pagina' => 'HOJA DE VIDA|PERSONAL|'.mb_strtoupper($bandeja),
                    'path' => 'hoja-vida/personal/',
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
                ];
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            
            View::render('personal', $data);
        }

        public static function personal_detalle($pagina, $filtro_busqueda, $bandeja, $id_registro) {
            $modulo_plataforma="1";
            Controller::checkSesion();
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $bandeja=checkInput(base64_decode($bandeja));
            $id_registro=checkInput(base64_decode($id_registro));
            // ini_set('display_errors', '1');
            // error_reporting(E_ALL);
            $modulo_perfil=$_SESSION[APP_SESSION.'usu_modulos']['Hoja de Vida-Consolidado'];

            $registros = new hv_personalModel();
            $registros->hvp_id=$id_registro;
            $resregistros=$registros->listDetailId();

            if (!isset($resregistros[0])) {
                $resregistros=array();
            }

            
            if(isset($_POST["form_guardar_documentos"])){
                //obtiene variables de formulario

                try {
                    $registros->hvp_alerta_actualizacion='0';

                    $resupdate = $registros->updateAlertaDocumentos();
                    
                    if ($resupdate) {

                        Flasher::new('¡Registro actualizado exitosamente!', 'success');
                    } else {
                        Flasher::new('¡Problemas al actualizar el registro, verifique e intente nuevamente!', 'warning');
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }
            
            $data =
            [
                'titulo_pagina' => 'HOJA DE VIDA|PERSONAL|DETALLE',
                'path' => 'hoja-vida/personal-detalle/',
                'path_add' => '/'.base64_encode($bandeja),
                'resultado_registros' => to_object($resregistros),
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'bandeja' => base64_encode($bandeja),
                'modulo_perfil' => $modulo_perfil,
                'id_registro' => base64_encode($id_registro),

            ];
            
            View::render('personal_detalle', $data);
        }

        public static function personal_crear($pagina, $filtro_busqueda, $bandeja) {
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

            $psicologo = new usuarioModel();
            $respsicologo=$psicologo->listPsicologo();

            if (!isset($respsicologo[0])) {
                $respsicologo=array();
            }
            
            $usuario = new usuarioModel();

            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                $hva_identificacion=checkInput($_POST['hva_identificacion']);
                $hva_nombres=checkInput($_POST['hva_nombres']);
                $hva_nombres_2=checkInput($_POST['hva_nombres_2']);
                $hva_apellido_1=checkInput($_POST['hva_apellido_1']);
                $hva_apellido_2=checkInput($_POST['hva_apellido_2']);
                $hva_correo=checkInput($_POST['hva_correo']);
                $hva_estado=checkInput($_POST['hva_estado']);
                $hva_area=checkInput($_POST['hva_area']);
                $hva_cargo=checkInput($_POST['hva_cargo']);
                $hva_psicologo='';
                $hva_observaciones=checkInput($_POST['hva_observaciones']);

                try {
                    if($_SESSION[APP_SESSION.'_hoja_vida_add']!=1) {
                        $usuario->usu_documento=$hva_identificacion;
                        $usuario->usu_acceso=$hva_identificacion;

                        $nueva_contrasena=newPassword(10);
                        $salt = substr(base64_encode(openssl_random_pseudo_bytes('30')), 0, 22);
                        $salt = strtr($salt, array('+' => '.'));

                        $usuario->usu_contrasena=crypt($nueva_contrasena, '$2y$10$' . $salt);

                        $usuario->usu_nombres_apellidos=$hva_nombres.' '.$hva_nombres_2.' '.$hva_apellido_1.' '.$hva_apellido_2;
                        $usuario->usu_correo=$hva_correo;
                        $usuario->usu_correo_corporativo=$hva_correo;
                        $usuario->usu_fecha_incorporacion=date('Y-m-d');
                        $usuario->usu_area='';
                        $usuario->usu_cargo='';
                        $usuario->usu_jefe_inmediato='';
                        $usuario->usu_ciudad='';
                        $usuario->usu_estado='Activo';
                        $usuario->usu_inicio_sesion='0';
                        $usuario->usu_avatar='avatar/avatar.jpg';
                        $usuario->usu_genero='';
                        $usuario->usu_fecha_nacimiento='';
                        $usuario->usu_perfil='';
                        $usuario->usu_actualiza_fecha='';
                        $usuario->usu_actualiza_login='';
                        $usuario->usu_registro_usuario=checkInput($_SESSION[APP_SESSION.'usu_id']);

                        $resusuario_duplicado=$usuario->listDuplicado();

                        if (!isset($resusuario_duplicado[0])) {
                            $resusuario_duplicado=array();
                        }

                        if (count($resusuario_duplicado)==0) {
                            $resinsert_usuario = $usuario->add();
                        } else {
                            $resinsert_usuario = $resusuario_duplicado[0]['usu_id'];
                        }

                        if ($resinsert_usuario!='') {
                            $usuario->usu_id=$resinsert_usuario;

                            $aspirante_hoja_vida = new hv_personalModel();
                            
                            $aspirante_hoja_vida->hvp_id=$usuario->usu_id;
                            $aspirante_hoja_vida->hvp_consentimiento_tratamiento_datos_personales='';
                            $aspirante_hoja_vida->hvp_datos_personales_tipo_documento='';
                            $aspirante_hoja_vida->hvp_datos_personales_numero_identificacion=$hva_identificacion;
                            $aspirante_hoja_vida->hvp_datos_personales_apellido_1=$hva_apellido_1;
                            $aspirante_hoja_vida->hvp_datos_personales_apellido_2=$hva_apellido_2;
                            $aspirante_hoja_vida->hvp_datos_personales_nombre_1=$hva_nombres;
                            $aspirante_hoja_vida->hvp_datos_personales_nombre_2=$hva_nombres_2;
                            $aspirante_hoja_vida->hvp_demografia_genero='';
                            $aspirante_hoja_vida->hvp_demografia_estado_civil='';
                            $aspirante_hoja_vida->hvp_demografia_lugar_nacimiento='';
                            $aspirante_hoja_vida->hvp_demografia_fecha_nacimiento='';
                            $aspirante_hoja_vida->hvp_demografia_edad='';
                            // $aspirante_hoja_vida->hvp_ubicacion_direccion_residencia=$resaspirante[0]['hva_direccion'];
                            // $aspirante_hoja_vida->hvp_ubicacion_ciudad_residencia=$resaspirante[0]['hva_ciudad'];
                            // $aspirante_hoja_vida->hvp_ubicacion_localidad_comuna=$resaspirante[0]['hva_localidad'];
                            // $aspirante_hoja_vida->hvp_ubicacion_barrio=$resaspirante[0]['hva_barrio'];

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
                            $aspirante_hoja_vida->hvp_contacto_numero_celular='';
                            $aspirante_hoja_vida->hvp_contacto_correo_personal=$hva_correo;
                            $aspirante_hoja_vida->hvp_contacto_correo_corporativo='';
                            $aspirante_hoja_vida->hvp_contacto_emergencia_nombres='';
                            $aspirante_hoja_vida->hvp_contacto_emergencia_apellidos='';
                            $aspirante_hoja_vida->hvp_contacto_emergencia_parentesco='';
                            $aspirante_hoja_vida->hvp_contacto_emergencia_celular='';
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
                            $aspirante_hoja_vida->hvp_interes_habitos_hobbies='';
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
                            $aspirante_hoja_vida->hvp_estado='Activo';
                            $aspirante_hoja_vida->hvp_auxiliar_1='';
                            $aspirante_hoja_vida->hvp_auxiliar_2='';
                            $aspirante_hoja_vida->hvp_auxiliar_3='';
                            $aspirante_hoja_vida->hvp_auxiliar_4='';
                            $aspirante_hoja_vida->hvp_auxiliar_5='';
                            $aspirante_hoja_vida->hvp_usuario_nt='';
                            $aspirante_hoja_vida->hvp_observaciones='';
                            $aspirante_hoja_vida->hvp_actualiza_usuario='';
                            $aspirante_hoja_vida->hvp_actualiza_fecha='';
                            $aspirante_hoja_vida->hvp_registro_usuario=checkInput($_SESSION[APP_SESSION.'usu_id']);

                            $resaspirante_duplicado=$aspirante_hoja_vida->listDuplicate();

                            if (!isset($resaspirante_duplicado[0])) {
                                $resaspirante_duplicado=array();
                            }

                            if (count($resaspirante_duplicado)==0) {
                                $resinsert_aspirante=$aspirante_hoja_vida->add();

                                if ($resinsert_aspirante) {
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
                                        $notificacion->nc_id_modulo='6';
                                        $notificacion->nc_address=$hva_correo.';';
                                        $notificacion->nc_subject="Bienvenido a Vive iQ";
                                        $notificacion->nc_body=notificacion_general($contenido, $boton_titulo, $boton_url);
                                        $notificacion->nc_embeddedimage_ruta="".BASEPATH_IMAGE."/logo/firma-verde.png;".BASEPATH_IMAGE."/logo/logo_notificacion.png";
                                        $notificacion->nc_embeddedimage_nombre="firma-verde;logo_notificacion";
                                        $notificacion->nc_embeddedimage_tipo="image/png;image/png";
                                        $notificacion->nc_usuario_registro=checkInput($_SESSION[APP_SESSION.'usu_id']);
                                        $resnotificacion=$notificacion->add();

                                        if ($resnotificacion) {
                                            Flasher::new('¡Registro creado exitosamente!', 'success');
                                            $_SESSION[APP_SESSION.'_hoja_vida_add']=1;
                                        } else {
                                            Flasher::new('¡Problemas al crear el registro, verifique e intente nuevamente!', 'warning');
                                        }
                                    } else {
                                        Flasher::new('¡Problemas al configurar permisos de usuario, verifique e intente nuevamente!', 'warning');
                                    }
                                } else {
                                    Flasher::new('¡Problemas al configurar permisos de usuario, verifique e intente nuevamente!', 'warning');
                                }
                            } else {
                                Flasher::new('¡El usuario ya existe en el registro de Hoja de Vida, verifique e intente nuevamente!', 'warning');
                            }
                        } else {
                            Flasher::new('¡El usuario ya existe, verifique e intente nuevamente!', 'warning');
                        }
                    } else {
                        Flasher::new('¡Registro creado exitosamente!', 'success');
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }

            $data =
            [
                'titulo_pagina' => 'HOJA DE VIDA|PERSONAL|CREAR',
                'path' => 'hoja-vida/personal-crear/',
                'path_add' => '/'.base64_encode($bandeja),
                'resultado_registros' => to_object($res),
                'pag_inicio' => $pag_inicio,
                'pag_fin' => $pag_fin,
                'pag_total' => $pag_total,
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'resultado_registros_area_lista' => to_object($resarea_lista),
                'resultado_registros_cargo' => to_object($rescargo),
                'resultado_registros_psicologo' => to_object($respsicologo),
                'bandeja' => base64_encode($bandeja),
            ];
            
            View::render('personal_crear', $data);
        }

        public static function personal_editar($pagina, $filtro_busqueda, $bandeja, $id_registro) {
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $bandeja=checkInput(base64_decode($bandeja));
            $id_registro=checkInput(base64_decode($id_registro));
            // ini_set('display_errors', '1');
            // error_reporting(E_ALL);

            $registros = new hv_personalModel();
            $registros->hvp_id=$id_registro;
            $resregistros=$registros->listDetailId();

            if (!isset($resregistros[0])) {
                $resregistros=array();
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

            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                $hvp_datos_personales_nombre_1=checkInput($_POST['hvp_datos_personales_nombre_1']);
                $hvp_datos_personales_nombre_2=checkInput($_POST['hvp_datos_personales_nombre_2']);
                $hvp_datos_personales_apellido_1=checkInput($_POST['hvp_datos_personales_apellido_1']);
                $hvp_datos_personales_apellido_2=checkInput($_POST['hvp_datos_personales_apellido_2']);
                $hvp_contacto_correo_corporativo=checkInput($_POST['hvp_contacto_correo_corporativo']);
                $hvp_fecha_ingreso=checkInput($_POST['hvp_fecha_ingreso']);
                $hvp_centro_costo=checkInput($_POST['hvp_centro_costo']);
                $hvp_cargo=checkInput($_POST['hvp_cargo']);
                $hvp_observaciones=checkInput($_POST['hvp_observaciones']);

                try {
                    $registros->hvp_datos_personales_nombre_1=$hvp_datos_personales_nombre_1;
                    $registros->hvp_datos_personales_nombre_2=$hvp_datos_personales_nombre_2;
                    $registros->hvp_datos_personales_apellido_1=$hvp_datos_personales_apellido_1;
                    $registros->hvp_datos_personales_apellido_2=$hvp_datos_personales_apellido_2;
                    $registros->hvp_contacto_correo_corporativo=$hvp_contacto_correo_corporativo;
                    $registros->hvp_fecha_ingreso=$hvp_fecha_ingreso;
                    $registros->hvp_centro_costo=$hvp_centro_costo;
                    $registros->hvp_cargo=$hvp_cargo;
                    $registros->hvp_observaciones=$hvp_observaciones;

                    $resupdate = $registros->updateInformacion();
                    
                    if ($resupdate) {
                        $aspirante = new hv_aspiranteModel();
                        $aspirante->hva_id = $resregistros[0]['hvp_aspirante_id'];
                        $aspirante->hva_nombres=$hvp_datos_personales_nombre_1;
                        $aspirante->hva_nombres_2=$hvp_datos_personales_nombre_2;
                        $aspirante->hva_apellido_1=$hvp_datos_personales_apellido_1;
                        $aspirante->hva_apellido_2=$hvp_datos_personales_apellido_2;
                        $aspirante->hva_correo_corporativo=strtolower($hvp_contacto_correo_corporativo);
                        $resupdate_aspirante = $aspirante->updateCorreoCorporativo();
                        $resupdate_aspirante = $aspirante->updateAspiranteInformacion();

                        $usuario = new usuarioModel();
                        $usuario->usu_id = $resregistros[0]['hvp_usuario_id'];
                        $usuario->usu_nombres_apellidos=$hvp_datos_personales_nombre_1.' '.$hvp_datos_personales_nombre_2.' '.$hvp_datos_personales_apellido_1.' '.$hvp_datos_personales_apellido_2;
                        $usuario->usu_correo_corporativo=$hvp_contacto_correo_corporativo;
                        $resupdate_usuario = $usuario->updateCorreoCorporativo();
                        $resupdate_usuario = $usuario->updateNombresApellidos();

                        Flasher::new('¡Registro editado exitosamente!', 'success');
                    } else {
                        Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Se ha generado un error al almacenar la información, verifique e intente nuevamente!', 'warning');
                }
            }

            $resregistros=$registros->listDetailId();

            if (!isset($resregistros[0])) {
                $resregistros=array();
            }

            $data =
            [
                'titulo_pagina' => 'HOJA DE VIDA|PERSONAL|EDITAR',
                'path' => 'hoja-vida/personal-editar/',
                'path_add' => '/'.base64_encode($bandeja),
                'resultado_registros' => to_object($resregistros),
                'pag_inicio' => $pag_inicio,
                'pag_fin' => $pag_fin,
                'pag_total' => $pag_total,
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'resultado_registros_area_lista' => to_object($resarea_lista),
                'resultado_registros_cargo' => to_object($rescargo),
                'bandeja' => base64_encode($bandeja),
                'id_registro' => base64_encode($id_registro),

            ];
            
            View::render('personal_editar', $data);
        }

        public static function personal_actualizar_masivo($pagina, $filtro_busqueda, $bandeja) {
            require_once(ROOT.'app/plugins/PHPOffice/vendor/autoload.php');
            $modulo_plataforma="1";
            Controller::checkSesion();
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $bandeja=checkInput(base64_decode($bandeja));
            
            $modulo_perfil=$_SESSION[APP_SESSION.'usu_modulos']['Hoja de Vida-Consolidado'];

            $control_errores_detalle=array();
            $control_registro_detalle=array();

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

            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                $tipo_actualizacion=checkInput($_POST['tipo_actualizacion']);

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
                                if ($columna_a!='') {
                                    $array_data_base[$control_item]['documento_identidad']=$columna_a;//DOCUMENTO_IDENTIDAD
                                    $array_data_base_motivo[$columna_a]['dato']=checkInput(strtoupper($columna_b));//MOTIVO RETIRO
                                } else {
                                    // echo 'Valor en la fila ' . $indicefila . ' no es una fecha: ' . $columna_b . "<br>";
                                    break;
                                    $control_errores++;
                                    $control_errores_detalle[]='Datos incompletos en fila: '.$indicefila;
                                }

                                $control_item++;
                            }

                            
                            for ($i=0; $i < count($array_data_base); $i++) {
                                $documento_identidad=$array_data_base[$i]['documento_identidad'];
                                if ($tipo_actualizacion=='Centro de Costo') {
                                    if (!isset($array_centro_costos[$array_data_base_motivo[$documento_identidad]['dato']]) OR $array_centro_costos[$array_data_base_motivo[$documento_identidad]['dato']]=='') {
                                        $control_errores_detalle[]='Centro de costos ['.$array_data_base_motivo[$documento_identidad]['dato'].'] no identificado en fila: '.$i+1;
                                        $control_errores++;
                                    } else {
                                        $documentos[]=$array_data_base[$i]['documento_identidad'];
                                    }
                                } elseif ($tipo_actualizacion=='Cargo') {
                                    if (!isset($array_cargos[$array_data_base_motivo[$documento_identidad]['dato']]) OR $array_cargos[$array_data_base_motivo[$documento_identidad]['dato']]=='') {
                                        $control_errores_detalle[]='Cargo ['.$array_data_base_motivo[$documento_identidad]['dato'].'] no identificado en fila: '.$i+1;
                                        $control_errores++;
                                    } else {
                                        $documentos[]=$array_data_base[$i]['documento_identidad'];
                                    }
                                
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
                                $control_actualizacion=0;
                                $control_registrar=0;
                                
                                $hojavida = new hv_personalModel();
                                $usuario = new usuarioModel();
                                $contenido_vinculados='';
                                $contenido_desiste='';
                                for ($i = 0; $i <= count($documentos); $i++) {
                                    if ($documentos[$i]!='') {
                                        
                                        $hojavida->hvp_datos_personales_numero_identificacion=$documentos[$i];
                                        $hojavida->hvp_centro_costo=$array_centro_costos[$array_data_base_motivo[$documentos[$i]]['dato']];
                                        $hojavida->hvp_cargo=$array_cargos[$array_data_base_motivo[$documentos[$i]]['dato']];
                                        $hojavida->hvp_actualiza_fecha=now();
                                        $reshojavida=$hojavida->listDuplicate();
        
                                        if (!isset($reshojavida[0])) {
                                            $reshojavida=array();
                                        }

                                        
        
                                        $usuario->usu_documento=$documentos[$i];
                                        $usuario->usu_area=$array_centro_costos[$array_data_base_motivo[$documentos[$i]]['dato']];
                                        $usuario->usu_cargo=$array_cargos[$array_data_base_motivo[$documentos[$i]]['dato']];
                                        $usuario->usu_actualiza_fecha=now();

                                        $resusuario_duplicado=$usuario->listDuplicadoCC();

                                        if (!isset($resusuario_duplicado[0])) {
                                            $resusuario_duplicado=array();
                                        }

                                        if (count($resusuario_duplicado)==0 OR count($reshojavida)==0) {
                                            $control_errores_detalle[]='Usuario no encontrado con documento: '.$documentos[$i];
                                            $resupdate_usuario=true;
                                        } else {
                                            $hojavida->hvp_id=$reshojavida[0]['hvp_id'];
                                            $usuario->usu_id=$resusuario_duplicado[0]['usu_id'];
                                            if ($tipo_actualizacion=='Centro de Costo') {
                                                $resupdate_usuario = $usuario->updateCentroCosto();
                                                $resupdate_hojavida = $hojavida->updateCentroCosto();

                                            } elseif ($tipo_actualizacion=='Cargo') {
                                                $resupdate_usuario = $usuario->updateCargo();
                                                $resupdate_hojavida = $hojavida->updateCargo();

                                            }
                                        }

                                        if ($resupdate_usuario AND $resupdate_hojavida) {
                                            $control_actualizacion++;
                                            
                                        } else {
                                            $control_errores++;
                                            $control_errores_detalle[]='Problemas al actualizar el usuario con documento: '.$documentos[$i];
                                        }
                                        
                                        $control_registrar++;
                                    }
                                }
    
                                if (($control_actualizacion+$control_errores)==$control_registrar) {
                                    Flasher::new('¡Registros actualizados exitosamente!', 'success');
                                    $_SESSION[APP_SESSION.'_actualizar_masivo_add']=1;

                                    
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
                'titulo_pagina' => 'HOJA DE VIDA|PERSONAL|ACTUALIZAR MASIVO',
                'path' => 'hoja-vida/personal-actualizar-masivo/',
                'path_add' => '/'.base64_encode($bandeja),
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'bandeja' => base64_encode($bandeja),
                'resultado_registros_errores' => $control_errores_detalle,
                'resultado_registros_creados' => $control_registro_detalle,
                'modulo_perfil' => $modulo_perfil,

            ];
            
            View::render('personal_actualizar_masivo', $data);
        }

        public static function personal_correo_masivo($pagina, $filtro_busqueda, $bandeja) {
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

            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                $hva_observaciones=checkInput($_POST['hva_observaciones']);
 
                try {
                    if($_SESSION[APP_SESSION.'_correo_masivo_add']!=1) {
                        if ($_FILES['documento_masivo']['name']!="") {
                            $archivo_extension = checkInput(strtolower(pathinfo(basename($_FILES['documento_masivo']['name']), PATHINFO_EXTENSION)));
                            $NombreArchivo=nowFile().".".$archivo_extension;
                            $ruta_actual=UPLOADS_ROOT."hoja_vida/";
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

                            $max_loops = 1000;

                            if ($numeroMayorDeFila < $max_loops) {
                                $control_item=0;
                                for ($indicefila = 2; $indicefila <= $numeroMayorDeFila; $indicefila++) {
                                    $columna_a = $hojaActual->getCellByColumnAndRow(1, $indicefila)->getValue();
                                    $columna_b = $hojaActual->getCellByColumnAndRow(2, $indicefila)->getValue();
                                    
                                    $array_data_base[$control_item]['documento_identidad']=checkInput($columna_a);//DOCUMENTO_IDENTIDAD
                                    $array_data_base[$control_item]['correo']=checkInput(strtolower($columna_b));//CORREO CORPORATIVA

                                    $control_item++;
                                }

                                
                                for ($i=0; $i < count($array_data_base); $i++) { 
                                    if ($array_data_base[$i]['documento_identidad']!='' AND $array_data_base[$i]['correo']!='') {
                                        
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
                            
                                for ($i=0; $i < count($array_data_base); $i++) { 
                                    if ($array_data_base[$i]['documento_identidad']!='' OR $array_data_base[$i]['correo']!='') {
                                        $control_registrar++;
                                        if ($array_data_base[$i]['documento_identidad']!='' AND $array_data_base[$i]['correo']!='') {
                                            $aspirante_hoja_vida->hvp_datos_personales_numero_identificacion=$array_data_base[$i]['documento_identidad'];
                                            $aspirante_hoja_vida->hvp_contacto_correo_corporativo=$array_data_base[$i]['correo'];
                                            $aspirante_hoja_vida->hvp_actualiza_fecha=now();

                                            $reshoja_vida=$aspirante_hoja_vida->listDuplicate();

                                            if (!isset($reshoja_vida[0])) {
                                                $reshoja_vida=array();
                                            }

                                            if (count($reshoja_vida)>0) {
                                                $aspirante_hoja_vida->hvp_id=$reshoja_vida[0]['hvp_id'];
                                                $resupdate = $aspirante_hoja_vida->updateCorreoCorporativo();

                                                if ($resupdate) {
                                                    $usuario->usu_documento=$reshoja_vida[0]['hvp_datos_personales_numero_identificacion'];;
                                                    $usuario->usu_acceso=$reshoja_vida[0]['hvp_datos_personales_numero_identificacion'];;

                                                    $nueva_contrasena=newPassword(10);
                                                    $salt = substr(base64_encode(openssl_random_pseudo_bytes('30')), 0, 22);
                                                    $salt = strtr($salt, array('+' => '.'));

                                                    $usuario->usu_contrasena=crypt($nueva_contrasena, '$2y$10$' . $salt);

                                                    $usuario->usu_nombres_apellidos=$reshoja_vida[0]['hvp_datos_personales_nombre_1'].' '.$reshoja_vida[0]['hvp_datos_personales_nombre_2'].' '.$reshoja_vida[0]['hvp_datos_personales_apellido_1'].' '.$reshoja_vida[0]['hvp_datos_personales_apellido_2'];
                                                    $usuario->usu_correo=$reshoja_vida[0]['hvp_contacto_correo_personal'];
                                                    $usuario->usu_correo_corporativo=$array_data_base[$i]['correo'];
                                                    $usuario->usu_fecha_incorporacion=date('Y-m-d');
                                                    $usuario->usu_area='';
                                                    $usuario->usu_cargo='';
                                                    $usuario->usu_jefe_inmediato='';
                                                    $usuario->usu_ciudad='';
                                                    $usuario->usu_estado='Activo';
                                                    $usuario->usu_inicio_sesion='0';
                                                    $usuario->usu_avatar='avatar/avatar.jpg';
                                                    $usuario->usu_genero='';
                                                    $usuario->usu_fecha_nacimiento='';
                                                    $usuario->usu_perfil='';
                                                    $usuario->usu_actualiza_fecha='';
                                                    $usuario->usu_actualiza_login='';
                                                    $usuario->usu_registro_usuario=checkInput($_SESSION[APP_SESSION.'usu_id']);

                                                    $resusuario_duplicado=$usuario->listDuplicado();

                                                    if (!isset($resusuario_duplicado[0])) {
                                                        $resusuario_duplicado=array();
                                                    }

                                                    if (count($resusuario_duplicado)==0) {
                                                        $resinsert_usuario = $usuario->add();
                                                    } else {
                                                        $resinsert_usuario = $resusuario_duplicado[0]['usu_id'];
                                                    }

                                                    if ($resinsert_usuario!='') {
                                                        $usuario->usu_id=$resinsert_usuario;

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
                                                        $notificacion->nc_id_modulo='6';
                                                        $notificacion->nc_address=$hva_correo.';';
                                                        $notificacion->nc_subject="Bienvenido a Vive iQ";
                                                        $notificacion->nc_body=notificacion_general($contenido, $boton_titulo, $boton_url);
                                                        $notificacion->nc_embeddedimage_ruta="".BASEPATH_IMAGE."/logo/firma-verde.png;".BASEPATH_IMAGE."/logo/logo_notificacion.png";
                                                        $notificacion->nc_embeddedimage_nombre="firma-verde;logo_notificacion";
                                                        $notificacion->nc_embeddedimage_tipo="image/png;image/png";
                                                        $notificacion->nc_usuario_registro=checkInput($_SESSION[APP_SESSION.'usu_id']);
                                                        $resnotificacion=$notificacion->add();

                                                        if ($resnotificacion) {
                                                            $control_insert++;
                                                            $control_registro_detalle[]='Correo corporativo actualizado exitosamente para el usuario: '.$array_data_base[$i]['documento_identidad'];
                                                        } else {
                                                            $control_errores++;
                                                            $control_errores_detalle[]='Problemas al programar notificación para el usuario: '.$array_data_base[$i]['documento_identidad'];
                                                        }
                                                    } else {
                                                        $control_errores++;
                                                        $control_errores_detalle[]='Problemas al crear credenciales para el usuario: '.$array_data_base[$i]['documento_identidad'];
                                                    }
                                                } else {
                                                    $control_errores++;
                                                    $control_errores_detalle[]='Problemas al actualizar el correo para el usuario: '.$array_data_base[$i]['documento_identidad'];
                                                }
                                            } else {
                                                $control_errores++;
                                                $control_errores_detalle[]='Problemas al encontrar el documento para el usuario: '.$array_data_base[$i]['documento_identidad'];
                                            }
                                        } else {
                                            $control_errores++;
                                            $control_errores_detalle[]='Datos incompletos en fila: '.$i+1;
                                        }
                                    }
                                }

                                if (($control_insert+$control_errores)==$control_registrar) {
                                    Flasher::new('¡Registros creados exitosamente!', 'success');
                                    $_SESSION[APP_SESSION.'_correo_masivo_add']=1;
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
                    echo $e->getMessage();
                }
            }

            $data =
            [
                'titulo_pagina' => 'HOJA DE VIDA|PERSONAL|ACTUALIZAR CORREO MASIVO',
                'path' => 'hoja-vida/personal-correo-masivo/',
                'path_add' => '/'.base64_encode($bandeja),
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'bandeja' => base64_encode($bandeja),
                'resultado_registros_errores' => $control_errores_detalle,
                'resultado_registros_creados' => $control_registro_detalle,

            ];
            
            View::render('personal_correo_masivo', $data);
        }

        public static function personal_autorizacion_descargar($id_registro, $tipo_view='') {
            $modulo_plataforma="1";
            Controller::checkSesion();
            // error_reporting(E_ALL);
            // ini_set('display_errors', '1');
            // require_once(ASSETS_ROOT.'plugins/PHPfpdf/mc_table.php');
            // require_once(ASSETS_ROOT.'plugins/TCPDF-main/tcpdf.php');
            // echo ASSETS_ROOT;
            $id_registro=checkInput(base64_decode($id_registro));

            //PDF TCPDF
            $pdf = new CustomTCPDF('P', 'mm', array(216, 355.6), true, 'UTF-8');
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
            
            $aspirante = new hv_personalModel();
            $aspirante->hvp_id=$id_registro;

            $resaspirante=$aspirante->listDetailId();

            if (!isset($resaspirante[0])) {
                $resaspirante=array();
            }

            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 10);
            $pdf->MultiCell('', 1, ''.$resaspirante[0]['TCIUDAD_ciu_municipio'].', '.$resaspirante[0]['TCIUDAD_ciu_departamento'].', '.date('d/m/Y', strtotime($resaspirante[0]['hvp_consentimiento_tratamiento_datos_personales_fecha'])).'', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);
            $pdf->MultiCell('', 1, '', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);
            $pdf->SetFont('Helvetica', 'B', 11);
            $pdf->MultiCell('', 1, 'AUTORIZACIÓN PARA EL TRATAMIENTO DE DATOS PERSONALES<br> Y DECLARACIONES', 0, 'C', 0, 1, '', '', true, 0, true, true, 0);
            $pdf->MultiCell('', 1, '', '', 'L', 0, 1, '', '', true, 0, true, true, 0);
            $pdf->MultiCell('', 1, '', '', 'L', 0, 1, '', '', true, 0, true, true, 0);
            $pdf->MultiCell('', 1, 'NOMBRES Y APELLIDOS: '.$resaspirante[0]['hvp_datos_personales_nombre_1'].' '.$resaspirante[0]['hvp_datos_personales_nombre_2'].' '.$resaspirante[0]['hvp_datos_personales_apellido_1'].' '.$resaspirante[0]['hvp_datos_personales_apellido_2'].'', 'B', 'L', 0, 1, '', '', true, 0, true, true, 0);
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

            if ($resaspirante[0]['hvp_auxiliar_3']!='') {
                // Agregar la firma después de la línea
                $imagenFirma = UPLOADS_ROOT_ASSETS.$resaspirante[0]['hvp_auxiliar_3'];
                $anchoFirma = 30; // ajusta el ancho de la firma según sea necesario
    
                if (file_exists($imagenFirma)) {
                    $pdf->Image($imagenFirma, 15, $posicionAntesDeFirma + 5, $anchoFirma);
                }
            }

            $pdf->SetTextColor(0, 0, 0); // Color de texto negro
            $pdf->SetFont('Helvetica', '', 11);
            $pdf->MultiCell(120, 50, '', '', 'L', 0, 1, '', '');
            $pdf->MultiCell(120, 4, 'Firma', 'T', 'L', 0, 1, '', '');
            $pdf->MultiCell(160, 4, 'Nombres y apellidos: '.$resaspirante[0]['hvp_datos_personales_nombre_1'].' '.$resaspirante[0]['hvp_datos_personales_nombre_2'].' '.$resaspirante[0]['hvp_datos_personales_apellido_1'].' '.$resaspirante[0]['hvp_datos_personales_apellido_2'], '', 'L', 0, 1, '', '');
            $pdf->MultiCell(160, 4, 'Identificación: '.$resaspirante[0]['hvp_datos_personales_numero_identificacion'], '', 'L', 0, 1, '', '');
            // $pdf->MultiCell(70, 4, 'Fecha: '.$resaspirante[0]['ea_identificacion'], '', 'L', 0, 1, '', '');

            $ruta_hoja_vida=UPLOADS_ROOT_ASSETS.'aspirante_documentos/'.$resaspirante[0]['hvp_id'].'/FORMATO AUTORIZACIÓN DE TRATAMIENTO DE DATOS PERSONALES Y DECLARACIONES-'.$resaspirante[0]['hvp_datos_personales_nombre_1'].' '.$resaspirante[0]['hvp_datos_personales_nombre_2'].' '.$resaspirante[0]['hvp_datos_personales_apellido_1'].' '.$resaspirante[0]['hvp_datos_personales_apellido_2'].'.pdf';
            
            if ($tipo_view=='view') {
                $action='I';
            } else {
                $action='D';
            }

            $pdf->Output($ruta_hoja_vida, $action);
            
            $data =
            [
                
            ];
        }

        public static function personal_autorizacion_descargar_zip() {
            $modulo_plataforma="1";
            Controller::checkSesion();
            // error_reporting(E_ALL);
            // ini_set('display_errors', '1');
            // Carpeta temporal para guardar PDFs
            $carpeta_temp = UPLOADS_ROOT_ASSETS . 'tmp_pdfs/';
            if (!is_dir($carpeta_temp)) {
                mkdir($carpeta_temp, 0777, true);
            }
            
            // Helpers
            $normalize_path = function(string $p): string {
                $p = trim($p);
                return preg_replace('#/+#','/',$p);
            };

            // Carga un archivo (cualquiera que sea su extensión), intenta decodificarlo con GD
            // y devuelve PNG en memoria (string) para usar con TCPDF "Image('@'.$bytes,...)".
            $load_image_as_png_bytes = function(string $path) use ($normalize_path) {
                $path = $normalize_path($path);
                if (!is_file($path) || !is_readable($path)) return [null, "no encontrado o sin permisos"];

                $size = @filesize($path);
                if ($size === 0) return [null, "archivo de 0 bytes"];

                $bytes = @file_get_contents($path);
                if ($bytes === false || strlen($bytes) < 16) return [null, "no se pudo leer bytes"];

                if (!function_exists('imagecreatefromstring')) {
                    return [null, "GD no disponible (imagecreatefromstring)"];
                }

                $im = @imagecreatefromstring($bytes);
                if (!$im) return [null, "GD no pudo decodificar (formato inválido/corrupto)"];

                ob_start();
                @imagepng($im);
                $png = ob_get_clean();
                @imagedestroy($im);

                if (!$png || strlen($png) < 100) {
                    return [null, "re-encode PNG inválido"];
                }
                return [$png, null];
            };

            // OJO: esto debe estar en true ANTES de cargar/usar TCPDF para que lance excepciones (por si acaso)
            if (!defined('K_TCPDF_THROW_EXCEPTION_ERROR')) {
                define('K_TCPDF_THROW_EXCEPTION_ERROR', true);
            }

            $aspirante = new hv_personalModel();
            $resaspirante=$aspirante->listAutorizacion();

            if (!isset($resaspirante[0])) {
                $resaspirante=array();
            }

            $archivos_pdf = [];
            $errores_firmas = []; // <-- NEW: acumulador de errores de firmas
            // count($resaspirante)
            for ($i=0; $i < count($resaspirante); $i++) {
                $id_registro=$resaspirante[$i]['hvp_id'];
                $nombres_apellidos=$resaspirante[$i]['hvp_datos_personales_nombre_1'].' '.$resaspirante[$i]['hvp_datos_personales_nombre_2'].' '.$resaspirante[$i]['hvp_datos_personales_apellido_1'].' '.$resaspirante[$i]['hvp_datos_personales_apellido_2'];
                $numero_identificacion=$resaspirante[$i]['hvp_datos_personales_numero_identificacion'];
                try {
                    //PDF TCPDF
                    $pdf = new CustomTCPDF('P', 'mm', array(216, 355.6), true, 'UTF-8');
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

                    $pdf->SetTextColor(0, 0, 0); // Color de texto negro
                    $pdf->SetFont('Helvetica', '', 10);
                    $pdf->MultiCell('', 1, ''.$resaspirante[$i]['TCIUDAD_ciu_municipio'].', '.$resaspirante[$i]['TCIUDAD_ciu_departamento'].', '.date('d/m/Y', strtotime($resaspirante[$i]['hvp_consentimiento_tratamiento_datos_personales_fecha'])).'', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);
                    $pdf->MultiCell('', 1, '', 0, 'L', 0, 1, '', '', true, 0, true, true, 0);
                    $pdf->SetFont('Helvetica', 'B', 11);
                    $pdf->MultiCell('', 1, 'AUTORIZACIÓN PARA EL TRATAMIENTO DE DATOS PERSONALES<br> Y DECLARACIONES', 0, 'C', 0, 1, '', '', true, 0, true, true, 0);
                    $pdf->MultiCell('', 1, '', '', 'L', 0, 1, '', '', true, 0, true, true, 0);
                    $pdf->MultiCell('', 1, '', '', 'L', 0, 1, '', '', true, 0, true, true, 0);
                    $pdf->MultiCell('', 1, 'NOMBRES Y APELLIDOS: '.$resaspirante[$i]['hvp_datos_personales_nombre_1'].' '.$resaspirante[$i]['hvp_datos_personales_nombre_2'].' '.$resaspirante[$i]['hvp_datos_personales_apellido_1'].' '.$resaspirante[$i]['hvp_datos_personales_apellido_2'].'', 'B', 'L', 0, 1, '', '', true, 0, true, true, 0);
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

                    // --- Firma (SIN rutas a archivos en Image())
                    $pdf->SetFont('Helvetica', '', 8);
                    $pdf->MultiCell(160, 4, '', 0, 'L', 0, 1);
                    $posY = $pdf->getY();

                    $ruta_relativa_firma = trim($resaspirante[$i]['hvp_auxiliar_3'] ?? '');
                    $firma_ok = false;

                    if ($ruta_relativa_firma !== '') {
                        $ruta_relativa_firma = ltrim($ruta_relativa_firma, '/');
                        $imagenFirma = rtrim(UPLOADS_ROOT_ASSETS, '/').'/'.$ruta_relativa_firma;
                        $imagenFirma = $normalize_path($imagenFirma);

                        list($pngBytes, $err) = $load_image_as_png_bytes($imagenFirma);

                        if ($pngBytes !== null) {
                            // Pasamos bytes directamente a TCPDF
                            try {
                                $pdf->Image('@'.$pngBytes, 15, $posY + 5, 30); // ancho 30mm
                                $firma_ok = true;
                            } catch (\Throwable $e) {
                                $errores_firmas[] = "ID {$id_registro} | {$numero_identificacion} | {$nombres_apellidos}: TCPDF falló al insertar firma en memoria -> ".$e->getMessage();
                            }
                        } else {
                            $errores_firmas[] = "ID {$id_registro} | {$numero_identificacion} | {$nombres_apellidos}: Firma inválida -> {$err}";
                        }
                    } else {
                        $errores_firmas[] = "ID {$id_registro} | {$numero_identificacion} | {$nombres_apellidos}: Sin ruta de firma definida.";
                    }

                    // Etiquetas finales
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetFont('Helvetica', '', 11);
                    $pdf->MultiCell(120, 50, '', 0, 'L', 0, 1);
                    $pdf->MultiCell(120, 4, 'Firma', 'T', 'L', 0, 1);
                    $pdf->MultiCell(160, 4,
                        'Nombres y apellidos: '.
                        ($resaspirante[$i]['hvp_datos_personales_nombre_1'] ?? '').' '.
                        ($resaspirante[$i]['hvp_datos_personales_nombre_2'] ?? '').' '.
                        ($resaspirante[$i]['hvp_datos_personales_apellido_1'] ?? '').' '.
                        ($resaspirante[$i]['hvp_datos_personales_apellido_2'] ?? ''),
                        0, 'L', 0, 1
                    );
                    $pdf->MultiCell(160, 4, 'Identificación: '.$resaspirante[$i]['hvp_datos_personales_numero_identificacion'], 0, 'L', 0, 1);

                    // Nombre de archivo PDF saneado
                    $nombreLimpio = preg_replace('/[^A-Za-z0-9_\-\. ]+/', '_',
                        'FORMATO AUTORIZACIÓN TDPD-'.
                        $resaspirante[$i]['hvp_id'].' '.
                        $resaspirante[$i]['hvp_datos_personales_nombre_1'].' '.
                        $resaspirante[$i]['hvp_datos_personales_nombre_2'].' '.
                        $resaspirante[$i]['hvp_datos_personales_apellido_1'].' '.
                        $resaspirante[$i]['hvp_datos_personales_apellido_2'].'.pdf'
                    );

                    $ruta_pdf = $carpeta_temp . $nombreLimpio;

                    // Guardar PDF siempre (haya o no firma)
                    $pdf->Output($ruta_pdf, 'F');
                    $archivos_pdf[] = $ruta_pdf;
                } catch (\Throwable $fatal) {
                    // Cualquier otra excepción no prevista
                    $errores_firmas[] = "ID {$id_registro} | {$numero_identificacion} | {$nombres_apellidos}: EXCEPCIÓN FATAL -> ".$fatal->getMessage();
                    // Continua con el siguiente
                    continue;
                }
                
            }

            // ====== CREAR LOG (si hubo errores de firmas) ======
            $ruta_log = null;
            if (!empty($errores_firmas)) {
                $ruta_log = $carpeta_temp.'errores_firmas_'.date('Ymd_His').'.txt';
                $contenido_log = "LOG DE ERRORES DE FIRMAS (".date('Y-m-d H:i:s').")\n";
                $contenido_log .= "Total registros con problema de firma: ".count($errores_firmas)."\n\n";
                $contenido_log .= implode("\n", $errores_firmas)."\n";
                @file_put_contents($ruta_log, $contenido_log);
            }

            // ====== CREAR ZIP ======
            $ruta_zip = $carpeta_temp . 'autorizaciones_' . date('Ymd_His') . '.zip';
            $zip = new ZipArchive();
            if ($zip->open($ruta_zip, ZipArchive::CREATE) === TRUE) {
                foreach ($archivos_pdf as $archivo) {
                    if (is_file($archivo)) {
                        $zip->addFile($archivo, basename($archivo));
                    }
                }
                if ($ruta_log && is_file($ruta_log)) {
                    $zip->addFile($ruta_log, basename($ruta_log));
                }
                $zip->close();
            }

            // ====== FORZAR DESCARGA ======
            if (is_file($ruta_zip)) {
                if (function_exists('ob_get_level')) {
                    while (ob_get_level()) { ob_end_clean(); }
                }
                header('Content-Type: application/zip');
                header('Content-Disposition: attachment; filename="' . basename($ruta_zip) . '"');
                header('Content-Length: ' . filesize($ruta_zip));
                flush();
                readfile($ruta_zip);
            } else {
                header('Content-Type: text/plain; charset=UTF-8');
                echo "No se pudo generar el archivo ZIP.";
            }

            // ====== LIMPIEZA ======
            foreach ($archivos_pdf as $archivo) {
                unlink($archivo);
            }
            unlink($ruta_zip);
            
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
                <td style="background-color: #E2E8F0;"><b>Nombres:</b><br>'.$resaspirante[0]['hva_nombres'].'</td>
                <td style="background-color: #E2E8F0;"><b>Primer apellido:</b><br>'.$resaspirante[0]['hva_apellido_1'].'</td>
                <td style="background-color: #E2E8F0;"><b>Segundo apellido:</b><br>'.$resaspirante[0]['hva_apellido_2'].'</td>
                <td style="background-color: #E2E8F0;"><b>Doc. identidad:</b><br>'.$resaspirante[0]['hva_identificacion'].'</td>
                </tr>';
            $html .= '</table>';

            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
                <td style="background-color: #E2E8F0;"><b>Dirección:</b><br>'.$resaspirante[0]['hva_direccion']. '</td>
                <td style="background-color: #E2E8F0;"><b>Barrio:</b><br>'.$resaspirante[0]['hva_barrio']. '</td>
                <td style="background-color: #E2E8F0;"><b>Ciudad:</b><br>'.$resaspirante[0]['ciu_municipio'].', '.$resaspirante[0]['ciu_departamento']. '</td>
                </tr>';
            $html .= '</table>';

            $html .= '<table cellspacing="2" cellpadding="3">';
            $html .= '<tr>
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
            
            $pdf->MultiCell(160, 4, 'Nombres y apellidos: '.$resaspirante[0]['hva_nombres'].' '.$resaspirante[0]['hva_apellido_1'].' '.$resaspirante[0]['hva_apellido_2'], '', 'L', 0, 1, '', '');
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
            
            
            
            
            $ruta_hoja_vida=UPLOADS_ROOT_ASSETS.'aspirante_documentos/'.$resaspirante[0]['hva_id'].'/FORMATO HOJA DE VIDA-'.$resaspirante[0]['hva_nombres'].' '.$resaspirante[0]['hva_apellido_1'].' '.$resaspirante[0]['hva_apellido_2'].'.pdf';
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
                    $extension = checkInput(strtolower(pathinfo(basename($ruta_documentos_individual), PATHINFO_EXTENSION)));
                    $nombre = $ruta_documentos_nombre[$j].'.'.$extension;
                    if ($extension=='pdf' AND file_exists($ruta_documentos_individual)) {
                        $zip->addFile($ruta_documentos_individual, $nombre);
                    }
                }

                // Cierra el archivo ZIP
                $zip->close();

                // Envía los encabezados necesarios para indicar que se descargará un archivo ZIP
                header('Content-Type: application/zip');
                header('Content-disposition: attachment; filename=' . $resaspirante[0]['hva_identificacion'].'-'.$resaspirante[0]['hva_nombres'].' '.$resaspirante[0]['hva_apellido_1'].' '.$resaspirante[0]['hva_apellido_2'].'.zip');
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
                echo $e->getMessage();
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
                echo $e->getMessage();
            }

            $data =
            [
                'resultado_registros' => to_object($resdocumentos),
            ];
            
            View::render('aspirantes_ofertas_documentos_ver', $data);
        }

        public static function personal_documentos_ver($id_registro) {
            $modulo_plataforma="1";
            Controller::checkSesion();
            // error_reporting(E_ALL);
            $id_registro=checkInput(base64_decode($id_registro));
            
            try {
                
                
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            $data =
            [
                'resultado_registros' => $id_registro,
            ];
            
            View::render('personal_documentos_ver', $data);
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
                echo $e->getMessage();
            }

            $data =
            [
                'resultado_registros' => to_object($resdocumentos),
            ];
            
            View::render('aspirantes_ofertas_documentos_ver', $data);
        }

        public static function formulario_instrucciones($menu_opcion) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // unset($_SESSION[APP_SESSION.'_hv_informacion_general']);
            // error_reporting(E_ALL);
            $menu_opcion=checkInput(base64_decode($menu_opcion));

            try {
                $registro_parametro = new parametroModel();
                $registro_parametro->app_id = 'autorizacion_tratamiento_datos';
                $resregistro_parametro=$registro_parametro->listDetail();

                if (!isset($resregistro_parametro[0])) {
                    $resregistro_parametro=array();
                }

                $ciudad = new ciudadModel();
                $resciudad=$ciudad->listActive();

                if (!isset($resciudad[0])) {
                    $resciudad=array();
                }

                $aspirante = new hv_personalModel();
                $aspirante->hvp_usuario_id=checkInput($_SESSION[APP_SESSION.'usu_aspirante_id']);

                $resaspirante=$aspirante->listDetail();

                if (!isset($resaspirante[0])) {
                    $resaspirante=array();
                }

                if(isset($_POST["form_guardar"])){
                    //obtiene variables de formulario
                    $ruta_guardar_general=ASSETS_ROOT."uploads/hoja_vida_documentos/".$aspirante->hvp_usuario_id."/";
                    if (!file_exists($ruta_guardar_general)) {
                        mkdir($ruta_guardar_general, 0777, true);
                    }
                    
                    $documento_control=0; 
                    if ($_FILES['documento_soporte']['name']!="") {
                        $archivo_extension = checkInput(strtolower(pathinfo(basename($_FILES['documento_soporte']['name']), PATHINFO_EXTENSION)));
                        if ($archivo_extension=="png" OR $archivo_extension=="jpg" OR $archivo_extension=="jpeg") {
                            if ($_FILES['documento_soporte']['size']<=80000000) {
                                $documento_NombreArchivo='firma'.'_'.nowFile().".".$archivo_extension;
                                $documento_ruta_actual=$ruta_guardar_general;
                                $documento_ruta_actual_guardar="hoja_vida_documentos/".$aspirante->hvp_usuario_id."/";
                                $documento_ruta_final=$documento_ruta_actual.$documento_NombreArchivo;
                                $documento_ruta_final_guardar=$documento_ruta_actual_guardar.$documento_NombreArchivo;
                                if ($_FILES['documento_soporte']["error"] > 0) {
                                    $documento_control++;
                                } else {
                                    if (move_uploaded_file($_FILES['documento_soporte']['tmp_name'], $documento_ruta_final)) {
                                        $aspirante->hvp_auxiliar_3=$documento_ruta_final_guardar;
                                        $aspirante->hvp_actualiza_fecha=now();

                                        $resupdate_aspirante_firma = $aspirante->updateAutorizacionFirma();

                                        if ($resupdate_aspirante_firma) {
                                            
                                        } else {
                                            $documento_control++;
                                        }
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
                    }

                    $hvp_consentimiento_tratamiento_datos_personales=checkInput($_POST['hvp_consentimiento_tratamiento_datos_personales']);

                    $aspirante->hvp_consentimiento_tratamiento_datos_personales=$hvp_consentimiento_tratamiento_datos_personales;
                    $aspirante->hvp_consentimiento_tratamiento_datos_personales_fecha=now();
                    $aspirante->hvp_actualiza_fecha=now();

                    $resupdate_aspirante = $aspirante->updateAutorizacion();

                    if ($resaspirante[0]['hvp_consentimiento_tratamiento_datos_personales_fecha']=='') {
                        $aspirante->hvp_consentimiento_tratamiento_datos_personales_fecha=now();
    
                        $resupdate_aspirante_fecha = $aspirante->updateAutorizacionFecha();
                    }
                    
                    if ($resupdate_aspirante AND $documento_control==0) {
                        // Flasher::new('¡Información actualizada exitosamente!', 'success');
                        Redirect::to('hoja-vida/formulario-personal/'.base64_encode('personal').'');
                    } else {
                        Flasher::new('¡Problemas al actualizar la información, verifique e intente nuevamente!', 'warning');
                    }
                }

                $resaspirante=$aspirante->listDetail();

                if (!isset($resaspirante[0])) {
                    $resaspirante=array();
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            $data =
            [   
                'titulo_pagina' => 'HOJA DE VIDA|AUTORIZACIÓN TRATAMIENTO DE DATOS PERSONALES',
                'path_add' => '/'.base64_encode('instrucciones'),
                'menu_opcion' => $menu_opcion,
                'resultado_registros_usuario' => to_object($resaspirante),
                'resultado_registros_usuario_count' => count($resaspirante),
                'resultado_registros_parametros' => to_object($resregistro_parametro),
            ];
            
            View::render('formulario', $data);
        }

        public static function formulario_personal($menu_opcion) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            
            $menu_opcion=checkInput(base64_decode($menu_opcion));

            try {
                $ciudad = new ciudadModel();
                $resciudad=$ciudad->listActive();

                if (!isset($resciudad[0])) {
                    $resciudad=array();
                }

                $aspirante = new hv_personalModel();
                $aspirante->hvp_usuario_id=checkInput($_SESSION[APP_SESSION.'usu_aspirante_id']);
                $resaspirante=$aspirante->listDetail();

                if (!isset($resaspirante[0])) {
                    $resaspirante=array();
                }

                $aspirante_oferta = new hv_aspiranteModel();
                $aspirante_oferta->hva_identificacion=$resaspirante[0]['hvp_datos_personales_numero_identificacion'];

                if(isset($_POST["form_guardar"])){
                    //obtiene variables de formulario
                    $hvp_datos_personales_tipo_documento=checkInput($_POST['hvp_datos_personales_tipo_documento']);
                    $hvp_datos_personales_numero_identificacion=checkInput($_POST['hvp_datos_personales_numero_identificacion']);
                    $hva_auxiliar_5=checkInput($_POST['hva_auxiliar_5']);
                    
                    $aspirante_oferta->hva_auxiliar_5=$hva_auxiliar_5;

                    $resupdate_fechaexpedicion = $aspirante_oferta->updateFechaExpedicion();

                    $hvp_datos_personales_nombre_1=checkInput($_POST['hvp_datos_personales_nombre_1']);
                    $hvp_datos_personales_nombre_2=checkInput($_POST['hvp_datos_personales_nombre_2']);
                    $hvp_datos_personales_apellido_1=checkInput($_POST['hvp_datos_personales_apellido_1']);
                    $hvp_datos_personales_apellido_2=checkInput($_POST['hvp_datos_personales_apellido_2']);
                    $hvp_nombre_preferencia=checkInput($_POST['hvp_nombre_preferencia']);
                    $hvp_demografia_genero=checkInput($_POST['hvp_demografia_genero']);
                    $hvp_demografia_estado_civil=checkInput($_POST['hvp_demografia_estado_civil']);
                    $hvp_demografia_lugar_nacimiento=checkInput($_POST['hvp_demografia_lugar_nacimiento']);
                    $hvp_demografia_fecha_nacimiento=checkInput($_POST['hvp_demografia_fecha_nacimiento']);
                    $hvp_demografia_edad=checkInput($_POST['hvp_demografia_edad']);

                    $hvp_familia_capacitacion_familia=checkInput($_POST['hvp_familia_capacitacion_familia']);
                    $hvp_expectativa_motivacion_expectativa_desarrollo=checkInput($_POST['hvp_expectativa_motivacion_expectativa_desarrollo']);
                    $hvp_expectativa_motivacion_expectativa_crecimiento_profesional=checkInput($_POST['hvp_expectativa_motivacion_expectativa_crecimiento_profesional']);
                    $hvp_expectativa_motivacion_realidad_crecimiento_profesional=checkInput($_POST['hvp_expectativa_motivacion_realidad_crecimiento_profesional']);
                    $hvp_expectativa_motivacion_motivacion_trabajo=checkInput($_POST['hvp_expectativa_motivacion_motivacion_trabajo']);

                    $aspirante->hvp_datos_personales_tipo_documento=$hvp_datos_personales_tipo_documento;
                    $aspirante->hvp_datos_personales_numero_identificacion=$hvp_datos_personales_numero_identificacion;
                    $aspirante->hvp_datos_personales_nombre_1=$hvp_datos_personales_nombre_1;
                    $aspirante->hvp_datos_personales_nombre_2=$hvp_datos_personales_nombre_2;
                    $aspirante->hvp_datos_personales_apellido_1=$hvp_datos_personales_apellido_1;
                    $aspirante->hvp_datos_personales_apellido_2=$hvp_datos_personales_apellido_2;
                    $aspirante->hvp_demografia_genero=$hvp_demografia_genero;
                    $aspirante->hvp_demografia_estado_civil=$hvp_demografia_estado_civil;
                    $aspirante->hvp_demografia_lugar_nacimiento=$hvp_demografia_lugar_nacimiento;
                    $aspirante->hvp_demografia_fecha_nacimiento=$hvp_demografia_fecha_nacimiento;
                    $aspirante->hvp_demografia_edad=$hvp_demografia_edad;
                    $aspirante->hvp_auxiliar_1=$hvp_nombre_preferencia;
                    $aspirante->hvp_familia_capacitacion_familia=$hvp_familia_capacitacion_familia;
                    $aspirante->hvp_expectativa_motivacion_expectativa_desarrollo=$hvp_expectativa_motivacion_expectativa_desarrollo;
                    $aspirante->hvp_expectativa_motivacion_expectativa_crecimiento_profesional=$hvp_expectativa_motivacion_expectativa_crecimiento_profesional;
                    $aspirante->hvp_expectativa_motivacion_realidad_crecimiento_profesional=$hvp_expectativa_motivacion_realidad_crecimiento_profesional;
                    $aspirante->hvp_expectativa_motivacion_motivacion_trabajo=$hvp_expectativa_motivacion_motivacion_trabajo;
                    $aspirante->hvp_actualiza_fecha=now();

                    $resupdate_aspirante = $aspirante->updatePersonal();
                    
                    if ($resupdate_aspirante) {
                        // Flasher::new('¡Información actualizada exitosamente!', 'success');
                        Redirect::to('hoja-vida/formulario-ubicacion/'.base64_encode('ubicacion').'');
                    } else {
                        Flasher::new('¡Problemas al actualizar la información, verifique e intente nuevamente!', 'warning');
                    }
                }

                $resaspirante=$aspirante->listDetail();

                if (!isset($resaspirante[0])) {
                    $resaspirante=array();
                }

                $resaspirante_oferta=$aspirante_oferta->listDuplicado();

                if (!isset($resaspirante_oferta[0])) {
                    $resaspirante_oferta=array();
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            $data =
            [
                'titulo_pagina' => 'HOJA DE VIDA|INFORMACIÓN PERSONAL Y DEMOGRÁFICA',
                'path_add' => '/'.base64_encode('xxx'),
                'menu_opcion' => $menu_opcion,
                'resultado_registros_usuario' => to_object($resaspirante),
                'resultado_registros_oferta' => to_object($resaspirante_oferta),
                'resultado_registros_usuario_count' => count($resaspirante),
                'resultado_registros_ciudad' => to_object($resciudad),
            ];
            
            View::render('formulario_personal', $data);
        }

        public static function formulario_ubicacion($menu_opcion) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            $menu_opcion=checkInput(base64_decode($menu_opcion));
            
            try {
                $aspirante = new hv_personalModel();
                $aspirante->hvp_usuario_id=checkInput($_SESSION[APP_SESSION.'usu_aspirante_id']);

                $ciudad = new ciudadModel();
                $resciudad=$ciudad->listActive();

                if (!isset($resciudad[0])) {
                    $resciudad=array();
                } 

                if(isset($_POST["form_guardar"])){
                    //obtiene variables de formulario
                    $hvp_ubicacion_ciudad_residencia=checkInput($_POST['hvp_ubicacion_ciudad_residencia']);
                    $hvp_ubicacion_direccion_residencia=checkInput($_POST['hvp_ubicacion_direccion_residencia']);
                    $hvp_ubicacion_maps_latitud=checkInput($_POST['hvp_ubicacion_maps_latitud']);
                    $hvp_ubicacion_maps_longitud=checkInput($_POST['hvp_ubicacion_maps_longitud']);
                    $hvp_ubicacion_maps_ciudad=checkInput($_POST['hvp_ubicacion_maps_ciudad']);
                    $hvp_ubicacion_maps_departamento=checkInput($_POST['hvp_ubicacion_maps_departamento']);
                    $hvp_ubicacion_maps_pais=checkInput($_POST['hvp_ubicacion_maps_pais']);
                    $hvp_ubicacion_maps_localidad=checkInput($_POST['hvp_ubicacion_maps_localidad']);
                    $hvp_ubicacion_maps_barrio=checkInput($_POST['hvp_ubicacion_maps_barrio']);
                    $hvp_ubicacion_maps_codigo_postal=checkInput($_POST['hvp_ubicacion_maps_codigo_postal']);
                    $hvp_ubicacion_maps_direccion=checkInput($_POST['hvp_ubicacion_maps_direccion']);

                    $hvp_ubicacion_localidad_comuna=checkInput($_POST['hvp_ubicacion_localidad_comuna']);
                    $hvp_ubicacion_barrio=checkInput($_POST['hvp_ubicacion_barrio']);
                    $hvp_ubicacion_barrio_lista=checkInput($_POST['hvp_ubicacion_barrio_lista']);
                    $hvp_contacto_numero_celular=checkInput($_POST['hvp_contacto_numero_celular']);
                    $hvp_contacto_numero_celular_alternativo=checkInput($_POST['hvp_contacto_numero_celular_alternativo']);
                    
                    $hvp_contacto_correo_personal=checkInput(strtolower($_POST['hvp_contacto_correo_personal']));
                    $hvp_contacto_emergencia_nombres=checkInput($_POST['hvp_contacto_emergencia_nombres']);
                    $hvp_contacto_emergencia_apellidos=checkInput($_POST['hvp_contacto_emergencia_apellidos']);
                    $hvp_contacto_emergencia_parentesco=checkInput($_POST['hvp_contacto_emergencia_parentesco']);
                    $hvp_contacto_emergencia_celular=checkInput($_POST['hvp_contacto_emergencia_celular']);

                    $hvp_contacto_emergencia_nombres_2=checkInput($_POST['hvp_contacto_emergencia_nombres_2']);
                    $hvp_contacto_emergencia_apellidos_2=checkInput($_POST['hvp_contacto_emergencia_apellidos_2']);
                    $hvp_contacto_emergencia_parentesco_2=checkInput($_POST['hvp_contacto_emergencia_parentesco_2']);
                    $hvp_contacto_emergencia_celular_2=checkInput($_POST['hvp_contacto_emergencia_celular_2']);

                    $aspirante->hvp_ubicacion_direccion_residencia=$hvp_ubicacion_direccion_residencia;

                    if ($hvp_ubicacion_ciudad_residencia=="11001" OR $hvp_ubicacion_ciudad_residencia=="05001") {
                        $aspirante->hvp_ubicacion_barrio=$hvp_ubicacion_barrio_lista;
                    } else {
                        $aspirante->hvp_ubicacion_barrio=$hvp_ubicacion_barrio;
                    }

                    $aspirante->hvp_ubicacion_direccion_residencia=$hvp_ubicacion_direccion_residencia;
                    $aspirante->hvp_ubicacion_ciudad_residencia=$hvp_ubicacion_ciudad_residencia;
                    $aspirante->hvp_ubicacion_localidad_comuna=$hvp_ubicacion_localidad_comuna;

                    $aspirante->hvp_ubicacion_maps_latitud=$hvp_ubicacion_maps_latitud;
                    $aspirante->hvp_ubicacion_maps_longitud=$hvp_ubicacion_maps_longitud;
                    $aspirante->hvp_ubicacion_maps_ciudad=$hvp_ubicacion_maps_ciudad;
                    $aspirante->hvp_ubicacion_maps_departamento=$hvp_ubicacion_maps_departamento;
                    $aspirante->hvp_ubicacion_maps_pais=$hvp_ubicacion_maps_pais;
                    $aspirante->hvp_ubicacion_maps_localidad=$hvp_ubicacion_maps_localidad;
                    $aspirante->hvp_ubicacion_maps_barrio=$hvp_ubicacion_maps_barrio;
                    $aspirante->hvp_ubicacion_maps_codigo_postal=$hvp_ubicacion_maps_codigo_postal;
                    $aspirante->hvp_ubicacion_maps_direccion=$hvp_ubicacion_maps_direccion;

                    $aspirante->hvp_contacto_numero_celular=$hvp_contacto_numero_celular;
                    $aspirante->hvp_auxiliar_2=$hvp_contacto_numero_celular_alternativo;

                    $aspirante->hvp_contacto_correo_personal=$hvp_contacto_correo_personal;
                    $aspirante->hvp_contacto_emergencia_nombres=$hvp_contacto_emergencia_nombres;
                    $aspirante->hvp_contacto_emergencia_apellidos=$hvp_contacto_emergencia_apellidos;
                    $aspirante->hvp_contacto_emergencia_parentesco=$hvp_contacto_emergencia_parentesco;
                    $aspirante->hvp_contacto_emergencia_celular=$hvp_contacto_emergencia_celular;

                    $aspirante->hvp_contacto_emergencia_nombres_2=$hvp_contacto_emergencia_nombres_2;
                    $aspirante->hvp_contacto_emergencia_apellidos_2=$hvp_contacto_emergencia_apellidos_2;
                    $aspirante->hvp_contacto_emergencia_parentesco_2=$hvp_contacto_emergencia_parentesco_2;
                    $aspirante->hvp_contacto_emergencia_celular_2=$hvp_contacto_emergencia_celular_2;


                    $aspirante->hvp_actualiza_fecha=now();

                    $resupdate_aspirante = $aspirante->updateUbicacion();
                    
                    if ($resupdate_aspirante) {
                        // Flasher::new('¡Información actualizada exitosamente!', 'success');
                        Redirect::to('hoja-vida/formulario-socioeconomico/'.base64_encode('socioeconomico').'');
                    } else {
                        Flasher::new('¡Problemas al actualizar la información, verifique e intente nuevamente!', 'warning');
                    }
                }

                $resaspirante=$aspirante->listDetail();

                if (!isset($resaspirante[0])) {
                    $resaspirante=array();
                }

                $localidad = new ciudad_barrioModel();
                $localidad->ciub_ciudad=$resaspirante[0]['hvp_ubicacion_ciudad_residencia'];

                $reslocalidad=$localidad->listLocalidad();

                if (!isset($reslocalidad[0])) {
                    $reslocalidad=array();
                }

                $barrio = new ciudad_barrioModel();
                $barrio->ciub_ciudad=$resaspirante[0]['hvp_ubicacion_ciudad_residencia'];
                $barrio->ciub_localidad=$resaspirante[0]['hvp_ubicacion_localidad_comuna'];
                
                // Valida Información Personal
                $resbarrio=$barrio->listBarrio();

                if (!isset($resbarrio[0])) {
                    $resbarrio=array();
                }

                $control_localidad='d-none';
                $control_barrio='d-block';
                $control_barrio_lista='d-none';
                if ($resaspirante[0]['hvp_ubicacion_ciudad_residencia']=='11001' OR $resaspirante[0]['hvp_ubicacion_ciudad_residencia']=='05001') {
                    $control_localidad='d-block';
                    $control_barrio='d-none';
                    $control_barrio_lista='d-block';
                }

                // $hvp_socioeconomico_servicios_vivienda_array=explode(';', $resaspirante[0]['hvp_socioeconomico_servicios_vivienda']);
                $maps_array[0]=$resaspirante[0]['hvp_ubicacion_maps_latitud'];
                $maps_array[1]=$resaspirante[0]['hvp_ubicacion_maps_longitud'];
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            $data =
            [
                'titulo_pagina' => 'HOJA DE VIDA|INFORMACIÓN DE UBICACIÓN Y CONTACTO',
                'path_add' => '/'.base64_encode('xxx'),
                'menu_opcion' => $menu_opcion,
                'resultado_registros_usuario' => to_object($resaspirante),
                'resultado_registros_usuario_count' => count($resaspirante),
                'resultado_registros_ciudad' => to_object($resciudad),
                'resultado_registros_localidad' => to_object($reslocalidad),
                'resultado_registros_barrio' => to_object($resbarrio),
                'control_localidad' => $control_localidad,
                'control_barrio' => $control_barrio,
                'control_barrio_lista' => $control_barrio_lista,
                'maps_array' => $maps_array,
            ];
            
            View::render('formulario_ubicacion', $data);
        }

        public static function formulario_socioeconomico($menu_opcion) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            $menu_opcion=checkInput(base64_decode($menu_opcion));
            try {

                $registro_parametro = new parametroModel();
                $registro_parametro->app_id = 'autorizacion_sagrilaft';
                $resregistro_parametro=$registro_parametro->listDetail();

                if (!isset($resregistro_parametro[0])) {
                    $resregistro_parametro=array();
                }

                $registro_parametro->app_id = 'hoja_vida_operador_internet';
                $resregistro_operador_internet=$registro_parametro->listDetail();

                if (!isset($resregistro_operador_internet[0])) {
                    $resregistro_operador_internet=array();
                }

                $array_operador_internet=explode(';', $resregistro_operador_internet[0]['app_descripcion']);

                $aspirante = new hv_personalModel();
                $aspirante->hvp_usuario_id=checkInput($_SESSION[APP_SESSION.'usu_aspirante_id']);

                if(isset($_POST["form_guardar"])){
                    //obtiene variables de formulario
                    $hvp_socioeconomico_estrato_socioeconomico=checkInput($_POST['hvp_socioeconomico_estrato_socioeconomico']);
                    $hvp_socioeconomico_operador_internet=checkInput($_POST['hvp_socioeconomico_operador_internet']);
                    $hvp_socioeconomico_operador_internet_otro=checkInput($_POST['hvp_socioeconomico_operador_internet_otro']);
                    $hvp_socioeconomico_velocidad_internet_descarga=checkInput($_POST['hvp_socioeconomico_velocidad_internet_descarga']);
                    $hvp_socioeconomico_velocidad_internet_carga=checkInput($_POST['hvp_socioeconomico_velocidad_internet_carga']);
                    $hvp_socioeconomico_caracteristicas_vivienda=checkInput($_POST['hvp_socioeconomico_caracteristicas_vivienda']);
                    $hvp_socioeconomico_condiciones_vivienda=checkInput($_POST['hvp_socioeconomico_condiciones_vivienda']);
                    $hvp_socioeconomico_estado_terminacion_vivienda=checkInput($_POST['hvp_socioeconomico_estado_terminacion_vivienda']);
                    $hvp_socioeconomico_servicios_vivienda_array=$_POST['hvp_socioeconomico_servicios_vivienda'];
                    
                    $hvp_socioeconomico_servicios_vivienda=implode(';', $hvp_socioeconomico_servicios_vivienda_array);
                    
                    $hvp_socioeconomico_plan_compra_vivienda=checkInput($_POST['hvp_socioeconomico_plan_compra_vivienda']);
                    $hvp_socioeconomico_beneficiario_subsidio_vivienda=checkInput($_POST['hvp_socioeconomico_beneficiario_subsidio_vivienda']);
                    $hvp_familia_numero_hijos=checkInput($_POST['hvp_familia_numero_hijos']);
                    
                    $edad_hijos=array();
                    if ($hvp_familia_numero_hijos>0) {
                        for ($i=1; $i <= $hvp_familia_numero_hijos; $i++) { 
                            $edad_hijos[]=$_POST['edad_hijos_'.$i.''];
                        }
                    }

                    $edad_hijos_str=implode(';', $edad_hijos);
                    
                    $hvp_familia_capacitacion_familia=checkInput($_POST['hvp_familia_capacitacion_familia']);
                    $hvp_financiero_activos=checkInput($_POST['hvp_financiero_activos']);
                    $hvp_financiero_ingresos=checkInput($_POST['hvp_financiero_ingresos']);
                    $hvp_financiero_pasivos=checkInput($_POST['hvp_financiero_pasivos']);
                    $hvp_financiero_egresos=checkInput($_POST['hvp_financiero_egresos']);
                    $hvp_financiero_patrimonio=checkInput($_POST['hvp_financiero_patrimonio']);
                    $hvp_financiero_ingresos_otros=checkInput($_POST['hvp_financiero_ingresos_otros']);
                    $hvp_financiero_concepto_ingresos=checkInput($_POST['hvp_financiero_concepto_ingresos']);
                    $hvp_financiero_moneda_extranjera=checkInput($_POST['hvp_financiero_moneda_extranjera']);

                    $hvp_origen_fondos=checkInput($_POST['hvp_origen_fondos']);
                    $hvp_pep_recursos=checkInput($_POST['hvp_pep_recursos']);
                    $hvp_pep_reconocimiento=checkInput($_POST['hvp_pep_reconocimiento']);
                    $hvp_pep_poder=checkInput($_POST['hvp_pep_poder']);
                    $hvp_pep_familiar=checkInput($_POST['hvp_pep_familiar']);
                    $hvp_pep_cedula=checkInput($_POST['hvp_pep_cedula']);
                    $hvp_pep_nombres_apellidos=checkInput($_POST['hvp_pep_nombres_apellidos']);

                    $aspirante->hvp_socioeconomico_estrato_socioeconomico=$hvp_socioeconomico_estrato_socioeconomico;
                    $aspirante->hvp_socioeconomico_operador_internet=$hvp_socioeconomico_operador_internet;
                    $aspirante->hvp_socioeconomico_operador_internet_otro=$hvp_socioeconomico_operador_internet_otro;
                    $aspirante->hvp_socioeconomico_velocidad_internet_descarga=$hvp_socioeconomico_velocidad_internet_descarga;
                    $aspirante->hvp_socioeconomico_velocidad_internet_carga=$hvp_socioeconomico_velocidad_internet_carga;
                    $aspirante->hvp_socioeconomico_caracteristicas_vivienda=$hvp_socioeconomico_caracteristicas_vivienda;
                    $aspirante->hvp_socioeconomico_condiciones_vivienda=$hvp_socioeconomico_condiciones_vivienda;
                    $aspirante->hvp_socioeconomico_estado_terminacion_vivienda=$hvp_socioeconomico_estado_terminacion_vivienda;
                    $aspirante->hvp_socioeconomico_servicios_vivienda=$hvp_socioeconomico_servicios_vivienda;
                    $aspirante->hvp_socioeconomico_plan_compra_vivienda=$hvp_socioeconomico_plan_compra_vivienda;
                    $aspirante->hvp_socioeconomico_beneficiario_subsidio_vivienda=$hvp_socioeconomico_beneficiario_subsidio_vivienda;
                    $aspirante->hvp_familia_numero_hijos=$hvp_familia_numero_hijos;
                    $aspirante->hvp_familia_hijos_menor_3=$edad_hijos_str;
                    $aspirante->hvp_familia_capacitacion_familia=$hvp_familia_capacitacion_familia;
                    $aspirante->hvp_financiero_activos=$hvp_financiero_activos;
                    $aspirante->hvp_financiero_ingresos=$hvp_financiero_ingresos;
                    $aspirante->hvp_financiero_pasivos=$hvp_financiero_pasivos;
                    $aspirante->hvp_financiero_egresos=$hvp_financiero_egresos;
                    $aspirante->hvp_financiero_patrimonio=$hvp_financiero_patrimonio;
                    $aspirante->hvp_financiero_ingresos_otros=$hvp_financiero_ingresos_otros;
                    $aspirante->hvp_financiero_concepto_ingresos=$hvp_financiero_concepto_ingresos;
                    $aspirante->hvp_financiero_moneda_extranjera=$hvp_financiero_moneda_extranjera;
                    $aspirante->hvp_origen_fondos=$hvp_origen_fondos;
                    $aspirante->hvp_pep_recursos=$hvp_pep_recursos;
                    $aspirante->hvp_pep_reconocimiento=$hvp_pep_reconocimiento;
                    $aspirante->hvp_pep_poder=$hvp_pep_poder;
                    $aspirante->hvp_pep_familiar=$hvp_pep_familiar;
                    $aspirante->hvp_pep_cedula=$hvp_pep_cedula;
                    $aspirante->hvp_pep_nombres_apellidos=$hvp_pep_nombres_apellidos;
                    
                    
                    $aspirante->hvp_actualiza_fecha=now();

                    $resupdate_aspirante = $aspirante->updateSocioeconomico();

                    
                    if ($resupdate_aspirante) {
                        // Flasher::new('¡Información actualizada exitosamente!', 'success');
                        Redirect::to('hoja-vida/formulario-salud-bienestar/'.base64_encode('salud-bienestar').'');
                    } else {
                        Flasher::new('¡Problemas al actualizar la información, verifique e intente nuevamente!', 'warning');
                    }
                }

                $resaspirante=$aspirante->listDetail();

                if (!isset($resaspirante[0])) {
                    $resaspirante=array();
                }

                $hvp_socioeconomico_servicios_vivienda_array=explode(';', $resaspirante[0]['hvp_socioeconomico_servicios_vivienda']);
                $edad_hijos_final_array=explode(';', $resaspirante[0]['hvp_familia_hijos_menor_3']);
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            $data =
            [
                'titulo_pagina' => 'HOJA DE VIDA|INFORMACIÓN SOCIOECONÓMICA Y FAMILIAR',
                'path_add' => '/'.base64_encode('xxx'),
                'menu_opcion' => $menu_opcion,
                'resultado_registros_usuario' => to_object($resaspirante),
                'resultado_registros_usuario_count' => count($resaspirante),
                'hvp_socioeconomico_servicios_vivienda_array' => $hvp_socioeconomico_servicios_vivienda_array,
                'edad_hijos_final_array' => $edad_hijos_final_array,
                'resultado_registros_parametros' => to_object($resregistro_parametro),
                'resultado_registros_operador_internet' => $array_operador_internet,
            ];
            
            View::render('formulario_socioeconomico', $data);
        }

        public static function formulario_salud_bienestar($menu_opcion) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            $menu_opcion=checkInput(base64_decode($menu_opcion));
            try {
                $registro_parametro = new parametroModel();
                $registro_parametro->app_id = 'hoja_vida_medicina_prepagada';
                $resregistro_medicina_prepagada=$registro_parametro->listDetail();

                if (!isset($resregistro_medicina_prepagada[0])) {
                    $resregistro_medicina_prepagada=array();
                }

                $array_medicina_prepagada=explode(';', $resregistro_medicina_prepagada[0]['app_descripcion']);

                $registro_parametro->app_id = 'hoja_vida_plan_complementario_salud';
                $resregistro_complementario_salud=$registro_parametro->listDetail();

                if (!isset($resregistro_complementario_salud[0])) {
                    $resregistro_complementario_salud=array();
                }

                $array_complementario_salud=explode(';', $resregistro_complementario_salud[0]['app_descripcion']);

                $aspirante = new hv_personalModel();
                $aspirante->hvp_usuario_id=checkInput($_SESSION[APP_SESSION.'usu_aspirante_id']);

                if(isset($_POST["form_guardar"])){
                    //obtiene variables de formulario
                    $hvp_salud_bienestar_grupo_sanguineo=checkInput($_POST['hvp_salud_bienestar_grupo_sanguineo']);
                    $hvp_salud_bienestar_rh=checkInput($_POST['hvp_salud_bienestar_rh']);
                    $hvp_salud_bienestar_actividad_fisica_minima=checkInput($_POST['hvp_salud_bienestar_actividad_fisica_minima']);
                    $hvp_salud_bienestar_fumador=checkInput($_POST['hvp_salud_bienestar_fumador']);
                    $hvp_salud_bienestar_pausas_activas=checkInput($_POST['hvp_salud_bienestar_pausas_activas']);
                    $hvp_salud_bienestar_medicina_prepagada=checkInput($_POST['hvp_salud_bienestar_medicina_prepagada']);
                    $hvp_salud_bienestar_medicina_prepagada_cual=checkInput($_POST['hvp_salud_bienestar_medicina_prepagada_cual']);
                    $hvp_salud_bienestar_plan_complementario_salud=checkInput($_POST['hvp_salud_bienestar_plan_complementario_salud']);
                    $hvp_salud_bienestar_plan_complementario_salud_cual=checkInput($_POST['hvp_salud_bienestar_plan_complementario_salud_cual']);


                    $aspirante->hvp_salud_bienestar_grupo_sanguineo=$hvp_salud_bienestar_grupo_sanguineo;
                    $aspirante->hvp_salud_bienestar_rh=$hvp_salud_bienestar_rh;
                    $aspirante->hvp_salud_bienestar_actividad_fisica_minima=$hvp_salud_bienestar_actividad_fisica_minima;
                    $aspirante->hvp_salud_bienestar_fumador=$hvp_salud_bienestar_fumador;
                    $aspirante->hvp_salud_bienestar_pausas_activas=$hvp_salud_bienestar_pausas_activas;
                    $aspirante->hvp_salud_bienestar_medicina_prepagada=$hvp_salud_bienestar_medicina_prepagada;
                    $aspirante->hvp_salud_bienestar_medicina_prepagada_cual=$hvp_salud_bienestar_medicina_prepagada_cual;
                    $aspirante->hvp_salud_bienestar_plan_complementario_salud=$hvp_salud_bienestar_plan_complementario_salud;
                    $aspirante->hvp_salud_bienestar_plan_complementario_salud_cual=$hvp_salud_bienestar_plan_complementario_salud_cual;
                    $aspirante->hvp_actualiza_fecha=now();

                    $resupdate_aspirante = $aspirante->updateSaludBienestar();

                    
                    if ($resupdate_aspirante) {
                        // Flasher::new('¡Información actualizada exitosamente!', 'success');
                        Redirect::to('hoja-vida/formulario-intereses-habitos/'.base64_encode('intereses-habitos').'');
                    } else {
                        Flasher::new('¡Problemas al actualizar la información, verifique e intente nuevamente!', 'warning');
                    }
                }

                $resaspirante=$aspirante->listDetail();

                if (!isset($resaspirante[0])) {
                    $resaspirante=array();
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            $data =
            [
                'titulo_pagina' => 'HOJA DE VIDA|INFORMACIÓN DE SALUD Y BIENESTAR',
                'path_add' => '/'.base64_encode('xxx'),
                'menu_opcion' => $menu_opcion,
                'resultado_registros_usuario' => to_object($resaspirante),
                'resultado_registros_usuario_count' => count($resaspirante),
                'resultado_registros_medicina_prepagada' => $array_medicina_prepagada,
                'resultado_registros_complementario_salud' => $array_complementario_salud,
            ];
            
            View::render('formulario_salud_bienestar', $data);
        }

        public static function formulario_intereses_habitos($menu_opcion) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            $menu_opcion=checkInput(base64_decode($menu_opcion));
            try {
                $aspirante = new hv_personalModel();
                $aspirante->hvp_usuario_id=checkInput($_SESSION[APP_SESSION.'usu_aspirante_id']);

                if(isset($_POST["form_guardar"])){
                    //obtiene variables de formulario
                    $hvp_interes_habitos_hobbies_deportes=checkInput($_POST['hvp_interes_habitos_hobbies_deportes']);
                    $hvp_interes_habitos_hobbies_deportes_frecuencia=checkInput($_POST['hvp_interes_habitos_hobbies_deportes_frecuencia']);
                    $hvp_interes_habitos_hobbies_deportes_cual=checkInput($_POST['hvp_interes_habitos_hobbies_deportes_cual']);
                    $hvp_interes_habitos_hobbies_aire=checkInput($_POST['hvp_interes_habitos_hobbies_aire']);
                    $hvp_interes_habitos_hobbies_aire_frecuencia=checkInput($_POST['hvp_interes_habitos_hobbies_aire_frecuencia']);
                    $hvp_interes_habitos_hobbies_aire_cual=checkInput($_POST['hvp_interes_habitos_hobbies_aire_cual']);
                    $hvp_interes_habitos_hobbies_arte=checkInput($_POST['hvp_interes_habitos_hobbies_arte']);
                    $hvp_interes_habitos_hobbies_arte_frecuencia=checkInput($_POST['hvp_interes_habitos_hobbies_arte_frecuencia']);
                    $hvp_interes_habitos_hobbies_arte_instrumento=checkInput($_POST['hvp_interes_habitos_hobbies_arte_instrumento']);
                    $hvp_interes_habitos_hobbies_arte_cual=checkInput($_POST['hvp_interes_habitos_hobbies_arte_cual']);
                    $hvp_interes_habitos_hobbies_tecnologia=checkInput($_POST['hvp_interes_habitos_hobbies_tecnologia']);
                    $hvp_interes_habitos_hobbies_tecnologia_frecuencia=checkInput($_POST['hvp_interes_habitos_hobbies_tecnologia_frecuencia']);
                    $hvp_interes_habitos_hobbies_tecnologia_cual=checkInput($_POST['hvp_interes_habitos_hobbies_tecnologia_cual']);
                    $hvp_interes_habitos_hobbies_otro=checkInput($_POST['hvp_interes_habitos_hobbies_otro']);
                    $hvp_interes_habitos_hobbies_otro_frecuencia=checkInput($_POST['hvp_interes_habitos_hobbies_otro_frecuencia']);
                    $hvp_interes_habitos_hobbies_otro_cual=checkInput($_POST['hvp_interes_habitos_hobbies_otro_cual']);
                    $hvp_interes_habitos_hobbies_recibir_informacion=checkInput($_POST['hvp_interes_habitos_hobbies_recibir_informacion']);


                    $hvp_interes_habitos_actividades_familia=checkInput($_POST['hvp_interes_habitos_actividades_familia']);
                    $hvp_interes_habitos_actividades_deportivas=checkInput($_POST['hvp_interes_habitos_actividades_deportivas']);
                    $hvp_interes_habitos_actividades_deportivas_cual=checkInput($_POST['hvp_interes_habitos_actividades_deportivas_cual']);
                    $hvp_interes_habitos_medio_transporte=checkInput($_POST['hvp_interes_habitos_medio_transporte']);
                    $hvp_interes_habitos_habito_ahorro=checkInput($_POST['hvp_interes_habitos_habito_ahorro']);
                    $hvp_interes_habitos_mascotas=checkInput($_POST['hvp_interes_habitos_mascotas']);
                    $hvp_interes_habitos_mascotas_cual=checkInput($_POST['hvp_interes_habitos_mascotas_cual']);


                    $aspirante->hvp_interes_habitos_hobbies_deportes=$hvp_interes_habitos_hobbies_deportes;
                    $aspirante->hvp_interes_habitos_hobbies_deportes_frecuencia=$hvp_interes_habitos_hobbies_deportes_frecuencia;
                    $aspirante->hvp_interes_habitos_hobbies_deportes_cual=$hvp_interes_habitos_hobbies_deportes_cual;
                    $aspirante->hvp_interes_habitos_hobbies_aire=$hvp_interes_habitos_hobbies_aire;
                    $aspirante->hvp_interes_habitos_hobbies_aire_frecuencia=$hvp_interes_habitos_hobbies_aire_frecuencia;
                    $aspirante->hvp_interes_habitos_hobbies_aire_cual=$hvp_interes_habitos_hobbies_aire_cual;
                    $aspirante->hvp_interes_habitos_hobbies_arte=$hvp_interes_habitos_hobbies_arte;
                    $aspirante->hvp_interes_habitos_hobbies_arte_frecuencia=$hvp_interes_habitos_hobbies_arte_frecuencia;
                    $aspirante->hvp_interes_habitos_hobbies_arte_instrumento=$hvp_interes_habitos_hobbies_arte_instrumento;
                    $aspirante->hvp_interes_habitos_hobbies_arte_cual=$hvp_interes_habitos_hobbies_arte_cual;
                    $aspirante->hvp_interes_habitos_hobbies_tecnologia=$hvp_interes_habitos_hobbies_tecnologia;
                    $aspirante->hvp_interes_habitos_hobbies_tecnologia_frecuencia=$hvp_interes_habitos_hobbies_tecnologia_frecuencia;
                    $aspirante->hvp_interes_habitos_hobbies_tecnologia_cual=$hvp_interes_habitos_hobbies_tecnologia_cual;
                    $aspirante->hvp_interes_habitos_hobbies_otro=$hvp_interes_habitos_hobbies_otro;
                    $aspirante->hvp_interes_habitos_hobbies_otro_frecuencia=$hvp_interes_habitos_hobbies_otro_frecuencia;
                    $aspirante->hvp_interes_habitos_hobbies_otro_cual=$hvp_interes_habitos_hobbies_otro_cual;
                    $aspirante->hvp_interes_habitos_hobbies_recibir_informacion=$hvp_interes_habitos_hobbies_recibir_informacion;

                    $aspirante->hvp_interes_habitos_actividades_familia=$hvp_interes_habitos_actividades_familia;
                    $aspirante->hvp_interes_habitos_actividades_deportivas=$hvp_interes_habitos_actividades_deportivas;
                    $aspirante->hvp_interes_habitos_actividades_deportivas_cual=$hvp_interes_habitos_actividades_deportivas_cual;
                    $aspirante->hvp_interes_habitos_medio_transporte=$hvp_interes_habitos_medio_transporte;
                    $aspirante->hvp_interes_habitos_habito_ahorro=$hvp_interes_habitos_habito_ahorro;
                    $aspirante->hvp_interes_habitos_mascotas=$hvp_interes_habitos_mascotas;
                    $aspirante->hvp_interes_habitos_mascotas_cual=$hvp_interes_habitos_mascotas_cual;
                    $aspirante->hvp_actualiza_fecha=now();

                    $resupdate_aspirante = $aspirante->updateHabitos();

                    
                    if ($resupdate_aspirante) {
                        // Flasher::new('¡Información actualizada exitosamente!', 'success');
                        Redirect::to('hoja-vida/formulario-formacion/'.base64_encode('formacion').'');
                    } else {
                        Flasher::new('¡Problemas al actualizar la información, verifique e intente nuevamente!', 'warning');
                    }
                }

                //Pendiente validar lista de prepagadas en cada ciudad donde tiene sede la empresa

                $resaspirante=$aspirante->listDetail();

                if (!isset($resaspirante[0])) {
                    $resaspirante=array();
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            $data =
            [
                'titulo_pagina' => 'HOJA DE VIDA|INFORMACIÓN DE INTERESES Y HÁBITOS',
                'path_add' => '/'.base64_encode('xxx'),
                'menu_opcion' => $menu_opcion,
                'resultado_registros_usuario' => to_object($resaspirante),
                'resultado_registros_usuario_count' => count($resaspirante),
            ];
            
            View::render('formulario_intereses_habitos', $data);
        }

        public static function formulario_formacion($menu_opcion) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            $menu_opcion=checkInput(base64_decode($menu_opcion));
            try {
                $aspirante = new hv_personalModel();
                $aspirante->hvp_usuario_id=checkInput($_SESSION[APP_SESSION.'usu_aspirante_id']);

                if(isset($_POST["form_guardar"])){
                    //obtiene variables de formulario
                    $hvp_formacion_nivel_academico_culminado=checkInput($_POST['hvp_formacion_nivel_academico_culminado']);
                    $hvp_auxiliar_4=checkInput($_POST['hvp_auxiliar_4']);
                    
                    $hvp_formacion_ultimo_certificado_enviado_rrhh=checkInput($_POST['hvp_formacion_ultimo_certificado_enviado_rrhh']);
                    $hvp_formacion_ultimo_estudio_realizado_titulo=checkInput($_POST['hvp_formacion_ultimo_estudio_realizado_titulo']);
                    $hvp_formacion_tarjeta_profesional=checkInput($_POST['hvp_formacion_tarjeta_profesional']);
                    $hvp_auxiliar_5=checkInput($_POST['hvp_auxiliar_5']);

                    $hvp_formacion_estudios_curso=checkInput($_POST['hvp_formacion_estudios_curso']);
                    $hvp_formacion_estudios_curso_titulo=checkInput($_POST['hvp_formacion_estudios_curso_titulo']);
                    $hvp_formacion_estudios_curso_nivel=checkInput($_POST['hvp_formacion_estudios_curso_nivel']);
                    $hvp_formacion_estudios_curso_establecimiento=checkInput($_POST['hvp_formacion_estudios_curso_establecimiento']);
                    $hvp_habilidades_nivel_ingles=checkInput($_POST['hvp_habilidades_nivel_ingles']);
                    $hvp_habilidades_nivel_excel=checkInput($_POST['hvp_habilidades_nivel_excel']);
                    $hvp_habilidades_nivel_google_ws=checkInput($_POST['hvp_habilidades_nivel_google_ws']);

                    //obtiene variables de formulario
                    $ruta_guardar_general=ASSETS_ROOT."uploads/hoja_vida_documentos/".$aspirante->hvp_usuario_id."/";
                    if (!file_exists($ruta_guardar_general)) {
                        mkdir($ruta_guardar_general, 0777, true);
                    }

                    $documento_control=0;
                    if ($_FILES['documento_soporte_ultimo_estudio']['name']!="") {
                        $archivo_extension = checkInput(strtolower(pathinfo(basename($_FILES['documento_soporte_ultimo_estudio']['name']), PATHINFO_EXTENSION)));
                        if ($archivo_extension=="pdf") {
                            if ($_FILES['documento_soporte_ultimo_estudio']['size']<=80000000) {
                                $documento_NombreArchivo='ultimo_certificado'.'_'.nowFile().".".$archivo_extension;
                                $documento_ruta_actual=$ruta_guardar_general;
                                $documento_ruta_actual_guardar="hoja_vida_documentos/".$aspirante->hvp_usuario_id."/";
                                $documento_ruta_final=$documento_ruta_actual.$documento_NombreArchivo;
                                $documento_ruta_final_guardar=$documento_ruta_actual_guardar.$documento_NombreArchivo;
                                if ($_FILES['documento_soporte_ultimo_estudio']["error"] > 0) {
                                    $documento_control++;
                                } else {
                                    if (move_uploaded_file($_FILES['documento_soporte_ultimo_estudio']['tmp_name'], $documento_ruta_final)) {
                                        $aspirante->hvp_auxiliar_4=$documento_ruta_final_guardar;
                                        $aspirante->hvp_alerta_actualizacion='1';
                                        $aspirante->hvp_actualiza_fecha=now();

                                        $resupdate_aspirante_certificado = $aspirante->updateUltimoCertificado();

                                        if ($resupdate_aspirante_certificado) {
                                            
                                        } else {
                                            $documento_control++;
                                        }
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
                    }

                    if ($_FILES['documento_soporte_tarjeta_profesional']['name']!="") {
                        $archivo_extension = checkInput(strtolower(pathinfo(basename($_FILES['documento_soporte_tarjeta_profesional']['name']), PATHINFO_EXTENSION)));
                        if ($archivo_extension=="pdf") {
                            if ($_FILES['documento_soporte_tarjeta_profesional']['size']<=80000000) {
                                $documento_NombreArchivo='tarjeta_profesional'.'_'.nowFile().".".$archivo_extension;
                                $documento_ruta_actual=$ruta_guardar_general;
                                $documento_ruta_actual_guardar="hoja_vida_documentos/".$aspirante->hvp_usuario_id."/";
                                $documento_ruta_final=$documento_ruta_actual.$documento_NombreArchivo;
                                $documento_ruta_final_guardar=$documento_ruta_actual_guardar.$documento_NombreArchivo;
                                if ($_FILES['documento_soporte_tarjeta_profesional']["error"] > 0) {
                                    $documento_control++;
                                } else {
                                    if (move_uploaded_file($_FILES['documento_soporte_tarjeta_profesional']['tmp_name'], $documento_ruta_final)) {
                                        $aspirante->hvp_auxiliar_5=$documento_ruta_final_guardar;
                                        $aspirante->hvp_alerta_actualizacion='1';
                                        $aspirante->hvp_actualiza_fecha=now();

                                        $resupdate_aspirante_tarjeta = $aspirante->updateTarjetaProfesional();

                                        if ($resupdate_aspirante_tarjeta) {
                                            
                                        } else {
                                            $documento_control++;
                                        }
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
                    }



                    $aspirante->hvp_formacion_nivel_academico_culminado=$hvp_formacion_nivel_academico_culminado;
                    $aspirante->hvp_formacion_ultimo_certificado_enviado_rrhh=$hvp_formacion_ultimo_certificado_enviado_rrhh;
                    $aspirante->hvp_formacion_ultimo_estudio_realizado_titulo=$hvp_formacion_ultimo_estudio_realizado_titulo;
                    $aspirante->hvp_formacion_tarjeta_profesional=$hvp_formacion_tarjeta_profesional;
                    
                    $aspirante->hvp_formacion_estudios_curso=$hvp_formacion_estudios_curso;
                    $aspirante->hvp_formacion_estudios_curso_titulo=$hvp_formacion_estudios_curso_titulo;
                    $aspirante->hvp_formacion_estudios_curso_nivel=$hvp_formacion_estudios_curso_nivel;
                    $aspirante->hvp_formacion_estudios_curso_establecimiento=$hvp_formacion_estudios_curso_establecimiento;
                    $aspirante->hvp_habilidades_nivel_ingles=$hvp_habilidades_nivel_ingles;
                    $aspirante->hvp_habilidades_nivel_excel=$hvp_habilidades_nivel_excel;
                    $aspirante->hvp_habilidades_nivel_google_ws=$hvp_habilidades_nivel_google_ws;
                    $aspirante->hvp_actualiza_fecha=now();

                    $resupdate_aspirante = $aspirante->updateFormacionHabilidades();

                    
                    if ($resupdate_aspirante AND $documento_control==0) {
                        // Flasher::new('¡Información actualizada exitosamente!', 'success');
                        Redirect::to('hoja-vida/formulario-poblaciones/'.base64_encode('poblaciones').'');
                    } else {
                        Flasher::new('¡Problemas al actualizar la información, verifique e intente nuevamente!', 'warning');
                    }
                }

                $resaspirante=$aspirante->listDetail();

                if (!isset($resaspirante[0])) {
                    $resaspirante=array();
                }

                $ciudad = new ciudadModel();
                $resciudad=$ciudad->listActive();

                if (!isset($resciudad[0])) {
                    $resciudad=array();
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            $data =
            [
                'titulo_pagina' => 'HOJA DE VIDA|INFORMACIÓN DE FORMACIÓN Y HABILIDADES',
                'path_add' => '/'.base64_encode('xxx'),
                'menu_opcion' => $menu_opcion,
                'resultado_registros_usuario' => to_object($resaspirante),
                'resultado_registros_usuario_count' => count($resaspirante),
                'resultado_registros_ciudad' => to_object($resciudad),
                'id_aspirante' => base64_encode($resaspirante[0]['hvp_aspirante_id']),
            ];
            
            View::render('formulario_formacion', $data);
        }

        public static function formulario_estudio_curso_registro() {
            if(isset($_POST["id_aspirante"])){
                try {
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
                    $aspirante_estudio->hvaec_registro_usuario=checkInput($_SESSION[APP_SESSION.'usu_id']);;

                    $resinsert = $aspirante_estudio->add();
                    $resultado_lista='';
                    if ($resinsert) {
                        $resultado_valor = 1;
                    } else {
                        $resultado_valor = 0;
                    }
                } catch (Exception $e) {
                    $e->getMessage();
                }
            }
          
            $data = array(
                "resultado_lista" => $resultado_lista,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function formulario_estudio_curso_eliminar() {
            if(isset($_POST["id_aspirante"])){
                try {
                    $id_aspirante = checkInput(base64_decode($_POST["id_aspirante"]));

                    //obtiene variables de formulario
                    $id_registro = checkInput(base64_decode($_POST["id_registro"]));

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
                    $e->getMessage();
                }
            }
          
            $data = array(
                "resultado_lista" => $resultado_lista,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function formulario_estudio_curso_listar() {
            if(isset($_POST["id_aspirante"])){
                try {
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
                                            <th class="px-1 py-2 text-center font-size-12">Institución educativa	</th>
                                            <th class="px-1 py-2 text-center font-size-12">Título a obtener</th>
                                            <th class="px-1 py-2 text-center font-size-12">Ciudad</th>
                                            <th class="px-1 py-2 text-center font-size-12">Horario</th>
                                            <th class="px-1 py-2 text-center font-size-12">Modalidad</th>
                                            <th class="px-1 py-2 text-center font-size-12">Fecha terminación</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                        for ($i=0; $i < count($resaspirante_estudio); $i++) { 
                            // 
                            $resultado_lista.='<tr>
                                            <td class="p-1 text-center">
                                                <a class="btn btn-danger btn-sm font-size-11 btn-table" title="Eliminar" onclick="estudio_curso_del('."'".base64_encode($resaspirante_estudio[$i]['hvaec_id'])."'".')"><i class="fas fa-trash-alt font-size-11"></i></a>
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
                    $e->getMessage();
                }
            }
          
            $data = array(
                "resultado_lista" => $resultado_lista,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function formulario_estudio_culminado_registro() {
            if(isset($_POST["id_aspirante"])){
                try {
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
                    $aspirante_estudio->hvaet_registro_usuario=checkInput($_SESSION[APP_SESSION.'usu_id']);;;

                    $resinsert = $aspirante_estudio->add();

                    $resultado_lista='';
                    if ($resinsert) {
                        $resultado_valor = 1;
                    } else {
                        $resultado_valor = 0;
                    }
                } catch (Exception $e) {
                    $e->getMessage();
                }
            }
          
            $data = array(
                "resultado_lista" => $resultado_lista,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function formulario_estudio_culminado_eliminar() {
            if(isset($_POST["id_aspirante"])){
                try {
                    $id_aspirante = checkInput(base64_decode($_POST["id_aspirante"]));
                    

                    //obtiene variables de formulario
                    $id_registro = checkInput(base64_decode($_POST["id_registro"]));

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
                    $e->getMessage();
                }
            }
          
            $data = array(
                "resultado_lista" => $resultado_lista,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function formulario_estudio_culminado_listar() {
            if(isset($_POST["id_aspirante"])){
                try {
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
                                            <th class="px-1 py-2 text-center font-size-12">Institución educativa</th>
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
                            // 
                            $resultado_lista.='<tr>
                                            <td class="p-1 text-center">
                                                <a class="btn btn-danger btn-sm font-size-11 btn-table" title="Eliminar" onclick="estudio_culminado_del('."'".base64_encode($resaspirante_estudio[$i]['hvaet_id'])."'".')"><i class="fas fa-trash-alt font-size-11"></i></a>
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
                    $e->getMessage();
                }
            }
          
            $data = array(
                "resultado_lista" => $resultado_lista,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function formulario_poblaciones($menu_opcion) {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            $menu_opcion=checkInput(base64_decode($menu_opcion));
            try {
                $registro_parametro = new parametroModel();
                $registro_parametro->app_id = 'veracidad_informacion';
                $resregistro_parametro=$registro_parametro->listDetail();

                if (!isset($resregistro_parametro[0])) {
                    $resregistro_parametro=array();
                }

                $registro_parametro->app_id = 'codigo_etica_buen_gobierno';
                $resregistro_parametro_cod_etica=$registro_parametro->listDetail();

                if (!isset($resregistro_parametro_cod_etica[0])) {
                    $resregistro_parametro_cod_etica=array();
                }

                $aspirante = new hv_personalModel();
                $aspirante->hvp_usuario_id=checkInput($_SESSION[APP_SESSION.'usu_aspirante_id']);

                if(isset($_POST["form_guardar"])){
                    //obtiene variables de formulario
                    $hvp_poblaciones_poblacion=checkInput($_POST['hvp_poblaciones_poblacion']);
                    $hvp_poblaciones_certificado=checkInput($_POST['hvp_poblaciones_certificado']);
                    $hvp_poblaciones_familiares_iq=checkInput($_POST['hvp_poblaciones_familiares_iq']);
                    $hvp_poblaciones_familiares_iq_identificacion=checkInput($_POST['hvp_poblaciones_familiares_iq_identificacion']);
                    $hvp_poblaciones_familiares_iq_nombres_apellidos=checkInput($_POST['hvp_poblaciones_familiares_iq_nombres_apellidos']);
                    $hvp_poblaciones_familiares_iq_ingreso_marzo_2022=checkInput($_POST['hvp_poblaciones_familiares_iq_ingreso_marzo_2022']);
                    $hvp_veracidad=checkInput($_POST['hvp_veracidad']);
                    
                    //Validar cargue soporte
                    //obtiene variables de formulario
                    $ruta_guardar_general=ASSETS_ROOT."uploads/hoja_vida_documentos/".$aspirante->hvp_id."/";
                    if (!file_exists($ruta_guardar_general)) {
                        mkdir($ruta_guardar_general, 0777, true);
                    }
                    
                    $documento_control=0;
                    if ($hvp_poblaciones_certificado=='Si') {
                        if ($_FILES['hvp_poblaciones_poblacion_soporte']['name']!="") {
                            $archivo_extension = checkInput(strtolower(pathinfo(basename($_FILES['hvp_poblaciones_poblacion_soporte']['name']), PATHINFO_EXTENSION)));
                            if ($archivo_extension=="pdf" OR $archivo_extension=="png" OR $archivo_extension=="jpg" OR $archivo_extension=="jpeg") {
                                if ($_FILES['hvp_poblaciones_poblacion_soporte']['size']<=80000000) {
                                    $documento_NombreArchivo='certificado_poblacion_'.nowFile().".".$archivo_extension;
                                    $documento_ruta_actual=$ruta_guardar_general;
                                    $documento_ruta_actual_guardar="hoja_vida_documentos/".$aspirante->hvp_id."/";
                                    $documento_ruta_final=$documento_ruta_actual.$documento_NombreArchivo;
                                    $documento_ruta_final_guardar=$documento_ruta_actual_guardar.$documento_NombreArchivo;
                                    if ($_FILES['hvp_poblaciones_poblacion_soporte']["error"] > 0) {
                                        $documento_control++;
                                    } else {
                                        if (move_uploaded_file($_FILES['hvp_poblaciones_poblacion_soporte']['tmp_name'], $documento_ruta_final)) {
                                            $aspirante->hvp_poblaciones_poblacion_soporte=$documento_ruta_final_guardar;
                                            $resupdate_aspirante = $aspirante->updatePoblacionesSoporte();
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
                    } else {
                        $documento_ruta_final_guardar='';
                        // $documento_control++;
                        $aspirante->hvp_poblaciones_poblacion_soporte=$documento_ruta_final_guardar;
                        $resupdate_aspirante = $aspirante->updatePoblacionesSoporte();
                    }

                    $aspirante->hvp_poblaciones_poblacion=$hvp_poblaciones_poblacion;
                    $aspirante->hvp_poblaciones_certificado=$hvp_poblaciones_certificado;
                    $aspirante->hvp_poblaciones_poblacion_soporte=$documento_ruta_final_guardar;
                    $aspirante->hvp_poblaciones_familiares_iq=$hvp_poblaciones_familiares_iq;
                    $aspirante->hvp_poblaciones_familiares_iq_identificacion=$hvp_poblaciones_familiares_iq_identificacion;
                    $aspirante->hvp_poblaciones_familiares_iq_nombres_apellidos=$hvp_poblaciones_familiares_iq_nombres_apellidos;
                    $aspirante->hvp_poblaciones_familiares_iq_ingreso_marzo_2022=$hvp_poblaciones_familiares_iq_ingreso_marzo_2022;
                    $aspirante->hvp_veracidad=$hvp_veracidad;
                    
                    $aspirante->hvp_actualiza_fecha=now();

                    $resupdate_aspirante = $aspirante->updatePoblaciones();
                    
                    if ($resupdate_aspirante) {
                        Flasher::new('¡Información actualizada exitosamente!', 'success');
                    } else {
                        Flasher::new('¡Problemas al actualizar la información, verifique e intente nuevamente!', 'warning');
                    }
                }

                $resaspirante=$aspirante->listDetail();

                if (!isset($resaspirante[0])) {
                    $resaspirante=array();
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            $data =
            [
                'titulo_pagina' => 'HOJA DE VIDA|INFORMACIÓN DE POBLACIONES Y RELACIONES FAMILIARES',
                'path_add' => '/'.base64_encode('xxx'),
                'menu_opcion' => $menu_opcion,
                'resultado_registros_usuario' => to_object($resaspirante),
                'resultado_registros_usuario_count' => count($resaspirante),
                'resultado_registros_parametros' => to_object($resregistro_parametro),
                'resultado_registros_parametros_cod_etica' => to_object($resregistro_parametro_cod_etica),
            ];
            
            View::render('formulario_poblaciones', $data);
        }

        public static function mostrar_seccion() {
            if(isset($_POST["id_aspirante"])){
                try {
                    $id_aspirante = checkInput(base64_decode($_POST["id_aspirante"]));
                    $seccion = checkInput($_POST["seccion"]);

                    $aspirante = new hv_personalModel();
                    $aspirante->hvp_id=$id_aspirante;
                    $resaspirante=$aspirante->listDetailId();

                    if (!isset($resaspirante[0])) {
                        $resaspirante=array();
                    }

                    $registro_parametro = new parametroModel();
                    $registro_parametro->app_id = 'autorizacion_tratamiento_datos';
                    $resregistro_parametro=$registro_parametro->listDetail();

                    if (!isset($resregistro_parametro[0])) {
                        $resregistro_parametro=array();
                    }

                    $id_aspirante = $resaspirante[0]['hvp_aspirante_id'];

                    $aspirante_estudio = new hv_aspirante_estudio_cursoModel();
                    $aspirante_estudio->hvaec_aspirante=$id_aspirante;
                    $resaspirante_estudio=$aspirante_estudio->listDetail();

                    if (!isset($resaspirante_estudio[0])) {
                        $resaspirante_estudio=array();
                    }

                    $aspirante_estudio_culminado = new hv_aspirante_estudio_terminadoModel();
                    $aspirante_estudio_culminado->hvaet_aspirante=$id_aspirante;
                    $resaspirante_estudio_culminado=$aspirante_estudio_culminado->listDetail();

                    if (!isset($resaspirante_estudio_culminado[0])) {
                        $resaspirante_estudio_culminado=array();
                    }

                    $registro_parametro->app_id = 'veracidad_informacion';
                    $resregistro_parametro_poblaciones=$registro_parametro->listDetail();

                    if (!isset($resregistro_parametro_poblaciones[0])) {
                        $resregistro_parametro_poblaciones=array();
                    }

                    $registro_parametro->app_id = 'codigo_etica_buen_gobierno';
                    $resregistro_parametro_cod_etica=$registro_parametro->listDetail();

                    if (!isset($resregistro_parametro_cod_etica[0])) {
                        $resregistro_parametro_cod_etica=array();
                    }

                    if (count($resaspirante)>0) {
                        $resultado_valor = 1;

                        if ($seccion=='instrucciones') {
                            $checked = ($resaspirante[0]['hvp_consentimiento_tratamiento_datos_personales'] == 'Si') ? 'checked' : '';

                            $resultado_lista = '<div class="col-md-12 mb-2">
                                <label for="">Progreso</label><span class="float-end">Completado: <span id="avance_total"></span> de <span id="secciones_total"></span></span>
                                <div class="progress" style="height: 25px;" id="avance_barra"></div>
                            </div>
                            <div class="col-md-12">
                                <p class="alert alert-corp p-1 my-0"><span class="fas fa-file-signature"></span> Autorización para el Tratamiento de Datos Personales</p>
                            </div>
                            <div class="col-md-12">
                                <div class="bg-light p-3 overflow-y-scroll" style="min-height: 100px !important; max-height: 300px !important;">
                                    '.$resregistro_parametro[0]['app_descripcion'].'
                                </div>
                            </div>
                            <div class="col-md-12 my-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Si" name="hvp_consentimiento_tratamiento_datos_personales" id="hvp_consentimiento_tratamiento_datos_personales" '.$checked.' required disabled>
                                    <label class="form-check-label font-size-12 fw-bold" for="hvp_consentimiento_tratamiento_datos_personales">Si, autorizo el tratamiento de datos personales</label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">';
                            if($resaspirante[0]['hvp_auxiliar_3']=='') {
                                $resultado_lista .= '<p class="alert alert-warning p-1 font-size-11 mt-0 mb-2">Para autorizar el Tratamiento de Datos Personales, por favor cargue la firma en formato de imagen.</p>';
                            } else {
                                $resultado_lista .= '<img src="'.UPLOADS.$resaspirante[0]['hvp_auxiliar_3'].'" class="img-fluid mb-2" style="width: 100px;">';
                            }
                            $resultado_lista .= '</div>';
                        } elseif ($seccion=='personal') {
                            $resultado_lista = '<div class="col-md-12 mb-2">
                                                <label for="">Progreso</label><span class="float-end">Completado: <span id="avance_total"></span> de <span id="secciones_total"></span></span>
                                                <div class="progress" style="height: 25px;" id="avance_barra">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-user-tie"></span> Información Personal</p>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label for="hvp_datos_personales_tipo_documento" class="form-label my-0 font-size-12">Tipo de documento de identidad</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1 is-in valid" name="hvp_datos_personales_numero_identificacion" id="hvp_datos_personales_numero_identificacion" value="'.$resaspirante[0]['hvp_datos_personales_tipo_documento'].'" required readonly>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="hvp_datos_personales_numero_identificacion" class="form-label my-0 font-size-12">Número de identificación</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1 is-in valid" name="hvp_datos_personales_numero_identificacion" id="hvp_datos_personales_numero_identificacion" value="'.$resaspirante[0]['hvp_datos_personales_numero_identificacion'].'" required readonly>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="hva_auxiliar_5" class="form-label my-0 font-size-12">Fecha de expedición</label>
                                                    <input type="date" class="form-control form-control-sm font-size-11 px-2 py-1 is-in valid" name="hva_auxiliar_5" id="hva_auxiliar_5" value="'.$resaspirante[0]['hva_auxiliar_5'].'" required readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_datos_personales_nombre_1" class="form-label my-0 font-size-12">Primer nombre</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_datos_personales_nombre_1" id="hvp_datos_personales_nombre_1" value="'.$resaspirante[0]['hvp_datos_personales_nombre_1'].'" required readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_datos_personales_nombre_2" class="form-label my-0 font-size-12">Segundo nombre</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_datos_personales_nombre_2" id="hvp_datos_personales_nombre_2" value="'.$resaspirante[0]['hvp_datos_personales_nombre_2'].'" readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_datos_personales_apellido_1" class="form-label my-0 font-size-12">Primer apellido</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_datos_personales_apellido_1" id="hvp_datos_personales_apellido_1" value="'.$resaspirante[0]['hvp_datos_personales_apellido_1'].'" required readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_datos_personales_apellido_2" class="form-label my-0 font-size-12">Segundo apellido</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_datos_personales_apellido_2" id="hvp_datos_personales_apellido_2" value="'.$resaspirante[0]['hvp_datos_personales_apellido_2'].'" required readonly>
                                            </div>
                                            <div class="col-md-3 mb-3 " id="div_hvp_nombre_preferencia">';
                                                if ($resaspirante[0]['hvp_auxiliar_1']!='') {
                                                    $resultado_lista.='<label for="hvp_nombre_preferencia" class="form-label my-0 font-size-12">¿Cómo prefieres que te llamen?</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_nombre_preferencia" id="hvp_nombre_preferencia" value="'.$resaspirante[0]['hvp_auxiliar_1'].'" required readonly>';
                                                }
                                                
                                    $resultado_lista.='</div>

                                            <div class="col-md-12">
                                                <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-address-card"></span> Información Demográfica</p>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_demografia_genero" class="form-label my-0 font-size-12">¿Cuál es tu género?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_demografia_genero" id="hvp_demografia_genero" value="'.$resaspirante[0]['hvp_demografia_genero'].'" required readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_demografia_estado_civil" class="form-label my-0 font-size-12">¿Cuál es tu estado civil ?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_demografia_estado_civil" id="hvp_demografia_estado_civil" value="'.$resaspirante[0]['hvp_demografia_estado_civil'].'" required readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="hvp_demografia_lugar_nacimiento" class="form-label my-0 font-size-12">Lugar nacimiento</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_demografia_lugar_nacimiento" id="hvp_demografia_lugar_nacimiento" value="'.$resaspirante[0]['TCIUDADN_ciu_municipio'].', '.$resaspirante[0]['TCIUDADN_ciu_departamento'].'" required readonly>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="hvp_demografia_fecha_nacimiento" class="form-label my-0 font-size-12">Fecha nacimiento</label>
                                                <input type="date" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_demografia_fecha_nacimiento" id="hvp_demografia_fecha_nacimiento" value="'.$resaspirante[0]['hvp_demografia_fecha_nacimiento'].'" required readonly>
                                            </div>
                                            <div class="col-md-1 mb-3">
                                                <label for="hvp_demografia_edad" class="form-label my-0 font-size-12">Edad</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_demografia_edad" id="hvp_demografia_edad" value="'.$resaspirante[0]['hvp_demografia_edad'].'" readonly required>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-history"></span> Información Antiguedad</p>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="hvp_expectativa_motivacion_expectativa_desarrollo" class="form-label my-0 font-size-12">¿Llevas más de 6 meses en la compañía?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_demografia_edad" id="hvp_demografia_edad" value="'.$resaspirante[0]['hvp_expectativa_motivacion_expectativa_desarrollo'].'" readonly required>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3 d-none" id="div_hvp_expectativa_motivacion_expectativa_crecimiento_profesional">
                                                    <label for="hvp_expectativa_motivacion_expectativa_crecimiento_profesional" class="form-label my-0 font-size-12">¿Crees que este trabajo te ofrecerá oportunidades de crecimiento profesional?</label>
                                                    <div id="experience-level" class="btn-group w-100" role="group" aria-label="Calificación">
                                                        <!-- Botones toggle -->
                                                        <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_expectativa_crecimiento_profesional" id="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level1" value="1" '.(($resaspirante[0]['hvp_expectativa_motivacion_expectativa_crecimiento_profesional']=='1') ? 'checked' : '').' required disabled>
                                                        <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level1">1</label>

                                                        <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_expectativa_crecimiento_profesional" id="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level2" value="2" '.(($resaspirante[0]['hvp_expectativa_motivacion_expectativa_crecimiento_profesional']=='2') ? 'checked' : '').' required disabled>
                                                        <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level2">2</label>

                                                        <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_expectativa_crecimiento_profesional" id="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level3" value="3" '.(($resaspirante[0]['hvp_expectativa_motivacion_expectativa_crecimiento_profesional']=='3') ? 'checked' : '').' required disabled>
                                                        <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level3">3</label>

                                                        <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_expectativa_crecimiento_profesional" id="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level4" value="4" '.(($resaspirante[0]['hvp_expectativa_motivacion_expectativa_crecimiento_profesional']=='4') ? 'checked' : '').' required disabled>
                                                        <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level4">4</label>

                                                        <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_expectativa_crecimiento_profesional" id="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level5" value="5" '.(($resaspirante[0]['hvp_expectativa_motivacion_expectativa_crecimiento_profesional']=='5') ? 'checked' : '').' required disabled>
                                                        <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_expectativa_crecimiento_profesional_level5">5</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3 d-none" id="div_hvp_expectativa_motivacion_realidad_crecimiento_profesional">
                                                    <label for="hvp_expectativa_motivacion_realidad_crecimiento_profesional" class="form-label my-0 font-size-12">¿En qué medida estás de acuerdo con la siguiente afirmación?:<br><br><b><i>“Este trabajo me ha ofrecido oportunidades de crecimiento laboral.”</i></b></label>
                                                    <div id="experience-level" class="btn-group w-100" role="group" aria-label="Calificación">
                                                        <!-- Botones toggle -->
                                                        <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_realidad_crecimiento_profesional" id="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level1" value="Totalmente en desacuerdo" '.(($resaspirante[0]['hvp_expectativa_motivacion_realidad_crecimiento_profesional']=='Totalmente en desacuerdo') ? 'checked' : '').' required disabled>
                                                        <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level1">Totalmente en desacuerdo</label>

                                                        <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_realidad_crecimiento_profesional" id="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level2" value="En desacuerdo" '.(($resaspirante[0]['hvp_expectativa_motivacion_realidad_crecimiento_profesional']=='En desacuerdo') ? 'checked' : '').' required disabled>
                                                        <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level2">En desacuerdo</label>

                                                        <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_realidad_crecimiento_profesional" id="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level3" value="Ni de acuerdo ni en desacuerdo" '.(($resaspirante[0]['hvp_expectativa_motivacion_realidad_crecimiento_profesional']=='Ni de acuerdo ni en desacuerdo') ? 'checked' : '').' required disabled>
                                                        <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level3">Ni de acuerdo ni en desacuerdo</label>

                                                        <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_realidad_crecimiento_profesional" id="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level4" value="De acuerdo" '.(($resaspirante[0]['hvp_expectativa_motivacion_realidad_crecimiento_profesional']=='De acuerdo') ? 'checked' : '').' required disabled>
                                                        <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level4">De acuerdo</label>

                                                        <input type="radio" class="btn-check" name="hvp_expectativa_motivacion_realidad_crecimiento_profesional" id="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level5" value="Totalmente de acuerdo" '.(($resaspirante[0]['hvp_expectativa_motivacion_realidad_crecimiento_profesional']=='Totalmente de acuerdo') ? 'checked' : '').' required disabled>
                                                        <label class="btn btn-outline-primary p-1 font-size-11" for="hvp_expectativa_motivacion_realidad_crecimiento_profesional_level5">Totalmente de acuerdo</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3 d-none" id="div_hvp_expectativa_motivacion_motivacion_trabajo">
                                                <label for="hvp_expectativa_motivacion_motivacion_trabajo" class="form-label my-0 font-size-12">Motivación principal para aceptar el trabajo</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_expectativa_motivacion_motivacion_trabajo" id="hvp_expectativa_motivacion_motivacion_trabajo" value="'.$resaspirante[0]['hvp_expectativa_motivacion_motivacion_trabajo'].'" required autocomplete="off" disabled>
                                            </div>';
                        } elseif ($seccion=='ubicacion') {
                            $control_localidad='d-none';
                            $control_barrio='d-block';
                            $control_barrio_lista='d-none';
                            if ($resaspirante[0]['hvp_ubicacion_ciudad_residencia']=='11001' OR $resaspirante[0]['hvp_ubicacion_ciudad_residencia']=='05001') {
                                $control_localidad='d-block';
                                $control_barrio='d-none';
                                $control_barrio_lista='d-block';
                            }
                            $resultado_lista='<div class="col-md-12 mb-2">
                                                <label for="">Progreso</label><span class="float-end">Completado: <span id="avance_total"></span> de <span id="secciones_total"></span></span>
                                                <div class="progress" style="height: 25px;" id="avance_barra">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-map-location-dot"></span> Información de Ubicación</p>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="hvp_ubicacion_ciudad_residencia" class="form-label my-0 font-size-12">Ciudad de residencia</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_demografia_edad" id="hvp_demografia_edad" value="'.$resaspirante[0]['TCIUDAD_ciu_municipio'].', '.$resaspirante[0]['TCIUDAD_ciu_departamento'].'" readonly required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="hvp_ubicacion_direccion_residencia" class="form-label my-0 font-size-12">Dirección de residencia</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_ubicacion_direccion_residencia" id="hvp_ubicacion_direccion_residencia" value="'.$resaspirante[0]['hvp_ubicacion_direccion_residencia'].'" required readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="hvp_ubicacion_maps_latitud" class="form-label my-0 font-size-12">Latitud</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_ubicacion_maps_latitud" id="hvp_ubicacion_maps_latitud" value="'.$resaspirante[0]['hvp_ubicacion_maps_latitud'].'" required readonly>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="hvp_ubicacion_maps_longitud" class="form-label my-0 font-size-12">Longitud</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_ubicacion_maps_longitud" id="hvp_ubicacion_maps_longitud" value="'.$resaspirante[0]['hvp_ubicacion_maps_longitud'].'" required readonly>
                                            </div>
                                            <div class="col-md-3 mb-3 '.$control_localidad.'" id="hvp_ubicacion_localidad_comuna_div">
                                                <label for="hvp_ubicacion_localidad_comuna" class="form-label my-0 font-size-12">Localidad</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_ubicacion_maps_longitud" id="hvp_ubicacion_maps_longitud" value="'.$resaspirante[0]['hvp_ubicacion_localidad_comuna'].'" required readonly>
                                            </div>
                                            <div class="col-md-3 mb-3 '.$control_barrio.'" id="hvp_ubicacion_barrio_div">
                                                <label for="hvp_ubicacion_barrio" class="form-label my-0 font-size-12">Barrio</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_ubicacion_barrio" id="hvp_ubicacion_barrio" value="'.$resaspirante[0]['hvp_ubicacion_barrio'].'" required>
                                            </div>
                                            <div class="col-md-3 mb-3 '.$control_barrio_lista.'" id="hvp_ubicacion_barrio_lista_div">
                                                <label for="hvp_ubicacion_barrio_lista" class="form-label my-0 font-size-12">Barrio</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_ubicacion_barrio" id="hvp_ubicacion_barrio" value="'.$resaspirante[0]['hvp_ubicacion_barrio'].'" required readonly>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-address-book"></span> Información de Contacto</p>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_contacto_numero_celular" class="form-label my-0 font-size-12">Número de celular</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_numero_celular" id="hvp_contacto_numero_celular" value="'.$resaspirante[0]['hvp_contacto_numero_celular'].'" maxlength="10" minlength="10" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_contacto_numero_celular_alternativo" class="form-label my-0 font-size-12">Número de celular alternativo</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_numero_celular_alternativo" id="hvp_contacto_numero_celular_alternativo" value="'.$resaspirante[0]['hvp_auxiliar_2'].'" maxlength="10" minlength="10" autocomplete="off" readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_contacto_correo_personal" class="form-label my-0 font-size-12">Correo electrónico personal</label>
                                                <input type="email" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_correo_personal" id="hvp_contacto_correo_personal" value="'.$resaspirante[0]['hvp_contacto_correo_personal'].'" required autocomplete="off" readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_contacto_correo_corporativo" class="form-label my-0 font-size-12">Correo electrónico corporativo</label>
                                                <input type="email" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_correo_corporativo" id="hvp_contacto_correo_corporativo" value="'.$resaspirante[0]['hvp_contacto_correo_corporativo'].'" readonly>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-truck-medical"></span> En caso de emergencia avisar a:</p>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_contacto_emergencia_nombres" class="form-label my-0 font-size-12">Nombres</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_emergencia_nombres" id="hvp_contacto_emergencia_nombres" value="'.$resaspirante[0]['hvp_contacto_emergencia_nombres'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_contacto_emergencia_apellidos" class="form-label my-0 font-size-12">Apellidos</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_emergencia_apellidos" id="hvp_contacto_emergencia_apellidos" value="'.$resaspirante[0]['hvp_contacto_emergencia_apellidos'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_contacto_emergencia_parentesco" class="form-label my-0 font-size-12">Parentesco</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_emergencia_apellidos" id="hvp_contacto_emergencia_apellidos" value="'.$resaspirante[0]['hvp_contacto_emergencia_parentesco'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_contacto_emergencia_celular" class="form-label my-0 font-size-12">Número de celular de tu familiar/amigo(a)</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_emergencia_celular" id="hvp_contacto_emergencia_celular" value="'.$resaspirante[0]['hvp_contacto_emergencia_celular'].'" maxlength="10" minlength="10" required readonly autocomplete="off">
                                            </div>
                                            <!-- CONTACTO EMERGENCIA 2 -->
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_contacto_emergencia_nombres_2" class="form-label my-0 font-size-12">Nombres</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_emergencia_nombres_2" id="hvp_contacto_emergencia_nombres_2" value="'.$resaspirante[0]['hvp_contacto_emergencia_nombres_2'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_contacto_emergencia_apellidos_2" class="form-label my-0 font-size-12">Apellidos</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_emergencia_apellidos_2" id="hvp_contacto_emergencia_apellidos_2" value="'.$resaspirante[0]['hvp_contacto_emergencia_apellidos_2'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_contacto_emergencia_parentesco_2" class="form-label my-0 font-size-12">Parentesco</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_emergencia_parentesco_2" id="hvp_contacto_emergencia_parentesco_2" value="'.$resaspirante[0]['hvp_contacto_emergencia_parentesco_2'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_contacto_emergencia_celular_2" class="form-label my-0 font-size-12">Número de celular de tu familiar/amigo(a)</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_emergencia_celular_2" id="hvp_contacto_emergencia_celular_2" value="'.$resaspirante[0]['hvp_contacto_emergencia_celular_2'].'" maxlength="10" minlength="10" required readonly autocomplete="off">
                                            </div>';
                        } elseif ($seccion=='socioeconomico') {
                            $registro_parametro = new parametroModel();
                            $registro_parametro->app_id = 'autorizacion_sagrilaft';
                            $resregistro_parametro=$registro_parametro->listDetail();

                            if (!isset($resregistro_parametro[0])) {
                                $resregistro_parametro=array();
                            }

                            $hvp_socioeconomico_servicios_vivienda_array= explode(';', $resaspirante[0]['hvp_socioeconomico_servicios_vivienda']);

                            $hvp_socioeconomico_servicios_vivienda_luz='';
                            $hvp_socioeconomico_servicios_vivienda_agua='';
                            $hvp_socioeconomico_servicios_vivienda_gas='';
                            $hvp_socioeconomico_servicios_vivienda_internet='';
                            $hvp_socioeconomico_servicios_vivienda_plataformas='';
                            if (in_array('Luz', $hvp_socioeconomico_servicios_vivienda_array)) {
                                $hvp_socioeconomico_servicios_vivienda_luz='checked';
                            }

                            if (in_array('Agua', $hvp_socioeconomico_servicios_vivienda_array)) {
                                $hvp_socioeconomico_servicios_vivienda_agua='checked';
                            }

                            if (in_array('Gas', $hvp_socioeconomico_servicios_vivienda_array)) {
                                $hvp_socioeconomico_servicios_vivienda_gas='checked';
                            }

                            if (in_array('Internet', $hvp_socioeconomico_servicios_vivienda_array)) {
                                $hvp_socioeconomico_servicios_vivienda_internet='checked';
                            }

                            if (in_array('Plataformas de entretenimiento', $hvp_socioeconomico_servicios_vivienda_array)) {
                                $hvp_socioeconomico_servicios_vivienda_plataformas='checked';
                            }

                            $edad_hijos_final_array=explode(';', $resaspirante[0]['hvp_familia_hijos_menor_3']);
                            
                            $resultado_lista='<div class="col-md-12 mb-2">
                                                <label for="">Progreso</label><span class="float-end">Completado: <span id="avance_total"></span> de <span id="secciones_total"></span></span>
                                                <div class="progress" style="height: 25px;" id="avance_barra">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-house-user"></span> Información Socioeconómica</p>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_socioeconomico_estrato_socioeconomico" class="form-label my-0 font-size-12">Estrato socioeconómico</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_socioeconomico_estrato_socioeconomico" id="hvp_socioeconomico_estrato_socioeconomico" value="'.$resaspirante[0]['hvp_socioeconomico_estrato_socioeconomico'].'" required readonly autocomplete="off">
                                            </div> 
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_socioeconomico_operador_internet" class="form-label my-0 font-size-12">Operador de internet</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_socioeconomico_operador_internet" id="hvp_socioeconomico_operador_internet" value="'.$resaspirante[0]['hvp_socioeconomico_operador_internet'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-6 mb-3 d-none" id="div_hvp_socioeconomico_operador_internet_otro">
                                                <label for="hvp_socioeconomico_operador_internet_otro" class="form-label my-0 font-size-12">Nombre operador</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_socioeconomico_operador_internet_otro" id="hvp_socioeconomico_operador_internet_otro" value="'.$resaspirante[0]['hvp_socioeconomico_operador_internet_otro'].'" required readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_socioeconomico_velocidad_internet_descarga" class="form-label my-0 font-size-12">Velocidad de descarga de internet (MB)</label>
                                                <input type="number" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_socioeconomico_velocidad_internet_descarga" id="hvp_socioeconomico_velocidad_internet_descarga" value="'.$resaspirante[0]['hvp_socioeconomico_velocidad_internet_descarga'].'" min="2" max="900" required readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_socioeconomico_velocidad_internet_carga" class="form-label my-0 font-size-12">Velocidad de carga de internet (MB)</label>
                                                <input type="number" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_socioeconomico_velocidad_internet_carga" id="hvp_socioeconomico_velocidad_internet_carga" value="'.$resaspirante[0]['hvp_socioeconomico_velocidad_internet_carga'].'" min="2" max="900" required readonly>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <p class="alert alert-warning p-1 m-0 font-size-11">Para confirmar la velocidad de su internet, por favor ingrese al siguiente link y siga las instrucciones para obtener esta información: <a href="https://www.speedtest.net/es" target="_blank"><span class="fas fa-arrow-up-right-from-square"></span> https://www.speedtest.net/es</a></p>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_socioeconomico_caracteristicas_vivienda" class="form-label my-0 font-size-12">Características de tu vivienda</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_socioeconomico_caracteristicas_vivienda" id="hvp_socioeconomico_caracteristicas_vivienda" value="'.$resaspirante[0]['hvp_socioeconomico_caracteristicas_vivienda'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_socioeconomico_condiciones_vivienda" class="form-label my-0 font-size-12">Condición de la vivienda</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_socioeconomico_condiciones_vivienda" id="hvp_socioeconomico_condiciones_vivienda" value="'.$resaspirante[0]['hvp_socioeconomico_condiciones_vivienda'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="hvp_socioeconomico_estado_terminacion_vivienda" class="form-label my-0 font-size-12">¿Cuál es el estado de terminación de tu vivienda?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_socioeconomico_estado_terminacion_vivienda" id="hvp_socioeconomico_estado_terminacion_vivienda" value="'.$resaspirante[0]['hvp_socioeconomico_estado_terminacion_vivienda'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_socioeconomico_servicios_vivienda" class="form-label my-0 font-size-12">¿Qué servicios tienes en tu vivienda?</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="hvp_socioeconomico_servicios_vivienda[]" value="Luz" id="xxx" '.$hvp_socioeconomico_servicios_vivienda_luz.' disabled>
                                                    <label class="form-check-label" for="flexCheckDefault">Luz</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="hvp_socioeconomico_servicios_vivienda[]" value="Agua" id="xxx" '.$hvp_socioeconomico_servicios_vivienda_agua.' disabled>
                                                    <label class="form-check-label" for="flexCheckChecked">Agua</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="hvp_socioeconomico_servicios_vivienda[]" value="Gas" id="xxx" '.$hvp_socioeconomico_servicios_vivienda_gas.' disabled>
                                                    <label class="form-check-label" for="flexCheckChecked">Gas</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="hvp_socioeconomico_servicios_vivienda[]" value="Internet" id="xxx" '.$hvp_socioeconomico_servicios_vivienda_internet.' disabled>
                                                    <label class="form-check-label" for="flexCheckChecked">Internet</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="hvp_socioeconomico_servicios_vivienda[]" value="Plataformas de entretenimiento" id="xxx" '.$hvp_socioeconomico_servicios_vivienda_plataformas.' disabled>
                                                    <label class="form-check-label" for="flexCheckChecked">Plataformas de entretenimiento</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="hvp_socioeconomico_plan_compra_vivienda" class="form-label my-0 font-size-12">¿Tienes pensado comprar vivienda en los próximos 3 años?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_socioeconomico_plan_compra_vivienda" id="hvp_socioeconomico_plan_compra_vivienda" value="'.$resaspirante[0]['hvp_socioeconomico_plan_compra_vivienda'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="hvp_socioeconomico_beneficiario_subsidio_vivienda" class="form-label my-0 font-size-12">¿Has sido beneficiario de subsidio de vivienda?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_socioeconomico_beneficiario_subsidio_vivienda" id="hvp_socioeconomico_beneficiario_subsidio_vivienda" value="'.$resaspirante[0]['hvp_socioeconomico_beneficiario_subsidio_vivienda'].'" required readonly autocomplete="off">
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-people-roof"></span> Información Familiar</p>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_familia_numero_hijos" class="form-label my-0 font-size-12">¿Cuántos hijos tienes?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_familia_numero_hijos" id="hvp_familia_numero_hijos" value="'.$resaspirante[0]['hvp_familia_numero_hijos'].'" required readonly autocomplete="off">
                                            </div>';
                                            if($resaspirante[0]['hvp_familia_numero_hijos']>0) {
                                                    $resultado_lista.='<label for="tabla_edad_hijos" class="form-label my-0 font-size-12">Por favor indique el rango de edad de sus hijos:</label>
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
                                                        <tbody>';
                                                            for ($i=1; $i <= $resaspirante[0]['hvp_familia_numero_hijos']; $i++) {
                                                                $estado_edad_1='';
                                                                $estado_edad_2='';
                                                                $estado_edad_3='';
                                                                $estado_edad_4='';
                                                                $estado_edad_5='';
                                                                
                                                                if ($edad_hijos_final_array[$i-1]=='0-2') {
                                                                    $estado_edad_1='checked';
                                                                }

                                                                if ($edad_hijos_final_array[$i-1]=='2-5') {
                                                                    $estado_edad_2='checked';
                                                                }

                                                                if ($edad_hijos_final_array[$i-1]=='5-10') {
                                                                    $estado_edad_3='checked';
                                                                }

                                                                if ($edad_hijos_final_array[$i-1]=='10-15') {
                                                                    $estado_edad_4='checked';
                                                                }

                                                                if ($edad_hijos_final_array[$i-1]=='15+') {
                                                                    $estado_edad_5='checked';
                                                                }

                                                                $resultado_lista.='<tr>
                                                                    <td class="p-1 align-middle text-center">Hijo '.$i.'</td>
                                                                    <td class="p-1 font-size-11 align-middle text-center">
                                                                        <input class="form-check-input font-size-12" type="radio" name="edad_hijos_'.$i.'" id="edad_hijos_'.$i.'" value="0-2" '.$estado_edad_1.' disabled>
                                                                    </td>
                                                                    <td class="p-1 font-size-11 align-middle text-center">
                                                                        <input class="form-check-input font-size-12" type="radio" name="edad_hijos_'.$i.'" id="edad_hijos_'.$i.'" value="2-5" '.$estado_edad_2.' disabled>
                                                                    </td>
                                                                    <td class="p-1 font-size-11 align-middle text-center">
                                                                        <input class="form-check-input font-size-12" type="radio" name="edad_hijos_'.$i.'" id="edad_hijos_'.$i.'" value="5-10" '.$estado_edad_3.' disabled>
                                                                    </td>
                                                                    <td class="p-1 font-size-11 align-middle text-center">
                                                                        <input class="form-check-input font-size-12" type="radio" name="edad_hijos_'.$i.'" id="edad_hijos_'.$i.'" value="10-15" '.$estado_edad_4.' disabled>
                                                                    </td>
                                                                    <td class="p-1 font-size-11 align-middle text-center">
                                                                        <input class="form-check-input font-size-12" type="radio" name="edad_hijos_'.$i.'" id="edad_hijos_'.$i.'" value="15+" '.$estado_edad_5.' disabled>
                                                                    </td>
                                                                </tr>';
                                                            }
                                                $resultado_lista.='</tbody>
                                                        </table>
                                                    </div>';
                                                }

                                $resultado_lista.='<div class="col-md-12 mb-3">
                                                <label for="hvp_familia_capacitacion_familia" class="form-label my-0 font-size-12">¿En cual de los siguientes temas relacionados con la familia te gustaría recibir capacitación o acompañamiento?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_familia_capacitacion_familia" id="hvp_familia_capacitacion_familia" value="'.$resaspirante[0]['hvp_familia_capacitacion_familia'].'" required readonly autocomplete="off">
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-"></span> Información Financiera</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="hvp_financiero_activos" class="form-label my-0 font-size-12">Activos <span class="fas fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="Relacione el valor de todos aquellos bienes y propiedades que se encuentren a su nombre (casas, apartamentos, locales, terrenos, fincas, vehículos, inversiones)."></span></label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_financiero_activos" id="hvp_financiero_activos" value="'.$resaspirante[0]['hvp_financiero_activos'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="hvp_financiero_ingresos" class="form-label my-0 font-size-12">Ingresos mensuales  <span class="fas fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="Hace referencia a los ingresos percibidos de forma constante o en promedio en el mes."></label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_financiero_ingresos" id="hvp_financiero_ingresos" value="'.$resaspirante[0]['hvp_financiero_ingresos'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="hvp_financiero_pasivos" class="form-label my-0 font-size-12">Pasivos <span class="fas fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="Relacione el monto de las deudas a cargo, vigentes en esa fecha (Créditos bancarios, obligaciones con particulares siempre que estén soportados con un documento, contrato o título valor; deudas con entidades del estado)."></label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_financiero_pasivos" id="hvp_financiero_pasivos" value="'.$resaspirante[0]['hvp_financiero_pasivos'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="hvp_financiero_egresos" class="form-label my-0 font-size-12">Egresos mensuales <span class="fas fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="Hace referencia a las deudas o salidas de dinero en el mes (de forma constante o en promedio)."></label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_financiero_egresos" id="hvp_financiero_egresos" value="'.$resaspirante[0]['hvp_financiero_egresos'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="hvp_financiero_patrimonio" class="form-label my-0 font-size-12">Patrimonio <span class="fas fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="Relacione  aquí el valor general del conjunto de bienes, derechos y obligaciones con los que cuenta actualmente (Activos - Pasivos)."></label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_financiero_patrimonio" id="hvp_financiero_patrimonio" value="'.$resaspirante[0]['hvp_financiero_patrimonio'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="hvp_financiero_ingresos_otros" class="form-label my-0 font-size-12">Otros ingresos <span class="fas fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="Ingresos adicionales que pueden darse de forma variable o esporádica."></label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_financiero_ingresos_otros" id="hvp_financiero_ingresos_otros" value="'.$resaspirante[0]['hvp_financiero_ingresos_otros'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="hvp_financiero_concepto_ingresos" class="form-label my-0 font-size-12">Concepto de otros ingresos</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_financiero_concepto_ingresos" id="hvp_financiero_concepto_ingresos" value="'.$resaspirante[0]['hvp_financiero_concepto_ingresos'].'" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="hvp_financiero_moneda_extranjera" class="form-label my-0 font-size-12">¿Realiza Operaciones en Moneda Extranjera?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_financiero_moneda_extranjera" id="hvp_financiero_moneda_extranjera" value="'.$resaspirante[0]['hvp_financiero_moneda_extranjera'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="appoinment-title mt-2">
                                                <h4>Declaración de Origen de Fondos y Prevención de Lavado de Activos y Financiación del Terrorismo - SAGRILAFT</h4>
                                            </div>
                                            <p class="appoinment-content-text mt-0 mb-2">
                                                '.$resregistro_parametro[0]['app_descripcion'].'
                                                
                                            </p>
                                            <div class="col-md-12 my-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="Si" name="hvp_origen_fondos" id="hvp_origen_fondos" '.(($resaspirante[0]['hvp_origen_fondos']=='Si') ? 'checked' : '').' required disabled>
                                                    <label class="form-check-label font-size-12 fw-bold" for="hvp_origen_fondos">Si, acepto</label>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-"></span> Personas Expuestas Públicamente - PEP</p>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="hvp_pep_recursos" class="form-label my-0 font-size-12">¿Maneja recursos públicos?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_pep_recursos" id="hvp_pep_recursos" value="'.$resaspirante[0]['hvp_pep_recursos'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="hvp_pep_reconocimiento" class="form-label my-0 font-size-12">¿Goza de reconocimiento público general?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_pep_reconocimiento" id="hvp_pep_reconocimiento" value="'.$resaspirante[0]['hvp_pep_reconocimiento'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="hvp_pep_poder" class="form-label my-0 font-size-12">¿Ejerce algún grado de poder público?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_pep_poder" id="hvp_pep_poder" value="'.$resaspirante[0]['hvp_pep_poder'].'" required readonly autocomplete="off">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="hvp_pep_familiar" class="form-label my-0 font-size-12">¿Tiene usted algún familiar que cumpla con una característica anterior?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_pep_familiar" id="hvp_pep_familiar" value="'.$resaspirante[0]['hvp_pep_familiar'].'" required readonly autocomplete="off">
                                            </div>';
                                            if ($resaspirante[0]['hvp_pep_recursos']=='Si' OR $resaspirante[0]['hvp_pep_reconocimiento']=='Si' OR $resaspirante[0]['hvp_pep_poder']=='Si' OR $resaspirante[0]['hvp_pep_familiar']=='Si') {
                                                $resultado_lista.='<div class="col-md-12 mb-3" id="mensaje_alerta_div">
                                                                    <p class="alert alert-warning p-1">Si alguna de las respuestas anteriores es afirmativa, por favor especifique cédula y nombre completo de la persona:</p>
                                                                </div>
                                                                <div class="col-md-4 mb-3" id="hvp_pep_cedula_div">
                                                                    <label for="hvp_pep_cedula" class="form-label my-0 font-size-12">Cédula</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_pep_cedula" id="hvp_pep_cedula" value="'.$resaspirante[0]['hvp_pep_cedula'].'" required readonly>
                                                                </div>
                                                                <div class="col-md-8 mb-3" id="hvp_pep_nombres_apellidos_div">
                                                                    <label for="hvp_pep_nombres_apellidos" class="form-label my-0 font-size-12">Nombres y apellidos</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_pep_nombres_apellidos" id="hvp_pep_nombres_apellidos" value="'.$resaspirante[0]['hvp_pep_nombres_apellidos'].'" required readonly>
                                                                </div>';
                                            }
                        } elseif ($seccion=='salud-bienestar') {
                            $resultado_lista='<div class="col-md-12 mb-2">
                                                <label for="">Progreso</label><span class="float-end">Completado: <span id="avance_total"></span> de <span id="secciones_total"></span></span>
                                                <div class="progress" style="height: 25px;" id="avance_barra">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-person-swimming"></span> Información de Salud y Bienestar</p>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="hvp_salud_bienestar_grupo_sanguineo" class="form-label my-0 font-size-12">¿Cuál es tu grupo sanguíneo?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_salud_bienestar_grupo_sanguineo" id="hvp_salud_bienestar_grupo_sanguineo" value="'.$resaspirante[0]['hvp_salud_bienestar_grupo_sanguineo'].'" required readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_salud_bienestar_rh" class="form-label my-0 font-size-12">¿Cuál es tu RH?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_salud_bienestar_rh" id="hvp_salud_bienestar_rh" value="'.$resaspirante[0]['hvp_salud_bienestar_rh'].'" required readonly>
                                            </div>
                                            <div class="col-md-5 mb-3">
                                                <label for="hvp_salud_bienestar_actividad_fisica_minima" class="form-label my-0 font-size-12">¿Realizas actividad física de mínimo 20 minutos al día?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_salud_bienestar_actividad_fisica_minima" id="hvp_salud_bienestar_actividad_fisica_minima" value="'.$resaspirante[0]['hvp_salud_bienestar_actividad_fisica_minima'].'" required readonly>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="hvp_salud_bienestar_fumador" class="form-label my-0 font-size-12">¿Fumas?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_salud_bienestar_fumador" id="hvp_salud_bienestar_fumador" value="'.$resaspirante[0]['hvp_salud_bienestar_fumador'].'" required readonly>
                                            </div>
                                            <div class="col-md-5 mb-3">
                                                <label for="hvp_salud_bienestar_pausas_activas" class="form-label my-0 font-size-12">¿Realizas pausas activas durante la jornada laboral?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_salud_bienestar_pausas_activas" id="hvp_salud_bienestar_pausas_activas" value="'.$resaspirante[0]['hvp_salud_bienestar_pausas_activas'].'" required readonly>
                                            </div>
                                            <div class="col-md-5 mb-3">
                                                <label for="hvp_salud_bienestar_medicina_prepagada" class="form-label my-0 font-size-12">¿Tienes medicina prepagada?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_salud_bienestar_medicina_prepagada" id="hvp_salud_bienestar_medicina_prepagada" value="'.$resaspirante[0]['hvp_salud_bienestar_medicina_prepagada'].'" required readonly>
                                            </div>';
                            
                                            if ($resaspirante[0]['hvp_salud_bienestar_medicina_prepagada']=='Si') {
                                                $resultado_lista.='<div class="col-md-6 mb-3" id="div_hvp_salud_bienestar_medicina_prepagada_cual">
                                                    <label for="hvp_salud_bienestar_medicina_prepagada_cual" class="form-label my-0 font-size-12">¿Cual?</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_salud_bienestar_medicina_prepagada_cual" id="hvp_salud_bienestar_medicina_prepagada_cual" value="'.$resaspirante[0]['hvp_salud_bienestar_medicina_prepagada_cual'].'" required readonly>
                                                </div>';
                                            }

                                            if ($resaspirante[0]['hvp_salud_bienestar_medicina_prepagada']=='No') {
                                                $resultado_lista.='<div class="col-md-6 mb-3" id="div_hvp_salud_bienestar_plan_complementario_salud">
                                                    <label for="hvp_salud_bienestar_plan_complementario_salud" class="form-label my-0 font-size-12">¿Tienes plan complementario de salud?</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_salud_bienestar_plan_complementario_salud" id="hvp_salud_bienestar_plan_complementario_salud" value="'.$resaspirante[0]['hvp_salud_bienestar_plan_complementario_salud'].'" required readonly>
                                                </div>';
                                            }

                                            if ($resaspirante[0]['div_hvp_salud_bienestar_plan_complementario_salud']=='Si') {
                                                $resultado_lista.='<div class="col-md-6 mb-3" id="div_hvp_salud_bienestar_plan_complementario_salud_cual">
                                                    <label for="hvp_salud_bienestar_plan_complementario_salud_cual" class="form-label my-0 font-size-12">¿Cual?</label>
                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_salud_bienestar_plan_complementario_salud_cual" id="hvp_salud_bienestar_plan_complementario_salud_cual" value="'.$resaspirante[0]['hvp_salud_bienestar_plan_complementario_salud_cual'].'" required readonly>
                                                </div>';
                                            }

                                            $resultado_lista.='<div class="col-md-12 mb-3">
                                                <p class="alert alert-warning p-1 m-0 font-size-12">
                                                    <b>Plan complementario en salud:</b> Amplía la cobertura del POS (Plan Obligatorio de Salud) con servicios adicionales como medicamentos costosos o consultas con especialistas. Sigue ligado al sistema público de salud.
                                                    <br><br>
                                                    <b>Medicina prepagada:</b> Sistema privado de salud con cobertura médica completa a través de una red privada de clínicas y hospitales. Independiente del sistema público de salud.
                                                </p>
                                            </div>';
                        } elseif ($seccion=='intereses-habitos') {
                            $resultado_lista='<div class="col-md-12 mb-2">
                                                <label for="">Progreso</label><span class="float-end">Completado: <span id="avance_total"></span> de <span id="secciones_total"></span></span>
                                                <div class="progress" style="height: 25px;" id="avance_barra">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-person-walking"></span> ¿Cuáles son tus hobbies?</p>
                                            </div>
                                            <div class="col-md-8 mb-3">
                                                <label for="hvp_interes_habitos_hobbies_deportes" class="form-label my-0 font-size-12">Deportes</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_deportes" id="hvp_interes_habitos_hobbies_deportes" value="'.$resaspirante[0]['hvp_interes_habitos_hobbies_deportes'].'" required readonly>
                                            </div>';

                                            if ($resaspirante[0]['hvp_interes_habitos_hobbies_deportes']!='') {
                                                $resultado_lista.='<div class="col-md-4 mb-3" id="div_hvp_interes_habitos_hobbies_deportes_frecuencia">
                                                                    <label for="hvp_interes_habitos_hobbies_deportes_frecuencia" class="form-label my-0 font-size-12">¿Con qué frecuencia practicas este hobbie?</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_deportes_frecuencia" id="hvp_interes_habitos_hobbies_deportes_frecuencia" value="'.$resaspirante[0]['hvp_interes_habitos_hobbies_deportes_frecuencia'].'" required readonly>
                                                                </div>';
                                            }

                                            if (stripos($resaspirante[0]['hvp_interes_habitos_hobbies_deportes'], 'Otro') !== false) {
                                                $resultado_lista.='<div class="col-md-12 mb-3" id="div_hvp_interes_habitos_hobbies_deportes_cual">
                                                                    <label for="hvp_interes_habitos_hobbies_deportes_cual" class="form-label my-0 font-size-12">¿Cuál?</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_deportes_cual" id="hvp_interes_habitos_hobbies_deportes_cual" value="'.$resaspirante[0]['hvp_interes_habitos_hobbies_deportes_cual'].'" required readonly>
                                                                </div>';
                                            }

                                            $resultado_lista.='<div class="col-md-8 mb-3">
                                                                <label for="hvp_interes_habitos_hobbies_aire" class="form-label my-0 font-size-12">Actividades al aire libre</label>
                                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_aire" id="hvp_interes_habitos_hobbies_aire" value="'.$resaspirante[0]['hvp_interes_habitos_hobbies_aire'].'" required readonly>
                                                            </div>';

                                            if ($resaspirante[0]['hvp_interes_habitos_hobbies_aire']!='') {
                                                $resultado_lista.='<div class="col-md-4 mb-3" id="div_hvp_interes_habitos_hobbies_aire_frecuencia">
                                                                    <label for="hvp_interes_habitos_hobbies_aire_frecuencia" class="form-label my-0 font-size-12">¿Con qué frecuencia practicas este hobbie?</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_aire_frecuencia" id="hvp_interes_habitos_hobbies_aire_frecuencia" value="'.$resaspirante[0]['hvp_interes_habitos_hobbies_aire_frecuencia'].'" required readonly>
                                                                </div>';
                                            }

                                            if (stripos($resaspirante[0]['hvp_interes_habitos_hobbies_aire'], 'Otro') !== false) {
                                                $resultado_lista.='<div class="col-md-12 mb-3" id="div_hvp_interes_habitos_hobbies_aire_cual">
                                                                    <label for="hvp_interes_habitos_hobbies_aire_cual" class="form-label my-0 font-size-12">¿Cuál?</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_aire_cual" id="hvp_interes_habitos_hobbies_aire_cual" value="'.$resaspirante[0]['hvp_interes_habitos_hobbies_aire_cual'].'" required readonly>
                                                                </div>';
                                            }

                                            $resultado_lista.='<div class="col-md-8 mb-3">
                                                            <label for="hvp_interes_habitos_hobbies_arte" class="form-label my-0 font-size-12">Arte y creatividad</label>
                                                            <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_arte" id="hvp_interes_habitos_hobbies_arte" value="'.$resaspirante[0]['hvp_interes_habitos_hobbies_arte'].'" required readonly>
                                                        </div>';

                                            if ($resaspirante[0]['hvp_interes_habitos_hobbies_arte']!='') {
                                                $resultado_lista.='<div class="col-md-4 mb-3" id="div_hvp_interes_habitos_hobbies_arte_frecuencia">
                                                                    <label for="hvp_interes_habitos_hobbies_arte_frecuencia" class="form-label my-0 font-size-12">¿Con qué frecuencia practicas este hobbie?</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_arte_frecuencia" id="hvp_interes_habitos_hobbies_arte_frecuencia" value="'.$resaspirante[0]['hvp_interes_habitos_hobbies_arte_frecuencia'].'" required readonly>
                                                                </div>';
                                            }

                                            if (stripos($resaspirante[0]['hvp_interes_habitos_hobbies_arte'], 'Otro') !== false) {
                                                $resultado_lista.='<div class="col-md-12 mb-3" id="div_hvp_interes_habitos_hobbies_arte_cual">
                                                                    <label for="hvp_interes_habitos_hobbies_arte_cual" class="form-label my-0 font-size-12">¿Cuál?</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_arte_cual" id="hvp_interes_habitos_hobbies_arte_cual" value="'.$resaspirante[0]['hvp_interes_habitos_hobbies_arte_cual'].'" required readonly>
                                                                </div>';
                                            }

                                            if (stripos($resaspirante[0]['hvp_interes_habitos_hobbies_arte'], 'Música') !== false) {
                                                $resultado_lista.='<div class="col-md-12 mb-3" id="div_hvp_interes_habitos_hobbies_arte_instrumento">
                                                                    <label for="hvp_interes_habitos_hobbies_arte_instrumento" class="form-label my-0 font-size-12">¿Cuál instrumento tocas?</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_arte_instrumento" id="hvp_interes_habitos_hobbies_arte_instrumento" value="'.$resaspirante[0]['hvp_interes_habitos_hobbies_arte_instrumento'].'" required readonly>
                                                                </div>';
                                            }

                                            $resultado_lista.='<div class="col-md-8 mb-3">
                                                                <label for="hvp_interes_habitos_hobbies_tecnologia" class="form-label my-0 font-size-12">Tecnología</label>
                                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_tecnologia" id="hvp_interes_habitos_hobbies_tecnologia" value="'.$resaspirante[0]['hvp_interes_habitos_hobbies_tecnologia'].'" required readonly>
                                                            </div>';

                                            if ($resaspirante[0]['hvp_interes_habitos_hobbies_tecnologia']!='') {
                                                $resultado_lista.='<div class="col-md-4 mb-3" id="div_hvp_interes_habitos_hobbies_tecnologia_frecuencia">
                                                            <label for="hvp_interes_habitos_hobbies_tecnologia_frecuencia" class="form-label my-0 font-size-12">¿Con qué frecuencia practicas este hobbie?</label>
                                                            <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_tecnologia_frecuencia" id="hvp_interes_habitos_hobbies_tecnologia_frecuencia" value="'.$resaspirante[0]['hvp_interes_habitos_hobbies_tecnologia_frecuencia'].'" required readonly>
                                                        </div>';
                                            }

                                            if (stripos($resaspirante[0]['hvp_interes_habitos_hobbies_tecnologia'], 'Otro') !== false) {
                                                $resultado_lista.='<div class="col-md-12 mb-3" id="div_hvp_interes_habitos_hobbies_tecnologia_cual">
                                                                    <label for="hvp_interes_habitos_hobbies_tecnologia_cual" class="form-label my-0 font-size-12">¿Cuál?</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_tecnologia_cual" id="hvp_interes_habitos_hobbies_tecnologia_cual" value="'.$resaspirante[0]['hvp_interes_habitos_hobbies_tecnologia_cual'].'" required readonly>
                                                                </div>';
                                            }

                                            $resultado_lista.='<div class="col-md-8 mb-3">
                                                                <label for="hvp_interes_habitos_hobbies_otro" class="form-label my-0 font-size-12">Otros</label>
                                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_otro" id="hvp_interes_habitos_hobbies_otro" value="'.$resaspirante[0]['hvp_interes_habitos_hobbies_otro'].'" required readonly>
                                                            </div>';

                                            if ($resaspirante[0]['hvp_interes_habitos_hobbies_otro']!='') {
                                                $resultado_lista.='<div class="col-md-4 mb-3" id="div_hvp_interes_habitos_hobbies_otro_frecuencia">
                                                                    <label for="hvp_interes_habitos_hobbies_otro_frecuencia" class="form-label my-0 font-size-12">¿Con qué frecuencia practicas este hobbie?</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_otro_frecuencia" id="hvp_interes_habitos_hobbies_otro_frecuencia" value="'.$resaspirante[0]['hvp_interes_habitos_hobbies_otro_frecuencia'].'" required readonly>
                                                                </div>';
                                            }

                                            if (stripos($resaspirante[0]['hvp_interes_habitos_hobbies_otro'], 'Otro') !== false) {
                                                $resultado_lista.='<div class="col-md-12 mb-3" id="div_hvp_interes_habitos_hobbies_otro_cual">
                                                                    <label for="hvp_interes_habitos_hobbies_otro_cual" class="form-label my-0 font-size-12">¿Cuál?</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_otro_cual" id="hvp_interes_habitos_hobbies_otro_cual" value="'.$resaspirante[0]['hvp_interes_habitos_hobbies_otro_cual'].'" required readonly>
                                                                </div>';
                                            }

                                            $resultado_lista.='<div class="col-md-12 mb-3">
                                                <label for="hvp_interes_habitos_hobbies_recibir_informacion" class="form-label my-0 font-size-12">¿Te gustaría recibir información sobre eventos o actividades relacionadas con tus hobbies?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_recibir_informacion" id="hvp_interes_habitos_hobbies_recibir_informacion" value="'.$resaspirante[0]['hvp_interes_habitos_hobbies_recibir_informacion'].'" required readonly>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-person-walking-luggage"></span> Información de Intereses y Hábitos</p>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="hvp_interes_habitos_actividades_familia" class="form-label my-0 font-size-12">¿Cuáles actividades te gusta hacer en familia?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_actividades_familia" id="hvp_interes_habitos_actividades_familia" value="'.$resaspirante[0]['hvp_interes_habitos_actividades_familia'].'" required readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_interes_habitos_actividades_deportivas" class="form-label my-0 font-size-12">¿Realizas actividades deportivas?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_actividades_deportivas" id="hvp_interes_habitos_actividades_deportivas" value="'.$resaspirante[0]['hvp_interes_habitos_actividades_deportivas'].'" required readonly>
                                            </div>';

                                            if ($resaspirante[0]['hvp_interes_habitos_actividades_deportivas']=='Si') {
                                                $resultado_lista.='<div class="col-md-4 mb-3" id="div_hvp_interes_habitos_actividades_deportivas_cual">
                                                                    <label for="hvp_interes_habitos_actividades_deportivas_cual" class="form-label my-0 font-size-12">¿Cuál actividad deportiva realizas?</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_actividades_deportivas_cual" id="hvp_interes_habitos_actividades_deportivas_cual" value="'.$resaspirante[0]['hvp_interes_habitos_actividades_deportivas_cual'].'" required readonly>
                                                                </div>';
                                            }
                                            
                                            $resultado_lista.='<div class="col-md-5 mb-3">
                                                <label for="hvp_interes_habitos_medio_transporte" class="form-label my-0 font-size-12">¿Cuál es tu medio de transporte cuando vas a la oficina?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_medio_transporte" id="hvp_interes_habitos_medio_transporte" value="'.$resaspirante[0]['hvp_interes_habitos_medio_transporte'].'" required readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_interes_habitos_habito_ahorro" class="form-label my-0 font-size-12">¿Tienes el hábito de ahorrar?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_habito_ahorro" id="hvp_interes_habitos_habito_ahorro" value="'.$resaspirante[0]['hvp_interes_habitos_habito_ahorro'].'" required readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_interes_habitos_mascotas" class="form-label my-0 font-size-12">¿Tienes Mascotas?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_mascotas" id="hvp_interes_habitos_mascotas" value="'.$resaspirante[0]['hvp_interes_habitos_mascotas'].'" required readonly>
                                            </div>';

                                            if ($resaspirante[0]['hvp_interes_habitos_mascotas']=='Si') {
                                                $resultado_lista.='<div class="col-md-6 mb-3" id="div_hvp_interes_habitos_mascotas_cual">
                                                                    <label for="hvp_interes_habitos_mascotas_cual" class="form-label my-0 font-size-12">Cuéntanos que mascota tienes?</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_mascotas_cual" id="hvp_interes_habitos_mascotas_cual" value="'.$resaspirante[0]['hvp_interes_habitos_mascotas_cual'].'" required readonly>
                                                                </div>';
                                            }
                                            
                        } elseif ($seccion=='formacion') {
                            $resultado_lista='<div class="col-md-12 mb-2">
                                                <label for="">Progreso</label><span class="float-end">Completado: <span id="avance_total"></span> de <span id="secciones_total"></span></span>
                                                <div class="progress" style="height: 25px;" id="avance_barra">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-ranking-star"></span> Último Nivel Académico Alcanzado</p>
                                            </div>
                                            <div class="col-md-8 mb-3">
                                                <label for="hvp_formacion_ultimo_certificado_enviado_rrhh" class="form-label my-0 font-size-12">Ya enviaste al área de Gestión humana el último certificado de tus estudios culminados?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_formacion_ultimo_certificado_enviado_rrhh" id="hvp_formacion_ultimo_certificado_enviado_rrhh" value="'.$resaspirante[0]['hvp_formacion_ultimo_certificado_enviado_rrhh'].'" required readonly>
                                            </div>
                                            <div class="col-md-8 mb-3">
                                                <label for="hvp_formacion_ultimo_estudio_realizado_titulo" class="form-label my-0 font-size-12">Indica el nombre del título de tu último estudio realizado</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_formacion_ultimo_estudio_realizado_titulo" id="hvp_formacion_ultimo_estudio_realizado_titulo" value="'.$resaspirante[0]['hvp_formacion_ultimo_estudio_realizado_titulo'].'" required autocomplete="off" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="hvp_formacion_tarjeta_profesional" class="form-label my-0 font-size-12">Tienes tarjeta profesional?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_formacion_tarjeta_profesional" id="hvp_formacion_tarjeta_profesional" value="'.$resaspirante[0]['hvp_formacion_tarjeta_profesional'].'" required readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="hvp_formacion_estudios_curso" class="form-label my-0 font-size-12">¿Estás estudiando actualmente?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_formacion_estudios_curso" id="hvp_formacion_estudios_curso" value="'.$resaspirante[0]['hvp_formacion_estudios_curso'].'" required readonly>
                                            </div>';

                                            if ($resaspirante[0]['hvp_formacion_estudios_curso']=='Si') {
                                                $resultado_lista.='<div class="col-md-9 mb-3" id="div_hvp_formacion_estudios_curso_titulo">
                                                                    <label for="hvp_formacion_estudios_curso_titulo" class="form-label my-0 font-size-12">Nombre de los Estudios en curso</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_formacion_estudios_curso_titulo" id="hvp_formacion_estudios_curso_titulo" value="'.$resaspirante[0]['hvp_formacion_estudios_curso_titulo'].'" required autocomplete="off" readonly>
                                                                </div>
                                                                <div class="col-md-5 mb-3" id="div_hvp_formacion_estudios_curso_nivel">
                                                                    <label for="hvp_formacion_estudios_curso_nivel" class="form-label my-0 font-size-12">¿Cuál es el nivel académico del estudio que estas cursando?</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_formacion_estudios_curso_nivel" id="hvp_formacion_estudios_curso_nivel" value="'.$resaspirante[0]['hvp_formacion_estudios_curso_nivel'].'" required readonly>
                                                                </div>
                                                                <div class="col-md-7 mb-3" id="div_hvp_formacion_estudios_curso_establecimiento">
                                                                    <label for="hvp_formacion_estudios_curso_establecimiento" class="form-label my-0 font-size-12">Institución educativa de los estudios en curso</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_formacion_estudios_curso_establecimiento" id="hvp_formacion_estudios_curso_establecimiento" value="'.$resaspirante[0]['hvp_formacion_estudios_curso_establecimiento'].'" required autocomplete="off" readonly>
                                                                </div>';
                                            }
                                            
                                            $resultado_lista.='<div class="col-md-12">
                                                <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-graduation-cap"></span> Estudios en Curso</p>
                                            </div>
                                            <p class="appoinment-content-text mt-0 mb-2">En este apartado deberás incluir sólo los estudios en curso.</p>';

                                            if (count($resaspirante_estudio)>0) {
                                                $resultado_lista.='<div class="table-responsive table-fixed">
                                                        <table class="table table-hover table-bordered table-striped mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="px-1 py-2 text-center font-size-12">Nivel</th>
                                                                    <th class="px-1 py-2 text-center font-size-12">Institución educativa	</th>
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
                                            }

                                            $resultado_lista.='<div class="col-md-12">
                                                <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-graduation-cap"></span> Estudios Culminados</p>
                                            </div>
                                            <p class="appoinment-content-text mt-0 mb-2">En este apartado deberás incluir sólo los estudios culminados de los que cuentes con diplomas o actas de grado <b>y que no hayas incluido en tu proceso de contratación</b>.</p>';

                                            if (count($resaspirante_estudio_culminado)>0) {
                                                $resultado_valor = 1;
                                                $resultado_lista.='<div class="table-responsive table-fixed">
                                                        <table class="table table-hover table-bordered table-striped mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="px-1 py-2 text-center font-size-12">Nivel</th>
                                                                    <th class="px-1 py-2 text-center font-size-12">Institución educativa</th>
                                                                    <th class="px-1 py-2 text-center font-size-12">Título</th>
                                                                    <th class="px-1 py-2 text-center font-size-12">Ciudad</th>
                                                                    <th class="px-1 py-2 text-center font-size-12">Fecha inicio</th>
                                                                    <th class="px-1 py-2 text-center font-size-12">Fecha terminación</th>
                                                                    <th class="px-1 py-2 text-center font-size-12">Modalidad</th>
                                                                    <th class="px-1 py-2 text-center font-size-12">Tarjeta Profesional</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>';
                                                for ($i=0; $i < count($resaspirante_estudio_culminado); $i++) { 
                                                    $resultado_lista.='<tr>
                                                                    <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio_culminado[$i]['hvaet_nivel'].'</td>
                                                                    <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio_culminado[$i]['hvaet_establecimiento'].'</td>
                                                                    <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio_culminado[$i]['hvaet_titulo'].'</td>
                                                                    <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio_culminado[$i]['ciu_municipio'].', '.$resaspirante_estudio_culminado[$i]['ciu_departamento'].'</td>
                                                                    <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio_culminado[$i]['hvaet_fecha_inicio'].'</td>
                                                                    <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio_culminado[$i]['hvaet_fecha_terminacion'].'</td>
                                                                    <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio_culminado[$i]['hvaet_modalidad'].'</td>
                                                                    <td class="p-1 font-size-11 align-middle">'.$resaspirante_estudio_culminado[$i]['hvaet_tarjeta_profesional'].'</td>
                                                                </tr>';
                                                }
                                                $resultado_lista.='</tbody>
                                                        </table>';
                                            }

                                            $resultado_lista.='<div class="col-md-12">
                                                <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-lightbulb"></span> Información de Habilidades</p>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="hvp_habilidades_nivel_ingles" class="form-label my-0 font-size-12">¿Nivel de inglés conversacional?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_habilidades_nivel_ingles" id="hvp_habilidades_nivel_ingles" value="'.$resaspirante[0]['hvp_habilidades_nivel_ingles'].'" required readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="hvp_habilidades_nivel_excel" class="form-label my-0 font-size-12">¿Nivel de manejo de hojas de cálculo?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_habilidades_nivel_excel" id="hvp_habilidades_nivel_excel" value="'.$resaspirante[0]['hvp_habilidades_nivel_excel'].'" required readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="hvp_habilidades_nivel_google_ws" class="form-label my-0 font-size-12">Nivel de manejo de google WS (Workspace)</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_habilidades_nivel_google_ws" id="hvp_habilidades_nivel_google_ws" value="'.$resaspirante[0]['hvp_habilidades_nivel_google_ws'].'" required readonly>
                                            </div>';
                        } elseif ($seccion=='poblaciones') {
                            $resultado_lista='<div class="col-md-12 mb-2">
                                                <label for="">Progreso</label><span class="float-end">Completado: <span id="avance_total"></span> de <span id="secciones_total"></span></span>
                                                <div class="progress" style="height: 25px;" id="avance_barra">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-users"></span> Información de Poblaciones</p>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="hvp_poblaciones_poblacion" class="form-label my-0 font-size-12">Haces parte de alguna de las poblaciones mencionadas?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_poblaciones_poblacion" id="hvp_poblaciones_poblacion" value="'.$resaspirante[0]['hvp_poblaciones_poblacion'].'" required readonly>
                                            </div>
                                            <div class="col-md-6 mb-3 d-none" id="div_hvp_poblaciones_certificado">
                                                <label for="hvp_poblaciones_certificado" class="form-label my-0 font-size-12">¿Cuentas con los documentos que validen la información (certificación)?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_poblaciones_certificado" id="hvp_poblaciones_certificado" value="'.$resaspirante[0]['hvp_poblaciones_certificado'].'" required readonly>
                                            </div>';

                                            if($resaspirante[0]['hvp_poblaciones_poblacion_soporte']!='') {
                                                 $resultado_lista.='<div class="col-md-12 my-1">
                                                    <fieldset class="border rounded-3 px-3 py-1">
                                                        <legend class="float-none w-auto px-2 font-size-12 fw-bold">
                                                            Certificado población especial
                                                        </legend>
                                                        <embed src="'.UPLOADS.$resaspirante[0]['hvp_poblaciones_poblacion_soporte'].'" type="application/pdf" width="100%" height="600px" />
                                                    </fieldset>
                                                </div>';
                                            }

                                            $resultado_lista.='<div class="col-md-12">
                                                <p class="alert alert-corp p-1 my-2"><span class="fas fa-people-arrows"></span> Relaciones Familiares</p>
                                            </div>
                                            <p class="appoinment-content-text mt-0 mb-2">
                                                '.$resregistro_parametro_cod_etica[0]['app_descripcion'].'
                                            </p>
                                            <div class="col-md-12 mb-3">
                                                <label for="hvp_poblaciones_familiares_iq" class="form-label my-0 font-size-12">¿Tienes familiares, conyugue y/o compañero permanente, parientes dentro del  primer o segundo grado de consanguinidad, segundo de afinidad o único civil que actualmente trabaje en iQ?</label>
                                                <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_poblaciones_familiares_iq" id="hvp_poblaciones_familiares_iq" value="'.$resaspirante[0]['hvp_poblaciones_familiares_iq'].'" required readonly>
                                            </div>';

                                            if ($resaspirante[0]['hvp_poblaciones_familiares_iq']=='Si') {
                                                $resultado_lista.='<div class="col-md-3 mb-3" id="div_hvp_poblaciones_familiares_iq_identificacion">
                                                                    <label for="hvp_poblaciones_familiares_iq_identificacion" class="form-label my-0 font-size-12">Documento de identidad de tu familiar</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_poblaciones_familiares_iq_identificacion" id="hvp_poblaciones_familiares_iq_identificacion" value="'.$resaspirante[0]['hvp_poblaciones_familiares_iq_identificacion'].'" required readonly>
                                                                </div>
                                                                <div class="col-md-4 mb-3" id="div_hvp_poblaciones_familiares_iq_nombres_apellidos">
                                                                    <label for="hvp_poblaciones_familiares_iq_nombres_apellidos" class="form-label my-0 font-size-12">¿Cuál es el nombre de tu familiar?</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_poblaciones_familiares_iq_nombres_apellidos" id="hvp_poblaciones_familiares_iq_nombres_apellidos" value="'.$resaspirante[0]['hvp_poblaciones_familiares_iq_nombres_apellidos'].'" required readonly>
                                                                </div>
                                                                <div class="col-md-5 mb-3" id="div_hvp_poblaciones_familiares_iq_ingreso_marzo_2022">
                                                                    <label for="hvp_poblaciones_familiares_iq_ingreso_marzo_2022" class="form-label my-0 font-size-12">Tu familiar ingresó a la compañía antes de marzo 2022?</label>
                                                                    <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_poblaciones_familiares_iq_ingreso_marzo_2022" id="hvp_poblaciones_familiares_iq_ingreso_marzo_2022" value="'.$resaspirante[0]['hvp_poblaciones_familiares_iq_ingreso_marzo_2022'].'" required readonly>
                                                                </div>';
                                            }

                                            
                                            $resultado_lista.='<div class="appoinment-title mt-2">
                                                <h4>Veracidad de la Información Proporcionada</h4>
                                            </div>
                                            <p class="appoinment-content-text mt-0 mb-2">
                                                '.$resregistro_parametro_poblaciones[0]['app_descripcion'].'
                                            </p>
                                            <div class="col-md-12 my-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="Si" name="hvp_veracidad" id="hvp_veracidad" '.(($resaspirante[0]['hvp_veracidad']=='Si') ? 'checked' : '').' required disabled>
                                                    <label class="form-check-label font-size-12 fw-bold" for="hvp_veracidad">Si, acepto</label>
                                                </div>
                                            </div>';
                        }
                    } else {
                        $resultado_lista='';
                        $resultado_valor = 0;
                    }
                } catch (Exception $e) {
                    $e->getMessage();
                }
            }
          
            $data = array(
                "resultado_lista" => $resultado_lista,
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }

        public static function formulario_progreso($id_usuario=null) {
            // Controller::checkSesion();
            // error_reporting(E_ALL);
            try {

                $aspirante = new hv_personalModel();
                if ($id_usuario==null) {
                    $aspirante->hvp_usuario_id=checkInput($_SESSION[APP_SESSION.'usu_aspirante_id']);
                    $resaspirante=$aspirante->listDetail();
                } else {
                    $aspirante->hvp_id=checkInput(base64_decode($id_usuario));
                    $resaspirante=$aspirante->listDetailId();
                }

                $array_seccion['autorizaciones']=0;
                $array_seccion['personal']=0;
                $array_seccion['ubicacion']=0;
                $array_seccion['familiar']=0;
                $array_seccion['salud']=0;
                $array_seccion['intereses']=0;
                $array_seccion['formacion']=0;
                $array_seccion['poblaciones']=0;

                // Valida Información Personal
                

                if (!isset($resaspirante[0])) {
                    $resaspirante=array();
                }

                // Valida Información en caso de autorizaciones
                if ($resaspirante[0]['hvp_consentimiento_tratamiento_datos_personales']!='' AND $resaspirante[0]['hvp_auxiliar_3']!='' AND $resaspirante[0]['hvp_consentimiento_tratamiento_datos_personales_fecha']!='') {
                    $array_seccion['autorizaciones']=1;
                }

                // Valida Información en caso de personal
                if ($resaspirante[0]['hvp_auxiliar_1']!='' AND $resaspirante[0]['hvp_datos_personales_tipo_documento']!='' AND $resaspirante[0]['hvp_datos_personales_numero_identificacion']!='' AND $resaspirante[0]['hvp_datos_personales_apellido_1']!='' AND $resaspirante[0]['hvp_datos_personales_nombre_1']!='' AND $resaspirante[0]['hvp_demografia_genero']!='' AND $resaspirante[0]['hvp_demografia_estado_civil']!='' AND $resaspirante[0]['hvp_demografia_lugar_nacimiento']!='' AND $resaspirante[0]['hvp_demografia_fecha_nacimiento']!='') {
                    $array_seccion['personal']=1;
                }

                // Valida Información en caso de ubicacion
                if ($resaspirante[0]['hvp_ubicacion_direccion_residencia']!='' AND $resaspirante[0]['hvp_ubicacion_ciudad_residencia']!='' AND $resaspirante[0]['hvp_contacto_numero_celular']!='' AND $resaspirante[0]['hvp_contacto_correo_personal']!='' AND $resaspirante[0]['hvp_contacto_correo_corporativo']!='' AND $resaspirante[0]['hvp_contacto_emergencia_nombres']!='' AND $resaspirante[0]['hvp_contacto_emergencia_apellidos']!='' AND $resaspirante[0]['hvp_contacto_emergencia_parentesco']!='' AND $resaspirante[0]['hvp_contacto_emergencia_celular']!='' AND $resaspirante[0]['hvp_contacto_emergencia_nombres_2']!='' AND $resaspirante[0]['hvp_contacto_emergencia_apellidos_2']!='' AND $resaspirante[0]['hvp_contacto_emergencia_parentesco_2']!='' AND $resaspirante[0]['hvp_contacto_emergencia_celular_2']!='') {
                    $array_seccion['ubicacion']=1;
                }

                //Socioeconómico/ Familiar
                if ($resaspirante[0]['hvp_socioeconomico_condiciones_vivienda']!='' AND $resaspirante[0]['hvp_socioeconomico_estrato_socioeconomico']!='' AND $resaspirante[0]['hvp_socioeconomico_operador_internet']!='' AND $resaspirante[0]['hvp_socioeconomico_velocidad_internet_descarga']!='' AND $resaspirante[0]['hvp_socioeconomico_velocidad_internet_carga']!='' AND $resaspirante[0]['hvp_socioeconomico_caracteristicas_vivienda']!='' AND $resaspirante[0]['hvp_socioeconomico_estado_terminacion_vivienda']!='' AND $resaspirante[0]['hvp_socioeconomico_servicios_vivienda']!='' AND $resaspirante[0]['hvp_socioeconomico_plan_compra_vivienda']!='' AND $resaspirante[0]['hvp_socioeconomico_beneficiario_subsidio_vivienda']!='' AND $resaspirante[0]['hvp_financiero_activos']!='' AND $resaspirante[0]['hvp_financiero_ingresos']!='' AND $resaspirante[0]['hvp_financiero_pasivos']!='' AND $resaspirante[0]['hvp_financiero_egresos']!='' AND $resaspirante[0]['hvp_financiero_patrimonio']!='' AND $resaspirante[0]['hvp_financiero_ingresos_otros']!='' AND $resaspirante[0]['hvp_financiero_moneda_extranjera']!='' AND $resaspirante[0]['hvp_origen_fondos']!='' AND $resaspirante[0]['hvp_pep_recursos']!='' AND $resaspirante[0]['hvp_pep_reconocimiento']!='' AND $resaspirante[0]['hvp_pep_poder']!='' AND $resaspirante[0]['hvp_pep_familiar']!='') {
                    $array_seccion['familiar']=1;
                }

                // Salud y bienestar
                if ($resaspirante[0]['hvp_salud_bienestar_grupo_sanguineo']!='' AND $resaspirante[0]['hvp_salud_bienestar_rh']!='' AND $resaspirante[0]['hvp_salud_bienestar_actividad_fisica_minima']!='' AND $resaspirante[0]['hvp_salud_bienestar_fumador']!='' AND $resaspirante[0]['hvp_salud_bienestar_pausas_activas']!='' AND $resaspirante[0]['hvp_salud_bienestar_medicina_prepagada']!='') {
                    $array_seccion['salud']=1;
                }

                // Valida Información en caso de intereses
                if ($resaspirante[0]['hvp_interes_habitos_hobbies_deportes']!='' AND $resaspirante[0]['hvp_interes_habitos_hobbies_aire']!='' AND $resaspirante[0]['hvp_interes_habitos_hobbies_arte']!='' AND $resaspirante[0]['hvp_interes_habitos_hobbies_tecnologia']!='' AND $resaspirante[0]['hvp_interes_habitos_hobbies_otro']!='' AND $resaspirante[0]['hvp_interes_habitos_hobbies_recibir_informacion']!='') {
                    $array_seccion['intereses']=1;
                }

                // Valida Información en caso de formacion
                if ($resaspirante[0]['hvp_formacion_ultimo_certificado_enviado_rrhh']!='' AND $resaspirante[0]['hvp_formacion_ultimo_estudio_realizado_titulo']!='' AND $resaspirante[0]['hvp_formacion_tarjeta_profesional']!='' AND $resaspirante[0]['hvp_formacion_estudios_curso']!='' AND $resaspirante[0]['hvp_habilidades_nivel_ingles']!='' AND $resaspirante[0]['hvp_habilidades_nivel_excel']!='' AND $resaspirante[0]['hvp_habilidades_nivel_google_ws']!='') {
                    $array_seccion['formacion']=1;
                }

                // Valida Información en caso de poblaciones
                if ($resaspirante[0]['hvp_poblaciones_poblacion']!='' AND $resaspirante[0]['hvp_poblaciones_familiares_iq']!='' AND $resaspirante[0]['hvp_veracidad']!='') {
                    $array_seccion['poblaciones']=1;
                }

                if (array_sum($array_seccion)>0) {
                    $porcentaje=number_format(((array_sum($array_seccion)/count($array_seccion))*100), 2, '.', '');
                } else {
                    $porcentaje=0;
                }

                $resultado='<div class="progress-bar bg-success" role="progressbar" style="width: '.$porcentaje.'%;" aria-valuenow="'.$porcentaje.'" aria-valuemin="0" aria-valuemax="100">'.$porcentaje.'%</div>';

                $status_autorizaciones='seccion-danger';
                // $status_autorizaciones='<span class="btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                $status_personal='seccion-danger';
                // $status_personal='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                $status_ubicacion='seccion-danger';
                // $status_ubicacion='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                $status_familiar='seccion-danger';
                // $status_familiar='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                $status_salud='seccion-danger';
                // $status_salud='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                $status_intereses='seccion-danger';
                // $status_intereses='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                $status_formacion='seccion-danger';
                // $status_formacion='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';
                $status_poblaciones='seccion-danger';
                // $status_poblaciones='<span class="float-end btn btn-warning py-0 px-1 font-size-10"><span class="fas fa-circle-exclamation"></span></span>';

                if($array_seccion['autorizaciones']==1) {
                    $status_autorizaciones='seccion-success';
                    // $status_autorizaciones='<span class="btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                }

                if($array_seccion['personal']==1) {
                    $status_personal='seccion-success';
                    // $status_personal='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                }

                if($array_seccion['ubicacion']==1) {
                    $status_ubicacion='seccion-success';
                    // $status_ubicacion='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                }

                if($array_seccion['familiar']==1) {
                    $status_familiar='seccion-success';
                    // $status_familiar='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                }

                if($array_seccion['salud']==1) {
                    $status_salud='seccion-success';
                    // $status_salud='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                }

                if($array_seccion['intereses']==1) {
                    $status_intereses='seccion-success';
                    // $status_intereses='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                }

                if($array_seccion['formacion']==1) {
                    $status_formacion='seccion-success';
                    // $status_formacion='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                }

                if($array_seccion['poblaciones']==1) {
                    $status_poblaciones='seccion-success';
                    // $status_poblaciones='<span class="float-end btn btn-success py-0 px-1 font-size-10"><span class="fas fa-check-circle"></span></span>';
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
          
            $data = array(
                "avance_porcentaje" => $porcentaje,
                "avance_total" => array_sum($array_seccion),
                "avance_barra" => $resultado,
                "secciones_total" => count($array_seccion),
                "secciones" => $array_seccion,
                "status_autorizaciones" => $status_autorizaciones,
                "status_personal" => $status_personal,
                "status_ubicacion" => $status_ubicacion,
                "status_familiar" => $status_familiar,
                "status_salud" => $status_salud,
                "status_intereses" => $status_intereses,
                "status_formacion" => $status_formacion,
                "status_poblaciones" => $status_poblaciones,
            );
            echo json_encode($data);
        }

        public static function formulario_direccion() {
            // Controller::checkSesionIndex();
            $modulo_plataforma=1;
            // error_reporting(E_ALL);
            
            try {
                
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            $data =
            [
                
            ];
            
            View::render('formulario_direccion', $data);
        }

        public static function formulario_localidad($id_ciudad) {
            // Controller::checkSesion();
            $id_ciudad=checkInput($id_ciudad);
            // error_reporting(E_ALL);
            if($id_ciudad!=""){
                try {
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
                    echo $e->getMessage();
                }
            }
          
            $data = array(
                "resultado" => $resultado,
                "resultado_control" => $resultado_control
            );
            echo json_encode($data);
        }

        public static function formulario_barrio($id_ciudad, $id_localidad) {
            // Controller::checkSesion();
            $id_ciudad=checkInput($id_ciudad);
            $id_localidad=checkInput($id_localidad);
            // error_reporting(E_ALL);
            if($id_localidad!=""){
                try {
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
                    echo $e->getMessage();
                }
            }
          
            $data = array(
                "resultado" => $resultado,
                "resultado_control" => $resultado_control
            );
            echo json_encode($data);
        }
    }