<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <?php echo $data['styles']; ?>
    <link rel="stylesheet" href="/dRaczekProjekt/css/productView.css">
</head>
<body>
    <?php $product = $data['product']; ?>
    <?php echo $data['header']; ?>
    <main>
        <div class="img-wrapper">
            <img src="<?php echo "/dRaczekProjekt/".$product['image_path_1']; ?>" class="main-img">
            <div class="imgs">
                <?php
                    if(!empty($product['image_path_1'])){
                        echo "<img src=\"/dRaczekProjekt/".$product['image_path_1']."\">";
                    }
                    if(!empty($product['image_path_2'])){
                        echo "<img src=\"/dRaczekProjekt/".$product['image_path_2']."\">";
                    }
                    if(!empty($product['image_path_3'])){
                        echo "<img src=\"/dRaczekProjekt/".$product['image_path_3']."\">";
                    }
                ?>
            </div>
        </div>
        <div class="main-info">
            <h1 class="product-name" style="font-size:24px"><?php echo $product['name']; ?></h1>
            <h2 class="product-price"><?php echo $product['price']."PLN"; ?></h2>
            <span class="product-quantity">Dostępna ilość : <b><?php echo $product['quantity']; ?> sztuk</b></span><br>
            <span class="product-views">Ilość wyświetleń produktu :  <b><?php echo $product['view_count']; ?> wyświetleń</b></span><br><br><br>
            <a href="/dRaczekProjekt/cart/add/<?php echo $product['id']; ?>" class="cartbtn">Dodaj do koszyka</a>
            <div class="server-info">
                <?php
                    if(isset($_SESSION['message'])){
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }
                ?>
            </div>
            <div class="info">
                <a href="#">Zobacz opcje płatności</a><br>
                <a href="#">Zobacz opcje dostawy</a><br>
            </div>
        </div>
        <div class="additional-info">
            <h2>Opis produktu</h2>
            <p class="product-description"><?php echo $product['description']; ?></p>
            <ul>
                <li>Rozmiar : <?php echo ProductSizeEnum::GetConstants()[$product['size']]; ?></li>
                <li>Kolor : <?php echo ProductColourEnum::GetConstants()[$product['colour']]; ?></li>
                <li>Płeć : <?php echo GenderEnum::GetConstants()[$product['gender']]; ?></li>
            </ul>
        </div>
    </main>
    <?php echo $data['footer']; ?>

    <script>
        var imgs = document.querySelectorAll(".imgs img");
        imgs.forEach(function(img, index) {
            img.addEventListener("click",()=>{
                document.querySelector(".main-img").setAttribute("src", img.getAttribute("src"));
            })
        });
    </script>
</body>
</html>