<?php
namespace Controller;

use Repository\UserProductRepository;
use Repository\ProductRepository;
use Request\CartRequest;
use Service\CartService;


class CartController
{
    private UserProductRepository $userProductRepository;
    private ProductRepository $productRepository;
    private CartService $cartService;

    public function __construct()
    {
        $this->userProductRepository = new UserProductRepository();
        $this->productRepository = new ProductRepository;
        $this->cartService = new CartService();
    }
    public function getCart() :void
    {
        session_start();
        $userId = $_SESSION['user_id'];
        if (!isset($userId)) {
            header("Location: /login");
        }

        $totalPrice = $this->cartService->getTotalPrice($userId);

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

        $this->cartService->addProduct($userId, $productId);

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

            $this->cartService->deleteProduct($userId, $productId);
            header("Location: /main");

        } else {
            $products = $this->productRepository->getAll();
            $totalPrice = $this->cartService->getTotalPrice($userId);
            require_once './../View/main.php';
        }
    }

}