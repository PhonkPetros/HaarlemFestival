<?php

namespace controllers;
use model\Ticket;
use Exception;
use model\Event;
use controllers\Navigationcontroller;
use controllers\Pagecontroller;
use services\Jazzservice;

require_once __DIR__ . '/../model/event.php';
require_once __DIR__ . '/../services/jazzservice.php';
require_once __DIR__ . '/../controllers/navigationcontroller.php';
require_once __DIR__ . '/../controllers/pagecontroller.php';

class Jazzcontroller
{
    private $jazzservice;
    private $navcpntroller;
    private $event;
    public function __construct() {
        $this->navcpntroller = new NavigationController();
        $this->jazzservice = new Jazzservice();
        $this->event = new Event();

    }

    public function show()
    {
        $eventDetails = $this->jazzservice->getEventDetails();
        $navigation = $this->navcpntroller->displayHeader();    
        require_once __DIR__ ."/../views/jazz/overview.php";
        
    }

    public function showEventDetails(){
        $eventDetails = $this->jazzservice->getEventDetails();
        $eventid = $eventDetails->getEventId();
        require_once __DIR__ . '/../views/admin/manage-event-details/editDetailsJazz.php';
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

            $currentEventDetails = $this->jazzservice->getEventDetails();
            $existingPicturePath = $currentEventDetails->getPicture();

           /* $uploadDirectory = '/img/EventImages/';
            $relativeUploadPath = $this->uploadImage($_FILES['image'] ?? null, $uploadDirectory);

            if ($relativeUploadPath === null) {
                $relativeUploadPath = $existingPicturePath;
            }
            */

            $result = $this->jazzservice->editEventDetails($eventId, $newEventName, $newStartDate, $newEndDate, $newPrice, $newLocation);

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

    public function editContent(){
        require_once __DIR__ ."/../views/admin/page-managment/editJazz.php";
    }

  
}