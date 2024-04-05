<?php
namespace model;

class DanceArtist implements \JsonSerializable {
    public int $artistId;
    public string $name;
    public $profile;

    public function __construct(int $artistId, string $name, $profile) {
        $this->artistId = $artistId;
        $this->name = $name;
        $this->profile = $profile;
    }

    public function jsonSerialize(): mixed {
        return [
            'id' => $this->getArtistId(),
            'name' => $this->getName(),
            'profile' => $this->getProfile()
        ];
    }

    public function getArtistId(): int {
        return $this->artistId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getProfile() {
        return $this->profile;
    }

    public function setName(string $name): void {
        $this->name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
}
?>
