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
        require_once __DIR__ . '/../views/admin/page-managment/editfestival.php';
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
        
        $userid = htmlspecialchars($_POST['user_id'] ?? '');
        $username = htmlspecialchars($_POST['username'] ?? '');
        $email = htmlspecialchars($_POST['email'] ?? '');
        $role = htmlspecialchars($_POST['role'] ?? '');
    
        if (empty($userid) || empty($username) || empty($email) || empty($role)) {
            echo json_encode(['success' => false, 'message' => 'Missing user details for update.']);
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
        $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : null;
        $role = htmlspecialchars($_POST['role'] ?? '');
        $password = htmlspecialchars($_POST['password'] ?? '');
        $usernameInUse = $this->adminservice->username_exists($username);
        $emailInUse = $this->adminservice->email_exists($email);

        $newUser = new User();
        $newUser->setUsername( $username );
        $newUser->setUserEmail( $email );
        $newUser->setUserRole( $role );
        $newUser->setPassword( $password );


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
        $result = $this->adminservice->createUsers($newUser);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'User has been added']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add user']);
        }
    }
}
