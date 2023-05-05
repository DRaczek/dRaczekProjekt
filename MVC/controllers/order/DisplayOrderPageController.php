<?php
include_once("MVC/models/databaseModels/OrderModel.php");
include_once("MVC/controllers/order/OrderController.php");
include_once("MVC/models/databaseModels/CategoryModel.php");
include_once("MVC/models/databaseModels/PaymentMethodsModel.php");
include_once("MVC/models/databaseModels/DeliveryModel.php");

class DisplayOrderPageController extends OrderController{
    public function __construct(){

    }

    public function displayOrderPage($id){
        $this->RedirectIfNotLoggedIn();
        $orderModel = new OrderModel();
        $order = $orderModel->getOrder($id, $_SESSION['user_id']);
        if($order===false || !isset($order['order']) || !isset($order['products'])){
            echo "Taki zasób nie istnieje";
            http_response_code(404);
            exit();
        }
        $koszt = $orderModel->getOrderValue($id);
        $paymentMethodsModel = new PaymentMethodsModel();
        $paymentMethodName = $paymentMethodsModel->getPaymentMethodName($order['order']['payment_method_id']);
        $deliveryModel = new DeliveryModel();
        $delivery = $deliveryModel->getPriceAndName($order['order']['delivery_id']);


        $data = array();
        $categoryModel = new CategoryModel();
        $headerData = array(
            "categories"=>$categoryModel->getCategories()
        );
        $data['order'] = $order;
        $data['koszt'] = $koszt;
        $data['delivery'] = $delivery;
        $data['paymentMethodName'] = $paymentMethodName;
        $data['categories'] = $headerData['categories'];
        $data['header']=$this->loadView("MVC/views/common/header", $headerData, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="/dRaczekProjekt/css/header.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/footer.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/basicLayout.css">';
        $this->loadView("MVC/views/order/OrderView", $data, false);
    }
}