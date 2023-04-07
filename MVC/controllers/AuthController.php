<?php
include_once("MVC/services/auth/RegistrationService.php");
include_once("MVC/services/auth/LoginService.php");
include_once("MVC/services/auth/PasswordResetService.php");
include_once("MVC/models/databaseModels/TokenModel.php");

class AuthController{
    public function __construct(){

    }
    public function RedirectIfLoggedIn(){
        if(isset($_SESSION['user_id'])){
            header("Location:home");
            exit();
        }
    }

    /**
     * Metody związane z rejestracją konta w systemie.
     */
    public function displayRegisterPage(){
        $this->RedirectIfLoggedIn();
        include("MVC/views/auth/register.php");
    }

    public function registrationProcess(){
        $this->RedirectIfLoggedIn();
        $registrationService = new RegistrationService();
        $registrationService->registerUser();
    }

    public function registrationVerify($token){
        $this->RedirectIfLoggedIn();
        $registrationService = new RegistrationService();
        $registrationService->verifyRegistration($token);
    }
    
    /**
     * Metody związane z logowaniem użytkownika do systemu.
     */
    public function displayLoginPage(){
        $this->RedirectIfLoggedIn();
        if(isset($_SESSION['user_id'])){
            header("Location:home");
        }
        include("MVC/views/auth/login.php");
    }

    public function loginProcess(){
        $this->RedirectIfLoggedIn();
        $loginService = new LoginService();
        $loginService->login();
    }

    /**
     * Metody związane z wylogowywaniem się.
     */
    public function logout(){
        include("logout.php");
    }

    /**
     * Metody związane z resetowaniem zapomnianego hasła do konta.
     */
    public function displayStepOnePasswordReset(){
        $this->RedirectIfLoggedIn();
        include("MVC/views/auth/stepOneResetPassword.php");
    }

    public function stepOnePasswordReset(){
        $this->RedirectIfLoggedIn();
        $passwordResetService = new PasswordResetService();
        $passwordResetService->stepOnePasswordReset();        
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
        $_SESSION['token']=$token;
        include("MVC/views/auth/stepTwoResetPassword.php");
    }

    public function stepTwoPasswordReset(){
        $this->RedirectIfLoggedIn();
        $passwordResetService = new PasswordResetService();
        $passwordResetService->stepTwoPasswordReset();        
    }

}