<?php
include_once("MVC/models/databaseModels/OrderModel.php");
include_once("MVC/controllers/order/OrderController.php");

class DisplayOrderPageController extends OrderController{
    public function __construct(){

    }

    public function displayOrderPage($id){
        $orderModel = new OrderModel();
        $order = $orderModel->getOrder($id);
        if($order===false || !isset($order['order']) || !isset($order['products'])){
            echo "Taki zasób nie istnieje";
            http_response_code(404);
            exit();
        }

        $koszt = $orderModel->getOrderValue($id);
        echo $koszt;

        echo "<pre>";
        print_r($order);
        echo "</pre>";

        if($order['order']['payment_status']==PaymentStatusEnum::UNPAID){
            if($order['order']['payment_method_id'] != 2){
                echo "<a href=\"../order/payment/".$order['order']['id']."\">Zapłać za zamówienie</a>";
            }//czyli za pobraniem
        }
        include("MVC/views/order/OrderView.php");
    }
}