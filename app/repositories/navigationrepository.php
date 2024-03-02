<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use model\Navigation; 

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/navigation.php'; 

class NavigationRepository extends dbconfig {
    
    private $navigationModel;

    public function __construct() {
        parent::__construct();
        $this->navigationModel = new Navigation();
    }
    public function getPages() {
        $pages = [];

        try {
        
            $stmt = $this->connection->prepare('SELECT navigation.*, page.name AS pageName FROM navigation INNER JOIN page ON navigation.page_id = page.id');
            $stmt->execute();
            $pages = $stmt->fetchAll(PDO::FETCH_CLASS, Navigation::class); 
        } catch (PDOException $e) {
            error_log('Failed to fetch pages: ' . $e->getMessage());
        }

        return $pages;
    }

    public function addPages($pageIds) {
        try {
            $this->connection->beginTransaction();
            $stmt = $this->connection->prepare('INSERT INTO navigation (page_id) VALUES (:page_id)');

            foreach ($pageIds as $pageId) {
                $stmt->bindParam(':page_id', $pageId);
                $stmt->execute();
            }

            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollBack();
            error_log('Failed to add pages: ' . $e->getMessage());
        }
    }

    public function removePages($pageIds) {
        try {
            $this->connection->beginTransaction();
            $stmt = $this->connection->prepare('DELETE FROM navigation WHERE page_id = :page_id');

            foreach ($pageIds as $pageId) {
                $stmt->bindParam(':page_id', $pageId);
                $stmt->execute();
            }

            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollBack();
            error_log('Failed to remove pages: ' . $e->getMessage());
        }
    }
}
