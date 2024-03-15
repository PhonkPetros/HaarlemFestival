<?php

namespace services;
use repositories\accountrepository;

class ResetPasswordService {
    private $repository;

    public function __construct() {
        $this->repository = new accountrepository();
    }

    public function resetPassword($email) {

        // Generate a unique token
        $token = bin2hex(random_bytes(32));
    
        $repository->saveResetPasswordToken($token, $email);
    
        // Compose the email message
        $subject = "Password Reset";
        $message = "Click the following link to reset your password: http://localhost/reset?token=$token";
    
        // Send the email
        $sent = $this->sendEmail($email, $subject, $message);
    
        if ($sent) {
            return true; // Password reset email sent successfully
        } else {
            return false; // Error sending email
        }
    }
    
    private function sendEmail($to, $subject, $message) {
        // Implement email sending logic here
        // Return true if email sent successfully, false otherwise
    }
}