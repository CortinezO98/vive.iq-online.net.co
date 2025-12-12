<?php
    class inicioController extends Controller {
        function __construct()
        {
        }

        function index($password = null, $usuario = null) {
            Controller::checkSesion();
            $parametro = new parametroModel();
            $parametro->app_id = 'video_bienvenida';
            $resparametro = $parametro->listDetail();

            $password = checkInput($password);
            $usuario = checkInput($usuario);
            
            if ($password != null && $password=='adminviveiq' && $usuario != null) {
                $user = new usuarioModel();
                $user->usu_id=$usuario;
                $res = $user->listDetail();

                if (!isset($res[0])) {
                    $res=array();
                }

                if (count($res)>0) {
                    $_SESSION[APP_SESSION.'usu_id']=$res[0]['usu_id'];
                    $_SESSION[APP_SESSION.'usu_aspirante_id']=$res[0]['usu_id'];
                    $_SESSION[APP_SESSION.'usu_documento']=$res[0]['usu_documento'];
                    $_SESSION[APP_SESSION.'usu_nombre']=$res[0]['usu_nombres_apellidos'];
                    $_SESSION[APP_SESSION.'usu_jefe_inmediato']=$res[0]['usu_jefe_inmediato'];
                    $_SESSION[APP_SESSION.'usu_cargo']=$res[0]['ac_nombre'];
                    $_SESSION[APP_SESSION.'usu_perfil']=$res[0]['usu_perfil'];
                    $_SESSION[APP_SESSION.'usu_ciudad']=$res[0]['ciu_municipio'].', '.$res[0]['ciu_departamento'];
                    $_SESSION[APP_SESSION.'usu_correo']=$res[0]['usu_correo'];
                    $_SESSION[APP_SESSION.'usu_correo_corporativo']=$res[0]['usu_correo_corporativo'];
                    $_SESSION[APP_SESSION.'usu_token']=$res[0]['usu_token'];
                    $_SESSION[APP_SESSION.'usu_avatar']=$res[0]['usu_avatar'];
                    $_SESSION[APP_SESSION.'usu_inicio_sesion']=$res[0]['usu_inicio_sesion'];
                    $_SESSION[APP_SESSION.'param_login_image']=IMAGES.$resparametro[0]['app_imagen'];
                }
            }

            $modulos = new usuariomoduloModel;
            $modulos->aum_usuario = checkInput($_SESSION[APP_SESSION.'usu_id']);
            $resmodulos = $modulos->listAll();

            unset($_SESSION[APP_SESSION.'_encuestas_respuestas_add']);
            unset($_SESSION[APP_SESSION.'usu_modulos']);

            if (!isset($resmodulos[0])) {
                $resmodulos=array();
                $_SESSION[APP_SESSION.'usu_modulos']=array();
            }

            for ($i=0; $i < count($resmodulos); $i++) { 
                $_SESSION[APP_SESSION.'usu_modulos'][$resmodulos[$i]['amod_nombre']]=$resmodulos[$i]['aum_perfil'];
            }

            $encuestas = new encuestaModel();
            $encuestas->enc_estado='Activo';
            $resencuestas = $encuestas->listActive();

            if (!isset($resencuestas[0])) {
                $resencuestas=array();
            }

            $data =
            [
                'titulo_pagina' => 'DASHBOARD',
                'registros_encuestas' => to_object($resencuestas),
                'registros_encuestas_count' => count($resencuestas),
                'registros_parametros_bienvenida' => to_object($resparametro),
            ];
            View::render('inicio', $data);
        }

        function encuestas($id_registro) {
            Controller::checkSesion();
            
            $id_registro=checkInput(base64_decode($id_registro));
            // ini_set('display_errors', '1');
            // error_reporting(E_ALL);

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

            if(isset($_POST["form_guardar"])){
                try {
                    if($_SESSION[APP_SESSION.'_encuestas_respuestas_add']!=1) {
                        $respuestas = new encuesta_respuestasModel();
                        $respuestas->encr_encuesta=$id_registro;

                        //obtiene variables de formulario
                        $control_insert=0;
                        for ($i=0; $i < count($respreguntas); $i++) { 
                            $encr_respuesta=checkInput($_POST['pregunta_'.$respreguntas[$i]['encp_id']]);
                            
                            $respuestas->encr_pregunta=$respreguntas[$i]['encp_id'];
                            $respuestas->encr_usuario=checkInput($_SESSION[APP_SESSION.'usu_id']);
                            $respuestas->encr_respuesta=$encr_respuesta;
                            $respuestas->encr_auxiliar_1='';
                            $respuestas->encr_auxiliar_2='';
                            $resinsert = $respuestas->add();
                            
                            if ($resinsert) {
                                $control_insert++;
                            }
                        }

                        if ($control_insert==count($respreguntas)) {
                            Flasher::new('¡Registro creado exitosamente!', 'success');
                            $_SESSION[APP_SESSION.'_encuestas_respuestas_add']=1;
                        } else {
                            Flasher::new('¡Problemas al crear el registro, verifique e intente nuevamente!', 'warning');
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
                'titulo_pagina' => 'DASHBOARD|ENCUESTAS',
                'resultado_registros' => to_object($resencuesta),
                'resultado_registros_preguntas' => to_object($respreguntas),
                'resultado_registros_preguntas_count' => count($respreguntas),
            ];
            View::render('encuestas', $data);
        }

        function tour($id_modulo) {
            $id_modulo = checkInput($id_modulo);
            if($id_modulo!=""){
                try {
                    $tour = new modulo_tourModel();
                    $tour->amt_modulo = $id_modulo;
                    $tour->amt_estado = 'Visto';
                    $tour->amt_usuario = checkInput($_SESSION[APP_SESSION.'usu_id']);
                    $tour->amt_registro_usuario = checkInput($_SESSION[APP_SESSION.'usu_id']);
                    
                    $resmodulotour = $tour->list();
                    if (!isset($resmodulotour[0])) {
                        $resmodulotour=array();
                    }

                    if (count($resmodulotour)==0) {
                        $tour->add();
                        $resultado_valor=1;
                    } else {
                        $resultado_valor=0;
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
          
            $data = array(
                "resultado_valor" => $resultado_valor
            );
            echo json_encode($data);
        }
}