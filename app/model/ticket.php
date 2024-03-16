<?php

namespace model;

class Ticket implements \JsonSerializable
{
    private int $ticket_id;
    private ?int $user_id = null; 
    private int $quantity;
    private string $ticket_hash;
    private string $state;
    private int $event_id;
    private string $language;
    private ?string $date = null; 
    private ?string $time = null; 
    

    public function getTicketId(): int {
        return $this->ticket_id;
    }

    public function setTicketId(int $ticket_id): void {
        $this->ticket_id = $ticket_id;
    }



    public function getUserId(): ?int { 
        return $this->user_id;
    }

    public function setUserId(?int $user_id): void { 
        $this->user_id = $user_id;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void {
        $this->quantity = $quantity;
    }

    public function getTicketHash(): string {
        return $this->ticket_hash;
    }

    public function setTicketHash(string $ticket_hash): void {
        $this->ticket_hash = $ticket_hash;
    }

    public function getState(): string {
        return $this->state;
    }

    public function setState(string $state): void {
        $this->state = $state;
    }

    public function getEventId(): int {
        return $this->event_id;
    }

    public function setEventId(int $event_id): void {
        $this->event_id = $event_id;
    }

    public function getTicketLanguage(): string {
        return $this->language;
    }

    public function setTicketLanguage(string $language): void {
        $this->language = $language;
    }

    public function getTicketDate(): ?string { 
        return $this->date;
    }

    public function setTicketDate(?string $date): void {
        $this->date = $date;
    }

    public function getTicketTime(): ?string { 
        return $this->time;
    }

    public function setTicketTime(?string $time): void { 
        $this->time = $time;
    }

    public function jsonSerialize(): mixed {
        return [
            'ticket_id' => $this->getTicketId(),
            'user_id' => $this->getUserId(),
            'quantity' => $this->getQuantity(),
            'ticket_hash' => $this->getTicketHash(),    
            'state' => $this->getState(),
            'event_id' => $this->getEventId(),
            'language' => $this->getTicketLanguage(),
            'date' => $this->getTicketDate(),
            'time'=> $this->getTicketTime(),
        ];
    }
}
