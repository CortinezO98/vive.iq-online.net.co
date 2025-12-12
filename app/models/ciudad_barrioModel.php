<?php
    class ciudad_barrioModel extends Model {
        public $ciub_id;
        public $ciub_ciudad;
        public $ciub_localidad;
        public $ciub_barrio;
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
                $filtro_str="AND (`ciu_departamento` LIKE :ciu_departamento OR `ciu_municipio` LIKE :ciu_municipio OR `ciub_localidad` LIKE :ciub_localidad OR `ciub_barrio` LIKE :ciub_barrio";
                $parametros_filtro = [
                    'ciu_departamento' => '%'.$this->filtro.'%',
                    'ciu_municipio' => '%'.$this->filtro.'%',
                    'ciub_localidad' => '%'.$this->filtro.'%',
                    'ciub_barrio' => '%'.$this->filtro.'%',
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_str="";
            }

            $sql='SELECT `ciub_id`, `ciub_ciudad`, `ciub_localidad`, `ciub_barrio` FROM `app_ciudades_barrios`
             WHERE 1=1 '.$filtro_str.' ORDER BY `ciub_ciudad`, `ciub_localidad`, `ciub_barrio` LIMIT :offset,:limite';

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listLocalidad(){
            $sql='SELECT DISTINCT `ciub_localidad` FROM `app_ciudades_barrios`
             WHERE `ciub_ciudad`=:ciub_ciudad ORDER BY `ciub_localidad`';
            
            $parametros = [
                'ciub_ciudad' => $this->ciub_ciudad,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listBarrio(){
            $sql='SELECT DISTINCT `ciub_barrio` FROM `app_ciudades_barrios`
             WHERE `ciub_ciudad`=:ciub_ciudad AND `ciub_localidad`=:ciub_localidad ORDER BY `ciub_barrio`';
            
            $parametros = [
                'ciub_ciudad' => $this->ciub_ciudad,
                'ciub_localidad' => $this->ciub_localidad,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }