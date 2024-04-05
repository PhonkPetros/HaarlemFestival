<?php
namespace model;

class Carousel implements \JsonSerializable
{
    private int $carousel_id;
    private int $section_id;
    private int $image_id;
    private ?string $label; 

    public function getCarouselId(): int {
        return $this->carousel_id;
    }

    public function setCarouselId(int $carousel_id): void {
        $this->carousel_id = filter_var($carousel_id, FILTER_SANITIZE_NUMBER_INT);
    }

    public function getLabel(): ?string {
        return $this->label;
    }

    public function setLabel(?string $label): void {
        $this->label = $label !== null ? filter_var($label, FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;  
    }

    public function getSectionId(): int {
        return $this->section_id;
    }

    public function setSectionId(int $section_id): void {
        $this->section_id = filter_var($section_id, FILTER_SANITIZE_NUMBER_INT);
    }

    public function getImageId(): int {
        return $this->image_id;
    }

    public function setImageId(int $image_id): void {
        $this->image_id = filter_var($image_id, FILTER_SANITIZE_NUMBER_INT);
    }

    public function jsonSerialize(): mixed {
        return [
            'carousel_id' => $this->getCarouselId(),
            'section_id' => $this->getSectionId(),
            'image_id' => $this->getImageId(),
            'label'=> $this->getLabel(),
        ];
    }
}
?>
