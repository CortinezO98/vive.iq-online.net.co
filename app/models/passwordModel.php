<?php
    class passwordModel extends Model {
        public $auc_id;
        public $auc_usuario;
        public $auc_contrasena;
        public $auc_registro_fecha;

        /**
         * Método para listar logs
         */

        public function list(){
            $sql='SELECT `auc_id`, `auc_usuario`, `auc_contrasena`, `auc_registro_fecha` FROM `app_usuario_contrasenas` WHERE `auc_usuario`=:auc_usuario ORDER BY `auc_registro_fecha` DESC LIMIT 1';

            $parametros = [
                'auc_usuario' => $this->auc_usuario
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listRecovery(){
            $sql='SELECT `auc_id`, `auc_usuario`, `auc_contrasena`, `auc_registro_fecha` FROM `app_usuario_contrasenas` WHERE `auc_usuario`=:auc_usuario ORDER BY `auc_registro_fecha` DESC LIMIT 1';

            $parametros = [
                'auc_usuario' => $this->auc_usuario
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para registrar log
         */

        public function add(){
            $sql='INSERT INTO `app_usuario_contrasenas`(`auc_usuario`, `auc_contrasena`) 
            VALUES (:auc_usuario, :auc_contrasena)';

            $parametros = [
                'auc_usuario' => $this->auc_usuario,
                'auc_contrasena' => $this->auc_contrasena,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function delete(){
            $sql='DELETE FROM `app_usuario_contrasenas` WHERE `auc_usuario`=:auc_usuario';

            $parametros = [
                'auc_usuario' => $this->auc_usuario,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }