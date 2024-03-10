<?php
namespace Controller;

use Model\UserProduct;
use Model\Product;


class CartController
{
    private UserProduct $modelUserProduct;

    public function __construct()
    {
        $this->modelUserProduct = new UserProduct();
    }
    public function getCart() :void
    {
        session_start();
        $userId = $_SESSION['user_id'];
        if (!isset($userId)) {
            header("Location: /login");
        }

        $cartProducts = $this->modelUserProduct->getAllUserProducts($userId);
        $totalPrice = $this->getTotalPrice($cartProducts);

        if (empty($cartProducts)) {
            $massage = 'В корзине пусто';
        }
        require_once './../View/cart.php';
    }

    public function getTotalPrice(array $cartProducts) :float
    {
        $totalPrice = '0';
        foreach ($cartProducts as $cartProduct) {
            $totalPrice += ($cartProduct['price'] * $cartProduct['quantity']);
        }
        return $totalPrice;
    }

}