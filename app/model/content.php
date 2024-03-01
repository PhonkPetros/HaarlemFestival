<?php
namespace model;

class Content implements \JsonSerializable
{
    private int $content_id;
    private string $context;

    public function getContentId(): int {
        return $this->content_id;
    }

    public function setContentId(int $content_id): void {
        $this->content_id = $content_id;
    }

    public function getContext(): string {
        return $this->context;
    }

    public function setContext(string $context): void {
        $this->context = $context;
    }

    public function jsonSerialize(): mixed {
        return [
            'content_id' => $this->content_id,
            'context' => $this->context,
        ];
    }
}
