<?php

use Core\App;
use Core\Container;
use Core\Database;


$container = new Container();

$container->bind("Core\Database", function () {
  $config = require basePath("libs/config.php");

  return new Database($config["database"]["host"], $config["database"]["port"], $config["database"]["dbname"], $config["database"]["user"], $config["database"]["password"]);
});

// $container->bind("ImageKit\Client", function () {
//   $config = require basePath("libs/config.php");
//   return new Client($config["imageKit"]["publicKey"], $config["imageKit"]["privateKey"], $config["imageKit"]["urlEndPoint"]);
// });

App::setContainer($container);
