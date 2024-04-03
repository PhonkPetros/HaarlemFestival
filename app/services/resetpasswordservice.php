<?php

namespace services;
use repositories\accountrepository;
use controllers\SMTPController;

class ResetPasswordService {
    private $repository;
    private $smtpController;

    public function __construct() {
        $this->repository = new accountrepository();
        $this->smtpController = new SMTPController();
    }

    public function resetPassword($email) {

        // Generate a unique token
        $token = bin2hex(random_bytes(32));
    
        $result = $this->repository->saveResetPasswordToken($token, $email);

        if ($result) {
            // Compose the email message
            $subject = "Password Reset";
            $message = "Click the following link to reset your password: http://localhost/new-password/?token=$token";

            // Send the email
            $sent = $this->smtpController->sendEmail($email, "Haarlem Visitor", $subject, $message, null);

            if ($sent) {
                return true; // Password reset email sent successfully
            } else {
                return false; // Error sending email
            }
        } else {
            return false;
        }
    }

    public function renewPassword($token, $newPassword) {
        return $this->repository->renewPassword($token, $newPassword);
    }
}