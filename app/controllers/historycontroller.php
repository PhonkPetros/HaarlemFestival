<?php

namespace controllers;

use model\Ticket;
use services\historyService;
use model\Event;

require_once __DIR__ . '/../model/event.php';
require_once __DIR__ . '/../services/historyservice.php';

class Historycontroller
{
    private $historyService;
    private $event;
    public function __construct()
    {
        $this->historyService = new HistoryService();
        $this->event = new Event();
    }

    public function show()
    {
        require_once __DIR__ . '/../views/history/overview.php';
    }

    public function showProveniershof()
    {
        require_once __DIR__ . '/../views/history/proveniershof.php';
    }

    public function showChurch()
    {
        require_once __DIR__ . '/../views/history/churchbravo.php';
    }

    public function editEventDetails()
    {
        $eventDetails = $this->historyService->getEventDetails();
        $eventId = $eventDetails->getEventId();
        $eventTickets = $this->historyService->getTickets($eventId);
        require_once __DIR__ . '/../views/admin/manage-event-details/editDetailsHistory.php';
    }
    

    public function addNewTimeSlot()
{
    $eventId = htmlspecialchars($_POST['event_id'] ?? null);
    $date = htmlspecialchars($_POST['date'] ?? null);
    $quantity = htmlspecialchars($_POST['quantity'] ?? null);
    $language = htmlspecialchars($_POST['language'] ?? null);
    $time = htmlspecialchars($_POST['time'] ?? null);
    $state = "Not Used";

    $newTicket = new Ticket();
    $newTicket->setEventId($eventId);
    $newTicket->setTicketDate($date);
    $newTicket->setQuantity($quantity);
    $newTicket->setTicketLanguage($language);
    $newTicket->setTicketTime($time);
    $newTicket->setState('Not Used');
    $newTicket->setTicketHash($this->generateTicketHash($eventId, $date, $time));
    
   
    $result = $this->historyService->addNewTimeSlot($newTicket);
    
   
    header('Content-Type: application/json');
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Timeslot added successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add timeslot.']);
    }
    exit;
}

    
    
    private function generateTicketHash($eventId, $date, $time) {
        $toHash = $eventId . $date . $time . uniqid('', true);
        return hash('sha256', $toHash);
    }
}