<?php
include_once("MVC/models/databaseModels/UserModel.php");
include_once("MVC/controllers/Controller.php");

class UserController extends Controller{
    public function __construct(){

    }

    public function RedirectIfNotLoggedIn(){
        if(!isset($_SESSION['user_id'])){
            header("Location:home");
            exit();
        }
    }
}