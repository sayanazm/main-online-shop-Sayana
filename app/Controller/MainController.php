<?php
namespace Controller;

use Repository\ProductRepository;
use Service\AuthenticationService\AuthenticationServiceInterface;
use Service\AuthenticationService\CookieAuthenticationService;
use Service\AuthenticationService\SessionAuthenticationService;
use Service\CartService;

class MainController
{
    private ProductRepository $productRepository;
    private CartService $cartService;
    private AuthenticationServiceInterface $authenticationService;

    public function __construct(AuthenticationServiceInterface $authenticationService, CartService $cartService, ProductRepository $productRepository)
    {
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
        $this->productRepository = $productRepository;
    }
    public function getProducts() :void
    {
        if (!$this->authenticationService->check()) {
            header("Location: /login");
        }

        $userId = $this->authenticationService->getCurrentUser()->getId();
        $products = $this->productRepository->getAll();
        $totalPrice = $this->cartService->getTotalPrice();

        require_once "./../View/main.php";

    }

}