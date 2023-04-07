<?php

class PasswordValidationHelper{
    public function __construct(){

    }
    
    public function validatePassword($password, $repeatPassword, &$violations){
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
}