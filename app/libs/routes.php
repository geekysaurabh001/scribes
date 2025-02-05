<?php

# common
global $router;

$router->get("/", "index.php");
$router->get("/about", "about.php");
$router->get("/contact", "contact.php");

# notes
$router->get("/notes", "notes/index.php")->only("auth"); // show all of the notes
$router->post("/notes", "notes/store.php")->only("auth"); // adding a new note into the notes
$router->get("/note", "notes/show.php")->only("auth"); // show single note
$router->delete("/note", "notes/destroy.php")->only("auth"); // delete a note
$router->patch("/note", "notes/update.php")->only("auth"); // update a note
$router->get("/note/create", "notes/create.php")->only("auth"); // show a form to create a new note
$router->get("/note/edit", "notes/edit.php")->only("auth"); // show an edit form to edit the old note

# auth
$router->get("/login", "auth/login/index.php")->only("guest");
$router->post("/login", "auth/login/store.php")->only("guest");
$router->get("/register", "auth/register/index.php")->only("guest");
$router->post("/register", "auth/register/store.php")->only("guest");
$router->delete("/logout", "/auth/logout/index.php")->only("auth");

# account
$router->get("/account", "account/index.php")->only("auth");
