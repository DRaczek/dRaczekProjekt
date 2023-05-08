<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <?php  echo $data['styles']; ?>
    <link rel="stylesheet" href="/dRaczekProjekt/css/adminItems.css">
    <link rel="stylesheet" href="/dRaczekProjekt/css/adminFilter.css">
</head>
<body>
    <?php
        $page = $data['filter']['page'];
        $pageSize = $data['filter']['pageSize'];
        $id = $data['filter']['id'];
        $user_id = $data['filter']['user_id'];
        $is_company = $data['filter']['is_company'];
        $first_name = $data['filter']['first_name'];
        $last_name = $data['filter']['last_name'];
        $street = $data['filter']['street'];
        $postal_code = $data['filter']['postal_code'];
        $postal_city = $data['filter']['postal_city'];
        $country = $data['filter']['country'];
        $nip = $data['filter']['nip'];
        $company_name = $data['filter']['company_name'];
        $delivery_id = $data['filter']['delivery_id'];
        $payment_method_id = $data['filter']['payment_method_id'];
        $payment_status = $data['filter']['payment_status'];
        $order_status = $data['filter']['order_status'];
        $created_date = $data['filter']['created_date'];
        $status = $data['filter']['status'];
        $orderBy = $data['filter']['orderBy'];
        $order = $data['filter']['order'];
        $result = $data['result'];
        $resultCount = $data['resultCount'];
    ?>
    <?php echo $data['header']; ?>
    <main>
        <h3>Filtr</h3>
        <div class="filter-wrapper">
            <button class="toggle" onclick = "toggleForm(event)">
                <img src="/dRaczekProjekt/img/filter.svg">
            </button>
            <form action="/dRaczekProjekt/admin/manage/orders" method="get" id="filterForm" class="hide">
                <input type="hidden" name="page" value = <?php echo $page; ?>>
                <input type="hidden" name="size" value = <?php echo $pageSize; ?>>
                Imię<input type="text" name="first_name" value = "<?php echo $first_name; ?>">
                Nazwisko<input type="text" name="last_name" value = "<?php echo $last_name; ?>">
                Ulica<input type="text" name="street" value = "<?php echo $street; ?>">
                Kod Pocztowy<input type="text" name="postal_code" value = "<?php echo $postal_code; ?>">
                Miejscowość<input type="text" name="postal_city" value = "<?php echo $postal_city; ?>">
                Kraj<input type="text" name="country" value = "<?php echo $country; ?>">
                Nip<input type="text" name="nip" value = "<?php echo $nip; ?>">
                Nazwa firmy<input type="text" name="company_name" value = "<?php echo $company_name; ?>">
                Sposób dostawy <select name="delivery_id">
                    <option value="999" <?php if($delivery_id==null)echo "selected";?>>ALL</option>
                    <?php foreach($data['delivery_methods'] as $method): ?>
                        <option value = "<?php echo $method['id']; ?>" <?php if($delivery_id==$method['id'])echo "selected"; ?>><?php echo $method['name']; ?></option>
                    <?php endforeach; ?>
                </select> 
                Sposób płatności <select name="payment_method_id">
                    <option value="999" <?php if($payment_method_id==null)echo "selected";?>>ALL</option>
                    <?php foreach($data['payment_methods'] as $method): ?>
                        <option value = "<?php echo $method['id']; ?>" <?php if($payment_method_id==$method['id'])echo "selected"; ?>><?php echo $method['name']; ?></option>
                    <?php endforeach; ?>
                </select> 
                Status płatności <select name="payment_status">
                    <option value="999" <?php if($payment_status==null)echo "selected";?>>ALL</option>
                    <?php foreach(PaymentStatusEnum::GetConstants() as $key=>$value): ?>
                        <option value = "<?php echo $key; ?>" <?php if($payment_status===$key)echo "selected"; ?>><?php echo $value; ?></option>
                    <?php endforeach; ?>
                </select> 
                Status zamówienia <select name="order_status">
                    <option value="999" <?php if($order_status==null)echo "selected";?>>ALL</option>
                    <?php foreach(OrderStatusEnum::GetConstants() as $key=>$value): ?>
                        <option value = "<?php echo $key; ?>" <?php if($order_status===$key)echo "selected"; ?>><?php echo $value; ?></option>
                    <?php endforeach; ?>
                </select> 
                Status <select name="status">
                    <option value="999" <?php if($status==null)echo "selected";?>>ALL</option>
                    <option value="0" <?php if($status===0)echo "selected";?>>INACTIVE</option>
                    <option value="1" <?php if($status===1)echo "selected";?>>ACTIVE</option>
                    <option value="2" <?php if($status===2)echo "selected";?>>SUSPENDED</option>
                </select> 
                Created date<input type="date" name="created_date" <?php echo "value=\"$created_date\""; ?>>
                Id<input type="text" name="id" <?php echo "value=\"$id\""; ?>>
                Sortowanie 
                <select name="orderBy">
                    <?php foreach($data['acceptableOrderBy'] as $field): ?>
                        <option value = "<?php echo $field; ?>" <?php if($orderBy==$field) echo "selected"; ?>><?php echo $field; ?></option>
                    <?php endforeach; ?>
                    <!-- <option value="created_date" <?php if($orderBy=="created_date")echo "selected";?>>Data utworzenia</option>
                    <option value="id" <?php if($orderBy=="id")echo "selected";?>>Id</option>
                    <option value="name" <?php if($orderBy=="name")echo "selected";?>>Nazwa</option>
                    <option value="status" <?php if($orderBy=="status")echo "selected";?>>Status</option> -->
                </select>
                <select name="order">
                    <option value="desc" <?php if($order=="desc")echo "selected";?>>Malejąco</option>
                    <option value="asc" <?php if($order=="asc")echo "selected";?>>Rosnąco</option>
                </select>
                <input type="submit" name="submit" value="Szukaj">
                <a href="/dRaczekProjekt/admin/manage/orders">Wyczyść filtry</a>
            </form>
        <div>
            <br>
        <?php
            if(isset($_SESSION['message'])){
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }

            if($result===null || count($result)===0){
                echo "<br>Nie znalezniono wyników";
            }
            else{
                echo "<br>Znaleziono : $resultCount pasujących wyników.";
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
                        <a class="caption" alt="user_id">
                            <span>
                                user_id
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['user_id'] ?>">
                            <span>
                                <?php echo $row['user_id'] ?>
                            </span>
                        </a>
                        <a class="caption" alt="Czy firma">
                            <span>
                                Czy firma
                            </span>
                        </a>
                        <a class="value" alt="<?php echo (($row['is_company']==0)?"NIE":"TAK"); ?>">
                            <span>
                                <?php echo (($row['is_company']==0)?"NIE":"TAK"); ?>
                            </span>
                        </a>
                        </a>
                        <a class="caption" alt="Imię">
                            <span>
                                Imię
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['first_name'] ?>">
                            <span>
                                <?php echo $row['first_name'] ?>
                            </span>
                        </a>
                        </a>
                        <a class="caption" alt="Nazwisko">
                            <span>
                            Nazwisko
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['last_name'] ?>">
                            <span>
                                <?php echo $row['last_name'] ?>
                            </span>
                        </a>
                        </a>
                        <a class="caption" alt="Ulica">
                            <span>
                            Ulica
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['street'] ?>">
                            <span>
                                <?php echo $row['street'] ?>
                            </span>
                        </a>
                        </a>
                        <a class="caption" alt="Numer domu">
                            <span>
                            Numer domu
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['street_number'] ?>">
                            <span>
                                <?php echo $row['street_number'] ?>
                            </span>
                        </a>
                        </a>
                        <a class="caption" alt="Kod pocztowy">
                            <span>
                            Kod pocztowy
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['postal_code'] ?>">
                            <span>
                                <?php echo $row['postal_code'] ?>
                            </span>
                        </a>
                        <a class="caption" alt="Miejsowość">
                            <span>
                            Miejsowość
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['postal_city'] ?>">
                            <span>
                                <?php echo $row['postal_city'] ?>
                            </span>
                        </a>
                        <a class="caption" alt="Kraj">
                            <span>
                            Kraj
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['country'] ?>">
                            <span>
                                <?php echo $row['country'] ?>
                            </span>
                        </a>
                        <a class="caption" alt="Nip">
                            <span>
                            Nip
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['nip'] ?>">
                            <span>
                                <?php echo $row['nip'] ?>
                            </span>
                        </a>
                        <a class="caption" alt="Nazwa firmy">
                            <span>
                            Nazwa firmy
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['company_name'] ?>">
                            <span>
                                <?php echo $row['company_name'] ?>
                            </span>
                        </a>
                        <a class="caption" alt="Sposób dostawy">
                            <span>
                            Sposób dostawy
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['delivery_name'] ?>">
                            <span>
                                <?php echo $row['delivery_name'] ?>
                            </span>
                        </a>
                        <a class="caption" alt="Śledzenie zamówienia">
                            <span>
                            Śledzenie zamówienia
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['delivery_tracking'] ?>">
                            <span>
                                <?php echo $row['delivery_tracking'] ?>
                            </span>
                        </a>
                        <a class="caption" alt="Sposób płatności">
                            <span>
                            Sposób płatności
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['payment_method_name'] ?>">
                            <span>
                                <?php echo $row['payment_method_name'] ?>
                            </span>
                        </a>
                        <a class="caption" alt="Status płatności">
                            <span>
                            Status płatności
                            </span>
                        </a>
                        <a class="value" alt="<?php echo PaymentStatusEnum::GetConstants()[$row['payment_status']] ?>">
                            <span>
                                <?php echo PaymentStatusEnum::GetConstants()[$row['payment_status']] ?>
                            </span>
                        </a>
                        <a class="caption" alt="Status zamówienia">
                            <span>
                            Status zamówienia
                            </span>
                        </a>
                        <a class="value" alt="<?php echo OrderStatusEnum::GetConstants()[$row['order_status']] ?>">
                            <span>
                                <?php echo OrderStatusEnum::GetConstants()[$row['order_status']] ?>
                            </span>
                        </a>
                        <a class="caption" alt="Data utworzenia">
                            <span>
                            Data utworzenia
                            </span>
                        </a>
                        <a class="value" alt="<?php echo $row['created_date']; ?>">
                            <span>
                                <?php echo $row['created_date']; ?>
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
                       
                       
                        <span class="option ban">
                            <a href="/dRaczekProjekt/admin/manage/orders/suspend/<?php echo $row['id']?>">Zbanuj</a>
                        </span>
                        <span class="option act">
                            <a href="/dRaczekProjekt/admin/manage/orders/activate/<?php echo $row['id']?>">Odbanuj</a>
                        </span>
                        <span class="option ban">
                            <a href="/dRaczekProjekt/admin/manage/orders/delete/<?php echo $row['id']?>">Usuń</a>
                        </span>
                        <span class="option edit">
                            <a href="/dRaczekProjekt/admin/manage/orders/edit/form/<?php echo $row['id']?>">Edytuj</a>
                        </span>
                        <span class="option edit">
                            <a href="/dRaczekProjekt/admin/manage/orders/products/<?php echo $row['id']?>">Zobacz zamówione produkty</a>
                        </span>
                        
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="pages">
                <?php
                    if($page>1){
                        echo "<a href=\"/dRaczekProjekt/admin/manage/orders?page=".($page-1)."&size=$pageSize";
                        if($first_name!==null)echo "&first_name=$first_name";
                        if($last_name!==null)echo "&last_name=$last_name";
                        if($street!==null)echo "&street=$street";
                        if($postal_code!==null)echo "&postal_code=$postal_code";
                        if($postal_city!==null)echo "&postal_city=$postal_city";
                        if($country!==null)echo "&country=$country";
                        if($nip!==null)echo "&nip=$nip";
                        if($company_name!==null)echo "&company_name=$company_name";
                        if($delivery_id!==null)echo "&delivery_id=$delivery_id";
                        if($payment_method_id!==null)echo "&payment_method_id=$payment_method_id";
                        if($payment_status!==null)echo "&payment_status=$payment_status";
                        if($order_status!==null)echo "&order_status=$order_status";
                        if($status!==null)echo "&status=$status";
                        if($created_date!==null)echo "&created_date=$created_date";
                        if($id!==null) echo "&id=$id";
                        if($orderBy!==null)echo "&orderBy=$orderBy";
                        if($order!==null)echo "&order=$order";
                        echo "\"><</a>";
                    }
                    echo "<a class=\"page\">".$page."</a>";
                    if($page*$pageSize < $resultCount){
                        echo "<a href=\"/dRaczekProjekt/admin/manage/orders?page=".($page+1)."&size=$pageSize";
                        if($first_name!==null)echo "&first_name=$first_name";
                        if($last_name!==null)echo "&last_name=$last_name";
                        if($street!==null)echo "&street=$street";
                        if($postal_code!==null)echo "&postal_code=$postal_code";
                        if($postal_city!==null)echo "&postal_city=$postal_city";
                        if($country!==null)echo "&country=$country";
                        if($nip!==null)echo "&nip=$nip";
                        if($company_name!==null)echo "&company_name=$company_name";
                        if($delivery_id!==null)echo "&delivery_id=$delivery_id";
                        if($payment_method_id!==null)echo "&payment_method_id=$payment_method_id";
                        if($payment_status!==null)echo "&payment_status=$payment_status";
                        if($order_status!==null)echo "&order_status=$order_status";
                        if($status!==null)echo "&status=$status";
                        if($created_date!==null)echo "&created_date=$created_date";
                        if($id!==null) echo "&id=$id";
                        if($orderBy!==null)echo "&orderBy=$orderBy";
                        if($order!==null)echo "&order=$order";
                        echo "\">></a>";
                    }
                ?>
            </div>

        <?php } ?>
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