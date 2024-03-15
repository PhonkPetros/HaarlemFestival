<?php


namespace controllers;

require_once __DIR__ . '/../controllers/navigationcontroller.php';
use controllers\Navigationcontroller;


class yummycontroller
{

    public function __construct() {
        $this->navigationController = new Navigationcontroller();
    }

    private $navigationController;

    public function showYummyOverview()
    {
        $navigationController = $this->navigationController->displayHeader();
        require_once __DIR__ . '/../views/yummy/overview.php';
    }

    public function editContent(){
        require_once __DIR__ ."/../views/admin/page-managment/editYummy.php";
    }
}