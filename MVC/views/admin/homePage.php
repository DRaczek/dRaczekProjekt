<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div style="border:5px dashed red;">
        <?php
            if(isset($_SESSION['user_id'])){
                echo "Zalogowano jako : ".$_SESSION['user_email']."<br>";
                echo "<a href=\"../logout\">wyloguj się</a><br>";
                echo "<a href=\"../user\">Szczegóły użytkownika</a>";
            }
            else{
                echo "<a href=\"login\">Zaloguj się</a>";
            }
        ?>
    </div>
    Admin Panel.<br>
    <p><a href="../admin/manage/users">Manage users</a></p>
    <p><a href="../admin/manage/categories">Manage categories</a></p>
    <p><a href="../admin/manage/products">Manage products</a></p>
</body>
</html>