<?php
include_once("MVC/models/databaseModels/UserModel.php");
include_once("MVC/models/validationHelpers/AuthValidationHelper.php");

class EditUserDetailsService{
    public function __construct(){

    }

    public function edit(){
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