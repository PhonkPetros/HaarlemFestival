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

    public function getRestaurant($eventId) {
        return $this->restaurantRepo->getRestaurant($eventId);
    }

    public function getAllRestaurants() {
        return $this->restaurantRepo->getAllRestaurants();
    }

    public function updateRestaurantDetails($id, $name, $price, $seats, $startDate, $endDate, $picturePath, $location, $description) {
        return $this->restaurantRepo->updateRestaurantDetails($id, $name, $price, $seats, $startDate, $endDate, $picturePath, $description, $location);
    }

    public function addTimeslot($restaurantId, $ticket_hash ,$date, $time, $quantity) {
        return $this->restaurantRepo->addTimeslot($restaurantId, $ticket_hash, $date, $time, $quantity);
    }

    public function getTimeslotsForRestaurant($eventId) {
        return $this->restaurantRepo->getTimeslotsForRestaurant($eventId);
    }
   
    public function getRestaurantByIdWithTimeslots($id) {
        return $this->restaurantRepo->getRestaurantByIdWithTimeslots($id);
    }

    public function addRestaurant($name, $location, $description, $price, $seats, $startDate, $endDate, $picturePath) {
        return $this->restaurantRepo->addRestaurant($name, $location, $description, $price, $seats, $startDate, $endDate, $picturePath);
    }

    public function deleteRestaurant($id) {
        return $this->restaurantRepo->deleteRestaurant($id);
    }

    public function deleteTimeSlot($id) {
        return $this->restaurantRepo->deleteTimeslot($id);
    }

    
}