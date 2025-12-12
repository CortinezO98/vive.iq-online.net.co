<?php
    class hv_aspirante_publicoModel extends Model {
        public $hvap_id;
        public $hvap_aspirante;
        public $hvap_recursos;
        public $hvap_reconocimiento;
        public $hvap_poder;
        public $hvap_familiar;
        public $hvap_observaciones;
        public $hvap_registro_usuario;
        public $hvap_registro_fecha;
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;

        public function deleteAll(){
            $sql='DELETE FROM `hoja_vida_aspirante_publico` WHERE `hvap_aspirante`=:hvap_aspirante';

            $parametros = [
                'hvap_aspirante' => $this->hvap_aspirante,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para listar usuarios
         */

        public function listDetail(){
            $sql='SELECT `hvap_id`, `hvap_aspirante`, `hvap_recursos`, `hvap_reconocimiento`, `hvap_poder`, `hvap_familiar`, `hvap_observaciones`, `hvap_registro_usuario`, `hvap_registro_fecha` FROM `hoja_vida_aspirante_publico`
             WHERE `hvap_aspirante`=:hvap_aspirante';

            $parametros = [
                'hvap_aspirante' => $this->hvap_aspirante,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listAllReport(){
            $sql='SELECT `hvap_id`, `hvap_aspirante`, `hvap_recursos`, `hvap_reconocimiento`, `hvap_poder`, `hvap_familiar`, `hvap_observaciones`, `hvap_registro_usuario`, `hvap_registro_fecha` FROM `hoja_vida_aspirante_publico`
             WHERE 1';

            $parametros = [
                // 'hvap_aspirante' => $this->hvap_aspirante,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }
        
        /**
         * Método para listar usuarios
         */

        public function listDetailFormulario(){
            $sql='SELECT `hvap_id`, `hvap_aspirante`, `hvap_recursos`, `hvap_reconocimiento`, `hvap_poder`, `hvap_familiar`, `hvap_observaciones`, `hvap_registro_usuario`, `hvap_registro_fecha` FROM `hoja_vida_aspirante_publico`
             WHERE `hvap_aspirante`=:hvap_aspirante AND `hvap_registro_fecha` LIKE :hvap_registro_fecha';

            $parametros = [
                'hvap_aspirante' => $this->hvap_aspirante,
                'hvap_registro_fecha' => '%'.$this->hvap_registro_fecha.'%',
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para crear un usuario 
         */

        public function add(){
            $sql='INSERT INTO `hoja_vida_aspirante_publico`(`hvap_aspirante`, `hvap_recursos`, `hvap_reconocimiento`, `hvap_poder`, `hvap_familiar`, `hvap_observaciones`, `hvap_registro_usuario`) VALUES (:hvap_aspirante, :hvap_recursos, :hvap_reconocimiento, :hvap_poder, :hvap_familiar, :hvap_observaciones, :hvap_registro_usuario)';

            $parametros = [
                'hvap_aspirante' => $this->hvap_aspirante,
                'hvap_recursos' => $this->hvap_recursos,
                'hvap_reconocimiento' => $this->hvap_reconocimiento,
                'hvap_poder' => $this->hvap_poder,
                'hvap_familiar' => $this->hvap_familiar,
                'hvap_observaciones' => $this->hvap_observaciones,
                'hvap_registro_usuario' => $this->hvap_registro_usuario,
            ];

            try {
                return ($this->hvap_id = parent::query($sql, $parametros)) ? $this->hvap_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateRegistro(){
            $sql='UPDATE `hoja_vida_aspirante_publico` SET `hvap_recursos`=:hvap_recursos, `hvap_reconocimiento`=:hvap_reconocimiento, `hvap_poder`=:hvap_poder, `hvap_familiar`=:hvap_familiar, `hvap_observaciones`=:hvap_observaciones, `hvap_registro_fecha`=:hvap_registro_fecha WHERE `hvap_aspirante`=:hvap_aspirante';

            $parametros = [
                'hvap_aspirante' => $this->hvap_aspirante,
                'hvap_recursos' => $this->hvap_recursos,
                'hvap_reconocimiento' => $this->hvap_reconocimiento,
                'hvap_poder' => $this->hvap_poder,
                'hvap_familiar' => $this->hvap_familiar,
                'hvap_observaciones' => $this->hvap_observaciones,
                'hvap_registro_fecha' => $this->hvap_registro_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }