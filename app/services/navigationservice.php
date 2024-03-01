<?php

namespace services;
use repositories\navigationrepository;

require_once __DIR__ . '/../repositories/navigationrepository.php';

class navigationservice 
{
    private $navigationrepo;
    
    public function __construct() {
        $this->navigationrepo = new navigationrepository(); 
    }

    public function get_navigation_repository() {
        return $this->navigationrepo->getPages();
        
    }
   
}
