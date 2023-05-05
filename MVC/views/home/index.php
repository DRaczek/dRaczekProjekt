<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <?php
        echo $data['styles'];
    ?>
</head>
<body>
    <?php
        echo $data['header'];
    ?>
        <main>
        <div style="border:5px dashed red;">
            <?php
                if(isset($_SESSION['user_id'])){
                    echo "Zalogowano jako : ".$_SESSION['user_email']."<br>";
                    echo "<a href=\"logout\">wyloguj się</a><br>";
                    echo "<a href=\"user\">Szczegóły użytkownika</a>";
                }
                else{
                    echo "<a href=\"login\">Zaloguj się</a>";
                }
            ?>
        </div>
        Strona główna aplikacji.
    <a href="login">Zaloguj się</a>
    <a href="register">Zarejestruj się</a>
    <br>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </main>
    <?php
        echo $data['footer'];
    ?>
</body>
</html>