<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define("ROOT", __DIR__);

require_once ROOT . '/components/Router.php';

$router = new Router();
$router->run();

// Авторизация
// Страница админа
// Страница юзера

//echo "<pre>";
//print_r( $items );
//echo "</pre>";
