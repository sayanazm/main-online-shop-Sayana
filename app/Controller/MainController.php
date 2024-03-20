<?php
namespace Controller;

use Repository\ProductRepository;
use Repository\UserProductRepository;
use Service\CartService;

class MainController
{
    private ProductRepository $productRepository;
    private UserProductRepository $userProductRepository;

    private CartService $cartService;

    public function __construct()
    {
        $this->productRepository = new ProductRepository;
        $this->userProductRepository = new UserProductRepository;
        $this->cartService = new CartService;
    }
    public function getProducts() :void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }
        $userId = $_SESSION['user_id'];

        $products = $this->productRepository->getAll();

        $totalPrice = $this->cartService->getTotalPrice($userId);

        require_once "./../View/main.php";

    }

}