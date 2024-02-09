<?php

namespace services;
use repositories\Loginrepository;
require_once __DIR__ . '/../repositories/loginrepository.php';

class loginService
{
    private $loginrepository;
    public function __construct() {
        $this->loginrepository = new loginrepository(); 
    }

    public function login($username, $password) {
        $this->loginrepository->login($username, $password);
    }

}