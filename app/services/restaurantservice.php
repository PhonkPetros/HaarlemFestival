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

    public function updateRestaurantDetails($id, $name, $price, $seats, $startDate, $endDate, $picturePath) {
        return $this->restaurantRepo->updateRestaurantDetails($id, $name, $price, $seats, $startDate, $endDate, $picturePath);
    }

    public function addTimeslot($restaurantId, $ticket_hash ,$date, $time, $quantity) {
        return $this->restaurantRepo->addTimeslot($restaurantId, $ticket_hash, $date, $time, $quantity);
    }

    public function getTicketTimeslotsForRestaurant() {
        return $this->restaurantRepo->getTicketTimeslotsForRestaurant();
    }

    
}