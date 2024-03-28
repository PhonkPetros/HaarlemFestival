<?php
namespace model;
use services\pageservice;

use PDOException;
use Exception;
use services\ContentService;


require_once __DIR__ . "/../services/pageservice.php";
require_once __DIR__ . "/../services/contentservice.php";
class Page implements \JsonSerializable
{
    private int $id;
    private string $name;
    private $pageService;
    private $contentService;


    public function __construct()
    {
        $this->pageService = new Pageservice();
        $this->contentService = new ContentService();
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function jsonSerialize(): mixed {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
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
                'type' => $section['type'] ?? null,
            ];
            $contentData[] = $sectionData;
        }
        return $contentData;
    }


    public function getContentAndImagesForResutrant($restaurnatId) {
        $pageIdArray = $this->pageService->getPageIdByRestaurantId($restaurnatId);
        $pageId = $pageIdArray["page_id"] ?? null;
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

}
