<?php
include_once("MVC/controllers/admin/products/AdminProductController.php");
include_once("MVC/models/databaseModels/CategoryModel.php");
include_once("MVC/models/databaseModels/AdminProductModel.php");

class ManageProductsController extends AdminProductController{
    public function __construct(){

    }

    public function displayManageProductsPage($pageable = "page=1&size=10"){
        $this->RedirectIfAdminNotLoggedIn();
     
        setcookie("admin_product_pageable", $pageable, time()+1*60*60, "/");

        if(!isset($_GET['page'])){
            $_GET['page']=1;
        }
        if(!isset($_GET['size'])){
            $_GET['size']=10;
        }

        $page = intval($_GET['page']);
        $pageSize = intval($_GET['size']);
        $name = null;    
        $categoryId =null;
        $description =null;
        $priceFrom = null;
        $priceTo = null;
        $quantityFrom = null;
        $quantityTo = null;
        $productSize = null;
        $colour = null;
        $viewCountFrom = null;
        $viewCountTo = null;
        $status = null;
        $createdDate = null;
        $orderBy = null;
        $order = null;
        $id=null;
        $gender=null;
     
        if(isset($_GET['name'])){
            $name = $_GET['name'];
        }
        if(isset($_GET['description'])){
            $description = $_GET['description'];
        }
        if(isset($_GET['categoryId'])){
            $categoryId = intval($_GET['categoryId']);
        }
        if(isset($_GET['priceFrom'])){
            $priceFrom = $_GET['priceFrom'];
        }
        if(isset($_GET['priceTo'])){
            $priceTo = $_GET['priceTo'];
        }
        if(isset($_GET['quantityFrom'])){
            $quantityFrom = intval($_GET['quantityFrom']);
        }
        if(isset($_GET['quantityTo'])){
            $quantityTo = intval($_GET['quantityTo']);
        }
        if(isset($_GET['productSize'])){
            $productSize = intval($_GET['productSize']);
        }
        if(isset($_GET['colour'])){
            $colour = intval($_GET['colour']);
        }
        if(isset($_GET['gender'])){
            $gender = intval($_GET['gender']);
        }
        if(isset($_GET['viewCountFrom'])){
            $viewCountFrom = intval($_GET['viewCountFrom']);
        }
        if(isset($_GET['viewCountTo'])){
            $viewCountTo = intval($_GET['viewCountTo']);
        }
        if(isset($_GET['status'])){
            $status = intval($_GET['status']);
        }
        if(isset($_GET['createdDate'])){
            $createdDate = $_GET['createdDate'];
        }
        if(isset($_GET['id'])){
            $id = intval($_GET['id']);
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
            "name",
            "categoryId",
            "description",
            "price",
            "quantity",
            "size",
            "colour",
            "view_count",
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

        $adminProductModel = new AdminProductModel();
        //wyszukiwanie ze specyfikacją
        if($status==999)$status=null; //czyli ze wszystkie statusy  
        if($categoryId==999)$categoryId=null; //czyli wszystkie kategorie
        if($productSize==999)$productSize=null;
        if($colour==999)$colour=null;
        if($gender==999)$gender=null;
        $result = $adminProductModel->searchProducts($firstResult,
                                                    $pageSize,
                                                    $id,
                                                    $name,
                                                    $categoryId,
                                                    $description,
                                                    $priceFrom, $priceTo,
                                                    $quantityFrom, $quantityTo,
                                                    $productSize,
                                                    $colour,
                                                    $gender,
                                                    $viewCountFrom, $viewCountTo,
                                                    $status,
                                                    $createdDate,
                                                    $orderBy,
                                                    $order);
        $resultCount = ($adminProductModel->searchProductsCount($id,
                                                                $name,
                                                                $categoryId,
                                                                $description,
                                                                $priceFrom, $priceTo,
                                                                $quantityFrom, $quantityTo,
                                                                $productSize,
                                                                $colour,
                                                                $gender,
                                                                $viewCountFrom, $viewCountTo,
                                                                $status,
                                                                $createdDate))[0];

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getCategories();

        include("MVC/views/admin/manageProductsPage.php");
    }
}