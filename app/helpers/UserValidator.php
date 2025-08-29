<?php

class UserValidator
{
    private $data;
    private $errors = [];
    private static $fields = ['name', 'phone_number', 'email', 'password', 'confirm_password'];

    public function __construct($post_data) {
        $this->data = $post_data;
    }

    public function validateForm() {
        // Check required fields
        foreach (self::$fields as $field) {
            if (!isset($this->data[$field])) {
                $this->addError($field . '_err', "$field is required.");
            }
        }

        $this->validateName();
        $this->validateEmail();
        $this->validatePhone();
        $this->validatePassword();
        $this->validateConfirmPassword();

        return $this->errors;
    }

    private function validateName() {
        $val = trim($this->data['name'] ?? '');
        if (empty($val)) {
            $this->addError('name_err', 'Name cannot be empty.');
        } elseif (strlen($val) < 3 || strlen($val) > 25) {
            $this->addError('name_err', 'Name must be between 3 and 25 characters.');
        }
    }

    private function validateEmail() {
        $val = trim($this->data['email'] ?? '');
        if (empty($val)) {
            $this->addError('email_err', 'Email cannot be empty.');
        } elseif (!filter_var($val, FILTER_VALIDATE_EMAIL)) {
            $this->addError('email_err', 'Invalid email format.');
        }
    }

    private function validatePhone() {
        $val = trim($this->data['phone_number'] ?? '');
        if (empty($val)) {
            $this->addError('phone_number_err', 'Phone number cannot be empty.');
        } elseif (!preg_match('/^\+?\d{9,15}$/', $val)) {
            $this->addError('phone_number_err', 'Phone number is invalid.');
        }
    }

    private function validatePassword() {
        $val = trim($this->data['password'] ?? '');
        if (empty($val)) {
            $this->addError('password_err', 'Password cannot be empty.');
        } elseif (strlen($val) < 8) {
            $this->addError('password_err', 'Password must be at least 8 characters.');
        }
    }

    private function validateConfirmPassword() {
        $password = trim($this->data['password'] ?? '');
        $confirm  = trim($this->data['confirm_password'] ?? '');
        if ($password !== $confirm) {
            $this->addError('confirm_password_err', 'Passwords do not match.');
        }
    }

    private function addError($key, $message) {
        $this->errors[$key] = $message;
    }
}
