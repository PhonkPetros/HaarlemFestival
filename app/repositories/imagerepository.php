<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use DateTime;
use model\Image;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/image.php';


class Imagerepository extends dbconfig {
    

    public function findImageById($imageId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM image WHERE image_id = :imageId");
        $stmt->bindParam(':imageId', $imageId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject(Image::class);
    }
    
}