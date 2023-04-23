<?php

class PaymentMethodsModel{
    public function __construct(){

    }
    public function getMethods(){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $stmt = $dbh->prepare("SELECT id, name FROM payment_methods WHERE status = ?");
        $stmt->execute([StatusEnum::ACTIVE]);
        $result = $stmt->fetchAll();
        $dbh = null;
        return $result;
    }

    public function paymentMethodExistsAndIsAvailable($id){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $stmt = $dbh->prepare("SELECT Count(id) FROM payment_methods WHERE id = ? AND status = ?");
        $stmt->execute([$id, StatusEnum::ACTIVE]);
        $result = $stmt->fetch()[0];
        $dbh = null;
        if($result<=0)return false;
        return true;
    }

    public function getPaymentMethodName($id){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $stmt = $dbh->prepare("SELECT name FROM payment_methods WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch()[0];
        $dbh = null;
        return $result;
    }
   
}