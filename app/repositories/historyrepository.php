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
    public function getEventDetails($eventID)
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


    public function addNewTimeSlot(Ticket $newTicket)
    {
        
        $checkSql = "SELECT COUNT(*) FROM Ticket WHERE event_id = :event_id AND Date = :date AND Time = :time AND language = :language AND endtime = :endTime";
    
        try {
            $checkStmt = $this->getConnection()->prepare($checkSql);
            $checkStmt->bindValue(':event_id', $newTicket->getEventId());
            $checkStmt->bindValue(':date', $newTicket->getTicketDate());
            $checkStmt->bindValue(':time', $newTicket->getTicketTime());
            $checkStmt->bindValue(':language', $newTicket->getTicketLanguage());
            $checkStmt->bindValue(':endTime', $newTicket->getTicketEndTime());
            $checkStmt->execute();
    
            $existingTicketCount = $checkStmt->fetchColumn();
    
            if ($existingTicketCount > 0) {
                error_log("A ticket with the same date, time, and language already exists.");
                return false;
            }
    
            $insertSql = "INSERT INTO Ticket (quantity, ticket_hash, state, event_id, language, Date, Time, endtime)
                          VALUES (:quantity, :ticket_hash, :state, :event_id, :language, :date, :time, :endTime)";
    
            $insertStmt = $this->getConnection()->prepare($insertSql);
            $insertStmt->bindValue(':quantity', $newTicket->getQuantity());
            $insertStmt->bindValue(':ticket_hash', $newTicket->getTicketHash());
            $insertStmt->bindValue(':state', $newTicket->getState());
            $insertStmt->bindValue(':event_id', $newTicket->getEventId());
            $insertStmt->bindValue(':language', $newTicket->getTicketLanguage());
            $insertStmt->bindValue(':date', $newTicket->getTicketDate());
            $insertStmt->bindValue(':time', $newTicket->getTicketTime());
            $insertStmt->bindValue(':endTime', $newTicket->getTicketEndTime());
            $insertStmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
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