<?php

class Router {

    private $routes;

    public function __construct() {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    private function getUrl() {
        if( !empty( $_SERVER['REQUEST_URI']) ) {
            $uri = explode('?', $_SERVER['REQUEST_URI']);
            return trim( $uri[0], '/');
        }
    }

    public function run() {
        $uri = $this->getUrl();
        foreach( $this->routes as $route => $action ) {
            if ($route == $uri) {
                include_once ROOT . '/controllers/ItemController.php';
                $controller = new ItemController();
                $controller->$action();
                break;
            }
        }
    }

}
