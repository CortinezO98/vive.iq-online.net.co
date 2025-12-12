<?php
    class hv_aspirante_experienciaModel extends Model {
        public $hvaex_id;
        public $hvaex_aspirante;
        public $hvaex_empresa;
        public $hvaex_cargo;
        public $hvaex_fecha_inicio;
        public $hvaex_fecha_retiro;
        public $hvaex_ciudad;
        public $hvaex_jefe_nombre;
        public $hvaex_jefe_cargo;
        public $hvaex_telefonos;
        public $hvaex_motivo_retiro;
        public $hvaex_registro_usuario;
        public $hvaet_registro_fecha;
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;

        public function deleteAll(){
            $sql='DELETE FROM `hoja_vida_aspirante_experiencia` WHERE `hvaex_aspirante`=:hvaex_aspirante';

            $parametros = [
                'hvaex_aspirante' => $this->hvaex_aspirante,
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
            $sql='SELECT `hvaex_id`, `hvaex_aspirante`, `hvaex_empresa`, `hvaex_cargo`, `hvaex_fecha_inicio`, `hvaex_fecha_retiro`, `hvaex_ciudad`, `hvaex_jefe_nombre`, `hvaex_jefe_cargo`, `hvaex_telefonos`, `hvaex_motivo_retiro`, `hvaex_registro_usuario`, `hvaet_registro_fecha`, TCIUDAD.`ciu_municipio`, TCIUDAD.`ciu_departamento` FROM `hoja_vida_aspirante_experiencia` LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_aspirante_experiencia`.`hvaex_ciudad`=TCIUDAD.`ciu_codigo`
             WHERE `hvaex_aspirante`=:hvaex_aspirante';

            $parametros = [
                'hvaex_aspirante' => $this->hvaex_aspirante,
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
            $sql='SELECT `hvaex_id`, `hvaex_aspirante`, `hvaex_empresa`, `hvaex_cargo`, `hvaex_fecha_inicio`, `hvaex_fecha_retiro`, `hvaex_ciudad`, `hvaex_jefe_nombre`, `hvaex_jefe_cargo`, `hvaex_telefonos`, `hvaex_motivo_retiro`, `hvaex_registro_usuario`, `hvaet_registro_fecha`, TCIUDAD.`ciu_municipio`, TCIUDAD.`ciu_departamento` FROM `hoja_vida_aspirante_experiencia` LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_aspirante_experiencia`.`hvaex_ciudad`=TCIUDAD.`ciu_codigo`
             WHERE 1';

            $parametros = [
                // 'hvaex_aspirante' => $this->hvaex_aspirante,
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
            $sql='SELECT `hvaex_id`, `hvaex_aspirante`, `hvaex_empresa`, `hvaex_cargo`, `hvaex_fecha_inicio`, `hvaex_fecha_retiro`, `hvaex_ciudad`, `hvaex_jefe_nombre`, `hvaex_jefe_cargo`, `hvaex_telefonos`, `hvaex_motivo_retiro`, `hvaex_registro_usuario`, `hvaet_registro_fecha`, TCIUDAD.`ciu_municipio`, TCIUDAD.`ciu_departamento` FROM `hoja_vida_aspirante_experiencia` LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_aspirante_experiencia`.`hvaex_ciudad`=TCIUDAD.`ciu_codigo`
             WHERE `hvaex_aspirante`=:hvaex_aspirante AND `hvaet_registro_fecha` LIKE :hvaet_registro_fecha';

            $parametros = [
                'hvaex_aspirante' => $this->hvaex_aspirante,
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
            $sql='INSERT INTO `hoja_vida_aspirante_experiencia`(`hvaex_aspirante`, `hvaex_empresa`, `hvaex_cargo`, `hvaex_fecha_inicio`, `hvaex_fecha_retiro`, `hvaex_ciudad`, `hvaex_jefe_nombre`, `hvaex_jefe_cargo`, `hvaex_telefonos`, `hvaex_motivo_retiro`, `hvaex_registro_usuario`) VALUES (:hvaex_aspirante, :hvaex_empresa, :hvaex_cargo, :hvaex_fecha_inicio, :hvaex_fecha_retiro, :hvaex_ciudad, :hvaex_jefe_nombre, :hvaex_jefe_cargo, :hvaex_telefonos, :hvaex_motivo_retiro, :hvaex_registro_usuario)';

            $parametros = [
                'hvaex_aspirante' => $this->hvaex_aspirante,
                'hvaex_empresa' => $this->hvaex_empresa,
                'hvaex_cargo' => $this->hvaex_cargo,
                'hvaex_fecha_inicio' => $this->hvaex_fecha_inicio,
                'hvaex_fecha_retiro' => $this->hvaex_fecha_retiro,
                'hvaex_ciudad' => $this->hvaex_ciudad,
                'hvaex_jefe_nombre' => $this->hvaex_jefe_nombre,
                'hvaex_jefe_cargo' => $this->hvaex_jefe_cargo,
                'hvaex_telefonos' => $this->hvaex_telefonos,
                'hvaex_motivo_retiro' => $this->hvaex_motivo_retiro,
                'hvaex_registro_usuario' => $this->hvaex_registro_usuario,
            ];

            try {
                return ($this->hvaex_id = parent::query($sql, $parametros)) ? $this->hvaex_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function delete(){
            $sql='DELETE FROM `hoja_vida_aspirante_experiencia` WHERE `hvaex_id`=:hvaex_id AND `hvaex_aspirante`=:hvaex_aspirante';

            $parametros = [
                'hvaex_id' => $this->hvaex_id,
                'hvaex_aspirante' => $this->hvaex_aspirante,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }