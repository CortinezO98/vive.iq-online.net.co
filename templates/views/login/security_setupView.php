<?php require_once INCLUDES.'inc_head.php'; ?>

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
                        <h3>Configurar pregunta de seguridad</h3>

                        <p class="mb-6">
                            Por protocolo, debes registrar una pregunta y una respuesta.
                            Esta información se usará para validar cambios de contraseña sin correo.
                        </p>
                    </div>

                    <?php
                        // Persistencia postback
                        $posted_asq_id = $_POST['asq_id'] ?? '';
                        $posted_custom_question = $_POST['custom_question'] ?? '';
                        $posted_answer = $_POST['asq_answer'] ?? '';
                    ?>

                    <!-- Form -->
                    <form name="form_security_setup" method="post" action="" autocomplete="off">
                        <input type="hidden" name="form_token" value="<?php echo checkInput($_SESSION['iqvive_token'] ?? ''); ?>">
                        <input type="hidden" name="form_security_setup" value="1">

                        <?php echo Flasher::flash(); ?>

                        <!-- Pregunta -->
                        <div class="mb-3">
                            <label class="form-label">Pregunta de seguridad</label>

                            <select class="form-select" name="asq_id" id="asq_id" required>
                                <option value="">Seleccione una opción…</option>

                                <?php if (!empty($questions) && is_array($questions)): ?>
                                    <?php foreach ($questions as $q): ?>
                                        <?php $id = (string)((int)$q['asq_id']); ?>
                                        <option value="<?php echo $id; ?>" <?php echo ($posted_asq_id === $id) ? 'selected' : ''; ?>>
                                            <?php echo checkInput($q['asq_question']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <option value="-1" <?php echo ($posted_asq_id === '-1') ? 'selected' : ''; ?>>
                                    Otra (escribir mi propia pregunta)
                                </option>
                            </select>

                            <div class="form-text">
                                Elige una pregunta que recuerdes fácilmente.
                            </div>
                        </div>

                        <!-- Pregunta personalizada -->
                        <div class="mb-3 d-none" id="custom_question_wrap">
                            <label class="form-label">Escriba su pregunta</label>
                            <input
                                type="text"
                                name="custom_question"
                                id="custom_question"
                                class="form-control"
                                maxlength="200"
                                placeholder="Ej: ¿Cuál fue el nombre de mi primer jefe?"
                                value="<?php echo checkInput($posted_custom_question); ?>"
                            >
                            <div class="form-text">
                                Debe ser una pregunta que solo tú conozcas.
                            </div>
                        </div>

                        <!-- Respuesta -->
                        <div class="mb-3">
                            <label class="form-label">Respuesta</label>

                            <div class="input-group">
                                <input
                                    type="password"
                                    name="asq_answer"
                                    id="asq_answer"
                                    class="form-control"
                                    placeholder="Escribe tu respuesta"
                                    maxlength="200"
                                    autocomplete="new-password"
                                    required
                                    value="<?php echo (isset($_POST['form_security_setup'])) ? checkInput($posted_answer) : ''; ?>"
                                >

                                <button
                                    class="btn btn-outline-secondary"
                                    type="button"
                                    id="toggleAnswer"
                                    aria-label="Ver respuesta"
                                >
                                    <i class="fas fa-eye" id="toggleAnswerIcon"></i>
                                </button>
                            </div>

                            <div class="form-text">
                                Recomendación: evita respuestas obvias. No compartas esta información.
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar y continuar
                            </button>

                            <a href="<?php echo URL; ?>inicio" class="btn btn-danger mt-1">
                                Cancelar
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</main>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Mostrar/Ocultar pregunta personalizada
    const sel = document.getElementById('asq_id');
    const wrap = document.getElementById('custom_question_wrap');
    const inputCustom = document.getElementById('custom_question');

    function toggleCustomQuestion() {
        if (sel.value === '-1') {
            wrap.classList.remove('d-none');
            inputCustom.setAttribute('required', 'required');
        } else {
            wrap.classList.add('d-none');
            inputCustom.removeAttribute('required');
            inputCustom.value = '';
        }
    }

    sel.addEventListener('change', toggleCustomQuestion);
    toggleCustomQuestion();

    // Ver / ocultar respuesta
    const input = document.getElementById('asq_answer');
    const btn   = document.getElementById('toggleAnswer');
    const icon  = document.getElementById('toggleAnswerIcon');

    btn.addEventListener('click', function () {
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });

});
</script>

<?php require_once INCLUDES.'inc_footer_index.php'; ?>
