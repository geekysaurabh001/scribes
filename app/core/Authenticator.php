<?php


namespace Core;

class Authenticator
{

  protected $user;

  public function attemptToLocateExistingUser(string $email)
  {
    $this->user = App::resolve(Database::class)->query("SELECT id, public_id, username, name,  email, password FROM `users` WHERE `email`=:email")->execute([":email" => $email])->fetch();

    if (!empty($this->user)) return true;

    return false;
  }
  public function attemptToValidatePassword(string $password)
  {
    if (password_verify($password, $this->user["password"])) {
      $this->setTokens($this->user);
      $this->login($this->user);
      return true;
    }
    return false;
  }

  protected function setTokens($user)
  {
    $env = parse_ini_file(basePath(".env"));
    $accessToken = generateJWT([
      "username" => $user["username"],
      "name" => $user["name"],
      "iat" => time(),
      "exp" => time() + ONE_HOUR_IN_SECONDS
    ], $env["JWT_SECRET"]);

    setcookie("access_token", $accessToken, [
      "expires" => time() + ONE_HOUR_IN_SECONDS,
      "path" => "/",
      "domain" => $env["APP_ENV"] == "development" ? ".scribes.test" : ".saurabhsrivastava.com",
      "httponly" => true,
      "secure" => true
    ]);

    $refreshToken = generateJWT([
      "username" => $user["username"],
      "name" => $user["name"],
      "iat" => time(),
      "exp" => time() + THIRTY_DAYS_IN_SECONDS // 60 seconds * 60 minutes * 24 hours * 30 days
    ], $env["JWT_SECRET"]);

    setcookie("refresh_token", $refreshToken, [
      "expires" => time() + THIRTY_DAYS_IN_SECONDS,
      "path" => "/",
      "domain" => $env["APP_ENV"] == "development" ? ".scribes.test" : ".saurabhsrivastava.com",
      "httponly" => true,
      "secure" => true
    ]);
  }

  protected function login($user)
  {
    $_SESSION["user"] = [
      "id" => $user["id"],
      "public_id" => $user["public_id"],
      "name" => $user["name"],
      "email" => $user["email"],
      "username" => $user["username"]
    ];
    $_SESSION["_flash"]["success"] = "Login successful.";

    session_regenerate_id();
  }
}
