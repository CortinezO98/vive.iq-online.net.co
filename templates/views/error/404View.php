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
    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?php echo CSS; ?>theme.min.css">
    <style type="text/css">
      .text-left { 
        text-align: left !important;
      }

      .text-right {
        text-align: right !important;
      }

      .font-weight-bold {
        font-weight: bold;
      }

      .error-page h1, .error-page .h1 {
        font-size: 12rem;
      }

      @media (max-width: 991px) {
        .error-page h1, .error-page .h1 {
          font-size: 8rem;
        }
      }
    </style>
</head>
<body class="bg-dark">
  <div class="container-scroller pt-4">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper align-items-center text-center error-page">
        <div class="row flex-grow">
          <div class="col-lg-7 mx-auto text-white">
            <div class="row align-items-center">
              <div class="col-lg-6 text-right pr-lg-4">
                <h1 class="display-1 mb-0 text-white">404</h1>
              </div>
              <div class="col-lg-6 text-left pl-lg-4">
                <h2 class="font-weight-bold text-white">¡LO SIENTO!</h2>
                <h3 class=" text-white">No se encontró la página que está buscando.</h3>
              </div>
            </div>
            <div class="row mt-5">
              <div class="col-12 text-center mt-xl-2">
                <a class="text-white font-weight-medium" href="<?php echo URL; ?>">Regresar al inicio</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- vendor plugins -->
  <!-- Libs JS -->
    <script src="<?php echo LIBS; ?>jquery/dist/jquery.min.js"></script>
    <script src="<?php echo LIBS; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo LIBS; ?>feather-icons/dist/feather.min.js"></script>
    <script src="<?php echo LIBS; ?>simplebar/dist/simplebar.min.js"></script>

    <!-- Theme JS -->
    <script src="<?php echo JS; ?>theme.min.js"></script>
 
    <!-- jsvectormap -->
    <script src="<?php echo JS; ?>vendors/chart.js"></script>
</body>
</html>