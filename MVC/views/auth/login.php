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
        <form action="login/sendForm" method="post" class="form">
            <h1>Zaloguj się</h1>
            <input type="email" name="email" placeholder="E-mail"><Br>
            <input type="password" name="password" placeholder="Hasło"><Br>
            <input type="submit" value="Zaloguj się">
            <?php
                if(isset($_SESSION['message'])){
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
            ?>
            <p>
                Zapomniałeś hasła do konta ? <a href="resetPassword/stepOne">Resetuj hasło</a>
            </p>
            <p>
                Nie masz konta? <a href="register">Zarejestruj się</a><br>
            </p>
            
          
        </form>
     
        <br>
    
    </main>
    <?php echo $data['footer']; ?>

</body>
</html>