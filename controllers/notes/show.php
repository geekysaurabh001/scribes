<?php

use Core\Database;

$config = require basePath("config.php");

$db = new Database($config["database"]["host"], $config["database"]["dbname"], $config["database"]["user"]);
$note = [];

if ($_SERVER["REQUEST_METHOD"] === "GET") {
  if (!$_GET["id"]) {
    abort();
  }

  $note = $db->query("SELECT public_id, user_id, title, description, content, thumbnail_path, featured_image_path, updated_at FROM `notes` WHERE `public_id`=:publicId")->execute([":publicId" => trim($_GET["id"])])->fetchOrAbort();


  if (is_array($note) && empty($note)) {
    header("Location: /notes");
    exit();
  }

  $currentUserId = 7;
  authorized($note["user_id"] === $currentUserId);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $action = htmlspecialchars(trim($_POST["action"]));
  $publicId = htmlspecialchars(trim($_POST["publicId"]));

  $note = $db->query("SELECT user_id FROM `notes` WHERE `public_id`=:publicId")->execute([":publicId" => $publicId])->fetchOrAbort();

  if (is_array($note) && empty($note)) {
    header("Location: /notes");
    exit();
  }
  $currentUserId = 7;
  authorized($note["user_id"] === $currentUserId);

  if ($action === "delete") {
    // dd($publicId);
    $result = $db->query("DELETE FROM `notes` WHERE `public_id`=:publicId AND `user_id`=:userId")->execute([":publicId" => $publicId, ":userId" => $currentUserId, ":table" => "notes"]);

    header("Location: /notes");
    exit();
  }
}

view("notes/show.view.php", [
  "heading" => $note["title"] ?? "No note found!",
  "note" => $note
]);
