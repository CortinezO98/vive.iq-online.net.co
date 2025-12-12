<?php
    class logModel extends Model {
        public $clog_log_modulo;
        public $clog_log_tipo;
        public $clog_log_accion;
        public $clog_log_detalle;
        public $clog_user_agent;
        public $clog_remote_addr;
        public $clog_remote_host;
        public $clog_script;
        public $clog_registro_usuario;
        public $pagina;
        public $filtro;

        /**
         * Método para listar logs
         */
        public function list(){
            $parametros = [
                'offset' => $this->offset,
                'limite' => $this->limite,
            ];

            if ($this->filtro!="" AND $this->filtro!="null") {
                $filtro_str="AND (`clog_log_modulo` LIKE :clog_log_modulo OR `clog_log_tipo` LIKE :clog_log_tipo OR `clog_log_accion` LIKE :clog_log_accion OR `clog_log_detalle` LIKE :clog_log_detalle OR `clog_script` LIKE :clog_script OR `clog_registro_usuario` LIKE :clog_registro_usuario OR `clog_registro_fecha` LIKE :clog_registro_fecha OR TUR.`usu_nombres_apellidos` LIKE :usu_nombres_apellidos)";
                $parametros_filtro = [
                    'clog_log_modulo' => '%'.$this->filtro.'%',
                    'clog_log_tipo' => '%'.$this->filtro.'%',
                    'clog_log_accion' => '%'.$this->filtro.'%',
                    'clog_log_detalle' => '%'.$this->filtro.'%',
                    'clog_script' => '%'.$this->filtro.'%',
                    'clog_registro_usuario' => '%'.$this->filtro.'%',
                    'clog_registro_fecha' => '%'.$this->filtro.'%',
                    'usu_nombres_apellidos' => '%'.$this->filtro.'%',
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_str="";
            }

            $sql='SELECT `clog_id`, `clog_log_modulo`, `clog_log_tipo`, `clog_log_accion`, `clog_log_detalle`, `clog_user_agent`, 
            `clog_remote_addr`, `clog_script`, `clog_registro_usuario`, `clog_registro_fecha`, TUR.`usu_nombres_apellidos`, TUR.`usu_documento` 
            FROM `app_log` LEFT JOIN `app_usuario` AS TUR ON `app_log`.`clog_registro_usuario`=TUR.`usu_id` 
            WHERE 1=1 '.$filtro_str.' ORDER BY `clog_registro_fecha` DESC LIMIT :offset,:limite';

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
                $filtro_str="AND (`clog_log_modulo` LIKE :clog_log_modulo OR `clog_log_tipo` LIKE :clog_log_tipo OR `clog_log_accion` LIKE :clog_log_accion OR `clog_log_detalle` LIKE :clog_log_detalle OR `clog_script` LIKE :clog_script OR `clog_registro_usuario` LIKE :clog_registro_usuario OR `clog_registro_fecha` LIKE :clog_registro_fecha OR TUR.`usu_nombres_apellidos` LIKE :usu_nombres_apellidos)";
                $parametros = [
                    'clog_log_modulo' => '%'.$this->filtro.'%',
                    'clog_log_tipo' => '%'.$this->filtro.'%',
                    'clog_log_accion' => '%'.$this->filtro.'%',
                    'clog_log_detalle' => '%'.$this->filtro.'%',
                    'clog_script' => '%'.$this->filtro.'%',
                    'clog_registro_usuario' => '%'.$this->filtro.'%',
                    'clog_registro_fecha' => '%'.$this->filtro.'%',
                    'usu_nombres_apellidos' => '%'.$this->filtro.'%',
                ];
            } else {
                $filtro_str="";
            }

            $sql='SELECT `clog_id`, `clog_log_modulo`, `clog_log_tipo`, `clog_log_accion`, `clog_log_detalle`, `clog_user_agent`, 
            `clog_remote_addr`, `clog_script`, `clog_registro_usuario`, `clog_registro_fecha`, TUR.`usu_nombres_apellidos` 
            FROM `app_log` LEFT JOIN `app_usuario` AS TUR ON `app_log`.`clog_registro_usuario`=TUR.`usu_id` 
            WHERE 1=1 '.$filtro_str.' ORDER BY `clog_registro_fecha` DESC';

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para registrar log
         */

        public function add(){
            $sql='INSERT INTO `app_log`(`clog_log_modulo`, `clog_log_tipo`, `clog_log_accion`, `clog_log_detalle`, 
            `clog_user_agent`, `clog_remote_addr`, `clog_script`, `clog_registro_usuario`) 
            VALUES (:clog_log_modulo, :clog_log_tipo, :clog_log_accion, :clog_log_detalle, :clog_user_agent, :clog_remote_addr, :clog_script, :clog_registro_usuario)';

            $parametros = [
                'clog_log_modulo' => $this->clog_log_modulo,
                'clog_log_tipo' => $this->clog_log_tipo,
                'clog_log_accion' => $this->clog_log_accion,
                'clog_log_detalle' => $this->clog_log_detalle,
                'clog_user_agent' => $this->clog_user_agent,
                'clog_remote_addr' => $this->clog_remote_addr,
                'clog_script' => $this->clog_script,
                'clog_registro_usuario' => $this->clog_registro_usuario
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }