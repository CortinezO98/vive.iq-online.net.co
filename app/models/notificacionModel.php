<?php
    class notificacionModel extends Model {
        public $nc_id;
        public $nc_id_modulo="1";
        public $nc_prioridad="Alta";
        public $nc_id_set_from="1";
        public $nc_address;
        public $nc_cc="";
        public $nc_bcc="";
        public $nc_reply_to="";
        public $nc_subject;
        public $nc_body;
        public $nc_embeddedimage_ruta;
        public $nc_embeddedimage_nombre;
        public $nc_embeddedimage_tipo;
        public $nc_attachment_ruta;
        public $nc_intentos='0';
        public $nc_eliminar='';
        public $nc_estado_envio='Pendiente';
        public $nc_fecha_envio='';
        public $nc_fecha_registro;
        public $nc_usuario_registro;
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;
        
        /**
         * Método para listar
         */
        public function list(){
            $parametros = [
                'offset' => $this->offset,
                'limite' => $this->limite,
            ];

            if ($this->filtro!="" AND $this->filtro!="null") {
                $filtro_str="AND (`nc_address` LIKE :nc_address OR `nc_subject` LIKE :nc_subject)";
                $parametros_filtro = [
                    'nc_address' => '%'.$this->filtro.'%',
                    'nc_subject' => '%'.$this->filtro.'%',
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_str="";
            }

            $sql='SELECT `nc_id`, `nc_id_modulo`, `nc_prioridad`, `nc_id_set_from`, `nc_address`, `nc_cc`, `nc_bcc`, `nc_reply_to`, `nc_subject`, `nc_body`, `nc_embeddedimage_ruta`, `nc_intentos`, `nc_eliminar`, `nc_estado_envio`, `ncr_host`, `ncr_port`, `ncr_smtpsecure`, `ncr_smtpauth`, `ncr_username`, `ncr_password`, `ncr_setfrom`, `ncr_setfrom_name`, `nc_embeddedimage_ruta`, `nc_embeddedimage_nombre`, `nc_embeddedimage_tipo`, `nc_attachment_ruta` FROM `app_notificaciones` LEFT JOIN `app_buzones` AS RT ON `app_notificaciones`.`nc_id_set_from`=RT.`ncr_id` WHERE 1=1 '.$filtro_str.' ORDER BY `nc_id` DESC LIMIT :offset,:limite';

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
                $filtro_str="AND (`nc_address` LIKE :nc_address OR `nc_subject` LIKE :nc_subject)";
                $parametros_filtro = [
                    'nc_address' => '%'.$this->filtro.'%',
                    'nc_subject' => '%'.$this->filtro.'%',
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_str="";
            }

            $sql='SELECT `nc_id` FROM `app_notificaciones` LEFT JOIN `app_buzones` AS RT ON `app_notificaciones`.`nc_id_set_from`=RT.`ncr_id` WHERE 1=1 '.$filtro_str.' ORDER BY `nc_id` DESC';

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para listar
         */
        public function listPendiente(){
            $sql='SELECT `nc_id`, `nc_id_modulo`, `nc_prioridad`, `nc_id_set_from`, `nc_address`, `nc_cc`, `nc_bcc`, `nc_reply_to`, `nc_subject`, `nc_body`, `nc_embeddedimage_ruta`, `nc_intentos`, `nc_eliminar`, `nc_estado_envio`, `ncr_host`, `ncr_port`, `ncr_smtpsecure`, `ncr_smtpauth`, `ncr_username`, `ncr_password`, `ncr_setfrom`, `ncr_setfrom_name`, `nc_embeddedimage_ruta`, `nc_embeddedimage_nombre`, `nc_embeddedimage_tipo`, `nc_attachment_ruta` FROM `app_notificaciones` LEFT JOIN `app_buzones` AS RT ON `app_notificaciones`.`nc_id_set_from`=RT.`ncr_id` WHERE `nc_estado_envio`=:nc_estado_envio AND `nc_id_set_from`=:nc_id_set_from ORDER BY `nc_prioridad` LIMIT :offset,:limite';

            $parametros = [
                'nc_estado_envio' => $this->nc_estado_envio,
                'nc_id_set_from' => $this->nc_id_set_from,
                'offset' => $this->offset,
                'limite' => $this->limite,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para listar
         */
        public function listPendienteHorario(){
            $sql='SELECT `nc_id`, `nc_id_modulo`, `nc_prioridad`, `nc_id_set_from`, `nc_address`, `nc_cc`, `nc_bcc`, `nc_reply_to`, `nc_subject`, `nc_body`, `nc_embeddedimage_ruta`, `nc_intentos`, `nc_eliminar`, `nc_estado_envio`, `ncr_host`, `ncr_port`, `ncr_smtpsecure`, `ncr_smtpauth`, `ncr_username`, `ncr_password`, `ncr_setfrom`, `ncr_setfrom_name`, `nc_embeddedimage_ruta`, `nc_embeddedimage_nombre`, `nc_embeddedimage_tipo`, `nc_attachment_ruta` FROM `app_notificaciones` LEFT JOIN `app_buzones` AS RT ON `app_notificaciones`.`nc_id_set_from`=RT.`ncr_id` WHERE `nc_estado_envio`=:nc_estado_envio AND `nc_id_set_from`=:nc_id_set_from AND `nc_prioridad`<>:nc_prioridad ORDER BY `nc_prioridad` LIMIT :offset,:limite';

            $parametros = [
                'nc_estado_envio' => $this->nc_estado_envio,
                'nc_id_set_from' => $this->nc_id_set_from,
                'nc_prioridad' => $this->nc_prioridad,
                'offset' => $this->offset,
                'limite' => $this->limite,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        /**
         * Método para crear un registro
         */

        public function add(){
            $sql='INSERT INTO `app_notificaciones`(`nc_id_modulo`, `nc_prioridad`, `nc_id_set_from`, `nc_address`, `nc_cc`, `nc_bcc`, `nc_reply_to`, `nc_subject`, `nc_body`, `nc_embeddedimage_ruta`, `nc_embeddedimage_nombre`, 
            `nc_embeddedimage_tipo`, `nc_attachment_ruta`, `nc_intentos`, `nc_eliminar`, `nc_estado_envio`, `nc_fecha_envio`, `nc_usuario_registro`) VALUES (:nc_id_modulo, :nc_prioridad, :nc_id_set_from, :nc_address, :nc_cc, :nc_bcc, :nc_reply_to, :nc_subject, :nc_body, :nc_embeddedimage_ruta, :nc_embeddedimage_nombre, 
            :nc_embeddedimage_tipo, :nc_attachment_ruta, :nc_intentos, :nc_eliminar, :nc_estado_envio, :nc_fecha_envio, :nc_usuario_registro)';

            $parametros = [
                'nc_id_modulo' => $this->nc_id_modulo,
                'nc_prioridad' => $this->nc_prioridad,
                'nc_id_set_from' => $this->nc_id_set_from,
                'nc_address' => $this->nc_address,
                'nc_cc' => $this->nc_cc,
                'nc_bcc' => $this->nc_bcc,
                'nc_reply_to' => $this->nc_reply_to,
                'nc_subject' => $this->nc_subject,
                'nc_body' => $this->nc_body,
                'nc_embeddedimage_ruta' => $this->nc_embeddedimage_ruta,
                'nc_embeddedimage_nombre' => $this->nc_embeddedimage_nombre,
                'nc_embeddedimage_tipo' => $this->nc_embeddedimage_tipo,
                'nc_attachment_ruta' => $this->nc_attachment_ruta,
                'nc_intentos' => $this->nc_intentos,
                'nc_eliminar' => $this->nc_eliminar,
                'nc_estado_envio' => $this->nc_estado_envio,
                'nc_fecha_envio' => $this->nc_fecha_envio,
                'nc_usuario_registro' => $this->nc_usuario_registro,
            ];

            try {
                return ($this->nc_id = parent::query($sql, $parametros)) ? $this->nc_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function updateEstado(){
            // error_reporting(E_ALL);
            // ini_set('display_errors', '1');
            $sql='UPDATE `app_notificaciones` SET `nc_intentos`=:nc_intentos, `nc_estado_envio`=:nc_estado_envio, `nc_fecha_envio`=:nc_fecha_envio WHERE `nc_id`=:nc_id';

            $parametros = [
                'nc_id' => $this->nc_id,
                'nc_intentos' => $this->nc_intentos,
                'nc_estado_envio' => $this->nc_estado_envio,
                'nc_fecha_envio' => $this->nc_fecha_envio,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }