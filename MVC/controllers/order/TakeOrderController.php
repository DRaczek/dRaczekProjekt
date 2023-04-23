<?php
include_once("MVC/models/databaseModels/DeliveryModel.php");
include_once("MVC/models/databaseModels/PaymentMethodsModel.php");

class TakeOrderController{
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