<?php

namespace Service;

use Entity\User;
use Repository\UserRepository;

class AuthenticationService
{
    private UserRepository $userRepository;
    
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function check(): bool
    {
        if (empty($_SESSION['user_id'])) {
            session_start();
        }
        return isset($_SESSION['user_id']);
    }
    
    public function getCurrentUser(): User|null
    {
        if ($this->check()) {
            $userId = $_SESSION['user_id'];
            return $this->userRepository->getUserById($userId);
        }
        
        return null;
    }
    
    public function setId(string $email): void
    {
        $user = $this->userRepository->getUserByEmail($email);
        session_start();
        $_SESSION['user_id'] = $user->getId();
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        header('Location: /login');
    }

}