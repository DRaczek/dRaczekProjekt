<?php
include_once("MVC/controllers/user/auth/AuthController.php");

class LogoutUserController extends AuthController{
    public function __construct(){

    }
    
    public function logout(){
        include("logout.php");
    }
}