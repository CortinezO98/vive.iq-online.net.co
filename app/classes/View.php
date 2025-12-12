<?php
    class View {
        public static function render($view, $data = []) {
            //Convertir el array asociativo en objeto
            $d = to_object($data); //$data en array o $d en objeto
            if(!is_file(VIEWS.CONTROLLER.DS.$view.'View.php')){
                die(sprintf('No existe la vista %sView en la carpeta %s', $view, CONTROLLER));
            }
            require_once VIEWS.CONTROLLER.DS.$view.'View.php';
            exit();
        }
    }