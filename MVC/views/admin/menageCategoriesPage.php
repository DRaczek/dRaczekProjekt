<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    Manage categories panel.<br>
    <a href="/dRaczekProjekt/admin/manage/categories/add">Dodaj kategorie</a>
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
                <th>Zdjęcie</th>
                <th>Status</th>
                <th>Data utworzenia</th>
                <th>Suspend<th>
                <th>Activate<th>
                <th>Delete<th>
                <th>Edit<th>
            </tr>
            <?php
                function createCell($value){
                    echo "<td>$value</td>";
                }

                foreach($result as $row){
                    echo "<tr>";
                    createCell($row['id']);
                    createCell($row['name']);
                    $imgPath = $row['image_path'];
                    echo<<<imageCell
                        <td><img src="/dRaczekProjekt/$imgPath" alt="Zdjęcie przypisane do kategorii" width="100" height="100"></td>
                    imageCell;
                    
                    
                    createCell($row['status']);
                    createCell($row['created_date']);
                    echo "<td><a href=\"/dRaczekProjekt/admin/manage/categories/suspend/".$row['id']."\">Suspend</a></td>";
                    echo "<td><a href=\"/dRaczekProjekt/admin/manage/categories/activate/".$row['id']."\">Activate</a></td>";
                    echo "<td><a href=\"/dRaczekProjekt/admin/manage/categories/delete/".$row['id']."\">Delete</a></td>";
                    echo "<td><a href=\"/dRaczekProjekt/admin/manage/categories/edit/form/".$row['id']."\">Edit</a></td>";
                    echo "</tr>";
                }
            ?>
        </table>
        <?php
                if($page>1){
                    echo "<a href=\"/dRaczekProjekt/admin/manage/categories?page=".($page-1)."&size=$pageSize";
                    if($name!==null)echo "&name=$name";
                    if($status!==null)echo "&status=$status";
                    if($createdDate!==null)echo "&createdDate=$createdDate";
                    if($orderBy!==null)echo "&orderBy=$orderBy";
                    if($order!==null)echo "&order=$order";
                    echo "\"><</a>";
                }
                echo $page;
                if($page*$pageSize < $resultCount){
                    echo "<a href=\"/dRaczekProjekt/admin/manage/categories?page=".($page+1)."&size=$pageSize";
                    if($name!==null)echo "&name=$name";
                    if($status!==null)echo "&status=$status";
                    if($createdDate!==null)echo "&createdDate=$createdDate";
                    if($orderBy!==null)echo "&orderBy=$orderBy";
                    if($order!==null)echo "&order=$order";
                    echo "\">></a>";
                }
               
        ?>
        
               

        <?php
            }
            echo "<h3>Filter</h3>";
            echo " <form action=\"/dRaczekProjekt/admin/manage/categories\" method=\"get\" id=\"filterForm\">"   
        ?>
                <input type="hidden" name="page" value = <?php echo $page; ?>>
                <input type="hidden" name="size" value = <?php echo $pageSize; ?>>
                Nazwa:<input type="text" name="name" <?php echo "value=\"$name\""; ?>><br>
                Status: <select name="status">
                    <option value="999" <?php if($status==null)echo "selected";?>>ALL</option>
                    <option value="0" <?php if($status===0)echo "selected";?>>INACTIVE</option>
                    <option value="1" <?php if($status===1)echo "selected";?>>ACTIVE</option>
                    <option value="2" <?php if($status===2)echo "selected";?>>SUSPENDED</option>
                </select> <br>
                Created date:<input type="date" name="createdDate" <?php echo "value=\"$createdDate\""; ?>><br>
                Id:<input type="text" name="id" <?php echo "value=\"$id\""; ?>><br>
                Sortowanie : <Br>
                <select name="orderBy">
                    <option value="created_date" <?php if($orderBy=="created_date")echo "selected";?>>Data utworzenia</option>
                    <option value="id" <?php if($orderBy=="id")echo "selected";?>>Id</option>
                    <option value="name" <?php if($orderBy=="name")echo "selected";?>>Nazwa</option>
                    <option value="status" <?php if($orderBy=="status")echo "selected";?>>Status</option>
                </select><Br>
                <select name="order">
                    <option value="desc" <?php if($order=="desc")echo "selected";?>>Malejąco</option>
                    <option value="asc" <?php if($order=="asc")echo "selected";?>>Rosnąco</option>
                </select><Br>   
                <input type="submit" name="submit" value="Szukaj">
            </form>
            <a href="/dRaczekProjekt/admin/manage/categories">Wyczyść filtry</a>

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
            </script>
    </div>
</body>
</html>