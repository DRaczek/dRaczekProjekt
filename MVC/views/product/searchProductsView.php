<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <?php echo $data['styles']; ?>
    <link rel="stylesheet" href="/dRaczekProjekt/css/searchProducts.css">
</head>
<body>
    <?php echo $data['header']; ?>
    <main>
       <form class="filter" action="/dRaczekProjekt/products" method="get">
            <input type="hidden" name="page" value="1">
            <input type="hidden" name="size" value="20">
            <input type="hidden" name="text" value="<?php if(isset($_GET['text']))echo $_GET['text']; else echo ""; ?>">
            <h2>Kategorie</h2>
            <hr>
            <select name="categoryId">
                <option value="999">Wszystkie</option>
                <?php foreach($data['categories'] as $category): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <h2>Sortowanie</h2>
            <select name="orderBy">
                <?php foreach($data['orderByTable'] as $key=>$value):?>
                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php endforeach; ?>
            </select>
            <select name="order">
                <option value="asc">Rosnąco</option>
                <option value="desc">Malejąco</option>
            </select>
            <h2>Płeć</h2>
            <input type="radio" name="gender" value="999" checked>Wszystkie<br>
                    <?php
                        foreach(GenderEnum::GetConstants() as $key => $value){
                            echo "<input type=\"radio\" value=\"$key\" name=\"gender\">$value<br>";
                        }
                    ?>
            <hr>
            <h3>Cena</h3>
            <hr>
            Przedział cenowy<br>
            <section class="przedzial">
                <input type="number" name="price_from">
                <input type="number" name="price_to">
            </section>
            <hr>
            <h2>Rozmiar</h2>
            <input type="radio" name="productSize" value="999" checked>Wszystkie<br>
                    <?php
                        foreach(ProductSizeEnum::GetConstants() as $key => $value){
                            echo "<input type=\"radio\" value=\"$key\" name=\"productSize\">$value<br>";
                        }
                    ?>
            <hr>
            <h2>Kolor</h2>
            <input type="radio" name="colour" value="999" checked>Wszystkie<br>
                    <?php
                        foreach(ProductColourEnum::GetConstants() as $key => $value){
                            echo "<input type=\"radio\" value=\"$key\" name=\"colour\">$value<br>";
                        }
                    ?>
            <hr>
            <input type="submit" value="Filtruj" name="submit">
        </form>
       <div class="results">
            <div class="pages">
                <?php
                    if($data['page']>1){
                        echo "<a href=\"/dRaczekProjekt/products?page=".($data['page']-1)."&size=".$data['pageSize'].$data['pageable'];
                        echo "\"><</a>";
                    }
                    echo $data['page'];
                    if($data['page']*$data['pageSize'] < $data['products_count']){
                        echo "<a href=\"/dRaczekProjekt/products?page=".($data['page']+1)."&size=".$data['pageSize'].$data['pageable'];
                        echo "\">></a>";
                    }
                ?>
            </div>
           

            <?php foreach($data['products'] as $product): ?>
                <a class="product" href="/dRaczekProjekt/products/<?php echo $product['id']; ?>">
                    <div class="img-wrapper">
                        <img src="/dRaczekProjekt/<?php echo $product['image_path_1']; ?>">
                    </div>
                    <div class="main-info">
                        <span class="product-name"><?php echo $product['name']; ?></span>
                        <span class="product-price"><?php echo $product['price']."PLN"; ?></span>
                        <span class="product-views"><?php echo "Ilość wyświetleń : ".$product['view_count']; ?></span>
                        <span class="product-quantity"><?php echo "Dostępna ilość : ".$product['quantity']; ?></span>
                    </div>
                    <div class="additional-info">
                        <ul>
                            <li>Płeć : <?php echo GenderEnum::GetConstants()[$product['gender']]; ?></li>
                            <li>Rozmiar : <?php echo ProductSizeEnum::GetConstants()[$product['size']]; ?></li>
                            <li>Kolor : <?php echo ProductColourEnum::GetConstants()[$product['colour']]; ?></li>
                        </ul>
                    </div>
                </a>
            <?php endforeach; ?>

            <div class="pages">
                <?php
                    if($data['page']>1){
                        echo "<a href=\"/dRaczekProjekt/products?page=".($data['page']-1)."&size=".$data['pageSize'].$data['pageable'];
                        echo "\"><</a>";
                    }
                    echo $data['page'];
                    if($data['page']*$data['pageSize'] < $data['products_count']){
                        echo "<a href=\"/dRaczekProjekt/products?page=".($data['page']+1)."&size=".$data['pageSize'].$data['pageable'];
                        echo "\">></a>";
                    }
                ?>
            </div>
       </div>
    </main>
    <?php echo $data['footer']; ?>

    <script>
                document.querySelector(".filter input[name=submit]").addEventListener("click", submitForm);
                function submitForm(event) {
                    event.preventDefault(); // Zapobieganie domyślnej akcji wysłania formularza
                    var form = document.querySelector(".filter");
                    let inputs = [];
                    console.log(inputs);
                    inputs.push(form.querySelector("input[name=page]"));
                    inputs.push(form.querySelector("input[name=size]"));
                    inputs.push(form.querySelector("input[name=text]"));
                    inputs.push(form.querySelector("select[name=categoryId]"));
                    inputs.push(getRadioValue("gender"));
                    inputs.push(form.querySelector("input[name=price_from]"));
                    inputs.push(form.querySelector("input[name=price_to]"));
                    inputs.push(getRadioValue("productSize"));
                    inputs.push(getRadioValue("colour"));
                    inputs.push(form.querySelector("select[name=orderBy]"));
                    inputs.push(form.querySelector("select[name=order]"));
                    var queryString = "";

                    // Pobieranie wartości wprowadzonych przez użytkownika i tworzenie ciągu zapytania
                    // jezeli pole jest puste, to nie jest przesyłane
                    for (var i = 0; i < inputs.length; i++) {
                        if (inputs[i].value !== "" && inputs[i].name !== "submit") {
                            if (queryString !== "") {
                                queryString += "&"; 
                            }
                            queryString += inputs[i].name + "=" + encodeURIComponent(inputs[i].value);
                        }
                    }

                    // Przekierowanie do nowego adresu URL z użyciem tylko uzupełnionych pól
                    window.location.href = form.action + "?" + queryString;
                }

                function getRadioValue(name){
                    let inputs = document.querySelectorAll(".filter input[name="+name+"]");
                    for(let i=0; i<inputs.length; i++){
                        if(inputs[i].checked==true)return inputs[i];
                    }
                }
            </script>
</body>
</html>