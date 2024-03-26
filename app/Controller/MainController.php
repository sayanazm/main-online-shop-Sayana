<?php
namespace Controller;

use Repository\ProductRepository;
use Service\AuthenticationService\CookieAuthenticationService;
use Service\AuthenticationService\SessionAuthenticationService;
use Service\CartService;

class MainController
{
    private ProductRepository $productRepository;
    private CartService $cartService;
    private SessionAuthenticationService $authenticationService;
    private CookieAuthenticationService $cookieAuthenticationService;

    public function __construct()
    {
        $this->productRepository = new ProductRepository;
        $this->cartService = new CartService;
        $this->authenticationService = new SessionAuthenticationService();
        $this->cookieAuthenticationService = new CookieAuthenticationService();
    }
    public function getProducts() :void
    {
        if (!$this->cookieAuthenticationService->check()) {
            header("Location: /login");
        }

        $userId = $this->cookieAuthenticationService->getCurrentUser()->getId();
        $products = $this->productRepository->getAll();
        $totalPrice = $this->cartService->getTotalPrice();

        require_once "./../View/main.php";

    }

}