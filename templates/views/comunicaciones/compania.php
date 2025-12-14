<?php
$title = "Compañía";
$description = "Quiénes somos, nuestra historia y propósito.";

ob_start();
?>

<h5>Misión</h5>
<p>Texto editable desde base de datos o CMS.</p>

<h5 class="mt-4">Visión</h5>
<p>Texto editable.</p>

<?php
$content = ob_get_clean();
require __DIR__.'/layout.php';
