<?php

use controllers\home;
use controllers\overview;


$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    
    case '/':
        require_once '../controllers/home.php';
        $controller = new home();
        $controller->show();
        break;
    case '/festival':
        require_once '../controllers/overview.php';
        $controller = new overview();
        $controller->show();
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}
?>

