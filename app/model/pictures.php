<?php 
namespace model;

class Pictures implements \JsonSerializable
{
    private int $picture_id;
    private string $picture_path;

    public function getPictureId(): int {
        return $this->picture_id;
    }

    public function setPictureId(int $picture_id): void {
        $this->picture_id = $picture_id;
    }

    public function getPicturePath(): string {
        return $this->picture_path;
    }

    public function setPicturePath(string $picture_path): void {
        $this->picture_path = $picture_path;
    }

    public function jsonSerialize(): mixed {
        return [
            'picture_id' => $this->picture_id,
            'picture_path' => $this->picture_path,
        ];
    }
}
