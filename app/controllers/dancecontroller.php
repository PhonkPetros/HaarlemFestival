<?php

namespace controllers;

use controllers\NavigationController;

class Dancecontroller
{

    private $navcpntroller;
    public function __construct() {
        $this->navcpntroller = new NavigationController();
    }

    public function show()
    {
        $navigation = $this->navcpntroller->displayHeader();    
        require_once __DIR__ ."/../views/dance/overview.php";
    }

    public function editEventDetails(){
        require_once __DIR__ . '/../views/admin/manage-event-details/editDetailsDance.php';
    }

    public function editContent(){
        require_once __DIR__ ."/../views/admin/page-managment/editDance.php";
    }

  
}