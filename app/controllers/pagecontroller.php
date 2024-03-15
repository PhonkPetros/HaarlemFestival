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
require_once __DIR__ . '/../config/constant-paths.php';
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
        $sectionType = $this->pageService->getType($sectionID);
    
        $editorContent = null;
        $imageFilePath = null;
        $pageIDFromSection = $sectionData['page_id'] ?? '';
        $carouselItems = $this->getCarouselImagesForHistory($sectionID);
        if ($sectionData) {
            $editorContent = $sectionData['editor_content'] ?? null;
            $imageFilePath = $sectionData['image_file_path'] ?? null;
        }
    
        require_once __DIR__ . "/../views/admin/page-managment/editSection.php";
    }
    


    public function updateContent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['section_id'])) {
            $sectionID = $_POST['section_id'];
            $content = empty($_POST['content']) ? null : $_POST['content'];
            $title = $_POST['sectionTitle'];
            $type = htmlspecialchars($_POST['newType']);

            $newImage = $_FILES['newImage'] ?? null;
            $path = '/img/uploads/';
            $imageAction = null;

            $resetImage = isset($_POST['resetImage']) && $_POST['resetImage'] == 1;
            if ($resetImage) {
                $imageAction = ['name' => 'default.png']; 
            } elseif ($newImage && $newImage['error'] == UPLOAD_ERR_OK) {
                $uploadedImageName = $this->uploadImage($newImage, $path);
                if ($uploadedImageName) {
                    $imageAction = ['name' => $uploadedImageName];
                }
            }


            try {
                $this->pageService->updateSectionContent($sectionID, $content, $imageAction ?? []);
                $this->pageService->updateSectionTitle($sectionID, $title);
                $this->pageService->updateType($sectionID, $type);


                $pageID = $this->pageService->getSectionPageId($sectionID);
                if ($pageID !== null) {
                    header('Location: /edit-content/?id=' . $pageID);
                    exit();
                } else {
                    throw new Exception("Page ID not found for section ID: " . $sectionID);
                }
            } catch (Exception $e) {
                error_log($e->getMessage());
            }
        }
    }
    private function uploadImage($imageFile, $uploadDirectory)
    {
        if (isset($imageFile) && $imageFile['error'] == UPLOAD_ERR_OK) {
            $imageFileName = basename($imageFile['name']);
            $absoluteUploadPath = $_SERVER['DOCUMENT_ROOT'] . $uploadDirectory . $imageFileName;

            if (move_uploaded_file($imageFile['tmp_name'], $absoluteUploadPath)) {
                return $imageFileName;
            } else {
                throw new Exception('Failed to upload image.');
            }
        }
        return null;
    }


    public function deleteSection()
    {
        $sectionID = htmlspecialchars($_POST["section_id"] ?? '');


        if (!$sectionID) {
            error_log('Section ID is missing.');
            return;
        }

        $sanitizedSectionID = filter_var($sectionID, FILTER_SANITIZE_NUMBER_INT);
        $pageID = $this->pageService->getSectionPageId($sanitizedSectionID);

        try {
            $this->pageService->deleteSection($sanitizedSectionID);
            header('Location: /edit-content/?id=' . $pageID);
        } catch (PDOException $e) {
            error_log('Failed to delete section: ' . $e->getMessage());

        } catch (Exception $e) {
            error_log($e->getMessage());

        }
    }

    public function deletePage()
    {

        $pageID = htmlspecialchars($_POST['id'] ?? '');
        if (!$pageID) {
            error_log('Page ID is missing.');
            return;
        }

        $sanitizedPageID = filter_var($pageID, FILTER_SANITIZE_NUMBER_INT);

        try {
            $allSections = $this->pageService->getAllSections($sanitizedPageID);
            foreach ($allSections as $section) {
                $this->pageService->deleteSection($section->getSectionId());
            }

            $this->pageService->deletePage($sanitizedPageID);
            header('Location: /admin/page-management/editfestival');
        } catch (PDOException $e) {
            error_log('Failed to delete section: ' . $e->getMessage());

        } catch (Exception $e) {
            error_log($e->getMessage());

        }
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

    public function getContentAndImagesByPage() {
        $pageId = htmlspecialchars($_GET['pageid']);
        $sections = $this->pageService->getSectionContentImages($pageId);
        $contentData = [];
        foreach ($sections as $section) {
            $sectionData = [
                'title' => $section['title'],
                'content' => $section['editor_content'] ?? null,
                'image' => $section['image_file_path'] ?? null,
                'type' => $section['type'] ?? null, // Ensure 'type' is included here.
            ];
            $contentData[] = $sectionData;
        }
        return $contentData;
    }
    
    public function getCarouselImagesForHistory($sectionID)
    {
        $carouselItems = $this->contentService->getCarouselItemsBySectionId($sectionID);
        $all = [];

        foreach ($carouselItems as $item) {
            $imageData = $this->contentService->getImageById($item->getImageId());
            if ($imageData) {
                $all['carouselItems'][] = [
                    'image' => $imageData->getFilePath(),
                    'label' => $item->getLabel(),
                    'carousel_id' => $item->getCarouselId(),
                ];
            }
        }

        return $all;
    }

    public function addNewPage()
    {
        $newPageName = htmlspecialchars($_POST['pageTitle']);
        $amountOfSections = htmlspecialchars($_POST['sectionAmount']);

        $pageNameExists = $this->pageService->getPageNameExists($newPageName);

        if ($pageNameExists) {
            $_SESSION['error_message'] = 'Page name already exists';
            header('Location: /admin/page-management/editfestival');
            exit;
        } else {
            $this->pageService->createPage($newPageName, $amountOfSections);
            $_SESSION['success_message'] = 'Page successfully created';
            header('Location: /admin/page-management/editfestival');
        }
    }

}
