<?php

namespace services;

use repositories\AccountRepository; 
require_once __DIR__ . '/../repositories/AccountRepository.php'; 

class AccountService {
    private $adminRepository;

    public function __construct() {
        $this->adminRepository = new AccountRepository(); 
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
}