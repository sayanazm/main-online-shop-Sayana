<?php
namespace Controller;

use Repository\ProductRepository;
use Request\CartRequest;
use Service\AuthenticationService\AuthenticationServiceInterface;
use Service\AuthenticationService\CookieAuthenticationService;
use Service\AuthenticationService\SessionAuthenticationService;
use Service\CartService;


class CartController
{
    private ProductRepository $productRepository;
    private CartService $cartService;
    private AuthenticationServiceInterface $authenticationService;

    public function __construct(AuthenticationServiceInterface $authenticationService, CartService $cartService)
    {
        $this->productRepository = new ProductRepository;
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
    }
    public function getCart() :void
    {
        if (!$this->authenticationService->check()) {
            header("Location: /login");
        }

        $cartProducts = $this->cartService->getProducts();
        $totalPrice = $this->cartService->getTotalPrice();

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

        $productId = $request->getProductId();

        $this->cartService->addProduct($productId);

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

            $this->cartService->deleteProduct($productId);
            header("Location: /main");

        } else {
            $products = $this->productRepository->getAll();
            $totalPrice = $this->cartService->getTotalPrice();
            require_once './../View/main.php';
        }
    }

}