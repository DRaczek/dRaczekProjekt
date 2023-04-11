<?php

include_once("MVC/services/user/EditUserDetailsService.php");
include_once("MVC/services/user/ChangeUserPasswordService.php");
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

    public function displayUserDetailsPage(){
        $this->RedirectIfNotLoggedIn();

        $userModel = new UserModel();
        $user = $userModel->getUser($_SESSION['user_id']);
        include("MVC/views/user/userDetails.php");
    }

    public function displayEditUserDetailsPage(){
        $this->RedirectIfNotLoggedIn();
        $userModel = new UserModel();
        $user = $userModel->getUser($_SESSION['user_id']);
        include("MVC/views/user/editUserDetails.php");
    }

    public function editUserDetailsPage(){
        $this->RedirectIfNotLoggedIn();
        $editUserDetailsService = new EditUserDetailsService();
        $editUserDetailsService->edit();       
    }

    public function displayChangeUserPasswordPage(){
        $this->RedirectIfNotLoggedIn();
        include("MVC/views/user/changePassword.php");
    }

    public function changeUserPassword(){
        $this->RedirectIfNotLoggedIn();
        $changeUserPasswordService = new ChangeUserPasswordService();
        $changeUserPasswordService->changePassword();
    }
    
}