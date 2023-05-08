<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <?php echo $data['styles']; ?>
    <link rel="stylesheet" href="/dRaczekProjekt/css/orderView.css">
</head>
<body>
    <?php echo $data['header']; ?>
    <main>
    <div class="items">
            <?php foreach($data['products'] as $produkt): ?>
                <a class="item" href="/dRaczekProjekt/products/<?php echo $produkt['id']; ?>">
                    <img src="/dRaczekProjekt/<?php echo $produkt['image_path_1']; ?>" alt="obrazek przedmiotu" width="100" height="100">
                    <p class="product-name"><?php
                        echo "(ID:".$produkt['id'].")".$produkt['name'];
                    ?><p>
                    <div class="price-wrapper">
                        <p>
                            Cena jednostkowa : 
                            <span class="priceUnit">
                                <?php
                                    echo $produkt['price'];
                                ?>
                            </span>
                            PLN
                        </p>
                        <p>
                            Cena łącznie :
                            <span class="price">
                                <?php
                                    echo ((float)$produkt['price']*(float)$produkt['quantity']);
                                ?>
                            </span>
                            PLN
                        </p>
                    </div>
               
                    <div class="quantity">
                        <span class="product-quantity">Ilość : <?php echo $produkt['quantity']; ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </main>
    <?php echo $data['footer']; ?>
</body>
</html>