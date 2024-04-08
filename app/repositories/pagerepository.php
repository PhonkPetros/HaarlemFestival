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
            $stmt = $this->connection->prepare('SELECT * FROM section WHERE page_id = :page_id ORDER BY section_id ASC');
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
    function getPageName($pageid) {
        $pageName = null; 
        try {
            $stmt = $this->connection->prepare('SELECT name FROM page WHERE id = :page_id'); 
            $stmt->bindParam(':page_id', $pageid, PDO::PARAM_INT);
            $stmt->execute();
            $page = $stmt->fetchObject(Page::class); 
            if ($page) {
                $pageName = $page->getName(); 
            }
        } catch (PDOException $e) {
            error_log('Failed to fetch page details: ' . $e->getMessage());
        }
        return $pageName; 
    }
    

    public function getSectionContentImages($pageId)
    {
        $sections = [];
        try {
            $stmt = $this->connection->prepare("
                SELECT s.*, e.content as editor_content, i.file_path as image_file_path, s.type
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
    
    

    public function getSectionContentImagesCarousel($sectionId)
    {
        $data = [];
        try {
            $stmt = $this->connection->prepare("
                SELECT
                    s.section_id,
                    s.page_id, 
                    e.content AS editor_content,
                    i.file_path AS image_file_path,
                    c.carousel_id,
                    c.label AS carousel_label, 
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
    


    public function getSectionTitle($sectionID)
    {
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

    public function getType($sectionID){
        $type = null;
        try {
            $stmt = $this->connection->prepare('SELECT type FROM section WHERE section_id = :section_id');
            $stmt->bindParam(':section_id', $sectionID, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $type = $result['type'];
            }

        } catch (PDOException $e) {
            error_log('Failed to fetch section title: ' . $e->getMessage());
        }

        return $type;
    }

    public function getSectionPageId($sectionID)
    {
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

    public function updateSectionContent($sectionID, $content, $image)
    {

        try {
            $stmt = $this->connection->prepare("SELECT editor_id, image_id FROM section WHERE section_id = :section_id");
            $stmt->bindParam(':section_id', $sectionID, PDO::PARAM_INT);
            $stmt->execute();
            $section = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!empty($section['editor_id'])) {
                $stmt = $this->connection->prepare("UPDATE editor SET content = :content WHERE id = :editor_id");
                $stmt->bindParam(':content', $content, PDO::PARAM_STR);
                $stmt->bindParam(':editor_id', $section['editor_id'], PDO::PARAM_INT);
                $stmt->execute();
            }

            if (!empty($image['name']) && !empty($section['image_id'])) {
                $stmt = $this->connection->prepare("UPDATE image SET file_path = :image WHERE image_id = :image_id");
                $stmt->bindParam(':image', $image['name'], PDO::PARAM_STR);
                $stmt->bindParam(':image_id', $section['image_id'], PDO::PARAM_INT);
                $stmt->execute();
            }

            $this->connection->commit();
        } catch (Exception $e) {
        }
    }

    public function updateSectionTitle($sectionID, $title)
    {
        if (empty($sectionID)) {
            throw new Exception('No section id');
        }

        $stmt = $this->connection->prepare("UPDATE section SET title = :title WHERE section_id = :section_id");
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':section_id', $sectionID, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateSectionType($sectionID, $type){
        if (empty($sectionID)) {
            throw new Exception('No section id');
        }

        $stmt = $this->connection->prepare("UPDATE section SET type = :type WHERE section_id = :section_id");
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':section_id', $sectionID, PDO::PARAM_INT);
        $stmt->execute();
    }


    public function deleteSection($sectionID)
    {
        try {
            $this->connection->beginTransaction();

            $stmt = $this->connection->prepare("DELETE FROM carousel WHERE section_id = :section_id");
            $stmt->bindParam(':section_id', $sectionID, PDO::PARAM_INT);
            $stmt->execute();

            $stmt = $this->connection->prepare("SELECT editor_id, image_id FROM section WHERE section_id = :section_id");
            $stmt->bindParam(':section_id', $sectionID, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $this->connection->prepare("DELETE FROM section WHERE section_id = :section_id");
            $stmt->bindParam(':section_id', $sectionID, PDO::PARAM_INT);
            $stmt->execute();

            if ($result && $result['editor_id']) {
                $stmt = $this->connection->prepare("DELETE FROM editor WHERE id = :editor_id");
                $stmt->bindParam(':editor_id', $result['editor_id'], PDO::PARAM_INT);
                $stmt->execute();
            }

            if ($result && $result['image_id']) {
                $stmt = $this->connection->prepare("DELETE FROM image WHERE image_id = :image_id");
                $stmt->bindParam(':image_id', $result['image_id'], PDO::PARAM_INT);
                $stmt->execute();
            }

            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollback();
            error_log('Failed to delete section: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deletePage($pageID)
    {
        try {
            $stmt = $this->connection->prepare('DELETE FROM navigation WHERE page_id = :page_id');
            $stmt->bindParam(':page_id', $pageID, PDO::PARAM_INT);
            $stmt->execute();
            
            $stmt = $this->connection->prepare("DELETE FROM page WHERE id = :page_id");
            $stmt->bindParam(':page_id', $pageID, PDO::PARAM_INT);
            $stmt->execute();

        } catch (PDOException $e) {

        }
    }


    public function getPageNameExists($newPageName)
    {
        try {
            $stmt = $this->connection->prepare('SELECT COUNT(*) FROM page WHERE name = :name');
            $stmt->bindParam(':name', $newPageName, PDO::PARAM_STR);
            $stmt->execute();
            $exists = $stmt->fetchColumn();
            return $exists > 0;
        } catch (PDOException $e) {
            error_log('Failed to check if page name exists: ' . $e->getMessage());
            return false;
        }
    }

    public function createPage($newPageName, $amountOfSections)
    {
        try {
            $this->connection->beginTransaction();

            $stmt = $this->connection->prepare('INSERT INTO page (name) VALUES (:name)');
            $stmt->bindParam(':name', $newPageName, PDO::PARAM_STR);
            $stmt->execute();
            $pageId = $this->connection->lastInsertId();

            $currentDateTime = date('Y-m-d H:i:s');

            for ($i = 1; $i <= $amountOfSections; $i++) {
                $stmt = $this->connection->prepare('INSERT INTO editor (content, created) VALUES (:content, :created)');
                $defaultContent = '<p>add content</p>';
                $stmt->bindParam(':content', $defaultContent, PDO::PARAM_STR);
                $stmt->bindParam(':created', $currentDateTime, PDO::PARAM_STR);
                $stmt->execute();
                $editorId = $this->connection->lastInsertId();

                $stmt = $this->connection->prepare('INSERT INTO image (file_path) VALUES (:file_path)');
                $defaultImagePath = 'default.png';
                $stmt->bindParam(':file_path', $defaultImagePath, PDO::PARAM_STR);
                $stmt->execute();
                $imageId = $this->connection->lastInsertId();

                $stmt = $this->connection->prepare('INSERT INTO section (page_id, editor_id, image_id, title, type) VALUES (:page_id, :editor_id, :image_id, :title, :type)');
                $defaultTitle = "New Section " . $i;
                $defaultType = "undefined";
                $stmt->bindParam(':page_id', $pageId, PDO::PARAM_INT);
                $stmt->bindParam(':editor_id', $editorId, PDO::PARAM_INT);
                $stmt->bindParam(':image_id', $imageId, PDO::PARAM_INT);
                $stmt->bindParam(':title', $defaultTitle, PDO::PARAM_STR);
                $stmt->bindParam(':type', $defaultType, PDO::PARAM_STR);
                $stmt->execute();
            }

            $this->connection->commit();
            return $pageId;

        } catch (PDOException $e) {
            $this->connection->rollback();
            error_log('Failed to create page and its sections: ' . $e->getMessage());
            throw $e;
        }
    }

    



    public function addNewSection($pageId, $defaultTitle = 'New Section', $defaultType = 'undefined') {
        try {
            $this->connection->beginTransaction();
    
            $currentDateTime = date('Y-m-d H:i:s');
            $defaultContent = '<p>Add content</p>';
            $defaultImagePath = 'default.png';

            $stmt = $this->connection->prepare('INSERT INTO editor (content, created) VALUES (:content, :created)');
            $stmt->bindParam(':content', $defaultContent, PDO::PARAM_STR);
            $stmt->bindParam(':created', $currentDateTime, PDO::PARAM_STR);
            $stmt->execute();
            $editorId = $this->connection->lastInsertId();

            $stmt = $this->connection->prepare('INSERT INTO image (file_path) VALUES (:file_path)');
            $stmt->bindParam(':file_path', $defaultImagePath, PDO::PARAM_STR);
            $stmt->execute();
            $imageId = $this->connection->lastInsertId();

            $stmt = $this->connection->prepare('INSERT INTO section (page_id, editor_id, image_id, title, type) VALUES (:page_id, :editor_id, :image_id, :title, :type)');
            $stmt->bindParam(':page_id', $pageId, PDO::PARAM_INT);
            $stmt->bindParam(':editor_id', $editorId, PDO::PARAM_INT);
            $stmt->bindParam(':image_id', $imageId, PDO::PARAM_INT);
            $stmt->bindParam(':title', $defaultTitle, PDO::PARAM_STR);
            $stmt->bindParam(':type', $defaultType, PDO::PARAM_STR);
            $stmt->execute();
    
            $this->connection->commit();

        } catch (PDOException $e) {
            $this->connection->rollback();
            error_log('Failed to add new section: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createResturantPage($newPageName, $section)
    {
        try {
            $this->connection->beginTransaction();

            $stmt = $this->connection->prepare('INSERT INTO page (name) VALUES (:name)');
            $stmt->bindParam(':name', $newPageName, PDO::PARAM_STR);
            $stmt->execute();
            $pageId = $this->connection->lastInsertId();

            $currentDateTime = date('Y-m-d H:i:s');

            foreach ($section as $sectionData) {
                $stmt = $this->connection->prepare('INSERT INTO editor (content, created) VALUES (:content, :created)');
                $stmt->bindParam(':content', $sectionData['content'], PDO::PARAM_STR);
                $stmt->bindParam(':created', $currentDateTime, PDO::PARAM_STR);
                $stmt->execute();
                $editorId = $this->connection->lastInsertId();

                $stmt = $this->connection->prepare('INSERT INTO image (file_path) VALUES (:file_path)');
                $stmt->bindParam(':file_path', $sectionData['image'], PDO::PARAM_STR);
                $stmt->execute();
                $imageId = $this->connection->lastInsertId();

                $stmt = $this->connection->prepare('INSERT INTO section (page_id, editor_id, image_id, title, type) VALUES (:page_id, :editor_id, :image_id, :title, :type)');
                $stmt->bindParam(':page_id', $pageId, PDO::PARAM_INT);
                $stmt->bindParam(':editor_id', $editorId, PDO::PARAM_INT);
                $stmt->bindParam(':image_id', $imageId, PDO::PARAM_INT);
                $stmt->bindParam(':title', $sectionData['title'], PDO::PARAM_STR);
                $stmt->bindParam(':type', $sectionData['type'], PDO::PARAM_STR);
                $stmt->execute();
            }

            $this->connection->commit();
            return $pageId;

        } catch (PDOException $e) {
            $this->connection->rollback();
            error_log('Failed to create page and its sections: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getPageIdByRestaurantId($restaurant_id){
        try {
            $stmt = $this->connection->prepare('SELECT page_id FROM Restaurant WHERE resturant_id = :resturant_id');
            $stmt->bindParam(':resturant_id', $restaurant_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (PDOException $e) {
            error_log('Failed to fetch page id: ' . $e->getMessage());
            return null;
        }
    }
    

    



}
