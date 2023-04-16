<?php
include_once("MVC/controllers/admin/user/AdminController.php");
include_once("MVC/models/databaseModels/AdminModel.php");

class LoginAdminController extends AdminController{
    public function __construct(){
        
    }

    public function displayLoginAdminPage(){
        if(isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin']===true)header("Location:home");
        include("MVC/views/admin/loginPage.php");
    }

    public function loginAdmin(){
        if(isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin']===true)header("Location:../home");
        
        if(!isset($_POST['submit']) || !isset($_POST['email']) || !isset($_POST['password'])){
            $_SESSION['message'] = "Nie wszystkie dane zostały przesłane.";
            header("Location:../login");
            exit();
        }
        if(empty($_POST['email']) || empty($_POST['password'])){
            $_SESSION['message'] = "Nie wszystkie pola zostały uzupełnione.";
            header("Location:../login");
            exit();
        }
        $email = $_POST['email'];
        $password = $_POST['password'];
        $adminModel = new AdminModel();
        $user = $adminModel->loginAdmin($email);
        if($user==null){
            $_SESSION['message'] = "Konto o podanych danych, nie istnieje";
            header("Location:../login");
            exit();
        }
        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_first_name'] = $user['first_name'];
            $_SESSION['user_is_admin'] = true;
            header("Location:../home");
        }
        else{
            $_SESSION['message'] = "Wystąpił błąd";
            header("Location:../login");
        }
    }
}