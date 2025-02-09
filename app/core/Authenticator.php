<?php


namespace Core;

use PDOException;

class Authenticator
{

  protected $user;
  protected $db;
  protected $refreshToken;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function attemptToLocateExistingUserByEmail(string $email)
  {
    $stmt = $this->db->query("SELECT id, public_id, username, name,  email, password FROM users WHERE email=:email")->execute([":email" => $email]);

    if ($stmt) {
      $this->user = $stmt->fetch();
      if (!empty($this->user)) return true;
    }

    return false;
  }

  public function attemptToLocateExistingUserByUsername(string $username)
  {
    $stmt = $this->db->query("SELECT * FROM users WHERE username= :username")->execute([
      ":username" => $username
    ]);
    if ($stmt) {
      $this->user = $stmt->fetch();
      if ($this->user) {
        return true;
      }
    }
    return false;
  }

  public function attemptToValidatePassword(string $password)
  {
    if (password_verify($password, $this->user["password"])) {
      $this->setTokens($this->user);
      $this->login($this->user, "Login successful.");
      return true;
    }
    return false;
  }

  public function attemptToRegister(string $name, string $username, string $email, string $password)
  {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $this->db->query("INSERT INTO users (public_id, name, username, email, password) VALUES (:publicId, :name, :username, :email, :password)")->execute([
      ":name" => $name,
      ":username" => $username,
      ":email" => $email,
      ":password" => $hashedPassword
    ]);

    if ($stmt) {
      $stmt2 = $this->db->query("SELECT id, public_id, name, username, email FROM users WHERE username = :username")->execute([
        ":username" => $username
      ]);
      // dd($stmt2);
      if ($stmt2) {
        $this->user = $stmt2->fetchOrAbort();

        $this->setTokens($this->user);
        $this->login($this->user, "Registration successful. Auto Login");

        return true;
      }

      return false;
    }
    return false;
  }

  protected function setTokens($user)
  {
    $accessToken = generateJWT([
      "username" => $user["username"],
      "name" => $user["name"],
      "iat" => time(),
      "exp" => time() + ONE_HOUR_IN_SECONDS
    ], getenv("JWT_SECRET"));

    setcookie("access_token", $accessToken, [
      "expires" => time() + ONE_HOUR_IN_SECONDS,
      "path" => "/",
      "domain" => getenv("APP_ENV") == "development" ? ".scribes.test" : ".scribes-2wfr.onrender.com",
      "httponly" => true,
      "secure" => true
    ]);

    $this->refreshToken = generateJWT([
      "username" => $user["username"],
      "name" => $user["name"],
      "iat" => time(),
      "exp" => time() + THIRTY_DAYS_IN_SECONDS // 60 seconds * 60 minutes * 24 hours * 30 days
    ], getenv("JWT_SECRET"));

    setcookie("refresh_token", $this->refreshToken, [
      "expires" => time() + THIRTY_DAYS_IN_SECONDS,
      "path" => "/",
      "domain" => getenv("APP_ENV") == "development" ? ".scribes.test" : ".scribes-2wfr.onrender.com",
      "httponly" => true,
      "secure" => true
    ]);
  }

  protected function login($user, string $message)
  {
    $_SESSION["user"] = [
      "id" => $user["id"],
      "public_id" => $user["public_id"],
      "name" => $user["name"],
      "email" => $user["email"],
      "username" => $user["username"]
    ];
    $_SESSION["_flash"]["success"] = $message;

    session_regenerate_id();
  }
}
