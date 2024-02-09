<?php
namespace config;

class dbconfig
{
    private $servername = 'mysql';
    private $username = 'developer';
    private $password = 'secret123';
    private $database = 'developmentdb';

    public function connect()
    {
        try {
            $conn = new \PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}

?>
