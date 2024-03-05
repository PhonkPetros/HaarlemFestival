<?php

namespace controllers;

use services\pageservice;

require_once __DIR__ . "/../services/pageservice.php";

class Pagecontroller
{
    private $pageService;
    public function __construct()
    {
        $this->pageService = new Pageservice();
    }

    public function editContent()
    {
        $allSections = $this->getSectionsFromPageID();
        $pageDetails = $this->getPageDetails();
        require_once __DIR__ . "/../views/admin/page-managment/editPageOverview.php";
    }
    public function getSectionsFromPageID()
    {
        $page = htmlspecialchars($_GET['id']);
        $allSections = $this->pageService->getAllSections($page);
        return $allSections;
    }

    public function getPageDetails()
    {
        $page = htmlspecialchars($_GET['id']);
        $pageDetails = $this->pageService->getPageDetails($page);
        return $pageDetails;
    }
    


}
