<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use model\Event;
use model\Ticket;


require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/event.php';
require_once __DIR__ . '/../model/ticket.php';

class historyrepository extends dbconfig
{
    public function getEventDetails($eventID = "8")
    {
        $sql = 'SELECT * FROM [Event] WHERE event_id = :eventID';

        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':eventID', $eventID, PDO::PARAM_INT);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, Event::class);
            $event = $stmt->fetch();

            return $event;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }


    public function addTimeSlot($restaurantId, $ticket_hash, $date, $time, $quantity) {
        $getEventIdSql = "SELECT event_id FROM Event WHERE restaurant_id = :restaurantId LIMIT 1";
    
        try {
            $getEventIdStmt = $this->connection->prepare($getEventIdSql);
            $getEventIdStmt->bindValue(':restaurantId', $restaurantId, PDO::PARAM_INT);
            $getEventIdStmt->execute();
            
            $eventId = $getEventIdStmt->fetchColumn();
            
            if (!$eventId) {
                echo "<script>alert('No event found for the specified restaurant ID.');</script>";
                return false;
            }
    
            $checkSql = "SELECT COUNT(*) FROM Ticket WHERE event_id = :event_id AND Date = :date AND Time = :time";
            $checkStmt = $this->connection->prepare($checkSql);
            $checkStmt->bindValue(':event_id', $eventId, PDO::PARAM_INT);
            $checkStmt->bindValue(':date', $date);
            $checkStmt->bindValue(':time', $time);
            $checkStmt->execute();
    
            if ($checkStmt->fetchColumn() > 0) {
                echo "<script>alert('A timeslot with the same date and time already exists.');</script>";
                return false;
            }
    
            $insertSql = "INSERT INTO Ticket (event_id, ticket_hash, date, time, quantity, state) 
                          VALUES (:event_id, :ticket_hash, :date, :time, :quantity, 'Not Used')";
            $insertStmt = $this->connection->prepare($insertSql);
            $insertStmt->bindValue(':event_id', $eventId, PDO::PARAM_INT);
            $insertStmt->bindValue(':ticket_hash', $ticket_hash);
            $insertStmt->bindValue(':date', $date);
            $insertStmt->bindValue(':time', $time);
            $insertStmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
            $insertStmt->execute();
    
            return true;
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "');</script>";
            return false;
        }
    }
    
    

    public function existEvent($newEventName, $eventId){
        $sql = "SELECT COUNT(*) FROM [Event] WHERE name = :name AND event_id != :eventId";
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':name', $newEventName, PDO::PARAM_STR);
            $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
            $stmt->execute();
    
            $count = $stmt->fetchColumn();
            return $count > 0 ? false : true;
        } catch (PDOException $e) {
            error_log(''. $e->getMessage());
            return false; 
        }
    }
    
    public function editEventDetails($eventId, $eventName, $startDate, $endDate, $price, $newLocation, $picture){
        $sql = "UPDATE Event SET 
                    name = :eventName, 
                    startDate = :startDate,  
                    endDate = :endDate, 
                    location = :location, 
                    price = :price,
                    picture = :picture
                WHERE event_id = :eventId";
    
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':eventName', $eventName, PDO::PARAM_STR);
            $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
            $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
    
            // Ensure $price is a string
            $price = trim($price);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
    
            $stmt->bindParam(':location', $newLocation, PDO::PARAM_STR);
            $stmt->bindParam(':picture', $picture, PDO::PARAM_STR);
            $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
    
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error updating event details: " . $e->getMessage());
            return false;
        }
    }
    
    
    public function removeTimeslot($ticketID){
        $sql = "DELETE FROM [Ticket] WHERE ticket_id = :ticketid AND user_id IS NULL;";
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':ticketid', $ticketID, PDO::PARAM_INT);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log(''. $e->getMessage());
            return false; 
        }
    }
    
    



}