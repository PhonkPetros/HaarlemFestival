<?php

namespace controllers;

use services\Myprogramservice;
use services\registerservice;
use services\ticketservice;
use controllers\NavigationController;
use controllers\MollieAPIController;
use model\OrderItem;

//call the user service to check update user data 

require_once __DIR__ . '/../services/myprogramservice.php';
require_once __DIR__ . '/../controllers/mollieAPIController.php';
require_once __DIR__ . '/../services/registerservice.php';
require_once __DIR__ . '/../config/constant-paths.php';
require_once __DIR__ . '/../controllers/navigationcontroller.php';
require_once __DIR__ . '/../services/ticketservice.php';
require_once __DIR__ . '/../controllers/smtpcontroller.php';
require_once __DIR__ . '/../model/orderItem.php';


class Myprogramcontroller
{
    private $smtpcontroller;
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
        $this->smtpcontroller = new SMTPController();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    function show()
    {
        $this->navigationController->displayHeader();
        $structuredTickets = [];
        $structuredOrderedItems = [];
        $uniqueTimes = [];

        if (isset($_SESSION['shopping_cart']) && !empty($_SESSION['shopping_cart'])) {
            $structuredTickets = $this->structureTicketsWithImages();

        }

        if (!isset($_SESSION['user'])) {
            $user = null;
        }
        $structuredOrderedItems = $this->getStructuredPurchasedOrderItemsByUserID();

        require_once __DIR__ . "/../views/my-program/overview.php";

    }


    function showPayment()
    {
        $this->navigationController->displayHeader();
        $structuredTickets = [];
        $uniqueTimes = [];
        $userInfo = $this->getUserInfoFromCart();

        if (isset($_SESSION['shopping_cart']) && !empty($_SESSION['shopping_cart'])) {
            $structuredTickets = $this->structureTicketsWithImages();
        }
        require_once __DIR__ . "/../views/my-program/payment.php";
    }

    function showSuccess()
    {
        $this->navigationController->displayHeader();
        require_once __DIR__ . "/../views/my-program/success.php";
    }

    function showFailure()
    {
        $this->navigationController->displayHeader();
        require_once __DIR__ . "/../views/my-program/failure.php";
    }


    // function showSharedCart($encodedCart, $hash)
    // {
    //     $this->navigationController->displayHeader();
    //     $sharedCart = $this->retrieveSharedCart($encodedCart, $hash);
    //     if ($sharedCart === null) {
    //         echo "Invalid or expired share link.";
    //         return;
    //     }
    //     $structuredTickets = $this->structureSharedCart($sharedCart);
    //     require_once __DIR__ . '/../views/my-program/share-basket-view.php';
    // }


    //Creates a reservation and adds reservations to shopping cart 
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

        $ticketInfo = [
            'ticketId' => $input['ticketId'] ?? '',
            'eventId' => $input['eventId'] ?? '',
            'ticketPrice' => $input['ticketPrice'] ?? '',
            'quantity' => $input['quantity'] ?? '',
            'ticketDate' => $input['ticketDate'] ?? '',
            'ticketTime' => $input['ticketTime'] ?? '',
            'ticketEndTime' => $input['ticketEndTime'] ?? '',
            'ticketLocation' => $input['ticketLocation'] ?? '',
            'user' => $userInfo
        ];
        

        //If your event has extra info that needs to be added to a shopping cart then add it below
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


        //Checking if the ticket already exists in the cart
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

        //Checking if the ticket quantity being set in form is greater than what is set in database for that one ticket
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


    //creates a shopping cart if a shopping cart does not exist in the session data
    function createShoppingCart()
    {
        if (!isset($_SESSION['shopping_cart'])) {
            $_SESSION['shopping_cart'] = array();
        }
    }

    //modifies ticket quantity using an api 
    function modifyItemQuantity()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $ticketId = $data['ticketId'];
        $eventId = $data['eventId'];
        $change = $data['change'];

        $ticketQuantity = $this->ticketservice->getTicketQuantity($ticketId);

        //iterating items in shopping cart and setting it
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


    //updates the total cart price
    function updateTotalCartPrice()
    {
        $totalCartPrice = array_sum(array_map(function ($item) {
            return $item['quantity'] * $item['ticketPrice'];
        }, $_SESSION['shopping_cart']));

        $iva = $totalCartPrice * 0.21;
        $totalCartPriceWithIVA = $totalCartPrice + $iva;

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'message' => 'Total cart price updated successfully.',
            'totalCartPrice' => $totalCartPriceWithIVA,
        ]);
    }

    // deletes items from shopping cart
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

        if (empty($_SESSION['shopping_cart'])) {
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

    //structuring ticket data for ticket list view
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

    //structuring ticket data for shared cart view
    // private function structureSharedCart($cartData)
    // {
    //     $structuredTickets = [];
    //     foreach ($cartData as $ticket) {
    //         $eventId = $ticket['eventId'];
    //         if (!array_key_exists($eventId, $structuredTickets)) {
    //             $eventDetails = $this->ticketservice->getEventDetails($eventId);
    //             $structuredTickets[$eventId] = [
    //                 'tickets' => [],
    //                 'image' => $eventDetails['picture'] ?? null,
    //                 'event_name' => $eventDetails['name'] ?? null,
    //                 'location' => $eventDetails['location'] ?? null,
    //                 'totalPrice' => 0
    //             ];
    //         }
    //         $ticketTotalPrice = $ticket['quantity'] * $ticket['ticketPrice'];
    //         $structuredTickets[$eventId]['totalPrice'] += $ticketTotalPrice;
    //         $ticket['totalPrice'] = $ticketTotalPrice;
    //         $structuredTickets[$eventId]['tickets'][] = $ticket;
    //     }
    //     return $structuredTickets;
    // }



    // //generates a sharable link of the session data of the shopping cart by hashing it and url encodign to the url
    // function generateShareableLink()
    // {
    //     if (!isset ($_SESSION['shopping_cart']) || empty ($_SESSION['shopping_cart'])) {
    //         echo json_encode(['status' => 'error', 'message' => 'Cart is empty']);
    //         exit;
    //     }

    //     $encodedCart = base64_encode(serialize($_SESSION['shopping_cart']));
    //     $hash = hash_hmac('sha256', $encodedCart, $_ENV['SECRET_KEY'] ?? 'default-secret');

    //     $link = "http://localhost/share-cart/?cart=" . urlencode($encodedCart) . "&hash=" . $hash;
    //     echo json_encode(['status' => 'success', 'link' => $link]);
    //     exit;
    // }


    // de-hashes the hashed shopping cart data
    function retrieveSharedCart($encodedCart, $hash)
    {
        $isValid = hash_equals(hash_hmac('sha256', $encodedCart, $_ENV['SECRET_KEY'] ?? 'default-secret'), $hash);

        if ($isValid) {
            return unserialize(base64_decode($encodedCart));
        }

        return null;
    }

    //gets user info set in the shopping cart that is stored in session
    function getUserInfoFromCart()
    {
        foreach ($_SESSION['shopping_cart'] as $item) {
            if (isset($item['user'])) {
                return $item['user'];
            }
        }
        return null;
    }

    //creating a new payment
    function initiatePayment()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        //geting the payment method
        $paymentMethod = $data['paymentMethod'] ?? null;
        //getting issuer
        $issuer = $data['issuer'] ?? null;

        // checking if user exists in database 
        $userInfo = $this->getUserInfoFromCart();
        if (!$this->userService->email_exists($userInfo['email'])) {
            echo json_encode(['status' => 'error', 'message' => 'User needs to register.']);
            exit;
        }

        //checking if tickets are still available
        if (!$this->checkTicketsAvailability($_SESSION['shopping_cart'])) {
            echo json_encode(['status' => 'error', 'message' => 'Some tickets are not available in the requested quantity.']);
            exit;
        }

        //calls the mollie api to create payment
        $userId = $_SESSION['user']['userID'];
        $paymentResult = $this->mollieAPIController->createPayment($userId, $_SESSION['shopping_cart'], $paymentMethod, $issuer);


        // if the payment status is success then it redirects user to the payment screen 
        if ($paymentResult['status'] === 'success') {
            echo json_encode(['status' => 'success', 'paymentUrl' => $paymentResult['paymentUrl']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Payment initiation failed.']);
        }
        exit;
    }

    public function paymentSuccess()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the payment ID is stored in the session
        if (!isset($_SESSION['payment_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Payment ID is required.']);
            exit;
        }

        $paymentId = $_SESSION['payment_id'];

        $paymentStatus = $this->mollieAPIController->getPaymentStatus($paymentId);

        if ($paymentStatus !== 'paid') {
            header('Location: /my-program/payment-failure');
            exit;
        }

        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['userID'])) {
            echo json_encode(['status' => 'error', 'message' => 'User information is missing.']);
            exit;
        }
        $userId = $_SESSION['user']['userID'];

        if (!isset($_SESSION['shopping_cart']) || empty($_SESSION['shopping_cart'])) {
            echo json_encode(['status' => 'error', 'message' => 'Shopping cart is empty.']);
            exit;
        }

        $orderProcessingResult = $this->myProgramService->processOrder($userId, $_SESSION['shopping_cart'], $paymentStatus);

        if ($orderProcessingResult['status'] === 'success') {
            $itemHashes = $orderProcessingResult['itemHashes'];
            $orderID = $orderProcessingResult['orderId'];

            $firstCartItem = $_SESSION['shopping_cart'][0];
            if (isset($firstCartItem['user']) && isset($firstCartItem['user']['email']) && isset($firstCartItem['user']['firstName'])) {
                $email = $firstCartItem['user']['email'];
                $firstName = $firstCartItem['user']['firstName'];
                $this->smtpcontroller->sendInvoice($email, $firstName,  $_SESSION['shopping_cart'], $orderID);
                $this->smtpcontroller->sendTickets($email, $firstName, $itemHashes);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'User email or first name is missing from the first cart item.']);
                exit;
            }

            $_SESSION['shopping_cart'] = [];
            header('Location: /my-program/order-confirmation');
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Processing Order Failed.']);
            exit;
        }
    }


    //this checks if tickets are still available in database from session data 
    function checkTicketsAvailability($cart)
    {
        foreach ($cart as $cartItem) {
            $ticketId = $cartItem['ticketId'];
            $requestedQuantity = $cartItem['quantity'];
            $availableQuantity = $this->ticketservice->getTicketQuantity($ticketId);

            if ($availableQuantity === null || $requestedQuantity > $availableQuantity) {
                return false;
            }
        }
        return true;
    }


    //getting all the purchased tickets by userID and structuring them 
    function getStructuredPurchasedOrderItemsByUserID()
    {
        $structuredOrderItems = [];
        if (isset($_SESSION['user']) && isset($_SESSION['user']['userID'])) {
            $userID = $_SESSION['user']['userID'];
            $purchasedOrderItems = $this->myProgramService->getOrderItemsByUser($userID);

            foreach ($purchasedOrderItems as $orderitem) {
                $event_details = $this->ticketservice->getEventDetails($orderitem->getEventId());
                $structuredItem = [
                    'order_item_id' => $orderitem->getOrderItemId(),
                    'order_id' => $orderitem->getOrderId(),
                    'user_id' => $orderitem->getUserId(),
                    'quantity' => $orderitem->getQuantity(),
                    'date' => $orderitem->getDate(),
                    'start_time' => $orderitem->getStartTime(),
                    'end_time' => $orderitem->getEndTime(),
                    'item_hash' => $orderitem->getItemHash(),
                    'event_id' => $orderitem->getEventId(),
                    'location' => $orderitem->getLocation(),
                    'event_details' => [
                        'image' => $event_details['picture'] ?? null,
                        'event_name' => $event_details['name'] ?? null,
                    ],

                ];

                // Customize the structured item based on the event ID
                switch ($orderitem->getEventId()) {
                    case EVENT_ID_HISTORY: // History
                        $structuredItem['language'] = $orderitem->getLanguage();
                        break;
                    case EVENT_ID_RESTAURANT: // Yummy
                        $structuredItem['restaurant_name'] = $orderitem->getRestaurantName();
                        $structuredItem['special_remarks'] = $orderitem->getSpecialRemarks();
                        break;
                    case EVENT_ID_DANCE:
                    case EVENT_ID_JAZZ: // Events Dance and Jaz
                        $structuredItem['ticket_type'] = $orderitem->getTicketType();
                        $structuredItem['artist_name'] = $orderitem->getArtistName();
                        break;
                }

                $structuredOrderItems[] = $structuredItem;
            }
            // Filter the structured order items to include only those within the specified date range
            $filteredOrderedItems = array_filter($structuredOrderItems, function ($item) {
                // Convert the item's date to a timestamp for easy comparison
                $itemDateTimestamp = strtotime($item['date']);
                // Define the start and end of the desired date range
                $startDateTimestamp = strtotime("2024-06-26");
                $endDateTimestamp = strtotime("2024-06-30");
                // Include the item if its date is within the range
                return $itemDateTimestamp >= $startDateTimestamp && $itemDateTimestamp <= $endDateTimestamp;
            });

            // Return only the items that passed the filtering
            return $filteredOrderedItems;
        } else {
            return [];
        }
    }

}
