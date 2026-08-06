<?php
    class hv_aspirante_eticaModel extends Model { 
        public $hvae_id;
        public $hvae_aspirante;
        public $hvae_familiar;
        public $hvae_familiar_nombre;
        public $hvae_familiar_area;
        public $hvae_poblacion_vulnerable;
        public $hvae_alerta_familiaridad;
        public $hvae_registro_usuario;
        public $hvae_registro_fecha;
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;

        public function deleteAll(){
            $sql='DELETE FROM `hoja_vida_aspirante_etica` WHERE `hvae_aspirante`=:hvae_aspirante';

            $parametros = [
                'hvae_aspirante' => $this->hvae_aspirante,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listDetail(){
            $sql='SELECT `hvae_id`, `hvae_aspirante`, `hvae_familiar`, `hvae_familiar_nombre`, `hvae_familiar_area`, `hvae_poblacion_vulnerable`, `hvae_alerta_familiaridad`, `hvae_registro_usuario`, `hvae_registro_fecha`
                  FROM `hoja_vida_aspirante_etica`
             WHERE `hvae_aspirante`=:hvae_aspirante';

            $parametros = [
                'hvae_aspirante' => $this->hvae_aspirante,
            ];

            try {
                return parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listAllReport(){
            $sql='SELECT `hvae_id`, `hvae_aspirante`, `hvae_familiar`, `hvae_familiar_nombre`, `hvae_familiar_area`, `hvae_poblacion_vulnerable`, `hvae_alerta_familiaridad`, `hvae_registro_usuario`, `hvae_registro_fecha`
                  FROM `hoja_vida_aspirante_etica`
             WHERE 1';

            try {
                return parent::query($sql, []);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listDetailFormulario(){
            $sql='SELECT `hvae_id`, `hvae_aspirante`, `hvae_familiar`, `hvae_familiar_nombre`, `hvae_familiar_area`, `hvae_poblacion_vulnerable`, `hvae_alerta_familiaridad`, `hvae_registro_usuario`, `hvae_registro_fecha`
                  FROM `hoja_vida_aspirante_etica`
                  WHERE `hvae_aspirante`=:hvae_aspirante
                    AND `hvae_registro_fecha` LIKE :hvae_registro_fecha';

            $parametros = [
                'hvae_aspirante' => $this->hvae_aspirante,
                'hvae_registro_fecha' => '%'.$this->hvae_registro_fecha.'%',
            ];

            try {
                return parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function add(){
            $sql='INSERT INTO `hoja_vida_aspirante_etica`
                    (`hvae_aspirante`, `hvae_familiar`, `hvae_familiar_nombre`, `hvae_familiar_area`,
                     `hvae_poblacion_vulnerable`, `hvae_alerta_familiaridad`, `hvae_registro_usuario`)
                  VALUES
                    (:hvae_aspirante, :hvae_familiar, :hvae_familiar_nombre, :hvae_familiar_area,
                     :hvae_poblacion_vulnerable, COALESCE(:hvae_alerta_familiaridad, 0), :hvae_registro_usuario)';

            $parametros = [
                'hvae_aspirante' => $this->hvae_aspirante,
                'hvae_familiar' => $this->hvae_familiar,
                'hvae_familiar_nombre' => $this->hvae_familiar_nombre,
                'hvae_familiar_area' => $this->hvae_familiar_area,
                'hvae_poblacion_vulnerable' => $this->hvae_poblacion_vulnerable,
                'hvae_alerta_familiaridad' => $this->hvae_alerta_familiaridad,
                'hvae_registro_usuario' => $this->hvae_registro_usuario,
            ];

            try {
                return ($this->hvae_id = parent::query($sql, $parametros)) ? $this->hvae_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateRegistro(){
            $sql='UPDATE `hoja_vida_aspirante_etica`
                  SET `hvae_familiar`=:hvae_familiar,
                      `hvae_familiar_nombre`=:hvae_familiar_nombre,
                      `hvae_familiar_area`=:hvae_familiar_area,
                      `hvae_poblacion_vulnerable`=:hvae_poblacion_vulnerable,
                      `hvae_alerta_familiaridad`=COALESCE(:hvae_alerta_familiaridad, `hvae_alerta_familiaridad`),
                      `hvae_registro_fecha`=:hvae_registro_fecha
                  WHERE `hvae_aspirante`=:hvae_aspirante';

            $parametros = [
                'hvae_aspirante' => $this->hvae_aspirante,
                'hvae_familiar' => $this->hvae_familiar,
                'hvae_familiar_nombre' => $this->hvae_familiar_nombre,
                'hvae_familiar_area' => $this->hvae_familiar_area,
                'hvae_poblacion_vulnerable' => $this->hvae_poblacion_vulnerable,
                'hvae_alerta_familiaridad' => $this->hvae_alerta_familiaridad,
                'hvae_registro_fecha' => $this->hvae_registro_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }