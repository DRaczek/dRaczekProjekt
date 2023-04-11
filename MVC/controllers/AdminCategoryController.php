<?php
include_once("MVC/services/adminCategory/AddCategoryService.php");
include_once("MVC/services/adminCategory/EditCategoryService.php");
include_once("MVC/models/databaseModels/AdminCategoryModel.php");

class AdminCategoryController{
    public function __construct(){

    }
    public function RedirectIfAdminNotLoggedIn(){
        if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_is_admin']) || $_SESSION['user_is_admin']===false){
            header("Location:../home");
            exit();
        }
    }

    /**
     * Category management.
     */
    public function displayManageCategoriesPage($pageable = "page=1&size=10"){
        $this->RedirectIfAdminNotLoggedIn();
        // pobiera z $_POST i tworzy URL rozpoznawalne przez Router
        setcookie("category_pageable", $pageable, time()+1*60*60, "/");
        if(isset($_POST['name']) 
        || isset($_POST['status'])
        || isset($_POST['created_date'])){

            $uri = $_SERVER['REQUEST_URI'];
            if(!empty($_POST['name'])){
                $uri.="&name=".$_POST['name'];
            }
            // z jakiegos powodu jezeli status=0 to empty() zwraca true
            if($_POST['status']==0 || !empty($_POST['status'])){
                $uri.="&status=".$_POST['status'];
            }
            if(!empty($_POST['created_date'])){
                $uri.="&createdDate=".$_POST['created_date'];
            }
            if(!empty($_POST['id'])){
                $uri.="&id=".$_POST['id'];
            }
            if(!empty($_POST['orderBy'])){
                $uri.="&orderBy=".$_POST['orderBy'];
            }
            if(!empty($_POST['order'])){
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
        $status = null;
        $createdDate = null;
        $orderBy = null;
        $order = null;
        $id=null;
     
        if(isset($params['name'])){
            $name = $params['name'];
        }
        if(isset($params['status'])){
            $status = intval($params['status']);
        }
        if(isset($params['createdDate'])){
            $createdDate = $params['createdDate'];
        }
        if(isset($params['id'])){
            $id = $params['id'];
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

    public function displayAddCategoryPage(){
        $this->RedirectIfAdminNotLoggedIn();
        include("MVC/views/admin/addCategoryPage.php");
    }

    public function addCategory(){
        $this->RedirectIfAdminNotLoggedIn();
        $addCategoryService = new AddCategoryService();
        $addCategoryService->addCategory();
    }

    public function suspendCategory($id){
        $this->RedirectIfAdminNotLoggedIn();
        $adminCategoryModel = new AdminCategoryModel();
        $location="../../categories".((isset($_COOKIE['category_pageable']))?"/".$_COOKIE['category_pageable']:"");
        try{
            $adminCategoryModel->suspendCategory($id, $_SESSION['user_id']);
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się zaktualizować danych kategorii";
            header("Location:$location");
            exit();
        }
        $_SESSION['message'] = "Poprawnie zmieniono status kategorii";
        header("Location:$location");
        
    }

    public function activateCategory($id){
        $this->RedirectIfAdminNotLoggedIn();
        $adminCategoryModel = new AdminCategoryModel();
        $location="../../categories".((isset($_COOKIE['category_pageable']))?"/".$_COOKIE['category_pageable']:"");
        try{
            $adminCategoryModel->activateCategory($id, $_SESSION['user_id']);
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się zaktualizować danych kategorii";
            header("Location:$location");
            exit();
        }
        $_SESSION['message'] = "Poprawnie zmieniono status kategorii";
        header("Location:$location");
    }

    public function deleteCategory($id){
        $this->RedirectIfAdminNotLoggedIn();
        $adminCategoryModel = new AdminCategoryModel();
        $location="../../categories".((isset($_COOKIE['category_pageable']))?"/".$_COOKIE['category_pageable']:"");
        try{
            $path = $adminCategoryModel->deleteCategory($id);
            if(file_exists($path)){
                unlink($path);
            }
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się usunąć kategorii";
            header("Location:$location");
            exit();
        }
        $_SESSION['message'] = "Poprawnie usunięto kategorię";
        header("Location:$location");
    }

    public function displayEditCategoryPage($id){
        include("MVC/views/admin/editCategoryPage.php");
    }

    public function editCategory(){
        $this->RedirectIfAdminNotLoggedIn();
        $editCategoryService = new EditCategoryService();
        $editCategoryService->edit();
    }

}