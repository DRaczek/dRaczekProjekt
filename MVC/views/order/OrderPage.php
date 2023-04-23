<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Strona zamówienia<br>
    <form action="../order/summary" method="post">
        Na firmę <input type="checkbox" name="is_company"><Br>
        Imię: <input type="text" name="first_name" required><br>
        Nazwisko: <input type="text" name="last_name" required><br>
        Ulica: <input type="text" name="street" required><br>
        Nr domu: <input type="number" name="street_number" required><br>
        Kod pocztowy : <input type="text" name="postal_code" required><Br>
        Miejscowość : <input type="text" name="postal_city" required><Br>
        Kraj : <select name="country" required>
            <option value="PL">Polska</option>
            <option value="DE">Niemcy</option>
            <option value="UK">Wielka Brytania</option>
        </select><Br>
        Nip: <input type="text" name="nip"><br>
        Nazwa przedsiębiorstwa: <input type="text" name="company_name"><br>
        Dostawa : <select name="delivery_id">
            <?php foreach($deliveryMethods as $method): ?>
                <option value="<?php echo $method['id']; ?>"><?php echo $method['name']."(+".$method['price']."PLN)";?></option>
            <?php endforeach; ?>
        </select><br>
        Płatność : <select name="payment_method_id">
            <?php foreach($paymentMethods as $method): ?>
                <option value="<?php echo $method['id']; ?>"><?php echo $method['name'];?></option>
            <?php endforeach; ?>
        </select><br>
        <input type="submit" value="Przejdź do podsumowania zamówienia" name="submit">
    </form>
    <?php
        if(isset($_SESSION['message'])){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
    ?>
</body>
</html>