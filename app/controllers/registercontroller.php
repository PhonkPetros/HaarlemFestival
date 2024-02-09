<?php

namespace controllers;
use model\user;

use services\registerservice;

require_once __DIR__ . '/../services/registerservice.php';

class registercontroller
{

    public $registerService;
  
    public function __construct() {
        $this->registerService = new registerservice();
    }

    public function show()
    {
        require_once '../views/register.php';
    }
    public function registerAction() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $email = htmlspecialchars($_POST['email']);
        
            if (!$this->registerService->username_exists($username)) {
                $this->registerService->register($username, $password, $email);
                header('Location: /login'); 
                exit;
            } else {
                echo "Error occurred when creating user";
            }
        }
    }
    

}
