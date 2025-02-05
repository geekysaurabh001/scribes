<?php

namespace Core;

use Middleware\Middleware;

class Router
{

    private $routes = [];

    public function add(string $uri, string $controller, string $method, ?string $middleware = NULL)
    {
        $this->routes[] = compact("uri", "controller", "method", "middleware");
        return $this;
    }

    public function get(string $uri, string $controller)
    {
        return $this->add($uri, $controller, "GET");
    }

    public function post(string $uri, string $controller)
    {
        return $this->add($uri, $controller, "POST");
    }

    public function delete(string $uri, string $controller)
    {
        return  $this->add($uri, $controller, "DELETE");
    }

    public function put(string $uri, string $controller)
    {
        return $this->add($uri, $controller, "PUT");
    }

    public function patch(string $uri, string $controller)
    {
        return $this->add($uri, $controller, "PATCH");
    }

    public function routeTo($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route["uri"] === $uri && $route["method"] === strtoupper($method)) {
                Middleware::resolve($route["middleware"]);
                return require basePath("http/controllers/" . $route["controller"]);
            }
        }

        abort(404);
    }

    public function only(string $key)
    {
        $this->routes[array_key_last($this->routes)]["middleware"] = $key;
        return $this;
    }
}
