<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <?php echo $data['styles']; ?>
    <link rel="stylesheet" href="/dRaczekProjekt/css/orderList.css">
</head>
<body>    
    <?php echo $data['header']; ?>
    <main>
        <h1>Złożone zamówienia</h1>
        <div class="items">
            <?php foreach($data['orders'] as $order): ?>
                <a class="item" href="/dRaczekProjekt/order/<?php echo $order['id']; ?>">
                    <h3>Zamówienie <span><?php echo $order['id']; ?></span></h3>
                    <span>Data złożenia zamówienia : <span><?php echo $order['created_date']; ?></span></span>
                    <span>Status zamówienia : <span><?php echo OrderStatusEnum::GetConstants()[$order['order_status']]; ?></span></span>
                    <span>Status płatności : <span><?php echo PaymentStatusEnum::GetConstants()[$order['payment_status']]; ?></span></span>
                </a>
            <?php endforeach; ?>
        </div>  
    </main>
    <?php echo $data['footer']; ?>
</body>
</html>