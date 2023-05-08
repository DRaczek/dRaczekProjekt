<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
</head>
<body>
    Strona logowania do panelu administratora.
    <form action="login/send" method="post">
        <input type="email" name="email" placeholder="Podaj email"><br>
        <input type="password" name="password" placeholder="Podaj hasło"><Br>
        <input type="submit" value="Zaloguj się" name="submit">
    </form>
    <?php
        if(isset($_SESSION['message'])){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
    ?>
</body>
</html>