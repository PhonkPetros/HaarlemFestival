<?php

namespace controllers;
require_once __DIR__ . '/../services/restaurantservice.php';

use services\RestaurantService;


class Restaurantcontroller
{
  
    public $restaurantService;

    public function __construct() {
        $this->navigationController = new Navigationcontroller();
        $this->restaurantService = new RestaurantService();
    }

    private $navigationController;

    public function showChosenResturant(/* Here I have to get the resturant id of what the user has clicked */)
    {
        $navigationController = $this->navigationController->displayHeader();
        require_once __DIR__ . '/../views/yummy/resturant.php';
    }

    public function editEventDetails() {
        
        $restaurants = $this->restaurantService->getAllRestaurants(); // Fetch all restaurants
        require_once __DIR__ . '/../views/admin/manage-event-details/editDetailsRestaurant.php';
    }
    
  
}