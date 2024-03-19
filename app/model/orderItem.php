<?
namespace model;

class OrderItem implements \JsonSerializable
{
    private int $order_item_id;
    private int $order_id;
    private int $user_id;
    private int $quantity;
    private string $language;
    private string $date;
    private string $start_time;
    private string $end_time;
    private string $item_hash;

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
        ];
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
