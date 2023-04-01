<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Strona do resetowania hasła(Step one).
    <form action="stepOne/send" method="post">
        <input type="email" name="email" placeholder="Wpisz swój e-mail"><Br>
        <input type="submit" value="Resetuj">
        <?php
        if(isset($_SESSION['message'])){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
    ?>
    </form>
</body>
</html>