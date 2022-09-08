<?php

session_start();

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define("ROOT", __DIR__);

require_once ROOT . '/components/Router.php';

//if(!empty($_SESSION['message'])) {
//    echo "<pre>";
//    print_r( $_SESSION['message'] );
//    echo "</pre>";
//
//    unset($_SESSION['message']);
//}

//if( isset($_SESSION['username']) && !empty($_SESSION['username'])) {
//    echo 'user logged in';
//}


$router = new Router();
$router->run();



// Авторизация
// Страница админа
// Страница юзера


