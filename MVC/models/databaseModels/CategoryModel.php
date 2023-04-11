<?php

class CategoryModel{
    public function __construct(){

    }

    public function getCategories(){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT id, name FROM categories WHERE STATUS = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([StatusEnum::ACTIVE]);
        $result = $stmt->fetchAll();
        $dbh = null;
        return $result;
    }

    public function getCategoryId($name){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT id FROM categories WHERE name = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$name]);
        $result = $stmt->fetch();
        $dbh = null;
        return $result;
    }
}