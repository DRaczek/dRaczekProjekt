<?php

class AuthController{
    public function __construct(){

    }
    public function displayLoginPage(){
        include("MVC/views/auth/login.php");
    }
    public function displayRegisterPage(){
        include("MVC/views/auth/register.php");
    }
}