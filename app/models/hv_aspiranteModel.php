<?php
    class hv_aspiranteModel extends Model {
        public $hva_id;
        public $hva_identificacion;
        public $hva_nombres;
        public $hva_nombres_2;
        public $hva_apellido_1;
        public $hva_apellido_2;
        public $hva_direccion;
        public $hva_barrio;
        public $hva_ciudad;
        public $hva_celular;
        public $hva_celular_2;
        public $hva_correo;
        public $hva_correo_corporativo;
        public $hva_nacimiento_lugar;
        public $hva_nacimiento_fecha;
        public $hva_operador_internet;
        public $hva_genero;
        public $hva_estado_civil;
        public $hva_estado;
        public $hva_localidad;
        public $hva_primer_empleo;
        public $hva_auxiliar_1;
        public $hva_auxiliar_2;
        public $hva_auxiliar_3;
        public $hva_auxiliar_4;
        public $hva_auxiliar_5;//Fecha de expedición del documento
        public $hva_ingreso_fecha;
        public $hva_retiro_fecha;
        public $hva_retiro_motivo;
        public $hva_observaciones;
        public $hva_oferta_id;
        public $hva_autorizaciones_id;
        public $hva_emergencia_id;
        public $hva_etica_id;
        public $hva_financiera_id;
        public $hva_informacion_id;
        public $hva_publico_id;
        public $hva_seguridad_social_id;
        public $hva_actualiza_usuario;
        public $hva_actualiza_fecha;
        public $hva_registro_usuario;
        public $hva_registro_fecha;
        public $hva_registro_fecha_2;
        public $filtro_bandeja='';
        public $filtro_perfil='';
        public $hvao_area;
        public $hvao_cargo;
        public $hvao_psicologo;
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;

        /**
         * Método para listar usuarios
         */

        public function list(){
            $parametros = [
                'offset' => $this->offset,
                'limite' => $this->limite,
            ];

            if ($this->filtro_bandeja!="" AND $this->filtro_bandeja!="null") {
                $filtro_bandeja_str="";
                if(count($this->filtro_bandeja)>0) {
                    for ($i=0; $i < count($this->filtro_bandeja); $i++) { 
                        $filtro_bandeja_str.=" `hva_estado`=:hva_estado_".$i." OR ";
                        $parametros_filtro = [
                            'hva_estado_'.$i => $this->filtro_bandeja[$i],
                        ];
                        $parametros = array_merge($parametros, $parametros_filtro);
                    }
                    $filtro_bandeja_str="AND (".substr($filtro_bandeja_str, 0, -3).")";
                }
            } else {
                $filtro_bandeja_str="";
            }

            if ($this->filtro_perfil!="" AND $this->filtro_perfil!="null" AND $this->filtro_perfil=="Visitante") {
                // $filtro_perfil_str=" AND `ea_despacho_escalafon`=:ea_despacho_escalafon AND (`hva_estado` LIKE :hva_estado_depacho)";
                // $parametros_filtro = [
                //     'ea_despacho_escalafon' => $this->ea_despacho_escalafon,
                //     'hva_estado_depacho' => '%Resolución%',
                // ];
                // $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_perfil_str="";
            }

            if ($this->filtro!="" AND $this->filtro!="null") {
                $filtro_str="AND (`hva_identificacion` LIKE :hva_identificacion OR `hva_nombres` LIKE :hva_nombres OR `hva_apellido_1` LIKE :hva_apellido_1 OR `hva_apellido_2` LIKE :hva_apellido_2)";
                $parametros_filtro = [
                    'hva_identificacion' => '%'.$this->filtro.'%',
                    'hva_nombres' => '%'.$this->filtro.'%',
                    'hva_apellido_1' => '%'.$this->filtro.'%',
                    'hva_apellido_2' => '%'.$this->filtro.'%',
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_str="";
            }

            $sql='SELECT `hva_id`, `hva_identificacion`, `hva_nombres`, `hva_nombres_2`, `hva_apellido_1`, `hva_apellido_2`, `hva_direccion`, `hva_barrio`, `hva_ciudad`, `hva_celular`, `hva_celular_2`, `hva_correo`, `hva_correo_corporativo`, `hva_nacimiento_lugar`, `hva_nacimiento_fecha`, `hva_operador_internet`, `hva_genero`, `hva_estado_civil`, `hva_estado`, `hva_localidad`, `hva_primer_empleo`, `hva_auxiliar_1`, `hva_auxiliar_2`, `hva_auxiliar_3`, `hva_auxiliar_4`, `hva_auxiliar_5`, `hva_ingreso_fecha`, `hva_retiro_fecha`, `hva_retiro_motivo`, `hva_observaciones`, `hva_oferta_id`, `hva_autorizaciones_id`, `hva_emergencia_id`, `hva_etica_id`, `hva_financiera_id`, `hva_informacion_id`, `hva_publico_id`, `hva_seguridad_social_id`, `hva_actualiza_usuario`, `hva_actualiza_fecha`, `hva_registro_usuario`, `hva_registro_fecha`, TUR.`usu_nombres_apellidos` AS usuario_registro, TUA.`usu_nombres_apellidos` AS usuario_actualiza, TUPS.`usu_nombres_apellidos` AS usuario_psicologo, TDIR.`usu_nombres_apellidos` AS usuario_director, TCIUDAD.`ciu_departamento`, TCIUDAD.`ciu_municipio`, TCIUDADN.`ciu_departamento` AS nacimiento_ciu_departamento, TCIUDADN.`ciu_municipio` AS nacimiento_ciu_municipio, TOF.`hvao_area`, TOF.`hvao_cargo`, TOF.`hvao_salario`, TOF.`hvao_psicologo`, TOF.hvao_director, TOF.`hvao_horario`, TOF.`hvao_debida_diligencia`, TOF.`hvao_prueba_confiabilidad`, TOF.`hvao_examen_medico`, TOF.`hvao_check_contratacion`, TOF.`hvao_fecha_diligencia`, TOF.`hvao_firma_ruta`, TOF.`hvao_estado`, TOF.`hvao_registro_usuario`, TOF.`hvao_registro_fecha`, TCAR.`ac_nombre`, TCC.`aa_nombre`, TBARRIO.`ciub_localidad`, TBARRIO.`ciub_barrio`, TAUTO.`hvada_veracidad`, TAUTO.`hvada_origen_fondos`, TAUTO.`hvada_proteccion_datos`, TAUTO.`hvada_tratamiento_datos`, THV.`hvp_usuario_nt` FROM `hoja_vida_aspirante` 
            LEFT JOIN `app_usuario` AS TUR ON `hoja_vida_aspirante`.`hva_registro_usuario`=TUR.`usu_id` 
            LEFT JOIN `app_usuario` AS TUA ON `hoja_vida_aspirante`.`hva_actualiza_usuario`=TUA.`usu_id`
            LEFT JOIN `hoja_vida_aspirante_oferta` AS TOF ON `hoja_vida_aspirante`.`hva_oferta_id`=TOF.`hvao_id`
            LEFT JOIN `app_usuario` AS TUPS ON TOF.`hvao_psicologo`=TUPS.`usu_id` 
            LEFT JOIN `app_usuario` AS TDIR ON TOF.`hvao_director`=TDIR.`usu_id` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCAR ON TOF.`hvao_cargo`=TCAR.`ac_id`
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TCC ON TOF.`hvao_area`=TCC.`aa_id`
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_aspirante`.`hva_ciudad`=TCIUDAD.`ciu_codigo`
            LEFT JOIN `app_ciudades` AS TCIUDADN ON `hoja_vida_aspirante`.`hva_nacimiento_lugar`=TCIUDADN.`ciu_codigo`
            LEFT JOIN `app_ciudades_barrios` AS TBARRIO ON `hoja_vida_aspirante`.`hva_barrio`=TBARRIO.`ciub_id`
            LEFT JOIN `hoja_vida_aspirante_autorizaciones` AS TAUTO ON `hoja_vida_aspirante`.`hva_autorizaciones_id`=TAUTO.`hvada_id`
            LEFT JOIN `hoja_vida_personal` AS THV ON `hoja_vida_aspirante`.`hva_id`=THV.`hvp_aspirante_id`
             WHERE 1=1 '.$filtro_bandeja_str.' '.$filtro_str.' '.$filtro_perfil_str.' LIMIT :offset,:limite';

            //  "SELECT `hva_id`, `hva_identificacion`, `hva_nombres`, `hva_nombres_2`, `hva_apellido_1`, `hva_apellido_2`, `hva_direccion`, `hva_barrio`, `hva_ciudad`, `hva_celular`, `hva_celular_2`, `hva_correo`, `hva_correo_corporativo`, `hva_nacimiento_lugar`, `hva_nacimiento_fecha`, `hva_operador_internet`, `hva_genero`, `hva_estado_civil`, `hva_estado`, `hva_localidad`, `hva_primer_empleo`, `hva_auxiliar_1`, `hva_auxiliar_2`, `hva_auxiliar_3`, `hva_auxiliar_4`, `hva_auxiliar_5`, `hva_ingreso_fecha`, `hva_retiro_fecha`, `hva_retiro_motivo`, `hva_observaciones`, `hva_oferta_id`, `hva_autorizaciones_id`, `hva_emergencia_id`, `hva_etica_id`, `hva_financiera_id`, `hva_informacion_id`, `hva_publico_id`, `hva_seguridad_social_id`, `hva_actualiza_usuario`, `hva_actualiza_fecha`, `hva_registro_usuario`, `hva_registro_fecha`, TUR.`usu_nombres_apellidos` AS usuario_registro, TUA.`usu_nombres_apellidos` AS usuario_actualiza, TUPS.`usu_nombres_apellidos` AS usuario_psicologo, 
            // TCIUDAD.`ciu_departamento`, TCIUDAD.`ciu_municipio`, MAXID.idmax, TOF.`hvao_area`, TOF.`hvao_cargo`, TOF.`hvao_salario`, TOF.`hvao_psicologo`, TOF.`hvao_horario`, TOF.`hvao_debida_diligencia`, TOF.`hvao_prueba_confiabilidad`, TOF.`hvao_examen_medico`, TOF.`hvao_check_contratacion`, TOF.`hvao_fecha_diligencia`, TOF.`hvao_firma_ruta`, TOF.`hvao_estado`, TOF.`hvao_registro_usuario`, TOF.`hvao_registro_fecha`, TCAR.`ac_nombre`, TCC.`aa_nombre`, TBARRIO.`ciub_localidad`, TBARRIO.`ciub_barrio`, TAUTO.`hvada_veracidad`, TAUTO.`hvada_origen_fondos`, TAUTO.`hvada_proteccion_datos`, TAUTO.`hvada_tratamiento_datos`, THV.`hvp_usuario_nt` FROM `hoja_vida_aspirante` LEFT JOIN `app_usuario` AS TUR ON `hoja_vida_aspirante`.`hva_registro_usuario`=TUR.`usu_id` LEFT JOIN `app_usuario` AS TUA ON `hoja_vida_aspirante`.`hva_actualiza_usuario`=TUA.`usu_id` LEFT JOIN (SELECT `hvao_aspirante`, MAX(`hvao_id`) AS idmax FROM `hoja_vida_aspirante_oferta` GROUP BY `hvao_aspirante`) AS MAXID ON `hoja_vida_aspirante`.`hva_id`=MAXID.`hvao_aspirante` LEFT JOIN `hoja_vida_aspirante_oferta` AS TOF ON MAXID.idmax=TOF.`hvao_id` LEFT JOIN `app_usuario` AS TUPS ON TOF.`hvao_psicologo`=TUPS.`usu_id` LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCAR ON TOF.`hvao_cargo`=TCAR.`ac_id` LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TCC ON TOF.`hvao_area`=TCC.`aa_id`
            // LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_aspirante`.`hva_ciudad`=TCIUDAD.`ciu_codigo`
            // LEFT JOIN `app_ciudades_barrios` AS TBARRIO ON `hoja_vida_aspirante`.`hva_barrio`=TBARRIO.`ciub_id`
            // LEFT JOIN (SELECT * FROM hoja_vida_aspirante_autorizaciones AS TAUTOMAX WHERE TAUTOMAX.hvada_id = (SELECT MAX(a2.hvada_id) FROM hoja_vida_aspirante_autorizaciones AS a2 WHERE a2.hvada_aspirante = TAUTOMAX.hvada_aspirante)) AS TAUTO ON hoja_vida_aspirante.hva_id = TAUTO.hvada_aspirante
            // LEFT JOIN `hoja_vida_personal` AS THV ON `hoja_vida_aspirante`.`hva_id`=THV.`hvp_aspirante_id`"

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listCount(){
            $parametros = [
            ];
            
            if ($this->filtro_bandeja!="" AND $this->filtro_bandeja!="null") {
                $filtro_bandeja_str="";
                if(count($this->filtro_bandeja)>0) {
                    for ($i=0; $i < count($this->filtro_bandeja); $i++) { 
                        $filtro_bandeja_str.=" `hva_estado`=:hva_estado_".$i." OR ";
                        $parametros_filtro = [
                            'hva_estado_'.$i => $this->filtro_bandeja[$i],
                        ];
                        $parametros = array_merge($parametros, $parametros_filtro);
                    }
                    $filtro_bandeja_str="AND (".substr($filtro_bandeja_str, 0, -3).")";
                }
            } else {
                $filtro_bandeja_str="";
            }

            if ($this->filtro_perfil!="" AND $this->filtro_perfil!="null" AND $this->filtro_perfil=="Visitante") {
                // $filtro_perfil_str=" AND `ea_despacho_escalafon`=:ea_despacho_escalafon AND (`hva_estado` LIKE :hva_estado_depacho)";
                // $parametros_filtro = [
                //     'ea_despacho_escalafon' => $this->ea_despacho_escalafon,
                //     'hva_estado_depacho' => '%Resolución%',
                // ];
                // $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_perfil_str="";
            }
            
            if ($this->filtro!="" AND $this->filtro!="null") {
                $filtro_str="AND (`hva_identificacion` LIKE :hva_identificacion OR `hva_nombres` LIKE :hva_nombres OR `hva_apellido_1` LIKE :hva_apellido_1 OR `hva_apellido_2` LIKE :hva_apellido_2)";
                $parametros_filtro = [
                    'hva_identificacion' => '%'.$this->filtro.'%',
                    'hva_nombres' => '%'.$this->filtro.'%',
                    'hva_apellido_1' => '%'.$this->filtro.'%',
                    'hva_apellido_2' => '%'.$this->filtro.'%',
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_str="";
            }

            $sql='SELECT `hva_id`, `hva_identificacion`, `hva_nombres`, `hva_nombres_2`, `hva_apellido_1`, `hva_apellido_2`, `hva_direccion`, `hva_barrio`, `hva_ciudad`, `hva_celular`, `hva_celular_2`, `hva_correo`, `hva_correo_corporativo`, `hva_nacimiento_lugar`, `hva_nacimiento_fecha`, `hva_operador_internet`, `hva_genero`, `hva_estado_civil`, `hva_estado`, `hva_localidad`, `hva_primer_empleo`, `hva_auxiliar_1`, `hva_auxiliar_2`, `hva_auxiliar_3`, `hva_auxiliar_4`, `hva_auxiliar_5`, `hva_ingreso_fecha`, `hva_retiro_fecha`, `hva_retiro_motivo`, `hva_observaciones`, `hva_oferta_id`, `hva_autorizaciones_id`, `hva_emergencia_id`, `hva_etica_id`, `hva_financiera_id`, `hva_informacion_id`, `hva_publico_id`, `hva_seguridad_social_id`, `hva_actualiza_usuario`, `hva_actualiza_fecha`, `hva_registro_usuario`, `hva_registro_fecha`, TUR.`usu_nombres_apellidos` AS usuario_registro, TUA.`usu_nombres_apellidos` AS usuario_actualiza, TUPS.`usu_nombres_apellidos` AS usuario_psicologo, TDIR.`usu_nombres_apellidos` AS usuario_director, TOF.`hvao_area`, TOF.`hvao_cargo`, TOF.`hvao_salario`, TOF.`hvao_psicologo`, TOF.hvao_director, TOF.`hvao_horario`, TOF.`hvao_debida_diligencia`, TOF.`hvao_prueba_confiabilidad`, TOF.`hvao_examen_medico`, TOF.`hvao_check_contratacion`, TOF.`hvao_fecha_diligencia`, TOF.`hvao_firma_ruta`, TOF.`hvao_estado`, TOF.`hvao_registro_usuario`, TOF.`hvao_registro_fecha` FROM `hoja_vida_aspirante` 
            LEFT JOIN `app_usuario` AS TUR ON `hoja_vida_aspirante`.`hva_registro_usuario`=TUR.`usu_id` 
            LEFT JOIN `app_usuario` AS TUA ON `hoja_vida_aspirante`.`hva_actualiza_usuario`=TUA.`usu_id`
            LEFT JOIN `hoja_vida_aspirante_oferta` AS TOF ON `hoja_vida_aspirante`.`hva_oferta_id`=TOF.`hvao_id`
            LEFT JOIN `app_usuario` AS TUPS ON TOF.`hvao_psicologo`=TUPS.`usu_id` 
            LEFT JOIN `app_usuario` AS TDIR ON TOF.`hvao_director`=TDIR.`usu_id` 
             WHERE 1=1 '.$filtro_bandeja_str.' '.$filtro_str.' '.$filtro_perfil_str.'';

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listDetail(){
            $sql='SELECT `hva_id`, `hva_identificacion`, `hva_nombres`, `hva_nombres_2`, `hva_apellido_1`, `hva_apellido_2`, `hva_direccion`, `hva_barrio`, `hva_ciudad`, `hva_celular`, `hva_celular_2`, `hva_correo`, `hva_correo_corporativo`, `hva_nacimiento_lugar`, `hva_nacimiento_fecha`, `hva_operador_internet`, `hva_genero`, `hva_estado_civil`, `hva_estado`, `hva_localidad`, `hva_primer_empleo`, `hva_auxiliar_1`, `hva_auxiliar_2`, `hva_auxiliar_3`, `hva_auxiliar_4`, `hva_auxiliar_5`, `hva_ingreso_fecha`, `hva_retiro_fecha`, `hva_retiro_motivo`, `hva_observaciones`, `hva_oferta_id`, `hva_autorizaciones_id`, `hva_emergencia_id`, `hva_etica_id`, `hva_financiera_id`, `hva_informacion_id`, `hva_publico_id`, `hva_seguridad_social_id`, `hva_actualiza_usuario`, `hva_actualiza_fecha`, `hva_registro_usuario`, `hva_registro_fecha`, TUR.`usu_nombres_apellidos` AS usuario_registro, TUA.`usu_nombres_apellidos` AS usuario_actualiza, TUPS.`usu_nombres_apellidos` AS usuario_psicologo, TDIR.`usu_nombres_apellidos` AS usuario_director, TCIUDAD.`ciu_departamento`, TCIUDAD.`ciu_municipio`, TCIUDADN.`ciu_departamento` AS nacimiento_ciu_departamento, TCIUDADN.`ciu_municipio` AS nacimiento_ciu_municipio, TOF.`hvao_area`, TOF.`hvao_cargo`, TOF.`hvao_salario`, TOF.`hvao_psicologo`, TOF.hvao_director, TOF.`hvao_horario`, TOF.`hvao_debida_diligencia`, TOF.`hvao_prueba_confiabilidad`, TOF.`hvao_examen_medico`, TOF.`hvao_check_contratacion`, TOF.`hvao_fecha_diligencia`, TOF.`hvao_firma_ruta`, TOF.`hvao_estado`, TOF.`hvao_registro_usuario`, TOF.`hvao_registro_fecha`, TCAR.`ac_nombre`, TCC.`aa_nombre`, TBARRIO.`ciub_localidad`, TBARRIO.`ciub_barrio`, TAUTO.`hvada_veracidad`, TAUTO.`hvada_origen_fondos`, TAUTO.`hvada_proteccion_datos`, TAUTO.`hvada_tratamiento_datos`, THV.`hvp_usuario_nt` FROM `hoja_vida_aspirante` 
            LEFT JOIN `app_usuario` AS TUR ON `hoja_vida_aspirante`.`hva_registro_usuario`=TUR.`usu_id` 
            LEFT JOIN `app_usuario` AS TUA ON `hoja_vida_aspirante`.`hva_actualiza_usuario`=TUA.`usu_id`
            LEFT JOIN `hoja_vida_aspirante_oferta` AS TOF ON `hoja_vida_aspirante`.`hva_oferta_id`=TOF.`hvao_id`
            LEFT JOIN `app_usuario` AS TUPS ON TOF.`hvao_psicologo`=TUPS.`usu_id` 
            LEFT JOIN `app_usuario` AS TDIR ON TOF.`hvao_director`=TDIR.`usu_id` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCAR ON TOF.`hvao_cargo`=TCAR.`ac_id`
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TCC ON TOF.`hvao_area`=TCC.`aa_id`
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_aspirante`.`hva_ciudad`=TCIUDAD.`ciu_codigo`
            LEFT JOIN `app_ciudades` AS TCIUDADN ON `hoja_vida_aspirante`.`hva_nacimiento_lugar`=TCIUDADN.`ciu_codigo`
            LEFT JOIN `app_ciudades_barrios` AS TBARRIO ON `hoja_vida_aspirante`.`hva_barrio`=TBARRIO.`ciub_id`
            LEFT JOIN `hoja_vida_aspirante_autorizaciones` AS TAUTO ON `hoja_vida_aspirante`.`hva_autorizaciones_id`=TAUTO.`hvada_id`
            LEFT JOIN `hoja_vida_personal` AS THV ON `hoja_vida_aspirante`.`hva_id`=THV.`hvp_aspirante_id`
             WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listAllReport(){
            $parametros = [
                // 'hva_registro_fecha' => $this->hva_registro_fecha,
                // 'hva_registro_fecha_2' => $this->hva_registro_fecha_2,
            ];
            
            if ($this->hvao_area!="" AND $this->hvao_area!="null" AND $this->hvao_area!="Todos") {
                $filtro_hvao_area_str=" AND TOF.`hvao_area`=:hvao_area";
                $parametros_filtro = [
                    'hvao_area' => $this->hvao_area,
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_hvao_area_str="";
            }

            if ($this->hvao_cargo!="" AND $this->hvao_cargo!="null" AND $this->hvao_cargo!="Todos") {
                $filtro_hvao_cargo_str=" AND TOF.`hvao_cargo`=:hvao_cargo";
                $parametros_filtro = [
                    'hvao_cargo' => $this->hvao_cargo,
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_hvao_cargo_str="";
            }

            if ($this->hvao_psicologo!="" AND $this->hvao_psicologo!="null" AND $this->hvao_psicologo!="Todos") {
                $filtro_hvao_psicologo_str=" AND TOF.`hvao_psicologo`=:hvao_psicologo";
                $parametros_filtro = [
                    'hvao_psicologo' => $this->hvao_psicologo,
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_hvao_psicologo_str="";
            }

            if ($this->hva_estado!="" AND $this->hva_estado!="null" AND $this->hva_estado!="Todos") {
                $filtro_hva_estado_str=" AND `hva_estado`=:hva_estado";
                $parametros_filtro = [
                    'hva_estado' => $this->hva_estado,
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_hva_estado_str="";
            }

            if ($this->hva_registro_fecha!="" AND $this->hva_registro_fecha!="null" AND $this->hva_registro_fecha_2!="" AND $this->hva_registro_fecha_2!="null") {
                if ($this->filtro_perfil=='Contratación' OR $this->filtro_perfil=='Gestión Usuarios') {
                    $filtro_fecha_ingreso_str=" AND `hva_ingreso_fecha`>=:hva_registro_fecha AND `hva_ingreso_fecha`<=:hva_registro_fecha_2";
                } else {
                    $filtro_fecha_ingreso_str=" AND `hva_registro_fecha`>=:hva_registro_fecha AND `hva_registro_fecha`<=:hva_registro_fecha_2";
                }
                
                $parametros_filtro = [
                    'hva_registro_fecha' => $this->hva_registro_fecha,
                    'hva_registro_fecha_2' => $this->hva_registro_fecha_2,
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_fecha_ingreso_str="";
            }

            $sql='SELECT `hva_id`, `hva_identificacion`, `hva_nombres`, `hva_nombres_2`, `hva_apellido_1`, `hva_apellido_2`, `hva_direccion`, `hva_barrio`, `hva_ciudad`, `hva_celular`, `hva_celular_2`, `hva_correo`, `hva_correo_corporativo`, `hva_nacimiento_lugar`, `hva_nacimiento_fecha`, `hva_operador_internet`, `hva_genero`, `hva_estado_civil`, `hva_estado`, `hva_localidad`, `hva_primer_empleo`, `hva_auxiliar_1`, `hva_auxiliar_2`, `hva_auxiliar_3`, `hva_auxiliar_4`, `hva_auxiliar_5`, `hva_ingreso_fecha`, `hva_retiro_fecha`, `hva_retiro_motivo`, `hva_observaciones`, `hva_oferta_id`, `hva_autorizaciones_id`, `hva_emergencia_id`, `hva_etica_id`, `hva_financiera_id`, `hva_informacion_id`, `hva_publico_id`, `hva_seguridad_social_id`, `hva_actualiza_usuario`, `hva_actualiza_fecha`, `hva_registro_usuario`, `hva_registro_fecha`, TUR.`usu_nombres_apellidos` AS usuario_registro, TUA.`usu_nombres_apellidos` AS usuario_actualiza, TUPS.`usu_nombres_apellidos` AS usuario_psicologo, TDIR.`usu_nombres_apellidos` AS usuario_director, TCIUDAD.`ciu_departamento`, TCIUDAD.`ciu_municipio`, TCIUDADN.`ciu_departamento` AS nacimiento_ciu_departamento, TCIUDADN.`ciu_municipio` AS nacimiento_ciu_municipio, TOF.`hvao_area`, TOF.`hvao_cargo`, TOF.`hvao_salario`, TOF.`hvao_psicologo`, TOF.hvao_director, TOF.`hvao_horario`, TOF.`hvao_debida_diligencia`, TOF.`hvao_prueba_confiabilidad`, TOF.`hvao_examen_medico`, TOF.`hvao_check_contratacion`, TOF.`hvao_fecha_diligencia`, TOF.`hvao_firma_ruta`, TOF.`hvao_estado`, TOF.`hvao_registro_usuario`, TOF.`hvao_registro_fecha`, TCAR.`ac_nombre`, TCC.`aa_nombre`, TBARRIO.`ciub_localidad`, TBARRIO.`ciub_barrio`, TAUTO.`hvada_veracidad`, TAUTO.`hvada_origen_fondos`, TAUTO.`hvada_proteccion_datos`, TAUTO.`hvada_tratamiento_datos`, THV.`hvp_usuario_nt` FROM `hoja_vida_aspirante` 
            LEFT JOIN `app_usuario` AS TUR ON `hoja_vida_aspirante`.`hva_registro_usuario`=TUR.`usu_id` 
            LEFT JOIN `app_usuario` AS TUA ON `hoja_vida_aspirante`.`hva_actualiza_usuario`=TUA.`usu_id`
            LEFT JOIN `hoja_vida_aspirante_oferta` AS TOF ON `hoja_vida_aspirante`.`hva_oferta_id`=TOF.`hvao_id`
            LEFT JOIN `app_usuario` AS TUPS ON TOF.`hvao_psicologo`=TUPS.`usu_id` 
            LEFT JOIN `app_usuario` AS TDIR ON TOF.`hvao_director`=TDIR.`usu_id` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCAR ON TOF.`hvao_cargo`=TCAR.`ac_id`
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TCC ON TOF.`hvao_area`=TCC.`aa_id`
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_aspirante`.`hva_ciudad`=TCIUDAD.`ciu_codigo`
            LEFT JOIN `app_ciudades` AS TCIUDADN ON `hoja_vida_aspirante`.`hva_nacimiento_lugar`=TCIUDADN.`ciu_codigo`
            LEFT JOIN `app_ciudades_barrios` AS TBARRIO ON `hoja_vida_aspirante`.`hva_barrio`=TBARRIO.`ciub_id`
            LEFT JOIN `hoja_vida_aspirante_autorizaciones` AS TAUTO ON `hoja_vida_aspirante`.`hva_autorizaciones_id`=TAUTO.`hvada_id`
            LEFT JOIN `hoja_vida_personal` AS THV ON `hoja_vida_aspirante`.`hva_id`=THV.`hvp_aspirante_id`
             WHERE 1=1 '.$filtro_hvao_area_str.' '.$filtro_hvao_cargo_str.' '.$filtro_hvao_psicologo_str.' '.$filtro_hva_estado_str.' '.$filtro_fecha_ingreso_str;
            
            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listAllReportVinculados(){
            $parametros = [
                // 'hva_registro_fecha' => $this->hva_registro_fecha,
                // 'hva_registro_fecha_2' => $this->hva_registro_fecha_2,
                'hva_estado_1' => 'Vinculado',
                'hva_estado_2' => 'Retirado',
            ];
            
            if ($this->hva_registro_fecha!="" AND $this->hva_registro_fecha!="null" AND $this->hva_registro_fecha_2!="" AND $this->hva_registro_fecha_2!="null") {
                $filtro_fecha_ingreso_str=" AND `hva_ingreso_fecha`>=:hva_registro_fecha AND `hva_ingreso_fecha`<=:hva_registro_fecha_2";
                $parametros_filtro = [
                    'hva_registro_fecha' => $this->hva_registro_fecha,
                    'hva_registro_fecha_2' => $this->hva_registro_fecha_2,
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_fecha_ingreso_str="";
            }

            $sql='SELECT `hva_id`, `hva_identificacion`, `hva_nombres`, `hva_nombres_2`, `hva_apellido_1`, `hva_apellido_2`, `hva_direccion`, `hva_barrio`, `hva_ciudad`, `hva_celular`, `hva_celular_2`, `hva_correo`, `hva_correo_corporativo`, `hva_nacimiento_lugar`, `hva_nacimiento_fecha`, `hva_operador_internet`, `hva_genero`, `hva_estado_civil`, `hva_estado`, `hva_localidad`, `hva_primer_empleo`, `hva_auxiliar_1`, `hva_auxiliar_2`, `hva_auxiliar_3`, `hva_auxiliar_4`, `hva_auxiliar_5`, `hva_ingreso_fecha`, `hva_retiro_fecha`, `hva_retiro_motivo`, `hva_observaciones`, `hva_oferta_id`, `hva_autorizaciones_id`, `hva_emergencia_id`, `hva_etica_id`, `hva_financiera_id`, `hva_informacion_id`, `hva_publico_id`, `hva_seguridad_social_id`, `hva_actualiza_usuario`, `hva_actualiza_fecha`, `hva_registro_usuario`, `hva_registro_fecha`, TUR.`usu_nombres_apellidos` AS usuario_registro, TUA.`usu_nombres_apellidos` AS usuario_actualiza, TUPS.`usu_nombres_apellidos` AS usuario_psicologo, TDIR.`usu_nombres_apellidos` AS usuario_director, TCIUDAD.`ciu_departamento`, TCIUDAD.`ciu_municipio`, TCIUDADN.`ciu_departamento` AS nacimiento_ciu_departamento, TCIUDADN.`ciu_municipio` AS nacimiento_ciu_municipio, TOF.`hvao_area`, TOF.`hvao_cargo`, TOF.`hvao_salario`, TOF.`hvao_psicologo`, TOF.hvao_director, TOF.`hvao_horario`, TOF.`hvao_debida_diligencia`, TOF.`hvao_prueba_confiabilidad`, TOF.`hvao_examen_medico`, TOF.`hvao_check_contratacion`, TOF.`hvao_fecha_diligencia`, TOF.`hvao_firma_ruta`, TOF.`hvao_estado`, TOF.`hvao_registro_usuario`, TOF.`hvao_registro_fecha`, TCAR.`ac_nombre`, TCC.`aa_nombre`, TBARRIO.`ciub_localidad`, TBARRIO.`ciub_barrio`, TAUTO.`hvada_veracidad`, TAUTO.`hvada_origen_fondos`, TAUTO.`hvada_proteccion_datos`, TAUTO.`hvada_tratamiento_datos`, THV.`hvp_usuario_nt` FROM `hoja_vida_aspirante` 
            LEFT JOIN `app_usuario` AS TUR ON `hoja_vida_aspirante`.`hva_registro_usuario`=TUR.`usu_id` 
            LEFT JOIN `app_usuario` AS TUA ON `hoja_vida_aspirante`.`hva_actualiza_usuario`=TUA.`usu_id`
            LEFT JOIN `hoja_vida_aspirante_oferta` AS TOF ON `hoja_vida_aspirante`.`hva_oferta_id`=TOF.`hvao_id`
            LEFT JOIN `app_usuario` AS TUPS ON TOF.`hvao_psicologo`=TUPS.`usu_id` 
            LEFT JOIN `app_usuario` AS TDIR ON TOF.`hvao_director`=TDIR.`usu_id` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCAR ON TOF.`hvao_cargo`=TCAR.`ac_id`
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TCC ON TOF.`hvao_area`=TCC.`aa_id`
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_aspirante`.`hva_ciudad`=TCIUDAD.`ciu_codigo`
            LEFT JOIN `app_ciudades` AS TCIUDADN ON `hoja_vida_aspirante`.`hva_nacimiento_lugar`=TCIUDADN.`ciu_codigo`
            LEFT JOIN `app_ciudades_barrios` AS TBARRIO ON `hoja_vida_aspirante`.`hva_barrio`=TBARRIO.`ciub_id`
            LEFT JOIN `hoja_vida_aspirante_autorizaciones` AS TAUTO ON `hoja_vida_aspirante`.`hva_autorizaciones_id`=TAUTO.`hvada_id`
            LEFT JOIN `hoja_vida_personal` AS THV ON `hoja_vida_aspirante`.`hva_id`=THV.`hvp_aspirante_id`
             WHERE 1=1 AND (`hva_estado`=:hva_estado_1 OR `hva_estado`=:hva_estado_2) '.$filtro_fecha_ingreso_str;
            
            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listDuplicado(){
            $sql='SELECT `hva_id`, `hva_identificacion`, `hva_nombres`, `hva_nombres_2`, `hva_apellido_1`, `hva_apellido_2`, `hva_direccion`, `hva_barrio`, `hva_ciudad`, `hva_celular`, `hva_celular_2`, `hva_correo`, `hva_correo_corporativo`, `hva_nacimiento_lugar`, `hva_nacimiento_fecha`, `hva_operador_internet`, `hva_genero`, `hva_estado_civil`, `hva_estado`, `hva_localidad`, `hva_primer_empleo`, `hva_auxiliar_1`, `hva_auxiliar_2`, `hva_auxiliar_3`, `hva_auxiliar_4`, `hva_auxiliar_5`, `hva_ingreso_fecha`, `hva_retiro_fecha`, `hva_retiro_motivo`, `hva_observaciones`, `hva_oferta_id`, `hva_autorizaciones_id`, `hva_emergencia_id`, `hva_etica_id`, `hva_financiera_id`, `hva_informacion_id`, `hva_publico_id`, `hva_seguridad_social_id`, `hva_actualiza_usuario`, `hva_actualiza_fecha`, `hva_registro_usuario`, `hva_registro_fecha`, TUR.`usu_nombres_apellidos` AS usuario_registro, TUA.`usu_nombres_apellidos` AS usuario_actualiza, TUPS.`usu_nombres_apellidos` AS usuario_psicologo, TDIR.`usu_nombres_apellidos` AS usuario_director, TCIUDAD.`ciu_departamento`, TCIUDAD.`ciu_municipio`, TCIUDADN.`ciu_departamento` AS nacimiento_ciu_departamento, TCIUDADN.`ciu_municipio` AS nacimiento_ciu_municipio, TOF.`hvao_area`, TOF.`hvao_cargo`, TOF.`hvao_salario`, TOF.`hvao_psicologo`, TOF.hvao_director, TOF.`hvao_horario`, TOF.`hvao_debida_diligencia`, TOF.`hvao_prueba_confiabilidad`, TOF.`hvao_examen_medico`, TOF.`hvao_check_contratacion`, TOF.`hvao_fecha_diligencia`, TOF.`hvao_firma_ruta`, TOF.`hvao_estado`, TOF.`hvao_registro_usuario`, TOF.`hvao_registro_fecha`, TCAR.`ac_nombre`, TCC.`aa_nombre`, TBARRIO.`ciub_localidad`, TBARRIO.`ciub_barrio`, TAUTO.`hvada_veracidad`, TAUTO.`hvada_origen_fondos`, TAUTO.`hvada_proteccion_datos`, TAUTO.`hvada_tratamiento_datos`, THV.`hvp_usuario_nt` FROM `hoja_vida_aspirante` 
            LEFT JOIN `app_usuario` AS TUR ON `hoja_vida_aspirante`.`hva_registro_usuario`=TUR.`usu_id` 
            LEFT JOIN `app_usuario` AS TUA ON `hoja_vida_aspirante`.`hva_actualiza_usuario`=TUA.`usu_id`
            LEFT JOIN `hoja_vida_aspirante_oferta` AS TOF ON `hoja_vida_aspirante`.`hva_oferta_id`=TOF.`hvao_id`
            LEFT JOIN `app_usuario` AS TUPS ON TOF.`hvao_psicologo`=TUPS.`usu_id` 
            LEFT JOIN `app_usuario` AS TDIR ON TOF.`hvao_director`=TDIR.`usu_id` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCAR ON TOF.`hvao_cargo`=TCAR.`ac_id`
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TCC ON TOF.`hvao_area`=TCC.`aa_id`
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_aspirante`.`hva_ciudad`=TCIUDAD.`ciu_codigo`
            LEFT JOIN `app_ciudades` AS TCIUDADN ON `hoja_vida_aspirante`.`hva_nacimiento_lugar`=TCIUDADN.`ciu_codigo`
            LEFT JOIN `app_ciudades_barrios` AS TBARRIO ON `hoja_vida_aspirante`.`hva_barrio`=TBARRIO.`ciub_id`
            LEFT JOIN `hoja_vida_aspirante_autorizaciones` AS TAUTO ON `hoja_vida_aspirante`.`hva_autorizaciones_id`=TAUTO.`hvada_id`
            LEFT JOIN `hoja_vida_personal` AS THV ON `hoja_vida_aspirante`.`hva_id`=THV.`hvp_aspirante_id`
             WHERE `hva_identificacion`=:hva_identificacion';

            $parametros = [
                'hva_identificacion' => $this->hva_identificacion,
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
            $sql='INSERT INTO `hoja_vida_aspirante`(`hva_identificacion`, `hva_nombres`, `hva_nombres_2`, `hva_apellido_1`, `hva_apellido_2`, `hva_direccion`, `hva_barrio`, `hva_ciudad`, `hva_celular`, `hva_celular_2`, `hva_correo`, `hva_correo_corporativo`, `hva_nacimiento_lugar`, `hva_nacimiento_fecha`, `hva_operador_internet`, `hva_genero`, `hva_estado_civil`, `hva_estado`, `hva_localidad`, `hva_primer_empleo`, `hva_auxiliar_1`, `hva_auxiliar_2`, `hva_auxiliar_3`, `hva_auxiliar_4`, `hva_auxiliar_5`, `hva_ingreso_fecha`, `hva_retiro_fecha`, `hva_retiro_motivo`, `hva_observaciones`, `hva_oferta_id`, `hva_autorizaciones_id`, `hva_emergencia_id`, `hva_etica_id`, `hva_financiera_id`, `hva_informacion_id`, `hva_publico_id`, `hva_seguridad_social_id`, `hva_actualiza_usuario`, `hva_actualiza_fecha`, `hva_registro_usuario`) VALUES (:hva_identificacion, :hva_nombres, :hva_nombres_2, :hva_apellido_1, :hva_apellido_2, :hva_direccion, :hva_barrio, :hva_ciudad, :hva_celular, :hva_celular_2, :hva_correo, :hva_correo_corporativo, :hva_nacimiento_lugar, :hva_nacimiento_fecha, :hva_operador_internet, :hva_genero, :hva_estado_civil, :hva_estado, :hva_localidad, :hva_primer_empleo, :hva_auxiliar_1, :hva_auxiliar_2, :hva_auxiliar_3, :hva_auxiliar_4, :hva_auxiliar_5, :hva_ingreso_fecha, :hva_retiro_fecha, :hva_retiro_motivo, :hva_observaciones, :hva_oferta_id, :hva_autorizaciones_id, :hva_emergencia_id, :hva_etica_id, :hva_financiera_id, :hva_informacion_id, :hva_publico_id, :hva_seguridad_social_id, :hva_actualiza_usuario, :hva_actualiza_fecha, :hva_registro_usuario)';

            $parametros = [
                'hva_identificacion' => $this->hva_identificacion,
                'hva_nombres' => $this->hva_nombres,
                'hva_nombres_2' => $this->hva_nombres_2,
                'hva_apellido_1' => $this->hva_apellido_1,
                'hva_apellido_2' => $this->hva_apellido_2,
                'hva_direccion' => $this->hva_direccion,
                'hva_barrio' => $this->hva_barrio,
                'hva_ciudad' => $this->hva_ciudad,
                'hva_celular' => $this->hva_celular,
                'hva_celular_2' => $this->hva_celular_2,
                'hva_correo' => $this->hva_correo,
                'hva_correo_corporativo' => $this->hva_correo_corporativo,
                'hva_nacimiento_lugar' => $this->hva_nacimiento_lugar,
                'hva_nacimiento_fecha' => $this->hva_nacimiento_fecha,
                'hva_operador_internet' => $this->hva_operador_internet,
                'hva_genero' => $this->hva_genero,
                'hva_estado_civil' => $this->hva_estado_civil,
                'hva_estado' => $this->hva_estado,
                'hva_localidad' => $this->hva_localidad,
                'hva_primer_empleo' => $this->hva_primer_empleo,
                'hva_auxiliar_1' => $this->hva_auxiliar_1,
                'hva_auxiliar_2' => $this->hva_auxiliar_2,
                'hva_auxiliar_3' => $this->hva_auxiliar_3,
                'hva_auxiliar_4' => $this->hva_auxiliar_4,
                'hva_auxiliar_5' => $this->hva_auxiliar_5,
                'hva_ingreso_fecha' => $this->hva_ingreso_fecha,
                'hva_retiro_fecha' => $this->hva_retiro_fecha,
                'hva_retiro_motivo' => $this->hva_retiro_motivo,
                'hva_observaciones' => $this->hva_observaciones,
                'hva_oferta_id' => $this->hva_oferta_id,
                'hva_autorizaciones_id' => $this->hva_autorizaciones_id,
                'hva_emergencia_id' => $this->hva_emergencia_id,
                'hva_etica_id' => $this->hva_etica_id,
                'hva_financiera_id' => $this->hva_financiera_id,
                'hva_informacion_id' => $this->hva_informacion_id,
                'hva_publico_id' => $this->hva_publico_id,
                'hva_seguridad_social_id' => $this->hva_seguridad_social_id,
                'hva_actualiza_usuario' => $this->hva_actualiza_usuario,
                'hva_actualiza_fecha' => $this->hva_actualiza_fecha,
                'hva_registro_usuario' => $this->hva_registro_usuario,
            ];

            try {
                return ($this->hva_id = parent::query($sql, $parametros)) ? $this->hva_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function delete(){
            $sql='DELETE FROM `hoja_vida_aspirante` WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function update(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_identificacion`=:hva_identificacion, `hva_nombres`=:hva_nombres, `hva_nombres_2`=:hva_nombres_2, `hva_apellido_1`=:hva_apellido_1, `hva_apellido_2`=:hva_apellido_2, `hva_correo`=:hva_correo, `hva_observaciones`=:hva_observaciones, `hva_actualiza_usuario`=:hva_actualiza_usuario, `hva_actualiza_fecha`=:hva_actualiza_fecha WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
                'hva_identificacion' => $this->hva_identificacion,
                'hva_nombres' => $this->hva_nombres,
                'hva_nombres_2' => $this->hva_nombres_2,
                'hva_apellido_1' => $this->hva_apellido_1,
                'hva_apellido_2' => $this->hva_apellido_2,
                'hva_correo' => $this->hva_correo,
                'hva_actualiza_usuario' => $this->hva_actualiza_usuario,
                'hva_actualiza_fecha' => $this->hva_actualiza_fecha,
                'hva_observaciones' => $this->hva_observaciones,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateAspirante(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_identificacion`=:hva_identificacion, `hva_nombres`=:hva_nombres, `hva_nombres_2`=:hva_nombres_2, `hva_apellido_1`=:hva_apellido_1, `hva_apellido_2`=:hva_apellido_2, `hva_correo`=:hva_correo,  `hva_estado`=:hva_estado, `hva_observaciones`=:hva_observaciones WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
                'hva_identificacion' => $this->hva_identificacion,
                'hva_nombres' => $this->hva_nombres,
                'hva_nombres_2' => $this->hva_nombres_2,
                'hva_apellido_1' => $this->hva_apellido_1,
                'hva_apellido_2' => $this->hva_apellido_2,
                'hva_correo' => $this->hva_correo,
                'hva_estado' => $this->hva_estado,
                'hva_observaciones' => $this->hva_observaciones,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateAspiranteInformacion(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_nombres`=:hva_nombres, `hva_nombres_2`=:hva_nombres_2, `hva_apellido_1`=:hva_apellido_1, `hva_apellido_2`=:hva_apellido_2 WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
                'hva_nombres' => $this->hva_nombres,
                'hva_nombres_2' => $this->hva_nombres_2,
                'hva_apellido_1' => $this->hva_apellido_1,
                'hva_apellido_2' => $this->hva_apellido_2,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateCorreoCorporativo(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_correo_corporativo`=:hva_correo_corporativo WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
                'hva_correo_corporativo' => $this->hva_correo_corporativo,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateCorreoCorporativoCC(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_correo_corporativo`=:hva_correo_corporativo WHERE `hva_identificacion`=:hva_identificacion';

            $parametros = [
                'hva_identificacion' => $this->hva_identificacion,
                'hva_correo_corporativo' => $this->hva_correo_corporativo,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateRegistro(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_auxiliar_5`=:hva_auxiliar_5, `hva_direccion`=:hva_direccion, `hva_barrio`=:hva_barrio, `hva_ciudad`=:hva_ciudad, `hva_localidad`=:hva_localidad, `hva_celular`=:hva_celular, `hva_celular_2`=:hva_celular_2, `hva_nacimiento_lugar`=:hva_nacimiento_lugar, `hva_nacimiento_fecha`=:hva_nacimiento_fecha, `hva_operador_internet`=:hva_operador_internet, `hva_genero`=:hva_genero, `hva_estado_civil`=:hva_estado_civil, `hva_actualiza_fecha`=:hva_actualiza_fecha WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
                'hva_auxiliar_5' => $this->hva_auxiliar_5,
                'hva_direccion' => $this->hva_direccion,
                'hva_barrio' => $this->hva_barrio,
                'hva_ciudad' => $this->hva_ciudad,
                'hva_localidad' => $this->hva_localidad,
                'hva_celular' => $this->hva_celular,
                'hva_celular_2' => $this->hva_celular_2,
                'hva_nacimiento_lugar' => $this->hva_nacimiento_lugar,
                'hva_nacimiento_fecha' => $this->hva_nacimiento_fecha,
                'hva_operador_internet' => $this->hva_operador_internet,
                'hva_genero' => $this->hva_genero,
                'hva_estado_civil' => $this->hva_estado_civil,
                'hva_actualiza_fecha' => $this->hva_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateFechaExpedicion(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_auxiliar_5`=:hva_auxiliar_5 WHERE `hva_identificacion`=:hva_identificacion';

            $parametros = [
                'hva_identificacion' => $this->hva_identificacion,
                'hva_auxiliar_5' => $this->hva_auxiliar_5,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateEstado(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_estado`=:hva_estado, `hva_actualiza_fecha`=:hva_actualiza_fecha WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
                'hva_estado' => $this->hva_estado,
                'hva_actualiza_fecha' => $this->hva_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateEstadoIngreso(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_estado`=:hva_estado, `hva_ingreso_fecha`=:hva_ingreso_fecha, `hva_actualiza_fecha`=:hva_actualiza_fecha WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
                'hva_estado' => $this->hva_estado,
                'hva_ingreso_fecha' => $this->hva_ingreso_fecha,
                'hva_actualiza_fecha' => $this->hva_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateEstadoRetiro(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_estado`=:hva_estado, `hva_retiro_fecha`=:hva_retiro_fecha, `hva_retiro_motivo`=:hva_retiro_motivo, `hva_actualiza_fecha`=:hva_actualiza_fecha WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
                'hva_estado' => $this->hva_estado,
                'hva_retiro_fecha' => $this->hva_retiro_fecha,
                'hva_retiro_motivo' => $this->hva_retiro_motivo,
                'hva_actualiza_fecha' => $this->hva_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateAutorizaEdad(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_auxiliar_3`=:hva_auxiliar_3, `hva_auxiliar_4`=:hva_auxiliar_4 WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
                'hva_auxiliar_3' => $this->hva_auxiliar_3,
                'hva_auxiliar_4' => $this->hva_auxiliar_4,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateEstudioCurso(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_auxiliar_1`=:hva_auxiliar_1 WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
                'hva_auxiliar_1' => $this->hva_auxiliar_1,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
        
        public function updatePrimerEmpleo(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_auxiliar_2`=:hva_auxiliar_2 WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
                'hva_auxiliar_2' => $this->hva_auxiliar_2,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateIdOferta(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_oferta_id`=:hva_oferta_id WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
                'hva_oferta_id' => $this->hva_oferta_id,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateIdAutorizaciones(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_autorizaciones_id`=:hva_autorizaciones_id WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
                'hva_autorizaciones_id' => $this->hva_autorizaciones_id,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateIdEmergencia(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_emergencia_id`=:hva_emergencia_id WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
                'hva_emergencia_id' => $this->hva_emergencia_id,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateIdEtica(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_etica_id`=:hva_etica_id WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
                'hva_etica_id' => $this->hva_etica_id,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateIdFinanciera(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_financiera_id`=:hva_financiera_id WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
                'hva_financiera_id' => $this->hva_financiera_id,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateIdInformacion(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_informacion_id`=:hva_informacion_id WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
                'hva_informacion_id' => $this->hva_informacion_id,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateIdPublico(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_publico_id`=:hva_publico_id WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
                'hva_publico_id' => $this->hva_publico_id,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateIdSeguridad(){
            $sql='UPDATE `hoja_vida_aspirante` SET `hva_seguridad_social_id`=:hva_seguridad_social_id WHERE `hva_id`=:hva_id';

            $parametros = [
                'hva_id' => $this->hva_id,
                'hva_seguridad_social_id' => $this->hva_seguridad_social_id,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }