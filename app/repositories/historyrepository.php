<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use DateTime;
use model\Event;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/event.php';


class historyrepository extends dbconfig
{
    public function getEventDetails($eventName = "history")
    {
        $sql = 'SELECT * FROM [Event] WHERE name = :eventName';
        
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':eventName', $eventName, PDO::PARAM_STR);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'model\Event');
            $event = $stmt->fetch();

            return $event;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

}