<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;

require_once __DIR__ . '/../config/dbconfig.php';

class AccountRepository extends dbconfig {
    
    public function getAllUsers() {
        
    }

    public function filterUsers($username, $role) {
      
    }

    public function deleteUsers($userID) {
       
    }
    
}
