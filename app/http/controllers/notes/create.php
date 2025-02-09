<?php

require basePath("libs/imagekit.php");

$notesIllustrationUrl = $imagekit->url([
  "path" => "/php-notes-app/notes.png",
  'transformation' => [
    [
      'height' => '616',
      'width' => '616'
    ]
  ]
]);

$errors = $_SESSION["_flash"]["errors"] ?? [];
$data = $_SESSION["_data"]["note_create"] ?? [];

view("notes/create.view.php", [
  "heading" => "Create Note",
  "errors" => $errors,
  "success" => NULL,
  "data" => $data,
  "notesIllustrationUrl" => $notesIllustrationUrl
]);
