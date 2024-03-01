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
use controllers\Navigationcontroller;
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
require_once __DIR__ . '/../controllers/navigationcontroller.php';

$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

//Please do not touch this
$queryString = parse_url($request, PHP_URL_QUERY);
$queryParams = [];
if ($queryString !== null) {
    parse_str($queryString, $queryParams);
}
$pageID = htmlspecialchars($queryParams["pageid"] ?? '');
$eventID = null;
if (strpos($request, '/manage-event-details/') === 0) {
    $eventID = htmlspecialchars($queryParams["id"] ?? '');
}

//Please do not touch this
if ($request === '/') {
    $pageID = '1';
}

if ($pageID || $eventID) {
    //this has to do with the editing of event details
    if ($eventID) {
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
        exit;
    } elseif ($pageID) {
        //this has to with our own pages
        switch ($pageID) {
            case "1":
                $controller = new overview();
                $controller->show();
                break;
            case '2':
                $controller = new Historycontroller();
                if ($method === 'GET') {
                    $controller->show();
                }
                break;
            case '3':
                $controller = new Dancecontroller();
                if ($method === 'GET') {
                    $controller->show();
                }
                break;
            case '4':
                $controller = new Jazzcontroller();
                if ($method === 'GET') {
                    $controller->show();
                }
                break;
            // case '5':
            //     $controller = new Jazzcontroller();
            //     if ($method === 'GET') {
            //         $controller->show();
            //     }
            //     break;
            case '6':
                $controller = new Historycontroller();
                if ($method === 'GET') {
                    $controller->showProveniershof();
                }
                break;
            case '7':
                $controller = new Historycontroller();
                if ($method === 'GET') {
                    $controller->showChurch();
                }
                break;
            default;
                //change this to use template controller
                http_response_code(404);
                $navigation = new Navigationcontroller();
                $navigation->displayHeader();
                require __DIR__ . '/../views/404.php';
              break;
        }
        exit;
    }
}

//Add routes for actions or admin routes that do not have to do with displaying detail pages or overview pages for your individual events
switch ($request) {
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
    case '/admin/page-management/editfestival':
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
        if ($method === 'POST') {
            $controller->removeTimeslot();
        }
        break;
    default:
        http_response_code(404);
        $navigation = new Navigationcontroller();
        $navigation->displayHeader();
        require __DIR__ . '/../views/404.php';
        break;
}



