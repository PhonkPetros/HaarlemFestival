<?php

namespace controllers;

use controllers\NavigationController;
use repositories\DanceRepository;
use controllers\Pagecontroller;

require_once __DIR__ . '/../repositories/dancerepository.php';
require_once __DIR__ . '/../controllers/pagecontroller.php';

class Dancecontroller
{

    private $navcontroller;
    private $repository;
    private $pagecontroller;
    public function __construct() {
        $this->navcontroller = new NavigationController();
        $this->repository = new DanceRepository();
        $this->pagecontroller = new Pagecontroller();
    }

    public function show()
    {
        $navigation = $this->navcontroller->displayHeader();
        $contentData = $this->pagecontroller->getContentAndImagesByPage();    
        require_once __DIR__ ."/../views/dance/overview.php";
    }

    public function editEventDetails(){
        $danceEvents = $this->repository->getDanceEvents();
        $artists = $this->repository->getArtists();
        require_once __DIR__ . '/../views/admin/manage-event-details/editDetailsDance.php';
    }

    public function editContent(){
        require_once __DIR__ ."/../views/admin/page-managment/editDance.php";
    }

    public function addNewEvent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $venue = $_POST['venue'];
            $address = $_POST['address'];
            $dateTime = $_POST['dateTime'];
            $dateTime = date('Y-m-d H:i:s', strtotime($dateTime));
            $price = $_POST['price'];
            $image = $_POST['image'];
            return $this->repository->addDanceEvent($venue, $address, $dateTime, $price, $image);
        }
    }

    public function updateEvent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $danceEventId = $_POST['danceEventId'];
            $venue = $_POST['venue'];
            $address = $_POST['address'];
            $dateTime = $_POST['dateTime'];
            $dateTime = date('Y-m-d H:i:s', strtotime($dateTime));
            $price = $_POST['price'];
            $image = $_POST['image'];
            return $this->repository->updateDanceEvent($danceEventId, $venue, $address, $dateTime, $price, $image);
        }
    }
}