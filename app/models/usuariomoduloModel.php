<?php
    class usuariomoduloModel extends Model {
        public $aum_id;
        public $aum_usuario;
        public $aum_modulo;
        public $aum_perfil;
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;
        

        /**
         * Método para listar detalle de un registro
         */
        public function listAll(){
            $sql='SELECT `aum_id`, `aum_usuario`, `aum_modulo`, `aum_perfil`, TMODULO.`amod_nombre` FROM `app_usuario_modulo` 
             LEFT JOIN `app_modulo` AS TMODULO ON `app_usuario_modulo`.`aum_modulo`=TMODULO.`amod_id`
             WHERE 1=1 AND TMODULO.`amod_estado`=:amod_estado AND `aum_usuario`=:aum_usuario';

            $parametros = [
                'amod_estado' => 'Activo',
                'aum_usuario' => $this->aum_usuario,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para crear un registro
         */
        public function add(){
            $sql='INSERT INTO `app_usuario_modulo`(`aum_id`, `aum_usuario`, `aum_modulo`, `aum_perfil`) VALUES (:aum_id, :aum_usuario, :aum_modulo, :aum_perfil)';

            $parametros = [
                'aum_id' => $this->aum_id,
                'aum_usuario' => $this->aum_usuario,
                'aum_modulo' => $this->aum_modulo,
                'aum_perfil' => $this->aum_perfil,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para crear un registro
         */
        public function addUpdate(){
            $sql='INSERT INTO `app_usuario_modulo`(`aum_id`, `aum_usuario`, `aum_modulo`, `aum_perfil`) VALUES (:aum_id, :aum_usuario, :aum_modulo, :aum_perfil) ON DUPLICATE KEY UPDATE `aum_perfil`=:aum_perfil_2';

            $parametros = [
                'aum_id' => $this->aum_id,
                'aum_usuario' => $this->aum_usuario,
                'aum_modulo' => $this->aum_modulo,
                'aum_perfil' => $this->aum_perfil,
                'aum_perfil_2' => $this->aum_perfil,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para eliminar un registro
         */
        public function delete(){
            $sql='DELETE FROM `app_usuario_modulo` WHERE `aum_usuario`=:aum_usuario';

            $parametros = [
                'aum_usuario' => $this->aum_usuario,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }