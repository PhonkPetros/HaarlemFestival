<?php

namespace controllers;

use services\Myprogramservice;
use services\registerservice;

require_once __DIR__ . '/../services/myprogramservice.php';
require_once __DIR__ . '/../services/registerservice.php';
require_once __DIR__ . '/../config/constant-paths.php';


class Myprogramcontroller
{

    private $myProgramService;
    private $userService;
    private $navcontroller;


    public function __construct()
    {
        $this->myProgramService = new Myprogramservice();
        $this->userService = new registerservice();
        $this->navcontroller = new NavigationController();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
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
                $item['ticketTime'] == $ticketInfo['ticketTime']
            ) {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'message' => 'This ticket is already in your shopping cart.',
                ]);
                exit;
            }
        }

        $_SESSION['shopping_cart'][] = $ticketInfo;

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'message' => 'Reservation successfully created!',
        ]);
        exit;
    }

    function updateUserInfo(){
        
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

    function showMyprogram()
    {
        $navigationController = $this->navcontroller->displayHeader();
        require_once __DIR__ ."/../views/my-program/overview.php";
    }

}
