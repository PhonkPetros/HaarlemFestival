<?php

namespace controllers;

use services\pageservice;

require_once __DIR__ ."/../services/pageservice.php";

class Pagecontroller
{
 private $pageService;
  
    public function __construct() {
        $this->pageService = new Pageservice();
     
    }


}
