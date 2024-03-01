<?php

namespace controllers;

use services\navigationservice;
require_once __DIR__ . '/../services/navigationservice.php';

class Navigationcontroller
{
    private $navigationservice;
  
    public function __construct() {
        $this->navigationservice = new navigationservice();
    }

    public function displayHeader() {
        $allPages = $this->navigationservice->get_navigation_repository();
        require_once __DIR__ .'/../views/general_views/header.php';
    }

}
