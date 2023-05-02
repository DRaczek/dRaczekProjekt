<?php
include_once("MVC/models/databaseModels/ProductModel.php");
include_once("MVC/controllers/cart/CartController.php");
include_once("MVC/models/databaseModels/CategoryModel.php");

class DisplayCartViewController extends CartController{
    public function __construct(){

    }
    public function displayCartView(){
        $koszyk = null;
        if(isset($_COOKIE['cart'])){
            $koszyk=unserialize($_COOKIE['cart']);
        }
        $productModel = new ProductModel();
        $summary = 0;
        foreach($koszyk as &$product){
            $data = $productModel->getProductCartData($product['productId']);
            $product['name'] = $data['name'];
            $product['image_path'] = $data['image_path_1'];
            $product['price'] = $data['price'];
            $product['product_quantity'] = $data['quantity'];
            $summary+=$product['price']* $product['quantity'];
        }
        unset($product);

        $data = array();
        $categoryModel = new CategoryModel();
        $headerData = array(
            "categories"=>$categoryModel->getCategories()
        );
        $data['summary'] = $summary;
        $data['cart'] = $koszyk;
        $data['categories'] = $headerData['categories'];
        $data['header']=$this->loadView("MVC/views/common/header", $headerData, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="/dRaczekProjekt/css/header.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/footer.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/basicLayout.css">';
        $this->loadView("MVC/views/cart/cartView", $data, false);
    }
}