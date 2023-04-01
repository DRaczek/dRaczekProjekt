<?php

class AuthController{
    public function __construct(){

    }
    public function checkIfLoggedInAndRedirect(){
        if(isset($_SESSION['user_id'])){
            header("Location:home");
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
                $this->registrationValidation();
            }
            catch(Exception $e){
                $_SESSION['message'] = $e->getMessage();
                header("Location:../register");
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

                $this->sendVerificationMail($user['email'], $token);

                $_SESSION['message'] ="Na podany e-mail wysłano link do potwierdzenia rejestracji. Kliknij link, aby potwierdzić rejestrację.";

                $dbh->commit();
                $dbh=null;
            }
            catch(PDOException $e){
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

    private function registrationValidation(){
        $violations = array();
        if(!isset($_POST['submit'])
        || !isset($_POST['email'])
        || !isset($_POST['first_name'])
        || !isset($_POST['last_name'])
        || !isset($_POST['date_of_birth'])
        || !isset($_POST['password'])
        || !isset($_POST['repeat_password'])){
            array_push($violations, "Nie wszystkie pola zostały przesłane<br>");
        }
        else{
            $email = $_POST['email'];
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $dateOfBirth = $_POST['date_of_birth'];
            $password = $_POST['password'];
            $repeatPassword = $_POST['repeat_password'];
            $this->validateEmail($email, $violations);
            $this->validateName($firstName, $lastName, $violations);
            $this->validateDateOfBirth($dateOfBirth, $violations);
            $this->validatePassword($password, $repeatPassword, $violations);
        }
        if(count($violations)>0){
            throw new Exception(implode(" ", $violations));
        }
    }

    private function sendVerificationMail($email, $token){
        $to = $email;
        $subject = 'Potwierdzenie rejestracji';
        $message = 'Witaj, aby potwierdzić rejestrację kliknij w poniższy link: '.
            'localhost/dRaczekProjekt/register/verify/'.$token;
        $headers = 'From: draczekprojekt@gmail.com' . "\r\n" .
            'Reply-To: draczekprojekt@gmail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail($to, $subject, $message, $headers);
    }

    private function validateEmail($email, &$violations){
        if(empty($email)){
            array_push($violations, "Nie podano pola e-mail<br>");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($violations, "Podany e-mail jest niepoprawny.<br>");
        }
        $usermodel = new UserModel();
        if(!$usermodel->isEmailUnique($email)){
            array_push($violations, "Podany e-mail jest już zarejestrowany.<br>");
        }
     
    }
    
    private function validateName($firstName, $lastName, &$violations){
        if(empty($firstName)){
            array_push($violations, "Nie podano imienia<br>");
        }
        if(empty($lastName)){
            array_push($violations, "Nie podano nazwiska<br>");
        }
        if (!preg_match('/^[a-zA-Z]{2,50}$/', $firstName)) {
            array_push($violations, "Podane imię jest niepoprawne.<br>");
        }
        if (!preg_match('/^[a-zA-Z]{2,50}+$/', $lastName)) {
            array_push($violations, "Podane nazwisko jest niepoprawne.<br>");
        }
    }

    private function validateDateOfBirth($date, &$violations){
        if(empty($date)){
            array_push($violations, "Nie podano daty urodzenia<br>");
        }
        $dateArr = explode('-', $date);
        //checkdate(month,day,year)
        if (count($dateArr) !== 3 || !checkdate($dateArr[1], $dateArr[2], $dateArr[0])) {
            array_push($violations, "Podana data urodzenia jest niepoprawna.<br>");
        }
        else{
            if(strtotime("1850-01-01")>$date){
                array_push($violations, "Podana data urodzenia jest niepoprawna.<br>");
            }
        }
       
    }

    private function validatePassword($password, $repeatPassword, &$violations){
        if(empty($password)){
            array_push($violations, "Nie podano hasła<br>");
        }
        if($password!=$repeatPassword){
            array_push($violations, "Podane hasła nie są take same.<br>");
        }
        if (!preg_match( '/^[A-Za-z\d]{8,40}$/', $password)) {
            array_push($violations, "Podane hasło nie jest poprawne. Hasło powinno składać się z wyłącznie liczb lub cyfr od 8 do 40<br>");
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
        }
        $email = $_POST['email'];
        $password = $_POST['password'];
        if(empty($email) || empty($password)){
            $_SESSION['message'] = "Podane dane są nieprawidłowe.";
            header("Location:../login");
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
            $this->sendStepOneResetPasswordMail($result['email'], $token);
            $_SESSION['message'] = "Na podany mail wysłano link do drugiego etapu resetu hasła.";
            header("Location:../stepOne");
        }
    }

    private function sendStepOneResetPasswordMail($email, $token){
        $to = $email;
        $subject = 'Reset hasła';
        $message = 'Witaj, aby zresetować swoje hasło przejdź do strony pod linkiem: '.
            'localhost/dRaczekProjekt/resetPassword/stepTwo/token/'.$token;
        $headers = 'From: draczekprojekt@gmail.com' . "\r\n" .
            'Reply-To: draczekprojekt@gmail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail($to, $subject, $message, $headers);
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
                $this->validatePassword($password, $repeatPassword, $violations);
            }
            catch(Exception $e){
                $_SESSION['message'] = implode("", $violations);
                header("Location:resetPassword/stepTwo/token/".$token);  
                $dbh=null;
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