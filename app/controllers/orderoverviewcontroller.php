<?php

namespace controllers;


use services\myprogramservice;

require_once __DIR__ . '/../services/myprogramservice.php';

class orderoverviewcontroller {
    private $service;

    public function __construct() {
        $this->service = new myprogramservice();
    }

    public function showOverviewTable ()
    {   
        $ordersContent = $this->service->getAllOrders();
        require_once __DIR__ ."/../views/admin/order-management/orderoverview.php";

    }
}
    
