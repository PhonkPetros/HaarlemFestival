<?php

namespace services;

use repositories\historyrepository;
use repositories\TicketRepo;

require_once __DIR__ . '/../repositories/historyrepository.php';
require_once __DIR__ . '/../repositories/ticketRepo.php';

class HistoryService
{
    private $historyRepo;
    private $ticketRepo;

    public function __construct()
    {
        $this->historyRepo = new Historyrepository();
        $this->ticketRepo = new TicketRepo();
    }

    public function getEventDetails($eventID) {
        return $this->historyRepo->getEventDetails($eventID);
    }

    public function getTickets($eventId) {
        return $this->ticketRepo->getTicketsForEvent($eventId);
    }

    public function getTicketPrice($eventId) {
        return $this->ticketRepo->getTicketPrice($eventId);
    }

    public function addNewTimeSlot($newTicket){
        $this->historyRepo->addNewTimeSlot($newTicket);
    }


    public function existEvent($newEventName, $eventId){
        return $this->historyRepo->existEvent($newEventName, $eventId);
    }

    
    public function editEventDetails($eventId, $eventName, $startDate, $endDate, $price, $newLocation, $picture){
        return $this->historyRepo->editEventDetails($eventId, $eventName, $startDate, $endDate, $price, $newLocation, $picture);
    }

    public function removeTimeslot($ticketID){
        $this->historyRepo->removeTimeslot($ticketID);
    }

}
