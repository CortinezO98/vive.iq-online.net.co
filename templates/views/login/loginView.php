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
                    <div class="mb-4 text-center">
                        <img src="<?php echo IMAGES; ?><?php echo LOGO; ?>" class="mb-2 img-fluid"></a>
                        <!-- <h4 class="text-center"><?php echo APP_NAME; ?></h4> -->
                        <h3>Iniciar sesión</h3>
                        <p class="mb-6">Por favor ingrese su información para iniciar sesión.</p>
                    </div>
                    <!-- Form -->
                    <form name="form_sing_in" method="post" action="">
                        <?php
                            $pad = bin2hex(random_bytes(random_int(32, 64)));
                        ?>
                        <input type="hidden" name="padding" value="<?php echo $pad; ?>">
                        <input type="hidden" name="form_token" value="<?php echo checkInput($_SESSION['iqvive_token']); ?>">
                        <?php echo Flasher::flash(); ?>
                        <!-- Username -->
                        <div class="mb-3">
                            <label for="usuario" class="form-label my-0">Usuario</label>
                            <input type="text" id="usuario" class="form-control" name="usuario" placeholder="" required autocomplete="off">
                        </div>
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label my-0">Contraseña</label>
                            <input type="password" id="password" class="form-control" name="password" placeholder="" required autocomplete="off">
                        </div>
                        <div class="col-md-12 my-2">
                            <center><div class="g-recaptcha" id="gwd-reCAPTCHA_2" data-sitekey="6LftzogoAAAAALfVpbnOYd1LPzf2my7LyGAuVMEF" data-callback="correctCaptcha"></div></center>
                            <?php if(isset($_POST["form_recovery"]) AND $_POST["g-recaptcha-response"]==''): ?>
                                <div id="response" class="col-md-12"><p class='alert alert-danger p-1 font-size-11 my-0'>¡Por favor valide el Captcha!</p></div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <!-- Button -->
                            <div class="d-grid">
                                <button type="submit" name="form_sing_in" class="btn btn-primary">Iniciar sesión</button>
                            </div>
                            <div class="d-md-flex justify-content-between mt-4">
                                <div>
                                    <a href="<?php echo URL; ?>login/forgot-password" class="text-inherit fs-5">Olvidó su contraseña?</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once INCLUDES.'inc_footer_index.php'; ?>