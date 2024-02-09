<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use DateTime;

require_once __DIR__ . '/../config/dbconfig.php';

class registerrepository extends dbconfig {
    
    public function usernameExists($username) {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM [User] WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    public function registerUser($username, $password, $email) {
        if (!$this->usernameExists($username)) {
            $user_ID = 2; // Also, ensure this is supposed to be static or if it should be dynamically set
            $role = "customer";
            $registration_date = new DateTime();
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            try {
                $stmt = $this->connection->prepare("INSERT INTO [User] (e_mail, username, password, role, user_ID, registration_date) VALUES (:email, :username, :password, :role, :user_ID, :registration_date)");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
                $stmt->bindParam(':role', $role, PDO::PARAM_STR);
                $stmt->bindParam(':user_ID', $user_ID, PDO::PARAM_INT); // Changed to :user_ID to match the SQL placeholder
                $stmt->bindParam(':registration_date', $registration_date->format('Y-m-d H:i:s'), PDO::PARAM_STR);
                $stmt->execute();
                
                return true;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false;
            }
        } else {
            echo "Username already exists.";
            return false;
        }
    }
    
}
