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
        <p>Email : <?php echo $user['email']; ?> </p>
        <p>Imię : <?php echo $user['first_name']; ?> </p>
        <p>Nazwisko : <?php echo $user['last_name']; ?> </p>
        <p>Data urodzenia : <?php echo $user['date_of_birth']; ?> </p>
        <a href="user/edit">Edytuj dane</a>
        <a href="user/changePassword">Zmień hasło</a>
        <?php
          if(isset($_SESSION['message'])){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            }
        ?>
    <?php } else echo "Nie udało się pobrać szczegółów użytkownika." ?>
</body>
</html>