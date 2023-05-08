<?php
include_once("MVC/models/databaseModels/AdminOrderModel.php");
include_once("MVC/models/databaseModels/CategoryModel.php");
include_once("MVC/models/databaseModels/PaymentMethodsModel.php");
include_once("MVC/models/databaseModels/DeliveryModel.php");
include_once("MVC/controllers/admin/order/AdminOrderController.php");

class ManageOrdersController extends AdminOrderController{
    public function __construct(){

    }

    public function displayManageOrdersPage($pageable="?page=1&size=10"){
        $this->RedirectIfAdminNotLoggedIn();

        if($pageable[0]=='?')$pageable=substr($pageable,1);
        setcookie("admin_order_pageable", $pageable, time()+1*60*60, "/");

        if(!isset($_GET['page'])){
            $_GET['page']=1;
        }
        if(!isset($_GET['size'])){
            $_GET['size']=10;
        }

        $page = intval($_GET['page']);
        if($page<1)$page=1;
        $pageSize = intval($_GET['size']);
        $id=null;
        $user_id=null;
        $is_company=null;
        $first_name=null;
        $last_name=null;
        $street=null;
        $postal_code=null;
        $postal_city=null;
        $country=null;
        $nip=null;
        $company_name=null;
        $delivery_id=null;
        $payment_method_id=null;
        $payment_status=null;
        $order_status=null;
        $created_date=null;
        $status=null;
        $orderBy=null;
        $order=null;
     
        if(isset($_GET['id'])){
            $id = intval($_GET['id']);
        }
        if(isset($_GET['user_id'])){
            $user_id = intval($_GET['user_id']);
        }
        if(isset($_GET['is_company'])){
            $is_company = intval($_GET['is_company']);
        }
        if(isset($_GET['first_name'])){
            $first_name = $_GET['first_name'];
        }
        if(isset($_GET['last_name'])){
            $last_name = $_GET['last_name'];
        }
        if(isset($_GET['street'])){
            $street = $_GET['street'];
        }
        if(isset($_GET['postal_code'])){
            $postal_code = $_GET['postal_code'];
        }
        if(isset($_GET['postal_city'])){
            $postal_city = $_GET['postal_city'];
        }
        if(isset($_GET['country'])){
            $country = $_GET['country'];
        }
        if(isset($_GET['nip'])){
            $nip = $_GET['nip'];
        }
        if(isset($_GET['company_name'])){
            $company_name = $_GET['company_name'];
        }
        if(isset($_GET['delivery_id'])){
            $delivery_id = intval($_GET['delivery_id']);
        }
        if(isset($_GET['payment_method_id'])){
            $payment_method_id = $_GET['payment_method_id'];
        }
        if(isset($_GET['payment_status'])){
            $payment_status = intval($_GET['payment_status']);
        }
        if(isset($_GET['order_status'])){
            $order_status = intval($_GET['order_status']);
        }
        if(isset($_GET['created_date'])){
            $created_date = $_GET['created_date'];
        }
        if(isset($_GET['status'])){
            $status = intval($_GET['status']);
        }
        if(isset($_GET['orderBy'])){
            $orderBy = $_GET['orderBy'];
        }
        if(isset($_GET['order'])){
            $order = $_GET['order'];
        }
        

        //jezeli orderBy niepoprawne to ustawi się domyślne
        $AcceptableOrderByArray = array(
            "created_date",
            "id",
            "user_id",
            "is_company",
            "first_name",
            "last_name",
            "street",
            "postal_code",
            "postal_city",
            "country",
            "nip",
            "company_name",
            "delivery_id",
            "payment_method_id",
            "payment_status",
            "order_status",
            "status"
        );
        if(!in_array($orderBy, $AcceptableOrderByArray)){
            $orderBy = $AcceptableOrderByArray[0];
        }
        $AcceptableOrderArray = array(
            "desc",
            "asc");
        if(!in_array($order, $AcceptableOrderArray)){
            $order = $AcceptableOrderArray[0];
        }
        
        $firstResult = ($page - 1) * $pageSize;

        //wyszukiwanie ze specyfikacją
        if($status==999)$status=null; //czyli ze wszystkie statusy  
        if($is_company==999)$is_company=null;
        if($order_status==999)$order_status=null;
        if($payment_status==999)$payment_status=null;
        if($payment_method_id==999)$payment_method_id=null;
        if($delivery_id==999)$delivery_id=null;

        $adminOrderModel = new AdminOrderModel();
        $result = $adminOrderModel->searchOrders(0,10);

        
        $result = $adminOrderModel->searchOrders($firstResult,
                                                $pageSize,
                                                $id,
                                                $user_id,
                                                $is_company,
                                                $first_name,
                                                $last_name,
                                                $street,
                                                $postal_code,
                                                $postal_city,
                                                $country,
                                                $nip,
                                                $company_name,
                                                $delivery_id,
                                                $payment_method_id,
                                                $payment_status,
                                                $order_status,
                                                $created_date,
                                                $status,
                                                $orderBy,
                                                $order);
        $resultCount = ($adminOrderModel->searchOrdersCount($id,
                                                            $user_id,
                                                            $is_company,
                                                            $first_name,
                                                            $last_name,
                                                            $street,
                                                            $postal_code,
                                                            $postal_city,
                                                            $country,
                                                            $nip,
                                                            $company_name,
                                                            $delivery_id,
                                                            $payment_method_id,
                                                            $payment_status,
                                                            $order_status,
                                                            $created_date,
                                                            $status));                                         
        $data = array();
        $categoryModel = new CategoryModel();
        $headerData = array(
            "categories"=>$categoryModel->getCategories()
        );
        $data['result'] = $result;
        $data['resultCount'] = $resultCount;
        $data['filter'] = [
            "page" => $page,
            "pageSize" => $pageSize,
            "id" => $id,
            "user_id" => $user_id,
            "is_company" => $is_company,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "street" => $street,
            "postal_code" => $postal_code,
            "postal_city" => $postal_city,
            "country" => $country,
            "nip" => $nip,
            "company_name" => $company_name,
            "delivery_id" => $delivery_id,
            "payment_method_id" => $payment_method_id,
            "payment_status" => $payment_status,
            "order_status" => $order_status,
            "created_date" => $created_date,
            "status" => $status,
            "orderBy" => $orderBy,
            "order" => $order
        ];
        $paymentMethodsModel = new PaymentMethodsModel();
        $data['payment_methods'] = $paymentMethodsModel->getMethods();
        $deliveryModel = new DeliveryModel();
        $data['delivery_methods'] = $deliveryModel->getMethods();
        $data['acceptableOrderBy'] = $AcceptableOrderByArray;
        $data['header']=$this->loadView("MVC/views/common/header", $headerData, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="/dRaczekProjekt/css/header.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/footer.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/basicLayout.css">';
        $this->loadView("MVC/views/admin/manageOrdersPage", $data, false);
    }
}