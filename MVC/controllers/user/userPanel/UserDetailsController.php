<?php
include_once("MVC/controllers/user/userPanel/UserController.php");

class UserDetailsController extends UserController{
    public function __construct(){

    }

    public function displayUserDetailsPage(){
        $this->RedirectIfNotLoggedIn();

        $userModel = new UserModel();
        $user = $userModel->getUser($_SESSION['user_id']);
        include("MVC/views/user/userDetails.php");
    }
}