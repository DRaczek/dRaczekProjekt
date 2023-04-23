<?php
include("MVC/models/databaseModels/ProductModel.php");

class DisplayProductViewController{
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
        echo "<pre>";
        print_r($product);
        echo "</pre>";
        include("MVC/views/product/productView.php");
    }
}