<?php

namespace controllers;

use controllers\Pagecontroller;
use controllers\NavigationController;

require_once __DIR__ . '/../controllers/navigationcontroller.php';
require_once __DIR__ . '/../controllers/pagecontroller.php';

class Templatecontroller
{

    private $pageController;
    private $navigationController;
    public function __construct()
    {
        $this->pageController = new Pagecontroller();
        $this->navigationController = new NavigationController();
   
    }

    public function show(){
        $contentData = $this->pageController->getContentAndImagesByPage();
        $this->navigationController->displayHeader();
        require_once __DIR__ . '/../views/template.php';
    }


   
}