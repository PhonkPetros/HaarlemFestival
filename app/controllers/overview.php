<?php

namespace controllers;
use controllers\Navigationcontroller;
require_once __DIR__ . '/../controllers/navigationcontroller.php';

class overview
{

    private $navigationController;

    public function __construct()
    {
        $this->navigationController = new Navigationcontroller();
    }

    public function show()
    {
        $pagetitle = "Home";
        $navigationController = $this->navigationController->displayHeader($pagetitle);
        require_once '../views/general_views/overview.php';
    }

    public function editContent(){
        require_once __DIR__ ."/../views/admin/page-managment/editHome.php";
    }

}