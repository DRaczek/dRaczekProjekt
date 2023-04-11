<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        td,th,tr,table{
            border:1px solid black;
            border-collapse:collapse;
        }
    </style>
</head>
<body>
    <div style="border:5px dashed red;">
        <?php
            if(isset($_SESSION['user_id'])){
                echo "Zalogowano jako : ".$_SESSION['user_email']."<br>";
                echo "<a href=\"../logout\">wyloguj się</a><br>";
                echo "<a href=\"../user\">Szczegóły użytkownika</a>";
            }
            else{
                echo "<a href=\"login\">Zaloguj się</a>";
            }
        ?>
    </div>
    Strona do zarządzania produktami.<br>
    <?php
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
    ?>
    <br><a href="/dRaczekProjekt/admin/manage/products/add">Dodaj produkt</a><br>
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
        <table>
                <tr>
                    <th>id</th> 
                    <th>Nazwa</th>
                    <th>Id Kategorii</th>
                    <th>Nazwa Kategorii</th>
                    <th>Zdjęcie 1</th>
                    <th>Zdjęcie 2</th>
                    <th>Zdjęcie 3</th>
                    <th>Opis</th>
                    <th>Cena</th>
                    <th>Ilość</th>
                    <th>Rozmiar</th>
                    <th>Kolor</th>
                    <th>Wyświetlenia</th>
                    <th>Status</th>
                    <th>Data utworzenia</th>
                    <th>Suspend</th>
                    <th>Activate</th>
                    <th>Delete</th>
                    <th>Edit</th>
                </tr>
                <?php
                    function createCell($value){
                        echo "<td>$value</td>";
                    }

                    foreach($result as $row){
                        echo "<tr>";
                        createCell($row['id']);
                        createCell($row['name']);
                        createCell($row['category_id']);
                        createCell($row['category_name']);
                        $imgPath1 = $row['image_path_1'];
                        $imgPath2 = $row['image_path_2'];
                        $imgPath3 = $row['image_path_3'];
                        echo<<<imageCell
                            <td><img src="/dRaczekProjekt/$imgPath1" alt="Pierwsze zdjęcie przypisane do kategorii" width="100" height="100"></td>
                        imageCell;
                        if($imgPath2!=null){
                            echo<<<imageCell
                                <td><img src="/dRaczekProjekt/$imgPath2" alt="Drugie zdjęcie przypisane do kategorii" width="100" height="100"></td>
                            imageCell;}
                        else{
                            echo "<td>Nie podano zdjęcia.</td>";   
                        }
                        if($imgPath3!=null){
                            echo<<<imageCell
                                <td><img src="/dRaczekProjekt/$imgPath3" alt="Drugie zdjęcie przypisane do kategorii" width="100" height="100"></td>
                            imageCell;}
                        else{
                            echo "<td>Nie podano zdjęcia.</td>";   
                        }
                        createCell($row['description']);
                        createCell($row['price']);
                        createCell($row['quantity']);
                        createCell($row['size']);
                        createCell($row['colour']);
                        createCell($row['view_count']);
                        createCell($row['status']);
                        createCell($row['created_date']);
                        echo "<td><a href=\"/dRaczekProjekt/admin/manage/products/suspend/".$row['id']."\">Suspend</a></td>";
                        echo "<td><a href=\"/dRaczekProjekt/admin/manage/products/activate/".$row['id']."\">Activate</a></td>";
                        echo "<td><a href=\"/dRaczekProjekt/admin/manage/products/delete/".$row['id']."\">Delete</a></td>";
                        echo "<td><a href=\"/dRaczekProjekt/admin/manage/products/edit/form/".$row['id']."\">Edit</a></td>";
                        echo "</tr>";
                    }
                ?>
            </table>
            <?php
                    if($page>1){
                        echo "<a href=\"/dRaczekProjekt/admin/manage/products/page=".($page-1)."&size=$pageSize";
                        if($name!==null)echo "&name=$name";
                        if($categoryId!==null)echo "&categoryId=$categoryId";
                        if($description!==null)echo "&description=$description";
                        if($priceFrom!==null)echo "&priceFrom=$priceFrom";
                        if($priceTo!==null)echo "&priceTo=$priceTo";
                        if($quantityFrom!==null)echo "&quantityFrom=$quantityFrom";
                        if($quantityTo!==null)echo "&quantityTo=$quantityTo";
                        if($productSize!==null)echo "&productSize=$productSize";
                        if($colour!==null)echo "&colour=$colour";
                        if($viewCountFrom!==null)echo "&viewCountFrom=$viewCountFrom";
                        if($viewCountTo!==null)echo "&viewCountTo=$viewCountTo";
                        if($status!==null)echo "&status=$status";
                        if($createdDate!==null)echo "&createdDate=$createdDate";
                        if($id!==null) echo "&id=$id";
                        if($orderBy!==null)echo "&orderBy=$orderBy";
                        if($order!==null)echo "&order=$order";
                        echo "\"><</a>";
                    }
                    echo $page;
                    if($page*$pageSize < $resultCount){
                        echo "<a href=\"/dRaczekProjekt/admin/manage/products/page=".($page+1)."&size=$pageSize";
                        if($name!==null)echo "&name=$name";
                        if($categoryId!==null)echo "&categoryId=$categoryId";
                        if($description!==null)echo "&description=$description";
                        if($priceFrom!==null)echo "&priceFrom=$priceFrom";
                        if($priceTo!==null)echo "&priceTo=$priceTo";
                        if($quantityFrom!==null)echo "&quantityFrom=$quantityFrom";
                        if($quantityTo!==null)echo "&quantityTo=$quantityTo";
                        if($productSize!==null)echo "&productSize=$productSize";
                        if($colour!==null)echo "&colour=$colour";
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
            
                

            <?php
                }
                echo "<h3>Filter</h3>";
                echo " <form action=\"/dRaczekProjekt/admin/manage/products/page=".($page)."&size=$pageSize\" method=\"post\">"   
            ?>
                    Id:<input type="text" name="id" <?php echo "value=\"$id\""; ?>><br>
                    Nazwa:<input type="text" name="name" <?php echo "value=\"$name\""; ?>><br>
                    Kategoria:<select name="categoryId">
                        <option value="999">ALL</option>
                    <?php
                        foreach($categories as $category){
                            echo "<option value = \"".$category['id']."\"".(($categoryId==$category['id'])?"selected":"").">".$category['name']."</option>";
                        }
                    ?>  
                    </select><Br>
                    Opis: <input type="text" name="description" value="<?php echo $description;?>"><br>
                    Cena od: <input type="number" name="priceFrom" step="0.01" value="<?php echo $priceFrom?>"><br>
                    Cena do: <input type="number" name="priceTo" step="0.01" value="<?php echo $priceTo?>"><br>
                    Ilość od: <input type="number" name="quantityFrom" value="<?php echo $quantityFrom?>"><br>
                    Ilość do: <input type="number" name="quantityTo" value="<?php echo $quantityTo?>"><br>
                    Rozmiar:<select name="productSize">
                        <option value="999">ALL</option>
                    <?php
                        foreach (ProductSizeEnum::getConstants() as $constantName => $constantValue) {
                            echo "<option value=\"$constantName\"".(($productSize===$constantName)?"selected":"").">$constantValue</option>";
                        }
                    ?>
                    </select><br>
                    Kolor:<select name="colour">
                        <option value="999">ALL</option>
                    <?php
                        foreach (ProductColourEnum::getConstants() as $constantName => $constantValue) {
                            echo "<option value=\"$constantName\"".(($colour===$constantName)?"selected":"").">$constantValue</option>";
                        }
                    ?>
                    </select><br>
                    Ilość wyświetleń od: <input type="number" name="viewCountFrom" value="<?php echo $viewCountFrom?>"><br>
                    Ilość wyświetleń do: <input type="number" name="viewCountTo" value="<?php echo $viewCountTo?>"><br>
                    Status: <select name="status">
                        <option value="999" <?php if($status==null)echo "selected";?>>ALL</option>
                        <option value="0" <?php if($status===0)echo "selected";?>>INACTIVE</option>
                        <option value="1" <?php if($status===1)echo "selected";?>>ACTIVE</option>
                        <option value="2" <?php if($status===2)echo "selected";?>>SUSPENDED</option>
                    </select> <br>
                    Created date:<input type="date" name="created_date" <?php echo "value=\"$createdDate\""; ?>><br>
                    Sortowanie : <Br>
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
                    </select><Br>
                    <select name="order">
                        <option value="desc" <?php if($order=="desc")echo "selected";?>>Malejąco</option>
                        <option value="asc" <?php if($order=="asc")echo "selected";?>>Rosnąco</option>
                    </select><Br>
                    <input type="submit" name="submit" value="Szukaj">
                </form>
                <a href="/dRaczekProjekt/admin/manage/products">Wyczyść filtry</a>
    </div>
</body>
</html>