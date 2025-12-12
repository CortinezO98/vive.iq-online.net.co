<?php
    class buzonesModel extends Model {
        public $ncr_id;
        public $ncr_host;
        public $ncr_port;
        public $ncr_smtpsecure;
        public $ncr_smtpauth;
        public $ncr_username;
        public $ncr_password;
        public $ncr_setfrom;
        public $ncr_setfrom_name;
        public $ncr_tipo;
        public $pagina;
        public $filtro;
        public $limite;
        public $offset;
        

        /**
         * Método para listar registros
         */

        public function list(){
            $parametros = [
                'offset' => $this->offset,
                'limite' => $this->limite,
            ];

            if ($this->filtro!="" AND $this->filtro!="null") {
                $filtro_str="AND (`ncr_username` LIKE :ncr_username)";
                $parametros_filtro = [
                    'ncr_username' => '%'.$this->filtro.'%',
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_str="";
            }

            $sql='SELECT `ncr_id`, `ncr_host`, `ncr_port`, `ncr_smtpsecure`, `ncr_smtpauth`, `ncr_username`, `ncr_password`, `ncr_setfrom`, `ncr_setfrom_name`, `ncr_tipo` FROM `app_buzones` 
             WHERE 1=1 '.$filtro_str.' ORDER BY `ncr_id` ASC LIMIT :offset,:limite';

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
                $filtro_str="AND (`ncr_username` LIKE :ncr_username)";
                $parametros_filtro = [
                    'ncr_username' => '%'.$this->filtro.'%',
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_str="";
            }

            $sql='SELECT `ncr_id`, `ncr_host`, `ncr_port`, `ncr_smtpsecure`, `ncr_smtpauth`, `ncr_username`, `ncr_password`, `ncr_setfrom`, `ncr_setfrom_name`, `ncr_tipo` FROM `app_buzones` 
             WHERE 1=1 '.$filtro_str.' ORDER BY `ncr_id` ASC';

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listDetail(){
            $sql='SELECT `ncr_id`, `ncr_host`, `ncr_port`, `ncr_smtpsecure`, `ncr_smtpauth`, `ncr_username`, `ncr_password`, `ncr_setfrom`, `ncr_setfrom_name`, `ncr_tipo` FROM `app_buzones`
             WHERE 1=1 AND `ncr_id`=:ncr_id';

            $parametros = [
                'ncr_id' => $this->ncr_id
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function update(){
            $sql='UPDATE `app_buzones` SET `ncr_host`=:ncr_host, `ncr_port`=:ncr_port, `ncr_smtpsecure`=:ncr_smtpsecure, `ncr_smtpauth`=:ncr_smtpauth, `ncr_username`=:ncr_username, `ncr_password`=:ncr_password, `ncr_setfrom`=:ncr_setfrom, `ncr_setfrom_name`=:ncr_setfrom_name WHERE `ncr_id`=:ncr_id';

            $parametros = [
                'ncr_id' => $this->ncr_id,
                'ncr_host' => $this->ncr_host,
                'ncr_port' => $this->ncr_port,
                'ncr_smtpsecure' => $this->ncr_smtpsecure,
                'ncr_smtpauth' => $this->ncr_smtpauth,
                'ncr_username' => $this->ncr_username,
                'ncr_password' => $this->ncr_password,
                'ncr_setfrom' => $this->ncr_setfrom,
                'ncr_setfrom_name' => $this->ncr_setfrom_name,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }