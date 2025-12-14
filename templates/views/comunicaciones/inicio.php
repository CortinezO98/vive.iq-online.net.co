<?php
$title = "Comunicaciones Vive iQ";
$description = "Información institucional, cultura y recursos para nuestros colaboradores.";

ob_start();
?>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card h-100 border-0 bg-light">
            <div class="card-body">
                <h5 class="fw-semibold">Sobre IQ</h5>
                <p class="text-muted">Conoce nuestra compañía y cultura organizacional.</p>
                <a href="<?= URL ?>comunicaciones/compania" class="btn btn-outline-primary btn-sm">
                    Ver más
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100 border-0 bg-light">
            <div class="card-body">
                <h5 class="fw-semibold">Lo que necesitas</h5>
                <p class="text-muted">Bienestar, formación, SST y beneficios.</p>
                <a href="<?= URL ?>comunicaciones/bienestar" class="btn btn-outline-primary btn-sm">
                    Explorar
                </a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__.'/layout.php';
