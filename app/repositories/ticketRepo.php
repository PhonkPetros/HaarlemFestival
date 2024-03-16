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






}