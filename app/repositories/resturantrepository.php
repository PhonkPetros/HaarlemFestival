<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use DateTime;
use model\Resturant;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/resturant.php';


class resturantrepository extends dbconfig {
    public function getAllRestaurants() {
        $restaurants = []; // Initialize an empty array to hold Restaurant objects
        try {
            $stmt = $this->connection->prepare("SELECT * FROM [Event] WHERE NAME = 'Restaurant'");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($results as $result) {
                $restaurant = new \model\Restaurant();
                $restaurant->setId($result['event_id']);
                $restaurant->setLocation($result['location']);
                $restaurant->setPrice($result['price']);
                $restaurant->setSeats(isset($result['seats']) ? (int)$result['seats'] : null); // Explicitly handle null seats
                $restaurant->setStartDate($result['startDate']);
                $restaurant->setEndDate($result['endDate']);
                $restaurants[] = $restaurant; // Add the Restaurant object to the array
            }
            
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
        return $restaurants; // Return the array of Restaurant objects
    }
    

    public function getRestaurantByName($name) {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM [Event] WHERE NAME = :name");
            $stmt->bindValue(':name', $name);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                $restaurant = new \model\Restaurant();
                $restaurant->setId($result['id']);
                $restaurant->setName($result['NAME']); // Assuming 'NAME' is the column name in your table
                $restaurant->setLocation($result['location']);
                $restaurant->setPrice($result['price']);
                $restaurant->setSeats($result['seats']); // Assuming there's a 'seats' field
                $restaurant->setStartDate($result['startDate']);
                $restaurant->setEndDate($result['endDate']);
                return $restaurant;
            }
            return null;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    
}