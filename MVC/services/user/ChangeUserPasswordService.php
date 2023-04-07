<?php
include_once("MVC/models/databaseModels/UserModel.php");
include_once("MVC/models/validationHelpers/ChangePasswordValidationHelper.php");

class ChangeUserPasswordService{
    public function __construct(){

    }
    public function changePassword(){
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