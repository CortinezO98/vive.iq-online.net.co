<?php
    class tokenModel extends Model {
        public $aut_id;
        public $aut_usuario;
        public $aut_token;
        public $aut_estado;
        public $aut_expira;
        public $aut_registro_fecha;

        /**
         * Método para listar tokens
         */

         public function listDetail(){
            $sql='SELECT `aut_id`, `aut_usuario`, `aut_token`, `aut_estado`, `aut_expira`, `aut_registro_fecha` FROM `app_usuario_tokens` WHERE `aut_usuario`=:aut_usuario';

            $parametros = [
                'aut_usuario' => $this->aut_usuario,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para listar tokens
         */

        public function validate(){
            $sql='SELECT `aut_id`, `aut_usuario`, `aut_token`, `aut_estado`, `aut_expira`, `aut_registro_fecha` FROM `app_usuario_tokens` WHERE `aut_usuario`=:aut_usuario AND `aut_token`=:aut_token AND `aut_expira`>:aut_expira';

            $parametros = [
                'aut_usuario' => $this->aut_usuario,
                'aut_token' => $this->aut_token,
                'aut_expira' => $this->aut_expira,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para listar tokens
         */

         public function update(){
            $sql='UPDATE `app_usuario_tokens` SET `aut_estado`=:aut_estado WHERE `aut_id`=:aut_id';

            $parametros = [
                'aut_id' => $this->aut_id,
                'aut_estado' => $this->aut_estado,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para registrar token
         */

        public function add(){
            $sql='INSERT INTO `app_usuario_tokens`(`aut_usuario`, `aut_token`, `aut_estado`, `aut_expira`) VALUES 
            (:aut_usuario, :aut_token, :aut_estado, :aut_expira)';

            $parametros = [
                'aut_usuario' => $this->aut_usuario,
                'aut_token' => $this->aut_token,
                'aut_estado' => $this->aut_estado,
                'aut_expira' => $this->aut_expira
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }