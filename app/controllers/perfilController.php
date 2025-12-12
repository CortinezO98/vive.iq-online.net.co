<?php
    class perfilController extends Controller {
        function __construct()
        {
        }

        function index() {
            Controller::checkSesion();
            unset($_SESSION[APP_SESSION.'cambiar_foto']);
            unset($_SESSION[APP_SESSION.'cambiar_contrasena']);
            $user = new usuarioModel();
            $user->usu_id = checkInput($_SESSION[APP_SESSION.'usu_id']);
            $res = $user->listDetail();

            $data =
            [
                'resultado_registros' => to_object($res),
            ];
            View::render('perfil', $data);
        }

        public static function cambiar_foto() {
            Controller::validarSesion();
            $data = [];

            $user = new usuarioModel();
            $user->usu_id = checkInput($_SESSION[APP_SESSION.'usu_id']);
            if(isset($_POST["form_guardar"])){
                //obtiene variables
                // error_reporting(E_ALL);
                // ini_set('display_errors', '1');
                try {
                    if($_SESSION[APP_SESSION.'cambiar_foto']!=1){
                        $nombre_archivo = basename($_FILES['documento']['name']); // elimina cualquier ruta relativa
                        $archivo_extension = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));
                        
                        if ($_FILES['documento']['name']!="" AND whiteListExt($archivo_extension)) {
                            $NombreArchivo=checkInput($_SESSION[APP_SESSION.'usu_id']).".".$archivo_extension;
                            $ruta_actual=ASSETS_ROOT."images/avatar/";
                            $ruta_actual_guardar="avatar/";
                            $ruta_final=$ruta_actual.$NombreArchivo;
                            $ruta_final_guardar=$ruta_actual_guardar.$NombreArchivo;
                            if ($_FILES['documento']["error"] > 0) {
                                $control_documento=0;
                            } else {
                              /*ahora co la funcion move_uploaded_file lo guardaremos en el destino que queramos*/
                                if (move_uploaded_file($_FILES['documento']['tmp_name'], $ruta_final)) {
                                    $control_documento=1;
                                } else {
                                    $control_documento=0;
                                }
                            }
                        } else {
                            $control_documento=0;
                        }
              
                        if ((file_exists($ruta_final) AND $control_documento==1)) {
                            $user->usu_avatar=$ruta_final_guardar;
                            $user->usu_actualiza_fecha=date('Y-m-d H:i:s');
                            $res = $user->updateFoto();
                            if ($res) {
                                Flasher::new('¡Registro actualizado exitosamente!', 'success');
                                $_SESSION[APP_SESSION.'usu_avatar']=$ruta_final_guardar.'?cod='.generar_token(5);
                                $_SESSION[APP_SESSION.'cambiar_foto']=1;
                            } else {
                                Flasher::new('¡Problemas asdasdal actualizar el registro, verifique e intente nuevamente!', 'warning');
                            }
                        } else {
                            Flasher::new('¡Problemas al actualizar el registro, verifique e intente nuevamente!', 'warning');
                        }
                    } else {
                        Flasher::new('¡Registro actualizado exitosamente!', 'success');
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
            
            View::render('cambiar-foto', $data);
        }

        public static function cambiar_contrasena() {
            Controller::validarSesion();
            $data = [];

            $user = new usuarioModel();
            $user->usu_id = checkInput($_SESSION[APP_SESSION.'usu_id']);
            if(isset($_POST["form_guardar"])){
                //obtiene variables
                $password_1=checkInput($_POST['password_1']);
                $password_2=checkInput($_POST['password_2']);
                try {
                    if($_SESSION[APP_SESSION.'cambiar_contrasena']!=1){
                        if ($password_1==$password_2) {
                            $estado_valida_password=1;
                            if (!strlen($password_1)>=8) {
                              $estado_valida_password=0;
                            }
                
                            if (!preg_match("/[0-9]/", $password_1)) {
                              $estado_valida_password=0;
                            }
                
                            if (!preg_match("/[a-z]/", $password_1)) {
                              $estado_valida_password=0;
                            }
                
                            if (!preg_match("/[A-Z]/", $password_1)) {
                              $estado_valida_password=0;
                            }
                
                            if (!preg_match("/[~!#$%^*+=<>]/", $password_1)) {
                              $estado_valida_password=0;
                            }
                
                            if ($estado_valida_password) {
                                //CONSULTA EN HISTORIAL DE CONTRASEÑAS PARA VALIDAR QUE NO SEA IGUAL A LA ULTIMA
                                $pass = new contrasenaModel();
                                $pass->auc_usuario = checkInput($_SESSION[APP_SESSION.'usu_id']);
                                $respass = $pass->lastPassword();
                                if (password_verify($password_1, $respass[0]['auc_contrasena'])) {
                                    Flasher::new('¡Contraseña usada recientemente, verifique e intente nuevamente!', 'warning');
                                } else {
                                    $contrasena_guardar = password_hash($password_1, PASSWORD_DEFAULT);
                    
                                    $user->usu_contrasena=$contrasena_guardar;
                                    $user->usu_actualiza_fecha=date('Y-m-d H:i:s');
                                    $res = $user->updateContrasena();
                                    if ($res) {
                                        Flasher::new('¡Contraseña actualizada exitosamente!', 'success');
                                        $_SESSION[APP_SESSION.'cambiar_contrasena']=1;
                                        $pass->auc_contrasena = $contrasena_guardar;
                                        $respassadd = $pass->add();
                                        
                                        // registro_log($enlace_db, 'Login', 'editar', 'Contraseña actualizada para usuario '.$_SESSION[APP_SESSION.'_session_usu_id'].'-'.$_SESSION[APP_SESSION.'_session_usu_nombre_completo']);
                    
                                        // //PROGRAMACIÓN NOTIFICACIÓN
                                        // $asunto='Cambio de Contraseña - '.APP_NAME.' | '.APP_NAME_ALL;
                                        // $referencia='Cambio de Contraseña';
                                        // $contenido="<p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Cordial saludo,<br><br>¡Se ha realizado actualización de contraseña!</p>
                                        //         <center>
                                        //             <p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'><b>Nombres y Apellidos: ".$_SESSION[APP_SESSION.'_session_usu_nombre_completo']."</b></p>
                                        //         </center>";
                                        // $nc_address=$_SESSION[APP_SESSION.'_session_usu_correo'].";";
                                        // $nc_cc='';
                                        // notificacion($enlace_db, $asunto, $referencia, $contenido, $nc_address, 'Login', $nc_cc);
                                        // registro_log($enlace_db, 'Login', 'notificacion', 'Notificación de cambio de contraseña para usuario '.$_SESSION[APP_SESSION.'_session_usu_id'].'-'.$_SESSION[APP_SESSION.'_session_usu_nombre_completo'].' programada');
                                    } else {
                                        Flasher::new('¡Problemas al actualizar la contraseña, verifique e intente nuevamente!', 'warning');
                                    }
                                }
                            } else {
                                Flasher::new('¡Contraseña no cumple requisitos mínimos de seguridad, verifique e intente nuevamente!', 'warning');
                            }
                        } else {
                            Flasher::new('¡Contraseña no coincide, verifique e intente nuevamente!', 'warning');
                        }
                    } else {
                        Flasher::new('¡Contraseña actualizada exitosamente!', 'success');
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
            
            View::render('cambiar-contrasena', $data);
        }
    }