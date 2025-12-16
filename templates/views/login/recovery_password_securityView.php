<?php require_once INCLUDES.'inc_head.php'; ?>
<link rel="stylesheet" href="<?php echo PLUGINS; ?>PWStrength-master/css/styles.css" />

<?php
// ✅ Solo permitir si ya pasó la verificación por pregunta
$verified = (int)($_SESSION[APP_SESSION.'_security_verified_for_reset'] ?? 0);
if ($verified !== 1) {
    Redirect::to('login/recovery-by-security');
    exit;
}

// Persistencia postback
$new_pass = $_POST['new_password'] ?? '';
$confirm  = $_POST['confirm_password'] ?? '';
?>

<!-- container -->
<main class="container d-flex flex-column">
    <div class="row align-items-center justify-content-center g-0 min-vh-100">
        <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">

            <a href="#" class="form-check form-switch theme-switch btn btn-light btn-icon rounded-circle d-none ">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                <label class="form-check-label" for="flexSwitchCheckDefault"></label>
            </a>

            <!-- Card -->
            <div class="card smooth-shadow-md">
                <!-- Card body -->
                <div class="card-body p-6">

                    <div class="mb-4">
                        <img src="<?php echo IMAGES; ?>logo/logo.png" class="mb-2 img-fluid" alt="Image">
                        <h3>Cambiar contraseña</h3>
                    </div>

                    <!-- Form -->
                    <form name="form_update_password_security" method="post" action="" autocomplete="off">
                        <input type="hidden" name="form_token" value="<?php echo checkInput($_SESSION['iqvive_token'] ?? ''); ?>">
                        <input type="hidden" name="form_update_password_security" value="1">

                        <?php echo Flasher::flash(); ?>

                        <p class="alert alert-warning p-1 m-0 font-size-11">
                            Por favor valide que la nueva contraseña cumpla con los requisitos mínimos de seguridad.
                        </p>

                        <div class="col-md-12 my-2">
                            <p class="appoinment-content-text my-0">Requisitos mínimos:</p>
                            <ul class="lead list-group" id="requirements">
                                <li id="length" class="list-group-item font-size-11 py-1">8 caracteres</li>
                                <li id="lowercase" class="list-group-item font-size-11 py-1">1 letra minúscula</li>
                                <li id="uppercase" class="list-group-item font-size-11 py-1">1 letra mayúscula</li>
                                <li id="number" class="list-group-item font-size-11 py-1">1 número</li>
                                <li id="special" class="list-group-item font-size-11 py-1">
                                    1 caracter especial
                                    <br>
                                    <span class="alert alert-warning px-1 py-0 font-size-12">
                                        ~  !  #  ¡  $  &  %  ^  *  +  =  -  [  ]  ;  ,  .  /  {  }  (  )  _  |  :  >
                                    </span>
                                </li>
                            </ul>
                        </div>

                        <!-- Nueva contraseña -->
                        <div class="col-md-12 my-2">
                            <div class="form-group">
                                <label for="new_password" class="form-label">Ingrese la nueva contraseña</label>
                                <input
                                    type="password"
                                    name="new_password"
                                    id="password"
                                    class="form-control"
                                    minlength="8"
                                    maxlength="72"
                                    value="<?php echo (isset($_POST["form_update_password_security"])) ? checkInput($new_pass) : ''; ?>"
                                    placeholder="Contraseña"
                                    onkeyup="getPassword();"
                                    required
                                    autocomplete="new-password"
                                >
                            </div>
                        </div>

                        <!-- Confirmar contraseña -->
                        <div class="col-md-12 my-2">
                            <div class="form-group">
                                <label for="confirm_password" class="form-label">Confirmar contraseña</label>
                                <input
                                    type="password"
                                    name="confirm_password"
                                    id="password_2"
                                    class="form-control"
                                    minlength="8"
                                    maxlength="72"
                                    value="<?php echo (isset($_POST["form_update_password_security"])) ? checkInput($confirm) : ''; ?>"
                                    placeholder="Confirmar contraseña"
                                    required
                                    autocomplete="new-password"
                                >
                            </div>
                        </div>

                        <div>
                            <!-- Button -->
                            <div class="d-grid">
                                <!-- Toggle mostrar/ocultar (como tu original) -->
                                <a id="togglePassword" class="btn btn-dark mb-4">
                                    <span class="fas fa-eye"></span> Mostrar contraseña
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Guardar contraseña
                                </button>

                                <a href="<?php echo URL; ?>login" class="btn btn-danger mt-1">
                                    Cancelar
                                </a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</main>

<script type="text/javascript" src="<?php echo PLUGINS; ?>PWStrength-master/js/checkpw.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const togglePasswordButton = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const passwordInput2 = document.getElementById('password_2');

    if (togglePasswordButton && passwordInput && passwordInput2) {
        togglePasswordButton.addEventListener('click', function () {

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePasswordButton.innerHTML = '<span class="fas fa-eye-slash"></span> Ocultar Contraseña';
            } else {
                passwordInput.type = 'password';
                togglePasswordButton.innerHTML = '<span class="fas fa-eye"></span> Mostrar Contraseña';
            }

            passwordInput2.type = (passwordInput2.type === 'password') ? 'text' : 'password';
        });
    }

});
</script>

<?php require_once INCLUDES.'inc_footer_index.php'; ?>
