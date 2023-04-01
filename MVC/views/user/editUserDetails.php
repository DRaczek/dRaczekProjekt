<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Strona szczegółów o użytkowniku.<br>
    <?php if($user){ ?>
        <form action="edit/send" method="post">
            <input type="text" name="first_name" placeholder="Imię" value="<?php echo $user['first_name']; ?>"><Br>
            <input type="text" name="last_name" placeholder="Nazwisko" value="<?php echo $user['last_name']; ?>"><Br>
            <input type="date" name="date_of_birth" placeholder="Data urodzenia" value="<?php echo $user['date_of_birth']; ?>"><Br>
            <input type="submit" value="Edytuj" name="submit">
            <?php
                if(isset($_SESSION['message'])){
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
            ?>
        </form>
    <?php } else echo "Nie udało się pobrać szczegółów użytkownika." ?>
</body>
</html>