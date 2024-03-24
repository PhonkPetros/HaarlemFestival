<?php

namespace controllers;

use services\pageservice;

use PDOException;
use Exception;
use services\ContentService;


require_once __DIR__ . "/../services/pageservice.php";
require_once __DIR__ . "/../services/contentservice.php";
require_once __DIR__ . '/../config/constant-paths.php';


class Pagecontroller
{
    private $pageService;
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
        $sectionID = filter_input(INPUT_GET, "section_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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

    public function addNewSection()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $pageId = filter_var($data['pageId'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            $this->pageService->addNewSection($pageId);

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function updateContent()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset ($_POST['section_id'])) {

            $sectionID = $_POST['section_id'];
            $content = empty ($_POST['content']) ? null : $_POST['content'];
            $title = $_POST['sectionTitle'];

            // Check if $_POST['newType'] exists before accessing it
            $type = isset ($_POST['newType']) ? htmlspecialchars($_POST['newType']) : null;

            $newImage = $_FILES['newImage'] ?? null;
            $path = '/img/uploads/';
            $imageAction = null;

            $resetImage = isset ($_POST['resetImage']) && $_POST['resetImage'] == 1;
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

                if ($type !== null) {
                    $this->pageService->updateType($sectionID, $type);
                }

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
        if (isset ($imageFile) && $imageFile['error'] == UPLOAD_ERR_OK) {
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
        $sectionID = filter_input(INPUT_POST, "section_id", FILTER_SANITIZE_NUMBER_INT);

        if (!$sectionID) {
            error_log('Section ID is missing.');
            return;
        }

        try {
            $pageID = $this->pageService->getSectionPageId($sectionID);
            $this->pageService->deleteSection($sectionID);
           
         
            header('Location: /edit-content/?id=' . $pageID);
        } catch (PDOException | Exception $e) {
            error_log($e->getMessage());
        }
    }


    public function deletePage()
    {
        $pageID = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        if (!$pageID) {
            error_log('Page ID is missing.');
            return;
        }

        try {
            $allSections = $this->pageService->getAllSections($pageID);
            foreach ($allSections as $section) {
                $this->pageService->deleteSection($section->getSectionId());
            }

            $this->pageService->deletePage($pageID);
            header('Location: /admin/page-management/editfestival');
        } catch (PDOException | Exception $e) {
            error_log($e->getMessage());
        }
    }





    public function getSectionsFromPageID()
    {
        $page = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        return $this->pageService->getAllSections($page);
    }

    public function getPageDetails()
    {
        $page = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        return $this->pageService->getPageDetails($page);
    }

    public function getContentAndImagesByPage()
    {
        $pageId = filter_input(INPUT_GET, 'pageid', FILTER_SANITIZE_NUMBER_INT);
        $sections = $this->pageService->getSectionContentImages($pageId);
        $contentData = [];
        foreach ($sections as $section) {
            $sectionData = [
                'title' => $section['title'],
                'content' => $section['editor_content'] ?? null,
                'image' => $section['image_file_path'] ?? null,
                'type' => $section['type'] ?? null,
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
        $newPageName = filter_input(INPUT_POST, 'pageTitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $amountOfSections = filter_input(INPUT_POST, 'sectionAmount', FILTER_SANITIZE_NUMBER_INT);

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
