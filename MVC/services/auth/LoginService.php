<?php
include_once("MVC/models/databaseModels/UserModel.php");

class LoginService{
    public function __construct(){

    }

    public function login(){
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