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

    public function showResetPasswordForm()
    {
        require_once '../views/reset-password.php';
    }

    public function showNewPasswordForm()
    {
        require_once '../views/new-password.php';
    }

    public function resetpasswordAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = htmlspecialchars($_POST["email"]);
        }
    }

    public function checkToken() {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $email = htmlspecialchars($_GET["token"]);
        }
        
    }
}