<?php
 $routes = array(
    '/dRaczekProjekt/' => array('controller' => 'HomeController', 'action' => 'index'),
    '/dRaczekProjekt/home' => array('controller' => 'HomeController', 'action' => 'index'),
    '/dRaczekProjekt/login' => array('controller' => 'AuthController', 'action' => 'displayLoginPage'),
    '/dRaczekProjekt/register' => array('controller' => 'AuthController', 'action' => 'displayRegisterPage'),
    '/dRaczekProjekt/register/sendForm' => array('controller' => 'AuthController', 'action' => 'registrationProcess'),
    '/dRaczekProjekt/register/verify/:token' => array('controller' => 'AuthController', 'action' => 'registrationVerify'),
    '/dRaczekProjekt/login/sendForm' => array('controller' => 'AuthController', 'action' => 'loginProcess'),
    '/dRaczekProjekt/logout' => array('controller' => 'AuthController', 'action' => 'logout'),
    '/dRaczekProjekt/resetPassword/stepOne' => array('controller' => 'AuthController', 'action' => 'displayStepOnePasswordReset'),
    '/dRaczekProjekt/resetPassword/stepOne/send' => array('controller' => 'AuthController', 'action' => 'stepOnePasswordReset'),
    '/dRaczekProjekt/resetPassword/stepTwo/token/:token' => array('controller' => 'AuthController', 'action' => 'displayStepTwoPasswordReset'),
    '/dRaczekProjekt/resetPassword/stepTwo/send' => array('controller' => 'AuthController', 'action' => 'stepTwoPasswordReset'),
    '/dRaczekProjekt/user' => array('controller' => 'UserController', 'action' => 'displayUserDetailsPage'),
    '/dRaczekProjekt/user/edit' => array('controller' => 'UserController', 'action' => 'displayEditUserDetailsPage'),
    '/dRaczekProjekt/user/edit/send' => array('controller' => 'UserController', 'action' => 'editUserDetailsPage'),
    '/dRaczekProjekt/user/changePassword' => array('controller' => 'UserController', 'action' => 'displayChangeUserPasswordPage'),
    '/dRaczekProjekt/user/changePassword/send' => array('controller' => 'UserController', 'action' => 'changeUserPassword'),
);
?>