<?php

namespace controllers;

use services\NavigationService;
use services\PageService;

require_once __DIR__ . '/../services/NavigationService.php';
require_once __DIR__ . '/../services/pageservice.php';

class NavigationController
{
    private $navigationService;
    private $pageService;
    private $existingNavigation;
    private $allPages;
    private $existingPageIds;

    public function __construct() {
        $this->navigationService = new NavigationService();
        $this->pageService = new PageService();
        $this->existingNavigation = $this->navigationService->get_navigation_repository();
        $this->allPages = $this->pageService->getPages();
        $this->existingPageIds = array_map(function($navigationItem) {
            return $navigationItem->getPageID();
        }, $this->existingNavigation);
    }

    public function displayHeader() {
        $allPages = $this->existingNavigation;
        require_once __DIR__ . '/../views/general_views/header.php';
    }

    public function modifyNavigationPage(){
        $existingNavigation = $this->existingNavigation;
        $allPages = $this->allPages;
        $existingPageIds = $this->existingPageIds;
        require_once __DIR__ . '/../views/admin/modify-navigation/edit-navigation.php';
    }

    public function updateNavigation() {
        $newPageIds = $_POST['pages'] ?? [];
        $newPageIds = array_map('htmlspecialchars', $newPageIds);
        $pagesToRemove = array_diff($this->existingPageIds, $newPageIds);
        $pagesToAdd = array_diff($newPageIds, $this->existingPageIds);

        if (!empty($pagesToRemove)) {
            $this->removePages($pagesToRemove);
        }
        
        if (!empty($pagesToAdd)) {
            $this->addPages($pagesToAdd);
        }

        header('Location: /modify-navigation/edit-navigation');
        exit();
    }

    private function removePages($pageIds) {
        return $this->navigationService->removePages($pageIds);
    }

    private function addPages($pageIds) {
        return $this->navigationService->addPages($pageIds);
    }
    
}
