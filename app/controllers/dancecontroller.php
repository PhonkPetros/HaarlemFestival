<?php

namespace controllers;

use controllers\NavigationController;
use repositories\DanceRepository;
use services\DanceService;
use controllers\Pagecontroller;

require_once __DIR__ . '/../repositories/dancerepository.php';
require_once __DIR__ . '/../services/danceservice.php';
require_once __DIR__ . '/../controllers/pagecontroller.php';

class Dancecontroller
{

    private $navcontroller;
    private $repository;
    private $service;
    private $pagecontroller;
    public function __construct() {
        $this->navcontroller = new NavigationController();
        $this->repository = new DanceRepository();
        $this->service = new DanceService();
        $this->pagecontroller = new Pagecontroller();
        // 
    }

    public function show()
    {
        $navigation = $this->navcontroller->displayHeader();
        $contentData = $this->pagecontroller->getContentAndImagesByPage();
        $artists = $this->service->getArtists();
        require_once __DIR__ ."/../views/dance/overview.php";
    }

    public function showArtist($artistId) {
        $navigation = $this->navcontroller->displayHeader();
        $artistDetails = $this->service->getArtistById($artistId);
        require_once __DIR__ ."/../views/dance/details.php";
    }

    public function editEventDetails(){
        $danceEvents = $this->repository->getDanceEvents();
        $artists = $this->repository->getArtists();
        $venues = $this->repository->getVenues();
        require_once __DIR__ . '/../views/admin/manage-event-details/editDetailsDance.php';
    }

    public function editContent(){
        require_once __DIR__ ."/../views/admin/page-managment/editDance.php";
    }

    public function addNewEvent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $venue = $_POST['venue'];
            $dateTime = $_POST['dateTime'];
            $dateTime = date('Y-m-d H:i:s', strtotime($dateTime));
            $price = $_POST['price'];
            $oneDayPrice = $_POST['oneDayPrice'];
            $allDaysPrice = $_POST['allDaysPrice'];
            $image = $_FILES['image'];
            $artists = $_POST['artists'];

            if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
                $uploadDir = "../public/img/Music_img/events/";
                $uploadFile = $uploadDir . basename($_FILES["image"]["name"]);
                
                if (file_exists($uploadFile)) {
                    unlink($uploadFile);
                }
                
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadFile)) {
                    $this->repository->addDanceEvent($venue, $dateTime, $price, $oneDayPrice, $allDaysPrice, $artists, "/img/Music_img/events/" . basename($_FILES["image"]["name"]));
                } else {
                    echo "there was an error uploading your file.";
                }
            }
        }
    }

    public function updateEvent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $danceEventId = $_POST['danceEventId'];
            $venue = $_POST['venue'];
            $dateTime = $_POST['dateTime'];
            $dateTime = date('Y-m-d H:i:s', strtotime($dateTime));
            $price = $_POST['price'];
            $oneDayPrice = $_POST['oneDayPrice'];
            $allDaysPrice = $_POST['allDaysPrice'];
            $artists = $_POST['artists'];
            $image = $_FILES['image'];

            if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
                $uploadDir = "../public/img/Music_img/events/";
                $uploadFile = $uploadDir . basename($_FILES["image"]["name"]);
                
                if (file_exists($uploadFile)) {
                    unlink($uploadFile);
                }
                
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadFile)) {
                    $this->repository->updateDanceEventWithImage($danceEventId, $venue, $dateTime, $price, $oneDayPrice, $allDaysPrice, $artists, "/img/Music_img/events/" . basename($_FILES["image"]["name"]));
                } else {
                    echo "there was an error uploading your file.";
                }
            } else if (!isset($_FILES["image"])) {
                return $this->repository->updateDanceEvent($danceEventId, $venue, $dateTime, $price, $oneDayPrice, $allDaysPrice, $artists);
            }
        }
    }

    public function deleteEvent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $danceEventId = $_POST['danceEventId'];
            $this->repository->deleteDanceEvent($danceEventId);
        }
    }

    public function addNewArtist() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $profile = $_FILES['profile'];
            $image1 = $_FILES['image1'];
            $image2 = $_FILES['image2'];
            $image3 = $_FILES['image3'];
            $video = $_FILES['video'];
            $album = $_POST['album'];
    
            $uploadDirectory = '../public/img/Music_img/artists/';
    
            $uploadedFiles = array();
    
            $imageFiles = array($profile, $image1, $image2, $image3);
            foreach ($imageFiles as $image) {
                if (!empty($image['tmp_name'])) {
                    $imageName = uniqid('image_', true) . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
                    $imagePath = $uploadDirectory . $imageName;
                    if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                        $uploadedFiles[] = "/img/Music_img/artists/" . $imageName;
                    }
                } else {
                    $uploadedFiles[] = null;
                }
            }
    
            if (!empty($video['tmp_name'])) {
                $videoName = uniqid('video_', true) . '.' . pathinfo($video['name'], PATHINFO_EXTENSION);
                $videoPath = $uploadDirectory . $videoName;
                if (move_uploaded_file($video['tmp_name'], $videoPath)) {
                    $uploadedFiles[] = "/img/Music_img/artists/" . $videoPath;
                }
            }
    
            return $this->service->addArtist($name, $description, $uploadedFiles[0], $uploadedFiles[1], $uploadedFiles[2], $uploadedFiles[3], $uploadedFiles[4], $album);
        }
    }
    
    public function updateArtist() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $artistId = $_POST['artistId'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $profile = isset($_FILES['profile']) ? $_FILES['profile'] : null;
            $image1 = isset($_FILES['image1']) ? $_FILES['image1'] : null;
            $image2 = isset($_FILES['image2']) ? $_FILES['image2'] : null;
            $image3 = isset($_FILES['image3']) ? $_FILES['image3'] : null;
            $video = isset($_FILES['video']) ? $_FILES['video'] : null;
            $album = $_POST['album'];
    
            $uploadDirectory = '../public/img/Music_img/artists/';
    
            $uploadedFiles = array();
    
            $imageFiles = array($profile, $image1, $image2, $image3);
            foreach ($imageFiles as $image) {
                if (!empty($image['tmp_name'])) {
                    $imageName = uniqid('image_', true) . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
                    $imagePath = $uploadDirectory . $imageName;
                    if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                        $uploadedFiles[] = "/img/Music_img/artists/" . $imageName;
                    }
                } else {
                    $uploadedFiles[] = null;
                }
            }
    
            if (!empty($video['tmp_name'])) {
                $videoName = uniqid('video_', true) . '.' . pathinfo($video['name'], PATHINFO_EXTENSION);
                $videoPath = $uploadDirectory . $videoName;
                if (move_uploaded_file($video['tmp_name'], $videoPath)) {
                    $uploadedFiles[] = "/img/Music_img/artists/" . $videoName;
                }
            }
            
            $this->service->updateArtist(
                $artistId,
                $name,
                $description,
                isset($uploadedFiles[0]) ? $uploadedFiles[0] : null,
                isset($uploadedFiles[1]) ? $uploadedFiles[1] : null,
                isset($uploadedFiles[2]) ? $uploadedFiles[2] : null,
                isset($uploadedFiles[3]) ? $uploadedFiles[3] : null,
                isset($uploadedFiles[4]) ? $uploadedFiles[4] : null,
                $album
            );

            // header('Content-Type: application/json');
            // echo json_encode(['status' => 'success', 'message' => 'Artist updated successfully', 'video' => $videoName]);
        }
    }

    public function deleteArtist() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $artistId = $_POST['artistId'];
            $this->service->deleteArtist($artistId);
        }
    }

    public function addVenue() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $location = $_POST['location'];
            $picture = $_FILES['picture'];

            $uploadDirectory = '../public/img/Music_img/venues/';
    
            $uploadedFiles = array();
    
            $imageFiles = array($picture);
            foreach ($imageFiles as $image) {
                if (!empty($image['tmp_name'])) {
                    $imageName = uniqid('image_', true) . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
                    $imagePath = $uploadDirectory . $imageName;
                    if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                        $uploadedFiles[] = "/img/Music_img/venues/" . $imageName;
                    }
                }
            }

            $this->service->addVenue($name, $location, $uploadedFiles[0]);
        }
    }

    public function updateVenue() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $venueId = $_POST['venueId'];
            $name = $_POST['name'];
            $location = $_POST['location'];
            $picture = $_FILES['picture'];

            $uploadDirectory = '../public/img/Music_img/venues/';
    
            $uploadedFiles = array();
    
            $imageFiles = array($picture);
            foreach ($imageFiles as $image) {
                if (!empty($image['tmp_name'])) {
                    $imageName = uniqid('image_', true) . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
                    $imagePath = $uploadDirectory . $imageName;
                    if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                        $uploadedFiles[] = "/img/Music_img/venues/" . $imageName;
                    }
                }
            }

            $this->service->updateVenue($venueId, $name, $location, $uploadedFiles[0]);
        }
    }

    public function deleteVenue() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $venueId = $_POST['venueId'];
            $this->service->deleteVenue($venueId);
        }
    }
}