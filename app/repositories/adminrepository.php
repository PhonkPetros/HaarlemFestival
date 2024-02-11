<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use DateTime;
use repositories\registerrepository;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../repositories/registerrepository.php';

class AdminRepository extends dbconfig {
    
    private $registerRepo;

    public function __construct() {
        parent::__construct();
        $this->registerRepo = new RegisterRepository();
    }
    public function getAllUsers() {
        $users = [];

        try {
            $stmt = $this->connection->prepare("SELECT * FROM [User]");
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching users: " . $e->getMessage());
        }

        return $users;
    }

    public function filterUsers($username, $role) {
        $users = [];

        try {
            $sql = "SELECT * FROM [User] WHERE username LIKE :username AND role = :role";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':role', $role);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error filtering users: " . $e->getMessage());
        }
        return $users;
    }

    public function deleteUsers($userID) {
        try {
            $stmt = $this->connection->prepare("DELETE FROM [User] WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
        }
    }
    
    public function registerUser($username, $password, $role, $email) {
        if (!$this->registerRepo->usernameExists($username) && !$this->registerRepo->emailExists($email)) {
            $user_ID = 5; 
            $registration_date = new DateTime();
            $formatted_date = $registration_date->format('Y-m-d H:i:s');
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            try {
                $stmt = $this->connection->prepare("INSERT INTO [User] (e_mail, username, password, role, user_ID, registration_date) VALUES (:email, :username, :password, :role, :user_ID, :registration_date)");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
                $stmt->bindParam(':role', $role, PDO::PARAM_STR);
                $stmt->bindParam(':user_ID', $user_ID, PDO::PARAM_INT);
                $stmt->bindParam(':registration_date', $formatted_date, PDO::PARAM_STR);
                $stmt->execute();
                
                return true;
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return false;
            }
        } else {
            if ($this->registerRepo->usernameExists($username)) {
                error_log("Username already exists.");
            }
            if ($this->registerRepo->emailExists($email)) {
                error_log("Email already exists.");
            }
            return false;
        }
    }

    public function editUser($userid, $username, $email, $role) {
        $currentDetails = $this->getUserById($userid);
        if (!$currentDetails) {
            return ['success' => false, 'message' => 'User not found.'];
        }

        try {
            $stmt = $this->connection->prepare("UPDATE [User] SET username = :username, e_mail = :email, role = :role WHERE user_id = :userid");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
            $stmt->execute();
    
            return ['success' => true, 'message' => 'User information updated successfully.'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Failed to update user information. Error: ' . $e->getMessage()];
        }
    }
    
    
    public function getUserById($userid) {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM [User] WHERE user_id = :userid");
            $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
            $stmt->execute();
    
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ?: null;
        } catch (PDOException $e) {
            error_log('Error fetching user by ID: ' . $e->getMessage());
            return null;
        }
    }
    
    
}