<?php
namespace model;

class Editor implements \JsonSerializable
{
    private int $content_id;
    private string $content;
    private string $created;

    public function getContentId(): int {
        return $this->content_id;
    }

    public function setContentId(int $content_id): void {
        $this->content_id = $content_id;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function setContent(string $content): void {
        $this->content = $content;
    }

    
    public function getCreated(): string {
        return $this->created;
    }

    public function setCreated(string $created): void {
        $this->created = $created;
    }

    public function jsonSerialize(): mixed {
        return [
            'id' => $this->getContentId(),
            'content' => $this->getContent(),
            'created'=> $this->getCreated(),
        ];
    }
}
