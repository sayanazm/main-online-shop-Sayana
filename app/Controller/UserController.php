<?php

namespace Controller;

use Repository\UserRepository;
use Request\LoginRequest;
use Request\RegistrationRequest;
use Service\AuthenticationService;


class UserController
{
    private UserRepository $userRepository;
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
        $this->authenticationService = new AuthenticationService();
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
            $this->authenticationService->setId($email);

            header("Location: /main");
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

}