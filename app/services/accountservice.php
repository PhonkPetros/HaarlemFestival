<?php

namespace services;

use repositories\accountrepository;

require_once __DIR__ . '/../repositories/accountrepository.php'; 

class Accountervice {

    private $accountRepository;

    public function __construct() {
        $this->accountRepository = new accountrepository(); 
    }

    
    public function updateEmail(int $userID, string $newEmail): bool {
        return $this->accountRepository->updateEmail($userID, $newEmail);
    }

    
    public function updateUsername(int $userID, string $newUsername): bool {
        return $this->accountRepository->updateUsername($userID, $newUsername);
    }

 
    public function updatePassword(int $userID, string $newPassword): bool {
        return $this->accountRepository->updatePassword($userID, $newPassword);
    }
}
