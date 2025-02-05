<?php

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$note = [];

if (!$_GET["id"]) {
  header("Location: /notes");
  exit();
}

$note = $db->query("SELECT public_id, user_id, title, description, content, thumbnail_path, featured_image_path, updated_at FROM `notes` WHERE `public_id`=:publicId")->execute([":publicId" => trim($_GET["id"])])->fetchOrAbort();


if (is_array($note) && empty($note)) {
  header("Location: /notes");
  exit();
}
$id = $_SESSION["user"]["id"];
Validator::authorized($note["user_id"] === $id);

view("notes/show.view.php", [
  "heading" => $note["title"] ?? "No note found!",
  "note" => $note
]);
