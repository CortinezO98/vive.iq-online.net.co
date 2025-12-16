<?php
class View {

    public static function render($view, $data = []) {
        $d = to_object($data); 
        if (is_array($data) && !empty($data)) {
            extract($data, EXTR_SKIP);
        }

        if (!is_file(VIEWS . CONTROLLER . DS . $view . 'View.php')) {
            die(sprintf('No existe la vista %sView en la carpeta %s', $view, CONTROLLER));
        }

        require_once VIEWS . CONTROLLER . DS . $view . 'View.php';
        exit();
    }
}
