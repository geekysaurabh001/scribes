<?php

use Core\App;
use Core\Database;
use Core\FileUploader;
use Core\Validator;

require basePath("libs/imagekit.php");
$db = App::resolve(Database::class);

$thumbailPath = NULL;
$thumbailUrl = NULL;
$featuredImageUrl = NULL;
$featuredImagePath = NULL;
$errors = [];
$success = NULL;

$title = htmlspecialchars(trim($_POST["title"]));
$description = htmlspecialchars(trim($_POST["description"]));
$content = htmlspecialchars(trim($_POST["content"]));

if (!Validator::string($title, 1, 255)) {
  $errors["title"] = "Title is missing!";
}
if (!Validator::string($description, 1, 255)) {
  $errors["description"] = "Description is missing!";
}
if (!Validator::string($content, 1, 1024)) {
  $errors["content"] = "Content is missing!";
}

$fileUploader = new FileUploader($imagekit);
$thumbnail = $fileUploader->uploadFile($_FILES, "/php-notes-app", "thumbnail");
$featuredImage = $fileUploader->uploadFile($_FILES, "/php-notes-app", "featuredImage");

if ($thumbnail) {
  $thumbnailPath = $thumbnail["filePath"];
  $thumbnailUrl = $thumbnail["url"];
}

if ($featuredImage) {
  $featuredImagePath = $featuredImage["filePath"];
  $featuredImageUrl = $featuredImage["url"];
}
$fileErrors = $fileUploader->getErrors();
if (Validator::array($fileErrors)) {
  if ($fileErrors["thumbnail"])
    $errors[] = $fileErrors["thumbnail"];
  if ($fileErrors["featuredImage"])
    $errors[] = $fileErrors["featuredImage"];
}


if (empty($errors)) {
  Validator::array($_SESSION) && Validator::array($_SESSION["user"]) && Validator::string($_SESSION["user"]["id"], 12, 12);

  $userId = $_SESSION["user"]["id"];

  if ($thumbailPath && $thumbailUrl && $featuredImagePath && $featuredImageUrl) {
    $db->query("INSERT INTO notes (title, description, content, user_id, public_id, thumbnail_url, thumbnail_path, featured_image_url, featured_image_path) VALUES(:title, :description, :content, :userId, :publicId, :thumbnailUrl, :thumbnailPath, :featuredImageUrl, :featuredImagePath)")->execute([":title" => trim($_POST["title"]), ":description" => trim($_POST["description"]), ":content" => trim($_POST["content"]), ":userId" => $userId, ":thumbnailUrl" => $thumbnailUrl, ":thumbnailPath" => $thumbnailPath, ":featuredImageUrl" => $featuredImageUrl, ":featuredImagePath" => $featuredImagePath]);
  } else {
    // dd("here");
    $db->query("INSERT INTO notes (title, description, content, user_id, public_id) VALUES(:title, :description, :content, :userId, :publicId)")->execute([":title" => trim($_POST["title"]), ":description" => trim($_POST["description"]), ":content" => trim($_POST["content"]), ":userId" => $userId]);
  }
  $success = "Notes created successfully!";
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
