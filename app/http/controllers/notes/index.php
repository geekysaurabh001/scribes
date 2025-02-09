<?php

use Core\App;
use Core\Database;
use Http\Forms\NotesForm;

$form = new NotesForm(App::resolve(Database::class));

$form->fetchAllNotes($_SESSION["user"]["id"]);

view("notes/index.view.php", [
    "heading" => "Notes",
    "notes" => $form->getNotes()
]);
