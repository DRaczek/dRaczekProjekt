<?php
include_once("MVC/models/databaseModels/AdminCategoryModel.php");
include_once("MVC/controllers/admin/categories/AdminCategoryController.php");

class ManageCategoriesController extends AdminCategoryController{
    public function __construct(){

    }

    public function displayManageCategoriesPage($pageable = "page=1&size=10"){
        $this->RedirectIfAdminNotLoggedIn();
        setcookie("category_pageable", $pageable, time()+1*60*60, "/");
        if(!isset($_GET['page'])){
            $_GET['page']=1;
        }
        if(!isset($_GET['size'])){
            $_GET['size']=10;
        }
        $page = intval($_GET['page']);
        $pageSize = intval($_GET['size']);
        $name= null;
        $status = null;
        $createdDate = null;
        $orderBy = null;
        $order = null;
        $id=null;
     
        if(isset($_GET['name'])){
            $name = $_GET['name'];
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

        //jezeli orderBy niepoprawne to ustawi się domyślne
        $AcceptableOrderByArray = array(
            "created_date",
            "id",
            "status",
            "name");
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

        $adminCategoryModel = new AdminCategoryModel();
        //wyszukiwanie ze specyfikacją
        if($status==999)$status=null; //czyli ze wszystkie statusy
        $result = $adminCategoryModel->searchCategories($firstResult, $pageSize, $id, $name, $status, $createdDate, $orderBy, $order);
        $resultCount = ($adminCategoryModel->searchCategoriesCount( $name, $status, $createdDate))[0];
        include("MVC/views/admin/menageCategoriesPage.php");
    }
}