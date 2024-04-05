<?php
namespace model;

class Page implements \JsonSerializable
{
    private int $id;
    private string $name;

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
        $this->name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function jsonSerialize(): mixed {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}
