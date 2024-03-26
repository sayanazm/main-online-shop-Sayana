<?php

namespace Controller;

use Repository\UserRepository;
use Request\LoginRequest;
use Request\RegistrationRequest;
use Service\AuthenticationService\CookieAuthenticationService;
use Service\AuthenticationService\SessionAuthenticationService;


class UserController
{
    private UserRepository $userRepository;
    private SessionAuthenticationService $authenticationService;

    private CookieAuthenticationService $cookieAuthenticationService;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
        $this->authenticationService = new SessionAuthenticationService();
        $this->cookieAuthenticationService = new CookieAuthenticationService();
    }

    public function getLoginForm() :void
    {
        require_once './../View/login.php';
    }

    public function login(LoginRequest $request) :void
    {
        $errors = $request->validateLogin();

        if (empty($errors)) {

            $email = $request->getEmail();
            $password = $request->getPassword();
            if ($this->cookieAuthenticationService->login($email, $password)) {
                header("Location: /main");
            } else {
                $errors['email'] = 'Неверный логин или пароль';
            }
        }

        require_once './../View/login.php';
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

            $this->userRepository->create($name, $email, $password);

            header("Location: /login");

        }
        require_once "./../View/registrate.php";
    }

    public function logout(): void
    {
        $this->cookieAuthenticationService->logout();
    }
}