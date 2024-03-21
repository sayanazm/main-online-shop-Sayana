<?php

namespace Controller\Admin;

use Repository\OrderRepository;
use Repository\OrderProductRepository;
use Repository\UserProductRepository;
use Request\OrderRequest;
use Service\CartService;
use Service\OrderService;

class AdminOrderController
{
    private OrderRepository $orderRepository;
    private OrderProductRepository $orderProductRepository;
    private UserProductRepository $userProductRepository;
    private OrderService $orderService;
    private CartService $cartService;


    public function __construct()
    {
        $this->orderRepository = new OrderRepository;
        $this->orderProductRepository = new OrderProductRepository;
        $this->userProductRepository = new UserProductRepository;
        $this->orderService = new OrderService;
        $this->cartService = new CartService;

    }
    public function getOrderForm(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }
        $userId = $_SESSION['user_id'];
        $cartProducts = $this->userProductRepository->getAllUserProducts($userId);
        $totalPrice = $this->cartService->getTotalPrice($userId);

        require_once './../View/order.php';
    }

    public function order(OrderRequest $orderRequest) :void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }
        $userId = $orderRequest->getUserId();

        $errors = $orderRequest->validateOrder($userId);

        if (empty($errors)) {

            $email = $orderRequest->getEmail();
            $phone = $orderRequest->getPhone();
            $name = $orderRequest->getName();
            $country = $orderRequest->getCountry();
            $city = $orderRequest->getCity();
            $address = $orderRequest->getAddress();
            $postal = $orderRequest->getPostal();

            $this->orderService->create($userId, $email, $phone, $name, $address, $city, $country, $postal);

            $totalPrice = $this->cartService->getTotalPrice($userId);

            require_once './../View/order-completed.php';
        }

    }


}