<?php
include_once("MVC/controllers/admin/products/AdminProductController.php");
include_once("MVC/models/databaseModels/AdminProductModel.php");

class ManageProductStateController extends AdminProductController{
    public function __construct(){

    }

    public function suspendProduct($id){
        $this->RedirectIfAdminNotLoggedIn();
        $adminProductModel = new AdminProductModel();
        $location="../../products".((isset($_COOKIE['admin_product_pageable']))?"?".$_COOKIE['admin_product_pageable']:"");
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
        $location="../../products".((isset($_COOKIE['admin_product_pageable']))?"?".$_COOKIE['admin_product_pageable']:"");
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
        $location="../../products".((isset($_COOKIE['admin_product_pageable']))?"?".$_COOKIE['admin_product_pageable']:"");
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
}