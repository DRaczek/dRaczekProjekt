<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <?php
        echo $data['styles'];
    ?>
    <link rel="stylesheet" href="/dRaczekProjekt/css/home.css">
</head>
<body>
    <?php
        echo $data['header'];
    ?>
    <main>
        <div class="banner">
            <img src="/dRaczekProjekt/img/logo/padding-logo.png">
        </div>
        <div class="oferta">
            <div class="item"><a href="/dRaczekProjekt/products">Produkty</a></div>
            <div class="item"><a href="/dRaczekProjekt/categories">Kategorie</a></div>
        </div>
        <h1 class="header">Najnowsze produkty</h1>
        <div class="newest">
            <div class="slide">
                <?php foreach($data['newest'] as $product): ?>
                    <a class="item" href="/dRaczekProjekt/products/<?php echo $product['id']; ?>">
                        <img src="/dRaczekProjekt/<?php echo $product['image_path_1'] ?>">
                        <span class="name"><?php echo $product['name']; ?></span>
                        <span class="price"><?php echo $product['price']; ?>PLN</span>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="move right">></div>
            <div class="move left"><</div>
        </div>
    </main>
    <?php
        echo $data['footer'];
    ?>
    <script>
        document.querySelector(".move.right").addEventListener("click",()=>{
            let width = document.querySelector("main .newest .slide .item").offsetWidth;
            document.querySelector("main .newest .slide").scrollLeft+=parseInt(width);
        });
        document.querySelector(".move.left").addEventListener("click",()=>{
            let width = document.querySelector("main .newest .slide .item").offsetWidth;
            document.querySelector("main .newest .slide").scrollLeft-=width;
        });
    </script>
</body>
</html>