<?php

namespace services;

use repositories\historyrepository;

require_once __DIR__ . '/../repositories/historyrepository.php';


class HistoryService
{
    private $historyRepo;

    public function __construct()
    {
        $this->historyRepo = new Historyrepository();
    }

    public function getEventDetails() {
        return $this->historyRepo->getEventDetails();
    }

    public function getTickets($eventId) {
        return $this->historyRepo->getTicketsForEvent($eventId);
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

}
