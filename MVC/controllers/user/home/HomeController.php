<?php
include_once("MVC/controllers/Controller.php");
include_once("MVC/models/databaseModels/CategoryModel.php");
include_once("MVC/models/databaseModels/ProductModel.php");

class HomeController extends Controller{
    public function __construct(){

    }
    public function index(){
        $data = array();
        $categoryModel = new CategoryModel();
        $headerData = array(
            "categories"=>$categoryModel->getCategories()
        );
        $productModel = new ProductModel();
        $data['newest'] = $productModel->getNewest();
        $data['header']=$this->loadView("MVC/views/common/header", $headerData, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/basicLayout.css">';
        $this->loadView("MVC/views/home/index", $data, false);
    }
}