<?php
require_once 'constants.php';

class connection{
    private static $db;
    private $connection;

    public function __construct() {
        $this->connection = new MySQLi(HOST,USER,PASS,DB);
    }

    function __destruct() {
        $this->connection->close();
    }

    public static function getConnection() {
        if (self::$db == null) {
            self::$db = new connection();
        }
        return self::$db->connection;
    }


}
?>