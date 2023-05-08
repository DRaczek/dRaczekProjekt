<?php

class AdminOrderModel{
    public function __construct(){

    }

    public function searchOrders($firstResultIdx, $pageSIze,
                                $id=null,
                                $user_id=null,
                                $is_company=null,
                                $first_name=null,
                                $last_name=null,
                                $street=null,
                                $postal_code=null,
                                $postal_city=null,
                                $country=null,
                                $nip=null,
                                $company_name=null,
                                $delivery_id=null,
                                $payment_method_id=null,
                                $payment_status=null,
                                $order_status=null,
                                $created_date=null,
                                $status=null,
                                $orderBy=null,
                                $order=null){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT *, (SELECT name FROM delivery_methods ds WHERE ds.id=o.delivery_id) as delivery_name, (SELECT name FROM payment_methods ps WHERE ps.id = o.payment_method_id) as payment_method_name FROM orders o WHERE 1=1 ";

        if($id===0 || !empty($id)){
            $query.=" AND `id` = :id ";
        }
        if($user_id===0 || !empty($user_id)){
            $query.=" AND `user_id` = :user_id ";
        }
        if(!empty($first_name)){
            $query.=" AND `first_name` LIKE(LOWER(:first_name)) ";
        }
        if(!empty($last_name)){
            $query.=" AND `last_name` LIKE(LOWER(:last_name)) ";
        }
        if(!empty($street)){
            $query.=" AND `street` LIKE(LOWER(:street)) ";
        }
        if(!empty($postal_code)){
            $query.=" AND `postal_code` = :postal_code ";
        }
        if(!empty($postal_city)){
            $query.=" AND `postal_city` LIKE(LOWER(:postal_city)) ";
        }
        if(!empty($country)){
            $query.=" AND `country` LIKE(LOWER(:country)) ";
        }
        if(!empty($nip)){
            $query.=" AND `nip` = :nip ";
        }
        if(!empty($company_name)){
            $query.=" AND `company_name` LIKE(LOWER(:company_name)) ";
        }
        if($delivery_id===0 || !empty($delivery_id)){
            $query.=" AND `delivery_id` = :delivery_id ";
        }
        if($payment_method_id===0 || !empty($payment_method_id)){
            $query.=" AND `payment_method_id` = :payment_method_id ";
        }
        if($payment_status===0 || !empty($payment_status)){
            $query.=" AND `payment_status` = :payment_status ";
        }
        if($order_status===0 || !empty($order_status)){
            $query.=" AND `order_status` = :order_status ";
        }
        if($status===0 || !empty($status)){
            $query.=" AND `status` = :status ";
        }
        if(!empty($createdDate)){
            $query.=" AND `created_date` LIKE(:createdDate) ";
        }
        if(!empty($orderBy) && !empty($order)){
            $query.=" ORDER BY $orderBy $order ";
        }


        $query.=" LIMIT :firstResult, :pageSize";

        $stmt = $dbh->prepare($query);      

        $stmt->bindParam(':firstResult', $firstResultIdx, PDO::PARAM_INT);
        $stmt->bindParam(':pageSize', $pageSIze, PDO::PARAM_INT);

        if($id===0 || !empty($id)){
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        }
        if($user_id===0 || !empty($user_id)){
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        }
        if(!empty($first_name)){
            $first_name=strtolower("%$first_name%");
            $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        }
        if(!empty($last_name)){
            $last_name=strtolower("%$last_name%");
            $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        }
        if(!empty($street)){
            $street=strtolower("%$street%");
            $stmt->bindParam(':street', $street, PDO::PARAM_STR);
        }
        if(!empty($postal_code)){
            $stmt->bindParam(':postal_code', $postal_code, PDO::PARAM_STR);
        }
        if(!empty($postal_city)){
            $postal_city=strtolower("%$postal_city%");
            $stmt->bindParam(':postal_city', $postal_city, PDO::PARAM_STR);
        }
        if(!empty($country)){
            $country=strtolower("%$country%");
            $stmt->bindParam(':country', $country, PDO::PARAM_STR);
        }
        if(!empty($nip)){
            $stmt->bindParam(':nip', $nip, PDO::PARAM_STR);
        }
        if(!empty($company_name)){
            $company_name=strtolower("%$company_name%");
            $stmt->bindParam(':company_name', $company_name, PDO::PARAM_STR);
        }
        if($delivery_id===0 || !empty($delivery_id)){
            $stmt->bindParam(':delivery_id', $delivery_id, PDO::PARAM_INT);
        }
        if($payment_method_id===0 || !empty($payment_method_id)){
            $stmt->bindParam(':payment_method_id', $payment_method_id, PDO::PARAM_INT);
        }
        if($payment_status===0 || !empty($payment_status)){
            $stmt->bindParam(':payment_status', $payment_status, PDO::PARAM_INT);
        }
        if($order_status===0 || !empty($order_status)){
            $stmt->bindParam(':order_status', $order_status, PDO::PARAM_INT);
        }
        if($status===0 || !empty($status)){
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

    public function searchOrdersCount($id=null,
                                    $user_id=null,
                                    $is_company=null,
                                    $first_name=null,
                                    $last_name=null,
                                    $street=null,
                                    $postal_code=null,
                                    $postal_city=null,
                                    $country=null,
                                    $nip=null,
                                    $company_name=null,
                                    $delivery_id=null,
                                    $payment_method_id=null,
                                    $payment_status=null,
                                    $order_status=null,
                                    $created_date=null,
                                    $status=null,
                                    $orderBy=null,
                                    $order=null){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT COUNT(id) FROM orders WHERE 1=1 ";

        if($id===0 || !empty($id)){
            $query.=" AND `id` = :id ";
        }
        if($user_id===0 || !empty($user_id)){
            $query.=" AND `user_id` = :user_id ";
        }
        if(!empty($first_name)){
            $query.=" AND `first_name` LIKE(LOWER(:first_name)) ";
        }
        if(!empty($last_name)){
            $query.=" AND `last_name` LIKE(LOWER(:last_name)) ";
        }
        if(!empty($street)){
            $query.=" AND `street` LIKE(LOWER(:street)) ";
        }
        if(!empty($postal_code)){
            $query.=" AND `postal_code` = :postal_code ";
        }
        if(!empty($postal_city)){
            $query.=" AND `postal_city` LIKE(LOWER(:postal_city)) ";
        }
        if(!empty($country)){
            $query.=" AND `country` LIKE(LOWER(:country)) ";
        }
        if(!empty($nip)){
            $query.=" AND `nip` = :nip ";
        }
        if(!empty($company_name)){
            $query.=" AND `company_name` LIKE(LOWER(:company_name)) ";
        }
        if($delivery_id===0 || !empty($delivery_id)){
            $query.=" AND `delivery_id` = :delivery_id ";
        }
        if($payment_method_id===0 || !empty($payment_method_id)){
            $query.=" AND `payment_method_id` = :payment_method_id ";
        }
        if($payment_status===0 || !empty($payment_status)){
            $query.=" AND `payment_status` = :payment_status ";
        }
        if($order_status===0 || !empty($order_status)){
            $query.=" AND `order_status` = :order_status ";
        }
        if($status===0 || !empty($status)){
            $query.=" AND `status` = :status ";
        }
        if(!empty($createdDate)){
            $query.=" AND `created_date` LIKE(:createdDate) ";
        }

        $stmt = $dbh->prepare($query);  

        if($id===0 || !empty($id)){
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        }
        if($user_id===0 || !empty($user_id)){
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        }
        if(!empty($first_name)){
            $first_name=strtolower("%$first_name%");
            $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        }
        if(!empty($last_name)){
            $last_name=strtolower("%$last_name%");
            $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        }
        if(!empty($street)){
            $street=strtolower("%$street%");
            $stmt->bindParam(':street', $street, PDO::PARAM_STR);
        }
        if(!empty($postal_code)){
            $stmt->bindParam(':postal_code', $postal_code, PDO::PARAM_STR);
        }
        if(!empty($postal_city)){
            $postal_city=strtolower("%$postal_city%");
            $stmt->bindParam(':postal_city', $postal_city, PDO::PARAM_STR);
        }
        if(!empty($country)){
            $country=strtolower("%$country%");
            $stmt->bindParam(':country', $country, PDO::PARAM_STR);
        }
        if(!empty($nip)){
            $stmt->bindParam(':nip', $nip, PDO::PARAM_STR);
        }
        if(!empty($company_name)){
            $company_name=strtolower("%$company_name%");
            $stmt->bindParam(':company_name', $company_name, PDO::PARAM_STR);
        }
        if($delivery_id===0 || !empty($delivery_id)){
            $stmt->bindParam(':delivery_id', $delivery_id, PDO::PARAM_INT);
        }
        if($payment_method_id===0 || !empty($payment_method_id)){
            $stmt->bindParam(':payment_method_id', $payment_method_id, PDO::PARAM_INT);
        }
        if($payment_status===0 || !empty($payment_status)){
            $stmt->bindParam(':payment_status', $payment_status, PDO::PARAM_INT);
        }
        if($order_status===0 || !empty($order_status)){
            $stmt->bindParam(':order_status', $order_status, PDO::PARAM_INT);
        }
        if($status===0 || !empty($status)){
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        }
        if(!empty($createdDate)){
            $createdDate = "%$createdDate%";
            $stmt->bindParam(':createdDate', $createdDate, PDO::PARAM_STR);
        }
        $stmt->execute();
        $dbh = null;
        return $stmt->fetch()[0];
    }

    public function suspendOrder($orderId, $userIdModified){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "UPDATE orders SET status = ?, last_modified_date = ?, user_id_last_modified = ?  WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([StatusEnum::SUSPENDED, (new DateTime())->format('Y-m-d H:i:s'), $userIdModified, $orderId]);
        $dbh = null;
    }
    public function activateOrder($orderId, $userIdModified){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "UPDATE orders SET status = ?, last_modified_date = ?, user_id_last_modified = ?  WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([StatusEnum::ACTIVE, (new DateTime())->format('Y-m-d H:i:s'), $userIdModified, $orderId]);
        $dbh = null;
    }
    public function deleteOrder($orderId){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "DELETE FROM orders WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$orderId]);
        $dbh = null;
    }
    public function getOrder($orderId){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT * FROM orders WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$orderId]);
        $dbh = null;
        return $stmt->fetch();
    }
    public function orderExists($orderId){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT COUNT(id) FROM orders WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$orderId]);
        $dbh = null;
        if($stmt->fetch()[0]>0){
            return true;
        }
        return false;
    }
    public function editOrder(  $id, 
                                $is_company,
                                $first_name,
                                $last_name,
                                $street,
                                $street_number,
                                $postal_code,
                                $postal_city,
                                $country,
                                $nip,
                                $company_name,
                                $delivery_id,
                                $delivery_tracking,
                                $payment_method_id,
                                $payment_status,
                                $order_status,
                                $user_id){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "UPDATE orders SET is_company = ?, first_name = ?, last_name = ?, street = ?, street_number = ?, postal_code = ?, postal_city = ?, country = ?, ";
        $query.= "nip = ?, company_name = ?, delivery_id = ?, delivery_tracking = ?, payment_method_id = ?, payment_status = ?, order_status = ?, user_id_last_modified = ?, last_modified_date = ? WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([
            $is_company,
            $first_name,
            $last_name,
            $street,
            $street_number,
            $postal_code,
            $postal_city,
            $country,
            $nip,
            $company_name,
            $delivery_id,
            $delivery_tracking,
            $payment_method_id,
            $payment_status,
            $order_status,
            $user_id,
            (new DateTime())->format('Y-m-d H:i:s'),
            $id]);
        $dbh = null;
    }

    public function getOrderProducts($id){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT products.id as id, image_path_1, name, orders_products.quantity as quantity, price FROM orders_products INNER JOIN products ON products.id=orders_products.product_id WHERE order_id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$id]);
        $result = $stmt->fetchAll();
        $dbh = null;
        return $result;
    }

}