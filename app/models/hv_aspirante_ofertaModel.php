<?php
    class hv_aspirante_ofertaModel extends Model {
        public $hvao_id;
        public $hvao_aspirante;
        public $hvao_area;
        public $hvao_cargo;
        public $hvao_salario;
        public $hvao_psicologo;
        public $hvao_director;
        public $hvao_horario;
        public $hvao_debida_diligencia;
        public $hvao_prueba_confiabilidad;
        public $hvao_examen_medico;
        public $hvao_check_contratacion;
        public $hvao_fecha_diligencia;
        public $hvao_firma_ruta;
        public $hvao_estado;
        public $hvao_revisa_usuario;
        public $hvao_revisa_fecha;
        public $hvao_estado_fase_2;
        public $hvao_auxiliar_1;
        public $hvao_auxiliar_2;
        public $hvao_registro_usuario;
        public $hvao_registro_fecha;
        public $filtro_area;
        public $filtro_cargo;
        public $filtro_psicolologo;
        public $filtro_estado;
        public $hvao_registro_fecha_2;
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;

        /**
         * Método para listar usuarios
         */

        public function list(){
            $sql='SELECT `hvao_id`, `hvao_aspirante`, `hvao_area`, `hvao_cargo`, `hvao_salario`, `hvao_psicologo`, `hvao_director`, `hvao_horario`, `hvao_debida_diligencia`, `hvao_prueba_confiabilidad`, `hvao_examen_medico`, `hvao_check_contratacion`, `hvao_fecha_diligencia`, `hvao_firma_ruta`, `hvao_estado`, `hvao_revisa_usuario`, `hvao_revisa_fecha`, `hvao_estado_fase_2`, `hvao_auxiliar_1`, `hvao_auxiliar_2`, `hvao_registro_usuario`, `hvao_registro_fecha`, TAS.`hva_identificacion`, TAS.`hva_nombres`, TAS.`hva_apellido_1`, TAS.`hva_apellido_2`, TAS.`hva_direccion`, TAS.`hva_barrio`, TAS.`hva_ciudad`, TAS.`hva_celular`, TAS.`hva_celular_2`, TAS.`hva_correo`, TAS.`hva_nacimiento_lugar`, TAS.`hva_nacimiento_fecha`, TAS.`hva_operador_internet`, TAS.`hva_genero`, TAS.`hva_estado_civil`, TAS.`hva_estado`, TAS.`hva_localidad`, TCAR.`ac_nombre`, TCC.`aa_nombre`, TUPS.`usu_nombres_apellidos` AS usuario_psicologo, TDIR.`usu_nombres_apellidos` AS usuario_director FROM `hoja_vida_aspirante_oferta` LEFT JOIN `app_usuario` AS TUPS ON `hoja_vida_aspirante_oferta`.`hvao_psicologo`=TUPS.`usu_id` LEFT JOIN `hoja_vida_aspirante` TAS ON `hoja_vida_aspirante_oferta`.`hvao_aspirante`=TAS.`hva_id` LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCAR ON `hoja_vida_aspirante_oferta`.`hvao_cargo`=TCAR.`ac_id` LEFT JOIN `app_usuario` AS TDIR ON `hoja_vida_aspirante_oferta`.`hvao_director`=TDIR.`usu_id` LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TCC ON `hoja_vida_aspirante_oferta`.`hvao_area`=TCC.`aa_id`
             WHERE `hvao_aspirante`=:hvao_aspirante ORDER BY `hvao_registro_fecha` DESC';

            $parametros = [
                'hvao_aspirante' => $this->hvao_aspirante,
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

         public function listLast(){
            $sql='SELECT `hvao_id`, `hvao_aspirante`, `hvao_area`, `hvao_cargo`, `hvao_salario`, `hvao_psicologo`, `hvao_director`, `hvao_horario`, `hvao_debida_diligencia`, `hvao_prueba_confiabilidad`, `hvao_examen_medico`, `hvao_check_contratacion`, `hvao_fecha_diligencia`, `hvao_firma_ruta`, `hvao_estado`, `hvao_revisa_usuario`, `hvao_revisa_fecha`, `hvao_estado_fase_2`, `hvao_auxiliar_1`, `hvao_auxiliar_2`, `hvao_registro_usuario`, `hvao_registro_fecha`, TAS.`hva_identificacion`, TAS.`hva_nombres`, TAS.`hva_apellido_1`, TAS.`hva_apellido_2`, TAS.`hva_direccion`, TAS.`hva_barrio`, TAS.`hva_ciudad`, TAS.`hva_celular`, TAS.`hva_celular_2`, TAS.`hva_correo`, TAS.`hva_nacimiento_lugar`, TAS.`hva_nacimiento_fecha`, TAS.`hva_operador_internet`, TAS.`hva_genero`, TAS.`hva_estado_civil`, TAS.`hva_estado`, TAS.`hva_localidad`, TCAR.`ac_nombre`, TCC.`aa_nombre`, TUPS.`usu_nombres_apellidos` AS usuario_psicologo, TDIR.`usu_nombres_apellidos` AS usuario_director FROM `hoja_vida_aspirante_oferta` LEFT JOIN `app_usuario` AS TUPS ON `hoja_vida_aspirante_oferta`.`hvao_psicologo`=TUPS.`usu_id` LEFT JOIN `hoja_vida_aspirante` TAS ON `hoja_vida_aspirante_oferta`.`hvao_aspirante`=TAS.`hva_id` LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCAR ON `hoja_vida_aspirante_oferta`.`hvao_cargo`=TCAR.`ac_id` LEFT JOIN `app_usuario` AS TDIR ON `hoja_vida_aspirante_oferta`.`hvao_director`=TDIR.`usu_id` LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TCC ON `hoja_vida_aspirante_oferta`.`hvao_area`=TCC.`aa_id`
             WHERE `hvao_aspirante`=:hvao_aspirante ORDER BY `hvao_registro_fecha` DESC LIMIT 1';

            $parametros = [
                'hvao_aspirante' => $this->hvao_aspirante,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listAllReport(){
            $parametros = [
                // 'hvao_registro_fecha' => $this->hvao_registro_fecha,
                // 'hvao_registro_fecha_2' => $this->hvao_registro_fecha_2,
            ];

            if ($this->filtro_area!="" AND $this->filtro_area!="null" AND $this->filtro_area!="Todos") {
                $filtro_area_str="AND (`hvao_area`=:hvao_area)";
                $parametros_filtro_area = [
                    'hvao_area' => $this->filtro_area,
                ];
                $parametros = array_merge($parametros, $parametros_filtro_area);
            } else {
                $filtro_area_str="";
            }

            if ($this->filtro_cargo!="" AND $this->filtro_cargo!="null" AND $this->filtro_cargo!="Todos") {
                $filtro_cargo_str="AND (`hvao_cargo`=:hvao_cargo)";
                $parametros_filtro_cargo = [
                    'hvao_cargo' => $this->filtro_cargo,
                ];
                $parametros = array_merge($parametros, $parametros_filtro_cargo);
            } else {
                $filtro_cargo_str="";
            }

            if ($this->filtro_psicolologo!="" AND $this->filtro_psicolologo!="null" AND $this->filtro_psicolologo!="Todos") {
                $filtro_psicolologo_str="AND (`hvao_psicologo`=:hvao_psicologo)";
                $parametros_filtro_psicolologo = [
                    'hvao_psicologo' => $this->filtro_psicolologo,
                ];
                $parametros = array_merge($parametros, $parametros_filtro_psicolologo);
            } else {
                $filtro_psicolologo_str="";
            }

            if ($this->filtro_estado!="" AND $this->filtro_estado!="null" AND $this->filtro_estado!="Todos") {
                $filtro_estado_str="AND (`hvao_psicologo`=:hvao_psicologo)";
                $parametros_filtro_estado = [
                    'hvao_psicologo' => $this->filtro_estado,
                ];
                $parametros = array_merge($parametros, $parametros_filtro_estado);
            } else {
                $filtro_estado_str="";
            }

            $sql='SELECT `hvao_id`, `hvao_aspirante`, `hvao_area`, `hvao_cargo`, `hvao_salario`, `hvao_psicologo`, `hvao_director`, `hvao_horario`, `hvao_debida_diligencia`, `hvao_prueba_confiabilidad`, `hvao_examen_medico`, `hvao_check_contratacion`, `hvao_fecha_diligencia`, `hvao_firma_ruta`, `hvao_estado`, `hvao_revisa_usuario`, `hvao_revisa_fecha`, `hvao_estado_fase_2`, `hvao_auxiliar_1`, `hvao_auxiliar_2`, `hvao_registro_usuario`, `hvao_registro_fecha`, TAS.`hva_identificacion`, TAS.`hva_nombres`, TAS.`hva_apellido_1`, TAS.`hva_apellido_2`, TAS.`hva_direccion`, TAS.`hva_barrio`, TAS.`hva_ciudad`, TAS.`hva_celular`, TAS.`hva_celular_2`, TAS.`hva_correo`, TAS.`hva_nacimiento_lugar`, TAS.`hva_nacimiento_fecha`, TAS.`hva_operador_internet`, TAS.`hva_genero`, TAS.`hva_estado_civil`, TAS.`hva_estado`, TAS.`hva_localidad`, TCAR.`ac_nombre`, TCC.`aa_nombre`, TUPS.`usu_nombres_apellidos` AS usuario_psicologo, TDIR.`usu_nombres_apellidos` AS usuario_director, TCIUDAD.`ciu_departamento`, TCIUDAD.`ciu_municipio`, TCIUDADN.`ciu_departamento` AS nacimiento_ciu_departamento, TCIUDADN.`ciu_municipio` AS nacimiento_ciu_municipio FROM `hoja_vida_aspirante_oferta` LEFT JOIN `app_usuario` AS TUPS ON `hoja_vida_aspirante_oferta`.`hvao_psicologo`=TUPS.`usu_id` LEFT JOIN `hoja_vida_aspirante` TAS ON `hoja_vida_aspirante_oferta`.`hvao_aspirante`=TAS.`hva_id` LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCAR ON `hoja_vida_aspirante_oferta`.`hvao_cargo`=TCAR.`ac_id` LEFT JOIN `app_usuario` AS TDIR ON `hoja_vida_aspirante_oferta`.`hvao_director`=TDIR.`usu_id` LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TCC ON `hoja_vida_aspirante_oferta`.`hvao_area`=TCC.`aa_id`
            LEFT JOIN `app_ciudades` AS TCIUDAD ON TAS.`hva_ciudad`=TCIUDAD.`ciu_codigo`
            LEFT JOIN `app_ciudades` AS TCIUDADN ON TAS.`hva_nacimiento_lugar`=TCIUDADN.`ciu_codigo`
             WHERE 1=1 '.$filtro_area_str.' '.$filtro_cargo_str.' '.$filtro_psicolologo_str.' '.$filtro_estado_str;

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para listar usuarios
         */

         public function listDetail(){
            $sql='SELECT `hvao_id`, `hvao_aspirante`, `hvao_area`, `hvao_cargo`, `hvao_salario`, `hvao_psicologo`, `hvao_director`, `hvao_horario`, `hvao_debida_diligencia`, `hvao_prueba_confiabilidad`, `hvao_examen_medico`, `hvao_check_contratacion`, `hvao_fecha_diligencia`, `hvao_firma_ruta`, `hvao_estado`, `hvao_revisa_usuario`, `hvao_revisa_fecha`, `hvao_estado_fase_2`, `hvao_auxiliar_1`, `hvao_auxiliar_2`, `hvao_registro_usuario`, `hvao_registro_fecha`, TAS.`hva_identificacion`, TAS.`hva_nombres`, TAS.`hva_apellido_1`, TAS.`hva_apellido_2`, TAS.`hva_direccion`, TAS.`hva_barrio`, TAS.`hva_ciudad`, TAS.`hva_celular`, TAS.`hva_celular_2`, TAS.`hva_correo`, TAS.`hva_nacimiento_lugar`, TAS.`hva_nacimiento_fecha`, TAS.`hva_operador_internet`, TAS.`hva_genero`, TAS.`hva_estado_civil`, TAS.`hva_estado`, TAS.`hva_localidad`, TCAR.`ac_nombre`, TCC.`aa_nombre`, TUPS.`usu_nombres_apellidos` AS usuario_psicologo, TDIR.`usu_nombres_apellidos` AS usuario_director FROM `hoja_vida_aspirante_oferta` LEFT JOIN `app_usuario` AS TUPS ON `hoja_vida_aspirante_oferta`.`hvao_psicologo`=TUPS.`usu_id` LEFT JOIN `hoja_vida_aspirante` TAS ON `hoja_vida_aspirante_oferta`.`hvao_aspirante`=TAS.`hva_id` LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCAR ON `hoja_vida_aspirante_oferta`.`hvao_cargo`=TCAR.`ac_id` LEFT JOIN `app_usuario` AS TDIR ON `hoja_vida_aspirante_oferta`.`hvao_director`=TDIR.`usu_id` LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TCC ON `hoja_vida_aspirante_oferta`.`hvao_area`=TCC.`aa_id`
             WHERE `hvao_id`=:hvao_id';

            $parametros = [
                'hvao_id' => $this->hvao_id,
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
            $sql='SELECT `hvao_id`, `hvao_aspirante`, `hvao_area`, `hvao_cargo`, `hvao_salario`, `hvao_psicologo`, `hvao_director`, `hvao_horario`, `hvao_debida_diligencia`, `hvao_prueba_confiabilidad`, `hvao_examen_medico`, `hvao_check_contratacion`, `hvao_fecha_diligencia`, `hvao_firma_ruta`, `hvao_estado`, `hvao_revisa_usuario`, `hvao_revisa_fecha`, `hvao_estado_fase_2`, `hvao_auxiliar_1`, `hvao_auxiliar_2`, `hvao_registro_usuario`, `hvao_registro_fecha`, TAS.`hva_identificacion`, TAS.`hva_nombres`, TAS.`hva_apellido_1`, TAS.`hva_apellido_2`, TAS.`hva_direccion`, TAS.`hva_barrio`, TAS.`hva_ciudad`, TAS.`hva_celular`, TAS.`hva_celular_2`, TAS.`hva_correo`, TAS.`hva_nacimiento_lugar`, TAS.`hva_nacimiento_fecha`, TAS.`hva_operador_internet`, TAS.`hva_genero`, TAS.`hva_estado_civil`, TAS.`hva_estado`, TAS.`hva_localidad`, TAS.`hva_auxiliar_1`, TAS.`hva_auxiliar_2`, TAS.`hva_auxiliar_5` FROM `hoja_vida_aspirante_oferta` LEFT JOIN `hoja_vida_aspirante` TAS ON `hoja_vida_aspirante_oferta`.`hvao_aspirante`=TAS.`hva_id`
             WHERE `hvao_id`=:hvao_id';

            $parametros = [
                'hvao_id' => $this->hvao_id,
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
            $sql='INSERT INTO `hoja_vida_aspirante_oferta`(`hvao_aspirante`, `hvao_area`, `hvao_cargo`, `hvao_salario`, `hvao_psicologo`, `hvao_director`, `hvao_horario`, `hvao_debida_diligencia`, `hvao_prueba_confiabilidad`, `hvao_examen_medico`, `hvao_check_contratacion`, `hvao_fecha_diligencia`, `hvao_firma_ruta`, `hvao_estado`, `hvao_revisa_usuario`, `hvao_revisa_fecha`, `hvao_estado_fase_2`, `hvao_auxiliar_1`, `hvao_auxiliar_2`, `hvao_registro_usuario`) VALUES (:hvao_aspirante, :hvao_area, :hvao_cargo, :hvao_salario, :hvao_psicologo, :hvao_director, :hvao_horario, :hvao_debida_diligencia, :hvao_prueba_confiabilidad, :hvao_examen_medico, :hvao_check_contratacion, :hvao_fecha_diligencia, :hvao_firma_ruta, :hvao_estado, :hvao_revisa_usuario, :hvao_revisa_fecha, :hvao_estado_fase_2, :hvao_auxiliar_1, :hvao_auxiliar_2, :hvao_registro_usuario)';

            $parametros = [
                'hvao_aspirante' => $this->hvao_aspirante,
                'hvao_area' => $this->hvao_area,
                'hvao_cargo' => $this->hvao_cargo,
                'hvao_salario' => $this->hvao_salario,
                'hvao_psicologo' => $this->hvao_psicologo,
                'hvao_director' => $this->hvao_director,
                'hvao_horario' => $this->hvao_horario,
                'hvao_debida_diligencia' => $this->hvao_debida_diligencia,
                'hvao_prueba_confiabilidad' => $this->hvao_prueba_confiabilidad,
                'hvao_examen_medico' => $this->hvao_examen_medico,
                'hvao_check_contratacion' => $this->hvao_check_contratacion,
                'hvao_fecha_diligencia' => $this->hvao_fecha_diligencia,
                'hvao_firma_ruta' => $this->hvao_firma_ruta,
                'hvao_estado' => $this->hvao_estado,
                'hvao_revisa_usuario' => $this->hvao_revisa_usuario,
                'hvao_revisa_fecha' => $this->hvao_revisa_fecha,
                'hvao_estado_fase_2' => $this->hvao_estado_fase_2,
                'hvao_auxiliar_1' => $this->hvao_auxiliar_1,
                'hvao_auxiliar_2' => $this->hvao_auxiliar_2,
                'hvao_registro_usuario' => $this->hvao_registro_usuario,
            ];

            try {
                return ($this->hvao_id = parent::query($sql, $parametros)) ? $this->hvao_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function delete(){
            $sql='DELETE FROM `hoja_vida_aspirante_oferta` WHERE `hvao_aspirante`=:hvao_aspirante';

            $parametros = [
                'hvao_aspirante' => $this->hvao_aspirante,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateEstado(){
            $sql='UPDATE `hoja_vida_aspirante_oferta` SET `hvao_estado`=:hvao_estado, `hvao_fecha_diligencia`=:hvao_fecha_diligencia WHERE `hvao_id`=:hvao_id';

            $parametros = [
                'hvao_id' => $this->hvao_id,
                'hvao_estado' => $this->hvao_estado,
                'hvao_fecha_diligencia' => $this->hvao_fecha_diligencia,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateEstadoVinculacion(){
            $sql='UPDATE `hoja_vida_aspirante_oferta` SET `hvao_estado`=:hvao_estado WHERE `hvao_id`=:hvao_id';

            $parametros = [
                'hvao_id' => $this->hvao_id,
                'hvao_estado' => $this->hvao_estado,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateOferta(){
            $sql='UPDATE `hoja_vida_aspirante_oferta` SET `hvao_estado`=:hvao_estado, `hvao_debida_diligencia`=:hvao_debida_diligencia, `hvao_prueba_confiabilidad`=:hvao_prueba_confiabilidad, `hvao_examen_medico`=:hvao_examen_medico, `hvao_check_contratacion`=:hvao_check_contratacion, `hvao_revisa_usuario`=:hvao_revisa_usuario, `hvao_revisa_fecha`=:hvao_revisa_fecha, `hvao_estado_fase_2`=:hvao_estado_fase_2, `hvao_auxiliar_1`=:hvao_auxiliar_1, `hvao_auxiliar_2`=:hvao_auxiliar_2 WHERE `hvao_id`=:hvao_id';

            $parametros = [
                'hvao_id' => $this->hvao_id,
                'hvao_estado' => $this->hvao_estado,
                'hvao_debida_diligencia' => $this->hvao_debida_diligencia,
                'hvao_prueba_confiabilidad' => $this->hvao_prueba_confiabilidad,
                'hvao_examen_medico' => $this->hvao_examen_medico,
                'hvao_check_contratacion' => $this->hvao_check_contratacion,
                'hvao_revisa_usuario' => $this->hvao_revisa_usuario,
                'hvao_revisa_fecha' => $this->hvao_revisa_fecha,
                'hvao_estado_fase_2' => $this->hvao_estado_fase_2,
                'hvao_auxiliar_1' => $this->hvao_auxiliar_1,
                'hvao_auxiliar_2' => $this->hvao_auxiliar_2,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateOfertaMasivo(){
            $sql='UPDATE `hoja_vida_aspirante_oferta` SET `hvao_estado`=:hvao_estado, `hvao_check_contratacion`=:hvao_check_contratacion WHERE `hvao_id`=:hvao_id';

            $parametros = [
                'hvao_id' => $this->hvao_id,
                'hvao_estado' => $this->hvao_estado,
                'hvao_check_contratacion' => $this->hvao_check_contratacion,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateOfertaEstado(){
            $sql='UPDATE `hoja_vida_aspirante_oferta` SET `hvao_estado_fase_2`=:hvao_estado_fase_2 WHERE `hvao_id`=:hvao_id';

            $parametros = [
                'hvao_id' => $this->hvao_id,
                'hvao_estado_fase_2' => $this->hvao_estado_fase_2,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }