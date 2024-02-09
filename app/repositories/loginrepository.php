<?php

namespace repositories;

use PDO;
use PDOException;
use DateTime;

class Loginrepository extends Repository {

    public function login($username, $password)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM User WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $currentUser = new \model\user();
                $currentUser->userID = $user['user_id'];
                $currentUser->ticketID = $user['ticket_id'];
                $currentUser->username = $user['username'];
                $currentUser->role = $user['role'];
                $currentUser->email = $user['e_mail'];
                $currentUser->registrationDate = new DateTime($user['registration_date']);

                return $currentUser->currentUserData();
            } else {
                echo 'Something went wrong when authenticating user';
                return null;
            }
        } catch (PDOException $e) {
            echo "Error during login: " . $e->getMessage();
            return null;
        }
    }
}
