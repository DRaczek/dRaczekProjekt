<?php
include_once("MVC/models/validationHelpers/PasswordValidationHelper.php");

class ChangePasswordValidationHelper{
    public function __construct(){

    }
    
    public function validateChangePasswordForm(){
        $violations = array();
        if(!isset($_POST['submit'])
        || !isset($_POST['oldPassword'])
        || !isset($_POST['password'])
        || !isset($_POST['repeatPassword'])){
            array_push($violations, "Nie wszystkie pola zostały przesłane<br>");
        }
        else{
            $oldPassword = $_POST['oldPassword'];
            $newPassword = $_POST['password'];
            $repearNewPassword = $_POST['repeatPassword'];
            $passwordValidationHelper = new PasswordValidationHelper();
            $passwordValidationHelper->validatePassword($newPassword, $repearNewPassword, $violations);
            $passwordValidationHelper->validatePassword($oldPassword, $oldPassword, $violations);
        }
        if(count($violations)>0){
            throw new Exception(implode(" ", $violations));
        }
    }
}