<?php

$env = parse_ini_file(basePath(".env"));

use Core\Validator;
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

require basePath("libs/jwt.php");
require basePath("libs/constants.php");

$name = htmlspecialchars($_POST["name"] ?? "");
$username = htmlspecialchars($_POST["username"] ?? "");
$email = htmlspecialchars($_POST["email"] ?? "");
$password = htmlspecialchars($_POST["password"] ?? "");
$confirmPassword = htmlspecialchars($_POST["confirmPassword"] ?? "");

$errors = [];

if (!Validator::string($name, 1, 255)) {
    $errors["name"] = "Name is required";
}

if (!Validator::string($username, 1, 255)) {
    $errors["username"] = "Username is required";
}

if (!Validator::email($email)) {
    $errors["email"] = "Email is required";
}

if (!Validator::string($password, 8, 255)) {
    $errors["password"] = "Password is required and must be at least 8 characters";
}

if (!Validator::string($confirmPassword, 8, 255)) {
    $errors["confirmPassword"] = "Confirm password is required and must be at least 8 characters";
}

if (!Validator::passwordMatch($password, $confirmPassword)) {
    $errors["confirmPassword"] = "Passwords do not match";
}

if (!empty($errors)) {
    return view("auth/register/index.view.php", [
        "errors" => $errors
    ]);
}


$user = $db->query("SELECT * FROM `users` WHERE `username`= :username")->execute([
    ":username" => $username
])->fetch();
if ($user) {
    $errors["username"] = "Username already exists. Please try another username or login.";
    return view("auth/register/index.view.php", [
        "errors" => $errors
    ]);
}

$user = $db->query("SELECT * FROM `users` WHERE `email`= :email")->execute([
    ":email" => $email
])->fetch();

if ($user) {
    $errors["email"] = "Email already exists. Please try another email or login.";
    return view("auth/register/index.view.php", [
        "errors" => $errors
    ]);
}

$refreshToken = generateJWT([
    "username" => $username,
    "name" => $name,
    "iat" => time(),
    "exp" => time() + THIRTY_DAYS_IN_SECONDS // 60 seconds * 60 minutes * 24 hours * 30 days
], $env["JWT_SECRET"]);

$accessToken = generateJWT([
    "username" => $username,
    "name" => $name,
    "iat" => time(),
    "exp" => time() + ONE_HOUR_IN_SECONDS
], $env["JWT_SECRET"]);

$db->query("INSERT INTO `users` (public_id, name, username, email, password, refresh_token) VALUES (:publicId, :name, :username, :email, :password, :refresh_token)")->execute([
    ":name" => $name,
    ":username" => $username,
    ":email" => $email,
    ":password" => password_hash($password, PASSWORD_DEFAULT),
    ":refresh_token" => $refreshToken
]);
// dd($username);
$registeredUser = $db->query("SELECT id, public_id, name, username, email FROM users WHERE `username` = :username")->execute([
    ":username" => $username
])->fetchOrAbort();


setcookie("access_token", $accessToken, [
    "expires" => time() + ONE_HOUR_IN_SECONDS,
    "path" => "/",
    "domain" => $env["APP_ENV"] == "development" ? ".scribes.test" : ".saurabhsrivastava.com",
    "httponly" => true,
    "secure" => true
]);

setcookie("refresh_token", $refreshToken, [
    "expires" => time() + THIRTY_DAYS_IN_SECONDS,
    "path" => "/",
    "domain" => $env["APP_ENV"] == "development" ? ".scribes.test" : ".saurabhsrivastava.com",
    "httponly" => true,
    "secure" => true
]);

$_SESSION["user"] = $registeredUser;
$_SESSION["_flash"]["success"] = "Registration successful. Please login.";

session_regenerate_id();

header("Location: /login");
exit();
