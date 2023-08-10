<?php

namespace Model;

class User extends ActiveRecord {
    protected static $table = 'users';
    protected static $columnsDB = ['id', 'name', 'lastname', 'email', 'password', 'confirm', 'token', 'admin'];
    
    public $id;
    public $name;
    public $lastname;
    public $email;
    public $password;
    public $password2;
    PUBLIC $actual_password;
    public $confirm;
    public $token;
    public $admin;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->lastname = $args['lastname'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->confirm = $args['confirm'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->admin = $args['admin'] ?? 0; //DB is tinyint(1) can`t be ' ' 
    }

    // Validate User Login
    public function validateLogin() {
        if(!$this->email) {
            self::$alerts['error'][] = 'The User Email is Required';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = 'Invalid Email';
        }
        if(!$this->password) {
            self::$alerts['error'][] = 'The password cannot be empty';
        }
        return self::$alerts;

    }

    // Validation for new accounts
    public function validateAccount() {
        if(!$this->name) {
            self::$alerts['error'][] = 'The name is Required';
        }
        if(!$this->lastname) {
            self::$alerts['error'][] = 'The lastname is Required';
     }
        if(!$this->email) {
            self::$alerts['error'][] = 'The email is Required';
        }
        if(!$this->password) {
            self::$alerts['error'][] = 'The password cannot be empty';
        }
        if(strlen($this->password) < 6) {
            self::$alerts['error'][] = 'The password must contain at least 6 characters';
        }
        if($this->password !== $this->password2) {
            self::$alerts['error'][] = 'The passwords are different';
        }
        return self::$alerts;
    }

    // Validate an email
    public function validateEmail() {
        if(!$this->email) {
            self::$alerts['error'][] = 'The email is Required';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = 'Invalid Email';
        }
        return self::$alerts;
    }

    // Validate Password 
    public function validatePassword() {
        if(!$this->password) {
            self::$alerts['error'][] = 'The password cannot be empty';
        }
        if(strlen($this->password) < 6) {
            self::$alerts['error'][] = 'The password must contain at least 6 characters';
        }
        return self::$alerts;
    }

    public function newPassword() : array {
        if(!$this->actual_password) {
            self::$alerts['error'][] = 'The Current Password cannot be empty';
        }
        if(!$this->actual_password) {
            self::$alerts['error'][] = 'The New Password cannot be empty';
        }
        if(strlen($this->actual_password) < 6) {
            self::$alerts['error'][] = 'The password must contain at least 6 characters';
        }
        return self::$alerts;
    }

    // Check the password
    public function checkPassword() : bool {
        return password_verify($this->actual_password, $this->password );
    }

    // Hash password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar un Token
    public function createToken() : void {
        $this->token = uniqid();
    }
}