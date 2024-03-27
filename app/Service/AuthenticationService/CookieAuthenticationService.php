<?php

namespace Service\AuthenticationService;

use Entity\User;
use Repository\UserRepository;

class CookieAuthenticationService implements AuthenticationServiceInterface
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function check(): bool
    {
        if (!isset($_COOKIE['user_id'])) {
            return false;
        }
        setcookie('user_id', $_COOKIE['user_id'], time()+86400, '/');
        return true;
    }

    public function login(string $email, string $password): bool
    {
        $user = $this->userRepository->getUserByEmail($email);

        if (!$user instanceof User) {
            return false;
        }
        if (!password_verify($password, $user->getPassword())) {
            return false;
        }

        setcookie("user_id", $user->getId(), time()+86400);

        return true;
    }

    public function getCurrentUser(): User|null
    {
        if ($this->check()) {
            $userId = $_COOKIE['user_id'];
            return $this->userRepository->getUserById($userId);
        }

        return null;
    }

    public function logout(): void
    {
        if (!empty($_COOKIE['user_id'])) {
            unset($_COOKIE['user_id']);
            setcookie('user_id', "", time()-86400);
        }
    }

}