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
            $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user->getPassword())) {
                return $user;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            return null;
        }
    }
}
