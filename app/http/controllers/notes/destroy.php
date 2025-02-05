<?php

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

// $action = htmlspecialchars(trim($_POST["_method"]));
$publicId = htmlspecialchars(trim($_POST["publicId"]));

if (!Validator::string($publicId, 12, 12)) {
  $errors["publicId"] = "Not a valid id!";
}

$note = $db->query("SELECT user_id FROM `notes` WHERE `public_id`=:publicId")->execute([":publicId" => $publicId])->fetchOrAbort();

if (!Validator::array($note)) {
  header("Location: /notes");
  exit();
}

$currentUserId = 7;
Validator::authorized($note["user_id"] === $currentUserId);

if ($action === "delete") {
  // dd($publicId);
  $result = $db->query("DELETE FROM `notes` WHERE `public_id`=:publicId AND `user_id`=:userId")->execute([":publicId" => $publicId, ":userId" => $currentUserId, ":table" => "notes"]);

  header("Location: /notes");
  exit();
}
