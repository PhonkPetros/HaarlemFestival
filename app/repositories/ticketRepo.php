<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use model\Event;
use model\Ticket;
use model\User;


require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/event.php';
require_once __DIR__ . '/../model/ticket.php';
require_once __DIR__ . '/../model/user.php';

class TicketRepo extends dbconfig
{

    public function getTicketsForEvent($eventId)
    {
        $sql = 'SELECT * FROM [Ticket] WHERE event_id = :event_id  AND user_id IS NULL;';

        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
            $stmt->execute();


            $ticketsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $tickets = [];
            foreach ($ticketsData as $ticketData) {
                $ticket = new Ticket();
                $ticket->setTicketId($ticketData['ticket_id']);
                $ticket->setUserId($ticketData['user_id'] ?? null);
                $ticket->setQuantity($ticketData['quantity']);
                $ticket->setTicketHash($ticketData['ticket_hash']);
                $ticket->setState($ticketData['state']);
                $ticket->setEventId($ticketData['event_id']);
                $ticket->setTicketLanguage($ticketData['language']);
                $ticket->setTicketDate($ticketData['Date']);
                $ticket->setTicketTime($ticketData['Time']);
                $ticket->setTicketEndTime($ticketData['endtime']);

                $tickets[] = $ticket;
            }

            return $tickets;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    public function getTicketImage($eventId)
    {
        $sql = 'SELECT picture FROM [Event] WHERE event_id = :event_id;';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['picture'] : null;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    public function getEventName($eventId)
    {
        $sql = 'SELECT name FROM [Event] WHERE event_id = :event_id;';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['name'] : null;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function getEventDetails($eventId)
    {
        $sql = 'SELECT name, picture, location FROM [Event] WHERE event_id = :event_id;';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result : null;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }


    public function getTicketPrice($eventID)
    {
        $sql = 'SELECT price FROM [Event] WHERE event_id = :eventID';

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

    public function getTicketQuantity($ticketID)
    {
        $sql = 'SELECT quantity FROM [Ticket] WHERE ticket_id = :ticketID';
    
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':ticketID', $ticketID, PDO::PARAM_INT);
            $stmt->execute();
    
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $event = $stmt->fetch();
    
            if ($event) {
                return (int) $event['quantity']; 
            } else {
                return 0; 
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null; 
        }
    }


    public function getReservedTicketsByUserId($userID) {
        // Adjusted SQL to include JOIN with Event table and filter by 'Reserved' state
        $sql = 'SELECT Ticket.*, Event.* FROM Ticket 
                JOIN Event ON Event.event_id = Ticket.event_id 
                WHERE Ticket.user_id = :userID AND Ticket.state = \'Reserved\'';
    
        $tickets = [];
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':userID', $userID, \PDO::PARAM_INT);
            $stmt->execute();
    
            $ticketsData = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
            foreach ($ticketsData as $ticketData) {
                $ticket = new Ticket();
                $ticket->setTicketId($ticketData['ticket_id']);
                $ticket->setUserId($ticketData['user_id']);
                $ticket->setQuantity($ticketData['quantity']);
                $ticket->setTicketHash($ticketData['ticket_hash']);
                $ticket->setState($ticketData['state']);
                $ticket->setEventId($ticketData['event_id']);
                $ticket->setTicketDate($ticketData['Date']); 
                $ticket->setTicketTime($ticketData['Time']);
                $ticket->setPrice($ticketData['price']);
                $ticket->setSpecialRequest($ticketData['special_request']);
    
                $tickets[] = $ticket;
            }
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        return $tickets;
    }
    

    public function getUserDetails($userID) {
        $sql = 'SELECT * FROM [User] WHERE user_id = :userID';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':userID', $userID, \PDO::PARAM_INT);
            $stmt->execute();

            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
            $userDetails = $stmt->fetch();

            if (!$userDetails) {
                return null;
            }

            $user = new \model\User();
            $user->setUserID($userDetails['user_id']);
            $user->setUserEmail($userDetails['email']);
            $user->setUsername($userDetails['username']);
            $user->setPassword($userDetails['password_hash']);
            $user->setUserRole($userDetails['role']);
            $user->setRegistrationDate($userDetails['created_at']);
            $user->setFirstname($userDetails['firstname']);
            $user->setLastname($userDetails['lastname']);
            $user->setAddress($userDetails['address']);
            $user->setPhoneNumber($userDetails['phone_number']);

            return $user;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function getReservation($eventID){
        $sql = 'SELECT * FROM [OrderItems] WHERE event_id = :eventID;';
    
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':eventID', $eventID, PDO::PARAM_INT);
            $stmt->execute();
    
            $reservationData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $reservationData;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function updateReservationStatus($orderId, $newStatus){
        $sql = 'UPDATE [OrderItems] SET status = :newStatus WHERE order_id = :orderId;';
    
        try {
            $stmt = $this->getConnection()->prepare($sql);
    
            $stmt->bindParam(':newStatus', $newStatus, PDO::PARAM_STR);
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return true; // Update successful
            } else {
                return false; // No rows updated, possibly because the order ID was not found
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Indicate failure
        }
    }
    
    

}