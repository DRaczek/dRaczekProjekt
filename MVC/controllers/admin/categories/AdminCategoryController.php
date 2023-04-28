<?php
include_once("MVC/controllers/Controller.php");
class AdminCategoryController extends Controller{
    public function __construct(){

    }
    
    protected function RedirectIfAdminNotLoggedIn(){
        if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_is_admin']) || $_SESSION['user_is_admin']===false){
            header("Location:../home");
            exit();
        }
    }
}