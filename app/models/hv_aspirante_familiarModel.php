<?php
    class hv_aspirante_familiarModel extends Model {
        public $hvaf_id;
        public $hvaf_aspirante;
        public $hvaf_nombres_apellidos;
        public $hvaf_parentesco;
        public $hvaf_edad;
        public $hvaf_nivel_educativo;
        public $hvaf_acargo;
        public $hvaf_convive;
        public $hvaf_registro_usuario;
        public $hvaf_registro_fecha;
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;

        public function deleteAll(){
            $sql='DELETE FROM `hoja_vida_aspirante_familiar` WHERE `hvaf_aspirante`=:hvaf_aspirante';

            $parametros = [
                'hvaf_aspirante' => $this->hvaf_aspirante,
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
            $sql='SELECT `hvaf_id`, `hvaf_aspirante`, `hvaf_nombres_apellidos`, `hvaf_parentesco`, `hvaf_edad`, `hvaf_nivel_educativo`, `hvaf_acargo`, `hvaf_convive`, `hvaf_registro_usuario`, `hvaf_registro_fecha` FROM `hoja_vida_aspirante_familiar`
             WHERE `hvaf_aspirante`=:hvaf_aspirante';

            $parametros = [
                'hvaf_aspirante' => $this->hvaf_aspirante,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listAllReport(){
            $sql='SELECT `hvaf_id`, `hvaf_aspirante`, `hvaf_nombres_apellidos`, `hvaf_parentesco`, `hvaf_edad`, `hvaf_nivel_educativo`, `hvaf_acargo`, `hvaf_convive`, `hvaf_registro_usuario`, `hvaf_registro_fecha` FROM `hoja_vida_aspirante_familiar`
             WHERE 1';

            $parametros = [
                // 'hvaf_aspirante' => $this->hvaf_aspirante,
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
            $sql='SELECT `hvaf_id`, `hvaf_aspirante`, `hvaf_nombres_apellidos`, `hvaf_parentesco`, `hvaf_edad`, `hvaf_nivel_educativo`, `hvaf_acargo`, `hvaf_convive`, `hvaf_registro_usuario`, `hvaf_registro_fecha` FROM `hoja_vida_aspirante_familiar`
             WHERE `hvaf_aspirante`=:hvaf_aspirante AND `hvaf_registro_fecha` LIKE :hvaf_registro_fecha';

            $parametros = [
                'hvaf_aspirante' => $this->hvaf_aspirante,
                'hvaf_registro_fecha' => '%'.$this->hvaf_registro_fecha.'%',
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
            $sql='INSERT INTO `hoja_vida_aspirante_familiar`(`hvaf_aspirante`, `hvaf_nombres_apellidos`, `hvaf_parentesco`, `hvaf_edad`, `hvaf_nivel_educativo`, `hvaf_acargo`, `hvaf_convive`, `hvaf_registro_usuario`) VALUES (:hvaf_aspirante, :hvaf_nombres_apellidos, :hvaf_parentesco, :hvaf_edad, :hvaf_nivel_educativo, :hvaf_acargo, :hvaf_convive, :hvaf_registro_usuario)';

            $parametros = [
                'hvaf_aspirante' => $this->hvaf_aspirante,
                'hvaf_nombres_apellidos' => $this->hvaf_nombres_apellidos,
                'hvaf_parentesco' => $this->hvaf_parentesco,
                'hvaf_edad' => $this->hvaf_edad,
                'hvaf_nivel_educativo' => $this->hvaf_nivel_educativo,
                'hvaf_acargo' => $this->hvaf_acargo,
                'hvaf_convive' => $this->hvaf_convive,
                'hvaf_registro_usuario' => $this->hvaf_registro_usuario,
            ];

            try {
                return ($this->hvaf_id = parent::query($sql, $parametros)) ? $this->hvaf_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function delete(){
            $sql='DELETE FROM `hoja_vida_aspirante_familiar` WHERE `hvaf_id`=:hvaf_id AND `hvaf_aspirante`=:hvaf_aspirante';

            $parametros = [
                'hvaf_id' => $this->hvaf_id,
                'hvaf_aspirante' => $this->hvaf_aspirante,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }