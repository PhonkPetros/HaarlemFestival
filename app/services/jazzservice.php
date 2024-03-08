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
    public function addNewTimeSlot($newTicket){
        $this->jazzrepo->addNewTimeSlot($newTicket);
    }
    public function editEventDetails($eventId, $eventName, $startDate, $price, $newLocation){
        return $this->jazzrepo->editEventDetails($eventId, $eventName, $startDate, $price, $newLocation);
    }
    public function removeTimeslot($ticketID){
        $this->jazzrepo->removeTimeslot($ticketID);
    }

}
