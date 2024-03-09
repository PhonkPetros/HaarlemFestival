<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use DateTime;
use model\Carousel;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/carousel.php';


class Carouselrepository extends dbconfig
{

    public function findCarouselItemsBySectionId($sectionId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM carousel WHERE section_id = :sectionId");
        $stmt->bindParam(':sectionId', $sectionId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Carousel::class);
    }

    public function updateCarouselItem($carouselId, $carouselImagePath, $newCarouselLabel){

    }

    public function updateCarouselLabel($carouselId, $newCarouselLabel){
        
    }


}