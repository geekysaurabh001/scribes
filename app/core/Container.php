<?php

namespace Core;

use Exception;

class Container
{
    private $bindings = [];

    public function bind(string $key, $resolver)
    {
        $this->bindings[$key] = $resolver;
    }
    public function resolve(string $key)
    {
        if (!array_key_exists($key, $this->bindings)) {
            throw new Exception("No matching binding found for $key");
        }
        $resolve = $this->bindings[$key];
        return call_user_func($resolve);
    }
}
