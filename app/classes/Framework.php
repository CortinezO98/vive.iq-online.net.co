<?php
    class Framework {
        //propiedades del framework
        private $nombre = 'MSIS Framework 2022';
        private $version = '1.0.0';
        private $uri = [];

        function __construct() {
            $this->init();
        }

        /**
         * Método para ejecutar cada "método" de forma subsecuente
         *
         * @return void
         */
        private function init() {
            //todos los métodos que queremos ejecutar consecutivamente
            $this->init_session();
            $this->init_load_config();
            $this->init_load_functions();
            $this->init_autoload();
            $this->dispatch();
        }

        /**
         * Método para iniciar la sesión en el sistema
         * 
         *  @return void
         */
        private function init_session() {
            if (session_status()==PHP_SESSION_NONE) {
                session_start();
            }

            return;
        }

        /**
         * Método para cargar la configuración del sistema
         *
         * @return void
         */
        private function init_load_config(){
            $file = 'config.php';
            if (!is_file('app/config/'.$file)) {
                die(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione.', $file, $this->nombre));
            }

            require_once 'app/config/'.$file;
            return;
        }

        /**
         * Método para cargar funciones del sistema y del usuario
         *
         * @return void
         */
        private function init_load_functions(){
            $file = 'core_functions.php';
            if (!is_file(FUNCTIONS.$file)) {
                die(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione.', $file, $this->nombre));
            }

            require_once FUNCTIONS.$file;

            $file = 'custom_functions.php';
            if (!is_file(FUNCTIONS.$file)) {
                die(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione.', $file, $this->nombre));
            }

            require_once FUNCTIONS.$file;

            return;
        }

        /**
         * Método para cargar todos los archivos de forma automática
         *
         * @return void
         */
        private function init_autoload(){
            require_once CLASSES.'Autoloader.php';
            Autoloader::init();
            // require_once CLASSES.'Db.php';
            // require_once CLASSES.'Model.php';
            // require_once CLASSES.'View.php';
            // require_once CLASSES.'Controller.php';
            
            // require_once CONTROLLERS.DEFAULT_CONTROLLER.'Controller.php';
            // require_once CONTROLLERS.DEFAULT_CONTROLLER_ERROR.'Controller.php';
            

            return;
        }

        /**
         * Método para filtrar y descomponer los elementos de la url y uri
         *
         * @return void
         */
        private function filter_url() {
            if (isset($_GET['uri'])) {
                $this->uri = $_GET['uri'];
                $this->uri = rtrim($this->uri, '/');
                //PENDIENTE LIMPIAR PARAMETRO URL SEGURIDAD
                // $this->uri = filter_var($this->uri, FILTER_SANITIZE_URL);
                $this->uri = explode('/', $this->uri);
                return $this->uri;
            }
            return;
        }

        /**
         * Método para ejecutar y cargar de forma automática el controlador solicitado por el usuario
         * su método y pasar parámetros a él
         *
         * @return void
         */
        private function dispatch(){
            //filtrar la url y separar la uri
            $this->filter_url();

            //---------------------------------------------------------------------------
            //Necesitamos saber si se está pasando el nombre de un controlador en la uri
            //$this->uri[0] es el controlador
            if (isset($this->uri[0])) {
                $controller_replace = str_replace('-', '_', $this->uri[0]);
                $current_controller = $controller_replace;
                unset($this->uri[0]);
            } else {
                $current_controller = DEFAULT_CONTROLLER;
            }

            //Ejecución del controlador
            //Verificamos si existe una clase con el controlador solicitado
            $controller = $current_controller.'Controller';
            if (!class_exists($controller)) {
                $controller = DEFAULT_CONTROLLER_ERROR.'Controller';
                $current_controller = DEFAULT_CONTROLLER_ERROR;
            }

            //---------------------------------------------------------------------------
            //Ejecución del método solicitado
            if (isset($this->uri[1])) {
                $method = str_replace('-', '_', $this->uri[1]);
                
                //Existe o no el método dentro de la clase a ejecutar (controlador)
                if (!method_exists($controller, $method)) {
                    $controller = DEFAULT_CONTROLLER_ERROR.'Controller';
                    $current_method = DEFAULT_METHOD;
                    $current_controller = DEFAULT_CONTROLLER_ERROR;
                } else {
                    $current_method = $method;
                }
                unset($this->uri[1]);
            } else {
                $current_method = DEFAULT_METHOD;
            }

            //---------------------------------------------------------------------------
            //Creando constantes para uso más adelante
            define('CONTROLLER', $current_controller);
            define('METHOD', $current_method);

            //---------------------------------------------------------------------------
            //Ejecutando controlador y método según se haga la petición
            $controller = new $controller;
            
            //Obteniendo los parámetros de la URI
            $params = array_values(empty($this->uri) ? [] : $this->uri);
            
            //Llamada al método solicitado por el usuario
            if(empty($params)){
                call_user_func([$controller, $current_method]);
            } else {
                call_user_func_array([$controller, $current_method], $params);
            }

            return;
        }

        /**
         * Correr el framework
         * @return void
         */
        public static function fly() {
            $framework = new self();
            return;
        }
    }