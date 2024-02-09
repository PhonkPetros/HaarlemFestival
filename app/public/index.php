<?php

use controllers\home;


$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    
    case '/':
        require_once '../controllers/home.php';
        $controller = new home();
        $controller->show();
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}
?>

