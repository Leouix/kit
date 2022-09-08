<?php

include_once ROOT . '/controllers/ItemController.php';
include_once ROOT . '/controllers/Auth.php';

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
        return false;
    }

    public function run() {
        $uri = $this->getUrl();
        foreach( $this->routes as $route => $action ) {
            if ($route == $uri) {
                $this->$action();
                break;
            }
        }
    }

    public function publicPanel() {
        ItemController::publicPanel();
    }

    public function login() {
        if(!empty($_SESSION['username'])) {
            header('Location: /');
        } else {
            Auth::login();
        }
    }

    public function logout() {
        Auth::logout();
    }

    public function register() {
        if(!empty($_SESSION['username'])) {
            header('Location: /');
        } else {
            Auth::register();
        }
    }

    public function adminPanel() {
        if(!empty($_SESSION['username'])) {
            ItemController::index();
        } else {
            Auth::login();
        }
    }

    public function addItem() {
        if(!empty($_SESSION['username'])) {
            $controller = new ItemController();
            $controller->addItem();
        }
    }

    public function editItem() {
        if(!empty($_SESSION['username'])) {
            $controller = new ItemController();
            $controller->editItem();
        }
    }

    public function deleteItem() {
        if(!empty($_SESSION['username'])) {
            $controller = new ItemController();
            $controller->deleteItem();
        }
    }

}
