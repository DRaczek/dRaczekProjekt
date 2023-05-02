<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php echo $data['styles']; ?>
    <link rel="stylesheet" href="/dRaczekProjekt/css/orderView.css">
</head>
<body>
    <?php
        $order = $data['order'];
        $koszt = $data['koszt'];
    ?>
    <?php echo $data['header']; ?>
    <main>
        <?php
            if($order['order']['payment_status']==PaymentStatusEnum::UNPAID){
                if($order['order']['payment_method_id'] != 2){
                    echo "<h2><a href=\"../order/payment/".$order['order']['id']."\">Zapłać za zamówienie</a></h2>  ";
                }//czyli za pobraniem
            }
        ?>
        <div class="data">
            <span class="caption title">Zamówienie <?php echo $order['order']['id'] ?></span>
            <span class="caption subtitle">Dane do dostawy</span>
            <span class="caption">Imię</span><span class="value"><?php echo $order['order']['first_name']; ?></span>
            <span class="caption">Nazwisko</span><span class="value"><?php echo $order['order']['last_name']; ?></span>
            <span class="caption">Ulica</span><span class="value"><?php echo $order['order']['street']; ?></span>
            <span class="caption">Nr. Domu</span><span class="value"><?php echo $order['order']['street_number']; ?></span>
            <span class="caption">Kod Pocztowy</span><span class="value"><?php echo $order['order']['postal_code']; ?></span>
            <span class="caption">Miejscowość</span><span class="value"><?php echo $order['order']['postal_city']; ?></span>
            <span class="caption">Kraj</span><span class="value"><?php echo $order['order']['country']; ?></span>
            <?php if($order['order']['is_company']==true): ?>
                <span class="caption subtitle">Dane przedsiębiorstwa</span>
                <span class="caption">Nazwa</span><span class="value"><?php echo $order['order']['company_name']; ?></span>
                <span class="caption">NIP</span><span class="value"><?php echo $order['order']['nip']; ?></span>
            <?php endif; ?>
            <span class="caption subtitle">Dostawa i Płatność</span>
            <span class="caption">Sposób dostawy</span><span class="value"><?php echo $data['delivery']['name']; ?></span>
            <span class="caption">Koszt dostawy</span><span class="value"><?php echo $data['delivery']['price']; ?>PLN</span>
            <span class="caption">Śledzenie dostawy</span><span class="value"><?php echo $order['order']['delivery_tracking']; ?></span>
            <span class="caption">Sposób płatności</span><span class="value"><?php echo $data['paymentMethodName']; ?></span>
            <span class="caption">Status płatności</span><span class="value"><?php echo PaymentStatusEnum::GetConstants()[$order['order']['payment_status']]; ?></span>
            <span class="caption">Cena końcowa</span><span class="value"><?php echo $data['koszt']; ?>PLN</span>
            <span class="caption">Status zamówienia</span><span class="value"><?php echo OrderStatusEnum::GetConstants()[$order['order']['order_status']]; ?></span>
        </div>
        <div class="items">
            <?php foreach($order['products'] as $produkt): ?>
                <a class="item" href="/dRaczekProjekt/products/<?php echo $produkt['id']; ?>">
                    <img src="/dRaczekProjekt/<?php echo $produkt['image_path_1']; ?>" alt="obrazek przedmiotu" width="100" height="100">
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
                </a>
            <?php endforeach; ?>
        </div>
    </main>
    <?php echo $data['footer']; ?>
</body>
</html>