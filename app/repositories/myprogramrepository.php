<?php

namespace repositories;

use PDO;
use PDOException;
use DateTime;

use config\dbconfig;

require_once __DIR__ . '/../config/dbconfig.php';


class Myprogramrepository extends dbconfig
{


    public function processOrder($userInfo, $cart)
    {
        $connection = $this->getConnection();
        $connection->beginTransaction();

        try {
            $totalPrice = 0;
            foreach ($cart as $item) {
                $totalPrice += $item['quantity'] * $item['ticketPrice'];
            }

            $orderId = $this->createOrder($userInfo['user_id'], $totalPrice);

            foreach ($cart as $item) {
                $this->updateTicketQuantity($item['ticketId'], $item['quantity']);
                $this->createOrderItem($orderId, $userInfo['user_id'], $item);
            }
            $connection->commit();
            return ['status' => 'success', 'message' => 'Order processed successfully'];
        } catch (\Exception $e) {
            $connection->rollBack();
            return ['status' => 'error', 'message' => 'Order processing failed: ' . $e->getMessage()];
        }
    }

    private function createOrder($userId, $totalPrice)
    {
        $sql = "INSERT INTO Orders (user_id, total_price, order_hash, status, created_at) VALUES (:user_id, :total_price, :order_hash, 'pending', GETDATE())";
        $stmt = $this->getConnection()->prepare($sql);

        $orderHash = bin2hex(random_bytes(16));

        $stmt->execute([
            ':user_id' => $userId,
            ':total_price' => $totalPrice,
            ':order_hash' => $orderHash
        ]);

        return $this->getConnection()->lastInsertId();
    }

    private function updateTicketQuantity($ticketId, $quantityPurchased)
    {
        $sql = "UPDATE Ticket SET quantity = quantity - :quantity WHERE ticket_id = :ticket_id AND quantity >= :quantity";
        $stmt = $this->getConnection()->prepare($sql);

        $stmt->execute([
            ':quantity' => $quantityPurchased,
            ':ticket_id' => $ticketId
        ]);

        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }

    private function createOrderItem($orderId, $userId, $item)
    {
        $sql = "INSERT INTO OrderItems (order_id, user_id, quantity, language, date, start_time, end_time, item_hash) VALUES (:order_id, :user_id, :quantity, :language, :date, :start_time, :end_time, :item_hash)";
        $stmt = $this->getConnection()->prepare($sql);

        $itemHash = hash('sha256', $userId . $item['ticketId'] . microtime());

        $stmt->execute([
            ':order_id' => $orderId,
            ':user_id' => $userId,
            ':quantity' => $item['quantity'],
            ':language' => $item['language'] ?? null,
            ':date' => $item['date'],
            ':start_time' => $item['startTime'],
            ':end_time' => $item['endTime'],
            ':item_hash' => $itemHash
        ]);
    }


}
