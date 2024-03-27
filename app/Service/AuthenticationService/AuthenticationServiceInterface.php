<?php

namespace Service\AuthenticationService;

use Entity\User;

interface AuthenticationServiceInterface
{
    public function check(): bool;
    public function getCurrentUser(): User | null;
    public function login(string $email, string $password): bool;
    public function logout(): void;

}