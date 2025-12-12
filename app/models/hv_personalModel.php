<?php
    class hv_personalModel extends Model {
        public $hvp_id;
        public $hvp_usuario_id;
        public $hvp_aspirante_id;
        public $hvp_centro_costo;
        public $hvp_cargo;
        public $hvp_consentimiento_tratamiento_datos_personales;
        public $hvp_consentimiento_tratamiento_datos_personales_fecha;
        public $hvp_datos_personales_tipo_documento;
        public $hvp_datos_personales_numero_identificacion;
        public $hvp_datos_personales_apellido_1;
        public $hvp_datos_personales_apellido_2;
        public $hvp_datos_personales_nombre_1;
        public $hvp_datos_personales_nombre_2;
        public $hvp_demografia_genero;
        public $hvp_demografia_estado_civil;
        public $hvp_demografia_lugar_nacimiento;
        public $hvp_demografia_fecha_nacimiento;
        public $hvp_demografia_edad;
        public $hvp_ubicacion_direccion_residencia;
        public $hvp_ubicacion_ciudad_residencia;
        public $hvp_ubicacion_localidad_comuna;
        public $hvp_ubicacion_barrio;
        public $hvp_ubicacion_maps_latitud;
        public $hvp_ubicacion_maps_longitud;
        public $hvp_ubicacion_maps_ciudad;
        public $hvp_ubicacion_maps_departamento;
        public $hvp_ubicacion_maps_pais;
        public $hvp_ubicacion_maps_localidad;
        public $hvp_ubicacion_maps_barrio;
        public $hvp_ubicacion_maps_codigo_postal;
        public $hvp_ubicacion_maps_direccion;
        public $hvp_socioeconomico_estrato_socioeconomico;
        public $hvp_socioeconomico_operador_internet;
        public $hvp_socioeconomico_operador_internet_otro;
        public $hvp_socioeconomico_velocidad_internet_descarga;
        public $hvp_socioeconomico_velocidad_internet_carga;
        public $hvp_socioeconomico_caracteristicas_vivienda;
        public $hvp_socioeconomico_condiciones_vivienda;
        public $hvp_socioeconomico_estado_terminacion_vivienda;
        public $hvp_socioeconomico_servicios_vivienda;
        public $hvp_socioeconomico_plan_compra_vivienda;
        public $hvp_socioeconomico_beneficiario_subsidio_vivienda;
        public $hvp_contacto_numero_celular;
        public $hvp_contacto_correo_personal;
        public $hvp_contacto_correo_corporativo;

        public $hvp_contacto_emergencia_nombres;
        public $hvp_contacto_emergencia_apellidos;
        public $hvp_contacto_emergencia_parentesco;
        public $hvp_contacto_emergencia_celular;

        public $hvp_contacto_emergencia_nombres_2;
        public $hvp_contacto_emergencia_apellidos_2;
        public $hvp_contacto_emergencia_parentesco_2;
        public $hvp_contacto_emergencia_celular_2;

        public $hvp_salud_bienestar_grupo_sanguineo;
        public $hvp_salud_bienestar_rh;
        public $hvp_salud_bienestar_actividad_fisica_minima;
        public $hvp_salud_bienestar_fumador;
        public $hvp_salud_bienestar_pausas_activas;
        public $hvp_salud_bienestar_medicina_prepagada;
        public $hvp_salud_bienestar_medicina_prepagada_cual;

        public $hvp_salud_bienestar_plan_complementario_salud;
        public $hvp_salud_bienestar_plan_complementario_salud_cual;

        public $hvp_familia_numero_hijos;
        public $hvp_familia_hijos_menor_3;
        public $hvp_familia_hijos_4_10;
        public $hvp_familia_hijos_11_17;
        public $hvp_familia_hijos_mayor_18;
        public $hvp_familia_capacitacion_familia;
        public $hvp_expectativa_motivacion_motivacion_trabajo;
        public $hvp_expectativa_antiguedad;
        public $hvp_expectativa_motivacion_expectativa_desarrollo;
        public $hvp_expectativa_motivacion_expectativa_crecimiento_profesional;
        public $hvp_expectativa_motivacion_realidad_crecimiento_profesional;
        
        public $hvp_interes_habitos_hobbies_deportes;
        public $hvp_interes_habitos_hobbies_deportes_frecuencia;
        public $hvp_interes_habitos_hobbies_deportes_cual;
        public $hvp_interes_habitos_hobbies_aire;
        public $hvp_interes_habitos_hobbies_aire_frecuencia;
        public $hvp_interes_habitos_hobbies_aire_cual;
        public $hvp_interes_habitos_hobbies_arte;
        public $hvp_interes_habitos_hobbies_arte_frecuencia;
        public $hvp_interes_habitos_hobbies_arte_instrumento;
        public $hvp_interes_habitos_hobbies_arte_cual;
        public $hvp_interes_habitos_hobbies_tecnologia;
        public $hvp_interes_habitos_hobbies_tecnologia_frecuencia;
        public $hvp_interes_habitos_hobbies_tecnologia_cual;
        public $hvp_interes_habitos_hobbies_otro;
        public $hvp_interes_habitos_hobbies_otro_frecuencia;
        public $hvp_interes_habitos_hobbies_otro_cual;
        public $hvp_interes_habitos_hobbies_recibir_informacion;


        public $hvp_interes_habitos_actividades_familia;
        public $hvp_interes_habitos_actividades_deportivas;
        public $hvp_interes_habitos_actividades_deportivas_cual;
        public $hvp_interes_habitos_medio_transporte;
        public $hvp_interes_habitos_habito_ahorro;
        public $hvp_interes_habitos_mascotas;
        public $hvp_interes_habitos_mascotas_cual;
        public $hvp_formacion_nivel_academico_culminado;
        public $hvp_formacion_ultimo_certificado_enviado_rrhh;
        public $hvp_formacion_ultimo_estudio_realizado_titulo;
        public $hvp_formacion_tarjeta_profesional;
        public $hvp_formacion_estudios_curso;
        public $hvp_formacion_estudios_curso_titulo;
        public $hvp_formacion_estudios_curso_nivel;
        public $hvp_formacion_estudios_curso_establecimiento;
        public $hvp_habilidades_nivel_ingles;
        public $hvp_habilidades_nivel_excel;
        public $hvp_habilidades_nivel_google_ws;
        public $hvp_poblaciones_poblacion;
        public $hvp_poblaciones_certificado;
        public $hvp_poblaciones_poblacion_soporte;
        public $hvp_poblaciones_familiares_iq;
        public $hvp_poblaciones_familiares_iq_identificacion;
        public $hvp_poblaciones_familiares_iq_nombres_apellidos;
        public $hvp_poblaciones_familiares_iq_ingreso_marzo_2022;
        
        public $hvp_financiero_activos;
        public $hvp_financiero_ingresos;
        public $hvp_financiero_pasivos;
        public $hvp_financiero_egresos;
        public $hvp_financiero_patrimonio;
        public $hvp_financiero_ingresos_otros;
        public $hvp_financiero_concepto_ingresos;
        public $hvp_financiero_moneda_extranjera;

        public $hvp_origen_fondos;

        public $hvp_pep_recursos;
        public $hvp_pep_reconocimiento;
        public $hvp_pep_poder;
        public $hvp_pep_familiar;
        public $hvp_pep_cedula;
        public $hvp_pep_nombres_apellidos;

        public $hvp_veracidad;
        
        public $hvp_alerta_actualizacion;
        
        public $hvp_estado;

        public $hvp_fecha_ingreso;
        public $hvp_retiro_fecha;
        public $hvp_retiro_motivo;


        public $hvp_auxiliar_1;//hvp_nombre_preferencia
        public $hvp_auxiliar_2;//hvp_contacto_numero_celular_alternativo
        public $hvp_auxiliar_3;//Firma_autorizacion_tratamiento_datos_personales
        public $hvp_auxiliar_4;//documento_ultimo_estudio
        public $hvp_auxiliar_5;//documento_tarjeta_profesional
        public $hvp_usuario_nt;
        public $hvp_observaciones;
        public $hvp_actualiza_usuario;
        public $hvp_actualiza_fecha;
        public $hvp_registro_usuario;
        public $hvp_registro_fecha;
        public $filtro_bandeja='';
        public $filtro_perfil='';
        public $fecha_inicio;
        public $fecha_fin;
        public $fecha_inicio_retiro;
        public $fecha_fin_retiro;
        public $filtro_documentos_nuevos='';
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
                        $filtro_bandeja_str.=" `hvp_estado`=:hvp_estado_".$i." OR ";
                        $parametros_filtro = [
                            'hvp_estado_'.$i => $this->filtro_bandeja[$i],
                        ];
                        $parametros = array_merge($parametros, $parametros_filtro);
                    }
                    $filtro_bandeja_str="AND (".substr($filtro_bandeja_str, 0, -3).")";
                }
            } else {
                $filtro_bandeja_str="";
            }

            if ($this->filtro_documentos_nuevos!="" AND $this->filtro_documentos_nuevos!="null") {
                $filtro_documento_nuevo_str=" AND `hvp_alerta_actualizacion`=:hvp_alerta_actualizacion";
                $parametros_filtro = [
                    'hvp_alerta_actualizacion' => $this->filtro_documentos_nuevos,
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_documento_nuevo_str="";
            }

            if ($this->filtro!="" AND $this->filtro!="null") {
                $filtro_str="AND (`hvp_datos_personales_numero_identificacion` LIKE :hvp_datos_personales_numero_identificacion OR `hvp_datos_personales_apellido_1` LIKE :hvp_datos_personales_apellido_1 OR `hvp_datos_personales_apellido_2` LIKE :hvp_datos_personales_apellido_2 OR `hvp_datos_personales_nombre_1` LIKE :hvp_datos_personales_nombre_1 OR `hvp_datos_personales_nombre_2` LIKE :hvp_datos_personales_nombre_2)";
                $parametros_filtro = [
                    'hvp_datos_personales_numero_identificacion' => '%'.$this->filtro.'%',
                    'hvp_datos_personales_apellido_1' => '%'.$this->filtro.'%',
                    'hvp_datos_personales_apellido_2' => '%'.$this->filtro.'%',
                    'hvp_datos_personales_nombre_1' => '%'.$this->filtro.'%',
                    'hvp_datos_personales_nombre_2' => '%'.$this->filtro.'%',
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_str="";
            }

            $sql='SELECT `hvp_id`, `hvp_usuario_id`, `hvp_aspirante_id`, `hvp_centro_costo`, `hvp_cargo`, `hvp_consentimiento_tratamiento_datos_personales`, `hvp_consentimiento_tratamiento_datos_personales_fecha`, `hvp_datos_personales_tipo_documento`, `hvp_datos_personales_numero_identificacion`, `hvp_datos_personales_apellido_1`, `hvp_datos_personales_apellido_2`, `hvp_datos_personales_nombre_1`, `hvp_datos_personales_nombre_2`, `hvp_demografia_genero`, `hvp_demografia_estado_civil`, `hvp_demografia_lugar_nacimiento`, `hvp_demografia_fecha_nacimiento`, `hvp_demografia_edad`, `hvp_ubicacion_direccion_residencia`, `hvp_ubicacion_ciudad_residencia`, `hvp_ubicacion_localidad_comuna`, `hvp_ubicacion_barrio`, `hvp_ubicacion_maps_latitud`, `hvp_ubicacion_maps_longitud`, `hvp_ubicacion_maps_ciudad`, `hvp_ubicacion_maps_departamento`, `hvp_ubicacion_maps_pais`, `hvp_ubicacion_maps_localidad`, `hvp_ubicacion_maps_barrio`, `hvp_ubicacion_maps_codigo_postal`, `hvp_ubicacion_maps_direccion`, `hvp_socioeconomico_estrato_socioeconomico`, `hvp_socioeconomico_operador_internet`, `hvp_socioeconomico_operador_internet_otro`, `hvp_socioeconomico_velocidad_internet_carga`, `hvp_socioeconomico_velocidad_internet_descarga`, `hvp_socioeconomico_caracteristicas_vivienda`, `hvp_socioeconomico_condiciones_vivienda`, `hvp_socioeconomico_estado_terminacion_vivienda`, `hvp_socioeconomico_servicios_vivienda`, `hvp_socioeconomico_plan_compra_vivienda`, `hvp_socioeconomico_beneficiario_subsidio_vivienda`, `hvp_contacto_numero_celular`, `hvp_contacto_correo_personal`, `hvp_contacto_correo_corporativo`, `hvp_contacto_emergencia_nombres`, `hvp_contacto_emergencia_apellidos`, `hvp_contacto_emergencia_parentesco`, `hvp_contacto_emergencia_celular`, `hvp_contacto_emergencia_nombres_2`, `hvp_contacto_emergencia_apellidos_2`, `hvp_contacto_emergencia_parentesco_2`, `hvp_contacto_emergencia_celular_2`, `hvp_salud_bienestar_grupo_sanguineo`, `hvp_salud_bienestar_rh`, `hvp_salud_bienestar_actividad_fisica_minima`, `hvp_salud_bienestar_fumador`, `hvp_salud_bienestar_pausas_activas`, `hvp_salud_bienestar_medicina_prepagada`, `hvp_salud_bienestar_medicina_prepagada_cual`, `hvp_salud_bienestar_plan_complementario_salud`, `hvp_salud_bienestar_plan_complementario_salud_cual`, `hvp_familia_numero_hijos`, `hvp_familia_hijos_menor_3`, `hvp_familia_hijos_4_10`, `hvp_familia_hijos_11_17`, `hvp_familia_hijos_mayor_18`, `hvp_familia_capacitacion_familia`, `hvp_expectativa_motivacion_motivacion_trabajo`, `hvp_expectativa_motivacion_expectativa_desarrollo`, `hvp_expectativa_motivacion_expectativa_crecimiento_profesional`, `hvp_expectativa_motivacion_realidad_crecimiento_profesional`, `hvp_interes_habitos_hobbies_deportes`, `hvp_interes_habitos_hobbies_deportes_frecuencia`, `hvp_interes_habitos_hobbies_deportes_cual`, `hvp_interes_habitos_hobbies_aire`, `hvp_interes_habitos_hobbies_aire_frecuencia`, `hvp_interes_habitos_hobbies_aire_cual`, `hvp_interes_habitos_hobbies_arte`, `hvp_interes_habitos_hobbies_arte_frecuencia`, `hvp_interes_habitos_hobbies_arte_instrumento`, `hvp_interes_habitos_hobbies_arte_cual`, `hvp_interes_habitos_hobbies_tecnologia`, `hvp_interes_habitos_hobbies_tecnologia_frecuencia`, `hvp_interes_habitos_hobbies_tecnologia_cual`, `hvp_interes_habitos_hobbies_otro`, `hvp_interes_habitos_hobbies_otro_frecuencia`, `hvp_interes_habitos_hobbies_otro_cual`, `hvp_interes_habitos_hobbies_recibir_informacion`, `hvp_interes_habitos_actividades_familia`, `hvp_interes_habitos_actividades_deportivas`, `hvp_interes_habitos_actividades_deportivas_cual`, `hvp_interes_habitos_medio_transporte`, `hvp_interes_habitos_habito_ahorro`, `hvp_interes_habitos_mascotas`, `hvp_interes_habitos_mascotas_cual`, `hvp_formacion_nivel_academico_culminado`, `hvp_formacion_ultimo_certificado_enviado_rrhh`, `hvp_formacion_ultimo_estudio_realizado_titulo`, `hvp_formacion_tarjeta_profesional`, `hvp_formacion_estudios_curso`, `hvp_formacion_estudios_curso_titulo`, `hvp_formacion_estudios_curso_nivel`, `hvp_formacion_estudios_curso_establecimiento`, `hvp_habilidades_nivel_ingles`, `hvp_habilidades_nivel_excel`, `hvp_habilidades_nivel_google_ws`, `hvp_poblaciones_poblacion`, `hvp_poblaciones_certificado`, `hvp_poblaciones_poblacion_soporte`, `hvp_poblaciones_familiares_iq`, `hvp_poblaciones_familiares_iq_identificacion`, `hvp_poblaciones_familiares_iq_nombres_apellidos`, `hvp_poblaciones_familiares_iq_ingreso_marzo_2022`, `hvp_financiero_activos`, `hvp_financiero_ingresos`, `hvp_financiero_pasivos`, `hvp_financiero_egresos`, `hvp_financiero_patrimonio`, `hvp_financiero_ingresos_otros`, `hvp_financiero_concepto_ingresos`, `hvp_financiero_moneda_extranjera`, `hvp_origen_fondos`, `hvp_pep_recursos`, `hvp_pep_reconocimiento`, `hvp_pep_poder`, `hvp_pep_familiar`, `hvp_pep_cedula`, `hvp_pep_nombres_apellidos`, `hvp_veracidad`, `hvp_alerta_actualizacion`, `hvp_estado`, `hvp_fecha_ingreso`, `hvp_retiro_fecha`, `hvp_retiro_motivo`, `hvp_auxiliar_1`, `hvp_auxiliar_2`, `hvp_auxiliar_3`, `hvp_auxiliar_4`, `hvp_auxiliar_5`, `hvp_usuario_nt`, `hvp_observaciones`, `hvp_actualiza_usuario`, `hvp_actualiza_fecha`, `hvp_registro_usuario`, `hvp_registro_fecha`, TCIUDAD.`ciu_departamento` AS TCIUDAD_ciu_departamento, TCIUDAD.`ciu_municipio` AS TCIUDAD_ciu_municipio, TCIUDADN.`ciu_departamento` AS TCIUDADN_ciu_departamento, TCIUDADN.`ciu_municipio` AS TCIUDADN_ciu_municipio, TCAR.`ac_nombre`, TCC.`aa_nombre` FROM `hoja_vida_personal`
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_personal`.`hvp_ubicacion_ciudad_residencia`=TCIUDAD.`ciu_codigo`
            LEFT JOIN `app_ciudades` AS TCIUDADN ON `hoja_vida_personal`.`hvp_demografia_lugar_nacimiento`=TCIUDADN.`ciu_codigo`
            LEFT JOIN `app_ciudades_barrios` AS TBARRIO ON `hoja_vida_personal`.`hvp_ubicacion_barrio`=TBARRIO.`ciub_id`
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCAR ON `hoja_vida_personal`.`hvp_cargo`=TCAR.`ac_id` LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TCC ON `hoja_vida_personal`.`hvp_centro_costo`=TCC.`aa_id`
             WHERE 1=1 '.$filtro_bandeja_str.' '.$filtro_str.' '.$filtro_documento_nuevo_str.' ORDER BY `hvp_datos_personales_nombre_1`, `hvp_datos_personales_nombre_2`, `hvp_datos_personales_apellido_1`, `hvp_datos_personales_apellido_2` LIMIT :offset,:limite';

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
                        $filtro_bandeja_str.=" `hvp_estado`=:hvp_estado_".$i." OR ";
                        $parametros_filtro = [
                            'hvp_estado_'.$i => $this->filtro_bandeja[$i],
                        ];
                        $parametros = array_merge($parametros, $parametros_filtro);
                    }
                    $filtro_bandeja_str="AND (".substr($filtro_bandeja_str, 0, -3).")";
                }
            } else {
                $filtro_bandeja_str="";
            }

            if ($this->filtro_documentos_nuevos!="" AND $this->filtro_documentos_nuevos!="null") {
                $filtro_documento_nuevo_str=" AND `hvp_alerta_actualizacion`=:hvp_alerta_actualizacion";
                $parametros_filtro = [
                    'hvp_alerta_actualizacion' => $this->filtro_documentos_nuevos,
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_documento_nuevo_str="";
            }

            if ($this->filtro!="" AND $this->filtro!="null") {
                $filtro_str="AND (`hvp_datos_personales_numero_identificacion` LIKE :hvp_datos_personales_numero_identificacion OR `hvp_datos_personales_apellido_1` LIKE :hvp_datos_personales_apellido_1 OR `hvp_datos_personales_apellido_2` LIKE :hvp_datos_personales_apellido_2 OR `hvp_datos_personales_nombre_1` LIKE :hvp_datos_personales_nombre_1 OR `hvp_datos_personales_nombre_2` LIKE :hvp_datos_personales_nombre_2)";
                $parametros_filtro = [
                    'hvp_datos_personales_numero_identificacion' => '%'.$this->filtro.'%',
                    'hvp_datos_personales_apellido_1' => '%'.$this->filtro.'%',
                    'hvp_datos_personales_apellido_2' => '%'.$this->filtro.'%',
                    'hvp_datos_personales_nombre_1' => '%'.$this->filtro.'%',
                    'hvp_datos_personales_nombre_2' => '%'.$this->filtro.'%',
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_str="";
            }

            $sql='SELECT `hvp_id`, `hvp_usuario_id`, `hvp_aspirante_id`, `hvp_centro_costo`, `hvp_cargo`, `hvp_consentimiento_tratamiento_datos_personales`, `hvp_consentimiento_tratamiento_datos_personales_fecha`, `hvp_datos_personales_tipo_documento`, `hvp_datos_personales_numero_identificacion`, `hvp_datos_personales_apellido_1`, `hvp_datos_personales_apellido_2`, `hvp_datos_personales_nombre_1`, `hvp_datos_personales_nombre_2`, `hvp_demografia_genero`, `hvp_demografia_estado_civil`, `hvp_demografia_lugar_nacimiento`, `hvp_demografia_fecha_nacimiento`, `hvp_demografia_edad`, `hvp_ubicacion_direccion_residencia`, `hvp_ubicacion_ciudad_residencia`, `hvp_ubicacion_localidad_comuna`, `hvp_ubicacion_barrio`, `hvp_ubicacion_maps_latitud`, `hvp_ubicacion_maps_longitud`, `hvp_ubicacion_maps_ciudad`, `hvp_ubicacion_maps_departamento`, `hvp_ubicacion_maps_pais`, `hvp_ubicacion_maps_localidad`, `hvp_ubicacion_maps_barrio`, `hvp_ubicacion_maps_codigo_postal`, `hvp_ubicacion_maps_direccion`, `hvp_socioeconomico_estrato_socioeconomico`, `hvp_socioeconomico_operador_internet`, `hvp_socioeconomico_operador_internet_otro`, `hvp_socioeconomico_velocidad_internet_carga`, `hvp_socioeconomico_velocidad_internet_descarga`, `hvp_socioeconomico_caracteristicas_vivienda`, `hvp_socioeconomico_condiciones_vivienda`, `hvp_socioeconomico_estado_terminacion_vivienda`, `hvp_socioeconomico_servicios_vivienda`, `hvp_socioeconomico_plan_compra_vivienda`, `hvp_socioeconomico_beneficiario_subsidio_vivienda`, `hvp_contacto_numero_celular`, `hvp_contacto_correo_personal`, `hvp_contacto_correo_corporativo`, `hvp_contacto_emergencia_nombres`, `hvp_contacto_emergencia_apellidos`, `hvp_contacto_emergencia_parentesco`, `hvp_contacto_emergencia_celular`, `hvp_contacto_emergencia_nombres_2`, `hvp_contacto_emergencia_apellidos_2`, `hvp_contacto_emergencia_parentesco_2`, `hvp_contacto_emergencia_celular_2`, `hvp_salud_bienestar_grupo_sanguineo`, `hvp_salud_bienestar_rh`, `hvp_salud_bienestar_actividad_fisica_minima`, `hvp_salud_bienestar_fumador`, `hvp_salud_bienestar_pausas_activas`, `hvp_salud_bienestar_medicina_prepagada`, `hvp_salud_bienestar_medicina_prepagada_cual`, `hvp_salud_bienestar_plan_complementario_salud`, `hvp_salud_bienestar_plan_complementario_salud_cual`, `hvp_familia_numero_hijos`, `hvp_familia_hijos_menor_3`, `hvp_familia_hijos_4_10`, `hvp_familia_hijos_11_17`, `hvp_familia_hijos_mayor_18`, `hvp_familia_capacitacion_familia`, `hvp_expectativa_motivacion_motivacion_trabajo`, `hvp_expectativa_motivacion_expectativa_desarrollo`, `hvp_expectativa_motivacion_expectativa_crecimiento_profesional`, `hvp_expectativa_motivacion_realidad_crecimiento_profesional`, `hvp_interes_habitos_hobbies_deportes`, `hvp_interes_habitos_hobbies_deportes_frecuencia`, `hvp_interes_habitos_hobbies_deportes_cual`, `hvp_interes_habitos_hobbies_aire`, `hvp_interes_habitos_hobbies_aire_frecuencia`, `hvp_interes_habitos_hobbies_aire_cual`, `hvp_interes_habitos_hobbies_arte`, `hvp_interes_habitos_hobbies_arte_frecuencia`, `hvp_interes_habitos_hobbies_arte_instrumento`, `hvp_interes_habitos_hobbies_arte_cual`, `hvp_interes_habitos_hobbies_tecnologia`, `hvp_interes_habitos_hobbies_tecnologia_frecuencia`, `hvp_interes_habitos_hobbies_tecnologia_cual`, `hvp_interes_habitos_hobbies_otro`, `hvp_interes_habitos_hobbies_otro_frecuencia`, `hvp_interes_habitos_hobbies_otro_cual`, `hvp_interes_habitos_hobbies_recibir_informacion`, `hvp_interes_habitos_actividades_familia`, `hvp_interes_habitos_actividades_deportivas`, `hvp_interes_habitos_actividades_deportivas_cual`, `hvp_interes_habitos_medio_transporte`, `hvp_interes_habitos_habito_ahorro`, `hvp_interes_habitos_mascotas`, `hvp_interes_habitos_mascotas_cual`, `hvp_formacion_nivel_academico_culminado`, `hvp_formacion_ultimo_certificado_enviado_rrhh`, `hvp_formacion_ultimo_estudio_realizado_titulo`, `hvp_formacion_tarjeta_profesional`, `hvp_formacion_estudios_curso`, `hvp_formacion_estudios_curso_titulo`, `hvp_formacion_estudios_curso_nivel`, `hvp_formacion_estudios_curso_establecimiento`, `hvp_habilidades_nivel_ingles`, `hvp_habilidades_nivel_excel`, `hvp_habilidades_nivel_google_ws`, `hvp_poblaciones_poblacion`, `hvp_poblaciones_certificado`, `hvp_poblaciones_poblacion_soporte`, `hvp_poblaciones_familiares_iq`, `hvp_poblaciones_familiares_iq_identificacion`, `hvp_poblaciones_familiares_iq_nombres_apellidos`, `hvp_poblaciones_familiares_iq_ingreso_marzo_2022`, `hvp_financiero_activos`, `hvp_financiero_ingresos`, `hvp_financiero_pasivos`, `hvp_financiero_egresos`, `hvp_financiero_patrimonio`, `hvp_financiero_ingresos_otros`, `hvp_financiero_concepto_ingresos`, `hvp_financiero_moneda_extranjera`, `hvp_origen_fondos`, `hvp_pep_recursos`, `hvp_pep_reconocimiento`, `hvp_pep_poder`, `hvp_pep_familiar`, `hvp_pep_cedula`, `hvp_pep_nombres_apellidos`, `hvp_veracidad`, `hvp_alerta_actualizacion`, `hvp_estado`, `hvp_fecha_ingreso`, `hvp_retiro_fecha`, `hvp_retiro_motivo`, `hvp_auxiliar_1`, `hvp_auxiliar_2`, `hvp_auxiliar_3`, `hvp_auxiliar_4`, `hvp_auxiliar_5`, `hvp_usuario_nt`, `hvp_observaciones`, `hvp_actualiza_usuario`, `hvp_actualiza_fecha`, `hvp_registro_usuario`, `hvp_registro_fecha`, TCIUDAD.`ciu_departamento` AS TCIUDAD_ciu_departamento, TCIUDAD.`ciu_municipio` AS TCIUDAD_ciu_municipio, TCIUDADN.`ciu_departamento` AS TCIUDADN_ciu_departamento, TCIUDADN.`ciu_municipio` AS TCIUDADN_ciu_municipio, TCAR.`ac_nombre`, TCC.`aa_nombre` FROM `hoja_vida_personal`
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_personal`.`hvp_ubicacion_ciudad_residencia`=TCIUDAD.`ciu_codigo`
            LEFT JOIN `app_ciudades` AS TCIUDADN ON `hoja_vida_personal`.`hvp_demografia_lugar_nacimiento`=TCIUDADN.`ciu_codigo`
            LEFT JOIN `app_ciudades_barrios` AS TBARRIO ON `hoja_vida_personal`.`hvp_ubicacion_barrio`=TBARRIO.`ciub_id`
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCAR ON `hoja_vida_personal`.`hvp_cargo`=TCAR.`ac_id` LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TCC ON `hoja_vida_personal`.`hvp_centro_costo`=TCC.`aa_id`
             WHERE 1=1 '.$filtro_bandeja_str.' '.$filtro_str.' '.$filtro_documento_nuevo_str.' ORDER BY `hvp_datos_personales_nombre_1`, `hvp_datos_personales_nombre_2`, `hvp_datos_personales_apellido_1`, `hvp_datos_personales_apellido_2`';

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listDetail(){
            $sql='SELECT `hvp_id`, `hvp_usuario_id`, `hvp_aspirante_id`, `hvp_centro_costo`, `hvp_cargo`, `hvp_consentimiento_tratamiento_datos_personales`, `hvp_consentimiento_tratamiento_datos_personales_fecha`, `hvp_datos_personales_tipo_documento`, `hvp_datos_personales_numero_identificacion`, `hvp_datos_personales_apellido_1`, `hvp_datos_personales_apellido_2`, `hvp_datos_personales_nombre_1`, `hvp_datos_personales_nombre_2`, `hvp_demografia_genero`, `hvp_demografia_estado_civil`, `hvp_demografia_lugar_nacimiento`, `hvp_demografia_fecha_nacimiento`, `hvp_demografia_edad`, `hvp_ubicacion_direccion_residencia`, `hvp_ubicacion_ciudad_residencia`, `hvp_ubicacion_localidad_comuna`, `hvp_ubicacion_barrio`, `hvp_ubicacion_maps_latitud`, `hvp_ubicacion_maps_longitud`, `hvp_ubicacion_maps_ciudad`, `hvp_ubicacion_maps_departamento`, `hvp_ubicacion_maps_pais`, `hvp_ubicacion_maps_localidad`, `hvp_ubicacion_maps_barrio`, `hvp_ubicacion_maps_codigo_postal`, `hvp_ubicacion_maps_direccion`, `hvp_socioeconomico_estrato_socioeconomico`, `hvp_socioeconomico_operador_internet`, `hvp_socioeconomico_operador_internet_otro`, `hvp_socioeconomico_velocidad_internet_carga`, `hvp_socioeconomico_velocidad_internet_descarga`, `hvp_socioeconomico_caracteristicas_vivienda`, `hvp_socioeconomico_condiciones_vivienda`, `hvp_socioeconomico_estado_terminacion_vivienda`, `hvp_socioeconomico_servicios_vivienda`, `hvp_socioeconomico_plan_compra_vivienda`, `hvp_socioeconomico_beneficiario_subsidio_vivienda`, `hvp_contacto_numero_celular`, `hvp_contacto_correo_personal`, `hvp_contacto_correo_corporativo`, `hvp_contacto_emergencia_nombres`, `hvp_contacto_emergencia_apellidos`, `hvp_contacto_emergencia_parentesco`, `hvp_contacto_emergencia_celular`, `hvp_contacto_emergencia_nombres_2`, `hvp_contacto_emergencia_apellidos_2`, `hvp_contacto_emergencia_parentesco_2`, `hvp_contacto_emergencia_celular_2`, `hvp_salud_bienestar_grupo_sanguineo`, `hvp_salud_bienestar_rh`, `hvp_salud_bienestar_actividad_fisica_minima`, `hvp_salud_bienestar_fumador`, `hvp_salud_bienestar_pausas_activas`, `hvp_salud_bienestar_medicina_prepagada`, `hvp_salud_bienestar_medicina_prepagada_cual`, `hvp_salud_bienestar_plan_complementario_salud`, `hvp_salud_bienestar_plan_complementario_salud_cual`, `hvp_familia_numero_hijos`, `hvp_familia_hijos_menor_3`, `hvp_familia_hijos_4_10`, `hvp_familia_hijos_11_17`, `hvp_familia_hijos_mayor_18`, `hvp_familia_capacitacion_familia`, `hvp_expectativa_motivacion_motivacion_trabajo`, `hvp_expectativa_motivacion_expectativa_desarrollo`, `hvp_expectativa_motivacion_expectativa_crecimiento_profesional`, `hvp_expectativa_motivacion_realidad_crecimiento_profesional`, `hvp_interes_habitos_hobbies_deportes`, `hvp_interes_habitos_hobbies_deportes_frecuencia`, `hvp_interes_habitos_hobbies_deportes_cual`, `hvp_interes_habitos_hobbies_aire`, `hvp_interes_habitos_hobbies_aire_frecuencia`, `hvp_interes_habitos_hobbies_aire_cual`, `hvp_interes_habitos_hobbies_arte`, `hvp_interes_habitos_hobbies_arte_frecuencia`, `hvp_interes_habitos_hobbies_arte_instrumento`, `hvp_interes_habitos_hobbies_arte_cual`, `hvp_interes_habitos_hobbies_tecnologia`, `hvp_interes_habitos_hobbies_tecnologia_frecuencia`, `hvp_interes_habitos_hobbies_tecnologia_cual`, `hvp_interes_habitos_hobbies_otro`, `hvp_interes_habitos_hobbies_otro_frecuencia`, `hvp_interes_habitos_hobbies_otro_cual`, `hvp_interes_habitos_hobbies_recibir_informacion`, `hvp_interes_habitos_actividades_familia`, `hvp_interes_habitos_actividades_deportivas`, `hvp_interes_habitos_actividades_deportivas_cual`, `hvp_interes_habitos_medio_transporte`, `hvp_interes_habitos_habito_ahorro`, `hvp_interes_habitos_mascotas`, `hvp_interes_habitos_mascotas_cual`, `hvp_formacion_nivel_academico_culminado`, `hvp_formacion_ultimo_certificado_enviado_rrhh`, `hvp_formacion_ultimo_estudio_realizado_titulo`, `hvp_formacion_tarjeta_profesional`, `hvp_formacion_estudios_curso`, `hvp_formacion_estudios_curso_titulo`, `hvp_formacion_estudios_curso_nivel`, `hvp_formacion_estudios_curso_establecimiento`, `hvp_habilidades_nivel_ingles`, `hvp_habilidades_nivel_excel`, `hvp_habilidades_nivel_google_ws`, `hvp_poblaciones_poblacion`, `hvp_poblaciones_certificado`, `hvp_poblaciones_poblacion_soporte`, `hvp_poblaciones_familiares_iq`, `hvp_poblaciones_familiares_iq_identificacion`, `hvp_poblaciones_familiares_iq_nombres_apellidos`, `hvp_poblaciones_familiares_iq_ingreso_marzo_2022`, `hvp_financiero_activos`, `hvp_financiero_ingresos`, `hvp_financiero_pasivos`, `hvp_financiero_egresos`, `hvp_financiero_patrimonio`, `hvp_financiero_ingresos_otros`, `hvp_financiero_concepto_ingresos`, `hvp_financiero_moneda_extranjera`, `hvp_origen_fondos`, `hvp_pep_recursos`, `hvp_pep_reconocimiento`, `hvp_pep_poder`, `hvp_pep_familiar`, `hvp_pep_cedula`, `hvp_pep_nombres_apellidos`, `hvp_veracidad`, `hvp_alerta_actualizacion`, `hvp_estado`, `hvp_fecha_ingreso`, `hvp_retiro_fecha`, `hvp_retiro_motivo`, `hvp_auxiliar_1`, `hvp_auxiliar_2`, `hvp_auxiliar_3`, `hvp_auxiliar_4`, `hvp_auxiliar_5`, `hvp_usuario_nt`, `hvp_observaciones`, `hvp_actualiza_usuario`, `hvp_actualiza_fecha`, `hvp_registro_usuario`, `hvp_registro_fecha`, TCIUDAD.`ciu_departamento` AS TCIUDAD_ciu_departamento, TCIUDAD.`ciu_municipio` AS TCIUDAD_ciu_municipio, TCIUDADN.`ciu_departamento` AS TCIUDADN_ciu_departamento, TCIUDADN.`ciu_municipio` AS TCIUDADN_ciu_municipio, TCAR.`ac_nombre`, TCC.`aa_nombre` FROM `hoja_vida_personal`
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_personal`.`hvp_ubicacion_ciudad_residencia`=TCIUDAD.`ciu_codigo`
            LEFT JOIN `app_ciudades` AS TCIUDADN ON `hoja_vida_personal`.`hvp_demografia_lugar_nacimiento`=TCIUDADN.`ciu_codigo`
            LEFT JOIN `app_ciudades_barrios` AS TBARRIO ON `hoja_vida_personal`.`hvp_ubicacion_barrio`=TBARRIO.`ciub_id`
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCAR ON `hoja_vida_personal`.`hvp_cargo`=TCAR.`ac_id` LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TCC ON `hoja_vida_personal`.`hvp_centro_costo`=TCC.`aa_id`
             WHERE `hvp_usuario_id`=:hvp_usuario_id';

            $parametros = [
                'hvp_usuario_id' => $this->hvp_usuario_id,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listDetailId(){
            $sql='SELECT `hvp_id`, `hvp_usuario_id`, `hvp_aspirante_id`, `hvp_centro_costo`, `hvp_cargo`, `hvp_consentimiento_tratamiento_datos_personales`, `hvp_consentimiento_tratamiento_datos_personales_fecha`, `hvp_datos_personales_tipo_documento`, `hvp_datos_personales_numero_identificacion`, `hvp_datos_personales_apellido_1`, `hvp_datos_personales_apellido_2`, `hvp_datos_personales_nombre_1`, `hvp_datos_personales_nombre_2`, `hvp_demografia_genero`, `hvp_demografia_estado_civil`, `hvp_demografia_lugar_nacimiento`, `hvp_demografia_fecha_nacimiento`, `hvp_demografia_edad`, `hvp_ubicacion_direccion_residencia`, `hvp_ubicacion_ciudad_residencia`, `hvp_ubicacion_localidad_comuna`, `hvp_ubicacion_barrio`, `hvp_ubicacion_maps_latitud`, `hvp_ubicacion_maps_longitud`, `hvp_ubicacion_maps_ciudad`, `hvp_ubicacion_maps_departamento`, `hvp_ubicacion_maps_pais`, `hvp_ubicacion_maps_localidad`, `hvp_ubicacion_maps_barrio`, `hvp_ubicacion_maps_codigo_postal`, `hvp_ubicacion_maps_direccion`, `hvp_socioeconomico_estrato_socioeconomico`, `hvp_socioeconomico_operador_internet`, `hvp_socioeconomico_operador_internet_otro`, `hvp_socioeconomico_velocidad_internet_carga`, `hvp_socioeconomico_velocidad_internet_descarga`, `hvp_socioeconomico_caracteristicas_vivienda`, `hvp_socioeconomico_condiciones_vivienda`, `hvp_socioeconomico_estado_terminacion_vivienda`, `hvp_socioeconomico_servicios_vivienda`, `hvp_socioeconomico_plan_compra_vivienda`, `hvp_socioeconomico_beneficiario_subsidio_vivienda`, `hvp_contacto_numero_celular`, `hvp_contacto_correo_personal`, `hvp_contacto_correo_corporativo`, `hvp_contacto_emergencia_nombres`, `hvp_contacto_emergencia_apellidos`, `hvp_contacto_emergencia_parentesco`, `hvp_contacto_emergencia_celular`, `hvp_contacto_emergencia_nombres_2`, `hvp_contacto_emergencia_apellidos_2`, `hvp_contacto_emergencia_parentesco_2`, `hvp_contacto_emergencia_celular_2`, `hvp_salud_bienestar_grupo_sanguineo`, `hvp_salud_bienestar_rh`, `hvp_salud_bienestar_actividad_fisica_minima`, `hvp_salud_bienestar_fumador`, `hvp_salud_bienestar_pausas_activas`, `hvp_salud_bienestar_medicina_prepagada`, `hvp_salud_bienestar_medicina_prepagada_cual`, `hvp_salud_bienestar_plan_complementario_salud`, `hvp_salud_bienestar_plan_complementario_salud_cual`, `hvp_familia_numero_hijos`, `hvp_familia_hijos_menor_3`, `hvp_familia_hijos_4_10`, `hvp_familia_hijos_11_17`, `hvp_familia_hijos_mayor_18`, `hvp_familia_capacitacion_familia`, `hvp_expectativa_motivacion_motivacion_trabajo`, `hvp_expectativa_motivacion_expectativa_desarrollo`, `hvp_expectativa_motivacion_expectativa_crecimiento_profesional`, `hvp_expectativa_motivacion_realidad_crecimiento_profesional`, `hvp_interes_habitos_hobbies_deportes`, `hvp_interes_habitos_hobbies_deportes_frecuencia`, `hvp_interes_habitos_hobbies_deportes_cual`, `hvp_interes_habitos_hobbies_aire`, `hvp_interes_habitos_hobbies_aire_frecuencia`, `hvp_interes_habitos_hobbies_aire_cual`, `hvp_interes_habitos_hobbies_arte`, `hvp_interes_habitos_hobbies_arte_frecuencia`, `hvp_interes_habitos_hobbies_arte_instrumento`, `hvp_interes_habitos_hobbies_arte_cual`, `hvp_interes_habitos_hobbies_tecnologia`, `hvp_interes_habitos_hobbies_tecnologia_frecuencia`, `hvp_interes_habitos_hobbies_tecnologia_cual`, `hvp_interes_habitos_hobbies_otro`, `hvp_interes_habitos_hobbies_otro_frecuencia`, `hvp_interes_habitos_hobbies_otro_cual`, `hvp_interes_habitos_hobbies_recibir_informacion`, `hvp_interes_habitos_actividades_familia`, `hvp_interes_habitos_actividades_deportivas`, `hvp_interes_habitos_actividades_deportivas_cual`, `hvp_interes_habitos_medio_transporte`, `hvp_interes_habitos_habito_ahorro`, `hvp_interes_habitos_mascotas`, `hvp_interes_habitos_mascotas_cual`, `hvp_formacion_nivel_academico_culminado`, `hvp_formacion_ultimo_certificado_enviado_rrhh`, `hvp_formacion_ultimo_estudio_realizado_titulo`, `hvp_formacion_tarjeta_profesional`, `hvp_formacion_estudios_curso`, `hvp_formacion_estudios_curso_titulo`, `hvp_formacion_estudios_curso_nivel`, `hvp_formacion_estudios_curso_establecimiento`, `hvp_habilidades_nivel_ingles`, `hvp_habilidades_nivel_excel`, `hvp_habilidades_nivel_google_ws`, `hvp_poblaciones_poblacion`, `hvp_poblaciones_certificado`, `hvp_poblaciones_poblacion_soporte`, `hvp_poblaciones_familiares_iq`, `hvp_poblaciones_familiares_iq_identificacion`, `hvp_poblaciones_familiares_iq_nombres_apellidos`, `hvp_poblaciones_familiares_iq_ingreso_marzo_2022`, `hvp_financiero_activos`, `hvp_financiero_ingresos`, `hvp_financiero_pasivos`, `hvp_financiero_egresos`, `hvp_financiero_patrimonio`, `hvp_financiero_ingresos_otros`, `hvp_financiero_concepto_ingresos`, `hvp_financiero_moneda_extranjera`, `hvp_origen_fondos`, `hvp_pep_recursos`, `hvp_pep_reconocimiento`, `hvp_pep_poder`, `hvp_pep_familiar`, `hvp_pep_cedula`, `hvp_pep_nombres_apellidos`, `hvp_veracidad`, `hvp_alerta_actualizacion`, `hvp_estado`, `hvp_fecha_ingreso`, `hvp_retiro_fecha`, `hvp_retiro_motivo`, `hvp_auxiliar_1`, `hvp_auxiliar_2`, `hvp_auxiliar_3`, `hvp_auxiliar_4`, `hvp_auxiliar_5`, `hvp_usuario_nt`, `hvp_observaciones`, `hvp_actualiza_usuario`, `hvp_actualiza_fecha`, `hvp_registro_usuario`, `hvp_registro_fecha`, TCIUDAD.`ciu_departamento` AS TCIUDAD_ciu_departamento, TCIUDAD.`ciu_municipio` AS TCIUDAD_ciu_municipio, TCIUDADN.`ciu_departamento` AS TCIUDADN_ciu_departamento, TCIUDADN.`ciu_municipio` AS TCIUDADN_ciu_municipio, TCAR.`ac_nombre`, TCC.`aa_nombre` FROM `hoja_vida_personal`
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_personal`.`hvp_ubicacion_ciudad_residencia`=TCIUDAD.`ciu_codigo`
            LEFT JOIN `app_ciudades` AS TCIUDADN ON `hoja_vida_personal`.`hvp_demografia_lugar_nacimiento`=TCIUDADN.`ciu_codigo`
            LEFT JOIN `app_ciudades_barrios` AS TBARRIO ON `hoja_vida_personal`.`hvp_ubicacion_barrio`=TBARRIO.`ciub_id`
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCAR ON `hoja_vida_personal`.`hvp_cargo`=TCAR.`ac_id` LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TCC ON `hoja_vida_personal`.`hvp_centro_costo`=TCC.`aa_id`
             WHERE `hvp_id`=:hvp_id';

            $parametros = [
                'hvp_id' => $this->hvp_id,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listAutorizacion(){
            $sql='SELECT `hvp_id`, `hvp_usuario_id`, `hvp_aspirante_id`, `hvp_centro_costo`, `hvp_cargo`, `hvp_consentimiento_tratamiento_datos_personales`, `hvp_consentimiento_tratamiento_datos_personales_fecha`, `hvp_datos_personales_tipo_documento`, `hvp_datos_personales_numero_identificacion`, `hvp_datos_personales_apellido_1`, `hvp_datos_personales_apellido_2`, `hvp_datos_personales_nombre_1`, `hvp_datos_personales_nombre_2`, `hvp_demografia_genero`, `hvp_demografia_estado_civil`, `hvp_demografia_lugar_nacimiento`, `hvp_demografia_fecha_nacimiento`, `hvp_demografia_edad`, `hvp_ubicacion_direccion_residencia`, `hvp_ubicacion_ciudad_residencia`, `hvp_ubicacion_localidad_comuna`, `hvp_ubicacion_barrio`, `hvp_ubicacion_maps_latitud`, `hvp_ubicacion_maps_longitud`, `hvp_ubicacion_maps_ciudad`, `hvp_ubicacion_maps_departamento`, `hvp_ubicacion_maps_pais`, `hvp_ubicacion_maps_localidad`, `hvp_ubicacion_maps_barrio`, `hvp_ubicacion_maps_codigo_postal`, `hvp_ubicacion_maps_direccion`, `hvp_socioeconomico_estrato_socioeconomico`, `hvp_socioeconomico_operador_internet`, `hvp_socioeconomico_operador_internet_otro`, `hvp_socioeconomico_velocidad_internet_carga`, `hvp_socioeconomico_velocidad_internet_descarga`, `hvp_socioeconomico_caracteristicas_vivienda`, `hvp_socioeconomico_condiciones_vivienda`, `hvp_socioeconomico_estado_terminacion_vivienda`, `hvp_socioeconomico_servicios_vivienda`, `hvp_socioeconomico_plan_compra_vivienda`, `hvp_socioeconomico_beneficiario_subsidio_vivienda`, `hvp_contacto_numero_celular`, `hvp_contacto_correo_personal`, `hvp_contacto_correo_corporativo`, `hvp_contacto_emergencia_nombres`, `hvp_contacto_emergencia_apellidos`, `hvp_contacto_emergencia_parentesco`, `hvp_contacto_emergencia_celular`, `hvp_contacto_emergencia_nombres_2`, `hvp_contacto_emergencia_apellidos_2`, `hvp_contacto_emergencia_parentesco_2`, `hvp_contacto_emergencia_celular_2`, `hvp_salud_bienestar_grupo_sanguineo`, `hvp_salud_bienestar_rh`, `hvp_salud_bienestar_actividad_fisica_minima`, `hvp_salud_bienestar_fumador`, `hvp_salud_bienestar_pausas_activas`, `hvp_salud_bienestar_medicina_prepagada`, `hvp_salud_bienestar_medicina_prepagada_cual`, `hvp_salud_bienestar_plan_complementario_salud`, `hvp_salud_bienestar_plan_complementario_salud_cual`, `hvp_familia_numero_hijos`, `hvp_familia_hijos_menor_3`, `hvp_familia_hijos_4_10`, `hvp_familia_hijos_11_17`, `hvp_familia_hijos_mayor_18`, `hvp_familia_capacitacion_familia`, `hvp_expectativa_motivacion_motivacion_trabajo`, `hvp_expectativa_motivacion_expectativa_desarrollo`, `hvp_expectativa_motivacion_expectativa_crecimiento_profesional`, `hvp_expectativa_motivacion_realidad_crecimiento_profesional`, `hvp_interes_habitos_hobbies_deportes`, `hvp_interes_habitos_hobbies_deportes_frecuencia`, `hvp_interes_habitos_hobbies_deportes_cual`, `hvp_interes_habitos_hobbies_aire`, `hvp_interes_habitos_hobbies_aire_frecuencia`, `hvp_interes_habitos_hobbies_aire_cual`, `hvp_interes_habitos_hobbies_arte`, `hvp_interes_habitos_hobbies_arte_frecuencia`, `hvp_interes_habitos_hobbies_arte_instrumento`, `hvp_interes_habitos_hobbies_arte_cual`, `hvp_interes_habitos_hobbies_tecnologia`, `hvp_interes_habitos_hobbies_tecnologia_frecuencia`, `hvp_interes_habitos_hobbies_tecnologia_cual`, `hvp_interes_habitos_hobbies_otro`, `hvp_interes_habitos_hobbies_otro_frecuencia`, `hvp_interes_habitos_hobbies_otro_cual`, `hvp_interes_habitos_hobbies_recibir_informacion`, `hvp_interes_habitos_actividades_familia`, `hvp_interes_habitos_actividades_deportivas`, `hvp_interes_habitos_actividades_deportivas_cual`, `hvp_interes_habitos_medio_transporte`, `hvp_interes_habitos_habito_ahorro`, `hvp_interes_habitos_mascotas`, `hvp_interes_habitos_mascotas_cual`, `hvp_formacion_nivel_academico_culminado`, `hvp_formacion_ultimo_certificado_enviado_rrhh`, `hvp_formacion_ultimo_estudio_realizado_titulo`, `hvp_formacion_tarjeta_profesional`, `hvp_formacion_estudios_curso`, `hvp_formacion_estudios_curso_titulo`, `hvp_formacion_estudios_curso_nivel`, `hvp_formacion_estudios_curso_establecimiento`, `hvp_habilidades_nivel_ingles`, `hvp_habilidades_nivel_excel`, `hvp_habilidades_nivel_google_ws`, `hvp_poblaciones_poblacion`, `hvp_poblaciones_certificado`, `hvp_poblaciones_poblacion_soporte`, `hvp_poblaciones_familiares_iq`, `hvp_poblaciones_familiares_iq_identificacion`, `hvp_poblaciones_familiares_iq_nombres_apellidos`, `hvp_poblaciones_familiares_iq_ingreso_marzo_2022`, `hvp_financiero_activos`, `hvp_financiero_ingresos`, `hvp_financiero_pasivos`, `hvp_financiero_egresos`, `hvp_financiero_patrimonio`, `hvp_financiero_ingresos_otros`, `hvp_financiero_concepto_ingresos`, `hvp_financiero_moneda_extranjera`, `hvp_origen_fondos`, `hvp_pep_recursos`, `hvp_pep_reconocimiento`, `hvp_pep_poder`, `hvp_pep_familiar`, `hvp_pep_cedula`, `hvp_pep_nombres_apellidos`, `hvp_veracidad`, `hvp_alerta_actualizacion`, `hvp_estado`, `hvp_fecha_ingreso`, `hvp_retiro_fecha`, `hvp_retiro_motivo`, `hvp_auxiliar_1`, `hvp_auxiliar_2`, `hvp_auxiliar_3`, `hvp_auxiliar_4`, `hvp_auxiliar_5`, `hvp_usuario_nt`, `hvp_observaciones`, `hvp_actualiza_usuario`, `hvp_actualiza_fecha`, `hvp_registro_usuario`, `hvp_registro_fecha`, TCIUDAD.`ciu_departamento` AS TCIUDAD_ciu_departamento, TCIUDAD.`ciu_municipio` AS TCIUDAD_ciu_municipio, TCIUDADN.`ciu_departamento` AS TCIUDADN_ciu_departamento, TCIUDADN.`ciu_municipio` AS TCIUDADN_ciu_municipio, TCAR.`ac_nombre`, TCC.`aa_nombre` FROM `hoja_vida_personal`
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_personal`.`hvp_ubicacion_ciudad_residencia`=TCIUDAD.`ciu_codigo`
            LEFT JOIN `app_ciudades` AS TCIUDADN ON `hoja_vida_personal`.`hvp_demografia_lugar_nacimiento`=TCIUDADN.`ciu_codigo`
            LEFT JOIN `app_ciudades_barrios` AS TBARRIO ON `hoja_vida_personal`.`hvp_ubicacion_barrio`=TBARRIO.`ciub_id`
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCAR ON `hoja_vida_personal`.`hvp_cargo`=TCAR.`ac_id` LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TCC ON `hoja_vida_personal`.`hvp_centro_costo`=TCC.`aa_id`
             WHERE `hvp_consentimiento_tratamiento_datos_personales`<>:hvp_consentimiento_tratamiento_datos_personales AND `hvp_auxiliar_3`<>:hvp_auxiliar_3';

            $parametros = [
                'hvp_consentimiento_tratamiento_datos_personales' => '',
                'hvp_auxiliar_3' => '',
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listDuplicate(){
            $sql='SELECT `hvp_id`, `hvp_usuario_id`, `hvp_aspirante_id`, `hvp_centro_costo`, `hvp_cargo`, `hvp_consentimiento_tratamiento_datos_personales`, `hvp_consentimiento_tratamiento_datos_personales_fecha`, `hvp_datos_personales_tipo_documento`, `hvp_datos_personales_numero_identificacion`, `hvp_datos_personales_apellido_1`, `hvp_datos_personales_apellido_2`, `hvp_datos_personales_nombre_1`, `hvp_datos_personales_nombre_2`, `hvp_demografia_genero`, `hvp_demografia_estado_civil`, `hvp_demografia_lugar_nacimiento`, `hvp_demografia_fecha_nacimiento`, `hvp_demografia_edad`, `hvp_ubicacion_direccion_residencia`, `hvp_ubicacion_ciudad_residencia`, `hvp_ubicacion_localidad_comuna`, `hvp_ubicacion_barrio`, `hvp_ubicacion_maps_latitud`, `hvp_ubicacion_maps_longitud`, `hvp_ubicacion_maps_ciudad`, `hvp_ubicacion_maps_departamento`, `hvp_ubicacion_maps_pais`, `hvp_ubicacion_maps_localidad`, `hvp_ubicacion_maps_barrio`, `hvp_ubicacion_maps_codigo_postal`, `hvp_ubicacion_maps_direccion`, `hvp_socioeconomico_estrato_socioeconomico`, `hvp_socioeconomico_operador_internet`, `hvp_socioeconomico_operador_internet_otro`, `hvp_socioeconomico_velocidad_internet_carga`, `hvp_socioeconomico_velocidad_internet_descarga`, `hvp_socioeconomico_caracteristicas_vivienda`, `hvp_socioeconomico_condiciones_vivienda`, `hvp_socioeconomico_estado_terminacion_vivienda`, `hvp_socioeconomico_servicios_vivienda`, `hvp_socioeconomico_plan_compra_vivienda`, `hvp_socioeconomico_beneficiario_subsidio_vivienda`, `hvp_contacto_numero_celular`, `hvp_contacto_correo_personal`, `hvp_contacto_correo_corporativo`, `hvp_contacto_emergencia_nombres`, `hvp_contacto_emergencia_apellidos`, `hvp_contacto_emergencia_parentesco`, `hvp_contacto_emergencia_celular`, `hvp_contacto_emergencia_nombres_2`, `hvp_contacto_emergencia_apellidos_2`, `hvp_contacto_emergencia_parentesco_2`, `hvp_contacto_emergencia_celular_2`, `hvp_salud_bienestar_grupo_sanguineo`, `hvp_salud_bienestar_rh`, `hvp_salud_bienestar_actividad_fisica_minima`, `hvp_salud_bienestar_fumador`, `hvp_salud_bienestar_pausas_activas`, `hvp_salud_bienestar_medicina_prepagada`, `hvp_salud_bienestar_medicina_prepagada_cual`, `hvp_salud_bienestar_plan_complementario_salud`, `hvp_salud_bienestar_plan_complementario_salud_cual`, `hvp_familia_numero_hijos`, `hvp_familia_hijos_menor_3`, `hvp_familia_hijos_4_10`, `hvp_familia_hijos_11_17`, `hvp_familia_hijos_mayor_18`, `hvp_familia_capacitacion_familia`, `hvp_expectativa_motivacion_motivacion_trabajo`, `hvp_expectativa_motivacion_expectativa_desarrollo`, `hvp_expectativa_motivacion_expectativa_crecimiento_profesional`, `hvp_expectativa_motivacion_realidad_crecimiento_profesional`, `hvp_interes_habitos_hobbies_deportes`, `hvp_interes_habitos_hobbies_deportes_frecuencia`, `hvp_interes_habitos_hobbies_deportes_cual`, `hvp_interes_habitos_hobbies_aire`, `hvp_interes_habitos_hobbies_aire_frecuencia`, `hvp_interes_habitos_hobbies_aire_cual`, `hvp_interes_habitos_hobbies_arte`, `hvp_interes_habitos_hobbies_arte_frecuencia`, `hvp_interes_habitos_hobbies_arte_instrumento`, `hvp_interes_habitos_hobbies_arte_cual`, `hvp_interes_habitos_hobbies_tecnologia`, `hvp_interes_habitos_hobbies_tecnologia_frecuencia`, `hvp_interes_habitos_hobbies_tecnologia_cual`, `hvp_interes_habitos_hobbies_otro`, `hvp_interes_habitos_hobbies_otro_frecuencia`, `hvp_interes_habitos_hobbies_otro_cual`, `hvp_interes_habitos_hobbies_recibir_informacion`, `hvp_interes_habitos_actividades_familia`, `hvp_interes_habitos_actividades_deportivas`, `hvp_interes_habitos_actividades_deportivas_cual`, `hvp_interes_habitos_medio_transporte`, `hvp_interes_habitos_habito_ahorro`, `hvp_interes_habitos_mascotas`, `hvp_interes_habitos_mascotas_cual`, `hvp_formacion_nivel_academico_culminado`, `hvp_formacion_ultimo_certificado_enviado_rrhh`, `hvp_formacion_ultimo_estudio_realizado_titulo`, `hvp_formacion_tarjeta_profesional`, `hvp_formacion_estudios_curso`, `hvp_formacion_estudios_curso_titulo`, `hvp_formacion_estudios_curso_nivel`, `hvp_formacion_estudios_curso_establecimiento`, `hvp_habilidades_nivel_ingles`, `hvp_habilidades_nivel_excel`, `hvp_habilidades_nivel_google_ws`, `hvp_poblaciones_poblacion`, `hvp_poblaciones_certificado`, `hvp_poblaciones_poblacion_soporte`, `hvp_poblaciones_familiares_iq`, `hvp_poblaciones_familiares_iq_identificacion`, `hvp_poblaciones_familiares_iq_nombres_apellidos`, `hvp_poblaciones_familiares_iq_ingreso_marzo_2022`, `hvp_financiero_activos`, `hvp_financiero_ingresos`, `hvp_financiero_pasivos`, `hvp_financiero_egresos`, `hvp_financiero_patrimonio`, `hvp_financiero_ingresos_otros`, `hvp_financiero_concepto_ingresos`, `hvp_financiero_moneda_extranjera`, `hvp_origen_fondos`, `hvp_pep_recursos`, `hvp_pep_reconocimiento`, `hvp_pep_poder`, `hvp_pep_familiar`, `hvp_pep_cedula`, `hvp_pep_nombres_apellidos`, `hvp_veracidad`, `hvp_alerta_actualizacion`, `hvp_estado`, `hvp_fecha_ingreso`, `hvp_retiro_fecha`, `hvp_retiro_motivo`, `hvp_auxiliar_1`, `hvp_auxiliar_2`, `hvp_auxiliar_3`, `hvp_auxiliar_4`, `hvp_auxiliar_5`, `hvp_usuario_nt`, `hvp_observaciones`, `hvp_actualiza_usuario`, `hvp_actualiza_fecha`, `hvp_registro_usuario`, `hvp_registro_fecha`, TCIUDAD.`ciu_departamento` AS TCIUDAD_ciu_departamento, TCIUDAD.`ciu_municipio` AS TCIUDAD_ciu_municipio, TCIUDADN.`ciu_departamento` AS TCIUDADN_ciu_departamento, TCIUDADN.`ciu_municipio` AS TCIUDADN_ciu_municipio, TCAR.`ac_nombre`, TCC.`aa_nombre` FROM `hoja_vida_personal`
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_personal`.`hvp_ubicacion_ciudad_residencia`=TCIUDAD.`ciu_codigo`
            LEFT JOIN `app_ciudades` AS TCIUDADN ON `hoja_vida_personal`.`hvp_demografia_lugar_nacimiento`=TCIUDADN.`ciu_codigo`
            LEFT JOIN `app_ciudades_barrios` AS TBARRIO ON `hoja_vida_personal`.`hvp_ubicacion_barrio`=TBARRIO.`ciub_id`
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCAR ON `hoja_vida_personal`.`hvp_cargo`=TCAR.`ac_id` LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TCC ON `hoja_vida_personal`.`hvp_centro_costo`=TCC.`aa_id`
             WHERE `hvp_datos_personales_numero_identificacion`=:hvp_datos_personales_numero_identificacion';

            $parametros = [
                'hvp_datos_personales_numero_identificacion' => $this->hvp_datos_personales_numero_identificacion,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listAllReport(){
            $parametros = [
                
            ];

            if ($this->fecha_inicio!="" AND $this->fecha_inicio!="null" AND $this->fecha_fin!="" AND $this->fecha_fin!="null") {
                $filtro_fecha_str=" AND `hvp_fecha_ingreso`>=:fecha_inicio AND `hvp_fecha_ingreso`<=:fecha_fin";
                $parametros_filtro = [
                    'fecha_inicio' => $this->fecha_inicio,
                    'fecha_fin' => $this->fecha_fin,
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_fecha_str="";
            }

            if ($this->fecha_inicio_retiro!="" AND $this->fecha_inicio_retiro!="null" AND $this->fecha_fin_retiro!="" AND $this->fecha_fin_retiro!="null") {
                $filtro_fecha_retiro_str=" AND `hvp_retiro_fecha`>=:fecha_inicio_retiro AND `hvp_retiro_fecha`<=:fecha_fin_retiro";
                $parametros_filtro = [
                    'fecha_inicio_retiro' => $this->fecha_inicio_retiro,
                    'fecha_fin_retiro' => $this->fecha_fin_retiro,
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_fecha_retiro_str="";
            }

            if ($this->hvp_estado!="" AND $this->hvp_estado!="null") {
                $hvp_estado_str=" AND `hvp_estado`=:hvp_estado";
                $parametros_filtro = [
                    'hvp_estado' => $this->hvp_estado,
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $hvp_estado_str="";
            }

            $sql='SELECT `hvp_id`, `hvp_usuario_id`, `hvp_aspirante_id`, `hvp_centro_costo`, `hvp_cargo`, `hvp_consentimiento_tratamiento_datos_personales`, `hvp_consentimiento_tratamiento_datos_personales_fecha`, `hvp_datos_personales_tipo_documento`, `hvp_datos_personales_numero_identificacion`, `hvp_datos_personales_apellido_1`, `hvp_datos_personales_apellido_2`, `hvp_datos_personales_nombre_1`, `hvp_datos_personales_nombre_2`, `hvp_demografia_genero`, `hvp_demografia_estado_civil`, `hvp_demografia_lugar_nacimiento`, `hvp_demografia_fecha_nacimiento`, `hvp_demografia_edad`, `hvp_ubicacion_direccion_residencia`, `hvp_ubicacion_ciudad_residencia`, `hvp_ubicacion_localidad_comuna`, `hvp_ubicacion_barrio`, `hvp_ubicacion_maps_latitud`, `hvp_ubicacion_maps_longitud`, `hvp_ubicacion_maps_ciudad`, `hvp_ubicacion_maps_departamento`, `hvp_ubicacion_maps_pais`, `hvp_ubicacion_maps_localidad`, `hvp_ubicacion_maps_barrio`, `hvp_ubicacion_maps_codigo_postal`, `hvp_ubicacion_maps_direccion`, `hvp_socioeconomico_estrato_socioeconomico`, `hvp_socioeconomico_operador_internet`, `hvp_socioeconomico_operador_internet_otro`, `hvp_socioeconomico_velocidad_internet_carga`, `hvp_socioeconomico_velocidad_internet_descarga`, `hvp_socioeconomico_caracteristicas_vivienda`, `hvp_socioeconomico_condiciones_vivienda`, `hvp_socioeconomico_estado_terminacion_vivienda`, `hvp_socioeconomico_servicios_vivienda`, `hvp_socioeconomico_plan_compra_vivienda`, `hvp_socioeconomico_beneficiario_subsidio_vivienda`, `hvp_contacto_numero_celular`, `hvp_contacto_correo_personal`, `hvp_contacto_correo_corporativo`, `hvp_contacto_emergencia_nombres`, `hvp_contacto_emergencia_apellidos`, `hvp_contacto_emergencia_parentesco`, `hvp_contacto_emergencia_celular`, `hvp_contacto_emergencia_nombres_2`, `hvp_contacto_emergencia_apellidos_2`, `hvp_contacto_emergencia_parentesco_2`, `hvp_contacto_emergencia_celular_2`, `hvp_salud_bienestar_grupo_sanguineo`, `hvp_salud_bienestar_rh`, `hvp_salud_bienestar_actividad_fisica_minima`, `hvp_salud_bienestar_fumador`, `hvp_salud_bienestar_pausas_activas`, `hvp_salud_bienestar_medicina_prepagada`, `hvp_salud_bienestar_medicina_prepagada_cual`, `hvp_salud_bienestar_plan_complementario_salud`, `hvp_salud_bienestar_plan_complementario_salud_cual`, `hvp_familia_numero_hijos`, `hvp_familia_hijos_menor_3`, `hvp_familia_hijos_4_10`, `hvp_familia_hijos_11_17`, `hvp_familia_hijos_mayor_18`, `hvp_familia_capacitacion_familia`, `hvp_expectativa_motivacion_motivacion_trabajo`, `hvp_expectativa_antiguedad`, `hvp_expectativa_motivacion_expectativa_desarrollo`, `hvp_expectativa_motivacion_expectativa_crecimiento_profesional`, `hvp_expectativa_motivacion_realidad_crecimiento_profesional`, `hvp_interes_habitos_hobbies_deportes`, `hvp_interes_habitos_hobbies_deportes_frecuencia`, `hvp_interes_habitos_hobbies_deportes_cual`, `hvp_interes_habitos_hobbies_aire`, `hvp_interes_habitos_hobbies_aire_frecuencia`, `hvp_interes_habitos_hobbies_aire_cual`, `hvp_interes_habitos_hobbies_arte`, `hvp_interes_habitos_hobbies_arte_frecuencia`, `hvp_interes_habitos_hobbies_arte_instrumento`, `hvp_interes_habitos_hobbies_arte_cual`, `hvp_interes_habitos_hobbies_tecnologia`, `hvp_interes_habitos_hobbies_tecnologia_frecuencia`, `hvp_interes_habitos_hobbies_tecnologia_cual`, `hvp_interes_habitos_hobbies_otro`, `hvp_interes_habitos_hobbies_otro_frecuencia`, `hvp_interes_habitos_hobbies_otro_cual`, `hvp_interes_habitos_hobbies_recibir_informacion`, `hvp_interes_habitos_actividades_familia`, `hvp_interes_habitos_actividades_deportivas`, `hvp_interes_habitos_actividades_deportivas_cual`, `hvp_interes_habitos_medio_transporte`, `hvp_interes_habitos_habito_ahorro`, `hvp_interes_habitos_mascotas`, `hvp_interes_habitos_mascotas_cual`, `hvp_formacion_nivel_academico_culminado`, `hvp_formacion_ultimo_certificado_enviado_rrhh`, `hvp_formacion_ultimo_estudio_realizado_titulo`, `hvp_formacion_tarjeta_profesional`, `hvp_formacion_estudios_curso`, `hvp_formacion_estudios_curso_titulo`, `hvp_formacion_estudios_curso_nivel`, `hvp_formacion_estudios_curso_establecimiento`, `hvp_habilidades_nivel_ingles`, `hvp_habilidades_nivel_excel`, `hvp_habilidades_nivel_google_ws`, `hvp_poblaciones_poblacion`, `hvp_poblaciones_certificado`, `hvp_poblaciones_poblacion_soporte`, `hvp_poblaciones_familiares_iq`, `hvp_poblaciones_familiares_iq_identificacion`, `hvp_poblaciones_familiares_iq_nombres_apellidos`, `hvp_poblaciones_familiares_iq_ingreso_marzo_2022`, `hvp_financiero_activos`, `hvp_financiero_ingresos`, `hvp_financiero_pasivos`, `hvp_financiero_egresos`, `hvp_financiero_patrimonio`, `hvp_financiero_ingresos_otros`, `hvp_financiero_concepto_ingresos`, `hvp_financiero_moneda_extranjera`, `hvp_origen_fondos`, `hvp_pep_recursos`, `hvp_pep_reconocimiento`, `hvp_pep_poder`, `hvp_pep_familiar`, `hvp_pep_cedula`, `hvp_pep_nombres_apellidos`, `hvp_veracidad`, `hvp_alerta_actualizacion`, `hvp_estado`, `hvp_fecha_ingreso`, `hvp_retiro_fecha`, `hvp_retiro_motivo`, `hvp_auxiliar_1`, `hvp_auxiliar_2`, `hvp_auxiliar_3`, `hvp_auxiliar_4`, `hvp_auxiliar_5`, `hvp_usuario_nt`, `hvp_observaciones`, `hvp_actualiza_usuario`, `hvp_actualiza_fecha`, `hvp_registro_usuario`, `hvp_registro_fecha`, TCIUDAD.`ciu_departamento` AS TCIUDAD_ciu_departamento, TCIUDAD.`ciu_municipio` AS TCIUDAD_ciu_municipio, TCIUDADN.`ciu_departamento` AS TCIUDADN_ciu_departamento, TCIUDADN.`ciu_municipio` AS TCIUDADN_ciu_municipio, TCAR.`ac_nombre`, TCC.`aa_nombre`, TASP.`hva_auxiliar_5` FROM `hoja_vida_personal` 
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_personal`.`hvp_ubicacion_ciudad_residencia`=TCIUDAD.`ciu_codigo`
            LEFT JOIN `app_ciudades` AS TCIUDADN ON `hoja_vida_personal`.`hvp_demografia_lugar_nacimiento`=TCIUDADN.`ciu_codigo`
            LEFT JOIN `app_ciudades_barrios` AS TBARRIO ON `hoja_vida_personal`.`hvp_ubicacion_barrio`=TBARRIO.`ciub_id`
            LEFT JOIN `hoja_vida_aspirante` AS TASP ON `hoja_vida_personal`.`hvp_aspirante_id`=TASP.`hva_id`
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCAR ON `hoja_vida_personal`.`hvp_cargo`=TCAR.`ac_id` LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TCC ON `hoja_vida_personal`.`hvp_centro_costo`=TCC.`aa_id`
             WHERE 1=1 '.$filtro_fecha_str.' '.$filtro_fecha_retiro_str.' '.$hvp_estado_str.'';

            

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listAllReportAspirantes(){
            $parametros = [
                'hvp_estado_1' => 'Activo',
                'hvp_estado_2' => 'Retirado',
            ];

            if ($this->hvp_estado!="" AND $this->hvp_estado!="null") {
                $hvp_estado_str=" AND `hvp_estado`=:hvp_estado";
                $parametros_filtro = [
                    'hvp_estado' => $this->hvp_estado,
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $hvp_estado_str="";
            }

            $sql='SELECT `hvp_id`, `hvp_usuario_id`, `hvp_aspirante_id`, `hvp_centro_costo`, `hvp_cargo`, `hvp_consentimiento_tratamiento_datos_personales`, `hvp_consentimiento_tratamiento_datos_personales_fecha`, `hvp_datos_personales_tipo_documento`, `hvp_datos_personales_numero_identificacion`, `hvp_datos_personales_apellido_1`, `hvp_datos_personales_apellido_2`, `hvp_datos_personales_nombre_1`, `hvp_datos_personales_nombre_2`, `hvp_demografia_genero`, `hvp_demografia_estado_civil`, `hvp_demografia_lugar_nacimiento`, `hvp_demografia_fecha_nacimiento`, `hvp_demografia_edad`, `hvp_ubicacion_direccion_residencia`, `hvp_ubicacion_ciudad_residencia`, `hvp_ubicacion_localidad_comuna`, `hvp_ubicacion_barrio`, `hvp_ubicacion_maps_latitud`, `hvp_ubicacion_maps_longitud`, `hvp_ubicacion_maps_ciudad`, `hvp_ubicacion_maps_departamento`, `hvp_ubicacion_maps_pais`, `hvp_ubicacion_maps_localidad`, `hvp_ubicacion_maps_barrio`, `hvp_ubicacion_maps_codigo_postal`, `hvp_ubicacion_maps_direccion`, `hvp_socioeconomico_estrato_socioeconomico`, `hvp_socioeconomico_operador_internet`, `hvp_socioeconomico_operador_internet_otro`, `hvp_socioeconomico_velocidad_internet_carga`, `hvp_socioeconomico_velocidad_internet_descarga`, `hvp_socioeconomico_caracteristicas_vivienda`, `hvp_socioeconomico_condiciones_vivienda`, `hvp_socioeconomico_estado_terminacion_vivienda`, `hvp_socioeconomico_servicios_vivienda`, `hvp_socioeconomico_plan_compra_vivienda`, `hvp_socioeconomico_beneficiario_subsidio_vivienda`, `hvp_contacto_numero_celular`, `hvp_contacto_correo_personal`, `hvp_contacto_correo_corporativo`, `hvp_contacto_emergencia_nombres`, `hvp_contacto_emergencia_apellidos`, `hvp_contacto_emergencia_parentesco`, `hvp_contacto_emergencia_celular`, `hvp_contacto_emergencia_nombres_2`, `hvp_contacto_emergencia_apellidos_2`, `hvp_contacto_emergencia_parentesco_2`, `hvp_contacto_emergencia_celular_2`, `hvp_salud_bienestar_grupo_sanguineo`, `hvp_salud_bienestar_rh`, `hvp_salud_bienestar_actividad_fisica_minima`, `hvp_salud_bienestar_fumador`, `hvp_salud_bienestar_pausas_activas`, `hvp_salud_bienestar_medicina_prepagada`, `hvp_salud_bienestar_medicina_prepagada_cual`, `hvp_salud_bienestar_plan_complementario_salud`, `hvp_salud_bienestar_plan_complementario_salud_cual`, `hvp_familia_numero_hijos`, `hvp_familia_hijos_menor_3`, `hvp_familia_hijos_4_10`, `hvp_familia_hijos_11_17`, `hvp_familia_hijos_mayor_18`, `hvp_familia_capacitacion_familia`, `hvp_expectativa_motivacion_motivacion_trabajo`, `hvp_expectativa_antiguedad`, `hvp_expectativa_motivacion_expectativa_desarrollo`, `hvp_expectativa_motivacion_expectativa_crecimiento_profesional`, `hvp_expectativa_motivacion_realidad_crecimiento_profesional`, `hvp_interes_habitos_hobbies_deportes`, `hvp_interes_habitos_hobbies_deportes_frecuencia`, `hvp_interes_habitos_hobbies_deportes_cual`, `hvp_interes_habitos_hobbies_aire`, `hvp_interes_habitos_hobbies_aire_frecuencia`, `hvp_interes_habitos_hobbies_aire_cual`, `hvp_interes_habitos_hobbies_arte`, `hvp_interes_habitos_hobbies_arte_frecuencia`, `hvp_interes_habitos_hobbies_arte_instrumento`, `hvp_interes_habitos_hobbies_arte_cual`, `hvp_interes_habitos_hobbies_tecnologia`, `hvp_interes_habitos_hobbies_tecnologia_frecuencia`, `hvp_interes_habitos_hobbies_tecnologia_cual`, `hvp_interes_habitos_hobbies_otro`, `hvp_interes_habitos_hobbies_otro_frecuencia`, `hvp_interes_habitos_hobbies_otro_cual`, `hvp_interes_habitos_hobbies_recibir_informacion`, `hvp_interes_habitos_actividades_familia`, `hvp_interes_habitos_actividades_deportivas`, `hvp_interes_habitos_actividades_deportivas_cual`, `hvp_interes_habitos_medio_transporte`, `hvp_interes_habitos_habito_ahorro`, `hvp_interes_habitos_mascotas`, `hvp_interes_habitos_mascotas_cual`, `hvp_formacion_nivel_academico_culminado`, `hvp_formacion_ultimo_certificado_enviado_rrhh`, `hvp_formacion_ultimo_estudio_realizado_titulo`, `hvp_formacion_tarjeta_profesional`, `hvp_formacion_estudios_curso`, `hvp_formacion_estudios_curso_titulo`, `hvp_formacion_estudios_curso_nivel`, `hvp_formacion_estudios_curso_establecimiento`, `hvp_habilidades_nivel_ingles`, `hvp_habilidades_nivel_excel`, `hvp_habilidades_nivel_google_ws`, `hvp_poblaciones_poblacion`, `hvp_poblaciones_certificado`, `hvp_poblaciones_poblacion_soporte`, `hvp_poblaciones_familiares_iq`, `hvp_poblaciones_familiares_iq_identificacion`, `hvp_poblaciones_familiares_iq_nombres_apellidos`, `hvp_poblaciones_familiares_iq_ingreso_marzo_2022`, `hvp_financiero_activos`, `hvp_financiero_ingresos`, `hvp_financiero_pasivos`, `hvp_financiero_egresos`, `hvp_financiero_patrimonio`, `hvp_financiero_ingresos_otros`, `hvp_financiero_concepto_ingresos`, `hvp_financiero_moneda_extranjera`, `hvp_origen_fondos`, `hvp_pep_recursos`, `hvp_pep_reconocimiento`, `hvp_pep_poder`, `hvp_pep_familiar`, `hvp_pep_cedula`, `hvp_pep_nombres_apellidos`, `hvp_veracidad`, `hvp_alerta_actualizacion`, `hvp_estado`, `hvp_fecha_ingreso`, `hvp_retiro_fecha`, `hvp_retiro_motivo`, `hvp_auxiliar_1`, `hvp_auxiliar_2`, `hvp_auxiliar_3`, `hvp_auxiliar_4`, `hvp_auxiliar_5`, `hvp_usuario_nt`, `hvp_observaciones`, `hvp_actualiza_usuario`, `hvp_actualiza_fecha`, `hvp_registro_usuario`, `hvp_registro_fecha`, TCIUDAD.`ciu_departamento` AS TCIUDAD_ciu_departamento, TCIUDAD.`ciu_municipio` AS TCIUDAD_ciu_municipio, TCIUDADN.`ciu_departamento` AS TCIUDADN_ciu_departamento, TCIUDADN.`ciu_municipio` AS TCIUDADN_ciu_municipio, TCAR.`ac_nombre`, TCC.`aa_nombre` FROM `hoja_vida_personal` 
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `hoja_vida_personal`.`hvp_ubicacion_ciudad_residencia`=TCIUDAD.`ciu_codigo`
            LEFT JOIN `app_ciudades` AS TCIUDADN ON `hoja_vida_personal`.`hvp_demografia_lugar_nacimiento`=TCIUDADN.`ciu_codigo`
            LEFT JOIN `app_ciudades_barrios` AS TBARRIO ON `hoja_vida_personal`.`hvp_ubicacion_barrio`=TBARRIO.`ciub_id`
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCAR ON `hoja_vida_personal`.`hvp_cargo`=TCAR.`ac_id` LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TCC ON `hoja_vida_personal`.`hvp_centro_costo`=TCC.`aa_id`
             WHERE 1=1 AND (`hvp_estado`=:hvp_estado_1 OR `hvp_estado`=:hvp_estado_2) '.$hvp_estado_str.'';

            

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listPendienteDiligenciamiento(){
            $sql='SELECT `hvp_id`, `hvp_usuario_id`, `hvp_aspirante_id`, `hvp_centro_costo`, `hvp_cargo`, `hvp_consentimiento_tratamiento_datos_personales`, `hvp_consentimiento_tratamiento_datos_personales_fecha`, `hvp_datos_personales_tipo_documento`, `hvp_datos_personales_numero_identificacion`, `hvp_datos_personales_apellido_1`, `hvp_datos_personales_apellido_2`, `hvp_datos_personales_nombre_1`, `hvp_datos_personales_nombre_2`, `hvp_demografia_genero`, `hvp_demografia_estado_civil`, `hvp_demografia_lugar_nacimiento`, `hvp_demografia_fecha_nacimiento`, `hvp_demografia_edad`, `hvp_ubicacion_direccion_residencia`, `hvp_ubicacion_ciudad_residencia`, `hvp_ubicacion_localidad_comuna`, `hvp_ubicacion_barrio`, `hvp_ubicacion_maps_latitud`, `hvp_ubicacion_maps_longitud`, `hvp_ubicacion_maps_ciudad`, `hvp_ubicacion_maps_departamento`, `hvp_ubicacion_maps_pais`, `hvp_ubicacion_maps_localidad`, `hvp_ubicacion_maps_barrio`, `hvp_ubicacion_maps_codigo_postal`, `hvp_ubicacion_maps_direccion`, `hvp_socioeconomico_estrato_socioeconomico`, `hvp_socioeconomico_operador_internet`, `hvp_socioeconomico_operador_internet_otro`, `hvp_socioeconomico_velocidad_internet_carga`, `hvp_socioeconomico_velocidad_internet_descarga`, `hvp_socioeconomico_caracteristicas_vivienda`, `hvp_socioeconomico_condiciones_vivienda`, `hvp_socioeconomico_estado_terminacion_vivienda`, `hvp_socioeconomico_servicios_vivienda`, `hvp_socioeconomico_plan_compra_vivienda`, `hvp_socioeconomico_beneficiario_subsidio_vivienda`, `hvp_contacto_numero_celular`, `hvp_contacto_correo_personal`, `hvp_contacto_correo_corporativo`, `hvp_contacto_emergencia_nombres`, `hvp_contacto_emergencia_apellidos`, `hvp_contacto_emergencia_parentesco`, `hvp_contacto_emergencia_celular`, `hvp_contacto_emergencia_nombres_2`, `hvp_contacto_emergencia_apellidos_2`, `hvp_contacto_emergencia_parentesco_2`, `hvp_contacto_emergencia_celular_2`, `hvp_salud_bienestar_grupo_sanguineo`, `hvp_salud_bienestar_rh`, `hvp_salud_bienestar_actividad_fisica_minima`, `hvp_salud_bienestar_fumador`, `hvp_salud_bienestar_pausas_activas`, `hvp_salud_bienestar_medicina_prepagada`, `hvp_salud_bienestar_medicina_prepagada_cual`, `hvp_salud_bienestar_plan_complementario_salud`, `hvp_salud_bienestar_plan_complementario_salud_cual`, `hvp_familia_numero_hijos`, `hvp_familia_hijos_menor_3`, `hvp_familia_hijos_4_10`, `hvp_familia_hijos_11_17`, `hvp_familia_hijos_mayor_18`, `hvp_familia_capacitacion_familia`, `hvp_expectativa_motivacion_motivacion_trabajo`, `hvp_expectativa_motivacion_expectativa_desarrollo`, `hvp_expectativa_motivacion_expectativa_crecimiento_profesional`, `hvp_expectativa_motivacion_realidad_crecimiento_profesional`, `hvp_interes_habitos_hobbies_deportes`, `hvp_interes_habitos_hobbies_deportes_frecuencia`, `hvp_interes_habitos_hobbies_deportes_cual`, `hvp_interes_habitos_hobbies_aire`, `hvp_interes_habitos_hobbies_aire_frecuencia`, `hvp_interes_habitos_hobbies_aire_cual`, `hvp_interes_habitos_hobbies_arte`, `hvp_interes_habitos_hobbies_arte_frecuencia`, `hvp_interes_habitos_hobbies_arte_instrumento`, `hvp_interes_habitos_hobbies_arte_cual`, `hvp_interes_habitos_hobbies_tecnologia`, `hvp_interes_habitos_hobbies_tecnologia_frecuencia`, `hvp_interes_habitos_hobbies_tecnologia_cual`, `hvp_interes_habitos_hobbies_otro`, `hvp_interes_habitos_hobbies_otro_frecuencia`, `hvp_interes_habitos_hobbies_otro_cual`, `hvp_interes_habitos_hobbies_recibir_informacion`, `hvp_interes_habitos_actividades_familia`, `hvp_interes_habitos_actividades_deportivas`, `hvp_interes_habitos_actividades_deportivas_cual`, `hvp_interes_habitos_medio_transporte`, `hvp_interes_habitos_habito_ahorro`, `hvp_interes_habitos_mascotas`, `hvp_interes_habitos_mascotas_cual`, `hvp_formacion_nivel_academico_culminado`, `hvp_formacion_ultimo_certificado_enviado_rrhh`, `hvp_formacion_ultimo_estudio_realizado_titulo`, `hvp_formacion_tarjeta_profesional`, `hvp_formacion_estudios_curso`, `hvp_formacion_estudios_curso_titulo`, `hvp_formacion_estudios_curso_nivel`, `hvp_formacion_estudios_curso_establecimiento`, `hvp_habilidades_nivel_ingles`, `hvp_habilidades_nivel_excel`, `hvp_habilidades_nivel_google_ws`, `hvp_poblaciones_poblacion`, `hvp_poblaciones_certificado`, `hvp_poblaciones_poblacion_soporte`, `hvp_poblaciones_familiares_iq`, `hvp_poblaciones_familiares_iq_identificacion`, `hvp_poblaciones_familiares_iq_nombres_apellidos`, `hvp_poblaciones_familiares_iq_ingreso_marzo_2022`, `hvp_financiero_activos`, `hvp_financiero_ingresos`, `hvp_financiero_pasivos`, `hvp_financiero_egresos`, `hvp_financiero_patrimonio`, `hvp_financiero_ingresos_otros`, `hvp_financiero_concepto_ingresos`, `hvp_financiero_moneda_extranjera`, `hvp_origen_fondos`, `hvp_pep_recursos`, `hvp_pep_reconocimiento`, `hvp_pep_poder`, `hvp_pep_familiar`, `hvp_pep_cedula`, `hvp_pep_nombres_apellidos`, `hvp_veracidad`, `hvp_alerta_actualizacion`, `hvp_estado`, `hvp_fecha_ingreso`, `hvp_retiro_fecha`, `hvp_retiro_motivo`, `hvp_auxiliar_1`, `hvp_auxiliar_2`, `hvp_auxiliar_3`, `hvp_auxiliar_4`, `hvp_auxiliar_5`, `hvp_usuario_nt`, `hvp_observaciones`, `hvp_actualiza_usuario`, `hvp_actualiza_fecha`, `hvp_registro_usuario`, `hvp_registro_fecha` FROM `hoja_vida_personal`
             WHERE `hvp_estado`=:hvp_estado AND (`hvp_consentimiento_tratamiento_datos_personales`=:hvp_consentimiento_tratamiento_datos_personales OR `hvp_auxiliar_3`=:hvp_auxiliar_3 OR `hvp_consentimiento_tratamiento_datos_personales_fecha`=:hvp_consentimiento_tratamiento_datos_personales_fecha OR
             `hvp_auxiliar_1`=:hvp_auxiliar_1 OR 
                `hvp_datos_personales_tipo_documento`=:hvp_datos_personales_tipo_documento OR 
                `hvp_datos_personales_numero_identificacion`=:hvp_datos_personales_numero_identificacion OR 
                `hvp_datos_personales_apellido_1`=:hvp_datos_personales_apellido_1 OR 
                `hvp_datos_personales_nombre_1`=:hvp_datos_personales_nombre_1 OR 
                `hvp_demografia_genero`=:hvp_demografia_genero OR 
                `hvp_demografia_estado_civil`=:hvp_demografia_estado_civil OR 
                `hvp_demografia_lugar_nacimiento`=:hvp_demografia_lugar_nacimiento OR 
                `hvp_demografia_fecha_nacimiento`=:hvp_demografia_fecha_nacimiento OR 
                `hvp_ubicacion_direccion_residencia`=:hvp_ubicacion_direccion_residencia OR 
                `hvp_ubicacion_ciudad_residencia`=:hvp_ubicacion_ciudad_residencia OR 
                `hvp_contacto_numero_celular`=:hvp_contacto_numero_celular OR 
                `hvp_contacto_correo_personal`=:hvp_contacto_correo_personal OR 
                `hvp_contacto_correo_corporativo`=:hvp_contacto_correo_corporativo OR 
                `hvp_contacto_emergencia_nombres`=:hvp_contacto_emergencia_nombres OR 
                `hvp_contacto_emergencia_apellidos`=:hvp_contacto_emergencia_apellidos OR 
                `hvp_contacto_emergencia_parentesco`=:hvp_contacto_emergencia_parentesco OR 
                `hvp_contacto_emergencia_celular`=:hvp_contacto_emergencia_celular OR 
                `hvp_contacto_emergencia_nombres_2`=:hvp_contacto_emergencia_nombres_2 OR 
                `hvp_contacto_emergencia_apellidos_2`=:hvp_contacto_emergencia_apellidos_2 OR 
                `hvp_contacto_emergencia_parentesco_2`=:hvp_contacto_emergencia_parentesco_2 OR 
                `hvp_contacto_emergencia_celular_2`=:hvp_contacto_emergencia_celular_2 OR 
                `hvp_socioeconomico_condiciones_vivienda`=:hvp_socioeconomico_condiciones_vivienda OR 
                `hvp_socioeconomico_estrato_socioeconomico`=:hvp_socioeconomico_estrato_socioeconomico OR 
                `hvp_socioeconomico_operador_internet`=:hvp_socioeconomico_operador_internet OR 
                `hvp_socioeconomico_velocidad_internet_descarga`=:hvp_socioeconomico_velocidad_internet_descarga OR 
                `hvp_socioeconomico_velocidad_internet_carga`=:hvp_socioeconomico_velocidad_internet_carga OR 
                `hvp_socioeconomico_caracteristicas_vivienda`=:hvp_socioeconomico_caracteristicas_vivienda OR 
                `hvp_socioeconomico_estado_terminacion_vivienda`=:hvp_socioeconomico_estado_terminacion_vivienda OR 
                `hvp_socioeconomico_servicios_vivienda`=:hvp_socioeconomico_servicios_vivienda OR 
                `hvp_socioeconomico_plan_compra_vivienda`=:hvp_socioeconomico_plan_compra_vivienda OR 
                `hvp_socioeconomico_beneficiario_subsidio_vivienda`=:hvp_socioeconomico_beneficiario_subsidio_vivienda OR 
                `hvp_financiero_activos`=:hvp_financiero_activos OR 
                `hvp_financiero_ingresos`=:hvp_financiero_ingresos OR 
                `hvp_financiero_pasivos`=:hvp_financiero_pasivos OR 
                `hvp_financiero_egresos`=:hvp_financiero_egresos OR 
                `hvp_financiero_patrimonio`=:hvp_financiero_patrimonio OR 
                `hvp_financiero_ingresos_otros`=:hvp_financiero_ingresos_otros OR 
                `hvp_financiero_moneda_extranjera`=:hvp_financiero_moneda_extranjera OR 
                `hvp_origen_fondos`=:hvp_origen_fondos OR 
                `hvp_pep_recursos`=:hvp_pep_recursos OR 
                `hvp_pep_reconocimiento`=:hvp_pep_reconocimiento OR 
                `hvp_pep_poder`=:hvp_pep_poder OR 
                `hvp_pep_familiar`=:hvp_pep_familiar OR 
                `hvp_salud_bienestar_grupo_sanguineo`=:hvp_salud_bienestar_grupo_sanguineo OR 
                `hvp_salud_bienestar_rh`=:hvp_salud_bienestar_rh OR 
                `hvp_salud_bienestar_actividad_fisica_minima`=:hvp_salud_bienestar_actividad_fisica_minima OR 
                `hvp_salud_bienestar_fumador`=:hvp_salud_bienestar_fumador OR 
                `hvp_salud_bienestar_pausas_activas`=:hvp_salud_bienestar_pausas_activas OR 
                `hvp_salud_bienestar_medicina_prepagada`=:hvp_salud_bienestar_medicina_prepagada OR 
                `hvp_interes_habitos_hobbies_deportes`=:hvp_interes_habitos_hobbies_deportes OR 
                `hvp_interes_habitos_hobbies_aire`=:hvp_interes_habitos_hobbies_aire OR 
                `hvp_interes_habitos_hobbies_arte`=:hvp_interes_habitos_hobbies_arte OR 
                `hvp_interes_habitos_hobbies_tecnologia`=:hvp_interes_habitos_hobbies_tecnologia OR 
                `hvp_interes_habitos_hobbies_otro`=:hvp_interes_habitos_hobbies_otro OR 
                `hvp_interes_habitos_hobbies_recibir_informacion`=:hvp_interes_habitos_hobbies_recibir_informacion OR 
                `hvp_formacion_ultimo_certificado_enviado_rrhh`=:hvp_formacion_ultimo_certificado_enviado_rrhh OR 
                `hvp_formacion_ultimo_estudio_realizado_titulo`=:hvp_formacion_ultimo_estudio_realizado_titulo OR 
                `hvp_formacion_tarjeta_profesional`=:hvp_formacion_tarjeta_profesional OR 
                `hvp_formacion_estudios_curso`=:hvp_formacion_estudios_curso OR 
                `hvp_habilidades_nivel_ingles`=:hvp_habilidades_nivel_ingles OR 
                `hvp_habilidades_nivel_excel`=:hvp_habilidades_nivel_excel OR 
                `hvp_habilidades_nivel_google_ws`=:hvp_habilidades_nivel_google_ws OR 
                `hvp_poblaciones_poblacion`=:hvp_poblaciones_poblacion OR 
                `hvp_poblaciones_familiares_iq`=:hvp_poblaciones_familiares_iq OR 
                `hvp_veracidad`=:hvp_veracidad)';

            $parametros = [
                'hvp_estado' => $this->hvp_estado,
                'hvp_consentimiento_tratamiento_datos_personales' => '',
                'hvp_auxiliar_3' => '',
                'hvp_consentimiento_tratamiento_datos_personales_fecha' => '',
                'hvp_auxiliar_1' => '',
                'hvp_datos_personales_tipo_documento' => '',
                'hvp_datos_personales_numero_identificacion' => '',
                'hvp_datos_personales_apellido_1' => '',
                'hvp_datos_personales_nombre_1' => '',
                'hvp_demografia_genero' => '',
                'hvp_demografia_estado_civil' => '',
                'hvp_demografia_lugar_nacimiento' => '',
                'hvp_demografia_fecha_nacimiento' => '',
                'hvp_ubicacion_direccion_residencia' => '',
                'hvp_ubicacion_ciudad_residencia' => '',
                'hvp_contacto_numero_celular' => '',
                'hvp_contacto_correo_personal' => '',
                'hvp_contacto_correo_corporativo' => '',
                'hvp_contacto_emergencia_nombres' => '',
                'hvp_contacto_emergencia_apellidos' => '',
                'hvp_contacto_emergencia_parentesco' => '',
                'hvp_contacto_emergencia_celular' => '',
                'hvp_contacto_emergencia_nombres_2' => '',
                'hvp_contacto_emergencia_apellidos_2' => '',
                'hvp_contacto_emergencia_parentesco_2' => '',
                'hvp_contacto_emergencia_celular_2' => '',
                'hvp_socioeconomico_condiciones_vivienda' => '',
                'hvp_socioeconomico_estrato_socioeconomico' => '',
                'hvp_socioeconomico_operador_internet' => '',
                'hvp_socioeconomico_velocidad_internet_descarga' => '',
                'hvp_socioeconomico_velocidad_internet_carga' => '',
                'hvp_socioeconomico_caracteristicas_vivienda' => '',
                'hvp_socioeconomico_estado_terminacion_vivienda' => '',
                'hvp_socioeconomico_servicios_vivienda' => '',
                'hvp_socioeconomico_plan_compra_vivienda' => '',
                'hvp_socioeconomico_beneficiario_subsidio_vivienda' => '',
                'hvp_financiero_activos' => '',
                'hvp_financiero_ingresos' => '',
                'hvp_financiero_pasivos' => '',
                'hvp_financiero_egresos' => '',
                'hvp_financiero_patrimonio' => '',
                'hvp_financiero_ingresos_otros' => '',
                'hvp_financiero_moneda_extranjera' => '',
                'hvp_origen_fondos' => '',
                'hvp_pep_recursos' => '',
                'hvp_pep_reconocimiento' => '',
                'hvp_pep_poder' => '',
                'hvp_pep_familiar' => '',
                'hvp_salud_bienestar_grupo_sanguineo' => '',
                'hvp_salud_bienestar_rh' => '',
                'hvp_salud_bienestar_actividad_fisica_minima' => '',
                'hvp_salud_bienestar_fumador' => '',
                'hvp_salud_bienestar_pausas_activas' => '',
                'hvp_salud_bienestar_medicina_prepagada' => '',
                'hvp_interes_habitos_hobbies_deportes' => '',
                'hvp_interes_habitos_hobbies_aire' => '',
                'hvp_interes_habitos_hobbies_arte' => '',
                'hvp_interes_habitos_hobbies_tecnologia' => '',
                'hvp_interes_habitos_hobbies_otro' => '',
                'hvp_interes_habitos_hobbies_recibir_informacion' => '',
                'hvp_formacion_ultimo_certificado_enviado_rrhh' => '',
                'hvp_formacion_ultimo_estudio_realizado_titulo' => '',
                'hvp_formacion_tarjeta_profesional' => '',
                'hvp_formacion_estudios_curso' => '',
                'hvp_habilidades_nivel_ingles' => '',
                'hvp_habilidades_nivel_excel' => '',
                'hvp_habilidades_nivel_google_ws' => '',
                'hvp_poblaciones_poblacion' => '',
                'hvp_poblaciones_familiares_iq' => '',
                'hvp_veracidad' => '',
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
            $sql='INSERT INTO `hoja_vida_personal`(`hvp_usuario_id`, `hvp_aspirante_id`, `hvp_centro_costo`, `hvp_cargo`, `hvp_consentimiento_tratamiento_datos_personales`, `hvp_consentimiento_tratamiento_datos_personales_fecha`, `hvp_datos_personales_tipo_documento`, `hvp_datos_personales_numero_identificacion`, `hvp_datos_personales_apellido_1`, `hvp_datos_personales_apellido_2`, `hvp_datos_personales_nombre_1`, `hvp_datos_personales_nombre_2`, `hvp_demografia_genero`, `hvp_demografia_estado_civil`, `hvp_demografia_lugar_nacimiento`, `hvp_demografia_fecha_nacimiento`, `hvp_demografia_edad`, `hvp_ubicacion_direccion_residencia`, `hvp_ubicacion_ciudad_residencia`, `hvp_ubicacion_localidad_comuna`, `hvp_ubicacion_barrio`, `hvp_ubicacion_maps_latitud`, `hvp_ubicacion_maps_longitud`, `hvp_ubicacion_maps_ciudad`, `hvp_ubicacion_maps_departamento`, `hvp_ubicacion_maps_pais`, `hvp_ubicacion_maps_localidad`, `hvp_ubicacion_maps_barrio`, `hvp_ubicacion_maps_codigo_postal`, `hvp_ubicacion_maps_direccion`, `hvp_socioeconomico_estrato_socioeconomico`, `hvp_socioeconomico_operador_internet`, `hvp_socioeconomico_operador_internet_otro`, `hvp_socioeconomico_velocidad_internet_carga`, `hvp_socioeconomico_velocidad_internet_descarga`, `hvp_socioeconomico_caracteristicas_vivienda`, `hvp_socioeconomico_condiciones_vivienda`, `hvp_socioeconomico_estado_terminacion_vivienda`, `hvp_socioeconomico_servicios_vivienda`, `hvp_socioeconomico_plan_compra_vivienda`, `hvp_socioeconomico_beneficiario_subsidio_vivienda`, `hvp_contacto_numero_celular`, `hvp_contacto_correo_personal`, `hvp_contacto_correo_corporativo`, `hvp_contacto_emergencia_nombres`, `hvp_contacto_emergencia_apellidos`, `hvp_contacto_emergencia_parentesco`, `hvp_contacto_emergencia_celular`, `hvp_contacto_emergencia_nombres_2`, `hvp_contacto_emergencia_apellidos_2`, `hvp_contacto_emergencia_parentesco_2`, `hvp_contacto_emergencia_celular_2`, `hvp_salud_bienestar_grupo_sanguineo`, `hvp_salud_bienestar_rh`, `hvp_salud_bienestar_actividad_fisica_minima`, `hvp_salud_bienestar_fumador`, `hvp_salud_bienestar_pausas_activas`, `hvp_salud_bienestar_medicina_prepagada`, `hvp_salud_bienestar_medicina_prepagada_cual`, `hvp_salud_bienestar_plan_complementario_salud`, `hvp_salud_bienestar_plan_complementario_salud_cual`, `hvp_familia_numero_hijos`, `hvp_familia_hijos_menor_3`, `hvp_familia_hijos_4_10`, `hvp_familia_hijos_11_17`, `hvp_familia_hijos_mayor_18`, `hvp_familia_capacitacion_familia`, `hvp_expectativa_motivacion_motivacion_trabajo`, `hvp_expectativa_antiguedad`, `hvp_expectativa_motivacion_expectativa_desarrollo`, `hvp_expectativa_motivacion_expectativa_crecimiento_profesional`, `hvp_expectativa_motivacion_realidad_crecimiento_profesional`, `hvp_interes_habitos_hobbies_deportes`, `hvp_interes_habitos_hobbies_deportes_frecuencia`, `hvp_interes_habitos_hobbies_deportes_cual`, `hvp_interes_habitos_hobbies_aire`, `hvp_interes_habitos_hobbies_aire_frecuencia`, `hvp_interes_habitos_hobbies_aire_cual`, `hvp_interes_habitos_hobbies_arte`, `hvp_interes_habitos_hobbies_arte_frecuencia`, `hvp_interes_habitos_hobbies_arte_instrumento`, `hvp_interes_habitos_hobbies_arte_cual`, `hvp_interes_habitos_hobbies_tecnologia`, `hvp_interes_habitos_hobbies_tecnologia_frecuencia`, `hvp_interes_habitos_hobbies_tecnologia_cual`, `hvp_interes_habitos_hobbies_otro`, `hvp_interes_habitos_hobbies_otro_frecuencia`, `hvp_interes_habitos_hobbies_otro_cual`, `hvp_interes_habitos_hobbies_recibir_informacion`, `hvp_interes_habitos_actividades_familia`, `hvp_interes_habitos_actividades_deportivas`, `hvp_interes_habitos_actividades_deportivas_cual`, `hvp_interes_habitos_medio_transporte`, `hvp_interes_habitos_habito_ahorro`, `hvp_interes_habitos_mascotas`, `hvp_interes_habitos_mascotas_cual`, `hvp_formacion_nivel_academico_culminado`, `hvp_formacion_ultimo_certificado_enviado_rrhh`, `hvp_formacion_ultimo_estudio_realizado_titulo`, `hvp_formacion_tarjeta_profesional`, `hvp_formacion_estudios_curso`, `hvp_formacion_estudios_curso_titulo`, `hvp_formacion_estudios_curso_nivel`, `hvp_formacion_estudios_curso_establecimiento`, `hvp_habilidades_nivel_ingles`, `hvp_habilidades_nivel_excel`, `hvp_habilidades_nivel_google_ws`, `hvp_poblaciones_poblacion`, `hvp_poblaciones_certificado`, `hvp_poblaciones_poblacion_soporte`, `hvp_poblaciones_familiares_iq`, `hvp_poblaciones_familiares_iq_identificacion`, `hvp_poblaciones_familiares_iq_nombres_apellidos`, `hvp_poblaciones_familiares_iq_ingreso_marzo_2022`, `hvp_financiero_activos`, `hvp_financiero_ingresos`, `hvp_financiero_pasivos`, `hvp_financiero_egresos`, `hvp_financiero_patrimonio`, `hvp_financiero_ingresos_otros`, `hvp_financiero_concepto_ingresos`, `hvp_financiero_moneda_extranjera`, `hvp_origen_fondos`, `hvp_pep_recursos`, `hvp_pep_reconocimiento`, `hvp_pep_poder`, `hvp_pep_familiar`, `hvp_pep_cedula`, `hvp_pep_nombres_apellidos`, `hvp_veracidad`, `hvp_alerta_actualizacion`, `hvp_estado`, `hvp_fecha_ingreso`, `hvp_retiro_fecha`, `hvp_retiro_motivo`, `hvp_auxiliar_1`, `hvp_auxiliar_2`, `hvp_auxiliar_3`, `hvp_auxiliar_4`, `hvp_auxiliar_5`, `hvp_usuario_nt`, `hvp_observaciones`, `hvp_actualiza_usuario`, `hvp_actualiza_fecha`, `hvp_registro_usuario`) VALUES (:hvp_usuario_id, :hvp_aspirante_id, :hvp_centro_costo, :hvp_cargo, :hvp_consentimiento_tratamiento_datos_personales, :hvp_consentimiento_tratamiento_datos_personales_fecha, :hvp_datos_personales_tipo_documento, :hvp_datos_personales_numero_identificacion, :hvp_datos_personales_apellido_1, :hvp_datos_personales_apellido_2, :hvp_datos_personales_nombre_1, :hvp_datos_personales_nombre_2, :hvp_demografia_genero, :hvp_demografia_estado_civil, :hvp_demografia_lugar_nacimiento, :hvp_demografia_fecha_nacimiento, :hvp_demografia_edad, :hvp_ubicacion_direccion_residencia, :hvp_ubicacion_ciudad_residencia, :hvp_ubicacion_localidad_comuna, :hvp_ubicacion_barrio, :hvp_ubicacion_maps_latitud, :hvp_ubicacion_maps_longitud, :hvp_ubicacion_maps_ciudad, :hvp_ubicacion_maps_departamento, :hvp_ubicacion_maps_pais, :hvp_ubicacion_maps_localidad, :hvp_ubicacion_maps_barrio, :hvp_ubicacion_maps_codigo_postal, :hvp_ubicacion_maps_direccion, :hvp_socioeconomico_estrato_socioeconomico, :hvp_socioeconomico_operador_internet, :hvp_socioeconomico_operador_internet_otro, :hvp_socioeconomico_velocidad_internet_carga, :hvp_socioeconomico_velocidad_internet_descarga, :hvp_socioeconomico_caracteristicas_vivienda, :hvp_socioeconomico_condiciones_vivienda, :hvp_socioeconomico_estado_terminacion_vivienda, :hvp_socioeconomico_servicios_vivienda, :hvp_socioeconomico_plan_compra_vivienda, :hvp_socioeconomico_beneficiario_subsidio_vivienda, :hvp_contacto_numero_celular, :hvp_contacto_correo_personal, :hvp_contacto_correo_corporativo, :hvp_contacto_emergencia_nombres, :hvp_contacto_emergencia_apellidos, :hvp_contacto_emergencia_parentesco, :hvp_contacto_emergencia_celular, :hvp_contacto_emergencia_nombres_2, :hvp_contacto_emergencia_apellidos_2, :hvp_contacto_emergencia_parentesco_2, :hvp_contacto_emergencia_celular_2, :hvp_salud_bienestar_grupo_sanguineo, :hvp_salud_bienestar_rh, :hvp_salud_bienestar_actividad_fisica_minima, :hvp_salud_bienestar_fumador, :hvp_salud_bienestar_pausas_activas, :hvp_salud_bienestar_medicina_prepagada, :hvp_salud_bienestar_medicina_prepagada_cual, :hvp_salud_bienestar_plan_complementario_salud, :hvp_salud_bienestar_plan_complementario_salud_cual, :hvp_familia_numero_hijos, :hvp_familia_hijos_menor_3, :hvp_familia_hijos_4_10, :hvp_familia_hijos_11_17, :hvp_familia_hijos_mayor_18, :hvp_familia_capacitacion_familia, :hvp_expectativa_motivacion_motivacion_trabajo, :hvp_expectativa_antiguedad, :hvp_expectativa_motivacion_expectativa_desarrollo, :hvp_expectativa_motivacion_expectativa_crecimiento_profesional, :hvp_expectativa_motivacion_realidad_crecimiento_profesional, :hvp_interes_habitos_hobbies_deportes, :hvp_interes_habitos_hobbies_deportes_frecuencia, :hvp_interes_habitos_hobbies_deportes_cual, :hvp_interes_habitos_hobbies_aire, :hvp_interes_habitos_hobbies_aire_frecuencia, :hvp_interes_habitos_hobbies_aire_cual, :hvp_interes_habitos_hobbies_arte, :hvp_interes_habitos_hobbies_arte_frecuencia, :hvp_interes_habitos_hobbies_arte_instrumento, :hvp_interes_habitos_hobbies_arte_cual, :hvp_interes_habitos_hobbies_tecnologia, :hvp_interes_habitos_hobbies_tecnologia_frecuencia, :hvp_interes_habitos_hobbies_tecnologia_cual, :hvp_interes_habitos_hobbies_otro, :hvp_interes_habitos_hobbies_otro_frecuencia, :hvp_interes_habitos_hobbies_otro_cual, :hvp_interes_habitos_hobbies_recibir_informacion, :hvp_interes_habitos_actividades_familia, :hvp_interes_habitos_actividades_deportivas, :hvp_interes_habitos_actividades_deportivas_cual, :hvp_interes_habitos_medio_transporte, :hvp_interes_habitos_habito_ahorro, :hvp_interes_habitos_mascotas, :hvp_interes_habitos_mascotas_cual, :hvp_formacion_nivel_academico_culminado, :hvp_formacion_ultimo_certificado_enviado_rrhh, :hvp_formacion_ultimo_estudio_realizado_titulo, :hvp_formacion_tarjeta_profesional, :hvp_formacion_estudios_curso, :hvp_formacion_estudios_curso_titulo, :hvp_formacion_estudios_curso_nivel, :hvp_formacion_estudios_curso_establecimiento, :hvp_habilidades_nivel_ingles, :hvp_habilidades_nivel_excel, :hvp_habilidades_nivel_google_ws, :hvp_poblaciones_poblacion, :hvp_poblaciones_certificado, :hvp_poblaciones_poblacion_soporte, :hvp_poblaciones_familiares_iq, :hvp_poblaciones_familiares_iq_identificacion, :hvp_poblaciones_familiares_iq_nombres_apellidos, :hvp_poblaciones_familiares_iq_ingreso_marzo_2022, :hvp_financiero_activos, :hvp_financiero_ingresos, :hvp_financiero_pasivos, :hvp_financiero_egresos, :hvp_financiero_patrimonio, :hvp_financiero_ingresos_otros, :hvp_financiero_concepto_ingresos, :hvp_financiero_moneda_extranjera, :hvp_origen_fondos, :hvp_pep_recursos, :hvp_pep_reconocimiento, :hvp_pep_poder, :hvp_pep_familiar, :hvp_pep_cedula, :hvp_pep_nombres_apellidos, :hvp_veracidad, :hvp_alerta_actualizacion, :hvp_estado, :hvp_fecha_ingreso, :hvp_retiro_fecha, :hvp_retiro_motivo, :hvp_auxiliar_1, :hvp_auxiliar_2, :hvp_auxiliar_3, :hvp_auxiliar_4, :hvp_auxiliar_5, :hvp_usuario_nt, :hvp_observaciones, :hvp_actualiza_usuario, :hvp_actualiza_fecha, :hvp_registro_usuario)';

            $parametros = [
                'hvp_usuario_id' => $this->hvp_usuario_id,
                'hvp_aspirante_id' => $this->hvp_aspirante_id,
                'hvp_centro_costo' => $this->hvp_centro_costo,
                'hvp_cargo' => $this->hvp_cargo,
                'hvp_consentimiento_tratamiento_datos_personales' => $this->hvp_consentimiento_tratamiento_datos_personales,
                'hvp_consentimiento_tratamiento_datos_personales_fecha' => $this->hvp_consentimiento_tratamiento_datos_personales_fecha,
                'hvp_datos_personales_tipo_documento' => $this->hvp_datos_personales_tipo_documento,
                'hvp_datos_personales_numero_identificacion' => $this->hvp_datos_personales_numero_identificacion,
                'hvp_datos_personales_apellido_1' => $this->hvp_datos_personales_apellido_1,
                'hvp_datos_personales_apellido_2' => $this->hvp_datos_personales_apellido_2,
                'hvp_datos_personales_nombre_1' => $this->hvp_datos_personales_nombre_1,
                'hvp_datos_personales_nombre_2' => $this->hvp_datos_personales_nombre_2,
                'hvp_demografia_genero' => $this->hvp_demografia_genero,
                'hvp_demografia_estado_civil' => $this->hvp_demografia_estado_civil,
                'hvp_demografia_lugar_nacimiento' => $this->hvp_demografia_lugar_nacimiento,
                'hvp_demografia_fecha_nacimiento' => $this->hvp_demografia_fecha_nacimiento,
                'hvp_demografia_edad' => $this->hvp_demografia_edad,
                'hvp_ubicacion_direccion_residencia' => $this->hvp_ubicacion_direccion_residencia,
                'hvp_ubicacion_ciudad_residencia' => $this->hvp_ubicacion_ciudad_residencia,
                'hvp_ubicacion_localidad_comuna' => $this->hvp_ubicacion_localidad_comuna,
                'hvp_ubicacion_barrio' => $this->hvp_ubicacion_barrio,
                'hvp_ubicacion_maps_latitud' => $this->hvp_ubicacion_maps_latitud,
                'hvp_ubicacion_maps_longitud' => $this->hvp_ubicacion_maps_longitud,
                'hvp_ubicacion_maps_ciudad' => $this->hvp_ubicacion_maps_ciudad,
                'hvp_ubicacion_maps_departamento' => $this->hvp_ubicacion_maps_departamento,
                'hvp_ubicacion_maps_pais' => $this->hvp_ubicacion_maps_pais,
                'hvp_ubicacion_maps_localidad' => $this->hvp_ubicacion_maps_localidad,
                'hvp_ubicacion_maps_barrio' => $this->hvp_ubicacion_maps_barrio,
                'hvp_ubicacion_maps_codigo_postal' => $this->hvp_ubicacion_maps_codigo_postal,
                'hvp_ubicacion_maps_direccion' => $this->hvp_ubicacion_maps_direccion,
                'hvp_socioeconomico_estrato_socioeconomico' => $this->hvp_socioeconomico_estrato_socioeconomico,
                'hvp_socioeconomico_operador_internet' => $this->hvp_socioeconomico_operador_internet,
                'hvp_socioeconomico_operador_internet_otro' => $this->hvp_socioeconomico_operador_internet_otro,
                'hvp_socioeconomico_velocidad_internet_carga' => $this->hvp_socioeconomico_velocidad_internet_carga,
                'hvp_socioeconomico_velocidad_internet_descarga' => $this->hvp_socioeconomico_velocidad_internet_descarga,
                'hvp_socioeconomico_caracteristicas_vivienda' => $this->hvp_socioeconomico_caracteristicas_vivienda,
                'hvp_socioeconomico_condiciones_vivienda' => $this->hvp_socioeconomico_condiciones_vivienda,
                'hvp_socioeconomico_estado_terminacion_vivienda' => $this->hvp_socioeconomico_estado_terminacion_vivienda,
                'hvp_socioeconomico_servicios_vivienda' => $this->hvp_socioeconomico_servicios_vivienda,
                'hvp_socioeconomico_plan_compra_vivienda' => $this->hvp_socioeconomico_plan_compra_vivienda,
                'hvp_socioeconomico_beneficiario_subsidio_vivienda' => $this->hvp_socioeconomico_beneficiario_subsidio_vivienda,
                'hvp_contacto_numero_celular' => $this->hvp_contacto_numero_celular,
                'hvp_contacto_correo_personal' => $this->hvp_contacto_correo_personal,
                'hvp_contacto_correo_corporativo' => $this->hvp_contacto_correo_corporativo,
                'hvp_contacto_emergencia_nombres' => $this->hvp_contacto_emergencia_nombres,
                'hvp_contacto_emergencia_apellidos' => $this->hvp_contacto_emergencia_apellidos,
                'hvp_contacto_emergencia_parentesco' => $this->hvp_contacto_emergencia_parentesco,
                'hvp_contacto_emergencia_celular' => $this->hvp_contacto_emergencia_celular,
                'hvp_contacto_emergencia_nombres_2' => $this->hvp_contacto_emergencia_nombres_2,
                'hvp_contacto_emergencia_apellidos_2' => $this->hvp_contacto_emergencia_apellidos_2,
                'hvp_contacto_emergencia_parentesco_2' => $this->hvp_contacto_emergencia_parentesco_2,
                'hvp_contacto_emergencia_celular_2' => $this->hvp_contacto_emergencia_celular_2,
                'hvp_salud_bienestar_grupo_sanguineo' => $this->hvp_salud_bienestar_grupo_sanguineo,
                'hvp_salud_bienestar_rh' => $this->hvp_salud_bienestar_rh,
                'hvp_salud_bienestar_actividad_fisica_minima' => $this->hvp_salud_bienestar_actividad_fisica_minima,
                'hvp_salud_bienestar_fumador' => $this->hvp_salud_bienestar_fumador,
                'hvp_salud_bienestar_pausas_activas' => $this->hvp_salud_bienestar_pausas_activas,
                'hvp_salud_bienestar_medicina_prepagada' => $this->hvp_salud_bienestar_medicina_prepagada,
                'hvp_salud_bienestar_medicina_prepagada_cual' => $this->hvp_salud_bienestar_medicina_prepagada_cual,
                'hvp_salud_bienestar_plan_complementario_salud' => $this->hvp_salud_bienestar_plan_complementario_salud,
                'hvp_salud_bienestar_plan_complementario_salud_cual' => $this->hvp_salud_bienestar_plan_complementario_salud_cual,
                'hvp_familia_numero_hijos' => $this->hvp_familia_numero_hijos,
                'hvp_familia_hijos_menor_3' => $this->hvp_familia_hijos_menor_3,
                'hvp_familia_hijos_4_10' => $this->hvp_familia_hijos_4_10,
                'hvp_familia_hijos_11_17' => $this->hvp_familia_hijos_11_17,
                'hvp_familia_hijos_mayor_18' => $this->hvp_familia_hijos_mayor_18,
                'hvp_familia_capacitacion_familia' => $this->hvp_familia_capacitacion_familia,
                'hvp_expectativa_motivacion_motivacion_trabajo' => $this->hvp_expectativa_motivacion_motivacion_trabajo,
                'hvp_expectativa_antiguedad' => $this->hvp_expectativa_antiguedad,
                'hvp_expectativa_motivacion_expectativa_desarrollo' => $this->hvp_expectativa_motivacion_expectativa_desarrollo,
                'hvp_expectativa_motivacion_expectativa_crecimiento_profesional' => $this->hvp_expectativa_motivacion_expectativa_crecimiento_profesional,
                'hvp_expectativa_motivacion_realidad_crecimiento_profesional' => $this->hvp_expectativa_motivacion_realidad_crecimiento_profesional,
                'hvp_interes_habitos_hobbies_deportes' => $this->hvp_interes_habitos_hobbies_deportes,
                'hvp_interes_habitos_hobbies_deportes_frecuencia' => $this->hvp_interes_habitos_hobbies_deportes_frecuencia,
                'hvp_interes_habitos_hobbies_deportes_cual' => $this->hvp_interes_habitos_hobbies_deportes_cual,
                'hvp_interes_habitos_hobbies_aire' => $this->hvp_interes_habitos_hobbies_aire,
                'hvp_interes_habitos_hobbies_aire_frecuencia' => $this->hvp_interes_habitos_hobbies_aire_frecuencia,
                'hvp_interes_habitos_hobbies_aire_cual' => $this->hvp_interes_habitos_hobbies_aire_cual,
                'hvp_interes_habitos_hobbies_arte' => $this->hvp_interes_habitos_hobbies_arte,
                'hvp_interes_habitos_hobbies_arte_frecuencia' => $this->hvp_interes_habitos_hobbies_arte_frecuencia,
                'hvp_interes_habitos_hobbies_arte_instrumento' => $this->hvp_interes_habitos_hobbies_arte_instrumento,
                'hvp_interes_habitos_hobbies_arte_cual' => $this->hvp_interes_habitos_hobbies_arte_cual,
                'hvp_interes_habitos_hobbies_tecnologia' => $this->hvp_interes_habitos_hobbies_tecnologia,
                'hvp_interes_habitos_hobbies_tecnologia_frecuencia' => $this->hvp_interes_habitos_hobbies_tecnologia_frecuencia,
                'hvp_interes_habitos_hobbies_tecnologia_cual' => $this->hvp_interes_habitos_hobbies_tecnologia_cual,
                'hvp_interes_habitos_hobbies_otro' => $this->hvp_interes_habitos_hobbies_otro,
                'hvp_interes_habitos_hobbies_otro_frecuencia' => $this->hvp_interes_habitos_hobbies_otro_frecuencia,
                'hvp_interes_habitos_hobbies_otro_cual' => $this->hvp_interes_habitos_hobbies_otro_cual,
                'hvp_interes_habitos_hobbies_recibir_informacion' => $this->hvp_interes_habitos_hobbies_recibir_informacion,
                'hvp_interes_habitos_actividades_familia' => $this->hvp_interes_habitos_actividades_familia,
                'hvp_interes_habitos_actividades_deportivas' => $this->hvp_interes_habitos_actividades_deportivas,
                'hvp_interes_habitos_actividades_deportivas_cual' => $this->hvp_interes_habitos_actividades_deportivas_cual,
                'hvp_interes_habitos_medio_transporte' => $this->hvp_interes_habitos_medio_transporte,
                'hvp_interes_habitos_habito_ahorro' => $this->hvp_interes_habitos_habito_ahorro,
                'hvp_interes_habitos_mascotas' => $this->hvp_interes_habitos_mascotas,
                'hvp_interes_habitos_mascotas_cual' => $this->hvp_interes_habitos_mascotas_cual,
                'hvp_formacion_nivel_academico_culminado' => $this->hvp_formacion_nivel_academico_culminado,
                'hvp_formacion_ultimo_certificado_enviado_rrhh' => $this->hvp_formacion_ultimo_certificado_enviado_rrhh,
                'hvp_formacion_ultimo_estudio_realizado_titulo' => $this->hvp_formacion_ultimo_estudio_realizado_titulo,
                'hvp_formacion_tarjeta_profesional' => $this->hvp_formacion_tarjeta_profesional,
                'hvp_formacion_estudios_curso' => $this->hvp_formacion_estudios_curso,
                'hvp_formacion_estudios_curso_titulo' => $this->hvp_formacion_estudios_curso_titulo,
                'hvp_formacion_estudios_curso_nivel' => $this->hvp_formacion_estudios_curso_nivel,
                'hvp_formacion_estudios_curso_establecimiento' => $this->hvp_formacion_estudios_curso_establecimiento,
                'hvp_habilidades_nivel_ingles' => $this->hvp_habilidades_nivel_ingles,
                'hvp_habilidades_nivel_excel' => $this->hvp_habilidades_nivel_excel,
                'hvp_habilidades_nivel_google_ws' => $this->hvp_habilidades_nivel_google_ws,
                'hvp_poblaciones_poblacion' => $this->hvp_poblaciones_poblacion,
                'hvp_poblaciones_certificado' => $this->hvp_poblaciones_certificado,
                'hvp_poblaciones_poblacion_soporte' => $this->hvp_poblaciones_poblacion_soporte,
                'hvp_poblaciones_familiares_iq' => $this->hvp_poblaciones_familiares_iq,
                'hvp_poblaciones_familiares_iq_identificacion' => $this->hvp_poblaciones_familiares_iq_identificacion,
                'hvp_poblaciones_familiares_iq_nombres_apellidos' => $this->hvp_poblaciones_familiares_iq_nombres_apellidos,
                'hvp_poblaciones_familiares_iq_ingreso_marzo_2022' => $this->hvp_poblaciones_familiares_iq_ingreso_marzo_2022,
                'hvp_financiero_activos' => $this->hvp_financiero_activos,
                'hvp_financiero_ingresos' => $this->hvp_financiero_ingresos,
                'hvp_financiero_pasivos' => $this->hvp_financiero_pasivos,
                'hvp_financiero_egresos' => $this->hvp_financiero_egresos,
                'hvp_financiero_patrimonio' => $this->hvp_financiero_patrimonio,
                'hvp_financiero_ingresos_otros' => $this->hvp_financiero_ingresos_otros,
                'hvp_financiero_concepto_ingresos' => $this->hvp_financiero_concepto_ingresos,
                'hvp_financiero_moneda_extranjera' => $this->hvp_financiero_moneda_extranjera,
                'hvp_origen_fondos' => $this->hvp_origen_fondos,
                'hvp_pep_recursos' => $this->hvp_pep_recursos,
                'hvp_pep_reconocimiento' => $this->hvp_pep_reconocimiento,
                'hvp_pep_poder' => $this->hvp_pep_poder,
                'hvp_pep_familiar' => $this->hvp_pep_familiar,
                'hvp_pep_cedula' => $this->hvp_pep_cedula,
                'hvp_pep_nombres_apellidos' => $this->hvp_pep_nombres_apellidos,
                'hvp_veracidad' => $this->hvp_veracidad,
                'hvp_alerta_actualizacion' => $this->hvp_alerta_actualizacion,
                'hvp_estado' => $this->hvp_estado,
                'hvp_fecha_ingreso' => $this->hvp_fecha_ingreso,
                'hvp_retiro_fecha' => $this->hvp_retiro_fecha,
                'hvp_retiro_motivo' => $this->hvp_retiro_motivo,
                'hvp_auxiliar_1' => $this->hvp_auxiliar_1,
                'hvp_auxiliar_2' => $this->hvp_auxiliar_2,
                'hvp_auxiliar_3' => $this->hvp_auxiliar_3,
                'hvp_auxiliar_4' => $this->hvp_auxiliar_4,
                'hvp_auxiliar_5' => $this->hvp_auxiliar_5,
                'hvp_usuario_nt' => $this->hvp_usuario_nt,
                'hvp_observaciones' => $this->hvp_observaciones,
                'hvp_actualiza_usuario' => $this->hvp_actualiza_usuario,
                'hvp_actualiza_fecha' => $this->hvp_actualiza_fecha,
                'hvp_registro_usuario' => $this->hvp_registro_usuario,
            ];

            try {
                return ($this->hvp_id = parent::query($sql, $parametros)) ? $this->hvp_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateAlertaDocumentos(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_alerta_actualizacion`=:hvp_alerta_actualizacion WHERE `hvp_id`=:hvp_id';

            $parametros = [
                'hvp_id' => $this->hvp_id,
                'hvp_alerta_actualizacion' => $this->hvp_alerta_actualizacion,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateCentroCosto(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_centro_costo`=:hvp_centro_costo, `hvp_actualiza_fecha`=:hvp_actualiza_fecha WHERE `hvp_id`=:hvp_id';

            $parametros = [
                'hvp_id' => $this->hvp_id,
                'hvp_centro_costo' => $this->hvp_centro_costo,
                'hvp_actualiza_fecha' => $this->hvp_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateCargo(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_cargo`=:hvp_cargo, `hvp_actualiza_fecha`=:hvp_actualiza_fecha WHERE `hvp_id`=:hvp_id';

            $parametros = [
                'hvp_id' => $this->hvp_id,
                'hvp_cargo' => $this->hvp_cargo,
                'hvp_actualiza_fecha' => $this->hvp_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateCorreoCorporativo(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_contacto_correo_corporativo`=:hvp_contacto_correo_corporativo, `hvp_usuario_nt`=:hvp_usuario_nt, `hvp_estado`=:hvp_estado,`hvp_actualiza_fecha`=:hvp_actualiza_fecha WHERE `hvp_usuario_id`=:hvp_usuario_id';

            $parametros = [
                'hvp_usuario_id' => $this->hvp_usuario_id,
                'hvp_contacto_correo_corporativo' => $this->hvp_contacto_correo_corporativo,
                'hvp_usuario_nt' => $this->hvp_usuario_nt,
                'hvp_estado' => $this->hvp_estado,
                'hvp_actualiza_fecha' => $this->hvp_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateCorreoCorporativoOnly(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_contacto_correo_corporativo`=:hvp_contacto_correo_corporativo, `hvp_actualiza_fecha`=:hvp_actualiza_fecha WHERE `hvp_usuario_id`=:hvp_usuario_id';

            $parametros = [
                'hvp_usuario_id' => $this->hvp_usuario_id,
                'hvp_contacto_correo_corporativo' => $this->hvp_contacto_correo_corporativo,
                'hvp_actualiza_fecha' => $this->hvp_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateRetiro(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_estado`=:hvp_estado, hvp_retiro_fecha=:hvp_retiro_fecha, `hvp_retiro_motivo`=:hvp_retiro_motivo, `hvp_actualiza_fecha`=:hvp_actualiza_fecha WHERE `hvp_aspirante_id`=:hvp_aspirante_id';

            $parametros = [
                'hvp_aspirante_id' => $this->hvp_aspirante_id,
                'hvp_estado' => $this->hvp_estado,
                'hvp_retiro_fecha' => $this->hvp_retiro_fecha,
                'hvp_retiro_motivo' => $this->hvp_retiro_motivo,
                'hvp_actualiza_fecha' => $this->hvp_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateAutorizacion(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_consentimiento_tratamiento_datos_personales`=:hvp_consentimiento_tratamiento_datos_personales,`hvp_actualiza_fecha`=:hvp_actualiza_fecha WHERE `hvp_usuario_id`=:hvp_usuario_id';

            $parametros = [
                'hvp_usuario_id' => $this->hvp_usuario_id,
                'hvp_consentimiento_tratamiento_datos_personales' => $this->hvp_consentimiento_tratamiento_datos_personales,
                'hvp_actualiza_fecha' => $this->hvp_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateAutorizacionFecha(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_consentimiento_tratamiento_datos_personales_fecha`=:hvp_consentimiento_tratamiento_datos_personales_fecha WHERE `hvp_usuario_id`=:hvp_usuario_id';

            $parametros = [
                'hvp_usuario_id' => $this->hvp_usuario_id,
                'hvp_consentimiento_tratamiento_datos_personales_fecha' => $this->hvp_consentimiento_tratamiento_datos_personales_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateAutorizacionFirma(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_auxiliar_3`=:hvp_auxiliar_3,`hvp_actualiza_fecha`=:hvp_actualiza_fecha WHERE `hvp_usuario_id`=:hvp_usuario_id';

            $parametros = [
                'hvp_usuario_id' => $this->hvp_usuario_id,
                'hvp_auxiliar_3' => $this->hvp_auxiliar_3,
                'hvp_actualiza_fecha' => $this->hvp_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateInformacion(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_datos_personales_apellido_1`=:hvp_datos_personales_apellido_1,`hvp_datos_personales_apellido_2`=:hvp_datos_personales_apellido_2,`hvp_datos_personales_nombre_1`=:hvp_datos_personales_nombre_1,`hvp_datos_personales_nombre_2`=:hvp_datos_personales_nombre_2, `hvp_centro_costo`=:hvp_centro_costo, `hvp_cargo`=:hvp_cargo, `hvp_contacto_correo_corporativo`=:hvp_contacto_correo_corporativo, `hvp_fecha_ingreso`=:hvp_fecha_ingreso, `hvp_observaciones`=:hvp_observaciones WHERE `hvp_id`=:hvp_id';

            $parametros = [
                'hvp_id' => $this->hvp_id,
                'hvp_datos_personales_apellido_1' => $this->hvp_datos_personales_apellido_1,
                'hvp_datos_personales_apellido_2' => $this->hvp_datos_personales_apellido_2,
                'hvp_datos_personales_nombre_1' => $this->hvp_datos_personales_nombre_1,
                'hvp_datos_personales_nombre_2' => $this->hvp_datos_personales_nombre_2,
                'hvp_centro_costo' => $this->hvp_centro_costo,
                'hvp_cargo' => $this->hvp_cargo,
                'hvp_contacto_correo_corporativo' => $this->hvp_contacto_correo_corporativo,
                'hvp_fecha_ingreso' => $this->hvp_fecha_ingreso,
                'hvp_observaciones' => $this->hvp_observaciones,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateInformacionReingreso(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_centro_costo`=:hvp_centro_costo, `hvp_cargo`=:hvp_cargo, `hvp_consentimiento_tratamiento_datos_personales_fecha`=:hvp_consentimiento_tratamiento_datos_personales_fecha, `hvp_datos_personales_numero_identificacion`=:hvp_datos_personales_numero_identificacion, `hvp_datos_personales_apellido_1`=:hvp_datos_personales_apellido_1, `hvp_datos_personales_apellido_2`=:hvp_datos_personales_apellido_2, `hvp_datos_personales_nombre_1`=:hvp_datos_personales_nombre_1, `hvp_datos_personales_nombre_2`=:hvp_datos_personales_nombre_2, `hvp_demografia_genero`=:hvp_demografia_genero, `hvp_demografia_estado_civil`=:hvp_demografia_estado_civil, `hvp_demografia_lugar_nacimiento`=:hvp_demografia_lugar_nacimiento, `hvp_demografia_fecha_nacimiento`=:hvp_demografia_fecha_nacimiento, `hvp_contacto_numero_celular`=:hvp_contacto_numero_celular, `hvp_contacto_correo_personal`=:hvp_contacto_correo_personal, `hvp_contacto_emergencia_nombres`=:hvp_contacto_emergencia_nombres, `hvp_contacto_emergencia_parentesco`=:hvp_contacto_emergencia_parentesco, `hvp_contacto_emergencia_celular`=:hvp_contacto_emergencia_celular, `hvp_financiero_activos`=:hvp_financiero_activos, `hvp_financiero_ingresos`=:hvp_financiero_ingresos, `hvp_financiero_pasivos`=:hvp_financiero_pasivos, `hvp_financiero_egresos`=:hvp_financiero_egresos, `hvp_financiero_patrimonio`=:hvp_financiero_patrimonio, `hvp_financiero_ingresos_otros`=:hvp_financiero_ingresos_otros, `hvp_financiero_concepto_ingresos`=:hvp_financiero_concepto_ingresos, `hvp_financiero_moneda_extranjera`=:hvp_financiero_moneda_extranjera, `hvp_fecha_ingreso`=:hvp_fecha_ingreso WHERE `hvp_id`=:hvp_id';

            $parametros = [
                'hvp_id' => $this->hvp_id,
                'hvp_centro_costo' => $this->hvp_centro_costo,
                'hvp_cargo' => $this->hvp_cargo,
                'hvp_consentimiento_tratamiento_datos_personales_fecha' => $this->hvp_consentimiento_tratamiento_datos_personales_fecha,
                'hvp_datos_personales_numero_identificacion' => $this->hvp_datos_personales_numero_identificacion,
                'hvp_datos_personales_apellido_1' => $this->hvp_datos_personales_apellido_1,
                'hvp_datos_personales_apellido_2' => $this->hvp_datos_personales_apellido_2,
                'hvp_datos_personales_nombre_1' => $this->hvp_datos_personales_nombre_1,
                'hvp_datos_personales_nombre_2' => $this->hvp_datos_personales_nombre_2,
                'hvp_demografia_genero' => $this->hvp_demografia_genero,
                'hvp_demografia_estado_civil' => $this->hvp_demografia_estado_civil,
                'hvp_demografia_lugar_nacimiento' => $this->hvp_demografia_lugar_nacimiento,
                'hvp_demografia_fecha_nacimiento' => $this->hvp_demografia_fecha_nacimiento,
                'hvp_contacto_numero_celular' => $this->hvp_contacto_numero_celular,
                'hvp_contacto_correo_personal' => $this->hvp_contacto_correo_personal,
                'hvp_contacto_emergencia_nombres' => $this->hvp_contacto_emergencia_nombres,
                'hvp_contacto_emergencia_parentesco' => $this->hvp_contacto_emergencia_parentesco,
                'hvp_contacto_emergencia_celular' => $this->hvp_contacto_emergencia_celular,
                'hvp_financiero_activos' => $this->hvp_financiero_activos,
                'hvp_financiero_ingresos' => $this->hvp_financiero_ingresos,
                'hvp_financiero_pasivos' => $this->hvp_financiero_pasivos,
                'hvp_financiero_egresos' => $this->hvp_financiero_egresos,
                'hvp_financiero_patrimonio' => $this->hvp_financiero_patrimonio,
                'hvp_financiero_ingresos_otros' => $this->hvp_financiero_ingresos_otros,
                'hvp_financiero_concepto_ingresos' => $this->hvp_financiero_concepto_ingresos,
                'hvp_financiero_moneda_extranjera' => $this->hvp_financiero_moneda_extranjera,
                'hvp_fecha_ingreso' => $this->hvp_fecha_ingreso,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
        
        public function updatePersonal(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_datos_personales_tipo_documento`=:hvp_datos_personales_tipo_documento,`hvp_datos_personales_numero_identificacion`=:hvp_datos_personales_numero_identificacion,`hvp_datos_personales_apellido_1`=:hvp_datos_personales_apellido_1,`hvp_datos_personales_apellido_2`=:hvp_datos_personales_apellido_2,`hvp_datos_personales_nombre_1`=:hvp_datos_personales_nombre_1,`hvp_datos_personales_nombre_2`=:hvp_datos_personales_nombre_2,`hvp_demografia_genero`=:hvp_demografia_genero,`hvp_demografia_estado_civil`=:hvp_demografia_estado_civil,`hvp_demografia_lugar_nacimiento`=:hvp_demografia_lugar_nacimiento,`hvp_demografia_fecha_nacimiento`=:hvp_demografia_fecha_nacimiento,`hvp_demografia_edad`=:hvp_demografia_edad,`hvp_actualiza_fecha`=:hvp_actualiza_fecha, `hvp_auxiliar_1`=:hvp_auxiliar_1, `hvp_expectativa_motivacion_motivacion_trabajo`=:hvp_expectativa_motivacion_motivacion_trabajo, `hvp_expectativa_motivacion_expectativa_desarrollo`=:hvp_expectativa_motivacion_expectativa_desarrollo, `hvp_expectativa_motivacion_expectativa_crecimiento_profesional`=:hvp_expectativa_motivacion_expectativa_crecimiento_profesional, `hvp_expectativa_motivacion_realidad_crecimiento_profesional`=:hvp_expectativa_motivacion_realidad_crecimiento_profesional WHERE `hvp_usuario_id`=:hvp_usuario_id';

            $parametros = [
                'hvp_usuario_id' => $this->hvp_usuario_id,
                'hvp_datos_personales_tipo_documento' => $this->hvp_datos_personales_tipo_documento,
                'hvp_datos_personales_numero_identificacion' => $this->hvp_datos_personales_numero_identificacion,
                'hvp_datos_personales_nombre_1' => $this->hvp_datos_personales_nombre_1,
                'hvp_datos_personales_nombre_2' => $this->hvp_datos_personales_nombre_2,
                'hvp_datos_personales_apellido_1' => $this->hvp_datos_personales_apellido_1,
                'hvp_datos_personales_apellido_2' => $this->hvp_datos_personales_apellido_2,
                'hvp_demografia_genero' => $this->hvp_demografia_genero,
                'hvp_demografia_estado_civil' => $this->hvp_demografia_estado_civil,
                'hvp_demografia_lugar_nacimiento' => $this->hvp_demografia_lugar_nacimiento,
                'hvp_demografia_fecha_nacimiento' => $this->hvp_demografia_fecha_nacimiento,
                'hvp_demografia_edad' => $this->hvp_demografia_edad,
                'hvp_actualiza_fecha' => $this->hvp_actualiza_fecha,
                'hvp_auxiliar_1' => $this->hvp_auxiliar_1,
                'hvp_expectativa_motivacion_motivacion_trabajo' => $this->hvp_expectativa_motivacion_motivacion_trabajo,
                'hvp_expectativa_motivacion_expectativa_desarrollo' => $this->hvp_expectativa_motivacion_expectativa_desarrollo,
                'hvp_expectativa_motivacion_expectativa_crecimiento_profesional' => $this->hvp_expectativa_motivacion_expectativa_crecimiento_profesional,
                'hvp_expectativa_motivacion_realidad_crecimiento_profesional' => $this->hvp_expectativa_motivacion_realidad_crecimiento_profesional,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateUbicacion(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_ubicacion_direccion_residencia`=:hvp_ubicacion_direccion_residencia,`hvp_ubicacion_ciudad_residencia`=:hvp_ubicacion_ciudad_residencia,`hvp_ubicacion_localidad_comuna`=:hvp_ubicacion_localidad_comuna,`hvp_ubicacion_barrio`=:hvp_ubicacion_barrio,`hvp_ubicacion_maps_latitud`=:hvp_ubicacion_maps_latitud, `hvp_ubicacion_maps_longitud`=:hvp_ubicacion_maps_longitud, `hvp_ubicacion_maps_ciudad`=:hvp_ubicacion_maps_ciudad, `hvp_ubicacion_maps_departamento`=:hvp_ubicacion_maps_departamento, `hvp_ubicacion_maps_pais`=:hvp_ubicacion_maps_pais, `hvp_ubicacion_maps_localidad`=:hvp_ubicacion_maps_localidad, `hvp_ubicacion_maps_barrio`=:hvp_ubicacion_maps_barrio, `hvp_ubicacion_maps_codigo_postal`=:hvp_ubicacion_maps_codigo_postal, `hvp_ubicacion_maps_direccion`=:hvp_ubicacion_maps_direccion,`hvp_contacto_numero_celular`=:hvp_contacto_numero_celular,`hvp_contacto_correo_personal`=:hvp_contacto_correo_personal, `hvp_contacto_emergencia_nombres`=:hvp_contacto_emergencia_nombres,`hvp_contacto_emergencia_apellidos`=:hvp_contacto_emergencia_apellidos,`hvp_contacto_emergencia_parentesco`=:hvp_contacto_emergencia_parentesco,`hvp_contacto_emergencia_celular`=:hvp_contacto_emergencia_celular, `hvp_contacto_emergencia_nombres_2`=:hvp_contacto_emergencia_nombres_2, `hvp_contacto_emergencia_apellidos_2`=:hvp_contacto_emergencia_apellidos_2, `hvp_contacto_emergencia_parentesco_2`=:hvp_contacto_emergencia_parentesco_2, `hvp_contacto_emergencia_celular_2`=:hvp_contacto_emergencia_celular_2, `hvp_auxiliar_2`=:hvp_auxiliar_2,`hvp_actualiza_fecha`=:hvp_actualiza_fecha WHERE `hvp_usuario_id`=:hvp_usuario_id';

            $parametros = [
                'hvp_usuario_id' => $this->hvp_usuario_id,
                'hvp_ubicacion_direccion_residencia' => $this->hvp_ubicacion_direccion_residencia,
                'hvp_ubicacion_ciudad_residencia' => $this->hvp_ubicacion_ciudad_residencia,
                'hvp_ubicacion_localidad_comuna' => $this->hvp_ubicacion_localidad_comuna,
                'hvp_ubicacion_barrio' => $this->hvp_ubicacion_barrio,
                'hvp_ubicacion_maps_latitud' => $this->hvp_ubicacion_maps_latitud,
                'hvp_ubicacion_maps_longitud' => $this->hvp_ubicacion_maps_longitud,
                'hvp_ubicacion_maps_ciudad' => $this->hvp_ubicacion_maps_ciudad,
                'hvp_ubicacion_maps_departamento' => $this->hvp_ubicacion_maps_departamento,
                'hvp_ubicacion_maps_pais' => $this->hvp_ubicacion_maps_pais,
                'hvp_ubicacion_maps_localidad' => $this->hvp_ubicacion_maps_localidad,
                'hvp_ubicacion_maps_barrio' => $this->hvp_ubicacion_maps_barrio,
                'hvp_ubicacion_maps_codigo_postal' => $this->hvp_ubicacion_maps_codigo_postal,
                'hvp_ubicacion_maps_direccion' => $this->hvp_ubicacion_maps_direccion,
                'hvp_contacto_numero_celular' => $this->hvp_contacto_numero_celular,
                'hvp_contacto_correo_personal' => $this->hvp_contacto_correo_personal,
                'hvp_contacto_emergencia_nombres' => $this->hvp_contacto_emergencia_nombres,
                'hvp_contacto_emergencia_apellidos' => $this->hvp_contacto_emergencia_apellidos,
                'hvp_contacto_emergencia_parentesco' => $this->hvp_contacto_emergencia_parentesco,
                'hvp_contacto_emergencia_celular' => $this->hvp_contacto_emergencia_celular,
                'hvp_contacto_emergencia_nombres_2' => $this->hvp_contacto_emergencia_nombres_2,
                'hvp_contacto_emergencia_apellidos_2' => $this->hvp_contacto_emergencia_apellidos_2,
                'hvp_contacto_emergencia_parentesco_2' => $this->hvp_contacto_emergencia_parentesco_2,
                'hvp_contacto_emergencia_celular_2' => $this->hvp_contacto_emergencia_celular_2,
                'hvp_auxiliar_2' => $this->hvp_auxiliar_2,
                'hvp_actualiza_fecha' => $this->hvp_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateSocioeconomico(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_socioeconomico_estrato_socioeconomico`=:hvp_socioeconomico_estrato_socioeconomico,`hvp_socioeconomico_operador_internet`=:hvp_socioeconomico_operador_internet,`hvp_socioeconomico_operador_internet_otro`=:hvp_socioeconomico_operador_internet_otro,`hvp_socioeconomico_velocidad_internet_carga`=:hvp_socioeconomico_velocidad_internet_carga,`hvp_socioeconomico_velocidad_internet_descarga`=:hvp_socioeconomico_velocidad_internet_descarga,`hvp_socioeconomico_caracteristicas_vivienda`=:hvp_socioeconomico_caracteristicas_vivienda,`hvp_socioeconomico_condiciones_vivienda`=:hvp_socioeconomico_condiciones_vivienda,`hvp_socioeconomico_estado_terminacion_vivienda`=:hvp_socioeconomico_estado_terminacion_vivienda,`hvp_socioeconomico_servicios_vivienda`=:hvp_socioeconomico_servicios_vivienda,`hvp_socioeconomico_plan_compra_vivienda`=:hvp_socioeconomico_plan_compra_vivienda,`hvp_socioeconomico_beneficiario_subsidio_vivienda`=:hvp_socioeconomico_beneficiario_subsidio_vivienda,`hvp_familia_numero_hijos`=:hvp_familia_numero_hijos,`hvp_familia_hijos_menor_3`=:hvp_familia_hijos_menor_3,`hvp_familia_capacitacion_familia`=:hvp_familia_capacitacion_familia, `hvp_financiero_activos`=:hvp_financiero_activos, `hvp_financiero_ingresos`=:hvp_financiero_ingresos, `hvp_financiero_pasivos`=:hvp_financiero_pasivos, `hvp_financiero_egresos`=:hvp_financiero_egresos, `hvp_financiero_patrimonio`=:hvp_financiero_patrimonio, `hvp_financiero_ingresos_otros`=:hvp_financiero_ingresos_otros, `hvp_financiero_concepto_ingresos`=:hvp_financiero_concepto_ingresos, `hvp_financiero_moneda_extranjera`=:hvp_financiero_moneda_extranjera, `hvp_origen_fondos`=:hvp_origen_fondos, `hvp_pep_recursos`=:hvp_pep_recursos, `hvp_pep_reconocimiento`=:hvp_pep_reconocimiento, `hvp_pep_poder`=:hvp_pep_poder, `hvp_pep_familiar`=:hvp_pep_familiar, `hvp_pep_cedula`=:hvp_pep_cedula, `hvp_pep_nombres_apellidos`=:hvp_pep_nombres_apellidos,`hvp_actualiza_fecha`=:hvp_actualiza_fecha WHERE `hvp_usuario_id`=:hvp_usuario_id';

            // ,`hvp_expectativa_motivacion_expectativa_desarrollo`=:hvp_expectativa_motivacion_expectativa_desarrollo,`hvp_expectativa_motivacion_expectativa_crecimiento_profesional`=:hvp_expectativa_motivacion_expectativa_crecimiento_profesional,`hvp_expectativa_motivacion_realidad_crecimiento_profesional`=:hvp_expectativa_motivacion_realidad_crecimiento_profesional

            $parametros = [
                'hvp_usuario_id' => $this->hvp_usuario_id,
                'hvp_socioeconomico_estrato_socioeconomico' => $this->hvp_socioeconomico_estrato_socioeconomico,
                'hvp_socioeconomico_operador_internet' => $this->hvp_socioeconomico_operador_internet,
                'hvp_socioeconomico_operador_internet_otro' => $this->hvp_socioeconomico_operador_internet_otro,
                'hvp_socioeconomico_velocidad_internet_descarga' => $this->hvp_socioeconomico_velocidad_internet_descarga,
                'hvp_socioeconomico_velocidad_internet_carga' => $this->hvp_socioeconomico_velocidad_internet_carga,
                'hvp_socioeconomico_caracteristicas_vivienda' => $this->hvp_socioeconomico_caracteristicas_vivienda,
                'hvp_socioeconomico_condiciones_vivienda' => $this->hvp_socioeconomico_condiciones_vivienda,
                'hvp_socioeconomico_estado_terminacion_vivienda' => $this->hvp_socioeconomico_estado_terminacion_vivienda,
                'hvp_socioeconomico_servicios_vivienda' => $this->hvp_socioeconomico_servicios_vivienda,
                'hvp_socioeconomico_plan_compra_vivienda' => $this->hvp_socioeconomico_plan_compra_vivienda,
                'hvp_socioeconomico_beneficiario_subsidio_vivienda' => $this->hvp_socioeconomico_beneficiario_subsidio_vivienda,
                'hvp_familia_numero_hijos' => $this->hvp_familia_numero_hijos,
                'hvp_familia_hijos_menor_3' => $this->hvp_familia_hijos_menor_3,
                'hvp_familia_capacitacion_familia' => $this->hvp_familia_capacitacion_familia,
                'hvp_financiero_activos' => $this->hvp_financiero_activos,
                'hvp_financiero_ingresos' => $this->hvp_financiero_ingresos,
                'hvp_financiero_pasivos' => $this->hvp_financiero_pasivos,
                'hvp_financiero_egresos' => $this->hvp_financiero_egresos,
                'hvp_financiero_patrimonio' => $this->hvp_financiero_patrimonio,
                'hvp_financiero_ingresos_otros' => $this->hvp_financiero_ingresos_otros,
                'hvp_financiero_concepto_ingresos' => $this->hvp_financiero_concepto_ingresos,
                'hvp_financiero_moneda_extranjera' => $this->hvp_financiero_moneda_extranjera,
                'hvp_origen_fondos' => $this->hvp_origen_fondos,
                'hvp_pep_recursos' => $this->hvp_pep_recursos,
                'hvp_pep_reconocimiento' => $this->hvp_pep_reconocimiento,
                'hvp_pep_poder' => $this->hvp_pep_poder,
                'hvp_pep_familiar' => $this->hvp_pep_familiar,
                'hvp_pep_cedula' => $this->hvp_pep_cedula,
                'hvp_pep_nombres_apellidos' => $this->hvp_pep_nombres_apellidos,
                'hvp_actualiza_fecha' => $this->hvp_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateSaludBienestar(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_salud_bienestar_grupo_sanguineo`=:hvp_salud_bienestar_grupo_sanguineo,`hvp_salud_bienestar_rh`=:hvp_salud_bienestar_rh,`hvp_salud_bienestar_actividad_fisica_minima`=:hvp_salud_bienestar_actividad_fisica_minima,`hvp_salud_bienestar_fumador`=:hvp_salud_bienestar_fumador,`hvp_salud_bienestar_pausas_activas`=:hvp_salud_bienestar_pausas_activas,`hvp_salud_bienestar_medicina_prepagada`=:hvp_salud_bienestar_medicina_prepagada,`hvp_salud_bienestar_medicina_prepagada_cual`=:hvp_salud_bienestar_medicina_prepagada_cual,`hvp_salud_bienestar_plan_complementario_salud`=:hvp_salud_bienestar_plan_complementario_salud,`hvp_salud_bienestar_plan_complementario_salud_cual`=:hvp_salud_bienestar_plan_complementario_salud_cual,`hvp_actualiza_fecha`=:hvp_actualiza_fecha WHERE `hvp_usuario_id`=:hvp_usuario_id';

            $parametros = [
                'hvp_usuario_id' => $this->hvp_usuario_id,
                'hvp_salud_bienestar_grupo_sanguineo' => $this->hvp_salud_bienestar_grupo_sanguineo,
                'hvp_salud_bienestar_rh' => $this->hvp_salud_bienestar_rh,
                'hvp_salud_bienestar_actividad_fisica_minima' => $this->hvp_salud_bienestar_actividad_fisica_minima,
                'hvp_salud_bienestar_fumador' => $this->hvp_salud_bienestar_fumador,
                'hvp_salud_bienestar_pausas_activas' => $this->hvp_salud_bienestar_pausas_activas,
                'hvp_salud_bienestar_medicina_prepagada' => $this->hvp_salud_bienestar_medicina_prepagada,
                'hvp_salud_bienestar_medicina_prepagada_cual' => $this->hvp_salud_bienestar_medicina_prepagada_cual,
                'hvp_salud_bienestar_plan_complementario_salud' => $this->hvp_salud_bienestar_plan_complementario_salud,
                'hvp_salud_bienestar_plan_complementario_salud_cual' => $this->hvp_salud_bienestar_plan_complementario_salud_cual,
                'hvp_actualiza_fecha' => $this->hvp_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateHabitos(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_interes_habitos_hobbies_deportes`=:hvp_interes_habitos_hobbies_deportes, `hvp_interes_habitos_hobbies_deportes_frecuencia`=:hvp_interes_habitos_hobbies_deportes_frecuencia, `hvp_interes_habitos_hobbies_deportes_cual`=:hvp_interes_habitos_hobbies_deportes_cual, `hvp_interes_habitos_hobbies_aire`=:hvp_interes_habitos_hobbies_aire, `hvp_interes_habitos_hobbies_aire_frecuencia`=:hvp_interes_habitos_hobbies_aire_frecuencia, `hvp_interes_habitos_hobbies_aire_cual`=:hvp_interes_habitos_hobbies_aire_cual, `hvp_interes_habitos_hobbies_arte`=:hvp_interes_habitos_hobbies_arte, `hvp_interes_habitos_hobbies_arte_frecuencia`=:hvp_interes_habitos_hobbies_arte_frecuencia, `hvp_interes_habitos_hobbies_arte_instrumento`=:hvp_interes_habitos_hobbies_arte_instrumento, `hvp_interes_habitos_hobbies_arte_cual`=:hvp_interes_habitos_hobbies_arte_cual, `hvp_interes_habitos_hobbies_tecnologia`=:hvp_interes_habitos_hobbies_tecnologia, `hvp_interes_habitos_hobbies_tecnologia_frecuencia`=:hvp_interes_habitos_hobbies_tecnologia_frecuencia, `hvp_interes_habitos_hobbies_tecnologia_cual`=:hvp_interes_habitos_hobbies_tecnologia_cual, `hvp_interes_habitos_hobbies_otro`=:hvp_interes_habitos_hobbies_otro, `hvp_interes_habitos_hobbies_otro_frecuencia`=:hvp_interes_habitos_hobbies_otro_frecuencia, `hvp_interes_habitos_hobbies_otro_cual`=:hvp_interes_habitos_hobbies_otro_cual, `hvp_interes_habitos_hobbies_recibir_informacion`=:hvp_interes_habitos_hobbies_recibir_informacion,`hvp_interes_habitos_actividades_familia`=:hvp_interes_habitos_actividades_familia,`hvp_interes_habitos_actividades_deportivas`=:hvp_interes_habitos_actividades_deportivas,`hvp_interes_habitos_actividades_deportivas_cual`=:hvp_interes_habitos_actividades_deportivas_cual,`hvp_interes_habitos_medio_transporte`=:hvp_interes_habitos_medio_transporte,`hvp_interes_habitos_habito_ahorro`=:hvp_interes_habitos_habito_ahorro,`hvp_interes_habitos_mascotas`=:hvp_interes_habitos_mascotas,`hvp_interes_habitos_mascotas_cual`=:hvp_interes_habitos_mascotas_cual,`hvp_actualiza_fecha`=:hvp_actualiza_fecha WHERE `hvp_usuario_id`=:hvp_usuario_id';

            $parametros = [
                'hvp_usuario_id' => $this->hvp_usuario_id,
                'hvp_interes_habitos_hobbies_deportes' => $this->hvp_interes_habitos_hobbies_deportes,
                'hvp_interes_habitos_hobbies_deportes_frecuencia' => $this->hvp_interes_habitos_hobbies_deportes_frecuencia,
                'hvp_interes_habitos_hobbies_deportes_cual' => $this->hvp_interes_habitos_hobbies_deportes_cual,
                'hvp_interes_habitos_hobbies_aire' => $this->hvp_interes_habitos_hobbies_aire,
                'hvp_interes_habitos_hobbies_aire_frecuencia' => $this->hvp_interes_habitos_hobbies_aire_frecuencia,
                'hvp_interes_habitos_hobbies_aire_cual' => $this->hvp_interes_habitos_hobbies_aire_cual,
                'hvp_interes_habitos_hobbies_arte' => $this->hvp_interes_habitos_hobbies_arte,
                'hvp_interes_habitos_hobbies_arte_frecuencia' => $this->hvp_interes_habitos_hobbies_arte_frecuencia,
                'hvp_interes_habitos_hobbies_arte_instrumento' => $this->hvp_interes_habitos_hobbies_arte_instrumento,
                'hvp_interes_habitos_hobbies_arte_cual' => $this->hvp_interes_habitos_hobbies_arte_cual,
                'hvp_interes_habitos_hobbies_tecnologia' => $this->hvp_interes_habitos_hobbies_tecnologia,
                'hvp_interes_habitos_hobbies_tecnologia_frecuencia' => $this->hvp_interes_habitos_hobbies_tecnologia_frecuencia,
                'hvp_interes_habitos_hobbies_tecnologia_cual' => $this->hvp_interes_habitos_hobbies_tecnologia_cual,
                'hvp_interes_habitos_hobbies_otro' => $this->hvp_interes_habitos_hobbies_otro,
                'hvp_interes_habitos_hobbies_otro_frecuencia' => $this->hvp_interes_habitos_hobbies_otro_frecuencia,
                'hvp_interes_habitos_hobbies_otro_cual' => $this->hvp_interes_habitos_hobbies_otro_cual,
                'hvp_interes_habitos_hobbies_recibir_informacion' => $this->hvp_interes_habitos_hobbies_recibir_informacion,
                'hvp_interes_habitos_actividades_familia' => $this->hvp_interes_habitos_actividades_familia,
                'hvp_interes_habitos_actividades_deportivas' => $this->hvp_interes_habitos_actividades_deportivas,
                'hvp_interes_habitos_actividades_deportivas_cual' => $this->hvp_interes_habitos_actividades_deportivas_cual,
                'hvp_interes_habitos_medio_transporte' => $this->hvp_interes_habitos_medio_transporte,
                'hvp_interes_habitos_habito_ahorro' => $this->hvp_interes_habitos_habito_ahorro,
                'hvp_interes_habitos_mascotas' => $this->hvp_interes_habitos_mascotas,
                'hvp_interes_habitos_mascotas_cual' => $this->hvp_interes_habitos_mascotas_cual,
                'hvp_actualiza_fecha' => $this->hvp_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateFormacionHabilidades(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_formacion_nivel_academico_culminado`=:hvp_formacion_nivel_academico_culminado,`hvp_formacion_ultimo_certificado_enviado_rrhh`=:hvp_formacion_ultimo_certificado_enviado_rrhh,`hvp_formacion_ultimo_estudio_realizado_titulo`=:hvp_formacion_ultimo_estudio_realizado_titulo,`hvp_formacion_tarjeta_profesional`=:hvp_formacion_tarjeta_profesional,`hvp_formacion_estudios_curso`=:hvp_formacion_estudios_curso,`hvp_formacion_estudios_curso_titulo`=:hvp_formacion_estudios_curso_titulo,`hvp_formacion_estudios_curso_nivel`=:hvp_formacion_estudios_curso_nivel,`hvp_formacion_estudios_curso_establecimiento`=:hvp_formacion_estudios_curso_establecimiento,`hvp_habilidades_nivel_ingles`=:hvp_habilidades_nivel_ingles,`hvp_habilidades_nivel_excel`=:hvp_habilidades_nivel_excel,`hvp_habilidades_nivel_google_ws`=:hvp_habilidades_nivel_google_ws,`hvp_actualiza_fecha`=:hvp_actualiza_fecha WHERE `hvp_usuario_id`=:hvp_usuario_id';

            $parametros = [
                'hvp_usuario_id' => $this->hvp_usuario_id,
                'hvp_formacion_nivel_academico_culminado' => $this->hvp_formacion_nivel_academico_culminado,
                'hvp_formacion_ultimo_certificado_enviado_rrhh' => $this->hvp_formacion_ultimo_certificado_enviado_rrhh,
                'hvp_formacion_ultimo_estudio_realizado_titulo' => $this->hvp_formacion_ultimo_estudio_realizado_titulo,
                'hvp_formacion_tarjeta_profesional' => $this->hvp_formacion_tarjeta_profesional,
                'hvp_formacion_estudios_curso' => $this->hvp_formacion_estudios_curso,
                'hvp_formacion_estudios_curso_titulo' => $this->hvp_formacion_estudios_curso_titulo,
                'hvp_formacion_estudios_curso_nivel' => $this->hvp_formacion_estudios_curso_nivel,
                'hvp_formacion_estudios_curso_establecimiento' => $this->hvp_formacion_estudios_curso_establecimiento,
                'hvp_habilidades_nivel_ingles' => $this->hvp_habilidades_nivel_ingles,
                'hvp_habilidades_nivel_excel' => $this->hvp_habilidades_nivel_excel,
                'hvp_habilidades_nivel_google_ws' => $this->hvp_habilidades_nivel_google_ws,
                'hvp_actualiza_fecha' => $this->hvp_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateUltimoCertificado(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_auxiliar_4`=:hvp_auxiliar_4, `hvp_alerta_actualizacion`=:hvp_alerta_actualizacion,`hvp_actualiza_fecha`=:hvp_actualiza_fecha WHERE `hvp_usuario_id`=:hvp_usuario_id';

            $parametros = [
                'hvp_usuario_id' => $this->hvp_usuario_id,
                'hvp_auxiliar_4' => $this->hvp_auxiliar_4,
                'hvp_alerta_actualizacion' => $this->hvp_alerta_actualizacion,
                'hvp_actualiza_fecha' => $this->hvp_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateTarjetaProfesional(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_auxiliar_5`=:hvp_auxiliar_5,  `hvp_alerta_actualizacion`=:hvp_alerta_actualizacion,`hvp_actualiza_fecha`=:hvp_actualiza_fecha WHERE `hvp_usuario_id`=:hvp_usuario_id';

            $parametros = [
                'hvp_usuario_id' => $this->hvp_usuario_id,
                'hvp_auxiliar_5' => $this->hvp_auxiliar_5,
                'hvp_alerta_actualizacion' => $this->hvp_alerta_actualizacion,
                'hvp_actualiza_fecha' => $this->hvp_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updatePoblaciones(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_poblaciones_poblacion`=:hvp_poblaciones_poblacion, `hvp_poblaciones_certificado`=:hvp_poblaciones_certificado,`hvp_poblaciones_familiares_iq`=:hvp_poblaciones_familiares_iq,`hvp_poblaciones_familiares_iq_identificacion`=:hvp_poblaciones_familiares_iq_identificacion,`hvp_poblaciones_familiares_iq_nombres_apellidos`=:hvp_poblaciones_familiares_iq_nombres_apellidos,`hvp_poblaciones_familiares_iq_ingreso_marzo_2022`=:hvp_poblaciones_familiares_iq_ingreso_marzo_2022, `hvp_veracidad`=:hvp_veracidad,`hvp_actualiza_fecha`=:hvp_actualiza_fecha WHERE `hvp_usuario_id`=:hvp_usuario_id';

            $parametros = [
                'hvp_usuario_id' => $this->hvp_usuario_id,
                'hvp_poblaciones_poblacion' => $this->hvp_poblaciones_poblacion,
                'hvp_poblaciones_certificado' => $this->hvp_poblaciones_certificado,
                'hvp_poblaciones_familiares_iq' => $this->hvp_poblaciones_familiares_iq,
                'hvp_poblaciones_familiares_iq_identificacion' => $this->hvp_poblaciones_familiares_iq_identificacion,
                'hvp_poblaciones_familiares_iq_nombres_apellidos' => $this->hvp_poblaciones_familiares_iq_nombres_apellidos,
                'hvp_poblaciones_familiares_iq_ingreso_marzo_2022' => $this->hvp_poblaciones_familiares_iq_ingreso_marzo_2022,
                'hvp_veracidad' => $this->hvp_veracidad,
                'hvp_actualiza_fecha' => $this->hvp_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updatePoblacionesSoporte(){
            $sql='UPDATE `hoja_vida_personal` SET `hvp_poblaciones_poblacion_soporte`=:hvp_poblaciones_poblacion_soporte WHERE `hvp_usuario_id`=:hvp_usuario_id';

            $parametros = [
                'hvp_usuario_id' => $this->hvp_usuario_id,
                'hvp_poblaciones_poblacion_soporte' => $this->hvp_poblaciones_poblacion_soporte,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }