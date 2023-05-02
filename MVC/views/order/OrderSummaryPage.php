<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php echo $data['styles']; ?>
    <link rel="stylesheet" href="/dRaczekProjekt/css/orderSummary.css">
</head>
<body>
    <?php
        $summary = $data['summary'];
        $koszyk = $data['cart'];
        $delivery = $data['delivery'];
        $paymentMethodName = $data['paymentMethodName'];
    ?>

    <?php echo $data['header']; ?>
    <main>
        <div class="steps">
            <div class="step active">Twój koszyk</div>
            <div class="step active">Dostawa i płatność</div>
            <div class="step active">Podsumowanie</div>
        </div>
        <div class="items">
            <?php
                foreach($koszyk as $produkt){
            ?>
               <div class="item">
                    <input type="hidden" name="cart_position_id" value="<?php echo $produkt['id']; ?>">
                    <img src="/dRaczekProjekt/<?php echo $produkt['image_path']; ?>" alt="obrazek przedmiotu" width="100" height="100">
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
                        <span class="product-quantity">Ilość : <?php echo $produkt['quantity']; ?></span>
                    </div>
                </div>
            <?php
                }
            ?>
        </div>
        <div class="preferences">
            <span>Wybrany sposób dostawy</span><span> <?php echo $delivery['name']; ?></span>
            <span>Wybrany sposób płatnośći</span><span><?php echo $paymentMethodName; ?></span>
            <span>Cena przedmiotów</span><span><?php echo $summary."PLN"; ?></span>
            <span>Dostawa</span><span><?php echo $delivery['price']."PLN"; ?></span>
            <span class="total">Cena końcowa</span><span class="total"><?php echo ($summary+$delivery['price'])."PLN"; ?></span>
        </div>
        <div class="data">
            <div class="card">
                <h3>Dane do dostawy</h3>
                <?php echo $_POST['first_name']." ".$_POST['last_name']; ?><Br>
                <?php echo $_POST['postal_code']." ".$_POST['postal_city']; ?><Br>
                <?php echo $_POST['street']." ".$_POST['street_number']; ?><br>
                <?php echo $_POST['country']; ?><br>
            </div>
            <?php if(isset($_POST['is_company']) && $_POST['is_company']==="on"): ?>
                <div class="card">
                    <h3>Dane przedsiębiorstwa</h3>
                    Nazwa firmy : <?php echo $_POST['company_name']; ?><br>
                    NIP : <?php echo $_POST['nip']; ?><br>
                </div>
            <?php endif; ?>
        </div>

        <form action="../order/submit" method="post">
            <?php foreach($_POST as $key => $value): ?>
                <input type="hidden" name="<?php echo $key; ?>" value = "<?php echo $value; ?>">
            <?php endforeach; ?>
            <input type="submit" value="Złóż zamówienie">
        </form>
    </main>
    <?php echo $data['footer']; ?>

</body>
</html>