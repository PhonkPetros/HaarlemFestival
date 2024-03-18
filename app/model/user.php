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
    private ?string $firstname;
    private ?string $lastname;
    private ?string $address;
    private ?string $phone_number;
    private ?int $rating;

    public function jsonSerialize() : mixed{
        return [
            'user_id' => $this->getUserID(),
            'email' => $this->getUserEmail(),
            'username' => $this->getUsername(),
            'role' => $this->getUserRole(),
            'created_at' => $this->getRegistrationDate(),
            'firstname' => $this->getFirstname(),
            'lastname' => $this->getLastname(),
            'address' => $this->getAddress(),
            'phone_number' => $this->getPhoneNumber(),
            'rating' => $this->getRating(),
        ];
    }

    public function getFirstname(): ?string {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): void {
        $this->firstname = $firstname;
    }

    public function getRating(): ?int {
        return $this->rating;
    }

    public function setRating(?int $rating): void {
        $this->rating = $rating;
    }


    public function getLastname(): ?string {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): void {
        $this->lastname = $lastname;
    }

    public function getAddress(): ?string {
        return $this->address;
    }

    public function setAddress(?string $address): void {
        $this->address = $address;
    }

    public function getPhoneNumber(): ?string {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): void {
        $this->phone_number = $phone_number;
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
