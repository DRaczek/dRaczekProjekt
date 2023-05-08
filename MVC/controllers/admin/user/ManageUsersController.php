<?php
include_once("MVC/controllers/admin/user/AdminController.php");
include_once("MVC/models/databaseModels/AdminModel.php");
include_once("MVC/models/databaseModels/CategoryModel.php");

class ManageUsersController extends AdminController{
    public function __construct(){
        
    }

    public function displayManageUsersPage($pageable = "page=1&size=10"){
        $this->RedirectIfAdminNotLoggedIn();
        if($pageable[0]=='?')$pageable=substr($pageable,1);
        setcookie("admin_users_pageable", $pageable, time()+1*60*60, "/");
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
        $email= null;
        $firstName = null;
        $lastName = null;
        $status = null;
        $createdDate = null;
        $orderBy=null;
        $order=null;
        if(isset($_GET['email'])){
            $email = $_GET['email'];
        }
        if(isset($_GET['firstName'])){
            $firstName = $_GET['firstName'];
        }
        if(isset($_GET['lastName'])){
            $lastName = $_GET['lastName'];
        }
        if(isset($_GET['status'])){
            $status = intval($_GET['status']);
        }
        if(isset($_GET['createdDate'])){
            $createdDate = $_GET['createdDate'];
        }
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        if(isset($_GET['orderBy'])){
            $orderBy = $_GET['orderBy'];
        }
        if(isset($_GET['order'])){
            $order = $_GET['order'];
        }

        $firstResult = ($page - 1) * $pageSize;

        //jezeli orderBy niepoprawne to ustawi się domyślne
        $AcceptableOrderByArray = array(
            "created_date",
            "id",
            "status",
            "first_name",
            "last_name",
            "email");
        if(!in_array($orderBy, $AcceptableOrderByArray)){
            $orderBy = $AcceptableOrderByArray[0];
        }
        $AcceptableOrderArray = array(
            "desc",
            "asc");
        if(!in_array($order, $AcceptableOrderArray)){
            $order = $AcceptableOrderArray[0];
        }

        $adminModel = new AdminModel();
        //wyszukiwanie ze specyfikacją
        if($status==999)$status=null; //czyli ze wszystkie statusy
        $result = $adminModel->searchUsers($firstResult, $pageSize, $email, $firstName, $lastName, $status, $createdDate, $id, $orderBy, $order);
        $resultCount = ($adminModel->searchUsersCount($email, $firstName, $lastName, $status, $createdDate, $id))[0];

        $data = array();
        $categoryModel = new CategoryModel();
        $headerData = array(
            "categories"=>$categoryModel->getCategories()
        );
        $data['result'] = $result;
        $data['resultCount'] = $resultCount;
        $data['filter'] = [
            "page"=>$page,
            "pageSize"=>$pageSize,
            "id"=>$id,
            "email"=>$email,
            "firstName"=>$firstName,
            "lastName"=>$lastName,
            "status"=>$status,
            "createdDate"=>$createdDate,
            "orderBy"=>$orderBy,
            "order"=>$order
        ];
        $data['header']=$this->loadView("MVC/views/common/header", $headerData, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="/dRaczekProjekt/css/header.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/footer.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/basicLayout.css">';
        $this->loadView("MVC/views/admin/manageUsersPage", $data, false);
    }
}