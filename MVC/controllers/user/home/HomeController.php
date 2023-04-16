<?php

class HomeController{
    public function __construct(){

    }
    public function index(){
        include("MVC/views/home/index.php");
    }
}