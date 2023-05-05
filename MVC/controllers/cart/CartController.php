<?php
include_once("MVC/controllers/Controller.php");
include_once("MVC/controllers/Controller.php");

class CartController extends Controller{
    public function __construct(){
        
    }

    public function RedirectIfNotLoggedIn(){
        if(!isset($_SESSION['user_id'])){
            header("Location:/dRaczekProjekt/login");
            exit();
        }
    }
}