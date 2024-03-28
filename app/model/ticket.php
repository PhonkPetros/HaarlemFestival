<?php

namespace model;
use services\ticketservice;
use services\Myprogramservice;
require_once __DIR__ . '/../services/ticketservice.php';
require_once __DIR__ . '/../services/myprogramservice.php';

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
    private ?string $endTime = null;
    private $ticketservice;
    private $myprogramservice;

    public function __construct() {
        $this->ticketservice = new ticketservice();
        $this->myprogramservice = new Myprogramservice();
    }

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


    public function getTicketEndTime(): ?string { 
        return $this->endTime;
    }

    public function setTicketEndTime(?string $endTime): void {
        $this->endTime = $endTime;
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
            'endTime' => $this->getTicketEndTime()
        ];
    }
      //structuring ticket data for ticket list view
      public function structureTicketsWithImages()
      {
          $structuredTickets = [];
          foreach ($_SESSION['shopping_cart'] as $ticket) {
              $eventId = $ticket['eventId'];
              if (!array_key_exists($eventId, $structuredTickets)) {
                  $eventDetails = $this->ticketservice->getEventDetails($eventId);
                  $structuredTickets[$eventId] = [
                      'tickets' => [],
                      'image' => $eventDetails['picture'] ?? null,
                      'event_name' => $eventDetails['name'] ?? null,
                      'totalPrice' => 0
                  ];
              }
              $ticketTotalPrice = $ticket['quantity'] * $ticket['ticketPrice'];
              $structuredTickets[$eventId]['totalPrice'] += $ticketTotalPrice;
              $ticket['totalPrice'] = $ticketTotalPrice;
              $structuredTickets[$eventId]['tickets'][] = $ticket;
          }
          return $structuredTickets;
      }

       //getting all the purchased tickets by userID and structuring them 
    function getStructuredPurchasedOrderItemsByUserID()
    {
        $structuredOrderItems = [];
        if (isset ($_SESSION['user']) && isset ($_SESSION['user']['userID'])) {
            $userID = $_SESSION['user']['userID'];
            $purchasedOrderItems = $this->myprogramservice->getOrderItemsByUser($userID);

            foreach ($purchasedOrderItems as $orderitem) {
                $event_details = $this->ticketservice->getEventDetails($orderitem->getEventId());
                $structuredItem = [
                    'order_item_id' => $orderitem->getOrderItemId(),
                    'order_id' => $orderitem->getOrderId(),
                    'user_id' => $orderitem->getUserId(),
                    'quantity' => $orderitem->getQuantity(),
                    'date' => $orderitem->getDate(),
                    'start_time' => $orderitem->getStartTime(),
                    'end_time' => $orderitem->getEndTime(),
                    'item_hash' => $orderitem->getItemHash(),
                    'event_id' => $orderitem->getEventId(),
                    'location' => $orderitem->getLocation(),
                    'event_details' => [
                        'image' => $event_details['picture'] ?? null,
                        'event_name' => $event_details['name'] ?? null,
                    ],

                ];

                // Customize the structured item based on the event ID
                switch ($orderitem->getEventId()) {
                    case EVENT_ID_HISTORY: // History
                        $structuredItem['language'] = $orderitem->getLanguage();
                        break;
                    case EVENT_ID_RESTAURANT: // Yummy
                        $structuredItem['restaurant_name'] = $orderitem->getRestaurantName();
                        $structuredItem['special_remarks'] = $orderitem->getSpecialRemarks();
                        break;
                    case EVENT_ID_DANCE:
                    case EVENT_ID_JAZZ: // Events Dance and Jaz
                        $structuredItem['ticket_type'] = $orderitem->getTicketType();
                        $structuredItem['artist_name'] = $orderitem->getArtistName();
                        break;
                }

                $structuredOrderItems[] = $structuredItem;
            }
            // Filter the structured order items to include only those within the specified date range
            $filteredOrderedItems = array_filter($structuredOrderItems, function ($item) {
                // Convert the item's date to a timestamp for easy comparison
                $itemDateTimestamp = strtotime($item['date']);
                // Define the start and end of the desired date range
                $startDateTimestamp = strtotime("2024-06-26");
                $endDateTimestamp = strtotime("2024-06-30");
                // Include the item if its date is within the range
                return $itemDateTimestamp >= $startDateTimestamp && $itemDateTimestamp <= $endDateTimestamp;
            });

            // Return only the items that passed the filtering
            return $filteredOrderedItems;
        } else {
            return [];
        }
    }
}
