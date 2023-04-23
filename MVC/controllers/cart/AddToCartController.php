<?php
include("MVC/models/databaseModels/ProductModel.php");

class AddToCartController{
    public function __construct(){

    }

    public function add($id){
        if(!$this->checkIfProductExists($id)){
            $_SESSION['message'] = "Produkt o takim id nie istnieje";
            header("Location:../../products/$id");
            exit();
        }
        if(isset($_COOKIE['cart'])){
            try{
                $koszyk = unserialize($_COOKIE['cart']);
                $lastId = end($koszyk)['id'];
                array_push($koszyk, ["id" => $lastId+1, "productId" => $id, "quantity" => 1]);
                setcookie("cart", serialize($koszyk), time()+30*24*60*60*60, "/");

                $_SESSION['message'] = "Dodano produkt do koszyka";
            }
            catch(Exception $e){
                setcookie("cart", false, time()-1);
                $_SESSION['message'] = "Nie udało się dodać produktu do koszyka";
            }
            finally{

                header("Location:../../products/$id");
                exit();
            }
        }
        else{
            $produkt = ["id" => 0 ,"productId" => $id, "quantity" => 1];
            $koszyk = [$produkt];
            setcookie("cart", serialize($koszyk), time()+30*24*60*60*60, "/");
            $_SESSION['message'] =  "Dodano produkt do koszyka";
            header("Location:../../products/$id");
        }
    }

    private function checkIfProductExists($productId){
        $productModel = new ProductModel();
        if($productModel->productExistsAndIsAvailable($productId)){
            return true;
        }
        else{
            return false;
        }
    }
}