<?php

namespace Http\Forms;

use Core\Validator;

class LoginForm
{
    private $errors = [];

    public function validate(string $email, string $password)
    {

        if (!Validator::email($email)) {
            $this->errors["email"] = "Email is required";
        }

        if (!Validator::string($password, 8, 255)) {
            $this->errors["password"] = "Password is required and must be at least 8 characters";
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
