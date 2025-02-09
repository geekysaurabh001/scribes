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

$success = $_SESSION["_flash"]["success"] ?? NULL;
$errors = $_SESSION["_flash"]["errors"] ?? [];
$data = $_SESSION["_data"]["register"] ?? [];



unset($_SESSION["_flash"]);
unset($_SESSION["_data"]);

// dd($data);

view("auth/register/index.view.php", [
  "heading" => "Register",
  "registerIllustrationUrl" => $registerIllustrationUrl,
  "success" => $success,
  "errors" => $errors,
  "submittedData" => $data
]);
