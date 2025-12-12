<?php
    class usuarioModel extends Model {
        public $usu_id;
        public $usu_documento;
        public $usu_acceso;
        public $usu_contrasena;
        public $usu_nombres_apellidos;
        public $usu_correo;
        public $usu_correo_corporativo;
        public $usu_fecha_incorporacion;
        public $usu_area;
        public $usu_cargo;
        public $usu_jefe_inmediato;
        public $usu_ciudad;
        public $usu_estado;
        public $usu_inicio_sesion;
        public $usu_avatar;
        public $usu_genero;
        public $usu_fecha_nacimiento;
        public $usu_perfil;
        public $usu_aspirante_id;
        public $usu_actualiza_fecha;
        public $usu_actualiza_login;
        public $usu_registro_usuario;
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

            if ($this->filtro!="" AND $this->filtro!="null") {
                $filtro_str="AND (`app_usuario`.`usu_documento` LIKE :usu_documento OR `app_usuario`.`usu_acceso` LIKE :usu_acceso OR `app_usuario`.`usu_nombres_apellidos` LIKE :usu_nombres_apellidos OR `app_usuario`.`usu_correo` LIKE :usu_correo OR `app_usuario`.`usu_correo_corporativo` LIKE :usu_correo_corporativo OR `app_usuario`.`usu_estado` LIKE :usu_estado OR TCIUDAD.`ciu_departamento` LIKE :ciu_departamento OR TCIUDAD.`ciu_municipio` LIKE :ciu_municipio)";
                $parametros_filtro = [
                    'usu_documento' => '%'.$this->filtro.'%',
                    'usu_acceso' => '%'.$this->filtro.'%',
                    'usu_nombres_apellidos' => '%'.$this->filtro.'%',
                    'usu_correo' => '%'.$this->filtro.'%',
                    'usu_correo_corporativo' => '%'.$this->filtro.'%',
                    'usu_estado' => '%'.$this->filtro.'%',
                    'ciu_departamento' => '%'.$this->filtro.'%',
                    'ciu_municipio' => '%'.$this->filtro.'%'
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_str="";
            }

            $sql='SELECT `app_usuario`.`usu_id`, `app_usuario`.`usu_documento`, `app_usuario`.`usu_acceso`, `app_usuario`.`usu_contrasena`, `app_usuario`.`usu_nombres_apellidos`, `app_usuario`.`usu_correo`, `app_usuario`.`usu_correo_corporativo`, `app_usuario`.`usu_fecha_incorporacion`, `app_usuario`.`usu_area`, `app_usuario`.`usu_cargo`, `app_usuario`.`usu_jefe_inmediato`, `app_usuario`.`usu_ciudad`, `app_usuario`.`usu_estado`, `app_usuario`.`usu_inicio_sesion`, `app_usuario`.`usu_avatar`, `app_usuario`.`usu_genero`, `app_usuario`.`usu_fecha_nacimiento`, `app_usuario`.`usu_perfil`, `app_usuario`.`usu_aspirante_id`, `app_usuario`.`usu_actualiza_fecha`, `app_usuario`.`usu_actualiza_login`, `app_usuario`.`usu_registro_usuario`, TAREA.`aa_nombre`, TCARGO.`ac_nombre`, TCIUDAD.`ciu_departamento`, TCIUDAD.`ciu_municipio`, TJEFE.`usu_nombres_apellidos` AS jefe_nombres_apellidos, TJEFE.`usu_correo` AS jefe_correo, TJEFE.`usu_correo_corporativo` AS jefe_correo_corporativo FROM `app_usuario` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TAREA ON `app_usuario`.`usu_area`=TAREA.`aa_id` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCARGO ON `app_usuario`.`usu_cargo`=TCARGO.`ac_id` 
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `app_usuario`.`usu_ciudad`=TCIUDAD.`ciu_codigo`
            LEFT JOIN `app_usuario` AS TJEFE ON `app_usuario`.`usu_jefe_inmediato`=TJEFE.`usu_id`
             WHERE 1=1 '.$filtro_str.' ORDER BY `app_usuario`.`usu_nombres_apellidos` ASC LIMIT :offset,:limite';

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listCount(){
            $parametros = [
            ];
            if ($this->filtro!="" AND $this->filtro!="null") {
                $filtro_str="AND (`app_usuario`.`usu_documento` LIKE :usu_documento OR `app_usuario`.`usu_acceso` LIKE :usu_acceso OR `app_usuario`.`usu_nombres_apellidos` LIKE :usu_nombres_apellidos OR `app_usuario`.`usu_correo` LIKE :usu_correo OR `app_usuario`.`usu_correo_corporativo` LIKE :usu_correo_corporativo OR `app_usuario`.`usu_estado` LIKE :usu_estado OR TCIUDAD.`ciu_departamento` LIKE :ciu_departamento OR TCIUDAD.`ciu_municipio` LIKE :ciu_municipio)";
                $parametros_filtro = [
                    'usu_documento' => '%'.$this->filtro.'%',
                    'usu_acceso' => '%'.$this->filtro.'%',
                    'usu_nombres_apellidos' => '%'.$this->filtro.'%',
                    'usu_correo' => '%'.$this->filtro.'%',
                    'usu_correo_corporativo' => '%'.$this->filtro.'%',
                    'usu_estado' => '%'.$this->filtro.'%',
                    'ciu_departamento' => '%'.$this->filtro.'%',
                    'ciu_municipio' => '%'.$this->filtro.'%'
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_str="";
            }

            $sql='SELECT `app_usuario`.`usu_id` FROM `app_usuario` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TAREA ON `app_usuario`.`usu_area`=TAREA.`aa_id` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCARGO ON `app_usuario`.`usu_cargo`=TCARGO.`ac_id` 
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `app_usuario`.`usu_ciudad`=TCIUDAD.`ciu_codigo`
            LEFT JOIN `app_usuario` AS TJEFE ON `app_usuario`.`usu_jefe_inmediato`=TJEFE.`usu_id`
             WHERE 1=1 '.$filtro_str.' ORDER BY `app_usuario`.`usu_nombres_apellidos` ASC';

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listActive(){
            $sql='SELECT `app_usuario`.`usu_id`, `app_usuario`.`usu_documento`, `app_usuario`.`usu_acceso`, `app_usuario`.`usu_contrasena`, `app_usuario`.`usu_nombres_apellidos`, `app_usuario`.`usu_correo`, `app_usuario`.`usu_correo_corporativo`, `app_usuario`.`usu_fecha_incorporacion`, `app_usuario`.`usu_area`, `app_usuario`.`usu_cargo`, `app_usuario`.`usu_jefe_inmediato`, `app_usuario`.`usu_ciudad`, `app_usuario`.`usu_estado`, `app_usuario`.`usu_inicio_sesion`, `app_usuario`.`usu_avatar`, `app_usuario`.`usu_genero`, `app_usuario`.`usu_fecha_nacimiento`, `app_usuario`.`usu_perfil`, `app_usuario`.`usu_aspirante_id`, `app_usuario`.`usu_actualiza_fecha`, `app_usuario`.`usu_actualiza_login`, `app_usuario`.`usu_registro_usuario`, TAREA.`aa_nombre`, TCARGO.`ac_nombre`, TCIUDAD.`ciu_departamento`, TCIUDAD.`ciu_municipio`, TJEFE.`usu_nombres_apellidos` AS jefe_nombres_apellidos, TJEFE.`usu_correo` AS jefe_correo, TJEFE.`usu_correo_corporativo` AS jefe_correo_corporativo FROM `app_usuario` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TAREA ON `app_usuario`.`usu_area`=TAREA.`aa_id` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCARGO ON `app_usuario`.`usu_cargo`=TCARGO.`ac_id` 
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `app_usuario`.`usu_ciudad`=TCIUDAD.`ciu_codigo`
            LEFT JOIN `app_usuario` AS TJEFE ON `app_usuario`.`usu_jefe_inmediato`=TJEFE.`usu_id`
             WHERE 1=1 AND `app_usuario`.`usu_estado`=:usu_estado ORDER BY `app_usuario`.`usu_nombres_apellidos` ASC';

            $parametros = [
                'usu_estado' => 'Activo'
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listDetail(){
            $sql='SELECT `app_usuario`.`usu_id`, `app_usuario`.`usu_documento`, `app_usuario`.`usu_acceso`, `app_usuario`.`usu_contrasena`, `app_usuario`.`usu_nombres_apellidos`, `app_usuario`.`usu_correo`, `app_usuario`.`usu_correo_corporativo`, `app_usuario`.`usu_fecha_incorporacion`, `app_usuario`.`usu_area`, `app_usuario`.`usu_cargo`, `app_usuario`.`usu_jefe_inmediato`, `app_usuario`.`usu_ciudad`, `app_usuario`.`usu_estado`, `app_usuario`.`usu_inicio_sesion`, `app_usuario`.`usu_avatar`, `app_usuario`.`usu_genero`, `app_usuario`.`usu_fecha_nacimiento`, `app_usuario`.`usu_perfil`, `app_usuario`.`usu_aspirante_id`, `app_usuario`.`usu_actualiza_fecha`, `app_usuario`.`usu_actualiza_login`, `app_usuario`.`usu_registro_usuario`, TAREA.`aa_nombre`, TCARGO.`ac_nombre`, TCIUDAD.`ciu_departamento`, TCIUDAD.`ciu_municipio`, TJEFE.`usu_nombres_apellidos` AS jefe_nombres_apellidos, TJEFE.`usu_correo` AS jefe_correo, TJEFE.`usu_correo_corporativo` AS jefe_correo_corporativo FROM `app_usuario` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TAREA ON `app_usuario`.`usu_area`=TAREA.`aa_id` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCARGO ON `app_usuario`.`usu_cargo`=TCARGO.`ac_id` 
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `app_usuario`.`usu_ciudad`=TCIUDAD.`ciu_codigo`
            LEFT JOIN `app_usuario` AS TJEFE ON `app_usuario`.`usu_jefe_inmediato`=TJEFE.`usu_id`
             WHERE `app_usuario`.`usu_id`=:usu_id';

            $parametros = [
                'usu_id' => $this->usu_id,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listPsicologo(){
            $sql='SELECT `app_usuario`.`usu_id`, `app_usuario`.`usu_documento`, `app_usuario`.`usu_acceso`, `app_usuario`.`usu_contrasena`, `app_usuario`.`usu_nombres_apellidos`, `app_usuario`.`usu_correo`, `app_usuario`.`usu_correo_corporativo`, `app_usuario`.`usu_fecha_incorporacion`, `app_usuario`.`usu_area`, `app_usuario`.`usu_cargo`, `app_usuario`.`usu_jefe_inmediato`, `app_usuario`.`usu_ciudad`, `app_usuario`.`usu_estado`, `app_usuario`.`usu_inicio_sesion`, `app_usuario`.`usu_avatar`, `app_usuario`.`usu_genero`, `app_usuario`.`usu_fecha_nacimiento`, `app_usuario`.`usu_perfil`, `app_usuario`.`usu_aspirante_id`, `app_usuario`.`usu_actualiza_fecha`, `app_usuario`.`usu_actualiza_login`, `app_usuario`.`usu_registro_usuario`, TAREA.`aa_nombre`, TCARGO.`ac_nombre`, TCIUDAD.`ciu_departamento`, TCIUDAD.`ciu_municipio`, TJEFE.`usu_nombres_apellidos` AS jefe_nombres_apellidos, TJEFE.`usu_correo` AS jefe_correo, TJEFE.`usu_correo_corporativo` AS jefe_correo_corporativo FROM `app_usuario` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TAREA ON `app_usuario`.`usu_area`=TAREA.`aa_id` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCARGO ON `app_usuario`.`usu_cargo`=TCARGO.`ac_id` 
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `app_usuario`.`usu_ciudad`=TCIUDAD.`ciu_codigo`
            LEFT JOIN `app_usuario` AS TJEFE ON `app_usuario`.`usu_jefe_inmediato`=TJEFE.`usu_id`
             WHERE 1=1 AND `app_usuario`.`usu_estado`=:usu_estado AND `app_usuario`.`usu_perfil`=:usu_perfil ORDER BY `app_usuario`.`usu_nombres_apellidos` ASC';

            $parametros = [
                'usu_estado' => 'Activo',
                'usu_perfil' => 'Psicólogo'
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listDuplicado(){
            $sql='SELECT `usu_id`, `usu_documento`, `usu_acceso`, `usu_contrasena`, `usu_nombres_apellidos`, `usu_correo`, `usu_correo_corporativo`, `usu_fecha_incorporacion`, `usu_area`, `usu_cargo`, `usu_jefe_inmediato`, `usu_ciudad`, `usu_estado`, `usu_inicio_sesion`, `usu_avatar`, `usu_genero`, `usu_fecha_nacimiento`, `usu_perfil`, `usu_aspirante_id`, `usu_actualiza_fecha`, `usu_actualiza_login`, `usu_registro_usuario`, TAREA.`aa_nombre`, TCARGO.`ac_nombre`, TCIUDAD.`ciu_departamento`, TCIUDAD.`ciu_municipio` FROM `app_usuario` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TAREA ON `app_usuario`.`usu_area`=TAREA.`aa_id` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCARGO ON `app_usuario`.`usu_cargo`=TCARGO.`ac_id` 
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `app_usuario`.`usu_ciudad`=TCIUDAD.`ciu_codigo`
             WHERE `usu_acceso`=:usu_acceso OR `usu_correo`=:usu_correo OR `usu_correo_corporativo`=:usu_correo_corporativo OR `usu_documento`=:usu_documento';

            $parametros = [
                'usu_acceso' => $this->usu_acceso,
                'usu_correo' => $this->usu_correo,
                'usu_correo_corporativo' => $this->usu_correo_corporativo,
                'usu_documento' => $this->usu_documento,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listDuplicadoEditar(){
            $sql='SELECT `usu_id`, `usu_documento`, `usu_acceso`, `usu_contrasena`, `usu_nombres_apellidos`, `usu_correo`, `usu_correo_corporativo`, `usu_fecha_incorporacion`, `usu_area`, `usu_cargo`, `usu_jefe_inmediato`, `usu_ciudad`, `usu_estado`, `usu_inicio_sesion`, `usu_avatar`, `usu_genero`, `usu_fecha_nacimiento`, `usu_perfil`, `usu_aspirante_id`, `usu_actualiza_fecha`, `usu_actualiza_login`, `usu_registro_usuario`, TAREA.`aa_nombre`, TCARGO.`ac_nombre`, TCIUDAD.`ciu_departamento`, TCIUDAD.`ciu_municipio` FROM `app_usuario` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TAREA ON `app_usuario`.`usu_area`=TAREA.`aa_id` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCARGO ON `app_usuario`.`usu_cargo`=TCARGO.`ac_id` 
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `app_usuario`.`usu_ciudad`=TCIUDAD.`ciu_codigo`
             WHERE `usu_id`<>:usu_id AND (`usu_acceso`=:usu_acceso OR `usu_correo`=:usu_correo OR `usu_correo_corporativo`=:usu_correo_corporativo OR `usu_documento`=:usu_documento)';

            $parametros = [
                'usu_id' => $this->usu_id,
                'usu_acceso' => $this->usu_acceso,
                'usu_correo' => $this->usu_correo,
                'usu_correo_corporativo' => $this->usu_correo_corporativo,
                'usu_documento' => $this->usu_documento,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listDuplicadoCC(){
            $sql='SELECT `usu_id`, `usu_documento`, `usu_acceso`, `usu_contrasena`, `usu_nombres_apellidos`, `usu_correo`, `usu_correo_corporativo`, `usu_fecha_incorporacion`, `usu_area`, `usu_cargo`, `usu_jefe_inmediato`, `usu_ciudad`, `usu_estado`, `usu_inicio_sesion`, `usu_avatar`, `usu_genero`, `usu_fecha_nacimiento`, `usu_perfil`, `usu_aspirante_id`, `usu_actualiza_fecha`, `usu_actualiza_login`, `usu_registro_usuario`, TAREA.`aa_nombre`, TCARGO.`ac_nombre`, TCIUDAD.`ciu_departamento`, TCIUDAD.`ciu_municipio` FROM `app_usuario` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TAREA ON `app_usuario`.`usu_area`=TAREA.`aa_id` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCARGO ON `app_usuario`.`usu_cargo`=TCARGO.`ac_id` 
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `app_usuario`.`usu_ciudad`=TCIUDAD.`ciu_codigo`
             WHERE `usu_documento`=:usu_documento';

            $parametros = [
                'usu_documento' => $this->usu_documento,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listDuplicadoId(){
            $sql='SELECT `usu_id`, `usu_documento`, `usu_acceso`, `usu_contrasena`, `usu_nombres_apellidos`, `usu_correo`, `usu_correo_corporativo`, `usu_fecha_incorporacion`, `usu_area`, `usu_cargo`, `usu_jefe_inmediato`, `usu_ciudad`, `usu_estado`, `usu_inicio_sesion`, `usu_avatar`, `usu_genero`, `usu_fecha_nacimiento`, `usu_perfil`, `usu_aspirante_id`, `usu_actualiza_fecha`, `usu_actualiza_login`, `usu_registro_usuario`, TAREA.`aa_nombre`, TCARGO.`ac_nombre`, TCIUDAD.`ciu_departamento`, TCIUDAD.`ciu_municipio` FROM `app_usuario` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TAREA ON `app_usuario`.`usu_area`=TAREA.`aa_id` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCARGO ON `app_usuario`.`usu_cargo`=TCARGO.`ac_id` 
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `app_usuario`.`usu_ciudad`=TCIUDAD.`ciu_codigo`
             WHERE `usu_aspirante_id`=:usu_aspirante_id';

            $parametros = [
                'usu_aspirante_id' => $this->usu_aspirante_id,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listResetMasivo(){
            $sql='SELECT `usu_id`, `usu_documento`, `usu_acceso`, `usu_contrasena`, `usu_nombres_apellidos`, `usu_correo`, `usu_correo_corporativo`, `usu_fecha_incorporacion`, `usu_area`, `usu_cargo`, `usu_jefe_inmediato`, `usu_ciudad`, `usu_estado`, `usu_inicio_sesion`, `usu_avatar`, `usu_genero`, `usu_fecha_nacimiento`, `usu_perfil`, `usu_aspirante_id`, `usu_actualiza_fecha`, `usu_actualiza_login`, `usu_registro_usuario`, TAREA.`aa_nombre`, TCARGO.`ac_nombre`, TCIUDAD.`ciu_departamento`, TCIUDAD.`ciu_municipio` FROM `app_usuario` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TAREA ON `app_usuario`.`usu_area`=TAREA.`aa_id` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCARGO ON `app_usuario`.`usu_cargo`=TCARGO.`ac_id` 
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `app_usuario`.`usu_ciudad`=TCIUDAD.`ciu_codigo`
             WHERE 1=1 AND `usu_contrasena`=:usu_contrasena ORDER BY `usu_id` ASC';

            $parametros = [
                'usu_contrasena' => ''
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para seleccionar un usuario datos login
         */

        public function login(){
            $sql='SELECT `usu_id`, `usu_documento`, `usu_acceso`, `usu_contrasena`, `usu_nombres_apellidos`, `usu_correo`, `usu_correo_corporativo`, `usu_fecha_incorporacion`, `usu_area`, `usu_cargo`, `usu_jefe_inmediato`, `usu_ciudad`, `usu_estado`, `usu_inicio_sesion`, `usu_avatar`, `usu_genero`, `usu_fecha_nacimiento`, `usu_perfil`, `usu_aspirante_id`, `usu_actualiza_fecha`, `usu_actualiza_login`, `usu_registro_usuario`, TAREA.`aa_nombre`, TCARGO.`ac_nombre`, TCIUDAD.`ciu_departamento`, TCIUDAD.`ciu_municipio` FROM `app_usuario` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_areas` AS TAREA ON `app_usuario`.`usu_area`=TAREA.`aa_id` 
            LEFT JOIN `'.DB_NAME_AUX.'`.`administrador_cargos` AS TCARGO ON `app_usuario`.`usu_cargo`=TCARGO.`ac_id` 
            LEFT JOIN `app_ciudades` AS TCIUDAD ON `app_usuario`.`usu_ciudad`=TCIUDAD.`ciu_codigo`
             WHERE `usu_acceso`=:usu_acceso AND `usu_estado`=:usu_estado';

            $user = [
                'usu_acceso' => $this->usu_acceso,
                'usu_estado' => $this->usu_estado
            ];

            try {
                return $res = parent::query($sql, $user);
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para crear un usuario 
         */
        public function add(){
            $sql='INSERT INTO `app_usuario`(`usu_documento`, `usu_acceso`, `usu_contrasena`, `usu_nombres_apellidos`, `usu_correo`, `usu_correo_corporativo`, `usu_fecha_incorporacion`, `usu_area`, `usu_cargo`, `usu_jefe_inmediato`, `usu_ciudad`, `usu_estado`, `usu_inicio_sesion`, `usu_avatar`, `usu_genero`, `usu_fecha_nacimiento`, `usu_perfil`, `usu_aspirante_id`, `usu_actualiza_fecha`, `usu_actualiza_login`, `usu_registro_usuario`) VALUES (:usu_documento, :usu_acceso, :usu_contrasena, :usu_nombres_apellidos, :usu_correo, :usu_correo_corporativo, :usu_fecha_incorporacion, :usu_area, :usu_cargo, :usu_jefe_inmediato, :usu_ciudad, :usu_estado, :usu_inicio_sesion, :usu_avatar, :usu_genero, :usu_fecha_nacimiento, :usu_perfil, :usu_aspirante_id, :usu_actualiza_fecha, :usu_actualiza_login, :usu_registro_usuario)';

            $parametros = [
                'usu_documento' => $this->usu_documento,
                'usu_acceso' => $this->usu_acceso,
                'usu_contrasena' => $this->usu_contrasena,
                'usu_nombres_apellidos' => $this->usu_nombres_apellidos,
                'usu_correo' => $this->usu_correo,
                'usu_correo_corporativo' => $this->usu_correo_corporativo,
                'usu_fecha_incorporacion' => $this->usu_fecha_incorporacion,
                'usu_area' => $this->usu_area,
                'usu_cargo' => $this->usu_cargo,
                'usu_jefe_inmediato' => $this->usu_jefe_inmediato,
                'usu_ciudad' => $this->usu_ciudad,
                'usu_estado' => $this->usu_estado,
                'usu_inicio_sesion' => $this->usu_inicio_sesion,
                'usu_avatar' => $this->usu_avatar,
                'usu_genero' => $this->usu_genero,
                'usu_fecha_nacimiento' => $this->usu_fecha_nacimiento,
                'usu_perfil' => $this->usu_perfil,
                'usu_aspirante_id' => $this->usu_aspirante_id,
                'usu_actualiza_fecha' => $this->usu_actualiza_fecha,
                'usu_actualiza_login' => $this->usu_actualiza_login,
                'usu_registro_usuario' => $this->usu_registro_usuario,
            ];

            try {
                return ($this->usu_id = parent::query($sql, $parametros)) ? $this->usu_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function update(){
            $sql='UPDATE `app_usuario` SET `usu_documento`=:usu_documento,`usu_acceso`=:usu_acceso,`usu_nombres_apellidos`=:usu_nombres_apellidos,`usu_correo`=:usu_correo,`usu_correo_corporativo`=:usu_correo_corporativo,`usu_fecha_incorporacion`=:usu_fecha_incorporacion,`usu_area`=:usu_area,`usu_cargo`=:usu_cargo,`usu_jefe_inmediato`=:usu_jefe_inmediato,`usu_ciudad`=:usu_ciudad,`usu_estado`=:usu_estado,`usu_genero`=:usu_genero,`usu_fecha_nacimiento`=:usu_fecha_nacimiento,`usu_perfil`=:usu_perfil,`usu_actualiza_fecha`=:usu_actualiza_fecha WHERE `usu_id`=:usu_id';

            $parametros = [
                'usu_id' => $this->usu_id,
                'usu_documento' => $this->usu_documento,
                'usu_acceso' => $this->usu_acceso,
                'usu_nombres_apellidos' => $this->usu_nombres_apellidos,
                'usu_correo' => $this->usu_correo,
                'usu_correo_corporativo' => $this->usu_correo_corporativo,
                'usu_fecha_incorporacion' => $this->usu_fecha_incorporacion,
                'usu_area' => $this->usu_area,
                'usu_cargo' => $this->usu_cargo,
                'usu_jefe_inmediato' => $this->usu_jefe_inmediato,
                'usu_ciudad' => $this->usu_ciudad,
                'usu_estado' => $this->usu_estado,
                'usu_genero' => $this->usu_genero,
                'usu_fecha_nacimiento' => $this->usu_fecha_nacimiento,
                'usu_perfil' => $this->usu_perfil,
                'usu_actualiza_fecha' => $this->usu_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateNombresApellidos(){
            $sql='UPDATE `app_usuario` SET `usu_nombres_apellidos`=:usu_nombres_apellidos WHERE `usu_id`=:usu_id';

            $parametros = [
                'usu_id' => $this->usu_id,
                'usu_nombres_apellidos' => $this->usu_nombres_apellidos,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateCorreoCorporativo(){
            $sql='UPDATE `app_usuario` SET `usu_correo_corporativo`=:usu_correo_corporativo WHERE `usu_id`=:usu_id';

            $parametros = [
                'usu_id' => $this->usu_id,
                'usu_correo_corporativo' => $this->usu_correo_corporativo,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function usuidUpdate(){
            $sql='UPDATE `app_usuario` SET `usu_aspirante_id`=:usu_aspirante_id WHERE `usu_id`=:usu_id';

            $parametros = [
                'usu_id' => $this->usu_id,
                'usu_aspirante_id' => $this->usu_aspirante_id,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updatePassword(){
            $sql='UPDATE `app_usuario` SET `usu_contrasena`=:usu_contrasena, `usu_estado`=:usu_estado,`usu_actualiza_fecha`=:usu_actualiza_fecha WHERE `usu_id`=:usu_id';

            $parametros = [
                'usu_id' => $this->usu_id,
                'usu_contrasena' => $this->usu_contrasena,
                'usu_estado' => 'Activo',
                'usu_actualiza_fecha' => $this->usu_actualiza_fecha,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateLogin(){
            $sql='UPDATE `app_usuario` SET `usu_actualiza_login`=:usu_actualiza_login WHERE `usu_id`=:usu_id';

            $parametros = [
                'usu_id' => $this->usu_id,
                'usu_actualiza_login' => $this->usu_actualiza_login,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateStatus(){
            $sql='UPDATE `app_usuario` SET `usu_estado`=:usu_estado WHERE `usu_id`=:usu_id';

            $parametros = [
                'usu_id' => $this->usu_id,
                'usu_estado' => $this->usu_estado,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateCentroCosto(){
            $sql='UPDATE `app_usuario` SET `usu_area`=:usu_area WHERE `usu_id`=:usu_id';

            $parametros = [
                'usu_id' => $this->usu_id,
                'usu_area' => $this->usu_area,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateCargo(){
            $sql='UPDATE `app_usuario` SET `usu_cargo`=:usu_cargo WHERE `usu_id`=:usu_id';

            $parametros = [
                'usu_id' => $this->usu_id,
                'usu_cargo' => $this->usu_cargo,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateSession(){
            $sql='UPDATE `app_usuario` SET `usu_inicio_sesion`=:usu_inicio_sesion WHERE `usu_id`=:usu_id';

            $parametros = [
                'usu_id' => $this->usu_id,
                'usu_inicio_sesion' => $this->usu_inicio_sesion,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function delete(){
            $sql='DELETE FROM `app_usuario` WHERE `usu_id`=:usu_id';

            $parametros = [
                'usu_id' => $this->usu_id,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para seleccionar un usuario datos recoveryPassword
         */
        public function userRecovery(){
            $sql='SELECT `usu_id`, `usu_nombres_apellidos`, `usu_correo`, `usu_correo_corporativo`, `usu_estado` FROM `app_usuario`
             WHERE `usu_correo_corporativo`=:usu_correo_corporativo AND `usu_estado`<>:usu_estado';

            $parametros = [
                'usu_correo_corporativo' => $this->usu_correo_corporativo,
                'usu_estado' => $this->usu_estado
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }