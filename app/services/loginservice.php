<?php

namespace services;
use repositories\Loginrepository;


class loginService
{
    private $loginrepository;
    public function __construct(Loginrepository $loginrepository) { $this->loginrepository = $loginrepository; }


}