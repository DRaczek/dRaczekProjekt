<?php

class ProductModel{
    public function __construct(){
        
    }

    public function getProduct($id){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT * FROM products WHERE id = ? AND status = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$id, StatusEnum::ACTIVE]);
        $result = $stmt->fetch();
        $dbh = null;
        return $result;
    }

    public function productExistsAndIsAvailable($id){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT Count(id) FROM products WHERE id = ? AND status = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$id, StatusEnum::ACTIVE]);
        $result = $stmt->fetch()[0];
        $dbh = null;
        if($result>=1){
            return true;
        }
        else{
            return false;
        }
    }

    public function getProductCartData($id){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT name, image_path_1, price, quantity FROM products WHERE id = ? AND status = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$id, StatusEnum::ACTIVE]);
        $result = $stmt->fetch();
        $dbh = null;
        return $result;
    }
}