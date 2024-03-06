<?php

namespace controllers;

use services\pageservice;
use model\Carousel;
use model\Editor;
use model\Section;
use model\Image;
use services\ContentService;

require_once __DIR__ . "/../services/pageservice.php";
require_once __DIR__ . "/../services/contentservice.php";
require_once __DIR__ . "/../model/carousel.php";
require_once __DIR__ . "/../model/editor.php";
require_once __DIR__ . "/../model/image.php";
require_once __DIR__ . "/../model/section.php";



class Pagecontroller
{
    private $pageService;
    private $carouselModel;
    private $editorModel;
    private $sectionModel;
    private $imageModel;
    private $contentService;

    public function __construct()
    {
        $this->pageService = new Pageservice();
        $this->contentService = new ContentService();
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

    public function getContentAndImagesByPage()
    {
        $pageId = htmlspecialchars($_GET['pageid']);
        $sections = $this->pageService->getSectionContentImages($pageId);
        $carouselItems = $this->contentService->getCarouselItemsBySectionId(14);
        $contentData = [];

        foreach ($sections as $section) {
            $sectionData = [
                'title' => $section['title'],
                'content' => $section['editor_content'] ?? null,
                'image' => $section['image_file_path'] ?? null,
                'carouselItems' => []
            ];

           
            foreach ($carouselItems as $item) {
                $imageData = $this->contentService->getImageById($item->getImageId());
                if ($imageData) {
                    $sectionData['carouselItems'][] = $imageData->getFilePath();
                }
            }

            $contentData[] = $sectionData;
        }

        return $contentData;
    }

}
