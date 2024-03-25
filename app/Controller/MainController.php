<?php
namespace Controller;

use Repository\ProductRepository;
use Repository\UserProductRepository;
use Service\AuthenticationService;
use Service\CartService;

class MainController
{
    private ProductRepository $productRepository;
    private CartService $cartService;
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->productRepository = new ProductRepository;
        $this->cartService = new CartService;
        $this->authenticationService = new AuthenticationService();
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