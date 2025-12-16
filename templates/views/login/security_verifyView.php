<?php require_once INCLUDES.'inc_head.php'; ?>

<?php
// Variables esperadas:
// - $question (array) con: asq_question, aus_attempts, aus_locked_until
// - $locked (bool) opcional

$qText     = $question['asq_question'] ?? '';
$lockedFlg = isset($locked) ? (bool)$locked : false;

// Persistencia postback
$posted_answer = $_POST['asq_answer'] ?? '';
?>

<!-- container -->
<main class="container d-flex flex-column">
    <div class="row align-items-center justify-content-center g-0 min-vh-100">
        <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">

            <a href="#" class="form-check form-switch theme-switch btn btn-light btn-icon rounded-circle d-none">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                <label class="form-check-label" for="flexSwitchCheckDefault"></label>
            </a>

            <!-- Card -->
            <div class="card smooth-shadow-md">
                <!-- Card body -->
                <div class="card-body p-6">

                    <div class="mb-4">
                        <img src="<?php echo IMAGES; ?>logo/logo.png" class="mb-2 img-fluid" alt="Image">
                        <h3>Verificación de seguridad</h3>

                        <p class="mb-6">
                            Responde la pregunta de seguridad para continuar.
                        </p>
                    </div>

                    <?php echo Flasher::flash(); ?>

                    <div class="alert alert-light border mb-3">
                        <div class="small text-muted mb-1">Pregunta:</div>
                        <div class="fw-semibold"><?php echo checkInput($qText); ?></div>
                    </div>

                    <?php if ($lockedFlg): ?>
                        <div class="alert alert-warning">
                            Tu verificación está temporalmente bloqueada por intentos fallidos. Intenta nuevamente más tarde.
                        </div>
                    <?php endif; ?>

                    <!-- Form -->
                    <form name="form_security_verify" method="post" action="" autocomplete="off">
                        <input type="hidden" name="form_token" value="<?php echo checkInput($_SESSION['iqvive_token'] ?? ''); ?>">
                        <input type="hidden" name="form_security_verify" value="1">

                        <!-- Respuesta -->
                        <div class="mb-3">
                            <label class="form-label">Respuesta</label>

                            <div class="input-group">
                                <input
                                    type="password"
                                    class="form-control"
                                    name="asq_answer"
                                    id="asq_answer"
                                    required
                                    maxlength="200"
                                    autocomplete="off"
                                    placeholder="Escribe tu respuesta"
                                    value="<?php echo (isset($_POST['form_security_verify'])) ? checkInput($posted_answer) : ''; ?>"
                                    <?php echo $lockedFlg ? 'disabled' : ''; ?>
                                >

                                <button
                                    class="btn btn-outline-secondary"
                                    type="button"
                                    id="toggleAnswer"
                                    aria-label="Ver respuesta"
                                    <?php echo $lockedFlg ? 'disabled' : ''; ?>
                                >
                                    <i class="fas fa-eye" id="toggleAnswerIcon"></i>
                                </button>
                            </div>

                            <div class="form-text">
                                Por seguridad, evita compartir esta información.
                            </div>
                        </div>

                        <div>
                            <!-- Buttons -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary" <?php echo $lockedFlg ? 'disabled' : ''; ?>>
                                    <i class="fas fa-user-check"></i> Verificar
                                </button>

                                <a href="<?php echo URL; ?>login" class="btn btn-danger mt-1">
                                    Volver al login
                                </a>
                            </div>
                        </div>

                    </form>

                    <hr class="my-4">

                    <p class="text-muted small mb-0">
                        Si no recuerdas la respuesta, contacta al administrador del sistema.
                    </p>

                </div>
            </div>

        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('asq_answer');
    const btn   = document.getElementById('toggleAnswer');
    const icon  = document.getElementById('toggleAnswerIcon');

    if (btn && input) {
        btn.addEventListener('click', function () {
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }
});
</script>

<?php require_once INCLUDES.'inc_footer_index.php'; ?>
