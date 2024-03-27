<?php

namespace Controller;

use Repository\UserProductRepository;
use Request\OrderRequest;
use Service\AuthenticationService\AuthenticationServiceInterface;
use Service\AuthenticationService\SessionAuthenticationService;
use Service\CartService;
use Service\OrderService;
use Throwable;

class OrderController
{
    private UserProductRepository $userProductRepository;
    private OrderService $orderService;
    private CartService $cartService;
    private  AuthenticationServiceInterface $authenticationService;


    public function __construct(AuthenticationServiceInterface $authenticationService, CartService $cartService, OrderService $orderService)
    {
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
        $this->orderService = $orderService;
        $this->userProductRepository = new UserProductRepository;
    }
    public function getOrderForm(): void
    {
        if (!$this->authenticationService->check()) {
            header("Location: /login");
        }

        $userId = $this->authenticationService->getCurrentUser()->getId();
        $cartProducts = $this->userProductRepository->getAllUserProducts($userId);

        $totalPrice = $this->cartService->getTotalPrice();

        require_once './../View/order.php';
    }

    /**
     * @throws Throwable
     */
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

            $orderedProducts = $this->orderService->order($userId, $email, $phone, $name, $address, $city, $country, $postal);

            header('/order-complete');
        }

        $totalPrice = $this->cartService->getTotalPrice();

        require_once './../View/order.php';

    }

}