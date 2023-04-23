<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .item{
            display:flex;
            flex-direction:row;
            align-items:center;
        }
        .item *{
            padding:20px;
        }
    </style>
</head>
<body>
    <?php
        foreach($koszyk as $produkt){
    ?>
        <div class="item">
            <input type="hidden" name="cart_position_id" value="<?php echo $produkt['id']; ?>">
            <img src="/dRaczekProjekt/<?php echo $produkt['image_path']; ?>" alt="obrazek przedmiotu" width="100" height="100">
            <p><?php
                echo $produkt['name'];
            ?><p>
            <p class="quantity">
                <?php
                    echo $produkt['quantity'];
                ?>
            </p>
            <p class="priceUnit">
                <?php
                    echo $produkt['price'];
                ?>
            </p>
            <p class="price">
                <?php
                    echo ((float)$produkt['price']*(float)$produkt['quantity']);
                ?>
            </p>
            <button onclick="decrease(<?php echo $produkt['id']; ?>)"> - </button>
            <button onclick="increase(<?php echo $produkt['id']; ?>)"> + </button>
            <a href = "cart/delete/<?php echo $produkt['id']; ?>">Usun</a>
        </div>
    

    

    <?php
        }
    ?>
    
    <div class ="summary">
        <div id = "price"><?php echo $summary ?></div>
    </div>

    <script>
        function decrease(id) {
            let quantityField = event.target.parentElement.querySelector(".quantity");
            let priceField = event.target.parentElement.querySelector(".price");
            let unitPrice = parseFloat(event.target.parentElement.querySelector(".priceUnit").textContent);
            let quantity = parseInt(quantityField.textContent);
            if (quantity > 1) {
                quantity--;
                document.querySelector("#price").textContent = parseFloat(document.querySelector("#price").textContent) - unitPrice;
                updateQuantity(quantity, id, quantityField, priceField, unitPrice);
            }
        }

        function increase(id) {
            let quantityField = event.target.parentElement.querySelector(".quantity");
            let priceField = event.target.parentElement.querySelector(".price");
            let unitPrice = parseFloat(event.target.parentElement.querySelector(".priceUnit").textContent);
            let quantity = parseInt(quantityField.textContent);
            quantity++;
            document.querySelector("#price").textContent = parseFloat(document.querySelector("#price").textContent) + unitPrice;
            updateQuantity(quantity, id, quantityField, priceField, unitPrice);
        }

        function updateQuantity(quantity, id, quantityField, priceField, unitPrice) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                // 4  - DONE
                if (this.readyState == 4 && this.status == 200) {
                    quantityField.textContent = quantity;
                    console.log(priceField);
                    priceField.textContent = quantity * unitPrice;
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