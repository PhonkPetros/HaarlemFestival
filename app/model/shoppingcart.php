<?php
namespace model;

class Shoppingcart implements \JsonSerializable
{
    private int $cart_id;
    private string $time_added;


    public function getCartID() : int{
        return $this->cart_id;
    }

    public function getTimeAdded() :string{
        return $this->time_added;
    }
   

    public function jsonSerialize(): mixed {
        return [
            'cart_id' => $this->getCartID(),
            'time_added' => $this->getTimeAdded(),
        ];
    }
}
