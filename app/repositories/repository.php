<?php
namespace repositories;

use PDO;
use PDOException;

class Repository {
    protected $connection;

    function __construct() {
        $server = "tcp:haarlem.database.windows.net,1433";
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
}
