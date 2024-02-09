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
            $authenticated = $this->authenticateLogin($username, $password);
        }
        if (!$authenticated) {
            $loginError = "Invalid username or password.";
            require_once '../views/login.php'; 
        }
        
    }

    public function authenticateLogin($username, $password)
    {
        $user = $this->loginService->login($username, $password);
        if ($user) {
            $_SESSION['user'] = $user; 
            $_SESSION['role'] = $user->role; 
            header('Location: /');
            exit();
        } else {
            return false;
        }
    }
    
}