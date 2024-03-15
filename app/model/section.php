<?php
namespace model;

enum Type {
    case Banner;
    case Body;
    case Title;
    case Image;
    case Carousel; 
}

class Section implements \JsonSerializable
{
    private int $section_id;
    private ?int $editor_id;
    private ?int $image_id;
    private int $page_id;
    private string $title;
    private string $type;

    public function getSectionId(): int {
        return $this->section_id;
    }

    public function setSectionId(int $section_id): void {
        $this->section_id = $section_id;
    }

    public function getEditorId(): ?int {
        return $this->editor_id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): void{
        $this->title = $title;
    }

    public function setEditorId(?int $editor_id): void {
        $this->editor_id = $editor_id;
    }

    public function getType(): string {
        return $this->type; 
    }

    public function setType(string $type): void{ 
        $this->type = $type;
    }

    public function getImageId(): ?int { 
        return $this->image_id;
    }

    public function setImageId(?int $image_id): void { 
        $this->image_id = $image_id;
    }

    public function getPageId(): int {
        return $this->page_id;
    }

    public function setPageId(int $page_id): void {
        $this->page_id = $page_id;
    }

    public function jsonSerialize(): mixed {
        return [
            'section_id' => $this->getSectionId(),
            'editor_id' => $this->getEditorId(),
            'image_id' => $this->getImageId(),
            'page_id' => $this->getPageId(),
            'title'=> $this->getTitle(),
            'type'=> $this->getType() 
        ];
    }
}
?>
