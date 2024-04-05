<?php

namespace model;

use JsonSerializable;

class Restaurant implements JsonSerializable{
    private int $id;
    private string $name;
    private string $location;
    private int $price;
    private ?int $seats;
    private string $startDate;
    private string $endDate;
    private ?string $picture;
    private string $description;
    private int $eventId;

    public function getId(): int {
        return $this->id;
    }

    public function setEventId(int $eventId): void {
        $this->eventId = $eventId;
    }

    public function getEventId(): int {
        return $this->eventId;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getPicture(): ?string {
        return $this->picture;
    }
    
    public function setPicture(?string $picture): void {
        $this->picture = $picture;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public function getLocation(): string {
        return $this->location;
    }

    public function setLocation(string $location): void {
        $this->location = filter_var($location, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public function getPrice(): int {
        return $this->price;
    }

    public function setPrice(int $price): void {
        $this->price = $price;
    }

    public function getSeats(): ?int {
        return $this->seats;
    }
    

    public function setSeats(?int $seats): void {
        $this->seats = $seats;
    }

    public function getStartDate(): string {
        return $this->startDate;
    }

    public function setStartDate(string $startDate): void {
        $this->startDate = $startDate;
    }

    public function getEndDate(): string {
        return $this->endDate;
    }


    public function setDescription(string $description): void {
        $this->description = filter_var($description, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public function getDescription(): string {
        return $this->description;
    }
    
    public function setEndDate(string $endDate): void {
        $this->endDate = $endDate;
    }

    public function jsonSerialize(): mixed {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'location' => $this->getLocation(),
            'price' => $this->getPrice(),
            'seats' => $this->getSeats(),
            'startDate' => $this->getStartDate(),
            'endDate' => $this->getEndDate(),
            'picture' => $this->getPicture()
        ];
    }
}
