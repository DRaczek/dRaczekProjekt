<?php
include_once("MVC/models/validationHelpers/OrderValidationHelper.php");
include_once("MVC/models/databaseModels/OrderModel.php");
include_once("MVC/models/databaseModels/ProductModel.php");
include_once("MVC/controllers/order/OrderController.php");

class SubmitOrderController extends OrderController{
    public function __construct(){

    }

    public function submit(){
        $this->RedirectIfNotLoggedIn();
        if(!$this->isCartApproved()){
            $_SESSION['message'] = "Wystąpił błąd związany z zwartością koszyka.";
            header("Location:/dRaczekProjekt/cart");
            exit();
        }
        try{
            $validationHelper = new OrderValidationHelper();
            $validationHelper->validate();
        }
        catch(Exception $e){    
            $_SESSION['message'] = $e->getMessage();
            http_response_code(400);
            header("Location:../order/data");
            exit();
        }

        $produkty = array();
        foreach(unserialize($_COOKIE['cart']) as $item){
            array_push($produkty, ['id'=>$item['productId'], "quantity"=>$item['quantity']]);
        }

        $data = [
            "user_id"=>$_SESSION['user_id'],
            "is_company"=>($_POST['is_company']=="on")?true:false,
            "first_name"=>$_POST['first_name'],
            "last_name"=>$_POST['last_name'],
            "street"=>$_POST['street'],
            "street_number"=>$_POST['street_number'],
            "postal_code"=>$_POST['postal_code'],
            "postal_city"=>$_POST['postal_city'],
            "country"=>$_POST['country'],
            "nip"=>$_POST['nip'],
            "company_name"=>$_POST['company_name'],
            "delivery_id"=>$_POST['delivery_id'],
            "delivery_tracking"=>"Brak danych",
            "payment_method_id"=>$_POST['payment_method_id'],
            "payment_status"=>PaymentStatusEnum::UNPAID,
            "order_status"=>OrderStatusEnum::ACCEPTED,
            "status"=>StatusEnum::ACTIVE,
            "products"=>$produkty
        ];

        $dbh = include("MVC/models/databaseModels/Database.php");
        $dbh->beginTransaction();
        try{
            $orderModel = new OrderModel();
            $result = $orderModel->submitOrder($data);
            $productModel = new ProductModel();
            foreach ($produkty as $produkt) {
                $productModel->updateProductQuantity($produkt['id'], $produkt['quantity']);
            }   
            setcookie("cart", serialize([]), time()+30*24*60*60*60, "/");
            $dbh->commit();
        }
        catch(Exception $e){
            $dbh->rollback();
        }
        $dbh=null;
    
        if($result===false){
            $_SESSION['message']= "Nie udało się złożyć zamówienia. Skontaktuj się z administratorem.";
            header("Location:../cart");
            exit();
        }
        else{
            header("Location:../order/".$result);
        }


    }
}