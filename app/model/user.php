<?php

namespace model;

use DateTime;

class User
{
    private int $userID;
    private ?int $ticketID;
    private string $username;
    private string $password;
    private string $role;
    private string $email;
    private DateTime $registrationDate;

    public function getUserData(): array
    {
        return [
            'userID' => $this->getUserID(),
            'ticketID' => $this->getTicketID(),
            'username' => $this->getUsername(),
            'role' => $this->getUserRole(),
            'email' => $this->getUserEmail(),
            'created_at' => $this->getRegistrationDate()->format('Y-m-d H:i:s'), 
        ];
    }

    public function getUserID(): int
    {
        return $this->userID;
    }

    public function setUserID(int $userID): void
    {
        $this->userID = $userID;
    }

    public function getTicketID(): ?int
    {
        return $this->ticketID;
    }

    public function setTicketID(?int $ticketID): void
    {
        $this->ticketID = $ticketID;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getUserRole(): string
    {
        return $this->role;
    }

    public function setUserRole(string $role): void
    {
        $this->role = $role;
    }

    public function getUserEmail(): string
    {
        return $this->email;
    }

    public function setUserEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getRegistrationDate(): DateTime
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(DateTime $registrationDate): void
    {
        $this->registrationDate = $registrationDate;
    }
}
