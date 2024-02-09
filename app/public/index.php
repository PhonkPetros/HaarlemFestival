<?php

use controllers\home;
use controllers\logincontroller;
use controllers\registercontroller;

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    
    case '/':
        require_once '../controllers/home.php';
        $controller = new home();
        $controller->show();
        break;
    case '/login':
        require_once '../controllers/logincontroller.php';
        $controller = new logincontroller();
        $controller->show();
        break;
    case '/register':
        require_once '../controllers/registercontroller.php';
        $controller = new registercontroller();
        $controller->show();
        break;         
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}
