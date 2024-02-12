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

    public function emailExists($email) {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM [User] WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function registerUser($username, $password, $email) {
        if (!$this->usernameExists($username) && !$this->emailExists($email)) {
            $role = "customer";
            $registration_date = new DateTime();
            $formatted_date = $registration_date->format('Y-m-d H:i:s');
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            try {
                $stmt = $this->connection->prepare("INSERT INTO [User] (email, username, password_hash, role, created_at) VALUES (:email, :username, :password_hash, :role, :created_at)");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':password_hash', $hashed_password, PDO::PARAM_STR);
                $stmt->bindParam(':role', $role, PDO::PARAM_STR);
                $stmt->bindParam(':created_at', $formatted_date, PDO::PARAM_STR);
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
