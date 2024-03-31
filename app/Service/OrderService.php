<?php

namespace Service;

use Entity\OrderProduct;
use Repository\OrderProductRepository;
use Repository\OrderRepository;
use Repository\Repository;
use Repository\UserProductRepository;
use Request\OrderRequest;
use Throwable;

class OrderService
{

    private OrderRepository $orderRepository;
    private OrderProductRepository $orderProductRepository;
    private UserProductRepository $userProductRepository;

    public function __construct(OrderRepository $orderRepository, OrderProductRepository $orderProductRepository, UserProductRepository $userProductRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->orderProductRepository = $orderProductRepository;
        $this->userProductRepository = $userProductRepository;
    }


    /**
     * @throws Throwable
     */
    public function order(int $userId, string $email, string $phone, string $name, string $address, string $city, string $country, int $postal): array
    {

        Repository::getPdo()->beginTransaction();

        try {

            $this->orderRepository->create($userId, $email, $phone, $name, $address, $city, $country, $postal);

            $orderId = $this->orderRepository->getOrderId();

            $orderedProducts = $this->orderProductRepository->addFromUserProducts($userId, $orderId);

            $this->userProductRepository->deleteAllUserProducts($userId);

            Repository::getPdo()->commit();

            return $orderedProducts;

        } catch (Throwable $exception ) {
            Repository::getPdo()->rollBack();

            throw $exception;
        }

    }


}