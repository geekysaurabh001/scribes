<?php

use Core\Database;

$config = require basePath("config.php");
require basePath("core/imagekit.php");

$errors = [];
$success = NULL;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $thumbailPath = NULL;
  $thumbailUrl = NULL;
  $featuredImageUrl = NULL;
  $featuredImagePath = NULL;

  if (strlen($_POST["title"]) === 0) {
    $errors["title"] = "Title is missing!";
  }
  if (strlen($_POST["description"]) === 0) {
    $errors["description"] = "Description is missing!";
  }
  if (strlen($_POST["content"]) === 0) {
    $errors["content"] = "Content is missing!";
  }

  if (isset($_FILES["thumbnail"]) && !empty($_FILES["thumbnail"]) && $_FILES["thumbnail"]["size"] !== 0) {
    print($_FILES["thumbnail"]["error"]);
    if (!!$_FILES["thumbnail"]["error"]) {
      $errors["thumbnail"] = $fileErrors[$_FILES["thumbnail"]["error"]];
    }
    if (is_uploaded_file($_FILES["thumbnail"]["tmp_name"])) {
      $thumbnailUpload = $imagekit->uploadFile([
        "file" => base64_encode(file_get_contents($_FILES["thumbnail"]["tmp_name"])),
        "fileName" => formatFileName($_FILES["thumbnail"]["name"]),
        "folder" => "/php-notes-app",
        "isPrivate" => false,
      ]);
      if (!empty($thumbnailUpload->error)) {
        $errors["thumbnail"] = "Thumbnail image upload failed!";
      }
      $thumbnailPath = $thumbnailUpload->result->filePath;
      $thumbnailUrl = $thumbnailUpload->result->url;
    }
  }

  if (isset($_FILES["featuredImage"]) && !empty($_FILES["featuredImage"]) && $_FILES["featuredImage"]["size"] !== 0) {
    print($_FILES["featuredImage"]["error"]);
    if (!!$_FILES["featuredImage"]["error"]) {
      $errors["featuredImage"] = $fileErrors[$_FILES["featuredImage"]["error"]];
    }
    if (is_uploaded_file($_FILES["featuredImage"]["tmp_name"])) {
      $featuredImageUpload = $imagekit->uploadFile([
        "file" => base64_encode(file_get_contents($_FILES["featuredImage"]["tmp_name"])),
        "fileName" => formatFileName($_FILES["featuredImage"]["name"]),
        "folder" => "/php-notes-app",
        "isPrivate" => false,
      ]);
      if (!empty($featuredImageUpload->error)) {
        $errors["featuredImage"] = "Featured image upload failed!";
      }
      $featuredImagePath = $thumbnailUpload->result->filePath;
      $featuredImageUrl = $thumbnailUpload->result->url;
    }
  }


  if (empty($errors)) {
    $db = new Database($config["database"]["host"], $config["database"]["dbname"], $config["database"]["user"]);
    // $randomInteger = mt_rand(6, 7);
    $randomInteger = 7;
    if ($thumbailPath && $thumbailUrl && $featuredImagePath && $featuredImageUrl) {
      $db->query("INSERT INTO `notes` (title, description, content, user_id, public_id, thumbnail_url, thumbnail_path, featured_image_url, featured_image_path) VALUES(:title, :description, :content, :userId, :publicId, :thumbnailUrl, :thumbnailPath, :featuredImageUrl, :featuredImagePath)")->execute([":title" => trim($_POST["title"]), ":description" => trim($_POST["description"]), ":content" => trim($_POST["content"]), ":userId" => $randomInteger, ":thumbnailUrl" => $thumbnailUrl, ":thumbnailPath" => $thumbnailPath, ":featuredImageUrl" => $featuredImageUrl, ":featuredImagePath" => $featuredImagePath]);
    } else {
      $db->query("INSERT INTO `notes` (title, description, content, user_id, public_id) VALUES(:title, :description, :content, :userId, :publicId)")->execute([":title" => trim($_POST["title"]), ":description" => trim($_POST["description"]), ":content" => trim($_POST["content"]), ":userId" => $randomInteger]);
    }
    $success = "Notes created successfully!";
  }
}


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
  "errors" => $errors,
  "success" => $success,
  "notesIllustrationUrl" => $notesIllustrationUrl
]);
