<?php

namespace services;

use repositories\resturantrepository;

require_once __DIR__ . '/../repositories/resturantrepository.php'; 


class RestaurantService
{
    private $restaurantRepo;

    public function __construct()
    {
        $this->restaurantRepo = new resturantrepository();
    }

    public function getAllRestaurants() {
        return $this->restaurantRepo->getAllRestaurants();
    }

    
}