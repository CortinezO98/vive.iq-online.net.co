<?php
    class hv_aspirante_financieraModel extends Model {
        public $hvaf_id;
        public $hvaf_aspirante;
        public $hvaf_activos;
        public $hvaf_pasivos;
        public $hvaf_patrimonio;
        public $hvaf_ingresos;
        public $hvaf_egresos;
        public $hvaf_ingresos_otros;
        public $hvaf_moneda_extranjera;
        public $hvaf_concepto_ingresos;
        public $hvaf_reporte;
        public $hvaf_reporte_cual;
        public $hvaf_registro_usuario;
        public $hvaf_registro_fecha;
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;

        public function deleteAll(){
            $sql='DELETE FROM `hoja_vida_aspirante_financiera` WHERE `hvaf_aspirante`=:hvaf_aspirante';

            $parametros = [
                'hvaf_aspirante' => $this->hvaf_aspirante,
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
            $sql='SELECT `hvaf_id`, `hvaf_aspirante`, `hvaf_activos`, `hvaf_pasivos`, `hvaf_patrimonio`, `hvaf_ingresos`, `hvaf_egresos`, `hvaf_ingresos_otros`, `hvaf_concepto_ingresos`, `hvaf_moneda_extranjera`, `hvaf_reporte`, `hvaf_reporte_cual`, `hvaf_registro_usuario`, `hvaf_registro_fecha` FROM `hoja_vida_aspirante_financiera`
             WHERE `hvaf_aspirante`=:hvaf_aspirante';

            $parametros = [
                'hvaf_aspirante' => $this->hvaf_aspirante,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listAllReport(){
            $sql='SELECT `hvaf_id`, `hvaf_aspirante`, `hvaf_activos`, `hvaf_pasivos`, `hvaf_patrimonio`, `hvaf_ingresos`, `hvaf_egresos`, `hvaf_ingresos_otros`, `hvaf_concepto_ingresos`, `hvaf_moneda_extranjera`, `hvaf_reporte`, `hvaf_reporte_cual`, `hvaf_registro_usuario`, `hvaf_registro_fecha` FROM `hoja_vida_aspirante_financiera`
             WHERE 1';

            $parametros = [
                // 'hvaf_aspirante' => $this->hvaf_aspirante,
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
            $sql='SELECT `hvaf_id`, `hvaf_aspirante`, `hvaf_activos`, `hvaf_pasivos`, `hvaf_patrimonio`, `hvaf_ingresos`, `hvaf_egresos`, `hvaf_ingresos_otros`, `hvaf_concepto_ingresos`, `hvaf_moneda_extranjera`, `hvaf_reporte`, `hvaf_reporte_cual`, `hvaf_registro_usuario`, `hvaf_registro_fecha` FROM `hoja_vida_aspirante_financiera`
             WHERE `hvaf_aspirante`=:hvaf_aspirante AND `hvaf_registro_fecha` LIKE :hvaf_registro_fecha';

            $parametros = [
                'hvaf_aspirante' => $this->hvaf_aspirante,
                'hvaf_registro_fecha' => '%'.$this->hvaf_registro_fecha.'%',
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
            $sql='INSERT INTO `hoja_vida_aspirante_financiera`(`hvaf_aspirante`, `hvaf_activos`, `hvaf_pasivos`, `hvaf_patrimonio`, `hvaf_ingresos`, `hvaf_egresos`, `hvaf_ingresos_otros`, `hvaf_concepto_ingresos`, `hvaf_moneda_extranjera`, `hvaf_reporte`, `hvaf_reporte_cual`, `hvaf_registro_usuario`) VALUES (:hvaf_aspirante, :hvaf_activos, :hvaf_pasivos, :hvaf_patrimonio, :hvaf_ingresos, :hvaf_egresos, :hvaf_ingresos_otros, :hvaf_concepto_ingresos, :hvaf_moneda_extranjera, :hvaf_reporte, :hvaf_reporte_cual, :hvaf_registro_usuario)';

            $parametros = [
                'hvaf_aspirante' => $this->hvaf_aspirante,
                'hvaf_activos' => $this->hvaf_activos,
                'hvaf_pasivos' => $this->hvaf_pasivos,
                'hvaf_patrimonio' => $this->hvaf_patrimonio,
                'hvaf_ingresos' => $this->hvaf_ingresos,
                'hvaf_egresos' => $this->hvaf_egresos,
                'hvaf_ingresos_otros' => $this->hvaf_ingresos_otros,
                'hvaf_concepto_ingresos' => $this->hvaf_concepto_ingresos,
                'hvaf_moneda_extranjera' => $this->hvaf_moneda_extranjera,
                'hvaf_reporte' => $this->hvaf_reporte,
                'hvaf_reporte_cual' => $this->hvaf_reporte_cual,
                'hvaf_registro_usuario' => $this->hvaf_registro_usuario,
            ];

            try {
                return ($this->hvaf_id = parent::query($sql, $parametros)) ? $this->hvaf_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateRegistro(){
            $sql='UPDATE `hoja_vida_aspirante_financiera` SET `hvaf_activos`=:hvaf_activos, `hvaf_pasivos`=:hvaf_pasivos, `hvaf_patrimonio`=:hvaf_patrimonio, `hvaf_ingresos`=:hvaf_ingresos, `hvaf_egresos`=:hvaf_egresos, `hvaf_ingresos_otros`=:hvaf_ingresos_otros, `hvaf_concepto_ingresos`=:hvaf_concepto_ingresos, `hvaf_moneda_extranjera`=:hvaf_moneda_extranjera, `hvaf_reporte`=:hvaf_reporte, `hvaf_reporte_cual`=:hvaf_reporte_cual, `hvaf_registro_fecha`=:hvaf_registro_fecha WHERE `hvaf_aspirante`=:hvaf_aspirante';

            $parametros = [
                'hvaf_aspirante' => $this->hvaf_aspirante,
                'hvaf_activos' => $this->hvaf_activos,
                'hvaf_pasivos' => $this->hvaf_pasivos,
                'hvaf_patrimonio' => $this->hvaf_patrimonio,
                'hvaf_ingresos' => $this->hvaf_ingresos,
                'hvaf_egresos' => $this->hvaf_egresos,
                'hvaf_ingresos_otros' => $this->hvaf_ingresos_otros,
                'hvaf_concepto_ingresos' => $this->hvaf_concepto_ingresos,
                'hvaf_moneda_extranjera' => $this->hvaf_moneda_extranjera,
                'hvaf_reporte' => $this->hvaf_reporte,
                'hvaf_reporte_cual' => $this->hvaf_reporte_cual,
                'hvaf_registro_fecha' => $this->hvaf_registro_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }