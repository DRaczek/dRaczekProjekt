<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <?php echo $data['styles']; ?>
    <link rel="stylesheet" href="/dRaczekProjekt/css/list.css">
    <style>
          main{
            margin: calc(var(--header-height) + 1%) 10%;    
            border: 1px solid lightgray;
            box-shadow: lightgray 5px 5px 5px, lightgray -5px 5px 5px;
            border-radius: 20px;
            padding: 20px;   
        }
        main form input{
            width:100%;
            height:100%;
            background-color:white;
            border: 1px solid lightgray;
            box-shadow: lightgray 5px 5px 5px, lightgray -5px 5px 5px;
            transition:0.3s;
        }
        main form input[type=submit]:hover{
            transform: scale(1.05);
        }
        @media screen and (max-width:600px) {
            main {
                margin: calc(var(--header-height) + 1%) 1%;    
                padding:5px
            }
        }
    </style>
</head>
<body>
    <?php
        $id = $data['id'];
    ?>
    <?php echo $data['header']; ?>
    <main>
        <form action="../send" method="post" enctype="multipart/form-data" class="list">
            <span class="caption">Podaj nazwę</span>
            <span class="value"><input type="text" name="name"></span>
            <span class="caption">Zdjęcie kategorii</span>
            <span class="value"><input type="file" name="image" id="image"></span>
            <span class="subtitle"><input type="submit" value="Edytuj kategorię" name="submit"></span>
            <input type="hidden" name="id" value=<?php echo $id; ?>>
        </form>
        <?php
        if(isset($_SESSION['message'])){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }?>
    </main>
    <?php echo $data['footer']; ?>
 
    
</body>
</html>