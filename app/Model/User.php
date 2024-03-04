<?php

namespace Model;

use Model\Model;
require_once './../Model/Model.php';
class User extends Model
{

    public function create(string $name, string $email, string $password) :void
    {
        $statement = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }
    public function getUserByEmail(string $email)
    {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $statement->execute(['email' => $email]);
        $user = $statement->fetch();

        return $user;
    }

}