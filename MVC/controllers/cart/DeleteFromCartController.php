<?php
include_once("MVC/controllers/cart/CartController.php");

class DeleteFromCartController extends CartController{
    public function __construct(){
        
    }

    public function delete($id){
        if(isset($_COOKIE['cart'])){
            $koszyk = unserialize($_COOKIE['cart']);
            echo $id;
            
            echo "<pre>";
            print_r($koszyk);
            echo "</pre>";
            $koszyk = array_filter($koszyk,function($item) use ($id){
                return $item['id'] != $id;
            });
            echo "<pre>";
            print_r($koszyk);
            echo "</pre>";
            setcookie('cart', serialize($koszyk), time()+30*24*60*60, "/");
            $_SESSION['message'] = "Poprawnie usunięto produkt z koszyka!";
            header("Location:../../cart");
            exit();
        }
        
        $_SESSION['message'] = "Koszyk jest pusty!";
        header("Location:../../cart");
        exit();
    }
}