<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use DateTime;
use model\Editor;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/editor.php';


class EditorRepository extends dbconfig {
    
    public function findEditorContentById($editorId)
    {
        $stmt = $this->connection->prepare("SELECT id AS content_id, content, created FROM editor WHERE id = :editorId");
        $stmt->bindParam(':editorId', $editorId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject(Editor::class);
    }
    
    
    
    
}