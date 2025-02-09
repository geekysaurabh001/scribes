<?php

use Core\App;
use Core\Authenticator;
use Core\Database;
use Http\Forms\LoginForm;

$db = App::resolve(Database::class);

$email = htmlspecialchars(trim($_POST["email"]));
$password = htmlspecialchars(trim($_POST["password"]));


$form = new LoginForm();
$auth = new Authenticator(App::resolve(Database::class));

if ($form->validate($email, $password)) {
    if ($auth->attemptToLocateExistingUserByEmail($email)) {
        if ($auth->attemptToValidatePassword($password)) {
            redirect("/notes");
        }
        $form->addError("password", "Password doesn't match");
        goto errors;
    }
    $form->addError("email", "No user found with that email address");
}

errors:
$_SESSION["_data"]["login"] = [
    "email" => $email,
    "password" => $password
];
$_SESSION["_flash"]["errors"] = $form->getErrors();
redirect("/login");
