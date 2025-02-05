<?php

use Core\Response;

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function abort($status = Response::NOT_FOUND)
{
    http_response_code($status);
    require basePath("http/controllers/$status.php");
    die();
}

function basePath($path)
{
    return BASE_PATH . $path;
}

function view(string $path, $attributes = [])
{
    extract($attributes);
    require basePath("views/" . $path);
}

function redirect(string $path)
{
    header("location: $path");
    exit();
}
