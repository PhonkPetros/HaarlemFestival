<?php

namespace services;
use repositories\registerrepository;

class registerservice 
{
    private $registerrepository;
    public function __construct(registerrepository $registerrepository) { $this->registerrepository = $registerrepository; }


}