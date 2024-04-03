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


    public function showChoseResturant($restaurantId)
    {
    $navigationController = $this->navigationController->displayHeader();
    
    $restaurantData = $this->restaurantService->getRestaurantByIdWithTimeslots($restaurantId);
    
    $restaurantDetails = $restaurantData['restaurantDetails'];
    $timeslots = $restaurantData['timeslots'];
    
    $contentData = $this->pagecontroller->getContentAndImagesForResutrant($restaurantId);
    
    require_once __DIR__ . '/../views/yummy/resturant.php';
    }



    public function editContent(){
        require_once __DIR__ ."/../views/admin/page-managment/editYummy.php";
    }
}