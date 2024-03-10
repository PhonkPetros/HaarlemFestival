<?

namespace model;

use JsonSerializable;

class Restaurant implements \JsonSerializable{
    private int $id;
    private string $name;
    private string $location;
    private int $price;
    private ?int $seats;
    private string $startDate;
    private string $endDate;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getLocation(): string {
        return $this->location;
    }

    public function setLocation(string $location): void {
        $this->location = $location;
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
        ];
    }
}