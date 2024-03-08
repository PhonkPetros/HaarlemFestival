<?php

namespace controllers;

use services\resetpasswordService;
require_once __DIR__ . '/../services/resetpassword.php';

class resetpasswordcontroller
{
    private $resetpasswordService;
  
    public function __construct() {
        $this->resetpasswordService = new resetpasswordService();
    }

    public function show()
    {
        require_once '../views/reset-password.php';
    }

    public function resetpasswordAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = htmlspecialchars($_POST["email"]);
            $newPassword = htmlspecialchars($_POST["newPassword"]);

            if (!$authenticated) {
                $loginError = "Invalid username or password.";
                require_once '../views/login.php'; 
            }
        }
    }
}