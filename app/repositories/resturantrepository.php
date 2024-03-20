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
    
    
    
    public function updateRestaurantDetails($id, $name, $price, $seats, $startDate, $endDate, $picturePath, $description, $location) {
        try {
            $price = max(0, floatval($price));
            $seats = max(0, intval($seats));
    
            $sqlRestaurant = "UPDATE Restaurant SET description = :description, seats = :seats";
            $sqlRestaurant .= " WHERE resturant_id = :id";
    
            $stmtRestaurant = $this->connection->prepare($sqlRestaurant);
            $stmtRestaurant->bindValue(':id', $id, PDO::PARAM_INT);
            $stmtRestaurant->bindValue(':description', $description);
            $stmtRestaurant->bindValue(':seats', $seats, PDO::PARAM_INT);
            $stmtRestaurant->execute();
            
            $sqlEvent = "UPDATE Event SET name = :name, location = :location, price = :price, startDate = :startDate, endDate = :endDate";
            if (!empty($picturePath)) {
                $sqlEvent .= ", picture = :eventPicture";
            }
            $sqlEvent .= " WHERE restaurant_id = :id";
    
            $stmtEvent = $this->connection->prepare($sqlEvent);
            $stmtEvent->bindValue(':id', $id, PDO::PARAM_INT);
            $stmtEvent->bindValue(':name', $name);
            $stmtEvent->bindValue(':location', $location);
            $stmtEvent->bindValue(':price', $price);
            $stmtEvent->bindValue(':startDate', $startDate);
            $stmtEvent->bindValue(':endDate', $endDate);
            if (!empty($picturePath)) {
                $stmtEvent->bindValue(':eventPicture', $picturePath);
            }
            $stmtEvent->execute();
    
            return true;
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

    public function getTimeslotsForRestaurant($eventId) {
        $tickets = []; // To store the full ticket details, not just timeslots.
        try {
            $stmt = $this->connection->prepare(
                "SELECT ticket_id, ticket_hash, date AS ticket_date, time AS ticket_time, quantity 
                FROM Ticket 
                WHERE event_id = :event_id"
            );
            $stmt->bindValue(':event_id', $eventId, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($results as $result) {
                $ticket = new \model\Ticket();
                $ticket->setEventId($eventId); // Assuming you have such a setter; if not, you may need to adjust.
                $ticket->setTicketId($result['ticket_id']); // Assuming you add this setter to your Ticket model
                $ticket->setTicketHash($result['ticket_hash']);
                $ticket->setTicketDate($result['ticket_date']);
                $ticket->setTicketTime($result['ticket_time']);
                $ticket->setQuantity($result['quantity']);
                $tickets[] = $ticket;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
        return $tickets;
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