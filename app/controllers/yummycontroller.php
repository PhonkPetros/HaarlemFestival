<?php


namespace controllers;

require_once __DIR__ . '/../controllers/navigationcontroller.php';
require_once __DIR__ . '/../services/restaurantservice.php';
use controllers\Navigationcontroller;
use repositories\resturantrepository;

class yummycontroller
{

    public function __construct() {
        $this->navigationController = new Navigationcontroller();
        $this->restaurantService = new resturantrepository();
    }

    private $navigationController;
    private $restaurantService;

    public function showYummyOverview()
    {
        $navigationController = $this->navigationController->displayHeader();
        $restaurants = $this->restaurantService->getAllRestaurants();
        require_once __DIR__ . '/../views/yummy/overview.php';
    }


    public function showChoseResturant($id)
    {
        $navigationController = $this->navigationController->displayHeader();
        $restaurantDetails = $this->restaurantService->getRestaurantByIdWithTimeslots($id);
        require_once __DIR__ . '/../views/yummy/resturant.php';
    }

    public function editContent(){
        require_once __DIR__ ."/../views/admin/page-managment/editYummy.php";
    }
}