<?php

namespace Service;

use Entity\OrderProduct;
use Repository\OrderProductRepository;
use Repository\OrderRepository;
use Repository\UserProductRepository;
use Request\OrderRequest;

class OrderService
{

    private UserProductRepository $userProductRepository;
    private OrderRepository $orderRepository;
    private OrderProductRepository $orderProductRepository;

    public function __construct(UserProductRepository $userProductRepository, OrderRepository $orderRepository, OrderProductRepository $orderProductRepository)
    {
        $this->userProductRepository = $userProductRepository;
        $this->orderRepository = $orderRepository;
        $this->orderProductRepository = $orderProductRepository;
    }


    public function create(int $userId, string $email, string $phone, string $name, string $address, string $city, string $country, int $postal): void
    {

        $this->orderRepository->create($userId, $email, $phone, $name, $address, $city, $country, $postal);
        $orderId = $this->orderRepository->getOrderId();
        $this->orderProductRepository->addFromUserProducts($userId, $orderId);
        $this->userProductRepository->deleteAllUserProducts($userId);

    }

}