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


}