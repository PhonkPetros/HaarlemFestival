<?php

namespace services;

use repositories\Pagerepository;
use PDOException;

require_once __DIR__ . '/../repositories/pagerepository.php';

class Pageservice
{
    private $pagerepo;

    public function __construct()
    {
        $this->pagerepo = new Pagerepository();
    }

    public function getPages()
    {
        return $this->pagerepo->getPages();

    }

    public function getAllSections($page)
    {
        return $this->pagerepo->getAllSections($page);
    }

    public function getPageDetails($page)
    {
        return $this->pagerepo->getPageDetails($page);
    }

    public function getSectionContentImages($page)
    {
        return $this->pagerepo->getSectionContentImages($page);
    }

    public function getSectionContentImagesCarousel($sectionId)
    {
        return $this->pagerepo->getSectionContentImagesCarousel($sectionId);
    }

    public function getSectionTitle($sectionID)
    {
        return $this->pagerepo->getSectionTitle($sectionID);
    }

    public function getPageIdByRestaurantId($restuarantId)
    {
        return $this->pagerepo->getPageIdByRestaurantId($restuarantId);
    }

    public function updateSectionContent($sectionID, $content, $image)
    {
        try {
            $this->pagerepo->updateSectionContent($sectionID, $content, $image);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function addNewSection($pageId)
    {
        return $this->pagerepo->addNewSection($pageId);
    }
    public function getSectionPageId($sectionID)
    {
        return $this->pagerepo->getSectionPageId($sectionID);
    }

    public function deleteSection($sectionID)
    {
        return $this->pagerepo->deleteSection($sectionID);
    }

    public function deletePage($pageID)
    {
        return $this->pagerepo->deletePage($pageID);
    }

    public function updateSectionTitle($sectionID, $title)
    {
        return $this->pagerepo->updateSectionTitle($sectionID, $title);
    }

    public function getPageNameExists($newPageName)
    {
        return $this->pagerepo->getPageNameExists($newPageName);
    }

    public function createPage($newPageName, $amountOfSections)
    {
        return $this->pagerepo->createPage($newPageName, $amountOfSections);
    }

    public function updateType($sectionID, $type)
    {
        return $this->pagerepo->updateSectionType($sectionID, $type);
    }

    public function getType($sectionID)
    {
        return $this->pagerepo->getType($sectionID);
    }
}
