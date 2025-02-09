<?php

use Core\App;
use Core\Database;
use Core\FileUploader;
use Core\Validator;
use Http\Forms\NotesForm;


$form = new NotesForm(App::resolve(Database::class));

$title = htmlspecialchars(trim($_POST["title"]));
$description = htmlspecialchars(trim($_POST["description"]));
$content = htmlspecialchars(trim($_POST["content"]));

if ($form->validateUser()) {
  $userId =  $_SESSION["user"]["id"];
  if ($form->validateFormNoteEntries($title, $description, $content)) {
    if ($form->validateFormFiles("thumbnail", "featuredImage")) {
      if ($form->insertDataWithFiles($title, $description, $content, $userId)) {
        redirect("/notes");
      }
      goto errors;
    }

    if ($form->insertDataWithoutFiles($title, $description, $content, $userId)) {
      redirect("/notes");
    }
    goto errors;
  }
}

errors:
$_SESSION["_data"]["note_create"] = [
  "title" => $title,
  "description" => $description,
  "content" => $content
];
$_SESSION["_flash"]["errors"] = $form->getNotesFormErrors();

redirect("/note/create");
