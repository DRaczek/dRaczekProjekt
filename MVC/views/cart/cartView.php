<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <?php echo $data['styles'] ?>
    <link rel="stylesheet" href="/dRaczekProjekt/css/cart.css">
    <link rel="stylesheet" href="/dRaczekProjekt/css/steps.css">
</head>
<body>
    <?php
        $koszyk = $data['cart'];
        $summary = $data['summary'];
    ?>
    <?php echo $data['header']; ?>
    <main>
        <div class = "content">
            <div class="steps">
                <div class="step active">Twój koszyk</div>
                <div class="step">Dostawa i płatność</div>
                <div class="step">Podsumowanie</div>
            </div>

            <?php
                foreach($koszyk as $produkt){
            ?>
                <div class="item">
                    <input type="hidden" name="cart_position_id" value="<?php echo $produkt['id']; ?>">
                    <a href="/dRaczekProjekt/products/<?php echo $produkt['productId']; ?>">
                        <img src="/dRaczekProjekt/<?php echo $produkt['image_path']; ?>" alt="obrazek przedmiotu" width="100" height="100">
                    </a>
                    <p class="product-name"><?php
                        echo $produkt['name'];
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
                        <button onclick="decrease(<?php echo $produkt['id']; ?>)"> - </button>
                        <span class="product-quantity"><?php echo $produkt['quantity']; ?></span>
                        <button onclick="increase(<?php echo $produkt['id']; ?>)"> + </button>
                    </div>
                    <a href = "cart/delete/<?php echo $produkt['id']; ?>">
                        <img src="/dRaczekProjekt/img/delete-icon.svg">
                    </a>
                </div>
            <?php
                }
            ?>
        </div>

        <div class="menu">
            <div class ="summary">
                <div id = "price">Wartość produktów <span id="total"><?php echo $summary ?>PLN<span></div>
                <a href="order/data" class="order-button">Złóż zamówienie</a>
            </div>
            <?php
                if(isset($_SESSION['message'])){
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
            ?>
        <div>

    </main>
    <?php echo $data['footer']; ?>
    

    <script>
        function decrease(id) {
            let itemElement = event.target;
            while(!itemElement.classList.contains("item")){
                itemElement=itemElement.parentElement;
            }

            let quantityField = itemElement.querySelector(".product-quantity");
            let priceField = itemElement.querySelector(".price");
            let unitPrice = parseFloat(itemElement.querySelector(".priceUnit").textContent);
            let quantity = parseInt(quantityField.textContent);
            if (quantity > 1) {
                quantity--;
                document.querySelector("#total").textContent = (parseFloat(document.querySelector("#total").textContent) - unitPrice).toFixed(2) + "PLN";
                updateQuantity(quantity, id, quantityField, priceField, unitPrice);
            }
        }

        function increase(id) {
            let itemElement = event.target;
            while(!itemElement.classList.contains("item")){
                itemElement=itemElement.parentElement;
            }
            let quantityField = itemElement.querySelector(".product-quantity");
            let priceField = itemElement.querySelector(".price");
            let unitPrice = parseFloat(itemElement.querySelector(".priceUnit").textContent);
            let quantity = parseInt(quantityField.textContent);
            quantity++;
            document.querySelector("#total").textContent = (parseFloat(document.querySelector("#total").textContent) + unitPrice).toFixed(2) + "PLN";
            updateQuantity(quantity, id, quantityField, priceField, unitPrice);
        }

        function updateQuantity(quantity, id, quantityField, priceField, unitPrice) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                // 4  - DONE
                if (this.readyState == 4 && this.status == 200) {
                    quantityField.textContent = quantity;
                    console.log(priceField);
                    priceField.textContent = (quantity * unitPrice).toFixed(2);
                }
            };
            xhttp.open('POST', '/dRaczekProjekt/cart/update', true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            let data = "quantity=" + quantity + "&id=" + id;
            xhttp.send(data);
        }
    </script>
</body>
</html>