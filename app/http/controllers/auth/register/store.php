<?php

use Core\App;
use Core\Authenticator;
use Core\Database;
use Http\Forms\RegisterForm;

$name = htmlspecialchars($_POST["name"] ?? "");
$username = htmlspecialchars($_POST["username"] ?? "");
$email = htmlspecialchars($_POST["email"] ?? "");
$password = htmlspecialchars($_POST["password"] ?? "");
$confirmPassword = htmlspecialchars($_POST["confirmPassword"] ?? "");

$form = new RegisterForm();
$auth = new Authenticator(App::resolve(Database::class));

if ($form->validate($name, $username, $email, $password, $confirmPassword)) {
    if (!$auth->attemptToLocateExistingUserByEmail($email)) {
        if (!$auth->attemptToLocateExistingUserByUsername($username)) {
            if ($auth->attemptToRegister($name, $username, $email, $password)) {
                redirect("/notes");
            }
            $form->addError("error", "Registration failed!");
            goto errors;
        }
        $form->addError("username", "Username already exists. Please try another username or login.");
        goto errors;
    }
    $form->addError("email", "Email already exists. Please try another email or login.");
}

errors:
$_SESSION["_data"]["register"] = [
    "name" => $name,
    "username" => $username,
    "email" => $email
];
$_SESSION["_flash"]["errors"] = $form->getErrors();
redirect("/register");
