<?php require INCLUDES.'inc_header.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 col-lg-9 mx-auto">

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <!-- TÍTULO -->
                    <h2 class="fw-bold text-primary mb-3">
                        <?= $title ?? 'Comunicaciones IQ'; ?>
                    </h2>

                    <!-- DESCRIPCIÓN -->
                    <?php if (!empty($description)): ?>
                        <p class="text-muted mb-4"><?= $description; ?></p>
                    <?php endif; ?>

                    <!-- CONTENIDO -->
                    <?= $content; ?>

                </div>
            </div>

        </div>
    </div>
</div>

<?php require INCLUDES.'inc_footer.php'; ?>
