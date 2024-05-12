<?php
session_start();
const BASE_PATH = __DIR__.'/../';
require BASE_PATH.'/vendor/autoload.php';
require BASE_PATH . 'Core/function.php';


//spl_autoload_register(function ($class)
//{
//    // Core\Database
//
//    $result = str_replace('\\', '/', $class);
//
//    require base_path($result.'.php');
//
//
//});


require base_path('loader.php');


$router = new \Core\Router();
$routes = require base_path('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
unset($_SESSION['error']);


//video 42