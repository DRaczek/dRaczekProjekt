    <?php

    class UpdateCartValueController{
        public function __construct(){

        }

        public function update(){
            if(!isset($_POST['quantity']) || !isset($_POST['id'])){
                http_response_code(400);
                exit();
            }
            else{
                $id = $_POST['id'];
                $quantity = $_POST['quantity'];
                $koszyk = unserialize($_COOKIE['cart']);
                // zmienia wszystkie pozycje koszyka o podanym id
                $zaktualizowanyKoszyk = array_map(function($item) use ($id, $quantity) {
                    if($item['id'] == $id) {
                        $item['quantity'] = $quantity;
                    }
                    return $item;
                }, $koszyk);
                
                // jezeli quantity<0 to pozycja jest usuwana z koszyka
                $przefiltrowanyKoszyk = array_filter($zaktualizowanyKoszyk, function($item) {
                    return $item['quantity'] > 0;
                });

                setcookie("cart", serialize($przefiltrowanyKoszyk), time()+30*24*60*60, "/");

                print_r($przefiltrowanyKoszyk);
            }
        }
    }