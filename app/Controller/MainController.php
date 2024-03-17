<?php
namespace Controller;

use Model\Product;
use Model\UserProduct;

class MainController
{
    private Product $modelProduct;
    private UserProduct $userProductModel;

    public function __construct()
    {
        $this->modelProduct = new Product;
        $this->userProductModel = new UserProduct;
    }
    public function getProducts() :void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }
        $userId = $_SESSION['user_id'];

        $products = $this->modelProduct->getAll();

        $cartProducts = $this->userProductModel->getAllUserProducts($userId);
        $totalPrice = $this->getTotalPrice($cartProducts);

        require_once "./../View/main.php";

    }

    public function getTotalPrice(array|null $cartProducts) :float
    {
        $totalPrice = '0';
        if ($cartProducts) {
            foreach ($cartProducts as $cartProduct) {
                $totalPrice += ($cartProduct->getPrice() * $cartProduct->getQuantity());
            }
        }
        return $totalPrice;
    }
}