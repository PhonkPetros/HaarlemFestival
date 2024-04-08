<?php

namespace repositories;

use PDO;
use Exception;
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
            $totalPrice = 0.0;
            $itemHashes = [];
            foreach ($cart as $item) {
                $totalPrice += (int) $item['quantity'] * (float) $item['ticketPrice'];
            }

            $orderId = $this->createOrder($userId, $totalPrice, $paymentStatus);

            foreach ($cart as $item) {
                $ticketId = $item['ticketId'];
                $quantityPurchased = $item['quantity'];

                $itemHash = $this->createOrderItem($orderId, $userId, $item);
                $itemHashes[] = $itemHash;
                $this->updateTicketQuantity($ticketId, $quantityPurchased);
            }
            $this->connection->commit();
            return ['status' => 'success', 'message' => 'Order processed successfully', 'orderId' => $orderId, 'itemHashes' => $itemHashes];
        } catch (Exception $e) {
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
        $date = new DateTime($item['ticketDate']);
        $formattedDate = $date->format('Y-m-d');

        $startTime = new DateTime($item['ticketTime']);
        $formattedStartTime = $startTime->format('H:i:s');
        $endTime = new DateTime($item['ticketEndTime']);
        $formattedEndTime = $endTime->format('H:i:s');

        $itemHash = hash('sha256', $userId . $orderId . microtime());

        $ticketType = '';
        if (isset($item['allAccessPass'])) {
            $ticketType = 'allaccesspass';
        } elseif (isset($item['dayPass'])) {
            $ticketType = 'daypass';
        }

        $language = $item['ticketLanguage'] ?? null;
        $eventId = $item['eventId'] ?? null;
        $location = $item['ticketLocation'] ?? null;
        $ticketType = $ticketType ?: null;
        $artistName = $item['artistName'] ?? null;
        $restaurantName = $item['restaurantName'] ?? null;
        $specialRemarks = $item['specialRemarks'] ?? null;
        $status = 'Active';

        $sql = "INSERT INTO OrderItems (order_id, user_id, quantity, language, date, start_time, end_time, item_hash, event_id, location, ticket_type, artist_name, restaurant_name, special_remarks, status) 
            VALUES (:order_id, :user_id, :quantity, :language, :date, :start_time, :end_time, :item_hash, :event_id, :location, :ticket_type, :artist_name, :restaurant_name, :special_remarks, :status)";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $item['quantity'], PDO::PARAM_INT);
        $stmt->bindParam(':language', $language, PDO::PARAM_STR);
        $stmt->bindParam(':date', $formattedDate);
        $stmt->bindParam(':start_time', $formattedStartTime);
        $stmt->bindParam(':end_time', $formattedEndTime);
        $stmt->bindParam(':item_hash', $itemHash);
        $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
        $stmt->bindParam(':location', $location, PDO::PARAM_STR);
        $stmt->bindParam(':ticket_type', $ticketType, PDO::PARAM_STR);
        $stmt->bindParam(':artist_name', $artistName, PDO::PARAM_STR);
        $stmt->bindParam(':restaurant_name', $restaurantName, PDO::PARAM_STR);
        $stmt->bindParam(':special_remarks', $specialRemarks, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);

        $stmt->execute();
        return $itemHash;
    }


    private function updateTicketQuantity($ticketId, $quantityPurchased)
    {
        try {

            $currentQuantity = $this->getCurrentTicketQuantity($ticketId);


            if ($currentQuantity === false) {
                throw new Exception("Ticket ID $ticketId not found");
            }

            if ($currentQuantity < $quantityPurchased) {
                throw new Exception("Not enough tickets available for Ticket ID $ticketId");
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
        } catch (Exception $e) {
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

    public function getOrderItemsByUser($userID)
    {
        // Added conditions in the WHERE clause to check for status = 'Active' or status IS NULL
        $stmt = $this->connection->prepare("SELECT * FROM OrderItems WHERE user_id = :user_id AND (status = 'Active' OR status IS NULL) ORDER BY date DESC");
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, OrderItem::class);
        $orders = $stmt->fetchAll();
        return $orders;
    }
    

    public function getAllOrders()
    {
        $stmt = $this->connection->prepare("SELECT OrderItems.order_item_id, OrderItems.date, [User].username, OrderItems.restaurant_name, OrderItems.artist_name, [Event].dance_event_id, OrderItems.location, OrderItems.quantity, OrderItems.language,OrderItems.start_time,OrderItems.end_time,OrderItems.ticket_type, OrderItems.special_remarks
        FROM OrderItems
		JOIN [User] ON OrderItems.user_id = [User].user_id
        LEFT JOIN Event ON OrderItems.event_id = Event.event_id");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


}