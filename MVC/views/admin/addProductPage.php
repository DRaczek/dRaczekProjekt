<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Strona do dodawania produktów.
    <form action="add/send" method="post" enctype="multipart/form-data">
        Podaj nazwę produktu: <input type="text" name="name" id=""><Br>
        Wybierz kategorię produktu: <select name="category">
            <?php
                foreach($categories as $category){
                    echo "<option value = \"".$category['name']."\">".$category['name']."</option>";
                }
            ?>  
        </select><Br>
        Podaj pierwsze zdjęcie produktu: <input type="file" name="image_1" required><Br>
        Podaj drugie zdjęcie produktu: <input type="file" name="image_2"><Br>
        Podaj trzecie zdjęcie produktu: <input type="file" name="image_3"><Br>
        Podaj opis produktu: <input type="text" name="description"><br>
        Podaj cenę produku: <input type="number" name="price" step="0.01"><br>
        Podaj ilość produktu: <input type="number" name="quantity"><br>
        Podaj rozmiar produktu: <select name="size">
            <?php
                foreach (ProductSizeEnum::getConstants() as $constantName => $constantValue) {
                    echo "<option value=\"$constantName\">$constantValue</option>";
                }
            ?>
        </select><br>
        Podaj kolor produktu: <select name="colour">
            <?php
                foreach (ProductColourEnum::getConstants() as $constantName => $constantValue) {
                    echo "<option value=\"$constantName\">$constantValue</option>";
                }
            ?>
        </select><br>
        Podaj płeć: <select name="gender">
            <?php
                foreach (GenderEnum::getConstants() as $constantName => $constantValue) {
                    echo "<option value=\"$constantName\">$constantValue</option>";
                }
            ?>
        </select><br>
        <input type="submit" value="Dodaj Produkt" name="submit">
    </form>
    <?php
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
    ?>
</body>
</html>