<?php

namespace controllers;

use services\historyService;
use model\Event;

require_once __DIR__ . '/../model/event.php';
require_once __DIR__ . '/../services/historyservice.php';

class Historycontroller
{
    private $historyService;
    private $event;
    public function __construct()
    {
        $this->historyService = new HistoryService();
        $this->event = new Event();
    }

    public function show()
    {
        require_once __DIR__ . '/../views/history/overview.php';
    }

    public function showProveniershof()
    {
        require_once __DIR__ . '/../views/history/proveniershof.php';
    }

    public function showChurch()
    {
        require_once __DIR__ . '/../views/history/churchbravo.php';
    }

    public function editEventDetails()
    {
        require_once __DIR__ . '/../views/admin/manage-event-details/editDetailsHistory.php';
    }
    
}