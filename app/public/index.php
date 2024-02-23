<?php
session_start();

// router needs to be changed sligthly
// for the edit event pages instead of sending the event name and through that way routiung the route to the controller 
// it should not be done like that. instead it should be done through utilising the event id
// this should also should be done for all the pages meaning that changes to the database should be done
// that way lets say a new page is added, then we can have a case in the switch case where if the page id does not match anything predifened
// then it sets it to a template controller that has all the base logic to load the page with the correct content as it will do so
// by utilizing the page id. 
// The router shouldnt change that much I want it to still be a simple switch case router but now instead of utilizing the names of the events
// using the event ids or the page ids to define the routes
// doing so will allow for more dynamic possibilities. 
//utilising the event id should only be done for the handling of event details
// page id should be used for modifying content of a page and for all the routes to view event pages that users would view 
// and again to do this we would have to completely change how the database is currently structured. 

use controllers\logincontroller;
use controllers\Logoutcontroller;
use controllers\registercontroller;
use controllers\admincontroller;
use controllers\Dancecontroller;
use controllers\Jazzcontroller;
use controllers\Restaurantcontroller;
use controllers\Historycontroller;
use controllers\accountcontroller;
use controllers\overview;

require_once __DIR__ . '/../controllers/overview.php';
require_once __DIR__ . '/../controllers/registercontroller.php';
require_once __DIR__ . '/../controllers/logincontroller.php';
require_once __DIR__ . '/../controllers/logoutcontroller.php';
require_once __DIR__ . '/../controllers/admincontroller.php';
require_once __DIR__ . '/../controllers/accountcontroller.php';
require_once __DIR__ . '/../controllers/restaurantcontroller.php';
require_once __DIR__ . '/../controllers/historycontroller.php';
require_once __DIR__ . '/../controllers/dancecontroller.php';
require_once __DIR__ . '/../controllers/jazzcontroller.php';

$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if (strpos($request, '/manage-event-details/') === 0) {
    parse_str(parse_url($request, PHP_URL_QUERY), $queryParams);
    $eventID = htmlspecialchars($queryParams["id"] ?? ''); 

    switch ($eventID) {
        case "5":
            $controller = new Dancecontroller();
            if ($method === 'GET') {
                $controller->editEventDetails();
            }
            break;
        case '6':
            $controller = new Jazzcontroller();
            if ($method === 'GET') {
                $controller->editEventDetails();
            }
            break;
        case '7':
            $controller = new Restaurantcontroller();
            if ($method === 'GET') {
                $controller->editEventDetails();
            }
            break;
        case '8':
            $controller = new Historycontroller();
            if ($method === 'GET') {
                $controller->showeditEventDetails();
            }
            break;
        default:
            //$controller = new TemplateController();
            if ($method === 'GET') {
                $controller->editEventDetails();
            }
            break;
    }
} else {
    switch ($request) {
        case '/':
            $controller = new overview();
            $controller->show();
            break;
        case '/login':
            $controller = new logincontroller();
            if ($method === 'GET') {
                $controller->show();
            } elseif ($method === 'POST') {
                $controller->loginAction();
            }
            break;
        case '/register':
            $controller = new registercontroller();
            if ($method === 'GET') {
                $controller->show();
            } elseif ($method === 'POST') {
                $controller->registerAction();
            }
            break;
        case '/logout':
            $logoutController = new Logoutcontroller();
            $logoutController->logout();
            break;
        case '/admin/dashboard':
            $controller = new admincontroller();
            if ($method === 'GET') {
                $controller->show();
            }
            break;
        case '/admin/manage-users':
            $controller = new admincontroller();
            if ($method === 'GET') {
                $controller->manageUsers();
            }
            break;
        case '/admin/delete-user':
            $controller = new admincontroller();
            if ($method === 'POST' && isset($_POST['user_id'])) {
                $controller->deleteUsers();
            }
            break;
        case '/admin/filter-users':
            $controller = new admincontroller();
            if ($method === 'POST') {
                $controller->filterUsers();
            }
            break;
        case '/admin/fetch-all-users':
            $controller = new admincontroller();
            if ($method === 'GET') {
                $controller->getAllUsers();
            }
            break;
        case '/account':
            $controller = new accountcontroller();
            $controller->show();
            break;
        case '/admin/add-user':
            $controller = new admincontroller();
            if ($method === 'POST') {
                $controller->addUsers();
            }
            break;
        case '/admin/edit-user':
            $controller = new admincontroller();
            if ($method === 'POST') {
                $controller->editUsers();
            }
            break;
        case '/admin/managefestival':
            $controller = new admincontroller();
            if ($method === 'GET') {
                $controller->manageFestivals();
            }
            break;
        case '/admin/editfestival':
            $controller = new admincontroller();
            if ($method === 'GET') {
                $controller->editFestivals();
            }
            break;
        case '/admin/orders':
            $controller = new admincontroller();
            if ($method === 'GET') {
                $controller->manageOrders();
            }
            break;
        case '/history/overview':
            $controller = new Historycontroller();
            if ($method === 'GET') {
                $controller->show();
            }
            break;
        case '/history/proveniershof':
            $controller = new Historycontroller();
            if ($method === 'GET') {
                $controller->showProveniershof();
            }
            break;
        case '/history/churchbravo':
            $controller = new Historycontroller();
            if ($method === 'GET') {
                $controller->showChurch();
            }
            break;
        case '/editDetailsHistory/addNewTimeSlot':
            $controller = new Historycontroller();
            if ($method === 'POST') {
                $controller->addNewTimeSlot();
            }
            break;
        case '/editDetailsHistory/editEventDetails':
            $controller = new Historycontroller();
            if ($method === 'POST') {
                $controller->editEventDetails();
            }
            break;
        case '/editDetailsHistory/deleteTimeSlot':
            $controller = new Historycontroller();
            if ($method === 'POST'){
                $controller->removeTimeslot();
            }    
        default:
            http_response_code(404);
            require __DIR__ . '/../views/404.php';
            break;
    }
}
