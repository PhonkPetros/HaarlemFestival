<?php
session_start();

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

//First checking for event id's for the manage event detail pages
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
    //else if the event ID is not set
    //This should also be modified so it checks for cases where the page id matches
    // for other routes that handles actions such as "'/editDetailsHistory/deleteTimeSlot':"
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
