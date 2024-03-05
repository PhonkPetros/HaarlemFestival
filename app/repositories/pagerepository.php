<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use model\Page;
use model\Section;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/page.php';
require_once __DIR__ . '/../model/section.php';


class Pagerepository extends dbconfig
{

    private $pageModel;

    public function __construct()
    {
        parent::__construct();
        $this->pageModel = new Page();
    }
    public function getPages()
    {
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

    public function getAllSections($page)
    {
        $sections = [];

        try {
            $stmt = $this->connection->prepare('SELECT * FROM section WHERE page_id = :page_id');
            $stmt->bindParam(':page_id', $page, PDO::PARAM_INT);
            $stmt->execute();
            $sections = $stmt->fetchAll(PDO::FETCH_CLASS, Section::class);
        } catch (PDOException $e) {
            error_log('Failed to fetch sections: ' . $e->getMessage());
        }

        return $sections;
    }

    public function getPageDetails($pageid)
    {
        $page = null;
        try {
            $stmt = $this->connection->prepare('SELECT * FROM [page] WHERE id = :page_id');
            $stmt->bindParam(':page_id', $pageid, PDO::PARAM_INT);
            $stmt->execute();
            $page = $stmt->fetchObject(Page::class); 
        } catch (PDOException $e) {
            error_log('Failed to fetch page details: ' . $e->getMessage());
        }
        return $page;
    }

}
