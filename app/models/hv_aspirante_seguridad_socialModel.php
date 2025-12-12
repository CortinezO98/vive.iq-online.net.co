<?php
    class hv_aspirante_seguridad_socialModel extends Model {
        public $hvass_id;
        public $hvass_aspirante;
        public $hvass_eps;
        public $hvass_pension;
        public $hvass_pension_voluntario;
        public $hvass_cesantias;
        public $hvass_prepagada;
        public $hvass_registro_usuario;
        public $hvass_registro_fecha;
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;

        public function deleteAll(){
            $sql='DELETE FROM `hoja_vida_aspirante_seguridad_social` WHERE `hvass_aspirante`=:hvass_aspirante';

            $parametros = [
                'hvass_aspirante' => $this->hvass_aspirante,
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
            $sql='SELECT `hvass_id`, `hvass_aspirante`, `hvass_eps`, `hvass_pension`, `hvass_pension_voluntario`, `hvass_cesantias`, `hvass_prepagada`, `hvass_registro_usuario`, `hvass_registro_fecha` FROM `hoja_vida_aspirante_seguridad_social`
             WHERE `hvass_aspirante`=:hvass_aspirante';

            $parametros = [
                'hvass_aspirante' => $this->hvass_aspirante,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listAllReport(){
            $sql='SELECT `hvass_id`, `hvass_aspirante`, `hvass_eps`, `hvass_pension`, `hvass_pension_voluntario`, `hvass_cesantias`, `hvass_prepagada`, `hvass_registro_usuario`, `hvass_registro_fecha` FROM `hoja_vida_aspirante_seguridad_social`
             WHERE 1';

            $parametros = [
                // 'hvass_aspirante' => $this->hvass_aspirante,
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
            $sql='SELECT `hvass_id`, `hvass_aspirante`, `hvass_eps`, `hvass_pension`, `hvass_pension_voluntario`, `hvass_cesantias`, `hvass_prepagada`, `hvass_registro_usuario`, `hvass_registro_fecha` FROM `hoja_vida_aspirante_seguridad_social`
             WHERE `hvass_aspirante`=:hvass_aspirante AND `hvass_registro_fecha` LIKE :hvass_registro_fecha';

            $parametros = [
                'hvass_aspirante' => $this->hvass_aspirante,
                'hvass_registro_fecha' => '%'.$this->hvass_registro_fecha.'%',
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
            $sql='INSERT INTO `hoja_vida_aspirante_seguridad_social`(`hvass_aspirante`, `hvass_eps`, `hvass_pension`, `hvass_pension_voluntario`, `hvass_cesantias`, `hvass_prepagada`, `hvass_registro_usuario`) VALUES (:hvass_aspirante, :hvass_eps, :hvass_pension, :hvass_pension_voluntario, :hvass_cesantias, :hvass_prepagada, :hvass_registro_usuario)';

            $parametros = [
                'hvass_aspirante' => $this->hvass_aspirante,
                'hvass_eps' => $this->hvass_eps,
                'hvass_pension' => $this->hvass_pension,
                'hvass_pension_voluntario' => $this->hvass_pension_voluntario,
                'hvass_cesantias' => $this->hvass_cesantias,
                'hvass_prepagada' => $this->hvass_prepagada,
                'hvass_registro_usuario' => $this->hvass_registro_usuario,
            ];

            try {
                return ($this->hvass_id = parent::query($sql, $parametros)) ? $this->hvass_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateRegistro(){
            $sql='UPDATE `hoja_vida_aspirante_seguridad_social` SET `hvass_eps`=:hvass_eps, `hvass_pension`=:hvass_pension, `hvass_pension_voluntario`=:hvass_pension_voluntario, `hvass_cesantias`=:hvass_cesantias, `hvass_prepagada`=:hvass_prepagada, `hvass_registro_fecha`=:hvass_registro_fecha WHERE `hvass_aspirante`=:hvass_aspirante';

            $parametros = [
                'hvass_aspirante' => $this->hvass_aspirante,
                'hvass_eps' => $this->hvass_eps,
                'hvass_pension' => $this->hvass_pension,
                'hvass_pension_voluntario' => $this->hvass_pension_voluntario,
                'hvass_cesantias' => $this->hvass_cesantias,
                'hvass_prepagada' => $this->hvass_prepagada,
                'hvass_registro_fecha' => $this->hvass_registro_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }