<?php

namespace Controller;

use Repository\UserProductRepository;
use Request\OrderRequest;
use Service\AuthenticationService;
use Service\CartService;
use Service\OrderService;

class OrderController
{
    private UserProductRepository $userProductRepository;
    private OrderService $orderService;
    private CartService $cartService;
    private  AuthenticationService $authenticationService;


    public function __construct()
    {
        $this->userProductRepository = new UserProductRepository;
        $this->orderService = new OrderService;
        $this->cartService = new CartService;
        $this->authenticationService = new AuthenticationService();

    }
    public function getOrderForm(): void
    {
        if (!$this->authenticationService->check()) {
            header("Location: /login");
        }

        $userId = $this->authenticationService->getCurrentUser()->getId();
        $cartProducts = $this->userProductRepository->getAllUserProducts($userId);

        $totalPrice = $this->cartService->getTotalPrice($userId);

        require_once './../View/order.php';
    }

    public function order(OrderRequest $orderRequest) :void
    {
        if (!$this->authenticationService->check()) {
            header("Location: /login");
        }

        $userId = $this->authenticationService->getCurrentUser()->getId();

        $errors = $orderRequest->validateOrder($userId);

        if (empty($errors)) {

            $email = $orderRequest->getEmail();
            $phone = $orderRequest->getPhone();
            $name = $orderRequest->getName();
            $country = $orderRequest->getCountry();
            $city = $orderRequest->getCity();
            $address = $orderRequest->getAddress();
            $postal = $orderRequest->getPostal();

            $order = $this->orderService->create($userId, $email, $phone, $name, $address, $city, $country, $postal);

            header('/order-complete');
        }

        $totalPrice = $this->cartService->getTotalPrice($userId);

        require_once './../View/order.php';

    }

}