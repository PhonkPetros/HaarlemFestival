<?php

namespace controllers;
require_once __DIR__ . '/../services/restaurantservice.php';

use services\RestaurantService;


class Restaurantcontroller
{
  
    public $restaurantService;

    public function __construct() {
        $this->navigationController = new Navigationcontroller();
        $this->restaurantService = new RestaurantService();
    }

    private $navigationController;


    public function editEventDetails($eventId) {
        
        $restaurants = $this->restaurantService->getRestaurant($eventId);
        $tickets = $this->restaurantService->getTimeslotsForRestaurant($eventId);
        require_once __DIR__ . '/../views/admin/manage-event-details/editDetailsRestaurant.php';
    }
    
    public function updateRestaurantDetails() {
        header('Content-Type: application/json');
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $location = $_POST['location'] ?? '';
            $price = $_POST['price'] ?? '';
            $seats = $_POST['seats'] ?? 0;
            $startDate = $_POST['startDate'] ?? '';
            $endDate = $_POST['endDate'] ?? '';
            $picturePath = '';
    
            $price = max(0, floatval($price));
            $seats = max(0, intval($seats)); 
    
            $response = ['success' => false, 'message' => 'An error occurred'];
    
            if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
                $targetDirectory = __DIR__ . '/../public/img/';
                $fileName = basename($_FILES['picture']['name']);
                $targetFilePath = $targetDirectory . $fileName;
                $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];
    
                if (in_array($fileType, $allowedTypes)) {
                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($_FILES['picture']['tmp_name'], $targetFilePath)) {
                        $picturePath = $fileName; // Store the file name
                    } else {
                        $response['message'] = 'Sorry, there was an error uploading your file.';
                        echo json_encode($response);
                        exit;
                    }
                } else {
                    $response['message'] = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
                    echo json_encode($response);
                    exit;
                }
            }
    
            // Call the updateRestaurantDetails method with the updated picturePath
            $result = $this->restaurantService->updateRestaurantDetails($id, $name, $price, $seats, $startDate, $endDate, $picturePath, $description, $location);
            if ($result) {
                $response = ['success' => true, 'message' => 'Restaurant details updated successfully.'];
            } else {
                $response['message'] = 'Failed to update restaurant details.';
            }
    
            echo json_encode($response);
            exit;
        }
    }
    
    
    

    public function addTimeSlot() {
        header('Content-Type: application/json');
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $restaurantId = $_POST['restaurantId'] ?? '';
            $date = $_POST['date'] ?? '';
            $time = $_POST['time'] ?? '';
            $quantity = $_POST['quantity'] ?? 0;
    
            $response = ['success' => false, 'message' => 'An error occurred'];
            
    
            if ($restaurantId && $date && $time && $quantity) {
                $result = $this->restaurantService->addTimeSlot($restaurantId, $ticketHash = $this->generateTicketHash($restaurantId, $date, $time) ,$date, $time, $quantity);
                if ($result) {
                    $response = ['success' => true, 'message' => 'Timeslot added successfully.'];
                } else {
                    $response['message'] = 'Failed to add timeslot.';
                }
            } else {
                $response['message'] = 'Invalid input data.';
            }
    
            echo json_encode($response);
            exit;
        }
    }

    private function generateTicketHash($eventId, $date, $time)
    {
        $toHash = $eventId . $date . $time . uniqid('', true);
        return hash('sha256', $toHash);
    }
    

    public function addRestaurant() {
        header('Content-Type: application/json');
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            $name = $_POST['name'] ?? '';
            $location = $_POST['location'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $seats = $_POST['seats'] ?? 0;
            $startDate = $_POST['startDate'] ?? '';
            $endDate = $_POST['endDate'] ?? '';
            $picturePath = $_POST['picturePath'] ?? '';
    
    
    
            $result = $this->restaurantService->addRestaurant($name, $location, $description, $price, $seats, $startDate, $endDate, $picturePath);
    
    
            if ($result) {
                $response = ['success' => true, 'message' => 'Restaurant added successfully.'];
            } else {
                $response = ['success' => false, 'message' => 'Failed to add the restaurant.'];
            }
    
    
            echo json_encode($response);
    
            exit;
        }
    }

    
    
    
  
}