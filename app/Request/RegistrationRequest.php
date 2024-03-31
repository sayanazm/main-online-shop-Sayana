<?php

namespace Request;

use Repository\UserRepository;
use Request\Request;

class RegistrationRequest extends Request
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
        return $this->body['psw'];

    }

    public function getPasswordRepeat()
    {
        return $this->body['psw-repeat'];

    }

    public function validate(): array
    {
        $errors = [];

        $userData = $this->getBody();

        $name = $this->getName();
        if (strlen($name) < 2) {
            $errors['name'] = "Имя должно быть больше 2 символов";
        }

        $email = $this->getEmail();
        if (strlen($email) < 2) {
            $errors['email'] = 'Email должен быть больше 2 символов';
        } elseif (!empty($this->userRepository->getUserByEmail($email))){
            $errors['email'] = 'Пользователь с таким Email уже существует';
        } else {
            $str = '@';
            $strpos = strpos($email, $str);

            if (empty($strpos)) {
                $errors['email'] = 'Email должен содержать @';
            }

        }

        $password = $this->getPassword();
        $passwordRepeat = $this->getPasswordRepeat();
        if (strlen($password) < 2) {
            $errors['password'] = "Пароль должен быть больше 2 символов";
        } else {

            if ($password != $passwordRepeat) {
                $errors['password'] = "Пароли не совпадают";
            }
        }

        return $errors;
    }

}