<?php

namespace model;

class User implements \JsonSerializable
{
    private int $user_id;
    private string $email;
    private string $username;
    private string $password_hash;
    private string $role;
    private string $created_at;

    public function jsonSerialize() : mixed{
        return [
            'user_id' => $this->getUserID(),
            'email' => $this->getUserEmail(),
            'username' => $this->getUsername(),
            'role' => $this->getUserRole(),
            'created_at' => $this->getRegistrationDate(),
        ];
    }

    public function getUserID(): int
    {
        return $this->user_id;
    }

    public function setUserID(int $userID): void
    {
        $this->user_id = $userID;
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
        return $this->password_hash;
    }

    public function setPassword(string $password): void
    {
        $this->password_hash = $password;
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

    public function getRegistrationDate(): string {
        return $this->created_at;
    }

    public function setRegistrationDate(string $registrationDate): void {
        $this->created_at = $registrationDate;
    }
}
