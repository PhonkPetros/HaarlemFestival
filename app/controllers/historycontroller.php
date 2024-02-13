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

  
}