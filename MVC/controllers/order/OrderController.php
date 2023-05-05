<?php
include_once("MVC/controllers/Controller.php");
include_once("MVC/models/databaseModels/ProductModel.php");

class OrderController extends Controller{
    public function __construct(){
        
    }

    public function RedirectIfNotLoggedIn(){
        if(!isset($_SESSION['user_id'])){
            header("Location:/dRaczekProjekt/login");
            exit();
        }
    }

    public function isCartApproved(){
        if(!isset($_COOKIE['cart']) || !is_array(unserialize($_COOKIE['cart']))){
            setcookie("cart", serialize([]), time()+30*24*60*60*60, "/");
        }
        $koszyk = unserialize($_COOKIE['cart']);
        $toDelete = array();
        $approved=true;
        $productModel = new ProductModel();
        foreach($koszyk as &$pozycja){
            if(!isset($pozycja['id'])
            || !isset($pozycja['productId'])
            || !isset($pozycja['quantity'])){
                array_push($toDelete, $pozycja);
                $approved=false;
                continue;
            }
            else{
                if(!$this->productExists($pozycja['productId'], $productModel)){
                    array_push($toDelete, $pozycja);
                    $approved=false;
                }
                else{
                    $res = $this->checkProductQuantity($pozycja['productId'], $pozycja['quantity'],$productModel);
                    if($res !== true){
                        $pozycja['quantity'] = $res;
                        $approved=false;
                    }
                }
            }
        }
        $koszyk = array_diff_assoc($koszyk, $toDelete);
        setcookie("cart", serialize($koszyk), time()+30*24*60*60*60, "/");
        return $approved;
    }

    private function productExists($id, $productModel){
        $productModel = new ProductModel();
        if($productModel->productExistsAndIsAvailable($id)==true){
            return true;
        }
        else{
            return false;
        }
    }
    private function checkProductQuantity($id, $quantity, $productModel){
        $available = $productModel->getProductAvailableQuantity($id);
        if($available>=$quantity){
            return true;
        }
        else{
            return $available;
        }
    }
}