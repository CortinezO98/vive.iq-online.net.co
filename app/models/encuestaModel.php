<?php
    class encuestaModel extends Model {
        public $enc_id;
        public $enc_titulo;
        public $enc_descripcion;
        public $enc_fecha_inicio;
        public $enc_fecha_fin;
        public $enc_estado;
        public $enc_areas;
        public $enc_contenido;
        public $enc_auxiliar_1;
        public $enc_auxiliar_2;
        public $enc_registro_usuario;
        public $enc_registro_fecha;
        public $filtro_bandeja='';
        public $filtro_perfil='';
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
                        $filtro_bandeja_str.=" `enc_estado`=:enc_estado_".$i." OR ";
                        $parametros_filtro = [
                            'enc_estado_'.$i => $this->filtro_bandeja[$i],
                        ];
                        $parametros = array_merge($parametros, $parametros_filtro);
                    }
                    $filtro_bandeja_str="AND (".substr($filtro_bandeja_str, 0, -3).")";
                }
            } else {
                $filtro_bandeja_str="";
            }

            if ($this->filtro!="" AND $this->filtro!="null") {
                $filtro_str="AND (`enc_titulo` LIKE :enc_titulo)";
                $parametros_filtro = [
                    'enc_titulo' => '%'.$this->filtro.'%',
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_str="";
            }

            $sql='SELECT `enc_id`, `enc_titulo`, `enc_descripcion`, `enc_fecha_inicio`, `enc_fecha_fin`, `enc_estado`, `enc_areas`, `enc_contenido`, `enc_auxiliar_1`, `enc_auxiliar_2`, `enc_registro_usuario`, `enc_registro_fecha`, TUR.`usu_nombres_apellidos` AS usuario_registro FROM `encuestas` LEFT JOIN `app_usuario` AS TUR ON `encuestas`.`enc_registro_usuario`=TUR.`usu_id` 
             WHERE 1=1 '.$filtro_bandeja_str.' '.$filtro_str.' ORDER BY `enc_titulo` ASC LIMIT :offset,:limite';

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
                        $filtro_bandeja_str.=" `enc_estado`=:enc_estado_".$i." OR ";
                        $parametros_filtro = [
                            'enc_estado_'.$i => $this->filtro_bandeja[$i],
                        ];
                        $parametros = array_merge($parametros, $parametros_filtro);
                    }
                    $filtro_bandeja_str="AND (".substr($filtro_bandeja_str, 0, -3).")";
                }
            } else {
                $filtro_bandeja_str="";
            }

            if ($this->filtro!="" AND $this->filtro!="null") {
                $filtro_str="AND (`enc_titulo` LIKE :enc_titulo)";
                $parametros_filtro = [
                    'enc_titulo' => '%'.$this->filtro.'%',
                ];
                $parametros = array_merge($parametros, $parametros_filtro);
            } else {
                $filtro_str="";
            }

            $sql='SELECT `enc_id`, `enc_titulo`, `enc_descripcion`, `enc_fecha_inicio`, `enc_fecha_fin`, `enc_estado`, `enc_areas`, `enc_contenido`, `enc_auxiliar_1`, `enc_auxiliar_2`, `enc_registro_usuario`, `enc_registro_fecha`, TUR.`usu_nombres_apellidos` AS usuario_registro FROM `encuestas` LEFT JOIN `app_usuario` AS TUR ON `encuestas`.`enc_registro_usuario`=TUR.`usu_id` 
             WHERE 1=1 '.$filtro_bandeja_str.' '.$filtro_str.' ORDER BY `enc_titulo` ASC';

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listDetail(){
            $sql='SELECT `enc_id`, `enc_titulo`, `enc_descripcion`, `enc_fecha_inicio`, `enc_fecha_fin`, `enc_estado`, `enc_areas`, `enc_contenido`, `enc_auxiliar_1`, `enc_auxiliar_2`, `enc_registro_usuario`, `enc_registro_fecha`, TUR.`usu_nombres_apellidos` AS usuario_registro FROM `encuestas` LEFT JOIN `app_usuario` AS TUR ON `encuestas`.`enc_registro_usuario`=TUR.`usu_id` 
             WHERE `enc_id`=:enc_id';

            $parametros = [
                'enc_id' => $this->enc_id,
            ];

            try {
                return $res = parent::query($sql, $parametros);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function listActive(){
            $sql='SELECT `enc_id`, `enc_titulo`, `enc_descripcion`, `enc_fecha_inicio`, `enc_fecha_fin`, `enc_estado`, `enc_areas`, `enc_contenido`, `enc_auxiliar_1`, `enc_auxiliar_2`, `enc_registro_usuario`, `enc_registro_fecha`, TUR.`usu_nombres_apellidos` AS usuario_registro FROM `encuestas` LEFT JOIN `app_usuario` AS TUR ON `encuestas`.`enc_registro_usuario`=TUR.`usu_id` 
             WHERE `enc_estado`=:enc_estado';

            $parametros = [
                'enc_estado' => $this->enc_estado,
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
            $sql='INSERT INTO `encuestas`(`enc_titulo`, `enc_descripcion`, `enc_fecha_inicio`, `enc_fecha_fin`, `enc_estado`, `enc_areas`, `enc_contenido`, `enc_auxiliar_1`, `enc_auxiliar_2`, `enc_registro_usuario`) VALUES (:enc_titulo, :enc_descripcion, :enc_fecha_inicio, :enc_fecha_fin, :enc_estado, :enc_areas, :enc_contenido, :enc_auxiliar_1, :enc_auxiliar_2, :enc_registro_usuario)';

            $parametros = [
                'enc_titulo' => $this->enc_titulo,
                'enc_descripcion' => $this->enc_descripcion,
                'enc_fecha_inicio' => $this->enc_fecha_inicio,
                'enc_fecha_fin' => $this->enc_fecha_fin,
                'enc_estado' => $this->enc_estado,
                'enc_areas' => $this->enc_areas,
                'enc_contenido' => $this->enc_contenido,
                'enc_auxiliar_1' => $this->enc_auxiliar_1,
                'enc_auxiliar_2' => $this->enc_auxiliar_2,
                'enc_registro_usuario' => $this->enc_registro_usuario,
            ];

            try {
                return ($this->enc_id = parent::query($sql, $parametros)) ? $this->enc_id : false;
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function update(){
            $sql='UPDATE `encuestas` SET `enc_titulo`=:enc_titulo, `enc_descripcion`=:enc_descripcion, `enc_fecha_inicio`=:enc_fecha_inicio, `enc_fecha_fin`=:enc_fecha_fin, `enc_estado`=:enc_estado, `enc_areas`=:enc_areas, `enc_contenido`=:enc_contenido, `enc_auxiliar_1`=:enc_auxiliar_1, `enc_auxiliar_2`=:enc_auxiliar_2 WHERE `enc_id`=:enc_id';

            $parametros = [
                'enc_id' => $this->enc_id,
                'enc_titulo' => $this->enc_titulo,
                'enc_descripcion' => $this->enc_descripcion,
                'enc_fecha_inicio' => $this->enc_fecha_inicio,
                'enc_fecha_fin' => $this->enc_fecha_fin,
                'enc_estado' => $this->enc_estado,
                'enc_areas' => $this->enc_areas,
                'enc_contenido' => $this->enc_contenido,
                'enc_auxiliar_1' => $this->enc_auxiliar_1,
                'enc_auxiliar_2' => $this->enc_auxiliar_2,
            ];

            try {
                return (parent::query($sql, $parametros)) ? true : false;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }