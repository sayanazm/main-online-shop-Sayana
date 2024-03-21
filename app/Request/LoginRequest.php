<?php

namespace Request;

use Repository\UserRepository;

class LoginRequest extends Request
{
    private UserRepository $userRepository;
    public function __construct(string $method, string $uri, array $headers, array $body)
    {
        parent::__construct($method, $uri, $headers, $body);

        $this->userRepository = new UserRepository();

    }

    public function getName()
    {
        return $this->body['name'];

    }

    public function getEmail()
    {
        return $this->body['email'];

    }

    public function getPassword()
    {
        return $this->body['password'];

    }

    public function validateLogin(): array
    {
        $errors = [];

        $email = $this->getEmail();
        $password = $this->getPassword();

        $user = $this->userRepository->getUserByEmail($email);

        if(empty($user)) {
            $errors['email'] = 'Пользователя не существует';
        } elseif (!password_verify($password, $user->getPassword())) {
            $errors['password'] = "Неверный логин или пароль";
        }

        return $errors;
    }

}