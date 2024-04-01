<?php

namespace controllers;

use services\AdminService;
use services\Pageservice;
use model\User;

require_once __DIR__ . '/../model/user.php';
require_once __DIR__ . '/../services/AdminService.php';
require_once __DIR__ . '/../services/pageservice.php';

class AdminController
{
    private $adminservice;
    private $usermodel;
    private $pageservice;
  
    public function __construct() {
        $this->pageservice = new Pageservice();
        $this->adminservice = new AdminService();
        $this->usermodel = new User();
    }

    public function show()
    {
        $userDetails = $_SESSION['user'];
        require_once __DIR__ . '/../views/admin/dashboard.php';
    }

    public function manageUsers(){
        require_once __DIR__ . '/../views/admin/manage-users.php';
    }

    public function manageFestivals(){
        $allEvents = $this->adminservice->getListOfEvents();
        require_once __DIR__ . '/../views/admin/managefestival.php';
    }
    

    public function editFestivals(){
        $allPages = $this->pageservice->getPages();
        require_once __DIR__ . '/../views/admin/editfestival.php';
    }

    public function manageOrders(){
        require_once __DIR__ . '/../views/admin/orders.php';
    }

    public function getAllUsers(){
        header('Content-Type: application/json');
        $allUsers = $this->adminservice->getAllUsers();
        echo json_encode($allUsers);
    }

    public function editUsers() {
        header('Content-Type: application/json');
        header('X-Content-Type-Options: nosniff'); 
        
        $userid = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL); 
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        if (empty($userid) || empty($username) || !$email || empty($role)) { 
            echo json_encode(['success' => false, 'message' => 'Invalid or missing user details for update.']);
            return;
        }

        $result = $this->adminservice->updateUser($userid, $username, $email, $role);

        if ($result['success']) {
            echo json_encode(['success' => true, 'message' => 'User has been updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update user. ' . $result['message']]);
        }
    }
    


    public function deleteUsers() {
        header('Content-Type: application/json');
        header('X-Content-Type-Options: nosniff');
        $userID = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
        $result = $this->adminservice->deleteUsers($userID);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'User has been deleted']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete user']);
        }
    }
    
    
    public function filterUsers() {
        header('Content-Type: application/json');
        $username = '%' . filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS) . '%'; // Using % for LIKE SQL query
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $filteredUsers = $this->adminservice->filterUsers($username, $role);
        echo json_encode($filteredUsers);
    }
    

    public function addUsers() {
        header('Content-Type: application/json');
        header('X-Content-Type-Options: nosniff');
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = $_POST['password'] ?? ''; 

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        $usernameInUse = $this->adminservice->username_exists($username);
        $emailInUse = $this->adminservice->email_exists($email);
    
        $newUser = new User();
        $newUser->setUsername($username);
        $newUser->setUserEmail($email);
        $newUser->setUserRole($role);
        $newUser->setPassword($hashedPassword);
    
        if($usernameInUse || $emailInUse) {
            $message = 'Username and/or email already in use';
            echo json_encode(['success'=> false, 'message'=> $message]);
            return; 
        }
        $result = $this->adminservice->createUsers($newUser);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'User has been added']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add user']);
        }
    }
    
}
