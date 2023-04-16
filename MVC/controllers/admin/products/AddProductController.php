<?php
include_once("MVC/controllers/admin/products/AdminProductController.php");
include_once("MVC/models/databaseModels/CategoryModel.php");
include_once("MVC/models/validationHelpers/ProductValidationHelper.php");
include_once("MVC/models/databaseModels/AdminProductModel.php");

class AddProductController extends AdminProductController{
    public function __construct(){

    }

    public function displayAddProductPage(){
        $this->RedirectIfAdminNotLoggedIn();
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getCategories();
        include("MVC/views/admin/addProductPage.php");
    }

    public function addProduct(){
        $this->RedirectIfAdminNotLoggedIn();
        //walidacja
        try{
            $validationHelper = new ProductValidationHelper();
            $targetFiles = $validationHelper->validate(false);
            
        }
        catch(Exception $e){
            $_SESSION['message'] = $e->getMessage();
            header("Location:../add");
            exit();
        }

        //zapis zdjęć na serwerze
        $added = array();
        foreach($targetFiles as $targetFile){
            $res = move_uploaded_file($targetFile['tmp_name'], $targetFile['name']);
            array_push($added,$targetFile['name']);
            if($res===false){
                foreach($added as $file){
                    unlink($file);
                } 
                $_SESSION['message'] = "Podaczas zapisywania plików wystąpił błąd.";
                header("Location:../add");
                exit();
                break;
            }
        }

        //zapis rekordów do bazy danych
        $categoryModel = new CategoryModel();
        $adminProductModel = new AdminProductModel();
        $categoryId = $categoryModel->getCategoryId($_POST['category'])[0];
        try{
            $adminProductModel->createProduct(
                $_POST['name'],
                $categoryId,
                $added[0],
                (count($added)>=2)?$added[1]:null,
                (count($added)>=3)?$added[2]:null,
                $_POST['description'],
                $_POST['price'],
                $_POST['quantity'],
                $_POST['size'],
                $_POST['colour'],
                $_SESSION['user_id']);
        }
        catch(Exception $e){
            $_SESSION['message'] = $e->getMessage();
            header("Location:../add");
            exit();
        }
        $_SESSION['message'] = "Poprawnie dodano produkt";
        header("Location:../add");
    }
}