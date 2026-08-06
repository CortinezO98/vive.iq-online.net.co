<?php require_once INCLUDES.'inc_head.php'; ?>
<?php if (defined('RECAPTCHA_ENABLED') && RECAPTCHA_ENABLED): ?>
<script src="https://www.google.com/recaptcha/api.js?hl=es" async defer></script>
<style>
    .vive-recaptcha {
        display: flex;
        justify-content: center;
        overflow: hidden;
    }

    @media (max-width: 380px) {
        .vive-recaptcha .g-recaptcha {
            transform: scale(0.88);
            transform-origin: center top;
            margin-bottom: -8px;
        }
    }
</style>
<?php endif; ?>
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

                        <?php if (
    defined('RECAPTCHA_ENABLED')
    && RECAPTCHA_ENABLED
): ?>
<div class="col-md-12 my-3 vive-recaptcha">
    <div
        class="g-recaptcha"
        data-sitekey="<?php echo htmlspecialchars(
            (string)RECAPTCHA_SITE_KEY,
            ENT_QUOTES,
            'UTF-8'
        ); ?>"
        data-theme="light"
    ></div>
</div>
<?php endif; ?>

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
