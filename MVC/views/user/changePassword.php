<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <?php echo $data['styles']; ?>
    <link rel="stylesheet" href="/dRaczekProjekt/css/changePassword.css">
</head>
<body>
    <?php echo $data['header']; ?>
    <main>
        <div id="user">
            <div class="account-img">
                <img src="/dRaczekProjekt/img/account-icon.svg">
            </div>
            <form action="changePassword/send" method="post">
                <table>
                    <tr>
                        <td class="title">Aktualne hasło</td>
                        <td> <input type="password" name="oldPassword" placeholder="Podaj dotychczasowe hasło"></td>
                    </tr>
                    <tr>
                        <td class="title">Nowe hasło</td>
                        <td> <input type="password" name="password" placeholder="Podaj nowe hasło"></td>
                    </tr>
                    <tr>
                        <td class="title">Powtórz nowe hasło</td>
                        <td><input type="password" name="repeatPassword" placeholder="Powtórz nowe hasło"></td>
                    </tr>
                    <tr>
                        <td class="title"><input type="submit" value="Zmień hasło" name="submit"></td>
                    </tr>
                </table>
            </form>
            <?php
                if(isset($_SESSION['message'])){
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
            ?>
        </div>
    </main>
    <?php echo $data['footer']; ?>
</body>
</html>