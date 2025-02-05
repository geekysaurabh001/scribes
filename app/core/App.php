<?php

namespace Core;

class App
{
  private static $container;

  public static function setContainer($container): void
  {
    static::$container = $container;
  }

  private static function getContainer()
  {
    return static::$container;
  }

  public static function bind(string $key, $resolver)
  {
    static::getContainer()->bind($key, $resolver);
  }

  public static function resolve(string $key)
  {
    return static::getContainer()->resolve($key);
  }
}
