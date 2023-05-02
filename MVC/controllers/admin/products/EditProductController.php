<?php
include_once("MVC/controllers/admin/products/AdminProductController.php");
include_once("MVC/models/databaseModels/CategoryModel.php");
include_once("MVC/models/databaseModels/AdminProductModel.php");
include_once("MVC/models/validationHelpers/ProductValidationHelper.php");

class EditProductController extends AdminProductController{
    public function __construct(){

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
        //walidacja
        try{
            $validationHelper = new ProductValidationHelper();
            $targetFiles = $validationHelper->validate(true);
        
        }
        catch(Exception $e){
            $_SESSION['message'] = $e->getMessage();
            header("Location:../../../products");
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
                header("Location:../../../products");
                exit();
                break;
            }
        }

        //zapis rekordów do bazy danych
        $categoryModel = new CategoryModel();
        $adminProductModel = new AdminProductModel();
        $categoryId = $categoryModel->getCategoryId($_POST['category'])[0];
        try{
            $adminProductModel->editProduct(
                $_POST['id'],
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
                $_POST['gender'],
                $_SESSION['user_id']);
        }
        catch(Exception $e){
            $_SESSION['message'] = $e->getMessage();
            header("Location:../../../products");
            exit();
        }
        $_SESSION['message'] = "Poprawnie edytowano produkt";
        header("Location:../../../products");
    }
}