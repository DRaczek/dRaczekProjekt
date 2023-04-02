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
                    echo "<a href=\"/dRaczekProjekt/admin/manage/users/page=".($page-1)."&size=$pageSize";
                    if($email!==null)echo "&email=$email";
                    if($firstName!==null)echo "&firstName=$firstName";
                    if($lastName!==null)echo "&lastName=$lastName";
                    if($status!==null)echo "&status=$status";
                    if($createdDate!==null)echo "&createdDate=$createdDate";
                    echo "\"><</a>";
                }
                echo $page;
                if($page*$pageSize < $resultCount){
                    echo "<a href=\"/dRaczekProjekt/admin/manage/users/page=".($page+1)."&size=$pageSize";
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
            echo " <form action=\"/dRaczekProjekt/admin/manage/users/page=".($page)."&size=$pageSize\" method=\"post\">"   
        ?>
         Email:<input type="text" name="email"><br>
                Imię:<input type="text" name="first_name"><br>
                Nazwisko:<input type="text" name="last_name"><br>
                Status: <select name="status">
                    <option value="0">INACTIVE</option>
                    <option value="1">ACTIVE</option>
                    <option value="2">SUSPENDED</option>
                </select> <br>
                Created date:<input type="date" name="created_date"><br>
                <input type="submit" name="submit" value="Szukaj">
                <input type="reset" value="Wyczyść">
            </form>
    </div>
</body>
</html>