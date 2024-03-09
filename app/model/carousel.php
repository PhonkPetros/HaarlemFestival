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
        $this->carousel_id = $carousel_id;
    }

    public function getLabel(): ?string {
        return $this->label;
    }

    public function setLabel(?string $lable): void {
        $this->label = $lable;  
    }
    public function getSectionId(): int {
        return $this->section_id;
    }

    public function setSectionId(int $section_id): void {
        $this->section_id = $section_id;
    }

    public function getImageId(): int {
        return $this->image_id;
    }

    public function setImageId(int $image_id): void {
        $this->image_id = $image_id;
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
