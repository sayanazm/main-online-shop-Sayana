<?php
namespace Controller;

use Repository\UserProductRepository;
use Repository\ProductRepository;
use Request\CartRequest;
use Service\CartService;


class CartController
{
    private UserProductRepository $userProductRepository;
    private ProductRepository $modelProduct;
    private CartService $cartService;

    public function __construct()
    {
        $this->userProductRepository = new UserProductRepository();
        $this->modelProduct = new ProductRepository;
        $this->cartService = new CartService();
    }
    public function getCart() :void
    {
        session_start();
        $userId = $_SESSION['user_id'];
        if (!isset($userId)) {
            header("Location: /login");
        }

        $cartProducts = $this->userProductRepository->getAllUserProducts($userId);
        $totalPrice = $this->cartService->getTotalPrice($cartProducts);

        if (empty($cartProducts)) {
            $massage = 'В корзине пусто';
        }
        require_once './../View/cart.php';
    }

    public function addProduct(CartRequest $request) :void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }

        $userId = $_SESSION['user_id'];
        $productId = $request->getProductId();
        $quantity = '1';

        $product = $this->userProductRepository->getOneByProductId($userId, $productId);
        if ($product) {
            $this->userProductRepository->plusQuantity($userId, $productId);
        } else {
            $this->userProductRepository->addProduct($userId, $productId, $quantity);
        }

        header("Location: /main");

    }
    public function deleteProduct(CartRequest $request) :void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }

        $userId = $_SESSION['user_id'];
        $productId = $request->getProductId();

        $errors = $request->validate($userId);

        if (empty($errors)) {
            $this->userProductRepository->minusQuantity($userId, $productId);

            $product = $this->userProductRepository->getOneByProductId($userId, $productId);
            if ($product) {
                if ($product->getQuantity() === 0) {
                    $this->userProductRepository->deleteProduct($userId, $productId);
                }
            }
            header("Location: /main");
        } else {
            $products = $this->modelProduct->getAll();
            $cartProducts = $this->userProductRepository->getAllUserProducts($userId);
            $totalPrice = $this->cartService->getTotalPrice($cartProducts);
            require_once './../View/main.php';
        }
    }

}