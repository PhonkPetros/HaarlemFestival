<?php

namespace services;

use repositories\AdminRepository; 
use repositories\registerrepository; 
require_once __DIR__ . '/../repositories/AdminRepository.php'; 
require_once __DIR__ . '/../repositories/registerrepository.php'; 

class AdminService {
    private $adminRepository;
    private $registerRepository;

    public function __construct() {
        $this->adminRepository = new AdminRepository(); 
        $this->registerRepository = new RegisterRepository();
    }

    public function getAllUsers() {
        return $this->adminRepository->getAllUsers();
    }

    public function filterUsers($username, $role) {
        return $this->adminRepository->filterUsers($username, $role);
    }

    public function deleteUsers($userID) {
        return $this->adminRepository->deleteUsers($userID);
    }

    public function createUsers($username, $email, $role, $password) {
        return $this->adminRepository->registerUser($username, $email, $role, $password);
    }

    public function username_exists($username) {
        return $this->registerRepository->usernameExists($username);
    }

    public function email_exists($email) {
        return $this->registerRepository->emailExists($email);
    }

    public function updateUser($userid, $username, $email, $role){
        return $this->adminRepository->editUser($userid, $username, $email, $role);
    }
    public function getUserById($userid) {
        return $this->adminRepository->getUserById($userid);
    }

 


}