<?php
include_once("MVC/controllers/admin/order/AdminOrderController.php");
include_once("MVC/models/databaseModels/CategoryModel.php");
include_once("MVC/models/databaseModels/PaymentMethodsModel.php");
include_once("MVC/models/databaseModels/DeliveryModel.php");
include_once("MVC/models/databaseModels/AdminOrderModel.php");
include_once("MVC/models/validationHelpers/OrderValidationHelper.php");

class EditOrderController extends AdminOrderController{
    public function __construct(){

    }
    public function displayForm($id){
        $this->RedirectIfAdminNotLoggedIn();
        $adminOrderModel = new AdminOrderModel();
        $order = $adminOrderModel->getOrder($id);
        if($order==null || $order==false){
            header("Location:../../../orders");
            exit();
        }
        $data = array();
        $categoryModel = new CategoryModel();
        $headerData = array(
            "categories"=>$categoryModel->getCategories()
        );
        $paymentMethodsModel = new PaymentMethodsModel();
        $data['payment_methods'] = $paymentMethodsModel->getMethods();
        $deliveryModel = new DeliveryModel();
        $data['delivery_methods'] = $deliveryModel->getMethods();
        $data['id'] = $id;
        $data['order'] = $order;
        $data['header']=$this->loadView("MVC/views/common/header", $headerData, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="/dRaczekProjekt/css/header.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/footer.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/basicLayout.css">';
        $this->loadView("MVC/views/admin/editOrderPage", $data, false);
    }

    public function edit(){
        $this->RedirectIfAdminNotLoggedIn();
        try{
            if(!isset($_POST['id'])){
                $_SESSION['message'] = "Nie przesłano pola id zamówienia";
                header("Location:/dRaczekProjekt/admin/manage/orders");
                exit();
            }
            $adminOrderModel = new AdminOrderModel();
            if(!$adminOrderModel->orderExists($_POST['id'])){
                $_SESSION['message'] = "Zamówienie o przesłanym id nie istenieje";
                header("Location:/dRaczekProjekt/admin/manage/orders");
                exit();
            }
            $orderValidationHelper = new OrderValidationHelper();
            $orderValidationHelper->validate(true);
            $adminOrderModel->editOrder(
                $_POST['id'],
                (($_POST['is_company']=="on")?true:false),
                $_POST['first_name'],
                $_POST['last_name'],
                $_POST['street'],
                $_POST['street_number'],
                $_POST['postal_code'],
                $_POST['postal_city'],
                $_POST['country'],
                $_POST['nip'],
                $_POST['company_name'],
                $_POST['delivery_id'],
                $_POST['delivery_tracking'],
                $_POST['payment_method_id'],
                $_POST['payment_status'],
                $_POST['order_status'],
                $_SESSION['user_id']);
            $_SESSION['message'] = "Poprawnie edytowano kategorię<br>";
            header("Location:/dRaczekProjekt/admin/manage/orders/edit/form/".$_POST['id']);
        }
        catch(Exception $e){
            $_SESSION['message'] = $e->getMessage();
            header("Location:/dRaczekProjekt/admin/manage/orders");
            exit();
        }
       
    }
}