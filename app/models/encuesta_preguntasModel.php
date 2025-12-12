<?php
    class encuesta_preguntasModel extends Model {
        public $encp_id;
        public $encp_encuesta;
        public $encp_orden;
        public $encp_pregunta;
        public $encp_contenido;
        public $encp_tipo;
        public $encp_opciones;
        public $encp_auxiliar_1;
        public $encp_auxiliar_2;
        public $encp_auxiliar_3;
        public $encp_auxiliar_4;
        public $encp_registro_usuario;
        public $encp_registro_fecha;
        public $filtro_bandeja='';
        public $filtro_perfil='';
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;

        /**
         * Método para listar usuarios
         */

        public function list(){
            $sql='SELECT `encp_id`, `encp_encuesta`, `encp_orden`, `encp_pregunta`, `encp_contenido`, `encp_tipo`, `encp_opciones`, `encp_auxiliar_1`, `encp_auxiliar_2`, `encp_auxiliar_3`, `encp_auxiliar_4`, `encp_registro_usuario`, `encp_registro_fecha` FROM `encuestas_preguntas` 
             WHERE `encp_encuesta`=:encp_encuesta  ORDER BY `encp_orden` ASC';
            
            $parametros = [
                'encp_encuesta' => $this->encp_encuesta,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listDetail(){
            $sql='SELECT `encp_id`, `encp_encuesta`, `encp_orden`, `encp_pregunta`, `encp_contenido`, `encp_tipo`, `encp_opciones`, `encp_auxiliar_1`, `encp_auxiliar_2`, `encp_auxiliar_3`, `encp_auxiliar_4`, `encp_registro_usuario`, `encp_registro_fecha` FROM `encuestas_preguntas` 
             WHERE `encp_encuesta`=:encp_encuesta AND `encp_id`=:encp_id ORDER BY `encp_orden` ASC';

            $parametros = [
                'encp_encuesta' => $this->encp_encuesta,
                'encp_id' => $this->encp_id,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listMax(){
            $sql='SELECT MAX(`encp_orden`) AS maximo FROM `encuestas_preguntas` WHERE `encp_encuesta`=:encp_encuesta';

            $parametros = [
                'encp_encuesta' => $this->encp_encuesta,
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
            $sql='INSERT INTO `encuestas_preguntas`(`encp_encuesta`, `encp_orden`, `encp_pregunta`, `encp_contenido`, `encp_tipo`, `encp_opciones`, `encp_auxiliar_1`, `encp_auxiliar_2`, `encp_auxiliar_3`, `encp_auxiliar_4`, `encp_registro_usuario`) VALUES (:encp_encuesta, :encp_orden, :encp_pregunta, :encp_contenido, :encp_tipo, :encp_opciones, :encp_auxiliar_1, :encp_auxiliar_2, :encp_auxiliar_3, :encp_auxiliar_4, :encp_registro_usuario)';

            $parametros = [
                'encp_encuesta' => $this->encp_encuesta,
                'encp_orden' => $this->encp_orden,
                'encp_pregunta' => $this->encp_pregunta,
                'encp_contenido' => $this->encp_contenido,
                'encp_tipo' => $this->encp_tipo,
                'encp_opciones' => $this->encp_opciones,
                'encp_auxiliar_1' => $this->encp_auxiliar_1,
                'encp_auxiliar_2' => $this->encp_auxiliar_2,
                'encp_auxiliar_3' => $this->encp_auxiliar_3,
                'encp_auxiliar_4' => $this->encp_auxiliar_4,
                'encp_registro_usuario' => $this->encp_registro_usuario,
            ];

            try {
                return ($this->encp_id = parent::query($sql, $parametros)) ? $this->encp_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function update(){
            $sql='UPDATE `encuestas_preguntas` SET `encp_pregunta`=:encp_pregunta,`encp_contenido`=:encp_contenido,`encp_tipo`=:encp_tipo,`encp_opciones`=:encp_opciones,`encp_auxiliar_1`=:encp_auxiliar_1,`encp_auxiliar_2`=:encp_auxiliar_2,`encp_auxiliar_3`=:encp_auxiliar_3,`encp_auxiliar_4`=:encp_auxiliar_4 WHERE `encp_id`=:encp_id';

            $parametros = [
                'encp_id' => $this->encp_id,
                'encp_pregunta' => $this->encp_pregunta,
                'encp_contenido' => $this->encp_contenido,
                'encp_tipo' => $this->encp_tipo,
                'encp_opciones' => $this->encp_opciones,
                'encp_auxiliar_1' => $this->encp_auxiliar_1,
                'encp_auxiliar_2' => $this->encp_auxiliar_2,
                'encp_auxiliar_3' => $this->encp_auxiliar_3,
                'encp_auxiliar_4' => $this->encp_auxiliar_4,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }