<?php
    class encuesta_respuestasModel extends Model {
        public $encr_id;
        public $encr_encuesta;
        public $encr_pregunta;
        public $encr_usuario;
        public $encr_respuesta;
        public $encr_auxiliar_1;
        public $encr_auxiliar_2;
        public $encr_registro_fecha;
        public $filtro_bandeja='';
        public $filtro_perfil='';
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;

        /**
         * Método para listar usuarios
         */

         public function listRespuestas(){
            $sql='SELECT DISTINCT `encr_encuesta`, `encr_usuario`, TUR.`usu_documento`, TUR.`usu_nombres_apellidos`, TCAR.`ac_nombre`, TCC.`aa_nombre` FROM `encuestas_respuestas`
            LEFT JOIN `app_usuario` AS TUR ON `encuestas_respuestas`.`encr_usuario`=TUR.`usu_id` 
            LEFT JOIN `hoja_vida_personal` AS TPER ON `encuestas_respuestas`.`encr_usuario`=TPER.`hvp_usuario_id`
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCAR ON TPER.`hvp_cargo`=TCAR.`ac_id` LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TCC ON TPER.`hvp_centro_costo`=TCC.`aa_id`
             WHERE `encr_encuesta`=:encr_encuesta';
            
            $parametros = [
                'encr_encuesta' => $this->encr_encuesta,
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

         public function listAll(){
            $sql='SELECT `encr_id`, `encr_encuesta`, `encr_pregunta`, `encr_usuario`, `encr_respuesta`, `encr_auxiliar_1`, `encr_auxiliar_2`, `encr_registro_fecha` FROM `encuestas_respuestas`
             WHERE `encr_encuesta`=:encr_encuesta  ORDER BY `encr_id` ASC';
            
            $parametros = [
                'encr_encuesta' => $this->encr_encuesta,
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
            $sql='INSERT INTO `encuestas_respuestas`(`encr_encuesta`, `encr_pregunta`, `encr_usuario`, `encr_respuesta`, `encr_auxiliar_1`, `encr_auxiliar_2`) VALUES (:encr_encuesta, :encr_pregunta, :encr_usuario, :encr_respuesta, :encr_auxiliar_1, :encr_auxiliar_2)';

            $parametros = [
                'encr_encuesta' => $this->encr_encuesta,
                'encr_pregunta' => $this->encr_pregunta,
                'encr_usuario' => $this->encr_usuario,
                'encr_respuesta' => $this->encr_respuesta,
                'encr_auxiliar_1' => $this->encr_auxiliar_1,
                'encr_auxiliar_2' => $this->encr_auxiliar_2,
            ];

            try {
                return ($this->encr_id = parent::query($sql, $parametros)) ? $this->encr_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }