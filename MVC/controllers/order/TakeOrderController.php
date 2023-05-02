<?php
include_once("MVC/models/databaseModels/DeliveryModel.php");
include_once("MVC/models/databaseModels/PaymentMethodsModel.php");
include_once("MVC/controllers/order/OrderController.php");
include_once("MVC/models/databaseModels/CategoryModel.php");

class TakeOrderController extends OrderController{
    public function __construct(){

    }

    public function displayOrderPage(){
        $deliveryModel = new DeliveryModel();
        $deliveryMethods = $deliveryModel->getMethods();
        $paymentMethodsModel = new PaymentMethodsModel();
        $paymentMethods = $paymentMethodsModel->getMethods();

        $data = array();
        $categoryModel = new CategoryModel();
        $headerData = array(
            "categories"=>$categoryModel->getCategories()
        );
        $data['deliveryMethods'] = $deliveryMethods;
        $data['paymentMethods'] = $paymentMethods;
        $data['categories'] = $headerData['categories'];
        $data['header']=$this->loadView("MVC/views/common/header", $headerData, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="/dRaczekProjekt/css/header.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/footer.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/basicLayout.css">';
        $this->loadView("MVC/views/order/OrderPage", $data, false);
    }
}