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
    






}