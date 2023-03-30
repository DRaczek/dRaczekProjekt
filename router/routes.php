<?php
 $routes = array(
    '/dRaczekProjekt/' => array('controller' => 'HomeController', 'action' => 'index'),
    '/dRaczekProjekt/home' => array('controller' => 'HomeController', 'action' => 'index'),
    '/dRaczekProjekt/login' => array('controller' => 'AuthController', 'action' => 'displayLoginPage'),
    '/dRaczekProjekt/register' => array('controller' => 'AuthController', 'action' => 'displayRegisterPage'),
    '/dRaczekProjekt/register/sendForm' => array('controller' => 'AuthController', 'action' => 'registrationProcess'),
    '/dRaczekProjekt/register/verify/:token' => array('controller' => 'AuthController', 'action' => 'registrationVerify'),
    '/dRaczekProjekt/login/sendForm' => array('controller' => 'AuthController', 'action' => 'loginProcess'),
    '/dRaczekProjekt/logout' => array('controller' => 'AuthController', 'action' => 'logout')
);
?>