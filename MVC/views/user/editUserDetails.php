<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <?php echo $data['styles']; ?>
    <link rel="stylesheet" href="/dRaczekProjekt/css/editUser.css">
    <link rel="stylesheet" href="/dRaczekProjekt/css/list.css">
</head>
<body>
    <?php echo $data['header']; ?>
    <main>
        <div id="user">
            <?php if($data['user']){ $user = $data['user'] ?>
                <div class="account-img">
                    <img src="/dRaczekProjekt/img/account-icon.svg">
                </div>
                <form action="edit/send" method="post" class="list">
                    <span class="caption">Imię</span><span class="value"><input type="text" name="first_name" placeholder="Imię" value="<?php echo $user['first_name']; ?>"></span>
                    <span class="caption">Nazwisko</span><span class="value"><input type="text" name="last_name" placeholder="Nazwisko" value="<?php echo $user['last_name']; ?>"></span>
                    <span class="caption">Data Urodzenia</span><span class="value"><input type="date" name="date_of_birth" placeholder="Data urodzenia" value="<?php echo $user['date_of_birth']; ?>"></span>
                    <span class="caption subtitle"><input type="submit" value="Edytuj" name="submit"></span></span>
                </form>
                <?php
                    if(isset($_SESSION['message'])){
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }
                ?>
                <?php
                if(isset($_SESSION['message'])){
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    }
                ?>
            <?php } else echo "Nie udało się pobrać szczegółów użytkownika." ?>
        </div>
    </main>
    <?php echo $data['footer']; ?>
</body>
</html>