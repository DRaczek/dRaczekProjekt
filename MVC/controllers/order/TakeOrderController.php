<?php
include_once("MVC/models/databaseModels/DeliveryModel.php");
include_once("MVC/models/databaseModels/PaymentMethodsModel.php");
include_once("MVC/controllers/order/OrderController.php");

class TakeOrderController extends OrderController{
    public function __construct(){

    }

    public function displayOrderPage(){
        $deliveryModel = new DeliveryModel();
        $deliveryMethods = $deliveryModel->getMethods();
        $paymentMethodsModel = new PaymentMethodsModel();
        $paymentMethods = $paymentMethodsModel->getMethods();
        include("MVC/views/order/OrderPage.php");
    }
}