<?php

namespace Service;

use Entity\OrderProduct;
use Repository\OrderProductRepository;
use Repository\OrderRepository;
use Repository\UserProductRepository;
use Request\OrderRequest;
use Throwable;

class OrderService
{

    private OrderRepository $orderRepository;
    private OrderProductRepository $orderProductRepository;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->orderProductRepository = new OrderProductRepository();
    }


    /**
     * @throws Throwable
     */
    public function create(int $userId, string $email, string $phone, string $name, string $address, string $city, string $country, int $postal): array
    {

        $this->orderRepository->create($userId, $email, $phone, $name, $address, $city, $country, $postal);
        $orderId = $this->orderRepository->getOrderId();
        $orderedProducts = $this->orderProductRepository->replaceToOrder($userId, $orderId);

        return $orderedProducts;

    }

}