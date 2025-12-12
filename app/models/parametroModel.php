<?php
    class parametroModel extends Model {
        public $app_id;
        public $app_titulo;
        public $app_tipo;
        public $app_descripcion;
        public $app_imagen;
        public $app_link;
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
                'app_id_1' => '',
                'app_id_2' => 'login',
                'app_id_3' => 'logo',
            ];

            if ($this->filtro!="" AND $this->filtro!="null") {
                $filtro_str="AND (`app_titulo` LIKE :app_titulo OR `app_descripcion` LIKE :app_descripcion)";
                $parametros_filtro = [
                    'app_titulo' => '%'.$this->filtro.'%',
                    'app_descripcion' => '%'.$this->filtro.'%',
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_str="";
            }

            $sql='SELECT `app_id`, `app_titulo`, `app_tipo`, `app_descripcion`, `app_imagen`, `app_link` FROM `app_plataforma_parametros` 
             WHERE 1=1 AND `app_id`<>:app_id_1 AND `app_id`<>:app_id_2 AND `app_id`<>:app_id_3 '.$filtro_str.' ORDER BY `app_id` ASC LIMIT :offset,:limite';

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listCount(){
            $parametros = [
                'app_id_1' => '',
                'app_id_2' => 'login',
                'app_id_3' => 'logo',
            ];
            
            if ($this->filtro!="" AND $this->filtro!="null") {
                $filtro_str="AND (`app_titulo` LIKE :app_titulo OR `app_descripcion` LIKE :app_descripcion)";
                $parametros_filtro = [
                    'app_titulo' => '%'.$this->filtro.'%',
                    'app_descripcion' => '%'.$this->filtro.'%',
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_str="";
            }

            $sql='SELECT `app_id`, `app_titulo`, `app_tipo`, `app_descripcion`, `app_imagen`, `app_link` FROM `app_plataforma_parametros` 
             WHERE 1=1 AND `app_id`<>:app_id_1 AND `app_id`<>:app_id_2 AND `app_id`<>:app_id_3 '.$filtro_str.' ORDER BY `app_titulo` ASC';

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listDetail(){
            $sql='SELECT `app_id`, `app_titulo`, `app_tipo`, `app_descripcion`, `app_imagen`, `app_link` FROM `app_plataforma_parametros` 
             WHERE 1=1 AND `app_id`=:app_id';

            $parametros = [
                'app_id' => $this->app_id
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function update(){
            $sql='UPDATE `app_plataforma_parametros` SET `app_descripcion`=:app_descripcion WHERE `app_id`=:app_id';

            $parametros = [
                'app_id' => $this->app_id,
                'app_descripcion' => $this->app_descripcion,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateImagen(){
            $sql='UPDATE `app_plataforma_parametros` SET `app_imagen`=:app_imagen WHERE `app_id`=:app_id';

            $parametros = [
                'app_id' => $this->app_id,
                'app_imagen' => $this->app_imagen,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }