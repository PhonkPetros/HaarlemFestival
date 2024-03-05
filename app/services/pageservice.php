<?php

namespace services;
use repositories\Pagerepository;

require_once __DIR__ . '/../repositories/pagerepository.php';

class Pageservice
{
    private $pagerepo;
    
    public function __construct() {
        $this->pagerepo = new Pagerepository();
    }

    public function getPages() {
        return $this->pagerepo->getPages();
        
    }
    
    public function getAllSections($page){
        return $this->pagerepo->getAllSections($page);
    }

    public function getPageDetails($page){
        return $this->pagerepo->getPageDetails($page);
    }
   
}
