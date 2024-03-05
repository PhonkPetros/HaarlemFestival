<?php
namespace model;

class Carousel implements \JsonSerializable
{
    private int $carousel_id;
    private int $section_id;
    private int $image_id;

    public function __construct(int $carousel_id = 0, int $section_id = 0, int $image_id = 0) {
        $this->carousel_id = $carousel_id;
        $this->section_id = $section_id;
        $this->image_id = $image_id;
    }

    public function getCarouselId(): int {
        return $this->carousel_id;
    }

    public function setCarouselId(int $carousel_id): void {
        $this->carousel_id = $carousel_id;
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
        ];
    }
}
