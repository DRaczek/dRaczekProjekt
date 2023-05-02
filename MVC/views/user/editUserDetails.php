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
</head>
<body>
    <?php echo $data['header']; ?>
    <main>
        <div id="user">
            <?php if($data['user']){ $user = $data['user'] ?>
                <div class="account-img">
                    <img src="/dRaczekProjekt/img/account-icon.svg">
                </div>
                <form action="edit/send" method="post">
                    <table>
                        <tr>
                            <td class="title">Imię</td>
                            <td><input type="text" name="first_name" placeholder="Imię" value="<?php echo $user['first_name']; ?>"></td>
                        </tr>
                        <tr>
                            <td class="title">Nazwisko</td>
                            <td><input type="text" name="last_name" placeholder="Nazwisko" value="<?php echo $user['last_name']; ?>"></td>
                        </tr>
                        <tr>
                            <td class="title">Data Urodzenia</td>
                            <td><input type="date" name="date_of_birth" placeholder="Data urodzenia" value="<?php echo $user['date_of_birth']; ?>"></td>
                        </tr>
                        <tr>
                            <td class="title"><input type="submit" value="Edytuj" name="submit"></td>
                        </tr>
                    </table>
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