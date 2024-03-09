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

    public function updateCarouselItem($carouselId, $newFilePath, $newCarouselLabel){
        try {
            $this->connection->beginTransaction();
    
            $stmt = $this->connection->prepare("SELECT image_id FROM carousel WHERE carousel_id = :carousel_id");
            $stmt->bindParam(':carousel_id', $carouselId, PDO::PARAM_INT);
            $stmt->execute();
            $existingImageId = $stmt->fetchColumn();
    
            if ($existingImageId) {
                $stmt = $this->connection->prepare("UPDATE image SET file_path = :file_path WHERE image_id = :image_id");
                $stmt->bindParam(':file_path', $newFilePath, PDO::PARAM_STR); 
                $stmt->bindParam(':image_id', $existingImageId, PDO::PARAM_INT);
                $stmt->execute();
            }
    
            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollback();
            error_log('Failed to update carousel item: ' . $e->getMessage());
            throw $e;
        }
    }
    
    

    public function updateCarouselLabel($carouselId, $newCarouselLabel){
        try {
            $stmt = $this->connection->prepare("UPDATE carousel SET label = :label WHERE carousel_id = :carousel_id");
            $stmt->bindParam(':label', $newCarouselLabel, PDO::PARAM_STR);
            $stmt->bindParam(':carousel_id', $carouselId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log('Failed to update carousel label: ' . $e->getMessage());
            throw $e;
        }
    }


}