<?php
    use PhpOffice\PhpSpreadsheet\IOFactory;
    class administrador_usuariosController extends Controller {
        function __construct()
        {
        }

        function index() {
            Controller::checkSesion();
            Redirect::to('administrador_usuarios/ver/0/null');
        }

        function ver($pagina, $filtro_busqueda) {
            Controller::checkSesion();
            // error_reporting(E_ALL);
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            unset($_SESSION[APP_SESSION.'_usuario_add']);

            if(isset($_POST["form_filtro_busqueda"])){
                //obtiene variables de formulario
                $filtro_busqueda=checkInput($_POST['filtro_busqueda']);
                $pagina=0;
            }
            
            try {
                $user = new usuarioModel();
                $user->pagina = $pagina;
                $user->limite = 20;
                $user->offset = $pagina*$user->limite;
                $user->filtro = $filtro_busqueda;
                
                $res = $user->list();
                $resCount = $user->listCount();
                if (!isset($res[0])) {
                    $res=array();
                }
                if (!isset($resCount[0])) {
                    $resCount=array();
                }
                $pag_total=ceil(count($resCount)/$user->limite);

                if (count($resCount)>0) {
                    $pag_inicio=($pagina*$user->limite)+1;
                } else {
                    $pag_inicio=0;
                } 
                
                if ((($pagina+1)*$user->limite)>count($resCount)) {
                    $pag_fin=count($resCount);
                } else {
                    $pag_fin=(($pagina+1)*$user->limite);
                }

                $data =
                [   
                    'titulo_pagina' => 'ADMINISTRADOR|USUARIOS|VER',
                    'path' => 'administrador_usuarios/ver/',
                    'resultado_registros' => to_object($res),
                    'pag_inicio' => $pag_inicio,
                    'pag_fin' => $pag_fin,
                    'pag_total' => $pag_total,
                    'resultado_registros_count' => count($resCount),
                    'pagina' => $pagina,
                    'filtro' => $filtro_busqueda,
                ];
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            
            View::render('ver', $data);
        }

        public static function crear($pagina, $filtro_busqueda) {
            $modulo_plataforma="1";
            Controller::checkSesion();
            // error_reporting(E_ALL);
            // ini_set('display_errors', 1);
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);

            $usuario = new usuarioModel();

            $ciudad = new ciudadModel();
            $resciudad=$ciudad->listActive();

            if (!isset($resciudad[0])) {
                $resciudad=array();
            }

            $modulo = new moduloModel();
            $resmodulo = $modulo->listActive();

            if (!isset($resmodulo[0])) {
                $resmodulo=array();
            }

            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                $usu_documento=checkInput($_POST['usu_documento']);
                $usu_acceso=checkInput($_POST['usu_acceso']);
                $usu_nombres_apellidos=checkInput($_POST['usu_nombres_apellidos']);
                $usu_estado=checkInput($_POST['usu_estado']);
                $usu_genero=checkInput($_POST['usu_genero']);
                $usu_fecha_incorporacion=checkInput($_POST['usu_fecha_incorporacion']);
                $usu_fecha_nacimiento=checkInput($_POST['usu_fecha_nacimiento']);
                $usu_correo=checkInput($_POST['usu_correo']);
                $usu_correo_corporativo=checkInput($_POST['usu_correo_corporativo']);
                $usu_ciudad=checkInput($_POST['usu_ciudad']);
                $usu_area=checkInput($_POST['usu_area']);
                $usu_cargo=checkInput($_POST['usu_cargo']);
                $usu_jefe_inmediato=checkInput($_POST['usu_jefe_inmediato']);
                $usu_perfil=checkInput($_POST['usu_perfil']);

                try {
                    if($_SESSION[APP_SESSION.'_usuario_add']!=1) {
                        $usuario->usu_documento=$usu_documento;
                        $usuario->usu_acceso=$usu_acceso;

                        $nueva_contrasena=newPassword(10);
                        $salt = substr(base64_encode(openssl_random_pseudo_bytes('30')), 0, 22);
                        $salt = strtr($salt, array('+' => '.'));

                        $usuario->usu_contrasena=crypt($nueva_contrasena, '$2y$10$' . $salt);

                        $usuario->usu_nombres_apellidos=$usu_nombres_apellidos;
                        $usuario->usu_correo=$usu_correo;
                        $usuario->usu_correo_corporativo=$usu_correo_corporativo;
                        $usuario->usu_fecha_incorporacion=$usu_fecha_incorporacion;
                        $usuario->usu_area=$usu_area;
                        $usuario->usu_cargo=$usu_cargo;
                        $usuario->usu_jefe_inmediato=$usu_jefe_inmediato;
                        $usuario->usu_ciudad=$usu_ciudad;
                        $usuario->usu_estado=$usu_estado;
                        $usuario->usu_inicio_sesion='0';
                        $usuario->usu_avatar='avatar/avatar.jpg';
                        $usuario->usu_genero=$usu_genero;
                        $usuario->usu_fecha_nacimiento=$usu_fecha_nacimiento;
                        $usuario->usu_perfil=$usu_perfil;
                        $usuario->usu_aspirante_id='';
                        $usuario->usu_actualiza_fecha='';
                        $usuario->usu_actualiza_login='';
                        $usuario->usu_registro_usuario=checkInput($_SESSION[APP_SESSION.'usu_id']);

                        $resusuario_duplicado=$usuario->listDuplicado();

                        if (!isset($resusuario_duplicado[0])) {
                            $resusuario_duplicado=array();
                        }

                        if (count($resusuario_duplicado)==0) {
                            $resinsert = $usuario->add();
                            
                            if ($resinsert) {
                                $usuario->usu_id=$resinsert;

                                $passhistorial = new passwordModel();
                                $passhistorial->auc_usuario = $usuario->usu_id;
                                $passhistorial->auc_contrasena = $usuario->usu_contrasena;
                                $passhistorial->add();

                                $usuariomodulo = new usuariomoduloModel();
                                $controlModulo=0;
                                $controlModuloInsert=0;
                                for ($i=0; $i < count($resmodulo); $i++) { 
                                    $id_modulo="usu_modulo_".$resmodulo[$i]['amod_id'];
                                    if (isset($_POST[$id_modulo])) {
                                        if ($_POST[$id_modulo]!="") {
                                            $controlModulo++;
                                            $usuariomodulo->aum_id='U'.$usuario->usu_id.'-M'.$resmodulo[$i]['amod_id'];
                                            $usuariomodulo->aum_usuario=$usuario->usu_id;
                                            $usuariomodulo->aum_modulo=$resmodulo[$i]['amod_id'];
                                            $usuariomodulo->aum_perfil=checkInput($_POST[$id_modulo]);
                                            $resinsertModulo = $usuariomodulo->add();
                                            $controlModuloInsert++;
                                        }
                                    }
                                }

                                //Crear aspirante o validar si existe
                                $aspirante = new hv_aspiranteModel();
                                $aspirante->hva_identificacion=$usu_documento;

                                $resaspirante=$aspirante->listDuplicado();

                                if (!isset($resaspirante[0])) {
                                    $resaspirante=array();
                                }
                                
                                $aspirante->hva_nombres=$usu_nombres_apellidos;
                                $aspirante->hva_nombres_2='';
                                $aspirante->hva_apellido_1='';
                                $aspirante->hva_apellido_2='';
                                $aspirante->hva_direccion='';
                                $aspirante->hva_barrio='';
                                $aspirante->hva_ciudad='';
                                $aspirante->hva_celular='';
                                $aspirante->hva_celular_2='';
                                $aspirante->hva_correo=$usu_correo;
                                $aspirante->hva_correo_corporativo=$usu_correo_corporativo;
                                $aspirante->hva_nacimiento_lugar='';
                                $aspirante->hva_nacimiento_fecha='';
                                $aspirante->hva_operador_internet='';
                                $aspirante->hva_genero='';
                                $aspirante->hva_estado_civil='';
                                $aspirante->hva_estado=$usu_estado;
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
                                $aspirante->hva_observaciones='';
                                $aspirante->hva_actualiza_usuario='';
                                $aspirante->hva_actualiza_fecha='';
                                $aspirante->hva_registro_usuario=checkInput($_SESSION[APP_SESSION.'usu_id']);
                                
                                if (count($resaspirante)==0) {
                                    $resinsert_aspirante = $aspirante->add();
                                    $hva_id=$resinsert_aspirante;
                                } else {
                                    $aspirante->hva_id=$resaspirante[0]['hva_id'];
                                    $resinsert_aspirante = $aspirante->updateAspirante();
                                    $hva_id=$resaspirante[0]['hva_id'];
                                }


                                $aspirante_hoja_vida = new hv_personalModel();
                                                        
                                $aspirante_hoja_vida->hvp_usuario_id=$resinsert;
                                $aspirante_hoja_vida->hvp_aspirante_id=$hva_id;
                                $aspirante_hoja_vida->hvp_consentimiento_tratamiento_datos_personales='';
                                $aspirante_hoja_vida->hvp_consentimiento_tratamiento_datos_personales_fecha='';
                                $aspirante_hoja_vida->hvp_datos_personales_tipo_documento='';
                                $aspirante_hoja_vida->hvp_datos_personales_numero_identificacion=$usu_documento;
                                $aspirante_hoja_vida->hvp_datos_personales_apellido_1='';
                                $aspirante_hoja_vida->hvp_datos_personales_apellido_2='';
                                $aspirante_hoja_vida->hvp_datos_personales_nombre_1=$usu_nombres_apellidos;
                                $aspirante_hoja_vida->hvp_datos_personales_nombre_2='';
                                $aspirante_hoja_vida->hvp_demografia_genero='';
                                $aspirante_hoja_vida->hvp_demografia_estado_civil='';
                                $aspirante_hoja_vida->hvp_demografia_lugar_nacimiento='';
                                $aspirante_hoja_vida->hvp_demografia_fecha_nacimiento='';
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
                                $aspirante_hoja_vida->hvp_contacto_numero_celular='';
                                $aspirante_hoja_vida->hvp_contacto_correo_personal=$usu_correo;
                                $aspirante_hoja_vida->hvp_contacto_correo_corporativo=$usu_correo_corporativo;
                                $aspirante_hoja_vida->hvp_contacto_emergencia_nombres='';
                                $aspirante_hoja_vida->hvp_contacto_emergencia_apellidos='';
                                $aspirante_hoja_vida->hvp_contacto_emergencia_parentesco='';
                                $aspirante_hoja_vida->hvp_contacto_emergencia_celular='';
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
                                $aspirante_hoja_vida->hvp_financiero_activos='';
                                $aspirante_hoja_vida->hvp_financiero_ingresos='';
                                $aspirante_hoja_vida->hvp_financiero_pasivos='';
                                $aspirante_hoja_vida->hvp_financiero_egresos='';
                                $aspirante_hoja_vida->hvp_financiero_patrimonio='';
                                $aspirante_hoja_vida->hvp_financiero_ingresos_otros='';
                                $aspirante_hoja_vida->hvp_financiero_concepto_ingresos='';
                                $aspirante_hoja_vida->hvp_financiero_moneda_extranjera='';
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
                                $aspirante_hoja_vida->hvp_fecha_ingreso='';
                                $aspirante_hoja_vida->hvp_retiro_fecha='';
                                $aspirante_hoja_vida->hvp_retiro_motivo='';
                                $aspirante_hoja_vida->hvp_auxiliar_1='';
                                $aspirante_hoja_vida->hvp_auxiliar_2='';
                                $aspirante_hoja_vida->hvp_auxiliar_3='';
                                $aspirante_hoja_vida->hvp_auxiliar_4='';
                                $aspirante_hoja_vida->hvp_auxiliar_5='';
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
                                }

                                if ($controlModulo==$controlModuloInsert) {
                                    $notificacion = new notificacionModel();
                                    $boton_titulo='Ir a plataforma '.APP_NAME;
                                    $boton_url=URL;
                                    //PROGRAMACIÓN NOTIFICACIÓN
                                        $contenido="<p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Sr(a) ".$usuario->usu_nombres_apellidos."<br><br>Se han generado las credenciales de acceso a la plataforma ".APP_NAME.":</p>
                                            <br>
                                            <br>
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
                                            </center>
                                            <br>";
                                    /*SE CONFIGURAN PARÁMETROS A REGISTRAR EN SISTEMA DE NOTIFICACIÓN*/
                                    $notificacion->nc_id_modulo=0;
                                    $notificacion->nc_address=$usuario->usu_correo_corporativo.';';
                                    $notificacion->nc_subject="Credenciales Acceso - ".APP_NAME;
                                    $notificacion->nc_body=notificacion_credenciales($contenido, $boton_titulo, $boton_url);
                                    $notificacion->nc_embeddedimage_ruta=BASEPATH_IMAGE.LOGO_NOTIFICACION;
                                    $notificacion->nc_embeddedimage_nombre="logo_notificacion";
                                    $notificacion->nc_embeddedimage_tipo="image/png";
                                    $notificacion->nc_usuario_registro=checkInput($_SESSION[APP_SESSION.'usu_id']);
                                    $notificacion->add();

                                    Flasher::new('¡Registro creado exitosamente!', 'success');
                                    $_SESSION[APP_SESSION.'_usuario_add']=1;
                                } else {
                                    Flasher::new('¡Problemas al crear el registro, verifique e intente nuevamente!', 'warning');
                                }
                            } else {
                                Flasher::new('¡Problemas al crear el registro, verifique e intente nuevamente!', 'warning');
                            }
                        } else {
                            Flasher::new('¡Problemas al crear el registro por posible duplicidad de usuario, verifique e intente nuevamente!', 'warning');
                        }
                    } else {
                        Flasher::new('¡Registro creado exitosamente!', 'success');
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }

            $area = new areaModel();
            $resarea = $area->listActive();

            if (!isset($resarea[0])) {
                $resarea=array();
            }

            $cargo = new cargoModel();
            $rescargo = $cargo->listActive();

            if (!isset($rescargo[0])) {
                $rescargo=array();
            }

            $resjefe=$usuario->listActive();

            if (!isset($resjefe[0])) {
                $resjefe=array();
            }

            $data =
            [
                'titulo_pagina' => 'ADMINISTRADOR|USUARIOS|CREAR',
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'resultado_registros_ciudad' => to_object($resciudad),
                'resultado_registros_area' => to_object($resarea),
                'resultado_registros_cargo' => to_object($rescargo),
                'resultado_registros_jefe' => to_object($resjefe),
                'resultado_registros_modulo' => to_object($resmodulo),
            ];
            
            View::render('crear', $data);
        }

        public static function editar($pagina, $filtro_busqueda, $id_registro) {
            $modulo_plataforma=1;
            Controller::checkSesion();
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $id_registro=checkInput(base64_decode($id_registro));
            // error_reporting(E_ALL);
            $usuario = new usuarioModel();
            $usuario->usu_id = $id_registro;

            $ciudad = new ciudadModel();
            $resciudad=$ciudad->listActive();

            if (!isset($resciudad[0])) {
                $resciudad=array();
            }

            $modulo = new moduloModel();
            $resmodulo = $modulo->listActive();

            if (!isset($resmodulo[0])) {
                $resmodulo=array();
            }

            $max_loops = 50;

            if (count($resmodulo) < $max_loops) {
                $array_usuariomodulo_perfil=array();
                for ($i=0; $i < count($resmodulo); $i++) { 
                    $array_usuariomodulo_perfil[$resmodulo[$i]['amod_id']]='';
                }
            }


            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                $usu_documento=checkInput($_POST['usu_documento']);
                $usu_acceso=checkInput($_POST['usu_acceso']);
                $usu_nombres_apellidos=checkInput($_POST['usu_nombres_apellidos']);
                $usu_estado=checkInput($_POST['usu_estado']);
                $usu_genero=checkInput($_POST['usu_genero']);
                $usu_fecha_incorporacion=checkInput($_POST['usu_fecha_incorporacion']);
                $usu_fecha_nacimiento=checkInput($_POST['usu_fecha_nacimiento']);
                $usu_correo_corporativo=checkInput($_POST['usu_correo_corporativo']);
                $usu_correo=checkInput($_POST['usu_correo']);
                $usu_ciudad=checkInput($_POST['usu_ciudad']);
                $usu_area=checkInput($_POST['usu_area']);
                $usu_cargo=checkInput($_POST['usu_cargo']);
                $usu_jefe_inmediato=checkInput($_POST['usu_jefe_inmediato']);
                $usu_perfil=checkInput($_POST['usu_perfil']);
                
                try {
                    $usuario->usu_documento=$usu_documento;
                    $usuario->usu_acceso=$usu_acceso;
                    $usuario->usu_nombres_apellidos=$usu_nombres_apellidos;
                    $usuario->usu_correo=$usu_correo;
                    $usuario->usu_correo_corporativo=$usu_correo_corporativo;
                    $usuario->usu_fecha_incorporacion=$usu_fecha_incorporacion;
                    $usuario->usu_area=$usu_area;
                    $usuario->usu_cargo=$usu_cargo;
                    $usuario->usu_jefe_inmediato=$usu_jefe_inmediato;
                    $usuario->usu_ciudad=$usu_ciudad;
                    $usuario->usu_estado=$usu_estado;
                    $usuario->usu_genero=$usu_genero;
                    $usuario->usu_perfil=$usu_perfil;
                    $usuario->usu_fecha_nacimiento=$usu_fecha_nacimiento;
                    $usuario->usu_actualiza_fecha=now();

                    $resusuario_duplicado=$usuario->listDuplicadoEditar();

                    if (!isset($resusuario_duplicado[0])) {
                        $resusuario_duplicado=array();
                    }

                    if (count($resusuario_duplicado)==0) {
                        $resupdate = $usuario->update();
                        
                        if ($resupdate) {
                            $hoja_vida = new hv_personalModel();
                            $hoja_vida->hvp_usuario_id = $id_registro;
                            $hoja_vida->hvp_contacto_correo_corporativo = $usu_correo_corporativo;
                            $hoja_vida->hvp_actualiza_fecha = now();
                            $resupdate_hoja_vida = $hoja_vida->updateCorreoCorporativoOnly();
    
                            $aspirante = new hv_aspiranteModel();
                            $aspirante->hva_identificacion = $usu_documento;
                            $aspirante->hva_correo_corporativo=$usu_correo_corporativo;
                            $resupdate_aspirante = $aspirante->updateCorreoCorporativoCC();
    
                            $usuariomodulo = new usuariomoduloModel();
                            $usuariomodulo->aum_usuario=$usuario->usu_id;
                            $usuariomodulo->delete();
                            $controlModulo=0;
                            $controlModuloInsert=0;
                            for ($i=0; $i < count($resmodulo); $i++) { 
                                $id_modulo="usu_modulo_".$resmodulo[$i]['amod_id'];
                                if (isset($_POST[$id_modulo])) {
                                    if ($_POST[$id_modulo]!="") {
                                        $controlModulo++;
                                        $usuariomodulo->aum_id='U'.$usuario->usu_id.'-M'.$resmodulo[$i]['amod_id'];
                                        $usuariomodulo->aum_usuario=$usuario->usu_id;
                                        $usuariomodulo->aum_modulo=$resmodulo[$i]['amod_id'];
                                        $usuariomodulo->aum_perfil=checkInput($_POST[$id_modulo]);
                                        $resinsertModulo = $usuariomodulo->add();
                                        $controlModuloInsert++;
                                    }
                                }
                            }
    
                            if ($controlModulo==$controlModuloInsert) {
                                Flasher::new('¡Registro editado exitosamente!', 'success');
                            } else {
                                Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                            }
                        } else {
                            Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                        }
                    } else {
                        Flasher::new('¡Problemas al crear el registro por posible duplicidad con los datos de otro usuario, verifique e intente nuevamente!', 'warning');
                    }


                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }

            if(isset($_POST["form_reset"])){
                try {
                    $nueva_contrasena=newPassword(10);
                    $salt = substr(base64_encode(openssl_random_pseudo_bytes('30')), 0, 22);
                    $salt = strtr($salt, array('+' => '.'));

                    $usuario->usu_contrasena=crypt($nueva_contrasena, '$2y$10$' . $salt);
                    $usuario->usu_actualiza_fecha=now();

                    $resupdatepass = $usuario->updatePassword();
                    
                    if ($resupdatepass) {
                        $usuario->usu_inicio_sesion = 0;
                        $usuario->updateSession();
                        
                        $passhistorial = new passwordModel();
                        $passhistorial->auc_usuario = $usuario->usu_id;
                        $passhistorial->auc_contrasena = $usuario->usu_contrasena;
                        $passhistorial->add();
                        
                        $resusuario=$usuario->listDetail();

                        $notificacion = new notificacionModel();
                        $boton_titulo='Ir a plataforma '.APP_NAME;
                        $boton_url=URL;
                        //PROGRAMACIÓN NOTIFICACIÓN
                            $contenido="<p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Sr(a) ".$resusuario[0]['usu_nombres_apellidos']."<br><br>Su cambio de contraseña se ha realizado de manera exitosa.</p>
                                <br>
                                <br>
                                <center>
                                    <table>
                                        <tr>
                                            <td style='font-size: 12px;padding: 3px 5px 3px 5px; margin-bottom: 3px; color: #FFFFFF; background-color: ".COLOR_PRINCIPAL."; border: solid 1px #FFFFFF; border-radius: 5px;'>Usuario</td>
                                            <td style='font-size: 12px;padding: 3px 5px 3px 5px; margin-bottom: 3px; color: #666666; background-color: #f2f2f2; border: solid 1px #FFFFFF; border-radius: 5px;'>".$resusuario[0]['usu_acceso']."</td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: 12px;padding: 3px 5px 3px 5px; margin-bottom: 3px; color: #FFFFFF; background-color: ".COLOR_PRINCIPAL."; border: solid 1px #FFFFFF; border-radius: 5px;'>Contraseña</td>
                                            <td style='font-size: 12px;padding: 3px 5px 3px 5px; margin-bottom: 3px; color: #666666; background-color: #f2f2f2; border: solid 1px #FFFFFF; border-radius: 5px;'>".$nueva_contrasena."</td>
                                        </tr>
                                    </table>
                                    <br>
                                    <br>
                                    <a href='".$boton_url."' target='_blank' style='border-radius:4px; color:#ffffff; font-size:12px; padding: 5px 5px 5px 5px; text-align:center; text-decoration:none !important; width:50%; display: block; background-color: ".COLOR_PRINCIPAL."'>".$boton_titulo."</a>
                                </center>
                                <br>";
                        /*SE CONFIGURAN PARÁMETROS A REGISTRAR EN SISTEMA DE NOTIFICACIÓN*/
                        $notificacion->nc_id_modulo=0;
                        $notificacion->nc_address=$resusuario[0]['usu_correo_corporativo'].';';
                        $notificacion->nc_subject="Reset Contraseña - ".APP_NAME;
                        $notificacion->nc_body=notificacion_credenciales($contenido, $boton_titulo, $boton_url);
                        $notificacion->nc_embeddedimage_ruta=BASEPATH_IMAGE.LOGO_NOTIFICACION;
                        $notificacion->nc_embeddedimage_nombre="logo_notificacion";
                        $notificacion->nc_embeddedimage_tipo="image/png";
                        $notificacion->nc_usuario_registro=checkInput($_SESSION[APP_SESSION.'usu_id']);
                        $notificacion->add();
                        Flasher::new('¡Contraseña reseteada exitosamente!', 'success');
                    } else {
                        Flasher::new('¡Problemas al resetear la contraseña, verifique e intente nuevamente!', 'warning');
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }

            $resusuario=$usuario->listDetail();

            $usuariomodulo = new usuariomoduloModel();
            $usuariomodulo->aum_usuario=$resusuario[0]['usu_id'];
            $resusuariomodulo = $usuariomodulo->listAll();

            if (!isset($resusuariomodulo[0])) {
                $resusuariomodulo=array();
            }

            for ($i=0; $i < count($resusuariomodulo); $i++) { 
                $array_usuariomodulo_perfil[$resusuariomodulo[$i]['aum_modulo']]=$resusuariomodulo[$i]['aum_perfil'];
            }

            $area = new areaModel();
            $resarea = $area->listActive();

            if (!isset($resarea[0])) {
                $resarea=array();
            }

            $cargo = new cargoModel();
            $rescargo = $cargo->listActive();

            if (!isset($rescargo[0])) {
                $rescargo=array();
            }

            $resjefe=$usuario->listActive();

            if (!isset($resjefe[0])) {
                $resjefe=array();
            }

            $data =
            [
                'titulo_pagina' => 'ADMINISTRADOR|USUARIOS|EDITAR',
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'resultado_registros_ciudad' => to_object($resciudad),
                'resultado_registros_modulo' => to_object($resmodulo),
                'resultado_registros_usuario' => to_object($resusuario),
                'resultado_registros_area' => to_object($resarea),
                'resultado_registros_cargo' => to_object($rescargo),
                'resultado_registros_jefe' => to_object($resjefe),
                'resultado_registros_usuariomodulo_perfil' => $array_usuariomodulo_perfil,
            ];
            
            View::render('editar', $data);
        }

        public static function reset_masivo() {
            $modulo_plataforma=1;
            Controller::checkSesion();
            
            // error_reporting(E_ALL);
            $usuario = new usuarioModel();
            $resusuario_reset=$usuario->listResetMasivo();
            
            if (!isset($resusuario_reset[0])) {
                $resusuario_reset=array();
            }

            for ($i=0; $i < count($resusuario_reset); $i++) { 
                try {
                    $nueva_contrasena=newPassword(10);
                    $salt = substr(base64_encode(openssl_random_pseudo_bytes('30')), 0, 22);
                    $salt = strtr($salt, array('+' => '.'));
                    echo $usuario->usu_id=$resusuario_reset[$i]['usu_id'];
                    $usuario->usu_contrasena=crypt($nueva_contrasena, '$2y$10$' . $salt);
                    $usuario->usu_actualiza_fecha=now();
    
                    $resupdatepass = $usuario->updatePassword();
                    echo "|";
                    if ($resupdatepass) {
                        echo "Contraseña generada";
                        $usuario->usu_inicio_sesion = 0;
                        $usuario->updateSession();
                        
                        $passhistorial = new passwordModel();
                        $passhistorial->auc_usuario = $usuario->usu_id;
                        $passhistorial->auc_contrasena = $usuario->usu_contrasena;
                        $passhistorial->add();
                        
                        $resusuario=$usuario->listDetail();
    
                        $notificacion = new notificacionModel();
                        $boton_titulo='Ir a plataforma '.APP_NAME;
                        $boton_url=URL;
                        //PROGRAMACIÓN NOTIFICACIÓN
                            $contenido="<p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>¡Bienvenido!</p>
                                <p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Ya eres un ciudadano iQ</p>
                                <p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Te asignamos un usuario y contraseña para que ingreses a Vive iQ, nuestra plataforma corporativa. Allí deberás tener al día tu información sociodemográfica.</p>
                                <center>
                                    <table>
                                        <tr>
                                            <td style='font-size: 12px;padding: 3px 5px 3px 5px; margin-bottom: 3px; color: #FFFFFF; background-color: ".COLOR_PRINCIPAL."; border: solid 1px #FFFFFF; border-radius: 5px;'>Usuario</td>
                                            <td style='font-size: 12px;padding: 3px 5px 3px 5px; margin-bottom: 3px; color: #666666; background-color: #f2f2f2; border: solid 1px #FFFFFF; border-radius: 5px;'>".$resusuario[0]['usu_acceso']."</td>
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
                            $notificacion->nc_id_modulo=0;
                            $notificacion->nc_address=$resusuario[0]['usu_correo_corporativo'].';';
                            $notificacion->nc_subject="Bienvenido a Vive iQ";
                            $notificacion->nc_body=notificacion_general($contenido, $boton_titulo, $boton_url);
                            $notificacion->nc_embeddedimage_ruta="".BASEPATH_IMAGE."/logo/firma-verde.png;".BASEPATH_IMAGE."/logo/logo_notificacion_bienvenida.jpg";
                            $notificacion->nc_embeddedimage_nombre="firma-verde;logo_notificacion";
                            $notificacion->nc_embeddedimage_tipo="image/png;image/png";
                            $notificacion->nc_usuario_registro=checkInput($_SESSION[APP_SESSION.'usu_id']);
                        
                        echo "|";
                        if ($notificacion->add()) {
                            echo "notificado";
                        } else {
                            echo "NO notificado";
                        }
                        
                    } else {
                        echo "Contraseña error";
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
                echo "<br>";
            }

            $data =
            [
                
            ];
            
            // View::render('editar', $data);
        }

        public static function reset_masivo_cc() {
            $modulo_plataforma=1;
            Controller::checkSesion();
            
            // error_reporting(E_ALL);
            $usuario = new usuarioModel();
            $resusuario_reset=$usuario->listResetMasivo();
            
            if (!isset($resusuario_reset[0])) {
                $resusuario_reset=array();
            }

            for ($i=0; $i < count($resusuario_reset); $i++) { 
                try {
                    echo $nueva_contrasena=$resusuario_reset[$i]['usu_documento'];
                    $salt = substr(base64_encode(openssl_random_pseudo_bytes('30')), 0, 22);
                    $salt = strtr($salt, array('+' => '.'));
                    echo " | ";
                    echo $usuario->usu_id=$resusuario_reset[$i]['usu_id'];
                    $usuario->usu_contrasena=crypt($nueva_contrasena, '$2y$10$' . $salt);
                    $usuario->usu_actualiza_fecha=now();
    
                    $resupdatepass = $usuario->updatePassword();
                    echo "|";
                    if ($resupdatepass) {
                        echo "Contraseña generada";
                        $usuario->usu_inicio_sesion = 0;
                        $usuario->updateSession();
                        
                        $passhistorial = new passwordModel();
                        $passhistorial->auc_usuario = $usuario->usu_id;
                        $passhistorial->auc_contrasena = $usuario->usu_contrasena;
                        $passhistorial->add();
                        
                        echo "|";
                        echo "actualizado";
                    } else {
                        echo "Contraseña error";
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
                echo "<br>";
            }

            $data =
            [
                
            ];
            
            // View::render('editar', $data);
        }
    }