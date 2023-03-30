<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div style="border:5px dashed red;">
        <?php
            if(isset($_SESSION['user_id'])){
                echo "Zalogowano jako : ".$_SESSION['user_email']."<br>";
                echo "<a href=\"logout\">wyloguj się</a>";
            }
            else{
                echo "<a href=\"login\">Zaloguj się</a>";
            }
        ?>
    </div>
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
    Nie masz konta? <a href="register">Zarejestruj się</a>

</body>
</html>