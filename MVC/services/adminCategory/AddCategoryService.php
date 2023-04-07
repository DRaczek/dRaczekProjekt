<?php
include_once("MVC/models/databaseModels/AdminCategoryModel.php");
include_once("MVC/models/validationHelpers/FileUploadValidationHelper.php");

class AddCategoryService{
    public function __construct(){

    }

    public function addCategory(){
        if(!isset($_FILES['image'])
        || !isset($_POST['submit'])
        || !isset($_POST['name'])){
            $_SESSION['message'] = "Nie wszystkie pola zostały przesłane.";
            header("Location:../add");
            exit();
        }
        $adminCategoryModel = new AdminCategoryModel();
        if($adminCategoryModel->isCategoryNameTaken($_POST['name'])){
            $_SESSION['message'] = "Kategoria o podanej nazwie już istnieje";
            header("Location:../add");
            exit();
        }

        $fileValidationHelper = new FileUploadValidationHelper();
        try{
            $targetFile = $fileValidationHelper->validateImage($_FILES['image'], "img/uploads/categories/");
        }
        catch(Exception $e){
            $_SESSION['message'] = $e->getMessage();
            header("Location:../add");
            exit();
        }
        if(!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)){
            $_SESSION['message'] = "Nie udało się zapisać pliku.";
            header("Location:../add");
            exit();
        }
       
        try{
            $adminCategoryModel->createCategory($_POST['name'], $targetFile, $_SESSION['user_id']);
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się dodać wpisu do bazy danych.";
        }
        $_SESSION['message'] = "Poprawnie dodano kategorię.";
        header("Location:../add");
    }
}