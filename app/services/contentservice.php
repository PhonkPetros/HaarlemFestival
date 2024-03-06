<?php

namespace services;

use repositories\EditorRepository;
use repositories\ImageRepository;
use repositories\CarouselRepository;

require_once __DIR__ . '/../repositories/carouselrepository.php';
require_once __DIR__ . '/../repositories/EditorRepository.php';
require_once __DIR__ . '/../repositories/imagerepository.php';

class ContentService
{
    private $editorRepo;
    private $imageRepo;
    private $carouselRepo;

    public function __construct()
    {
        $this->editorRepo = new EditorRepository();
        $this->imageRepo = new ImageRepository();
        $this->carouselRepo = new CarouselRepository();
    }

    public function getEditorContentById($editorId)
    {
        return $this->editorRepo->findEditorContentById($editorId);
    }

    public function getImageById($imageId)
    {
        return $this->imageRepo->findImageById($imageId);
    }

    public function getCarouselItemsBySectionId($sectionId)
    {
        return $this->carouselRepo->findCarouselItemsBySectionId($sectionId);
    }
}

