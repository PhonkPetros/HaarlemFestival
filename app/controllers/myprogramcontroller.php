<?php

namespace controllers;

use services\Myprogramservice;

require_once __DIR__ . '/../services/myprogramservice.php';


class Myprogramcontroller
{

    private $myProgramService;

    public function __construct() {
        $this->myProgramService = new Myprogramservice();
        
    }
    
}
