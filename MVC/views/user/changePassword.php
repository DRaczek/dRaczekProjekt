<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="changePassword/send" method="post">
        <input type="password" name="oldPassword" placeholder="Podaj dotychczasowe hasło">
        <input type="password" name="password" placeholder="Podaj nowe hasło">
        <input type="password" name="repeatPassword" placeholder="Powtórz nowe hasło">
        <input type="submit" value="Zmień hasło" name="submit">
        <?php
                if(isset($_SESSION['message'])){
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
            ?>
    </form>
</body>
</html>