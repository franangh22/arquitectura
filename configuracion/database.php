<?php
class Database
{
    #Atributos
    private static $host = 'localhost'; #HOST_NAME
    private static $dbName = 'usuariodb'; #DB_NAME
    private static $dbUser = 'root'; #USER_DB
    private static $dbPass = ''; #DB_PASS
    private static $error;
    public function __construct()
    {
    }
    #Configurar la conexion
    private static function connection()
    {
        $dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$dbName;
        $opc = array(PDO::ATTR_PERSISTENT => TRUE, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        #instanciar la conexion
        try {
            #Crear el primer OBJ
            $conndb = new PDO($dsn, self::$dbUser, self::$dbPass, $opc);
            #set horario
            $conndb->exec('SET time_zone = "-03:00";');
            $conndb->exec('SET @@session.time_zone = "-03:00";');
        } catch (PDOException $e) {
            self::$error = $e->getMessage();
            return self::$error;
        }
        return $conndb;
    }
    #metodo para ejecutar
    public static function execute($sql, $params = [])
    {
        $stmt = static::connection()->prepare($sql);
        try {
            $resultado = $stmt->execute($params);
        } catch (PDOException $e) {
            $resultado = $e->getMessage();
        }
        return $resultado;
    }
    #Recuperar todos
    public static function getRecords($sql, $params = [])
    {
        $stmt = static::connection()->prepare($sql);
        try {
            #instanciar el primer OBJ
            $stmt->execute($params);
            $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "<pre>";
            var_dump($e);
            echo "</pre>";
            $resultado = false;
        }
        return $resultado;
    }
    public static function getRecordsbyID($sql, $params = [])
    {
        $stmt = static::connection()->prepare($sql);
        try {
            #instanciar el primer OBJ
            $stmt->execute($params);
            $resultado = $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "<pre>";
            var_dump($e);
            echo "</pre>";
            $resultado = false;
        }
        return $resultado;
    }
}