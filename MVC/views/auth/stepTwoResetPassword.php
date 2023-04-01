<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Strona do resetowania hasła (Step two)
    <form action="../../stepTwo/send" method="post">
        <input type="hidden" name="token" value="<?php if(isset($_SESSION['token'])){
            echo $_SESSION['token'];
            unset($_SESSION['token']);
        }  ?>">
        <input type="password" name="password" placeholder="Podaj nowe hasło">
        <input type="password" name="repeatPassword" placeholder="Powtórz hasło">
        <input type="submit" value="Resetuj hasło" name="submit">
    </form>
    <?php
        if(isset($_SESSION['message'])){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
</body>
</html>