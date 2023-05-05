<?php
include_once("MVC/models/databaseModels/OrderModel.php");
include_once("MVC/controllers/order/OrderController.php");
include_once("MVC/models/databaseModels/CategoryModel.php");

class OrderPaymentController extends OrderController{
    public function __construct(){

    }
    

    public function displayPaymentPage($id){
        $this->RedirectIfNotLoggedIn();
        $orderModel = new OrderModel();
        if(!$orderModel->orderExistsAndIsAvailable($id, $_SESSION['user_id'])){
            echo "Zasób nie istnieje!";
            http_response_code(404);
            exit();
        }
        if($orderModel->getOrderPaymentStatus($id)!=PaymentStatusEnum::UNPAID){
            echo "Zamówienie zostało już opłacone";
            http_response_code(404);
            exit();
        }

        $data = array();
        $categoryModel = new CategoryModel();
        $headerData = array(
            "categories"=>$categoryModel->getCategories()
        );
        $data['id'] = $id;
        $data['categories'] = $headerData['categories'];
        $data['header']=$this->loadView("MVC/views/common/header", $headerData, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="/dRaczekProjekt/css/header.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/footer.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/basicLayout.css">';
        $this->loadView("MVC/views/order/PaymentPage", $data, false);
    }

    public function pay($id){
        $this->RedirectIfNotLoggedIn();
        $orderModel = new OrderModel();
        if(!$orderModel->orderExistsAndIsAvailable($id, $_SESSION['user_id'])){
            echo "Zasób nie istnieje!";
            http_response_code(404);
            exit();
        }
        if($orderModel->getOrderPaymentStatus($id)!=PaymentStatusEnum::UNPAID){
            echo "Zamówienie zostało już opłacone";
            http_response_code(404);
            exit();
        }
        try{
            $orderModel->simulateOrderPayment($id);
        }
        catch(Exception $e){
            $_SESSION['message'] = "Płatność nie powiodła się!";
        }
        header("Location:../../order/$id");
        exit();
        
    }
}