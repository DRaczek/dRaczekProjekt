?<?php
include_once("MVC/controllers/user/userPanel/UserController.php");
include_once("MVC/models/databaseModels/UserModel.php");
include_once("MVC/models/validationHelpers/ChangePasswordValidationHelper.php");
include_once("MVC/models/databaseModels/CategoryModel.php");

class ChangeUserPasswordController extends UserController{
    public function __construct(){

    }

    public function displayChangeUserPasswordPage(){
        $this->RedirectIfNotLoggedIn();

        $userModel = new UserModel();
        $data = array();
        $categoryModel = new CategoryModel();
        $headerData = array(
            "categories"=>$categoryModel->getCategories()
        );
        $data['user'] = $userModel->getUser($_SESSION['user_id']);
        $data['header']=$this->loadView("MVC/views/common/header", $headerData, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="/dRaczekProjekt/css/header.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/footer.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/basicLayout.css">';
        $this->loadView("MVC/views/user/changePassword", $data, false);
    }

    public function changeUserPassword(){
        $this->RedirectIfNotLoggedIn();
        try{
            $validationHelper = new ChangePasswordValidationHelper();
            $validationHelper->validateChangePasswordForm();
        }
        catch(Exception $e){
            $_SESSION['message'] = $e->getMessage();
            header("Location:../changePassword");
            exit();
        }
        $userModel = new UserModel();
        $user = $userModel->loginUser($_SESSION['user_email']);
        if(!password_verify($_POST['oldPassword'], $user['password'])){
            $_SESSION['message'] = "Podane hasło sie nie zgadza";
            header("Location:../changePassword");
            exit();
        }
        try{
            $userModel->resetUserPassword($_SESSION['user_id'], $_POST['password']);    
        }
        catch(Exception $e){
            $_SESSION['message'] = "Podczas zmiany hasła wystąpił błąd";
            header("Location:../changePassword");
            exit();
        }
        $_SESSION['message'] = "Pomyślnie zmieniono hasło";
        header("Location:../../user");
    }
}