<?php

require basePath("libs/imagekit.php");

$loginIllustrationUrl = $imagekit->url([
    "path" => "/php-notes-app/login.png",
    'transformation' => [
        [
            'height' => '616',
            'width' => '616'
        ]
    ]
]);

$success = $_SESSION["_flash"]["success"] ?? NULL;
$errors = $_SESSION["_flash"]["errors"] ?? [];
$data = $_SESSION["_data"]["login"] ?? [];

unset($_SESSION["_flash"]);
unset($_SESSION["_data"]);

view("auth/login/index.view.php", [
    "heading" => "Login",
    "loginIllustrationUrl" => $loginIllustrationUrl,
    "success" => $success,
    "errors" => $errors,
    "submittedData" => $data
]);
