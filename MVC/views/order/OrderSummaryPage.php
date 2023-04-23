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
    Strona podsumowania zamówienia
    <div class="items">
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
            </div>
        <?php
            }
        ?>
        <p class="delivery">
            Wybrany sposób dostawy : <?php echo $delivery['name']; ?><Br>
            Cena wybranego sposoby dostawy : <?php echo $paymentMethodName; ?>
        </p>
        <p class="summary">
            Cena przedmiotów : <?php echo $summary."PLN"; ?><Br>
            + Dostawa : <?php echo $delivery['price']."PLN"; ?><br>
            Cena końcowa <?php echo ($summary+$delivery['price'])."PLN"; ?>: 
        </p>
    </div>

    <div class="data">
        <h3>Dane do dostawy</h3>
        <?php echo $_POST['first_name']." ".$_POST['last_name']; ?><Br>
        <?php echo $_POST['postal_code']." ".$_POST['postal_city']; ?><Br>
        <?php echo $_POST['street']." ".$_POST['street_number']; ?><br>
        <?php echo $_POST['country']; ?><br>

        
        <?php if(isset($_POST['is_company']) && $_POST['is_company']==="on"): ?>
            <h3>Dane przedsiębiorstwa</h3>
            Nazwa firmy : <?php echo $_POST['company_name']; ?><br>
            NIP : <?php echo $_POST['nip']; ?><br>
        <?php endif; ?>
    </div>

    <form action="../order/submit" method="post">
        <?php foreach($_POST as $key => $value): ?>
            <input type="hidden" name="<?php echo $key; ?>" value = "<?php echo $value; ?>">
        <?php endforeach; ?>
        <input type="submit" value="Złóż zamówienie">
    </form>
    
</body>
</html>