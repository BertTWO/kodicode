<?php
require_once(BASE_PATH.'config/Router.php');

$router = new Router();


$router->get('/users', 'UserController', 'getAll');
$router->get('/users/{id}', 'UserController', 'getById');

$router->get('/log-in', 'AuthController', 'viewLogin'); 
$router->post('/log-in', 'AuthController', 'handleLogin'); 

$router->get('/logout','AuthController','handleLogout');

$router->get('/register', 'UserController', 'viewRegister'); 
$router->post('/register', 'UserController', 'handleRegister'); 

$router->get('/teacher/dashboard', 'TeacherController', 'dashboard'); 
$router->get('/student/dashboard', 'StudentController', 'dashboard'); 



$router->dispatch();    
