<?php

namespace services;

use repositories\historyrepository;

require_once __DIR__ . '/../repositories/historyrepository.php';


class HistoryService
{
    private $historyRepo;

    public function __construct()
    {
        $this->historyRepo = new Historyrepository();
    }



}
