<?php

session_start();

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define("ROOT", __DIR__);

require_once ROOT . '/components/Router.php';

if(!empty($_SESSION['message'])) {
    print($_SESSION['message']);
    unset($_SESSION['message']);
}


$router = new Router();
$router->run();
