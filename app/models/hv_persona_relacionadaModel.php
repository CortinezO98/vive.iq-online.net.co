<?php
    class hv_persona_relacionadaModel extends Model {
        public $hpr_id;
        public $hpr_contexto;
        public $hpr_propietario_id;
        public $hpr_nombre_completo;
        public $hpr_cargo;
        public $hpr_campana_cliente;
        public $hpr_relacion_contractual;
        public $hpr_parentesco;
        public $hpr_orden;
        public $hpr_estado;
        public $hpr_registro_usuario;
        public $hpr_registro_fecha;
        public $hpr_actualiza_usuario;
        public $hpr_actualiza_fecha;

        private $tiene_columna_estado = null;

        private function tieneColumnaEstado(){
            if ($this->tiene_columna_estado !== null) {
                return $this->tiene_columna_estado;
            }

            $sql='SELECT COUNT(*) AS total
                  FROM INFORMATION_SCHEMA.COLUMNS
                  WHERE TABLE_SCHEMA=DATABASE()
                    AND TABLE_NAME=\'hoja_vida_persona_relacionada\'
                    AND COLUMN_NAME=\'hpr_estado\'';

            $resultado=parent::query($sql, []);
            $this->tiene_columna_estado=isset($resultado[0]['total']) && (int)$resultado[0]['total']>0;

            return $this->tiene_columna_estado;
        }

        private function filtroActivo(){
            return $this->tieneColumnaEstado() ? " AND `hpr_estado`='activo'" : '';
        }

        public function add(){
            $sql='INSERT INTO `hoja_vida_persona_relacionada`
                    (`hpr_contexto`, `hpr_propietario_id`, `hpr_nombre_completo`,
                     `hpr_cargo`, `hpr_campana_cliente`, `hpr_relacion_contractual`,
                     `hpr_parentesco`, `hpr_orden`, `hpr_registro_usuario`)
                  VALUES
                    (:hpr_contexto, :hpr_propietario_id, :hpr_nombre_completo,
                     :hpr_cargo, :hpr_campana_cliente, :hpr_relacion_contractual,
                     :hpr_parentesco, :hpr_orden, :hpr_registro_usuario)';

            $parametros = [
                'hpr_contexto' => $this->hpr_contexto,
                'hpr_propietario_id' => $this->hpr_propietario_id,
                'hpr_nombre_completo' => $this->hpr_nombre_completo,
                'hpr_cargo' => $this->hpr_cargo,
                'hpr_campana_cliente' => $this->hpr_campana_cliente,
                'hpr_relacion_contractual' => $this->hpr_relacion_contractual,
                'hpr_parentesco' => $this->hpr_parentesco,
                'hpr_orden' => $this->hpr_orden,
                'hpr_registro_usuario' => $this->hpr_registro_usuario,
            ];

            try {
                return ($this->hpr_id = parent::query($sql, $parametros)) ? $this->hpr_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listDetail(){
            $sql='SELECT `hpr_id`, `hpr_contexto`, `hpr_propietario_id`,
                         `hpr_nombre_completo`, `hpr_cargo`, `hpr_campana_cliente`,
                         `hpr_relacion_contractual`, `hpr_parentesco`, `hpr_orden`,
                         `hpr_registro_usuario`, `hpr_registro_fecha`
                  FROM `hoja_vida_persona_relacionada`
                  WHERE `hpr_contexto`=:hpr_contexto
                    AND `hpr_propietario_id`=:hpr_propietario_id'
                    .$this->filtroActivo().
                  ' ORDER BY `hpr_orden`, `hpr_id`';

            $parametros = [
                'hpr_contexto' => $this->hpr_contexto,
                'hpr_propietario_id' => $this->hpr_propietario_id,
            ];

            try {
                return parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listAllReport(){
            $sql='SELECT `hpr_id`, `hpr_contexto`, `hpr_propietario_id`,
                         `hpr_nombre_completo`, `hpr_cargo`, `hpr_campana_cliente`,
                         `hpr_relacion_contractual`, `hpr_parentesco`, `hpr_orden`,
                         `hpr_registro_usuario`, `hpr_registro_fecha`
                  FROM `hoja_vida_persona_relacionada`
                  WHERE `hpr_contexto`=:hpr_contexto'
                    .$this->filtroActivo().
                  ' ORDER BY `hpr_propietario_id`, `hpr_orden`, `hpr_id`';

            $parametros = [
                'hpr_contexto' => $this->hpr_contexto,
            ];

            try {
                return parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function countByOwner(){
            $sql='SELECT COUNT(*) AS total
                  FROM `hoja_vida_persona_relacionada`
                  WHERE `hpr_contexto`=:hpr_contexto
                    AND `hpr_propietario_id`=:hpr_propietario_id'
                    .$this->filtroActivo();

            $parametros = [
                'hpr_contexto' => $this->hpr_contexto,
                'hpr_propietario_id' => $this->hpr_propietario_id,
            ];

            try {
                $resultado=parent::query($sql, $parametros);
                return isset($resultado[0]['total']) ? (int)$resultado[0]['total'] : 0;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function delete(){
            $parametros = [
                'hpr_id' => $this->hpr_id,
                'hpr_contexto' => $this->hpr_contexto,
                'hpr_propietario_id' => $this->hpr_propietario_id,
            ];

            if ($this->tieneColumnaEstado()) {
                $sql="UPDATE `hoja_vida_persona_relacionada`
                      SET `hpr_estado`='eliminado', `hpr_actualiza_fecha`=NOW()
                      WHERE `hpr_id`=:hpr_id
                        AND `hpr_contexto`=:hpr_contexto
                        AND `hpr_propietario_id`=:hpr_propietario_id";
            } else {
                $sql='DELETE FROM `hoja_vida_persona_relacionada`
                      WHERE `hpr_id`=:hpr_id
                        AND `hpr_contexto`=:hpr_contexto
                        AND `hpr_propietario_id`=:hpr_propietario_id';
            }

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function deleteAll(){
            $parametros = [
                'hpr_contexto' => $this->hpr_contexto,
                'hpr_propietario_id' => $this->hpr_propietario_id,
            ];

            if ($this->tieneColumnaEstado()) {
                $sql="UPDATE `hoja_vida_persona_relacionada`
                      SET `hpr_estado`='eliminado', `hpr_actualiza_fecha`=NOW()
                      WHERE `hpr_contexto`=:hpr_contexto
                        AND `hpr_propietario_id`=:hpr_propietario_id";
            } else {
                $sql='DELETE FROM `hoja_vida_persona_relacionada`
                      WHERE `hpr_contexto`=:hpr_contexto
                        AND `hpr_propietario_id`=:hpr_propietario_id';
            }

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }
