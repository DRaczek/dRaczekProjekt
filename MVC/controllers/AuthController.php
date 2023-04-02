<?php
include("MVC/models/AuthValidationHelper.php");

class AuthController{
    public function __construct(){

    }
    public function checkIfLoggedInAndRedirect(){
        if(isset($_SESSION['user_id'])){
            header("Location:home");
            exit();
        }
    }

    /**
     * Metody związane z rejestracją konta w systemie.
     */
    public function displayRegisterPage(){
        $this->checkIfLoggedInAndRedirect();
        include("MVC/views/auth/register.php");
    }

    public function registrationProcess(){
        $this->checkIfLoggedInAndRedirect();
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
                $dbh = include("MVC/models/Database.php");
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
          
        }
       header("Location:../register");
    }

    public function registrationVerify(){
        $this->checkIfLoggedInAndRedirect();
        $uri = $_SERVER['REQUEST_URI'];
        $parts = explode("/", $uri);
        $token = end($parts);
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
    
    /**
     * Metody związane z logowaniem użytkownika do systemu.
     */
    public function displayLoginPage(){
        $this->checkIfLoggedInAndRedirect();
        if(isset($_SESSION['user_id'])){
            header("Location:home");
        }
        include("MVC/views/auth/login.php");
    }

    public function loginProcess(){
        $this->checkIfLoggedInAndRedirect();
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
        $this->checkIfLoggedInAndRedirect();
        include("MVC/views/auth/stepOneResetPassword.php");
    }

    public function stepOnePasswordReset(){
        $this->checkIfLoggedInAndRedirect();
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

    public function displayStepTwoPasswordReset(){
        $this->checkIfLoggedInAndRedirect();
        $uri = $_SERVER['REQUEST_URI'];
        $parts = explode("/", $uri);
        $token = end($parts);
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
        $this->checkIfLoggedInAndRedirect();
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