<?php

class AdminProductModel{
    public function __construct(){

    }

    public function isProductNameTaken($name, $id=null){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT COUNT(*) FROM products WHERE LOWER(name) LIKE ?";
        if($id!=null && !empty($id)){
            $query.=" AND id != ? ";
        }
        $stmt = $dbh->prepare($query);
        $name = "%$name%";
        $name = mb_strtolower($name);
        $params = array($name);
        if($id!=null && !empty($id)){
            array_push($params, $id);
        }
        $stmt->execute($params);
        $count = ($stmt->fetch())[0];
        $dbh = null;
        if($count>0){
            return true;
        }
        else{
            return false;
        }
    }

    public function createProduct(  $name,
                                    $category_id,
                                    $image_path_1,
                                    $image_path_2=null,
                                    $image_path_3=null,
                                    $description,
                                    $price,
                                    $quantity,
                                    $size,
                                    $colour,
                                    $user_id){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "INSERT INTO `products` (`name`, `category_id`, `image_path_1`, `image_path_2`, `image_path_3`, `description`, `price`, `quantity`, `size`, `colour`, `view_count`, `last_modified_date`, `user_id_last_modified`, `created_date`, `user_id_created`, `status`) ";
        $query .= "VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $dbh->prepare($query);
        $stmt->execute([
            $name,
            $category_id,
            $image_path_1,
            $image_path_2,
            $image_path_3,
            $description,
            $price,
            $quantity,
            $size,
            $colour,
            0,
            (new DateTime())->format('Y-m-d H:i:s'),
            $user_id,
            (new DateTime())->format('Y-m-d H:i:s'),
            $user_id,
            (int)StatusEnum::ACTIVE]);
        $dbh = null;
    }

    public function searchProducts( $firstResultIdx,
                                    $pageSIze,
                                    $id=null,
                                    $name=null,
                                    $category_id=null,
                                    $description=null,
                                    $price_from=null, $price_to=null,
                                    $quantity_from=null, $quantity_to=null,
                                    $size=null,
                                    $colour=null,
                                    $viewCount_from=null, $viewCount_to=null,
                                    $status=null,
                                    $createdDate=null,
                                    $orderBy=null,
                                    $order=null){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT products.id, products.name, category_id, categories.name as category_name, image_path_1, image_path_2, image_path_3, description, price, quantity, size, colour, view_count, products.status, products.created_date FROM products INNER JOIN categories ON categories.id=products.category_id WHERE 1=1";

        if($id===0 || !empty($id)){
            $query.=" AND products.id = :productId ";
        }
        if(!empty($name)){
            $query.=" AND LOWER(products.name) LIKE(:name) ";
        }
        if($category_id===0 || !empty($category_id)){
            $query.=" AND `category_id` = :categoryId ";
        }
        if(!empty($description)){
            $description = strtolower($description);
            $query.=" AND LOWER(description) LIKE(:description) ";
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
        if(!empty($quantity_from) && !empty($quantity_to)){
            $query.=" AND `quantity` BETWEEN :quantity_from AND :quantity_to ";
        }
        else if(!empty($quantity_from)){
            $query.=" AND `quantity` > :quantity_from ";
        }
        else if(!empty($quantity_to)){
            $query.=" AND `quantity` < :quantity_to ";
        }
        if($size===0 || !empty($size)){
            $query.=" AND `size` = :size ";
        }
        if($colour===0 || !empty($colour)){
            $query.=" AND `colour` = :colour ";
        }
        if(!empty($viewCount_from) && !empty($viewCount_to)){
            $query.=" AND `view_count` BETWEEN :viewCount_from AND :viewCount_to ";
        }
        else if(!empty($viewCount_from)){
            $query.=" AND `view_count` > :viewCount_from ";
        }
        else if(!empty($viewCount_to)){
            $query.=" AND `view_count` < :viewCount_to ";
        }
        if($status===0 || !empty($status)){
            $query.=" AND products.status LIKE(:status) ";
        }
        if(!empty($createdDate)){
            $query.=" AND products.created_date LIKE(:createdDate) ";
        }
        if(!empty($orderBy) && !empty($order)){
            $query.=" ORDER BY $orderBy $order ";
        }

        $query.=" LIMIT :firstResult, :pageSize";

        $stmt = $dbh->prepare($query);  

        $stmt->bindParam(':firstResult', $firstResultIdx, PDO::PARAM_INT);
        $stmt->bindParam(':pageSize', $pageSIze, PDO::PARAM_INT);

        if($id===0 || !empty($id)){
            $stmt->bindParam(':productId', $id, PDO::PARAM_INT);
        }
        if(!empty($name)){
            $name = "%$name%";
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        }
        if($category_id===0 || !empty($category_id)){
            $stmt->bindParam(':categoryId', $category_id, PDO::PARAM_INT);
        }
        if(!empty($description)){
            $description = "%$description%";
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        }
        if(!empty($price_from)){
            $stmt->bindParam(':price_from', $price_from, PDO::PARAM_INT);
        }
        if(!empty($price_to)){
            $stmt->bindParam(':price_to', $price_to, PDO::PARAM_INT);
        }
        if(!empty($quantity_from)){
            $stmt->bindParam(':quantity_from', $quantity_from, PDO::PARAM_INT);
        }
        if(!empty($quantity_to)){
            $stmt->bindParam(':quantity_to', $quantity_to, PDO::PARAM_INT);
        }
        if($size===0 || !empty($size)){
            $stmt->bindParam(':size', $size, PDO::PARAM_INT);
        }
        if($colour===0 || !empty($colour)){
            $stmt->bindParam(':colour', $colour, PDO::PARAM_INT);
        }
        if(!empty($viewCount_from)){
            $stmt->bindParam(':viewCount_from', $viewCount_from, PDO::PARAM_INT);
        }
        if(!empty($viewCount_to)){
            $stmt->bindParam(':viewCount_to', $viewCount_to, PDO::PARAM_INT);
        }
        if($status===0 || !empty($status)){
            $status = "%$status%";
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        }
        if(!empty($createdDate)){
            $createdDate = "%$createdDate%";
            $stmt->bindParam(':createdDate', $createdDate, PDO::PARAM_STR);
        }
        $stmt->execute();
        $dbh = null;
        return $stmt->fetchAll();
    }

    public function searchProductsCount($id=null,
                                        $name=null,
                                        $category_id=null,
                                        $description=null,
                                        $price_from=null, $price_to=null,
                                        $quantity_from=null, $quantity_to=null,
                                        $size=null,
                                        $colour=null,
                                        $viewCount_from=null, $viewCount_to=null,
                                        $status=null,
                                        $createdDate=null){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT Count(*) FROM products WHERE 1=1";
        if($id===0 || !empty($id)){
            $query.=" AND `id` = :productId ";
        }
        if(!empty($name)){
            $query.=" AND LOWER(name) LIKE(:name) ";
        }
        if(!empty($category_id)){
            $query.=" AND `category_id` = :categoryId ";
        }
        if(!empty($description)){
            $description = strtolower($description);
            $query.=" AND LOWER(description) LIKE(:description) ";
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
        if(!empty($quantity_from) && !empty($quantity_to)){
            $query.=" AND `quantity` BETWEEN :quantity_from AND :quantity_to ";
        }
        else if(!empty($quantity_from)){
            $query.=" AND `quantity` > :quantity_from ";
        }
        else if(!empty($quantity_to)){
            $query.=" AND `quantity` < :quantity_to ";
        }
        if(!empty($size)){
            $query.=" AND `size` = :size ";
        }
        if(!empty($colour)){
            $query.=" AND `colour` = :colour ";
        }
        if(!empty($viewCount_from) && !empty($viewCount_to)){
            $query.=" AND `view_count` BETWEEN :viewCount_from AND :viewCount_to ";
        }
        else if(!empty($viewCount_from)){
            $query.=" AND `view_count` > :viewCount_from ";
        }
        else if(!empty($viewCount_to)){
            $query.=" AND `view_count` < :viewCount_to ";
        }
        if($status==0 || !empty($status)){
            $query.=" AND `status` LIKE(:status) ";
        }
        if(!empty($createdDate)){
            $query.=" AND `created_date` LIKE(:createdDate) ";
        }

        $stmt = $dbh->prepare($query);

        if($id===0 || !empty($id)){
            $stmt->bindParam(':productId', $id, PDO::PARAM_INT);
        }
        if(!empty($name)){
            $name = "%$name%";
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        }
        if(!empty($category_id)){
            $stmt->bindParam(':categoryId', $category_id, PDO::PARAM_INT);
        }
        if(!empty($description)){
            $description = "%$description%";
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        }
        if(!empty($price_from)){
            $stmt->bindParam(':price_from', $price_from, PDO::PARAM_INT);
        }
        if(!empty($price_to)){
            $stmt->bindParam(':price_to', $price_to, PDO::PARAM_INT);
        }
        if(!empty($quantity_from)){
            $stmt->bindParam(':quantity_from', $quantity_from, PDO::PARAM_INT);
        }
        if(!empty($quantity_to)){
            $stmt->bindParam(':quantity_to', $quantity_to, PDO::PARAM_INT);
        }
        if(!empty($size)){
            $stmt->bindParam(':size', $size, PDO::PARAM_INT);
        }
        if(!empty($colour)){
            $stmt->bindParam(':colour', $colour, PDO::PARAM_INT);
        }
        if(!empty($viewCount_from)){
            $stmt->bindParam(':viewCount_from', $viewCount_from, PDO::PARAM_INT);
        }
        if(!empty($viewCount_to)){
            $stmt->bindParam(':viewCount_to', $viewCount_to, PDO::PARAM_INT);
        }
        if($status==0 || !empty($status)){
            $status = "%$status%";
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        }
        if(!empty($createdDate)){
            $createdDate = "%$createdDate%";
            $stmt->bindParam(':createdDate', $createdDate, PDO::PARAM_STR);
        }
        
        $stmt->execute();
        $dbh = null;
        return $stmt->fetch();
    }

    public function suspendProduct($productId, $userIdModified){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "UPDATE products SET status = ?, last_modified_date = ?, user_id_last_modified = ?  WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([StatusEnum::SUSPENDED, (new DateTime())->format('Y-m-d H:i:s'), $userIdModified, $productId]);
        $dbh = null;
    }

    public function activateProduct($productId, $userIdModified){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "UPDATE products SET status = ?, last_modified_date = ?, user_id_last_modified = ?  WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([StatusEnum::ACTIVE, (new DateTime())->format('Y-m-d H:i:s'), $userIdModified, $productId]);
        $dbh = null;
    }

    public function deleteProduct($productId){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT image_path_1, image_path_2, image_path_3 FROM products WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$productId]);
        $imagePaths = $stmt->fetch()[0];
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$productId]);
        $dbh = null;
        return $imagePaths;
    }

    public function getProduct($id){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT id, name, category_id, description, price, quantity, size, colour FROM products WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        $dbh = null;
        return $result;
    }

    public function editProduct($id
                                ,$name,
                                $category_id,
                                $image_path_1,
                                $image_path_2=null,
                                $image_path_3=null,
                                $description,
                                $price,
                                $quantity,
                                $size,
                                $colour,
                                $user_id){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "UPDATE `products` SET name = ?, category_id = ?, image_path_1 = ?, image_path_2 = ?, image_path_3 = ?, description = ?, price = ?, quantity = ?, size = ?, colour = ?, last_modified_date = ?, user_id_last_modified = ? WHERE id = ? ";
        $stmt = $dbh->prepare($query);
        $stmt->execute([
            $name,
            $category_id,
            $image_path_1,
            $image_path_2,
            $image_path_3,
            $description,
            $price,
            $quantity,
            $size,
            $colour,
            (new DateTime())->format('Y-m-d H:i:s'),
            $user_id,
            $id]);
        $dbh = null;
    }
}