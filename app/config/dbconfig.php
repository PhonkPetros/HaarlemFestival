<?php
namespace config;

use PDO;
use PDOException;

class dbconfig {
    protected $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $server = "tcp:haarlem.database.windows.net";
        $database = "HaarlemFestival";
        $username = "festivalAdmin";
        $password = "Admin@123";

        try {
            $this->connection = new PDO("sqlsrv:Server=$server;Database=$database", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}
