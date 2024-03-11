<?php

namespace Controller;

use Model\User;


class UserController
{
    private User $modelUser;

    public function __construct()
    {
        $this->modelUser = new User;
    }

    public function getLoginForm() :void
    {
        require_once './../View/login.php';
    }

    public function login($array) :void
    {
        $errors = $this->validateLogin($array);

        if (empty($errors)) {

            $user = $this->modelUser->getUserByEmail($array['email']);

            session_start();
            $_SESSION['user_id'] = $user['id'];

            header("Location: /main");
        }

        require_once './../View/login.php';
    }

    private function validateLogin(array $array): array
    {
        $errors = [];

        $email = $array['email'];
        $password = $array['password'];

        $user = $this->modelUser->getUserByEmail($email);

        if(empty($user)) {
            $errors['email'] = 'Пользователя не существует';
        } elseif (!password_verify($password, $user['password'])) {
            $errors['password'] = "Неверный логин или пароль";
        }

        return $errors;
    }

    public function getRegistrationForm() :void
    {
        require_once "./../View/registrate.php";
    }

    public function registrate($array) :void
    {
        $errors = $this->validateRegistration($array);

        if (empty($errors)) {

            $password = $array['psw'];
            $name = $array['name'];
            $email = $array['email'];

            $password = password_hash($password, PASSWORD_DEFAULT);

            $this->modelUser->create($name, $email, $password);

            header("Location: /login");

        }
        require_once "./../View/registrate.php";
    }

    private function validateRegistration(array $data): array
    {
        $errors = [];

        $name = $data['name'];
        if (strlen($name) < 2) {
            $errors['name'] = "Имя должно быть больше 2 символов";
        }

        $email = $data['email'];
        if (strlen($email) < 2) {
            $errors['email'] = 'Email должен быть больше 2 символов';
        } elseif (!empty($this->modelUser->getUserByEmail($email))){
            $errors['email'] = 'Пользователь с таким Email уже существует';
        } else {
            $str = '@';
            $strpos = strpos($email, $str);

            if ($strpos === false) {
                $errors['email'] = 'Email должен содержать @';
            }

        }

        $password = $data['psw'];
        $password_repeat = $data['psw-repeat'];
        if (strlen($password) < 2) {
            $errors['password'] = "Пароль должен быть больше 2 символов";
        } else {

            if ($password != $password_repeat) {
                $errors['password'] = "Пароли не совпадают";
            }
        }

        return $errors;
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        header('Location: /login');
    }

}