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

    public function register($username, $password, $email) {
        return $this->registerrepository->registerUser($username, $password, $email);
    }

    public function username_exists($username){
        return $this->registerrepository->usernameExists($username);
    }
}
