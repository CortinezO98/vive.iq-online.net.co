<?php
    class loginController extends Controller {
        function __construct()
        {
        }

        function index() {
            Controller::checkSesionIndex();
            // error_reporting(E_ALL);
            // ini_set('display_errors', '1');
            unset($_SESSION[APP_SESSION.'_forgot_registro_creado']);
            unset($_SESSION[APP_SESSION.'_recovery_registro_creado']);
            unset($_SESSION[APP_SESSION.'_update_registro_creado']);
            $parametro = new parametroModel();
            $parametro->app_id = 'login';
            $resparametro = $parametro->listDetail();
            $parametro->app_id = 'logo';
            $resparametrologo = $parametro->listDetail();
            $parametro->app_id = 'inicio';
            $resparametroinicio = $parametro->listDetail();

            if(isset($_POST["form_sing_in"])){
                if (!isset($_POST['form_token'], $_SESSION['iqvive_token']) || 
                    !hash_equals($_SESSION['iqvive_token'], $_POST['form_token'])) {
                    Flasher::new('¡Error al validar el token, por favor intente nuevamente!', 'warning');
                } else {
                    //obtiene variable usuario y contraseña de formulario login
                    $usuario=checkInput($_POST['usuario']);
                    $password=checkInput($_POST['password']);

                    $captcha_response = true;
                    $recaptcha = checkInput($_POST['g-recaptcha-response']);
                
                    $url = 'https://www.google.com/recaptcha/api/siteverify';
                    $data = array(
                        'secret' => '6LftzogoAAAAAKT8XIuZaRDE3GJn0pFvv7YXNL2I',
                        'response' => $recaptcha
                    );
                    $options = array(
                        'http' => array (
                            'method' => 'POST',
                            'content' => http_build_query($data)
                        )
                    );
                    $context  = stream_context_create($options);
                    $verify = file_get_contents($url, false, $context);
                    $captcha_success = json_decode($verify);
                    $captcha_response = $captcha_success->success;
                    $captcha_response = true;
                    try {
                        if ($captcha_response) {
                            if ($usuario!="" AND $password!="") {
                                $user = new usuarioModel();
                                $user->usu_acceso=$usuario;
                                $user->usu_estado='Activo';
                                $res = $user->login();

                                if (!isset($res[0])) {
                                    $res=array();
                                }

                                if (count($res)>0) {
                                    //Correo encontrado y usuario activo
                                    if (!isset($_COOKIE['cin'])) {
                                        setcookie('cin', 0, time() + 365 * 24 * 60 * 60);
                                    }
                                    setcookie('cin', $_COOKIE['cin']+1, time() + 365 * 24 * 60 * 60);
                                    
                                    $log = new logModel();
                                    $log->clog_log_modulo='Login';
                                    $log->clog_user_agent=checkInput($_SERVER['HTTP_USER_AGENT']);
                                    $log->clog_remote_addr=checkInput($_SERVER['REMOTE_ADDR']);
                                    $log->clog_script=checkInput($_SERVER['PHP_SELF']);
                                    $log->clog_registro_usuario=$res[0]['usu_id'];
                                    
                                    if (crypt($password, $res[0]['usu_contrasena']) == $res[0]['usu_contrasena']) {
                                        unset($_COOKIE['cin']);
                                        setcookie('cin', 0, 0);
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
                                        $_SESSION[APP_SESSION.'param_logo_image']=IMAGES.$resparametrologo[0]['app_imagen'];
                                        $_SESSION[APP_SESSION.'param_inicio_image']=IMAGES.$resparametroinicio[0]['app_imagen'];

                                        $user->usu_id=$res[0]['usu_id'];
                                        $user->usu_actualiza_login=now();
                                        $user->updateLogin();

                                        $log->clog_log_tipo='inicio_sesion';
                                        $log->clog_log_accion='Inicio de sesión';
                                        $log->clog_log_detalle='Inicio de sesión';
                                        $log->add();

                                        $pass = new passwordModel();
                                        $pass->auc_usuario = $_SESSION[APP_SESSION.'usu_id'];
                                        $respass = $pass->list();

                                        $fecha_control=date("Y-m-d", strtotime("+ 60 day", strtotime($respass[0]['auc_registro_fecha'])));

                                        if (date('Y-m-d')>=$fecha_control) {
                                            $_SESSION[APP_SESSION.'usu_inicio_sesion']=0;
                                            $log->clog_log_tipo='password_expirada';
                                            $log->clog_log_accion='Contraseña expirada';
                                            $log->clog_log_detalle='Contraseña expirada';
                                            $log->add();
                                        }

                                        if ($_SESSION[APP_SESSION.'usu_inicio_sesion']==1) {
                                            Redirect::to('inicio');
                                        } else {
                                            Redirect::to('login/password-update');
                                        }
                                    } else {
                                        if ($_COOKIE['cin']>=5) {
                                            $user->usu_id = $res[0]['usu_id'];
                                            $user->usu_estado = 'Bloqueado';
                                            $resstatus = $user->updateStatus();

                                            if ($resstatus) {
                                                $log->clog_log_tipo='login_bloqueado';
                                                $log->clog_log_accion='Bloqueo usuario';
                                                $log->clog_log_detalle='Bloqueo de usuario por intentos fallidos';
                                                $log->add();
                                            } else {
                                                $log->clog_log_tipo='login_bloqueado_error';
                                                $log->clog_log_accion='Bloqueo usuario';
                                                $log->clog_log_detalle='Error bloqueo de usuario por intentos fallidos';
                                                $log->add();
                                            }

                                            unset($_COOKIE['cin']);
                                            setcookie('cin', 0, 0);
                                            Flasher::new('¡El usuario ha sido bloqueado por más de 4 intentos fallídos, por favor ingrese a la opción de recuperar contraseña!', 'warning');
                                        } else {
                                            Flasher::new('¡Usuario y/o contraseña incorrectos, verifique e intente nuevamente!', 'warning');
                                        }
                                    }
                                } else {
                                    //Correo no encontrado o usuario inactivo
                                    Flasher::new('¡Usuario y/o contraseña incorrectos, verifique e intente nuevamente!', 'warning');
                                }
                            } else {
                                //datos incompletos
                                Flasher::new('¡Usuario y/o contraseña incorrectos, verifique e intente nuevamente!', 'warning');
                            }
                        } else {
                            //Correo no encontrado o usuario inactivo
                            Flasher::new('¡Por favor valide el Captcha, verifique e intente nuevamente!', 'warning');
                        }
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                }
                
            }

            $data = [
                'resultado_registros' => $resparametro,
                'resultado_registros_logo' => $resparametrologo,
            ];
            
            View::render('login', $data);
        }

        function forgot_password() {
            Controller::checkSesionIndex();
            $modulo_plataforma=1;
            $parametro = new parametroModel();
            $parametro->app_id = 'login';
            $resparametro = $parametro->listDetail();
            $parametro->app_id = 'logo';
            $resparametrologo = $parametro->listDetail();
            if(isset($_POST["form_recovery"])){
                if (!isset($_POST['form_token'], $_SESSION['iqvive_token']) || 
                    !hash_equals($_SESSION['iqvive_token'], $_POST['form_token'])) {
                    Flasher::new('¡Error al validar el token, por favor intente nuevamente!', 'warning');
                } else {
                    //obtiene variable usuario
                    $usuario=checkInput($_POST['correo']);

                    $recaptcha = checkInput($_POST['g-recaptcha-response']);
                
                    $url = 'https://www.google.com/recaptcha/api/siteverify';
                    $data = array(
                        'secret' => '6LftzogoAAAAAKT8XIuZaRDE3GJn0pFvv7YXNL2I',
                        'response' => $recaptcha
                    );
                    $options = array(
                        'http' => array (
                            'method' => 'POST',
                            'content' => http_build_query($data)
                        )
                    );
                    $context  = stream_context_create($options);
                    $verify = file_get_contents($url, false, $context);
                    $captcha_success = json_decode($verify);
                    $captcha_response = $captcha_success->success;
                    
                    try {
                        if ($usuario!="" AND $captcha_response) {
                            if($_SESSION[APP_SESSION.'_forgot_registro_creado']!=1) {
                                $user = new usuarioModel();
                                $user->usu_correo_corporativo=$usuario;
                                $user->usu_estado='Retirado';
                                $resusuario = $user->userRecovery();

                                if (!isset($resusuario[0])) {
                                    $resusuario=array();
                                }

                                if (count($resusuario)>0) {
                                    $token = new tokenModel();
                                    $token->aut_usuario=$resusuario[0]['usu_id'];
                                    $token->aut_token=newToken();
                                    $token->aut_estado='Generado';
                                    $token->aut_expira=date("Y-m-d H:i:s", strtotime("+ 20 minute", strtotime(now())));
                                    $res_insert_token = $token->add();
                                    
                                    $notificacion = new notificacionModel();
                                    $boton_titulo='Clic aquí para recuperar contraseña';
                                    $boton_url=URL."login/recovery-password/".base64_encode($token->aut_usuario)."/".base64_encode($token->aut_token);
                                    //PROGRAMACIÓN NOTIFICACIÓN
                                        $contenido="<p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Sr(a) ".$resusuario[0]['usu_nombres_apellidos']."<br><br>Se ha iniciado el proceso de recuperación de contraseña, para continuar, por favor ingrese al siguiente link:</p>
                                            <br>
                                            <br>
                                            <center>
                                                <a href='".$boton_url."' target='_blank' style='border-radius:4px; color:#ffffff; font-size:12px; padding: 5px 5px 5px 5px; text-align:center; text-decoration:none !important; width:50%; display: block; background-color: ".COLOR_PRINCIPAL."'>".$boton_titulo."</a>
                                            </center>
                                            <br>";
                                    /*SE CONFIGURAN PARÁMETROS A REGISTRAR EN SISTEMA DE NOTIFICACIÓN*/
                                    $notificacion->nc_id_modulo=0;
                                    $notificacion->nc_address=$resusuario[0]['usu_correo_corporativo'].';';
                                    $notificacion->nc_subject="Recuperar Contraseña - ".APP_NAME;
                                    $notificacion->nc_body=notificacion_credenciales($contenido, $boton_titulo, $boton_url);
                                    $notificacion->nc_embeddedimage_ruta=BASEPATH_IMAGE.LOGO_NOTIFICACION;
                                    $notificacion->nc_embeddedimage_nombre="logo_notificacion";
                                    $notificacion->nc_embeddedimage_tipo="image/png";
                                    $notificacion->nc_usuario_registro=checkInput($resusuario[0]['usu_id']);
                                    $res_insert_notificacion = $notificacion->add();

                                    $log = new logModel();
                                    $log->clog_log_modulo='Forgot password';
                                    $log->clog_user_agent=checkInput($_SERVER['HTTP_USER_AGENT']);
                                    $log->clog_remote_addr=checkInput($_SERVER['REMOTE_ADDR']);
                                    $log->clog_script=checkInput($_SERVER['PHP_SELF']);
                                    $log->clog_registro_usuario=$resusuario[0]['usu_id'];
                                    
                                    if ($res_insert_token) {
                                        $log->clog_log_tipo='token_sesion';
                                        $log->clog_log_accion='Token sesión';
                                        $log->clog_log_detalle='Generación de token proceso recuperación de contraseña';
                                        $log->add();
                                    } else {
                                        $log->clog_log_tipo='token_sesion_error';
                                        $log->clog_log_accion='Token sesión';
                                        $log->clog_log_detalle='Error en generación de token proceso recuperación de contraseña';
                                        $log->add();
                                    }
                                    
                                    if ($res_insert_notificacion) {
                                        $log->clog_log_tipo='notificacion_programada';
                                        $log->clog_log_accion='Notificación';
                                        $log->clog_log_detalle='Programación notificación proceso recuperación de contraseña';
                                        $log->add();
                                    } else {
                                        $log->clog_log_tipo='notificacion_programada_error';
                                        $log->clog_log_accion='Notificación';
                                        $log->clog_log_detalle='Error en programación notificación proceso recuperación de contraseña';
                                        $log->add();
                                    }

                                    if ($res_insert_token AND $res_insert_notificacion){
                                        Flasher::new('¡Para continuar con el proceso de recuperación de contraseña, por favor siga las instrucciones enviadas al correo electrónico registrado!<br><br>Recuerde que cuenta con 20 minutos antes de que expire la solicitud', 'success');
                                        $_SESSION[APP_SESSION.'_forgot_registro_creado']=1;
                                    } else {
                                        Flasher::new('¡Problemas al crear el registro, verifique e intente nuevamente!', 'warning');
                                    }
                                } else {
                                    Flasher::new('¡Problemas al validar el usuario, verifique e intente nuevamente!', 'warning');
                                }
                            } else {
                                Flasher::new('¡Para continuar con el proceso de recuperación de contraseña, por favor siga las instrucciones enviadas al correo registrado!', 'success');
                            }
                        } else {
                            //Correo no encontrado o usuario inactivo
                            Flasher::new('¡Por favor valide el Captcha, verifique e intente nuevamente!', 'warning');
                        }
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                }
            }

            $data = [
                'resultado_registros' => $resparametro,
                'resultado_registros_logo' => $resparametrologo,
            ];
            
            View::render('forgot_password', $data);
        }

        function recovery_password($id_usuario, $id_token) {
            Controller::checkSesionIndex();
            $modulo_plataforma=1;
            $parametro = new parametroModel();
            $parametro->app_id = 'login';
            $resparametro = $parametro->listDetail();
            $parametro->app_id = 'logo';
            $resparametrologo = $parametro->listDetail();

            $id_usuario=checkInput(base64_decode($id_usuario));
            $id_token=checkInput(base64_decode($id_token));
            $token = new tokenModel();
            $token->aut_usuario=$id_usuario;
            $token->aut_token=$id_token;
            $token->aut_expira=now();
            $res_token = $token->validate();

            if (!isset($res_token[0])) {
                $res_token=array();
            }

            if (count($res_token)>0) {
                $valida_token=1;
                if(isset($_POST["form_recovery"])){
                    if (!isset($_POST['form_token'], $_SESSION['iqvive_token']) || 
                        !hash_equals($_SESSION['iqvive_token'], $_POST['form_token'])) {
                        Flasher::new('¡Error al validar el token, por favor intente nuevamente!', 'warning');
                    } else {
                        //obtiene variable usuario
                        $password_1=checkInput($_POST['password_1']);
                        $password_2=checkInput($_POST['password_2']);
                        try {
                            if($_SESSION[APP_SESSION.'_recovery_registro_creado']!=1) {
                                if ($password_1==$password_2) {
                                    $user = new usuarioModel();
                                    $user->usu_id=$token->aut_usuario;

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
                        
                                    // Lista de caracteres especiales permitidos
                                    $caracteres_especiales = "~!#¡$&%^*+=\-\[\];,./{}()_|\\:>";

                                    // Asegura que la variable solo contenga caracteres permitidos en la expresión regular
                                    if (preg_match('/[' . preg_quote($caracteres_especiales, '/') . ']/', $password_1)) {
                                        
                                    } else {
                                        $estado_valida_password=0;
                                    }
                        
                                    if ($estado_valida_password) {
                                        //CONSULTA EN HISTORIAL DE CONTRASEÑAS PARA VALIDAR QUE NO SEA IGUAL A LA ULTIMA
                                        $pass = new passwordModel();
                                        $pass->auc_usuario = $user->usu_id;
                                        $respass = $pass->listRecovery();

                                        if (!isset($respass[0])) {
                                            $respass=array();
                                        }

                                        $control_historial=0;
                                        for ($i=0; $i < count($respass); $i++) { 
                                            if (crypt($password_1, $respass[$i]['auc_contrasena']) == $respass[$i]['auc_contrasena']) {
                                                $control_historial=1;
                                            }
                                        }

                                        if ($control_historial) {
                                            Flasher::new('¡Contraseña usada recientemente, verifique e intente nuevamente!', 'warning');
                                        } else {
                                            $salt = substr(base64_encode(openssl_random_pseudo_bytes('30')), 0, 22);
                                            $salt = strtr($salt, array('+' => '.'));
                                            $contrasena_guardar = crypt($password_1, '$2y$10$' . $salt);
                                            
                                            $user->usu_contrasena=$contrasena_guardar;
                                            $user->usu_actualiza_fecha=date('Y-m-d H:i:s');
                                            $resUpdatePass = $user->updatePassword();

                                            $log = new logModel();
                                            $log->clog_log_modulo='Recovery password';
                                            $log->clog_user_agent=checkInput($_SERVER['HTTP_USER_AGENT']);
                                            $log->clog_remote_addr=checkInput($_SERVER['REMOTE_ADDR']);
                                            $log->clog_script=checkInput($_SERVER['PHP_SELF']);
                                            $log->clog_registro_usuario=$user->usu_id;
                                            
                                            if ($resUpdatePass) {
                                                $log->clog_log_tipo='password_update';
                                                $log->clog_log_accion='Contraseña Actualizada';
                                                $log->clog_log_detalle='Contraseña actualizada proceso actualización de contraseña';
                                                $log->add();
                                            } else {
                                                $log->clog_log_tipo='password_update_error';
                                                $log->clog_log_accion='Contraseña Actualizada';
                                                $log->clog_log_detalle='Error contraseña actualizada proceso actualización de contraseña';
                                                $log->add();
                                            }
                                            
                                            if ($resUpdatePass) {
                                                Flasher::new('¡Contraseña actualizada exitosamente!', 'success');
                                                $_SESSION[APP_SESSION.'_recovery_registro_creado']=1;
                                                $pass->auc_contrasena = $contrasena_guardar;
                                                $respassadd = $pass->add();

                                                if ($respassadd) {
                                                    $log->clog_log_tipo='password_register';
                                                    $log->clog_log_accion='Contraseña Registrada';
                                                    $log->clog_log_detalle='Contraseña registrada proceso actualización de contraseña';
                                                    $log->add();

                                                    //Obtiene datos del usuario
                                                    $res = $user->listDetail();

                                                    if (!isset($res[0])) {
                                                        $res=array();
                                                    }

                                                    //Programa notificación confirmación actualización de contraseña
                                                    $notificacion = new notificacionModel();
                                                    $boton_titulo='Ir a '.APP_NAME;
                                                    $boton_url=URL;
                                                    //PROGRAMACIÓN NOTIFICACIÓN
                                                        $contenido="<p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Sr(a) ".$res[0]['usu_nombres_apellidos']."<br><br>Su cambio de contraseña se ha realizado de manera exitosa.</p>
                                                            <br>
                                                            <br>
                                                            <center>
                                                                <a href='".$boton_url."' target='_blank' style='border-radius:4px; color:#ffffff; font-size:12px; padding: 5px 5px 5px 5px; text-align:center; text-decoration:none !important; width:50%; display: block; background-color: ".COLOR_PRINCIPAL."'>".$boton_titulo."</a>
                                                            </center>
                                                            <br>";
                                                    /*SE CONFIGURAN PARÁMETROS A REGISTRAR EN SISTEMA DE NOTIFICACIÓN*/
                                                    $notificacion->nc_id_modulo=0;
                                                    $notificacion->nc_address=$res[0]['usu_correo_corporativo'].';';
                                                    $notificacion->nc_subject="Contraseña Actualizada - ".APP_NAME;
                                                    $notificacion->nc_body=notificacion_credenciales($contenido, $boton_titulo, $boton_url);
                                                    $notificacion->nc_embeddedimage_ruta=BASEPATH_IMAGE.LOGO_NOTIFICACION;
                                                    $notificacion->nc_embeddedimage_nombre="logo_notificacion";
                                                    $notificacion->nc_embeddedimage_tipo="image/png";
                                                    $notificacion->nc_usuario_registro=checkInput($res[0]['usu_id']);
                                                    $res_insert_notificacion = $notificacion->add();

                                                    if ($res_insert_notificacion) {
                                                        $log->clog_log_tipo='notificacion_programada';
                                                        $log->clog_log_accion='Notificación';
                                                        $log->clog_log_detalle='Programación notificación proceso actualización de contraseña';
                                                        $log->add();
                                                    } else {
                                                        $log->clog_log_tipo='notificacion_programada_error';
                                                        $log->clog_log_accion='Notificación';
                                                        $log->clog_log_detalle='Error en programación notificación proceso actualización de contraseña';
                                                        $log->add();
                                                    }

                                                    //Iniciar sesión con datos del usuario y redireccionar a inicio
                                                    $control_login=false;

                                                    if (count($res)>0) {
                                                        $log = new logModel();
                                                        $log->clog_log_modulo='Login';
                                                        $log->clog_user_agent=checkInput($_SERVER['HTTP_USER_AGENT']);
                                                        $log->clog_remote_addr=checkInput($_SERVER['REMOTE_ADDR']);
                                                        $log->clog_script=checkInput($_SERVER['PHP_SELF']);
                                                        $log->clog_registro_usuario=$res[0]['usu_id'];
                                                        
                                                        $parametro = new parametroModel();
                                                        $parametro->app_id = 'login';
                                                        $resparametro = $parametro->listDetail();
                                                        $parametro->app_id = 'logo';
                                                        $resparametrologo = $parametro->listDetail();
                                                        $parametro->app_id = 'inicio';
                                                        $resparametroinicio = $parametro->listDetail();

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
                                                        $_SESSION[APP_SESSION.'param_logo_image']=IMAGES.$resparametrologo[0]['app_imagen'];
                                                        $_SESSION[APP_SESSION.'param_inicio_image']=IMAGES.$resparametroinicio[0]['app_imagen'];

                                                        
                                                        $user->usu_id=$res[0]['usu_id'];
                                                        $user->usu_actualiza_login=now();
                                                        $user->updateLogin();

                                                        $log->clog_log_tipo='inicio_sesion';
                                                        $log->clog_log_accion='Inicio de sesión';
                                                        $log->clog_log_detalle='Inicio de sesión';
                                                        $log->add();

                                                        $control_login=true;
                                                    } else {
                                                        //Correo no encontrado o usuario inactivo
                                                        Flasher::new('¡Se ha presentado un error - usuario no encontrado, verifique e intente nuevamente!', 'danger');
                                                    }
                                                } else {
                                                    $log->clog_log_tipo='password_register_error';
                                                    $log->clog_log_accion='Contraseña Registrada';
                                                    $log->clog_log_detalle='Error contraseña registrada proceso actualización de contraseña';
                                                    $log->add();
                                                }
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
                }
            } else {
                $valida_token=0;
            }
            
            $data =
            [
                'valida_token' => $valida_token,
                'resultado_registros' => $resparametro,
                'resultado_registros_logo' => $resparametrologo,
                'control_login' => $control_login,
            ];
            
            View::render('recovery_password', $data);
        }

        function password_update() {
            Controller::checkSesionIndex();
            $modulo_plataforma=1;
            $parametro = new parametroModel();
            $parametro->app_id = 'login';
            $resparametro = $parametro->listDetail();
            $parametro->app_id = 'logo';
            $resparametrologo = $parametro->listDetail();
            if(isset($_POST["form_recovery"])){
                if (!isset($_POST['form_token'], $_SESSION['iqvive_token']) || 
                    !hash_equals($_SESSION['iqvive_token'], $_POST['form_token'])) {
                    Flasher::new('¡Error al validar el token, por favor intente nuevamente!', 'warning');
                } else {
                    //obtiene variable usuario
                    $password_1=checkInput($_POST['password_1']);
                    $password_2=checkInput($_POST['password_2']);
                    try {
                        if($_SESSION[APP_SESSION.'_update_registro_creado']!=1) {
                            if ($password_1==$password_2) {
                                $user = new usuarioModel();
                                $user->usu_id=$_SESSION[APP_SESSION.'usu_id'];

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
                    
                                // Lista de caracteres especiales permitidos
                                $caracteres_especiales = "~!#¡$&%^*+=\-\[\];,./{}()_|\\:>";

                                // Asegura que la variable solo contenga caracteres permitidos en la expresión regular
                                if (preg_match('/[' . preg_quote($caracteres_especiales, '/') . ']/', $password_1)) {
                                    
                                } else {
                                    $estado_valida_password=0;
                                }
                    
                                if ($estado_valida_password) {
                                    //CONSULTA EN HISTORIAL DE CONTRASEÑAS PARA VALIDAR QUE NO SEA IGUAL A LA ULTIMA
                                    $pass = new passwordModel();
                                    $pass->auc_usuario = $user->usu_id;
                                    $respass = $pass->listRecovery();

                                    if (!isset($respass[0])) {
                                        $respass=array();
                                    }

                                    $control_historial=0;
                                    for ($i=0; $i < count($respass); $i++) { 
                                        if (crypt($password_1, $respass[$i]['auc_contrasena']) == $respass[$i]['auc_contrasena']) {
                                            $control_historial=1;
                                        }
                                    }

                                    if ($control_historial) {
                                        Flasher::new('¡Contraseña usada recientemente, verifique e intente nuevamente!', 'warning');
                                    } else {
                                        $salt = substr(base64_encode(openssl_random_pseudo_bytes('30')), 0, 22);
                                        $salt = strtr($salt, array('+' => '.'));
                                        $contrasena_guardar = crypt($password_1, '$2y$10$' . $salt);
                                        
                                        $user->usu_contrasena=$contrasena_guardar;
                                        $user->usu_actualiza_fecha=date('Y-m-d H:i:s');
                                        $resUpdatePass = $user->updatePassword();

                                        $log = new logModel();
                                        $log->clog_log_modulo='Recovery password';
                                        $log->clog_user_agent=checkInput($_SERVER['HTTP_USER_AGENT']);
                                        $log->clog_remote_addr=checkInput($_SERVER['REMOTE_ADDR']);
                                        $log->clog_script=checkInput($_SERVER['PHP_SELF']);
                                        $log->clog_registro_usuario=$user->usu_id;
                                        
                                        if ($resUpdatePass) {
                                            $log->clog_log_tipo='password_update';
                                            $log->clog_log_accion='Contraseña Actualizada';
                                            $log->clog_log_detalle='Contraseña actualizada proceso actualización de contraseña expirada';
                                            $log->add();
                                        } else {
                                            $log->clog_log_tipo='password_update_error';
                                            $log->clog_log_accion='Contraseña Actualizada';
                                            $log->clog_log_detalle='Error contraseña actualizada proceso actualización de contraseña expirada';
                                            $log->add();
                                        }
                                        
                                        if ($resUpdatePass) {
                                            Flasher::new('¡Contraseña actualizada exitosamente!', 'success');
                                            $_SESSION[APP_SESSION.'_update_registro_creado']=1;
                                            $user->usu_inicio_sesion=1;
                                            $user->updateSession();

                                            $_SESSION[APP_SESSION.'usu_inicio_sesion']=1;
                                            
                                            $pass->auc_contrasena = $contrasena_guardar;
                                            $respassadd = $pass->add();

                                            if ($respassadd) {
                                                $log->clog_log_tipo='password_register';
                                                $log->clog_log_accion='Contraseña Registrada';
                                                $log->clog_log_detalle='Contraseña registrada proceso actualización de contraseña expirada';
                                                $log->add();
                                            } else {
                                                $log->clog_log_tipo='password_register_error';
                                                $log->clog_log_accion='Contraseña Registrada';
                                                $log->clog_log_detalle='Error contraseña registrada proceso actualización de contraseña expirada';
                                                $log->add();
                                            }
                                            
                                            $resusuario = $user->listDetail();
                        
                                            $notificacion = new notificacionModel();
                                            $boton_titulo='Ir a '.APP_NAME;
                                            $boton_url=URL;
                                            //PROGRAMACIÓN NOTIFICACIÓN
                                                $contenido="<p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Sr(a) ".$resusuario[0]['usu_nombres_apellidos']."<br><br>Su cambio de contraseña se ha realizado de manera exitosa.</p>
                                                    <br>
                                                    <br>
                                                    <center>
                                                        <a href='".$boton_url."' target='_blank' style='border-radius:4px; color:#ffffff; font-size:12px; padding: 5px 5px 5px 5px; text-align:center; text-decoration:none !important; width:50%; display: block; background-color: ".COLOR_PRINCIPAL."'>".$boton_titulo."</a>
                                                    </center>
                                                    <br>";
                                            /*SE CONFIGURAN PARÁMETROS A REGISTRAR EN SISTEMA DE NOTIFICACIÓN*/
                                            $notificacion->nc_id_modulo=0;
                                            $notificacion->nc_address=$resusuario[0]['usu_correo_corporativo'].';';
                                            $notificacion->nc_subject="Contraseña Actualizada - ".APP_NAME;
                                            $notificacion->nc_body=notificacion_credenciales($contenido, $boton_titulo, $boton_url);
                                            $notificacion->nc_embeddedimage_ruta=BASEPATH_IMAGE.LOGO_NOTIFICACION;
                                            $notificacion->nc_embeddedimage_nombre="logo_notificacion";
                                            $notificacion->nc_embeddedimage_tipo="image/png";
                                            $notificacion->nc_usuario_registro=checkInput($resusuario[0]['usu_id']);
                                            $res_insert_notificacion = $notificacion->add();
                                            
                                            if ($res_insert_notificacion) {
                                                $log->clog_log_tipo='notificacion_programada';
                                                $log->clog_log_accion='Notificación';
                                                $log->clog_log_detalle='Programación notificación proceso actualización de contraseña';
                                                $log->add();
                                                Redirect::to('inicio');
                                            } else {
                                                $log->clog_log_tipo='notificacion_programada_error';
                                                $log->clog_log_accion='Notificación';
                                                $log->clog_log_detalle='Error en programación notificación proceso actualización de contraseña';
                                                $log->add();
                                            }
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
            }

            $control_login=1;
            if (!isset($_SESSION[APP_SESSION.'usu_id'])) {
                $control_login=0;
                Flasher::new('¡No hemos encontrado una sesión activa, verifique e intente nuevamente!', 'warning');
            }

            $data =
            [
                'resultado_registros' => $resparametro,
                'resultado_registros_logo' => $resparametrologo,
                'control_login' => $control_login,
            ];
            
            View::render('update_password', $data);
        }
    }