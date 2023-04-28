<?php
include_once("MVC/models/databaseModels/OrderModel.php");
include_once("MVC/controllers/order/OrderController.php");

class OrderPaymentController extends OrderController{
    public function __construct(){

    }
    
    private function checkIfLoggedInAndRedirect(){
        if(!isset($_SESSION['user_id'])){
            header("/dRaczekProjekt/login");
            exit();
        }
    }

    public function displayPaymentPage($id){
        $this->checkIfLoggedInAndRedirect();
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
        include("MVC/views/order/PaymentPage.php");
    }

    public function pay($id){
        $this->checkIfLoggedInAndRedirect();
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