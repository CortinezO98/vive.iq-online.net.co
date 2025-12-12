<?php
    class Db
    {
        private $link;
        private $engine;
        private $name;
        private $user;
        private $pass;
        private $charset;
        
        /**
         * Constructor para la clase
         * 
         */
        public function __construct() {
            $this->engine = DB_ENGINE;
            $this->host = DB_HOST;
            $this->name = DB_NAME;
            $this->user = DB_USER;
            $this->pass = DB_PASS;
            $this->charset = DB_CHARSET;
            return $this;
        }

        /**
         * Método para abrir una conexión a la base de datos
         * 
         */
        private function connect() {
            try {
                $emulate_prepares_below_version = '5.1.17';
                $this->link = new PDO($this->engine.':host='.$this->host.';dbname='.$this->name.';charset='.$this->charset, $this->user, $this->pass);
                $serverversion = $this->link->getAttribute(PDO::ATTR_SERVER_VERSION);
                $emulate_prepares = (version_compare($serverversion, $emulate_prepares_below_version, '<'));
                $this->link->setAttribute(PDO::ATTR_EMULATE_PREPARES, $emulate_prepares);
                return $this->link;
            } catch (PDOException $e) {
                die(sprintf('No hay conexión a la base de datos, hubo un error: %s', $e->getMessage()));
            }
        }

        /**
         * Método para hacer un query a la base de datos
         * 
         * @param string $sql
         * @param array $params
         * @return void
         * 
         */
        public static function query($sql, $params = []) {
            $db = new self();
            $link = $db->connect(); //Conexión a DB
            $link->beginTransaction(); //por cualquier error,checkpoint
            $query = $link->prepare($sql);

            //Manejamos errores en query o petición
            if (!$query->execute($params)) {
                $link->rollBack();
                $error = $query->errorInfo();
                //index 0 es tipo de error
                //index 1 es cód error
                //index 2 es mensaje de error al usuario
                throw new Exception($error[2]);
            }

            if (strpos($sql, 'SELECT') !== false) {
                return $query->rowCount() > 0 ? $query->fetchAll() : false;
            } elseif (strpos($sql, 'INSERT') !== false) {
                $id = $link->lastInsertId();
                $link->commit();
                return $id;
            } elseif (strpos($sql, 'UPDATE') !== false) {
                $link->commit();
                return true;
            } elseif (strpos($sql, 'DELETE') !== false) {
                if($query->rowCount()>0) {
                    $link->commit();
                    return true;
                }

                $link->rollBack();
                return false;//Nada ha sido borrado
            } else {
                $link->commit();
                return true;
            }
        }
    }