<?php

namespace controllers;

use controllers\Pagecontroller;
use controllers\NavigationController;
use services\Pageservice;


require_once __DIR__ . '/../controllers/navigationcontroller.php';
require_once __DIR__ . '/../controllers/pagecontroller.php';
require_once __DIR__ . '/../services/pageservice.php';


class Templatecontroller
{


    private $pageController;
    private $navigationController;
    private $pageService;
    public function __construct()
    {
        $this->pageService = new Pageservice();
        $this->pageController = new Pagecontroller();
        $this->navigationController = new NavigationController();

    }

    function getPageName()
    {
        $pageId = htmlspecialchars($_GET['pageid']);
        $pageName = $this->pageService->getPageName($pageId);
        return $pageName;
    }

    public function show()
    {
        $pagetitle = $this->getPageName();
        $contentData = $this->pageController->getContentAndImagesByPage();
        $this->navigationController->displayHeader($pagetitle);
        require_once __DIR__ . '/../views/template.php';
    }

}