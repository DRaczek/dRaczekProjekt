<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <?php echo $data['styles']; ?>
    <style>
        main {
            margin: calc(var(--header-height) + 1%) 10%;
            padding:20px;
            border:1px solid lightgray;
            box-shadow: lightgray 5px 5px 5px, lightgray -5px 5px 5px;
            display:flex;
            justify-content:center;
            align-items:center;
            flex-direction:column;
            text-align:center;
        }
        main a{
            padding:30px 20px;
            border:1px solid lightgray;
            box-shadow: lightgray 5px 5px 5px, lightgray -5px 5px 5px;
            text-decoration:none;
            color:black;
            font-size:22px;
            transition:0.3s
        }
        main a:hover{
            transform:scale(1.1);
            background-color:lightgray;
        }
        @media screen and (max-width:600px){
            main{
                margin: calc(var(--header-height) + 1%) 1%;
                padding:5px;
            }
            main a{
                padding:10px
            }

        }
    </style>
</head>
<body>
    <?php $id = $data['id']; ?>
    <?php echo $data['header']; ?>
    <main>
        <h1>Strona symulująca płatność online dla zamówienia o id <?php echo $id; ?></h1>
        <a href="../../order/pay/<?php echo $id; ?>">Zasymuluj płatność za zamówienie</a>
    </main>
    <?php echo $data['footer']; ?>

</body>
</html>