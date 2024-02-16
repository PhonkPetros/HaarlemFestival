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
                $response['message'] = 'Username is already taken';
                echo json_encode($response);
                exit;
            }
            if ($this->accountService->updateUsername($this->user->getUserID(), $newUsername)) {
                $response['success'] = true;
                $this->sendEmail('Your username has been updated successfully.');
                $response['message'] = 'Username updated successfully';
            } else {
                $response['message'] = 'Failed to update username';
            }
        } else {
            $response['message'] = 'Username field is empty';
        }

        echo json_encode($response);
        exit;
    }

    public function updateEmail()
    {
        $response = ['success' => false, 'message' => ''];

        if (isset($_POST['updateEmail'])) {
            $newEmail = htmlspecialchars($_POST['updateEmail']);

            if ($this->registerService->email_exists($newEmail)) {
                $response['message'] = 'Email is already taken';
                echo json_encode($response);
                exit;
            }

            if ($this->accountService->updateEmail($this->user->getUserID(), $newEmail)) {
                $message = 'Your email address has been updated successfully.';
                if ($this->sendEmail($message)) {
                    $response['success'] = true;
                    $response['message'] = 'Email updated successfully';
                } else {
                    $response['message'] = 'Failed to send confirmation email';
                }
            } else {
                $response['message'] = 'Failed to update email';
            }
        } else {
            $response['message'] = 'Email field is empty';
        }

        echo json_encode($response);
        exit;
    }

    public function updatePassword()
    {
        $response = ['success' => false, 'message' => ''];

        if (isset($_POST['oldPassword'], $_POST['newPassword'])) {
            $oldPassword = htmlspecialchars($_POST['oldPassword']);
            $newPassword = htmlspecialchars($_POST['newPassword']);

            $currentHashedPassword = $this->user->getPassword();

            if (!password_verify($oldPassword, $currentHashedPassword)) {
                $response['message'] = 'Old password is incorrect';
                echo json_encode($response);
                exit;
            }

            if ($this->accountService->updatePassword($this->user->getUserID(), $newPassword)) {
                $message = 'Your password has been updated successfully.';
                if ($this->sendEmail($message)) {
                    $response['success'] = true;
                    $response['message'] = 'Password updated successfully';
                } else {
                    $response['message'] = 'Failed to send confirmation email';
                }
            } else {
                $response['message'] = 'Failed to update password';
            }
        } else {
            $response['message'] = 'Password fields are empty';
        }

        echo json_encode($response);
        exit;
    }
}
