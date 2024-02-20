<?php
namespace model;

class History implements \JsonSerializable
{
    private int $history_id;
    private string $speaker;
    private int $picture_id;
    private int $content_id;
    private int $event_id;

    public function getHistoryId(): int {
        return $this->history_id;
    }

    public function setHistoryId(int $history_id): void {
        $this->history_id = $history_id;
    }

    public function getSpeaker(): string {
        return $this->speaker;
    }

    public function setSpeaker(string $speaker): void {
        $this->speaker = $speaker;
    }

    public function getPictureId(): int {
        return $this->picture_id;
    }

    public function setPictureId(int $picture_id): void {
        $this->picture_id = $picture_id;
    }

    public function getContentId(): int {
        return $this->content_id;
    }

    public function setContentId(int $content_id): void {
        $this->content_id = $content_id;
    }

    public function getEventId(): int {
        return $this->event_id;
    }

    public function setEventId(int $event_id): void {
        $this->event_id = $event_id;
    }

    public function jsonSerialize(): mixed {
        return [
            'history_id' => $this->history_id,
            'speaker' => $this->speaker,
            'picture_id' => $this->picture_id,
            'content_id' => $this->content_id,
            'event_id' => $this->event_id,
        ];
    }
}
