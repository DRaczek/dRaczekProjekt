<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <?php echo $data['styles']; ?>
    <link rel="stylesheet" href="/dRaczekProjekt/css/login.css">
</head>
<body>
    <?php echo $data['header']; ?>
    <main>
        <form action="../../stepTwo/send" method="post" class="form">
            <h1>Krok drugi resetowania hasła</h1>
            <input type="hidden" name="token" value="<?php echo $data['token']; ?>">
            <input type="password" name="password" placeholder="Podaj nowe hasło">
            <input type="password" name="repeatPassword" placeholder="Powtórz hasło">
            <input type="submit" value="Resetuj hasło" name="submit">
            <?php
                if(isset($_SESSION['message'])){
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
            ?>
        </form>
    </main>
    <?php echo $data['footer']; ?>

</body>
</html>