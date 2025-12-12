<!DOCTYPE html>
<html lang="<?php echo LANG; ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>

    <link rel="shortcut icon" href="<?php echo FAVICON; ?>favicon.ico" type="image/x-icon">

    <!-- Libs CSS -->
    <link href="<?php echo LIBS; ?>bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo LIBS; ?>@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="<?php echo LIBS; ?>simplebar/dist/simplebar.min.css" rel="stylesheet">
    <link href="<?php echo LIBS; ?>fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="<?php echo LIBS; ?>fontawesome/css/brands.css" rel="stylesheet">
    <link href="<?php echo LIBS; ?>fontawesome/css/solid.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo PLUGINS; ?>bootstrap-select/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="<?php echo PLUGINS; ?>Tour-JS/lib.css">
    <script src="<?php echo PLUGINS; ?>Tour-JS/lib.js"></script>
    <script src="<?php echo PLUGINS; ?>Highcharts-Gantt/code/highcharts-gantt.js"></script>
    <script src="<?php echo PLUGINS; ?>tinymce/tinymce.min.js"></script>
    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?php echo CSS; ?>theme.min.css?v=1.1">
    <?php
        // $nonceheader = base64_encode(random_bytes(16));
        // header("Content-Security-Policy: default-src 'self'; script-src 'self' 'nonce-$nonceheader' https://www.google.com https://www.gstatic.com https://code.jquery.com; object-src 'none'; style-src 'self' https://fonts.googleapis.com 'unsafe-inline'; font-src 'self' https://fonts.gstatic.com data:; img-src 'self' data: https://www.gstatic.com https://www.google.com; frame-src https://www.google.com https://www.gstatic.com https://www.youtube.com; connect-src 'self' https://www.google.com https://www.gstatic.com; frame-ancestors 'none'; base-uri 'self';");
    ?>
</head>
<body>