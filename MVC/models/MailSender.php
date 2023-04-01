<?php

class MailSender{
    public function __construct(){

    }

    public function sendStepOneResetPasswordMail($email, $token){
        $to = $email;
        $subject = 'Reset hasła';
        $message = 'Witaj, aby zresetować swoje hasło przejdź do strony pod linkiem: '.
            'localhost/dRaczekProjekt/resetPassword/stepTwo/token/'.$token;
        $headers = 'From: draczekprojekt@gmail.com' . "\r\n" .
            'Reply-To: draczekprojekt@gmail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail($to, $subject, $message, $headers);
    }

    public function sendVerificationMail($email, $token){
        $to = $email;
        $subject = 'Potwierdzenie rejestracji';
        $message = 'Witaj, aby potwierdzić rejestrację kliknij w poniższy link: '.
            'localhost/dRaczekProjekt/register/verify/'.$token;
        $headers = 'From: draczekprojekt@gmail.com' . "\r\n" .
            'Reply-To: draczekprojekt@gmail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail($to, $subject, $message, $headers);
    }
}