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

}
