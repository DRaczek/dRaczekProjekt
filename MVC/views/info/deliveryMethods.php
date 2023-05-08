<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <?php echo $data['styles']; ?>
    <style>
        main{
            margin: calc(var(--header-height) + 1%) 10%;
            border: 1px solid lightgray;
            box-shadow: lightgray 5px 5px 5px,lightgray -5px 5px 5px;
            padding:10px
        }
        main .grid{
            display:grid;
            text-align:center;
            grid-template-columns: 1fr 1fr;
        }
        main .grid > *{
            border: 1px solid black;
            border-collapse:collapse;
            padding:30px;
        }
        main .grid > .header{
            font-weight:600;
            font-size:22px;
        }
        @media screen and (max-width:600px) {
            main{
                margin: calc(var(--header-height) + 1%) 1%;
            }
        }
        @media screen and (max-width:400px) {
            main .grid > *{
                padding: 30px 5px ; 
            }
        }
    </style>
</head>
<body>
    <?php echo $data['header']; ?>
    <main>
        <div class="grid">
            <div class="header">
                Sposób dostawy
            </div>
            <div class="header">
                Cena
            </div>
            <?php foreach($data['delivery_methods'] as $method): ?>
                <div class="value">
                    <?php echo $method['name']; ?>
                </div>
                <div class="value">
                    <?php echo $method['price']." PLN"; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <?php echo $data['footer']; ?>
</body>
</html>