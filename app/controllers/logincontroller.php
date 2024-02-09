<?php

namespace controllers;
use services\loginService;
require_once __DIR__ . '/../services/loginservice.php';


class logincontroller
{
    public $loginService;
  
    public function __construct() {
        $this->loginService = new LoginService();
    }

    public function show()
    {
        require_once '../views/login.php';
    }

    public function loginAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = htmlspecialchars($_POST["username"]);
            $password = htmlspecialchars($_POST["password"]);
            $this->authenticateLogin($username, $password);
        }
    }

    public function authenticateLogin($username, $password)
    {
        $user = $this->loginService->login($username, $password);
        if ($user) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user'] = $user;
          header('Location: /');
            return true;

        } else {
            return false;
        }
   
    }
}