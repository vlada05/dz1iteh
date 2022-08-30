<?php

class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db_name = "domaci1";
    private static $instance = null;
    private $connection = null;

    private function __construct()
    {
        $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Database();
        }

        return self::$instance;
    }
}
?>