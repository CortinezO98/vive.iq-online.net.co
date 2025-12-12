<?php
    class modulo_tourModel extends Model {
        public $amt_id;
        public $amt_usuario;
        public $amt_modulo;
        public $amt_estado;
        public $amt_registro_usuario;

        /**
         * Método para listar logs
         */

        public function list(){
            $sql='SELECT `amt_id`, `amt_usuario`, `amt_modulo`, `amt_estado`, `amt_registro_usuario`, `amt_registro_fecha` FROM `app_modulo_tour` WHERE `amt_usuario`=:amt_usuario AND `amt_modulo`=:amt_modulo';

            $parametros = [
                'amt_usuario' => $this->amt_usuario,
                'amt_modulo' => $this->amt_modulo,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para registrar
         */
        public function add(){
            $sql='INSERT INTO `app_modulo_tour`(`amt_usuario`, `amt_modulo`, `amt_estado`, `amt_registro_usuario`) VALUES (:amt_usuario, :amt_modulo, :amt_estado, :amt_registro_usuario)';

            $parametros = [
                'amt_usuario' => $this->amt_usuario,
                'amt_modulo' => $this->amt_modulo,
                'amt_estado' => $this->amt_estado,
                'amt_registro_usuario' => $this->amt_registro_usuario,
            ];

            try {
                return ($this->amt_id = parent::query($sql, $parametros)) ? $this->amt_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }