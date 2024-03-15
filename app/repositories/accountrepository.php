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
        $sql = "SELECT email FROM [User] WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $stmt = $this->db->prepare('INSERT INTO password_reset_temp (email, "key") VALUES (?, ?)');
            $stmt->execute([$email, $token]);
            return true;
        } else {
            return false;
        }
    }

    public function renewPassword($token, $newPassword) {
        $sql = "SELECT email FROM password_reset_temp WHERE [key] = :token";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE [User] SET password_hash = ? WHERE email = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$hashedPassword, $row['email']]);
            
            return $stmt->rowCount() > 0;
        } else {
            return false;
        }
    }
}
