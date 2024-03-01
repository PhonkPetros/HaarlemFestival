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
        $navigationController = $this->navigationController->displayHeader();
        require_once '../views/general_views/overview.php';
    }

}