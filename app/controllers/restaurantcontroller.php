<?php

namespace controllers;
require_once __DIR__ . '/../services/restaurantservice.php';
require_once __DIR__ . '/../services/ticketservice.php';

use services\RestaurantService;
use services\ticketservice;

class Restaurantcontroller
{
  
    public $restaurantService;
    public $ticketService;

    public function __construct() {
        $this->navigationController = new Navigationcontroller();
        $this->restaurantService = new RestaurantService();
        $this->ticketService = new ticketservice();
    }

    private $navigationController;


    public function editEventDetails($eventId) {
        
        $restaurants = $this->restaurantService->getRestaurant($eventId);
        $timeslots = $this->restaurantService->getTimeslotsForRestaurant($eventId);
        $reservations = $this->ticketService->getReservations($eventId);
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
    
            $response = ['success' => false, 'message' => 'An error occurred'];

            if ($price < 1) {
                echo json_encode(['success' => false, 'message' => 'Price must be greater than 0.']);
                exit;
            }
    
            if ($seats < 1) {
                echo json_encode(['success' => false, 'message' => 'Seats must be greater than 0.']);
                exit;
            }

            if ($startDate > $endDate){
                echo json_encode(['success' => false, 'message' => 'Start date greater than end date']);
                exit;
            }
    
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
            $seats = $_POST['seats'] ?? '';
            $startDate = $_POST['startDate'] ?? '';
            $endDate = $_POST['endDate'] ?? '';
            $picturePath = '';
    
            $requiredFields = [
                'name' => $name,
                'location' => $location,
                'description' => $description,
                'price' => $price,
                'seats' => $seats,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ];

            if ($startDate > $endDate){
                echo json_encode(['success' => false, 'message' => 'Start date greater than enddate']);
                exit;
            }
    
            foreach ($requiredFields as $fieldName => $value) {
                if (empty($value)) {
                    echo json_encode(['success' => false, 'message' => ucwords($fieldName) . ' must not be empty.']);
                    exit;
                }
            }
    
            // Additional validations for price and seats
            if ($price < 1) {
                echo json_encode(['success' => false, 'message' => 'Price must be greater than 0.']);
                exit;
            }
    
            if ($seats < 1) {
                echo json_encode(['success' => false, 'message' => 'Seats must be greater than 0.']);
                exit;
            }
    
            // File upload logic...
            // Your existing file upload logic remains here unchanged
    
            // Attempt to add restaurant with provided details
            $result = $this->restaurantService->addRestaurant($name, $location, $description, floatval($price), intval($seats), $startDate, $endDate, $picturePath);
        
            if ($result) {
                $response = ['success' => true, 'message' => 'Restaurant added successfully.', 'picturePath' => $picturePath];
            } else {
                $response = ['success' => false, 'message' => 'Failed to add the restaurant.'];
            }
        
            echo json_encode($response);
            exit;
        }
    }
    
    

    public function deleteRestaurant(){
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_restaurant_id"])) {
            $this->restaurantService->deleteRestaurant($_POST["delete_restaurant_id"]);
            header('Location: /admin/managefestival');
            exit(); 
        }        
    }

    public function updateStatus() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $orderId = $_POST['order_id'] ?? null;
            $newStatus = $_POST['new_status'] ?? null;
            $eventId = $_POST['event_id'] ?? null;
            if ($orderId && $newStatus && $eventId) {
                $result = $this->ticketService->updateReservationStatus($orderId, $newStatus);
                if ($result) {
                    // Redirect to the restaurant details page after successful update
                    header("Location: /manage-event-details/editDetails?id=" . urlencode($eventId));
                    exit();
                } else {
                    // Handle failure (consider logging the failure and providing feedback to the user)
                    echo json_encode(['success' => false, 'message' => 'Failed to update status.']);
                }
            } else {
                // Handle missing data
                echo json_encode(['success' => false, 'message' => 'Missing required data.']);
            }
            exit();
        }
    }
    

    public function deleteTimeSlot(){
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_timeslot_id"])) {
            $this->restaurantService->deleteTimeSlot($_POST["delete_timeslot_id"]);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit(); 
        }        
    }


    public function makeAnReservation() {
        if (!isset($_SESSION['user']['userID'])) {
            echo json_encode(['error' => 'User not logged in', 'login_required' => true]);
            return;
        }
    
        $data = json_decode(file_get_contents('php://input'), true);
    
        $errors = $this->validateReservationFields($data);
        if (!empty($errors)) {
            echo json_encode(['errors' => $errors]);
            return;
        }
    
        $ticketId = $data['ticketId'];
        $user_id = $_SESSION['user']['userID']; 
        $specialRequest = $data['specialRequest'];
        $address = $data['address'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $phoneNumber = $data['phoneNumber'];
        $quantity = $data['quantity'];
        $reservationPrice = 10.00;
        $totalPrice = $quantity * $reservationPrice;
    
        $mollieController = new MollieAPIController();
        $paymentResponse = $mollieController->createPayment($user_id, [
            ['quantity' => $quantity, 'ticketPrice' => $totalPrice]
        ], "creditcard");
    
        if ($paymentResponse['status'] === 'success') {
            $this->restaurantService->addReservation($ticketId, $user_id, $specialRequest, $address, $firstName, $lastName, $phoneNumber);
            
            echo json_encode(['success' => true, 'paymentUrl' => $paymentResponse['paymentUrl']]);
        } else {
            echo json_encode(['error' => $paymentResponse['message']]);
        }
        exit;
    }
    
    
    private function validateReservationFields($data) {
        $errors = [];
        $fieldsToCheck = ['firstName', 'lastName', 'phoneNumber', 'email', 'quantity', 'ticketId'];
    
        foreach ($fieldsToCheck as $field) {
            if (empty($data[$field])) {
                $errors[] = ['error' => "$field field is required", 'field' => $field];
            }
        }
    
        if (isset($data['quantity']) && $data['quantity'] <= 0) {
            $errors[] = ['error' => "Quantity must be greater than 0", 'field' => 'quantity'];
        }
    
        return $errors;
    }
    
    
}