<?php
    class hv_aspirante_estudio_cursoModel extends Model {
        public $hvaec_id;
        public $hvaec_aspirante;
        public $hvaec_nivel;
        public $hvaec_establecimiento;
        public $hvaec_titulo;
        public $hvaec_ciudad;
        public $hvaec_horario;
        public $hvaec_modalidad;
        public $hvaec_fecha_terminacion;
        public $hvaec_registro_usuario;
        public $hvaec_registro_fecha;
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;

        public function deleteAll(){
            $sql='DELETE FROM `hoja_vida_aspirante_estudio_curso` WHERE `hvaec_aspirante`=:hvaec_aspirante';

            $parametros = [
                'hvaec_aspirante' => $this->hvaec_aspirante,
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
            $sql='SELECT `hvaec_id`, `hvaec_aspirante`, `hvaec_nivel`, `hvaec_establecimiento`, `hvaec_titulo`, `hvaec_ciudad`, `hvaec_horario`, `hvaec_modalidad`, `hvaec_fecha_terminacion`, `hvaec_registro_usuario`, `hvaec_registro_fecha`, TCIUDAD.`ciu_municipio`, TCIUDAD.`ciu_departamento` FROM `hoja_vida_aspirante_estudio_curso` LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_aspirante_estudio_curso`.`hvaec_ciudad`=TCIUDAD.`ciu_codigo`
             WHERE `hvaec_aspirante`=:hvaec_aspirante';

            $parametros = [
                'hvaec_aspirante' => $this->hvaec_aspirante,
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
            $sql='SELECT `hvaec_id`, `hvaec_aspirante`, `hvaec_nivel`, `hvaec_establecimiento`, `hvaec_titulo`, `hvaec_ciudad`, `hvaec_horario`, `hvaec_modalidad`, `hvaec_fecha_terminacion`, `hvaec_registro_usuario`, `hvaec_registro_fecha`, TCIUDAD.`ciu_municipio`, TCIUDAD.`ciu_departamento` FROM `hoja_vida_aspirante_estudio_curso` LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_aspirante_estudio_curso`.`hvaec_ciudad`=TCIUDAD.`ciu_codigo`
             WHERE `hvaec_aspirante`=:hvaec_aspirante AND `hvaec_registro_fecha` LIKE :hvaec_registro_fecha';

            $parametros = [
                'hvaec_aspirante' => $this->hvaec_aspirante,
                'hvaec_registro_fecha' => '%'.$this->hvaec_registro_fecha.'%',
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
            $sql='INSERT INTO `hoja_vida_aspirante_estudio_curso`(`hvaec_aspirante`, `hvaec_nivel`, `hvaec_establecimiento`, `hvaec_titulo`, `hvaec_ciudad`, `hvaec_horario`, `hvaec_modalidad`, `hvaec_fecha_terminacion`, `hvaec_registro_usuario`) VALUES (:hvaec_aspirante, :hvaec_nivel, :hvaec_establecimiento, :hvaec_titulo, :hvaec_ciudad, :hvaec_horario, :hvaec_modalidad, :hvaec_fecha_terminacion, :hvaec_registro_usuario)';

            $parametros = [
                'hvaec_aspirante' => $this->hvaec_aspirante,
                'hvaec_nivel' => $this->hvaec_nivel,
                'hvaec_establecimiento' => $this->hvaec_establecimiento,
                'hvaec_titulo' => $this->hvaec_titulo,
                'hvaec_ciudad' => $this->hvaec_ciudad,
                'hvaec_horario' => $this->hvaec_horario,
                'hvaec_modalidad' => $this->hvaec_modalidad,
                'hvaec_fecha_terminacion' => $this->hvaec_fecha_terminacion,
                'hvaec_registro_usuario' => $this->hvaec_registro_usuario,
            ];

            try {
                return ($this->hva_id = parent::query($sql, $parametros)) ? $this->hva_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function delete(){
            $sql='DELETE FROM `hoja_vida_aspirante_estudio_curso` WHERE `hvaec_id`=:hvaec_id AND `hvaec_aspirante`=:hvaec_aspirante';

            $parametros = [
                'hvaec_id' => $this->hvaec_id,
                'hvaec_aspirante' => $this->hvaec_aspirante,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }