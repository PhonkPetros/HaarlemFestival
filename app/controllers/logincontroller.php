<?php

namespace controllers;

use services\loginService;

require_once __DIR__ . '/../services/loginservice.php';

class logincontroller
{
    private $loginService;

    public function __construct()
    {
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
            $_SESSION['user'] = [
                'userID' => $user->getUserId(),
                'username' => $user->getUsername(),
                'role' => $user->getUserRole(),
                'email' => $user->getUserEmail(),
                'password_hash' => $user->getPassword(),
                'firstName' => $user->getFirstname(),
                'lastName' => $user->getLastname(),
                'phoneNumber' => $user->getPhoneNumber(),
                'address' => $user->getAddress()
            ];
    
            $_SESSION['role'] = $user->getUserRole();
            if (isset($_SESSION['shopping_cart'])) {
                foreach ($_SESSION['shopping_cart'] as &$item) {
                    $item['user'] = $_SESSION['user'];
                }
                unset($item);
            }
    
            switch ($_SESSION['role']) {
                case 'customer':
                    header('Location: /');
                    exit();
                case 'admin':
                    header('Location: /admin/dashboard');
                    exit();
                default:
                    header('Location: /');
                    exit();
            }
        } else {
            return false;
        }
    }
    

}
