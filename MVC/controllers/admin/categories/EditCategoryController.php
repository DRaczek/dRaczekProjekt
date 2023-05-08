<?php
include_once("MVC/models/databaseModels/AdminCategoryModel.php");
include_once("MVC/models/databaseModels/CategoryModel.php");
include_once("MVC/models/validationHelpers/FileUploadValidationHelper.php");
include_once("MVC/controllers/admin/categories/AdminCategoryController.php");

class EditCategoryController extends AdminCategoryController{
    public function __construct(){

    }

    public function displayEditCategoryPage($id){
        $this->RedirectIfAdminNotLoggedIn();
        $data = array();
        $categoryModel = new CategoryModel();
        $headerData = array(
            "categories"=>$categoryModel->getCategories()
        );
        $data['id'] = $id;
        $data['header']=$this->loadView("MVC/views/common/header", $headerData, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="/dRaczekProjekt/css/header.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/footer.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/basicLayout.css">';
        $this->loadView("MVC/views/admin/editCategoryPage", $data, false);
    }

    public function editCategory(){
        $this->RedirectIfAdminNotLoggedIn();
        if(!isset($_FILES['image'])
        || !isset($_POST['submit'])
        || !isset($_POST['name'])
        || !isset($_POST['id'])){
            $_SESSION['message'] = "Nie wszystkie pola zostały przesłane.";
            header("Location:../edit/form/$id");
            exit();
        }
        $id = intval($_POST['id']);
        $adminCategoryModel = new AdminCategoryModel();
        if($adminCategoryModel->isCategoryNameTaken($_POST['name'], $id)){
            $_SESSION['message'] = "Kategoria o podanej nazwie już istnieje";
            header("Location:../edit/form/$id");
            exit();
        }

        $fileValidationHelper = new FileUploadValidationHelper();
        try{
            $targetFile = $fileValidationHelper->validateImage($_FILES['image'], "img/uploads/categories/");
        }
        catch(Exception $e){
            $_SESSION['message'] = $e->getMessage();
            header("Location:../edit/form/$id");
            exit();
        }

        if(!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)){
            $_SESSION['message'] = "Nie udało się zapisać pliku.";
            header("Location:../edit/form/$id");
            exit();
        }
       
        try{
            $oldImg = $adminCategoryModel->editCategory($_POST['name'], $targetFile, $_SESSION['user_id'], $id);
            if(file_exists($oldImg)){
                unlink($oldImg);
            }
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się dodać wpisu do bazy danych.";
        }
        $_SESSION['message'] = "Poprawnie zmieniono kategorię.";
        header("Location:../edit/form/$id");
    }

}