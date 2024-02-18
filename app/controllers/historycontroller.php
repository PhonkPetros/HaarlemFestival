<?php

namespace controllers;



class Historycontroller
{
    public function __construct() {
        
    }

    public function show()
    {
        require_once __DIR__ . '/../views/history/overview.php';
    }

    public function showProveniershof(){
        require_once __DIR__ . '/../views/history/proveniershof.php';
    }

    public function showChurch(){
        require_once __DIR__ . '/../views/history/churchbravo.php';
    }

    public function editEventDetails(){
        require_once __DIR__ . '/../views/admin/manage-event-details/editDetailsHistory.php';
    }
  
}