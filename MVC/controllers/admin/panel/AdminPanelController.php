<?php
include_once("MVC/controllers/Controller.php");
include_once("MVC/models/databaseModels/CategoryModel.php");

class AdminPanelController extends Controller{
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
        $data = array();
        $categoryModel = new CategoryModel();
        $headerData = array(
            "categories"=>$categoryModel->getCategories()
        );
        $data['header']=$this->loadView("MVC/views/common/header", $headerData, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="/dRaczekProjekt/css/header.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/footer.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/basicLayout.css">';
        $this->loadView("MVC/views/admin/homePage", $data, false);
    }
}