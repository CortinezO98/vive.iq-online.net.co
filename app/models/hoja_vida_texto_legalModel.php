<?php
    /**
     * Modelo para textos legales versionados (RF-04/RF-05).
     * Tabla compartida entre Seleccion y Ciudadano iQ.
     */
    class hoja_vida_texto_legalModel extends Model {
        public $htl_id;
        public $htl_tipo;
        public $htl_version;
        public $htl_contenido;
        public $htl_vigente;
        public $htl_registro_fecha;

        /**
         * Obtiene el texto legal vigente (htl_vigente=1) para un tipo dado.
         * Tipos validos: 'sagrilaft_ptee' | 'autorizacion_datos' | 'consideraciones'
         * Si existiera mas de una version marcada vigente (no deberia pasar en operacion
         * normal), devuelve la de mayor version.
         */
        public function getVigentePorTipo(){
            $sql='SELECT `htl_id`, `htl_tipo`, `htl_version`, `htl_contenido`, `htl_vigente`, `htl_registro_fecha` FROM `hoja_vida_texto_legal`
             WHERE `htl_tipo`=:htl_tipo AND `htl_vigente`=1 ORDER BY `htl_version` DESC LIMIT 1';

            $parametros = [
                'htl_tipo' => $this->htl_tipo,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }
