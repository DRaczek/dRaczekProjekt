<?php
    require_once("router/routes.php");
    require_once("router/Router.php");

    include("MVC/controllers/HomeController.php");
    include("MVC/controllers/AuthController.php");
    include("MVC/controllers/UserController.php");
    include("MVC/controllers/AdminController.php");

    include("MVC/models/StatusEnum.php");
    include("MVC/models/TokenActionEnum.php");

    include("MVC/models/UserModel.php");
    include("MVC/models/TokenModel.php");
    include("MVC/models/AdminModel.php");
    
    include("MVC/models/MailSender.php");

    session_start();
    
    $router = new Router('/app');
   
    $requestUri = $_SERVER['REQUEST_URI'];
    if (!$router->routeRequest($requestUri, $routes)) {
        echo "Nie znaleziono strony!";
    }
?>