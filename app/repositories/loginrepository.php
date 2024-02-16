<?php

namespace repositories;

use PDO;
use PDOException;
use DateTime;
use model\User; 
use config\dbconfig;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/user.php';

class LoginRepository extends dbconfig {

    public function login($username, $password)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM [User] WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userData && password_verify($password, $userData['password_hash'])) {
                $user = new User();
                $user->setUserID($userData['user_id']);
                $user->setTicketID($userData['ticket_id'] ?? 0);
                $user->setUsername($userData['username']);
                $user->setUserRole($userData['role']);
                $user->setUserEmail($userData['email']);
                $user->setPassword($userData['password_hash']);
                $user->setRegistrationDate(new DateTime($userData['created_at']));
                return $user;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            return null;
        }
    }
}
