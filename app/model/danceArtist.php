<?php
namespace model;

class DanceArtist {
    private int $artistId;
    private string $name;
    private string $image;

    public function __construct(int $artistId, string $name, string $image) {
        $this->artistId = $artistId;
        $this->name = $name;
        $this->image = $image;
    }

    public function getArtistId(): int {
        return $this->artistId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getImage(): string {
        return $this->image;
    }
}