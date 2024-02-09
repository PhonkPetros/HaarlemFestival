<?php
namespace App\Controllers;

class HomeController
{
   

    function __construct()
    {
  
    }

    public function index()
    {
       
        require __DIR__ . '/../views/home/index.php';
    }

    public function about()
    {
        require __DIR__ . '/../views/home/about.php';
    }
}