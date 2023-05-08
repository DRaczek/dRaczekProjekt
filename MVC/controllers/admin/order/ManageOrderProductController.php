<?php
include_once("MVC/controllers/admin/order/AdminOrderController.php");
include_once("MVC/models/databaseModels/CategoryModel.php");
include_once("MVC/models/databaseModels/AdminOrderModel.php");

class ManageOrderProductController extends AdminOrderController{
    public function __construct(){

    }
    public function display($id){
        $this->RedirectIfAdminNotLoggedIn();
        $data = array();

        $adminOrderModel = new AdminOrderModel();
        $data['products'] = $adminOrderModel->getOrderProducts($id);
        if($data['products']==null || $data['products'] == false){
            $_SESSION['message'] = "Zamówienie o podanym id nie istnieje";
            header("Location:../../orders");
            exit();
        }

        $categoryModel = new CategoryModel();
        $headerData = array(
            "categories"=>$categoryModel->getCategories()
        );
        $data['header']=$this->loadView("MVC/views/common/header", $headerData, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="/dRaczekProjekt/css/header.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/footer.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/basicLayout.css">';
        $this->loadView("MVC/views/admin/orderProductsPage", $data, false);
    }
}