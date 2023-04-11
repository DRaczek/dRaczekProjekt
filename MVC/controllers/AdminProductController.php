<?php
include_once("MVC/services/adminProduct/AddProductService.php");
include_once("MVC/services/adminProduct/EditProductService.php");
include_once("MVC/models/databaseModels/CategoryModel.php");
include_once("MVC/models/databaseModels/AdminProductModel.php");

class AdminProductController{
    public function __construct(){
        
    }
    
    public function RedirectIfAdminNotLoggedIn(){
        if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_is_admin']) || $_SESSION['user_is_admin']===false){
            header("Location:../home");
            exit();
        }
    }

      /**
     * Product Management
     */
    public function displayManageProductsPage($pageable = "page=1&size=10"){
        $this->RedirectIfAdminNotLoggedIn();
     

        setcookie("admin_product_pageable", $pageable, time()+1*60*60, "/");
        if(isset($_POST['submit'])){

            $uri = $_SERVER['REQUEST_URI'];
            if(isset($_POST['name']) && !empty($_POST['name'])){
                $uri.="&name=".$_POST['name'];
            }
            if(isset($_POST['categoryId']) && $_POST['categoryId']==0 || !empty($_POST['categoryId'])){
                $uri.="&categoryId=".$_POST['categoryId'];
            }
            if(isset($_POST['description']) && !empty($_POST['description'])){
                $uri.="&description=".$_POST['description'];
            }
            if(isset($_POST['priceFrom']) && $_POST['priceFrom']==0 || !empty($_POST['priceFrom'])){
                $uri.="&priceFrom=".$_POST['priceFrom'];
            }
            if(isset($_POST['priceTo']) && $_POST['priceTo']==0 || !empty($_POST['priceTo'])){
                $uri.="&priceTo=".$_POST['priceTo'];
            }
            if(isset($_POST['quantityFrom']) && $_POST['quantityFrom']==0 || !empty($_POST['quantityFrom'])){
                $uri.="&quantityFrom=".$_POST['quantityFrom'];
            }
            if(isset($_POST['quantityTo']) && $_POST['quantityTo']==0 || !empty($_POST['quantityTo'])){
                $uri.="&quantityTo=".$_POST['quantityTo'];
            }
            if(isset($_POST['productSize']) && $_POST['productSize']==0 || !empty($_POST['productSize'])){
                $uri.="&productSize=".$_POST['productSize'];
            }
            if(isset($_POST['colour']) && $_POST['colour']==0 || !empty($_POST['colour'])){
                $uri.="&colour=".$_POST['colour'];
            }
            if(isset($_POST['viewCountFrom']) && $_POST['viewCountFrom']==0 || !empty($_POST['viewCountFrom'])){
                $uri.="&viewCountFrom=".$_POST['viewCountFrom'];
            }
            if(isset($_POST['viewCountTo']) && $_POST['viewCountTo']==0 || !empty($_POST['viewCountTo'])){
                $uri.="&viewCountTo=".$_POST['viewCountTo'];
            }
            // z jakiegos powodu jezeli status=0 to empty() zwraca true
            if(isset($_POST['status']) && $_POST['status']==0 || !empty($_POST['status'])){
                $uri.="&status=".$_POST['status'];
            }
            if(isset($_POST['createdDate']) && !empty($_POST['created_date'])){
                $uri.="&createdDate=".$_POST['created_date'];
            }
            if(isset($_POST['id']) && !empty($_POST['id'])){
                $uri.="&id=".$_POST['id'];
            }
            if(isset($_POST['orderBy']) && !empty($_POST['orderBy'])){
                $uri.="&orderBy=".$_POST['orderBy'];
            }
            if(isset($_POST['order']) && !empty($_POST['order'])){
                $uri.="&order=".$_POST['order'];
            }
            header("Location:$uri");
            exit();
        }

        //Pobiera dane z URL
        parse_str($pageable, $params);

        $page = intval($params['page']);
        $pageSize = intval($params['size']);
        $name= null;
        $categoryId=null;
        $description=null;
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
     
        if(isset($params['name'])){
            $name = $params['name'];
        }
        if(isset($params['description'])){
            $description = $params['description'];
        }
        if(isset($params['categoryId'])){
            $categoryId = intval($params['categoryId']);
        }
        if(isset($params['priceFrom'])){
            $priceFrom = $params['priceFrom'];
        }
        if(isset($params['priceTo'])){
            $priceTo = $params['priceTo'];
        }
        if(isset($params['quantityFrom'])){
            $quantityFrom = intval($params['quantityFrom']);
        }
        if(isset($params['quantityTo'])){
            $quantityTo = intval($params['quantityTo']);
        }
        if(isset($params['productSize'])){
            $productSize = intval($params['productSize']);
        }
        if(isset($params['colour'])){
            $colour = intval($params['colour']);
        }
        if(isset($params['viewCountFrom'])){
            $viewCountFrom = intval($params['viewCountFrom']);
        }
        if(isset($params['viewCountTo'])){
            $viewCountTo = intval($params['viewCountTo']);
        }
        if(isset($params['status'])){
            $status = intval($params['status']);
        }
        if(isset($params['createdDate'])){
            $createdDate = $params['createdDate'];
        }
        if(isset($params['id'])){
            $id = intval($params['id']);
        }
        if(isset($params['orderBy'])){
            $orderBy = $params['orderBy'];
        }
        if(isset($params['order'])){
            $order = $params['order'];
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
        $result = $adminProductModel->searchProducts(   $firstResult,
                                                        $pageSize,
                                                        $id,
                                                        $name,
                                                        $categoryId,
                                                        $description,
                                                        $priceFrom, $priceTo,
                                                        $quantityFrom, $quantityTo,
                                                        $productSize,
                                                        $colour,
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
                                                                $viewCountFrom, $viewCountTo,
                                                                $status,
                                                                $createdDate))[0];

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getCategories();

        include("MVC/views/admin/manageProductsPage.php");
    }

    public function displayAddProductPage(){
        $this->RedirectIfAdminNotLoggedIn();
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getCategories();
        include("MVC/views/admin/addProductPage.php");
    }

    public function addProduct(){
        $this->RedirectIfAdminNotLoggedIn();
        $addProductService = new AddProductService();
        $addProductService->add();
    }

    public function suspendProduct($id){
        $this->RedirectIfAdminNotLoggedIn();
        $adminProductModel = new AdminProductModel();
        $location="../../products".((isset($_COOKIE['admin_product_pageable']))?"/".$_COOKIE['admin_product_pageable']:"");
        try{
            $adminProductModel->suspendProduct($id, $_SESSION['user_id']);
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się zaktualizować danych produktu";
            header("Location:$location");
            exit();
        }
        $_SESSION['message'] = "Poprawnie zmieniono status produktu";
        header("Location:$location");
        
    }

    public function activateProduct($id){
        $this->RedirectIfAdminNotLoggedIn();
        $adminProductModel = new AdminProductModel();
        $location="../../products".((isset($_COOKIE['admin_product_pageable']))?"/".$_COOKIE['admin_product_pageable']:"");
        try{
            $adminProductModel->activateProduct($id, $_SESSION['user_id']);
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się zaktualizować danych produktu";
            header("Location:$location");
            exit();
        }
        $_SESSION['message'] = "Poprawnie zmieniono status produktu";
        header("Location:$location");
        
    }

    public function deleteProduct($id){
        $this->RedirectIfAdminNotLoggedIn();
        $adminProductModel = new AdminProductModel();
        $location="../../products".((isset($_COOKIE['admin_product_pageable']))?"/".$_COOKIE['admin_product_pageable']:"");
        try{
            $paths = $adminProductModel->deleteProduct($id);
            foreach($paths as $path){
                if(file_exists($path)){
                    unlink($path);
                }
            }
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się usunąć produktu";
            header("Location:$location");
            exit();
        }
        $_SESSION['message'] = "Poprawnie usunięto produkt";
        header("Location:$location");
    }

    public function displayEditProductPage($id){
        $this->RedirectIfAdminNotLoggedIn();
        $adminProductModel = new AdminProductModel();
        $product = $adminProductModel->getProduct($id);
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getCategories();
        include("MVC/views/admin/editProductPage.php");
    }

    public function editProduct(){
        $this->RedirectIfAdminNotLoggedIn();
        $editProductService = new EditProductService();
        $editProductService->edit();
    }
}