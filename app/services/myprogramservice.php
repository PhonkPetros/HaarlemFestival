<?php

namespace services;
use repositories\Myprogramrepository;
require_once __DIR__ . '/../repositories/myprogramrepository.php';

class Myprogramservice
{
    private $myprogramRepo;
 
    public function __construct() {
        $this->myprogramRepo = new Myprogramrepository();
    }

    function processOrder($userId, $cart){
        return $this->myprogramRepo->processOrder($userId, $cart);
    }

    function createOrder($userId, $totalPrice){
        return $this->myprogramRepo->createOrder($userId, $totalPrice);
    }

    function updateTicketQuantity($ticketId, $quantityPurchased){
        return $this->updateTicketQuantity($ticketId, $quantityPurchased);
    }


    function createOrderItem($orderId, $userId, $item){
        return $this->createOrderItem($orderId, $userId, $item);
    }

    function getAllOrders()
    {   
        
        $allOrders =  $this->myprogramRepo->getAllOrders();

        for ($i = 0; $i < count($allOrders); $i++) 
        {
            if (isset($allOrders[$i]['location'])) {
                $allOrders[$i]['events'] = "History";
            } else if (isset($allOrders[$i]['restaurant_name'])) {
                $allOrders[$i]['events'] = "Yummy ({$allOrders[$i]['restaurant_name']})";
            } else if (isset($allOrders[$i]['artist_name'])) {
                $allOrders[$i]['events'] = "Dance ({$allOrders[$i]['artist_name']})";
            }
        }

        return $allOrders;
    }

}