<?php

namespace controllers;

use services\AdminService;

require_once __DIR__ . '/../services/AdminService.php';


class AdminController
{
    private $adminservice;
  
    public function __construct() {
        $this->adminservice = new AdminService();
    }

    public function show()
    {
        $userDetails = $_SESSION['user'];
        require_once __DIR__ . '/../views/admin/dashboard.php';
    }

    public function manageUsers(){
        require_once __DIR__ . '/../views/admin/manage-users.php';
    }

    public function getAllUsers(){
        header('Content-Type: application/json');
        $allUsers = $this->adminservice->getAllUsers();
        echo json_encode($allUsers);
    }

    public function editUsers($userID){
    }

    public function deleteUsers() {
        header('Content-Type: application/json');
        $userID = htmlspecialchars($_POST['user_id'] ?? '');
        $result = $this->adminservice->deleteUsers($userID);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'User has been deleted']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete user']);
        }
    
    }
    
    public function filterUsers() {
        header('Content-Type: application/json');
        $username = '%' . htmlspecialchars($_POST['username'] ?? '') . '%'; // Using % for LIKE SQL query
        $role = htmlspecialchars($_POST['role'] ?? '');
        $filteredUsers = $this->adminservice->filterUsers($username, $role);
        echo json_encode($filteredUsers);
    }

    public function addUsers() {
        header('Content-Type: application/json');
        $username = htmlspecialchars($_POST['username'] ?? '');
        $email = htmlspecialchars($_POST['email'] ?? '');
        $role = htmlspecialchars($_POST['role'] ?? '');
        $password = htmlspecialchars($_POST['password'] ?? '');
    
        $usernameInUse = $this->adminservice->username_exists($username);
        $emailInUse = $this->adminservice->email_exists($email);
    
        if($usernameInUse || $emailInUse){
            $message = 'Username and/or email already in use';
            if ($usernameInUse) {
                $message = 'Username already in use';
            }
            if ($emailInUse) {
                $message = 'Email already in use';
            }
            if ($usernameInUse && $emailInUse) {
                $message = 'Both username and email are already in use';
            }
            echo json_encode(['success'=> false, 'message'=> $message]);
            return; 
        }

        $result = $this->adminservice->createUsers($username, $password, $role, $email);
    
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'User has been added']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add user']);
        }
    }
    
    
}
