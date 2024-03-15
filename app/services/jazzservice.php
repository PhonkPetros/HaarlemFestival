<?php
namespace services;
use repositories\Jazzrepository;
require_once __DIR__.'/../repositories/jazzrepository.php';

class Jazzservice{
    private $jazzrepo;

    public function __construct()
    {
        $this->jazzrepo = new Jazzrepository();
    }

    public function getEventDetails()
    {
        return $this->jazzrepo->getEventdetails();
    }
    public function getTickets($eventId) {
        return $this->jazzrepo->getTicketsForEvent($eventId);
    }

    public function addNewTimeSlot($newTicket){
        $this->jazzrepo->addNewTimeSlot($newTicket);
    }
    public function editEventDetails($eventId, $eventName, $startDate,$endDate, $price, $newLocation,$picture){
        return $this->jazzrepo->editEventDetails($eventId, $eventName, $startDate,$endDate, $price, $newLocation, $picture);
    }
    public function existEvent($newEventName, $eventId){
        return $this->jazzrepo->existEvent($newEventName, $eventId);
    }
    public function removeTimeslot($ticketID){
        $this->jazzrepo->removeTimeslot($ticketID);
    }

}
