<?php

namespace model;
use DateTime;

class user
{
    public int $userID; 
    public ?int $ticketID; 
    public string $username;
    public string $password; 
    public string $role;
    public string $email; 
    public DateTime $registrationDate;

    public function currentUserData(): array
    {
        return [
            'userID' => $this->userID,
            'ticketID' => $this->ticketID,
            'username' => $this->username,
            'role' => $this->role,
            'email' => $this->email,
            'created_at' => $this->registrationDate->format('Y-m-d H:i:s'), 
        ];
    }
}
