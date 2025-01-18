<?php

use Core\Response;

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function urlIs($url)
{
    return $_SERVER["REQUEST_URI"] === $url;
}

function abort($status = Response::NOT_FOUND)
{
    http_response_code($status);
    require basePath("controllers/$status.php");
    die();
}

function routeTo($uri, $routes)
{
    if (array_key_exists($uri, $routes)) {
        require basePath($routes[$uri]);
        return;
    }

    abort(404);
}

function authorized($condition, $status = Response::FORBIDDEN)
{
    if (!$condition) {
        abort($status);
    }
}

function basePath($path)
{
    return BASE_PATH . $path;
}

function view($path, $attributes = [])
{
    extract($attributes);
    require basePath("views/" . $path);
}
