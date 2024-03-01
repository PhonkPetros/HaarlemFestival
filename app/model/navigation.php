<?php

namespace model;

class Navigation implements \JsonSerializable {
    private int $navigation_id;
    private int $page_id;
    private string $pageName; 


    public function getId(): int {
        return $this->navigation_id;
    }

    public function setId(int $id): void {
        $this->navigation_id = $id;
    }

    public function getPageID(): int {
        return $this->page_id;
    }

    public function setPageID(int $pageID): void {
        $this->page_id = $pageID;
    }

    public function getPageName(): string {
        return $this->pageName;
    }

    public function setPageName(string $pageName): void {
        $this->pageName = $pageName;
    }

    public function jsonSerialize(): mixed {
        return [
            'navigation_id' => $this->getId(),
            'page_id' => $this->getPageID(),
            'pageName' => $this->getPageName(),
        ];
    }
}
