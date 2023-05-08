<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <?php echo $data['styles']; ?>
    <link rel="stylesheet" href="/dRaczekProjekt/css/adminManageCategories.css"> 
    <link rel="stylesheet" href="/dRaczekProjekt/css/adminItems.css"> 
    <link rel="stylesheet" href="/dRaczekProjekt/css/adminFilter.css"> 
</head>
<body>
    <?php
        $result = $data['result'];
        $resultCount = $data['resultCount'];
        $page = $data['filter']['page'];
        $pageSize = $data['filter']['pageSize'];
        $id = $data['filter']['id'];
        $name = $data['filter']['name'];
        $status = $data['filter']['status'];
        $createdDate = $data['filter']['createdDate'];
        $orderBy = $data['filter']['orderBy'];
        $order = $data['filter']['order'];
    ?>
    <?php echo $data['header']; ?>

    <main>
        <a href="/dRaczekProjekt/admin/manage/categories/add" id="addLink">
            <img src="/dRaczekProjekt/img/add-icon.svg">
        </a>

        <h3>Filtr</h3>
        <div class="filter-wrapper">
            <button class="toggle" onclick = "toggleForm(event)">
                <img src="/dRaczekProjekt/img/filter.svg">
            </button>
            <form action="/dRaczekProjekt/admin/manage/categories" method="get" id="filterForm" class="hide">
                <input type="hidden" name="page" value = <?php echo $page; ?>>
                <input type="hidden" name="size" value = <?php echo $pageSize; ?>>
                Nazwa:<input type="text" name="name" <?php echo "value=\"$name\""; ?>>
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
                    <option value="name" <?php if($orderBy=="name")echo "selected";?>>Nazwa</option>
                    <option value="status" <?php if($orderBy=="status")echo "selected";?>>Status</option>
                </select>
                <select name="order">
                    <option value="desc" <?php if($order=="desc")echo "selected";?>>Malejąco</option>
                    <option value="asc" <?php if($order=="asc")echo "selected";?>>Rosnąco</option>
                </select>
                <input type="submit" name="submit" value="Szukaj">
                <a href="/dRaczekProjekt/admin/manage/categories">Wyczyść filtry</a>
            </form>
        <div>
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
                        <a class="caption" alt="Email">
                            <span>
                                Nazwa
                            </span>
                        </a>
                        <a class="value"alt="<?php echo $row['name'];?>">
                            <span>
                                <?php echo $row['name'] ?>
                            </span>
                        </a>
                        <a class="caption" alt="Imię">
                            <span>
                                Zdjęcie
                            </span>
                        </a>
                        <a class="value img" alt="Zdjęcie kategorii">
                            <img src="/dRaczekProjekt/<?php echo $row['image_path']; ?>">
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
                            <a href="/dRaczekProjekt/admin/manage/categories/suspend/<?php echo $row['id']?>">Zbanuj</a>
                        </span>
                        <span class="option act">
                            <a href="/dRaczekProjekt/admin/manage/categories/activate/<?php echo $row['id']?>">Odbanuj</a>
                        </span>
                        <span class="option ban">
                            <a href="/dRaczekProjekt/admin/manage/categories/delete/<?php echo $row['id']?>">Usuń</a>
                        </span>
                        <span class="option edit">
                            <a href="/dRaczekProjekt/admin/manage/categories/edit/form/<?php echo $row['id']?>">Edytuj</a>
                        </span>
                        
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="pages">
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
                        echo "<a class=\"page\">".$page."</a>";
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