<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Strona logowania<br>
    <form action="login/sendForm" method="post">
        <input type="email" name="email" placeholder="E-mail"><Br>
        <input type="password" name="password" placeholder="Hasło"><Br>
        <input type="submit" value="Zaloguj się">
    </form>
    <?php
        if(isset($_SESSION['message'])){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
    ?>
    <br>
    Zapomniałeś hasła do konta ? <a href="resetPassword/stepOne">Resetuj hasło</a><Br>
    Nie masz konta? <a href="register">Zarejestruj się</a><br>

</body>
</html>