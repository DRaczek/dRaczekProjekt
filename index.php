<?php
    require_once("router/routes.php");
    require_once("router/Router.php");

    $router = new Router('/app');
   
    $requestUri = $_SERVER['REQUEST_URI'];
    if (!$router->routeRequest($requestUri, $routes)) {
        echo "Nie znaleziono strony!";
    }
?>