<?php
session_start();

define("BASE_PATH", __DIR__. '/../');
define("ASSETS_FOLDER",__DIR__.'/../public');

spl_autoload_register(function($class) {

    $corePath = BASE_PATH . 'config/' . $class . '.php';
    if (file_exists($corePath)) {
        require_once $corePath;
        return;
    }


    $controllerPath = BASE_PATH . 'app/controllers/' . $class . '.php';
    if (file_exists($controllerPath)) {
        require_once $controllerPath;
        return;
    }

    $modelPath = BASE_PATH . 'app/models/' . $class . '.php';
    if (file_exists($modelPath)) {
        require_once $modelPath;
        return;
    }
});

require_once BASE_PATH.'vendor/autoload.php'; 
require_once BASE_PATH . 'web/routes.php';


