<?php
    class moduloModel extends Model {
        public $amod_id;
        public $amod_nombre;
        public $amod_estado;
        public $amod_observaciones;
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;

        /**
         * Método para listar registros activos
         */
        public function listActive(){
            $sql='SELECT `amod_id`, `amod_nombre`, `amod_estado`, `amod_observaciones` FROM `app_modulo`
             WHERE 1=1 ORDER BY `amod_nombre` ASC';
            
            $parametros = [
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }