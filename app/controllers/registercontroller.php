<?php

namespace controllers;

use services\registerservice;
use model\User;

require_once __DIR__ . '/../services/registerservice.php';
require_once __DIR__ . '/../model/user.php';

class registercontroller
{
    private $registerService;
    private $user;
  
    public function __construct() {
        $this->registerService = new registerservice();
        $this->user = new User();
    }

    public function show()
    {
        require_once '../views/register.php';
    }

    public function registerAction() {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $captchaResponse = filter_input(INPUT_POST, 'g-recaptcha-response', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $secretKey = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe'; 
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$captchaResponse}");
            $responseKeys = json_decode($response, true);
    
            if (!$responseKeys["success"]) {
                $registrationStatus = "CAPTCHA verification failed. Please try again.";
                require_once '../views/register.php';
                return;
            }
    
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $passwordRaw = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    
            // Ensure email is valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $registrationStatus = "Invalid email address. Please provide a valid email.";
                require_once '../views/register.php';
                return;
            }
    
            $hashedPassword = password_hash($passwordRaw, PASSWORD_DEFAULT); 
    
            $newUser = new User();
            $newUser->setUsername($username);
            $newUser->setPassword($hashedPassword);
            $newUser->setUserEmail($email);
    
            if (!$this->registerService->username_exists($username) && !$this->registerService->email_exists($email)) {
                $this->registerService->register($newUser);
                header('Location: /login');
                exit;
            } else {
                $registrationStatus = "Username or email already exists. Please choose a different one.";
                require_once '../views/register.php';
            }
        }
    }
    
}
