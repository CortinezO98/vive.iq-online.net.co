<?php
    class cargoModel extends Model {
        public $ac_id;
        public $ac_nombre;
        public $ac_observaciones;
        public $ac_registro_usuario;
        public $ac_registro_fecha;
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;
        

        /**
         * Método para listar registros
         */

        public function list(){
            $parametros = [
                'offset' => $this->offset,
                'limite' => $this->limite,
            ];

            if ($this->filtro!="" AND $this->filtro!="null") {
                $filtro_str="AND (`ac_nombre` LIKE :ac_nombre OR `ac_observaciones` LIKE :ac_observaciones OR `ac_registro_usuario` LIKE :ac_registro_usuario OR TUR.`usu_nombres_apellidos` LIKE :usu_nombres_apellidos)";
                $parametros_filtro = [
                    'ac_nombre' => '%'.$this->filtro.'%',
                    'ac_observaciones' => '%'.$this->filtro.'%',
                    'ac_registro_usuario' => '%'.$this->filtro.'%',
                    'usu_nombres_apellidos' => '%'.$this->filtro.'%',
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_str="";
            }

            $sql='SELECT `ac_id`, `ac_nombre`, `ac_observaciones`, `ac_registro_usuario`, `ac_registro_fecha`, TUR.`usu_nombres_apellidos` FROM `'.DB_NAME_AUX.'`.`administrador_cargos` 
            LEFT JOIN `app_usuario` AS TUR ON `'.DB_NAME_AUX.'`.`administrador_cargos`.`ac_registro_usuario`=TUR.`usu_id` 
             WHERE 1=1 '.$filtro_str.' ORDER BY `ac_nombre` ASC LIMIT :offset,:limite';

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listCount(){
            if ($this->filtro!="" AND $this->filtro!="null") {
                $filtro_str="AND (`ac_nombre` LIKE :ac_nombre OR `ac_observaciones` LIKE :ac_observaciones OR `ac_registro_usuario` LIKE :ac_registro_usuario OR TUR.`usu_nombres_apellidos` LIKE :usu_nombres_apellidos)";
                $parametros = [
                    'ac_nombre' => '%'.$this->filtro.'%',
                    'ac_observaciones' => '%'.$this->filtro.'%',
                    'ac_registro_usuario' => '%'.$this->filtro.'%',
                    'usu_nombres_apellidos' => '%'.$this->filtro.'%',
                ];
            } else {
                $filtro_str="";
            }

            $sql='SELECT `ac_id`, `ac_nombre`, `ac_observaciones`, `ac_registro_usuario`, `ac_registro_fecha`, TUR.`usu_nombres_apellidos` FROM `'.DB_NAME_AUX.'`.`administrador_cargos` 
            LEFT JOIN `app_usuario` AS TUR ON `'.DB_NAME_AUX.'`.`administrador_cargos`.`ac_registro_usuario`=TUR.`usu_id` 
             WHERE 1=1 '.$filtro_str.' ORDER BY `ac_nombre` ASC';

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listDetail(){
            $sql='SELECT `ac_id`, `ac_nombre`, `ac_observaciones`, `ac_registro_usuario`, `ac_registro_fecha`, TUR.`usu_nombres_apellidos` FROM `'.DB_NAME_AUX.'`.`administrador_cargos` 
            LEFT JOIN `app_usuario` AS TUR ON `'.DB_NAME_AUX.'`.`administrador_cargos`.`ac_registro_usuario`=TUR.`usu_id` 
             WHERE 1=1 AND `ac_id`=:ac_id ORDER BY `ac_nombre` ASC';

            $parametros = [
                'ac_id' => $this->ac_id
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para crear un registro
         */

        public function add(){
            $sql='INSERT INTO `'.DB_NAME_AUX.'`.`administrador_cargos`(`ac_nombre`, `ac_observaciones`, `ac_registro_usuario`) VALUES (:ac_nombre, :ac_observaciones, :ac_registro_usuario)';

            $parametros = [
                'ac_nombre' => $this->ac_nombre,
                'ac_observaciones' => $this->ac_observaciones,
                'ac_registro_usuario' => $this->ac_registro_usuario,
            ];

            try {
                return ($this->ac_id = parent::query($sql, $parametros)) ? $this->ac_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function update(){
            $sql='UPDATE `'.DB_NAME_AUX.'`.`administrador_cargos` SET `ac_nombre`=:ac_nombre, `ac_observaciones`=:ac_observaciones WHERE `ac_id`=:ac_id';

            $parametros = [
                'ac_id' => $this->ac_id,
                'ac_nombre' => $this->ac_nombre,
                'ac_observaciones' => $this->ac_observaciones,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function delete(){
            $sql='DELETE FROM `'.DB_NAME_AUX.'`.`administrador_cargos` WHERE `ac_id`=:ac_id';

            $parametros = [
                'ac_id' => $this->ac_id,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listActive(){
            $parametros = [
            ];

            $sql='SELECT `ac_id`, `ac_nombre`, `ac_observaciones`, `ac_registro_usuario`, `ac_registro_fecha`, TUR.`usu_nombres_apellidos` FROM `'.DB_NAME_AUX.'`.`administrador_cargos` 
            LEFT JOIN `app_usuario` AS TUR ON `'.DB_NAME_AUX.'`.`administrador_cargos`.`ac_registro_usuario`=TUR.`usu_id` 
             WHERE 1=1 ORDER BY `ac_nombre` ASC';

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }