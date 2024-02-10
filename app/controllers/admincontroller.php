<?php

namespace controllers;
use services\adminservice;

require_once __DIR__ . '/../services/adminservice.php';

class admincontroller
{

    public $adminservice;
  
    public function __construct() {
        $this->adminservice = new adminservice();
    }

    public function show()
    {
        $userDetails =  $_SESSION['user'];
        require_once '../views/admin/dashboard.php';
    }

    public function manageUsers(){
        require_once '../views/admin/manage-users.php';
    }

}
