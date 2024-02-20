<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use DateTime;
use model\Event;
use model\Ticket;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/event.php';
require_once __DIR__ . '/../model/ticket.php';

class historyrepository extends dbconfig
{
    public function getEventDetails($eventName = "history")
    {
        $sql = 'SELECT * FROM [Event] WHERE name = :eventName';

        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':eventName', $eventName, PDO::PARAM_STR);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, Event::class);
            $event = $stmt->fetch();

            return $event;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function getTicketsForEvent($eventId)
    {
        $sql = 'SELECT * FROM [Ticket] WHERE event_id = :event_id';

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

    public function addNewTimeSlot(Ticket $newTicket)
    {
        $checkSql = "SELECT COUNT(*) FROM Ticket WHERE event_id = :event_id AND Date = :date AND Time = :time";
    
        try {
            $checkStmt = $this->getConnection()->prepare($checkSql);
            $checkStmt->bindValue(':event_id', $newTicket->getEventId());
            $checkStmt->bindValue(':date', $newTicket->getTicketDate());
            $checkStmt->bindValue(':time', $newTicket->getTicketTime());
            $checkStmt->execute();

            $existingTicketCount = $checkStmt->fetchColumn();

            if ($existingTicketCount > 0) {
                error_log("A ticket with the same date and time already exists.");
                return false;
            }

            $insertSql = "INSERT INTO Ticket (quantity, ticket_hash, state, event_id, language, Date, Time)
                          VALUES (:quantity, :ticket_hash, :state, :event_id, :language, :date, :time)";
    
            $insertStmt = $this->getConnection()->prepare($insertSql);
            $insertStmt->bindValue(':quantity', $newTicket->getQuantity());
            $insertStmt->bindValue(':ticket_hash', $newTicket->getTicketHash());
            $insertStmt->bindValue(':state', $newTicket->getState());
            $insertStmt->bindValue(':event_id', $newTicket->getEventId());
            $insertStmt->bindValue(':language', $newTicket->getTicketLanguage());
            $insertStmt->bindValue(':date', $newTicket->getTicketDate());
            $insertStmt->bindValue(':time', $newTicket->getTicketTime());
            $insertStmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }
    



}