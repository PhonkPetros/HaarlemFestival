<?php
namespace model;

class Event implements \JsonSerializable
{
    private $artist;
    private $dayPass;
    private $allDayPass;
    private $seats;
    
    private int $event_id;
    private string $name;
    private string $startDate;
    private string $location;
    private int $price;
    private string $picture;
    private string $endDate;
    

    public function jsonSerialize(): mixed {
        return [
            'event_id' => $this->getEventId(),
            'name' => $this->getName(),
            'startDate' => $this->getStartDate(),
            'endDate' => $this->getEndDate(),
            'location' => $this->getLocation(),
            'price' => $this->getPrice(),
            'picture' => $this->getPicture(),
        ];
    }

    public function getEventId(): int {
        return $this->event_id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getStartDate(): string {
        return $this->startDate;
    }

    public function getEndDate(): string {
        return $this->endDate;
    }


    public function getLocation(): string {
        return $this->location;
    }

    public function getPrice(): int {
        return $this->price;
    }

    public function getPicture(): string {
        return $this->picture;
    }

    public function setEventId(int $event_id): void {
        $this->event_id = $event_id;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setStartDate(string $date): void {
        $this->startDate = $date;
    }

    public function setEndDate(string $date): void {
        $this->endDate = $date;
    }

    public function setLocation(string $location): void {
        $this->location = $location;
    }

    public function setPrice(int $price): void {
        $this->price = $price;
    }

    public function setPicture(string $picture): void {
        $this->picture = $picture;
    }

}
