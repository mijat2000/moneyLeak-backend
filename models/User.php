<?php

class User
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Login
    public function login($email, $password)
    {

        $password_hashed = md5($password, false);
        //Create query
        $query = "SELECT id_user,is_verified from users where email = :email AND password = :password";

        //Prepare statement
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_hashed);

        //Execute the query
        $stmt->execute();
        return $stmt;
    }

    public function register($email, $name, $lastname, $password, $hash)
    {

        $password_hashed = md5($password, false);
        $query = "INSERT INTO users(email, name, lastname, password, validation_key)  VALUES (:email,:name,:lastname,:password,:validation_key)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':password', $password_hashed);
        $stmt->bindParam(':validation_key', $hash);

        $stmt->execute();
        return $stmt;
    }

    //checking if email is in use
    public function checkEmail($email)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $email);

        $stmt->execute();
        return $stmt;
    }

    public function validateEmail($code)
    {
        $query = "UPDATE users  SET is_verified = 1 where validation_key = :validation_key ";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':validation_key', $code);

        $stmt->execute();
        return $stmt;
    }

    public function forgottenPassword($email)
    {
        $query = "SELECT validation_key FROM users where email = :email ";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $email);

        $stmt->execute();
        return $stmt;
    }

    public function updatePassword($code, $password)
    {
        $password_hashed = md5($password, false);
        $query = "UPDATE users SET password = :password WHERE  validation_key = :code ";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':password', $password_hashed);
        $stmt->bindParam(':code', $code);

        $stmt->execute();
        return $stmt;
    }
}
