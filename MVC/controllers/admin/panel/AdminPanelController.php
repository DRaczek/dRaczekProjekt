<?php

class AdminPanelController{
    public function __construct(){
        
    }

    public function RedirectIfAdminNotLoggedIn(){
        if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_is_admin']) || $_SESSION['user_is_admin']===false){
            header("Location:/dRaczekProjekt/home");
            exit();
        }
    }

    public function displayAdminHomePage(){
        $this->RedirectIfAdminNotLoggedIn();
        include("MVC/views/admin/homePage.php");
    }
}