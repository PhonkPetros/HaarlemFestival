<?php

namespace controllers;

use model\Ticket;
use services\historyService;
use Exception;
use model\Event;
use controllers\Navigationcontroller;
use controllers\Pagecontroller;

require_once __DIR__ . '/../model/event.php';
require_once __DIR__ . '/../services/historyservice.php';
require_once __DIR__ . '/../controllers/navigationcontroller.php';
require_once __DIR__ . '/../controllers/pagecontroller.php';

class Historycontroller
{
    private $historyService;
    private $navigationController;
    private $pagecontroller;
    private $event;
    public function __construct()
    {
        $this->historyService = new HistoryService();
        $this->navigationController = new Navigationcontroller();
        $this->pagecontroller = new Pagecontroller();
        $this->event = new Event();
    }

    public function show()
    {
        $eventDetails = $this->historyService->getEventDetails(8);
        $structuredTickets = $this->getStructuredTickets($eventDetails->getEventId());
        $uniqueTimes = $this->getUniqueTimes($structuredTickets);
        $navigationController = $this->navigationController->displayHeader();

        $contentData = $this->pagecontroller->getContentAndImagesByPage();
        $carouselItems = $this->pagecontroller->getCarouselImagesForHistory(14);
        require_once __DIR__ . '/../views/history/overview.php';
    }

    public function editContent()
    {
        $allSections = $this->pagecontroller->getSectionsFromPageID();
        $pageDetails = $this->pagecontroller->getPageDetails();
        require_once __DIR__ . "/../views/admin/page-managment/editHistory.php";
    }


    public function showeditEventDetails()
    {
        $eventDetails = $this->historyService->getEventDetails(8);
        $eventId = $eventDetails->getEventId();
        $eventTickets = $this->historyService->getTickets($eventId);
        require_once __DIR__ . '/../views/admin/manage-event-details/editDetailsHistory.php';
    }


    public function addNewTimeSlot()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            header('X-Content-Type-Options: nosniff');

            $eventId = filter_input(INPUT_POST, 'event_id', FILTER_SANITIZE_NUMBER_INT);
            $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);
            $language = filter_input(INPUT_POST, 'language', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $endTime = filter_input(INPUT_POST, 'endtime', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $newTicket = new Ticket();
            $newTicket->setEventId($eventId);
            $newTicket->setTicketDate($date);
            $newTicket->setQuantity($quantity);
            $newTicket->setTicketLanguage($language);
            $newTicket->setTicketTime($time);
            $newTicket->setState('Not Used');
            $newTicket->setTicketHash($this->generateTicketHash($eventId, $date, $time));
            $newTicket->setTicketEndTime($endTime);

            $result = $this->historyService->addNewTimeSlot($newTicket);

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
            header('Content-Type: application/json');
            header('X-Content-Type-Options: nosniff');

            $eventId = filter_input(INPUT_POST, 'event_id', FILTER_SANITIZE_NUMBER_INT);
            $newEventName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $newStartDate = filter_input(INPUT_POST, 'startDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $newEndDate = filter_input(INPUT_POST, 'endDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $newLocation = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $newPrice = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

            $currentEventDetails = $this->historyService->getEventDetails(8);
            $existingPicturePath = $currentEventDetails->getPicture();

            $uploadDirectory = '/img/EventImages/';
            $relativeUploadPath = $this->uploadImage($_FILES['image'] ?? null, $uploadDirectory);

            if ($relativeUploadPath === null) {
                $relativeUploadPath = $existingPicturePath;
            }

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


    public function removeTimeslot()
    {
        try {
            $ticketID = filter_input(INPUT_POST, 'ticket_id', FILTER_SANITIZE_NUMBER_INT);

            $result = $this->historyService->removeTimeslot($ticketID);
            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Timeslot removed successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to remove timeslot.']);
            }
            exit;

        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }



    private function uploadImage($imageFile, $uploadDirectory)
    {
        if (isset ($imageFile) && $imageFile['error'] == UPLOAD_ERR_OK) {
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
        $eventDetails = $this->historyService->getEventDetails($eventId);
        $location = $eventDetails->getLocation();
        $ticketPrice = $this->historyService->getTicketPrice($eventId);

        $price = $ticketPrice ? $ticketPrice->getPrice() : null;

        $structuredTickets = [];

        foreach ($tickets as $ticket) {
            $ticketId = $ticket->getTicketId();
            $eventId = $ticket->getEventId();
            $language = $ticket->getTicketLanguage();
            $date = $ticket->getTicketDate();
            $time = $ticket->getTicketTime();
            $endTime = $ticket->getTicketEndTime();
            $quantity = $ticket->getQuantity();


            $structuredTickets[$language][$date][$time] = [
                'ticket_id' => $ticketId,
                'event_id' => $eventId,
                'language' => $language,
                'date' => $date,
                'time' => $time,
                'endtime' => $endTime,
                'quantity' => $quantity,
                'price' => $price,
                'location' => $location
            ];
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