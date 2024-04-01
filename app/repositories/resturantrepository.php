<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use DateTime;
use model\Resturant;
use model\Ticket;
use repositories\Pagerepository;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/resturant.php';
require_once __DIR__ . '/../model/ticket.php';
require_once __DIR__ . '/../repositories/pagerepository.php';


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
            $checkEventStmt = $this->connection->prepare("SELECT event_id FROM [Event] WHERE restaurant_id = :restaurantId");
            $checkEventStmt->bindValue(':restaurantId', $restaurantId, PDO::PARAM_INT);
            $checkEventStmt->execute();
            
            $eventRow = $checkEventStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$eventRow) {
                echo "Error: No events found for the provided restaurant ID.";
                return false;
            }
            
            $eventId = $eventRow['event_id'];
            
            $insertStmt = $this->connection->prepare("INSERT INTO [Ticket] (event_id, ticket_hash, date, time, quantity, state) VALUES (:event_id, :ticket_hash, :date, :time, :quantity, :state)");
            $insertStmt->bindValue(':event_id', $eventId, PDO::PARAM_INT); 
            $insertStmt->bindValue(':ticket_hash', $ticket_hash);
            $insertStmt->bindValue(':date', $date);
            $insertStmt->bindValue(':time', $time);
            $insertStmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
            $insertStmt->bindValue(':state', 'Not Used');
            $insertStmt->execute();
            
            return $insertStmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    
    
    
    

    public function getTimeslotsForRestaurant($eventId) {
        $tickets = [];
        try {
            $stmt = $this->connection->prepare(
                "SELECT ticket_id, ticket_hash, date, time, quantity 
                FROM Ticket 
                WHERE event_id = :event_id"
            );
            $stmt->bindValue(':event_id', $eventId, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($results as $result) {
                $ticket = new \model\Ticket();
                $ticket->setEventId($eventId);
                $ticket->setTicketId($result['ticket_id']);
                $ticket->setTicketHash($result['ticket_hash']);
                $ticket->setTicketDate($result['date']); 
                $ticket->setTicketTime($result['time']);
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
        $timeslots = [];
    
        try {
            // Fetch restaurant and event details
            $stmt = $this->connection->prepare(
                "SELECT *
                 FROM Restaurant 
                 JOIN [Event] ON Restaurant.resturant_id = [Event].restaurant_id
                 WHERE Restaurant.resturant_id = :restaurantId"
            );
    
            $stmt->bindValue(':restaurantId', $restaurantId, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if ($results) {
                foreach ($results as $result) {
                    if (!$restaurantDetails) {
                        $restaurantDetails = new \model\Restaurant();
                        $restaurantDetails->setId($result['resturant_id'] ?? '');
                        $restaurantDetails->setLocation($result['location'] ?? '');
                        $restaurantDetails->setPrice($result['price'] ?? 0); // Assuming 0 is a sensible default for price
                        $restaurantDetails->setSeats(isset($result['seats']) ? (int)$result['seats'] : null);
                        $restaurantDetails->setStartDate($result['startDate'] ?? '');
                        $restaurantDetails->setEndDate($result['endDate'] ?? '');
                        $restaurantDetails->setPicture($result['picture'] ?? '');
                        $restaurantDetails->setEventId($result['event_id'] ?? '');
                    }
            
                    $ticketStmt = $this->connection->prepare("SELECT * FROM Ticket WHERE event_id = :eventId");
                    $ticketStmt->bindValue(':eventId', $restaurantDetails->getEventId(), PDO::PARAM_INT);
                    $ticketStmt->execute();
                    $ticketResults = $ticketStmt->fetchAll(PDO::FETCH_ASSOC);
            
                    foreach ($ticketResults as $ticketResult) {
                        $ticket = new \model\Ticket();
                        $ticket->setEventId($ticketResult['event_id'] ?? '');
                        $ticket->setTicketId($ticketResult['ticket_id'] ?? '');
                        $ticket->setTicketHash($ticketResult['ticket_hash'] ?? '');
                        $ticket->setTicketDate($ticketResult['Date'] ?? '');
                        $ticket->setTicketTime($ticketResult['Time'] ?? '');
                        $ticket->setQuantity($ticketResult['quantity'] ?? '');
                        $timeslots[] = $ticket;
                    }
                }
            }
            
            return ['restaurantDetails' => $restaurantDetails, 'timeslots' => $timeslots];
            
    
            return ['restaurantDetails' => $restaurantDetails, 'timeslots' => $timeslots];
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
            
            $pageRepository = new Pagerepository();
            $content = include __DIR__ . '/../config/resurantDefaultContent.php';
            $pageId = $pageRepository->createResturantPage($name, $content);
    
            $stmtRestaurant = $this->connection->prepare("INSERT INTO Restaurant (description, seats, page_id) VALUES (:description, :seats, :pageId)");
            $stmtRestaurant->bindValue(':description', $description);
            $stmtRestaurant->bindValue(':seats', $seats);
            $stmtRestaurant->bindValue(':pageId', $pageId);
            $stmtRestaurant->execute();
            $restaurantId = $this->connection->lastInsertId();
    
            $stmtEvent = $this->connection->prepare("INSERT INTO Event (name, startDate, location, price, endDate, picture, restaurant_id) 
            VALUES (:name, :startDate, :location, :price, :endDate, :picture, :restaurantId)");
            $stmtEvent->bindValue(':name', $name);
            $stmtEvent->bindValue(':startDate', $startDate);
            $stmtEvent->bindValue(':location', $location);
            $stmtEvent->bindValue(':price', $price);
            $stmtEvent->bindValue(':endDate', $endDate);
            $stmtEvent->bindValue(':picture', $picturePath);
            $stmtEvent->bindValue(':restaurantId', $restaurantId);
            $stmtEvent->execute();
            $this->connection->commit();
    
            return true; 
        } catch (PDOException $e) {
            $this->connection->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function deleteRestaurant($restaurantId) {
        try {
            $this->connection->beginTransaction();
    
            $stmtDeleteRestaurant = $this->connection->prepare("DELETE FROM Restaurant WHERE resturant_id = :restaurantId");
            $stmtDeleteRestaurant->bindValue(':restaurantId', $restaurantId, PDO::PARAM_INT);
            $stmtDeleteRestaurant->execute();
    
            $this->connection->commit();
    
            return true;
        } catch (PDOException $e) {
            $this->connection->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function deleteTimeslot($ticket_hash){
        try {
            $stmt = $this->connection->prepare("DELETE FROM Ticket WHERE ticket_hash = :ticket_hash");
            $stmt->bindValue(':ticket_hash', $ticket_hash);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }

    }

    public function addReservation($ticket_id, $user_id, $specialRequest, $address, $firstName, $lastName, $phoneNumber) {
        try {
            $this->connection->beginTransaction();
            
            $stmtTicket = $this->connection->prepare("
                UPDATE Ticket 
                SET user_id = :user_id, 
                    state = 'Reserved', 
                    special_request = :specialRequest
                WHERE ticket_id = :ticket_id");
            $stmtTicket->bindValue(':ticket_id', $ticket_id);
            $stmtTicket->bindValue(':user_id', $user_id);
            $stmtTicket->bindValue(':specialRequest', $specialRequest);
            $stmtTicket->execute();
            
            $stmtUser = $this->connection->prepare("
                UPDATE [User] 
                SET address = :address, 
                    firstname = :firstname, 
                    lastname = :lastname, 
                    phone_number = :phone_number
                WHERE user_id = :user_id");
            $stmtUser->bindValue(':user_id', $user_id);
            $stmtUser->bindValue(':address', $address);
            $stmtUser->bindValue(':firstname', $firstName);
            $stmtUser->bindValue(':lastname', $lastName);
            $stmtUser->bindValue(':phone_number', $phoneNumber);
            $stmtUser->execute();
            
            $this->connection->commit();
            
            return true;
        } catch (PDOException $e) {
            $this->connection->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    



}