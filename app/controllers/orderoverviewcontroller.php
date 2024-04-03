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
        $orderIds = $_POST['orderIds'];

        //if user actually select something
        if (isset($orderIds)) {
            $orderIds = explode(',', $orderIds);
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

                if (in_array($row['order_item_id'], $orderIds)) {
                    echo implode("\t", array_values($row)) . "\n";
                }
            }
        }
    }
}
    