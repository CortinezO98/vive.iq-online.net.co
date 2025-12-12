<?php
    function newToken($longitud=18) {
        return bin2hex(random_bytes(($longitud - ($longitud % 2)) / 2));
    }

    function newPassword($length) {
        $key = "";
        $pattern = "1234567890_*@()abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $max = strlen($pattern)-1;
        for($i = 0; $i < $length; $i++){
            $key .= substr($pattern, mt_rand(0,$max), 1);
        }
        return $key;
    }

    function dateToText($fecha) {
        $anio=date('Y', strtotime($fecha));
        $mes=date('m', strtotime($fecha));
        $dia=date('d', strtotime($fecha));

        $array_mes_nombre['01']='enero';
        $array_mes_nombre['02']='febrero';
        $array_mes_nombre['03']='marzo';
        $array_mes_nombre['04']='abril';
        $array_mes_nombre['05']='mayo';
        $array_mes_nombre['06']='junio';
        $array_mes_nombre['07']='julio';
        $array_mes_nombre['08']='agosto';
        $array_mes_nombre['09']='Septiembre';
        $array_mes_nombre['10']='octubre';
        $array_mes_nombre['11']='noviembre';
        $array_mes_nombre['12']='diciembre';

        $texto=$dia.' de '.$array_mes_nombre[$mes].' de '.$anio;

        return $texto;
    }

    function nombreMes($mes) {
        $array_mes_nombre['01']='enero';
        $array_mes_nombre['02']='febrero';
        $array_mes_nombre['03']='marzo';
        $array_mes_nombre['04']='abril';
        $array_mes_nombre['05']='mayo';
        $array_mes_nombre['06']='junio';
        $array_mes_nombre['07']='julio';
        $array_mes_nombre['08']='agosto';
        $array_mes_nombre['09']='Septiembre';
        $array_mes_nombre['10']='octubre';
        $array_mes_nombre['11']='noviembre';
        $array_mes_nombre['12']='diciembre';

        $texto=$array_mes_nombre[$mes];

        return $texto;
    }

    function calcularEdad($fechaNacimiento) {
        $fechaNacimiento = new DateTime($fechaNacimiento);
        $hoy = new DateTime();
        $diferencia = $hoy->diff($fechaNacimiento);
        return $diferencia->y;
    }

    function estadoDiligenciaHV($resregistros) {
        $cantidad_campos = 0;
        $control_diligenciamiento = 0;
        $array_estados = array();

        //Autorizaciones
        $cantidad_campos++;
        $array_estados['estado_autorizaciones']='';
        $array_estados['estado_autorizaciones_icono']='';
        if($resregistros['hvp_consentimiento_tratamiento_datos_personales']!='' AND $resregistros['hvp_auxiliar_3']!='' AND $resregistros['hvp_consentimiento_tratamiento_datos_personales_fecha']!=''){
            $array_estados['estado_autorizaciones']='Diligenciado';
            $array_estados['estado_autorizaciones_icono']='<span class="fas fa-check-circle text-success"></span>';
            $control_diligenciamiento++;
        } else {
            $array_estados['estado_autorizaciones']='Pendiente';
            $array_estados['estado_autorizaciones_icono']='<span class="fas fa-times-circle text-danger"></span>';
        }
        

        //Información Personal
        $cantidad_campos++;
        $array_estados['estado_informacion_personal']='';
        $array_estados['estado_informacion_personal_icono']='';
        if($resregistros['hvp_auxiliar_1']!='' AND $resregistros['hvp_datos_personales_tipo_documento']!='' AND $resregistros['hvp_datos_personales_numero_identificacion']!='' AND $resregistros['hvp_datos_personales_apellido_1']!='' AND $resregistros['hvp_datos_personales_nombre_1']!='' AND $resregistros['hvp_demografia_genero']!='' AND $resregistros['hvp_demografia_estado_civil']!='' AND $resregistros['hvp_demografia_lugar_nacimiento']!='' AND $resregistros['hvp_demografia_fecha_nacimiento']!=''){
            $array_estados['estado_informacion_personal']='Diligenciado';
            $array_estados['estado_informacion_personal_icono']='<span class="fas fa-check-circle text-success"></span>';
            $control_diligenciamiento++;
        } else {
            $array_estados['estado_informacion_personal']='Pendiente';
            $array_estados['estado_informacion_personal_icono']='<span class="fas fa-times-circle text-danger"></span>';
        }
        

        //Ubicación/ Contacto
        $cantidad_campos++;
        $array_estados['estado_ubicacion_contacto']='';
        $array_estados['estado_ubicacion_contacto_icono']='';
        if($resregistros['hvp_ubicacion_direccion_residencia']!='' AND $resregistros['hvp_ubicacion_ciudad_residencia']!='' AND $resregistros['hvp_contacto_numero_celular']!='' AND $resregistros['hvp_contacto_correo_personal']!='' AND $resregistros['hvp_contacto_correo_corporativo']!='' AND $resregistros['hvp_contacto_emergencia_nombres']!='' AND $resregistros['hvp_contacto_emergencia_apellidos']!='' AND $resregistros['hvp_contacto_emergencia_parentesco']!='' AND $resregistros['hvp_contacto_emergencia_celular']!='' AND $resregistros['hvp_contacto_emergencia_nombres_2']!='' AND $resregistros['hvp_contacto_emergencia_apellidos_2']!='' AND $resregistros['hvp_contacto_emergencia_parentesco_2']!='' AND $resregistros['hvp_contacto_emergencia_celular_2']!=''){
            $array_estados['estado_ubicacion_contacto']='Diligenciado';
            $array_estados['estado_ubicacion_contacto_icono']='<span class="fas fa-check-circle text-success"></span>';
            $control_diligenciamiento++;
        } else {
            $array_estados['estado_ubicacion_contacto']='Pendiente';
            $array_estados['estado_ubicacion_contacto_icono']='<span class="fas fa-times-circle text-danger"></span>';
        }
        

        //Socioeconómico/ Familiar
        $cantidad_campos++;
        $array_estados['estado_socioeconomico_familiar']='';
        $array_estados['estado_socioeconomico_familiar_icono']='';
        if($resregistros['hvp_socioeconomico_condiciones_vivienda']!='' AND $resregistros['hvp_socioeconomico_estrato_socioeconomico']!='' AND $resregistros['hvp_socioeconomico_operador_internet']!='' AND $resregistros['hvp_socioeconomico_velocidad_internet_descarga']!='' AND $resregistros['hvp_socioeconomico_velocidad_internet_carga']!='' AND $resregistros['hvp_socioeconomico_caracteristicas_vivienda']!='' AND $resregistros['hvp_socioeconomico_estado_terminacion_vivienda']!='' AND $resregistros['hvp_socioeconomico_servicios_vivienda']!='' AND $resregistros['hvp_socioeconomico_plan_compra_vivienda']!='' AND $resregistros['hvp_socioeconomico_beneficiario_subsidio_vivienda']!='' AND $resregistros['hvp_financiero_activos']!='' AND $resregistros['hvp_financiero_ingresos']!='' AND $resregistros['hvp_financiero_pasivos']!='' AND $resregistros['hvp_financiero_egresos']!='' AND $resregistros['hvp_financiero_patrimonio']!='' AND $resregistros['hvp_financiero_ingresos_otros']!='' AND $resregistros['hvp_financiero_moneda_extranjera']!='' AND $resregistros['hvp_origen_fondos']!='' AND $resregistros['hvp_pep_recursos']!='' AND $resregistros['hvp_pep_reconocimiento']!='' AND $resregistros['hvp_pep_poder']!='' AND $resregistros['hvp_pep_familiar']!=''){
            $array_estados['estado_socioeconomico_familiar']='Diligenciado';
            $array_estados['estado_socioeconomico_familiar_icono']='<span class="fas fa-check-circle text-success"></span>';
            $control_diligenciamiento++;
        } else {
            $array_estados['estado_socioeconomico_familiar']='Pendiente';
            $array_estados['estado_socioeconomico_familiar_icono']='<span class="fas fa-times-circle text-danger"></span>';
        }
        

        //Salud/ Bienestar
        $cantidad_campos++;
        $array_estados['estado_salud_bienestar']='';
        $array_estados['estado_salud_bienestar_icono']='';
        if($resregistros['hvp_salud_bienestar_grupo_sanguineo']!='' AND $resregistros['hvp_salud_bienestar_rh']!='' AND $resregistros['hvp_salud_bienestar_actividad_fisica_minima']!='' AND $resregistros['hvp_salud_bienestar_fumador']!='' AND $resregistros['hvp_salud_bienestar_pausas_activas']!='' AND $resregistros['hvp_salud_bienestar_medicina_prepagada']!=''){
            $array_estados['estado_salud_bienestar']='Diligenciado';
            $array_estados['estado_salud_bienestar_icono']='<span class="fas fa-check-circle text-success"></span>';
            $control_diligenciamiento++;
        } else {
            $array_estados['estado_salud_bienestar']='Pendiente';
            $array_estados['estado_salud_bienestar_icono']='<span class="fas fa-times-circle text-danger"></span>';
        }
        

        //Intereses/ Hábitos
        $cantidad_campos++;
        $array_estados['estado_intereses_habitos']='';
        $array_estados['estado_intereses_habitos_icono']='';
        if($resregistros['hvp_interes_habitos_hobbies_deportes']!='' AND $resregistros['hvp_interes_habitos_hobbies_aire']!='' AND $resregistros['hvp_interes_habitos_hobbies_arte']!='' AND $resregistros['hvp_interes_habitos_hobbies_tecnologia']!='' AND $resregistros['hvp_interes_habitos_hobbies_otro']!='' AND $resregistros['hvp_interes_habitos_hobbies_recibir_informacion']!=''){
            $array_estados['estado_intereses_habitos']='Diligenciado';
            $array_estados['estado_intereses_habitos_icono']='<span class="fas fa-check-circle text-success"></span>';
            $control_diligenciamiento++;
        } else {
            $array_estados['estado_intereses_habitos']='Pendiente';
            $array_estados['estado_intereses_habitos_icono']='<span class="fas fa-times-circle text-danger"></span>';
        }
        

        //Formación/ Habilidades
        $cantidad_campos++;
        $array_estados['estado_formacion_habilidades']='';
        $array_estados['estado_formacion_habilidades_icono']='';
        if($resregistros['hvp_formacion_ultimo_certificado_enviado_rrhh']!='' AND $resregistros['hvp_formacion_ultimo_estudio_realizado_titulo']!='' AND $resregistros['hvp_formacion_tarjeta_profesional']!='' AND $resregistros['hvp_formacion_estudios_curso']!='' AND $resregistros['hvp_habilidades_nivel_ingles']!='' AND $resregistros['hvp_habilidades_nivel_excel']!='' AND $resregistros['hvp_habilidades_nivel_google_ws']!=''){
            $array_estados['estado_formacion_habilidades']='Diligenciado';
            $array_estados['estado_formacion_habilidades_icono']='<span class="fas fa-check-circle text-success"></span>';
            $control_diligenciamiento++;
        } else {
            $array_estados['estado_formacion_habilidades']='Pendiente';
            $array_estados['estado_formacion_habilidades_icono']='<span class="fas fa-times-circle text-danger"></span>';
        }
        
        //Poblaciones/ Relaciones Familiares
        $cantidad_campos++;
        $array_estados['estado_poblaciones_relaciones']='';
        $array_estados['estado_poblaciones_relaciones_icono']='';
        if($resregistros['hvp_poblaciones_poblacion']!='' AND $resregistros['hvp_poblaciones_familiares_iq']!='' AND $resregistros['hvp_veracidad']!=''){
            $array_estados['estado_poblaciones_relaciones']='Diligenciado';
            $array_estados['estado_poblaciones_relaciones_icono']='<span class="fas fa-check-circle text-success"></span>';
            $control_diligenciamiento++;
        } else {
            $array_estados['estado_poblaciones_relaciones']='Pendiente';
            $array_estados['estado_poblaciones_relaciones_icono']='<span class="fas fa-times-circle text-danger"></span>';
        }
        
        $array_estados['estado_general']='';
        $array_estados['estado_general_icono']='';
        if($control_diligenciamiento>0){
            $array_estados['estado_general']=number_format((($control_diligenciamiento/$cantidad_campos)*100), 1, '.', '').'%';
            $array_estados['estado_general_icono']='<span class="badge bg-success">'.number_format((($control_diligenciamiento/$cantidad_campos)*100), 1, '.', '').'%</span>';
        } else {
            $array_estados['estado_general']='0%';
            $array_estados['estado_general_icono']='<span class="badge bg-danger">0%</span>';
        }

        return $array_estados;
    }