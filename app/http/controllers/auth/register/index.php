<?php

require basePath("libs/imagekit.php");

$registerIllustrationUrl = $imagekit->url([
  "path" => "/php-notes-app/register.png",
  'transformation' => [
    [
      'height' => '616',
      'width' => '616'
    ]
  ]
]);

view("auth/register/index.view.php", [
  "heading" => "Register",
  "registerIllustrationUrl" => $registerIllustrationUrl,
  "success" => NULL
]);
