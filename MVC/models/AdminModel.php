<?php

class AdminModel{
    public function __construct(){

    }
    public function loginAdmin($email){
        $dbh = include("MVC/models/Database.php");
        $query = "SELECT id, first_name, email, password FROM users WHERE email = ? AND status = ? AND users.id IN (SELECT user_id FROM users_admin)";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$email, (int)StatusEnum::ACTIVE]);
        $dbh = null;
        return $stmt->fetch();
    }

    /**
     * User management.
     */

    public function searchUsersCount($email=null, $firstName=null, $lastName=null, $status=null, $createdDate=null){
        $dbh = include("MVC/models/Database.php");
        include("config/predefindedUsers.php");
        $query = "SELECT Count(*) FROM users WHERE id != :id";
        if(!empty($email)){
            $query.=" AND `email` LIKE(:email) ";
        }
        if(!empty($firstName)){
            $query.=" AND `first_name` LIKE(:firstName) ";
        }
        if(!empty($lastName)){
            $query.=" AND `last_name` LIKE(:lastName) ";
        }
        if(!empty($status)){
            $query.=" AND `status` LIKE(:status) ";
        }
        if(!empty($createdDate)){
            $query.=" AND `created_date` LIKE(:createdDate) ";
        }

        $stmt = $dbh->prepare($query);

        $stmt->bindParam(':id', $System_user_id, PDO::PARAM_INT);
        if(!empty($email)){
            $email = "%$email%";
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        }
        if(!empty($firstName)){
            $firstName = "%$firstName%";
            $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        }
        if(!empty($lastName)){
            $lastName = "%$lastName%";
            $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        }
        if(!empty($status)){
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

    public function searchUsers($firstResultIdx, $pageSIze, $email=null, $firstName=null, $lastName=null, $status=null, $createdDate=null){
        $dbh = include("MVC/models/Database.php");
        include("config/predefindedUsers.php");
        $query = "SELECT id, email, first_name, last_name, status, created_date FROM users WHERE `id`!=:id";

        if(!empty($email)){
            $query.=" AND `email` LIKE(:email) ";
        }
        if(!empty($firstName)){
            $query.=" AND `first_name` LIKE(:firstName) ";
        }
        if(!empty($lastName)){
            $query.=" AND `last_name` LIKE(:lastName) ";
        }
        if(!empty($status)){
            $query.=" AND `status` LIKE(:status) ";
        }
        if(!empty($createdDate)){
            $query.=" AND `created_date` LIKE(:createdDate) ";
        }

        $query.=" LIMIT :firstResult, :pageSize";

        $stmt = $dbh->prepare($query);  

        $stmt->bindParam(':id', $System_user_id, PDO::PARAM_INT);
        $stmt->bindParam(':firstResult', $firstResultIdx, PDO::PARAM_INT);
        $stmt->bindParam(':pageSize', $pageSIze, PDO::PARAM_INT);

        if(!empty($email)){
            $email = "%$email%";
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        }
        if(!empty($firstName)){
            $firstName = "%$firstName%";
            $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        }
        if(!empty($lastName)){
            $lastName = "%$lastName%";
            $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        }
        if(!empty($status)){
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

    public function suspendUser($userId, $userIdModified){
        $dbh = include("MVC/models/Database.php");
        $query = "UPDATE users SET status = ?, last_modified_date = ?, user_id_last_modified = ?  WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([StatusEnum::SUSPENDED, (new DateTime())->format('Y-m-d H:i:s'), $userIdModified, $userId]);
        $dbh = null;
    }

    public function activateUser($userId, $userIdModified){
        $dbh = include("MVC/models/Database.php");
        $query = "UPDATE users SET status = ?, last_modified_date = ?, user_id_last_modified = ?  WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([StatusEnum::ACTIVE, (new DateTime())->format('Y-m-d H:i:s'), $userIdModified, $userId]);
        $dbh = null;
    }

    /**
     * Category management.
     */

     public function isCategoryNameTaken($name, $id=null){
        $dbh = include("MVC/models/Database.php");
        $query = "SELECT COUNT(*) FROM categories WHERE LOWER(name) LIKE ?";
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

    public function createCategory($name, $file, $user_id){
        $dbh = include("MVC/models/Database.php");
        $query = "INSERT INTO categories(name, image_path, created_date, user_id_created, last_modified_date, user_id_last_modified, status) ";
        $query .= "VALUES(?, ?, ?, ?, ?, ?, ?)";
        $stmt = $dbh->prepare($query);
        $stmt->execute([
            $name,
            $file,
            (new DateTime())->format('Y-m-d H:i:s'),
            $user_id,
            (new DateTime())->format('Y-m-d H:i:s'),
            $user_id,
            (int)StatusEnum::ACTIVE]);
        $dbh = null;
    }

    public function searchCategories($firstResultIdx, $pageSIze, $id=null, $name=null, $status=null, $createdDate=null, $orderBy=null, $order=null){
        $dbh = include("MVC/models/Database.php");
        include("config/predefindedUsers.php");
        $query = "SELECT id, name, image_path, status, created_date FROM categories WHERE `id`!=:id";

        if($id===0 || !empty($id)){
            $query.=" AND `id` = :categoryId ";
        }
        if(!empty($name)){
            $query.=" AND `name` LIKE(:name) ";
        }
        if($status==0 || !empty($status)){
            $query.=" AND `status` LIKE(:status) ";
        }
        if(!empty($createdDate)){
            $query.=" AND `created_date` LIKE(:createdDate) ";
        }
        if(!empty($orderBy) && !empty($order)){
            $query.=" ORDER BY $orderBy $order ";
        }

        $query.=" LIMIT :firstResult, :pageSize";

        $stmt = $dbh->prepare($query);  

        $stmt->bindParam(':id', $System_user_id, PDO::PARAM_INT);
        $stmt->bindParam(':firstResult', $firstResultIdx, PDO::PARAM_INT);
        $stmt->bindParam(':pageSize', $pageSIze, PDO::PARAM_INT);

        if($id===0 || !empty($id)){
            $stmt->bindParam(':categoryId', $id, PDO::PARAM_INT);
        }
        if(!empty($name)){
            $name = "%$name%";
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
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
        return $stmt->fetchAll();
    }

    public function searchCategoriesCount($name=null, $status=null, $createdDate=null){
        $dbh = include("MVC/models/Database.php");
        include("config/predefindedUsers.php");
        $query = "SELECT Count(*) FROM categories WHERE id != :id";
        if(!empty($name)){
            $query.=" AND `name` LIKE(:name) ";
        }
        if(!empty($status)){
            $query.=" AND `status` LIKE(:status) ";
        }
        if(!empty($createdDate)){
            $query.=" AND `created_date` LIKE(:createdDate) ";
        }

        $stmt = $dbh->prepare($query);

        $stmt->bindParam(':id', $System_user_id, PDO::PARAM_INT);
        if(!empty($name)){
            $name = "%$name%";
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        }
        if(!empty($status)){
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

    public function suspendCategory($categoryId, $userIdModified){
        $dbh = include("MVC/models/Database.php");
        $query = "UPDATE categories SET status = ?, last_modified_date = ?, user_id_last_modified = ?  WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([StatusEnum::SUSPENDED, (new DateTime())->format('Y-m-d H:i:s'), $userIdModified, $categoryId]);
        $dbh = null;
    }

    public function activateCategory($categoryId, $userIdModified){
        $dbh = include("MVC/models/Database.php");
        $query = "UPDATE categories SET status = ?, last_modified_date = ?, user_id_last_modified = ?  WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([StatusEnum::ACTIVE, (new DateTime())->format('Y-m-d H:i:s'), $userIdModified, $categoryId]);
        $dbh = null;
    }

    public function deleteCategory($categoryId){
        $dbh = include("MVC/models/Database.php");
        $query = "SELECT image_path FROM categories WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$categoryId]);
        $imagePath = $stmt->fetch()[0];
        $query = "DELETE FROM categories WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$categoryId]);
        $dbh = null;
        return $imagePath;
    }

    public function editCategory($name, $file, $user_id, $categoryId){
        $dbh = include("MVC/models/Database.php");
        $query = "SELECT image_path FROM categories WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$categoryId]);
        $path = $stmt->fetch()[0];
        $query = "UPDATE categories SET name = ?, image_path = ?, last_modified_date = ?, user_id_last_modified = ? WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([
            $name,
            $file,
            (new DateTime())->format('Y-m-d H:i:s'),
            $user_id,
            $categoryId]);
        $dbh = null;
        return $path;
    }

}