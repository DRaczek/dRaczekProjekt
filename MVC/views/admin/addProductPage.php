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
        @media screen and (max-width:600px) {
            main {
                margin: calc(var(--header-height) + 1%) 1%;    
                padding:5px
            }
        }
    </style>
</head>
<body>
    <?php $categories = $data['categories'] ?>
    <?php echo $data['header']; ?>
    <main>
        <form action="add/send" method="post" enctype="multipart/form-data" class="list">
            <span class="caption">Nazwa</span>
            <span class="value"><input type="text" name="name" id=""></span>
            <span class="caption">Kategoria</span>
            <span class="value">
                <select name="category">
                    <?php
                        foreach($categories as $category){
                            echo "<option value = \"".$category['name']."\">".$category['name']."</option>";
                        }
                    ?>  
                </select>
            </span>
            <span class="caption">Pierwsze zdjęcie produktu</span>
            <span class="value"><input type="file" name="image_1" required></span>
            <span class="caption">Drugie zdjęcie produktu</span>
            <span class="value"><input type="file" name="image_2"></span>
            <span class="caption">Trzecie zdjęcie produktu</span>
            <span class="value"><input type="file" name="image_3"></span>
            <span class="caption">Opis</span>
            <span class="value"><input type="text" name="description"></span>
            <span class="caption">Cena</span>
            <span class="value"><input type="number" name="price" step="0.01"></span>
            <span class="caption">Ilość</span>
            <span class="value"><input type="number" name="quantity"></span>
            <span class="caption">Rozmiar</span>
            <span class="value">
                <select name="size">
                    <?php
                        foreach (ProductSizeEnum::getConstants() as $constantName => $constantValue) {
                            echo "<option value=\"$constantName\">$constantValue</option>";
                        }
                    ?>
                </select>
            </span>
            <span class="caption">Kolor</span>
            <span class="value">
                <select name="colour">
                    <?php
                        foreach (ProductColourEnum::getConstants() as $constantName => $constantValue) {
                            echo "<option value=\"$constantName\">$constantValue</option>";
                        }
                    ?>
                </select>
            </span>
            <span class="caption">Płeć</span>
            <span class="value">
                <select name="gender">
                    <?php
                        foreach (GenderEnum::getConstants() as $constantName => $constantValue) {
                            echo "<option value=\"$constantName\">$constantValue</option>";
                        }
                    ?>
                </select>
            </span>
            <span class="subtitle">
                <input type="submit" value="Dodaj Produkt" name="submit">
            </span>
        </form>
        <?php
        if(isset($_SESSION['message'])){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
    ?>
    </main>
    <?php echo $data['footer']; ?>
   
</body>
</html>