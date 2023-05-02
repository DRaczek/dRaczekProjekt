<?php
include_once("MVC/controllers/user/auth/AuthController.php");
include_once("MVC/models/databaseModels/UserModel.php");
include_once("MVC/models/databaseModels/TokenModel.php");
include_once("MVC/models/MailSender.php");

class StepOnePasswordResetController extends AuthController{
    public function __construct(){

    }

    public function displayStepOnePasswordReset(){
        $this->RedirectIfLoggedIn();
        $data = array();
        $data['header']=$this->loadView("MVC/views/common/header", null, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="/dRaczekProjekt/css/header.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/footer.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/basicLayout.css">';
        $this->loadView("MVC/views/auth/stepOneResetPassword", $data, false);
    }

    public function stepOnePasswordReset(){
        $this->RedirectIfLoggedIn();
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
}