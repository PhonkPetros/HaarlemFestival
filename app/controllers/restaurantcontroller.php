<?php

namespace controllers;



class Restaurantcontroller
{

  
    public function __construct() {
        $this->navigationController = new Navigationcontroller();
    }

    private $navigationController;

    public function showChosenResturant(/* Here I have to get the resturant id of what the user has clicked */)
    {
        $navigationController = $this->navigationController->displayHeader();
        require_once __DIR__ . '/../views/yummy/resturant.php';
    }

    public function editEventDetails(){
        require_once __DIR__ . '/../views/admin/manage-event-details/editDetailsRestaurant.php';
    }
  
}