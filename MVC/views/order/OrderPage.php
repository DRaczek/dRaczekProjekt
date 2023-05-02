<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php echo $data['styles']; ?>
    <link rel="stylesheet" href="/dRaczekProjekt/css/orderForm.css">
</head>
<body>
    <?php
        $deliveryMethods = $data['deliveryMethods'];
        $paymentMethods = $data['paymentMethods'];
    ?>

    <?php echo $data['header']; ?>

    <main>
        <div class="steps">
            <div class="step active">Twój koszyk</div>
            <div class="step active">Dostawa i płatność</div>
            <div class="step">Podsumowanie</div>
        </div>
        <form action="../order/summary" method="post" class="order">
            <span class="caption">Na firmę</span>
            <label class="switch" for="is_company">
                <a class="on">ON</a>
                <a class="off">OFF</a>
                <input type="checkbox" name="is_company" id="is_company">
                <span class="slider"></span>
            </label>
            <hr>
            <span class="caption">Imię</span> <input type="text" name="first_name" required>
            <hr>
            <span class="caption">Nazwisko</span> <input type="text" name="last_name" required>
            <hr>
            <span class="caption">Ulica</span> <input type="text" name="street" required>
            <hr>
            <span class="caption">Nr domu</span> <input type="number" name="street_number" required>
            <hr>
            <span class="caption">Kod pocztowy</span> <input type="text" name="postal_code" required>
            <hr>
            <span class="caption">Miejscowość</span> <input type="text" name="postal_city" required>
            <hr>
            <span class="caption">Kraj</span> <select name="country" required>
                <option value="PL">Polska</option>
                <option value="DE">Niemcy</option>
                <option value="UK">Wielka Brytania</option>
            </select>
            <hr>
            <span class="caption">Nip</span> <input type="text" name="nip">
            <hr>
            <span class="caption">Nazwa przedsiębiorstwa</span> <input type="text" name="company_name">
            <hr>
            <span class="caption">Dostawa</span> <select name="delivery_id">
                <?php foreach($deliveryMethods as $method): ?>
                    <option value="<?php echo $method['id']; ?>"><?php echo $method['name']."(+".$method['price']."PLN)";?></option>
                <?php endforeach; ?>
            </select>
            <hr>
            <span class="caption">Płatność</span> <select name="payment_method_id">
                <?php foreach($paymentMethods as $method): ?>
                    <option value="<?php echo $method['id']; ?>"><?php echo $method['name'];?></option>
                <?php endforeach; ?>
            </select>
            <hr>
            <input type="submit" value="Przejdź do podsumowania zamówienia" name="submit">

            <?php
                if(isset($_SESSION['message'])){
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
            ?>
        </form>
  
    </main>
    <?php echo $data['footer']; ?>
   
</body>
</html>