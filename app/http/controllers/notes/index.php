<?php

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$id = $_SESSION["user"]["id"];
// dd($id);
$notes = $db->query("SELECT notes.public_id as publicId, title FROM notes JOIN users ON notes.user_id = users.id WHERE users.id= :id")
    ->execute([":id" => $id])->fetchAll();
// dd($notes);
if (!Validator::array($notes)) {
    $notes = [];
}

// dd($_COOKIE);

view("notes/index.view.php", [
    "heading" => "Notes",
    "notes" => $notes
]);
