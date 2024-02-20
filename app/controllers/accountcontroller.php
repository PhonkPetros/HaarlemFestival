<?php

namespace controllers;

use services\registerservice;
use model\user;
use services\accountervice;

require_once __DIR__ . '/../services/accountservice.php';
require_once __DIR__ . '/../services/registerservice.php';
require_once __DIR__ . '/../model/user.php';
require_once __DIR__ . '/../controllers/smtpcontroller.php';


class AccountController
{
    private $registerService;
    private $accountService;
    private $user;
    private $smtpController;

    public function __construct()
    {
        
        $this->registerService = new registerservice();
        $this->accountService = new accountervice();
        $this->user = new user();
        $this->smtpController = new SMTPController();

        $this->user->setUserID($_SESSION['user']['userID']);
        $this->user->setPassword($_SESSION['user']['password_hash']);
        $this->user->setUserEmail($_SESSION['user']['email']);
        $this->user->setUsername($_SESSION['user']['username']);
    }



    public function show()
    {




        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['updateEmailBtn'])) {
                $this->updateEmail();
            } elseif (isset($_POST['updateUsernameBtn'])) {
                $this->updateUsername();
            } elseif (isset($_POST['updatePasswordBtn'])) {
                $this->updatePassword();
            }
        }

        require_once '../views/user/account.php';

        // if (isset($_SESSION['response'])) {
        //     unset($_SESSION['response']);
        // }

    }


    private function sendEmail($message)
    {
        $subject = 'Account Update Confirmation';
        $recipientEmail = $this->user->getUserEmail();
        $recipientName = $this->user->getUsername();

        return $this->smtpController->sendEmail($recipientEmail, $recipientName, $subject, $message);
    }



    public function updateUsername()
    {
        if (isset($_POST['updateUsername'])) {
            $newUsername = htmlspecialchars($_POST['updateUsername']);

            if ($this->registerService->username_exists($newUsername)) {
                $_SESSION['response'] = ['success' => false, 'message' => 'Username is already taken'];
            } elseif ($this->accountService->updateUsername($this->user->getUserID(), $newUsername)) {
                $message = 'Your username has been updated successfully.';
                if ($this->sendEmail($message)) {
                    $_SESSION['response'] = ['success' => true, 'message' => 'Username updated successfully'];
                } else {
                    $_SESSION['response'] = ['success' => false, 'message' => 'Failed to send confirmation email'];
                }
            } else {
                $_SESSION['response'] = ['success' => false, 'message' => 'Failed to update username'];
            }
        } else {
            $_SESSION['response'] = ['success' => false, 'message' => 'Username field is empty'];
        }

        header('Location: /account');
        exit;
    }


    public function updateEmail()
    {
        if (isset($_POST['updateEmail'])) {
            $newEmail = htmlspecialchars($_POST['updateEmail']);
            if ($this->registerService->email_exists($newEmail)) {
                $_SESSION['response'] = ['success' => false, 'message' => 'Email is already taken'];
            } elseif ($this->accountService->updateEmail($this->user->getUserID(), $newEmail)) {
                $message = 'Your email address has been updated successfully.';
                $this->user->setUserEmail($newEmail);
                if ($this->sendEmail($message)) {
                    $_SESSION['response'] = ['success' => true, 'message' => 'Email updated successfully'];
                } else {
                    $_SESSION['response'] = ['success' => false, 'message' => 'Failed to send confirmation email'];
                }
            } else {
                $_SESSION['response'] = ['success' => false, 'message' => 'Failed to update email'];
            }
        } else {
            $_SESSION['response'] = ['success' => false, 'message' => 'Email field is empty'];
        }

        header('Location: /account');
        exit;
    }


    public function updatePassword()
    {
        if (isset($_POST['oldPassword'], $_POST['newPassword'])) {
            $oldPassword = htmlspecialchars($_POST['oldPassword']);
            $newPassword = htmlspecialchars($_POST['newPassword']);
            $currentHashedPassword = $this->user->getPassword();
    
            if (!password_verify($oldPassword, $currentHashedPassword)) {
                $_SESSION['response'] = ['success' => false, 'message' => 'Old password is incorrect'];
            } elseif ($this->accountService->updatePassword($this->user->getUserID(), $newPassword)) {
                $message = 'Your password has been updated successfully.';
                if ($this->sendEmail($message)) {
                    $_SESSION['response'] = ['success' => true, 'message' => 'Password updated successfully'];
                } else {
                    $_SESSION['response'] = ['success' => false, 'message' => 'Failed to send confirmation email'];
                }
            } else {
                $_SESSION['response'] = ['success' => false, 'message' => 'Failed to update password'];
            }
        } else {
            $_SESSION['response'] = ['success' => false, 'message' => 'Password fields are empty'];
        }
    
        header('Location: /account');
        exit;
    }
    
}
