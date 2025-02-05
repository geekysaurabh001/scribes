<?php

$_SESSION = [];
session_destroy();

$params = session_get_cookie_params();

setcookie("PHPSESSID", "", time() - 3600, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
setcookie("access_token", "", time() - 3600, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
setcookie("refresh_token", "", time() - 3600, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

header("Location: /");
exit();
