<?php

namespace controllers;

use services\registerservice;

require_once __DIR__ . '/../services/registerservice.php';

class registercontroller
{
    private $registerService;
  
    public function __construct() {
        $this->registerService = new registerservice();
    }

    public function show()
    {
        require_once '../views/register.php';
    }

    public function registerAction() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $captchaResponse = $_POST['g-recaptcha-response'];
            $secretKey = "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe"; 
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$captchaResponse}");
            $responseKeys = json_decode($response, true);

            if (!$responseKeys["success"]) {
                $registrationStatus = "CAPTCHA verification failed. Please try again.";
                require_once '../views/register.php';
                return;
            }

            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $email = htmlspecialchars($_POST['email']);
        
            if (!$this->registerService->username_exists($username) && !$this->registerService->email_exists($email)) {
                $this->registerService->register($username, $password, $email);
                header('Location: /login'); 
                exit;
            } else {
                $registrationStatus = "Username already exists. Please choose a different one.";
                require_once '../views/register.php';
            }
        }
    }
}
