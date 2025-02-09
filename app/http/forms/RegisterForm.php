<?php

namespace Http\Forms;

use Core\Validator;

class RegisterForm
{

  private $errors = [];

  public function validate(string $name, string $username, string $email, string $password, string $confirmPassword)
  {

    if (!Validator::string($name, 1, 255)) {
      $this->errors["name"] = "Name is required";
    }

    if (!Validator::string($username, 1, 255)) {
      $this->errors["username"] = "Username is required";
    }

    if (!Validator::email($email)) {
      $this->errors["email"] = "Email is required";
    }

    if (!Validator::string($password, 8, 255)) {
      $this->errors["password"] = "Password is required and must be at least 8 characters";
    }

    if (!Validator::string($confirmPassword, 8, 255)) {
      $this->errors["confirmPassword"] = "Confirm password is required and must be at least 8 characters";
    }

    if (!Validator::passwordMatch($password, $confirmPassword)) {
      $this->errors["confirmPassword"] = "Passwords do not match";
    }

    return empty($this->errors);
  }

  public function addError(string $key, string $message)
  {
    $this->errors[$key] = $message;
  }

  public function getErrors()
  {
    return $this->errors;
  }
}
