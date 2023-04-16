<?php
include_once("MVC/controllers/user/userPanel/UserController.php");
include_once("MVC/models/databaseModels/UserModel.php");
include_once("MVC/models/validationHelpers/AuthValidationHelper.php");

class EditUserDetailsController extends UserController{
    public function __construct(){

    }

    public function displayEditUserDetailsPage(){
        $this->RedirectIfNotLoggedIn();
        $userModel = new UserModel();
        $user = $userModel->getUser($_SESSION['user_id']);
        include("MVC/views/user/editUserDetails.php");
    }

    public function editUserDetailsPage(){
        $this->RedirectIfNotLoggedIn();
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
}