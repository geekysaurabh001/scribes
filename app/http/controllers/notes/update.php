<?php

use Core\App;
use Core\Database;
use Core\FileUploader;
use Core\Validator;

$db = App::resolve(Database::class);

require basePath("libs/imagekit.php");


$thumbailPath = NULL;
$thumbailUrl = NULL;
$featuredImageUrl = NULL;
$featuredImagePath = NULL;
$errors = [];
$note = [];
$success = NULL;

$title = htmlspecialchars(trim($_POST["title"]));
$description = htmlspecialchars(trim($_POST["description"]));
$content = htmlspecialchars(trim($_POST["content"]));
$publicId = htmlspecialchars(trim($_POST["publicId"]));

if (!Validator::string($publicId, 12, 12)) {
  $errors["publicId"] = "Not a valid id!";
}

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
  $currentUserId = $_SESSION["user"]["id"];
  if ($thumbailPath && $thumbailUrl && $featuredImagePath && $featuredImageUrl) {
    $db->query("UPDATE notes SET title=:title, description=:description, content=:content, thumbnail_url=:thumbnailUrl, thumbnail_path=:thumbnailPath, featured_image_url=:featuredImageUrl, featured_image_path=:featuredImagePath WHERE user_id=:userId AND public_id=:publicId")->execute([":title" => trim($_POST["title"]), ":description" => trim($_POST["description"]), ":content" => trim($_POST["content"]), ":userId" => $currentUserId, ":thumbnailUrl" => $thumbnailUrl, ":thumbnailPath" => $thumbnailPath, ":featuredImageUrl" => $featuredImageUrl, ":featuredImagePath" => $featuredImagePath, ":publicId" => $publicId, ":table" => "notes"]);
  } else {
    $db->query("UPDATE notes SET title=:title, description=:description, content=:content WHERE user_id=:userId AND public_id=:publicId")->execute([":title" => trim($_POST["title"]), ":description" => trim($_POST["description"]), ":content" => trim($_POST["content"]), ":userId" => $currentUserId, ":publicId" => $publicId, ":table" => "notes"]);
  }
  $note = $db->query("SELECT public_id, user_id, title, description, content, thumbnail_path, featured_image_path, updated_at FROM notes WHERE public_id=:publicId")->execute([":publicId" => $publicId])->fetchOrAbort();
  $success = "Note updated successfully!";
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

view("notes/edit.view.php", [
  "heading" => htmlspecialchars($_POST['title']),
  "errors" => $errors,
  "success" => $success,
  "note" => $note,
  "notesIllustrationUrl" => $notesIllustrationUrl
]);
