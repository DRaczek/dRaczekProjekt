<header>
    <a href="/dRaczekProjekt/home" id="logo-wrapper">
        <img src="/dRaczekProjekt/img/logo/logo_transparent_img_only.png" id="logo">
    </a>
    <div id="searchbar-wrapper">
        <form action="/dRaczekProjekt/products" method="get">
            <input type="hidden" name="page" value="1">
            <input type="hidden" name="size" value="20">
            <input type="text" name="text" <?php if(isset($_GET['text'])) echo "value=\"".$_GET['text']."\""; ?>>
            <select name="categoryId">
                <option value="999">Wszystkie kategorie</option>
                <?php
                    foreach($data['categories'] as $category){
                        echo "<option value=\"".$category['id']."\">".$category['name']."</option>";
                    }
                ?>
            </select>
            <input type="submit" value="Szukaj">
        </form>
    </div>
    <div id="header-items-wrapper">
        <a class="item" href="/dRaczekProjekt/cart">
            <img src="/dRaczekProjekt/img/cart-icon.svg">
        </a>

        <div class="item">
            <img src="/dRaczekProjekt/img/account-icon.svg">
            <div class="details">
                <?php
                    if(isset($_SESSION['user_id']) && isset($_SESSION['user_email'])){
                        echo "<h3>Witaj ".$_SESSION['user_first_name']."!</h3>";
                        echo "<span class = \"user-details\">".$_SESSION['user_email']."</span><Br>";
                        echo "<a href=\"/dRaczekProjekt/user\">KONTO</a>";
                        echo "<a href=\"/dRaczekProjekt/logout\">WYLOGUJ</a>";
                        echo "<hr>";
                        echo "<a href=\"/dRaczekProjekt/orders\">Zamówienia</a>";
                        if(isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin']==true){
                            echo "<hr>";
                            echo "<a href=\"/dRaczekProjekt/admin/home\">Panel Administratora</a>";
                        }
                    }
                    else{
                        echo "<a href=\"/dRaczekProjekt/login\">ZALOGUJ SIĘ</a>";
                        echo "<a href=\"/dRaczekProjekt/register\">ZAREJESTRUJ SIĘ</a>";
                    }
                ?>
            </div>
        </div>
    </div>
    
</header>