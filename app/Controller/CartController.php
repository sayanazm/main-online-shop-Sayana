<?php
namespace Controller;

use Model\UserProduct;
use Model\Product;


class CartController
{
    private UserProduct $userProductModel;
    private Product $modelProduct;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->modelProduct = new Product;
    }
    public function getCart() :void
    {
        session_start();
        $userId = $_SESSION['user_id'];
        if (!isset($userId)) {
            header("Location: /login");
        }

        $cartProducts = $this->userProductModel->getAllUserProducts($userId);
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

    public function addProduct($array) :void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }

        $userId = $_SESSION['user_id'];
        $productId = $array['product_id'];
        $quantity = '1';

        $product = $this->userProductModel->getOneByProductId($userId, $productId);
        if ($product) {
            $this->userProductModel->plusQuantity($userId, $productId);
        } else {
            $this->userProductModel->addProduct($userId, $productId, $quantity);
        }

        header("Location: /main");

    }
    public function deleteProduct($array) :void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }

        $userId = $_SESSION['user_id'];
        $productId = $array['product_id'];

        $errors = $this->validate($userId, $productId);

        if (empty($errors)) {
            $this->userProductModel->minusQuantity($userId, $productId);

            $product = $this->userProductModel->getOneByProductId($userId, $productId);
            if ($product) {
                if ($product['quantity'] === 0) {
                    $this->userProductModel->deleteProduct($userId, $productId);
                }
            }
            header("Location: /main");
        } else {
            $products = $this->modelProduct->getAll();
            require_once './../View/main.php';
        }
    }

    private function validate($userId, $productId): array
    {
        $errors = [];

        $product = $this->userProductModel->getOneByProductId($userId, $productId);

        if ($product) {
            if ($product['quantity'] <= '0') {

                $errors['quantity'] = 'Этого товара уже нет в корзине';

            }
        }
        return $errors;
    }
}