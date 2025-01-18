<?php

use Core\Database;

$config = require basePath("config.php");

$db = new Database($config["database"]["host"], $config["database"]["dbname"], $config["database"]["user"]);

$randomInteger = mt_rand(6, 7);
$notes = $db->query("SELECT public_id as publicId, title FROM `notes` WHERE `user_id`=:userId")
  ->execute([":userId" => $randomInteger])->fetchAll();

if (!is_array($notes) || empty($notes)) {
  $notes = [];
}

view("notes/index.view.php", [
  "heading" => "Notes",
  "notes" => $notes
]);
