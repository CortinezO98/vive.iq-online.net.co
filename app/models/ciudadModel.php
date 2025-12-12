<?php
    class ciudadModel extends Model {
        public $ciu_codigo;
        public $ciu_departamento;
        public $ciu_municipio;
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
                $filtro_str="AND (`ciu_departamento` LIKE :ciu_departamento OR `ciu_municipio` LIKE :ciu_municipio";
                $parametros_filtro = [
                    'ciu_departamento' => '%'.$this->filtro.'%',
                    'ciu_municipio' => '%'.$this->filtro.'%',
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_str="";
            }

            $sql='SELECT `ciu_codigo`, `ciu_departamento`, `ciu_municipio` FROM `app_ciudades`
             WHERE 1=1 '.$filtro_str.' ORDER BY `ciu_municipio`, `ciu_departamento` LIMIT :offset,:limite';

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listActive(){
            $sql='SELECT `ciu_codigo`, `ciu_departamento`, `ciu_municipio` FROM `app_ciudades`
             WHERE 1=1 ORDER BY `ciu_municipio`, `ciu_departamento`';
            
            $parametros = [
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }