<?php

session_start();

const BASE_PATH = __DIR__ . "/../";

require BASE_PATH . "libs/function.php";
require basePath("libs/jwt.php");
require basePath("libs/constants.php");


spl_autoload_register(function ($class) {
    $classPath = explode("\\", $class);
    $classPath[0] = strtolower($classPath[0]);
    $loadClass = implode("\\", $classPath);
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $loadClass);
    // var_dump($class);
    require basePath("$class.php");
});

require basePath("libs/bootstrap.php");

use Core\Router;

$router = new Router();
$routes = require basePath("libs/routes.php");
$uri = parse_url($_SERVER["REQUEST_URI"])["path"];
$method = $_POST["_method"] ?? $_SERVER["REQUEST_METHOD"];
// dd($method);
$router->routeTo($uri, $method);
