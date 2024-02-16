<?php

namespace controllers;

use services\loginService;
require_once __DIR__ . '/../services/loginservice.php';

class logincontroller
{
    private $loginService;
  
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

            if (!$authenticated) {
                $loginError = "Invalid username or password.";
                require_once '../views/login.php'; 
            }
        }
    }

    private function authenticateLogin($username, $password)
    {
        $user = $this->loginService->login($username, $password);
        if ($user) {
            $_SESSION['email'] = $user->getUserEmail();
            $_SESSION['user'] = [
                'userID' => $user->getUserId(),
                'username' => $user->getUsername(),
                'role' => $user->getUserRole(),
                'email' => $user->getUserEmail(),
                'password_hash' => $user->getPassword()
            ];
            $_SESSION['role'] = $user->getUserRole();
            header('Location: /');
            exit();
        } else {
            return false;
        }
    }
}
