<?php
 $routes = array(
    '/dRaczekProjekt/' => array('controller' => 'HomeController', 'action' => 'index'),
    '/dRaczekProjekt/home' => array('controller' => 'HomeController', 'action' => 'index'),
    '/dRaczekProjekt/login' => array('controller' => 'AuthController', 'action' => 'displayLoginPage'),
    '/dRaczekProjekt/register' => array('controller' => 'AuthController', 'action' => 'displayRegisterPage')
);
?>