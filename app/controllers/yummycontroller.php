<?php

namespace controllers;

class yummycontroller
{

    public function showYummy()
    {
        require_once __DIR__ . '/../views/yummy/overview.php';
    }

    public function editContent(){
        require_once __DIR__ ."/../views/admin/page-managment/editYummy.php";
    }

}