<?php

namespace controllers;

use model\Ticket;
use services\historyService;
use Exception;
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
        $eventDetails = $this->historyService->getEventDetails();
        $structuredTickets = $this->getStructuredTickets($eventDetails->getEventId());
        $uniqueTimes = $this->getUniqueTimes($structuredTickets);
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

    public function showeditEventDetails()
    {
        $eventDetails = $this->historyService->getEventDetails();
        $eventId = $eventDetails->getEventId();
        $eventTickets = $this->historyService->getTickets($eventId);
        require_once __DIR__ . '/../views/admin/manage-event-details/editDetailsHistory.php';
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

            $result = $this->historyService->addNewTimeSlot($newTicket);


            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Timeslot added successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add timeslot.']);
            }
            exit;
        }
    }

    public function editEventDetails()
    {
        try {
            $eventId = htmlspecialchars($_POST['event_id'] ?? null);
            $newEventName = htmlspecialchars($_POST['name'] ?? null);
            $newStartDate = htmlspecialchars($_POST['startDate'] ?? null);
            $newEndDate = htmlspecialchars($_POST['endDate'] ?? null);
            $newLocation = htmlspecialchars($_POST['location'] ?? null);
            $newPrice = htmlspecialchars($_POST['price'] ?? null);
            $relativeUploadPath = null;
            $uploadDirectory = '/img/EventImages/';
            $relativeUploadPath = $this->uploadImage($_FILES['image'] ?? null, $uploadDirectory);

            $result = $this->historyService->editEventDetails($eventId, $newEventName, $newStartDate, $newEndDate, $newPrice, $newLocation, $relativeUploadPath);

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
        $tickets = $this->historyService->getTickets($eventId);
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
}