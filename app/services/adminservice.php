<?php

namespace services;
use repositories\Adminrepository;
require_once __DIR__ . '/../repositories/adminrepository.php';

class adminService 
{
    private $adminrepository;
    public function __construct() {
        $this->adminrepository = new adminrepository(); 
    }


}