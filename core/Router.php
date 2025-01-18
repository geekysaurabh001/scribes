<?php

namespace Core;

class Router {}


$routes = require basePath("routes.php");

$uri = parse_url($_SERVER["REQUEST_URI"])["path"];
routeTo($uri, $routes);
