<?php

const BASE_PATH = __DIR__ . "/../";
require BASE_PATH . "core/function.php";
require basePath("core/imagekit.php");


// require basePath("NanoIdGenerator.php");
// require basePath("Database.php");
// require basePath("Response.php");



spl_autoload_register(function ($class) {
  $classPath = explode("\\", $class);
  $classPath[0] = strtolower($classPath[0]);
  $loadClass = implode("\\", $classPath);
  $class = str_replace('\\', DIRECTORY_SEPARATOR, $loadClass);

  require basePath("$class.php");
});

require basePath("core/router.php");
