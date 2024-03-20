<?php
namespace Controller;

use Repository\ProductRepository;
use Repository\UserProductRepository;

class MainController
{
    private ProductRepository $productRepository;
    private UserProductRepository $userProductRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository;
        $this->userProductRepository = new UserProductRepository;
    }
    public function getProducts() :void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }
        $userId = $_SESSION['user_id'];

        $products = $this->productRepository->getAll();

        $cartProducts = $this->userProductRepository->getAllUserProducts($userId);
        $totalPrice = $this->getTotalPrice($cartProducts);

        require_once "./../View/main.php";

    }

    public function getTotalPrice(array|null $cartProducts) :float
    {
        $totalPrice = '0';
        if ($cartProducts) {
            foreach ($cartProducts as $cartProduct) {
                $totalPrice += ($cartProduct->getProduct()->getPrice() * $cartProduct->getQuantity());
            }
        }
        return $totalPrice;
    }
}