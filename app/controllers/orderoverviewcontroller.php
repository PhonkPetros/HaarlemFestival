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

    public function exportExcel()
    {
        $ordersContent = $this->service->getAllOrders();

        // File Name & Content Header For Download
        $file_name = "ordersContent.xls";
        header("Content-Disposition: attachment; filename=\"$file_name\"");
        header("Content-Type: application/vnd.ms-excel");

        $column_names = false;
        // run loop through each row in $ordersContent
        foreach($ordersContent as $row) {
            if(!$column_names) {
                echo implode("\t", array_keys($row)) . "\n";
                $column_names = true;
            }
            // The array_walk() function runs each array element in a user-defined function.
            // array_walk($row, 'filterCustomerData');
            echo implode("\t", array_values($row)) . "\n";
        }
    }
}
    
