<?php

class loginController extends Controller
{
    private const SECURITY_MAX_ATTEMPTS = 5;
    private const SECURITY_LOCK_MINUTES = 10;

    private const ROUTE_HOME       = 'inicio';
    private const ROUTE_LOGIN      = 'login';
    private const ROUTE_SEC_SETUP  = 'login/security-setup';
    private const ROUTE_PASS_UPD   = 'login/password-update';
    private const ROUTE_REC_START  = 'login/recovery-by-security';
    private const ROUTE_SEC_VERIFY = 'login/security-verify';
    private const ROUTE_REC_UPDATE = 'login/recovery-password-security';

    public function __construct() {}

    /* =========================
     * HELPERS
     * ========================= */

    private function csrfOk(): bool
    {
        return (
            isset($_POST['form_token'], $_SESSION['iqvive_token']) &&
            hash_equals((string)$_SESSION['iqvive_token'], (string)$_POST['form_token'])
        );
    }

    private function recaptchaOk(string $response): bool
    {
        $response = checkInput($response);
        if ($response === '') return false;

        $secret = defined('RECAPTCHA_SECRET')
            ? (string)RECAPTCHA_SECRET
            : '6LftzogoAAAAAKT8XIuZaRDE3GJn0pFvv7YXNL2I';

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret'   => $secret,
            'response' => $response
        ];

        $options = [
            'http' => [
                'method'  => 'POST',
                'content' => http_build_query($data),
                'timeout' => 8,
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n"
            ]
        ];

        $context = stream_context_create($options);
        $verify  = @file_get_contents($url, false, $context);
        if ($verify === false) return false;

        $captcha = json_decode($verify);
        return (is_object($captcha) && !empty($captcha->success));
    }

    private function requireLogin(): void
    {
        if (!isset($_SESSION[APP_SESSION.'usu_id'])) {
            Redirect::to(self::ROUTE_LOGIN);
            exit;
        }
    }

    private function passwordOk(string $plain, string $storedHash): bool
    {
        $plain = (string)$plain;
        $storedHash = (string)$storedHash;
        if ($storedHash === '') return false;

        if (preg_match('/^\$2[aby]\$/', $storedHash)) {
            if (password_verify($plain, $storedHash)) return true;
        }

        return hash_equals(crypt($plain, $storedHash), $storedHash);
    }

    private function hasSecurityQuestion(int $usuId): bool
    {
        $sec = new usuarioSecurityModel();
        $sec->aus_usuario = $usuId;
        $r = $sec->getByUser();
        return isset($r[0]);
    }

    private function mustUpdatePassword(): bool
    {
        return ((int)($_SESSION[APP_SESSION.'usu_inicio_sesion'] ?? 0) !== 1);
    }

    private function redirectAfterLogin(): void
    {
        $usuId = (int)($_SESSION[APP_SESSION.'usu_id'] ?? 0);
        if ($usuId <= 0) {
            Redirect::to(self::ROUTE_LOGIN);
            exit;
        }

        $hasSecurity = $this->hasSecurityQuestion($usuId);
        $mustUpdate  = $this->mustUpdatePassword();

        if (!$hasSecurity) {
            $_SESSION[APP_SESSION.'_must_setup_security'] = 1;
            Redirect::to(self::ROUTE_SEC_SETUP);
            exit;
        }

        unset($_SESSION[APP_SESSION.'_must_setup_security']);

        if ($mustUpdate) {
            Redirect::to(self::ROUTE_PASS_UPD);
            exit;
        }

        Redirect::to(self::ROUTE_HOME);
        exit;
    }

    /* =========================
     * LOGIN
     * ========================= */

    public function index()
    {
        Controller::checkSesionIndex();


        // ✅ Genera token CSRF si no existe
        if (empty($_SESSION['iqvive_token'])) {
            $_SESSION['iqvive_token'] = bin2hex(random_bytes(32));
        }


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



        // DEBUG TEMPORAL - quitar después
        error_log('SESSION al entrar a index: ' . print_r($_SESSION, true));
        error_log('POST keys: ' . implode(', ', array_keys($_POST)));
        if (isset($_POST["form_sing_in"])) {

            if (!$this->csrfOk()) {
                Flasher::new('¡Error al validar el token, por favor intente nuevamente!', 'warning');

            } else {

                $usuario  = checkInput($_POST['usuario'] ?? '');
                $password = checkInput($_POST['password'] ?? '');

                // ✅ CAPTCHA DESHABILITADO
                $captchaOk = true;

                try {

                    if ($usuario === '' || $password === '') {
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
                            setcookie('cin', ((int)($_COOKIE['cin'] ?? 0)) + 1, time() + 365 * 24 * 60 * 60);

                            $log = new logModel();
                            $log->clog_log_modulo = 'Login';
                            $log->clog_user_agent = checkInput($_SERVER['HTTP_USER_AGENT'] ?? '');
                            $log->clog_remote_addr = checkInput($_SERVER['REMOTE_ADDR'] ?? '');
                            $log->clog_script = checkInput($_SERVER['PHP_SELF'] ?? '');
                            $log->clog_registro_usuario = $res[0]['usu_id'];

                            if ($this->passwordOk($password, (string)($res[0]['usu_contrasena'] ?? ''))) {

                                unset($_COOKIE['cin']);
                                setcookie('cin', 0, 0);

                                $_SESSION[APP_SESSION.'usu_id'] = (int)$res[0]['usu_id'];
                                $_SESSION[APP_SESSION.'usu_aspirante_id'] = (int)($res[0]['usu_aspirante_id'] ?? $res[0]['usu_id']);
                                $_SESSION[APP_SESSION.'usu_documento'] = $res[0]['usu_documento'] ?? '';
                                $_SESSION[APP_SESSION.'usu_acceso'] = $res[0]['usu_acceso'] ?? '';
                                $_SESSION[APP_SESSION.'usu_nombre'] = $res[0]['usu_nombres_apellidos'] ?? '';
                                $_SESSION[APP_SESSION.'usu_nombres_apellidos'] = $res[0]['usu_nombres_apellidos'] ?? '';
                                $_SESSION[APP_SESSION.'usu_jefe_inmediato'] = $res[0]['usu_jefe_inmediato'] ?? '';

                                $_SESSION[APP_SESSION.'usu_correo'] = $res[0]['usu_correo'] ?? '';
                                $_SESSION[APP_SESSION.'usu_correo_corporativo'] = $res[0]['usu_correo_corporativo'] ?? '';

                                $_SESSION[APP_SESSION.'usu_area'] = $res[0]['usu_area'] ?? '';
                                $_SESSION[APP_SESSION.'usu_cargo'] = $res[0]['ac_nombre'] ?? ($res[0]['usu_cargo'] ?? '');
                                $_SESSION[APP_SESSION.'ac_nombre'] = $res[0]['ac_nombre'] ?? '';
                                $_SESSION[APP_SESSION.'aa_nombre'] = $res[0]['aa_nombre'] ?? '';

                                $ciu = '';
                                if (!empty($res[0]['ciu_municipio'] ?? '') && !empty($res[0]['ciu_departamento'] ?? '')) {
                                    $ciu = ($res[0]['ciu_municipio'] ?? '') . ', ' . ($res[0]['ciu_departamento'] ?? '');
                                } else {
                                    $ciu = $res[0]['usu_ciudad'] ?? '';
                                }
                                $_SESSION[APP_SESSION.'usu_ciudad'] = $ciu;

                                $_SESSION[APP_SESSION.'usu_token'] = $res[0]['usu_token'] ?? '';
                                $_SESSION[APP_SESSION.'usu_avatar'] = $res[0]['usu_avatar'] ?? '';
                                $_SESSION[APP_SESSION.'usu_estado'] = $res[0]['usu_estado'] ?? '';
                                $_SESSION[APP_SESSION.'usu_inicio_sesion'] = (int)($res[0]['usu_inicio_sesion'] ?? 0);
                                $_SESSION[APP_SESSION.'usu_perfil'] = $res[0]['usu_perfil'] ?? '';
                                $_SESSION[APP_SESSION.'usu_actualiza_login'] = $res[0]['usu_actualiza_login'] ?? '';

                                if (isset($resparametro[0]['app_imagen'])) {
                                    $_SESSION[APP_SESSION.'param_login_image'] = IMAGES.$resparametro[0]['app_imagen'];
                                }
                                if (isset($resparametrologo[0]['app_imagen'])) {
                                    $_SESSION[APP_SESSION.'param_logo_image'] = IMAGES.$resparametrologo[0]['app_imagen'];
                                }
                                if (isset($resparametroinicio[0]['app_imagen'])) {
                                    $_SESSION[APP_SESSION.'param_inicio_image'] = IMAGES.$resparametroinicio[0]['app_imagen'];
                                }

                                $user->usu_id = (int)$res[0]['usu_id'];
                                $user->usu_actualiza_login = date('Y-m-d H:i:s');
                                $user->updateLogin();

                                $log->clog_log_tipo = 'inicio_sesion';
                                $log->clog_log_accion = 'Inicio de sesión';
                                $log->clog_log_detalle = 'Inicio de sesión';
                                $log->add();

                                $pass = new passwordModel();
                                $pass->auc_usuario = (int)$_SESSION[APP_SESSION.'usu_id'];
                                $respass = $pass->list();
                                if (!isset($respass[0])) $respass = [];

                                if (count($respass) > 0) {
                                    $fecha_control = date("Y-m-d", strtotime("+ 60 day", strtotime($respass[0]['auc_registro_fecha'])));
                                    if (date('Y-m-d') >= $fecha_control) {
                                        $_SESSION[APP_SESSION.'usu_inicio_sesion'] = 0;

                                        $log->clog_log_tipo = 'password_expirada';
                                        $log->clog_log_accion = 'Contraseña expirada';
                                        $log->clog_log_detalle = 'Contraseña expirada';
                                        $log->add();
                                    }
                                }

                                $this->redirectAfterLogin();

                            } else {
                                Flasher::new('¡Usuario o contraseña incorrectos!', 'warning');
                            }
                        }
                    }

                } catch (Exception $e) {
                    Flasher::new(
                        'Error: ' . $e->getMessage() . 
                        ' | Línea: ' . $e->getLine() . 
                        ' | Archivo: ' . basename($e->getFile()), 
                        'warning'
                    );
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

    /* =========================
     * SECURITY SETUP
     * ========================= */

    public function security_setup()
    {
        $this->requireLogin();

        $usuId = (int)$_SESSION[APP_SESSION.'usu_id'];
        $hasSecurity = $this->hasSecurityQuestion($usuId);

        if ($hasSecurity) {
            unset($_SESSION[APP_SESSION.'_must_setup_security']);

            if ($this->mustUpdatePassword()) {
                Redirect::to(self::ROUTE_PASS_UPD);
                exit;
            }

            Redirect::to(self::ROUTE_HOME);
            exit;
        }

        $mQ = new securityQuestionModel();
        $questions = $mQ->listActive();
        if (!is_array($questions)) $questions = [];

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

                } elseif ($questionId === -1 && mb_strlen($customQuestion, 'UTF-8') > 200) {
                    Flasher::new('¡La pregunta personalizada no puede superar 200 caracteres!', 'warning');

                } elseif ($answerRaw === '') {
                    Flasher::new('¡Debe escribir la respuesta!', 'warning');

                } else {

                    if ($questionId === -1) {
                        $customQuestionSafe = checkInput($customQuestion);

                        $sql = "INSERT INTO app_security_questions (asq_question, asq_estado)
                                VALUES (:q, 'Activo')";
                        $ok = (new securityQuestionModel())->query($sql, ['q' => $customQuestionSafe]);

                        if (!$ok) {
                            Flasher::new('¡No se pudo guardar la pregunta personalizada!', 'warning');
                            $questionId = 0;
                        } else {
                            $last = (new securityQuestionModel())->query("SELECT LAST_INSERT_ID() AS id", []);
                            $questionId = (int)($last[0]['id'] ?? 0);
                        }
                    }

                    if ($questionId > 0) {

                        $answerHash = password_hash($answerRaw, PASSWORD_BCRYPT, ['cost' => 12]);

                        $sec = new usuarioSecurityModel();
                        $sec->aus_usuario     = $usuId;
                        $sec->aus_question_id = $questionId;
                        $sec->aus_answer_hash = $answerHash;

                        if ($sec->upsert()) {

                            unset($_SESSION[APP_SESSION.'_must_setup_security']);
                            Flasher::new('¡Pregunta de seguridad configurada exitosamente!', 'success');

                            if ($this->mustUpdatePassword()) {
                                Redirect::to(self::ROUTE_PASS_UPD);
                                exit;
                            }

                            Redirect::to(self::ROUTE_HOME);
                            exit;

                        } else {
                            Flasher::new('¡No fue posible guardar la configuración!', 'warning');
                        }
                    }
                }
            }
        }

        View::render('security_setup', ['questions' => $questions]);
    }

    /* =========================
     * PASSWORD UPDATE
     * ========================= */

    public function password_update()
    {
        $this->requireLogin();

        $control_login = $this->mustUpdatePassword();
        $control_login_sesion = !$control_login;

        if (isset($_POST["form_recovery"]) && $control_login) {

            if (!$this->csrfOk()) {
                Flasher::new('¡Error al validar el token, por favor intente nuevamente!', 'warning');

            } else {

                $password_1 = checkInput($_POST['password_1'] ?? '');
                $password_2 = checkInput($_POST['password_2'] ?? '');

                if ($password_1 === '' || $password_2 === '') {
                    Flasher::new('¡Debe ingresar la nueva contraseña y su confirmación!', 'warning');

                } elseif ($password_1 !== $password_2) {
                    Flasher::new('¡Las contraseñas no coinciden!', 'warning');

                } else {

                    $ok = true;

                    if (strlen($password_1) < 8) $ok = false;
                    if (!preg_match('/[A-Z]/', $password_1)) $ok = false;
                    if (!preg_match('/[a-z]/', $password_1)) $ok = false;
                    if (!preg_match('/[0-9]/', $password_1)) $ok = false;

                    $caracteres_especiales = "~!#¡$&%^*+=\-\[\];,\.\/\{\}\(\)_\|\\:>";
                    if (!preg_match('/[' . preg_quote($caracteres_especiales, '/') . ']/', $password_1)) $ok = false;

                    if (!$ok) {
                        Flasher::new('¡La contraseña no cumple con la política de seguridad!', 'warning');

                    } else {

                        $usuId = (int)$_SESSION[APP_SESSION.'usu_id'];

                        $pass = new passwordModel();
                        $pass->auc_usuario = $usuId;
                        $respass = $pass->listRecovery();
                        if (!isset($respass[0])) $respass = [];

                        $repetida = false;
                        foreach ($respass as $row) {
                            if ($this->passwordOk($password_1, (string)($row['auc_contrasena'] ?? ''))) {
                                $repetida = true;
                                break;
                            }
                        }

                        if ($repetida) {
                            Flasher::new('¡Contraseña usada recientemente, verifique e intente nuevamente!', 'warning');

                        } else {

                            $salt = substr(base64_encode(openssl_random_pseudo_bytes(30)), 0, 22);
                            $salt = strtr($salt, ['+' => '.']);
                            $hash = crypt($password_1, '$2y$10$' . $salt);

                            $u = new usuarioModel();
                            $u->usu_id = $usuId;
                            $u->usu_contrasena = $hash;
                            $u->usu_actualiza_fecha = date('Y-m-d H:i:s');

                            if ($u->updatePassword()) {

                                $_SESSION[APP_SESSION.'_update_registro_creado'] = 1;

                                $u->usu_inicio_sesion = 1;
                                $u->updateSession();
                                $_SESSION[APP_SESSION.'usu_inicio_sesion'] = 1;

                                $pass->auc_contrasena = $hash;
                                $pass->add();

                                Flasher::new('¡Contraseña actualizada exitosamente!', 'success');

                                if (!$this->hasSecurityQuestion($usuId)) {
                                    $_SESSION[APP_SESSION.'_must_setup_security'] = 1;
                                    Redirect::to(self::ROUTE_SEC_SETUP);
                                    exit;
                                }

                                Redirect::to(self::ROUTE_HOME);
                                exit;
                            }

                            Flasher::new('¡Problemas al actualizar contraseña, intente nuevamente!', 'warning');
                        }
                    }
                }
            }
        }

        $data = [
            'control_login' => $control_login,
            'control_login_sesion' => $control_login_sesion
        ];

        View::render('update_password', $data);
    }

    /* =========================
     * RECOVERY BY SECURITY
     * ========================= */

    public function recovery_by_security()
    {
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

                $usuario = checkInput($_POST['usuario'] ?? '');

                // ✅ CAPTCHA DESHABILITADO
                if ($usuario === '') {
                    Flasher::new('¡Debe ingresar su usuario!', 'warning');
                } else {

                    $u = new usuarioModel();
                    $u->usu_acceso = $usuario;
                    $u->usu_estado = 'Activo';
                    $resusuario = $u->login();
                    if (!isset($resusuario[0])) $resusuario = [];

                    if (count($resusuario) === 0) {
                        Flasher::new('¡Si el usuario existe, podrá continuar con la validación!', 'success');
                    } else {
                        $_SESSION[APP_SESSION.'_recovery_security_user'] = (int)($resusuario[0]['usu_id'] ?? 0);
                        unset($_SESSION[APP_SESSION.'_security_verified_for_reset']);
                        Redirect::to(self::ROUTE_SEC_VERIFY);
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

    /* =========================
     * SECURITY VERIFY
     * ========================= */

    public function security_verify()
    {
        Controller::checkSesionIndex();

        $parametro = new parametroModel();
        $parametro->app_id = 'login';
        $resparametro = $parametro->listDetail();

        $parametro->app_id = 'logo';
        $resparametrologo = $parametro->listDetail();

        $usuId = (int)($_SESSION[APP_SESSION.'_recovery_security_user'] ?? 0);
        if ($usuId <= 0) {
            Redirect::to(self::ROUTE_REC_START);
            exit;
        }

        $sec = new usuarioSecurityModel();
        $sec->aus_usuario = $usuId;
        $qdata = $sec->getQuestionByUser();
        if (!isset($qdata[0])) $qdata = [];

        if (count($qdata) === 0) {
            Flasher::new('¡El usuario no tiene pregunta de seguridad configurada!', 'warning');
            Redirect::to(self::ROUTE_REC_START);
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

                    $r = $sec->getByUser();
                    if (!isset($r[0])) $r = [];

                    $hash = (string)($r[0]['aus_answer_hash'] ?? '');
                    $attempts = (int)($r[0]['aus_attempts'] ?? 0);

                    if ($hash === '') {
                        Flasher::new('¡El usuario no tiene respuesta de seguridad registrada!', 'warning');
                        Redirect::to(self::ROUTE_REC_START);
                        exit;
                    }

                    if (!password_verify($answerRaw, $hash)) {

                        $attempts++;
                        $lock = null;

                        if ($attempts >= self::SECURITY_MAX_ATTEMPTS) {
                            $lock = date('Y-m-d H:i:s', strtotime('+' . self::SECURITY_LOCK_MINUTES . ' minutes'));
                        }

                        $sec->setAttemptsAndLock($attempts, $lock);
                        Flasher::new('¡Respuesta incorrecta!', 'warning');

                    } else {
                        $sec->setAttemptsAndLock(0, null);
                        $_SESSION[APP_SESSION.'_security_verified_for_reset'] = 1;
                        Redirect::to(self::ROUTE_REC_UPDATE);
                        exit;
                    }
                }
            }
        }

        $data = [
            'resultado_registros' => $resparametro,
            'resultado_registros_logo' => $resparametrologo,
            'question' => $qdata[0],
            'locked' => $locked,
        ];

        View::render('security_verify', $data);
    }

    /* =========================
     * RECOVERY PASSWORD SECURITY
     * ========================= */

    public function recovery_password_security()
    {
        Controller::checkSesionIndex();

        $parametro = new parametroModel();
        $parametro->app_id = 'login';
        $resparametro = $parametro->listDetail();

        $parametro->app_id = 'logo';
        $resparametrologo = $parametro->listDetail();

        $usuId = (int)($_SESSION[APP_SESSION.'_recovery_security_user'] ?? 0);
        $verified = (int)($_SESSION[APP_SESSION.'_security_verified_for_reset'] ?? 0);

        if ($usuId <= 0 || $verified !== 1) {
            Redirect::to(self::ROUTE_REC_START);
            exit;
        }

        if (isset($_POST['form_update_password_security'])) {

            if (!$this->csrfOk()) {
                Flasher::new('¡Error al validar el token, por favor intente nuevamente!', 'warning');
            } else {

                $p1 = trim((string)($_POST['new_password'] ?? ''));
                $p2 = trim((string)($_POST['confirm_password'] ?? ''));

                if ($p1 === '' || $p2 === '') {
                    Flasher::new('¡Debe completar los campos de contraseña!', 'warning');

                } elseif ($p1 !== $p2) {
                    Flasher::new('¡Las contraseñas no coinciden!', 'warning');

                } else {

                    $hasLower = preg_match('/[a-z]/', $p1);
                    $hasUpper = preg_match('/[A-Z]/', $p1);
                    $hasNum   = preg_match('/[0-9]/', $p1);
                    $hasSpec  = preg_match('/[~!#¡$&%\^*\+=\-\[\];,\.\/\{\}\(\)_\|:>]/', $p1);

                    if (strlen($p1) < 8 || !$hasLower || !$hasUpper || !$hasNum || !$hasSpec) {
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

                            unset($_SESSION[APP_SESSION.'_recovery_security_user']);
                            unset($_SESSION[APP_SESSION.'_security_verified_for_reset']);

                            Flasher::new('¡Contraseña actualizada exitosamente!', 'success');
                            Redirect::to(self::ROUTE_LOGIN);
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

    /* =========================
     * FORGOT PASSWORD / LOGOUT
     * ========================= */

    public function forgot_password()
    {
        Redirect::to(self::ROUTE_REC_START);
        exit;
    }

    public function logout()
    {
        session_destroy();
        Redirect::to(self::ROUTE_LOGIN);
        exit;
    }
}
