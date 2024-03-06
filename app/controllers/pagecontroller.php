<?php

namespace controllers;

use services\pageservice;
use model\Carousel;
use model\Editor;
use model\Section;
use model\Image;
use PDOException;
use Exception;
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


    public function editSectionContent()
    {
        $sectionID = htmlspecialchars($_GET["section_id"] ?? '');
        $sectionTitle = $this->pageService->getSectionTitle($sectionID);
        $sectionData = $this->pageService->getSectionContentImagesCarousel($sectionID)[0] ?? null;

        $editorContent = null;
        $imageFilePath = null;
        $carouselItems = null;

        if ($sectionData) {
            $editorContent = $sectionData['editor_content'] ?? null;
            $imageFilePath = $sectionData['image_file_path'] ?? null;

            if (isset($sectionData['carousel_id'])) {
                $carouselItems = [];
            }
        }

        require_once __DIR__ . "/../views/admin/page-managment/editSection.php";
    }
    public function updateContent(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['section_id'], $_POST['content'])) {
            $sectionID = $_POST['section_id'];
            $content = $_POST['content'];

            $sanitizedSectionID = filter_var($sectionID, FILTER_SANITIZE_NUMBER_INT);
    
            try {
                $this->pageService->updateSectionContent($sanitizedSectionID, $content);
                $pageID = $this->pageService->getSectionPageId($sanitizedSectionID); 
    
                if ($pageID !== null) {
                    header('Location: /edit-content/?id=' . $pageID);
                    exit();
                } else {
                    throw new Exception("Page ID not found for section ID: " . $sanitizedSectionID);
                }
            } catch (PDOException $e) {
                error_log('Failed to update section content: ' . $e->getMessage());
            } catch (Exception $e) {
                error_log($e->getMessage());
            }
        }
    }
    
    private function imageUpload()
    {
    
    }

    public function deleteSection()
    {
        $sectionID = htmlspecialchars($_GET["section_id"]);
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
        $contentData = [];
        foreach ($sections as $section) {
            $sectionData = [
                'title' => $section['title'],
                'content' => $section['editor_content'] ?? null,
                'image' => $section['image_file_path'] ?? null,
            ];
            $contentData[] = $sectionData;
        }
        return $contentData;
    }

    public function getCarouselImagesForHistory()
    {
        $carouselItems = $this->contentService->getCarouselItemsBySectionId(14);
        $all = [];

        foreach ($carouselItems as $item) {
            $imageData = $this->contentService->getImageById($item->getImageId());
            if ($imageData) {
                $all['carouselItems'][] = $imageData->getFilePath();
            }
        }

        return $all;
    }

}
