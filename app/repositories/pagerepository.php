<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use model\Page;
use Exception;
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
            $stmt = $this->connection->prepare('SELECT * FROM section WHERE page_id = :page_id ORDER BY section_id ASC' );
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

    public function getSectionContentImages($pageId) {
        $sections = [];
        try {
            $stmt = $this->connection->prepare("
                SELECT s.*, e.content as editor_content, i.file_path as image_file_path
                FROM section s
                LEFT JOIN editor e ON s.editor_id = e.id
                LEFT JOIN image i ON s.image_id = i.image_id
                WHERE s.page_id = :page_id
                ORDER BY s.section_id ASC
            ");
            $stmt->bindParam(':page_id', $pageId, PDO::PARAM_INT);
            $stmt->execute();
            $sections = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            error_log('Failed to fetch sections with content and images: ' . $e->getMessage());
        }
    
        return $sections;
    }
    
    public function getSectionContentImagesCarousel($sectionId) {
        $data = [];
        try {
            $stmt = $this->connection->prepare("
                SELECT
                    s.section_id,
                    e.content AS editor_content,
                    i.file_path AS image_file_path,
                    c.carousel_id,
                    ci.file_path AS carousel_image_file_path
                FROM
                    section s
                    LEFT JOIN editor e ON s.editor_id = e.id
                    LEFT JOIN image i ON s.image_id = i.image_id
                    LEFT JOIN carousel c ON s.section_id = c.section_id
                    LEFT JOIN image ci ON c.image_id = ci.image_id
                WHERE
                    s.section_id = :section_id
            ");
            $stmt->bindParam(':section_id', $sectionId, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            error_log('Failed to fetch section content, images, and carousel: ' . $e->getMessage());
        }
    
        return $data;
    }

    public function getSectionTitle($sectionID){
        $title = null;
        try {
            $stmt = $this->connection->prepare('SELECT title FROM section WHERE section_id = :section_id');
            $stmt->bindParam(':section_id', $sectionID, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                $title = $result['title'];
            }
            
        } catch (PDOException $e) {
            error_log('Failed to fetch section title: ' . $e->getMessage());
        }

        return $title;
    }

    public function getSectionPageId($sectionID){
        try {
            $stmt = $this->connection->prepare('SELECT page_id FROM section WHERE section_id = :section_id');
            $stmt->bindParam(':section_id', $sectionID, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result ? $result['page_id'] : null;
            
        } catch (PDOException $e) {
            error_log('Failed to fetch page id: ' . $e->getMessage());
            return null;
        }
    }
    
    public function updateSectionContent($sectionID, $content)
    {
        $stmt = $this->connection->prepare("SELECT editor_id FROM section WHERE section_id = :section_id");
        $stmt->bindParam(':section_id', $sectionID, PDO::PARAM_INT);
        $stmt->execute();
        $editorID = $stmt->fetchColumn();
    
        if ($editorID !== false) {
            $stmt = $this->connection->prepare("UPDATE editor SET content = :content WHERE id = :editor_id");
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $stmt->bindParam(':editor_id', $editorID, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            throw new Exception("No editor found for section ID: " . $sectionID);
        }
    }
    
}
