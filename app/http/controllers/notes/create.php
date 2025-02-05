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


view("notes/create.view.php", [
  "heading" => "Create Note",
  "errors" => [],
  "success" => NULL,
  "notesIllustrationUrl" => $notesIllustrationUrl
]);
