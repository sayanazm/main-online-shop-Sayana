<?php

namespace Controller;

use Repository\UserRepository;
use Request\RegistrationRequest;
use Request\Request;


class UserController
{
    private UserRepository $modelUser;

    public function __construct()
    {
        $this->modelUser = new UserRepository;
    }

    public function getLoginForm() :void
    {
        require_once './../View/login.php';
    }

    public function login(Request $request) :void
    {
        $errors = $this->validateLogin($request);

        if (empty($errors)) {

            $userData = $request->getBody();
            $user = $this->modelUser->getUserByEmail($userData['email']);

            session_start();
            $_SESSION['user_id'] = $user->getId();

            header("Location: /main");
        }

        require_once './../View/login.php';
    }

    private function validateLogin(Request $request): array
    {
        $errors = [];

        $userData = $request->getBody();

        $email = $userData['email'];
        $password = $userData['password'];

        $user = $this->modelUser->getUserByEmail($email);

        if(empty($user)) {
            $errors['email'] = 'Пользователя не существует';
        } elseif (!password_verify($password, $user->getPassword())) {
            $errors['password'] = "Неверный логин или пароль";
        }

        return $errors;
    }

    public function getRegistrationForm() :void
    {
        require_once "./../View/registrate.php";
    }

    public function registrate(RegistrationRequest $request) :void
    {
        $errors = $request->validate();

        if (empty($errors)) {

            $password = $request->getPassword();
            $name = $request->getName();
            $email = $request->getEmail();

            $password = password_hash($password, PASSWORD_DEFAULT);

            $this->modelUser->create($name, $email, $password);

            header("Location: /login");

        }
        require_once "./../View/registrate.php";
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        header('Location: /login');
    }

}