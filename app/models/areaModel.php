<?php
    class areaModel extends Model {
        public $aa_id;
        public $aa_nombre;
        public $aa_observaciones;
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
                $filtro_str="AND (`aa_nombre` LIKE :aa_nombre OR `aa_observaciones` LIKE :aa_observaciones OR `aa_registro_usuario` LIKE :aa_registro_usuario OR TUR.`usu_nombres_apellidos` LIKE :usu_nombres_apellidos)";
                $parametros_filtro = [
                    'aa_nombre' => '%'.$this->filtro.'%',
                    'aa_observaciones' => '%'.$this->filtro.'%',
                    'aa_registro_usuario' => '%'.$this->filtro.'%',
                    'usu_nombres_apellidos' => '%'.$this->filtro.'%',
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_str="";
            }

            $sql='SELECT `aa_id`, `aa_nombre`, `aa_observaciones`, `aa_registro_usuario`, `aa_registro_fecha`, TUR.`usu_nombres_apellidos` FROM `'.DB_NAME_AUX.'`.`administrador_areas` 
            LEFT JOIN `app_usuario` AS TUR ON `'.DB_NAME_AUX.'`.`administrador_areas`.`aa_registro_usuario`=TUR.`usu_id` 
             WHERE 1=1 '.$filtro_str.' ORDER BY `aa_nombre` ASC LIMIT :offset,:limite';

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listCount(){
            if ($this->filtro!="" AND $this->filtro!="null") {
                $filtro_str="AND (`aa_nombre` LIKE :aa_nombre OR `aa_observaciones` LIKE :aa_observaciones OR `aa_registro_usuario` LIKE :aa_registro_usuario OR TUR.`usu_nombres_apellidos` LIKE :usu_nombres_apellidos)";
                $parametros = [
                    'aa_nombre' => '%'.$this->filtro.'%',
                    'aa_observaciones' => '%'.$this->filtro.'%',
                    'aa_registro_usuario' => '%'.$this->filtro.'%',
                    'usu_nombres_apellidos' => '%'.$this->filtro.'%',
                ];
            } else {
                $filtro_str="";
            }

            $sql='SELECT `aa_id`, `aa_nombre`, `aa_observaciones`, `aa_registro_usuario`, `aa_registro_fecha`, TUR.`usu_nombres_apellidos` FROM `'.DB_NAME_AUX.'`.`administrador_areas` 
            LEFT JOIN `app_usuario` AS TUR ON `'.DB_NAME_AUX.'`.`administrador_areas`.`aa_registro_usuario`=TUR.`usu_id` 
             WHERE 1=1 '.$filtro_str.' ORDER BY `aa_nombre` ASC';

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listDetail(){
            $sql='SELECT `aa_id`, `aa_nombre`, `aa_observaciones`, `aa_registro_usuario`, `aa_registro_fecha`, TUR.`usu_nombres_apellidos` FROM `'.DB_NAME_AUX.'`.`administrador_areas` 
            LEFT JOIN `app_usuario` AS TUR ON `'.DB_NAME_AUX.'`.`administrador_areas`.`aa_registro_usuario`=TUR.`usu_id` 
             WHERE 1=1 AND `aa_id`=:aa_id ORDER BY `aa_nombre` ASC';

            $parametros = [
                'aa_id' => $this->aa_id
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
            $sql='INSERT INTO `'.DB_NAME_AUX.'`.`administrador_areas`(`aa_nombre`, `aa_observaciones`, `aa_registro_usuario`) VALUES (:aa_nombre, :aa_observaciones, :aa_registro_usuario)';

            $parametros = [
                'aa_nombre' => $this->aa_nombre,
                'aa_observaciones' => $this->aa_observaciones,
                'aa_registro_usuario' => $this->aa_registro_usuario,
            ];

            try {
                return ($this->aa_id = parent::query($sql, $parametros)) ? $this->aa_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function update(){
            $sql='UPDATE `'.DB_NAME_AUX.'`.`administrador_areas` SET `aa_nombre`=:aa_nombre, `aa_observaciones`=:aa_observaciones WHERE `aa_id`=:aa_id';

            $parametros = [
                'aa_id' => $this->aa_id,
                'aa_nombre' => $this->aa_nombre,
                'aa_observaciones' => $this->aa_observaciones,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function delete(){
            $sql='DELETE FROM `'.DB_NAME_AUX.'`.`administrador_areas` WHERE `aa_id`=:aa_id';

            $parametros = [
                'aa_id' => $this->aa_id,
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

            $sql='SELECT `aa_id`, `aa_nombre`, `aa_observaciones`, `aa_registro_usuario`, `aa_registro_fecha`, TUR.`usu_nombres_apellidos` FROM `'.DB_NAME_AUX.'`.`administrador_areas` 
            LEFT JOIN `app_usuario` AS TUR ON `'.DB_NAME_AUX.'`.`administrador_areas`.`aa_registro_usuario`=TUR.`usu_id` 
             WHERE 1=1 ORDER BY `aa_nombre` ASC';

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }