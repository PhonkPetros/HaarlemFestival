<?php
namespace model;

use services\HistoryService;
require_once __DIR__ . '/../services/historyservice.php';

class History
{
    private $historyService;
    public function __construct()
    {
        $this->historyService = new HistoryService();
    }

    public function getStructuredTickets($eventId)
    {
        $tickets = $this->historyService->getTickets($eventId);
        $eventDetails = $this->historyService->getEventDetails($eventId);
        $location = $eventDetails->getLocation();
        $ticketPrice = $this->historyService->getTicketPrice($eventId);

        $price = $ticketPrice ? $ticketPrice->getPrice() : null;

        $structuredTickets = [];

        foreach ($tickets as $ticket) {
            $ticketId = $ticket->getTicketId();
            $eventId = $ticket->getEventId();
            $language = $ticket->getTicketLanguage();
            $date = $ticket->getTicketDate();
            $time = $ticket->getTicketTime();
            $endTime = $ticket->getTicketEndTime();
            $quantity = $ticket->getQuantity();


            $structuredTickets[$language][$date][$time] = [
                'ticket_id' => $ticketId,
                'event_id' => $eventId,
                'language' => $language,
                'date' => $date,
                'time' => $time,
                'endtime' => $endTime,
                'quantity' => $quantity,
                'price' => $price,
                'location' => $location
            ];
        }

        return $structuredTickets;
    }

    public function getUniqueTimes($structuredTickets)
    {
        $allTimes = [];

        foreach ($structuredTickets as $dates) {
            foreach ($dates as $times) {
                $allTimes = array_merge($allTimes, array_keys($times));
            }
        }

        $uniqueTimes = array_unique($allTimes);
        sort($uniqueTimes);

        return $uniqueTimes;
    }

}
