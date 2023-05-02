<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <?php echo $data['styles']; ?>
    <link rel="stylesheet" href="css/userDetails.css">
</head>
<body>
    <?php echo $data['header']; ?>
    <main>
        <div id="user">
            <?php if($data['user']){ $user = $data['user'] ?>
                <div class="account-img">
                    <img src="img/account-icon.svg">
                </div>
                <table>
                    <tr>
                        <td class="title">Email</td>
                        <td><?php echo $user['email']; ?></td>
                    </tr>
                    <tr>
                        <td class="title">Imię</td>
                        <td><?php echo $user['first_name']; ?></td>
                    </tr>
                    <tr>
                        <td class="title">Nazwisko</td>
                        <td><?php echo $user['last_name']; ?></td>
                    </tr>
                    <tr>
                        <td class="title">Data urodzenia</td>
                        <td><?php echo $user['date_of_birth']; ?></td>
                    </tr>
                </table>
                <a href="user/edit" id="editIcon-wrapper">
                    <img src="img/edit-icon.svg" class="icon">
                </a>
                <a href="user/changePassword" class="icon">Zmień hasło</a>
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