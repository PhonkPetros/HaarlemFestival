<?php
namespace model;

class Event implements \JsonSerializable
{
    private int $event_id;
    private string $name;
    private string $date;
    private string $location;
    private int $price;
    private string $time;
    private string $picture;

    public function jsonSerialize(): mixed {
        return [
            'event_id' => $this->getEventId(),
            'name' => $this->getName(),
            'date' => $this->getDate(),
            'location' => $this->getLocation(),
            'price' => $this->getPrice(),
            'time' => $this->getTime(),
            'picture' => $this->getPicture(),
        ];
    }

    public function getEventId(): int {
        return $this->event_id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDate(): string {
        return $this->date;
    }

    public function getLocation(): string {
        return $this->location;
    }

    public function getPrice(): int {
        return $this->price;
    }

    public function getTime(): string {
        return $this->time;
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

    public function setDate(string $date): void {
        $this->date = $date;
    }

    public function setLocation(string $location): void {
        $this->location = $location;
    }

    public function setPrice(int $price): void {
        $this->price = $price;
    }

    public function setTime(string $time): void {
        $this->time = $time;
    }

    public function setPicture(string $picture): void {
        $this->picture = $picture;
    }

}
