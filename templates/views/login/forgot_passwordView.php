<?php require_once INCLUDES.'inc_head.php'; ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<style>
    @media (max-width: 1400px) {
        #gwd-reCAPTCHA_2 {
            transform: scale(0.84) !important;
            transform-origin: 0 0;
        }
    }

    @media (max-width: 1200px) {
        #gwd-reCAPTCHA_2 {
            transform: scale(0.64) !important;
            transform-origin: 0 0;
        }
    }

    @media (max-width: 992px) {
        #gwd-reCAPTCHA_2 {
            transform: scale(0.76) !important;
            transform-origin: 0 0;
        }
    }

    @media (max-width: 768px) {
        #gwd-reCAPTCHA_2 {
            transform: scale(1) !important;
            transform-origin: 0 0;
        }
    }
</style>
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
                        <h3>Recuperar contraseña</h3>
                        <?php if($_SESSION[APP_SESSION.'_forgot_registro_creado']!=1): ?>
                            <p class="mb-6">Ingrese la dirección de correo electrónico asociada a su cuenta y enviaremos un enlace para restablecer la contraseña.</p>
                        <?php endif; ?>
                    </div>
                    <!-- Form -->
                    <form name="form_recovery" method="post" action="">
                        <input type="hidden" name="form_token" value="<?php echo checkInput($_SESSION['iqvive_token']); ?>">
                        <?php echo Flasher::flash(); ?>
                        <?php if($_SESSION[APP_SESSION.'_forgot_registro_creado']!=1): ?>
                            <!-- Correo -->
                            <div class="mb-3">
                                <input type="email" name="correo" class="form-control" value="<?php echo (isset($_POST["form_recovery"])) ? checkInput($_POST['correo']) : ''; ?>" placeholder="correo@dominio.com" <?php echo ($_SESSION[APP_SESSION.'_forgot_registro_creado']==1) ? 'disabled' : ''; ?> required>
                            </div>
                            <div class="col-md-12 my-2">
                                <center><div class="g-recaptcha" id="gwd-reCAPTCHA_2" data-sitekey="6LftzogoAAAAALfVpbnOYd1LPzf2my7LyGAuVMEF" data-callback="correctCaptcha"></div></center>
                                <?php if(isset($_POST["form_recovery"]) AND $_POST["g-recaptcha-response"]==''): ?>
                                    <div id="response" class="col-md-12"><p class='alert alert-danger p-1 font-size-11 my-0'>¡Por favor valide el Captcha!</p></div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div>
                            <!-- Button -->
                            <div class="d-grid">
                                <?php if($_SESSION[APP_SESSION.'_forgot_registro_creado']==1): ?>
                                    <a href="<?php echo URL; ?>login" class="btn btn-dark mt-1">Finalizar</a>
                                <?php else: ?>
                                    <button type="submit" name="form_recovery" class="btn btn-primary"><i class="fas fa-user-check"></i> Validar correo</button>
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