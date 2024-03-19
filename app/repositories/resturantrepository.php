<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use DateTime;
use model\Resturant;
use model\Ticket;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/resturant.php';
require_once __DIR__ . '/../model/ticket.php';


class resturantrepository extends dbconfig {

    public function getRestaurant($eventId) {
        $restaurants = [];
        try {
            $stmt = $this->connection->prepare(
                "SELECT *
                FROM Restaurant
                JOIN Event ON Event.restaurant_id = Restaurant.resturant_id
                WHERE Event.event_id = :event_id"
            );
            $stmt->bindValue(':event_id', $eventId);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($results as $result) {
                $restaurant = new \model\Restaurant();
                $restaurant->setId($result['restaurant_id']);
                $restaurant->setDescription($result['description']);
                $restaurant->setSeats($result['seats']);
                $restaurant->setName($result['name']);
                $restaurant->setStartDate($result['startDate']);
                $restaurant->setLocation($result['location']);
                $restaurant->setPrice($result['price']);
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

    public function getAllRestaurants() {
        $restaurants = [];
        try {
            $stmt = $this->connection->prepare(
                "SELECT *
                FROM Restaurant
                JOIN Event ON Event.restaurant_id = Restaurant.resturant_id"
            );
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($results as $result) {
                $restaurant = new \model\Restaurant();
                $restaurant->setId($result['restaurant_id']);
                $restaurant->setDescription($result['description']);
                $restaurant->setSeats($result['seats']);
                $restaurant->setName($result['name']);
                $restaurant->setStartDate($result['startDate']);
                $restaurant->setLocation($result['location']);
                $restaurant->setPrice($result['price']);
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


    public function getTicketTimeslotsForResturant($id) {
        $times = [];
        try {
            $stmt = $this->connection->prepare("SELECT [Time] FROM [Ticket] WHERE event_id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($results as $result) {
                $times[] = $result['time'];
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
        return $times;
    }
    
    public function addTimeSlot($restaurantId, $ticket_hash, $date, $time, $quantity) {
        try {
            $stmt = $this->connection->prepare("INSERT INTO [Ticket] (event_id, ticket_hash, date, time, quantity, state) VALUES (:restaurantId, :ticket_hash, :date, :time, :quantity, :state)");
    
            $stmt->bindValue(':restaurantId', $restaurantId, PDO::PARAM_INT);
            $stmt->bindValue(':ticket_hash', $ticket_hash);
            $stmt->bindValue(':date', $date);
            $stmt->bindValue(':time', $time);
            $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindValue(':state', 'Not Used');
    
            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getTicketTimeslotsForRestaurant($eventId) {
        $timeslots = [];
    
        try {
            $sql = "SELECT * 
                    FROM Restaurant 
                    JOIN Event ON Event.restaurant_id = Restaurant.restaurant_id 
                    JOIN Ticket ON Ticket.event_id = Event.event_id 
                    WHERE Ticket.event_id = :eventId";
    
            $stmt = $this->connection->prepare($sql);
    
            $stmt->bindValue(':eventId', $eventId);
    
            $stmt->execute();
    
            $ticketResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($ticketResults as $ticketResult) {
                $ticket = new \model\Ticket();
                $ticket->setEventId($ticketResult['event_id']);
                $ticket->setQuantity($ticketResult['quantity']);
                $ticket->setTicketDate($ticketResult['Date']);
                $ticket->setTicketTime($ticketResult['Time']);
    
                $timeslots[] = $ticket;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    
        return $timeslots;
    }
    


    public function getRestaurantByIdWithTimeslots($restaurantId) {
        $restaurantDetails = null;
        try {
            $stmt = $this->connection->prepare(
                "SELECT [Event].*, Ticket.ticket_hash, Ticket.date AS ticket_date, Ticket.time AS ticket_time, Ticket.quantity 
                FROM [Event] 
                LEFT JOIN Ticket ON [Event].event_id = Ticket.event_id 
                WHERE [Event].event_id = :restaurantId AND [Event].name = 'Restaurant'"
            );
    
            $stmt->bindValue(':restaurantId', $restaurantId, PDO::PARAM_INT);
            $stmt->execute();
    
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $timeslots = [];
            
            if ($results) {
                foreach ($results as $result) {
                    if (!$restaurantDetails) {
                        $restaurantDetails = new \model\Restaurant();
                        $restaurantDetails->setId($result['event_id']);
                        $restaurantDetails->setLocation($result['location']);
                        $restaurantDetails->setPrice($result['price']);
                        $restaurantDetails->setSeats(isset($result['seats']) ? (int)$result['seats'] : null);
                        $restaurantDetails->setStartDate($result['startDate']);
                        $restaurantDetails->setEndDate($result['endDate']);
                        $restaurantDetails->setPicture($result['picture']);
                    }
                    
                    if ($result['ticket_hash']) { 
                        $ticket = new \model\Ticket();
                        $ticket->setEventId($result['event_id']);
                        $ticket->setTicketHash($result['ticket_hash']);
                        $ticket->setTicketDate($result['ticket_date']);
                        $ticket->setTicketTime($result['ticket_time']);
                        $ticket->setQuantity($result['quantity']);
                        $timeslots[] = $ticket;
                    }
                }
    
                
            }
    
            return $restaurantDetails;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    
    public function addRestaurant($name, $location, $description, $price, $seats, $startDate, $endDate, $picturePath) {
        if (empty($name) || empty($location) || empty($description) || empty($price)) {
            return false;
        }
        try {
            $this->connection->beginTransaction();
    
            $stmt = $this->connection->prepare("INSERT INTO Restaurant ([description], seats) VALUES (:description, :seats)");
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':seats', $seats);
            $stmt->execute();
            $restaurantId = $this->connection->lastInsertId();
    
            $stmt = $this->connection->prepare("INSERT INTO [Event] ([name], startDate, location, price, endDate, picture, restaurant_id) 
            VALUES (:name, :startDate, :location, :price, :endDate, :picture, :restaurantId)");
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':startDate', $startDate);
            $stmt->bindValue(':location', $location);
            $stmt->bindValue(':price', $price);
            $stmt->bindValue(':endDate', $endDate);
            $stmt->bindValue(':picture', $picturePath);
            $stmt->bindValue(':restaurantId', $restaurantId);
            $stmt->execute();
            $this->connection->commit();
    
            return true; 
        } catch (PDOException $e) {
            $this->connection->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}