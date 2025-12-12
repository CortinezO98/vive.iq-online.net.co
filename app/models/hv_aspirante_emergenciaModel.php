<?php
    class hv_aspirante_emergenciaModel extends Model {
        public $hvaem_id;
        public $hvaem_aspirante;
        public $hvaem_nombres_apellidos;
        public $hvaem_parentesco;
        public $hvaem_telefono;
        public $hvaem_grupo_sanguineo;
        public $hvaem_rh;
        public $hvaem_antecedentes;
        public $hvaem_registro_usuario;
        public $hvaem_registro_fecha;
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;

        public function deleteAll(){
            $sql='DELETE FROM `hoja_vida_aspirante_emergencia` WHERE `hvaem_aspirante`=:hvaem_aspirante';

            $parametros = [
                'hvaem_aspirante' => $this->hvaem_aspirante,
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
            $sql='SELECT `hvaem_id`, `hvaem_aspirante`, `hvaem_nombres_apellidos`, `hvaem_parentesco`, `hvaem_telefono`, `hvaem_grupo_sanguineo`, `hvaem_rh`, `hvaem_antecedentes`, `hvaem_registro_usuario`, `hvaem_registro_fecha` FROM `hoja_vida_aspirante_emergencia`
             WHERE `hvaem_aspirante`=:hvaem_aspirante';

            $parametros = [
                'hvaem_aspirante' => $this->hvaem_aspirante,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listAllReport(){
            $sql='SELECT `hvaem_id`, `hvaem_aspirante`, `hvaem_nombres_apellidos`, `hvaem_parentesco`, `hvaem_telefono`, `hvaem_grupo_sanguineo`, `hvaem_rh`, `hvaem_antecedentes`, `hvaem_registro_usuario`, `hvaem_registro_fecha` FROM `hoja_vida_aspirante_emergencia`
             WHERE 1';

            $parametros = [
                // 'hvaem_aspirante' => $this->hvaem_aspirante,
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
            $sql='SELECT `hvaem_id`, `hvaem_aspirante`, `hvaem_nombres_apellidos`, `hvaem_parentesco`, `hvaem_telefono`, `hvaem_grupo_sanguineo`, `hvaem_rh`, `hvaem_antecedentes`, `hvaem_registro_usuario`, `hvaem_registro_fecha` FROM `hoja_vida_aspirante_emergencia`
             WHERE `hvaem_aspirante`=:hvaem_aspirante AND `hvaem_registro_fecha` LIKE :hvaem_registro_fecha';

            $parametros = [
                'hvaem_aspirante' => $this->hvaem_aspirante,
                'hvaem_registro_fecha' => '%'.$this->hvaem_registro_fecha.'%',
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
            $sql='INSERT INTO `hoja_vida_aspirante_emergencia`(`hvaem_aspirante`, `hvaem_nombres_apellidos`, `hvaem_parentesco`, `hvaem_telefono`, `hvaem_grupo_sanguineo`, `hvaem_rh`, `hvaem_antecedentes`, `hvaem_registro_usuario`) VALUES (:hvaem_aspirante, :hvaem_nombres_apellidos, :hvaem_parentesco, :hvaem_telefono, :hvaem_grupo_sanguineo, :hvaem_rh, :hvaem_antecedentes, :hvaem_registro_usuario)';

            $parametros = [
                'hvaem_aspirante' => $this->hvaem_aspirante,
                'hvaem_nombres_apellidos' => $this->hvaem_nombres_apellidos,
                'hvaem_parentesco' => $this->hvaem_parentesco,
                'hvaem_telefono' => $this->hvaem_telefono,
                'hvaem_grupo_sanguineo' => $this->hvaem_grupo_sanguineo,
                'hvaem_rh' => $this->hvaem_rh,
                'hvaem_antecedentes' => $this->hvaem_antecedentes,
                'hvaem_registro_usuario' => $this->hvaem_registro_usuario,
            ];

            try {
                return ($this->hvaem_id = parent::query($sql, $parametros)) ? $this->hvaem_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateRegistro(){
            $sql='UPDATE `hoja_vida_aspirante_emergencia` SET `hvaem_nombres_apellidos`=:hvaem_nombres_apellidos, `hvaem_parentesco`=:hvaem_parentesco, `hvaem_telefono`=:hvaem_telefono, `hvaem_grupo_sanguineo`=:hvaem_grupo_sanguineo, `hvaem_rh`=:hvaem_rh, `hvaem_antecedentes`=:hvaem_antecedentes, `hvaem_registro_fecha`=:hvaem_registro_fecha WHERE `hvaem_aspirante`=:hvaem_aspirante';

            $parametros = [
                'hvaem_aspirante' => $this->hvaem_aspirante,
                'hvaem_nombres_apellidos' => $this->hvaem_nombres_apellidos,
                'hvaem_parentesco' => $this->hvaem_parentesco,
                'hvaem_telefono' => $this->hvaem_telefono,
                'hvaem_grupo_sanguineo' => $this->hvaem_grupo_sanguineo,
                'hvaem_rh' => $this->hvaem_rh,
                'hvaem_antecedentes' => $this->hvaem_antecedentes,
                'hvaem_registro_fecha' => $this->hvaem_registro_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }