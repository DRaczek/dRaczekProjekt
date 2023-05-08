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
        main{
            display:grid;
            grid-template-columns: 1fr 1fr;
            gap:30px;
            padding:10px;
        }
        main a{
            text-decoration:none;
            color:black;
            font-weight:600;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            text-align:center;
            border: 1px solid lightgray;
            box-shadow: lightgray 5px 5px 5px, lightgray -5px 5px 5px;
        }
        main a img{
            max-width:300px;
            width: 100%;
            height:auto;
        }
        @media screen and (max-width:500px){
            main{
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php echo $data['header']; ?>
    <main>
        <a href="../admin/manage/users">
            <img src="/dRaczekProjekt/img/user.svg">
            <h2>Zarządzaj użytkownikami</h2>
        </a>
        <a href="../admin/manage/categories">
            <img src="/dRaczekProjekt/img/category.svg">
            <h2>Zarządzaj kategoriami</h2>
        </a>
        <a href="../admin/manage/products">
            <img src="/dRaczekProjekt/img/product.svg">
            <h2>Zarządzaj produktami</h2>
        </a>
        <a href="../admin/manage/orders">
            <img src="/dRaczekProjekt/img/order.svg">
            <h2>Zarządzaj zamówieniami</h2>
        </a>
    </main>
    <?php echo $data['footer']; ?>
</body>
</html>