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

//require_once ROOT . '/components/DB.php';
//
//$db = DB::getConnection();
//$sql = "SELECT * FROM items";
//$stm = $db->query($sql);
//$items = $stm->fetchAll(PDO::FETCH_ASSOC);
////
////$result = [];
////foreach($items as $item) {
////    if( empty($item['parent'])) {
////        $result['root'][] = $item;
////    } else {
////        $result['root'][$item['parent']][] = $item;
////    }
////}
////
//echo "<pre>";
//print_r( $items );
//echo "</pre>";
