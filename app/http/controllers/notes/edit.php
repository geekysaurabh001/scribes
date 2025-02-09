<?php

use Core\App;
use Core\Database;
use Core\Validator;

require basePath("libs/imagekit.php");

$db = App::resolve(Database::class);

$note = [];

if (!$_GET["id"]) {
    header("Location: /notes");
    exit();
}

$note = $db->query("SELECT public_id, user_id, title, description, content, thumbnail_path, featured_image_path, updated_at FROM notes WHERE public_id=:publicId")->execute([":publicId" => trim($_GET["id"])])->fetchOrAbort();


if (is_array($note) && empty($note)) {
    header("Location: /notes");
    exit();
}

$currentUserId = $_SESSION["user"]["id"];
Validator::authorized($note["user_id"] === $currentUserId);


$notesIllustrationUrl = $imagekit->url([
    "path" => "/php-notes-app/notes.png",
    'transformation' => [
        [
            'height' => '616',
            'width' => '616'
        ]
    ]
]);

view("notes/edit.view.php", [
    "heading" => $note["title"],
    "note" => $note,
    "success" => NULL,
    "notesIllustrationUrl" => $notesIllustrationUrl
]);
