<?php
    class hv_aspirante_informacionModel extends Model {
        public $hvai_id;
        public $hvai_aspirante;
        public $hvai_excolaborador;
        public $hvai_excolaborador_motivo;
        public $hvai_excolaborador_fecha;
        public $hvai_seleccion_previo;
        public $hvai_seleccion_previo_cargo;
        public $hvai_seleccion_previo_fecha;
        public $hvai_trabajo;
        public $hvai_trabajo_tipo;
        public $hvai_trabajo_empresa;
        public $hvai_trabajo_cargo;
        public $hvai_ocupacion;
        public $hvai_conflicto_renuncia;
        public $hvai_medio_conocer_oferta;
        public $hvai_registro_usuario;
        public $hvai_registro_fecha;
        public $filtro_bandeja='';
        public $filtro_perfil='';
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;

        public function deleteAll(){
            $sql='DELETE FROM `hoja_vida_aspirante_informacion` WHERE `hvai_aspirante`=:hvai_aspirante';

            $parametros = [
                'hvai_aspirante' => $this->hvai_aspirante,
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
            $sql='SELECT `hvai_id`, `hvai_aspirante`, `hvai_excolaborador`, `hvai_excolaborador_motivo`, `hvai_excolaborador_fecha`, `hvai_seleccion_previo`, `hvai_seleccion_previo_cargo`, `hvai_seleccion_previo_fecha`, `hvai_trabajo`, `hvai_trabajo_tipo`, `hvai_trabajo_empresa`, `hvai_trabajo_cargo`, `hvai_ocupacion`, `hvai_conflicto_renuncia`, `hvai_medio_conocer_oferta`, `hvai_registro_usuario`, `hvai_registro_fecha` FROM `hoja_vida_aspirante_informacion`
             WHERE `hvai_aspirante`=:hvai_aspirante';

            $parametros = [
                'hvai_aspirante' => $this->hvai_aspirante,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listAllReport(){
            $sql='SELECT `hvai_id`, `hvai_aspirante`, `hvai_excolaborador`, `hvai_excolaborador_motivo`, `hvai_excolaborador_fecha`, `hvai_seleccion_previo`, `hvai_seleccion_previo_cargo`, `hvai_seleccion_previo_fecha`, `hvai_trabajo`, `hvai_trabajo_tipo`, `hvai_trabajo_empresa`, `hvai_trabajo_cargo`, `hvai_ocupacion`, `hvai_conflicto_renuncia`, `hvai_medio_conocer_oferta`, `hvai_registro_usuario`, `hvai_registro_fecha` FROM `hoja_vida_aspirante_informacion`
             WHERE 1';

            $parametros = [
                // 'hvai_aspirante' => $this->hvai_aspirante,
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
            $sql='SELECT `hvai_id`, `hvai_aspirante`, `hvai_excolaborador`, `hvai_excolaborador_motivo`, `hvai_excolaborador_fecha`, `hvai_seleccion_previo`, `hvai_seleccion_previo_cargo`, `hvai_seleccion_previo_fecha`, `hvai_trabajo`, `hvai_trabajo_tipo`, `hvai_trabajo_empresa`, `hvai_trabajo_cargo`, `hvai_ocupacion`, `hvai_conflicto_renuncia`, `hvai_medio_conocer_oferta`, `hvai_registro_usuario`, `hvai_registro_fecha` FROM `hoja_vida_aspirante_informacion`
             WHERE `hvai_aspirante`=:hvai_aspirante AND `hvai_registro_fecha` LIKE :hvai_registro_fecha';

            $parametros = [
                'hvai_aspirante' => $this->hvai_aspirante,
                'hvai_registro_fecha' => '%'.$this->hvai_registro_fecha.'%',
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
            $sql='INSERT INTO `hoja_vida_aspirante_informacion`(`hvai_aspirante`, `hvai_excolaborador`, `hvai_excolaborador_motivo`, `hvai_excolaborador_fecha`, `hvai_seleccion_previo`, `hvai_seleccion_previo_cargo`, `hvai_seleccion_previo_fecha`, `hvai_trabajo`, `hvai_trabajo_tipo`, `hvai_trabajo_empresa`, `hvai_trabajo_cargo`, `hvai_ocupacion`, `hvai_conflicto_renuncia`, `hvai_medio_conocer_oferta`, `hvai_registro_usuario`) VALUES (:hvai_aspirante, :hvai_excolaborador, :hvai_excolaborador_motivo, :hvai_excolaborador_fecha, :hvai_seleccion_previo, :hvai_seleccion_previo_cargo, :hvai_seleccion_previo_fecha, :hvai_trabajo, :hvai_trabajo_tipo, :hvai_trabajo_empresa, :hvai_trabajo_cargo, :hvai_ocupacion, :hvai_conflicto_renuncia, :hvai_medio_conocer_oferta, :hvai_registro_usuario)';

            $parametros = [
                'hvai_aspirante' => $this->hvai_aspirante,
                'hvai_excolaborador' => $this->hvai_excolaborador,
                'hvai_excolaborador_motivo' => $this->hvai_excolaborador_motivo,
                'hvai_excolaborador_fecha' => $this->hvai_excolaborador_fecha,
                'hvai_seleccion_previo' => $this->hvai_seleccion_previo,
                'hvai_seleccion_previo_cargo' => $this->hvai_seleccion_previo_cargo,
                'hvai_seleccion_previo_fecha' => $this->hvai_seleccion_previo_fecha,
                'hvai_trabajo' => $this->hvai_trabajo,
                'hvai_trabajo_tipo' => $this->hvai_trabajo_tipo,
                'hvai_trabajo_empresa' => $this->hvai_trabajo_empresa,
                'hvai_trabajo_cargo' => $this->hvai_trabajo_cargo,
                'hvai_ocupacion' => $this->hvai_ocupacion,
                'hvai_conflicto_renuncia' => $this->hvai_conflicto_renuncia,
                'hvai_medio_conocer_oferta' => $this->hvai_medio_conocer_oferta,
                'hvai_registro_usuario' => $this->hvai_registro_usuario,
            ];

            try {
                return ($this->hvai_id = parent::query($sql, $parametros)) ? $this->hvai_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateRegistro(){
            $sql='UPDATE `hoja_vida_aspirante_informacion` SET `hvai_excolaborador`=:hvai_excolaborador, `hvai_excolaborador_motivo`=:hvai_excolaborador_motivo, `hvai_excolaborador_fecha`=:hvai_excolaborador_fecha, `hvai_seleccion_previo`=:hvai_seleccion_previo, `hvai_seleccion_previo_cargo`=:hvai_seleccion_previo_cargo, `hvai_seleccion_previo_fecha`=:hvai_seleccion_previo_fecha, `hvai_trabajo`=:hvai_trabajo, `hvai_trabajo_tipo`=:hvai_trabajo_tipo, `hvai_trabajo_empresa`=:hvai_trabajo_empresa, `hvai_trabajo_cargo`=:hvai_trabajo_cargo, `hvai_ocupacion`=:hvai_ocupacion, `hvai_conflicto_renuncia`=:hvai_conflicto_renuncia, `hvai_medio_conocer_oferta`=:hvai_medio_conocer_oferta, `hvai_registro_fecha`=:hvai_registro_fecha WHERE `hvai_aspirante`=:hvai_aspirante';

            $parametros = [
                'hvai_aspirante' => $this->hvai_aspirante,
                'hvai_excolaborador' => $this->hvai_excolaborador,
                'hvai_excolaborador_motivo' => $this->hvai_excolaborador_motivo,
                'hvai_excolaborador_fecha' => $this->hvai_excolaborador_fecha,
                'hvai_seleccion_previo' => $this->hvai_seleccion_previo,
                'hvai_seleccion_previo_cargo' => $this->hvai_seleccion_previo_cargo,
                'hvai_seleccion_previo_fecha' => $this->hvai_seleccion_previo_fecha,
                'hvai_trabajo' => $this->hvai_trabajo,
                'hvai_trabajo_tipo' => $this->hvai_trabajo_tipo,
                'hvai_trabajo_empresa' => $this->hvai_trabajo_empresa,
                'hvai_trabajo_cargo' => $this->hvai_trabajo_cargo,
                'hvai_ocupacion' => $this->hvai_ocupacion,
                'hvai_conflicto_renuncia' => $this->hvai_conflicto_renuncia,
                'hvai_medio_conocer_oferta' => $this->hvai_medio_conocer_oferta,
                'hvai_registro_fecha' => $this->hvai_registro_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }