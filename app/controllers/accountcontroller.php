<?php

namespace controllers;
use services\accountservice;

require_once __DIR__ . '/../services/accountservice.php';


class accountcontroller{


    public $userservice;

    public function __construct() {
        $this->userservice = new accountservice();
    }

    public function show()
    {
        require_once '../views/user/account.php';
    }

    

}