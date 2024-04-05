<?php
namespace model;

class Order implements \JsonSerializable
{
    private int $order_id;
    private int $user_id;
    private float $total_price;
    private string $order_hash;
    private string $status;
    private string $created_at;

    public function jsonSerialize(): mixed {
        return [
            'order_id' => $this->getOrderId(),
            'user_id' => $this->getUserId(),
            'total_price' => $this->getTotalPrice(),
            'order_hash' => $this->getOrderHash(),
            'status' => $this->getStatus(),
            'created_at' => $this->getCreatedAt(),
        ];
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

    public function getTotalPrice(): float {
        return $this->total_price;
    }

    public function setTotalPrice(float $total_price): void {
        $this->total_price = $total_price;
    }

    public function getOrderHash(): string {
        return $this->order_hash;
    }

    public function setOrderHash(string $order_hash): void {
        $this->order_hash = filter_var($order_hash, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = filter_var($status, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public function getCreatedAt(): string {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): void {
        $this->created_at = $created_at;
    }
}
?>
