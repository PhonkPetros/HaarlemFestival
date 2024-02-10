<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;

require_once __DIR__ . '/../config/dbconfig.php';

class AdminRepository extends dbconfig {
    
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
    
}
