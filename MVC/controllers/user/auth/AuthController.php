<?php

class AuthController{
    public function __construct(){

    }
    public function RedirectIfLoggedIn(){
        if(isset($_SESSION['user_id'])){
            header("Location:home");
            exit();
        }
    }
}