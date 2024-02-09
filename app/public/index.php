<?php
session_start(); 

use controllers\home;
use controllers\logincontroller;
use controllers\registercontroller;


require_once __DIR__ . '/../controllers/home.php';
require_once __DIR__ . '/../controllers/registercontroller.php';
require_once __DIR__ . '/../controllers/logincontroller.php';


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
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}
