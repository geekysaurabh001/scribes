<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$db->init();

view("index.view.php", [
  "heading" => "Home"
]);
