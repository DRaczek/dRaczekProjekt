<?php

class UserController{
    public function __construct(){

    }

    public function checkIfLoggedInAndRedirect(){
        if(!isset($_SESSION['user_id'])){
            header("Location:home");
            exit();
        }
    }

    public function displayUserDetailsPage(){
        $this->checkIfLoggedInAndRedirect();

        $userModel = new UserModel();
        $user = $userModel->getUser($_SESSION['user_id']);
        include("MVC/views/user/userDetails.php");
    }

    public function displayEditUserDetailsPage(){
        $this->checkIfLoggedInAndRedirect();
        $userModel = new UserModel();
        $user = $userModel->getUser($_SESSION['user_id']);
        include("MVC/views/user/editUserDetails.php");
    }

    public function editUserDetailsPage(){
        $this->checkIfLoggedInAndRedirect();
        try{
            $validationHelper = new AuthValidationHelper();
            $validationHelper->validateEditUserForm();
        }
        catch(Exception $e){
            $_SESSION['message'] = $e->getMessage();
            header("Location:../edit");
            exit();
        }

        try{
            $userModel = new UserModel();
            $userModel->editUser($_POST['first_name'], $_POST['last_name'], $_POST['date_of_birth'], $_SESSION['user_id']);
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się edytować danych użytkownika";
        }
        $_SESSION['message'] = "Poprawnie zedytowano dane użytkownika";
        header("Location:../../user");
       
    }

    public function displayChangeUserPasswordPage(){
        $this->checkIfLoggedInAndRedirect();
        include("MVC/views/user/changePassword.php");
    }

    public function changeUserPassword(){
        $this->checkIfLoggedInAndRedirect();
        echo $_SERVER['REQUEST_URI'];

        try{
            $validationHelper = new AuthValidationHelper();
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