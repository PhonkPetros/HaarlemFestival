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
        $restaurants = [];
        try {
            $stmt = $this->connection->prepare("SELECT * FROM [Event] WHERE NAME = 'Restaurant'");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($results as $result) {
                $restaurant = new \model\Restaurant();
                $restaurant->setId($result['event_id']);
                $restaurant->setLocation($result['location']);
                $restaurant->setPrice($result['price']);
                $restaurant->setSeats(isset($result['seats']) ? (int)$result['seats'] : null);
                $restaurant->setStartDate($result['startDate']);
                $restaurant->setEndDate($result['endDate']);
                $restaurant->setPicture($result['picture']);
                $restaurants[] = $restaurant;
            }
            
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
        return $restaurants;
    }
    

    public function getRestaurantByName($location) {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM [Event] WHERE NAME = :location");
            $stmt->bindValue(':location', $location);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                $restaurant = new \model\Restaurant();
                $restaurant->setId($result['id']);
                $restaurant->setLocation($result['location']);
                $restaurant->setPrice($result['price']);
                $restaurant->setSeats($result['seats']);
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

    public function updateRestaurantDetails($id, $name, $price, $seats, $startDate, $endDate, $picturePath) {
        try {
            $sql = "UPDATE [Event] SET location = :location, price = :price, seats = :seats, startDate = :startDate, endDate = :endDate";
            
            if (!empty($picturePath)) {
                $sql .= ", picture = :picture";
            }
    
            $sql .= " WHERE event_id = :id";
    
            $stmt = $this->connection->prepare($sql);
    
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':location', $name);
            $stmt->bindValue(':price', $price);
            $stmt->bindValue(':seats', $seats, PDO::PARAM_INT);
            $stmt->bindValue(':startDate', $startDate);
            $stmt->bindValue(':endDate', $endDate);
    
            if (!empty($picturePath)) {
                $stmt->bindValue(':picture', $picturePath);
            }
    
            $stmt->execute();
    
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    
}