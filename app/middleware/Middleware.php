<?php

namespace Middleware;

use Middleware\Auth;
use Middleware\Guest;

class Middleware
{
  public const MAP = [
    "auth" => Auth::class,
    "guest" => Guest::class,
  ];

  public static function resolve($key)
  {
    if (!$key) {
      return;
    }
    $middleware = static::MAP[$key] ?? NULL;

    if (!$middleware) {
      throw new \Exception("No middleware found for key: {$key}");
    }

    (new $middleware())->handle();
  }
}
