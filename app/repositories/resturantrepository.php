<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use DateTime;

require_once __DIR__ . '/../config/dbconfig.php';

class resturantrepository extends dbconfig {
    public function getAllResturants() {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM [Event] WHERE NAME = 'Restaurant'");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}