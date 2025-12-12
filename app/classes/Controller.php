<?php
    class Controller {
        public static function checkSesion(){
            $self = new self();
            if (empty($_SESSION['iqvive_token'])) {
                $_SESSION['iqvive_token'] = bin2hex(random_bytes(32));
            }
            if (MANTENIMIENTO==1) {
                Redirect::to('mantenimiento');
            }

            if (!isset($_SESSION[APP_SESSION.'usu_id']) || $_SESSION[APP_SESSION.'usu_id']=="") {
                Redirect::to('login');
            } else {
                if ($_SESSION[APP_SESSION.'usu_inicio_sesion']==0) {
                    Redirect::to('login/password-update');
                }
            }
        }

        public static function checkPermiso($modulo){
            $self = new self();
            if (!isset($_SESSION[APP_SESSION.'usu_modulos'][$modulo]) OR $_SESSION[APP_SESSION.'usu_modulos'][$modulo]=='') {
                Redirect::to('inicio');
            }
        }

        public static function checkSesionIndex(){
            $self = new self();
            if (empty($_SESSION['iqvive_token'])) {
                $_SESSION['iqvive_token'] = bin2hex(random_bytes(32));
            }
            if (isset($_SESSION[APP_SESSION.'usu_id']) && $_SESSION[APP_SESSION.'usu_id']!="") {
                if ($_SESSION[APP_SESSION.'usu_inicio_sesion']==1) {
                    Redirect::to('inicio');
                }
            }
        }
    }