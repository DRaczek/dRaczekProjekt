<?php
include_once("MVC/models/databaseModels/ProductModel.php");
include_once("MVC/models/databaseModels/CategoryModel.php");
include_once("MVC/controllers/Controller.php");

class DisplayProductViewController extends Controller{
    public function __construct(){

    }

    public function displayProductView($id){
        $productModel = new ProductModel();
        $product = $productModel->getProduct($id);
        if($product===false){
            $_SESSION['message'] = "Produkt o takim id nie istnieje!";
            header("Location:../home");
            exit();
        }
        $productModel->incProductViewCount($id);    
        $data = array();
        $categoryModel = new CategoryModel();
        $headerData = array(
            "categories"=>$categoryModel->getCategories()
        );
        $data['product'] = $product;
        $data['categories'] = $headerData['categories'];
        $data['header']=$this->loadView("MVC/views/common/header", $headerData, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="/dRaczekProjekt/css/header.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/footer.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/basicLayout.css">';
        $this->loadView("MVC/views/product/productView", $data, false);
    }
}