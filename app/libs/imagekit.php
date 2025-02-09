<?php


$config = require basePath("libs/config.php");

use ImageKit\ImageKit;

$imagekit = new ImageKit(
  $config["imageKit"]["publicKey"],
  $config["imageKit"]["privateKey"],
  $config["imageKit"]["urlEndPoint"],
);
