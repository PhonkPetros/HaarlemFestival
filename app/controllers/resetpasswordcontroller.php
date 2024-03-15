<?php

namespace controllers;

use services\ResetPasswordService;
require_once __DIR__ . '/../services/resetpasswordservice.php';

class resetpasswordcontroller
{
    private $resetpasswordService;
  
    public function __construct() {
        $this->resetpasswordService = new ResetPasswordService();
    }

    public function showResetPasswordForm()
    {
        require_once '../views/general_views/reset-password.php';
    }

    public function showNewPasswordForm()
    {
        require_once '../views/general_views/new-password.php';
    }

    public function successfulNewPassword ()
    {
        require_once'../views/general_views/password-updated.php';
    }

    public function showLinkSuccessfullySent()
    {
        require_once'../views/general_views/reset-link-sent.php';

    }

    public function showInvalidEmail()
    {
        require_once'../views/general_views/invalid-email.php';
    }

    public function resetpasswordAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = htmlspecialchars($_POST["email"]);
            $result = $this->resetpasswordService->resetPassword($email);

            if ($result) {
                $this->showLinkSuccessfullySent();
            } else {
                $this->showInvalidEmail();
            }
        }
    }

    public function updatePasswordAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $token = htmlspecialchars($_POST["token"]);
            $newPassword = htmlspecialchars($_POST["newPassword"]);

            $result = $this->resetpasswordService->renewPassword($token, $newPassword);

            if ($result) {
                $this->successfulNewPassword();
            } else {
                echo 'Reset password failed';

            }
        }
    }
}