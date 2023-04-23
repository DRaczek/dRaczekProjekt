<?php
include_once("MVC/models/validationHelpers/PasswordValidationHelper.php");

class AuthValidationHelper{
    public function __construct(){
        
    }

    public function validateEditUserForm(){
        $violations = array();
        if(!isset($_POST['submit'])
        || !isset($_POST['first_name'])
        || !isset($_POST['last_name'])
        || !isset($_POST['date_of_birth'])){
            array_push($violations, "Nie wszystkie pola zostały przesłane<br>");
        }
        else{
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $dateOfBirth = $_POST['date_of_birth'];
            $this->validateName($firstName, $lastName, $violations);
            $this->validateDateOfBirth($dateOfBirth, $violations);
        }
        if(count($violations)>0){
            throw new Exception(implode(" ", $violations));
        }
    }

    public function registrationValidation(){
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
            $passwordValidationHelper = new PasswordValidationHelper();
            $passwordValidationHelper->validatePassword($password, $repeatPassword, $violations);
        }
        if(count($violations)>0){
            throw new Exception(implode(" ", $violations));
        }
    }

    private function validateEmail($email, &$violations){
        if(empty($email)){
            array_push($violations, "Nie podano pola e-mail<br>");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($violations, "Podany e-mail jest niepoprawny.<br>");
        }
        $usermodel = new UserModel();
        if($usermodel->isEmailTaken($email)){
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
        if (!preg_match('/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]{2,50}$/', $firstName)) {
            array_push($violations, "Podane imię jest niepoprawne.<br>");
        }
        if (!preg_match('/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]{2,50}+$/', $lastName)) {
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
}