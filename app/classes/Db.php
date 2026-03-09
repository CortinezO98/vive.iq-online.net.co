<?php
class Db
{
    private $link;
    private $engine;
    private $name;
    private $user;
    private $pass;
    private $charset;
    private $host;
    private $port;
    
    /**
     * Constructor para la clase
     */
    public function __construct() {
        $this->engine  = DB_ENGINE;
        $this->host    = DB_HOST;
        $this->port    = defined('DB_PORT') ? DB_PORT : 3306;
        $this->name    = DB_NAME;
        $this->user    = DB_USER;
        $this->pass    = DB_PASS;
        $this->charset = DB_CHARSET;
        return $this;
    }

    /**
     * Método para abrir una conexión a la base de datos
     */
    private function connect() {
        try {
            $emulate_prepares_below_version = '5.1.17';

            $this->link = new PDO(
                $this->engine .
                ':host=' . $this->host .
                ';port=' . $this->port .
                ';dbname=' . $this->name .
                ';charset=' . $this->charset,
                $this->user,
                $this->pass
            );

            $serverversion = $this->link->getAttribute(PDO::ATTR_SERVER_VERSION);
            $emulate_prepares = version_compare($serverversion, $emulate_prepares_below_version, '<');

            $this->link->setAttribute(PDO::ATTR_EMULATE_PREPARES, $emulate_prepares);
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->link->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $this->link;
        } catch (PDOException $e) {
            die(sprintf(
                'No hay conexión a la base de datos, hubo un error: %s',
                $e->getMessage()
            ));
        }
    }

    /**
     * Método para hacer un query a la base de datos
     *
     * @param string $sql
     * @param array $params
     * @return mixed
     */
    public static function query($sql, $params = []) {
        $db = new self();
        $link = $db->connect();
        $link->beginTransaction();
        $query = $link->prepare($sql);

        try {
            if (!$query->execute($params)) {
                $link->rollBack();
                $error = $query->errorInfo();
                throw new Exception($error[2] ?? 'Error desconocido en la consulta.');
            }

            $sqlTrim = ltrim((string)$sql);

            if (stripos($sqlTrim, 'SELECT') === 0) {
                $rows = $query->fetchAll();
                $link->commit();
                return !empty($rows) ? $rows : false;

            } elseif (stripos($sqlTrim, 'INSERT') === 0) {
                $id = $link->lastInsertId();
                $link->commit();
                return $id;

            } elseif (stripos($sqlTrim, 'UPDATE') === 0) {
                $link->commit();
                return true;

            } elseif (stripos($sqlTrim, 'DELETE') === 0) {
                if ($query->rowCount() > 0) {
                    $link->commit();
                    return true;
                }

                $link->rollBack();
                return false; 
            } else {
                $link->commit();
                return true;
            }
        } catch (Exception $e) {
            if ($link->inTransaction()) {
                $link->rollBack();
            }
            throw $e;
        }
    }
}
?>