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
    private $smtpController;


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
        $structuredOrderedItems = [];
        $uniqueTimes = [];

        if (isset ($_SESSION['shopping_cart']) && !empty ($_SESSION['shopping_cart'])) {
            $structuredTickets = $this->structureTicketsWithImages();

        }

        $userId = $_SESSION['user']['userID'] ?? null;
        $reservedTickets = $this->ticketservice->getReservedTicketsByUserId($userId) ?: [];

        $structuredOrderedItems = $this->getStructuredPurchasedOrderItemsByUserID();

        require_once __DIR__ . "/../views/my-program/overview.php";

    }


    function showPayment()
    {
        $this->navigationController->displayHeader();
        $structuredTickets = [];
        $uniqueTimes = [];
        $userInfo = $this->getUserInfoFromCart();

        $userId = $_SESSION['user']['userID'] ?? null;
        $reservedTickets = $this->ticketservice->getReservedTicketsByUserId($userId) ?: [];
        $userDetails = $this->ticketservice->getUserDetails($userId);

        if (isset ($_SESSION['shopping_cart']) && !empty ($_SESSION['shopping_cart'])) {
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
            'ticketPrice' => $input['ticketPrice'] ?? 0, // Assuming default price is 0 if not provided
            'quantity' => $input['quantity'] ?? 0, // Assuming default quantity is 0 if not provided
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

    //updates user info in database
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


    //creates a shopping cart if a shopping cart does not exist in the session data
    function createShoppingCart()
    {
        if (!isset ($_SESSION['shopping_cart'])) {
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

    function getUserInfoFromCart()
    {
        if (isset($_SESSION['shopping_cart']) && is_array($_SESSION['shopping_cart']) && !empty($_SESSION['shopping_cart'])) {
            foreach ($_SESSION['shopping_cart'] as $item) {
                if (isset($item['user'])) {
                    return $item['user'];
                }
            }
        }
        return null;
    }


    


    //creating a new payment
    function initiatePayment()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!is_array($data) || !isset($data['ticketsInfo'], $data['ticketsInfo']['ticketDetails'][0])) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ticket data.']);
            exit;
        }

        // Extract the first ticketDetails item to validate it has ticketId and quantity
        $firstTicketDetail = $data['ticketsInfo']['ticketDetails'][0];
        if (!isset($firstTicketDetail['ticketId']) || !isset($firstTicketDetail['quantity'])) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ticket data.']);
            exit;
        }

        $userId = $_SESSION['user']['userID'];
        $userDetails = $this->ticketservice->getUserDetails($userId);

        if (!$userDetails || !$this->userService->email_exists($userDetails->getUserEmail())) {
            echo json_encode(['status' => 'error', 'message' => 'User needs to register.']);
            exit;
        }

        $shoppingCart = [
            'ticketDetails' => $data['ticketsInfo']['ticketDetails'],
            'userDetails' => [
                'username' => $userDetails->getUsername(),
                'lastname' => $userDetails->getLastname(),
                'email' => $userDetails->getUserEmail(),
                'phoneNumber' => $userDetails->getPhoneNumber()
            ]
        ];

        $_SESSION['shopping_cart'] = $shoppingCart; 

            if (!$this->checkTicketsAvailability($shoppingCart['ticketDetails'])) {
                echo json_encode(['status' => 'error', 'message' => 'Some tickets are not available in the requested quantity.']);
                exit;
            }

            $paymentResult = $this->mollieAPIController->createPayment($userId, $shoppingCart['ticketDetails'], $data['paymentMethod'], $data['issuer']);

            if ($paymentResult['status'] === 'success') {
                echo json_encode(['status' => 'success', 'paymentUrl' => $paymentResult['paymentUrl']]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Payment initiation failed.']);
            }
            exit;
    }


    //if the mollie api returns with a good response then 
    public function paymentSuccess()
    {
        // Start the session if it hasn't been started already
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the payment ID is stored in the session
        if (!isset ($_SESSION['payment_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Payment ID is required.']);
            exit;
        }

        // Retrieve the payment ID from the session
        $paymentId = $_SESSION['payment_id'];

        // Retrieve the payment status using the payment ID
        $paymentStatus = $this->mollieAPIController->getPaymentStatus($paymentId);

        if ($paymentStatus !== 'paid') {
            // Redirect to a failure page or handle the failure scenario
            header('Location: http://localhost/my-program/payment-failure');
            exit;
        }

        // If payment is successful, proceed with the existing code
        $userId = $_SESSION['user']['userID'];
        $orderProcessingResult = $this->myProgramService->processOrder($userId, $_SESSION['shopping_cart'], $paymentStatus);

        if ($orderProcessingResult['status'] === 'success') {
            // Empty the shopping cart session data after successful order processing
            $_SESSION['shopping_cart'] = [];
            header('Location: http://localhost/my-program/order-confirmation');
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
        if (isset ($_SESSION['user']) && isset ($_SESSION['user']['userID'])) {
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


    public function fetchTicketDetails()
    {
        header('Content-Type: application/json');

        $userId = $_SESSION['user']['userID'] ?? null;

        if (is_null($userId)) {
            echo json_encode(['status' => 'error', 'message' => 'No user session found.']);
            exit;
        }

        $ticketsInCart = $this->ticketservice->getReservedTicketsByUserId($userId);

        if ($ticketsInCart === null) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to retrieve tickets from the cart.']);
            exit;
        }

        // Convert ticket details to a JSON-friendly structure
        $ticketDetails = [];
        foreach ($ticketsInCart as $ticket) {
            $ticketDetails[] = [
                'ticketId' => $ticket->getTicketId(),
                'date' => $ticket->getTicketDate(),
                'time' => $ticket->getTicketTime(),
                'ticketPrice' => $ticket->getPrice(),
                'quantity' => $ticket->getQuantity(),
                'specialRequest' => $ticket->getSpecialRequest(),
            ];
        }

        echo json_encode(['status' => 'success', 'ticketDetails' => $ticketDetails]);
        exit;
    }


}


