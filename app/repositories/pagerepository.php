<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use model\Page; 


require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ .'/../model/page.php';


class Pagerepository extends dbconfig {
    
   private $pageModel;

    public function __construct() {
        parent::__construct();
        $this->pageModel = new Page();
    }
    public function getPages() {
        $pages = [];

        try {
        
            $stmt = $this->connection->prepare('SELECT * FROM page');
            $stmt->execute();
            $pages = $stmt->fetchAll(PDO::FETCH_CLASS, Page::class); 
        } catch (PDOException $e) {
            error_log('Failed to fetch pages: ' . $e->getMessage());
        }

        return $pages;
    }
}
