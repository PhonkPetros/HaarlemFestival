<?php

namespace controllers;

use model\Ticket;
use Exception;
use model\Event;
use controllers\Navigationcontroller;
use controllers\Pagecontroller;
use services\Jazzservice;


class Jazzcontroller
{
    private $jazzservice;
    private $navigationController;
    private $event;
    public function __construct() {
        $this->navigationController = new NavigationController();
        $this->jazzservice = new Jazzservice();
        $this->event = new Event();

    }

    public function show()
    {
        $eventDetails = $this->jazzservice->getEventDetails();
        $navigation = $this->navigationController->displayHeader();  
        $structuredTickets = $this->getStructuredTickets($eventDetails->getEventId());
        $uniqueTimes = $this->getUniqueTimes($structuredTickets);  
        require_once __DIR__ ."/../views/jazz/overview.php";
        
    }

    public function showEventDetails(){
        $eventDetails = $this->jazzservice->getEventDetails();
        $eventid = $eventDetails->getEventId();
        $eventTickets = $this->jazzservice->getTickets($eventid);
        require_once __DIR__ . '/../views/admin/manage-event-details/editDetailsJazz.php';
    }
    public function editEventDetails()
    {
        try {
        $eventId = isset($_POST['event_id']) ? htmlspecialchars($_POST['event_id']) : null;
        $newEventName = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : null;
        $newStartDate = isset($_POST['startDate']) ? htmlspecialchars($_POST['startDate']) : null;
        $newEndDate = isset($_POST['endDate']) ? htmlspecialchars($_POST['endDate']) : null;
        $newLocation = isset($_POST['location']) ? htmlspecialchars($_POST['location']) : null;
        $newPrice = isset($_POST['price']) ? htmlspecialchars($_POST['price']) : null;


            $currentEventDetails = $this->jazzservice->getEventDetails();
            $existingPicturePath = $currentEventDetails->getPicture();

            $uploadDirectory = '/img/EventImages/';
            $relativeUploadPath = $this->uploadImage($_FILES['image'] ?? null, $uploadDirectory);

            if ($relativeUploadPath === null) {
                $relativeUploadPath = $existingPicturePath;
            }
        

            $result = $this->jazzservice->editEventDetails($eventId, $newEventName, $newStartDate,$newEndDate, $newPrice, $newLocation,$relativeUploadPath);////problem

            if (!$result) {
                throw new Exception('Failed to edit Event Details.');
            }

            echo json_encode(['success' => true, 'message' => 'Event Details Edited Successfully.']);

        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
    public function addNewTimeSlot()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventId = htmlspecialchars($_POST['event_id'] ?? null);
            $date = htmlspecialchars($_POST['date'] ?? null);
            $quantity = htmlspecialchars($_POST['quantity'] ?? null);
            $language = htmlspecialchars($_POST['language'] ?? null);
            $time = htmlspecialchars($_POST['time'] ?? null);

            $newTicket = new Ticket();
            $newTicket->setEventId($eventId);
            $newTicket->setTicketDate($date);
            $newTicket->setQuantity($quantity);
            $newTicket->setTicketLanguage($language);
            $newTicket->setTicketTime($time);
            $newTicket->setState('Not Used');
            $newTicket->setTicketHash($this->generateTicketHash($eventId, $date, $time));

            $result = $this->jazzservice->addNewTimeSlot($newTicket);


            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Timeslot added successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add timeslot.']);
            }
            exit;
        }
    }
    public function removeTimeslot()
    {
        try {
            $ticketID = htmlspecialchars($_POST['ticket_id'] ?? null);

            $result = $this->jazzservice->removeTimeslot($ticketID);
            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Timeslot removed successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to revmove timeslot.']);
            }
            exit;

        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }

    }
    private function uploadImage($imageFile, $uploadDirectory)
    {
        if (isset($imageFile) && $imageFile['error'] == UPLOAD_ERR_OK) {
            $imageFileName = basename($imageFile['name']);
            $absoluteUploadPath = $_SERVER['DOCUMENT_ROOT'] . $uploadDirectory . $imageFileName;

            if (move_uploaded_file($imageFile['tmp_name'], $absoluteUploadPath)) {
                return $uploadDirectory . $imageFileName;
            } else {
                throw new Exception('Failed to upload image.');
            }
        }
        return null;
    }


    private function generateTicketHash($eventId, $date, $time)
    {
        $toHash = $eventId . $date . $time . uniqid('', true);
        return hash('sha256', $toHash);
    }
    private function getStructuredTickets($eventId)
    {
        $tickets = $this->jazzservice->getTickets($eventId);
        $structuredTickets = [];

        foreach ($tickets as $ticket) {
            $language = $ticket->getTicketLanguage();
            $date = $ticket->getTicketDate();
            $time = $ticket->getTicketTime();
            $quantity = $ticket->getQuantity();

            $structuredTickets[$language][$date][$time] = $quantity;
        }

        return $structuredTickets;
    }

    private function getUniqueTimes($structuredTickets)
    {
        $allTimes = [];

        foreach ($structuredTickets as $dates) {
            foreach ($dates as $times) {
                $allTimes = array_merge($allTimes, array_keys($times));
            }
        }

        $uniqueTimes = array_unique($allTimes);
        sort($uniqueTimes);

        return $uniqueTimes;
    }
    


    public function editContent(){
        require_once __DIR__ ."/../views/admin/page-managment/editJazz.php";
    }

  
}