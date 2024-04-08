<?php


namespace controllers;

require_once __DIR__ . '/../controllers/navigationcontroller.php';
require_once __DIR__ . '/../controllers/pagecontroller.php';
require_once __DIR__ . '/../services/restaurantservice.php';
require_once __DIR__ . '/../controllers/pagecontroller.php';
use controllers\Navigationcontroller;
use repositories\resturantrepository;
use controllers\Pagecontroller;


class yummycontroller
{

    public function __construct()
    {
        $this->pageController = new Pagecontroller();
        $this->navigationController = new Navigationcontroller();
        $this->restaurantService = new resturantrepository();
        $this->pagecontroller = new Pagecontroller();
    }
    private $pagecontroller;
    private $navigationController;
    private $restaurantService;
    private $pageController;

    public function showYummyOverview()
    {
        $pagetitle = "Yummy";
        $navigationController = $this->navigationController->displayHeader($pagetitle);
        $restaurants = $this->restaurantService->getAllRestaurants();
        $overviewContent = $this->pagecontroller->getContentAndImagesByPage();
        require_once __DIR__ . '/../views/yummy/overview.php';
    }


    public function showChoseResturant($restaurantId)
    {
        $restaurantName = $this->restaurantService->getRestaurantName($restaurantId);
        $navigationController = $this->navigationController->displayHeader($restaurantName);

        $restaurantData = $this->restaurantService->getRestaurantByIdWithTimeslots($restaurantId);

        $restaurantDetails = $restaurantData['restaurantDetails'];
        $timeslots = $restaurantData['timeslots'];

        $contentData = $this->pageController->getContentAndImagesForResutrant($restaurantId);

        require_once __DIR__ . '/../views/yummy/resturant.php';
    }

}