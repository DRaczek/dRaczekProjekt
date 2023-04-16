<?php
    require_once("router/routes.php");
    require_once("router/Router.php");

    include_once("MVC/models/enumerated/StatusEnum.php");
    include_once("MVC/models/enumerated/TokenActionEnum.php");
    include_once("MVC/models/enumerated/ProductColourEnum.php");
    include_once("MVC/models/enumerated/ProductSizeEnum.php");

    session_start();
    
    $router = new Router();
   
    $requestUri = $_SERVER['REQUEST_URI'];
    if (!$router->routeRequest($requestUri, $routes)) {
        echo "Nie znaleziono strony!";
    }
?>