<?php
include_once("MVC/controllers/user/userPanel/UserController.php");
include_once("MVC/models/databaseModels/CategoryModel.php");

class UserDetailsController extends UserController{
    public function __construct(){

    }

    public function displayUserDetailsPage(){
        $this->RedirectIfNotLoggedIn();

        $userModel = new UserModel();
        $data = array();
        $categoryModel = new CategoryModel();
        $headerData = array(
            "categories"=>$categoryModel->getCategories()
        );
        $data['user'] = $userModel->getUser($_SESSION['user_id']);
        $data['header']=$this->loadView("MVC/views/common/header", $headerData, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/basicLayout.css">';
        $this->loadView("MVC/views/user/userDetails", $data, false);
    }
}