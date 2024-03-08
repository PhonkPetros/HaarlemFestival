<?php
namespace repositories;
use config\dbconfig;
use PDO;
use PDOException;
use model\Event;
use model\Ticket;
require_once __DIR__ .'/../config/dbconfig.php';
require_once __DIR__ . '/../model/event.php';
require_once __DIR__ . '/../model/ticket.php';

Class Jazzrepository extends dbconfig{

    public function  getEventdetails($eventid = "6"){

        $sql = 'SELECT* FROM[EVENT] WHERE event_id = :eventid;';

        try{
            $stmt = $this->getConnection()->prepare($sql);
            $stmt -> bindParam(':eventid',$eventid,PDO::PARAM_INT);
            $stmt-> execute();
            
            $stmt->setFetchMode(PDO::FETCH_CLASS, Event::class);
            $event = $stmt->fetch();
            return $event;

        }catch(PDOException $e){
            echo "Error: ". $e->getMessage();
            return null;

        }
    }

public function addNewTimeSlot( Ticket $newTicket){

$checkSql = "SELECT COUNT(*) FROM Ticket WHERE event_id = :event_id AND Date = :date AND Time = :time ";

    try{

        $checkstmt = $this->getConnection()->prepare($checksql);
        $checkStmt->bindValue(':event_id', $newTicket->getEventId());
        $checkStmt->bindValue(':date', $newTicket->getTicketDate());
        $checkStmt->bindValue(':time', $newTicket->getTicketTime());
        //$checkStmt->bindValue(':language', $newTicket->getTicketLanguage());
        $checkStmt->execute();

        $existingTicketCount = $checkStmt->fetchColumn();
    
        if ($existingTicketCount > 0) {
            error_log("A ticket with the same date, time, and language already exists.");
            return false;
        }

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
public function editEventDetails($eventId, $eventName, $startDate, $price, $newLocation){
    $sql = "UPDATE Event SET 
                name = :eventName, 
                startDate = :startDate,  
                endDate = :endDate, 
                location = :location, 
                price = :price,
                /*picture = :picture */
            WHERE event_id = :eventId";

    try {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':eventName', $eventName, PDO::PARAM_STR);
        $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
       // $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':location', $newLocation, PDO::PARAM_STR);
       // $stmt->bindParam(':picture', $picture, PDO::PARAM_STR);
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

}
