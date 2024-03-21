<?php
namespace Controller;

use Repository\ProductRepository;
use Request\CartRequest;
use Service\AuthenticationService;
use Service\CartService;


class CartController
{
    private ProductRepository $productRepository;
    private CartService $cartService;
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->productRepository = new ProductRepository;
        $this->cartService = new CartService();
        $this->authenticationService = new AuthenticationService();
    }
    public function getCart() :void
    {
        if (!$this->authenticationService->check()) {
            header("Location: /login");
        }

        $userId = $this->authenticationService->getCurrentUser()->getId();
        $totalPrice = $this->cartService->getTotalPrice($userId);

        if (empty($cartProducts)) {
            $massage = 'В корзине пусто';
        }
        require_once './../View/cart.php';
    }

    public function addProduct(CartRequest $request) :void
    {
        if (!$this->authenticationService->check()) {
            header("Location: /login");
        }

        $userId = $this->authenticationService->getCurrentUser()->getId();
        $productId = $request->getProductId();

        $this->cartService->addProduct($userId, $productId);

        header("Location: /main");

    }
    public function deleteProduct(CartRequest $request) :void
    {
        if (!$this->authenticationService->check()) {
            header("Location: /login");
        }

        $userId = $this->authenticationService->getCurrentUser()->getId();
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