<?php

namespace services;
use repositories\TicketRepo;

require_once __DIR__ . "/../repositories/ticketRepo.php"; 

class ticketservice {

    private $ticketRepo;

    public function __construct() {
        $this->ticketRepo = new TicketRepo(); 
    }

    function getTicketImage($eventID){
        return $this->ticketRepo->getTicketImage($eventID);
    }

    function getEventName($eventId){
        return $this->ticketRepo->getEventName($eventId);
    }

    function getEventDetails($eventId){
        return $this->ticketRepo->getEventDetails($eventId);
    }

    function getTicketQuantity($ticketID){
        return $this->ticketRepo->getTicketQuantity($ticketID);
    }

    function getReservedTicketsByUserId($userID) {
        return $this->ticketRepo->getReservedTicketsByUserId($userID);
    }

    function getUserDetails($userID){
        return $this->ticketRepo->getUserDetails($userID);
    }

    function getReservations($eventID){
        return $this->ticketRepo->getReservation($eventID);
    }
    function updateReservationStatus($orderId, $newStatus){
        return $this->ticketRepo->updateReservationStatus($orderId, $newStatus);
    }
}
