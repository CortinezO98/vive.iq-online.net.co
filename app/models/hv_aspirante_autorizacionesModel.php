<?php
    class hv_aspirante_autorizacionesModel extends Model {
        public $hvada_id;
        public $hvada_aspirante;
        public $hvada_veracidad;
        public $hvada_origen_fondos;
        public $hvada_proteccion_datos;
        public $hvada_tratamiento_datos;
        public $hvada_registro_usuario;
        public $hvada_registro_fecha;
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;

        public function deleteAll(){
            $sql='DELETE FROM `hoja_vida_aspirante_autorizaciones` WHERE `hvada_aspirante`=:hvada_aspirante';

            $parametros = [
                'hvada_aspirante' => $this->hvada_aspirante,
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
            $sql='SELECT `hvada_id`, `hvada_aspirante`, `hvada_veracidad`, `hvada_origen_fondos`, `hvada_proteccion_datos`, `hvada_tratamiento_datos`, `hvada_registro_usuario`, `hvada_registro_fecha` FROM `hoja_vida_aspirante_autorizaciones`
             WHERE `hvada_aspirante`=:hvada_aspirante';

            $parametros = [
                'hvada_aspirante' => $this->hvada_aspirante,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listAllReport(){
            $sql='SELECT `hvada_id`, `hvada_aspirante`, `hvada_veracidad`, `hvada_origen_fondos`, `hvada_proteccion_datos`, `hvada_tratamiento_datos`, `hvada_registro_usuario`, `hvada_registro_fecha` FROM `hoja_vida_aspirante_autorizaciones`
             WHERE 1';

            $parametros = [
                // 'hvada_aspirante' => $this->hvada_aspirante,
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
            $sql='SELECT `hvada_id`, `hvada_aspirante`, `hvada_veracidad`, `hvada_origen_fondos`, `hvada_proteccion_datos`, `hvada_tratamiento_datos`, `hvada_registro_usuario`, `hvada_registro_fecha` FROM `hoja_vida_aspirante_autorizaciones`
             WHERE `hvada_aspirante`=:hvada_aspirante AND `hvada_registro_fecha` LIKE :hvada_registro_fecha';

            $parametros = [
                'hvada_aspirante' => $this->hvada_aspirante,
                'hvada_registro_fecha' => '%'.$this->hvada_registro_fecha.'%',
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
            $sql='INSERT INTO `hoja_vida_aspirante_autorizaciones`(`hvada_aspirante`, `hvada_veracidad`, `hvada_origen_fondos`, `hvada_proteccion_datos`, `hvada_tratamiento_datos`, `hvada_registro_usuario`) VALUES (:hvada_aspirante, :hvada_veracidad, :hvada_origen_fondos, :hvada_proteccion_datos, :hvada_tratamiento_datos, :hvada_registro_usuario)';

            $parametros = [
                'hvada_aspirante' => $this->hvada_aspirante,
                'hvada_veracidad' => $this->hvada_veracidad,
                'hvada_origen_fondos' => $this->hvada_origen_fondos,
                'hvada_proteccion_datos' => $this->hvada_proteccion_datos,
                'hvada_tratamiento_datos' => $this->hvada_tratamiento_datos,
                'hvada_registro_usuario' => $this->hvada_registro_usuario,
            ];

            try {
                return ($this->hvada_id = parent::query($sql, $parametros)) ? $this->hvada_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para crear un usuario 
         */

         public function addPTD(){
            $sql='INSERT INTO `hoja_vida_aspirante_autorizaciones`(`hvada_aspirante`, `hvada_veracidad`, `hvada_origen_fondos`, `hvada_proteccion_datos`, `hvada_tratamiento_datos`, `hvada_registro_usuario`) VALUES (:hvada_aspirante, :hvada_veracidad, :hvada_origen_fondos, :hvada_proteccion_datos, :hvada_tratamiento_datos, :hvada_registro_usuario)';

            $parametros = [
                'hvada_aspirante' => $this->hvada_aspirante,
                'hvada_veracidad' => $this->hvada_veracidad,
                'hvada_origen_fondos' => $this->hvada_origen_fondos,
                'hvada_proteccion_datos' => $this->hvada_proteccion_datos,
                'hvada_tratamiento_datos' => $this->hvada_tratamiento_datos,
                'hvada_registro_usuario' => $this->hvada_registro_usuario,
            ];

            try {
                return ($this->hvada_id = parent::query($sql, $parametros)) ? $this->hvada_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateRegistro(){
            $sql='UPDATE `hoja_vida_aspirante_autorizaciones` SET `hvada_veracidad`=:hvada_veracidad, `hvada_origen_fondos`=:hvada_origen_fondos, `hvada_proteccion_datos`=:hvada_proteccion_datos, `hvada_registro_fecha`=:hvada_registro_fecha WHERE `hvada_aspirante`=:hvada_aspirante';

            $parametros = [
                'hvada_aspirante' => $this->hvada_aspirante,
                'hvada_veracidad' => $this->hvada_veracidad,
                'hvada_origen_fondos' => $this->hvada_origen_fondos,
                'hvada_proteccion_datos' => $this->hvada_proteccion_datos,
                'hvada_registro_fecha' => $this->hvada_registro_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateRegistroPTD(){
            $sql='UPDATE `hoja_vida_aspirante_autorizaciones` SET `hvada_tratamiento_datos`=:hvada_tratamiento_datos, `hvada_registro_fecha`=:hvada_registro_fecha WHERE `hvada_aspirante`=:hvada_aspirante';

            $parametros = [
                'hvada_aspirante' => $this->hvada_aspirante,
                'hvada_tratamiento_datos' => $this->hvada_tratamiento_datos,
                'hvada_registro_fecha' => $this->hvada_registro_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }