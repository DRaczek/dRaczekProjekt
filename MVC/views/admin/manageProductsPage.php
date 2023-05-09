<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <?php echo $data['styles']; ?>
    <link rel="stylesheet" href="/dRaczekProjekt/css/adminItems.css"> 
    <link rel="stylesheet" href="/dRaczekProjekt/css/adminFilter.css"> 
    <!-- Używam tutaj takich samych styli dla przycisku do dodawania -->
    <link rel="stylesheet" href="/dRaczekProjekt/css/adminManageCategories.css">  
</head>
<body>
    <?php
            $page = $data['filter']['page'];
            $pageSize = $data['filter']['pageSize'];
            $name = $data['filter']['name'];
            $categoryId = $data['filter']['categoryId'];
            $description = $data['filter']['description'];
            $priceFrom = $data['filter']['priceFrom'];
            $priceTo = $data['filter']['priceTo'];
            $quantityFrom = $data['filter']['quantityFrom'];
            $quantityTo = $data['filter']['quantityTo'];
            $productSize = $data['filter']['productSize'];
            $colour = $data['filter']['colour'];
            $viewCountFrom = $data['filter']['viewCountFrom'] ;
            $viewCountTo = $data['filter']['viewCountTo'];
            $status = $data['filter']['status'];
            $createdDate = $data['filter']['createdDate'];
            $orderBy = $data['filter']['orderBy'] ;
            $order = $data['filter']['order'];
            $id = $data['filter']['id'];
            $gender = $data['filter']['gender'];

            $result = $data['result'];
            $resultCount  = $data['resultCount'];
            $categories = $data['categories'];
    ?>
    <?php echo $data['header']; ?>
    <main>

        <?php
            if(isset($_SESSION['message'])){
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
        ?>
            <br>
            <a href="/dRaczekProjekt/admin/manage/products/add" id="addLink">
                <img src="/dRaczekProjekt/img/add-icon.svg">
            </a>

            <div class="filter-wrapper">
                    <button class="toggle" onclick = "toggleForm(event)">
                        <img src="/dRaczekProjekt/img/filter.svg">
                    </button>
                    <h3>Filtr</h3>
                    <form action="/dRaczekProjekt/admin/manage/products" method="get" id="filterForm" class="hide"> 
                        <input type="hidden" name="page" value = <?php echo $page; ?>>
                        <input type="hidden" name="size" value = <?php echo $pageSize; ?>>
                        Nazwa:<input type="text" name="name" <?php echo "value=\"$name\""; ?>>
                        Kategoria:<select name="categoryId">
                            <option value="999">ALL</option>
                        <?php
                            foreach($categories as $category){
                                echo "<option value = \"".$category['id']."\"".(($categoryId==$category['id'])?"selected":"").">".$category['name']."</option>";
                            }
                        ?>  
                        </select>
                        Opis: <input type="text" name="description" value="<?php echo $description;?>">
                        Cena od: <input type="number" name="priceFrom" step="0.01" value="<?php echo $priceFrom?>">
                        Cena do: <input type="number" name="priceTo" step="0.01" value="<?php echo $priceTo?>">
                        Ilość od: <input type="number" name="quantityFrom" value="<?php echo $quantityFrom?>">
                        Ilość do: <input type="number" name="quantityTo" value="<?php echo $quantityTo?>">
                        Rozmiar:<select name="productSize">
                            <option value="999">ALL</option>
                        <?php
                            foreach (ProductSizeEnum::getConstants() as $constantName => $constantValue) {
                                echo "<option value=\"$constantName\"".(($productSize===$constantName)?"selected":"").">$constantValue</option>";
                            }
                        ?>
                        </select>
                        Kolor:<select name="colour">
                            <option value="999">ALL</option>
                        <?php
                            foreach (ProductColourEnum::getConstants() as $constantName => $constantValue) {
                                echo "<option value=\"$constantName\"".(($colour===$constantName)?"selected":"").">$constantValue</option>";
                            }
                        ?>
                        </select>
                        Płeć:<select name="gender">
                            <option value="999">ALL</option>
                        <?php
                            foreach (GenderEnum::getConstants() as $constantName => $constantValue) {
                                echo "<option value=\"$constantName\"".(($colour===$constantName)?"selected":"").">$constantValue</option>";
                            }
                        ?>
                        </select>
                        Ilość wyświetleń od: <input type="number" name="viewCountFrom" value="<?php echo $viewCountFrom?>">
                        Ilość wyświetleń do: <input type="number" name="viewCountTo" value="<?php echo $viewCountTo?>">
                        Status: <select name="status">
                            <option value="999" <?php if($status==null)echo "selected";?>>ALL</option>
                            <option value="0" <?php if($status===0)echo "selected";?>>INACTIVE</option>
                            <option value="1" <?php if($status===1)echo "selected";?>>ACTIVE</option>
                            <option value="2" <?php if($status===2)echo "selected";?>>SUSPENDED</option>
                        </select> 
                        Created date:<input type="date" name="createdDate" <?php echo "value=\"$createdDate\""; ?>>
                        Id:<input type="text" name="id" <?php echo "value=\"$id\""; ?>>
                        Sortowanie : 
                        <select name="orderBy">
                            <option value="created_date" <?php if($orderBy=="created_date")echo "selected";?>>Data utworzenia</option>
                            <option value="id" <?php if($orderBy=="id")echo "selected";?>>Id</option>
                            <option value="categoryId" <?php if($orderBy=="categoryId")echo "selected";?>>Id kategorii</option>
                            <option value="description" <?php if($orderBy=="description")echo "selected";?>>Opis</option>
                            <option value="price" <?php if($orderBy=="price")echo "selected";?>>Cena</option>
                            <option value="quantity" <?php if($orderBy=="quantity")echo "selected";?>>Ilość</option>
                            <option value="size" <?php if($orderBy=="size")echo "selected";?>>Rozmiar</option>
                            <option value="colour" <?php if($orderBy=="colour")echo "selected";?>>Kolor</option>
                            <option value="view_count" <?php if($orderBy=="view_count")echo "selected";?>>Ilość wyświetleń</option>
                            <option value="status" <?php if($orderBy=="status")echo "selected";?>>Status</option>
                        </select>
                        <select name="order">
                            <option value="desc" <?php if($order=="desc")echo "selected";?>>Malejąco</option>
                            <option value="asc" <?php if($order=="asc")echo "selected";?>>Rosnąco</option>
                        </select>
                        <input type="submit" name="submit" value="Szukaj">
                        <a href="/dRaczekProjekt/admin/manage/products">Wyczyść filtry</a>
                    </form>
            </div>
                    
        <div>
            <?php
                    if(isset($_SESSION['message'])){
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }

                    if($result===null || count($result)===0){
                        echo "Nie znalezniono wyników";
                    }
                    else{
                        echo "Znaleziono : $resultCount pasujących wyników.";
                ?>

                <div class="items">
                <?php foreach($result as $row): ?>
                    <div class="item">
                        <a class="caption" alt="Id">
                            <span>
                                Id
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['id'] ?>">
                            <span>
                                <?php echo $row['id'] ?>
                            </span>
                        </a>
                        <a class="caption" alt="Nazwa">
                            <span>
                                Nazwa
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['name'];?>">
                            <span>
                                <?php echo $row['name'] ?>
                            </span>
                        </a>

                        <a class="caption" alt="Id Kategorii">
                            <span>
                            Id Kategorii
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['category_id'];?>">
                            <span>
                                <?php echo $row['category_id'] ?>
                            </span>
                        </a>
                        <a class="caption" alt="Nazwa Kategorii">
                            <span>
                            Nazwa Kategorii
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['category_name'];?>">
                            <span>
                                <?php echo $row['category_name'] ?>
                            </span>
                        </a>
                        <a class="caption" alt="Pierwsze zdjęcie produktu">
                            <span>
                                Zdjęcie 1
                            </span>
                        </a>
                        <a class="value img" alt="Pierwsze zdjęcie produktu">
                            <img src="/dRaczekProjekt/<?php echo $row['image_path_1']; ?>">
                        </a>
                        <a class="caption" alt="Drugie zdjęcie produktu">
                            <span>
                                Zdjęcie 2
                            </span>
                        </a>
                        <a class="value img" alt="Drugie zdjęcie produktu">
                            <img src="/dRaczekProjekt/<?php echo $row['image_path_2']; ?>">
                        </a>
                        <a class="caption" alt="Trzecie zdjęcie produktu">
                            <span>
                                Zdjęcie 3
                            </span>
                        </a>
                        <a class="value img" alt="Trzecie zdjęcie produktu">
                            <img src="/dRaczekProjekt/<?php echo $row['image_path_3']; ?>">
                        </a>
                        <a class="caption" alt="Opis">
                            <span>
                            Opis
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['description'];?>">
                            <span>
                                <?php echo $row['description'] ?>
                            </span>
                        </a> 
                        <a class="caption" alt="Cena">
                            <span>
                            Cena
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['price'];?>">
                            <span>
                                <?php echo $row['price'] ?>
                            </span>
                        </a> 
                        <a class="caption" alt="Ilość">
                            <span>
                            Ilość
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['quantity'];?>">
                            <span>
                                <?php echo $row['quantity'] ?>
                            </span>
                        </a> 
                        <a class="caption" alt="Rozmiar">
                            <span>
                            Rozmiar
                            </span>
                        </a>
                        <a class="value" alt=" <?php echo ProductSizeEnum::GetConstants()[$row['size']];?>">
                            <span>
                                <?php echo ProductSizeEnum::GetConstants()[$row['size']]; ?>
                            </span>
                        </a> 
                        <a class="caption" alt="Kolor">
                            <span>
                            Kolor
                            </span>
                        </a>
                        <a class="value" alt=" <?php echo ProductColourEnum::GetConstants()[$row['colour']];?>">
                            <span>
                                <?php echo ProductColourEnum::GetConstants()[$row['colour']]; ?>
                            </span>
                        </a> 
                        <a class="caption" alt="Płeć">
                            <span>
                            Płeć
                            </span>
                        </a>
                        <a class="value" alt=" <?php echo GenderEnum::GetConstants()[$row['gender']];?>">
                            <span>
                                <?php echo GenderEnum::GetConstants()[$row['gender']]; ?>
                            </span>
                        </a> 
                        <a class="caption" alt="Wyświetlenia">
                            <span>
                            Wyświetlenia
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['view_count'];?>">
                            <span>
                                <?php echo $row['view_count'] ?>
                            </span>
                        </a>
                        <a class="caption" alt="Status">
                            <span>
                                Status
                            </span>
                        </a>
                        <a class="value" alt="<?php echo StatusEnum::GetConstants()[$row['status']] ?>">
                            <span>
                                <?php echo StatusEnum::GetConstants()[$row['status']] ?>
                            </span>
                        </a>
                        <a class="caption" alt="Data Utworzenia">
                            <span>
                                Data Utworzenia
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['created_date'] ?>">
                            <span>
                                <?php echo $row['created_date'] ?>
                            </span>
                        </a>
                        <span class="option ban">
                            <a href="/dRaczekProjekt/admin/manage/products/suspend/<?php echo $row['id']?>">Zbanuj</a>
                        </span>
                        <span class="option act">
                            <a href="/dRaczekProjekt/admin/manage/products/activate/<?php echo $row['id']?>">Odbanuj</a>
                        </span>
                        <span class="option ban">
                            <a href="/dRaczekProjekt/admin/manage/products/delete/<?php echo $row['id']?>">Usuń</a>
                        </span>
                        <span class="option edit">
                            <a href="/dRaczekProjekt/admin/manage/products/edit/form/<?php echo $row['id']?>">Edytuj</a>
                        </span>
                        
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="pages">
                <?php
                    if($page>1){
                        echo "<a href=\"/dRaczekProjekt/admin/manage/products?page=".($page-1)."&size=$pageSize";
                        if($name!==null)echo "&name=$name";
                        if($categoryId!==null)echo "&categoryId=$categoryId";
                        if($description!==null)echo "&description=$description";
                        if($priceFrom!==null)echo "&priceFrom=$priceFrom";
                        if($priceTo!==null)echo "&priceTo=$priceTo";
                        if($quantityFrom!==null)echo "&quantityFrom=$quantityFrom";
                        if($quantityTo!==null)echo "&quantityTo=$quantityTo";
                        if($productSize!==null)echo "&productSize=$productSize";
                        if($colour!==null)echo "&colour=$colour";
                        if($gender!==null)echo "&gender=$gender";
                        if($viewCountFrom!==null)echo "&viewCountFrom=$viewCountFrom";
                        if($viewCountTo!==null)echo "&viewCountTo=$viewCountTo";
                        if($status!==null)echo "&status=$status";
                        if($createdDate!==null)echo "&createdDate=$createdDate";
                        if($id!==null) echo "&id=$id";
                        if($orderBy!==null)echo "&orderBy=$orderBy";
                        if($order!==null)echo "&order=$order";
                        echo "\"><</a>";
                    }
                    echo "<a class=\"page\">".$page."</a>";
                    if($page*$pageSize < $resultCount){
                        echo "<a href=\"/dRaczekProjekt/admin/manage/products?page=".($page+1)."&size=$pageSize";
                        if($name!==null)echo "&name=$name";
                        if($categoryId!==null)echo "&categoryId=$categoryId";
                        if($description!==null)echo "&description=$description";
                        if($priceFrom!==null)echo "&priceFrom=$priceFrom";
                        if($priceTo!==null)echo "&priceTo=$priceTo";
                        if($quantityFrom!==null)echo "&quantityFrom=$quantityFrom";
                        if($quantityTo!==null)echo "&quantityTo=$quantityTo";
                        if($productSize!==null)echo "&productSize=$productSize";
                        if($colour!==null)echo "&colour=$colour";
                        if($gender!==null)echo "&gender=$gender";
                        if($viewCountFrom!==null)echo "&viewCountFrom=$viewCountFrom";
                        if($viewCountTo!==null)echo "&viewCountTo=$viewCountTo";
                        if($status!==null)echo "&status=$status";
                        if($createdDate!==null)echo "&createdDate=$createdDate";
                        if($id!==null) echo "&id=$id";
                        if($orderBy!==null)echo "&orderBy=$orderBy";
                        if($order!==null)echo "&order=$order";
                        echo "\">></a>";
                    }
                ?>
            </div>
                
                <?php
                    }
                ?>
        </div>
    </main>
    <?php echo $data['footer']; ?>

    <script>
        document.querySelector("#filterForm input[name=submit]").addEventListener("click", submitForm);
        function submitForm(event) {
            event.preventDefault(); // Zapobieganie domyślnej akcji wysłania formularza
            var form = document.getElementById("filterForm");
            var inputs = form.querySelectorAll("input, select");
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
        function toggleForm(event){
            let el = event.target;
            while(!el.classList.contains("filter-wrapper"))el=el.parentElement;
            el.querySelector("form").classList.toggle("hide");
        }
    </script>
</body>
</html>