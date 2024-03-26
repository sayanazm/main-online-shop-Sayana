<?php

namespace Service;

use Entity\User;
use Repository\UserProductRepository;
use Service\AuthenticationService\CookieAuthenticationService;
use Service\AuthenticationService\SessionAuthenticationService;

class CartService
{
    private UserProductRepository $userProductRepository;
    private SessionAuthenticationService $authenticationService;
    private CookieAuthenticationService $cookieAuthenticationService;

    public function __construct()
    {
        $this->userProductRepository = new UserProductRepository();
        $this->authenticationService = new SessionAuthenticationService();
        $this->cookieAuthenticationService = new CookieAuthenticationService();
    }

    public function addProduct(int $productId): void
    {
        $user = $this->cookieAuthenticationService->getCurrentUser();
        if (!$user instanceof User) {
            return;
        }
        $userId = $user->getId();
        $product = $this->userProductRepository->getOneByProductId($userId, $productId);
        if ($product) {
            $this->userProductRepository->plusQuantity($userId, $productId);
        } else {
            $this->userProductRepository->addProduct($userId, $productId, 1);
        }

    }

    public function deleteProduct(int $productId): void
    {
        $user = $this->cookieAuthenticationService->getCurrentUser();
        if (!$user instanceof User) {
            return;
        }
        $userId = $user->getId();
        $this->userProductRepository->minusQuantity($userId, $productId);

        $product = $this->userProductRepository->getOneByProductId($userId, $productId);
        if ($product) {
            if ($product->getQuantity() === 0) {
                $this->userProductRepository->deleteProduct($userId, $productId);
            }
        }
    }

    public function getTotalPrice() :float
    {
        $totalPrice = '0';
        $cartProducts = $this->getProducts();
        if (!empty($cartProducts)) {
            foreach ($cartProducts as $cartProduct) {
                $totalPrice += ($cartProduct->getProduct()->getPrice() * $cartProduct->getQuantity());
            }
        }
        return $totalPrice;
    }

    public function getProducts(): array|null
    {
        $user = $this->cookieAuthenticationService->getCurrentUser();
        if (!$user instanceof User) {
            return null;
        }
        return $this->userProductRepository->getAllUserProducts($user->getId());
    }
}