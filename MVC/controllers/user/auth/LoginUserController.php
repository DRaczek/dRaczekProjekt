<?php
include_once("MVC/controllers/user/auth/AuthController.php");
include_once("MVC/models/databaseModels/UserModel.php");

class LoginUserController extends AuthController{
    public function __construct(){

    }

    public function displayLoginPage(){
        $this->RedirectIfLoggedIn();
        if(isset($_SESSION['user_id'])){
            header("Location:home");
        }

        $data = array();
        $data['header']=$this->loadView("MVC/views/common/header", null, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="/dRaczekProjekt/css/header.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/footer.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/basicLayout.css">';
        $this->loadView("MVC/views/auth/login", $data, false);
    }

    public function loginProcess(){
        $this->RedirectIfLoggedIn();
        if(!isset($_POST['email']) || !isset($_POST['password'])){
            $_SESSION['message'] = "Podane dane są nieprawidłowe.";
            header("Location:../login");
            exit();
        }
        $email = $_POST['email'];
        $password = $_POST['password'];
        if(empty($email) || empty($password)){
            $_SESSION['message'] = "Podane dane są nieprawidłowe.";
            header("Location:../login");
            exit();
        }

        $userModel = new UserModel();
        $user = $userModel->loginUser($email);
        if($user && password_verify("$password", $user['password'])){
            $_SESSION['user_id']=$user['id'];
            $_SESSION['user_first_name'] = $user['first_name'];
            $_SESSION['user_email'] = $user['email'];
            header("Location:../home");
        }
        else{
            $_SESSION['message'] = "Nieprawidłowy email lub hasło";
            header("Location:../login");
        }
    }
}