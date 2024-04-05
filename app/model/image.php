<?php
namespace model;

class Image implements \JsonSerializable
{
    private int $image_id;
    private ?string $file_path; 


    public function getImageId(): int {
        return $this->image_id;
    }

    public function setImageId(int $image_id): void {
        $this->image_id = $image_id;
    }

    public function getFilePath(): ?string {
        return $this->file_path;
    }

    public function setFilePath(?string $file_path): void {
        $this->file_path = filter_var($file_path, FILTER_SANITIZE_URL);
    }

    public function jsonSerialize(): mixed {
        return [
            'image_id' => $this->image_id,
            'file_path' => $this->file_path,
        ];
    }
}
?>
