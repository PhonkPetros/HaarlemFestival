<?php

namespace controllers;

use services\Myprogramservice;
use services\registerservice;
use services\ticketservice;
use controllers\NavigationController;
use controllers\MollieAPIController;

//call the user service to check update user data 

require_once __DIR__ . '/../services/myprogramservice.php';
require_once __DIR__ . '/../controllers/mollieAPIController.php';
require_once __DIR__ . '/../services/registerservice.php';
require_once __DIR__ . '/../config/constant-paths.php';
require_once __DIR__ . '/../controllers/navigationcontroller.php';
require_once __DIR__ . '/../services/ticketservice.php';


class Myprogramcontroller
{
    private $navigationController;
    private $mollieAPIController;
    private $ticketservice;
    private $myProgramService;
    private $userService;
    private $navcontroller;


    public function __construct()
    {
        $this->myProgramService = new Myprogramservice();
        $this->ticketservice = new ticketservice();
        $this->navigationController = new NavigationController();
        $this->userService = new registerservice();
        $this->navcontroller = new NavigationController();
        $this->mollieAPIController = new MollieAPIController();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    function show()
    {
        $this->navigationController->displayHeader();
        $structuredTickets = [];
        $uniqueTimes = [];

        if (isset ($_SESSION['shopping_cart']) && !empty ($_SESSION['shopping_cart'])) {
            $structuredTickets = $this->structureTicketsWithImages();
            $uniqueTimes = $this->getUniqueTimes($structuredTickets);
        }
        require_once __DIR__ ."/../views/my-program/overview.php";
    
    }
  
    function showPayment(){
        $this->navigationController->displayHeader();
        $structuredTickets = [];
        $uniqueTimes = [];
        $userInfo = $this->getUserInfoFromCart();

        if (isset ($_SESSION['shopping_cart']) && !empty ($_SESSION['shopping_cart'])) {
            $structuredTickets = $this->structureTicketsWithImages();
            $uniqueTimes = $this->getUniqueTimes($structuredTickets);
        }
        require_once __DIR__ ."/../views/my-program/payment.php";
    }

    function showSuccess(){
        $this->navigationController->displayHeader();
        require_once __DIR__ ."/../views/my-program/success.php";
    }

    function showSharedCart($encodedCart, $hash)
    {
        $this->navigationController->displayHeader();
        $sharedCart = $this->retrieveSharedCart($encodedCart, $hash);
        if ($sharedCart === null) {
            echo "Invalid or expired share link.";
            return;
        }
        $structuredTickets = $this->structureSharedCart($sharedCart);
        require_once __DIR__ . '/../views/my-program/share-basket-view.php';
    }



    function createReservation()
    {
        //creates a shopping cart if it does not exist in the session
        $this->createShoppingCart();

        //decodes session data 
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, true);

        //holds user info
        $userInfo = [
            'firstName' => $input['firstName'] ?? '',
            'lastName' => $input['lastName'] ?? '',
            'address' => $input['address'] ?? '',
            'phoneNumber' => $input['phoneNumber'] ?? '',
            'email' => $input['email'] ?? ''
        ];

        //updates the user object in the session
        $_SESSION['user']['firstName'] = $userInfo['firstName'];
        $_SESSION['user']['lastName'] = $userInfo['lastName'];
        $_SESSION['user']['address'] = $userInfo['address'];
        $_SESSION['user']['phoneNumber'] = $userInfo['phoneNumber'];
        $_SESSION['user']['email'] = $userInfo['email'];

        $this->updateUserInfo();

        $ticketInfo = [
            'ticketId' => $input['ticketId'] ?? '',
            'eventId' => $input['eventId'] ?? '',
            'ticketPrice' => $input['ticketPrice'] ?? '',
            'quantity' => $input['quantity'] ?? '',
            'ticketDate' => $input['ticketDate'] ?? '',
            'ticketTime' => $input['ticketTime'] ?? '',
            'ticketEndTime' => $input['ticketEndTime'] ?? '',
            'user' => $userInfo
        ];

        switch ($ticketInfo['eventId']) {
            case EVENT_ID_DANCE:
            case EVENT_ID_JAZZ:
                $ticketInfo['artistName'] = $input['artistName'] ?? '';
                $ticketInfo['allAccessPass'] = $input['allAccesPass'] ?? '';
                $ticketInfo['dayPass'] = $inputJSON['dayPass'] ?? ''; 
                break;
            case EVENT_ID_RESTAURANT:
                $ticketInfo['restaurantName'] = $input['restaurantName'] ?? '';
                $ticketInfo['specialRemarks'] = $input['specialRemarks'] ?? '';
                break;
            case EVENT_ID_HISTORY:
                $ticketInfo['ticketLanguage'] = $input['ticketLanguage'] ?? '';
                break;
            default:
                break;
        }

        foreach ($_SESSION['shopping_cart'] as $item) {
            if (
                $item['ticketId'] == $ticketInfo['ticketId'] &&
                $item['eventId'] == $ticketInfo['eventId'] &&
                $item['ticketDate'] == $ticketInfo['ticketDate'] &&
                $item['ticketTime'] == $ticketInfo['ticketTime'] &&
                $item['ticketEndTime'] == $ticketInfo['ticketEndTime']
            ) {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'message' => 'This ticket is already in your shopping cart.',
                ]);
                exit;
            }
        }

        $ticketQuantity = $this->ticketservice->getTicketQuantity($ticketInfo['ticketId']);
        if ($ticketQuantity === null) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Could not retrieve ticket quantity.',
            ]);
            exit;
        } elseif ($ticketQuantity < $ticketInfo['quantity']) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Requested quantity exceeds available quantity.',
            ]);
            exit;
        }

        $_SESSION['shopping_cart'][] = $ticketInfo;

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'message' => 'Reservation successfully created!',
        ]);
        exit;
    }

    function updateUserInfo()
    {

        $userInfo = [
            'firstName' => $_SESSION['user']['firstName'] ?? '',
            'lastName' => $_SESSION['user']['lastName'] ?? '',
            'address' => $_SESSION['user']['address'] ?? '',
            'phoneNumber' => $_SESSION['user']['phoneNumber'] ?? '',
            'email' => $_SESSION['user']['email'] ?? ''
        ];


        $userEmail = $userInfo['email'];
        $userExists = $this->userService->email_exists($userEmail);

        if ($userExists) {
            $this->userService->updateUser($userInfo);
        }
    }

    function createShoppingCart()
    {
        if (!isset ($_SESSION['shopping_cart'])) {
            $_SESSION['shopping_cart'] = array();
        }
    }

    function modifyItemQuantity()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $ticketId = $data['ticketId'];
        $eventId = $data['eventId'];
        $change = $data['change'];

        $ticketQuantity = $this->ticketservice->getTicketQuantity($ticketId);

        foreach ($_SESSION['shopping_cart'] as &$item) {
            if ($item['ticketId'] == $ticketId && $item['eventId'] == $eventId) {
                $newTotalQuantity = $item['quantity'] + $change;
                if ($newTotalQuantity > $ticketQuantity) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Requested quantity exceeds available quantity.',
                    ]);
                    exit;
                }

                $item['quantity'] = max($item['quantity'] + $change, 1);
                $newQuantity = $item['quantity'];
                $newTotalPrice = $item['quantity'] * $item['ticketPrice'];
                break;
            }
        }
        unset($item);

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'message' => 'Quantity modified successfully.',
            'newQuantity' => $newQuantity,
            'newTotalPrice' => $newTotalPrice
        ]);
    }

    function updateTotalCartPrice()
    {
        $totalCartPrice = array_sum(array_map(function ($item) {
            return $item['quantity'] * $item['ticketPrice'];
        }, $_SESSION['shopping_cart']));

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'message' => 'Total cart price updated successfully.',
            'totalCartPrice' => $totalCartPrice
        ]);
    }

    function deleteItemFromCart()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $ticketId = $data['ticketId'];
        $eventId = $data['eventId'];

        foreach ($_SESSION['shopping_cart'] as $key => $item) {
            if ($item['ticketId'] == $ticketId && $item['eventId'] == $eventId) {
                unset($_SESSION['shopping_cart'][$key]);
                $_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
                break;
            }
        }

        if (empty ($_SESSION['shopping_cart'])) {
            $message = 'The shopping cart is now empty.';
        } else {
            $message = 'Item removed successfully.';
        }

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'message' => $message
        ]);
    }

    private function structureTicketsWithImages()
    {
        $structuredTickets = [];
        foreach ($_SESSION['shopping_cart'] as $ticket) {
            $eventId = $ticket['eventId'];
            if (!array_key_exists($eventId, $structuredTickets)) {
                $eventDetails = $this->ticketservice->getEventDetails($eventId);
                $structuredTickets[$eventId] = [
                    'tickets' => [],
                    'image' => $eventDetails['picture'] ?? null,
                    'event_name' => $eventDetails['name'] ?? null,
                    'location' => $eventDetails['location'] ?? null,
                    'totalPrice' => 0
                ];
            }
            $ticketTotalPrice = $ticket['quantity'] * $ticket['ticketPrice'];
            $structuredTickets[$eventId]['totalPrice'] += $ticketTotalPrice;
            $ticket['totalPrice'] = $ticketTotalPrice;
            $structuredTickets[$eventId]['tickets'][] = $ticket;
        }
        return $structuredTickets;
    }

    private function structureSharedCart($cartData)
    {
        $structuredTickets = [];
        foreach ($cartData as $ticket) {
            $eventId = $ticket['eventId'];
            if (!array_key_exists($eventId, $structuredTickets)) {
                $eventDetails = $this->ticketservice->getEventDetails($eventId);
                $structuredTickets[$eventId] = [
                    'tickets' => [],
                    'image' => $eventDetails['picture'] ?? null,
                    'event_name' => $eventDetails['name'] ?? null,
                    'location' => $eventDetails['location'] ?? null,
                    'totalPrice' => 0
                ];
            }
            $ticketTotalPrice = $ticket['quantity'] * $ticket['ticketPrice'];
            $structuredTickets[$eventId]['totalPrice'] += $ticketTotalPrice;
            $ticket['totalPrice'] = $ticketTotalPrice;
            $structuredTickets[$eventId]['tickets'][] = $ticket;
        }
        return $structuredTickets;
    }


    private function getUniqueTimes($structuredTickets)
    {
        $allTimes = [];

        foreach ($structuredTickets as $event) {
            foreach ($event['tickets'] as $ticket) {
                if (isset ($ticket['ticketTime']) && is_string($ticket['ticketTime'])) {
                    $allTimes[] = $ticket['ticketTime'];
                }
            }
        }

        $uniqueTimes = array_unique($allTimes);
        sort($uniqueTimes);

        return $uniqueTimes;
    }

    function generateShareableLink()
    {
        if (!isset ($_SESSION['shopping_cart']) || empty ($_SESSION['shopping_cart'])) {
            echo json_encode(['status' => 'error', 'message' => 'Cart is empty']);
            exit;
        }

        $encodedCart = base64_encode(serialize($_SESSION['shopping_cart']));
        $hash = hash_hmac('sha256', $encodedCart, $_ENV['SECRET_KEY'] ?? 'default-secret');

        $link = "http://localhost/share-cart/?cart=" . urlencode($encodedCart) . "&hash=" . $hash;
        echo json_encode(['status' => 'success', 'link' => $link]);
        exit;
    }


    function retrieveSharedCart($encodedCart, $hash)
    {
        $isValid = hash_equals(hash_hmac('sha256', $encodedCart, $_ENV['SECRET_KEY'] ?? 'default-secret'), $hash);

        if ($isValid) {
            return unserialize(base64_decode($encodedCart));
        }

        return null;
    }

    function getUserInfoFromCart() {
        foreach ($_SESSION['shopping_cart'] as $item) {
            if (isset($item['user'])) {
                return $item['user']; 
            }
        }
        return null; 
    }
    

    function initiatePayment() {
        $data = json_decode(file_get_contents('php://input'), true);
        $paymentMethod = $data['paymentMethod'] ?? null;
        $issuer = $data['issuer'] ?? null;


        $userInfo = $this->getUserInfoFromCart();
        $userExists = $this->userService->email_exists($userInfo['email']);
        $userId = $this->userService->getUserIDThroughEmail($userInfo['email']);
    
        if (!$userExists) {
            echo json_encode(['status' => 'error', 'message' => 'User needs to register.']);
            exit;
        }

     
    
        $ticketsAvailable = $this->checkTicketsAvailability($_SESSION['shopping_cart']);
    
   
        if (!$ticketsAvailable) {
            echo json_encode(['status' => 'error', 'message' => 'Some tickets are not available in the requested quantity.']);
            exit;
        }
    
        $paymentResult = $this->mollieAPIController->createPayment($userId, $_SESSION['shopping_cart'], $paymentMethod, $issuer);
     
        if ($paymentResult['status'] === 'success') {
            // Payment was successful, update database
            $orderProcessingResult = $this->myProgramService->processOrder($userId, $_SESSION['shopping_cart']);
            
            if($orderProcessingResult['status'] === 'success') {
                // Clear the shopping cart after successful order processing
                $_SESSION['shopping_cart'] = [];
                
                // Provide the payment URL so that the front-end can redirect the user
                echo json_encode(['status' => 'success', 'paymentUrl' => $paymentResult['paymentUrl']]);
            } else {
                // Handle order processing failure
                echo json_encode(['status' => 'error', 'message' => 'Order processing failed.']);
            }
        } else {
            // Handle payment failure
            echo json_encode(['status' => 'error', 'message' => 'Payment failed.']);
        }        
        exit;
    }
    
    
    function checkTicketsAvailability($cart) {
        foreach ($cart as $cartItem) {
            $ticketId = $cartItem['ticketId'];
            $requestedQuantity = $cartItem['quantity'];
            $availableQuantity = $this->ticketservice->getTicketQuantity($ticketId);
    
            if ($availableQuantity === null) {
                return false;
            }
    
            if ($requestedQuantity > $availableQuantity) {
                return false;
            }
        }
        return true;
    }
    
    
    


}


