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
    Manage users panel.<br>
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
                <th>email</th>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Status</th>
                <th>Data utworzenia</th>
                <th>Suspend<th>
                <th>Activate<th>
            </tr>
            <?php
                function createCell($value){
                    echo "<td>$value</td>";
                }

                foreach($result as $row){
                    echo "<tr>";
                    createCell($row['id']);
                    createCell($row['email']);
                    createCell($row['first_name']);
                    createCell($row['last_name']);
                    createCell($row['status']);
                    createCell($row['created_date']);
                    echo "<td><a href=\"/dRaczekProjekt/admin/manage/users/suspend/".$row['id']."\">Suspend</a></td>";
                    echo "<td><a href=\"/dRaczekProjekt/admin/manage/users/activate/".$row['id']."\">Activate</a></td>";
                    echo "</tr>";
                }
            ?>
        </table>
        <?php
                if($page>1){
                    echo "<a href=\"/dRaczekProjekt/admin/manage/users?page=".($page-1)."&size=$pageSize";
                    if($email!==null)echo "&email=$email";
                    if($firstName!==null)echo "&firstName=$firstName";
                    if($lastName!==null)echo "&lastName=$lastName";
                    if($status!==null)echo "&status=$status";
                    if($createdDate!==null)echo "&createdDate=$createdDate";
                    echo "\"><</a>";
                }
                echo $page;
                if($page*$pageSize < $resultCount){
                    echo "<a href=\"/dRaczekProjekt/admin/manage/users?page=".($page+1)."&size=$pageSize";
                    if($email!==null)echo "&email=$email";
                    if($firstName!==null)echo "&firstName=$firstName";
                    if($lastName!==null)echo "&lastName=$lastName";
                    if($status!==null)echo "&status=$status";
                    if($createdDate!==null)echo "&createdDate=$createdDate";
                    echo "\">></a>";
                }
               
        ?>
        
               

        <?php
            }
            echo "<h3>Filter</h3>";
            echo " <form action=\"/dRaczekProjekt/admin/manage/users\" method=\"get\" id=\"filterForm\">"   
        ?>
                <input type="hidden" name="page" value="<?php echo $page; ?>">
                <input type="hidden" name="size" value="<?php echo $pageSize; ?>">
                Email:<input type="text" name="email" value = "<?php echo $email; ?>"><br>
                Imię:<input type="text" name="firstName" value ="<?php echo $firstName; ?>"><br>
                Nazwisko:<input type="text" name="lastName" value ="<?php echo $lastName; ?>"><br>
                Status: <select name="status">
                    <option value="999" <?php if($status==null)echo "selected";?>>ALL</option>
                    <option value="0" <?php if($status===0)echo "selected";?>>INACTIVE</option>
                    <option value="1" <?php if($status===1)echo "selected";?>>ACTIVE</option>
                    <option value="2" <?php if($status===2)echo "selected";?>>SUSPENDED</option>
                </select> <br>
                Created date:<input type="date" name="createdDate" value = "<?php echo $createdDate; ?>"><br>
                Id:<input type="text" name="id" <?php echo "value=\"$id\""; ?>><br>
                Sortowanie : <Br>
                <select name="orderBy">
                    <option value="created_date" <?php if($orderBy=="created_date")echo "selected";?>>Data utworzenia</option>
                    <option value="id" <?php if($orderBy=="id")echo "selected";?>>Id</option>
                    <option value="email" <?php if($orderBy=="email")echo "selected";?>>Email</option>
                    <option value="status" <?php if($orderBy=="status")echo "selected";?>>Status</option>
                    <option value="first_name" <?php if($orderBy=="first_name")echo "selected";?>>Imię</option>
                    <option value="last_name" <?php if($orderBy=="last_name")echo "selected";?>>Nazwisko</option>
                </select><Br>
                <select name="order">
                    <option value="desc" <?php if($order=="desc")echo "selected";?>>Malejąco</option>
                    <option value="asc" <?php if($order=="asc")echo "selected";?>>Rosnąco</option>
                </select><Br>   
                <input type="submit" name="submit" value="Szukaj">
            </form>
            <a href="/dRaczekProjekt/admin/manage/users">Wyczyść filtry</a>

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