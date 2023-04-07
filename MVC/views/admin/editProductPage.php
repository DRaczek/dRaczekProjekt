<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Strona do edycji produktu.<br>
    <form action="send" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        Podaj nazwę produktu: <input type="text" name="name" value="<?php echo $product['name']; ?>"><Br>
        Wybierz kategorię produktu: <select name="category">
            <?php
                foreach($categories as $category){
                    echo "<option value = \"".$category['name']."\"".(($product['category_id']===$category['id'])?"selected":"").">".$category['name']."</option>";
                }
            ?>  
        </select><Br>
        Podaj pierwsze zdjęcie produktu: <input type="file" name="image_1" required><Br>
        Podaj drugie zdjęcie produktu: <input type="file" name="image_2"><Br>
        Podaj trzecie zdjęcie produktu: <input type="file" name="image_3"><Br>
        Podaj opis produktu: <input type="text" name="description" value="<?php echo $product['description']; ?>"><br>
        Podaj cenę produku: <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>"><br>
        Podaj ilość produktu: <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>"><br>
        Podaj rozmiar produktu: <select name="size">
            <?php
                foreach (ProductSizeEnum::getConstants() as $constantName => $constantValue) {
                    echo "<option value=\"$constantName\"".(($product['size']==$constantName)?"selected":"").">$constantValue</option>";
                }
            ?>
        </select><br>
        Podaj kolor produktu: <select name="colour">
            <?php
                foreach (ProductColourEnum::getConstants() as $constantName => $constantValue) {
                    echo "<option value=\"$constantName\"".(($product['colour']==$constantName)?"selected":"").">$constantValue</option>";
                }
            ?>
        </select><br>
        <input type="submit" value="Edytuj Produkt" name="submit">
    </form>
    <?php
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
    ?>
</body>
</html>