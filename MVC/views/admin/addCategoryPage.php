<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Strona do dodawania kategorii.<br>
    <form action="add/send" method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="nazwa kategori"><br>
        Zdjęcie kategori : <input type="file" name="image" id="image"><br>
        <input type="submit" value="Dodaj kategorię" name="submit">
    </form>
    <?php
      if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }?>
    
</body>
</html>