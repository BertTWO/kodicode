<?php

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

class Router {

    protected $router;

    public function __construct() {

            $this->router = new RouteCollector();
    }
    public function get($path, $controller, $action = null) {
        $this->router->get($path, [$controller, $action]);
    }
    public function post($path, $controller, $action = null) {
        $this->router->post($path, [$controller, $action]);
    }
    public function put($path, $controller, $action = null) {
        $this->router->put($path, [$controller, $action]);
    }

    public function delete($path, $controller, $action = null) {
        $this->router->delete($path, [$controller, $action]);
    }
   public function dispatch() {
    $dispatcher = new Dispatcher($this->router->getData());

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];

 
    $root = '/kodicode';
    if (strpos($uri, $root) === 0) {
        $uri = substr($uri, strlen($root));
    }

    if ($uri == '') {
        $uri = '/';
    }

    try {
        $response = $dispatcher->dispatch($method, $uri);
        echo $response;
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

}
