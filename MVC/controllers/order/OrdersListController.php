<?php
include_once("MVC/controllers/order/OrderController.php");
include_once("MVC/models/databaseModels/CategoryModel.php");
include_once("MVC/models/databaseModels/OrderModel.php");


class OrdersListController extends OrderController{
    public function __construct(){

    }

    public function display(){
        $this->RedirectIfNotLoggedIn();
        $orderModel = new OrderModel();
        $orders = $orderModel->getOrders($_SESSION['user_id']);

        $data = array();
        $categoryModel = new CategoryModel();
        $headerData = array(
            "categories"=>$categoryModel->getCategories()
        );
        $data['orders'] = $orders;
        $data['categories'] = $headerData['categories'];
        $data['header']=$this->loadView("MVC/views/common/header", $headerData, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="/dRaczekProjekt/css/header.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/footer.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/basicLayout.css">';
        $this->loadView("MVC/views/order/OrderList", $data, false);
    }
}