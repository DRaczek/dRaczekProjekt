<?php
include_once("MVC/controllers/user/auth/AuthController.php");
include_once("MVC/models/validationHelpers/AuthValidationHelper.php");
include_once("MVC/models/databaseModels/UserModel.php");
include_once("MVC/models/databaseModels/TokenModel.php");
include_once("MVC/models/MailSender.php");

class RegisterUserController extends AuthController{
    public function __construct(){

    }

    public function displayRegisterPage(){
        $this->RedirectIfLoggedIn();
        include("MVC/views/auth/register.php");
    }

    public function registrationProcess(){
        $this->RedirectIfLoggedIn();
      if(isset($_POST['submit'])){
            try{
                $validationHelper = new AuthValidationHelper();
                $validationHelper->registrationValidation();
            }
            catch(Exception $e){
                $_SESSION['message'] = $e->getMessage();
                header("Location:../register");
                exit();
            }
            try{
                $dbh = include("MVC/models/databaseModels/Database.php");
                $dbh->beginTransaction();

                include("config/predefindedUsers.php");
                $userModel = new UserModel();

                $user = $userModel->registerUser($_POST['email'],$_POST['first_name'],$_POST['last_name'],$_POST['date_of_birth'], $_POST['password'], $System_user_id);

                $token = bin2hex(random_bytes(32)); //losowy token do rejestracji(raczej nie unikualny, ale mala szansa na powtórzenie)
                $tokenModel = new TokenModel();
                $tokenModel->saveToken($token, TokenActionEnum::REGISTER_USER, $user['id'], $System_user_id);

                $mailSender = new MailSender();
                $mailSender->sendVerificationMail($user['email'], $token);

                $_SESSION['message'] ="Na podany e-mail wysłano link do potwierdzenia rejestracji. Kliknij link, aby potwierdzić rejestrację.";

                $dbh->commit();
                $dbh=null;
            }
            catch(Exception $e){
                $dbh->rollback();
                $_SESSION['message'] ="Wystąpił błąd podczas rejestracji!";
            }
            header("Location:../register");
        }
    }

    public function registrationVerify($token){
        $this->RedirectIfLoggedIn();
        $tokenModel = new TokenModel();
        $result = $tokenModel->checkToken($token);
        if($result===false){
            echo "Token nieprawidłowy";
        }
        else {
            $userModel = new UserModel();
            $userModel->activateUser($result['user_id']);
            echo "Konto zweryfikowane!";
            $tokenModel->deleteToken($token);
        }
    }
}