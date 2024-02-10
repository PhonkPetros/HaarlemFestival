<?php

namespace controllers;
use services\adminservice;

require_once __DIR__ . '/../services/adminservice.php';

class admincontroller
{

    public $adminservice;
  
    public function __construct() {
        $this->adminservice = new adminservice();
    }

    public function show()
    {
        $userDetails =  $_SESSION['user'];
        require_once '../views/admin/dashboard.php';
    }

    public function manageUsers(){
        require_once '../views/admin/manage-users.php';
    }

    public function getAllUsers(){
        header('Content-Type: application/json');
        $allUsers = $this->adminservice->getAllUsers();
        echo json_encode($allUsers);
    }

    public function editUsers($userID){

    }

    public function deleteUsers() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"])) {
            $userID = htmlspecialchars($_POST["user_id"]);
            $this->adminservice->deleteUsers($userID);
            header('Location: /admin/manage-users'); 
        } else {
            echo "Error deleting user";
        }
    }
    

    public function filterUsers() {
        header('Content-Type: application/json');
        $username = '%'.($_POST['username'] ?? '').'%'; // Use % for LIKE SQL query
        $role = $_POST['role'] ?? '';
        $filteredUsers = $this->adminservice->filterUsers($username, $role);
        echo json_encode($filteredUsers);
    }


}
