<?php require_once INCLUDES.'inc_head.php'; ?>
<link rel="stylesheet" href="<?php echo PLUGINS; ?>PWStrength-master/css/styles.css" />
<!-- container -->
<main class="container d-flex flex-column">
    <div class="row align-items-center justify-content-center g-0
        min-vh-100">
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
                        <img src="<?php echo IMAGES; ?>logo/logo.png" class="mb-2 img-fluid" alt="Image"></a>
                        <!-- <h4 class="text-center"><?php echo APP_NAME_ALL; ?></h4> -->
                        <h3>Cambiar contraseña</h3>
                    </div>
                    <!-- Form -->
                    <form name="form_recovery" method="post" action="">
                        <input type="hidden" name="form_token" value="<?php echo checkInput($_SESSION['iqvive_token']); ?>">
                        <?php echo Flasher::flash(); ?>
                        <?php if($data['valida_token']): ?>
                            <?php if($_SESSION[APP_SESSION.'_recovery_registro_creado']!=1): ?>
                                <p class="alert alert-warning p-1 m-0 font-size-11">Por favor valide que la nueva contraseña cumpla con los requisitos mínimos de seguridad.</p>
                                <div class="col-md-12 my-2">
                                    <p class="appoinment-content-text my-0">Requisitos mínimos:</p>
                                    <ul class="lead list-group" id="requirements">
                                        <li id="length" class="list-group-item font-size-11 py-1">8 caracteres</li>
                                        <li id="lowercase" class="list-group-item font-size-11 py-1">1 letra minúscula</li>
                                        <li id="uppercase" class="list-group-item font-size-11 py-1">1 letra mayúscula</li>
                                        <li id="number" class="list-group-item font-size-11 py-1">1 número</li>
                                        <li id="special" class="list-group-item font-size-11 py-1">1 caracter especial
                                            <br><span class="alert alert-warning px-1 py-0 font-size-12">~  !  #  ¡  $  &  %  ^  *  +  =  -  [  ]  ;  ,  .  /  {  }  (  )  _  |  :  ></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-12 my-2">
                                    <div class="form-group">
                                        <label for="password_1" class="form-label">Ingrese la nueva contraseña</label>
                                        <input type="password" name="password_1" id="password" class="form-control" minlenght="8" maxlenght="15" value="<?php echo (isset($_POST["password_1"])) ? checkInput($_POST['password_1']) : ''; ?>" placeholder="Contraseña" <?php echo ($_SESSION[APP_SESSION.'_recovery_registro_creado']==1) ? 'disabled' : ''; ?>  onkeyup="getPassword();" required>
                                    </div>    
                                </div>
                                <div class="col-md-12 my-2">
                                    <div class="form-group">
                                        <label for="password_2" class="form-label">Confirmar contraseña</label>
                                        <input type="password" name="password_2" id="password_2" class="form-control" minlenght="8" maxlenght="15" value="<?php echo (isset($_POST["password_2"])) ? checkInput($_POST['password_2']) : ''; ?>" placeholder="Contraseña" <?php echo ($_SESSION[APP_SESSION.'_recovery_registro_creado']==1) ? 'disabled' : ''; ?> required>
                                    </div>    
                                </div>
                            <?php elseif($_SESSION[APP_SESSION.'_recovery_registro_creado']==1): ?>
                                
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="col-md-12 my-2">
                                <p class="alert alert-warning p-1">¡No hemos podido validar el token, por favor intenta nuevamente!</p>
                            </div>
                        <?php endif; ?>
                        <div>
                            <!-- Button -->
                            <div class="d-grid">
                                <?php if($data['valida_token']): ?>
                                    <?php if($data['control_login']): ?>
                                        <a href="<?php echo URL; ?>inicio" class="btn btn-success mt-1">Continuar</a>
                                    <?php endif; ?>
                                    <?php if($_SESSION[APP_SESSION.'_recovery_registro_creado']==1): ?>
                                        <!-- <a href="<?php echo URL; ?>login" class="btn btn-dark mt-1">Finalizar</a> -->
                                    <?php else: ?>
                                        <a id="togglePassword" class="btn btn-dark mb-4"><span class="fas fa-eye"></span> Mostrar contraseña</a>
                                        <button type="submit" name="form_recovery" class="btn btn-primary">Guardar contraseña</button>
                                        <a href="<?php echo URL; ?>login" class="btn btn-danger mt-1">Cancelar</a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="<?php echo URL; ?>login" class="btn btn-danger mt-1">Cancelar</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once INCLUDES.'inc_footer_index.php'; ?>
<script type="text/javascript" src="<?php echo PLUGINS; ?>PWStrength-master/js/checkpw.js"></script>
<script>
    const togglePasswordButton = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const passwordInput2 = document.getElementById('password_2');

    togglePasswordButton.addEventListener('click', function() {
        // Cambia el tipo de input entre 'password' y 'text'
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePasswordButton.innerHTML = '<span class="fas fa-eye-slash"></span> Ocultar Contraseña';
        } else {
            passwordInput.type = 'password';
            togglePasswordButton.innerHTML = '<span class="fas fa-eye"></span> Mostrar Contraseña';
        }

        if (passwordInput2.type === 'password') {
            passwordInput2.type = 'text';
        } else {
            passwordInput2.type = 'password';
        }
    });
</script>