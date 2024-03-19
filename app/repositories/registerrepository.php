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

    public function getUserIDThroughEmail($email) {
        try {
            $stmt = $this->connection->prepare("SELECT user_id FROM [User] WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ? $user['user_id'] : false;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

    public function registerUser($newuser) {
        $username = $newuser->getUsername();
        $email = $newuser->getUserEmail();
        $password = $newuser->getPassword(); 
        $role = "customer";

        if (!$this->usernameExists($username) && !$this->emailExists($email)) {
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
            echo "Username or email already exists.";
            return false;
        }
    }

    public function updateUser($userInfo)
    {
        $email = $userInfo['email'];
        $firstName = $userInfo['firstName'];
        $lastName = $userInfo['lastName'];
        $address = $userInfo['address'];
        $phoneNumber = $userInfo['phoneNumber'];

        try {
            $stmt = $this->connection->prepare("UPDATE [User] SET firstname = :firstName, lastname = :lastName, address = :address, phone_number = :phoneNumber WHERE email = :email");
            $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
            $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


}
