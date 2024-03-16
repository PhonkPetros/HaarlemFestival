<?php

namespace services;
use repositories\registerrepository;

require_once __DIR__ . '/../repositories/registerrepository.php';

class registerservice 
{
    private $registerrepository;
    
    public function __construct() {
        $this->registerrepository = new registerrepository(); 
    }

    public function register($newuser) {
        return $this->registerrepository->registerUser($newuser);
    }

    public function username_exists($username){
        return $this->registerrepository->usernameExists($username);
    }

    public function email_exists($email){
        return $this->registerrepository->emailExists($email);
    }

    public function updateUser($userInfo){
        return $this->registerrepository->updateUser($userInfo);
    }
}
