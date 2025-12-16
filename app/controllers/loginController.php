<?php
class loginController extends Controller {

    public function __construct() {}

    private function csrfOk(): bool {
        return (
            isset($_POST['form_token'], $_SESSION['iqvive_token']) &&
            hash_equals($_SESSION['iqvive_token'], (string)$_POST['form_token'])
        );
    }

    private function recaptchaOk(string $response): bool {
        $response = checkInput($response);
        if ($response === '') return false;

        $url = 'https://www.google.com/recaptcha/api/siteverify';   
        $data = [
            'secret'   => '6LftzogoAAAAAKT8XIuZaRDE3GJn0pFvv7YXNL2I', 
            'response' => $response
        ];
        $options = [
            'http' => [
                'method'  => 'POST',
                'content' => http_build_query($data),
                'timeout' => 8,
            ]
        ];

        $context = stream_context_create($options);
        $verify  = @file_get_contents($url, false, $context);
        if ($verify === false) return false;

        $captcha_success = json_decode($verify);
        return (is_object($captcha_success) && !empty($captcha_success->success));
    }

    private function requireLogin(): void {
        if (!isset($_SESSION[APP_SESSION.'usu_id'])) {
            Redirect::to('login');
            exit;
        }
    }


    private function enforceSecurityQuestionAfterLogin(int $usuId): void {
        $sec = new usuarioSecurityModel();
        $sec->aus_usuario = $usuId;
        $r = $sec->getByUser();
        if (!isset($r[0])) $r = [];

        $needsSetup = false;

        if (count($r) === 0) {
            $needsSetup = true;
        } else {
            $qid  = $r[0]['aus_question_id'] ?? null;
            $hash = $r[0]['aus_answer_hash'] ?? null;
            if (empty($qid) || empty($hash)) $needsSetup = true;
        }

        if ($needsSetup) {
            $_SESSION[APP_SESSION.'_must_setup_security'] = 1;
            Redirect::to('login/security-setup');
            exit;
        }
    }


    public function index() {
        Controller::checkSesionIndex();

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

        if (isset($_POST["form_sing_in"])) {

            if (!$this->csrfOk()) {
                Flasher::new('¡Error al validar el token, por favor intente nuevamente!', 'warning');
            } else {

                $usuario  = checkInput($_POST['usuario'] ?? '');
                $password = checkInput($_POST['password'] ?? '');

                $recaptcha = (string)($_POST['g-recaptcha-response'] ?? '');
                $captchaOk = $this->recaptchaOk($recaptcha);

                try {
                    if (!$captchaOk) {
                        Flasher::new('¡Por favor valide el Captcha!', 'warning');
                    } elseif ($usuario === '' || $password === '') {
                        Flasher::new('¡Debe ingresar usuario y contraseña!', 'warning');
                    } else {

                        $user = new usuarioModel();
                        $user->usu_acceso = $usuario;
                        $user->usu_estado = 'Activo';
                        $res = $user->login(); 
                        if (!isset($res[0])) $res = [];

                        if (count($res) === 0) {
                            Flasher::new('¡Usuario o contraseña incorrectos!', 'warning');
                        } else {


                            if (!isset($_COOKIE['cin'])) {
                                setcookie('cin', 0, time() + 365 * 24 * 60 * 60);
                            }
                            setcookie('cin', ((int)$_COOKIE['cin']) + 1, time() + 365 * 24 * 60 * 60);

                            $log = new logModel();
                            $log->clog_log_modulo = 'Login';
                            $log->clog_user_agent = checkInput($_SERVER['HTTP_USER_AGENT'] ?? '');
                            $log->clog_remote_addr = checkInput($_SERVER['REMOTE_ADDR'] ?? '');
                            $log->clog_script = checkInput($_SERVER['PHP_SELF'] ?? '');
                            $log->clog_registro_usuario = $res[0]['usu_id'];

                            if (crypt($password, $res[0]['usu_contrasena']) == $res[0]['usu_contrasena']) {


                                unset($_COOKIE['cin']);
                                setcookie('cin', 0, 0);

                                $_SESSION[APP_SESSION.'usu_id'] = (int)$res[0]['usu_id'];
                                $_SESSION[APP_SESSION.'usu_documento'] = $res[0]['usu_documento'] ?? '';
                                $_SESSION[APP_SESSION.'usu_acceso'] = $res[0]['usu_acceso'] ?? '';
                                $_SESSION[APP_SESSION.'usu_nombres_apellidos'] = $res[0]['usu_nombres_apellidos'] ?? '';
                                $_SESSION[APP_SESSION.'usu_correo'] = $res[0]['usu_correo'] ?? '';
                                $_SESSION[APP_SESSION.'usu_correo_corporativo'] = $res[0]['usu_correo_corporativo'] ?? '';
                                $_SESSION[APP_SESSION.'usu_area'] = $res[0]['usu_area'] ?? '';
                                $_SESSION[APP_SESSION.'usu_cargo'] = $res[0]['usu_cargo'] ?? '';
                                $_SESSION[APP_SESSION.'usu_ciudad'] = $res[0]['usu_ciudad'] ?? '';
                                $_SESSION[APP_SESSION.'usu_estado'] = $res[0]['usu_estado'] ?? '';
                                $_SESSION[APP_SESSION.'usu_inicio_sesion'] = $res[0]['usu_inicio_sesion'] ?? '';
                                $_SESSION[APP_SESSION.'usu_avatar'] = $res[0]['usu_avatar'] ?? '';
                                $_SESSION[APP_SESSION.'usu_perfil'] = $res[0]['usu_perfil'] ?? '';
                                $_SESSION[APP_SESSION.'usu_actualiza_login'] = $res[0]['usu_actualiza_login'] ?? '';
                                $_SESSION[APP_SESSION.'aa_nombre'] = $res[0]['aa_nombre'] ?? '';
                                $_SESSION[APP_SESSION.'ac_nombre'] = $res[0]['ac_nombre'] ?? '';

                                $this->enforceSecurityQuestionAfterLogin((int)$res[0]['usu_id']);

                                Redirect::to('inicio');
                                exit;

                            } else {
                                Flasher::new('¡Usuario o contraseña incorrectos!', 'warning');
                            }
                        }
                    }
                } catch (Exception $e) {
                    Flasher::new('¡Error interno en autenticación!', 'warning');
                }
            }
        }

        $data = [
            'resultado_registros' => $resparametro,
            'resultado_registros_logo' => $resparametrologo,
            'resultado_registros_inicio' => $resparametroinicio,
        ];

        View::render('login', $data);
    }

    public function security_setup() {
        $this->requireLogin();

        $mQ = new securityQuestionModel();
        $questions = $mQ->listActive();
        if (!is_array($questions)) {
            $questions = [];
        }

        if (isset($_POST['form_security_setup'])) {

            if (!$this->csrfOk()) {
                Flasher::new('¡Error al validar el token, por favor intente nuevamente!', 'warning');
            } else {

                $questionId     = (int)($_POST['asq_id'] ?? 0);
                $customQuestion = trim((string)($_POST['custom_question'] ?? ''));
                $answerRaw      = trim((string)($_POST['asq_answer'] ?? ''));

                if ($questionId === 0) {
                    Flasher::new('¡Debe seleccionar una pregunta!', 'warning');

                } elseif ($questionId === -1 && $customQuestion === '') {
                    Flasher::new('¡Debe escribir su pregunta personalizada!', 'warning');

                } elseif ($answerRaw === '') {
                    Flasher::new('¡Debe escribir la respuesta!', 'warning');

                } else {

                    if ($questionId === -1) {
                        $sql = "INSERT INTO app_security_questions (asq_question, asq_estado)
                                VALUES (:q, 'Activo')";
                        $ok = (new securityQuestionModel())->query($sql, [
                            'q' => $customQuestion
                        ]);

                        if (!$ok) {
                            Flasher::new('¡No se pudo guardar la pregunta personalizada!', 'warning');
                            $questionId = 0;
                        } else {
                            $last = (new securityQuestionModel())->query(
                                "SELECT LAST_INSERT_ID() AS id",
                                []
                            );
                            $questionId = (int)($last[0]['id'] ?? 0);
                        }
                    }

                    if ($questionId > 0) {
                        $answerHash = password_hash($answerRaw, PASSWORD_DEFAULT);

                        $sec = new usuarioSecurityModel();
                        $sec->aus_usuario      = (int)$_SESSION[APP_SESSION.'usu_id'];
                        $sec->aus_question_id  = $questionId;
                        $sec->aus_answer_hash  = $answerHash;

                        if ($sec->upsert()) {
                            unset($_SESSION[APP_SESSION.'_must_setup_security']);
                            Flasher::new('¡Pregunta de seguridad configurada exitosamente!', 'success');
                            Redirect::to('inicio');
                            exit;
                        } else {
                            Flasher::new('¡No fue posible guardar la configuración!', 'warning');
                        }
                    }
                }
            }
        }

        View::render('security_setup', [
            'questions' => $questions
        ]);
    }


    public function recovery_by_security() {
        Controller::checkSesionIndex();

        $parametro = new parametroModel();
        $parametro->app_id = 'login';
        $resparametro = $parametro->listDetail();

        $parametro->app_id = 'logo';
        $resparametrologo = $parametro->listDetail();

        if (isset($_POST['form_recovery_security_start'])) {

            if (!$this->csrfOk()) {
                Flasher::new('¡Error al validar el token, por favor intente nuevamente!', 'warning');
            } else {

                $correo = checkInput($_POST['correo'] ?? '');
                $recaptcha = (string)($_POST['g-recaptcha-response'] ?? '');
                $captchaOk = $this->recaptchaOk($recaptcha);

                if ($correo === '') {
                    Flasher::new('¡Debe ingresar su correo corporativo!', 'warning');
                } elseif (!$captchaOk) {
                    Flasher::new('¡Por favor valide el Captcha!', 'warning');
                } else {

                    $user = new usuarioModel();
                    $user->usu_correo_corporativo = $correo;
                    $user->usu_estado = 'Retirado';
                    $resusuario = $user->userRecovery();
                    if (!isset($resusuario[0])) $resusuario = [];

                    if (count($resusuario) === 0) {
                        Flasher::new('¡Si el usuario existe, podrá continuar con la validación!', 'success');
                    } else {
                        $_SESSION[APP_SESSION.'_recovery_security_user'] = (int)$resusuario[0]['usu_id'];
                        unset($_SESSION[APP_SESSION.'_security_verified_for_reset']);
                        Redirect::to('login/security-verify');
                        exit;
                    }
                }
            }
        }

        $data = [
            'resultado_registros' => $resparametro,
            'resultado_registros_logo' => $resparametrologo,
        ];
        View::render('recovery_by_security', $data);
    }


    public function security_verify() {
        Controller::checkSesionIndex();

        $parametro = new parametroModel();
        $parametro->app_id = 'login';
        $resparametro = $parametro->listDetail();

        $parametro->app_id = 'logo';
        $resparametrologo = $parametro->listDetail();

        $usuId = (int)($_SESSION[APP_SESSION.'_recovery_security_user'] ?? 0);
        if ($usuId <= 0) {
            Redirect::to('login/recovery-by-security');
            exit;
        }


        $sec = new usuarioSecurityModel();
        $sec->aus_usuario = $usuId;
        $qdata = $sec->getQuestionByUser();
        if (!isset($qdata[0])) $qdata = [];

        if (count($qdata) === 0) {
            Flasher::new('¡El usuario no tiene pregunta de seguridad configurada!', 'warning');
            Redirect::to('login/recovery-by-security');
            exit;
        }

        $lockedUntil = $qdata[0]['aus_locked_until'] ?? null;
        $locked = (!empty($lockedUntil) && strtotime($lockedUntil) > time());

        if (isset($_POST['form_security_verify'])) {

            if (!$this->csrfOk()) {
                Flasher::new('¡Error al validar el token, por favor intente nuevamente!', 'warning');

            } elseif ($locked) {
                Flasher::new('¡Demasiados intentos! Intente más tarde.', 'warning');

            } else {

                $answerRaw = trim((string)($_POST['asq_answer'] ?? ''));

                if ($answerRaw === '') {
                    Flasher::new('¡Debe ingresar la respuesta!', 'warning');
                } else {

                    $sec2 = new usuarioSecurityModel();
                    $sec2->aus_usuario = $usuId;
                    $r = $sec2->getByUser();
                    if (!isset($r[0])) $r = [];

                    if (count($r) === 0) {
                        Flasher::new('¡No fue posible validar la información!', 'warning');
                        Redirect::to('login/recovery-by-security');
                        exit;
                    }

                    $hash = (string)($r[0]['aus_answer_hash'] ?? '');
                    $attempts = (int)($r[0]['aus_attempts'] ?? 0);

                    if ($hash === '') {
                        Flasher::new('¡El usuario no tiene respuesta de seguridad registrada!', 'warning');
                        Redirect::to('login/recovery-by-security');
                        exit;
                    }

                    if (!password_verify($answerRaw, $hash)) {
                        $attempts++;

                        $lock = null;
                        if ($attempts >= 5) {
                            $lock = date('Y-m-d H:i:s', strtotime('+10 minutes'));
                        }

                        $sec2->setAttemptsAndLock($attempts, $lock);

                        Flasher::new('¡Respuesta incorrecta!', 'warning');
                    } else {
                        $sec2->setAttemptsAndLock(0, null);

                        $_SESSION[APP_SESSION.'_security_verified_for_reset'] = 1;

                        Redirect::to('login/recovery-password-security');
                        exit;
                    }
                }
            }
        }

        // Render
        $data = [
            'resultado_registros' => $resparametro,
            'resultado_registros_logo' => $resparametrologo,
            'question' => $qdata[0],
            'locked' => $locked,
        ];
        View::render('security_verify', $data);
    }


    public function recovery_password_security() {
        Controller::checkSesionIndex();

        $parametro = new parametroModel();
        $parametro->app_id = 'login';
        $resparametro = $parametro->listDetail();

        $parametro->app_id = 'logo';
        $resparametrologo = $parametro->listDetail();

        $usuId = (int)($_SESSION[APP_SESSION.'_recovery_security_user'] ?? 0);
        $verified = (int)($_SESSION[APP_SESSION.'_security_verified_for_reset'] ?? 0);

        if ($usuId <= 0 || $verified !== 1) {
            Redirect::to('login/recovery-by-security');
            exit;
        }

        if (isset($_POST['form_update_password_security'])) {

            if (!$this->csrfOk()) {
                Flasher::new('¡Error al validar el token, por favor intente nuevamente!', 'warning');

            } else {

                $p1 = (string)($_POST['new_password'] ?? '');
                $p2 = (string)($_POST['confirm_password'] ?? '');

                $p1 = trim($p1);
                $p2 = trim($p2);

                if ($p1 === '' || $p2 === '') {
                    Flasher::new('¡Debe completar los campos de contraseña!', 'warning');

                } elseif ($p1 !== $p2) {
                    Flasher::new('¡Las contraseñas no coinciden!', 'warning');

                } elseif (strlen($p1) < 8) {
                    Flasher::new('¡La contraseña debe tener mínimo 8 caracteres!', 'warning');

                } else {

                    $hasLower = preg_match('/[a-z]/', $p1);
                    $hasUpper = preg_match('/[A-Z]/', $p1);
                    $hasNum   = preg_match('/[0-9]/', $p1);
                    $hasSpec  = preg_match('/[~!#¡$&%\^*\+=\-\[\];,\.\/\{\}\(\)_\|:>]/', $p1);

                    if (!$hasLower || !$hasUpper || !$hasNum || !$hasSpec) {
                        Flasher::new('¡La contraseña no cumple los requisitos mínimos!', 'warning');
                    } else {

                        $salt = substr(base64_encode(openssl_random_pseudo_bytes(30)), 0, 22);
                        $salt = strtr($salt, ['+' => '.']);
                        $hash = crypt($p1, '$2y$10$' . $salt);

                        $u = new usuarioModel();
                        $u->usu_id = $usuId;
                        $u->usu_contrasena = $hash;
                        $u->usu_actualiza_fecha = date('Y-m-d H:i:s');

                        if ($u->updatePassword()) {

                            // limpiar sesión del flujo
                            unset($_SESSION[APP_SESSION.'_recovery_security_user']);
                            unset($_SESSION[APP_SESSION.'_security_verified_for_reset']);

                            Flasher::new('¡Contraseña actualizada exitosamente!', 'success');
                            Redirect::to('login');
                            exit;

                        } else {
                            Flasher::new('¡No fue posible actualizar la contraseña!', 'warning');
                        }
                    }
                }
            }
        }

        $data = [
            'resultado_registros' => $resparametro,
            'resultado_registros_logo' => $resparametrologo,
        ];

        View::render('recovery_password_security', $data);
    }


    public function forgot_password() {
        Redirect::to('login/recovery-by-security');
        exit;
    }

    public function logout() {
        session_destroy();
        Redirect::to('login');
        exit;
    }
}
