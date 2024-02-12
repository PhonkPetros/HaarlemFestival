<?php

namespace repositories;

use PDO;
use PDOException;
use DateTime;
use model\User; 
use config\dbconfig;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/user.php';

class Loginrepository extends dbconfig {

    public function login($username, $password)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM [User] WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                $currentUser = new User();
                $currentUser->userID = $user['user_id'];
                $currentUser->ticketID = $user['ticket_id'] ?? 0;
                $currentUser->username = $user['username'];
                $currentUser->role = $user['role'];
                $currentUser->email = $user['email'];
                $currentUser->registrationDate = new DateTime($user['created_at']);
                return $currentUser; 
                // return $currentUser->currentUserData(); 
            } else {
                return null;
            }
        } catch (PDOException $e) {
            return null;
        }
    }
}
