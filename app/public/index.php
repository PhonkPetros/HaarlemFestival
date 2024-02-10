<?php
session_start();

use controllers\home;
use controllers\logincontroller;
use controllers\Logoutcontroller;
use controllers\registercontroller;
use controllers\admincontroller;
use controllers\accountcontroller;


require_once __DIR__ . '/../controllers/home.php';
require_once __DIR__ . '/../controllers/registercontroller.php';
require_once __DIR__ . '/../controllers/logincontroller.php';
require_once __DIR__ . '/../controllers/logoutcontroller.php';
require_once __DIR__ . '/../controllers/admincontroller.php';
require_once __DIR__ . '/../controllers/accountcontroller.php';



$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD']; 

switch ($request) {
    case '/':
        $controller = new home();
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
    case '/admin/edit-user':
        $controller = new admincontroller();
        if ($method === 'POST' && isset($_POST['user_id'])) {
            $controller->editUsers($_POST['user_id']);
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
        if ($method === 'POST') {
            $controller->getAllUsers();
        }
        break;
    case '/account':
        $controller = new accountcontroller();
        if ($method === 'GET') {
            $controller->show();
        }
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/../views/404.php';
        break;
    
}
