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

    public function getOrder($id, $userId){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT * FROM orders WHERE id = ? AND status = ? AND user_id = ? ";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$id, StatusEnum::ACTIVE, $userId]);
        
        $result = array();
        $result['order'] = $stmt->fetch();
        if(!is_array($result['order'])){
            $dbh=null;
            return false;
            exit();
        }

        $query = "SELECT products.id as id, image_path_1, name, orders_products.quantity as quantity, price FROM orders_products INNER JOIN products ON products.id=orders_products.product_id WHERE order_id = ? AND orders_products.status = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$id, StatusEnum::ACTIVE]);
        
        $result['products'] = $stmt->fetchAll();

        $dbh = null;
        return $result;
    }

    public function getOrderValue($id){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT SUM(p.price*op.quantity) FROM orders_products op INNER JOIN products p ON p.id=op.product_id WHERE order_id = ? AND op.status = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$id, StatusEnum::ACTIVE]);

        $sum = $stmt->fetch()[0];

        $query = "SELECT price FROM delivery_methods WHERE delivery_methods.id = (SELECT delivery_id FROM orders o WHERE o.id = ? AND o.status = ? LIMIT 1)";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$id, StatusEnum::ACTIVE]);
    
        $sum += $stmt->fetch()[0];

        $dbh = null;
        return $sum;
    }

    public function orderExistsAndIsAvailable($id, $userId){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT COUNT(id) as liczba FROM orders WHERE id = ? AND status = ? AND user_id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$id, StatusEnum::ACTIVE, $userId]);;
        $result = $stmt->fetch()['liczba'];
        $dbh = null;
        if($result==1){
            return true;
        }
        return false;
    }

    public function getOrderPaymentStatus($id){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT payment_status FROM orders WHERE id = ? AND status = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$id, StatusEnum::ACTIVE]);;
        $result = $stmt->fetch()['payment_status'];
        $dbh = null;
        return $result;
    }

    public function simulateOrderPayment($id){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "UPDATE orders SET payment_status = ? WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([PaymentStatusEnum::PAID, $id]);
        $dbh = null;
    }

    
}