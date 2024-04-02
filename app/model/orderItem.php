<?
namespace model;

class OrderItem implements \JsonSerializable
{
    private int $order_item_id;
    private int $order_id;
    private int $user_id;
    private int $quantity;
    private ?string $language; 
    private string $date;
    private string $start_time;
    private string $end_time;
    private string $item_hash;
    private ?int $event_id;
    private ?string $location; 
    private ?string $ticket_type; 
    private ?string $artist_name;
    private ?string $restaurant_name; 
    private ?string $special_remarks;
    private ?string $status;

    public function jsonSerialize(): mixed {
        return [
            'order_item_id' => $this->getOrderItemId(),
            'order_id' => $this->getOrderId(),
            'user_id' => $this->getUserId(),
            'quantity' => $this->getQuantity(),
            'language' => $this->getLanguage(),
            'date' => $this->getDate(),
            'start_time' => $this->getStartTime(),
            'end_time' => $this->getEndTime(),
            'item_hash' => $this->getItemHash(),
            'event_id' => $this->getEventId(),
            'location' => $this->getLocation(),
            'ticket_type' => $this->getTicketType(),
            'artist_name' => $this->getArtistName(),
            'restaurant_name' => $this->getRestaurantName(),
            'special_remarks' => $this->getSpecialRemarks(),
            'status' => $this->getStatus(),
        ];
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void {
        $this->status = $status;
    }

    public function getEventId(): ?int {
        return $this->event_id;
    }

    public function setEventId(?int $event_id): void {
        $this->event_id = $event_id;
    }

    public function getLocation(): ?string {
        return $this->location;
    }

    public function setLocation(?string $location): void {
        $this->location = $location;
    }

    public function getTicketType(): ?string {
        return $this->ticket_type;
    }

    public function setTicketType(?string $ticket_type): void {
        $this->ticket_type = $ticket_type;
    }

    public function getArtistName(): ?string {
        return $this->artist_name;
    }

    public function setArtistName(?string $artist_name): void {
        $this->artist_name = $artist_name;
    }

    public function getRestaurantName(): ?string {
        return $this->restaurant_name;
    }

    public function setRestaurantName(?string $restaurant_name): void {
        $this->restaurant_name = $restaurant_name;
    }

    public function getSpecialRemarks(): ?string {
        return $this->special_remarks;
    }

    public function setSpecialRemarks(?string $special_remarks): void {
        $this->special_remarks = $special_remarks;
    }

    public function getOrderItemId(): int {
        return $this->order_item_id;
    }

    public function setOrderItemId(int $order_item_id): void {
        $this->order_item_id = $order_item_id;
    }

    public function getOrderId(): int {
        return $this->order_id;
    }

    public function setOrderId(int $order_id): void {
        $this->order_id = $order_id;
    }

    public function getUserId(): int {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void {
        $this->user_id = $user_id;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void {
        $this->quantity = $quantity;
    }

    public function getLanguage(): string {
        return $this->language;
    }

    public function setLanguage(string $language): void {
        $this->language = $language;
    }

    public function getDate(): string {
        return $this->date;
    }

    public function setDate(string $date): void {
        $this->date = $date;
    }

    public function getStartTime(): string {
        return $this->start_time;
    }

    public function setStartTime(string $start_time): void {
        $this->start_time = $start_time;
    }

    public function getEndTime(): string {
        return $this->end_time;
    }

    public function setEndTime(string $end_time): void {
        $this->end_time = $end_time;
    }

    public function getItemHash(): string {
        return $this->item_hash;
    }

    public function setItemHash(string $item_hash): void {
        $this->item_hash = $item_hash;
    }
}
