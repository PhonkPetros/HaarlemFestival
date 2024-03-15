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

    public function getTicketTimeslotsForRestaurant() {
        $timeslots = [];
    
        try {
            $stmt = $this->connection->prepare("SELECT [Event].event_id, [Event].[location], Ticket.[Date], Ticket.[Time], Ticket.quantity FROM [Event] JOIN Ticket ON [Event].event_id = Ticket.event_id WHERE [Event].[name] = :eventName");
    
            $stmt->bindValue(':eventName', 'Restaurant');
    
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
    

    
    
    
}