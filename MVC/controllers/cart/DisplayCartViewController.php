<?php
include_once("MVC/models/databaseModels/ProductModel.php");

class DisplayCartViewController{
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
        // uniewaznienie referencji
        echo "<pre>";
        print_r($koszyk);
        echo "</pre>";
        include("MVC/views/cart/cartView.php");
    }
}