<?php
include_once("MVC/controllers/user/auth/AuthController.php");
include_once("MVC/models/databaseModels/UserModel.php");
include_once("MVC/models/databaseModels/TokenModel.php");
include_once("MVC/models/validationHelpers/PasswordValidationHelper.php");

class StepTwoPasswordResetController extends AuthController{
    public function __construct(){

    }

    public function displayStepTwoPasswordReset($token){
        $this->RedirectIfLoggedIn();
        $tokenModel = new TokenModel();
        $result = $tokenModel->checkToken($token);
        if($result===false || $result['action']!=(int)TokenActionEnum::STEP_ONE_RESET_PASSWORD){
            $_SESSION['message'] = "Nieprawidłowy token";
            include("MVC/views/auth/stepTwoResetPassword.php");
            exit();
        }
        $data = array();
        $data['token']=$token;
        $data['header']=$this->loadView("MVC/views/common/header", null, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="/dRaczekProjekt/css/header.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/footer.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/basicLayout.css">';
        $this->loadView("MVC/views/auth/stepTwoResetPassword", $data, false);
    }

    public function stepTwoPasswordReset(){
        $this->RedirectIfLoggedIn();
        if(!isset($_POST['submit'])
        || !isset($_POST['token'])
        || !isset($_POST['password'])
        || !isset($_POST['repeatPassword'])){
            header("Location:../stepOne");  
            exit();
        }

        try{
            $dbh = include("MVC/models/databaseModels/Database.php");
            //jest sprawdzenie tokenu, usuniecie tokenu i modyfikacja uzytkownika wiec dalem transakcje
            $dbh->beginTransaction();
    
            $token = $_POST['token'];
            $tokenModel = new TokenModel();
            $result = $tokenModel->checkToken($token);
            if($result===false || $result['action']!=(int)TokenActionEnum::STEP_ONE_RESET_PASSWORD){
                header("Location:../stepOne");
                exit();  
            }
            $password = $_POST['password'];
            $repeatPassword = $_POST['repeatPassword'];
          
            $violations = array();
            try{
                $validationHelper = new PasswordValidationHelper();
                $validationHelper->validatePassword($password, $repeatPassword, $violations);
            }
            catch(Exception $e){
                $_SESSION['message'] = implode("", $violations);
                header("Location:resetPassword/stepTwo/token/".$token);  
                $dbh=null;
                exit();
            }
            $userModel = new UserModel();
            $userModel->resetUserPassword($result['user_id'], $password);
            $tokenModel->deleteToken($token);
            $_SESSION['message'] = "Hasło zostało zmienionie";
            header("Location:../stepOne");     
        }
        catch(PDOException $e){
            $dbh->rollback();
            $dbh = null;
            $_SESSION['message'] ="Wystąpił błąd";
            header("Location:../stepOne");  
        }
        $dbh=null;  
    }
}