<?php
include_once("MVC/controllers/user/userPanel/UserController.php");
include_once("MVC/models/databaseModels/UserModel.php");
include_once("MVC/models/validationHelpers/AuthValidationHelper.php");
include_once("MVC/models/databaseModels/CategoryModel.php");

class EditUserDetailsController extends UserController{
    public function __construct(){

    }

    public function displayEditUserDetailsPage(){
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
        $this->loadView("MVC/views/user/editUserDetails", $data, false);
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