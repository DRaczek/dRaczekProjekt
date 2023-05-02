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

    public function searchProducts($firstResultIdx,
                                    $pageSIze,
                                    $name=null,
                                    $categoryId=null,
                                    $gender=null,
                                    $price_from=null, $price_to=null,
                                    $size=null,
                                    $colour=null,
                                    $orderBy=null,
                                    $order=null){
        $dbh = include("MVC/models/databaseModels/Database.php");
        include("config/predefindedUsers.php");
        $query = "SELECT id, name, image_path_1, price, quantity, size, colour, gender, view_count FROM products WHERE 1=1 ";

        if($categoryId===0 || !empty($categoryId)){
            $query.=" AND `category_id` = :categoryId ";
        }
        if(!empty($name)){
            $query.=" AND LOWER(name) LIKE(:name) ";
        }
        if($gender===0 || !empty($gender)){
            $query.=" AND `gender` = :gender ";
        }
        if(!empty($price_from) && !empty($price_to)){
            $query.=" AND `price` BETWEEN :price_from AND :price_to ";
        }
        else if(!empty($price_from)){
            $query.=" AND `price` > :price_from ";
        }
        else if(!empty($price_to)){
            $query.=" AND `price` < :price_to ";
        }
        if($size===0 || !empty($size)){
            $query.=" AND `size` = :size ";
        }
        if($colour===0 || !empty($colour)){
            $query.=" AND `colour` = :colour ";
        }
        if(!empty($orderBy) && !empty($order)){
            $query.=" ORDER BY $orderBy $order ";
        }

        $query.=" LIMIT :firstResult, :pageSize";

        $stmt = $dbh->prepare($query);  

        $stmt->bindParam(':firstResult', $firstResultIdx, PDO::PARAM_INT);
        $stmt->bindParam(':pageSize', $pageSIze, PDO::PARAM_INT);

        if($categoryId===0 || !empty($categoryId)){
            $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        }
        if(!empty($name)){
            $name = "%$name%";
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        }
        if($gender===0 || !empty($gender)){
            $stmt->bindParam(':gender', $gender, PDO::PARAM_INT);
        }
        if(!empty($price_from)){
            $stmt->bindParam(':price_from', $price_from, PDO::PARAM_INT);
        }
        if(!empty($price_to)){
            $stmt->bindParam(':price_to', $price_to, PDO::PARAM_INT);
        }
        if($size===0 || !empty($size)){
            $stmt->bindParam(':size', $size, PDO::PARAM_INT);
        }
        if($colour===0 || !empty($colour)){
            $stmt->bindParam(':colour', $colour, PDO::PARAM_INT);
        }
        $stmt->execute();
        $dbh = null;
        return $stmt->fetchAll();
    }

    public function searchProductsCount($name=null,
                                        $categoryId=null,
                                        $gender=null,
                                        $price_from=null, $price_to=null,
                                        $size=null,
                                        $colour=null){
        $dbh = include("MVC/models/databaseModels/Database.php");
        include("config/predefindedUsers.php");
        $query = "SELECT Count(id) FROM products WHERE 1=1 ";

        if($categoryId===0 || !empty($categoryId)){
            $query.=" AND `category_id` = :categoryId ";
        }
        if(!empty($name)){
            $query.=" AND LOWER(name) LIKE(:name) ";
        }
        if($gender===0 || !empty($gender)){
            $query.=" AND `gender` = :gender ";
        }
        if(!empty($price_from) && !empty($price_to)){
            $query.=" AND `price` BETWEEN :price_from AND :price_to ";
        }
        else if(!empty($price_from)){
            $query.=" AND `price` > :price_from ";
        }
        else if(!empty($price_to)){
            $query.=" AND `price` < :price_to ";
        }
        if($size===0 || !empty($size)){
            $query.=" AND `size` = :size ";
        }
        if($colour===0 || !empty($colour)){
            $query.=" AND `colour` = :colour ";
        }

        $stmt = $dbh->prepare($query);  

        if($categoryId===0 || !empty($categoryId)){
            $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        }
        if(!empty($name)){
            $name = "%$name%";
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        }
        if($gender===0 || !empty($gender)){
            $stmt->bindParam(':gender', $gender, PDO::PARAM_INT);
        }
        if(!empty($price_from)){
            $stmt->bindParam(':price_from', $price_from, PDO::PARAM_INT);
        }
        if(!empty($price_to)){
            $stmt->bindParam(':price_to', $price_to, PDO::PARAM_INT);
        }
        if($size===0 || !empty($size)){
            $stmt->bindParam(':size', $size, PDO::PARAM_INT);
        }
        if($colour===0 || !empty($colour)){
            $stmt->bindParam(':colour', $colour, PDO::PARAM_INT);
        }
        $stmt->execute();
        $dbh = null;
        return $stmt->fetch()[0];
    }

    public function incProductViewCount($id){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "UPDATE products SET view_count = view_count+1 WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$id]);
        $dbh = null;
    }

}