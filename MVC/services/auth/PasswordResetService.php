<?php
include_once("MVC/models/databaseModels/UserModel.php");
include_once("MVC/models/databaseModels/TokenModel.php");
include_once("MVC/models/MailSender.php");
include_once("MVC/models/validationHelpers/AuthValidationHelper.php");

class PasswordResetService{
    public function __construct(){

    }
    
    public function stepOnePasswordReset(){
        if(!isset($_POST['email']) && !isset($_POST['submit'])){
            $_SESSION['message'] = "Nie wszystkie pola zostały wysłane.";
            header("Location:../stepOne");
            exit();
        }
        $email = $_POST['email'];
        $userModel = new UserModel();
        $result = $userModel->getActiveUserIdByEmail($email);
        if($result==null){
            $_SESSION['message'] = "Konto o podanym mailu nie istnieje lub jest niedostępne.";
            header("Location:../stepOne");
        }
        else{
            include("config/predefindedUsers.php");
            $token = bin2hex(random_bytes(32));
            $tokenModel = new TokenModel();
            $tokenModel->saveToken($token, TokenActionEnum::STEP_ONE_RESET_PASSWORD, $result['id'], $System_user_id);
            $mailSender = new MailSender();
            $mailSender->sendStepOneResetPasswordMail($result['email'], $token);
            $_SESSION['message'] = "Na podany mail wysłano link do drugiego etapu resetu hasła.";
            header("Location:../stepOne");
        }
    }

    public function stepTwoPasswordReset(){
        if(!isset($_POST['submit'])
        || !isset($_POST['token'])
        || !isset($_POST['password'])
        || !isset($_POST['repeatPassword'])){
            header("Location:../stepOne");  
            exit();
        }

        try{
            $dbh = include("MVC/models/Database.php");
            $dbh->beginTransaction();
    
            $token = $_POST['token'];
            $tokenModel = new TokenModel();
            $result = $tokenModel->checkToken($token);
            if($result===false || $result['action']!=(int)TokenActionEnum::STEP_ONE_RESET_PASSWORD){
                header("Location:../stepOne");  
            }
            $password = $_POST['password'];
            $repeatPassword = $_POST['repeatPassword'];
          
            $violations = array();
            try{
                $validationHelper = new AuthValidationHelper();
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