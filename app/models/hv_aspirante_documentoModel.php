<?php
    class hv_aspirante_documentoModel extends Model { 
        public $hvad_id;
        public $hvad_aspirante;
        public $hvad_tipo;
        public $hvad_nombre;
        public $hvad_ruta;
        public $hvad_extension;
        public $hvad_registro_usuario;
        public $hvad_registro_fecha;
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;

        public function deleteAll(){
            $sql='DELETE FROM `hoja_vida_aspirante_documentos` WHERE `hvad_aspirante`=:hvad_aspirante';

            $parametros = [
                'hvad_aspirante' => $this->hvad_aspirante,
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

         public function listDocumento(){
            $sql='SELECT `hvad_id`, `hvad_aspirante`, `hvad_tipo`, `hvad_nombre`, `hvad_ruta`, `hvad_extension`, `hvad_registro_usuario`, `hvad_registro_fecha` FROM `hoja_vida_aspirante_documentos`
             WHERE `hvad_id`=:hvad_id';

            $parametros = [
                'hvad_id' => $this->hvad_id,
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

         public function listDetail(){
            $sql='SELECT `hvad_id`, `hvad_aspirante`, `hvad_tipo`, `hvad_nombre`, `hvad_ruta`, `hvad_extension`, `hvad_registro_usuario`, `hvad_registro_fecha` FROM `hoja_vida_aspirante_documentos`
             WHERE `hvad_aspirante`=:hvad_aspirante AND `hvad_tipo`<>:hvad_tipo AND `hvad_tipo`<>:hvad_tipo_2 ORDER BY `hvad_id` DESC';

            $parametros = [
                'hvad_aspirante' => $this->hvad_aspirante,
                'hvad_tipo' => 'firma',
                'hvad_tipo_2' => 'firma_padre',
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
        public function listDetailAll(){
            $sql='SELECT `hvad_id`, `hvad_aspirante`, `hvad_tipo`, `hvad_nombre`, `hvad_ruta`, `hvad_extension`, `hvad_registro_usuario`, `hvad_registro_fecha` FROM `hoja_vida_aspirante_documentos`
             WHERE `hvad_aspirante`=:hvad_aspirante AND `hvad_tipo`=:hvad_tipo ORDER BY `hvad_id` DESC';

            $parametros = [
                'hvad_aspirante' => $this->hvad_aspirante,
                'hvad_tipo' => $this->hvad_tipo,
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
            $sql='SELECT `hvad_id`, `hvad_aspirante`, `hvad_tipo`, `hvad_nombre`, `hvad_ruta`, `hvad_extension`, `hvad_registro_usuario`, `hvad_registro_fecha` FROM `hoja_vida_aspirante_documentos`
             WHERE `hvad_aspirante`=:hvad_aspirante AND `hvad_tipo`=:hvad_tipo AND `hvad_registro_fecha`>=:hvad_registro_fecha ORDER BY `hvad_id` DESC';

            $parametros = [
                'hvad_aspirante' => $this->hvad_aspirante,
                'hvad_tipo' => $this->hvad_tipo,
                'hvad_registro_fecha' => $this->hvad_registro_fecha,
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
        public function listDetailFormularioDuplicado(){
            $sql='SELECT `hvad_id`, `hvad_aspirante`, `hvad_tipo`, `hvad_nombre`, `hvad_ruta`, `hvad_extension`, `hvad_registro_usuario`, `hvad_registro_fecha` FROM `hoja_vida_aspirante_documentos`
             WHERE `hvad_aspirante`=:hvad_aspirante AND `hvad_tipo`=:hvad_tipo';

            $parametros = [
                'hvad_aspirante' => $this->hvad_aspirante,
                'hvad_tipo' => $this->hvad_tipo,
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
            $sql='INSERT INTO `hoja_vida_aspirante_documentos`(`hvad_aspirante`, `hvad_tipo`, `hvad_nombre`, `hvad_ruta`, `hvad_extension`, `hvad_registro_usuario`) VALUES (:hvad_aspirante, :hvad_tipo, :hvad_nombre, :hvad_ruta, :hvad_extension, :hvad_registro_usuario)';

            $parametros = [
                'hvad_aspirante' => $this->hvad_aspirante,
                'hvad_tipo' => $this->hvad_tipo,
                'hvad_nombre' => $this->hvad_nombre,
                'hvad_ruta' => $this->hvad_ruta,
                'hvad_extension' => $this->hvad_extension,
                'hvad_registro_usuario' => $this->hvad_registro_usuario,
            ];

            try {
                return ($this->hvad_id = parent::query($sql, $parametros)) ? $this->hvad_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateRegistro(){
            $sql='UPDATE `hoja_vida_aspirante_documentos` SET `hvad_nombre`=:hvad_nombre, `hvad_ruta`=:hvad_ruta, `hvad_extension`=:hvad_extension, `hvad_registro_fecha`=:hvad_registro_fecha WHERE `hvad_aspirante`=:hvad_aspirante AND `hvad_tipo`=:hvad_tipo';

            $parametros = [
                'hvad_aspirante' => $this->hvad_aspirante,
                'hvad_tipo' => $this->hvad_tipo,
                'hvad_nombre' => $this->hvad_nombre,
                'hvad_ruta' => $this->hvad_ruta,
                'hvad_extension' => $this->hvad_extension,
                'hvad_registro_fecha' => $this->hvad_registro_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }