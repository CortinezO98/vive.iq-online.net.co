<?php
    class hv_aspirante_estudio_terminadoModel extends Model {
        public $hvaet_id;
        public $hvaet_aspirante;
        public $hvaet_nivel;
        public $hvaet_establecimiento;
        public $hvaet_titulo;
        public $hvaet_ciudad;
        public $hvaet_fecha_inicio;
        public $hvaet_fecha_terminacion;
        public $hvaet_tarjeta_profesional;
        public $hvaet_modalidad;
        public $hvaet_registro_usuario;
        public $hvaet_registro_fecha;
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;

        public function deleteAll(){
            $sql='DELETE FROM `hoja_vida_aspirante_estudio_terminado` WHERE `hvaet_aspirante`=:hvaet_aspirante';

            $parametros = [
                'hvaet_aspirante' => $this->hvaet_aspirante,
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
            $sql='SELECT `hvaet_id`, `hvaet_aspirante`, `hvaet_nivel`, `hvaet_establecimiento`, `hvaet_titulo`, `hvaet_ciudad`, `hvaet_fecha_inicio`, `hvaet_fecha_terminacion`, `hvaet_tarjeta_profesional`, `hvaet_modalidad`, `hvaet_registro_usuario`, `hvaet_registro_fecha`, TCIUDAD.`ciu_municipio`, TCIUDAD.`ciu_departamento` FROM `hoja_vida_aspirante_estudio_terminado` LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_aspirante_estudio_terminado`.`hvaet_ciudad`=TCIUDAD.`ciu_codigo`
             WHERE `hvaet_aspirante`=:hvaet_aspirante';

            $parametros = [
                'hvaet_aspirante' => $this->hvaet_aspirante,
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

         public function listAllReport(){
            $sql='SELECT `hvaet_id`, `hvaet_aspirante`, `hvaet_nivel`, `hvaet_establecimiento`, `hvaet_titulo`, `hvaet_ciudad`, `hvaet_fecha_inicio`, `hvaet_fecha_terminacion`, `hvaet_tarjeta_profesional`, `hvaet_modalidad`, `hvaet_registro_usuario`, `hvaet_registro_fecha`, TCIUDAD.`ciu_municipio`, TCIUDAD.`ciu_departamento` FROM `hoja_vida_aspirante_estudio_terminado` LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_aspirante_estudio_terminado`.`hvaet_ciudad`=TCIUDAD.`ciu_codigo`
             WHERE 1';

            $parametros = [
                // 'hvaet_aspirante' => $this->hvaet_aspirante,
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
            $sql='SELECT `hvaet_id`, `hvaet_aspirante`, `hvaet_nivel`, `hvaet_establecimiento`, `hvaet_titulo`, `hvaet_ciudad`, `hvaet_fecha_inicio`, `hvaet_fecha_terminacion`, `hvaet_tarjeta_profesional`, `hvaet_modalidad`, `hvaet_registro_usuario`, `hvaet_registro_fecha`, TCIUDAD.`ciu_municipio`, TCIUDAD.`ciu_departamento` FROM `hoja_vida_aspirante_estudio_terminado` LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_aspirante_estudio_terminado`.`hvaet_ciudad`=TCIUDAD.`ciu_codigo`
             WHERE `hvaet_aspirante`=:hvaet_aspirante AND `hvaet_registro_fecha` LIKE :hvaet_registro_fecha';

            $parametros = [
                'hvaet_aspirante' => $this->hvaet_aspirante,
                'hvaet_registro_fecha' => '%'.$this->hvaet_registro_fecha.'%',
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
            $sql='INSERT INTO `hoja_vida_aspirante_estudio_terminado`(`hvaet_aspirante`, `hvaet_nivel`, `hvaet_establecimiento`, `hvaet_titulo`, `hvaet_ciudad`, `hvaet_fecha_inicio`, `hvaet_fecha_terminacion`, `hvaet_tarjeta_profesional`, `hvaet_modalidad`, `hvaet_registro_usuario`) VALUES (:hvaet_aspirante, :hvaet_nivel, :hvaet_establecimiento, :hvaet_titulo, :hvaet_ciudad, :hvaet_fecha_inicio, :hvaet_fecha_terminacion, :hvaet_tarjeta_profesional, :hvaet_modalidad, :hvaet_registro_usuario)';

            $parametros = [
                'hvaet_aspirante' => $this->hvaet_aspirante,
                'hvaet_nivel' => $this->hvaet_nivel,
                'hvaet_establecimiento' => $this->hvaet_establecimiento,
                'hvaet_titulo' => $this->hvaet_titulo,
                'hvaet_ciudad' => $this->hvaet_ciudad,
                'hvaet_fecha_inicio' => $this->hvaet_fecha_inicio,
                'hvaet_fecha_terminacion' => $this->hvaet_fecha_terminacion,
                'hvaet_tarjeta_profesional' => $this->hvaet_tarjeta_profesional,
                'hvaet_modalidad' => $this->hvaet_modalidad,
                'hvaet_registro_usuario' => $this->hvaet_registro_usuario,
            ];

            try {
                return ($this->hvaet_id = parent::query($sql, $parametros)) ? $this->hvaet_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function delete(){
            $sql='DELETE FROM `hoja_vida_aspirante_estudio_terminado` WHERE `hvaet_id`=:hvaet_id AND `hvaet_aspirante`=:hvaet_aspirante';

            $parametros = [
                'hvaet_id' => $this->hvaet_id,
                'hvaet_aspirante' => $this->hvaet_aspirante,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }