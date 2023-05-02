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
        <form action="register/sendForm" method="post" class="form">
            <h1>Zarejestruj się</h1>
            <input type="email" name="email" placeholder="E-mail"><Br>
            <input type="text" name="first_name" placeholder="Imię"><Br>
            <input type="text" name="last_name" placeholder="Nazwisko"><Br>
            <input type="date" name="date_of_birth" placeholder="Data urodzenia"><Br>
            <input type="password" name="password" placeholder="Hasło"><Br>
            <input type="password" name="repeat_password" placeholder="Powtórz hasło"><Br>
            <input type="submit" value="Prześlij" name="submit">
            <?php
                if(isset($_SESSION['message'])){
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
            ?>
            <p>
                Masz już konto ? <a href="login">Zaloguj się</a>
            </p>
        </form>
     
        <br>
    
    </main>
    <?php echo $data['footer']; ?>

</body>
</html>