<?php

class OrderModel{
    public function __construct(){

    }
    public function submitOrder($data){
        $dbh = include("MVC/models/databaseModels/Database.php");

        $query = "INSERT INTO orders(user_id, is_company, first_name, last_name, street, street_number, postal_code, postal_city, country, nip, company_name, delivery_id, delivery_tracking, payment_method_id, payment_status, order_status, created_date, user_id_created, last_modified_date, user_id_last_modified, status)";
        $query.=" VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $dbh->prepare($query);
        $stmt->execute([
            $data['user_id'],
            $data['is_company'],
            $data['first_name'],
            $data['last_name'],
            $data['street'],
            $data['street_number'],
            $data['postal_code'],
            $data['postal_city'],
            $data['country'],
            $data['nip'],
            $data['company_name'],
            $data['delivery_id'],
            $data['delivery_tracking'],
            $data['payment_method_id'],
            $data['payment_status'],
            $data['order_status'],
            (new DateTime())->format('Y-m-d H:i:s'),
            $data['user_id'],
            (new DateTime())->format('Y-m-d H:i:s'),
            $data['user_id'],
            $data['status']
        ]);
        $stmt = null;
        
        $stmt = ($dbh->query("SELECT id FROM orders WHERE user_id=".$data['user_id']." ORDER BY created_date DESC LIMIT 1"));
        $orderId = $stmt->fetch()['id'];
        foreach($data['products'] as $product){
            $this->submitOrderProduct($orderId, $product['id'], $product['quantity'], $data['user_id']);
        }

        $dbh = null;
        return $orderId;
    }

    private function submitOrderProduct($orderId, $productId, $quantity, $userId){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "INSERT INTO orders_products(order_id, product_id, quantity, created_date, user_id_created, last_modified_date, user_id_last_modified, status)";
        $query.=" VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$orderId, $productId, $quantity, (new DateTime())->format('Y-m-d H:i:s'), $userId, (new DateTime())->format('Y-m-d H:i:s'), $userId, StatusEnum::ACTIVE]);
        $dbh = null;
    }

  
   
}