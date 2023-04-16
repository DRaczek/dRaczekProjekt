<?php
include_once("MVC/models/databaseModels/AdminCategoryModel.php");
include_once("MVC/controllers/admin/categories/AdminCategoryController.php");
include_once("MVC/models/validationHelpers/DeleteCategoryValidationHelper.php");

class ManageCategoryStateController extends AdminCategoryController{
    public function __construct(){

    }

    public function suspendCategory($id){
        $this->RedirectIfAdminNotLoggedIn();
        $adminCategoryModel = new AdminCategoryModel();
        $location="../../categories".((isset($_COOKIE['category_pageable']))?"?".$_COOKIE['category_pageable']:"");
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
        $location="../../categories".((isset($_COOKIE['category_pageable']))?"?".$_COOKIE['category_pageable']:"");
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
        $location="../../categories".((isset($_COOKIE['category_pageable']))?"?".$_COOKIE['category_pageable']:"");
        try{
            $deleteCategoryValidationHelper = new DeleteCategoryValidationHelper();
            $deleteCategoryValidationHelper->validate($id);
        }
        catch(Exception $e){
            $_SESSION['message'] = $e->getMessage();
            header("Location:$location");
            exit();
        }
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
}