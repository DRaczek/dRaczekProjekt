<?php

class Router {
    public function __construct(){
        // if(preg_match('#^(\?page=(\d)+&size=(\d)+((&text=([\p{L}\p{N}]+))*))$#u', "?page=1&size=10")){
        //     echo "x";
        // }
        // else{
        //     echo "y";
        // }
        // die();
    }

    /**
     * Funkcja służąca do routingu.
    */
    function routeRequest($requestUri, $routes) {
        $requestUri=urldecode($requestUri);
        //petla sprawdza czy podany adres pasuje do $routes
        foreach ($routes as $route => $params) {
            // zamienia zmienne w adresie URL na wyrażenia regularne
            //np. '/users/123' na '/users/(\d+)', co później jest wykorzystane do przypisania argumentu do wyrażenia regularnego
            $pattern = str_replace(':id', '(\d+)', $route);
            $pattern = str_replace(":token", '([A-Za-z\d]+)', $pattern);
            $pattern = str_replace(":pageableProductsUser", '(\?page=(\d)+&size=(\d)+((&text=([\p{L}\p{N}\s]*))*)((&categoryId=(\d)+)*)((&gender=(\d)+)*)((&price_from=(\d)+)*)((&price_to=(\d)+)*)((&productSize=(\d)+)*)((&colour=(\d)+)*)((&orderBy=([\p{L}\p{N}_])+)*)((&order=([\p{L}])+)*))', $pattern);
            $pattern = str_replace(":pageableCategories", '\?((page=(\d)+)(&size=(\d)+)((&name=([A-Za-z\d])+)*)((&status=(\d)+)*)((&createdDate=([\d-])+)*)((&id=(\d)+)*)((&orderBy=([A-Za-z_])+)*)((&order=([A-Za-z])+)*))', $pattern);
            $pattern = str_replace(":pageableProducts", '\?((page=(\d)+)(&size=(\d)+)((&name=([A-Za-z\d])+)*)((&categoryId=(\d)+)*)((&description=([a-zA-Z0-9.,:;"\'() \n-])+)*)((&priceFrom=(\d+(?:\.\d+)?))*)((&priceTo=(\d+(?:\.\d+)?))*)((&quantityFrom=(\d)+)*)((&quantityTo=(\d)+)*)((&productSize=(\d)+)*)((&colour=(\d)+)*)((&gender=(\d)+)*)((&viewCountFrom=(\d)+)*)((&viewCountTo=(\d)+)*)((&status=(\d)+)*)((&createdDate=([\d-])+)*)((&id=(\d)+)*)((&orderBy=([A-Za-z_])+)*)((&order=([A-Za-z])+)*))', $pattern);
            $pattern = str_replace(":pageableOrders", '\?((page=(\d)+)(&size=(\d)+)((&first_name=([A-Za-z\d])+)*)((&last_name=([A-Za-z\d])+)*)((&street=([A-Za-z\d])+)*)((&postal_code=([-\d])+)*)((&postal_city=([A-Za-z\d])+)*)((&country=([A-Za-z\d])+)*)((&nip=([\d])+)*)((&company_name=([A-Za-z\d])+)*)((&delivery_id=(\d)+)*)((&payment_method_id=(\d)+)*)((&payment_status=(\d)+)*)((&order_status=(\d)+)*)((&status=(\d)+)*)((&createdDate=([\d-])+)*)((&id=(\d)+)*)((&orderBy=([A-Za-z_])+)*)((&order=([A-Za-z])+)*))', $pattern);
            
            // dopasowuje adres URL do wzorca i pobiera pasujące zmienne
            // ^ - początek łancucha znaków
            // $ - koniec łańcucha znaków
            // # - delimiter (php wyrzuca błąd, jeżeli ich nie ma), oddzielają wyrażenia regularne od ich flag
            // Jeśli adres URL pasuje do wzorca, funkcja preg_match() przypisuje dopasowane wartości do zmiennej $matches,
            // która jest tablicą asocjacyjną, w której klucze odpowiadają kolejnym dopasowanym wyrażeniom regularnym w $pattern,
            // a wartości to pasujące wartości w adresie URL.
            if (preg_match('#^'.$pattern.'$#u', $requestUri, $matches)) {
                $controllerUri="";
                if(isset($params['path']))$controllerUri = $params['path'];
                else $controllerUri = "MVC/controllers/";
                $controllerUri.=$params['controller'];
                include_once($controllerUri.".php");
                $controller = new $params['controller']();
                $action = $params['action'];
                // usuwa pierwszy element, bo pierwszy element zawiera cały URL.
                $params = array_slice($matches, 1);
                //wywołuje $controller->$action($params);
                call_user_func_array(array($controller, $action), $params);
                return true;
            }
        }
        return false;
    }
  }