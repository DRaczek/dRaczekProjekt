<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <?php echo $data['styles']; ?>
    <link rel="stylesheet" href="/dRaczekProjekt/css/list.css">
    <style>
        main{
            margin: calc(var(--header-height) + 1%) 10%;    
            border: 1px solid lightgray;
            box-shadow: lightgray 5px 5px 5px, lightgray -5px 5px 5px;
            border-radius: 20px;
            padding: 20px;   
        }
        main form input, main form select{
            width:100%;
            height:100%;
            background-color:white;
            border: 1px solid lightgray;
            box-shadow: lightgray 5px 5px 5px, lightgray -5px 5px 5px;
            transition:0.3s;
        }
        main form input[type=submit]:hover{
            transform: scale(1.05);
        }
        main .switch{
            border: 1px solid lightgray;
            box-shadow: lightgray 5px 5px 5px, lightgray -5px 5px 5px;
            width: 100px;
            height: 50px;
            position: relative;
        }

        main .switch span{
            position: absolute;
            width: 50px;
            height: 50px;
            background-color: blue;
            top: 0;
            left:0;
            transition: 0.3s;
        }

        main .switch input[type=checkbox]{
            display: none;
        }

        main .switch input[type=checkbox]:checked + span{
        transform: translate(100%, 0);
        }

        main .switch .off, main .switch .on{
            position: absolute;
            transform: translate(-50%, -50%);
        }

        main .switch .off{
            top: 50%;
            left: 75%;
        }

        main .switch .on{
            top: 50%;
            left: 25%;
        }
        @media screen and (max-width:600px) {
            main {
                margin: calc(var(--header-height) + 1%) 1%;    
                padding:5px
            }
        }
    </style>
</head>
<body>
    <?php 
        $order = $data['order'];
    ?>
    <?php echo $data['header']; ?>
    <main>
        <form action="../send" method="post" enctype="multipart/form-data" class="list">
            <span class="caption">Czy firma</span>
            <span class="value">
               <input type="checkbox" name="is_company" <?php if($order['is_company']==true) echo "checked"; ?>>
            </span>
            <span class="caption">Imię</span>
            <span class="value"><input type="text" name="first_name" value="<?php echo $order['first_name']; ?>"></span>
            <span class="caption">Nazwisko</span>
            <span class="value"><input type="text" name="last_name"  value="<?php echo $order['last_name']; ?>"></span>
            <span class="caption">Ulica</span>
            <span class="value"><input type="text" name="street" value="<?php echo $order['street']; ?>"></span>
            <span class="caption">Numer domu</span>
            <span class="value"><input type="text" name="street_number" value="<?php echo $order['street_number']; ?>"></span>
            <span class="caption">Kod pocztowy</span>
            <span class="value"><input type="text" name="postal_code" value="<?php echo $order['postal_code']; ?>"></span>
            <span class="caption">Miejscowość</span>
            <span class="value"><input type="text" name="postal_city" value="<?php echo $order['postal_city']; ?>"></span>
            <span class="caption">Kraj</span>
            <span class="value"><input type="text" name="country" value="<?php echo $order['country']; ?>"></span>
            <span class="caption">NIP</span>
            <span class="value"><input type="text" name="nip" value="<?php echo $order['nip']; ?>"></span>
            <span class="caption">Nazwa przedsiębiorstwa</span>
            <span class="value"><input type="text" name="company_name"  value="<?php echo $order['company_name']; ?>"></span>
            <span class="caption">Sposób dostawy</span>
            <span class="value">
                <select name="delivery_id">
                    <?php foreach($data['delivery_methods'] as $method): ?>
                        <option value = "<?php echo $method['id']; ?>" <?php if($order['delivery_id']==$method['id'])echo "selected"; ?>><?php echo $method['name']; ?></option>
                    <?php endforeach; ?>
                </select> 
            </span>
            <span class="caption">Śledzenie zamówienia</span>
            <span class="value"><input type="text" name="delivery_tracking" value="<?php echo $order['delivery_tracking']; ?>"></span>
            <span class="caption">Sposób płatności</span>
            <span class="value">
                <select name="payment_method_id">
                    <?php foreach($data['payment_methods'] as $method): ?>
                        <option value = "<?php echo $method['id']; ?>" <?php if($order['payment_method_id']==$method['id'])echo "selected"; ?>><?php echo $method['name']; ?></option>
                    <?php endforeach; ?>
                </select> 
            </span>
            <span class="caption">Status płatności</span>
            <span class="value">
                <select name="payment_status">
                    <?php foreach(PaymentStatusEnum::GetConstants() as $key=>$value): ?>
                        <option value = "<?php echo $key; ?>" <?php if($order['payment_status']===$key)echo "selected"; ?>><?php echo $value; ?></option>
                    <?php endforeach; ?>
                </select> 
            </span>
            <span class="caption">Status zamówienia</span>
            <span class="value">
                <select name="order_status">
                    <?php foreach(OrderStatusEnum::GetConstants() as $key=>$value): ?>
                        <option value = "<?php echo $key; ?>" <?php if($order['order_status']===$key)echo "selected"; ?>><?php echo $value; ?></option>
                    <?php endforeach; ?>
                </select>
            </span>
            <span class="subtitle"><input type="submit" value="Edytuj zamówienie" name="submit"></span>
            <input type="hidden" name="id" value=<?php echo $data['id']; ?>>
        </form>
    </main>
    <?php echo $data['footer']; ?>
</body>
</html>