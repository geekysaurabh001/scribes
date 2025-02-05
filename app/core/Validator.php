<?php

namespace Core;

class Validator
{
  public static function string(string $value, int $min = 1, int $max = INF): bool
  {
    $value = trim($value);
    return strlen($value) >= $min && strlen($value) <= $max;
  }

  public static function email(string $email): bool
  {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }
  // isset($_FILES["thumbnail"]) && !empty($_FILES["thumbnail"]) && $_FILES["thumbnail"]["size"] !== 0

  public static function array(array $value): bool
  {
    return isset($value) && is_array($value) && !empty($value);
  }

  public static function file(array $value): bool
  {
    return Validator::array($value) && isset($value["size"]) && $value["size"] !== 0;
  }

  public static function urlIs($url)
  {
    return $_SERVER["REQUEST_URI"] === $url;
  }

  public static function authorized($condition, $status = Response::FORBIDDEN)
  {
    if (!$condition) {
      abort($status);
    }
  }

  public static function passwordMatch($password, $confirm_password)
  {
    return $password === $confirm_password;
  }
}
