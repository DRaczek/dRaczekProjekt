<?php
include_once("MVC/models/databaseModels/UserModel.php");

class UserController{
    public function __construct(){

    }

    public function RedirectIfNotLoggedIn(){
        if(!isset($_SESSION['user_id'])){
            header("Location:home");
            exit();
        }
    }
}