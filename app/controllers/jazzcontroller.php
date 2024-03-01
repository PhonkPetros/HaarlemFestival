<?php

namespace controllers;



class Jazzcontroller
{

  
    public function __construct() {
        
    }

    public function show()
    {
        
    }

    public function editEventDetails(){
        require_once __DIR__ . '/../views/admin/manage-event-details/editDetailsJazz.php';
    }

    public function editContent(){
        require_once __DIR__ ."/../views/admin/page-managment/editJazz.php";
    }

  
}