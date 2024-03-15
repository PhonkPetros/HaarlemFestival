<?php

namespace Repositories;

use config\dbconfig;
use PDO;
use PDOException;
use DateTime;

require_once __DIR__ . '/../config/dbconfig.php';
class AccountRepository {

    private $db;

    public function __construct() {
        $dbConfig = new dbconfig();
        $this->db = $dbConfig->getConnection();

    }
    
    public function updateEmail($userId, $newEmail) {
        try {
            $sql = "UPDATE [User] SET email = ? WHERE user_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$newEmail, $userId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function updateUsername($userId, $newUsername) {
        try {
            $sql = "UPDATE [User] SET username = ? WHERE user_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$newUsername, $userId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function updatePassword($userId, $newPassword) {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE [User] SET password_hash = ? WHERE user_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$hashedPassword, $userId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Handle exception or log error
            throw $e;
        }
    }

    public function saveResetPasswordToken ($token, $email) {
        $stmt = $this->db->prepare('INSERT INTO password_reset_temp (email, key) VALUES (?, ?)');
        $stmt->execute([$token, $email]);
    }
}
