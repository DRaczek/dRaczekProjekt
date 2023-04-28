<?php
include_once("MVC/controllers/Controller.php");

class AuthController extends Controller{
    public function __construct(){

    }
    public function RedirectIfLoggedIn(){
        if(isset($_SESSION['user_id'])){
            header("Location:home");
            exit();
        }
    }
}