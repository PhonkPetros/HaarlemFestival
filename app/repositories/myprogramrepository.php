<?php

namespace repositories;

use PDO;
use PDOException;
use DateTime;

use Repositories\TicketRepo;
use config\dbconfig;
use model\OrderItem;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/ticketRepo.php';
require_once __DIR__ . '/../model/orderItem.php';


class Myprogramrepository extends dbconfig
{
    private $ticketRepo;

    public function __construct()
    {
        parent::__construct();
        $this->ticketRepo = new TicketRepo();
    }


    public function processOrder($userId, $cart, $paymentStatus)
    {
        $this->connection->beginTransaction();
        try {
            $totalPrice = 0.0; // Initialize as float
            foreach ($cart as $item) {
                // Ensure we convert to the correct data type before arithmetic operations
                $totalPrice += (int) $item['quantity'] * (float) $item['ticketPrice'];
            }

            $orderId = $this->createOrder($userId, $totalPrice, $paymentStatus);

            foreach ($cart as $item) {
                $success = $this->updateTicketQuantity((int) $item['ticketId'], (int) $item['quantity']);
                if (!$success) {
                    throw new \Exception("Could not update ticket quantity for ticket ID: {$item['ticketId']}");
                }
                $this->createOrderItem($orderId, $userId, $item);
            }
            $this->connection->commit();
            return ['status' => 'success', 'message' => 'Order processed successfully'];
        } catch (\Exception $e) {
            $this->connection->rollback();
            return ['status' => 'error', 'message' => 'Order processing failed: ' . $e->getMessage()];
        }
    }

    private function createOrder($userId, $totalPrice, $paymentStatus)
    {

        $stmt = $this->connection->prepare("INSERT INTO Orders (user_id, total_price, order_hash, status, created_at) VALUES (:user_id, :total_price, :order_hash, :status, CURRENT_TIMESTAMP)");
        $orderHash = bin2hex(random_bytes(16));
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':total_price', $totalPrice);
        $stmt->bindParam(':order_hash', $orderHash);
        $stmt->bindParam(':status', $paymentStatus);

        $stmt->execute();

        return $this->connection->lastInsertId();
    }

    //modify this to contain event id location ticket type artistname restaurant name and special remarks
    private function createOrderItem($orderId, $userId, $item)
    {
        // Ensure the date format matches the one in your database
        $date = new DateTime($item['ticketDate']);
        $formattedDate = $date->format('Y-m-d');

        // Similarly for time, ensure format matches your database's expectation
        $startTime = new DateTime($item['ticketTime']);
        $formattedStartTime = $startTime->format('H:i:s');
        $endTime = new DateTime($item['ticketEndTime']);
        $formattedEndTime = $endTime->format('H:i:s');

        $itemHash = hash('sha256', $userId . $item['ticketId'] . microtime());

        $stmt = $this->connection->prepare("INSERT INTO OrderItems (order_id, user_id, quantity, language, date, start_time, end_time, item_hash) VALUES (:order_id, :user_id, :quantity, :language, :date, :start_time, :end_time, :item_hash)");

        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $item['quantity'], PDO::PARAM_INT);
        $stmt->bindParam(':language', $item['ticketLanguage'], PDO::PARAM_STR);
        $stmt->bindParam(':date', $formattedDate);
        $stmt->bindParam(':start_time', $formattedStartTime);
        $stmt->bindParam(':end_time', $formattedEndTime);
        $stmt->bindParam(':item_hash', $itemHash);

        $stmt->execute();

    }

    private function updateTicketQuantity($ticketId, $quantityPurchased)
    {
        try {

            $currentQuantity = $this->getCurrentTicketQuantity($ticketId);


            if ($currentQuantity === false) {
                throw new \Exception("Ticket ID $ticketId not found");
            }

            if ($currentQuantity < $quantityPurchased) {
                throw new \Exception("Not enough tickets available for Ticket ID $ticketId");
            }

            $newQuantity = $currentQuantity - $quantityPurchased;


            if ($newQuantity > 0) {

                $stmt = $this->connection->prepare("UPDATE Ticket SET quantity = :new_quantity WHERE ticket_id = :ticket_id");
                $stmt->bindParam(':new_quantity', $newQuantity, PDO::PARAM_INT);
                $stmt->bindParam(':ticket_id', $ticketId, PDO::PARAM_INT);
                $stmt->execute();
            } else {

                $this->deleteTicket($ticketId);
            }

            return true;
        } catch (\Exception $e) {
            error_log("Update ticket quantity failed: " . $e->getMessage());
            return false;
        }
    }


    private function getCurrentTicketQuantity($ticketId)
    {
        $stmt = $this->connection->prepare("SELECT quantity FROM Ticket WHERE ticket_id = :ticket_id");
        $newticketId = (int) $ticketId;
        $stmt->bindParam(':ticket_id', $newticketId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result !== false) {
            return (int) $result['quantity'];
        }
        return false;

    }


    private function deleteTicket($ticketId)
    {
        $stmt = $this->connection->prepare("DELETE FROM Ticket WHERE ticket_id = :ticket_id");
        $stmt->bindParam(':ticket_id', $ticketId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function getOrderItemsByUser($userID){
        $stmt = $this->connection->prepare("SELECT * FROM OrderItems WHERE user_id = :user_id ORDER BY date DESC");
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
        $stmt->execute(); 
        $stmt->setFetchMode(PDO::FETCH_CLASS, OrderItem::class); 
        $orders = $stmt->fetchAll(); 
        return $orders;
    }
    

}
